@extends('layouts.masterBidan')

@section('content')
<div class="container-lg mt-4">

    {{-- Card utama untuk Kumpulan Total Jadwal Bidan --}}
    <div class="card shadow-sm border-0 bg-white p-4 mb-4">
        <h3 class="fw-bold mb-4 text-dark">Jadwal Bidan</h3>

        <div class="row g-3">
            {{-- HARI INI --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-0" style="background-color:#d8f3dc;">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 me-3" style="background-color:#b7e4c7;">
                            <i class="fas fa-calendar-alt" style="color:#2d6a4f;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Jadwal Hari Ini</h6>
                            <p class="mb-0 text-success fw-semibold">{{ $countHariIni }} Jadwal</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PERSALINAN --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-0" style="background-color:#e9d8fd;">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 me-3" style="background-color:#d6bcfa;">
                            <i class="fas fa-baby" style="color:#6b46c1;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Jadwal Persalinan</h6>
                            <p class="mb-0 text-purple fw-semibold">{{ $countPersalinan }} Kasus</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KONTROL PEMERIKSAAN --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-0" style="background-color:#ffe5b4;">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 me-3" style="background-color:#ffd580;">
                            <i class="fas fa-user-md" style="color:#cc8400;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Pemeriksaan Kontrol</h6>
                            <p class="mb-0 text-warning fw-semibold">{{ $countKontrol }} Ibu Hamil</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- IMUNISASI --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-0" style="background-color:#caf0f8;">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 me-3" style="background-color:#ade8f4;">
                            <i class="fas fa-syringe" style="color:#0077b6;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Jadwal Imunisasi</h6>
                            <p class="mb-0 text-primary fw-semibold">{{ $countImunisasi }} Terjadwal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card daftar detail Jadwal Hari Ini --}}
    <div class="card shadow-sm border-0 bg-white p-4">
        <h5 class="fw-bold mb-3 text-dark">Jadwal Bidan Hari Ini</h5>

        @if($jadwalHariIniList->isEmpty())
            <div class="alert alert-info text-center">
                Tidak ada jadwal pemeriksaan untuk hari ini.
            </div>
        @else
            @foreach($jadwalHariIniList as $jadwal)
                @php
                    // Logika dinamis untuk warna card berdasarkan keyword keterangan
                    $bgColor = '#d8f3dc'; // Default Hijau (Pemeriksaan Umum)
                    $badgeColor = 'bg-success';
                    
                    if(Str::contains(strtolower($jadwal->keterangan), ['imunisasi'])) {
                        $bgColor = '#caf0f8'; // Biru info
                        $badgeColor = 'bg-primary';
                    } elseif(Str::contains(strtolower($jadwal->keterangan), ['persalinan', 'melahirkan'])) {
                        $bgColor = '#e9d8fd'; // Ungu
                        $badgeColor = 'bg-purple';
                    } elseif(Str::contains(strtolower($jadwal->keterangan), ['kontrol'])) {
                        $bgColor = '#ffe5b4'; // Jingga/Kuning
                        $badgeColor = 'bg-warning text-dark';
                    }
                @endphp

                <div class="card shadow-sm border-0 mb-2" style="background-color: {{ $bgColor }};">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }} WIB</strong> 
                            — {{ $jadwal->keterangan }} (Pasien: {{ $jadwal->nama_pasien }})
                        </div>
                        <span class="badge {{ $badgeColor }} ms-2">Terjadwal</span>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</div>
@endsection