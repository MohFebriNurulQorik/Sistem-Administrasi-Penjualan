<x-app-layout>
    <x-slot name="header">Tambah User</x-slot>

    <div class="bg-white p-6 rounded-2xl border">
    @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 text-red-600 rounded">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf

            <input type="text" name="name" placeholder="Nama"
                   class="w-full border p-3 rounded-xl">
            <input type="text" name="company_name" placeholder="Company Name"
                   class="w-full border p-3 rounded-xl">

            <input type="email" name="email" placeholder="Email"
                   class="w-full border p-3 rounded-xl">

            <input type="password" name="password" placeholder="Password"
                   class="w-full border p-3 rounded-xl">

            <select name="role" class="w-full border p-3 rounded-xl">
                <option value="admin">Admin</option>
                <option value="sales">Sales</option>
                <option value="finance">Finance</option>
            </select>

            <button class="bg-blue-600 text-white px-6 py-3 rounded-xl">
                Simpan
            </button>
        </form>

    </div>
</x-app-layout>