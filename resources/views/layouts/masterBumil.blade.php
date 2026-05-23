<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda') - Bumiloo</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #E91E8C;
            --primary-light: #F875AA;
            --primary-pale: #FCE4EC;
            --body-bg: #fdf2f5;
            --sidebar-w: 250px;
            --text-main: #1A1A2E;
            --radius-card: 20px;
            --shadow-card: 0 2px 16px rgba(233,30,140,0.07);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--body-bg);
            margin: 0;
            overflow-x: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            background-color: var(--primary-light);
            min-height: 100vh;
            color: white;
            padding: 20px 0;
            position: fixed;
            width: var(--sidebar-w);
            z-index: 1000;
        }

        .sidebar .nav-link {
            color: white;
            padding: 12px 25px;
            margin: 5px 15px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            transition: 0.3s;
            font-size: 14px;
            border: none;
            background: none;
            width: calc(100% - 30px);
            text-align: left;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.3);
            font-weight: bold;
        }

        .sidebar .nav-link i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        /* MAIN CONTENT */
        #main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            width: calc(100% - var(--sidebar-w));
        }

        .page-inner {
            padding: 30px;
        }

        .text-pink { color: var(--primary-light) !important; }

        @media (max-width: 991px) {
            .sidebar { width: 80px; }
            .sidebar .nav-link span, .sidebar .text-center span, .sidebar hr { display: none; }
            #main-content { margin-left: 80px; width: calc(100% - 80px); }
        }
    </style>

    @yield('styles')
</head>
<body>

{{-- SIDEBAR --}}
<div class="sidebar shadow">
    <div class="text-center mb-4">
        <img src="{{ asset('images/logobumiloo.png') }}" alt="Logo Bumiloo"
             style="max-height:70px;" class="rounded-circle mb-2 shadow-sm">
        <br>
        <span class="badge bg-white rounded-pill px-3 py-2 text-pink" 
              style="font-weight: 700; font-size: 12px;">
            Bumil
        </span>
    </div>
    <hr class="mx-3 text-white">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('bumil.dashboard') }}"
               class="nav-link {{ request()->routeIs('bumil.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> <span>Beranda</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-comments"></i> <span>Konsultasi</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-chart-line"></i> <span>Perkembangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-calendar-check"></i> <span>HPL</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-bell"></i> <span>Reminder</span>
            </a>
        </li>

        <hr class="mx-3">
<li class="nav-item">
    <form id="logout-form" method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="button" onclick="konfirmasiLogout()" class="nav-link logout-btn" style="background: none; border: none; cursor: pointer; width: 100%; text-align: left;">
            <i class="fas fa-sign-out-alt"></i> Keluar
        </button>
    </form>
</li>
</ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiLogout() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan keluar dari sesi aplikasi Bumiloo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F84F8F', // Warna Pink Fanta khas Bumiloo
            cancelButtonColor: '#94A3B8',  // Warna Abu-abu minimalis
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-[24px]' // Melengkung estetik mirip figma kalian
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika klik "Ya, Keluar!", form di atas akan di-submit otomatis oleh JavaScript
                document.getElementById('logout-form').submit();
            }
        })
    }
</script>

{{-- TOPBAR --}}
@include('partials.header')

{{-- MAIN CONTENT --}}
<main id="main-content">
    <div class="page-inner">
        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

@include('partials.footer')
</body>
</html>