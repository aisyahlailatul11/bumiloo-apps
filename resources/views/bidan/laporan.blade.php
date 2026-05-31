@extends('layouts.masterBidan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Laporan Bidan</h2>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card card-custom p-4 border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-success bg-opacity-10 rounded-4 me-3 text-success">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0">{{ $jumlahKunjunganBulanIni ?? $jumlahKunjunganHariIni }}</h2>
                        <small class="text-muted">Jumlah Kunjungan Bulan Ini</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-custom p-4 border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-primary bg-opacity-10 rounded-4 me-3 text-primary">
                        <i class="fas fa-baby fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0">{{ $jumlahPersalinanBulanIni ?? $jumlahPersalinanHariIni }}</h2>
                        <small class="text-muted">Jumlah Persalinan Bulan Ini</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card card-custom p-4 border-0 shadow-sm h-100 bg-pink-light">
                <h6 class="fw-bold mb-3">Jumlah Kunjungan Per Bulan</h6>
                <div style="height:250px;"><canvas id="kunjunganChart"></canvas></div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card card-custom p-4 border-0 shadow-sm h-100 bg-pink-light">
                <h6 class="fw-bold mb-3">Jumlah Ibu Hamil per Trimester</h6>
                <div style="height:250px;"><canvas id="trimesterChart"></canvas></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card card-custom p-4 border-0 shadow-sm h-100 bg-pink-light">
                <h6 class="fw-bold mb-3">Jumlah Persalinan Per Bulan</h6>
                <div style="height:250px;"><canvas id="persalinanChart"></canvas></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // PIE CHART (Trimester)
    new Chart(document.getElementById('trimesterChart'), {
        type: 'pie',
        data: {
            labels: ['Trimester 1', 'Trimester 2', 'Trimester 3'],
            datasets: [{
                data: [{{ $perTrimester[0] ?? 0 }}, {{ $perTrimester[1] ?? 0 }}, {{ $perTrimester[2] ?? 0 }}],
                backgroundColor: ['#FFD700', '#9333EA', '#3B82F6'],
                borderWidth: 0
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { position: 'right' } }
        }
    });

    // LINE CHART (Kunjungan per bulan) - Sumbu Y Selisih 5
    new Chart(document.getElementById('kunjunganChart'), {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'],
            datasets: [{
                data: {!! json_encode($perBulan) !!},
                borderColor: '#f875aa',
                borderWidth: 3,
                backgroundColor: 'rgba(248,117,170,0.15)',
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
                        stepSize: 5, // Mengatur jeda kelipatan 5 (0, 5, 10, 15, dst)
                        color: '#6c757d'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)', // Garis panduan horizontal tipis
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

    // LINE CHART (Persalinan per bulan) - Sumbu Y Selisih 5
    new Chart(document.getElementById('persalinanChart'), {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'],
            datasets: [{
                data: {!! json_encode($perBulanPersalinan) !!},
                borderColor: '#3B82F6',
                borderWidth: 3,
                backgroundColor: 'rgba(59,130,246,0.15)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#3B82F6'
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
                        stepSize: 5, // Mengatur jeda kelipatan 5 (0, 5, 10, 15, dst)
                        color: '#6c757d'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)', // Garis panduan horizontal tipis
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