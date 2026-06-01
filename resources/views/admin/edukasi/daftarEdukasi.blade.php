@extends('layouts.masterAdmin')

@section('title', 'Daftar Edukasi - Admin Bumiloo')

@section('content')
<div class="min-h-screen flex flex-col px-4 py-4" style="background-color: #fcf8fa;">
    <div class="flex-grow">
        
        {{-- HEADER: JUDUL & TOMBOL TAMBAH --}}
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: rgba(244, 114, 182, 0.2) !important;">
            <h2 class="fw-bold text-dark m-0" style="font-size: 28px;">Daftar Edukasi</h2>
            <a href="{{ route('admin.edukasi.create') }}" class="btn text-white px-3 py-2 rounded-3 fw-semibold d-flex align-items-center shadow-sm" style="background-color: #f472b6; font-size: 14px;">
                <i class="bi bi-plus-lg me-1"></i> + Tambah Edukasi
            </a>
        </div>

        {{-- ALERT NOTIFIKASI BERHASIL (TAMBAH/HAPUS) --}}
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center" role="alert" style="background-color: #d1fae5; color: #065f46; border-left: 4px solid #10b981 !important;">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div class="fw-semibold">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        {{-- LIST DATA ARTIKEL EDUKASI --}}
        <div class="row">
            <div class="col-lg-12">
                
                @forelse($artikels as $edu)
                    {{-- CARD CONTAINER --}}
                    <div class="card border rounded-4 p-3 mb-3 shadow-sm position-relative" style="border: 1px solid rgba(244, 114, 182, 0.2) !important; background-color: #ffffff;">
                        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-stretch">
                            
                            {{-- GAMBAR THUMBNAIL (ADAPTIF DATA DUMMY / STORAGE HASIL UPLOAD) --}}
                            <div class="me-3 mb-3 mb-md-0 flex-shrink-0 shadow-sm rounded-3 overflow-hidden" style="width: 180px; height: 120px;">
                                @if($edu->gambar)
                                    @if(str_contains($edu->gambar, 'artikel-images/'))
                                        {{-- Jika hasil upload form Admin (disimpan di storage) --}}
                                        <img src="{{ Storage::url($edu->gambar) }}" alt="{{ $edu->judul_edukasi }}" class="w-100 h-100" style="object-fit: cover;">
                                    @else
                                        {{-- Jika data bawaan awal (diambil langsung dari folder sesuai foto aset Anda) --}}
                                        <img src="{{ asset('build/images/' . $edu->gambar) }}" alt="{{ $edu->judul_edukasi }}" class="w-100 h-100" style="object-fit: cover;">
                                    @endif
                                @else
                                    {{-- Fallback jika tidak ada data gambar sama sekali --}}
                                    <img src="{{ asset('build/images/usgibuhamil.png') }}" alt="Default Image" class="w-100 h-100" style="object-fit: cover;">
                                @endif
                            </div>
                            
                            {{-- BODY INFO --}}
                            <div class="flex-grow-1 d-flex flex-column justify-content-between pe-md-5">
                                <div class="mb-4 mb-md-0">
                                    {{-- JUDUL ARTIKEL --}}
                                    <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">{{ $edu->judul_edukasi }}</h5>
                                    
                                    {{-- TAG KATEGORI --}}
                                    <span class="badge mb-2 px-2 py-1" style="font-size: 11px; border-radius: 6px; background-color: rgba(244, 114, 182, 0.1); color: #ec4899; border: 1px solid rgba(244, 114, 182, 0.2);">
                                        {{ $edu->kategori }}
                                    </span>
                                    
                                    {{-- KONTEN / DESKRIPSI --}}
                                    <p class="text-secondary small mb-0 text-justify" style="line-height: 1.5; font-size: 13px; color: #4b5563 !important;">
                                        {{ Str::limit($edu->konten_edukasi, 230) }}
                                    </p>
                                </div>
                                
                                {{-- WAKTU UPLOAD --}}
                                <div class="text-muted small mt-2" style="font-size: 11px; font-weight: 500;">
                                    <i class="bi bi-clock me-1"></i> {{ $edu->created_at->diffForHumans() }}
                                </div>
                            </div>
                            
                            {{-- TOMBOL AKSI (EDIT & HAPUS) --}}
                            <div class="position-absolute bottom-0 end-0 m-3 d-flex gap-2">
                                {{-- Tombol Edit --}}
                            <a href="{{ route('admin.edukasi.edit', $edu->id) }}" 
                                class="btn btn-sm text-dark px-3 py-1.5 d-flex align-items-center fw-bold shadow-sm" 
                                style="font-size: 12px; background-color: #ffda6a; border: none; border-radius: 8px;">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </a>
                                
    {{-- Tombol Hapus --}}
    <form action="{{ route('admin.edukasi.destroy', $edu->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel edukasi ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm text-white px-3 py-1.5 d-flex align-items-center fw-bold shadow-sm" style="font-size: 12px; background-color: #ef4444; border: none; border-radius: 8px;">
            <i class="bi bi-trash me-1"></i> Hapus
        </button>
    </form>
</div>

                        </div>
                    </div>
                @empty
                    {{-- KONDISI JIKA TIDAK ADA DATA --}}
                    <div class="text-center p-5 bg-white rounded-4 border border-dashed shadow-sm" style="border-color: rgba(244, 114, 182, 0.3) !important;">
                        <i class="bi bi-book text-muted" style="font-size: 48px; color: #f472b6 !important;"></i>
                        <p class="text-muted mt-2 mb-0 fw-semibold">Belum ada data edukasi yang ditambahkan.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</div>
@endsection