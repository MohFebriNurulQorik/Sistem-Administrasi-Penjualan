<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Imports\ItemsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $items = Item::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // Agar saat pindah halaman, hasil search tidak hilang

        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => [
                'required',
                Rule::unique('items')->where(fn($q) => $q->where('tenant_id', auth()->user()->tenant_id)),
            ],
            'name'  => 'required',
            'price' => 'required|numeric',
            'type'  => 'required'
        ]);

        Item::create($request->all());

        return redirect()->route('items.index')->with('success', 'Item berhasil ditambahkan');
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'code' => [
                'required',
                Rule::unique('items')
                    ->where(fn($q) => $q->where('tenant_id', auth()->user()->tenant_id))
                    ->ignore($item->id), // Sesuaikan $item->id dengan variabel data Anda
            ],
            'name'  => 'required',
            'price' => 'required|numeric',
            'type'  => 'required'
        ]);

        $item->update($request->all());

        return redirect()->route('items.index')->with('success', 'Item berhasil diupdate');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new ItemsImport, $request->file('file'));

        return back()->with('success', 'Item berhasil diimport');
    }
}
