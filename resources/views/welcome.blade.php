<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Selamat Datang di Bumiloo</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
    /* Mengunci mati seluruh layar biar ga ada scroll miring atau mental ke atas */
    html, body {
        margin: 0 !important;
        padding: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        overflow: hidden !important;
        background: linear-gradient(135deg, #FFF0F5 0%, #FFE4E1 50%, #FFF5F7 100%) !important;
    }

    * { box-sizing: border-box !important; font-family: 'Poppins', sans-serif; }

    /* KUNCI TENGAH ABSOLUT: Ukuran max-width diperkecil agar pas di laptop */
    .main-wrapper {
        position: absolute !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        width: 85%;
        max-width: 850px; /* 💡 FIXED: Diperkecil dari 1024px agar card tidak kebesaran */
        z-index: 10;
    }

    /* --- ANIMASI BACKGROUND BLUR --- */
    .bg-circle {
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(248,117,170,0.15) 0%, rgba(248,117,170,0) 70%);
        z-index: 1;
        animation: floatCircle 8s infinite ease-in-out;
    }
    .circle-1 { width: 400px; height: 400px; top: -100px; left: -100px; }
    .circle-2 { width: 500px; height: 500px; bottom: -150px; right: -150px; animation-delay: 2s; }

    /* --- CARD UTAMA: Lengkungan disesuaikan --- */
    .welcome-card {
        background: rgba(255, 255, 255, 0.92) !important;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.6) !important;
        border-radius: 32px !important; /* 💡 Diperhalus dari 40px agar lebih proporsional */
        box-shadow: 0 25px 60px -15px rgba(248, 117, 170, 0.15) !important;
        display: grid !important;
        grid-template-columns: 1fr !important;
        overflow: hidden !important;
        animation: fadeInUp 1s ease-out;
    }

    @media (min-width: 768px) {
        .welcome-card { grid-template-columns: 1.15fr 0.85fr !important; }
    }

    /* --- SISI KIRI: PADDING DIPERKECIL --- */
    .content-side {
        padding: 40px 35px !important; /* 💡 FIXED: Diturunkan dari 60px agar ruangnya pas */
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important; 
        text-align: center !important; 
        justify-content: center !important;
    }

    .brand-logo {
        max-height: 70px !important; /* 💡 Diperkecil dikit dari 80px */
        width: auto !important;
        margin-bottom: 20px !important; 
        display: block !important;
        animation: bounceSoft 3s infinite ease-in-out;
    }

    .headline {
        font-family: 'Playfair Display', serif !important;
        font-size: 26px !important; /* 💡 FIXED: Diperkecil dari 32px agar teks tidak raksasa */
        line-height: 1.3 !important;
        color: #1E3A5F !important;
        margin-bottom: 14px !important;
        font-weight: 700 !important;
    }
    
    .headline span { color: #F875AA !important; font-style: italic !important; font-weight: 500 !important; }

    .paragraph {
        font-size: 13px !important; /* 💡 Diperkecil dari 14px */
        color: #64748B !important;
        line-height: 1.6 !important;
        margin-bottom: 25px !important; /* 💡 Dipersempit jaraknya */
        max-width: 400px !important;
    }

    /* --- TOMBOL NAVIGASI --- */
    .nav-links { display: flex !important; gap: 12px !important; flex-wrap: wrap !important; justify-content: center !important; }

    .btn-bumiloo {
        padding: 10px 26px !important; /* 💡 Padding disesuaikan lebih ramping */
        border-radius: 14px !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        text-decoration: none !important;
        transition: 0.3s !important;
        display: inline-block !important;
    }

    .btn-primary-bml {
        background-color: #f875aa !important;
        color: white !important;
        box-shadow: 0 6px 15px -4px rgba(248, 117, 170, 0.4) !important;
    }
    .btn-primary-bml:hover { transform: translateY(-2px) !important; background-color: #E91E8C !important; }

    .btn-outline-bml {
        border: 2px solid #f875aa !important;
        color: #f875aa !important;
        background-color: transparent !important;
    }
    .btn-outline-bml:hover { background-color: rgba(248, 117, 170, 0.08) !important; transform: translateY(-2px) !important; }

    /* --- SISI KANAN: FRAME FOTO SEIMBANG --- */
    .visual-side {
        background: linear-gradient(135deg, #FFF5F7 0%, #FFE4E1 100%) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 30px !important;
    }

    /* UKURAN SEIMBANG: Diturunkan agar pas dengan card baru */
    .image-frame {
        width: 280px !important; /* 💡 FIXED: Diturunkan dari 370px agar seimbang dan pas */
        height: 280px !important;
        border-radius: 50% !important;
        background-color: #FFFFFF !important;
        border: 8px solid rgba(255, 255, 255, 0.7) !important;
        box-shadow: 0 20px 40px rgba(248, 117, 170, 0.12) !important;
        overflow: hidden !important;
        animation: pulseImage 5s infinite ease-in-out;
    }

    .image-frame img { width: 100% !important; height: 100% !important; object-fit: cover !important; }

    /* --- ANIMASI KEYFRAMES --- */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes floatCircle { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
    @keyframes bounceSoft { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
    @keyframes pulseImage { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.02); } }
</style>
    </head>
    <body>

        <div class="bg-circle circle-1"></div>
        <div class="bg-circle circle-2"></div>

        <div class="main-wrapper">
            <div class="welcome-card">
                
                <div class="content-side">
                    <img src="{{ asset('images/logobumiloo.png') }}" onerror="this.src='https://cdn-icons-png.flaticon.com/512/2924/2924610.png'" alt="Logo Bumiloo" class="brand-logo">

                    <h1 class="headline">
                        Setiap Langkah Kecil Anda,<br>adalah <span>Keajaiban Besar.</span>
                    </h1>
                    
                    <p class="paragraph">
                        Selamat datang di Bumiloo. Ruang aman terintegrasi untuk memantau kesehatan Ibu dan perkembangan janin Anda.
                    </p>

                    <div class="nav-links">
                        @if (Route::has('login'))
                            
                            {{-- 🟢 KONDISI 1: JIKA USER SUDAH LOGIN --}}
                            {{-- Biar ga kosong melompong, kita kasih tombol otomatis masuk ke gerbang utama /dashboard --}}
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-bumiloo btn-primary-bml" style="display: inline-flex !important; align-items: center; gap: 8px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 16px; height: 16px; fill: currentColor;" viewBox="0 0 24 24">
                                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                                    </svg>
                                    Masuk ke Aplikasi
                                </a>
                            @endauth

                            {{-- 🟡 KONDISI 2: JIKA USER BELUM LOGIN (TAMU) --}}
                            {{-- Tombol asli kelompokmu yang sempat hilang bakal nongol lagi di sini --}}
                            @guest
                                <a href="{{ route('login') }}" class="btn-bumiloo btn-primary-bml">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-bumiloo btn-outline-bml">Register</a>
                                @endif
                            @endguest

                        @endif
                    </div>

                <div class="visual-side">
                    <div class="image-frame">
                        <img src="{{ asset('images/welcomebumil.png') }}" 
                             onerror="this.src='https://images.unsplash.com/photo-1584269600464-37b1b58a9fe7?q=80&w=600&auto=format&fit=cover'" 
                             alt="Ibu Hamil Bumiloo">
                    </div>
                </div>

            </div>
        </div>

    </body>
</html>