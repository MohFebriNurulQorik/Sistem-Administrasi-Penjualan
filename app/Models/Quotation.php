<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Quotation extends Model
{
    use BelongsToTenant; 
    protected $fillable = [
        'quotation_number',
        'customer_id',
        'valid_until',
        'project',
        'attn',
        'subtotal',
        'vat',
        'vat_amount',
        'grand_total',
        'remark',
        'print_date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }
}