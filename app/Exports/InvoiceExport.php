<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoiceExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Invoice::with('customer', 'customerInvoice')
            ->get()
            ->map(function ($inv) {
                return [
                    'Invoice Number' => $inv->invoice_number,
                    'Customer'       => $inv->customer->company_name ?? '-',
                    'Invoice To'     => $inv->customerInvoice->company_name ?? '-',
                    'PO Number'      => $inv->po_number,
                    'SO Number'      => $inv->so_number,
                    'Subtotal'       => $inv->subtotal,
                    'VAT'            => $inv->vat_amount,
                    'Total'          => $inv->total_amount,
                    'Due Date'       => $inv->due_date,
                    'Print Date'     => $inv->print_date,
                    'Created At'     => $inv->created_at->format('Y-m-d'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Invoice Number',
            'Customer',
            'Invoice To',
            'PO Number',
            'SO Number',
            'Subtotal',
            'VAT',
            'Total',
            'Due Date',
            'Print Date',
            'Created At',
        ];
    }
}