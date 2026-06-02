<x-app-layout>
    <x-slot name="header">Edit Customer</x-slot>

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
        
        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label>Company Name</label>
                    <input type="text" name="company_name" value="{{ $customer->company_name }}"
                        class="w-full border p-2 rounded">
                </div>

                <div>
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $customer->email }}"
                        class="w-full border p-2 rounded">
                </div>

                <div>
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ $customer->phone }}"
                        class="w-full border p-2 rounded">
                </div>

                <div>
                    <label>Name</label>
                    <input type="text" name="attn" value="{{ $customer->attn }}"
                        class="w-full border p-2 rounded">
                </div>
                <div>
                    <label>Position</label>
                    <select name="job" id="job" class="w-full border p-2 rounded">
                        @foreach ($positions as $position)
                            <option value="{{ $position->position_name }}"
                                {{ $customer->job == $position->position_name ? 'selected' : '' }}>
                                {{ $position->position_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-2">
                    <label>Address</label>
                    <textarea name="address" class="w-full border p-2 rounded">{{ $customer->address }}</textarea>
                </div>

            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end items-center gap-3">
                <!-- Tombol Discard / Batal -->
                <a href="{{ route('customers.index') }}"
                    class="bg-gray-500 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-600 transition-all">
                        Discard
                    </a>

                <!-- Tombol Simpan -->
                <button type="submit"
                    class="bg-blue-600 text-white px-8 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all">
                    Update
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
            $(document).ready(function() {
                $('#job').select2({
                    placeholder: 'Pilih Position',
                    width: '100%'
                });
            });
        </script>
    @endpush
</x-app-layout>
