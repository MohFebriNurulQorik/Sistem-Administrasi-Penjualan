<x-app-layout>
    <x-slot name="header">Items</x-slot>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <!-- Judul -->
        <h2 class="text-xl font-bold text-slate-800">Data Items</h2>

        <!-- Grup Aksi -->
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <!-- Form Import -->
                <form action="{{ route('items.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2 bg-slate-50 p-1.5 rounded-2xl border border-slate-200">
                    @csrf
                    <input type="file" name="file" required
                        class="block w-full text-xs text-slate-500
                        file:mr-4 file:py-1.5 file:px-4
                        file:rounded-xl file:border-0
                        file:text-xs file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100 cursor-pointer focus:outline-none" />
                    
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                        Import
                    </button>
                </form>

                <!-- Tombol Tambah -->
                <a href="{{ route('items.create') }}" 
                class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-all shadow-lg shadow-blue-100 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Tambah Item
                </a>
            </div>
        </div>

        {{-- SEARCH --}}
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search item..." class="border rounded-lg px-3 py-2 w-80">

            <button class="bg-blue-600 text-white px-4 rounded-lg">
                Search
            </button>

            @if (request('search'))
                <a href="{{ route('items.index') }}" class="px-4 py-2 border rounded-lg">
                    Reset
                </a>
            @endif
        </form>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 font-medium rounded-r-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border border-slate-100">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="p-4 font-semibold border-b">Code</th>
                        <th class="p-4 font-semibold border-b">Name</th>
                        <th class="p-4 font-semibold border-b text-center">UOM</th>
                        <th class="p-4 font-semibold border-b">Price</th>
                        <th class="p-4 font-semibold border-b">Type</th>
                        <th class="p-4 font-semibold border-b text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    @foreach($items as $item)
                    <tr class="border-b hover:bg-slate-50 transition-colors">
                        <td class="p-4 font-medium text-blue-600 uppercase">{{ $item->code }}</td>
                        <td class="p-4 font-semibold text-slate-800">{{ $item->name }}</td>
                        <td class="p-4 text-center">
                            <span class="bg-slate-100 px-2 py-1 rounded text-[10px] font-bold uppercase">{{ $item->uom }}</span>
                        </td>
                        <td class="p-4">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $item->type == 'Service' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' }}">
                                {{ $item->type }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('items.edit', $item->id) }}" 
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                    Edit
                                </a>

                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus item ini?')" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $items->links() }}
        </div>

    </div>
</x-app-layout>
