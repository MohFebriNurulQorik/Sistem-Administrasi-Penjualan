<x-guest-layout>
    <div class="p-4">
        <!-- HEADER LOGIN -->
        <div class="mb-10 text-center">
            <div class="inline-flex items-center justify-center p-3 bg-amber-500 rounded-2xl mb-4">
                <img src="{{ asset('images/logo-mizutech.png') }}" alt="MizuTech" class="h-10 w-auto">
            </div>
            <h2 class="text-2xl font-extrabold text-white tracking-tight">Masuk ke Sistem</h2>
            <p class="text-black text-sm mt-1">Silakan masukkan akun administrasi Anda</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Pilih Perusahaan -->
            <div>
                <x-input-label for="tenant_id" value="Perusahaan" class="text-black font-semibold mb-1" />
                <select id="tenant_id" name="tenant_id"
                    class="block mt-1 w-full bg-slate-900/50 border-gray-700 text-black focus:border-amber-500 focus:ring-amber-500 rounded-xl transition text-sm py-2.5 px-3
                           @error('tenant_id') border-red-500 @enderror">
                    <option value="">-- Pilih Perusahaan --</option>
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                            {{ $tenant->name }}
                        </option>
                    @endforeach
                </select>
                @error('tenant_id')
                    <p class="mt-2 text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-black font-semibold mb-1" />
                <x-text-input id="email"
                    class="block mt-1 w-full bg-slate-900/50 border-gray-700 text-white focus:border-amber-500 focus:ring-amber-500 rounded-xl transition"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                    placeholder="nama@perusahaan.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <x-input-label for="password" :value="__('Password')" class="text-black font-semibold" />
                    @if (Route::has('password.request'))
                        <a class="text-xs text-amber-500 hover:text-amber-400 transition font-bold" href="{{ route('password.request') }}">
                            {{ __('Lupa Password?') }}
                        </a>
                    @endif
                </div>

                <x-text-input id="password"
                    class="block mt-1 w-full bg-slate-900/50 border-gray-700 text-black focus:border-amber-500 focus:ring-amber-500 rounded-xl transition"
                    type="password"
                    name="password"
                    required autocomplete="current-password"
                    placeholder="••••••••" />

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
            </div>

            <!-- Action Button -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full py-3.5 bg-blue-800 p-2 hover:bg-orange-600 text-white font-black rounded-xl shadow-lg shadow-orange-950/20 transition-all active:scale-95 uppercase tracking-widest text-sm"
                    style="background-color: #f97316;">
                    {{ __('Masuk Sekarang') }}
                </button>
            </div>

            <!-- Register Link -->
            @if (Route::has('register'))
                <p class="text-center text-sm text-gray-500">
                    Belum punya akses?
                    <a href="{{ route('register') }}" class="text-amber-500 font-bold hover:underline">Hubungi IT Solution</a>
                </p>
            @endif

        </form>
    </div>
</x-guest-layout>