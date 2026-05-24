@extends('layouts.masterBumil')

@section('title', 'Beranda Bumiloo')

@section('content')
<div class="row">
    {{-- ===== LEFT COLUMN ===== --}}
    <div class="col-lg-8 col-left">

        {{-- HERO BANNER --}}
        <div class="hero-banner mb-4">
            <img src="{{ asset('images/frame65.png') }}" alt="Hero Banner" class="img-fluid rounded-4 shadow-sm">
            <div class="mt-2 text-end">
                <a href="#" class="hero-btn text-decoration-none fw-bold text-pink">Baca artikel hari ini →</a>
            </div>
        </div>

        {{-- DAFTAR ARTIKEL --}}
        <div class="section-heading h4 fw-bold mb-3">Daftar Artikel</div>

        @php
            $artikels = [
                [
                    'img'   => asset('images/ibumual.png'),
                    'title' => 'Alasan mual dan muntah saat hamil',
                    'desc'  => 'Beberapa penyebab terjadinya rasa mual dan muntah pada ibu hamil, beserta cara mengatasinya.',
                ],
                [
                    'img'   => asset('images/ibupusing.png'),
                    'title' => 'Cara mengatasi sakit kepala',
                    'desc'  => 'Beberapa cara ampuh mengatasi sakit kepala pada ibu hamil.',
                ],
                [
                    'img'   => asset('images/gayahidup.png'),
                    'title' => 'Gaya hidup sehat saat hamil',
                    'desc'  => 'Panduan gaya hidup sehat untuk ibu hamil.',
                ],
                [
                    'img'   => asset('images/ibuolahraga.png'),
                    'title' => 'Olahraga yang aman untuk ibu hamil',
                    'desc'  => 'Rekomendasi olahraga yang aman untuk ibu dan bayi.',
                ],
                [
                    'img'   => asset('images/ibukonsul.png'),
                    'title' => 'Konsultasi rutin dengan dokter dan bidan',
                    'desc'  => 'Konsultasi rutin dengan dokter dan bidan membantu ibu mengetahui perkembangan si kecil.',
                ],
            ];
        @endphp

        @foreach($artikels as $artikel)
            <div class="artikel-card d-flex bg-white p-3 rounded-4 shadow-sm mb-3 align-items-center">
                <div class="artikel-thumb me-3">
                    <img src="{{ $artikel['img'] }}" alt="{{ $artikel['title'] }}" class="rounded-3" width="120" height="80" style="object-fit: cover;">
                </div>
                <div class="artikel-body flex-grow-1">
                    <div class="artikel-title fw-bold text-dark">{{ $artikel['title'] }}</div>
                    <div class="artikel-desc text-muted small">{{ $artikel['desc'] }}</div>
                </div>
                <div class="artikel-bookmark text-pink" onclick="toggleBookmark(this)" style="cursor: pointer;" title="Simpan">
                    <i class="bi bi-bookmark text-secondary"></i>
                </div>
            </div>
        @endforeach

    </div>{{-- /col-left --}}


    {{-- ===== RIGHT COLUMN ===== --}}
    <div class="col-lg-4 col-right">

        {{-- ARTIKEL TERPOPULER --}}
        <div class="rc-card bg-white p-4 rounded-4 shadow-sm mb-4 border-0">
            <div class="rc-card-title fw-bold mb-3" style="color: #f687b3;">Artikel Terpopuler</div>

            @php
            $populer = [
                ['rank' => '01', 'img' => asset('images/makanansehatbumil.png'), 'title' => 'Tips memilih camilan sehat untuk Bunda', 'time' => '6 menit yang lalu'],
                ['rank' => '02', 'img' => asset('images/olahragabumil.png'), 'title' => 'Olahraga yang aman untuk Bunda', 'time' => '6 menit yang lalu'],
                ['rank' => '03', 'img' => asset('images/pantaukondisibayi.png'), 'title' => 'Pantau kondisi si kecil bersama kami', 'time' => '6 menit yang lalu'],
                ['rank' => '04', 'img' => asset('images/ukuranbayi.png'), 'title' => 'Ketahui ukuran si kecil setiap minggunya', 'time' => '6 menit yang lalu'],
                ['rank' => '05', 'img' => asset('images/ajakbayingobrol.png'), 'title' => 'Bunda, ajak si kecil bicara', 'time' => '6 menit yang lalu'],
            ];
            @endphp

            @foreach($populer as $p)
            <div class="popular-item d-flex align-items-center mb-3">
                <div class="popular-rank me-3">
                    <span class="badge bg-light text-dark shadow-sm">{{ $p['rank'] }}</span>
                </div>
                <div class="popular-thumb me-3">
                    <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}" class="rounded shadow-sm" width="60" height="40" style="object-fit: cover;">
                </div>
                <div class="popular-info">
                    <div class="popular-title fw-bold small text-dark">{{ \Str::limit($p['title'], 35) }}</div>
                    <div class="popular-time text-muted mt-1" style="font-size: 10px;">{{ $p['time'] }}</div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- REKOMENDASI --}}
        <div class="rekomen-card text-white p-4 rounded-4 shadow-sm mb-4 position-relative overflow-hidden" style="background-color: #f687b3;">
            <div class="rekomen-card-title fw-bold h5">Rekomendasi untuk Bunda</div>
            <div class="rekomen-card-desc small mb-3">Temukan artikel yang sesuai dengan kebutuhan Bunda.</div>
            <a href="#" class="btn btn-light btn-sm rounded-pill px-3 fw-bold" style="color: #f687b3;">Lihat Rekomendasi</a>
            <div class="rekomen-illustration position-absolute end-0 bottom-0 opacity-25">
                <img src="{{ asset('images/checklist.png') }}" alt="Checklist" width="80">
            </div>
        </div>

        {{-- KATEGORI POPULER --}}
        <div class="rc-card bg-white p-4 rounded-4 shadow-sm border-0">
            <div class="rc-card-header d-flex justify-content-between align-items-center mb-3">
                <div class="rc-card-title fw-bold">Kategori Populer</div>
                <a href="#" class="link-semua text-decoration-none small" style="color: #f687b3;">Lihat semua</a>
            </div>
            <div class="tag-wrap d-flex flex-wrap gap-2">
                <span class="badge rounded-pill bg-info text-white px-3 py-2">Olahraga</span>
                <span class="badge rounded-pill bg-warning text-dark px-3 py-2">Rutinitas Bunda</span>
                <span class="badge rounded-pill bg-success text-white px-3 py-2">Makanan sehat</span>
                <span class="badge rounded-pill bg-primary text-white px-3 py-2">Kesehatan si kecil</span>
                <span class="badge rounded-pill bg-danger text-white px-3 py-2">Nutrisi</span>
            </div>
        </div>

    </div>{{-- /col-right --}}
</div>
@endsection