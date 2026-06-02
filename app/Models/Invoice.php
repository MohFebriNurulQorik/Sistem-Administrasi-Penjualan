<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Invoice extends Model
{

    use BelongsToTenant; 
      protected $fillable = [
        'invoice_number',
        'customer_id',
        'customer_invoice_id',
        'quotation_id',
        'po_number',
        'so_number',
        'terms',
        'due_date',
        'currency',
        'subtotal',
        'vat',
        'vat_amount',
        'total_amount',
        'amount_in_words',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'print_date',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function customerInvoice()
    {
        return $this->belongsTo(Customer::class, 'customer_invoice_id');
    }
}
