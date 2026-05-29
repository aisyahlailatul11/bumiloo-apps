@extends('layouts.masterBidan')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Daftar Pasien Hari Ini</h4>

    <!-- Tombol Tambah -->
    <a href="{{ route('bidan.inputDaftarPasien') }}" class="btn btn-primary mb-3">
        <i class="fas fa-user-plus"></i> Tambah
    </a>

    @foreach($pasienList as $pasien)
        <div class="card mb-3 shadow-sm" 
             onclick="window.location='{{ route('pasien.show', $pasien->id) }}'" 
             style="cursor:pointer;">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-user-circle fa-3x text-primary"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="mb-1">{{ $pasien->nama_pasien }}</h5>
                    <p class="mb-0 text-muted">
                        Jadwal: {{ $pasien->jadwal_kontrol }} <br>
                        Kategori: {{ $pasien->kategori }}
                    </p>
                </div>
                <div>
                    <i class="fas fa-chevron-right text-secondary"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
