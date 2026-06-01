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
        // Mendapatkan bulan dan tahun saat ini
        $bulanIni = \Carbon\Carbon::now()->month;
        $tahunIni = \Carbon\Carbon::now()->year;

        // 1. Jumlah kunjungan BULAN INI
        $jumlahKunjunganBulanIni = \App\Models\Perkembangan::whereMonth('tanggal_pemeriksaan', $bulanIni)
            ->whereYear('tanggal_pemeriksaan', $tahunIni)
            ->count();

        // 2. Jumlah persalinan BULAN INI
        $jumlahPersalinanBulanIni = \App\Models\Perkembangan::whereMonth('tanggal_pemeriksaan', $bulanIni)
            ->whereYear('tanggal_pemeriksaan', $tahunIni)
            ->where('jenis_layanan', 'Persalinan')
            ->count();

        // Data untuk pie chart (jumlah ibu hamil per trimester)
        $perTrimester = [
            \App\Models\Perkembangan::where('trimester', 1)->count(),
            \App\Models\Perkembangan::where('trimester', 2)->count(),
            \App\Models\Perkembangan::where('trimester', 3)->count(),
        ];

        // Data untuk line chart kunjungan per bulan (berdasarkan tahun berjalan)
        $perBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $perBulan[] = \App\Models\Perkembangan::whereMonth('tanggal_pemeriksaan', $i)
                ->whereYear('tanggal_pemeriksaan', $tahunIni)
                ->count();
        }

        // Data untuk line chart persalinan per bulan (berdasarkan tahun berjalan)
        $perBulanPersalinan = [];
        for ($i = 1; $i <= 12; $i++) {
            $perBulanPersalinan[] = \App\Models\Perkembangan::whereMonth('tanggal_pemeriksaan', $i)
                ->whereYear('tanggal_pemeriksaan', $tahunIni)
                ->where('jenis_layanan', 'Persalinan')
                ->count();
        }

        // Mengirimkan variabel baru ke view
        return view('admin.dashboard', compact(
            'jumlahKunjunganBulanIni',
            'jumlahPersalinanBulanIni',
            'perTrimester',
            'perBulan',
            'perBulanPersalinan'
        ));
    }

//DATA PASIEN (MASTER)
public function storeDataPasien(Request $request)
{
    // 1. Validasi
    $data = $request->validate([
        'nik' => 'required|unique:tb_pendaftaran,nik|digits:16',
        'nama' => 'required',
        'tempat_lahir' => 'required|string',
        'tgl_lahir' => 'required|date',
        'umur' => 'required|integer',
        'alamat' => 'required|string',
        'no_hp' => 'required|string|max:20',
        'agama' => 'required|string',
        'pendidikan' => 'required|string',
        'gol_darah' => 'required|string',
        'pekerjaan' => 'required|string',
        'nama_suami' => 'required|string|max:255',
        'tgllahir_suami' => 'required|date',
        'usia_suami' => 'required|integer',
        'hpht' => 'required|date',
    ], [
        'nik.unique' => 'NIK ini sudah terdaftar di sistem Bumiloo.',
        'nik.digits' => 'NIK harus tepat 16 digit.',
    ]);

    // 2. Logika Pekerjaan "Lainnya"
    // Karena $data sudah berisi semua input yang tervalidasi, 
    // kita cukup update key 'pekerjaan' di dalam array $data tersebut.
    if ($request->filled('pekerjaan_manual')) {
        $data['pekerjaan'] = $request->input('pekerjaan_manual');
    }
    
    // 3. Tambahkan status default
    $data['created_by'] = 'admin'; 
    $data['user_id'] = null;
    $data['status_konsultasi'] = 'Datang Langsung'; 

    // 4. Simpan ke database
    \App\Models\Pendaftaran::create($data);

    // 5. Redirect balik ke halaman Data Pasien
    return redirect()->route('admin.master.pasien')
                 ->with('success', 'Data pasien berhasil disimpan!');
}

public function createDataPasien()
    {
        // Pastikan path view-nya benar (misal: 'admin.master.create')
        return view('admin.master.createDataPasien');
    }

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
    $jadwalEdit = null; // Ini untuk data jadwal jika sedang mode edit

    // 1. Ambil data pasien jika ada pendaftaran_id
    if ($request->has('pendaftaran_id')) {
        $pasienTerpilih = \App\Models\Pendaftaran::find($request->pendaftaran_id);
    }

    // 2. Ambil data jadwal jika sedang mode edit
    if ($request->has('edit_id')) {
        $jadwalEdit = Jadwal::find($request->edit_id);
        
        // Jika jadwal ditemukan, pastikan data pasien juga ada 
        // (kita ambil lewat relasi atau query manual)
        if ($jadwalEdit) {
            $pasienTerpilih = \App\Models\Pendaftaran::find($jadwalEdit->pendaftaran_id);
        }
    }

    // 3. Ambil semua jadwal untuk tabel di bawah form
    $jadwals = Jadwal::latest()->get();

    // Kirim ketiganya ke view
    return view('admin.jadwal.index', compact('jadwals', 'jadwalEdit', 'pasienTerpilih'));
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

    $this->kirimEmailJadwal($jadwal, false);

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

        $this->kirimEmailJadwal($jadwal, true);

    return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui dan email dikirim ulang!');
}

private function kirimEmailJadwal($jadwal, $isUpdate = false) // Tambahkan parameter $isUpdate
{
    $user = \App\Models\User::where('name', $jadwal->nama_pasien)->first(); 
    
    if ($user && $user->email) {
        \Illuminate\Support\Facades\Mail::to($user->email)
            ->send(new \App\Mail\JadwalKontrol($jadwal, $isUpdate)); // Oper parameter ke sini
    } else {
        \Log::error('Gagal kirim email: User tidak ditemukan untuk nama: ' . $jadwal->nama_pasien);
    }
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