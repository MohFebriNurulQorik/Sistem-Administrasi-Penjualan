<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts: Plus Jakarta Sans (Sesuai Landing Page) -->
        <link rel="preconnect" href="https://googleapis.com">
        <link rel="preconnect" href="https://gstatic.com" crossorigin>
        <link href="https://googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="antialiased text-white">
        
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden bg-[#020617]">
            
            <!-- BACKGROUND IMAGE FULL SCREEN (Sesuai Welcome Page) -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/bg.jpg') }}" class="w-full h-full object-cover opacity-40" alt="Background">
                <!-- Overlay Biru Navy Pekat -->
                <div class="absolute inset-0 bg-gradient-to-tr from-slate-950 via-blue-950/80 to-slate-950"></div>
            </div>

            {{-- <!-- LOGO AREA -->
            <div class="z-10 text-center">
                <a href="/" class="flex flex-col items-center gap-4 group">
                    <div class="bg-orange-500 p-3 rounded-2xl shadow-2xl shadow-orange-500/20 group-hover:scale-105 transition-transform duration-300">
                        <!-- Menggunakan logo MizuTech asli -->
                        <img src="{{ asset('images/logo-mizutech.png') }}" alt="Logo" class="h-10 w-auto">
                    </div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-white uppercase tracking-widest">
                        Mizu<span class="text-orange-500">Tech</span>
                    </h1>
                </a>
            </div> --}}

            <!-- KARTU FORM (Glassmorphism Modern) -->
            <div class="z-10 w-full sm:max-w-md mt-8 px-8 py-10 bg-yellow-800/2 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-[5.5rem] border border-white/10">
                
                <!-- Slot Content (Isi Form Login/Register) -->
                <div class="relative">
                    {{ $slot }}
                </div>

            </div>

            <!-- FOOTER SIMPLE -->
            <div class="z-10 mt-10 text-gray-500 text-[10px] font-bold uppercase tracking-[0.4em]">
                &copy; {{ date('Y') }} {{ config('app.name') }} &bull; Enterprise IT Solution
            </div>

        </div>
    </body>
</html>
