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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    :root {
        --primary: #E91E8C;
        --primary-light: #F875AA;
        --primary-pale: #FCE4EC;
        --body-bg: #fdf2f5;
        --sidebar-w: 250px;
        --text-main: #1A1A2E;
        --radius-card: 20px;
        --shadow-card: 0 2px 16px rgba(233, 30, 140, 0.07);
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

    /* MAIN CONTENT (SUDAH DIPERBAIKI) */
    #main-content {
        margin-left: var(--sidebar-w);
        min-height: 100vh;
        width: calc(100% - var(--sidebar-w));
        padding-top: 50px !important;
        /* Jarak aman agar konten turun di bawah navbar fixed */
    }

    .page-inner {
        padding: 30px;
    }

    .text-pink {
        color: var(--primary-light) !important;
    }

    /* RESPONSIVE LAYOUT */
    @media (max-width: 991px) {
        .sidebar {
            width: 80px;
        }

        .sidebar .nav-link span,
        .sidebar .text-center span,
        .sidebar hr {
            display: none;
        }

        #main-content {
            margin-left: 80px;
            width: calc(100% - 80px);
            padding-top: 100px !important;
            /* Jarak aman versi HP/Tablet agar tetap sinkron */
        }
    }

    /* =========================================
   DARK MODE - Pasien / Bumil
   Selector disesuaikan: #main-content & .page-inner
   Sidebar & navbar tidak berubah
   ========================================= */

    /* === BACKGROUND UTAMA === */
    body.dark-mode {
        background-color: #1a1a2e !important;
    }

    body.dark-mode #main-content {
        background-color: #1a1a2e !important;
        color: #e2e8f0 !important;
    }

    body.dark-mode .page-inner {
        background-color: #1a1a2e !important;
    }

    /* === HEADING & TEXT === */
    body.dark-mode #main-content h1,
    body.dark-mode #main-content h2,
    body.dark-mode #main-content h3,
    body.dark-mode #main-content h4,
    body.dark-mode #main-content h5,
    body.dark-mode #main-content h6 {
        color: #f1f5f9 !important;
    }

    body.dark-mode #main-content p,
    body.dark-mode #main-content span,
    body.dark-mode #main-content label,
    body.dark-mode #main-content small {
        color: #cbd5e1 !important;
    }

    body.dark-mode #main-content .text-muted {
        color: #94a3b8 !important;
    }

    body.dark-mode #main-content .text-pink {
        color: #f472b6 !important;
    }

    /* === CARD === */
    body.dark-mode #main-content .card {
        background-color: #252545 !important;
        border: 1px solid #2e2e50 !important;
        color: #e2e8f0 !important;
    }

    body.dark-mode #main-content .card-header {
        background-color: #2a2a4a !important;
        border-bottom-color: #2e2e50 !important;
        color: #f1f5f9 !important;
    }

    body.dark-mode #main-content .card-body,
    body.dark-mode #main-content .card-footer {
        background-color: #252545 !important;
        color: #e2e8f0 !important;
    }

    /* === HERO / BANNER SECTION (banner gelap di halaman bumil) === */
    body.dark-mode #main-content [class*="hero"],
    body.dark-mode #main-content [class*="banner"],
    body.dark-mode #main-content [class*="jumbotron"] {
        background-color: #1e1e38 !important;
        color: #e2e8f0 !important;
    }

    /* === ARTIKEL / LIST ITEM === */
    body.dark-mode #main-content .list-group-item,
    body.dark-mode #main-content [class*="artikel"],
    body.dark-mode #main-content [class*="article"] {
        background-color: #252545 !important;
        border-color: #2e2e50 !important;
        color: #e2e8f0 !important;
    }

    /* === STAT CARD ICON BACKGROUND === */
    body.dark-mode #main-content .bg-success-subtle,
    body.dark-mode #main-content .bg-primary-subtle,
    body.dark-mode #main-content .bg-danger-subtle,
    body.dark-mode #main-content .bg-warning-subtle,
    body.dark-mode #main-content .bg-info-subtle {
        background-color: rgba(255, 255, 255, 0.08) !important;
    }

    /* === TABLE === */
    body.dark-mode #main-content .table {
        color: #e2e8f0 !important;
        border-color: #2e2e50 !important;
    }

    body.dark-mode #main-content .table thead th {
        background-color: #2a2a4a !important;
        color: #f1f5f9 !important;
        border-color: #3d3d65 !important;
    }

    body.dark-mode #main-content .table tbody td,
    body.dark-mode #main-content .table tbody tr {
        border-color: #2e2e50 !important;
    }

    body.dark-mode #main-content .table-striped>tbody>tr:nth-of-type(odd)>* {
        background-color: rgba(255, 255, 255, 0.04) !important;
        color: #e2e8f0 !important;
    }

    body.dark-mode #main-content .table-hover>tbody>tr:hover>* {
        background-color: rgba(248, 117, 170, 0.08) !important;
    }

    /* === FORM INPUT === */
    body.dark-mode #main-content .form-control,
    body.dark-mode #main-content .form-select {
        background-color: #2a2a4a !important;
        border-color: #3d3d65 !important;
        color: #e2e8f0 !important;
    }

    body.dark-mode #main-content .form-control::placeholder {
        color: #64748b !important;
    }

    body.dark-mode #main-content .form-control:focus,
    body.dark-mode #main-content .form-select:focus {
        background-color: #2a2a4a !important;
        border-color: #f875aa !important;
        box-shadow: 0 0 0 3px rgba(248, 117, 170, 0.2) !important;
        color: #e2e8f0 !important;
    }

    body.dark-mode #main-content .input-group-text {
        background-color: #2e2e50 !important;
        border-color: #3d3d65 !important;
        color: #94a3b8 !important;
    }

    /* === MODAL === */
    body.dark-mode .modal-content {
        background-color: #252545 !important;
        border-color: #2e2e50 !important;
        color: #e2e8f0 !important;
    }

    body.dark-mode .modal-header,
    body.dark-mode .modal-footer {
        border-color: #2e2e50 !important;
    }

    body.dark-mode .modal-title {
        color: #f1f5f9 !important;
    }

    body.dark-mode .btn-close {
        filter: invert(1);
    }

    /* === DROPDOWN === */
    body.dark-mode #main-content .dropdown-menu {
        background-color: #252545 !important;
        border-color: #3d3d65 !important;
    }

    body.dark-mode #main-content .dropdown-item {
        color: #e2e8f0 !important;
    }

    body.dark-mode #main-content .dropdown-item:hover {
        background-color: rgba(248, 117, 170, 0.12) !important;
        color: #f472b6 !important;
    }

    /* === ALERT === */
    body.dark-mode #main-content .alert {
        background-color: #2a2a4a !important;
        border-color: #3d3d65 !important;
        color: #e2e8f0 !important;
    }

    /* === PAGINATION === */
    body.dark-mode #main-content .page-link {
        background-color: #252545 !important;
        border-color: #3d3d65 !important;
        color: #e2e8f0 !important;
    }

    body.dark-mode #main-content .page-item.active .page-link {
        background-color: #f875aa !important;
        border-color: #f875aa !important;
    }

    /* === SCROLLBAR === */
    body.dark-mode ::-webkit-scrollbar {
        width: 6px;
    }

    body.dark-mode ::-webkit-scrollbar-track {
        background: #1a1a2e;
    }

    body.dark-mode ::-webkit-scrollbar-thumb {
        background: #3d3d65;
        border-radius: 4px;
    }

    body.dark-mode ::-webkit-scrollbar-thumb:hover {
        background: #f875aa;
    }

    /* =========================================
   TAMBAHAN DARK MODE - Dashboard Bumil
   Fix: .rc-card, .artikel-card, .popular-*
   ========================================= */

    /* === CARD KANAN: Artikel Terpopuler & Kategori Populer === */
    body.dark-mode .rc-card {
        background-color: #252545 !important;
        border: 1px solid #2e2e50 !important;
    }

    body.dark-mode .rc-card-title {
        color: #f472b6 !important;
    }

    body.dark-mode .rc-card-header .link-semua {
        color: #f472b6 !important;
    }

    /* === ARTIKEL POPULER ITEM === */
    body.dark-mode .popular-title {
        color: #f1f5f9 !important;
    }

    body.dark-mode .popular-time {
        color: #94a3b8 !important;
    }

    body.dark-mode .popular-rank .badge {
        background-color: #2a2a4a !important;
        color: #e2e8f0 !important;
    }

    /* === ARTIKEL CARD KIRI (daftar artikel) === */
    body.dark-mode .artikel-card {
        background-color: #252545 !important;
        border: 1px solid #2e2e50 !important;
    }

    body.dark-mode .artikel-title {
        color: #f1f5f9 !important;
    }

    body.dark-mode .artikel-desc {
        color: #94a3b8 !important;
    }

    /* === SECTION HEADING (Daftar Artikel) === */
    body.dark-mode .section-heading {
        color: #f1f5f9 !important;
    }

    /* === bg-white hardcoded di dalam #main-content === */
    body.dark-mode #main-content .bg-white {
        background-color: #252545 !important;
    }

    /* === text-dark hardcoded (judul artikel, rank) === */
    body.dark-mode #main-content .text-dark {
        color: #f1f5f9 !important;
    }

    /* === Kategori tag badge bg-light === */
    body.dark-mode #main-content .badge.bg-light {
        background-color: #2a2a4a !important;
        color: #e2e8f0 !important;
    }
    </style>

    @yield('styles')
</head>

<body>
    {{-- SIDEBAR --}}
    <div class="sidebar shadow">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logobumiloo.png') }}" alt="Logo Bumiloo" style="max-height:70px;"
                class="rounded-circle mb-2 shadow-sm">
            <br>
            <span class="badge bg-white rounded-pill px-3 py-2 text-pink" style="font-weight: 700; font-size: 12px;">
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
                <a href="{{ route('bumil.konsultasi') }}" class="nav-link">
                    <i class="fas fa-comments"></i>
                    <span>Konsultasi</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bumil.riwayatPerkembangan') }}"
                    class="nav-link {{ request()->routeIs('bumil.riwayatPerkembangan') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> <span>Perkembangan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bumil.hpl') }}"
                    class="nav-link {{ request()->routeIs('bumil.hpl') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> <span>HPL</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('bumil.reminder') }}"
                    class="nav-link {{ request()->routeIs('bumil.reminder') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i> <span>Reminder</span>
                </a>
            </li>

            <hr class="mx-3">
            <li class="nav-item">
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="button" onclick="konfirmasiLogout()" class="nav-link logout-btn"
                        style="background: none; border: none; cursor: pointer; width: 100%; text-align: left;">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <script>
    function konfirmasiLogout() {
        Swal.fire({
            title: 'Keluar sesi?',
            text: 'Anda akan keluar dari aplikasi.',
            icon: 'question',
            width: '320px',
            padding: '24px',
            showCancelButton: true,
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            buttonsStyling: false // PENTING: Matikan styling bawaan
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
    </script>

    <style>
    /* 1. Paksa bentuk persegi dan ukuran */
    .swal2-container .swal2-popup {
        border-radius: 20px !important;
        width: 320px !important;
        display: flex !important;
        flex-direction: column !important;
    }

    /* 2. Tombol jadi rata samping (row), bukan menumpuk */
    .swal2-actions {
        display: flex !important;
        flex-direction: row !important;
        gap: 12px !important;
        width: 100% !important;
        justify-content: center !important;
    }

    /* 3. Styling tombol solid (PENTING: Gunakan class default swal2) */
    .swal2-confirm {
        background-color: #F84F8F !important;
        color: #ffffff !important;
        border: none !important;
        padding: 10px 20px !important;
        border-radius: 8px !important;
        font-weight: 700 !important;
        font-size: 14px !important;
        order: 2 !important;
        /* Memastikan posisi tombol */
    }

    .swal2-cancel {
        background-color: #e2e8f0 !important;
        color: #475569 !important;
        border: none !important;
        padding: 10px 20px !important;
        border-radius: 8px !important;
        font-weight: 700 !important;
        font-size: 14px !important;
        order: 1 !important;
    }
    </style>
    @include('partials.alerts'){{-- TOPBAR --}}
    @include('partials.header')

    {{-- MAIN CONTENT --}}
    <main id="main-content">
        <div class="page-inner">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
    <script>
    // Fungsi untuk menyalakan/mematikan dark mode saat tombol diklik
    function toggleDarkMode() {
        const body = document.body;
        const switchInput = document.getElementById('darkModeSwitch');

        if (switchInput.checked) {
            body.classList.add('dark-mode');
            localStorage.setItem('theme', 'dark'); // Menyimpan pilihan user agar tidak hilang saat di-refresh
        } else {
            body.classList.remove('dark-mode');
            localStorage.setItem('theme', 'light');
        }
    }

    // Fungsi untuk mengecek status dark mode saat halaman pertama kali dimuat (menghindari reset saat ganti halaman)
    document.addEventListener("DOMContentLoaded", function() {
        const currentTheme = localStorage.getItem('theme');
        const switchInput = document.getElementById('darkModeSwitch');

        if (currentTheme === 'dark') {
            document.body.classList.add('dark-mode');
            if (switchInput) {
                switchInput.checked = true; // Menjaga tombol toggle tetap dalam posisi ON
            }
        }
    });
    </script>
</body>

</html>