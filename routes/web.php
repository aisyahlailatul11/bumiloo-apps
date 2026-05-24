<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BidanController;
use App\Http\Controllers\BumilController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\InputPasienController;
use App\Http\Controllers\PerkembanganController;
use App\Http\Controllers\PengaturanController;

// 1. Rute Home / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// 2. Middleware Auth (Semua rute di dalam sini wajib login)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // REDIRECTOR DASHBOARD (Pintu utama pembagian kamar setelah login)
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'Admin') return redirect()->route('admin.dashboard');
        if ($role === 'Bidan') return redirect()->route('bidan.dashboard');
        
        // Khusus Ibu Hamil: Cek pendaftaran
        $sudahDaftar = \Illuminate\Support\Facades\DB::table('tb_pendaftaran')
            ->where('user_id', auth()->id())
            ->exists();
            
        return $sudahDaftar
            ? redirect()->route('bumil.dashboard')
            : redirect()->route('pendaftaran.create');
    })->name('dashboard');

    // ==========================================
    // --- GRUP ROUTE ADMIN (Disatukan di sini) ---
    // ==========================================
    Route::prefix('admin')->group(function () {
        
        // Halaman Utama Admin -> URL: /admin/dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // Master Data Admin
        Route::prefix('master')->group(function () {
            
            // --- FITUR PASIEN ---
            Route::get('/pasien', [AdminController::class, 'masterPasien'])->name('master.pasien');
            Route::get('/pasien/{id}/edit', [AdminController::class, 'editPasien'])->name('master.pasien.edit');
            
            // --- FITUR BIDAN ---
            // URL: /admin/master/bidan
            Route::get('/bidan', [AdminController::class, 'dataBidan'])->name('master.dataBidan');
            // URL: /admin/master/bidan-alias (Penyelamat Sidebar Baris 51)
            Route::get('/bidan-alias', [AdminController::class, 'dataBidan'])->name('master.bidan');
            // URL: /admin/master/bidan/{id}/update
            Route::put('/bidan/{id}/update', function ($id) {
                return redirect()->back()->with('success', 'Data bidan berhasil diperbarui! (Demo Mode)');
            })->name('bidan.update');

            // --- FITUR HAK AKSES ---
            // URL: /admin/master/hak-akses
            Route::get('/hak-akses', [AdminController::class, 'hakAkses'])->name('master.hakakses');
            // URL: /admin/master/hak-akses/create
            Route::get('/hak-akses/create', [AdminController::class, 'createHakAkses'])->name('hakakses.create');
            // URL: /admin/master/hak-akses/{id}/view
            Route::get('/hak-akses/{id}/view', [AdminController::class, 'viewHakAkses'])->name('hakakses.view');
            // URL: /admin/master/hak-akses/{id}/edit
            Route::get('/hak-akses/{id}/edit', [AdminController::class, 'editHakAkses'])->name('hakakses.edit');
        });

        // Fitur Jadwal Kegiatan Admin -> URL: /admin/jadwal
        Route::get('/jadwal', [AdminController::class, 'jadwalIndex'])->name('jadwal.index');
        Route::post('/jadwal', [AdminController::class, 'jadwalStore'])->name('jadwal.store');
        Route::put('/jadwal/{id}', [AdminController::class, 'jadwalUpdate'])->name('jadwal.update');
        Route::delete('/jadwal/{id}', [AdminController::class, 'jadwalDestroy'])->name('jadwal.destroy');

        // Fitur Edukasi & Laporan Admin -> URL: /admin/edukasi & /admin/laporan
        Route::get('/edukasi', function () {
            return view('admin.edukasi');
        })->name('admin.edukasi');

        Route::get('/laporan', function () {
            return view('admin.laporan');
        })->name('admin.laporan');
    });

    // ==========================================
    // --- GRUP ROUTE BIDAN---
    // ==========================================
    Route::prefix('bidan')->group(function () {
        
        // Halaman Utama Dashboard Bidan
        Route::get('/dashboard', [BidanController::class, 'index'])->name('bidan.dashboard');
        
        // Membuka Halaman Form Input & Tabel Daftar Pasien (Memanggil Controller Baru)
        Route::get('/input-daftar-pasien', [InputPasienController::class, 'indexPasien'])->name('bidan.inputDaftarPasien');
        
        // Route untuk PROSES SIMPAN (Method harus POST)
        // PERBAIKAN: Menghapus 'bidan/' di URL agar tidak terjadi double prefix /bidan/bidan/
        Route::post('pasien/store', [InputPasienController::class, 'storePasien'])->name('bidan.pasien.store');
        
        // Mengambil data spesifik pasien saat baris tabel di-klik (untuk Javascript Fetch)
        Route::get('/pasien/{id}', [InputPasienController::class, 'showPasien'])->name('pasien.show');
        
        // 1. Jalur GET untuk menampilkan halaman form perkembangan (Tempat tujuan Tombol Selanjutnya)
        Route::get('/input-perkembangan-pasien', function () {
            return view('bidan.inputPerkembanganPasien');
        })->name('bidan.inputPerkembanganPasien');

        // 2. Jalur POST untuk memproses simpan data dari form perkembangan tersebut ke database
        Route::post('/input-perkembangan-pasien/store', [PerkembanganController::class, 'storePerkembangan'])->name('bidan.inputPerkembangan');

        // Halaman Jadwal Praktik Bidan
        Route::get('/jadwal', function () { return view('bidan.jadwal'); })->name('bidan.jadwal');

        // Halaman Utama Konsultasi
        Route::get('/konsultasi', function () {
            return view('bidan.konsultasi', ['konsultasis' => collect([])]);
        })->name('bidan.konsultasi');

        // Halaman Laporan / Rekam Medis
        Route::get('/laporan', function () { return view('bidan.laporan'); })->name('bidan.laporan');
        Route::get('/laporan-bidan-demo', function () { return view('bidan.laporan'); })->name('bidan.laporanBidan');

        // Halaman Room Chat Pasien
        Route::get('/roomchat', function () { return view('bidan.roomchat'); })->name('bidan.roomchat');
    }); // <--- Mengunci Grup Bidan dengan aman

    // ==========================================
    // --- GRUP ROUTE IBU HAMIL (BUMIL) ---
    // ==========================================
    Route::prefix('bumil')->group(function () {
        Route::get('/dashboard', [BumilController::class, 'index'])->name('bumil.dashboard');
        // Tambahkan rute internal bumil lainnya di bawah sini nanti
    });


    // Fitur Pendaftaran Bumil (Di luar prefix bumil karena diakses sebelum punya dashboard)
    Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

    // PROFILE ROUTES (Bawaan Breeze agar tidak error)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ─── Pengaturan ──────────────────────────────
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan/update', [PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::post('/pengaturan/updateavatar', [PengaturanController::class, 'updateAvatar'])->name('profile.updateAvatar');
    //
    Route::get('/pengaturan/keamanan', function () {
    $role = auth()->user()->role;
    // Ubah 'pengaturan.keamanan' menjadi 'partials.subsettings.keamanan'
    return view('partials.subsettings.keamanan', compact('role'));
})->name('pengaturan.keamanan');

Route::get('/pengaturan/gantinomor', function () {
    $role = auth()->user()->role;
    return view('partials.subsettings.gantinomor', compact('role'));
})->name('pengaturan.gantinomor');

Route::get('/pengaturan/bantuan', function () {
    $role = auth()->user()->role;
    return view('partials.subsettings.bantuan', compact('role'));
})->name('pengaturan.bantuan');
});

// Logout Route (Menggunakan Controller yang sudah kita perbaiki)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
// Pastikan rute ini mengarah ke PengaturanController
Route::delete('/pengaturan/hapus-akun', [App\Http\Controllers\PengaturanController::class, 'destroy'])->name('profile.destroy');

require __DIR__.'/auth.php';