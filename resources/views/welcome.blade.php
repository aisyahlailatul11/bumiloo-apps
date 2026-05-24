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
            /* Mengunci mati seluruh layar biar ga ada scroll miring */
            html, body {
                margin: 0 !important;
                padding: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
                overflow: hidden !important;
                background: linear-gradient(135deg, #FFF0F5 0%, #FFE4E1 50%, #FFF5F7 100%) !important;
            }

            * { box-sizing: border-box !important; font-family: 'Poppins', sans-serif; }

            /* KUNCI LEBAR LANDSCAPE: Biar memanjang kesamping */
            .main-wrapper {
                position: absolute !important;
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                width: 85%;
                max-width: 850px; 
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

            /* --- CARD UTAMA: Grid Terbagi 2 Sisi Sempurna --- */
            .welcome-card {
                background: rgba(255, 255, 255, 0.92) !important;
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.6) !important;
                border-radius: 32px !important;
                box-shadow: 0 25px 60px -15px rgba(248, 117, 170, 0.15) !important;
                display: grid !important;
                grid-template-columns: 1fr !important;
                overflow: hidden !important;
                animation: fadeInUp 1s ease-out;
            }

            @media (min-width: 768px) {
                .welcome-card { 
                    grid-template-columns: 1.25fr 0.75fr !important; 
                    min-height: 420px !important; 
                    max-height: 450px !important; 
                }
            }

            /* --- SISI KIRI: SEMUA DIKUNCI DI TENGAH --- */
            .content-side {
                padding: 40px 35px !important; 
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important; 
                text-align: center !important; 
                justify-content: center !important;
                width: 100% !important;
            }

            .brand-logo {
                max-height: 65px !important; 
                width: auto !important;
                margin: 0 auto 20px auto !important; 
                display: block !important;
                animation: bounceSoft 3s infinite ease-in-out;
            }

            .headline {
                font-family: 'Playfair Display', serif !important;
                font-size: 26px !important; 
                line-height: 1.3 !important;
                color: #1E3A5F !important;
                margin-bottom: 12px !important;
                font-weight: 700 !important;
            }
            
            .headline span { color: #F875AA !important; font-style: italic !important; font-weight: 500 !important; }

            .paragraph {
                font-size: 13px !important;
                color: #64748B !important;
                line-height: 1.6 !important;
                margin-bottom: 25px !important;
                max-width: 440px !important;
            }

            /* --- TOMBOL DI TENGAH --- */
            .nav-links { display: flex !important; gap: 12px !important; flex-wrap: wrap !important; justify-content: center !important; width: 100% !important;}

            .btn-bumiloo {
                padding: 10px 28px !important;
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

            /* 🌸 CSS POP-UP MODAL PREMIUM BUMILOO */
.modal-overlay {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(30, 58, 95, 0.4); /* Efek redup biru navy */
    backdrop-filter: blur(8px);
    transition: opacity 400ms;
    visibility: hidden;
    opacity: 0;
    z-index: 999;
}
.modal-overlay:target {
    visibility: visible;
    opacity: 1;
}

.modal-box {
    margin: 10% auto;
    padding: 30px;
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(248, 117, 170, 0.3);
    border-radius: 24px;
    width: 90%;
    max-width: 480px;
    position: relative;
    box-shadow: 0 20px 50px rgba(248, 117, 170, 0.15);
    text-align: center;
}

.modal-close {
    position: absolute;
    top: 15px;
    right: 20px;
    transition: all 200ms;
    font-size: 30px;
    font-weight: bold;
    text-decoration: none;
    color: #94A3B8;
}
.modal-close:hover { color: #f875aa; }

.modal-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    border: 4px solid #FFE4E1;
    margin-bottom: 12px;
}

.modal-header h3 {
    color: #1E3A5F;
    font-size: 18px;
    margin: 0 0 5px 0;
    font-weight: 700;
}

.badge-akreditasi {
    background-color: #f875aa;
    color: white;
    padding: 3px 12px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
}

.modal-body { margin-top: 20px; text-align: left; }

.modal-bio {
    font-size: 13px;
    color: #64748B;
    line-height: 1.6;
    background: #FFF5F7;
    padding: 12px 15px;
    border-radius: 12px;
    border-left: 3px solid #f875aa;
    margin-bottom: 20px;
}

.modal-info-row {
    font-size: 13px;
    color: #1E3A5F;
    margin-bottom: 10px;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

            /* --- SISI KANAN: FRAME LINGKARAN FOTO --- */
            .visual-side {
                background: linear-gradient(135deg, #FFF5F7 0%, #FFE4E1 100%) !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 20px !important;
                width: 100% !important;
            }

            .image-frame {
                width: 250px !important; 
                height: 250px !important;
                border-radius: 50% !important;
                background-color: #FFFFFF !important;
                border: 8px solid rgba(255, 255, 255, 0.7) !important;
                box-shadow: 0 20px 40px rgba(248, 117, 170, 0.12) !important;
                overflow: hidden !important;
                animation: pulseImage 5s infinite ease-in-out;
            }

            .image-frame img { width: 100% !important; height: 100% !important; object-fit: cover !important; }

            /* --- ANIMASI KEYFRAMES --- */
            @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
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

                    <div class="nav-links" style="display: flex !important; align-items: center !important; justify-content: center !important; gap: 12px !important;">
                    <a href="#tentangKlinik" title="Tentang Klinik" style="border: 2px solid #1E3A5F !important; color: #1E3A5F !important; background: transparent !important; width: 40px !important; height: 40px !important; border-radius: 14px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-size: 15px !important; text-decoration: none !important; transition: 0.2s !important; box-sizing: border-box !important;">
                        <i class="fas fa-clinic-medical"></i></a>
                        @if (Route::has('login'))
                            
                            {{-- KONDISI 1: JIKA USER SUDAH LOGIN --}}
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-bumiloo btn-primary-bml" style="display: inline-flex !important; align-items: center; gap: 8px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 16px; height: 16px; fill: currentColor;" viewBox="0 0 24 24">
                                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                                    </svg>
                                    Masuk ke Aplikasi
                                </a>
                            @endauth

                            {{-- KONDISI 2: JIKA USER BELUM LOGIN (GUEST) --}}
                            @guest
                            <a href="{{ route('login') }}" class="btn-bumiloo btn-primary-bml">Log in</a>
                            @if (Route::has('register'))
                            <a href="{{ route('login') }}?action=register" class="btn-bumiloo btn-outline-bml">Register</a>
                            @endif
                            @endguest

                        @endif
                    </div>
                </div> <div class="visual-side">
                    <div class="image-frame">
                        <img src="{{ asset('images/welcomebumil.png') }}" 
                             onerror="this.src='https://images.unsplash.com/photo-1584269600464-37b1b58a9fe7?q=80&w=600&auto=format&fit=cover'" 
                             alt="Ibu Hamil Bumiloo">
                    </div>
                </div>

            </div>
        </div>
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
    </body>
</html>