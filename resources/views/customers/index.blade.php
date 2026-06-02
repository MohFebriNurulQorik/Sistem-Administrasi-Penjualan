<x-app-layout>
    <x-slot name="header">Customers</x-slot>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <!-- Judul -->
            <h2 class="text-xl font-bold text-slate-800">Data Customers</h2>

            <!-- Grup Aksi (Import & Tambah) -->
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">

                <!-- Form Import Customer -->
                <form action="{{ route('customers.import') }}" method="POST" enctype="multipart/form-data"
                    class="flex items-center gap-2 bg-slate-50 p-1.5 rounded-2xl border border-slate-200">
                    @csrf
                    <input type="file" name="file" required
                        class="block w-full text-xs text-slate-500
                        file:mr-4 file:py-1.5 file:px-4
                        file:rounded-xl file:border-0
                        file:text-xs file:font-semibold
                        file:bg-green-50 file:text-green-700
                        hover:file:bg-green-100 cursor-pointer focus:outline-none" />

                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Import
                    </button>
                </form>

                <!-- Tombol Tambah Customer -->
                <a href="{{ route('customers.create') }}"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-all shadow-lg shadow-blue-100 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Customer
                </a>
            </div>
        </div>

        {{-- SEARCH --}}
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search customer..." class="border rounded-lg px-3 py-2 w-80">

            <button class="bg-blue-600 text-white px-4 rounded-lg">
                Search
            </button>

            @if (request('search'))
                <a href="{{ route('customers.index') }}" class="px-4 py-2 border rounded-lg">
                    Reset
                </a>
            @endif
        </form>

        @if (session('success'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="p-3">No</th>
                        <th class="p-3">Company</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Phone</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Posision</th>
                        <th class="p-3">Address</th>
                        <th class="p-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $c)
                        <tr class="border-t">
                            <td class="p-3">{{ $loop->iteration }}</td>
                            <td class="p-3 font-semibold">{{ $c->company_name }}</td>
                            <td class="p-3">{{ $c->email }}</td>
                            <td class="p-3">{{ $c->phone }}</td>
                            <td class="p-3">{{ $c->attn }}</td>
                            <td class="p-3">{{ $c->job }}</td>
                            <td class="p-3">{{ $c->address }}</td>
                            <td class="p-3 text-center flex gap-2 justify-center">
                                <a href="{{ route('customers.edit', $c->id) }}"
                                    class="bg-yellow-400 px-3 py-1 rounded text-xs font-bold">
                                    Edit
                                </a>

                                <form action="{{ route('customers.destroy', $c->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin hapus?')"
                                        class="bg-red-500 text-white px-3 py-1 rounded text-xs font-bold">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $customers->links() }}
        </div>

    </div>
</x-app-layout>
