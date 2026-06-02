<x-app-layout>
    <x-slot name="header">Tambah Tenant Baru</x-slot>

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

        <form action="{{ route('admin.tenants.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Informasi Perusahaan --}}
            <div class="mb-6">
                <h3 class="text-sm font-bold text-slate-700 mb-4 pb-2 border-b">Informasi Perusahaan</h3>
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Nama Perusahaan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name') }}"
                               placeholder="contoh: PT Maju Jaya"
                               class="w-full border p-2 rounded-xl text-sm @error('name') border-red-400 @enderror">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Slug <span class="text-red-500">*</span>
                            <span class="text-slate-400 font-normal">(auto dari nama)</span>
                        </label>
                        <input type="text" name="slug" id="slug"
                               value="{{ old('slug') }}"
                               placeholder="contoh: pt-maju-jaya"
                               class="w-full border p-2 rounded-xl text-sm @error('slug') border-red-400 @enderror">
                        @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email') }}"
                               placeholder="admin@perusahaan.com"
                               class="w-full border p-2 rounded-xl text-sm @error('email') border-red-400 @enderror">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Telepon</label>
                        <input type="text" name="phone"
                               value="{{ old('phone') }}"
                               placeholder="021-000000"
                               class="w-full border p-2 rounded-xl text-sm @error('phone') border-red-400 @enderror">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
                        <textarea name="address" rows="2"
                                  placeholder="Alamat lengkap perusahaan"
                                  class="w-full border p-2 rounded-xl text-sm @error('address') border-red-400 @enderror">{{ old('address') }}</textarea>
                        @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Logo</label>
                        <input type="file" name="logo" accept="image/jpg,image/jpeg,image/png"
                               class="w-full border p-2 rounded-xl text-sm @error('logo') border-red-400 @enderror">
                        <p class="text-xs text-slate-400 mt-1">Format JPG/PNG, maksimal 2MB</p>
                        @error('logo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>

            {{-- Langganan & Status --}}
            <div class="mb-6">
                <h3 class="text-sm font-bold text-slate-700 mb-4 pb-2 border-b">Langganan & Status</h3>
                <div class="grid grid-cols-3 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" class="w-full border p-2 rounded-xl text-sm @error('status') border-red-400 @enderror">
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Non-aktif</option>
                        </select>
                        @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Mulai Langganan</label>
                        <input type="date" name="subscription_start"
                               value="{{ old('subscription_start', date('Y-m-d')) }}"
                               class="w-full border p-2 rounded-xl text-sm @error('subscription_start') border-red-400 @enderror">
                        @error('subscription_start')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Akhir Langganan</label>
                        <input type="date" name="subscription_end"
                               value="{{ old('subscription_end', date('Y-m-d', strtotime('+1 year'))) }}"
                               class="w-full border p-2 rounded-xl text-sm @error('subscription_end') border-red-400 @enderror">
                        <p class="text-xs text-slate-400 mt-1">Kosongkan untuk unlimited</p>
                        @error('subscription_end')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>

            {{-- Tombol --}}
            <div class="pt-6 border-t border-slate-100 flex justify-end items-center gap-3">
                <a href="{{ route('admin.tenants.index') }}"
                   class="bg-gray-500 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-600 transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-8 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all">
                    Simpan
                </button>
            </div>

        </form>
    </div>

    @push('scripts')
    <script>
        // Auto-generate slug dari nama perusahaan
        document.getElementById('name').addEventListener('input', function () {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
            document.getElementById('slug').value = slug;
        });
    </script>
    @endpush
</x-app-layout>