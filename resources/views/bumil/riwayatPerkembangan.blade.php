@extends('layouts.masterBumil')

@section('content')
<div class="container-fluid py-3">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Riwayat Perkembangan Kehamilan</h4>
        <p class="text-muted mb-0">
            Ringkasan riwayat pemeriksaan dan perkembangan kehamilan Bunda
        </p>
    </div>

    {{-- SUMMARY --}}
    <div class="summary-card mb-4">
        <div class="row g-3">

            <div class="col-md-4">
                <div class="summary-item">
                    <div class="summary-icon">
                        <i class="bi bi-calendar-heart"></i>
                    </div>
                    <div>
                        <p>Usia Kehamilan Saat Ini</p>
                        <h5>{{ $terakhir->usia_kehamilan ?? '-' }} Minggu</h5>
                        <span>Trimester {{ $terakhir->trimester ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-item">
                    <div class="summary-icon">
                        <i class="bi bi-clipboard2-pulse"></i>
                    </div>
                    <div>
                        <p>Total Pemeriksaan</p>
                        <h5>{{ $riwayats->count() }} Pemeriksaan</h5>
                        <span>Riwayat kunjungan</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-item">
                    <div class="summary-icon">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <div>
                        <p>Pemeriksaan Terakhir</p>
                        <h5>
                            @if($terakhir)
                            {{ \Carbon\Carbon::parse($terakhir->tanggal_pemeriksaan)->format('d M Y') }}
                            @else
                            -
                            @endif
                        </h5>
                        <span>Kontrol terakhir</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- DETAIL CARD --}}
    <div class="row g-4 mb-4">

        {{-- RIWAYAT KEHAMILAN --}}
        {{-- RIWAYAT KEHAMILAN --}}
        <div class="col-lg-5">
            <div class="custom-card h-100">
                <div class="section-heading">
                    <i class="bi bi-person-heart"></i>
                    <span>Riwayat Kehamilan</span>
                </div>

                <div class="data-list">
                    <div class="data-item">
                        <span>Nama</span>
                        <strong>{{ $pendaftaran->nama ?? '-' }}</strong>
                    </div>

                    <div class="data-item">
                        <span>Tanggal Lahir</span>
                        <strong>{{ $pendaftaran->tanggal_lahir ?? '-' }}</strong>
                    </div>

                    <div class="data-item">
                        <span>Golongan Darah</span>
                        <strong>{{ $pendaftaran->golongan_darah ?? '-' }}</strong>
                    </div>

                    <div class="data-item">
                        <span>Kehamilan Ke-</span>
                        <strong>{{ $terakhir->kehamilan_ke ?? '-' }}</strong>
                    </div>

                    <div class="data-item">
                        <span>HPHT</span>
                        <strong>{{ $pendaftaran->hpht ?? '-' }}</strong>
                    </div>

                    <div class="data-item">
                        <span>HPL</span>
                        <strong>
                            {{ $terakhir && $terakhir->hpl ? \Carbon\Carbon::parse($terakhir->hpl)->format('d-m-Y') : '-' }}
                        </strong>
                    </div>

                    <div class="data-item">
                        <span>Riwayat Penyakit</span>
                        <strong>{{ $terakhir->riwayat_penyakit ?? '-' }}</strong>
                    </div>

                    <div class="data-item">
                        <span>Riwayat Alergi</span>
                        <strong>{{ $terakhir->riwayat_alergi ?? '-' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        {{-- KONDISI TERAKHIR --}}
        <div class="col-lg-7">
            <div class="custom-card h-100">
                <div class="section-heading">
                    <i class="bi bi-heart-pulse"></i>
                    <span>Ringkasan Kondisi Terakhir</span>
                </div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="info-card">
                            <p>Berat Badan</p>
                            <h6>{{ $terakhir->berat_badan ?? '-' }} <span>kg</span></h6>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <p>Tinggi Badan</p>
                            <h6>{{ $terakhir->tinggi_badan ?? '-' }} <span>cm</span></h6>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <p>Tekanan Darah</p>
                            <h6>{{ $terakhir->tekanan_darah ?? '-' }} <span>mmHg</span></h6>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <p>IMT</p>
                            <h6>{{ $terakhir->imt ?? '-' }}</h6>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <p>Tinggi Fundus Uteri</p>
                            <h6>{{ $terakhir->tinggi_fundus ?? '-' }} <span>cm</span></h6>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <p>Denyut Jantung Janin</p>
                            <h6>{{ $terakhir->djj ?? '-' }} <span>x/menit</span></h6>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <p>LILA</p>
                            <h6>{{ $terakhir->lila ?? '-' }} <span>cm</span></h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- TABEL RIWAYAT --}}
    <div class="custom-card">
        <h5 class="fw-bold mb-2">Riwayat Pemeriksaan</h5>
        <p class="text-muted mb-4">
            Jumlah Data Pemeriksaan: {{ $riwayats->count() }}
        </p>

        <div class="table-responsive">
            <table class="table align-middle riwayat-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pemeriksaan</th>
                        <th>Usia Kehamilan</th>
                        <th>HPL</th>
                        <th>Keluhan</th>
                        <th>Tindakan / Saran</th>
                        <th>Selengkapnya</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($riwayats as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $item->usia_kehamilan }} Minggu
                        </td>

                        <td>
                            {{ $item->hpl ? \Carbon\Carbon::parse($item->hpl)->format('d-m-Y') : '-' }}
                        </td>

                        <td>
                            {{ $item->keluhan ?? '-' }}
                        </td>

                        <td>
                            {{ $item->tindakan ?? '-' }}
                        </td>

                        <td class="text-center">
                            <a href="{{ route('bumil.detailRiwayatPerkembangan', $item->id) }}"
                                class="btn btn-sm text-white rounded-pill px-4" style="background:#F875AA;">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            Belum ada riwayat pemeriksaan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
.custom-card {
    background: #fff;
    border-radius: 24px;
    padding: 28px;
    box-shadow: 0 6px 20px rgba(233, 30, 140, 0.08);
    border: 1px solid #f7e2ec;
}

.summary-card {
    background: #FFF0F7;
    border-radius: 24px;
    padding: 24px;
    box-shadow: 0 6px 18px rgba(233, 30, 140, 0.08);
}

.summary-item {
    display: flex;
    align-items: center;
    gap: 14px;
    background: #fff;
    border-radius: 20px;
    padding: 18px;
    height: 100%;
}

.summary-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #FFE4EF;
    color: #F875AA;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 23px;
    flex-shrink: 0;
}

.summary-item p {
    margin: 0;
    font-size: 13px;
    color: #64748B;
}

.summary-item h5 {
    margin: 3px 0;
    font-size: 20px;
    font-weight: 700;
    color: #1E293B;
}

.summary-item span {
    font-size: 13px;
    color: #F875AA;
    font-weight: 500;
}

.section-heading {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #F875AA;
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 24px;
}

.section-heading i {
    font-size: 26px;
}

.data-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    padding: 14px 0;
    border-bottom: 1px solid #f3d8e5;
}

.data-item:last-child {
    border-bottom: none;
}

.data-item span {
    color: #64748B;
    font-size: 15px;
}

.data-item strong {
    color: #1E293B;
    font-size: 15px;
    font-weight: 600;
    text-align: right;
}

.info-card {
    background: #FFF8FC;
    border: 1px solid #FBE1EE;
    border-radius: 18px;
    padding: 18px 20px;
    height: 100%;
}

.info-card p {
    margin: 0 0 6px;
    color: #64748B;
    font-size: 14px;
}

.info-card h6 {
    margin: 0;
    color: #1E293B;
    font-size: 22px;
    font-weight: 650;
}

.info-card h6 span {
    font-size: 14px;
    font-weight: 400;
    color: #64748B;
}

.riwayat-table {
    min-width: 900px;
    border-collapse: separate;
    border-spacing: 0;
}

.riwayat-table thead th {
    background: #F84F8F;
    color: white;
    padding: 18px 24px;
    font-weight: 700;
    border: none;
}

.riwayat-table thead th:first-child {
    border-top-left-radius: 18px;
    border-bottom-left-radius: 18px;
}

.riwayat-table thead th:last-child {
    border-top-right-radius: 18px;
    border-bottom-right-radius: 18px;
}

.riwayat-table tbody td {
    padding: 20px 24px;
    color: #334155;
    border-bottom: 1px solid #eef2f7;
}

.riwayat-table tbody tr:hover {
    background: #fff5fa;
}

@media (max-width: 768px) {
    .custom-card {
        padding: 20px;
    }

    .data-item {
        align-items: flex-start;
        flex-direction: column;
        gap: 4px;
    }

    .data-item strong {
        text-align: left;
    }
}
</style>
@endsection