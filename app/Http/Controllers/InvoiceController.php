<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\InvoiceExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\TemplatePDF;

class InvoiceController extends Controller
{
    /**
     * List Invoice
     */
    public function index(Request $request)
    {
        $query = Invoice::with('customer');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('invoice_number', 'like', '%' . $request->search . '%')
                    ->orWhere('po_number', 'like', '%' . $request->search . '%')
                    ->orWhereHas('customer', function ($c) use ($request) {
                        $c->where('company_name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $invoices = $query->orderBy('invoice_number', 'desc')->paginate(10)->withQueryString();

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show Detail
     */
    public function show($id)
    {
        $invoice = Invoice::with(['customer', 'items'])->findOrFail($id);

        return view('invoices.show', compact('invoice'));
    }

    public function pdf($id)
    {
        $invoice = Invoice::with(['customer', 'items'])->findOrFail($id);

        $template = TemplatePDF::select('blade_name')->where('status', 'active')->first();
        $pdf = Pdf::loadView('invoices.' . $template->blade_name, compact('invoice'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');
    }

    /**
     * Create Form
     */
    public function create()
    {
        return view('invoices.create', [
            'customers' => Customer::all(),
            'items' => Item::all()
        ]);
    }

    /**
     * Store Invoice
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items.item_id' => 'required|array',
            'items.price' => 'required|array',
            'items.qty' => 'required|array',
            'print_date' => 'required|date',
            'vat_amount' => 'required'
        ]);


        DB::beginTransaction();

        try {

            $items = $request->items;


            $subtotal = 0;

            // =========================
            // CALCULATE SUBTOTAL
            // =========================
            for ($i = 0; $i < count($items['item_id']); $i++) {

                $price = (float) $items['price'][$i];
                $qty   = (float) $items['qty'][$i];

                $subtotal += $price * $qty;
            }

            // =========================
            // VAT (FROM FORM)
            // =========================
            $vatPercent = (float) $request->vat ?? 11;
            $vatAmount = $subtotal * $vatPercent / 100;

            $total = $subtotal + $vatAmount;

            // =========================
            // CREATE INVOICE
            // =========================

            $printDate = $request->print_date
                ? Carbon::parse($request->print_date)
                : now();

            $today = $printDate->format('Ymd');

            $last = Invoice::whereMonth('print_date', $printDate->month)
                ->whereYear('print_date', $printDate->year)
                ->orderBy('id', 'desc')
                ->first();

            $next = 1;

            if ($last) {
                $lastSeq = (int) substr($last->invoice_number, -4);
                $next = $lastSeq + 1;
            }

            $number = 'INV-' . $today . '-' . str_pad($next, 4, '0', STR_PAD_LEFT);

            $invoice = Invoice::create([
                'invoice_number' => $number,
                'customer_id' => $request->customer_id,
                'customer_invoice_id' => $request->customer_invoice_id,
                'so_number' => $request->so_number,
                'terms' => $request->terms,
                'due_date' => $request->due_date,
                'print_date' => $request->print_date ?? now(),

                'subtotal' => $subtotal,
                'vat' => $vatPercent,
                'vat_amount' => $vatAmount,
                'total_amount' => $total,
                'amount_in_words' => $this->terbilang($total),

                'currency' => 'IDR',
            ]);

            // =========================
            // INSERT ITEMS
            // =========================
            for ($i = 0; $i < count($items['item_id']); $i++) {

                $product = Item::find($items['item_id'][$i]);

                $price = (float) $items['price'][$i];
                $qty   = (float) $items['qty'][$i];

                $amount = $price * $qty;

                $invoice->items()->create([
                    'item_code' => $product->code,
                    'description' => $product->name,
                    'price' => $price,
                    'qty' => $qty,
                    'amount' => $amount,
                    'uom' => $product->uom,

                ]);
            }

            DB::commit();

            return redirect()
                ->route('invoices.index')
                ->with('success', 'Invoice berhasil dibuat');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->withInput()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Edit Form
     */
    public function edit($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        return view('invoices.edit', [
            'invoice' => $invoice,
            'items' => Item::all(),
            'customers' => Customer::all()
        ]);
    }

    /**
     * Update Invoice
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required',
            'print_date' => 'required|date',
            'due_date' => 'required|date',
            'items' => 'required|array',
            'items.item_id' => 'required|array',
        ]);

        $invoice = Invoice::findOrFail($id);

        // =========================
        // UPDATE INVOICE HEADER
        // =========================
        $invoice->update([
            'customer_id' => $request->customer_id,
            'customer_invoice_id' => $request->customer_invoice_id,
            'print_date' => $request->print_date,
            'due_date' => $request->due_date,
            'po_number' => $request->po_number,
            'so_number' => $request->so_number,
            'terms' => $request->terms,

            'subtotal' => $request->subtotal ?? 0,
            'vat' => $request->vat ?? 0,
            'vat_amount' => $request->vat_amount ?? 0,
            'total_amount' => $request->grand_total ?? 0,
        ]);

        // =========================
        // RESET ITEMS
        // =========================
        $invoice->items()->delete();

        // =========================
        // INSERT ITEMS BARU
        // =========================
        $items = $request->items;

        foreach ($items['item_id'] as $i => $itemId) {

            if (!$itemId) continue;

            $product = Item::find($items['item_id'][$i]);
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_code' => $product->code,
                'description' => $product->name,
                'price'    => $items['price'][$i] ?? 0,
                'qty'      => $items['qty'][$i] ?? 0,
                'uom'      => $items['uom'][$i]  ?? null,
                'amount'   => $items['amount'][$i] ?? 0,
            ]);
        }

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice updated successfully');
    }

    public function duplicate($id)
    {
        $old = Invoice::with('items')->findOrFail($id);

        DB::beginTransaction();

        try {

            // ===== GENERATE NUMBER BARU (FORMAT: INV-YYYYMMDD-0001) =====
            $dateObj = $old->print_date ? Carbon::parse($old->print_date) : Carbon::now();

            $last = Invoice::whereMonth('print_date', $dateObj->month)
                            ->whereYear('print_date', $dateObj->year)
                            ->latest('id')
                            ->first();

            $nextNumber = 1;

            if ($last) {
                $lastSeq = (int) substr($last->invoice_number, -4);
                $nextNumber = $lastSeq + 1;
            }

            $newNumber = 'INV-' . $dateObj->format('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // ===== COPY HEADER =====
            $new = $old->replicate();

            $new->invoice_number = $newNumber;
            $new->created_at = now();
            $new->updated_at = now();

            // optional reset kalau mau fresh hitung ulang
            // $new->subtotal = 0;
            // $new->vat_amount = 0;
            // $new->total_amount = 0;

            $new->save();

            // ===== COPY ITEMS =====
            foreach ($old->items as $item) {
                $new->items()->create([
                    'item_id'     => $item->item_id,     
                    'item_code'   => $item->item_code,
                    'description' => $item->description,

                    'price'  => $item->price,
                    'qty'    => $item->qty,
                    'uom'    => $item->uom,
                    'amount' => $item->amount,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('invoices.edit', $new->id)
                ->with('success', 'Invoice duplicated successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }
    /**
     * Delete
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice deleted');
    }

    public function exportInvoice()
    {
        return Excel::download(new InvoiceExport, 'invoices.xlsx');
    }
    /**
     * =========================
     * HELPERS
     * =========================
     */

    private function calculateSubtotal($items)
    {
        $subtotal = 0;

        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        return $subtotal;
    }



    private function terbilang($number)
    {
        return strtoupper(
            \NumberFormatter::create('id', \NumberFormatter::SPELLOUT)->format($number)
        ) . ' RUPIAH';
    }
}
