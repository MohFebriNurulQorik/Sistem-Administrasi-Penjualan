<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrderItem extends Model
{
    protected $fillable = [
        'delivery_order_id',
        'part_number',
        'description',
        'qty',
        'serial_number',
    ];

    // =========================
    // RELATIONSHIP
    // =========================

    public function deliveryOrder()
    {
        return $this->belongsTo(DeliveryOrder::class);
    }
}