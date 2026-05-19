<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BidanController;
use App\Http\Controllers\BumilController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
        // Halaman Utama Admin
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // Master Data Admin
        Route::prefix('master')->group(function () {
            Route::get('/pasien', [AdminController::class, 'dataPasien'])->name('master.pasien');
            Route::get('/bidan', [AdminController::class, 'dataBidan'])->name('master.bidan');
            Route::get('/hak-akses', [AdminController::class, 'hakAkses'])->name('master.hakakses');
            Route::get('/hak-akses/create', [AdminController::class, 'createHakAkses'])->name('hakakses.create');
            Route::get('/hak-akses/{id}/view', [AdminController::class, 'viewHakAkses'])->name('hakakses.view');
            Route::get('/hak-akses/{id}/edit', [AdminController::class, 'editHakAkses'])->name('hakakses.edit');
        });
<<<<<<< Updated upstream

        // Fitur Jadwal Kegiatan Admin
=======
        
        // Fitur Jadwal (Lengkap: View, Simpan, Edit, Hapus)
>>>>>>> Stashed changes
        Route::get('/jadwal', [AdminController::class, 'jadwalIndex'])->name('jadwal.index');
        Route::post('/jadwal', [AdminController::class, 'jadwalStore'])->name('jadwal.store');
        Route::put('/jadwal/{id}', [AdminController::class, 'jadwalUpdate'])->name('jadwal.update');
        Route::delete('/jadwal/{id}', [AdminController::class, 'jadwalDestroy'])->name('jadwal.destroy');

        // Fitur Edukasi & Laporan Admin
        Route::get('/edukasi', function () {
            return view('admin.edukasi'); 
        })->name('admin.edukasi');

        Route::get('/laporan', function () {
            return view('admin.laporan'); 
        })->name('admin.laporan');
    });

    // ==========================================
    // --- GRUP ROUTE BIDAN ---
    // ==========================================
    Route::prefix('bidan')->group(function () {
        Route::get('/dashboard', [BidanController::class, 'index'])->name('bidan.dashboard');
        // Tambahkan rute internal bidan lainnya di bawah sini nanti
    });

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
});

// Logout Route (Menggunakan Controller yang sudah kita perbaiki)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__.'/auth.php';