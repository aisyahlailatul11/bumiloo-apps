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
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\DaftarPasienController;
use App\Http\Controllers\LaporanBidanController;
use App\Http\Controllers\BumilKonsultasiController;
use App\Http\Controllers\DataBidanController;
use Illuminate\Support\Facades\DB;

// Rute Home / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Middleware Auth (Proteksi Login)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // REDIRECTOR DASHBOARD (Biarkan tetap di sini)
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'Admin') return redirect()->route('admin.dashboard');
        if ($user->role === 'Bidan') return redirect()->route('bidan.dashboard');
        
        $sudahDaftar = DB::table('tb_pendaftaran')->where('user_id', $user->id)->exists();
            
        return $sudahDaftar
            ? redirect()->route('bumil.dashboard')
            : redirect()->route('pendaftaran.create');
    })->name('dashboard');

    // Route Pendaftaran (Pindahkan ke dalam grup Bumil di bawah agar lebih rapi)
});

// ==========================================
// --- GRUP ROUTE IBU HAMIL (BUMIL) ---
// ==========================================
Route::middleware(['auth', 'verified'])->prefix('bumil')->group(function () {

    // Dashboard Bumil 
    Route::get('/dashboard', [BumilController::class, 'index'])->name('bumil.dashboard');

    // Route Pendaftaran 
    Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

    // ARTIKEL BUMIL
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('bumil.artikel');
    
    // RIWAYAT PERKEMBANGAN
    Route::get('/riwayat-perkembangan', [BumilController::class, 'riwayatPerkembangan'])->name('bumil.riwayatPerkembangan');

    // DETAIL PEMERIKSAAN   
    Route::get('/riwayat-perkembangan/detail/{id}', [BumilController::class, 'detailRiwayatPerkembangan'])->name('bumil.detailRiwayatPerkembangan');

    // HPL
    Route::get('/hpl', [BumilController::class, 'hpl'])->name('bumil.hpl');

    // KONSULTASI BUMIL
    Route::get('/konsultasi', [BumilController::class, 'konsultasi'])->name('bumil.konsultasi');
    Route::post('/konsultasi/kirim', [BumilController::class, 'kirimKonsultasi'])->name('bumil.konsultasi.kirim');
    Route::post('/konsultasi-bumil/ajukan', [BumilKonsultasiController::class, 'ajukanJadwal'])->name('konsultasi.ajukan');

    // REMINDER BUMIL
    Route::get('/reminder', [BumilController::class, 'reminder'])->name('bumil.reminder');
});

// ==========================================
// --- GRUP ROUTE ADMIN ---
// ==========================================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Halaman Utama Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Master Data Admin
Route::prefix('master')->group(function () {
    // Ubah .pasien menjadi .dataPasien agar sama dengan yang dipanggil di layout
    Route::get('/pasien', [AdminController::class, 'masterPasien'])->name('master.pasien');

    //create data pasien
    Route::get('/admin/master/pasien/create', [AdminController::class, 'createDataPasien'])
     ->name('master.createDataPasien');

    Route::get('/bidan', [DataBidanController::class, 'dataBidan'])->name('master.bidan');
    
    // Gunakan POST saja, tidak perlu Route::any agar lebih aman
    Route::post('/bidan/update/{id}', [DataBidanController::class, 'updateBidan'])->name('bidan.update');
});

    // Fitur Jadwal Kegiatan Admin
    Route::get('/jadwal', [AdminController::class, 'jadwalIndex'])->name('jadwal.index');
    Route::post('/jadwal', [AdminController::class, 'jadwalStore'])->name('jadwal.store');
    Route::put('/jadwal/{id}', [AdminController::class, 'jadwalUpdate'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [AdminController::class, 'jadwalDestroy'])->name('jadwal.destroy');

    // FITUR EDUKASI ADMIN
    Route::get('/edukasi', [ArtikelController::class, 'adminIndex'])->name('admin.edukasi');
    Route::get('/edukasi/create', [ArtikelController::class, 'create'])->name('admin.edukasi.create');
    Route::post('/edukasi/store', [ArtikelController::class, 'store'])->name('admin.edukasi.store');
    Route::delete('/edukasi/hapus/{id}', [ArtikelController::class, 'destroy'])->name('admin.edukasi.destroy');

    // Laporan Admin
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('admin.laporan.pdf');
    Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('admin.laporan.excel');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('admin.laporan.cetak');
});

// ==========================================
// --- GRUP ROUTE BIDAN ---
// ==========================================
Route::middleware(['auth'])->prefix('bidan')->group(function () {
    
    Route::get('/dashboard', [BidanController::class, 'index'])->name('bidan.dashboard');
      Route::get('/daftar-pasien', [PendaftaranController::class, 'index'])
        ->name('bidan.daftarPasien');

   //Daftar pasien hari ini
    Route::get('/daftar-pasien', [DaftarPasienController::class, 'index'])
    ->name('bidan.daftarPasien');
    Route::get('/input-daftar-pasien/{id}', [InputPasienController::class, 'indexPasien'])
    ->name('bidan.inputDaftarPasien');
    Route::post('/pasien/store', [InputPasienController::class, 'storePasien'])
    ->name('bidan.pasien.store');

// perkembangan pasien
    Route::get('/input-perkembangan-pasien', [PerkembanganController::class, 'indexPerkembangan'])->name('bidan.inputPerkembanganPasien');

    Route::post('/input-perkembangan-pasien/store', [PerkembanganController::class, 'storePerkembangan'])->name('bidan.inputPerkembangan');
    Route::get('/jadwal', [AdminController::class, 'jadwalBidan'])->name('bidan.jadwal');
    Route::get('/cek-kunjungan/{pasien_id}', [PerkembanganController::class, 'cekKunjungan'])
    ->name('bidan.cekKunjungan');

    // KONSULTASI BIDAN
    Route::get('/konsultasi', [BidanController::class, 'konsultasi'])->name('bidan.konsultasi');
    Route::get('/konsultasi/{user_id}', [BidanController::class, 'detailKonsultasi'])->name('bidan.konsultasi.detail');
    Route::post('/konsultasi/{user_id}/kirim', [BidanController::class, 'kirimKonsultasi'])->name('bidan.konsultasi.kirim');
    Route::post('/konsultasi/{user_id}/request-offline', [BidanController::class, 'requestOffline'])->name('bidan.konsultasi.requestOffline');
    
    // Laporan Bidan
    Route::get('/laporan', [LaporanBidanController::class, 'index'])
        ->name('bidan.laporan');
});

// PROFILE & PENGATURAN ROUTES (Sistem Umum Bawaan Laravel)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan/update', [PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::post('/pengaturan/updateavatar', [PengaturanController::class, 'updateAvatar'])->name('profile.updateAvatar');
    
    Route::get('/pengaturan/keamanan', function () {
        $role = auth()->user()->role;
        return view('partials.subsettings.keamanan', compact('role'));
    })->name('pengaturan.keamanan');

    Route::get('/pengaturan/gantinomor', function () {
        $role = auth()->user()->role;
        return view('partials.subsettings.gantinomor', compact('role'));
    })->name('pengaturan.gantinomor');
    Route::post('/pengaturan/gantinomor', [PengaturanController::class, 'updateNoHp'])->name('update.nohp');

    Route::get('/pengaturan/bantuan', function () {
        $role = auth()->user()->role;
        return view('partials.subsettings.bantuan', compact('role'));
    })->name('pengaturan.bantuan');
    Route::post('/pengaturan/update-email', [PengaturanController::class, 'updateEmail'])->name('pengaturan.updateEmail');
    Route::post('/pengaturan/update-password', [PengaturanController::class, 'updatePassword'])->name('pengaturan.updatePassword');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::delete('/pengaturan/hapus-akun', [PengaturanController::class, 'destroy'])->name('pengaturan.hapusAkun');
});

require __DIR__.'/auth.php';