@extends('layouts.masterBidan')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<style>
    /* Tema Warna Kebidanan Modern */
    :root {
        --pink-primary: #f875aa;
        --pink-dark: #d95388;
        --pink-light: #fdf0f5;
    }

    /* Penyesuaian Tata Letak Header: Naik ke Atas & Lebih Bersih */
    .header-layout {
        margin-top: -12px; /* Menarik posisi judul agak ke atas */
        margin-bottom: 24px;
    }
    .header-layout h3 {
        font-size: 1.65rem;
        color: #1a1a1a;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    /* Card Putih Pasien Terpisah (Sesuai Struktur Awalmu yang Dipercantik) */
    .pasien-card-custom {
        cursor: pointer; 
        transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: 1px solid #eef1f6 !important;
        background-color: #ffffff;
        margin-bottom: 14px; /* Jarak antar card putih */
    }
    .pasien-card-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05) !important;
        border-color: var(--pink-primary) !important;
    }
    .pasien-card-custom:hover .arrow-icon {
        color: var(--pink-primary) !important;
        transform: translateX(3px);
    }

    /* Lingkaran Ikon Bulat Berwarna Solid Terang (Bukan Pastel) */
    .icon-solid-circle {
        width: 50px;
        height: 50px;
        min-width: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
    }
    .bg-solid-success { background-color: #28a745; }
    .bg-solid-warning { background-color: #ffc107; color: #212529 !important; }
    .bg-solid-info    { background-color: #17a2b8; }
    .bg-solid-primary { background-color: var(--pink-primary); }

    /* Desain Sistem Badge Keterangan & Jam Kotak Minimalis */
    .badge-item-custom {
        font-size: 0.8rem;
        padding: 5px 12px;
        border-radius: 6px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        background-color: #f1f3f5;
        color: #495057;
        border: 1px solid #e3e6ea;
    }
    
    /* Badge Kategori Kanan */
    .badge-kategori-pill {
        font-size: 0.8rem;
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: 600;
        display: inline-block;
    }
    .bg-pastel-success { background: rgba(40,167,69,0.12); color: #28a745; }
    .bg-pastel-warning { background: rgba(255,193,7,0.15); color: #856404; }
    .bg-pastel-info    { background: rgba(23,162,184,0.12); color: #17a2b8; }
    .bg-pastel-primary { background: rgba(248,117,170,0.15); color: var(--pink-dark); }

    /* Badge Status Notifikasi "Sudah Diperiksa" */
    .badge-status-periksa {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        display: inline-flex;
        align-items: center;
    }

    .arrow-icon {
        transition: all 0.2s ease;
    }
</style>

<div class="container-fluid py-4">
    
    <div class="header-layout row align-items-center">
        <div class="col-md-7 mb-2 mb-md-0">
            <h3 class="mb-1"><i class="text-danger me-2"></i>Daftar Pasien Hari Ini</h3>
            <p class="text-muted small mb-0">
                <i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
            </p>
        </div>
        <div class="col-md-5 text-md-end">
            <span class="badge-item-custom bg-white shadow-sm px-3 py-2 text-dark" style="border-radius: 10px;">
                <i class="fas fa-users text-muted me-2"></i>Total Antrean: <strong class="ms-1 text-dark" style="font-size: 0.95rem;">{{ $pasienList->count() }} Pasien</strong>
            </span>
        </div>
    </div>

    @include('partials.alerts')

    @if($pasienList->isEmpty())
        <div class="card shadow-sm border-0 text-center p-5 rounded-4 bg-white">
            <div class="card-body">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                     style="width: 80px; height: 80px; background: var(--pink-light); color: var(--pink-primary);">
                    <i class="fas fa-calendar-check fa-2x"></i>
                </div>
                <h5 class="fw-bold text-dark">Tidak Ada Pasien Terjadwal</h5>
                <p class="text-muted mb-0 mx-auto" style="max-width: 400px;">Semua jadwal pemeriksaan atau kunjungan untuk hari ini masih kosong atau telah diselesaikan.</p>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($pasienList as $pasien)
                @php
                    // Set default warna untuk ikon solid & badge pembantu
                    $bgSolidCircle = 'bg-solid-primary';
                    $iconClass = 'fa-user-circle';
                    $badgeClass = 'bg-pastel-primary';

                    // Klasifikasi warna visual dinamis berdasarkan string kategori
                    if(Str::contains(strtolower($pasien->kategori), 'pemeriksaan')) {
                        $bgSolidCircle = 'bg-solid-success';
                        $iconClass = 'fa-stethoscope';
                        $badgeClass = 'bg-pastel-success';
                    } elseif(Str::contains(strtolower($pasien->kategori), 'kontrol')) {
                        $bgSolidCircle = 'bg-solid-warning';
                        $iconClass = 'fa-notes-medical';
                        $badgeClass = 'bg-pastel-warning';
                    } elseif(Str::contains(strtolower($pasien->kategori), 'imunisasi')) {
                        $bgSolidCircle = 'bg-solid-info';
                        $iconClass = 'fa-syringe';
                        $badgeClass = 'bg-pastel-info';
                    }
                    
                    // Otomatis cek status pemeriksaan dari database
                    $isDiperiksa = isset($pasien->status) && (strtolower($pasien->status) == 'selesai' || strtolower($pasien->status) == 'diperiksa');
                @endphp

                <div class="col-12">
                    <div class="card pasien-card-custom shadow-sm rounded-4 border-0" 
                         onclick="window.location='{{ route('bidan.inputDaftarPasien', $pasien->id) }}'">
                        <div class="card-body p-3 d-flex align-items-center">
                            
                            <div class="me-3 d-none d-sm-flex icon-solid-circle {{ $bgSolidCircle }}">
                                <i class="fas {{ $iconClass }} fa-lg"></i>
                            </div>

                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                    <h5 class="fw-bold text-dark mb-0" style="letter-spacing: -0.3px; font-size: 1.1rem;">{{ $pasien->nama_pasien }}</h5>
                                    
                                    @if($isDiperiksa)
                                        <span class="badge-status-periksa">
                                            <i class="fas fa-check-circle me-1"></i> Sudah Diperiksa
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="d-flex flex-wrap gap-2 align-items-center mt-2">
                                    <span class="badge-item-custom" style="padding: 3px 8px; font-size: 0.75rem;">
                                        <i class="far fa-clock text-primary me-1"></i> {{ \Carbon\Carbon::parse($pasien->jam)->format('H:i') }} WIB
                                    </span>
                                    <span class="badge-item-custom" style="padding: 3px 8px; font-size: 0.75rem; background-color: #f8f9fa;">
                                        <i class="fas fa-clipboard-list me-1 text-muted"></i> Ket: {{ $pasien->keterangan ?? '-' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="text-end d-flex align-items-center gap-3 ms-2">
                                <div class="d-none d-sm-block">
                                    <span class="badge-kategori-pill {{ $badgeClass }}">
                                        {{ $pasien->kategori }}
                                    </span>
                                </div>
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-light transition-all" style="width: 35px; height: 35px;">
                                    <i class="fas fa-chevron-right text-muted small arrow-icon"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection