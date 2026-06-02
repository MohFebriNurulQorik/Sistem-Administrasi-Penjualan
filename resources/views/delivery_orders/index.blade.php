<x-app-layout>
    <x-slot name="header">Delivery Order</x-slot>

    <div class="bg-white p-6 rounded-2xl shadow-sm border">

        <!-- HEADER -->
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-bold">List Delivery Order</h2>
            <div class="flex gap-2">

                <a href="{{ route('delivery-orders.export') }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Export Excel
                </a>
                <a href="{{ route('delivery-orders.create') }}" 
                class="bg-blue-600 text-white px-4 py-2 rounded-xl">
                    Create
                </a>
            </div>
        </div>

        <!-- SEARCH -->
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search DO number, project, customer..."
                class="border rounded-lg px-3 py-2 w-80">

            <button class="bg-blue-600 text-white px-4 rounded-lg">
                Search
            </button>

            @if(request('search'))
                <a href="{{ route('delivery-orders.index') }}"
                   class="px-4 py-2 border rounded-lg">
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

        <!-- TABLE -->
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-center">No</th>
                    <th>DO Number</th>
                    <th>Customer</th>
                    <th>Invoice</th>
                    <th>Project</th>
                    <th>Delivery Date</th>
                    <th>Print Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($deliveryOrders as $do)
                <tr class="border-b">
                    <td class="text-center">{{ $loop->iteration }}</td>

                    <td>{{ $do->do_number }}</td>

                    <td>{{ $do->customer->company_name ?? '-' }}</td>

                    <td>{{ $do->invoice->invoice_number ?? '-' }}</td>
                    <td>{{ $do->project ?? '-' }}</td>

                    <td>{{ $do->delivery_date ?? '-' }}</td>
                    <td>{{ $do->print_date ?? '-' }}</td>

                    <td class="flex justify-center gap-2">

                        <!-- PDF -->
                        <a href="{{ route('delivery-orders.show', $do->id) }}"
                           target="_blank"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                            PDF
                        </a>

                        <!-- EDIT -->
                        <a href="{{ route('delivery-orders.edit', $do->id) }}"
                           class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                            Edit
                        </a>

                        <!-- DELETE -->
                        <form method="POST" action="{{ route('delivery-orders.destroy', $do->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                Delete
                            </button>
                        </form>

                        <!-- DUPLICATE -->
                        <a href="{{ route('delivery-orders.duplicate', $do->id) }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                            Duplicate
                        </a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- PAGINATION -->
        <div class="mt-4">
            {{ $deliveryOrders->links() }}
        </div>

    </div>
</x-app-layout>