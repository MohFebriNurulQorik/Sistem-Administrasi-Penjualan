<x-app-layout>
    <x-slot name="header">Quotation</x-slot>

    <div class="bg-white p-6 rounded-2xl shadow-sm border">
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-bold">List Quotation</h2>
            <div class="flex gap-2">
                <a href="{{ route('quotations.export') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg">
                    Export Quotation
                </a>
                <a href="{{ route('quotations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-xl">
                    Create
                </a>
            </div>
        </div>
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search number, project, customer..." class="border rounded-lg px-3 py-2 w-80">

            <button class="bg-blue-600 text-white px-4 rounded-lg">
                Search
            </button>

            @if (request('search'))
                <a href="{{ route('quotations.index') }}" class="px-4 py-2 border rounded-lg">
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


        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-center">No</th>
                    <th>Number</th>
                    <th>Customer</th>
                    <th>Project</th>
                    <th>Print Date</th>
                    <th>Valid Date</th>
                    <th>Total</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($quotations as $q)
                    <tr class="border-b">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $q->quotation_number }}</td>
                        <td>{{ $q->customer->company_name }}</td>
                        <td>{{ $q->project }}</td>
                        <td class="text-center">{{ $q->print_date }}</td>
                        <td class="text-center">{{ $q->valid_until }}</td>
                        <td class="text-right">Rp {{ number_format($q->grand_total) }}</td>
                        <td class="flex justify-center gap-2">
                            <a href="{{ route('quotations.show', $q->id) }}"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">PDF</a>
                            <a href="{{ route('quotations.edit', $q->id) }}"
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">Edit</a>
                            <form method="POST" action="{{ route('quotations.destroy', $q->id) }}">
                                @csrf @method('DELETE')
                                <button
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">Delete</button>
                            </form>
                            <a href="{{ route('quotations.duplicate', $q->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">Duplicate</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $quotations->links() }}
        </div>
    </div>
</x-app-layout>
