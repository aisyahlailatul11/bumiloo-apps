<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Bumiloo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            margin: 0;
            background-color: #FCE4EC;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-aisyah {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px !important; 
            border: 2px solid #FBCFE8 !important; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1) !important;
        }

        .input-custom {
            border: 1.5px solid #e5e7eb;
            background: white;
            transition: all 0.3s;
            font-size: 1.1rem;
        }

        .input-custom:focus {
            border-color: #f472b6;
            box-shadow: 0 0 0 4px #fdf2f8;
            outline: none;
        }
    </style>
</head>
<body class="antialiased p-6 md:p-14">

    {{-- KARTU PENDAFTARAN --}}
    <div class="w-full max-w-6xl p-10 md:p-16 card-aisyah relative overflow-hidden"
         x-data="{ 
            tglLahirBumil: '', 
            umurBumil: '',
            tglLahirSuami: '',
            usiaSuami: '',
            hitungUmur(tgl) {
                if(!tgl) return '';
                let lahir = new Date(tgl);
                let hariIni = new Date();
                let umur = hariIni.getFullYear() - lahir.getFullYear();
                let bulan = hariIni.getMonth() - lahir.getMonth();
                if (bulan < 0 || (bulan === 0 && hariIni.getDate() < lahir.getDate())) {
                    umur--;
                }
                return umur > 0 ? umur : 0;
            }
         }">
        
        <div class="absolute top-0 right-0 w-40 h-40 bg-pink-100 rounded-bl-full opacity-60"></div>

        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 text-center mb-14 tracking-wider uppercase">
            PENDAFTARAN
        </h1>

        <form action="{{ route('pendaftaran.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-8">
                
                {{-- SISI KIRI (DATA IBU HAMIL) --}}
                <div class="space-y-6">
                    <div>
                        <label class="font-bold text-gray-700 ml-1">NIK</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);" placeholder="Masukkan 16 Digit NIK" class="w-full mt-2 px-6 py-4 rounded-2xl input-custom">
                        <x-input-error :messages="$errors->get('nik')" class="mt-1" />
                    </div>
                    <div>
                        <label class="font-bold text-gray-700 ml-1">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan Nama Lengkap" class="w-full mt-2 px-6 py-4 rounded-2xl input-custom">
                        <x-input-error :messages="$errors->get('nama')" class="mt-1" />
                    </div>
                    <div>
                        <label class="font-bold text-gray-700 ml-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" required placeholder="Kota" class="w-full mt-2 px-6 py-4 rounded-2xl input-custom">
                    </div>
                    <div>
                        <label class="font-bold text-gray-700 ml-1">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" x-model="tglLahirBumil" @change="umurBumil = hitungUmur(tglLahirBumil)" required class="w-full mt-2 px-6 py-4 rounded-2xl input-custom">
                    </div>
                    <div class="w-2/3">
                        <label class="font-bold text-gray-700 ml-1">Umur</label>
                        <input type="number" name="umur" x-model="umurBumil" required placeholder="Tahun" class="w-full mt-2 px-6 py-4 rounded-2xl input-custom bg-gray-50 font-bold text-pink-600">
                    </div>
                    <div>
                        <label class="font-bold text-gray-700 ml-1">Alamat</label>
                        <textarea name="alamat" rows="4" required placeholder="Alamat lengkap..." class="w-full mt-2 px-6 py-4 rounded-2xl input-custom"></textarea>
                    </div>
                </div>

                {{-- SISI KANAN (DATA PENDUKUNG & SUAMI) --}}
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="font-bold text-gray-700 ml-1">No. HP</label>
                            <input type="text" name="no_hp" required placeholder="WhatsApp" class="w-full mt-2 px-6 py-4 rounded-2xl input-custom">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 ml-1">Agama</label>
                            <select name="agama" required class="w-full mt-2 px-6 py-4 rounded-2xl input-custom bg-white">
                                <option value="" disabled selected>Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Budha">Budha</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="font-bold text-gray-700 ml-1">Pendidikan</label>
                            <select name="pendidikan" required class="w-full mt-2 px-6 py-4 rounded-2xl input-custom bg-white">
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="S1">S1/Diploma</option>
                                <option value="S1">S2</option>
                                <option value="S1">S3</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 ml-1">Golongan Darah</label>
                            <select name="gol_darah" required class="w-full mt-2 px-6 py-4 rounded-2xl input-custom bg-white">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                    </div>

                    <div x-data="{ job: '' }">
                        <label class="font-bold text-gray-700 ml-1">Pekerjaan</label>
                        <select name="pekerjaan" x-model="job" required class="w-full mt-2 px-6 py-4 rounded-2xl input-custom bg-white">
                            <option value="" disabled selected>-- Pilih Pekerjaan --</option>
                            <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                            <option value="PNS">PNS</option>
                            <option value="Wiraswasta">Wiraswasta</option>
                            <option value="Lainnya">Lainnya...</option>
                        </select>
                        <input x-show="job === 'Lainnya'" type="text" name="pekerjaan_lainnya" placeholder="Pekerjaan Bunda..." class="w-full mt-3 px-6 py-3 rounded-2xl border border-pink-200 bg-white">
                    </div>

                    <div>
                        <label class="font-bold text-gray-700 ml-1">Nama Suami</label>
                        <input type="text" name="nama_suami" required placeholder="Nama Ayah" class="w-full mt-2 px-6 py-4 rounded-2xl input-custom">
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="font-bold text-gray-700 ml-1">Tanggal Lahir Suami</label>
                            <input type="date" name="tgllahir_suami" x-model="tglLahirSuami" @change="usiaSuami = hitungUmur(tglLahirSuami)" required class="w-full mt-2 px-6 py-4 rounded-2xl input-custom">
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 ml-1">Umur Suami</label>
                            <input type="number" name="usia_suami" x-model="usiaSuami" required placeholder="Tahun" class="w-full mt-2 px-6 py-4 rounded-2xl input-custom bg-gray-50 font-bold text-pink-600">
                        </div>
                    </div>

                    {{-- HPHT --}}
                    <div class="bg-pink-100 p-8 rounded-[2.5rem] border-3 border-pink-200 shadow-inner">
                        <label class="font-extrabold text-pink-700 block mb-3 text-lg uppercase tracking-tight">HPHT (Hari Pertama Haid Terakhir)</label>
                        <input type="date" name="hpht" required class="w-full px-6 py-4 rounded-2xl border-pink-300 focus:ring-4 focus:ring-pink-50 bg-white text-lg">
                        <x-input-error :messages="$errors->get('hpht')" class="mt-1" />
                    </div>
                </div>
            </div>

            {{-- TOMBOL DAFTAR --}}
            <div class="flex justify-end pt-10">
                <button type="submit" class="bg-[#2563EB] hover:bg-blue-700 text-white font-black py-5 px-16 rounded-3xl shadow-2xl transition-all transform hover:scale-105 uppercase tracking-[0.2em] text-xl flex items-center gap-3">
                    Daftar
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success_register'))
<script>
    Swal.fire({
        title: 'Selamat Datang Ibu Hebat! 🎉',
        text: 'Akun Bumiloo Anda berhasil dibuat. Silahkan lengkapi formulir pendaftaran medis awal ini yaa.',
        icon: 'success',
        confirmButtonColor: '#F875AA', 
        confirmButtonText: 'Siap, Mengerti!',
        customClass: { popup: 'rounded-3xl font-poppins' }
    });
</script>

@if(session('info'))
<script>
    Swal.fire({
        title: 'Perhatian! ⚠️',
        text: "{{ session('info') }}",
        icon: 'info',
        confirmButtonColor: '#F875AA',
        confirmButtonText: 'Isi Formulir Sekarang!',
        customClass: { popup: 'rounded-3xl font-poppins' }
    });
</script>
@endif
</html>