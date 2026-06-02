<aside :class="sidebarOpen ? 'w-72' : 'w-20'"
    class="bg-white border-r border-slate-200 min-h-screen transition-all duration-300 ease-in-out hidden lg:flex flex-col sticky top-0 z-50">

    <!-- Logo -->

    @if (Auth::user()->tenant->id == 1)
    <div class="h-20 flex items-center px-6 border-b border-slate-100">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <img x-show="sidebarOpen" src="{{ asset('images/logo-mizutech.png') }}" alt="MizuTech" class="h-10 w-auto">
            <img x-show="!sidebarOpen" src="{{ asset('images/logo-icon.png') }}" alt="Mizu" class="h-8 w-8">
        </a>
    </div>
    @else
    <div class="h-20 flex items-center px-6 border-b border-slate-100 bg-blue-600">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <img x-show="sidebarOpen" src="{{ asset('images/DwisantaraLogo2.png') }}" alt="Dwisantara" style="height: 4.5rem; width: auto;">
            <img x-show="!sidebarOpen" src="{{ asset('images/DwisantaraLogo1 .png') }}" alt="Dwisantara" style="height: 2rem; width: auto;">
        </a>
    </div>
    @endif
      

    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-4 px-3 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-600' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span x-show="sidebarOpen" class="font-semibold whitespace-nowrap">Dashboard</span>
        </a>

        <!-- Sales Group -->
        <div class="pt-2 pb-2">
            <p x-show="sidebarOpen" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 px-3 mb-2">
                Sales</p>
            <a href="{{ route('quotations.index') }}"
                class="flex items-center gap-4 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-all">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Quotation</span>
            </a>
            <a href="{{ route('invoices.index') }}"
                class="flex items-center gap-4 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-all">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Invoice</span>
            </a>
            <a href="{{ route('delivery-orders.index') }}"
                class="flex items-center gap-4 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-all">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1m-4 0h1m-5-1v2m5-2v2m12-5h-3.586" />
                </svg>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Delivery Order</span>
            </a>
        </div>

        <!-- Master Data Group -->
        <div class="pt-4 pb-2">
            <p x-show="sidebarOpen" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 px-3 mb-2">
                Master Data</p>
            <a href="{{ route('customers.index') }}"
                class="flex items-center gap-4 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-all">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Customers</span>
            </a>
            <a href="{{ route('items.index') }}"
                class="flex items-center gap-4 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-all">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Items</span>
            </a>
            <a href="{{ route('projects.index') }}"
                class="flex items-center gap-4 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-all">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 7a2 2 0 012-2h3l2 2h9a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                </svg>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Projects</span>
            </a>
            <a href="{{ route('positions.index') }}"
                class="flex items-center gap-4 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-all">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 6V5a3 3 0 016 0v1m-9 0h12a2 2 0 012 2v9a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2z" />
                </svg>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Positions</span>
            </a>
        </div>

        @if(auth()->user()->role=='admin'||auth()->user()->role=='superadmin')

        <!-- Settings Group -->
        <div class="pt-2">
            <p x-show="sidebarOpen" class="text-[10px] font-bold uppercase tracking-widest text-slate-400 px-3 mb-2">
                Settings</p>
            <a href="{{ route('users.index') }}"
                class="flex items-center gap-4 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-all">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Users</span>
            </a>
            <a  href="{{ route('template.edit') }}"
                class="flex items-center gap-4 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-all">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                        d="M9 15h6M9 11h6M12 3v6h6" />
                </svg>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Template PDF</span>
            </a>
        </div>
        @endif
    </nav>

    <!-- Profile -->
    <div class="p-4 border-t border-slate-100">
       
        <div class="flex items-center gap-3 p-2 rounded-xl bg-slate-50">
            <div
                class="w-8 h-8 rounded-lg bg-yellow-400 flex items-center justify-center text-blue-900 font-bold text-xs">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div x-show="sidebarOpen" class="overflow-hidden">
                <p class="text-xs font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-slate-500">Administrator</p>
            </div>
        </div>
         <div class="font-bold items-center gap-3 p-2 rounded-xl text-xs bg-slate-50">
        {{Auth::user()->tenant->name ?? ''}}
        </div>
    </div>
</aside>
