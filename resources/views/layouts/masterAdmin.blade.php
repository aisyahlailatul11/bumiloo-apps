<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bumiloo - Dashboard Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
       body { font-family: 'Poppins', sans-serif; background-color: #fdf2f5; margin: 0; }
.sidebar { background-color: #f875aa; min-height: 100vh; color: white; padding: 20px 0; position: fixed; width: 250px; z-index: 100; }
.sidebar .nav-link { color: white; padding: 12px 25px; margin: 5px 15px; border-radius: 10px; display: flex; align-items: center; transition: 0.3s; }
.sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: rgba(255, 255, 255, 0.3); font-weight: bold; }
.sidebar .nav-link i { margin-right: 15px; width: 20px; }

/* Baris yang sudah diperbaiki jarak atasnya */
.main-content { margin-left: 250px; padding: 30px; padding-top: 100px !important; }

.text-pink { color: #f875aa; }
.logo-shadow { box-shadow: 0 4px 6px rgba(248,117,170,0.6); }
.logout-btn { background: none; border: none; color: white; width: 100%; text-align: left; }
/* === BACKGROUND UTAMA === */
body.dark-mode {
  background-color: #1a1a2e !important;
}

body.dark-mode .main-content {
  background-color: #1a1a2e !important;
  color: #e2e8f0 !important;
}

/* === HEADING & TEXT di main-content === */
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
body.dark-mode .main-content .text-pink {
  color: #f472b6 !important;
}

/* === CARD === */
body.dark-mode .main-content .card {
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

/* === STAT CARD ICON BACKGROUND === */
body.dark-mode .main-content .bg-success-subtle,
body.dark-mode .main-content .bg-primary-subtle,
body.dark-mode .main-content .bg-danger-subtle,
body.dark-mode .main-content .bg-warning-subtle,
body.dark-mode .main-content .bg-info-subtle {
  background-color: rgba(255,255,255,0.08) !important;
}

/* === TABLE === */
body.dark-mode .main-content .table {
  color: #e2e8f0 !important;
  border-color: #2e2e50 !important;
}
body.dark-mode .main-content .table thead th {
  background-color: #2a2a4a !important;
  color: #f1f5f9 !important;
  border-color: #3d3d65 !important;
}
body.dark-mode .main-content .table tbody td,
body.dark-mode .main-content .table tbody tr {
  border-color: #2e2e50 !important;
}
body.dark-mode .main-content .table-striped > tbody > tr:nth-of-type(odd) > * {
  background-color: rgba(255,255,255,0.04) !important;
  color: #e2e8f0 !important;
}
body.dark-mode .main-content .table-hover > tbody > tr:hover > * {
  background-color: rgba(248,117,170,0.08) !important;
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

/* === MODAL (muncul di atas main-content) === */
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

/* === DROPDOWN di main-content === */
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

/* === ALERT di main-content === */
body.dark-mode .main-content .alert {
  background-color: #2a2a4a !important;
  border-color: #3d3d65 !important;
  color: #e2e8f0 !important;
}

/* === PAGINATION di main-content === */
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
            <img src="{{ asset('images/Logo_bumiloo.png') }}" alt="Logo Bumiloo"
     style="max-height:120px; width:120px; object-fit:contain;" class="mb-2">
            <br>
            <span class="badge bg-white text-pink rounded-pill px-3">Super Admin</span>
        </div>
        <hr class="mx-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i> Beranda
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center"
                   data-bs-toggle="collapse" href="#masterDataMenu" role="button">
                    <span><i class="fas fa-folder"></i> Master Data</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse {{ Request::is('admin/master*') ? 'show' : '' }}" id="masterDataMenu">
                    <ul class="nav flex-column ms-4">
                        <li><a href="{{ route('master.pasien') }}" class="nav-link"><i class="fas fa-users"></i> Data Pasien</a></li>
                        <li><a href="{{ route('master.bidan') }}" class="nav-link"><i class="fas fa-user-nurse"></i> Data Bidan</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item"><a class="nav-link" href="{{ route('jadwal.index') }}"><i class="fas fa-calendar-alt"></i>Input Jadwal</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.edukasi') }}"><i class="fas fa-edit"></i> Input Edukasi</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.laporan') }}"><i class="fas fa-file-alt"></i> Laporan</a></li>

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
        icon: 'warning', // Tetap warning untuk ikon tanda seru
        iconColor: '#EF4444', // <--- INI KUNCI AGAR IKON JADI MERAH
        showCancelButton: true,
        // URUTAN TOMBOL DI SWEETALERT2:
        // Secara default, confirmButton di kanan, cancelButton di kiri.
        reverseButtons: true, // <--- INI AKAN MEMAKSA POSISI SESUAI KEINGINANMU
        confirmButtonColor: '#F84F8F', 
        cancelButtonColor: '#94A3B8',
        confirmButtonText: 'Ya, Keluar!',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-[24px]'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    })
}
</script>

    @include('partials.header')

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Fungsi untuk mengubah status tema saat tombol switch diklik
    function toggleDarkMode() {
        const body = document.body;
        const switchInput = document.getElementById('darkModeSwitch');
        
        if (switchInput.checked) {
            body.classList.add('dark-mode');
            localStorage.setItem('theme', 'dark'); // Menyimpan status agar tidak hilang saat refresh
        } else {
            body.classList.remove('dark-mode');
            localStorage.setItem('theme', 'light');
        }
    }

    // Fungsi otomatis untuk memeriksa tema setiap kali halaman dimuat / ganti halaman
    document.addEventListener("DOMContentLoaded", function() {
        const currentTheme = localStorage.getItem('theme');
        const switchInput = document.getElementById('darkModeSwitch');
        
        if (currentTheme === 'dark') {
            document.body.classList.add('dark-mode');
            if (switchInput) {
                switchInput.checked = true; // Menjaga posisi switch tetap ON
            }
        }
    });
</script>
@include('partials.alerts')
</body>
</html>