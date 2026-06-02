<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class DeliveryOrder extends Model
{
    use BelongsToTenant; 
    
    protected $fillable = [
        'do_number',
        'customer_id',
        'invoice_id',
        'shipping_address',
        'invoice_address',
        'delivery_date',
        'po_number',
        'project',
        'attn',
        'shipper_name',
        'recipient_name',
        'print_date'
    ];

    // =========================
    // RELATIONSHIP
    // =========================

    // ke customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // ke invoice (optional)
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // ke items
    public function items()
    {
        return $this->hasMany(DeliveryOrderItem::class);
    }
}