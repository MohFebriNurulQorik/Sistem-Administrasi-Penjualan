<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                Edit Invoice
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg">
                <ul class="text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- HEADER --}}
                <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        {{-- CUSTOMER --}}
                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider mb-2 block">
                                Customer
                            </label>
                            <select name="customer_id" id="customer-select" class="w-full">
                                @foreach ($customers as $c)
                                    <option value="{{ $c->id }}" data-company="{{ $c->company_name }}"
                                        {{ $invoice->customer_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->company_name }} - {{ $c->attn }} ({{ $c->job }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider mb-2 block">
                                Customer Invoice To
                            </label>

                            <select name="customer_invoice_id" id="customer-invoice-select" class="w-full">
                                {{-- nanti diisi JS --}}
                            </select>

                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


                        {{-- SO --}}
                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider mb-2 block">
                                SO Number
                            </label>
                            <input type="text" name="so_number" value="{{ $invoice->so_number }}"
                                class="w-full border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 py-2.5">
                        </div>

                        {{-- DUE --}}
                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider mb-2 block">
                                Due Date
                            </label>
                            <input type="date" name="due_date" value="{{ $invoice->due_date }}"
                                class="w-full border-slate-200 rounded-lg py-2.5">
                        </div>

                        {{-- PRINT --}}
                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider mb-2 block">
                                Print Date
                            </label>
                            <input type="date" name="print_date" value="{{ $invoice->print_date }}"
                                class="w-full border-slate-200 rounded-lg py-2.5">
                        </div>

                        {{-- TERMS (SAMA PERSIS QUOTATION STYLE) --}}
                        <div class="md:col-span-3">
                            <input type="hidden" name="terms" id="terms">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">
                                Remark / Terms
                            </label>
                            <div id="editor" class="bg-white rounded-lg border border-slate-200"
                                style="height:120px;">
                                {!! $invoice->terms !!}
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ITEMS --}}
                <div class="p-8">

                    <div class="border border-slate-200 rounded-xl overflow-hidden">

                        <table class="w-full text-left" id="items-table">

                            <thead>
                                <tr class="bg-blue-600 text-white text-xs">
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest w-1/3">Item
                                        Description</th>
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest text-center">Unit
                                        Price</th>
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest text-center w-24">
                                        Qty</th>
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest text-center w-24">
                                        Uom</th>
                                    <th class="p-4 text-[10px] font-black uppercase tracking-widest text-right">Amount
                                    </th>
                                    <th class="p-4 w-16"></th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                @foreach ($invoice->items as $i => $item)
                                    <tr>

                                        <td class="p-3">
                                            <select name="items[item_id][{{ $i }}]"
                                                class="item-select w-full">
                                                @foreach ($items as $it)
                                                    <option value="{{ $it->id }}"
                                                        data-price="{{ $it->price }}"
                                                        data-uom="{{ $it->uom }}"
                                                        {{ $item->item_code == $it->code ? 'selected' : '' }}>
                                                        {{ $it->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td class="p-3">
                                            <input type="number" name="items[price][{{ $i }}]"
                                                value="{{ $item->price }}"
                                                class="price w-full border-slate-200 rounded-lg text-right py-2">
                                        </td>

                                        <td class="p-3">
                                            <input type="number" name="items[qty][{{ $i }}]"
                                                value="{{ $item->qty }}"
                                                class="qty w-full border-slate-200 rounded-lg text-center py-2">
                                        </td>

                                        <td class="p-3">
                                            <input type="text" name="items[uom][{{ $i }}]"
                                                value="{{ $item->uom }}"
                                                class="uom w-full text-center bg-transparent border-none text-center"
                                                readonly>
                                        </td>

                                        <td class="p-3 text-right">
                                            <input type="hidden" name="items[amount][{{ $i }}]"
                                                class="amount" value="{{ $item->amount }}">

                                            <span class="amount-display">
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

                    <button type="button" onclick="addRow()"
                        class="mt-4 px-4 py-2 bg-white border border-slate-200 rounded-lg font-bold">
                        + Add Item
                    </button>

                    {{-- SUMMARY (SAMA QUOTATION STYLE) --}}
                    <div class="mt-10 flex justify-end">

                        <div class="w-96 bg-slate-50 border border-slate-200 rounded-2xl p-6 space-y-3">

                            <div class="flex justify-between">
                                <span class="text-slate-600 font-semibold">Subtotal</span>
                                <span id="subtotal" class="font-bold">0</span>
                                <input type="hidden" name="subtotal" id="subtotal_input" value="0">
                            </div>

                            <div class="flex justify-between items-center text-slate-600">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-semibold">VAT / PPN</span>
                                    <input type="number" id="vat_percent" name="vat"
                                        value="{{ $invoice->vat }}" oninput="calcTotal()"
                                        class="w-14 p-1 text-center border-slate-200 rounded-md text-sm focus:ring-blue-500/20 focus:border-blue-500">
                                    <span class="text-sm font-medium">%</span>
                                </div>
                                <div class="text-right">
                                    <span id="vat_amount_display" class="font-bold text-slate-800">0</span>
                                    <input type="hidden" name="vat_amount" id="vat_amount_input" value="0">
                                </div>
                            </div>

                            <div class="flex justify-between text-lg font-black">
                                <input type="hidden" name="grand_total" id="grand_total_input" value="0">
                                <span>Total</span>
                                <span id="grand_total">0</span>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="flex justify-end gap-2 p-8 border-t bg-slate-50">
                    <a href="{{ route('invoices.index') }}"
                        class="px-5 py-3 bg-gray-500 text-white rounded-lg font-bold">
                        DISCARD
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700">
                        UPDATE INVOICE
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- STYLE (SAMA 100% QUOTATION SELECT2) --}}
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

    {{-- SCRIPT --}}
    @push('scripts')
        <script>
            const availableItems = @json($items);
            let id = {{ count($invoice->items) }};

            $(document).ready(function() {
                $('#customer-select').select2({
                    width: '100%'
                });
                $('#customer-invoice-select').select2({
                    width: '100%'
                });

                let customers = @json($customers);

                function loadInvoiceTo(selectedCustomerId) {

                    let selected = customers.find(c => c.id == selectedCustomerId);

                    let companyName = selected ? selected.company_name : null;

                    let invoiceSelect = $('#customer-invoice-select');

                    invoiceSelect.empty();

                    let filtered = customers.filter(c => c.company_name === companyName);

                    if (filtered.length > 0) {

                        filtered.forEach(c => {
                            invoiceSelect.append(`
                    <option value="${c.id}"
                        ${c.id == "{{ $invoice->customer_invoice_id }}" ? 'selected' : ''}>
                        ${c.attn} (${c.job})
                    </option>
                `);
                        });

                    } else {
                        invoiceSelect.append(`<option value="">No Data</option>`);
                    }

                    invoiceSelect.trigger('change.select2');
                }

                // ON CHANGE CUSTOMER
                $('#customer-select').on('change', function() {
                    loadInvoiceTo($(this).val());
                });

                // AUTO LOAD SAAT PAGE EDIT
                loadInvoiceTo($('#customer-select').val());




                $('.item-select').select2({
                    width: '100%'
                });

                const quill = new Quill('#editor', {
                    theme: 'snow'
                });
                quill.root.innerHTML = `{!! $invoice->terms !!}`;

                $('form').on('submit', function() {
                    $('#terms').val(quill.root.innerHTML);
                });

                // 🔥 INIT EXISTING ROW SELECT EVENT
                $('.item-select').each(function() {
                    initItemSelect($(this));
                });

                calcTotal();
            });

            // ======================
            // INIT ITEM SELECT
            // ======================
            function initItemSelect($select) {
                $select.on('select2:select', function(e) {

                    let el = e.params.data.element;
                    let price = el.dataset.price || 0;
                    let uom = el.dataset.uom || '-';

                    let row = $(this).closest('tr');

                    row.find('.price').val(price);
                    row.find('.uom').val(uom);

                    calcRow(row);
                });
            }

            // ======================
            // ROW CALC
            // ======================
            function calcRow(row) {
                let price = parseFloat(row.find('.price').val()) || 0;
                let qty = parseFloat(row.find('.qty').val()) || 0;

                let amount = price * qty;

                row.find('.amount').val(amount);
                row.find('.amount-display').text(amount.toLocaleString('id-ID'));

                calcTotal();
            }

            // ======================
            // TOTAL
            // ======================
            function calcTotal() {
                let subtotal = 0;

                $('.amount').each(function() {
                    subtotal += parseFloat($(this).val()) || 0;
                });

                let vat = parseFloat($('#vat_percent').val()) || 0;
                let total = subtotal + (subtotal * vat / 100);

                $('#subtotal').text(subtotal.toLocaleString('id-ID'));
                let vatAmount = subtotal * vat / 100;
                $('#vat_amount_display').text(vatAmount.toLocaleString('id-ID'));
                $('#vat_amount_input').val(vatAmount);
                $('#subtotal').text(subtotal.toLocaleString('id-ID'));
                $('#subtotal_input').val(subtotal);
                $('#grand_total').text(total.toLocaleString('id-ID'));
                $('#grand_total_input').val(total);
            }

            // ======================
            // INPUT LISTENER
            // ======================
            $(document).on('input', '.price, .qty', function() {
                calcRow($(this).closest('tr'));
            });

            // ======================
            // ADD ROW (FIXED)
            // ======================
            function addRow() {
                id++;

                let row = `
            <tr>

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
                    <input type="number" name="items[price][${id}]" class="price w-full border-slate-200 rounded-lg text-right py-2">
                </td>

                <td class="p-3">
                    <input type="number" name="items[qty][${id}]" value="1" class="qty w-full border-slate-200 rounded-lg text-center py-2">
                </td>

                <td class="p-3">
                    <input type="text" name="items[uom][${id}]" class="uom w-full text-center bg-transparent border-none" readonly>
                </td>

                <td class="p-3 text-right">
                    <input type="hidden" name="items[amount][${id}]" class="amount">
                    <span class="amount-display">0</span>
                </td>

                 <td class="p-3 text-center">
                    <button type="button" onclick="this.closest('tr').remove();calcTotal()"
                            class="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </td>

            </tr>`;

                const $row = $(row);
                $('#items-table tbody').append($row);

                const $select = $row.find('.item-select');

                $select.select2({
                    width: '100%'
                });

                initItemSelect($select);
            }
        </script>
    @endpush

</x-app-layout>
