<x-app-layout>
    <x-slot name="header">Profile Settings</x-slot>

    <div class="space-y-6">
        <!-- Update Informasi Profil -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-100">
            <div class="max-w-xl">
             
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-100">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Hapus Akun -->
        {{-- <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-red-100 bg-red-50/30">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div> --}}
    </div>
</x-app-layout>
