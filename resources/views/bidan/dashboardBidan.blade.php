@extends('layouts.masterBidan')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Bumiloo Dashboard</h2>
    </div>

    {{-- CARD RINGKASAN --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
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

        <div class="col-md-4 mb-3">
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

        <div class="col-md-4 mb-3">
            <div class="card card-custom p-4 border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-danger bg-opacity-10 rounded-4 me-3 text-danger">
                        <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0">{{ $rataKunjungan ?? 0 }}</h2>
                        <small class="text-muted">Rata-rata Kunjungan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ISI DASHBOARD --}}
    <div class="row">

        {{-- JADWAL HARI INI --}}
        <div class="col-md-7 mb-4">
            <div class="card card-custom p-4 border-0 shadow-sm h-100">
                <h5 class="fw-bold mb-4">Janji Pemeriksaan Hari Ini</h5>

                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                        <tbody>
                            @forelse ($jadwalHariIni ?? [] as $jadwal)
                            <tr>
                                <td class="text-muted small" width="90">
                                    {{ \Carbon\Carbon::parse($jadwal->jam ?? $jadwal->waktu ?? now())->format('H:i') }}
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($jadwal->nama_pasien ?? 'Pasien') }}"
                                            class="rounded-circle me-3" width="40" height="40">

                                        <div>
                                            <span class="fw-bold d-block">
                                                {{ $jadwal->nama_pasien ?? 'Nama pasien tidak tersedia' }}
                                            </span>

                                            <small class="text-muted">
                                                {{ $jadwal->usia_kehamilan ?? '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-end">
                                    <span class="badge rounded-pill bg-pink-light text-pink border border-pink px-3">
                                        {{ $jadwal->keterangan ?? $jadwal->status ?? 'Pemeriksaan' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    Belum ada jadwal pemeriksaan hari ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 p-3 bg-pink-light rounded-4 d-flex align-items-center border border-pink">
                    <i class="fas fa-info-circle text-pink me-3 fs-3"></i>
                    <p class="mb-0 small">
                        Ingatkan ibu hamil untuk melakukan pemeriksaan rutin sesuai jadwal.
                    </p>
                </div>
            </div>
        </div>

        {{-- CHART --}}
        <div class="col-md-5 mb-4">

            <div class="card card-custom p-4 border-0 shadow-sm mb-4">
                <h6 class="fw-bold mb-3">Jumlah Ibu Hamil per Trimester</h6>
                <div style="height: 200px;">
                    <canvas id="trimesterChart"></canvas>
                </div>
            </div>

            <div class="card card-custom p-4 border-0 shadow-sm">
                <h6 class="fw-bold mb-3">Jumlah Kunjungan Per Bulan</h6>
                <div style="height: 150px;">
                    <canvas id="kunjunganChart"></canvas>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {

    new Chart(document.getElementById('trimesterChart'), {
        type: 'pie',
        data: {
            labels: ['Trimester 1', 'Trimester 2', 'Trimester 3'],
            datasets: [{
                data: {
                    !!json_encode($perTrimester) !!
                },
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
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov',
                'Des'
            ],
            datasets: [{
                data: {
                    !!json_encode($perBulan) !!
                },
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
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

});
</script>
@endsection