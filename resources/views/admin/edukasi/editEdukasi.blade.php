@extends('layouts.masterAdmin')

@section('title', 'Edit Edukasi - Bumiloo')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />

<style>
    .content-container { padding: 40px; box-sizing: border-box; width: 100%; }
    .form-card { background: #ffffff; border-radius: 20px; padding: 40px; border: 1px solid rgba(244, 114, 182, 0.15); width: 100%; box-sizing: border-box; }
    .form-title { font-size: 32px; font-weight: 800; color: #1f2937; margin-bottom: 36px; }
    .form-row-grid { display: grid; grid-template-columns: 220px 1fr; align-items: center; gap: 20px; margin-bottom: 24px; }
    .form-row-grid-top { display: grid; grid-template-columns: 220px 1fr; align-items: flex-start; gap: 20px; margin-bottom: 24px; }
    .form-label-custom { font-size: 15px; font-weight: 700; color: #374151; margin: 0; }
    .input-custom-field { width: 100%; padding: 14px 18px; border-radius: 12px; border: 1.5px solid #e5e7eb; font-size: 14px; outline: none; background-color: #fbfbfb; box-sizing: border-box; font-family: 'Poppins', sans-serif; transition: all 0.2s; }
    .input-custom-field:focus { border-color: #f472b6; background-color: #ffffff; box-shadow: 0 0 0 4px rgba(244, 114, 182, 0.15); }
    
    /* Styling Kustom Toolbar & Teks Editor Berbasis Font Poppins */
    .ql-toolbar.ql-snow { border-top-left-radius: 12px; border-top-right-radius: 12px; border: 1.5px solid #e5e7eb !important; background: #ffffff; font-family: 'Poppins', sans-serif !important; }
    .ql-toolbar.ql-snow .ql-size { font-family: 'Poppins', sans-serif !important; font-weight: 600; color: #4b5563; }
    .ql-container.ql-snow { border-bottom-left-radius: 12px; border-bottom-right-radius: 12px; border: 1.5px solid #e5e7eb !important; min-height: 250px; background: #fbfbfb; }
    
    /* Paksa Placeholder dan Isi Editor Menggunakan Poppins */
    .ql-editor { font-family: 'Poppins', sans-serif !important; font-size: 15px; }
    .ql-editor.ql-blank::before { font-family: 'Poppins', sans-serif !important; font-style: normal !important; color: #9ca3af !important; font-size: 15px; }

    .btn-choose-image { cursor: pointer; background-color: #f472b6; color: white; font-size: 14px; font-weight: 700; padding: 10px 20px; border-radius: 10px; display: inline-block; }
    .preview-image-box { margin-top: 14px; border: 1.5px solid #e5e7eb; border-radius: 16px; overflow: hidden; width: 280px; height: 165px; display: flex; align-items: center; justify-content: center; background-color: #f9fafb; }
    .preview-image-box img { width: 100%; height: 100%; object-fit: cover; }
    
    .action-row-footer { display: flex; justify-content: flex-end; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 1.5px solid #f3f4f6; }
    .btn-submit-blue { background-color: #3b82f6; color: white; font-weight: 700; font-size: 14px; padding: 12px 28px; border-radius: 12px; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; font-family: 'Poppins', sans-serif; }
    .btn-submit-blue:hover { background-color: #2563eb; }
    .btn-kembali { background-color: #f3f4f6; color: #4b5563; font-weight: 700; font-size: 14px; padding: 12px 28px; border-radius: 12px; text-decoration: none; display: flex; align-items: center; gap: 8px; }
    .btn-kembali:hover { background-color: #e5e7eb; }

    /* Desain Input Kategori Baru */
    .kategori-wrapper { display: flex; flex-direction: column; gap: 10px; width: 100%; }
    .input-baru-container { display: none; margin-top: 5px; animation: fadeIn 0.3s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="content-container">
    <div class="form-card">
        <h2 class="form-title">Edit Artikel Edukasi</h2>

        @if ($errors->any())
            <div style="margin-bottom: 20px; padding: 16px; background-color: #fee2e2; border-left: 4px solid #ef4444; color: #991b1b; border-radius: 8px; font-size: 14px; font-weight: 600;">
                <ul style="list-style-type: disc; padding-left: 20px; margin: 0;">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.edukasi.update', $artikel->id) }}" method="POST" enctype="multipart/form-data" id="formEditEdukasi">
            @csrf
            @method('PUT')
            
            <div class="form-row-grid">
                <label for="judul_edukasi" class="form-label-custom">Judul Edukasi</label>
                <div>
                    <input type="text" id="judul_edukasi" name="judul_edukasi" value="{{ $artikel->judul_edukasi }}" required class="input-custom-field">
                </div>
            </div>

            <div class="form-row-grid">
                <label for="kategori_select" class="form-label-custom">Kategori</label>
                <div class="kategori-wrapper">
                    {{-- Select Pilihan Utama --}}
                    <select id="kategori_select" name="kategori" class="input-custom-field" required onchange="checkNewCategory(this)">
                        @php
                            $defaultKategori = ['Kebugaran', 'Kesehatan Bayi', 'Makanan Sehat', 'Kehamilan'];
                            $currentKategori = $artikel->kategori;
                        @endphp
                        
                        {{-- Render List Default --}}
                        @foreach($defaultKategori as $kat)
                            <option value="{{ $kat }}" {{ $currentKategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach

                        {{-- Jika kategori saat ini adalah kategori kustom di luar bawaan, tampilkan sebagai pilihan aktif --}}
                        @if(!in_repeat_check($currentKategori, $defaultKategori))
                            <option value="{{ $currentKategori }}" selected>{{ $currentKategori }}</option>
                        @endif

                        <option value="buat_baru" style="font-weight: bold; color: #f472b6;">+ Tambah Kategori Baru...</option>
                    </select>

                    {{-- Input Teks Tambahan yang Muncul Jika Klik Tambah Kategori Baru --}}
                    <div id="kategori_baru_container" class="input-baru-container">
                        <input type="text" id="kategori_baru" placeholder="Tulis nama kategori baru..." class="input-custom-field" style="border-color: #f472b6; background-color: #fffafc;">
                        <small style="color: #f472b6; font-size: 12px; margin-top: 4px; display: block; font-weight: 500;">*Kategori baru akan otomatis terpilih dan tersimpan ketika Anda menyimpan artikel.</small>
                    </div>
                </div>
            </div>

            <div class="form-row-grid-top">
                <label class="form-label-custom" style="margin-top: 10px;">Konten Edukasi</label>
                <div>
                    <div id="toolbar-container">
                        <select class="ql-size">
                            <option value="small">Kecil</option>
                            <option selected>Normal</option>
                            <option value="large">Besar</option>
                            <option value="huge">Sangat Besar</option>
                        </select>
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-list" value="ordered"></button>
                        <button class="ql-list" value="bullet"></button>
                        <button class="ql-clean"></button>
                    </div>
                    <div id="editor-konten">{!! $artikel->konten_edukasi !!}</div>
                    <input type="hidden" name="konten_edukasi" id="konten_edukasi">
                </div>
            </div>

            <div class="form-row-grid-top">
                <label class="form-label-custom" style="margin-top: 10px;">Upload Gambar</label>
                <div>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <label for="gambar" class="btn-choose-image">Ubah Gambar</label>
                        <input type="file" id="gambar" name="gambar" accept="image/*" style="display: none;" onchange="previewImage(event)">
                        <span id="file-name" style="font-size: 14px; color: #6b7280; font-weight: 600;">Menggunakan gambar saat ini</span>
                    </div>
                    <div class="preview-image-box">
                        <img id="output_image" src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%23ccc\' stroke-width=\'1.5\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg>' }}" />
                    </div>
                </div>
            </div>

            <div class="action-row-footer">
                <a href="{{ route('admin.edukasi') }}" class="btn-kembali">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn-submit-blue">
                    <i class="fa-solid fa-pen-to-square"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Helper Fungsi PHP Lokal untuk Pengecekan --}}
@php
function in_repeat_check($val, $arr) {
    return in_array(strtolower($val), array_map('strtolower', $arr));
}
@endphp
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    // Inisialisasi Rich Text Editor
    const quill = new Quill('#editor-konten', {
        modules: { toolbar: '#toolbar-container' },
        theme: 'snow',
        placeholder: 'Tulis isi konten edukasi di sini...'
    });

    // Kontrol Tampilan Input Kategori Kustom
    function checkNewCategory(selectObj) {
        const container = document.getElementById('kategori_baru_container');
        const inputBaru = document.getElementById('kategori_baru');
        
        if (selectObj.value === 'buat_baru') {
            container.style.display = 'block';
            inputBaru.setAttribute('required', 'required');
            inputBaru.focus();
        } else {
            container.style.display = 'none';
            inputBaru.removeAttribute('required');
        }
    }

    // Pindahkan isi editor ke input tersembunyi (ALERT SUDAH DIHAPUS)
    document.getElementById('formEditEdukasi').onsubmit = function() {
        var konten = document.querySelector('input[name=konten_edukasi]');
        konten.value = quill.root.innerHTML;

        // Logika dropdown kategori kustom
        const selectObj = document.getElementById('kategori_select');
        const inputBaru = document.getElementById('kategori_baru');
        if (selectObj.value === 'buat_baru' && inputBaru.value.trim() !== '') {
            let opt = document.createElement('option');
            opt.value = inputBaru.value.trim();
            opt.text = inputBaru.value.trim();
            selectObj.appendChild(opt);
            selectObj.value = inputBaru.value.trim();
        }
    };

    function previewImage(event) {
        const reader = new FileReader();
        const imageField = document.getElementById('output_image');
        const fileNameSpan = document.getElementById('file-name');
        if (event.target.files.length > 0) { fileNameSpan.textContent = event.target.files[0].name; }
        reader.onload = function() { if (reader.readyState === 2) { imageField.src = reader.result; } }
        if (event.target.files[0]) { reader.readAsDataURL(event.target.files[0]); }
    }
</script>
@endsection