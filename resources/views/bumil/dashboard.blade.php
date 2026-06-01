@extends('layouts.masterBumil')

@section('title', 'Beranda Bumiloo')

@section('content')
{{-- Tambahkan pembungkus dengan flex-col dan min-h-screen --}}
<div class="min-h-screen flex flex-col">
    <div class="flex-grow">
        <div class="row">
            {{-- ===== LEFT COLUMN ===== --}}
            <div class="col-lg-8 col-left">
                {{-- HERO BANNER --}}
                <div class="hero-banner mb-4">
                    <img src="{{ asset('images/frame65.png') }}" alt="Hero Banner" class="img-fluid rounded-4 shadow-sm">
                </div>

                {{-- GANTI FOREACH LAMA KAMU DENGAN BLOK FORELSE INI --}}
@forelse($artikels as $artikel)
    <div class="artikel-card d-flex bg-white p-3 rounded-4 shadow-sm mb-3 align-items-center">
        <div class="artikel-thumb me-3">
            @if($artikel->gambar)
                @if(str_contains($artikel->gambar, 'artikel-images/'))
                    {{-- Gambar baru hasil upload admin --}}
                    <img src="{{ Storage::url($artikel->gambar) }}" alt="{{ $artikel->judul_edukasi }}" class="rounded-3" width="120" height="80" style="object-fit: cover;">
                @else
                    {{-- Gambar dummy bawaan di folder public/build/images/ --}}
                    <img src="{{ asset('build/images/' . $artikel->gambar) }}" alt="{{ $artikel->judul_edukasi }}" class="rounded-3" width="120" height="80" style="object-fit: cover;">
                @endif
            @else
                <img src="{{ asset('build/images/usgibuhamil.png') }}" alt="Default Image" class="rounded-3" width="120" height="80" style="object-fit: cover;">
            @endif
        </div>
        <div class="artikel-body flex-grow-1">
            {{-- Menggunakan kolom dari database kamu --}}
            <div class="artikel-title fw-bold text-dark">{{ $artikel->judul_edukasi }}</div>
            <div class="artikel-desc text-muted small">{{ Str::limit($artikel->konten_edukasi, 120) }}</div>
        </div>
        <div class="artikel-bookmark text-pink" onclick="toggleBookmark(this)" style="cursor: pointer;" title="Simpan">
            <i class="bi bi-bookmark text-secondary"></i>
        </div>
    </div>
@empty
    <div class="text-center p-5 bg-white rounded-4 shadow-sm mb-3">
        <p class="text-muted mb-0">Belum ada artikel edukasi yang tersedia.</p>
    </div>
@endforelse

{{-- GANTI FOREACH ARTIKEL POPULER LAMA DENGAN INI --}}
@forelse($populer as $index => $p)
    <div class="popular-item d-flex align-items-center mb-3">
        <div class="popular-rank me-3">
            {{-- Mengubah index urutan loop menjadi format penulisan angka 01, 02, dst --}}
            <span class="badge bg-light text-dark shadow-sm">{{ sprintf('%02d', $index + 1) }}</span>
        </div>
        <div class="popular-thumb me-3">
            @if($p->gambar)
                @if(str_contains($p->gambar, 'artikel-images/'))
                    <img src="{{ Storage::url($p->gambar) }}" alt="{{ $p->judul_edukasi }}" class="rounded shadow-sm" width="60" height="40" style="object-fit: cover;">
                @else
                    <img src="{{ asset('build/images/' . $p->gambar) }}" alt="{{ $p->judul_edukasi }}" class="rounded shadow-sm" width="60" height="40" style="object-fit: cover;">
                @endif
            @else
                <img src="{{ asset('build/images/usgibuhamil.png') }}" alt="Default Image" class="rounded shadow-sm" width="60" height="40" style="object-fit: cover;">
            @endif
        </div>
        <div class="popular-info">
            {{-- Menggunakan kolom dari database kamu --}}
            <div class="popular-title fw-bold small text-dark">{{ \Str::limit($p->judul_edukasi, 35) }}</div>
            <div class="popular-time text-muted mt-1" style="font-size: 10px;">{{ $p->created_at->diffForHumans() }}</div>
        </div>
    </div>
@empty
    <p class="text-muted small mb-0">Belum ada artikel populer.</p>
@endforelse
        
@endsection