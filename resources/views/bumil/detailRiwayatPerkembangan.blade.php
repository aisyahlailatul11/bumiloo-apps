@extends('layouts.masterBumil')

@section('content')
<div class="container-fluid py-4">

    <h4 class="fw-bold mb-3">Detail Pemeriksaan Kehamilan</h4>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <span class="me-3">
                <i class="fa fa-calendar"></i>
                {{ \Carbon\Carbon::parse($riwayat->tanggal_pemeriksaan)->format('d F Y') }}
            </span>

            <span>
                <i class="fa fa-clock"></i>
                {{ $riwayat->waktu_pemeriksaan }} WIB
            </span>
        </div>

        <div>
            Pemeriksaan oleh :
            <span class="text-pink">Bidan</span>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
        <div class="card-body d-flex justify-content-between align-items-center">

            <div class="text-center flex-fill">
                <p class="fw-bold mb-1">Usia Kehamilan Saat Ini</p>
                <h4 class="text-pink fw-bold">
                    {{ $riwayat->usia_kehamilan }} Minggu
                </h4>
                <h5 class="text-pink">Trimester {{ $riwayat->trimester }}</h5>
            </div>

            <div class="text-center flex-fill border-start">
                <p class="fw-bold mb-1">Perkiraan HPL</p>
                <h5 class="text-pink fw-bold">
                    {{ $pendaftaran->hpl ?? '-' }}
                </h5>
            </div>

            <div class="text-center flex-fill border-start">
                <p class="fw-bold mb-1">HPHT</p>
                <h5 class="text-pink fw-bold">
                    {{ $pendaftaran->hpht ?? '-' }}
                </h5>
            </div>

        </div>
    </div>

    <div class="row g-3">

        <div class="col-md-5">
            <div class="card border-0 shadow-sm" style="border-radius:16px;">
                <div class="card-body">
                    <h5 class="text-pink fw-bold text-center">Keluhan Saat Ini</h5>
                    <p>{{ $riwayat->keluhan ?? '-' }}</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3" style="border-radius:16px;">
                <div class="card-body">
                    <h5 class="text-pink fw-bold text-center">Tindakan / Saran Bidan</h5>
                    <p>{!! nl2br(e($riwayat->tindakan ?? '-')) !!}</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3" style="border-radius:16px;">
                <div class="card-body">
                    <h5 class="text-pink fw-bold text-center">Obat</h5>
                    <p>{!! nl2br(e($riwayat->obat ?? '-')) !!}</p>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm" style="border-radius:16px;">
                <div class="card-body">
                    <h5 class="text-pink fw-bold text-center">Hasil Pemeriksaan</h5>

                    <table class="table table-borderless">
                        <tr>
                            <td>Berat Badan</td>
                            <td>: {{ $riwayat->berat_badan }} kg</td>
                        </tr>
                        <tr>
                            <td>Tinggi Badan</td>
                            <td>: {{ $riwayat->tinggi_badan }} cm</td>
                        </tr>
                        <tr>
                            <td>Tekanan Darah</td>
                            <td>: {{ $riwayat->tekanan_darah }} mmHg</td>
                        </tr>
                        <tr>
                            <td>IMT</td>
                            <td>: {{ $riwayat->imt }}</td>
                        </tr>
                        <tr>
                            <td>Tinggi Fundus Uteri</td>
                            <td>: {{ $riwayat->tinggi_fundus }} cm</td>
                        </tr>
                        <tr>
                            <td>Denyut Jantung Janin</td>
                            <td>: {{ $riwayat->djj }} x/menit</td>
                        </tr>
                        <tr>
                            <td>LILA</td>
                            <td>: {{ $riwayat->lila }} cm</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3" style="border-radius:16px;">
                <div class="card-body">
                    <h5 class="text-pink fw-bold text-center">Catatan Tambahan</h5>
                    <p>{{ $riwayat->catatan_tambahan ?? '-' }}</p>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-4">
        <a href="{{ route('bumil.riwayatPerkembangan') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

</div>
@endsection