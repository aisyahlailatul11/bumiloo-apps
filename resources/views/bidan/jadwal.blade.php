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

    /* Penyesuaian Posisi Header ke Atas */
    .header-layout {
        margin-top: -12px;
        margin-bottom: 24px;
    }
    .header-layout h2 {
        font-size: 1.7rem;
        color: #1a1a1a;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    /* Ukuran Teks Angka & Ikon Statistik Ringkasan (Diperbesar) */
    .stat-number {
        font-size: 1.9rem !important;
        font-weight: 700;
        color: #212529;
        line-height: 1.2;
    }
    .stat-icon {
        font-size: 1.9rem !important; /* Ukuran ikon diperbesar sedikit */
    }

    /* Container Utama Pembungkus Jadwal & Timeline */
    .schedule-main-container {
        background-color: #ffffff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        border: 1px solid #eef1f6;
    }

    /* Badge Tanggal Dinamis Warna Biru */
    .badge-date-blue {
        background-color: #0d6efd;
        color: #ffffff;
        font-size: 0.85rem;
        font-weight: 600;
        padding: 6px 16px;
        border-radius: 30px;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.15);
    }

    /* Komponen Utama Garis Vertikal (Timeline) */
    .timeline-wrapper {
        position: relative;
        padding-left: 32px; /* Memberi ruang untuk garis dan lingkaran */
        margin-top: 20px;
    }
    
    /* Garis Vertikal Abu-abu */
    .timeline-wrapper::before {
        content: "";
        position: absolute;
        left: 7px;
        top: 15px;
        bottom: 15px;
        width: 3px;
        background-color: #e9ecef;
        border-radius: 2px;
    }

    /* Item Timeline untuk Memposisikan Lingkaran */
    .timeline-card-item {
        position: relative;
        margin-bottom: 16px;
    }
    .timeline-card-item:last-child {
        margin-bottom: 0;
    }

    /* Lingkaran Indikator yang Menempel pada Garis Vertikal */
    .timeline-card-item::before {
        content: "";
        position: absolute;
        left: -32px; /* Pas di tengah posisi garis vertikal */
        top: 26px;  /* Sejajar lurus dengan tengah card */
        width: 17px;
        height: 17px;
        border-radius: 50%;
        border: 3px solid #ffffff;
        box-shadow: 0 0 0 3px #0d6efd; /* Efek lingkaran ring warna biru */
        z-index: 2;
    }

    /* Warna Dinamis Lingkaran Berdasarkan Kategori */
    .timeline-circle-success::before { box-shadow: 0 0 0 3px #28a745; background-color: #28a745; }
    .timeline-circle-purple::before  { box-shadow: 0 0 0 3px #6b46c1; background-color: #6b46c1; }
    .timeline-circle-warning::before { box-shadow: 0 0 0 3px #ffc107; background-color: #ffc107; }

    /* Struktur Card Putih Jadwal di dalam Timeline */
    .jadwal-card-custom {
        border: 1px solid #eef1f6 !important;
        background-color: #ffffff;
        border-radius: 12px !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        transition: all 0.2s ease-in-out;
    }
    .jadwal-card-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05) !important;
        border-color: var(--pink-primary) !important;
    }

    /* Lingkaran Ikon Bulat Solid di Dalam Card */
    .icon-solid-circle {
        width: 46px;
        height: 46px;
        min-width: 46px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff !important;
    }
    .bg-solid-hari-ini   { background-color: #28a745; }
    .bg-solid-persalinan { background-color: #6b46c1; }
    .bg-solid-kontrol    { background-color: #ffc107; color: #212529 !important; }

    /* Badge Kotak Informasi Jam & Keterangan */
    .badge-info-box {
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

    /* Badge Status Terjadwal (Sekarang Warna Hijau Lebih Terang & Kelihatan) */
    .badge-status-pill-green {
        font-size: 0.8rem;
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: 700;
        display: inline-block;
        background-color: #28a745;
        color: #ffffff;
        box-shadow: 0 3px 8px rgba(40, 167, 69, 0.2);
    }
</style>

<div class="container-fluid py-4">
    
    <div class="header-layout d-flex justify-content-between align-items-center">
        <h2 class="fw-bold mb-0"><i class="text-danger me-2"></i>Jadwal Bidan</h2>
    </div>

    <div class="row g-3 mb-4">
        {{-- HARI INI --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="p-3 me-3 rounded-3" style="background-color:#d8f3dc; min-width: 60px; text-align: center;">
                        <i class="fas fa-calendar-alt stat-icon" style="color:#2d6a4f;"></i>
                    </div>
                    <div>
                        <p class="stat-number mb-0">{{ $countHariIni }}</p>
                        <h6 class="text-muted small fw-semibold mb-0">Jadwal Hari Ini</h6>
                    </div>
                </div>
            </div>
        </div>

        {{-- PERSALINAN --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="p-3 me-3 rounded-3" style="background-color:#e9d8fd; min-width: 60px; text-align: center;">
                        <i class="fas fa-baby stat-icon" style="color:#6b46c1;"></i>
                    </div>
                    <div>
                        <p class="stat-number mb-0">{{ $countPersalinan }}</p>
                        <h6 class="text-muted small fw-semibold mb-0">Jadwal Persalinan</h6>
                    </div>
                </div>
            </div>
        </div>

        {{-- KONTROL PEMERIKSAAN --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="p-3 me-3 rounded-3" style="background-color:#ffe5b4; min-width: 60px; text-align: center;">
                        <i class="fas fa-user-md stat-icon" style="color:#cc8400;"></i>
                    </div>
                    <div>
                        <p class="stat-number mb-0">{{ $countKontrol }}</p>
                        <h6 class="text-muted small fw-semibold mb-0">Pemeriksaan Kontrol</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="schedule-main-container">
        
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pb-3 border-bottom mb-2">
            <h5 class="fw-bold text-dark mb-0">
                <i class="fas fa-list-ul me-2 text-secondary"></i>Jadwal Bidan Hari Ini
            </h5>
            
            <div class="badge-date-blue">
                <i class="far fa-calendar-alt me-2"></i> Hari Ini: {{ \Carbon\Carbon::today()->locale('id')->translatedFormat('l, d F Y') }}
            </div>
        </div>

        @if($jadwalHariIniList->isEmpty())
            <div class="text-center p-5 text-muted">
                <i class="fas fa-calendar-times fa-2x mb-2 opacity-40"></i>
                <h6 class="fw-bold mb-0">Tidak ada jadwal untuk hari ini.</h6>
            </div>
        @else
            <div class="timeline-wrapper">
                @foreach($jadwalHariIniList as $jadwal)
                    @php
                        // Default set variabel tema
                        $bgSolidCircle = 'bg-solid-hari-ini';
                        $iconClass = 'fa-clock';
                        $circleTimelineColor = 'timeline-circle-success';

                        // Kondisi penentuan warna ring lini masa dan ikon di dalam card
                        if(Str::contains(strtolower($jadwal->keterangan), ['persalinan', 'melahirkan'])) {
                            $bgSolidCircle = 'bg-solid-persalinan';
                            $iconClass = 'fa-baby';
                            $circleTimelineColor = 'timeline-circle-purple';
                        } elseif(Str::contains(strtolower($jadwal->keterangan), ['kontrol'])) {
                            $bgSolidCircle = 'bg-solid-kontrol';
                            $iconClass = 'fa-user-md';
                            $circleTimelineColor = 'timeline-circle-warning';
                        }
                    @endphp

                    <div class="timeline-card-item {{ $circleTimelineColor }}">
                        <div class="card jadwal-card-custom border-0">
                            <div class="card-body p-3 d-flex align-items-center">
                                
                                <div class="me-3 d-none d-sm-flex icon-solid-circle {{ $bgSolidCircle }}">
                                    <i class="fas {{ $iconClass }}"></i>
                                </div>

                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                        Pasien: {{ $jadwal->nama_pasien }}
                                    </h6>
                                    
                                    <div class="d-flex flex-wrap gap-2 align-items-center mt-2">
                                        <span class="badge-info-box">
                                            <i class="far fa-clock text-primary me-1"></i> {{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }} WIB
                                        </span>
                                        <span class="badge-info-box" style="background-color: #f8f9fa;">
                                            <i class="fas fa-clipboard-list text-muted me-1"></i> {{ $jadwal->keterangan }}
                                        </span>
                                    </div>
                                </div>

                                <div class="text-end ms-2">
                                    <span class="badge-status-pill-green">
                                        Terjadwal
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div> @endif
    </div> </div>
@endsection