@extends('layouts.masterAdmin')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold">Laporan Pemeriksaan Ibu Hamil</h2>
        <small class="text-muted">Ringkasan dan data kehamilan</small>
    </div>
    <div class="d-none d-print-block">
    <div class="header">
        <div class="header-text">
            <h2>Praktik Bidan Mandiri Siti Fatimah</h2>
            <p>Jl. Melati No. 2, Kab. Jember</p>
        </div>
    </div>
    <hr>
    <div class="judul">
        <h2>LAPORAN MONITORING PELAYANAN KESEHATAN IBU</h2>
        <p>dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    <table class="table table-bordered">
        </table>
</div>

    {{-- CHART --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3">
                <h6 class="fw-bold mb-2">Jumlah Kunjungan Per Bulan</h6>
                <div style="height:180px;"><canvas id="chartKunjungan"></canvas></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3">
                <h6 class="fw-bold mb-2">Jumlah Ibu Hamil per Trimester</h6>
                <div style="height:180px;"><canvas id="chartTrimester"></canvas></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3">
                <h6 class="fw-bold mb-2">Jumlah Persalinan Per Bulan</h6>
                <div style="height:180px;"><canvas id="chartPersalinan"></canvas></div>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="card border-0 shadow-sm p-4 mb-4">
        <h6 class="fw-bold text-pink mb-3"><i class="fas fa-filter me-1"></i> Filter Laporan</h6>
        <form method="GET" action="{{ route('admin.laporan') }}" id="formFilter">
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label small">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Trimester</label>
                    <select name="trimester" class="form-select">
                        <option value="semua">Semua Trimester</option>
                        <option value="1" {{ request('trimester') == '1' ? 'selected' : '' }}>Trimester 1</option>
                        <option value="2" {{ request('trimester') == '2' ? 'selected' : '' }}>Trimester 2</option>
                        <option value="3" {{ request('trimester') == '3' ? 'selected' : '' }}>Trimester 3</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Jenis Layanan</label>
                    <select name="jenis_layanan" class="form-select">
                        <option value="semua">Semua Jenis</option>
                        <option value="Kunjungan Pertama" {{ request('jenis_layanan') == 'Kunjungan Pertama' ? 'selected' : '' }}>Kunjungan Pertama</option>
                        <option value="Kunjungan Ulang" {{ request('jenis_layanan') == 'Kunjungan Ulang' ? 'selected' : '' }}>Kunjungan Ulang</option>
                        <option value="Persalinan" {{ request('jenis_layanan') == 'Persalinan' ? 'selected' : '' }}>Persalinan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">IMT</label>
                    <select name="imt" class="form-select">
                        <option value="semua">Semua IMT</option>
                        <option value="normal" {{ request('imt') == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="lebih" {{ request('imt') == 'lebih' ? 'selected' : '' }}>Lebih</option>
                        <option value="kurang" {{ request('imt') == 'kurang' ? 'selected' : '' }}>Kurang</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Usia Kehamilan (minggu)</label>
                    <div class="d-flex gap-1">
                        <input type="number" name="usia_min" class="form-control" placeholder="Min" value="{{ request('usia_min') }}">
                        <input type="number" name="usia_max" class="form-control" placeholder="Max" value="{{ request('usia_max') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label small">Cari Nama Ibu Hamil</label>
                    <div class="input-group">
                        <input type="text" name="nama_pasien" id="inputNama" class="form-control"
                            placeholder="Ketik nama ibu hamil..."
                            value="{{ request('nama_pasien') }}">
                        <button type="submit" class="btn" style="background-color:#f875aa; color:white;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- TOMBOL --}}
            <div class="d-flex gap-2 mt-3 flex-wrap">
                <button type="submit" class="btn text-white px-4" style="background-color:#f875aa;">
                    <i class="fas fa-search me-1"></i> Tampilkan Laporan
                </button>
                <a href="{{ route('admin.laporan') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-redo me-1"></i> Reset Filter
                </a>
                <a href="{{ route('admin.laporan.pdf', request()->query()) }}" 
                   class="btn btn-outline-danger px-3" target="_blank">
                    <i class="fas fa-file-pdf me-1"></i> Export PDF
                </a>
                <a href="{{ route('admin.laporan.excel', request()->query()) }}" 
                   class="btn btn-outline-success px-3">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </a>
               {{-- Tombol Cetak di file laporan.blade.php --}}
<a href="{{ route('admin.laporan.cetak', request()->query()) }}" 
   target="_blank" 
   class="btn btn-outline-secondary px-3">
   <i class="fas fa-print me-1"></i> Cetak
</a>
            </div>
        </form>
    </div>

<div class="d-none d-print-block mb-4">
    <div style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 10px;">
        <h2 style="margin: 0; font-size: 18px; text-transform: uppercase;">Praktik Bidan Mandiri Siti Fatimah</h2>
        <p style="margin: 0; font-size: 12px;">Jl. Melati No. 2, Kab. Jember</p>
    </div>
    <div style="text-align: center; margin-bottom: 20px;">
        <h4 style="margin: 0; font-size: 14px; text-transform: uppercase;">Laporan Monitoring Pelayanan Kesehatan Ibu</h4>
        <p style="margin: 0; font-size: 10px;">Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</div>

{{-- TABEL --}}
<div class="card border-0 shadow-sm p-4" id="print-table">
    <h6 class="fw-bold mb-3 d-print-none">Tabel Pasien</h6>
    <div style="overflow-x: scroll; width: 100%;">
        <table class="table table-striped table-hover align-middle small" style="min-width: 1500px;">
            <thead style="background-color:#f875aa; color:white;">
                <tr>
                    <th>ID</th><th>Nama</th><th>Tgl</th><th>Waktu</th><th>UK</th><th>Tri</th><th>Ke-</th><th>Layanan</th>
                    <th>BB</th><th>TB</th><th>IMT</th><th>T.Darah</th><th>Fundus</th><th>LILA</th><th>DJJ</th>
                    <th>Riwayat</th><th>Alergi</th><th>Keluhan</th><th>Tindakan</th><th>Obat</th><th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $row)
                <tr>
                    <td>{{ $row->pasien_id }}</td>
                    <td>{{ $row->pasien->nama_pasien ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->tanggal_pemeriksaan)->format('d/m/Y') }}</td>
                    <td>{{ $row->waktu_pemeriksaan }}</td>
                    <td>{{ $row->usia_kehamilan }}</td>
                    <td>{{ $row->trimester }}</td>
                    <td>{{ $row->kehamilan_ke }}</td>
                    <td>{{ $row->jenis_layanan ?? '-' }}</td>
                    <td>{{ $row->berat_badan }}</td>
                    <td>{{ $row->tinggi_badan }}</td>
                    <td>{{ $row->imt }}</td>
                    <td>{{ $row->tekanan_darah }}</td>
                    <td>{{ $row->tinggi_fundus }}</td>
                    <td>{{ $row->lila }}</td>
                    <td>{{ $row->djj }}</td>
                    <td>{{ $row->riwayat_penyakit ?? '-' }}</td>
                    <td>{{ $row->riwayat_alergi ?? '-' }}</td>
                    <td>{{ $row->keluhan ?? '-' }}</td>
                    <td>{{ $row->tindakan ?? '-' }}</td>
                    <td>{{ $row->obat ?? '-' }}</td>
                    <td>{{ $row->catatan_tambahan ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="21" class="text-center">Belum ada data pemeriksaan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <small class="text-muted mt-2">Total: {{ $data->count() }} data</small>
</div>

</div>

{{-- CSS CETAK --}}
<style>
    /* CSS tabel tidak dempet */
#print-table table th,
#print-table table td {
    white-space: nowrap;
    padding: 8px 12px !important;
}

#print-table .table-responsive {
    overflow-x: auto;
}

@media print {
    /* 1. Sembunyikan SEMUA elemen body secara default */
    body * {
        visibility: hidden !important;
    }

    /* 2. Hanya tampilkan ID #print-table dan semua isinya */
    #print-table, #print-table * {
        visibility: visible !important;
    }

    /* 3. Posisi paksa ke pojok kiri atas */
    #print-table {
        position: absolute;
        left: 0;
        top: 0;
        width: 100% !important;
    }

    @page {
        size: A4 landscape;
        margin: 1cm;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const bulanLabel = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
    const perBulan = @json($perBulan);
    const perTrimester = @json($perTrimester);
    const perBulanPersalinan = @json($perBulanPersalinan);

    // Chart Kunjungan
    const ctx1 = document.getElementById('chartKunjungan').getContext('2d');
    const grad1 = ctx1.createLinearGradient(0, 0, 0, 180);
    grad1.addColorStop(0, 'rgba(248,117,170,0.4)');
    grad1.addColorStop(1, 'rgba(248,117,170,0)');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: bulanLabel,
            datasets: [{ data: perBulan, borderColor: '#f875aa', backgroundColor: grad1,
                fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#f875aa', borderWidth: 2 }]
        },
        options: { maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { display: false }, x: { grid: { display: false } } }
        }
    });

    // Chart Trimester
    new Chart(document.getElementById('chartTrimester'), {
        type: 'pie',
        data: {
            labels: ['Trimester 1', 'Trimester 2', 'Trimester 3'],
            datasets: [{ data: perTrimester,
                backgroundColor: ['#FFD700', '#9333EA', '#3B82F6'], borderWidth: 0 }]
        },
        options: { maintainAspectRatio: false,
            plugins: { legend: { position: 'right', labels: { font: { size: 11 } } } }
        }
    });

    // Chart Persalinan
    const ctx3 = document.getElementById('chartPersalinan').getContext('2d');
    const grad3 = ctx3.createLinearGradient(0, 0, 0, 180);
    grad3.addColorStop(0, 'rgba(248,117,170,0.4)');
    grad3.addColorStop(1, 'rgba(248,117,170,0)');
    new Chart(ctx3, {
        type: 'line',
        data: {
            labels: bulanLabel,
            datasets: [{ data: perBulanPersalinan, borderColor: '#f875aa', backgroundColor: grad3,
                fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#f875aa', borderWidth: 2 }]
        },
        options: { maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { display: false }, x: { grid: { display: false } } }
        }
    });
});

</script>
@endsection