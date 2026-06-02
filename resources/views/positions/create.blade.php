<x-app-layout>
    <x-slot name="header">
        Create Position
    </x-slot>

    <div class="max-w-xl mx-auto">
        <div class="bg-white p-6 rounded-2xl shadow-sm border">

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 text-red-600 rounded">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('positions.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">
                        Position Name
                    </label>
                    <input type="text" name="position_name"
                        value="{{ old('position_name') }}"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-100"
                        placeholder="Contoh: Manager / Staff IT"
                        required>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('positions.index') }}"
                        class="px-4 py-2 bg-slate-200 rounded-lg text-sm font-semibold">
                        Back
                    </a>

                    <button type="submit"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>