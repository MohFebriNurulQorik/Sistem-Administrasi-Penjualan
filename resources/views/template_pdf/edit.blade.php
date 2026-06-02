<x-app-layout>
    <x-slot name="header">Pilih Template Aktif</x-slot>

    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        
        <form action="{{ route('template.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-4">
                <label class="text-sm font-bold text-slate-600">Select System Default Template:</label>
                
                <!-- Dropdown Pilih Template -->
                <select name="id" id="pdf-select" class="border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                    @foreach($listTemplates as $item)
                        <option value="{{ $item->id }}" {{ $item->status == 'active' ? 'selected' : '' }}>
                            {{ $item->code }} - {{ $item->company_name }} {{ $item->status == 'active' ? '(Currently Used)' : '' }}
                        </option>
                    @endforeach
                </select>

                <p class="text-xs text-slate-500 italic">
                    *The selected template will be automatically used for all PDF prints.
                </p>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" 
                    class="bg-blue-600 text-white px-10 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all">
                    Activate Templates
                </button>
            </div>
        </form>

    </div>
     @push('styles')
        <style>
            /* Modern Select2 Styling */
            .select2-container--default .select2-selection--single {
                background-color: #fff !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 0.5rem !important;
                height: 44px !important;
                display: flex !important;
                align-items: center !important;
                transition: all 0.2s;
            }

            .select2-container--default .select2-selection--single:focus {
                border-color: #3b82f6 !important;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 42px !important;
            }
        </style>
    @endpush
    @push('scripts')
        <script>
          $('#pdf-select').select2({
                    width: '100%'
            });
        </script>
    @endpush
</x-app-layout>
