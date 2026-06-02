<x-app-layout>
    <x-slot name="header">Positions</x-slot>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">

            <h2 class="text-xl font-bold text-slate-800">Data Position</h2>

            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">

                <!-- IMPORT -->
                <form action="{{ route('positions.import') }}" method="POST" enctype="multipart/form-data"
                    class="flex items-center gap-2 bg-slate-50 p-1.5 rounded-2xl border border-slate-200">
                    @csrf

                    <input type="file" name="file" required
                        class="block text-xs text-slate-500
                        file:mr-3 file:py-1.5 file:px-4
                        file:rounded-xl file:border-0
                        file:text-xs file:font-semibold
                        file:bg-green-50 file:text-green-700
                        hover:file:bg-green-100 cursor-pointer" />

                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
                        
                        <!-- ICON -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>

                        Import
                    </button>
                </form>

                <!-- CREATE -->
                <a href="{{ route('positions.create') }}"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center gap-2">
                    Tambah Position
                </a>

            </div>
        </div>

        <!-- ALERT -->
        @if(session('success'))
            <div class="mb-4 p-3 rounded-xl bg-green-50 text-green-700 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- TABLE -->
        <div class="overflow-x-auto rounded-xl border">
            <table class="w-full text-sm text-left">

                <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                    <tr>
                        <th class="p-3 w-12 text-center">No</th>
                        <th class="p-3">Position Name</th>
                        <th class="p-3 w-40 text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($positions as $p)
                        <tr class="hover:bg-slate-50 transition">

                            <td class="p-3 text-center text-slate-500">
                                {{ $loop->iteration }}
                            </td>

                            <td class="p-3 font-semibold text-slate-800">
                                {{ $p->position_name }}
                            </td>

                            <td class="p-3 text-center">
                                <div class="flex justify-center gap-2">

                                    <!-- EDIT -->
                                    <a href="{{ route('positions.edit',$p->id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 px-3 py-1 rounded-lg text-xs font-bold transition">
                                        Edit
                                    </a>

                                    <!-- DELETE -->
                                    <form method="POST" action="{{ route('positions.destroy',$p->id) }}">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Yakin hapus data?')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs font-bold transition">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-6 text-center text-slate-400">
                                Belum ada data position
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-4">
            {{ $positions->links() }}
        </div>

    </div>
</x-app-layout>