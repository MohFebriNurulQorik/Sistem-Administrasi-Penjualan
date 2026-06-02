<x-app-layout>
    <x-slot name="header">Projects</x-slot>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <!-- Judul -->
            <h2 class="text-xl font-bold text-slate-800">Data Projects</h2>

            <!-- Grup Aksi (Import & Tambah) -->
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                
                <!-- Form Import Project -->
                <form action="{{ route('projects.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2 bg-slate-50 p-1.5 rounded-2xl border border-slate-200">
                    @csrf
                    <input type="file" name="file" required
                        class="block w-full text-xs text-slate-500
                        file:mr-4 file:py-1.5 file:px-4
                        file:rounded-xl file:border-0
                        file:text-xs file:font-semibold
                        file:bg-green-50 file:text-green-700
                        hover:file:bg-green-100 cursor-pointer focus:outline-none" />
                    
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                        Import
                    </button>
                </form>

                <!-- Tombol Tambah Project -->
                <a href="{{ route('projects.create') }}" 
                class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-all shadow-lg shadow-blue-100 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Tambah Project
                </a>
            </div>
        </div>

        {{-- SEARCH --}}
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search Project Name..." class="border rounded-lg px-3 py-2 w-80">

            <button class="bg-blue-600 text-white px-4 rounded-lg">
                Search
            </button>

            @if (request('search'))
                <a href="{{ route('projects.index') }}" class="px-4 py-2 border rounded-lg">
                    Reset
                </a>
            @endif
        </form>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden border border-slate-100 rounded-2xl">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 font-bold">No</th>
                        <th class="p-4 font-bold">Project Code</th>
                        <th class="p-4 font-bold">Project Name</th>
                        <th class="p-4 font-bold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($projects as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-4 text-slate-500">{{ $loop->iteration }}</td>
                        <td class="p-4 uppercase tracking-tight">
                            <span class="bg-slate-100 text-slate-700 px-2 py-1 rounded-lg font-mono font-bold text-xs border border-slate-200">
                                {{ $p->code }}
                            </span>
                        </td>
                        <td class="p-4 font-semibold text-slate-700">{{ $p->name }}</td>
                        <td class="p-4">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('projects.edit', $p->id) }}" 
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                    Edit
                                </a>

                                <form action="{{ route('projects.destroy', $p->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin hapus?')" 
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
            {{ $projects->links() }}
        </div>

    </div>
</x-app-layout>
