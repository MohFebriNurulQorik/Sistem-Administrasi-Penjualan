<?php

namespace App\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    /**
     * Boot trait: otomatis set tenant_id saat create,
     * dan filter query hanya data tenant aktif.
     */
    public static function bootBelongsToTenant(): void
    {
        // Auto-set tenant_id saat membuat record baru
        static::creating(function ($model) {
            if (! $model->tenant_id && app()->bound('currentTenant')) {
                $model->tenant_id = app('currentTenant')->id;
            }
        });

        // Global scope: semua query otomatis filter per tenant
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (app()->bound('currentTenant')) {
                $builder->where(
                    $builder->getModel()->getTable() . '.tenant_id',
                    app('currentTenant')->id
                );
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
