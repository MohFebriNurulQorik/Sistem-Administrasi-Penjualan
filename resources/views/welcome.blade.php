<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Administrasi Penjualan | {{ config('app.name', 'MizuTech') }}</title>
    
    <!-- Vite Standard Laravel -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Plus Jakarta Sans -->
    <link href="https://googleapis.com" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            margin: 0;
            background-color: #000;
        }

        /* Container Full Screen */
        .hero {
            height: 100vh;
            width: 100%;
            position: relative;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Background Image Full Screen */
        .hero-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }
        .hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* Overlay Gelap (Sesuai gambar referensi) */
        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6); 
            z-index: 1;
        }

        /* Navbar Sederhana */
        nav {
            position: relative;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 5%;
        }

        .logo img {
            height: 45px; /* Ukuran logo MizuTech agar tetap proporsional */
            width: auto;
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            opacity: 0.8;
            transition: opacity 0.3s;
        }
        .nav-links a:hover { opacity: 1; color: #f97316; }

        /* Content Tengah */
        .hero-content {
            position: relative;
            z-index: 10;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 0 1rem;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-top: 1.5rem;
            color: #cbd5e1;
            max-width: 700px;
            font-weight: 500;
        }

        /* Tombol Orange MizuTech */
        .btn-orange {
            margin-top: 3rem;
            color: white;
            padding: 1.1rem 3rem;
            border-radius: 0.75rem;
            text-decoration: none;
            font-weight: 800;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px -5px rgba(249, 115, 22, 0.4);
        }

        .btn-orange:hover {
            background-color: #ea580c;
            transform: translateY(-3px);
            box-shadow: 0 15px 25px -5px rgba(249, 115, 22, 0.5);
        }

        /* Responsif untuk HP */
        @media (max-width: 768px) {
            .hero-content h1 { font-size: 2.2rem; }
            .hero-content p { font-size: 1rem; }
            .nav-links { display: none; }
            nav { padding: 1.5rem; }
        }
    </style>
</head>

<body>

    <div class="hero">
        
        <!-- Background -->
        <div class="hero-bg">
            <img src="{{ asset('images/bg.jpg') }}" alt="MizuTech Background">
            <div class="overlay"></div>
        </div>

        <!-- Navbar -->
        <nav>
            <div class="logo">
                <img src="{{ asset('images/logo-mizutech.png') }}" alt="MizuTech Logo">
            </div>
            <div class="nav-links">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" style="color: #ffffff;">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Masuk Akun</a>
                    @endauth
                @endif
            </div>
        </nav>

        <!-- Main Message -->
        <div class="hero-content">
            <h1>Selamat Datang di <br> <span style="color: #f0c42e;">Sistem Administrasi Penjualan</span></h1>
            <p>Sistem cerdas untuk membuat dan memonitoring <br class="hidden md:block"> 
               <strong>Invoice, Quotation,</strong> dan <strong>Delivery Order</strong> secara terpadu.</p>
            
            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 btn-orange">
                Login
            </a>
        </div>

    </div>

</body>
</html>
