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
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #fdf2f5;
        margin: 0;
    }

    .sidebar {
        background-color: #f687b3;
        min-height: 100vh;
        color: white;
        padding: 20px 0;
        position: fixed;
        width: 250px;
        z-index: 100;
    }

    .sidebar .nav-link {
        color: white;
        padding: 12px 25px;
        margin: 5px 15px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        transition: 0.3s;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: rgba(255, 255, 255, 0.3);
        font-weight: bold;
    }

    .sidebar .nav-link i {
        margin-right: 15px;
        width: 20px;
    }

    .main-content {
        margin-left: 250px;
        padding: 30px;
    }

    .text-pink {
        color: #f687b3;
    }

    .logout-btn {
        background: none;
        border: none;
        color: white;
        width: 100%;
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="sidebar shadow">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logobumiloo.png') }}" alt="Logo Bumiloo" style="max-height:75px;"
                class="rounded-circle mb-2 bg-white p-1">
            <br>
            <span class="badge bg-white text-pink rounded-pill px-3">Bidan</span>
        </div>
        <hr class="mx-3">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ Request::is('bidan/dashboard') ? 'active' : '' }}"
                    href="{{ route('bidan.dashboard') }}"><i class="fas fa-home"></i> Beranda</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('bidan/konsultasi*') ? 'active' : '' }}"
                    href="{{ route('bidan.konsultasi') }}"><i class="fas fa-comment"></i> Konsultasi</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('bidan/input-data') ? 'active' : '' }}"
                    href="{{ route('bidan.inputDaftarPasien') }}"><i class="fas fa-user-plus"></i> Input Pasien</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('bidan/jadwal-kegiatan') ? 'active' : '' }}"
                    href="{{ route('bidan.jadwal') }}"><i class="fas fa-calendar-alt"></i> Jadwal</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('bidan/laporan*') ? 'active' : '' }}"
                    href="{{ route('bidan.laporan') }}"><i class="fa fa-file-alt"></i> Laporan</a></li>

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function konfirmasiLogout() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan keluar dari sesi aplikasi Bumiloo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F84F8F', // Warna Pink Fanta khas Bumiloo
            cancelButtonColor: '#94A3B8', // Warna Abu-abu minimalis
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
</body>

</html>