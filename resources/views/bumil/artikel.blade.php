@extends('layouts.masterBumil')

@section('title','Daftar Artikel Edukasi')

@section('content')

<div class="container-fluid py-4 px-5">

    <h4 class="fw-bold mb-4">Daftar Artikel Edukasi</h4>

    <form method="GET" action="{{ route('bumil.artikel') }}" class="bg-white rounded-4 shadow-sm p-3 mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Cari artikel..."
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-4">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>

                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn text-white w-100" style="background:#F875AA;">
                    Cari
                </button>
            </div>
        </div>
    </form>

    <div class="row g-4">
        @forelse($artikels as $artikel)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('bumil.artikel.detail', $artikel->id) }}"
                   class="text-decoration-none text-dark">

                    <div class="bg-white rounded-4 shadow-sm h-100 overflow-hidden">

                        @if($artikel->gambar)
                            @if(str_contains($artikel->gambar, 'artikel-images/'))
                                <img src="{{ Storage::url($artikel->gambar) }}"
                                     style="width:100%; height:170px; object-fit:cover;">
                            @else
                                <img src="{{ asset('build/images/' . $artikel->gambar) }}"
                                     style="width:100%; height:170px; object-fit:cover;">
                            @endif
                        @else
                            <img src="{{ asset('build/images/usgibuhamil.png') }}"
                                 style="width:100%; height:170px; object-fit:cover;">
                        @endif

                        <div class="p-3">
                            <span class="badge rounded-pill mb-2"
                                  style="background:#FFE2EF; color:#F875AA;">
                                {{ $artikel->kategori }}
                            </span>

                            <h6 class="fw-bold">
                                {{ $artikel->judul_edukasi }}
                            </h6>

                            <p class="text-muted small mb-0">
                                {{ Str::limit(strip_tags($artikel->konten_edukasi), 100) }}
                            </p>
                        </div>

                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="bg-white rounded-4 shadow-sm p-5 text-center">
                    <p class="text-muted mb-0">Artikel tidak ditemukan.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $artikels->links() }}
    </div>

</div>

@endsection