<x-app-layout>
    <x-slot name="header">Tambah Item</x-slot>

    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg">
                <ul class="text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('items.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                <input name="code" placeholder="Code" class="border p-2 rounded" required>
                <input name="name" placeholder="Name" class="border p-2 rounded" required>

                <input name="uom" placeholder="UOM" class="border p-2 rounded">

                <input type="number" name="price" placeholder="Price" class="border p-2 rounded" required>

                <select name="type" class="border p-2 rounded" required>
                    <option value="">-- Type --</option>
                    <option>Hardware</option>
                    <option>Software</option>
                    <option>Service</option>
                    <option>Other</option>
                </select>

            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end items-center gap-3">
                <!-- Tombol Discard / Batal -->
                <a href="{{ route('items.index') }}"
                    class="bg-gray-500 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-600 transition-all">
                    Back
                </a>

                <!-- Tombol Simpan -->
                <button type="submit"
                    class="bg-blue-600 text-white px-8 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
