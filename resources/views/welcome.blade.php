
<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">



        <title>Selamat Datang di Bumiloo</title>



        <link rel="preconnect" href="https://fonts.bunny.net">

        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700" rel="stylesheet" />

        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">



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



            /* KUNCI TENGAH ABSOLUT: Dijamin card berada tepat di tengah-tengah layar laptop */

            .main-wrapper {

                position: absolute !important;

                top: 50% !important;

                left: 50% !important;

                transform: translate(-50%, -50%) !important;

                width: 90%;

                max-width: 1024px;

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

            .circle-1 { width: 450px; height: 450px; top: -100px; left: -100px; }

            .circle-2 { width: 550px; height: 550px; bottom: -150px; right: -150px; animation-delay: 2s; }



            /* --- CARD UTAMA: Grid Kanan-Kiri Figma Pas --- */

            .welcome-card {

                background: rgba(255, 255, 255, 0.92) !important;

                backdrop-filter: blur(20px);

                border: 1px solid rgba(255, 255, 255, 0.6) !important;

                border-radius: 40px !important;

                box-shadow: 0 35px 70px -15px rgba(248, 117, 170, 0.2) !important;

                display: grid !important;

                grid-template-columns: 1fr !important;

                overflow: hidden !important;

                animation: fadeInUp 1s ease-out;

            }



            @media (min-width: 768px) {

                .welcome-card { grid-template-columns: 1.15fr 0.85fr !important; }

            }



            /* --- SISI KIRI: KONTEN & LOGO CENTER --- */

            .content-side {

                padding: 60px 45px !important;

                display: flex !important;

                flex-direction: column !important;

                align-items: center !important;

                text-align: center !important;

                justify-content: center !important;

            }



            .brand-logo {

                max-height: 80px !important;

                width: auto !important;

                margin-bottom: 25px !important;

                display: block !important;

                animation: bounceSoft 3s infinite ease-in-out;

            }



            .headline {

                font-family: 'Playfair Display', serif !important;

                font-size: 32px !important;

                line-height: 1.3 !important;

                color: #1E3A5F !important;

                margin-bottom: 16px !important;

                font-weight: 700 !important;

            }

           

            .headline span { color: #F875AA !important; font-style: italic !important; font-weight: 500 !important; }



            .paragraph {

                font-size: 14px !important;

                color: #64748B !important;

                line-height: 1.7 !important;

                margin-bottom: 35px !important;

                max-width: 440px !important;

            }



            /* --- TOMBOL BALIK KE ASLI --- */

            .nav-links { display: flex !important; gap: 14px !important; flex-wrap: wrap !important; justify-content: center !important; }



            .btn-bumiloo {

                padding: 12px 30px !important;

                border-radius: 16px !important;

                font-size: 14px !important;

                font-weight: 700 !important;

                text-decoration: none !important;

                transition: 0.3s !important;

                display: inline-block !important;

            }



            .btn-primary-bml {

                background-color: #f875aa !important;

                color: white !important;

                box-shadow: 0 8px 20px -5px rgba(248, 117, 170, 0.4) !important;

            }

            .btn-primary-bml:hover { transform: translateY(-2px) !important; background-color: #E91E8C !important; }



            .btn-outline-bml {

                border: 2px solid #f875aa !important;

                color: #f875aa !important;

                background-color: transparent !important;

            }

            .btn-outline-bml:hover { background-color: rgba(248, 117, 170, 0.08) !important; transform: translateY(-2px) !important; }



            /* --- SISI KANAN: FRAME FOTO SANGAT BESAR --- */

            .visual-side {

                background: linear-gradient(135deg, #FFF5F7 0%, #FFE4E1 100%) !important;

                display: flex !important;

                align-items: center !important;

                justify-content: center !important;

                padding: 40px !important;

            }



            /* UKURAN BESAR PRESISI: Dinaikkan ke 370px biar padat seimbang */

            .image-frame {

                width: 370px !important;

                height: 370px !important;

                border-radius: 50% !important;

                background-color: #FFFFFF !important;

                border: 12px solid rgba(255, 255, 255, 0.7) !important;

                box-shadow: 0 25px 50px rgba(248, 117, 170, 0.18) !important;

                overflow: hidden !important;

                animation: pulseImage 5s infinite ease-in-out;

            }



            .image-frame img { width: 100% !important; height: 100% !important; object-fit: cover !important; }



            /* --- ANIMASI KEYFRAMES --- */

            @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }

            @keyframes floatCircle { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }

            @keyframes bounceSoft { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }

            @keyframes pulseImage { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.03); } }

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

                        Setiap Langkah Kecil Anda,<br>Adalah <span>Keajaiban Besar.</span>

                    </h1>
                    <p class="paragraph">
                        Selamat datang di Bumiloo. Ruang aman terintegrasi untuk memantau kesehatan Ibu dan perkembangan janin Anda.
                    </p>
                    
                   <div class="nav-links">
    @if (Route::has('login'))
        @auth
            {{-- Jika User sudah login, arahkan ke Dashboard --}}
            <a href="{{ url('/dashboard') }}" class="btn-bumiloo btn-primary-bml">Dashboard</a>
        @else
            {{-- Jika User belum login, tampilkan Login & Register --}}
            <a href="{{ route('login') }}" class="btn-bumiloo btn-primary-bml">Log in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-bumiloo btn-outline-bml">Register</a>
            @endif
        @endauth
    @endif
</div>
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
<<<<<<< HEAD
        <div id="tentangKlinik" class="modal-overlay">
    <div class="modal-box">
        <a href="#" class="modal-close">&times;</a>
        
        <div class="modal-header">
            <div style="width: 80px; height: 80px; background-color: #FFF5F7; border: 3px solid #FFE4E1; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto; box-shadow: 0 8px 20px rgba(248, 117, 170, 0.15);">
                <i class="fas fa-user-md" style="font-size: 36px; color: #f875aa;"></i></div>
            <h3>Praktik Bidan Mandiri Siti Fatimah</h3>
            <span class="badge-akreditasi">Terakreditasi - A</span>
        </div>

        <div class="modal-body">
            <p class="modal-bio">
                "Bidan berpengalaman 15 tahun, spesialisasi ibu dan anak. Menyediakan layanan prenatal, postnatal, dan KB dengan sistem terintegrasi."
            </p>
            <div class="modal-info-row">
                <strong><i class="fas fa-clock" style="color: #f875aa;"></i> Jadwal Praktik:</strong>
                <span>Senin-Jumat (08:00 - 16:00 WIB)</span>
            </div>
            <div class="modal-info-row">
                <strong><i class="fas fa-map-marker-alt" style="color: #f875aa;"></i> Alamat Klinik:</strong>
                <span>Jl. Melati No. 5, Kecamatan Patrang, Kab. Jember</span>
            </div>
        </div>
    </div>
</div>
=======
>>>>>>> 02785db6db7727b3b78913b8140caeec5eba4f85
    </body>
</html>

