<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- 1. Judul: Mengambil dari .env (APP_NAME) atau default ke 'MizuTech' -->
    <title>{{ config('app.name', 'MizuTech') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}"> 

    <link rel="preconnect" href="https://bunny.net">
    {{-- <link href="https://bunny.net/css?family=figtree:400,500,600,700,900&display=swap" rel="stylesheet" /> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ url('plugin/select2-4.0.13/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    @stack('styles')
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Navbar Atas -->
            @include('layouts.navigation')

            <!-- Content Container -->
            <main class="flex-1 overflow-y-auto focus:outline-none">
                @isset($header)
                    <header class="bg-white border-b border-slate-200">
                        <div class="max-w-[1600px] mx-auto py-6 px-6 sm:px-8">
                            <h2 class="font-bold text-2xl text-slate-800 tracking-tight flex items-center gap-3">
                                <span class="w-1.5 h-8 bg-blue-600 rounded-full"></span>
                                {{ $header }}
                            </h2>
                        </div>
                    </header>
                @endisset

                <div class="py-8 px-6 sm:px-8 max-w-[1600px] mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
   
    <script src="{{ url('plugin/jquery/jquery-3.7.1.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script src="{{ url('plugin/select2-4.0.13/dist/js/select2.min.js') }}"></script>

    @stack('modals')
    @stack('scripts')
   
</body>
</html>
