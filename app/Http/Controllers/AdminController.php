<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\User;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\DB;
use App\Models\Pasien;
use App\Models\Perkembangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\JadwalKontrol;

class AdminController extends Controller
{
    
    public function index()
{
    $hariIni = \Carbon\Carbon::today();

    // Jumlah kunjungan hari ini
    $jumlahKunjunganHariIni = \App\Models\Perkembangan::whereDate('tanggal_pemeriksaan', $hariIni)->count();

    // Jumlah persalinan hari ini
    $jumlahPersalinanHariIni = \App\Models\Perkembangan::whereDate('tanggal_pemeriksaan', $hariIni)
        ->where('jenis_layanan', 'Persalinan')
        ->count();

    // Data untuk pie chart (jumlah ibu hamil per trimester)
    $perTrimester = [
        \App\Models\Perkembangan::where('trimester', 1)->count(),
        \App\Models\Perkembangan::where('trimester', 2)->count(),
        \App\Models\Perkembangan::where('trimester', 3)->count(),
    ];

    // Data untuk line chart kunjungan per bulan
    $perBulan = [];
    for ($i = 1; $i <= 12; $i++) {
        $perBulan[] = \App\Models\Perkembangan::whereMonth('tanggal_pemeriksaan', $i)->count();
    }

    // Data untuk line chart persalinan per bulan
    $perBulanPersalinan = [];
    for ($i = 1; $i <= 12; $i++) {
        $perBulanPersalinan[] = \App\Models\Perkembangan::whereMonth('tanggal_pemeriksaan', $i)
            ->where('jenis_layanan', 'Persalinan')
            ->count();
    }

    return view('admin.dashboard', compact(
        'jumlahKunjunganHariIni',
        'jumlahPersalinanHariIni',
        'perTrimester',
        'perBulan',
        'perBulanPersalinan'
    ));
}

    /**
     * Menampilkan Data Pasien
     */
    public function dataPasien()
{
    // Mengambil user dengan role 'Ibu Hamil' sesuai log database kamu
    $pasiens = \App\Models\User::where('role', 'Ibu Hamil')->orderBy('created_at', 'desc')->get();
    
    // Arahkan ke folder resources/views/admin/pasien/index.blade.php
    return view('admin.pasien.index', compact('pasiens')); 
}

//DATA PASIEN (MASTER)

public function masterPasien(Request $request)
{
    // Mulai query dari model Pendaftaran
    $query = \App\Models\Pendaftaran::query();

    //Pencarian (berdasarkan nama pasien)
    if ($request->has('cari') && $request->cari != '') {
        $query->where('nama', 'like', '%' . $request->cari . '%');
    }

    //Filter Status 
    if ($request->has('status') && $request->status != 'semua') {
        $query->where('status_konsultasi', $request->status);
    }

    // Eksekusi query
    $pasiens = $query->latest()->get();
    $totalPasien = $pasiens->count();

    return view('admin.master.dataPasien', compact('pasiens', 'totalPasien'));
}

    //INPUT JADWAL
    public function jadwalIndex(Request $request)
{
    $pasienTerpilih = null;

    if ($request->has('pendaftaran_id')) {
        $pasienTerpilih = \App\Models\Pendaftaran::find($request->pendaftaran_id);
    }

    $editJadwal = null;
    if ($request->has('edit_id')) {
        $editJadwal = Jadwal::find($request->edit_id);

        if ($editJadwal) {
            $pasienTerpilih = $editJadwal;
        }
    }

    $jadwals = Jadwal::latest()->get();

    return view('admin.jadwal.index', compact('jadwals', 'editJadwal', 'pasienTerpilih'));
}

    public function jadwalStore(Request $request)
{
    $request->validate([
        'nama'            => 'required',
        'nik'             => 'required|unique:jadwals,nik,NULL,id,tgl_pemeriksaan,' . $request->tgl_pemeriksaan,
        'tgl_pemeriksaan' => 'required|date',
        'jam'             => 'required',
        'keterangan'      => 'required',
    ]);

    //Simpan data jadwal ke database
   $jadwal = Jadwal::create([
    'nama_pasien'     => $request->nama,    
    'nik'             => $request->nik,
    'no_hp'           => $request->no_hp,
    'tgl_lahir'       => $request->tgl_lahir,
    'tgl_pemeriksaan' => $request->tgl_pemeriksaan,
    'jam'             => $request->jam,
    'keterangan'      => $request->keterangan,
]);

    $pendaftaran = \App\Models\Pendaftaran::where('nik', $request->nik)->first();

   // Update status_konsultasi jadi 'terjadwal' jika pendaftarannya ketemu
    if ($pendaftaran) {
        $pendaftaran->update([
            'status_konsultasi' => 'terjadwal'
        ]);
    }

    // Cari pendaftaran berdasarkan NIK
$pendaftaran = \App\Models\Pendaftaran::where('nik', $jadwal->nik)->first();

if ($pendaftaran) {
    $user = \App\Models\User::where('nik', $pendaftaran->nik)->first(); 
    
    if ($user && $user->email) {
        \Illuminate\Support\Facades\Mail::to($user->email)
            ->send(new \App\Mail\JadwalKontrol($jadwal));
    } else {
        \Log::error('Gagal kirim email: User tidak ditemukan atau email kosong untuk NIK: ' . $pendaftaran->nik);
    }
}


    return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dibuat dan status diperbarui!');
}

    public function jadwalUpdate(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        
        $request->validate([
            'tgl_pemeriksaan' => 'required|date',
            'jam'             => 'required',
            'keterangan'      => 'required',
        ]);

        // Update jadwal yang sedang di-edit
        $jadwal->update([
            'tgl_pemeriksaan' => $request->tgl_pemeriksaan,
            'jam'             => $request->jam,
            'keterangan'      => $request->keterangan,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal konsultasi berhasil diperbarui!');
    }

    public function jadwalDestroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();
        
        return redirect()->route('jadwal.index')->with('success', 'Jadwal konsultasi berhasil dihapus!');
    }

    public function edukasiIndex()
    {
        // Contoh: Mengembalikan view edukasi
        return view('admin.edukasi.inputEdukasi'); 
    }

    public function jadwalBidan()
{
    // Ambil tanggal hari ini
    $hariIni = Carbon::today();

    // Ambil jadwal dengan tanggal pemeriksaan = hari ini
    $jadwalHariIniList = Jadwal::whereDate('tgl_pemeriksaan', $hariIni)
                               ->orderBy('jam', 'asc')
                               ->get();

    $countHariIni = $jadwalHariIniList->count(); 

    $jadwalKontrolList = Jadwal::whereDate('tgl_pemeriksaan', $hariIni)
                               ->where(function($query) {
                                   $query->where(DB::raw('LOWER(keterangan)'), 'LIKE', '%kontrol%')
                                         ->orWhere(DB::raw('LOWER(keterangan)'), 'LIKE', '%pemeriksaan%');
                               })->get();
    $countKontrol = $jadwalKontrolList->count();

    $jadwalImunisasiList = Jadwal::whereDate('tgl_pemeriksaan', $hariIni)
                                 ->where(DB::raw('LOWER(keterangan)'), 'LIKE', '%imunisasi%')
                                 ->get();
    $countImunisasi = $jadwalImunisasiList->count();

   $jadwalPersalinanList = Jadwal::whereDate('tgl_pemeriksaan', $hariIni)
    ->where(function($query) {
        $query->where(DB::raw('LOWER(keterangan)'), 'LIKE', '%persalinan%')
              ->orWhere(DB::raw('LOWER(keterangan)'), 'LIKE', '%melahirkan%');
    })->get();

    $countPersalinan = $jadwalPersalinanList->count();

    return view('bidan.jadwal', compact(
        'jadwalHariIniList', 
        'jadwalKontrolList',
        'jadwalImunisasiList',
        'jadwalPersalinanList',
        'countHariIni', 
        'countKontrol', 
        'countImunisasi', 
        'countPersalinan'
    ));
}
}