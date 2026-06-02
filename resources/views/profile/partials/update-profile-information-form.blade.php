<section>
    <header>
        <h2 class="text-lg font-bold text-slate-800">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ __("Perbarui informasi profil akun dan alamat email Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('patch')

        <!-- Input Nama -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-semibold" />
            <x-text-input id="name" name="name" type="text" 
                class="mt-1 block w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm" 
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Input Email -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="text-slate-700 font-semibold" />
            <x-text-input id="email" name="email" type="email" 
                class="mt-1 block w-full border-slate-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm" 
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-3 bg-yellow-50 rounded-xl border border-yellow-100">
                    <p class="text-sm text-yellow-700">
                        {{ __('Email Anda belum terverifikasi.') }}

                        <button form="send-verification" class="underline font-bold hover:text-yellow-900 focus:outline-none transition-colors">
                            {{ __('Klik di sini untuk kirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-xs text-green-600">
                            {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                {{ __('Simpan Profil') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium"
                >
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        {{ __('Berhasil diperbarui.') }}
                    </span>
                </p>
            @endif
        </div>
    </form>
</section>
