<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">Edit Quotation</h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 font-medium rounded-r-lg shadow-sm">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>Please correct the following errors:</span>
                </div>
                <ul class="list-disc list-inside text-sm opacity-80">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <form action="{{ route('quotations.update', $quotation->id) }}" method="POST" class="p-0">
                @csrf
                @method('PUT')

                <!-- HEADER -->
                <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                    <div class="mb-8">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">
                            Quotation Number
                        </label>
                        <input type="text" name="quotation_number" value="{{ $quotation->quotation_number }}"
                            class="w-full border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all py-2.5">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <!-- CUSTOMER -->
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">
                                Customer / Company
                            </label>
                            <select name="customer_id" id="customer-select" class="w-full">
                                <option value="">Search Company...</option>
                                @foreach ($customers as $c)
                                    <option value="{{ $c->id }}"
                                        {{ $quotation->customer_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->company_name }} - {{ $c->attn }} ({{ $c->job }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- PROJECT -->
                         <div>
                            <label class="text-xs font-black text-slate-500 uppercase mb-2 block">Project</label>
                            <select name="project" id="project-select" class="w-full">
                                @foreach ($projects as $p)
                                    <option value="{{ $p->name }}" {{ $quotation->project == $p->name ? 'selected' : '' }}>
                                        {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- VALID UNTIL -->
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">
                                Valid Until
                            </label>
                            <input type="date" name="valid_until" value="{{ $quotation->valid_until }}"
                                class="w-full border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all py-2.5">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">
                                Print Date
                            </label>
                            <input type="date" name="print_date" value="{{ $quotation->print_date }}"
                                class="w-full border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all py-2.5">
                        </div>
                    </div>
                    <div class="mt-8">
                        <input type="hidden" name="remark" id="remark-input">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">
                            Remark / Terms
                        </label>
                        <div id="editor" class="bg-white rounded-lg border-slate-200" style="height:120px;">
                            {!! $quotation->remark !!}
                        </div>
                    </div>
                </div>

                <!-- ITEMS -->
                <div class="p-8">
                    <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm">

                        <table class="w-full text-left border-collapse" id="items-table">
                            <thead>
                                <tr class="bg-blue-600 text-white">
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest w-1/3">Item
                                        Description</th>
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest text-right">Unit
                                        Price</th>
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest text-center w-24">
                                        Qty</th>
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest text-center w-24">
                                        Uom</th>
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest text-center w-24">
                                        Disc%</th>
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest text-right">Amount
                                    </th>
                                    <th class="p-4 w-16"></th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @foreach ($quotation->items as $i => $item)
                                    <tr>

                                        <td class="p-3">
                                            <select name="items[item_id][{{ $i }}]"
                                                class="item-select w-full">
                                                @foreach ($items as $it)
                                                    <option value="{{ $it->id }}"
                                                        data-price="{{ $it->price }}"
                                                        data-uom="{{ $it->uom }}"
                                                        {{ $item->part_number == $it->code ? 'selected' : '' }}>
                                                        {{ $it->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td class="p-3">
                                            <input type="number" name="items[price][{{ $i }}]"
                                                value="{{ $item->price }}"
                                                class="price w-full border-slate-200 rounded-lg text-right py-1.5">
                                        </td>

                                        <td class="p-3">
                                            <input type="number" name="items[qty][{{ $i }}]"
                                                value="{{ $item->qty }}"
                                                class="qty w-full border-slate-200 rounded-lg text-center py-1.5">
                                        </td>

                                        <td class="p-3">
                                            <input type="text" name="items[uom][{{ $i }}]"
                                                value="{{ $item->uom }}"
                                                class="uom w-full text-center bg-transparent border-none" readonly>
                                        </td>

                                        <td class="p-3">
                                            <input type="number" name="items[discount][{{ $i }}]"
                                                value="{{ $item->discount_percent }}"
                                                class="discount w-full border-slate-200 rounded-lg text-center py-1.5">
                                        </td>

                                        <td class="p-3 text-right">
                                            <input type="hidden" name="items[amount][{{ $i }}]"
                                                class="amount" value="{{ $item->amount }}">
                                            <span class="amount-display font-bold">
                                                {{ number_format($item->amount, 0) }}
                                            </span>
                                        </td>

                                        <td class="p-3 text-center">
                                            <button type="button" onclick="this.closest('tr').remove();calcTotal()"
                                                class="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <button type="button" onclick="addRow()"
                            class="px-4 py-2 bg-white border rounded-lg font-bold">
                            + Add Row
                        </button>
                    </div>

                    <!-- SUMMARY -->
                    <div class="mt-10 flex flex-col md:flex-row justify-between items-start gap-8">
                        <div class="w-full md:w-1/2 text-slate-500 text-sm italic">
                            * Please ensure all items and discounts are correct before saving.
                        </div>

                        <div
                            class="w-full md:w-96 space-y-3 bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow-inner">
                            <div class="flex justify-between items-center text-slate-600">
                                <input type="hidden" name="subtotal" id="subtotal_input" value="0">
                                <span class="text-sm font-semibold">Subtotal</span>
                                <span id="subtotal" class="font-bold text-slate-800 text-lg">0</span>
                            </div>

                            <div class="flex justify-between items-center text-slate-600">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-semibold">VAT / PPN</span>
                                    <input type="number" id="vat_percent" name="vat"
                                        value="{{ $quotation->vat }}" oninput="calcTotal()"
                                        class="w-14 p-1 text-center border-slate-200 rounded-md text-sm focus:ring-blue-500/20 focus:border-blue-500">
                                    <span class="text-sm font-medium">%</span>
                                </div>
                                <div class="text-right">
                                    <span id="vat_amount_display" class="font-bold text-slate-800">0</span>
                                    <input type="hidden" name="vat_amount" id="vat_amount_input" value="0">
                                </div>
                            </div>

                            <div class="pt-4 border-t border-slate-200 flex justify-between items-center">
                                <input type="hidden" name="grand_total" id="grand_total_input" value="0">
                                <span class="font-black text-slate-900 uppercase tracking-tighter">Grand Total</span>
                                <div class="text-right">
                                    <span
                                        class="text-[10px] block font-bold text-blue-500 uppercase leading-none">Rupiah
                                        (IDR)</span>
                                    <span class="text-3xl font-black text-blue-600 leading-tight">
                                        <span id="grand_total">0</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-2 p-8 border-t bg-slate-50">
                    <a href="{{ route('quotations.index') }}"
                        class="bg-gray-500 text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-gray-600 transition-all">
                        DISCARD
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700">
                        UPDATE QUOTATION
                    </button>
                </div>

            </form>
        </div>
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
            const availableItems = @json($items);

            $(document).ready(function() {
                $('#project-select').select2({
                    width: '100%'
                });
                $('#customer-select').select2({
                    width: '100%'
                });
                $('.item-select').select2({
                    width: '100%'
                });

                const quill = new Quill('#editor', {
                    theme: 'snow'
                });

                quill.root.innerHTML = `{!! $quotation->remark !!}`;

                $('form').on('submit', function() {
                    $('#remark-input').val(quill.root.innerHTML);
                });


                calcTotal();
            });

            let id = @json($i);

            function addRow() {
                id++;
                let row = `
            <tr class="group">
                <td class="p-3">
                    <select name="items[item_id][${id}]" class="item-select w-full">
                        <option value="">Choose Item...</option>
                        ${availableItems.map(i => `
                                                    <option value="${i.id}" data-price="${i.price}" data-uom="${i.uom}">
                                                        ${i.name}
                                                    </option>
                                                `).join('')}
                    </select>
                </td>

                <td class="p-3">
                    <input type="number" name="items[price][${id}]" class="price w-full border-slate-200 rounded-lg text-right py-1.5">
                </td>

                <td class="p-3 text-center">
                    <input type="number" name="items[qty][${id}]" class="qty w-full border-slate-200 rounded-lg text-center py-1.5" value="1">
                </td>

                <td class="p-3 text-center">
                    <input type="text" name="items[uom][${id}]" class="uom w-full text-center bg-transparent border-none" readonly>
                </td>

                <td class="p-3 text-center">
                    <input type="number" name="items[discount][${id}]" class="discount w-full border-slate-200 rounded-lg text-center py-1.5" value="0">
                </td>

                <td class="p-3 text-right">
                    <input type="hidden" name="items[${id}][amount]" class="amount">
                    <span class="amount-display font-bold text-slate-700">0</span>
                </td>

                <td class="p-3 text-center">
                    <button type="button" onclick="$(this).closest('tr').remove();calcTotal()" 
                        class="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </td>
            </tr>`;

                const $row = $(row);
                $('#items-table tbody').append($row);

                // 🔥 IMPORTANT: init select2 + event AFTER append
                const $select = $row.find('.item-select');

                $select.select2({
                    width: '100%'
                });

                // 🔥 FIX PRICE & UOM AUTO FILL
                $select.on('select2:select', function(e) {
                    let data = e.params.data.element.dataset;

                    let price = data.price || 0;
                    let uom = data.uom || '-';

                    let row = $(this).closest('tr');

                    row.find('.price').val(price);
                    row.find('.uom').val(uom);

                    calcRow(row);
                });
            }

            $(document).on('input', '.price, .qty, .discount', function() {
                calcRow($(this).closest('tr'));
            });

            function calcRow(row) {
                let price = parseFloat(row.find('.price').val()) || 0;
                let qty = parseFloat(row.find('.qty').val()) || 0;
                let disc = parseFloat(row.find('.discount').val()) || 0;

                let total = price * qty;
                let final = total - (total * disc / 100);

                row.find('.amount').val(final);
                row.find('.amount-display').text(final.toLocaleString('id-ID'));

                calcTotal();
            }

            function calcTotal() {
                let subtotal = 0;

                $('.amount').each(function() {
                    subtotal += parseFloat($(this).val()) || 0;
                });

                let vat = parseFloat($('#vat_percent').val()) || 0;
                let vatAmount = subtotal * vat / 100;
                let grand = subtotal + vatAmount;

                $('#subtotal').text(subtotal.toLocaleString('id-ID'));
                $('#subtotal_input').val(subtotal);

                $('#vat_amount_display').text(vatAmount.toLocaleString('id-ID'));
                $('#vat_amount_input').val(vatAmount);

                $('#grand_total').text(grand.toLocaleString('id-ID'));
                $('#grand_total_input').val(grand);
            }
        </script>
    @endpush

</x-app-layout>
