@extends('layouts.masterBumil')

@section('title', $artikel->judul_edukasi)

@section('content')
<style>
    .btn-back-gray {
        background-color: #e2e8f0;
        color: #4a5568;
        padding: 8px 20px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: background 0.2s;
    }
    .btn-back-gray:hover {
        background-color: #cbd5e0;
        color: #2d3748;
    }
    /* Memastikan card tidak terlalu mepet dengan tombol */
    .article-detail-card {
        margin-top: 20px;
    }
</style>

<div class="container-fluid py-4">
    <!-- Tombol Kembali diletakkan di container terpisah agar posisinya stabil -->
    <div class="mb-4">
        <a href="{{ route('bumil.artikel') }}" class="btn-back-gray">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-4 shadow-sm p-4 article-detail-card">
        <h3 class="fw-bold mb-4">{{ $artikel->judul_edukasi }}</h3>

        <span class="badge bg-pink mb-3">
            {{ $artikel->kategori }}
        </span>

        @if($artikel->gambar)
            <img src="{{ Storage::url($artikel->gambar) }}"
                 class="img-fluid rounded mb-4" 
                 alt="{{ $artikel->judul_edukasi }}">
        @endif

        {{-- BAGIAN YANG DIPERBAIKI: Menggunakan font Poppins agar teks cetakan editor rapi --}}
        <div class="content-edukasi-render" style="font-family: 'Poppins', sans-serif; color: #374151; font-size: 16px; line-height: 1.8;">
            {!! $artikel->konten_edukasi !!}
        </div>

    </div>
</div>

@endsection