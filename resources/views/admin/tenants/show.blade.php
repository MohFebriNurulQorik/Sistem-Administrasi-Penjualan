<x-app-layout>
    <x-slot name="header">Detail Tenant — {{ $tenant->name }}</x-slot>

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-3 gap-6">

        {{-- Kolom Kiri: Info Tenant --}}
        <div class="col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-sm border text-center">

                {{-- Logo / Avatar --}}
                @if($tenant->logo)
                    <img src="{{ asset('storage/' . $tenant->logo) }}"
                         class="w-20 h-20 rounded-2xl object-cover border mx-auto mb-4">
                @else
                    <div class="w-20 h-20 rounded-2xl bg-blue-100 flex items-center justify-center mx-auto mb-4">
                        <span class="text-blue-600 font-bold text-2xl">
                            {{ strtoupper(substr($tenant->name, 0, 2)) }}
                        </span>
                    </div>
                @endif

                <h2 class="font-bold text-slate-800 text-lg">{{ $tenant->name }}</h2>
                <code class="text-xs text-slate-400">{{ $tenant->slug }}</code>

                <div class="mt-3">
                    <span class="text-xs px-3 py-1 rounded-full font-semibold
                        {{ $tenant->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        {{ $tenant->status === 'active' ? 'Aktif' : 'Non-aktif' }}
                    </span>
                </div>

                {{-- Info Detail --}}
                <div class="mt-6 text-left space-y-3 text-sm">
                    <div>
                        <p class="text-xs text-slate-400">Email</p>
                        <p class="font-medium text-slate-700">{{ $tenant->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Telepon</p>
                        <p class="font-medium text-slate-700">{{ $tenant->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Alamat</p>
                        <p class="font-medium text-slate-700">{{ $tenant->address ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Langganan</p>
                        <p class="font-medium text-slate-700">
                            @if($tenant->subscription_end)
                                {{ $tenant->subscription_start?->format('d M Y') }} –
                                {{ $tenant->subscription_end->format('d M Y') }}
                                @if(!$tenant->isSubscriptionValid())
                                    <span class="text-xs text-red-500 block">Expired</span>
                                @endif
                            @else
                                Unlimited
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="mt-6 flex flex-col gap-2">
                    <a href="{{ route('admin.tenants.edit', $tenant) }}"
                       class="bg-blue-600 text-white py-2 rounded-xl text-sm font-bold hover:bg-blue-700 transition-all">
                        Edit Tenant
                    </a>
                    <form action="{{ route('admin.tenants.toggle-status', $tenant) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="w-full py-2 rounded-xl text-sm font-bold transition-all
                            {{ $tenant->status === 'active'
                                ? 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100'
                                : 'bg-green-50 text-green-700 hover:bg-green-100' }}">
                            {{ $tenant->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                    <a href="{{ route('admin.tenants.index') }}"
                       class="bg-slate-100 text-slate-600 py-2 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">
                        Kembali
                    </a>
                </div>

            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div class="col-span-2 space-y-6">

            {{-- Statistik --}}
            <div class="grid grid-cols-3 gap-4">
                @foreach([
                    ['label' => 'Users', 'value' => $stats['users'], 'color' => 'blue'],
                    ['label' => 'Customers', 'value' => $stats['customers'], 'color' => 'green'],
                    ['label' => 'Invoices', 'value' => $stats['invoices'], 'color' => 'yellow'],
                    ['label' => 'Quotations', 'value' => $stats['quotations'], 'color' => 'purple'],
                    ['label' => 'Delivery Orders', 'value' => $stats['delivery_orders'], 'color' => 'slate'],
                ] as $stat)
                <div class="bg-white p-4 rounded-2xl shadow-sm border">
                    <p class="text-xs text-slate-400 mb-1">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $stat['value'] }}</p>
                </div>
                @endforeach
            </div>

            {{-- Daftar Users --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <h3 class="text-sm font-bold text-slate-700 mb-4 pb-2 border-b">Users Tenant</h3>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-left">
                            <th class="px-3 py-2 rounded-l-lg">Nama</th>
                            <th class="px-3 py-2">Email</th>
                            <th class="px-3 py-2 rounded-r-lg">Role</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($tenant->users as $user)
                        <tr>
                            <td class="px-3 py-2 font-semibold text-slate-700">{{ $user->name }}</td>
                            <td class="px-3 py-2 text-slate-500">{{ $user->email }}</td>
                            <td class="px-3 py-2">
                                <span class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-full">
                                    {{ $user->role ?? 'user' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-6 text-slate-400 text-xs">Belum ada user</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Assign User --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <h3 class="text-sm font-bold text-slate-700 mb-4 pb-2 border-b">Assign User ke Tenant</h3>
                <form action="{{ route('admin.tenants.assign-user', $tenant) }}" method="POST"
                      class="flex gap-3">
                    @csrf
                    <select name="user_id" class="w-full border p-2 rounded-xl text-sm">
                        <option value="">-- Pilih User --</option>
                        @foreach(\App\Models\User::where(function($q) use ($tenant) {
                            $q->whereNull('tenant_id')->orWhere('tenant_id', '!=', $tenant->id);
                        })->where('role', '!=', 'superadmin')->get() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-xl text-sm font-bold hover:bg-blue-700 transition-all text-nowrap">
                        Assign
                    </button>
                </form>
            </div>

        </div>
    </div>

</x-app-layout>