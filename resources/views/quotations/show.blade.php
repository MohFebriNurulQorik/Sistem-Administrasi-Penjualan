<x-app-layout>
    <x-slot name="header">
        Quotation Detail
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">

        <!-- HEADER -->
        <div class="flex justify-between items-start mb-8">

            <div>
                <h2 class="text-2xl font-black text-slate-800">
                    {{ $quotation->quotation_number }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    Project: {{ $quotation->project ?? '-' }}
                </p>
            </div>


        </div>

        <!-- CUSTOMER INFO -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            <div class="bg-slate-50 p-5 rounded-xl">
                <p class="text-xs text-slate-500 uppercase font-bold">Customer</p>
                <p class="font-bold text-slate-800 mt-1">
                    {{ $quotation->customer->company_name }}
                </p>
                <p class="text-sm text-slate-600">
                    {{ $quotation->customer->attn }} ({{ $quotation->customer->job }})
                </p>
                <p class="text-sm text-slate-600">
                    {{ $quotation->customer->email }}
                </p>
                <p class="text-sm text-slate-600">
                    {{ $quotation->customer->phone }}
                </p>
                <p class="text-sm text-slate-600">
                    {{ $quotation->customer->address }}
                </p>
            </div>

            <div class="bg-slate-50 p-5 rounded-xl">
                <p class="text-xs text-slate-500 uppercase font-bold">Quotation Info</p>

                <div class="mt-2 space-y-1 text-sm">
                    
                <p class="text-sm text-slate-500">Valid Until :   <span class="font-bold text-slate-800">
                    {{ $quotation->valid_until ?? '-' }}
                </span></p>
              
                <p class="text-sm text-slate-500">Print Date :  <span class="font-bold text-slate-800">
                    {{ $quotation->print_date ?? '-' }}
                </span></p>
               
                    <p><span class="text-slate-500">Subtotal:</span> Rp {{ number_format($quotation->subtotal, 0) }}</p>
                    <p><span class="text-slate-500">VAT:</span> Rp {{ number_format($quotation->vat_amount, 0) }}</p>
                    <p class="font-bold text-slate-800">
                        Grand Total: Rp {{ number_format($quotation->grand_total, 0) }}
                    </p>
                </div>
            </div>

        </div>

        <!-- ITEMS TABLE -->
        <div class="border rounded-xl overflow-hidden mb-8">

            <table class="w-full text-sm">

                <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                    <tr>
                        <th class="p-3 text-left">Description</th>
                        <th class="p-3 text-center">Qty</th>
                        <th class="p-3 text-center">UOM</th>
                        <th class="p-3 text-right">Price</th>
                        <th class="p-3 text-center">Disc %</th>
                        <th class="p-3 text-right">Amount</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach ($quotation->items as $item)
                        <tr class="hover:bg-slate-50">

                            <td class="p-3">
                                <p class="font-semibold text-slate-800">
                                    {{ $item->description }}
                                </p>
                                <p class="text-xs text-slate-400">
                                    {{ $item->part_number }}
                                </p>
                            </td>

                            <td class="p-3 text-center">
                                {{ $item->qty }}
                            </td>

                            <td class="p-3 text-center">
                                {{ $item->uom }}
                            </td>

                            <td class="p-3 text-right">
                                {{ number_format($item->price, 0) }}
                            </td>

                            <td class="p-3 text-center">
                                {{ $item->discount_percent }}%
                            </td>

                            <td class="p-3 text-right font-bold text-slate-800">
                                {{ number_format($item->amount, 0) }}
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        <!-- REMARK -->
        <div class="bg-slate-50 p-5 rounded-xl mb-6">
            <p class="text-xs font-bold text-slate-500 uppercase mb-2">Remark</p>
            <div class="text-sm text-slate-700">
                {!! $quotation->remark ?? '-' !!}
            </div>
        </div>

        <!-- ACTION -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('quotations.pdf', $quotation->id) }}"
            target="_blank"
            class="px-5 py-2 bg-blue-600 text-white rounded-lg font-bold">
                Print
            </a>
            <a href="{{ route('quotations.edit', $quotation->id) }}"
               class="px-5 py-2 bg-yellow-500 text-white rounded-lg font-bold">
                Edit
            </a>

            <a href="{{ route('quotations.index') }}"
               class="px-5 py-2 bg-slate-200 text-slate-700 rounded-lg font-bold">
                Back
            </a>

        </div>

    </div>
</x-app-layout>