<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="font-bold text-slate-800">Create Project</span>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
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
            <form action="{{ route('projects.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Project Code -->
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-slate-700 ml-1">Project Code</label>
                        <div class="relative">
                            <input type="text" name="code" required
                                class="w-full pl-4 pr-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition-all outline-none placeholder:text-slate-400 uppercase font-mono"
                                placeholder="CONTOH: PRJ-001">
                        </div>
                    </div>

                    <!-- Project Name -->
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-slate-700 ml-1">Project Name</label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-50 focus:border-blue-500 transition-all outline-none placeholder:text-slate-400"
                            placeholder="Masukkan nama lengkap proyek">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-10 pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <a href="{{ route('projects.index') }}"
                        class="bg-gray-500 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-600 transition-all">
                        Back
                    </a>
                    <button type="submit"
                        class="bg-blue-600 text-white px-8 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all flex items-center gap-2">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
