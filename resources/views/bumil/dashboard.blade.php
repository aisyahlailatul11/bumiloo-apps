@extends('layouts.masterBumil')

@section('title', 'Beranda Bumiloo')

@section('content')

<style>
    .dashboard-bumil {
        padding: 24px 36px;
    }

    .hero-banner img {
        width: 100%;
        max-height: 260px;
        object-fit: cover;
        border-radius: 26px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 28px 0 18px;
    }

    .section-title {
        font-weight: 800;
        color: #222;
        margin: 0;
    }

    .btn-selengkapnya {
        background: #f46aa8;
        color: white;
        border-radius: 30px;
        padding: 10px 22px;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
    }

    .btn-selengkapnya:hover {
        background: #e85b9c;
        color: white;
    }

    .artikel-card {
        background: white;
        border-radius: 22px;
        padding: 14px;
        display: flex;
        gap: 18px;
        align-items: center;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        margin-bottom: 16px;
        transition: 0.2s;
    }

    .artikel-card:hover {
        transform: translateY(-3px);
        color: inherit;
    }

    .artikel-img {
        width: 155px;
        height: 105px;
        border-radius: 18px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .artikel-kategori {
        background: #ffe1ef;
        color: #f062a6;
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 700;
    }

    .artikel-title {
        font-size: 18px;
        font-weight: 800;
        margin: 8px 0 6px;
        color: #222;
    }

    .artikel-desc {
        color: #666;
        font-size: 14px;
        line-height: 1.5;
    }
</style>

<div class="dashboard-bumil">

    <div class="hero-banner">
        <img src="{{ asset('images/frame65.png') }}" alt="Banner Bumiloo">
    </div>

    <div class="section-header">
        <h4 class="section-title">Edukasi untuk Bunda</h4>

        <a href="{{ route('bumil.artikel') }}" class="btn-selengkapnya">
            Selengkapnya
        </a>
    </div>

    @forelse($artikels as $artikel)
        <a href="{{ route('bumil.artikel.detail', $artikel->id) }}" class="artikel-card">

            @if($artikel->gambar)
                @if(str_contains($artikel->gambar, 'artikel-images/'))
                    <img src="{{ Storage::url($artikel->gambar) }}" class="artikel-img" alt="{{ $artikel->judul_edukasi }}">
                @else
                    <img src="{{ asset('build/images/' . $artikel->gambar) }}" class="artikel-img" alt="{{ $artikel->judul_edukasi }}">
                @endif
            @else
                <img src="{{ asset('build/images/usgibuhamil.png') }}" class="artikel-img" alt="Default">
            @endif

            <div>
                <span class="artikel-kategori">{{ $artikel->kategori }}</span>

                <div class="artikel-title">
                    {{ $artikel->judul_edukasi }}
                </div>

                <div class="artikel-desc">
                    {{ Str::limit(strip_tags($artikel->konten_edukasi), 130) }}
                </div>
            </div>
        </a>
    @empty
        <div class="bg-white rounded-4 shadow-sm p-5 text-center">
            <p class="text-muted mb-0">Belum ada artikel edukasi.</p>
        </div>
    @endforelse

</div>

@endsection