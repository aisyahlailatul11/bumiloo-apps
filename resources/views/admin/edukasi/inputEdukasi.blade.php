<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bumiloo - Tambah Edukasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-bumiloo { background-color: #f472b6; }
        .text-bumiloo { color: #f472b6; }
        .hover-bumiloo:hover { background-color: #ec4899; }
    </style>
</head>
<body class="bg-gray-100 font-sans flex">

    <aside class="w-64 bg-pink-400 min-h-screen text-white flex flex-col shadow-xl">
        <div class="p-5 flex flex-col items-center border-b border-pink-300">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-md mb-2">
                <i class="fa-solid fa-baby text-pink-500 text-3xl"></i>
            </div>
            <span class="text-sm font-semibold tracking-wider">Super Admin</span>
        </div>

        <nav class="flex-1 p-4 space-y-2 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-pink-500 transition duration-200">
                <i class="fa-solid fa-house w-5"></i>
                <span>Beranda</span>
            </a>

            <div class="relative">
                <button onclick="toggleDropdown()" class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-pink-500 transition duration-200 focus:outline-none">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-database w-5"></i>
                        <span>Master Data</span>
                    </div>
                    <i id="arrow-icon" class="fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
                </button>
                <div id="dropdown-menu" class="hidden pl-8 mt-1 space-y-1 bg-pink-500/30 rounded-lg overflow-hidden transition-all duration-300">
                    <a href="{{ route('master.pasien') }}" class="block p-2 text-xs hover:text-pink-200">Data Pasien</a>
                    <a href="{{ route('master.bidan') }}" class="block p-2 text-xs hover:text-pink-200">Data Bidan</a>
                    <a href="{{ route('master.hakakses') }}" class="block p-2 text-xs hover:text-pink-200">Hak Akses</a>
                </div>
            </div>

            <a href="{{ route('jadwal.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-pink-500 transition duration-200">
                <i class="fa-solid fa-calendar-days w-5"></i>
                <span>Input Jadwal</span>
            </a>

            <a href="{{ route('admin.edukasi') }}" class="flex items-center space-x-3 p-3 rounded-lg bg-pink-600 font-medium shadow-inner transition duration-200">
                <i class="fa-solid fa-book-open w-5"></i>
                <span>Input Edukasi</span>
            </a>

            <a href="{{ route('admin.laporan') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-pink-500 transition duration-200">
                <i class="fa-solid fa-file-lines w-5"></i>
                <span>Laporan</span>
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-h-screen">
        
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-pink-600 tracking-wide">Bumiloo</h1>
            
            <div class="flex items-center space-x-6">
                <div class="relative">
                    <input type="text" placeholder="Cari..." class="pl-4 pr-10 py-1.5 bg-gray-100 rounded-full text-sm border focus:outline-none focus:border-pink-400 w-60">
                    <i class="fa-solid fa-magnifying-glass absolute right-3 top-2.5 text-gray-400 text-sm"></i>
                </div>
                
                <button class="relative text-gray-600 hover:text-pink-500 transition focus:outline-none">
                    <i class="fa-solid fa-bell text-lg"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center">3</span>
                </button>

                <div class="flex items-center space-x-2 border-l pl-4 border-gray-200">
                    <i class="fa-solid fa-circle-user text-2xl text-gray-600"></i>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-red-500 hover:underline font-medium">Keluar</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1 p-8 max-w-5xl w-full mx-auto">
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
        </main>
    </div>

    <script>
        // Fungsi untuk mengontrol buka-tutup dropdown Master Data di sidebar
        function toggleDropdown() {
            const menu = document.getElementById('dropdown-menu');
            const arrow = document.getElementById('arrow-icon');
            menu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

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
</body>
</html>