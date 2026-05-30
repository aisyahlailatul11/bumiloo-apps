@extends('layouts.masterBidan')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4 text-dark">Daftar Pasien Hari Ini</h3>

    @if($pasienList->isEmpty())
        <div class="alert alert-info text-center">
            Tidak ada pasien terjadwal untuk hari ini.
        </div>
    @else
        {{-- DI SINI DIUBAH: Menggunakan $pasien sebagai alias --}}
        @foreach($pasienList as $pasien)
            @php
                // Tentukan warna ikon dan badge berdasarkan kategori
                $iconColor = 'text-primary';
                $bgCircle = 'rgba(0,123,255,0.1)';
                $badgeClass = 'bg-info';

                if(Str::contains(strtolower($pasien->kategori), 'pemeriksaan')) {
                    $iconColor = 'text-success';
                    $bgCircle = 'rgba(25,135,84,0.1)'; // hijau pastel
                    $badgeClass = 'bg-success';
                } elseif(Str::contains(strtolower($pasien->kategori), 'kontrol')) {
                    $iconColor = 'text-warning';
                    $bgCircle = 'rgba(255,193,7,0.1)'; // kuning pastel
                    $badgeClass = 'bg-warning text-dark';
                } elseif(Str::contains(strtolower($pasien->kategori), 'imunisasi')) {
                    $iconColor = 'text-info';
                    $bgCircle = 'rgba(13,202,240,0.1)'; // biru pastel
                    $badgeClass = 'bg-info';
                }
            @endphp

            <div class="card mb-3 shadow rounded-3 border-0" 
                onclick="window.location='{{ route('bidan.inputDaftarPasien', $pasien->id) }}'"
                 style="cursor:pointer; transition:0.2s; border:1px solid rgba(0,0,0,0.05);">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 d-flex align-items-center justify-content-center rounded-circle" 
                         style="width:60px; height:60px; background:{{ $bgCircle }};">
                        <i class="fas fa-user-circle fa-2x {{ $iconColor }}"></i>
                    </div>

                    <div class="flex-grow-1">
                        <h5 class="mb-1">{{ $pasien->nama_pasien }}</h5>
                        <p class="mb-0 text-muted">
                            Jadwal: {{ \Carbon\Carbon::parse($pasien->jam)->format('H:i') }} WIB <br>
                            <span class="badge {{ $badgeClass }}">{{ $pasien->keterangan }}</span>
                        </p>
                    </div>
                    
                    <div>
                        <i class="fas fa-chevron-right text-secondary"></i>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection