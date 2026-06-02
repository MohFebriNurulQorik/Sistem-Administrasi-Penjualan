<x-app-layout>
    <x-slot name="header">Edit Tenant — {{ $tenant->name }}</x-slot>

    <div class="bg-white p-6 rounded-2xl shadow-sm border">

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg">
                <ul class="text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.tenants.update', $tenant) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- Informasi Perusahaan --}}
            <div class="mb-6">
                <h3 class="text-sm font-bold text-slate-700 mb-4 pb-2 border-b">Informasi Perusahaan</h3>
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Nama Perusahaan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name"
                               value="{{ old('name', $tenant->name) }}"
                               class="w-full border p-2 rounded-xl text-sm @error('name') border-red-400 @enderror">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Slug <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="slug"
                               value="{{ old('slug', $tenant->slug) }}"
                               class="w-full border p-2 rounded-xl text-sm @error('slug') border-red-400 @enderror">
                        @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', $tenant->email) }}"
                               class="w-full border p-2 rounded-xl text-sm @error('email') border-red-400 @enderror">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Telepon</label>
                        <input type="text" name="phone"
                               value="{{ old('phone', $tenant->phone) }}"
                               class="w-full border p-2 rounded-xl text-sm @error('phone') border-red-400 @enderror">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
                        <textarea name="address" rows="2"
                                  class="w-full border p-2 rounded-xl text-sm @error('address') border-red-400 @enderror">{{ old('address', $tenant->address) }}</textarea>
                        @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Logo</label>
                        @if($tenant->logo)
                            <div class="mb-2 flex items-center gap-3">
                                <img src="{{ asset('storage/' . $tenant->logo) }}"
                                     class="h-12 rounded-lg border object-cover">
                                <span class="text-xs text-slate-400">Logo saat ini</span>
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/jpg,image/jpeg,image/png"
                               class="w-full border p-2 rounded-xl text-sm @error('logo') border-red-400 @enderror">
                        <p class="text-xs text-slate-400 mt-1">Kosongkan jika tidak ingin mengubah logo</p>
                        @error('logo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>

            {{-- Langganan & Status --}}
            <div class="mb-6">
                <h3 class="text-sm font-bold text-slate-700 mb-4 pb-2 border-b">Langganan & Status</h3>
                <div class="grid grid-cols-3 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full border p-2 rounded-xl text-sm @error('status') border-red-400 @enderror">
                            <option value="active" {{ old('status', $tenant->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status', $tenant->status) === 'inactive' ? 'selected' : '' }}>Non-aktif</option>
                        </select>
                        @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Mulai Langganan</label>
                        <input type="date" name="subscription_start"
                               value="{{ old('subscription_start', $tenant->subscription_start?->format('Y-m-d')) }}"
                               class="w-full border p-2 rounded-xl text-sm @error('subscription_start') border-red-400 @enderror">
                        @error('subscription_start')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Akhir Langganan</label>
                        <input type="date" name="subscription_end"
                               value="{{ old('subscription_end', $tenant->subscription_end?->format('Y-m-d')) }}"
                               class="w-full border p-2 rounded-xl text-sm @error('subscription_end') border-red-400 @enderror">
                        <p class="text-xs text-slate-400 mt-1">Kosongkan untuk unlimited</p>
                        @error('subscription_end')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>

            {{-- Tombol --}}
            <div class="pt-6 border-t border-slate-100 flex justify-end items-center gap-3">
                <a href="{{ route('admin.tenants.show', $tenant) }}"
                   class="bg-gray-500 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-600 transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-8 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</x-app-layout>