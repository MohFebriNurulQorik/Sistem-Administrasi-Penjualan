<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    protected $fillable = [
        'quotation_id',
        'type',
        'part_number',
        'description',
        'qty',
        'uom',
        'price',
        'total_price',
        'discount_percent',
        'amount',
        'total',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
