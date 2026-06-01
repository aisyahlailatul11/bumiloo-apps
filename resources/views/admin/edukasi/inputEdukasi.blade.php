@extends('layouts.masterAdmin')

@section('title', 'Tambah Edukasi - Bumiloo')

@section('content')
<style>
    /* Paksa tombol menu Input Edukasi di sidebar agar aktif putih transparan */
    .sidebar-bumiloo .sidebar-menu-list li a.menu-link:has(.fa-book-open),
    a[href*="edukasi"] {
        background-color: rgba(255, 255, 255, 0.25) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
    }

    /* Container utama agar konten tidak terlalu menempel ke pinggir */
    .content-container {
        padding: 40px;
        box-sizing: border-box;
        width: 100%;
    }

    /* Card Box Putih Utama */
    .form-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 40px;
        border: 1px solid rgba(244, 114, 182, 0.15);
        width: 100%;
        box-sizing: border-box;
    }

    .form-title {
        font-size: 32px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 36px;
    }

    /* Struktur Grid Form Baris (Label Kiri, Input Kanan) */
    .form-row-grid {
        display: grid;
        grid-template-columns: 220px 1fr;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .form-row-grid-top {
        display: grid;
        grid-template-columns: 220px 1fr;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 24px;
    }

    .form-label-custom {
        font-size: 15px;
        font-weight: 700;
        color: #374151;
        margin: 0;
    }

    /* Input & Textarea Styling */
    .input-custom-field {
        width: 100%;
        padding: 14px 18px;
        border-radius: 12px;
        border: 1.5px solid #e5e7eb;
        font-size: 14px;
        outline: none;
        transition: all 0.2s ease;
        background-color: #fbfbfb;
        box-sizing: border-box;
    }

    .input-custom-field:focus {
        border-color: #f472b6;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(244, 114, 182, 0.15);
    }

    /* Desain Tombol Pilih Gambar Pink */
    .btn-choose-image {
        cursor: pointer;
        background-color: #f472b6;
        color: white;
        font-size: 14px;
        font-weight: 700;
        padding: 10px 20px;
        border-radius: 10px;
        display: inline-block;
        border: none;
        transition: background 0.2s;
    }

    .btn-choose-image:hover {
        background-color: #ec4899;
    }

    /* Box Pratinjau Gambar */
    .preview-image-box {
        margin-top: 14px;
        border: 1.5px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        width: 280px; 
        height: 165px; 
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f9fafb;
    }

    .preview-image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .info-size-text {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 6px;
        font-weight: 500;
    }

    /* Tombol Simpan di Kanan Bawah */
    .action-row-footer {
        display: flex;
        justify-content: flex-end;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1.5px solid #f3f4f6;
    }

    .btn-submit-pink {
        background-color: #f472b6;
        color: white;
        font-weight: 700;
        font-size: 14px;
        padding: 12px 28px;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-submit-pink:hover {
        background-color: #ec4899;
        transform: translateY(-1px);
    }
</style>

<div class="content-container">
    <div class="form-card">
        <h2 class="form-title">Tambah Edukasi</h2>

        {{-- Flash Message Sukses --}}
        @if(session('success'))
            <div style="margin-bottom: 20px; padding: 16px; background-color: #d1fae5; border-left: 4px solid #10b981; color: #065f46; border-radius: 0 12px 12px 0; font-size: 14px; font-weight: 600;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Validasi Form --}}
        @if ($errors->any())
            <div style="margin-bottom: 20px; padding: 16px; background-color: #fee2e2; border-left: 4px solid #ef4444; color: #991b1b; border-radius: 0 12px 12px 0; font-size: 14px; font-weight: 600;">
                <ul style="list-style-type: disc; padding-left: 20px; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Tag Pembuka yang Benar (Membungkus Seluruh Elemen Form hingga Footer) --}}
        <form action="{{ route('admin.edukasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Input Judul Edukasi --}}
            <div class="form-row-grid">
                <label for="judul_edukasi" class="form-label-custom">Judul Edukasi</label>
                <div>
                    <input type="text" id="judul_edukasi" name="judul_edukasi" placeholder="Masukkan Judul Edukasi..." required class="input-custom-field">
                </div>
            </div>

            {{-- Input Kategori --}}
            <div class="form-row-grid">
                <label for="kategori" class="form-label-custom">Kategori</label>
                <div>
                    <input type="text" id="kategori" name="kategori" placeholder="Masukkan Kategori Edukasi..." required class="input-custom-field">
                </div>
            </div>

            {{-- Input Konten Edukasi --}}
            <div class="form-row-grid-top">
                <label for="konten_edukasi" class="form-label-custom" style="margin-top: 10px;">Konten Edukasi</label>
                <div>
                    <textarea id="konten_edukasi" name="konten_edukasi" placeholder="Masukkan Konten Edukasi..." required class="input-custom-field" style="resize: none; height: 160px;"></textarea>
                </div>
            </div>

            {{-- Upload Gambar Berkas --}}
            <div class="form-row-grid-top">
                <label class="form-label-custom" style="margin-top: 10px;">Upload Gambar</label>
                <div>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <label for="gambar" class="btn-choose-image">Pilih Gambar</label>
                        <input type="file" id="gambar" name="gambar" accept="image/*" style="display: none;" onchange="previewImage(event)">
                        <span id="file-name" style="font-size: 14px; color: #6b7280; font-weight: 600;">Tidak ada file yang dipilih</span>
                    </div>
                    
                    <div class="preview-image-box">
                        <img id="output_image" src="{{ asset('build/images/usgibuhamil.png') }}" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%23ccc\' stroke-width=\'1.5\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg>'" />
                    </div>
                    
                    <p class="info-size-text">*Ukuran Gambar Maksimal 2 MB</p>
                </div>
            </div>

            {{-- Action Row Footer Di dalam Tag Form --}}
            <div class="action-row-footer">
                <button type="submit" class="btn-submit-pink">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        const imageField = document.getElementById('output_image');
        const fileNameSpan = document.getElementById('file-name');

        if (event.target.files.length > 0) {
            fileNameSpan.textContent = event.target.files[0].name;
        }

        reader.onload = function() {
            if (reader.readyState === 2) {
                imageField.src = reader.result;
            }
        }
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection