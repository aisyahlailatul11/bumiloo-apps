<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function create()
    {
        return view('pendaftaran.create');
    }

    public function store(Request $request)
{
    // 1. Validasi Data
    $validated = $request->validate([
        'nik' => 'required|unique:tb_pendaftaran,nik|digits:16', 
        'nama' => 'required|string|max:255',
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

    // 2. Gunakan cara 'new' agar kita bisa set data sistem secara eksplisit
    $pendaftaran = new \App\Models\Pendaftaran();
    $pendaftaran->fill($validated); // Isi data dari form

    // 3. Set data sistem secara OTOMATIS (Ini kuncinya!)
    $pendaftaran->user_id = auth()->id(); // Mengambil ID dari user yang sedang login
    $pendaftaran->created_by = 'pasien';   // Otomatis tandai sebagai 'pasien'
    $pendaftaran->status_konsultasi = 'menunggu';

    // 4. Simpan
    $pendaftaran->save(); 

    return redirect()->route('bumil.dashboard')
                     ->with('success', 'Pendaftaran berhasil, Selamat datang Bunda!');
}
}