@extends('layouts.masterBumil')

@section('content')
<div class="container-fluid py-4">

    <h4 class="fw-bold mb-1">Riwayat Perkembangan Kehamilan</h4>
    <p class="text-muted mb-3">Ringkasan riwayat pemeriksaan dan perkembangan kehamilan Bunda</p>

    <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
        <div class="card-body d-flex align-items-center justify-content-between"
            style="background:#fde8f2; border-radius:16px;">

            <div>
                <p class="fw-bold mb-1">Usia Kehamilan Saat Ini</p>
                <h4 class="text-pink fw-bold mb-0">
                    {{ $terakhir->usia_kehamilan ?? '-' }} Minggu
                </h4>
                <h5 class="text-pink">
                    Trimester {{ $terakhir->trimester ?? '-' }}
                </h5>
            </div>

            <div class="text-center px-4 border-start">
                <p class="fw-bold mb-1">Perkiraan HPL</p>
                <h5 class="text-pink fw-bold">
                    {{ $pendaftaran->hpl ?? '-' }}
                </h5>
            </div>

            <div class="text-center px-4 border-start">
                <p class="fw-bold mb-1">Total Pemeriksaan</p>
                <h5 class="text-pink fw-bold">
                    {{ $riwayats->count() }} Pemeriksaan
                </h5>
            </div>

        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
                <div class="card-body">
                    <h5 class="text-pink fw-bold text-center mb-3">Riwayat Kehamilan</h5>

                    <table class="table table-borderless">
                        <tr>
                            <td>Nama</td>
                            <td>: {{ $pendaftaran->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>: {{ $pendaftaran->tanggal_lahir ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Golongan Darah</td>
                            <td>: {{ $pendaftaran->golongan_darah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Kehamilan Ke-</td>
                            <td>: {{ $terakhir->kehamilan_ke ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>HPHT</td>
                            <td>: {{ $pendaftaran->hpht ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Riwayat Penyakit</td>
                            <td>: {{ $terakhir->riwayat_penyakit ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Riwayat Alergi</td>
                            <td>: {{ $terakhir->riwayat_alergi ?? '-' }}</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
                <div class="card-body">
                    <h5 class="text-pink fw-bold text-center mb-3">Ringkasan Kondisi Terakhir</h5>

                    <table class="table table-borderless">
                        <tr>
                            <td>Berat Badan</td>
                            <td>: {{ $terakhir->berat_badan ?? '-' }} kg</td>
                        </tr>
                        <tr>
                            <td>Tinggi Badan</td>
                            <td>: {{ $terakhir->tinggi_badan ?? '-' }} cm</td>
                        </tr>
                        <tr>
                            <td>Tekanan Darah</td>
                            <td>: {{ $terakhir->tekanan_darah ?? '-' }} mmHg</td>
                        </tr>
                        <tr>
                            <td>IMT</td>
                            <td>: {{ $terakhir->imt ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Tinggi Fundus Uteri</td>
                            <td>: {{ $terakhir->tinggi_fundus ?? '-' }} cm</td>
                        </tr>
                        <tr>
                            <td>Denyut Jantung Janin</td>
                            <td>: {{ $terakhir->djj ?? '-' }} x/menit</td>
                        </tr>
                        <tr>
                            <td>LILA</td>
                            <td>: {{ $terakhir->lila ?? '-' }} cm</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-bold text-pink mb-3">Riwayat Pemeriksaan</h5>

    <div class="table-responsive shadow-sm" style="border-radius:16px; overflow:hidden;">
        <table class="table table-bordered text-center align-middle">
            <thead style="background:#f875aa; color:white;">
                <tr>
                    <th>No</th>
                    <th>Tanggal Pemeriksaan</th>
                    <th>Usia Kehamilan</th>
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
                        {{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d F Y') }}
                    </td>

                    <td>
                        {{ $item->usia_kehamilan }} Minggu
                    </td>

                    <td>
                        {{ $item->keluhan }}
                    </td>

                    <td>
                        {{ $item->tindakan }}
                    </td>

                    <td class="text-center">
                        <a href="{{ route('bumil.detailRiwayatPerkembangan', $item->id) }}"
                            class="btn text-white px-3 py-1" style="background-color:#f472b6; border-radius:10px;">
                            Detail
                        </a>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Belum ada riwayat pemeriksaan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection