@extends('layouts.masterBidan')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<style>
    .bg-purple {
        background-color: #6b46c1 !important;
        color: #fff !important;
    }
    .card-body i {
        font-size: 2rem; /* ikon lebih besar */
    }
    .card-body p {
        font-size: 2rem; /* angka lebih besar */
    }

    .timeline {
        position: relative;
        margin-left: 30px;
        padding-left: 20px;
        border-left: 3px solid #ccc;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    .timeline-item::before {
        content: "";
        position: absolute;
        left: -32px;
        top: 5px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #0077b6;
        border: 2px solid #fff;
    }
</style>

<div class="container-fuid">
     <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Jadwal Bidan</h2>
     </div>

    <div class="row g-3 mb-4">
        {{-- HARI INI --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 me-3 rounded-3" style="background-color:#d8f3dc;">
                        <i class="fas fa-calendar-alt" style="color:#2d6a4f;"></i>
                    </div>
                    <div>
                        <p class="fw-bold mb-0">{{ $countHariIni }} </p>
                         <h6 class="text-dark mb-0">Jadwal Hari Ini</h6>
                    </div>
                </div>
            </div>
        </div>

        {{-- PERSALINAN --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 me-3 rounded-3" style="background-color:#e9d8fd;">
                        <i class="fas fa-baby" style="color:#6b46c1;"></i>
                    </div>
                    <div>
                        <p class="fw-bold mb-0">{{ $countPersalinan }} </p>
                        <h6 class="text-dark mb-0">Jadwal Persalinan</h6>
                    </div>
                </div>
            </div>
        </div>

        {{-- KONTROL PEMERIKSAAN --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 me-3 rounded-3" style="background-color:#ffe5b4;">
                        <i class="fas fa-user-md" style="color:#cc8400;"></i>
                    </div>
                    <div>
                        <p class="fw-bold mb-0">{{ $countKontrol }} </p>
                        <h6 class="text-dark mb-0">Pemeriksaan Kontrol</h6>
                    </div>
                </div>
            </div>
        </div>

        {{-- IMUNISASI --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 me-3 rounded-3" style="background-color:#caf0f8;">
                        <i class="fas fa-syringe" style="color:#0077b6;"></i>
                    </div>
                    <div>
                        <p class="fw-bold mb-0">{{ $countImunisasi }} </p>
                        <h6 class="text-dark mb-0">Jadwal Imunisasi</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card daftar detail Jadwal Hari Ini --}}
    <div class="card shadow-sm border-0 bg-white p-4">
        <h5 class="fw-bold mb-3 text-dark">Jadwal Bidan Hari Ini</h5>

        @if($jadwalHariIniList->isEmpty() && $jadwalPersalinanList->isEmpty() && $jadwalKontrolList->isEmpty() && $jadwalImunisasiList->isEmpty())
            <div class="alert alert-info text-center">
                Tidak ada jadwal untuk hari ini.
            </div>
        @else
            <div class="timeline">
                @foreach($jadwalHariIniList as $jadwal)
                    @php
                        $bgColor = '#d8f3dc';
                        $badgeColor = 'bg-success';
                        if(Str::contains(strtolower($jadwal->keterangan), ['imunisasi'])) {
                            $bgColor = '#caf0f8';
                            $badgeColor = 'bg-primary';
                        } elseif(Str::contains(strtolower($jadwal->keterangan), ['persalinan', 'melahirkan'])) {
                            $bgColor = '#e9d8fd';
                            $badgeColor = 'bg-purple';
                        } elseif(Str::contains(strtolower($jadwal->keterangan), ['kontrol'])) {
                            $bgColor = '#ffe5b4';
                            $badgeColor = 'bg-warning text-dark';
                        }
                    @endphp

                    <div class="timeline-item">
                        <div class="card shadow-sm border-0 mb-2 bg-white">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }} WIB</strong> 
                                    — {{ $jadwal->keterangan }} (Pasien: {{ $jadwal->nama_pasien }})
                                </div>
                                <span class="badge {{ $badgeColor }} ms-2">Terjadwal</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
