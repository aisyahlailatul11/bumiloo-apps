@extends('layouts.masterBumil')
@section('title', 'Beranda Bumiloo')

@section('content')
<style>
    .dashboard-bumil {
        padding: 24px;
        width: 100%;
    }
    .artikel-horizontal-scroll {
        display: flex; 
        overflow-x: auto; 
        gap: 20px; 
        padding-bottom: 20px; 
        scrollbar-width: none;
        width: 100%; /* Pastikan full width */
    }

    .artikel-card-v2 {
        min-width: 320px; /* Sedikit lebih lebar biar pas */
        flex: 0 0 auto; 
    }
    /* Hero Banner */
    .hero-banner { background: linear-gradient(135deg, #FFD1E6 0%, #FFAEC9 100%); border-radius: 26px; padding: 30px 40px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; }
    .banner-title { font-size: 32px; font-weight: 800; line-height: 1.2; margin-bottom: 10px; }
    .banner-image-wrapper img { height: 220px; object-fit: contain; }

    /* Edukasi Section */
    .edu-section { margin-top: 10px; }
    .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }

    .artikel-card-v2:hover { transform: translateY(-5px); }
    .artikel-img-v2 { width: 100%; height: 150px; object-fit: cover; border-radius: 20px 20px 0 0; }
    .artikel-body-v2 { padding: 15px; }
    .artikel-kategori { background: #fee2e2; color: #f84f8f; padding: 3px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; }
</style>

<div class="dashboard-bumil">
    {{-- Banner Utama --}}
    <div class="hero-banner">
    <div class="banner-text">
        <h2 class="banner-title">
    <span class="banner-quote-icon">“</span> 
    Setiap detik yang Bunda lalui adalah perjalanan indah menuju pelukan Si Kecil. 
    <span class="banner-quote-icon">”</span>
</h2>
        <p class="banner-sub">
            Bumiloo hadir menemani setiap momen spesial kehamilan Bunda dengan edukasi terpercaya.
        </p>
    </div>
    <div class="banner-image-wrapper">
        <img src="{{ asset('images/gambardashboard.png') }}" alt="Ilustrasi Ibu Hamil">
    </div>
</div>

    {{-- Section Edukasi --}}
    <div class="edu-section">
        <div class="section-header">
            <h4 class="fw-bold mb-0">Edukasi untuk Bunda</h4>
            <a href="{{ route('bumil.artikel') }}" class="btn btn-sm text-white px-3" style="background: #F84F8F; border-radius: 20px;">Selengkapnya</a>
        </div>

        <div class="artikel-horizontal-scroll">
            @forelse($artikels as $artikel)
                <a href="{{ route('bumil.artikel.detail', $artikel->id) }}" class="artikel-card-v2">
                    <img src="{{ $artikel->gambar ? (str_contains($artikel->gambar, 'artikel-images/') ? Storage::url($artikel->gambar) : asset('build/images/'.$artikel->gambar)) : asset('build/images/usgibuhamil.png') }}" class="artikel-img-v2" alt="Artikel">
                    <div class="artikel-body-v2">
                        <span class="artikel-kategori">{{ $artikel->kategori }}</span>
                        <div class="fw-bold mt-2" style="font-size: 15px; color: #333;">{{ Str::limit($artikel->judul_edukasi, 40) }}</div>
                        <div class="text-muted" style="font-size: 12px; margin-top: 5px;">{{ Str::limit(strip_tags($artikel->konten_edukasi), 60) }}</div>
                    </div>
                </a>
            @empty
                <p class="text-muted">Belum ada artikel edukasi.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection