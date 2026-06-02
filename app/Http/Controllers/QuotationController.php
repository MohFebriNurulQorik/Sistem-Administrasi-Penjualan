<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Customer;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\QuotationExport;
use App\Models\Project;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\TemplatePDF;
use Illuminate\Validation\Rule;


class QuotationController extends Controller
{
    /**
     * Display list
     */
    public function index(Request $request)
    {
        $query = Quotation::with('customer');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('quotation_number', 'like', '%' . $request->search . '%')
                    ->orWhere('project', 'like', '%' . $request->search . '%')
                    ->orWhereHas('customer', function ($c) use ($request) {
                        $c->where('company_name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $quotations = $query->orderBy('quotation_number', 'desc')->paginate(10)->withQueryString();

        return view('quotations.index', compact('quotations'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $customers = Customer::all();
        $items = Item::all();
        $projects = Project::all();

        return view('quotations.create', compact('customers', 'items', 'projects'));
    }

    /**
     * Store new quotation
     */
    public function store(Request $request)
    {
        $request->validate([
            'print_date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'valid_until' => 'required|date',
            'project' => 'required|string',

            'items.item_id' => 'required|array',
            'items.item_id.*' => 'required|exists:items,id',

            'items.price.*' => 'required|numeric',
            'items.qty.*' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {

            $items = $request->items;

            // ===== HITUNG SUBTOTAL =====
            $subtotal = 0;

            for ($i = 0; $i < count($items['item_id']); $i++) {

                $price = (float) $items['price'][$i];
                $qty   = (int) $items['qty'][$i];
                $disc  = (float) ($items['discount'][$i] ?? 0);

                $total = $price * $qty;
                $amount = $total - ($total * $disc / 100);

                $subtotal += $amount;
            }

            // ===== VAT =====
            $vatPercent = (float) ($request->vat ?? 11);
            $vatAmount  = (float) ($request->vat_amount ?? ($subtotal * $vatPercent / 100));
            $grandTotal = $subtotal + $vatAmount;

            // ===== QUOTATION NUMBER =====
            $printDate = $request->print_date
                ? Carbon::parse($request->print_date)
                : now();

            $today = $printDate->format('Ymd');

            $last = Quotation::whereMonth('print_date', $printDate->month)
                ->whereYear('print_date', $printDate->year)
                ->orderBy('id', 'desc')
                ->first();

            $nextNumber = 1;

            if ($last && preg_match('/QT-\d{8}-(\d+)/', $last->number, $m)) {
                $nextNumber = (int)$m[1] + 1;
            }

            $number = 'QT-' . $today . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // ===== CREATE QUOTATION =====
            $quotation = Quotation::create([
                'quotation_number' => $number,
                'customer_id' => $request->customer_id,
                'valid_until' => $request->valid_until,
                'project' => $request->project,
                'attn' => null,
                'subtotal' => $subtotal,
                'vat' => $vatPercent,
                'vat_amount' => $vatAmount,
                'grand_total' => $grandTotal,
                'remark' => $request->remark ?? null,
                'print_date' => $request->print_date ?? null,
            ]);

            // ===== INSERT ITEMS =====
            for ($i = 0; $i < count($items['item_id']); $i++) {

                $product = Item::find($items['item_id'][$i]);

                $price = (float) $items['price'][$i];
                $qty   = (int) $items['qty'][$i];
                $disc  = (float) ($items['discount'][$i] ?? 0);

                $total = $price * $qty;
                $amount = $total - ($total * $disc / 100);

                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'type' => $product->type,
                    'part_number' => $product->code ?? null,
                    'description' => $product->name,
                    'qty' => $qty,
                    'uom' => $items['uom'][$i] ?? $product->uom,
                    'price' => $price,
                    'total_price' => $total,
                    'discount_percent' => $disc,
                    'amount' => $amount,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('quotations.index')
                ->with('success', 'Quotation berhasil dibuat');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'error' => $e->getMessage()
                ]);
        }
    }

    /**
     * Show detail
     */
    public function show($id)
    {
        $quotation = Quotation::with(['customer', 'items'])
            ->findOrFail($id);

        return view('quotations.show', compact('quotation'));
    }

    public function printPdf($id)
    {
        $quotation = Quotation::with('customer', 'items')->findOrFail($id);

        $template = TemplatePDF::select('blade_name')->where('status', 'active')->first();
        
        $pdf = Pdf::loadView('quotations.' . $template->blade_name, compact('quotation', 'template'));


        $pdf->setPaper('A4', 'portrait');
        

        return $pdf->stream('quotation-' . $quotation->quotation_number . '.pdf');
    }

    /**
     * Edit form
     */
    public function edit($id)
    {
        $quotation = Quotation::with('items')->findOrFail($id);
        $projects = Project::all();

        return view('quotations.edit', [
            'quotation' => $quotation,
            'customers' => Customer::all(),
            'items' => Item::all(),
            'projects' => $projects
        ]);
    }

    /**
     * Update quotation
     */
    public function update(Request $request, $id)
    {

        
        $request->validate([
            'print_date'       => 'required|date',
            'valid_until'      => 'required|date',
            'project'          => 'required|string',
            'quotation_number' => [
                'required',
                Rule::unique('quotations')
                    ->where(fn($q) => $q->where('tenant_id', auth()->user()->tenant_id))
                    ->ignore($id),
            ],
            'customer_id'      => 'required|exists:customers,id',
            'items.item_id' => 'required|array', 
        ]);

        DB::beginTransaction();

        try {

            $quotation = Quotation::findOrFail($id);

            $subtotal = 0;

            // ambil semua array
            $itemIds = $request->items['item_id'];
            $prices  = $request->items['price'];
            $qtys    = $request->items['qty'];
            $uoms    = $request->items['uom'];
            $discs   = $request->items['discount'];

            // ===== HITUNG SUBTOTAL =====
            foreach ($itemIds as $i => $itemId) {

                $price = (float) ($prices[$i] ?? 0);
                $qty   = (int) ($qtys[$i] ?? 0);
                $disc  = (float) ($discs[$i] ?? 0);

                $total  = $price * $qty;
                $amount = $total - ($total * $disc / 100);

                $subtotal += $amount;
            }

            // ===== VAT =====
            $vatPercent = (float) ($request->vat ?? 11);
            $vatAmount  = $subtotal * ($vatPercent / 100);
            $grandTotal = $subtotal + $vatAmount;

            // ===== UPDATE HEADER =====
            $quotation->update([
                'customer_id' => $request->customer_id,
                'quotation_number' => $request->quotation_number,
                'valid_until' => $request->valid_until,
                'project' => $request->project,
                'subtotal' => $subtotal,
                'vat' => $vatPercent,
                'vat_amount' => $vatAmount,
                'grand_total' => $grandTotal,
                'remark' => $request->remark ?? null,
                'print_date' => $request->print_date ?? null,
            ]);

            // ===== HAPUS ITEM LAMA =====
            $quotation->items()->delete();

            // ===== INSERT ULANG =====
            foreach ($itemIds as $i => $itemId) {

                $product = Item::find($itemId);

                $price = (float) ($prices[$i] ?? 0);
                $qty   = (int) ($qtys[$i] ?? 0);
                $disc  = (float) ($discs[$i] ?? 0);
                $uom   = $uoms[$i] ?? $product->uom;

                $total  = $price * $qty;
                $amount = $total - ($total * $disc / 100);

                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'type' => $product->type ?? null,
                    'part_number' => $product->code ?? null,
                    'description' => $product->name ?? null,
                    'qty' => $qty,
                    'uom' => $uom,
                    'price' => $price,
                    'total_price' => $total,
                    'discount_percent' => $disc,
                    'amount' => $amount,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('quotations.index')
                ->with('success', 'Quotation updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Delete quotation
     */
    public function destroy($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->delete();

        return redirect()->route('quotations.index')->with('success', 'Quotation deleted');
    }

    public function exportQuotation()
    {
        return Excel::download(new QuotationExport, 'quotations.xlsx');
    }

    public function duplicate($id)
    {
        $old = Quotation::with('items')->findOrFail($id);

        DB::beginTransaction();

        try {

            $dateObj = $old->print_date ? Carbon::parse($old->print_date) : Carbon::now();

            $last = Quotation::whereMonth('print_date', $dateObj->month)
                            ->whereYear('print_date', $dateObj->year)
                            ->latest('id')
                            ->first();

            $nextNumber = 1;

            if ($last) {
                $lastSeq = (int) substr($last->quotation_number, -4);
                $nextNumber = $lastSeq + 1;
            }

            $newNumber = 'QT-' . $dateObj->format('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $new = $old->replicate();

            $new->quotation_number = $newNumber;
            $new->created_at = now();
            $new->updated_at = now();

            $new->save();

            // ===== COPY ITEMS =====
            foreach ($old->items as $item) {
                $new->items()->create([
                    'type' => $item->type,
                    'part_number' => $item->part_number,
                    'description' => $item->description,
                    'qty' => $item->qty,
                    'uom' => $item->uom,
                    'price' => $item->price,
                    'discount_percent' => $item->discount_percent,
                    'amount' => $item->amount,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('quotations.edit', $new->id)
                ->with('success', 'Quotation duplicated successfully');
        } catch (\Exception $e) {


            DB::rollBack();


            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }
}
