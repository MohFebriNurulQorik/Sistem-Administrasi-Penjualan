<x-app-layout>
    <x-slot name="header">
        Dashboard {{Auth::user()->tenant->name ?? ''}}
    </x-slot>

    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">

        <!-- Welcome Banner -->
        <div class="xl:col-span-3 relative overflow-hidden bg-blue-600 rounded-[2rem] p-10 shadow-xl">
            <h3 class="text-3xl font-black text-white">Selamat Datang 🚀</h3>
            <p class="text-blue-100 mt-3">
                Sistem Invoice, Quotation dan Delivery Order Dashboard
            </p>

            <div class="mt-6 flex gap-4 text-white">
                <div>
                    <p class="text-sm text-blue-100">Monthly Revenue</p>
                    <p class="text-2xl font-black">
                        Rp {{ number_format($monthlyRevenue, 0) }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-blue-100">Growth</p>
                    <p class="text-2xl font-black">
                        {{ number_format($revenueGrowth, 1) }}%
                    </p>
                </div>
            </div>
            <div class="mt-8 flex gap-4">
                <a href="{{ route('invoices.create') }}"
                    class="bg-yellow-400 text-blue-900 px-8 py-3 rounded-2xl font-bold hover:bg-white transition-all">
                    Buat Invoice
                </a>
                <a href="{{ route('invoices.index') }}"
                    class="bg-blue-500/50 text-white border border-blue-400 px-8 py-3 rounded-2xl font-bold hover:bg-blue-500">
                    Lihat Laporan Invoice
                </a>
            </div>
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-96 h-96 bg-white opacity-10 rounded-full"></div>
        </div>

        <!-- KPI Card -->
        <div class="bg-white rounded-[2rem] p-6 border shadow-sm">
            <h4 class="font-bold mb-4">Business KPI</h4>

            <div class="space-y-4">

                <div class="bg-slate-50 p-4 rounded-xl">
                    <div class="flex justify-between">
                        <span class="text-xs font-bold text-slate-500">Total Customer</span>
                        <span class="font-bold text-blue-600">{{ $totalCustomer }}</span>
                    </div>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl">
                    <div class="flex justify-between">
                        <span class="text-xs font-bold text-slate-500">Total Invoice</span>
                        <span class="font-bold text-slate-800">{{ $totalInvoice }}</span>
                    </div>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl">
                    <div class="flex justify-between">
                        <span class="text-xs font-bold text-slate-500">Total Revenue</span>
                        <span class="font-bold text-green-600">
                            Rp {{ number_format($totalRevenue, 0) }}
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <!-- TOP QUOTATION -->
        <div class="bg-white rounded-[2rem] p-6 border shadow-sm xl:col-span-2">
            <h4 class="font-bold mb-4">Top 5 Customer (Quotation)</h4>

            <div class="space-y-3">
                @foreach ($topQuotationCustomers as $c)
                    <div class="flex justify-between bg-slate-50 p-3 rounded-xl">
                        <span class="text-sm font-semibold">
                            {{ $c->customer->company_name ?? '-' }}
                        </span>
                        <span class="text-blue-600 font-bold">
                            {{ $c->total_quotation }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- TOP INVOICE -->
        <div class="bg-white rounded-[2rem] p-6 border shadow-sm xl:col-span-2">
            <h4 class="font-bold mb-4">Top 5 Customer (Invoice)</h4>

            <div class="space-y-3">
                @foreach ($topInvoiceCustomers as $c)
                    <div class="flex justify-between bg-slate-50 p-3 rounded-xl">
                        <span class="text-sm font-semibold">
                            {{ $c->customer->company_name ?? '-' }}
                        </span>
                        <span class="text-green-600 font-bold">
                            {{ $c->total_invoice }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- TOP REVENUE -->
        <div class="bg-white rounded-[2rem] p-6 border shadow-sm xl:col-span-4">
            <h4 class="font-bold mb-4">Top 5 Revenue Customer</h4>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @foreach ($topRevenueCustomers as $c)
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <p class="text-xs text-slate-500 font-bold">Customer</p>
                        <p class="font-semibold text-slate-800">
                            {{ $c->customer->company_name ?? '-' }}
                        </p>

                        <p class="mt-2 text-green-600 font-black">
                            Rp {{ number_format($c->total_revenue, 0) }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
