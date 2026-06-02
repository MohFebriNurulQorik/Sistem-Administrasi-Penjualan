<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="font-bold text-slate-800">Edit Position</span>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100">

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg">
                    <ul class="text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('positions.update', $position->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Position Name -->
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-slate-700 ml-1">Position Name</label>
                        <input type="text" name="position_name" 
                            value="{{ old('position_name', $position->position_name) }}" 
                            required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition-all outline-none text-slate-700"
                            placeholder="Contoh: Manager, Staff, etc.">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-10 pt-6 border-t border-slate-100 flex justify-end items-center gap-3">
                    <a href="{{ route('positions.index') }}"
                        class="bg-gray-500 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-600 transition-all">
                        Discard
                    </a>

                    <button type="submit"
                        class="bg-blue-600 text-white px-8 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
