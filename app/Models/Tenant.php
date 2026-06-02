<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'logo',
        'status',
        'subscription_start',
        'subscription_end',
    ];

    protected $casts = [
        'subscription_start' => 'date',
        'subscription_end'   => 'date',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    public function deliveryOrders(): HasMany
    {
        return $this->hasMany(DeliveryOrder::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    // ─── Helper ───────────────────────────────────────────────

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isSubscriptionValid(): bool
    {
        if (! $this->subscription_end) {
            return true; // unlimited
        }
        return now()->lte($this->subscription_end);
    }
}
