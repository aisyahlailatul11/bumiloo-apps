@extends('layouts.masterBumil')

@section('title', 'Daftar Artikel Edukasi')

@section('content')

<style>
    /* Styling untuk pencarian biru modern */
    .search-input {
        border: 2px solid #e2e8f0; /* Border tipis halus */
        border-radius: 12px 0 0 12px; /* Lengkungan kiri */
        padding: 10px 15px;
        transition: all 0.3s;
    }
    
    .search-input:focus {
        border-color: #3b82f6; /* Biru saat diklik */
        box-shadow: none;
    }

    .btn-search {
        background-color: #3b82f6; /* Biru Utama */
        color: white;
        border-radius: 0 12px 12px 0; /* Lengkungan kanan */
        padding: 0 20px;
        font-weight: 600;
        transition: background 0.3s;
    }

    .btn-search:hover {
        background-color: #2563eb; /* Biru lebih gelap saat hover */
        color: white;
    }

    .search-wrapper {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border-radius: 14px; /* Container utama melengkung */
    }

    .btn-back-gray {
        background-color: #e2e8f0;
        color: #4a5568;
        padding: 6px 16px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }
    .article-container { max-width: 100%; padding: 24px; }
    
    /* Membatasi lebar filter agar tidak memenuhi layar */
    .filter-wrapper { max-width: 450px; margin-left: auto; }
</style>

<div class="article-container">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-dark">Daftar Artikel Edukasi</h4>
        <a href="{{ route('bumil.dashboard') }}" class="btn-back-gray">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="d-flex justify-content-end mb-4">
    <div style="width: 100%; max-width: 350px;" class="search-wrapper"> 
        <form method="GET" action="{{ route('bumil.artikel') }}">
            <div class="input-group">
                <input type="text" 
                       name="search" 
                       class="form-control search-input" 
                       placeholder="Cari artikel..." 
                       value="{{ request('search') }}">
                
                <button type="submit" class="btn btn-search">
                    Cari
                </button>
            </div>
        </form>
    </div>
</div>

    <!-- Daftar Artikel -->
    <div class="row">
        @forelse($artikels as $artikel)
            <div class="col-12 mb-3">
                <a href="{{ route('bumil.artikel.detail', $artikel->id) }}" class="text-decoration-none text-dark">
                    <div class="bg-white rounded-4 shadow-sm p-3 d-flex align-items-center">
                        <img src="{{ $artikel->gambar ? (str_contains($artikel->gambar, 'artikel-images/') ? Storage::url($artikel->gambar) : asset('build/images/'.$artikel->gambar)) : asset('build/images/usgibuhamil.png') }}" 
                             style="width: 140px; height: 100px; object-fit: cover; border-radius: 15px;" class="me-4">
                        <div class="flex-grow-1">
                            <span class="badge rounded-pill mb-2" style="background:#FFE2EF; color:#F875AA; font-size: 10px;">{{ $artikel->kategori }}</span>
                            <h6 class="fw-bold mb-1">{{ $artikel->judul_edukasi }}</h6>
                            <p class="text-muted small mb-0">{{ Str::limit(strip_tags($artikel->konten_edukasi), 150) }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Artikel tidak ditemukan.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection