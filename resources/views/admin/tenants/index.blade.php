<x-app-layout>
    <x-slot name="header">Manajemen Tenant</x-slot>

    <div class="bg-white p-6 rounded-2xl shadow-sm border">

        {{-- Alert --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header + Tombol Tambah --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Daftar Tenant</h2>
                <p class="text-sm text-slate-500">Kelola semua tenant yang terdaftar di sistem</p>
            </div>
            <a href="{{ route('admin.tenants.create') }}"
               class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all">
                + Tambah Tenant
            </a>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.tenants.index') }}" class="flex gap-2 mb-6">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama atau slug tenant..."
                   class="w-full border p-2 rounded-xl text-sm">
            <button type="submit"
                    class="bg-slate-100 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-all">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.tenants.index') }}"
                   class="bg-red-50 text-red-600 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-red-100 transition-all">
                    Reset
                </a>
            @endif
        </form>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 text-left">
                        <th class="px-4 py-3 rounded-l-xl">#</th>
                        <th class="px-4 py-3">Tenant</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Telepon</th>
                        <th class="px-4 py-3">Langganan</th>
                        <th class="px-4 py-3">Users</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 rounded-r-xl text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tenants as $tenant)
                    <tr class="hover:bg-slate-50 transition-all">
                        <td class="px-4 py-3 text-slate-400">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if($tenant->logo)
                                    <img src="{{ asset('storage/' . $tenant->logo) }}"
                                         class="w-9 h-9 rounded-lg object-cover border">
                                @else
                                    <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-content-center">
                                        <span class="text-blue-600 font-bold text-xs">
                                            {{ strtoupper(substr($tenant->name, 0, 2)) }}
                                        </span>
                                    </div>
                                @endif
                                <div>
                                    <div class="font-semibold text-slate-800">{{ $tenant->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $tenant->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <code class="text-xs bg-slate-100 px-2 py-1 rounded">{{ $tenant->slug }}</code>
                        </td>
                        <td class="px-4 py-3 text-slate-500">{{ $tenant->phone ?? '-' }}</td>
                        <td class="px-4 py-3 text-xs">
                            @if($tenant->subscription_end)
                                @if($tenant->isSubscriptionValid())
                                    <span class="text-green-600">s/d {{ $tenant->subscription_end->format('d M Y') }}</span>
                                @else
                                    <span class="text-red-500">Expired {{ $tenant->subscription_end->format('d M Y') }}</span>
                                @endif
                            @else
                                <span class="text-slate-400">Unlimited</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-slate-100 text-slate-600 text-xs px-2 py-1 rounded-full">
                                {{ $tenant->users_count }} user
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <form action="{{ route('admin.tenants.toggle-status', $tenant) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    class="text-xs px-3 py-1 rounded-full font-semibold transition-all
                                    {{ $tenant->status === 'active'
                                        ? 'bg-green-100 text-green-700 hover:bg-green-200'
                                        : 'bg-red-100 text-red-600 hover:bg-red-200' }}">
                                    {{ $tenant->status === 'active' ? 'Aktif' : 'Non-aktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.tenants.show', $tenant) }}"
                                   class="text-xs bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg hover:bg-slate-200 transition-all">
                                    Detail
                                </a>
                                <a href="{{ route('admin.tenants.edit', $tenant) }}"
                                   class="text-xs bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition-all">
                                    Edit
                                </a>
                                <form action="{{ route('admin.tenants.destroy', $tenant) }}" method="POST"
                                      onsubmit="return confirm('Hapus tenant {{ $tenant->name }}? Semua data akan ikut terhapus!')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-100 transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-12 text-slate-400">
                            <div class="text-4xl mb-2">🏢</div>
                            Belum ada tenant terdaftar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($tenants->hasPages())
            <div class="mt-4">{{ $tenants->links() }}</div>
        @endif

    </div>
</x-app-layout>