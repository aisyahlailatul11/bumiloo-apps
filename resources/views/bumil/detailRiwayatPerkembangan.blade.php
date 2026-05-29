@extends('layouts.masterBumil')

@section('content')
<div class="container-fluid py-3">

    <div class="medical-card">

        {{-- HEADER --}}
        <div class="medical-header">
            <div>
                <h4 class="fw-bold mb-1">Hasil Pemeriksaan Kehamilan</h4>
                <p class="text-muted mb-0">Detail hasil pemeriksaan antenatal care ibu hamil</p>
            </div>

            <span class="status-badge">
                Selesai Diperiksa
            </span>
        </div>

        {{-- IDENTITAS PEMERIKSAAN --}}
        <div class="info-strip mt-4">
            <div>
                <small>Tanggal Pemeriksaan</small>
                <strong>
                    {{ $riwayat->tanggal_pemeriksaan ? \Carbon\Carbon::parse($riwayat->tanggal_pemeriksaan)->translatedFormat('d F Y') : '-' }}
                </strong>
            </div>

            <div>
                <small>Waktu</small>
                <strong>
                    {{ $riwayat->waktu_pemeriksaan ?? $riwayat->waktu ?? '-' }} WIB
                </strong>
            </div>

            <div>
                <small>Pemeriksa</small>
                <strong>
                    {{ $riwayat->nama_bidan ?? 'Bidan Siti Fatimah' }}
                </strong>
            </div>
        </div>

        <hr class="my-4">

        {{-- DATA KEHAMILAN --}}
        <div class="section-title">
            Data Kehamilan
        </div>

        <div class="table-responsive">
            <table class="table medical-table">
                <tbody>
                    <tr>
                        <th>Usia Kehamilan</th>
                        <td>{{ $riwayat->usia_kehamilan ?? '-' }} Minggu</td>
                    </tr>
                    <tr>
                        <th>Trimester</th>
                        <td>Trimester {{ $riwayat->trimester ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>HPHT</th>
                        <td>{{ $pendaftaran->hpht ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Keluhan Utama</th>
                        <td>{{ $riwayat->keluhan ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- HASIL PEMERIKSAAN --}}
        <div class="section-title mt-4">
            Hasil Pemeriksaan Fisik
        </div>

        <div class="table-responsive">
            <table class="table medical-table">
                <tbody>
                    <tr>
                        <th>Berat Badan</th>
                        <td>{{ $riwayat->berat_badan ?? '-' }} kg</td>
                        <th>Tinggi Badan</th>
                        <td>{{ $riwayat->tinggi_badan ?? '-' }} cm</td>
                    </tr>

                    <tr>
                        <th>Tekanan Darah</th>
                        <td>{{ $riwayat->tekanan_darah ?? '-' }} mmHg</td>
                        <th>IMT</th>
                        <td>{{ $riwayat->imt ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Tinggi Fundus Uteri</th>
                        <td>{{ $riwayat->tinggi_fundus_uteri ?? $riwayat->tinggi_fundus ?? '-' }} cm</td>
                        <th>Denyut Jantung Janin</th>
                        <td>{{ $riwayat->denyut_jantung_janin ?? $riwayat->djj ?? '-' }} x/menit</td>
                    </tr>

                    <tr>
                        <th>LILA</th>
                        <td>{{ $riwayat->lila ?? '-' }} cm</td>
                        <th>Status Pemeriksaan</th>
                        <td>Selesai</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- TINDAKAN --}}
        <div class="section-title mt-4">
            Tindakan dan Rencana Asuhan
        </div>

        <div class="note-box mb-3">
            <label>Tindakan / Saran Bidan</label>
            <p>{!! nl2br(e($riwayat->tindakan_saran ?? $riwayat->tindakan ?? '-')) !!}</p>
        </div>

        <div class="note-box mb-3">
            <label>Obat / Vitamin</label>
            <p>{!! nl2br(e($riwayat->obat ?? '-')) !!}</p>
        </div>

        <div class="note-box">
            <label>Catatan Tambahan</label>
            <p>{{ $riwayat->catatan_tambahan ?? $riwayat->catatan ?? '-' }}</p>
        </div>

        {{-- FOOTER --}}
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
            <a href="{{ route('bumil.riwayatPerkembangan') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>

            <small class="text-muted">
                Data ini merupakan ringkasan hasil pemeriksaan kehamilan.
            </small>
        </div>

    </div>

</div>

<style>
.medical-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 32px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
    border: 1px solid #f1dbe6;
}

.medical-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    flex-wrap: wrap;
}

.status-badge {
    background: #FFF0F7;
    color: #F875AA;
    border: 1px solid #F8C8DE;
    padding: 8px 16px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 14px;
}

.info-strip {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    background: #FFF8FC;
    border: 1px solid #FBE1EE;
    border-radius: 18px;
    padding: 18px 22px;
}

.info-strip small {
    display: block;
    color: #64748B;
    font-size: 13px;
    margin-bottom: 4px;
}

.info-strip strong {
    color: #1E293B;
    font-weight: 600;
    font-size: 15px;
}

.section-title {
    font-size: 17px;
    font-weight: 700;
    color: #F875AA;
    margin-bottom: 12px;
    padding-left: 10px;
    border-left: 4px solid #F875AA;
}

.medical-table {
    border: 1px solid #EEF2F7;
    border-radius: 14px;
    overflow: hidden;
    margin-bottom: 0;
}

.medical-table th {
    width: 22%;
    background: #F8FAFC;
    color: #475569;
    font-weight: 600;
    padding: 14px 18px;
    border-color: #EEF2F7;
    white-space: nowrap;
}

.medical-table td {
    color: #1E293B;
    padding: 14px 18px;
    border-color: #EEF2F7;
}

.note-box {
    background: #FFF8FC;
    border: 1px solid #FBE1EE;
    border-radius: 16px;
    padding: 18px 20px;
}

.note-box label {
    display: block;
    color: #64748B;
    font-size: 13px;
    margin-bottom: 8px;
    font-weight: 600;
}

.note-box p {
    color: #1E293B;
    font-size: 15px;
    line-height: 1.7;
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .medical-card {
        padding: 22px;
    }

    .info-strip {
        grid-template-columns: 1fr;
    }

    .medical-table th,
    .medical-table td {
        display: block;
        width: 100%;
    }

    .medical-table th {
        border-bottom: none;
    }
}
</style>
@endsection