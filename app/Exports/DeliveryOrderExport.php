<?php

namespace App\Exports;

use App\Models\DeliveryOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DeliveryOrderExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DeliveryOrder::with('customer', 'invoice')
            ->get()
            ->map(function ($do) {
                return [
                    'DO Number'      => $do->do_number,
                    'Customer'       => $do->customer->company_name ?? '-',
                    'Invoice'        => $do->invoice->invoice_number ?? '-',
                    'Delivery Date'  => $do->delivery_date,
                    'PO Number'      => $do->po_number,
                    'Project'        => $do->project,
                    'Attn'           => $do->attn,
                    'Created At'     => $do->created_at->format('Y-m-d'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'DO Number',
            'Customer',
            'Invoice',
            'Delivery Date',
            'PO Number',
            'Project',
            'Attn',
            'Created At',
        ];
    }
}