<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-800">Create Delivery Order</h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4">

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

            <form action="{{ route('delivery-orders.store') }}" method="POST" id="do-form">
                @csrf

                {{-- HEADER --}}
                <div class="p-8 border-b bg-slate-50/50 grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div>
                        <label class="text-xs font-black text-slate-500 uppercase mb-2 block">Customer Shipp</label>
                        <select name="customer_id" id="customer-select" class="w-full">
                            <option value="">Select Customer</option>
                            @foreach ($customers as $c)
                                <option value="{{ $c->id }}" data-attn="{{ $c->attn }}">
                                    {{ $c->company_name }} - {{ $c->attn }} ({{ $c->job }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-black text-slate-500 uppercase mb-2 block">Attn Shipp</label>
                        <input type="text" name="attn" id="attn-input" class="w-full border rounded-lg">
                    </div>
                    <div>
                        <label class="text-xs font-black text-slate-500 uppercase mb-2 block">Project</label>
                        <select name="project" id="project-select" class="w-full">
                            <option value="">Select Project</option>
                            @foreach ($projects as $p)
                                <option value="{{ $p->name }}">
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-black text-slate-500 uppercase mb-2 block">Invoice (Optional)</label>
                        <select name="invoice_id" class="w-full" id="invoice-select">
                            <option value="">Select Invoice</option>
                            @foreach ($invoices as $inv)
                                <option value="{{ $inv->id }}">
                                    {{ $inv->invoice_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>



                    <div>
                        <label class="text-xs font-black text-slate-500 uppercase mb-2 block">Delivery Date</label>
                        <input type="date" name="delivery_date" class="w-full border rounded-lg">
                    </div>



                    <div>
                        <label class="text-xs font-black text-slate-500 uppercase tracking-wider mb-2 block">
                            Print Date
                        </label>
                        <input type="date" name="print_date" class="w-full border-slate-200 rounded-lg py-2.5">
                    </div>

                </div>

                {{-- ITEMS --}}
                <div class="p-8">

                    <div class="border rounded-xl overflow-hidden">
                        <table class="w-full text-left border-collapse" id="items-table">
                            <thead>
                                <tr class="bg-blue-600 text-white">
                                    <th class="p-4 text-[10px] font-black uppercase">Description</th>
                                    <th class="p-4 text-[10px] font-black uppercase w-1/4">Part Number</th>
                                    <th class="p-4 text-[10px] font-black uppercase text-center w-24">Qty</th>
                                    <th class="p-4 text-[10px] font-black uppercase">Serial Number</th>
                                    <th class="p-4 w-16"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100"></tbody>
                        </table>
                    </div>

                    <button type="button" onclick="addRow()"
                        class="mt-4 px-4 py-2 border rounded-lg bg-white font-bold">
                        + Add Item
                    </button>

                </div>

                {{-- FOOTER --}}
                 <div class="bg-slate-50 px-8 py-6 flex justify-end gap-4 border-t border-slate-100">
                    <a href="{{ route('delivery-orders.index') }}"
                        class="bg-gray-500 text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-gray-600 transition-all">
                        BACK
                    </a>
                    <button type="submit"
                        class="px-10 py-3 bg-blue-600 text-white font-black rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 active:scale-95">
                        SAVE DELIVERY ORDER
                    </button>
                </div>

            </form>

        </div>
    </div>

    @push('styles')
        <style>
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
            const availableItems = @json($items);

            document.addEventListener("DOMContentLoaded", function() {

                $('#customer-select').select2({
                    width: '100%'
                });

                $('#customer-select').on('change', function() {
                    let attn = $(this).find(':selected').data('attn') || '';
                    $('#attn-input').val(attn);
                });

                $('#project-select').select2({
                    width: '100%'
                });

                $('#invoice-select').select2({
                    width: '100%'
                });


                addRow();
            });

            function addRow() {

                let rowHtml = `
    <tr>

        <td class="p-3">
            <select name="items[description][]" class="item-select w-full">
                <option value="">Choose Item...</option>
                ${availableItems.map(i => `
                            <option value="${i.name}" data-code="${i.code}">
                                ${i.name}
                            </option>
                        `).join('')}
            </select>
        </td>

        <td class="p-3">
            <input type="text" name="items[part_number][]" class="part-number w-full border rounded">
        </td>

        <td class="p-3">
            <input type="number" name="items[qty][]" class="w-full text-center border rounded" value="1">
        </td>

        <td class="p-3">
            <input type="text" name="items[serial_number][]" class="w-full border rounded">
        </td>

        <td class="p-3 text-center">
            <button type="button" onclick="removeRow(this)" class="p-2 text-slate-300 hover:text-red-500">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </td>

    </tr>`;

                const $row = $(rowHtml);

                $('#items-table tbody').append($row);

                const $select = $row.find('.item-select');

                $select.select2({
                    width: '100%'
                });

                // 🔥 AUTO FILL PART NUMBER
                $select.on('select2:select', function(e) {

                    let selectedOption = e.params.data.element;
                    let code = selectedOption.dataset.code || '';

                    let row = $(this).closest('tr');

                    row.find('.part-number').val(code);
                });
            }

            function removeRow(btn) {
                $(btn).closest('tr').remove();
            }
        </script>
    @endpush

</x-app-layout>
