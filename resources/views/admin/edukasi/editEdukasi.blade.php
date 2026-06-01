@extends('layouts.masterAdmin')

@section('content')
<div class="container-fluid py-4 px-5" style="background-color: #ffffff; min-height: 100vh;">
    
    {{-- Judul Halaman --}}
    <div class="mb-4">
        <h2 class="fw-bold text-dark" style="font-size: 28px; font-family: 'Poppins', sans-serif;">Edit Edukasi</h2>
    </div>

    {{-- Form Utama --}}
    <form action="{{ route('admin.edukasi.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Baris Judul Edukasi --}}
        <div class="row mb-4 align-items-center">
            <div class="col-md-2">
                <label for="judul_edukasi" class="form-label fw-bold text-dark mb-0" style="font-size: 16px;">Judul Edukasi</label>
            </div>
            <div class="col-md-8">
                <input type="text" 
                       class="form-control @error('judul_edukasi') is-invalid @enderror shadow-sm" 
                       id="judul_edukasi" 
                       name="judul_edukasi" 
                       value="{{ old('judul_edukasi', $artikel->judul_edukasi) }}" 
                       style="border-radius: 10px; border: 1px solid #ced4da; padding: 12px 20px; font-size: 15px;" 
                       required>
                @error('judul_edukasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Baris Kategori --}}
        <div class="row mb-4 align-items-center">
            <div class="col-md-2">
                <label for="kategori" class="form-label fw-bold text-dark mb-0" style="font-size: 16px;">Kategori</label>
            </div>
            <div class="col-md-8">
                <input type="text" 
                       class="form-control @error('kategori') is-invalid @enderror shadow-sm" 
                       id="kategori" 
                       name="kategori" 
                       value="{{ old('kategori', $artikel->kategori) }}" 
                       style="border-radius: 10px; border: 1px solid #ced4da; padding: 12px 20px; font-size: 15px;" 
                       required>
                @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Baris Konten Edukasi --}}
        <div class="row mb-4 align-items-start">
            <div class="col-md-2 pt-2">
                <label for="konten_edukasi" class="form-label fw-bold text-dark mb-0" style="font-size: 16px;">Konten Edukasi</label>
            </div>
            <div class="col-md-8">
                <textarea class="form-control @error('konten_edukasi') is-invalid @enderror shadow-sm" 
                          id="konten_edukasi" 
                          name="konten_edukasi" 
                          rows="6" 
                          style="border-radius: 12px; border: 1px solid #ced4da; padding: 15px 20px; font-size: 15px; line-height: 1.6;" 
                          required>{{ old('konten_edukasi', $artikel->konten_edukasi) }}</textarea>
                @error('konten_edukasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Baris Upload Gambar --}}
        <div class="row mb-4 align-items-start">
            <div class="col-md-2 pt-2">
                <label class="form-label fw-bold text-dark mb-0" style="font-size: 16px;">Upload Gambar</label>
            </div>
            <div class="col-md-8">
                <div class="d-flex flex-column gap-3">
                    {{-- Tombol Custom File Picker ala Khas Bumiloo --}}
                    <div class="position-relative">
                        <input type="file" 
                               class="form-control @error('gambar') is-invalid @enderror" 
                               id="gambar" 
                               name="gambar" 
                               style="display: none;" 
                               onchange="document.getElementById('file-chosen').textContent = this.files[0].name">
                        <button type="button" 
                                class="btn text-white fw-bold px-4 py-2 shadow-sm" 
                                onclick="document.getElementById('gambar').click()" 
                                style="background-color: #f472b6; border: none; border-radius: 8px; font-size: 14px;">
                            Pilih Gambar
                        </button>
                        <span id="file-chosen" class="text-muted ms-2" style="font-size: 13px;">Belum ada berkas dipilih</span>
                    </div>

                    {{-- Kontainer Preview Gambar Lama --}}
                    @if($artikel->gambar)
                        <div class="mt-1">
                            <img src="{{ asset('storage/' . $artikel->gambar) }}" 
                                 alt="Preview Gambar" 
                                 class="shadow-sm rounded" 
                                 style="max-width: 320px; height: auto; border-radius: 12px; display: block;">
                            <small class="text-muted d-block mt-2" style="font-size: 13px;">*Ukuran Gambar Maksimal 2 MB</small>
                        </div>
                    @endif
                    
                    @error('gambar')
                        <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Baris Tombol Aksi Akhir --}}
        <div class="row mt-5">
            <div class="col-md-10 d-flex justify-content-end gap-3">
                <a href="{{ route('admin.edukasi') }}" 
                   class="btn btn-light fw-bold px-4 py-2 border text-muted shadow-sm" 
                   style="border-radius: 8px; font-size: 14px;">
                    Batal
                </a>
                <button type="submit" 
                        class="btn text-white fw-bold px-4 py-2 d-flex align-items-center gap-1 shadow-sm" 
                        style="background-color: #f472b6; border: none; border-radius: 8px; font-size: 14px;">
                    <i class="bi bi-box-arrow-in-down" style="font-size: 16px;"></i> Update
                </button>
            </div>
        </div>
    </form>
</div>
@endsection