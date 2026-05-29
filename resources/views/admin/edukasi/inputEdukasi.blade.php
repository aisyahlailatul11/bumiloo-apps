@extends('layouts.masterAdmin')

@section('title', 'Tambah Edukasi - Bumiloo')

@section('content')
<style>
    .bg-bumiloo { background-color: #f472b6; }
    .text-bumiloo { color: #f472b6; }
    .hover-bumiloo:hover { background-color: #ec4899; }
</style>

<div class="p-8 max-w-5xl w-full mx-auto">
    <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Tambah Edukasi</h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-lg text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.edukasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-4 items-center gap-4">
                <label for="judul_edukasi" class="text-sm font-semibold text-gray-700">Judul Edukasi</label>
                <div class="col-span-3">
                    <input type="text" id="judul_edukasi" name="judul_edukasi" placeholder="Masukkan Judul Edukasi..." required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-pink-300 focus:border-pink-400 outline-none transition text-sm">
                </div>
            </div>

            <div class="grid grid-cols-4 items-center gap-4">
                <label for="kategori" class="text-sm font-semibold text-gray-700">Kategori</label>
                <div class="col-span-3">
                    <input type="text" id="kategori" name="kategori" placeholder="Masukkan Kategori Edukasi..." required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-pink-300 focus:border-pink-400 outline-none transition text-sm">
                </div>
            </div>

            <div class="grid grid-cols-4 items-start gap-4">
                <label for="konten_edukasi" class="text-sm font-semibold text-gray-700 pt-2">Konten Edukasi</label>
                <div class="col-span-3">
                    <textarea id="konten_edukasi" name="konten_edukasi" rows="6" placeholder="Masukkan Konten Edukasi..." required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-pink-300 focus:border-pink-400 outline-none transition text-sm resize-none"></textarea>
                </div>
            </div>

            <div class="grid grid-cols-4 items-start gap-4">
                <label class="text-sm font-semibold text-gray-700 pt-2">Upload Gambar</label>
                <div class="col-span-3 space-y-3">
                    <div class="flex items-center space-x-4">
                        <label for="gambar" class="cursor-pointer bg-pink-500 hover:bg-pink-600 text-white text-xs font-semibold px-4 py-2.5 rounded-lg shadow-sm transition duration-200">
                            Pilih Gambar
                        </label>
                        <input type="file" id="gambar" name="gambar" accept="image/*" class="hidden" onchange="previewImage(event)">
                        <span id="file-name" class="text-xs text-gray-500">Tidak ada file yang dipilih</span>
                    </div>
                    
                    <p class="text-xs text-gray-400 font-medium">*Ukuran Gambar Maksimal 2 MB</p>

                    <div class="mt-2 border rounded-xl overflow-hidden w-64 bg-gray-50 h-40 flex items-center justify-center relative">
                        <img id="output_image" class="w-full h-full object-cover hidden" />
                        <div id="placeholder-text" class="text-gray-400 text-xs flex flex-col items-center">
                            <i class="fa-solid fa-image text-2xl mb-1"></i>
                            <span>Pratinjau gambar di sini</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t">
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-semibold text-sm px-6 py-2.5 rounded-xl shadow-md transition duration-200 flex items-center space-x-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk menangani penamaan file dan pemuatan gambar (Preview) secara langsung
    function previewImage(event) {
        const reader = new FileReader();
        const imageField = document.getElementById('output_image');
        const placeholder = document.getElementById('placeholder-text');
        const fileNameSpan = document.getElementById('file-name');

        // Menampilkan nama file di label samping tombol
        if (event.target.files.length > 0) {
            fileNameSpan.textContent = event.target.files[0].name;
        }

        reader.onload = function() {
            if (reader.readyState === 2) {
                imageField.src = reader.result;
                imageField.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
        }
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection