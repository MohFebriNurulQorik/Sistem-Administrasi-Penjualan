<x-app-layout>
    <x-slot name="header">
        Delivery Order Detail
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">

        <!-- HEADER -->
        <div class="flex justify-between items-start mb-8">

            <div>
                <h2 class="text-2xl font-black text-slate-800">
                    {{ $do->do_number }}
                </h2>

                <p class="text-slate-500 text-sm mt-1">
                    Print : {{ $do->print_date ?? '-' }} |
                    Project: {{ $do->project ?? '-' }}
                </p>
            </div>

            <div class="text-right">
                <p class="text-sm text-slate-500">Delivery Date</p>
                <p class="font-bold text-slate-800">
                    {{ $do->delivery_date ?? '-' }}
                </p>
            </div>

        </div>

        <!-- CUSTOMER INFO -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            <div class="bg-slate-50 p-5 rounded-xl">
                <p class="text-xs text-slate-500 uppercase font-bold">Customer Shipping Info</p>

                <p class="font-bold text-slate-800 mt-1">
                    {{ $do->customer->company_name ?? '-' }}
                </p>

                <p class="text-sm text-slate-600">
                    {{ $do->attn ?? ($do->customer->attn ?? '-') }} ({{ $do->customer->job ?? '-' }})
                </p>
                <p class="text-sm text-slate-600">
                    {{ $do->customer->email ?? '-' }} | {{ $do->customer->phone ?? '-' }}
                </p>

                <p class="text-sm text-slate-600">
                    {{ $do->shipping_address ?? ($do->customer->address ?? '-') }}
                </p>
            </div>

            @if($do->invoice)
                <div class="bg-slate-50 p-5 rounded-xl">
                    <p class="text-xs text-slate-500 uppercase font-bold">Invoice Info</p>

                    <div class="mt-2 space-y-1 text-sm">

                        <p  class="font-bold text-slate-800 mt-1">
                            <span class="text-slate-500">Ref:</span>
                            {{ $do->invoice->invoice_number ?? '-' }}
                        </p>
                        <p class="font-bold text-slate-800 mt-1">
                            {{ $do->invoice->customer->company_name ?? '-' }}
                        </p>
                        <p>
                            {{ $do->invoice->customer->address ?? '-' }}
                        </p>
                        <p>
                            {{ $do->invoice->customer->attn ?? '-' }} ({{ $do->invoice->customer->job ?? '-' }})
                        </p>

                        <p>
                            {{ $do->invoice->customer->email ?? '-' }} | {{ $do->invoice->customer->phone ?? '-' }}
                        </p>
                    


                    </div>
                </div>
            @endif

        </div>

        <!-- ITEMS TABLE -->
        <div class="border rounded-xl overflow-hidden mb-8">

            <table class="w-full text-sm">

                <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                    <tr>
                        <th class="p-3 text-left">Part Number</th>
                        <th class="p-3 text-left">Description</th>
                        <th class="p-3 text-center">Qty</th>
                        <th class="p-3 text-left">Serial Number</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach ($do->items as $item)
                        <tr class="hover:bg-slate-50">

                            <td class="p-3">
                                {{ $item->part_number ?? '-' }}
                            </td>

                            <td class="p-3 font-semibold text-slate-800">
                                {{ $item->description }}
                            </td>

                            <td class="p-3 text-center">
                                {{ $item->qty }}
                            </td>

                            <td class="p-3">
                                {{ $item->serial_number ?? '-' }}
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
                {{ $do->remark ?? '-' }}
            </div>
        </div>

        <!-- ACTION -->
        <div class="flex justify-end gap-3">

            <a href="{{ route('delivery-orders.pdf', $do->id) }}"
               target="_blank"
               class="px-5 py-2 bg-blue-600 text-white rounded-lg font-bold">
                Print
            </a>

            <a href="{{ route('delivery-orders.edit', $do->id) }}"
               class="px-5 py-2 bg-yellow-500 text-white rounded-lg font-bold">
                Edit
            </a>

            <a href="{{ route('delivery-orders.index') }}"
               class="px-5 py-2 bg-slate-200 text-slate-700 rounded-lg font-bold">
                Back
            </a>

        </div>

    </div>
</x-app-layout>