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
        .main-content { margin-left: 250px; padding: 30px; }
        .text-pink { color: #f875aa; }
        .logo-shadow { box-shadow: 0 4px 6px rgba(248,117,170,0.6); }
        .logout-btn { background: none; border: none; color: white; width: 100%; text-align: left; }
    </style>
</head>

<body>
    <div class="sidebar shadow">
        <div class="text-center mb-4">
            <img src="{{ asset('images/Logo_bumiloo.png') }}" alt="Logo Bumiloo"
                 style="max-height:75px;" class="logo-shadow rounded-circle mb-2 bg-white">
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

            <li class="nav-item"><a class="nav-link" href="{{ route('jadwal.index') }}"><i class="fas fa-calendar-alt"></i> Jadwal</a></li>
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

    @include('partials.header')

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>