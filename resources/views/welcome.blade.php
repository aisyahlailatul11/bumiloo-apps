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
        html, body { margin: 0 !important; padding: 0 !important; width: 100vw !important; height: 100vh !important; overflow: hidden !important; background: linear-gradient(135deg, #FFF0F5 0%, #FFE4E1 50%, #FFF5F7 100%) !important; }
        * { box-sizing: border-box !important; font-family: 'Poppins', sans-serif; }
        
        /* Layout Utama */
        .main-wrapper { position: absolute !important; top: 50% !important; left: 50% !important; transform: translate(-50%, -50%) !important; width: 90%; max-width: 1024px; z-index: 10; }
        
        /* Modal Overlay & Box */
        .modal-overlay { position: fixed !important; top: 0; left: 0; width: 100%; height: 100%; background: rgba(30, 58, 95, 0.4); backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center; visibility: hidden; opacity: 0; z-index: 9999 !important; transition: all 0.3s ease; }
        .modal-overlay:target { visibility: visible; opacity: 1; }
        .modal-box { background: white; padding: 30px; border-radius: 30px; width: 90%; max-width: 450px; position: relative; box-shadow: 0 20px 50px rgba(0,0,0,0.15); text-align: center; }
        .modal-close { position: absolute; top: 15px; right: 20px; font-size: 30px; text-decoration: none; color: #94A3B8; }
        .modal-avatar { width: 80px; height: 80px; border-radius: 50%; margin-bottom: 15px; display: flex; align-items: center; justify-content: center; background: #FFF0F5; }
        .modal-header h3 { color: #1E3A5F; font-size: 18px; margin: 0; }
        .badge-akreditasi { background: #f875aa; color: white; padding: 3px 12px; border-radius: 12px; font-size: 11px; }
        .modal-body { margin-top: 20px; text-align: left; font-size: 13px; color: #64748B; }
        .modal-info-row { margin-bottom: 10px; }

        /* Komponen Welcome Card */
        .welcome-card { background: rgba(255, 255, 255, 0.92) !important; backdrop-filter: blur(20px); border-radius: 40px !important; box-shadow: 0 35px 70px -15px rgba(248, 117, 170, 0.2) !important; display: grid !important; grid-template-columns: 1fr !important; overflow: hidden !important; animation: fadeInUp 1s ease-out; }
        @media (min-width: 768px) { .welcome-card { grid-template-columns: 1.15fr 0.85fr !important; min-height: 450px !important; } }
        .content-side { padding: 60px 45px !important; display: flex !important; flex-direction: column !important; align-items: center !important; text-align: center !important; justify-content: center !important; }
        .brand-logo { max-height: 80px !important; margin-bottom: 25px !important; animation: bounceSoft 3s infinite ease-in-out; }
        .headline { font-family: 'Playfair Display', serif !important; font-size: 32px !important; color: #1E3A5F !important; margin-bottom: 16px !important; font-weight: 700 !important; }
        .headline span { color: #F875AA !important; font-style: italic !important; }
        .nav-links { display: flex !important; gap: 14px !important; flex-wrap: wrap !important; justify-content: center !important; }
        .btn-bumiloo { padding: 12px 30px !important; border-radius: 16px !important; font-size: 14px !important; font-weight: 700 !important; text-decoration: none !important; }
        .btn-primary-bml { background-color: #f875aa !important; color: white !important; }
        .btn-outline-bml { border: 2px solid #f875aa !important; color: #f875aa !important; }
        .visual-side { background: linear-gradient(135deg, #FFF5F7 0%, #FFE4E1 100%) !important; display: flex !important; align-items: center !important; justify-content: center !important; padding: 40px !important; }
        .image-frame { width: 370px !important; height: 370px !important; border-radius: 50% !important; background: #FFFFFF !important; border: 12px solid rgba(255, 255, 255, 0.7) !important; overflow: hidden !important; animation: pulseImage 5s infinite ease-in-out; }
        .image-frame img { width: 100% !important; height: 100% !important; object-fit: cover !important; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulseImage { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.03); } }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="welcome-card">
            <div class="content-side">
    <img src="{{ asset('images/logobumiloo.png') }}" alt="Logo" class="brand-logo">
    
    <h1 class="headline" style="margin-bottom: 10px;">
        Setiap Langkah Kecil Anda,<br>Adalah <span>Keajaiban Besar.</span>
    </h1>
    
    <p class="paragraph" style="margin-bottom: 5px;">
        Pendamping setia kesehatan ibu dan janin.
    </p>

    <h2 class="sub-headline" style="font-size: 15px; margin-bottom: 20px; color: #64748B;">
        Praktik Bidan Mandiri Siti Fatimah, Jember
    </h2>
                
                <div class="nav-links">
                    <a href="#tentangKlinik" class="btn-outline-bml" style="width: 50px; height: 50px; border-radius: 50% !important; display: flex; align-items: center; justify-content: center;"><i class="fas fa-clinic-medical"></i></a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-bumiloo btn-primary-bml">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-bumiloo btn-primary-bml">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-bumiloo btn-outline-bml">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
            <div class="visual-side">
                <div class="image-frame">
                    <img src="{{ asset('images/welcomebumil.png') }}" onerror="this.src='https://images.unsplash.com/photo-1584269600464-37b1b58a9fe7?q=80&w=600&auto=format&fit=cover'" alt="Bumiloo">
                </div>
            </div>
        </div>
    </div>

    <div id="tentangKlinik" class="modal-overlay">
        <div class="modal-box">
            <a href="#" style="float:right; text-decoration:none; color:#666;">✕</a>
            
            <div class="modal-header" style="margin-bottom: 20px;">
                <i class="fas fa-user-nurse" style="font-size: 45px; color: #f875aa; margin-bottom: 10px;"></i>
                <h3 style="margin: 0; color: #1E3A5F;">Bidan Siti Fatimah</h3>
                <span style="background: #f875aa; color: white; padding: 2px 10px; border-radius: 10px; font-size: 11px;">Terakreditasi - A</span>
            </div>

            <div class="modal-body" style="text-align: left; font-size: 13px; color: #475569; line-height: 1.5;">
                <p style="margin-bottom: 15px;">
                   Bidan berpengalaman 15 tahun, spesialisasi ibu dan anak. Menyediakan layanan prenatal, postnatal, dan KB.
                </p>
                <div style="margin-bottom: 8px;"><i class="fas fa-clock" style="color: #f875aa; width: 20px;"></i> Senin - Jumat (08:00 - 16:00)</div>
                <div><i class="fas fa-map-marker-alt" style="color: #f875aa; width: 20px;"></i> Jl. Melati No. 5, Jember</div>
            </div>
        </div>
    </div>
</body>
</html>