<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bumiloo - Dashboard Bidan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
body { font-family: 'Poppins', sans-serif; background-color: #fdf2f5; margin: 0; }
.sidebar { background-color: #f687b3; min-height: 100vh; color: white; padding: 20px 0; position: fixed; width: 250px; z-index: 100; }
.sidebar .nav-link { color: white; padding: 12px 25px; margin: 5px 15px; border-radius: 10px; display: flex; align-items: center; transition: 0.3s; }
.sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: rgba(255, 255, 255, 0.3); font-weight: bold; }
.sidebar .nav-link i { margin-right: 15px; width: 20px; }

/* Di sini letak perubahannya, padding-top digabung langsung ke .main-content */
.main-content { margin-left: 250px; padding: 30px; padding-top: 100px !important; }

.text-pink { color: #f687b3; }
.logout-btn { background: none; border: none; color: white; width: 100%; text-align: left; }
/* =========================================
   DARK MODE - Bidan
   Semua selector pakai .main-content
   ========================================= */

body.dark-mode {
  background-color: #1a1a2e !important;
}
body.dark-mode .main-content {
  background-color: #1a1a2e !important;
  color: #e2e8f0 !important;
}

/* === HEADING === */
body.dark-mode .main-content h1,
body.dark-mode .main-content h2,
body.dark-mode .main-content h3,
body.dark-mode .main-content h4,
body.dark-mode .main-content h5,
body.dark-mode .main-content h6 {
  color: #f1f5f9 !important;
}
body.dark-mode .main-content p,
body.dark-mode .main-content span,
body.dark-mode .main-content label,
body.dark-mode .main-content small {
  color: #cbd5e1 !important;
}
body.dark-mode .main-content .text-muted {
  color: #94a3b8 !important;
}
body.dark-mode .main-content .text-dark {
  color: #f1f5f9 !important;
}
body.dark-mode .main-content .text-pink {
  color: #f472b6 !important;
}

/* === CARD (.card & .card-custom) === */
body.dark-mode .main-content .card,
body.dark-mode .main-content .card-custom {
  background-color: #252545 !important;
  border: 1px solid #2e2e50 !important;
  color: #e2e8f0 !important;
}
body.dark-mode .main-content .card-header {
  background-color: #2a2a4a !important;
  border-bottom-color: #2e2e50 !important;
  color: #f1f5f9 !important;
}
body.dark-mode .main-content .card-body,
body.dark-mode .main-content .card-footer {
  background-color: #252545 !important;
  color: #e2e8f0 !important;
}

/* === bg-white hardcoded === */
body.dark-mode .main-content .bg-white {
  background-color: #252545 !important;
}

/* === STAT CARD ICON === */
body.dark-mode .main-content .bg-success-subtle,
body.dark-mode .main-content .bg-primary-subtle,
body.dark-mode .main-content .bg-danger-subtle,
body.dark-mode .main-content .bg-warning-subtle,
body.dark-mode .main-content .bg-info-subtle,
body.dark-mode .main-content .bg-success.bg-opacity-10,
body.dark-mode .main-content .bg-primary.bg-opacity-10,
body.dark-mode .main-content .bg-danger.bg-opacity-10 {
  background-color: rgba(255,255,255,0.08) !important;
}

/* === TABEL === */
body.dark-mode .main-content .table,
body.dark-mode .main-content .table-borderless {
  color: #e2e8f0 !important;
}
body.dark-mode .main-content .table td,
body.dark-mode .main-content .table tr,
body.dark-mode .main-content .table-borderless td,
body.dark-mode .main-content .table-borderless tr {
  background-color: transparent !important;
  color: #e2e8f0 !important;
  border-color: #2e2e50 !important;
}
body.dark-mode .main-content .table thead th {
  background-color: #2a2a4a !important;
  color: #f1f5f9 !important;
  border-color: #3d3d65 !important;
}

/* === NOTIF BOX (bg-pink-light) === */
body.dark-mode .main-content .bg-pink-light {
  background-color: rgba(248,117,170,0.1) !important;
  border-color: rgba(248,117,170,0.3) !important;
}

/* === bg-light (avatar) === */
body.dark-mode .main-content .bg-light {
  background-color: #2a2a4a !important;
  color: #e2e8f0 !important;
}

/* === FORM INPUT === */
body.dark-mode .main-content .form-control,
body.dark-mode .main-content .form-select {
  background-color: #2a2a4a !important;
  border-color: #3d3d65 !important;
  color: #e2e8f0 !important;
}
body.dark-mode .main-content .form-control::placeholder {
  color: #64748b !important;
}
body.dark-mode .main-content .form-control:focus,
body.dark-mode .main-content .form-select:focus {
  background-color: #2a2a4a !important;
  border-color: #f875aa !important;
  box-shadow: 0 0 0 3px rgba(248,117,170,0.2) !important;
  color: #e2e8f0 !important;
}
body.dark-mode .main-content .input-group-text {
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
body.dark-mode .main-content .dropdown-menu {
  background-color: #252545 !important;
  border-color: #3d3d65 !important;
}
body.dark-mode .main-content .dropdown-item {
  color: #e2e8f0 !important;
}
body.dark-mode .main-content .dropdown-item:hover {
  background-color: rgba(248,117,170,0.12) !important;
  color: #f472b6 !important;
}

/* === ALERT === */
body.dark-mode .main-content .alert {
  background-color: #2a2a4a !important;
  border-color: #3d3d65 !important;
  color: #e2e8f0 !important;
}

/* === PAGINATION === */
body.dark-mode .main-content .page-link {
  background-color: #252545 !important;
  border-color: #3d3d65 !important;
  color: #e2e8f0 !important;
}
body.dark-mode .main-content .page-item.active .page-link {
  background-color: #f875aa !important;
  border-color: #f875aa !important;
}

/* === SCROLLBAR === */
body.dark-mode ::-webkit-scrollbar { width: 6px; }
body.dark-mode ::-webkit-scrollbar-track { background: #1a1a2e; }
body.dark-mode ::-webkit-scrollbar-thumb {
  background: #3d3d65;
  border-radius: 4px;
}
body.dark-mode ::-webkit-scrollbar-thumb:hover {
  background: #f875aa;
}
</style>
</head>

<body>
    <div class="sidebar shadow">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logobumiloo.png') }}" alt="Logo Bumiloo"
     style="max-height:120px; width:120px; object-fit:contain;" class="mb-2">
            <br>
            <span class="badge bg-white text-pink rounded-pill px-3">Bidan</span>
        </div>
        <hr class="mx-3">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ Request::is('bidan/dashboard') ? 'active' : '' }}" href="{{ route('bidan.dashboard') }}"><i class="fas fa-home"></i> Beranda</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('bidan/konsultasi*') ? 'active' : '' }}" href="{{ route('bidan.konsultasi') }}"><i class="fas fa-comment"></i> Konsultasi</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('bidan/daftar-pasien') ? 'active' : '' }}" href="{{ route('bidan.daftarPasien') }}"><i class="fas fa-user-plus"></i> Input Perkembangan</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('bidan/jadwal-kegiatan') ? 'active' : '' }}" href="{{ route('bidan.jadwal') }}"><i class="fas fa-calendar-alt"></i> Jadwal</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('bidan/laporan*') ? 'active' : '' }}" href="{{ route('bidan.laporan') }}"><i class="fa fa-file-alt"></i> Laporan</a></li>
            
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
        order: 2 !important; /* Memastikan posisi tombol */
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
    @include('partials.header')

    <div class="main-content">
        @yield('content')
    </div>

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
@include('partials.alerts')
</body>
</html>