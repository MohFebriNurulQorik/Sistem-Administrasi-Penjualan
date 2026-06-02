<x-app-layout>
    <x-slot name="header">Invoice</x-slot>

    <div class="bg-white p-6 rounded-2xl shadow-sm border">

        {{-- HEADER --}}
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-bold">List Invoice</h2>
            <div class="flex gap-2">

                <a href="{{ route('invoices.export') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg ">
                    Export Invoice
                </a>
                <a href="{{ route('invoices.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-xl">
                    Create
                </a>
            </div>
        </div>

        {{-- SEARCH --}}
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search invoice, PO, customer..." class="border rounded-lg px-3 py-2 w-80">

            <button class="bg-blue-600 text-white px-4 rounded-lg">
                Search
            </button>

            @if (request('search'))
                <a href="{{ route('invoices.index') }}" class="px-4 py-2 border rounded-lg">
                    Reset
                </a>
            @endif
        </form>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg">
                <ul class="text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- TABLE --}}
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-center">No</th>
                    <th>Invoice Number</th>
                    <th>Customer</th>
                    <th>Invoice To</th>
                    <th>SO Number</th>
                    <th>Due Date</th>
                    <th>Print Date</th>
                    <th class="text-right">Total</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($invoices as $inv)
                    <tr class="border-b">
                        <td class="text-center">{{ $loop->iteration }}</td>

                        <td>{{ $inv->invoice_number }}</td>

                        <td>{{ $inv->customer->company_name ?? '-' }}</td>

                        <td> {{ $inv->customerInvoice ? $inv->customerInvoice->attn . '  (' . $inv->customerInvoice->job . ')' : '-' }} </td>
                        <td>{{ $inv->so_number ?? '-' }}</td>

                        <td>
                            {{ $inv->due_date ? \Carbon\Carbon::parse($inv->due_date)->format('d M Y') : '-' }}
                        </td>
                        <td>
                            {{ $inv->print_date ? \Carbon\Carbon::parse($inv->print_date)->format('d M Y') : '-' }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($inv->total_amount) }}
                        </td>

                        <td class="flex justify-center gap-2">

                            {{-- PDF --}}
                            <a href="{{ route('invoices.show', $inv->id) }}" target="_blank"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold">
                                PDF
                            </a>

                            {{-- EDIT --}}
                            <a href="{{ route('invoices.edit', $inv->id) }}"
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold">
                                Edit
                            </a>

                            {{-- DELETE --}}
                            <form method="POST" action="{{ route('invoices.destroy', $inv->id) }}">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold">
                                    Delete
                                </button>
                            </form>

                            {{-- DUPLICATE --}}
                            <a href="{{ route('invoices.duplicate', $inv->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold">
                                Duplicate
                            </a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $invoices->links() }}
        </div>

    </div>
</x-app-layout>
