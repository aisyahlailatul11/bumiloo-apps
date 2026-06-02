@extends('layouts.masterAdmin')

@section('title', 'Daftar Edukasi - Bumiloo')

@section('content')
<style>
    .content-container {
        padding: 15px 15px;;
        box-sizing: border-box;
        width: 100%;
    }

    .header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: -15px;
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 800;
        color: #1f2937;
        margin: 0;
    }

    .btn-tambah {
        background-color: #f472b6;
        color: white;
        font-weight: 700;
        font-size: 14px;
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-tambah:hover {
        background-color: #ec4899;
        transform: translateY(-1px);
    }

    /* Card Memanjang */
    .artikel-card-row {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid rgba(244, 114, 182, 0.15);
        display: flex;
        gap: 20px;
        align-items: center;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .artikel-img {
        width: 150px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        background-color: #f3f4f6;
    }

    .artikel-body {
        flex: 1;
        cursor: pointer; /* Menandakan bisa diklik untuk baca */
    }

    .artikel-kategori {
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 700;
        color: #f472b6;
        margin-bottom: 4px;
    }

    .artikel-judul {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 8px 0;
    }

    .artikel-snippet {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .artikel-actions {
        display: flex;
        gap: 10px;
    }

    .btn-action-edit {
        background-color: #fcf63d;
        color: white;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-edit:hover {
        background-color: #ebeb2565;
    }

    .btn-action-hapus {
        background-color: #ef4444;
        color: white;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-hapus:hover {
        background-color: #dc2626;
    }

    /* Modal untuk baca artikel */
    .modal-baca {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    .modal-content {
        background: white;
        padding: 30px;
        border-radius: 20px;
        max-width: 700px;
        width: 100%;
        max-height: 80vh;
        overflow-y: auto;
        position: relative;
    }
    .close-modal {
        position: absolute;
        top: 20px; right: 20px;
        font-size: 24px; cursor: pointer; color: #9ca3af;
    }
</style>

<div class="content-container">
    <div class="header-row">
        <h2 class="page-title">Daftar Artikel Edukasi</h2>
        <a href="{{ route('admin.edukasi.create') }}" class="btn-tambah">
            <i class="fa-solid fa-plus"></i> Tambah Edukasi
        </a>
    </div>

    {{-- Looping Data Artikel dalam bentuk Card Memanjang --}}
    @forelse($artikels as $artikel)
        <div class="artikel-card-row">
            <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%23ccc\' stroke-width=\'1.5\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><path d=\'M21 15l-5-5L5 21\'/></svg>' }}" class="artikel-img" alt="Gambar Artikel">
            
            <div class="artikel-body" onclick="bacaArtikel('{{ addslashes($artikel->judul_edukasi) }}', '{{ addslashes($artikel->kategori) }}', '{{ base64_encode($artikel->konten_edukasi) }}')">
                <div class="artikel-kategori">{{ $artikel->kategori }}</div>
                <h3 class="artikel-judul">{{ $artikel->judul_edukasi }}</h3>
                <div class="artikel-snippet">{!! strip_tags($artikel->konten_edukasi) !!}</div>
                <small style="color: #9ca3af; margin-top: 5px; display: block;">Klik area tulisan ini untuk membaca penuh</small>
            </div>

            <div class="artikel-actions">
                <a href="{{ route('admin.edukasi.edit', $artikel->id) }}" class="btn-action-edit">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>
                {{-- Memanggil fungsi SweetAlert2 confirmDelete --}}
                <button type="button" class="btn-action-hapus" onclick="confirmDelete('{{ $artikel->id }}', '{{ addslashes($artikel->judul_edukasi) }}')">
                    <i class="fa-solid fa-trash"></i> Hapus
                </button>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 40px; color: #9ca3af; background: white; border-radius: 16px;">
            Belum ada artikel edukasi yang ditambahkan.
        </div>
    @endforelse
</div>

{{-- Pop up Modal untuk Membaca Artikel Secara Penuh --}}
<div id="modalBaca" class="modal-baca">
    <div class="modal-content">
        <span class="close-modal" onclick="tutupModal()">&times;</span>
        <span id="modalKategori" style="color:#f472b6; font-weight:700; font-size:12px; text-transform:uppercase;"></span>
        <h2 id="modalJudul" style="margin-top:5px; margin-bottom:20px; font-weight:800; color:#1f2937;"></h2>
        <hr style="border:0; border-top:1px solid #e5e7eb; margin-bottom:20px;">
        <div id="modalKonten" style="color:#374151; line-height:1.7; font-size:15px;"></div>
    </div>
</div>

{{-- SweetAlert2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Yakin ingin menghapus artikel?',
            text: "Artikel \"" + nama + "\" akan terhapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#94A3B8',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-[24px]' }
        }).then((result) => {
            if (result.isConfirmed) { 
                let form = document.createElement('form');
                form.action = "/admin/edukasi/hapus/" + id;
                form.method = 'POST';
                form.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(form);
                form.submit();
            }
        })
    }

    function bacaArtikel(judul, kategori, kontenBase64) {
        document.getElementById('modalJudul').innerText = judul;
        document.getElementById('modalKategori').innerText = kategori;
        // Decode base64 konten HTML agar text style (Bold/Italic/Underline) tampil sempurna
        document.getElementById('modalKonten').innerHTML = atob(kontenBase64);
        document.getElementById('modalBaca').style.display = 'flex';
    }

    function tutupModal() {
        document.getElementById('modalBaca').style.display = 'none';
    }

    window.onclick = function(event) {
        let modal = document.getElementById('modalBaca');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endsection