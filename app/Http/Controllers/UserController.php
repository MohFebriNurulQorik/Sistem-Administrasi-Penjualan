<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function index()
    {
        $users = User::where('tenant_id', auth()->user()->tenant_id)->latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => [
                'required',
                'email',
                // Unique per tenant, bukan global
                Rule::unique('users')->where(fn($q) => $q->where('tenant_id', auth()->user()->tenant_id)),
            ],
            'password' => 'required|min:6',
            'role'     => 'required',
        ]);

        User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
            'company_name' => $request->company_name,
            'tenant_id'    => auth()->user()->tenant_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required',
            'email' => [
                'required',
                'email',
                // Unique per tenant, kecuali user ini sendiri
                Rule::unique('users')
                    ->where(fn($q) => $q->where('tenant_id', auth()->user()->tenant_id))
                    ->ignore($user->id),
            ],
            'role'  => 'required',
        ]);

        $user->update([
            'name'         => $request->name,
            'email'        => $request->email,
            'role'         => $request->role,
            'company_name' => $request->company_name,
            'tenant_id'    => auth()->user()->tenant_id,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}