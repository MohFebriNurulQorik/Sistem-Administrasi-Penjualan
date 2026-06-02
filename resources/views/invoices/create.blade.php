<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                Create Invoice
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4">

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

            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf

                {{-- HEADER --}}
                <div class="p-8 border-b bg-slate-50/50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase mb-2 block">Customer</label>
                            <select name="customer_id" id="customer-select" class="w-full">
                                <option value="">Select Customer</option>
                                @foreach ($customers as $c)
                                    <option value="{{ $c->id }}" data-company="{{ $c->company_name }}">
                                        {{ $c->company_name }} - {{ $c->attn }} ({{ $c->job }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase mb-2 block">
                                Customer Invoice To
                            </label>
                            <select name="customer_invoice_id" id="customer-invoice-select" class="w-full">
                                <option value="">Select Contact</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase mb-2 block">SO Number</label>
                            <input type="text" name="so_number" class="w-full border rounded-lg">
                        </div>

                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase mb-2 block">Due Date</label>
                            <input type="date" name="due_date" class="w-full border rounded-lg">
                        </div>

                        <div>
                            <label class="text-xs font-black text-slate-500 uppercase mb-2 block">Print Date</label>
                            <input type="date" name="print_date" value="{{ now()->format('Y-m-d') }}"
                                class="w-full border rounded-lg">
                        </div>

                        {{-- TERMS --}}
                        <div class="md:col-span-3">
                            <input type="hidden" name="terms" id="terms">
                            <label class="block text-xs font-black text-slate-500 uppercase mb-2">
                                Remark / Terms
                            </label>
                            <div id="editor" class="bg-white rounded-lg border" style="height:120px;"></div>
                        </div>

                    </div>
                </div>

                {{-- ITEMS --}}
                <div class="p-8">

                    <div class="border rounded-xl overflow-hidden">
                        <table class="w-full text-left" id="items-table">
                            <thead>
                                <tr class="bg-blue-600 text-white text-xs">
                                    <th class="p-4 w-1/3">Item</th>
                                    <th class="p-4 text-center">Price</th>
                                    <th class="p-4 text-center w-24">Qty</th>
                                    <th class="p-4 text-center w-24">Uom</th>
                                    <th class="p-4 text-right">Amount</th>
                                    <th class="p-4 w-16"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <button type="button" onclick="addRow()"
                        class="mt-4 px-4 py-2 border rounded-lg bg-white font-bold">
                        + Add Item
                    </button>

                    {{-- SUMMARY --}}
                    <div class="mt-10 flex justify-end">
                        <div class="w-96 bg-slate-50 border rounded-2xl p-6 space-y-3">

                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span id="subtotal">0</span>
                                <input type="hidden" name="subtotal" id="subtotal_input">
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="flex gap-2">
                                    <span>VAT</span>
                                    <input type="number" id="vat_percent" name="vat" value="11"
                                        oninput="calcTotal()"
                                        class="w-14 p-1 text-center border-slate-200 rounded-md text-sm focus:ring-blue-500/20 focus:border-blue-500">
                                    <span>%</span>
                                </div>
                                <span id="vat_amount_display">0</span>
                                <input type="hidden" name="vat_amount" id="vat_amount_input">
                            </div>

                            <div class="flex justify-between font-bold">
                                <span>Total</span>
                                <span id="grand_total">0</span>
                                <input type="hidden" name="grand_total" id="grand_total_input">
                            </div>

                        </div>
                    </div>

                </div>

                
                {{-- FOOTER --}}
                <div class="bg-slate-50 px-8 py-6 flex justify-end gap-4 border-t border-slate-100">
                    <a href="{{ route('invoices.index') }}"
                        class="bg-gray-500 text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-gray-600 transition-all">
                        BACK
                    </a>
                    <button type="submit"
                        class="px-10 py-3 bg-blue-600 text-white font-black rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5 active:scale-95">
                        SAVE INVOICE
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
            let id = 0;

            $(document).ready(function() {

                $('#customer-select').select2({
                    width: '100%'
                });
                $('#customer-invoice-select').select2({
                    width: '100%'
                });

                let customers = @json($customers);

                $('#customer-select').on('change', function() {

                    let companyName = $(this).find(':selected').data('company');

                    let invoiceSelect = $('#customer-invoice-select');

                    // RESET TOTAL (IMPORTANT BIAR CLEAN)
                    invoiceSelect.val(null).trigger('change');
                    invoiceSelect.empty();

                    let filtered = customers.filter(c => c.company_name === companyName);
                    console.log(filtered);

                    if (filtered.length > 0) {

                        invoiceSelect.append(`<option value="">Select Contact</option>`);

                            filtered.forEach(c => {
                                invoiceSelect.append(`
                        <option value="${c.id}">
                            ${c.attn} (${c.job})
                        </option>
                    `);
                        });

                    } else {
                        invoiceSelect.append(`<option value="">No Data Found</option>`);
                    }

                    // WAJIB refresh select2
                    invoiceSelect.trigger('change.select2');
                });

                const quill = new Quill('#editor', {
                    theme: 'snow'
                });

                $('form').on('submit', function() {
                    $('#terms').val(quill.root.innerHTML);
                });

                addRow();
            });

            function calcRow(row) {
                let price = parseFloat(row.find('.price').val()) || 0;
                let qty = parseFloat(row.find('.qty').val()) || 0;
                let amount = price * qty;

                row.find('.amount').val(amount);
                row.find('.amount-display').text(amount.toLocaleString('id-ID'));

                calcTotal();
            }

            function calcTotal() {
                let subtotal = 0;

                $('.amount').each(function() {
                    subtotal += parseFloat($(this).val()) || 0;
                });

                let vat = parseFloat($('#vat_percent').val()) || 0;
                let vatAmount = subtotal * vat / 100;
                let total = subtotal + vatAmount;

                $('#subtotal').text(subtotal.toLocaleString('id-ID'));
                $('#subtotal_input').val(subtotal);

                $('#vat_amount_display').text(vatAmount.toLocaleString('id-ID'));
                $('#vat_amount_input').val(vatAmount);

                $('#grand_total').text(total.toLocaleString('id-ID'));
                $('#grand_total_input').val(total);
            }

            $(document).on('input', '.price, .qty, #vat_percent', function() {
                calcRow($(this).closest('tr'));
            });

            function addRow() {


                let row = `
            <tr>
                <td class="p-3">
                    <select name="items[item_id][]" class="item-select w-full">
                        <option value="">Choose Item...</option>
                        ${availableItems.map(i => `
                                    <option value="${i.id}" data-price="${i.price}" data-uom="${i.uom}">
                                        ${i.name}
                                    </option>
                                `).join('')}
                    </select>
                </td>

                <td class="p-3">
                    <input type="number" name="items[price][]" class="price w-full text-right border rounded">
                </td>

                <td class="p-3">
                    <input type="number" name="items[qty][]" value="1" class="qty w-full text-center border rounded">
                </td>

                <td class="p-3">
                    <input type="text" name="items[uom][]" class="uom w-full text-center border-none" readonly>
                </td>

                <td class="p-3 text-right">
                    <input type="hidden" name="items[amount][]" class="amount">
                    <span class="amount-display">0</span>
                </td>

                <td class="p-3 text-center">
                    <button type="button" onclick="this.closest('tr').remove();calcTotal()"
                        class="p-2 text-slate-300 hover:text-red-500">
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
        </script>
    @endpush

</x-app-layout>
