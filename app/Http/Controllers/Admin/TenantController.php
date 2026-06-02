<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    // ─── Index ────────────────────────────────────────────────

    public function index(Request $request)
    {
      
        $tenants = Tenant::withCount('users')
            ->when($request->search, fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('slug', 'like', "%{$request->search}%")
            )
            ->latest()
            ->paginate(15);

        return view('admin.tenants.index', compact('tenants'));
    }

    // ─── Create ───────────────────────────────────────────────

    public function create()
    {
        return view('admin.tenants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'slug'               => 'required|string|max:100|unique:tenants,slug|alpha_dash',
            'email'              => 'nullable|email|max:255',
            'phone'              => 'nullable|string|max:20',
            'address'            => 'nullable|string',
            'logo'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'             => 'required|in:active,inactive',
            'subscription_start' => 'nullable|date',
            'subscription_end'   => 'nullable|date|after_or_equal:subscription_start',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('tenants/logos', 'public');
        }

        $tenant = Tenant::create($validated);

        return redirect()->route('admin.tenants.show', $tenant)
                         ->with('success', "Tenant \"{$tenant->name}\" berhasil dibuat.");
    }

    // ─── Show ─────────────────────────────────────────────────

    public function show(Tenant $tenant)
    {
        $tenant->load('users');
        $stats = [
            'users'          => $tenant->users()->count(),
            'customers'      => $tenant->customers()->count(),
            'invoices'       => $tenant->invoices()->count(),
            'quotations'     => $tenant->quotations()->count(),
            'delivery_orders'=> $tenant->deliveryOrders()->count(),
        ];

        return view('admin.tenants.show', compact('tenant', 'stats'));
    }

    // ─── Edit ─────────────────────────────────────────────────

    public function edit(Tenant $tenant)
    {
        return view('admin.tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'slug'               => ['required','string','max:100','alpha_dash', Rule::unique('tenants','slug')->ignore($tenant->id)],
            'email'              => 'nullable|email|max:255',
            'phone'              => 'nullable|string|max:20',
            'address'            => 'nullable|string',
            'logo'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'             => 'required|in:active,inactive',
            'subscription_start' => 'nullable|date',
            'subscription_end'   => 'nullable|date|after_or_equal:subscription_start',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('tenants/logos', 'public');
        }

        $tenant->update($validated);

        return redirect()->route('admin.tenants.show', $tenant)
                         ->with('success', 'Data tenant berhasil diperbarui.');
    }

    // ─── Delete ───────────────────────────────────────────────

    public function destroy(Tenant $tenant)
    {
        $name = $tenant->name;
        $tenant->delete(); // cascade akan hapus semua data terkait

        return redirect()->route('admin.tenants.index')
                         ->with('success', "Tenant \"{$name}\" berhasil dihapus.");
    }

    // ─── Toggle Status ────────────────────────────────────────

    public function toggleStatus(Tenant $tenant)
    {
        $tenant->update([
            'status' => $tenant->status === 'active' ? 'inactive' : 'active'
        ]);

        return back()->with('success', "Status tenant diubah menjadi {$tenant->status}.");
    }

    // ─── Assign User ke Tenant ────────────────────────────────

    public function assignUser(Request $request, Tenant $tenant)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        User::where('id', $request->user_id)
            ->update(['tenant_id' => $tenant->id]);

        return back()->with('success', 'User berhasil ditambahkan ke tenant.');
    }
}
