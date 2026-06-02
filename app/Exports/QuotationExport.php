<?php

namespace App\Exports;

use App\Models\Quotation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuotationExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Quotation::with('customer')
            ->get()
            ->map(function ($q) {

                return [
                    'Quotation Number' => $q->quotation_number,
                    'Customer'         => $q->customer->company_name ?? '-',
                    'Project'          => $q->project,
                    'Subtotal'         => $q->subtotal,
                    'VAT'              => $q->vat_amount,
                    'Grand Total'      => $q->grand_total,
                    'Valid Until'      => $q->valid_until,
                    'Created At'       => $q->created_at->format('Y-m-d'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Quotation Number',
            'Customer',
            'Project',
            'Subtotal',
            'VAT',
            'Grand Total',
            'Valid Until',
            'Created At',
        ];
    }
}