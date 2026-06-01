@extends('layouts.masterBumil')

@section('title',$artikel->judul_edukasi)

@section('content')

<div class="container-fluid py-4">

    <a href="{{ route('bumil.artikel') }}"
       class="btn btn-secondary mb-3">
       ← Kembali
    </a>

    <div class="bg-white rounded-4 shadow-sm p-4">

        <h3 class="fw-bold mb-3">
            {{ $artikel->judul_edukasi }}
        </h3>

        <span class="badge bg-pink mb-3">
            {{ $artikel->kategori }}
        </span>

        @if($artikel->gambar)

            <img src="{{ Storage::url($artikel->gambar) }}"
                 class="img-fluid rounded mb-4">

        @endif

        <div>
            {!! nl2br(e($artikel->konten_edukasi)) !!}
        </div>

    </div>

</div>

@endsection