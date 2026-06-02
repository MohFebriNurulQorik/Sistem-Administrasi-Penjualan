<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        // Super admin tidak perlu tenant scope
        if ($user->role === 'superadmin') {
            return $next($request);
        }

        // User harus punya tenant_id
        if (! $user->tenant_id) {
            abort(403, 'Akun Anda belum terhubung ke tenant manapun.');
        }

        $tenant = Tenant::find($user->tenant_id);

        if (! $tenant) {
            abort(404, 'Tenant tidak ditemukan.');
        }

        if (! $tenant->isActive()) {
            abort(403, 'Tenant tidak aktif. Hubungi administrator.');
        }

        if (! $tenant->isSubscriptionValid()) {
            abort(403, 'Masa berlangganan tenant telah habis.');
        }

        // Bind tenant ke service container
        app()->instance('currentTenant', $tenant);

        // Share ke semua view Blade
        view()->share('currentTenant', $tenant);

        return $next($request);
    }
}