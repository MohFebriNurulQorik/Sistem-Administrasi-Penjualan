<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderItem;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\DeliveryOrderExport;
use App\Models\Project;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\TemplatePDF;

class DeliveryOrderController extends Controller
{
    // =========================
    // INDEX
    // =========================
    public function index(Request $request)
    {
        $query = DeliveryOrder::with('customer');

        if ($request->search) {
            $query->where('do_number', 'like', "%{$request->search}%")
                ->orWhere('project', 'like', "%{$request->search}%")
                ->orWhereHas('customer', function ($q) use ($request) {
                    $q->where('company_name', 'like', "%{$request->search}%");
                });
        }

        $deliveryOrders = $query->orderby('do_number', 'desc')->paginate(10);

        return view('delivery_orders.index', compact('deliveryOrders'));
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        $customers = Customer::all();
        $invoices = Invoice::all();
        $items = Item::all();
        $projects = Project::all();

        return view('delivery_orders.create', compact('customers', 'invoices', 'items', 'projects'));
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'delivery_date' => 'required|date',
            'project' => 'nullable|string|max:255',
            'print_date' => 'required|date',
        ]);

        DB::beginTransaction();

        try {

            $customer_id = $request->customer_id;
            $shipping_address = $request->shipping_address;
            $invoice_address = $request->invoice_address;

            // =========================
            // HANDLE INVOICE / CUSTOMER
            // =========================
            if ($request->invoice_id) {

                $invoice = Invoice::with('customer')->findOrFail($request->invoice_id);

                $customer_id = $invoice->customer_id;
                $invoice_address = $invoice->customer->invoice_address ?? null;
            } else {

                $customer = Customer::findOrFail($customer_id);

                $shipping_address = $customer->shipping_address ?? null;
                $invoice_address = $customer->invoice_address ?? null;
            }

            // =========================
            // CREATE DELIVERY ORDER
            // =========================

            $printDate = $request->print_date
                ? Carbon::parse($request->print_date)
                : now();

            $today = $printDate->format('Ymd');

            $last = DeliveryOrder::whereMonth('print_date', $printDate->month)
                ->whereYear('print_date', $printDate->year)
                ->orderBy('id', 'desc')
                ->first();

            $next = 1;

            if ($last) {
                $lastSeq = (int) substr($last->do_number, -4);
                $next = $lastSeq + 1;
            }

            $number = 'DO-' . $today . '-' . str_pad($next, 4, '0', STR_PAD_LEFT);

            $do = DeliveryOrder::create([
                'do_number' => $number,
                'customer_id' => $customer_id,
                'invoice_id' => $request->invoice_id,
                'shipping_address' => $shipping_address,
                'invoice_address' => $invoice_address,
                'delivery_date' => $request->delivery_date,
                'po_number' => $request->po_number,
                'project' => $request->project,
                'attn' => $request->attn,
                'shipper_name' => $request->shipper_name,
                'recipient_name' => $request->recipient_name,
                'print_date' => $request->print_date,
            ]);

            // =========================
            // ITEMS LOOP (FIXED)
            // =========================
            if (!empty($request->items['description'])) {

                $count = count($request->items['description']);

                for ($i = 0; $i < $count; $i++) {

                    if (empty($request->items['description'][$i])) {
                        continue;
                    }

                    $do->items()->create([
                        'part_number'   => $request->items['part_number'][$i] ?? null,
                        'description'   => $request->items['description'][$i],
                        'qty'           => $request->items['qty'][$i] ?? 1,
                        'serial_number' => $request->items['serial_number'][$i] ?? null,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('delivery-orders.index')
                ->with('success', 'Delivery Order created successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    // =========================
    // SHOW
    // =========================
    public function show($id)
    {
        $do = DeliveryOrder::with('items', 'customer', 'invoice')
            ->findOrFail($id);

        return view('delivery_orders.show', compact('do'));
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $do = DeliveryOrder::with('items')->findOrFail($id);
        $customers = Customer::all();
        $invoices = Invoice::all();
        $items = Item::all();
        $projects = Project::all();

        return view('delivery_orders.edit', compact('do', 'customers', 'invoices', 'items', 'projects'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $do = DeliveryOrder::findOrFail($id);

            // =========================
            // SET CUSTOMER / ADDRESS
            // =========================
            if ($request->invoice_id) {

                $invoice = Invoice::with('customer')->findOrFail($request->invoice_id);

                $request->merge([
                    'customer_id' => $invoice->customer_id,
                    'invoice_address' => $invoice->customer->invoice_address,
                ]);
            } else {

                $customer = Customer::findOrFail($request->customer_id);

                $request->merge([
                    'shipping_address' => $customer->shipping_address,
                    'invoice_address' => $customer->invoice_address,
                ]);
            }

            // =========================
            // UPDATE HEADER
            // =========================
            $do->update([
                'customer_id' => $request->customer_id,
                'invoice_id' => $request->invoice_id,
                'shipping_address' => $request->shipping_address,
                'invoice_address' => $request->invoice_address,
                'delivery_date' => $request->delivery_date,
                'po_number' => $request->po_number,
                'project' => $request->project,
                'attn' => $request->attn,
                'shipper_name' => $request->shipper_name,
                'recipient_name' => $request->recipient_name,
            ]);

            // =========================
            // DELETE OLD ITEMS
            // =========================
            $do->items()->delete();

            // =========================
            // INSERT NEW ITEMS
            // =========================
            if ($request->items && isset($request->items['description'])) {

                $count = count($request->items['description']);

                for ($i = 0; $i < $count; $i++) {

                    if (!isset($request->items['description'][$i])) {
                        continue;
                    }

                    $do->items()->create([
                        'part_number'   => $request->items['part_number'][$i] ?? null,
                        'description'   => $request->items['description'][$i],
                        'qty'           => $request->items['qty'][$i] ?? 1,
                        'serial_number' => $request->items['serial_number'][$i] ?? null,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('delivery-orders.index')
                ->with('success', 'Delivery Order updated successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $do = DeliveryOrder::findOrFail($id);
        $do->delete();

        return redirect()->route('delivery-orders.index')
            ->with('success', 'Delivery Order deleted');
    }

    // =========================
    // DUPLICATE
    // =========================
    public function duplicate($id)
    {
        $old = DeliveryOrder::with(['items', 'invoice.customer', 'customer'])
            ->findOrFail($id);

        DB::beginTransaction();

        try {

            $dateObj = $old->print_date ? Carbon::parse($old->print_date) : Carbon::now();

            $last = DeliveryOrder::whereMonth('print_date', $dateObj->month)
                            ->whereYear('print_date', $dateObj->year)
                            ->latest('id')
                            ->first();

            $nextNumber = 1;

            if ($last) {
                $lastSeq = (int) substr($last->do_number, -4);
                $nextNumber = $lastSeq + 1;
            }

            $newNumber = 'DO-' . $dateObj->format('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $new = $old->replicate();



            $new->do_number = $newNumber;
            $new->created_at = now();
            $new->updated_at = now();

            // penting: pastikan relasi aman
            $new->invoice_id = $old->invoice_id;
            $new->customer_id = $old->customer_id;

            $new->save();

            // =========================
            // DUPLICATE ITEMS
            // =========================
            foreach ($old->items as $item) {
                $new->items()->create([
                    'part_number'   => $item->part_number,
                    'description'   => $item->description,
                    'qty'           => $item->qty,
                    'serial_number' => $item->serial_number,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('delivery-orders.edit', $new->id)
                ->with('success', 'Delivery Order duplicated successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function export()
    {
        return Excel::download(new DeliveryOrderExport, 'delivery-orders.xlsx');
    }
    // =========================
    // PDF
    // =========================
    public function pdf($id)
    {
        $do = DeliveryOrder::with('items', 'customer', 'invoice')
            ->findOrFail($id);

        $template = TemplatePDF::select('blade_name')->where('status', 'active')->first();

        $pdf = Pdf::loadView('delivery_orders.'.$template->blade_name, compact('do'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('DO-' . $do->do_number . '.pdf');
    }

    // =========================
    // GENERATE DO NUMBER
    // =========================
}
