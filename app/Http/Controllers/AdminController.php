<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\User;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Dashboard Utama Admin
     */
    public function index()
    {
        // PERBAIKAN: Ubah dari 'dashboard' menjadi 'admin.dashboard'
        // Agar Laravel memanggil resources/views/admin/dashboard.blade.php
        
        $totalPasien = User::where('role', 'Ibu Hamil')->count();
        $totalBidan = User::where('role', 'Bidan')->count();
        $totalKunjungan = 23; // Sementara hardcode atau ambil dari tabel kunjungan jika ada

        return view('admin.dashboard', compact('totalPasien', 'totalBidan', 'totalKunjungan'));
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

    /**
     * Menampilkan Data Bidan untuk Admin
     */
   public function dataBidan()
{
    $b = \App\Models\User::where('role', 'Bidan')->orderBy('created_at', 'desc')->first();
    if (!$b) {
        $b = (object) [
            'id' => 1,
            'id_bidan' => 'B001',
            'nama' => 'Siti Fatimah, Amd.Keb', 
            'email' => 'bidan@demo.com',
            'nip' => '-',
            'sip' => '-'
        ];
    }
    return view('admin.master.dataBidan', compact('b'));
}
public function masterPasien()
{
    $pasiens = \App\Models\Pendaftaran::all(); 
    $totalPasien = $pasiens->count(); 
    return view('admin.master.dataPasien', compact('pasiens', 'totalPasien'));
}

    /**
     * Menampilkan Halaman Hak Akses
     */
    public function hakAkses()
    {
        $roles = \App\Models\User::all();
        return view('admin.master.hakakses', compact('roles'));
    }
    // Fungsi untuk halaman View Detail
public function viewHakAkses($id)
{
    // Hanya mengambil SATU data role yang cocok dengan ID
    $role = \App\Models\User::findOrFail($id); 
    return view('admin.master.view', compact('role')); 
}

// Fungsi untuk halaman Edit
public function editHakAkses($id)
{
    // Hanya mengambil SATU data role yang cocok dengan ID
    $role = \App\Models\User::findOrFail($id);

    return view('admin.master.edit', compact('role')); 
}

    /**
     * /*
    // Menampilkan Jadwal Bumil
    */
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
        'nik'             => 'required',
        'tgl_pemeriksaan' => 'required|date',
        'jam'             => 'required',
        'keterangan'      => 'required',
    ]);

    Jadwal::create([
        'nama_pasien'     => $request->nama, 
        'nik'             => $request->nik,
        'no_hp'           => $request->no_hp,
        'tgl_lahir'       => $request->tgl_lahir,
        'tgl_pemeriksaan' => $request->tgl_pemeriksaan,
        'jam'             => $request->jam,
        'keterangan'      => $request->keterangan,
    ]);

    return redirect()->route('jadwal.index')->with('success', 'Jadwal konsultasi berhasil disimpan!');
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
}
