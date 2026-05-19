<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\User;
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
        $pasiens = User::where('role', 'Ibu Hamil')->latest()->get(); 
        $totalPasien = $pasiens->count();

        return view('master.pasien', compact('pasiens', 'totalPasien'));
    }

    /**
     * Menampilkan Data Bidan untuk Admin
     */
    public function dataBidan()
    {
        $bidans = User::where('role', 'Bidan')->latest()->get();
        return view('master.bidan', compact('bidans'));
    }

    /**
     * Menampilkan Halaman Hak Akses
     */
    public function hakAkses()
    {
        $users = User::all();
        return view('master.hakakses', compact('users'));
    }

    /**
     * FITUR JADWAL KONSULTASI
     */
    public function jadwalIndex(Request $request)
    {
        $pasien = null;
        if ($request->has('pasien_id')) {
            $pasien = User::find($request->pasien_id);
        }

        $editJadwal = null;
        if ($request->has('edit_id')) {
            $editJadwal = Jadwal::find($request->edit_id);
        }

        $jadwals = Jadwal::latest()->get();

        return view('admin.jadwal.index', compact('pasien', 'jadwals', 'editJadwal'));
    }

    public function jadwalStore(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required',
            'tgl_periksa' => 'required|date',
        ]);

        Jadwal::create($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil disimpan!');
    }

    public function jadwalUpdate(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diupdate!');
    }

    public function jadwalDestroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();
        
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}