@extends('layouts.masterBidan')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Bumiloo Dashboard</h2>
    </div>

    {{-- CARD RINGKASAN --}}
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card card-custom p-4 border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-success bg-opacity-10 rounded-4 me-3 text-success">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0">{{ $janjiHariIni ?? 0 }}</h2>
                        <small class="text-muted">Janji Hari Ini</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card card-custom p-4 border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-primary bg-opacity-10 rounded-4 me-3 text-primary">
                        <i class="fas fa-stethoscope fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0">{{ $pemeriksaanBulanIni ?? 0 }}</h2>
                        <small class="text-muted">Pemeriksaan Bulan Ini</small>
                    </div>
                </div>
            </div>
        </div>
    </div> {{-- PENUTUP ROW RINGKASAN YANG TADI HILANG --}}


    {{-- ISI DASHBOARD --}}
    <div class="row">

        {{-- JADWAL HARI INI (KIRI) --}}
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Janji Pemeriksaan Hari Ini</h5>
                        <small class="text-muted">
                            Jadwal pemeriksaan berdasarkan tabel jadwals
                        </small>
                    </div>

                    <span class="badge rounded-pill bg-pink-light text-pink px-3 py-2">
                        {{ $janjiHariIni ?? 0 }} Jadwal
                    </span>
                </div>

                @forelse ($jadwalHariIni ?? [] as $jadwal)
                    <div class="appointment-card mb-3">
                        <div class="appointment-time">
                            <i class="fas fa-clock"></i>
                            <strong>
                                {{ \Carbon\Carbon::parse($jadwal->jam ?? now())->format('H:i') }}
                            </strong>
                        </div>

                        <div class="appointment-avatar">
                            {{ strtoupper(substr($jadwal->nama_pasien ?? 'P', 0, 2)) }}
                        </div>

                        <div class="appointment-info">
                            <h6 class="fw-bold mb-1">
                                {{ $jadwal->nama_pasien ?? 'Nama pasien' }}
                            </h6>
                            <small class="text-muted d-block">
                                <i class="fas fa-notes-medical me-1 text-pink"></i>
                                {{ $jadwal->keterangan ?? 'Pemeriksaan Kehamilan' }}
                            </small>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 mb-3">
                        <div class="empty-icon mb-3">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <h6 class="fw-bold mb-1">Belum ada jadwal hari ini</h6>
                        <p class="text-muted small mb-0">
                            Jadwal akan muncul setelah admin membuat jadwal pemeriksaan.
                        </p>
                    </div>
                @endforelse

                <div class="mt-auto p-3 rounded-4 bg-pink-light border border-pink d-flex align-items-center mb-3">
                    <i class="fas fa-circle-info text-pink me-3 fs-4"></i>
                    <p class="mb-0 small">
                        Pastikan pasien datang sesuai jam pemeriksaan dan membawa identitas diri.
                    </p>
                </div>

            </div>
        </div>

        {{-- CHART (KANAN) --}}
        <div class="col-md-6 mb-3">
            <div class="card card-custom p-4 border-0 shadow-sm mb-3">
                <h6 class="fw-bold mb-3">Jumlah Ibu Hamil per Trimester</h6>
                <div style="height: 200px;">
                    <canvas id="trimesterChart"></canvas>
                </div>
            </div>

            <div class="card card-custom p-4 border-0 shadow-sm mb-3">
                <h6 class="fw-bold mb-3">Jumlah Kunjungan Per Bulan</h6>
                <div style="height: 150px;">
                    <canvas id="kunjunganChart"></canvas>
                </div>
            </div>
        </div>

    </div> {{-- PENUTUP ROW ISI DASHBOARD --}}
</div>
@endsection

<style>
    .appointment-card {
        display: grid;
        grid-template-columns: 80px 58px minmax(0, 1fr);
        gap: 14px;
        align-items: center;
        width: 100%;
        padding: 16px;
        border-radius: 22px;
        background: linear-gradient(135deg, #fff7fb, #ffffff);
        border: 1px solid rgba(248, 117, 170, 0.25);
        transition: 0.25s;
        overflow: hidden;
    }

    .appointment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(248, 117, 170, 0.18);
    }

    .appointment-time {
        background: rgba(248, 117, 170, 0.12);
        color: #f875aa;
        border-radius: 18px;
        padding: 12px 8px;
        text-align: center;
        font-weight: 700;
    }

    .appointment-time i {
        display: block;
        font-size: 17px;
        margin-bottom: 4px;
    }

    .appointment-avatar {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f875aa, #ffb3c6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 18px;
        flex-shrink: 0;
    }

    .appointment-info {
        min-width: 0;
    }

    .appointment-info h6,
    .appointment-info small {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .bg-pink-light {
        background-color: rgba(248, 117, 170, 0.12) !important;
    }

    .text-pink {
        color: #f875aa !important;
    }

    .border-pink {
        border-color: rgba(248, 117, 170, 0.35) !important;
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        border-radius: 24px;
        background: rgba(248, 117, 170, 0.12);
        color: #f875aa;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }
</style>

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {

    new Chart(document.getElementById('trimesterChart'), {
        type: 'pie',
        data: {
            labels: ['Trimester 1', 'Trimester 2', 'Trimester 3'],
            datasets: [{
                data: {!! json_encode($perTrimester) !!},
                backgroundColor: ['#FFD700', '#9333EA', '#3B82F6'],
                borderWidth: 0
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });

    new Chart(document.getElementById('kunjunganChart'), {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'],
            datasets: [{
                data: {!! json_encode($perBulan) !!},
                borderColor: '#f875aa',
                borderWidth: 3,
                backgroundColor: 'rgba(248,117,170,0.3)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#f875aa'
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { 
                y: { 
                    display: true, 
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5,
                        color: '#6c757d'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    }
                }, 
                x: { 
                    grid: { display: false },
                    ticks: { color: '#6c757d' }
                } 
            }
        }
    });

});
</script>
@endsection