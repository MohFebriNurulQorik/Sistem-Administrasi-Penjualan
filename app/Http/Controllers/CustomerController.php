<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Position;

class CustomerController extends Controller
{
    // list
    public function index(Request $request)
    {
        $search = $request->get('search');

        $customers = Customer::when($search, function($query) use ($search) {
            $query->where('company_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhere('job', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        ->withQueryString(); // Penting agar pagination tidak hilang saat di-klik

        return view('customers.index', compact('customers'));
    }

    // form create
    public function create()
    {
        $positions= Position::all();
        return view('customers.create', compact('positions'));
    }

    // simpan
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Customer berhasil ditambahkan');
    }

    // form edit
    public function edit(Customer $customer)
    {
        $positions = Position::all();
        return view('customers.edit', compact('customer', 'positions'));
    }

    // update
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'company_name' => 'required',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Customer berhasil diupdate');
    }

    // delete
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new CustomersImport, $request->file('file'));

        return back()->with('success', 'Customer berhasil diimport');
    }
}