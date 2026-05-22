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
    // 1. ATURAN VALIDASI (Menentukan syarat field wajib dan panjang karakter)
    $validated = $request->validate([
        // Syarat NIK: Wajib diisi, harus unik di tb_pendaftaran, panjangnya minimal 16 dan maksimal 16 digit
        'nik' => 'required|unique:tb_pendaftaran|digits:16', 
        
        // Field lain yang wajib diisi (required)
        'nama' => 'required',
        'tempat_lahir' => 'required',
        'tgl_lahir' => 'required|date',
        'umur' => 'required|integer',
        'alamat' => 'required',
        'no_hp' => 'required',
        'agama' => 'required',
        'pendidikan' => 'required',
        'gol_darah' => 'required',
        'pekerjaan' => 'required',
        'nama_suami' => 'required',
        'tgllahir_suami' => 'required|date',
        'usia_suami' => 'required|integer',
        'hpht' => 'required|date',
    ], [
        // 2. KUSTOMISASI PERINGATAN / PESAN ERROR (Tampil kalau inputan salah)
        'nik.required' => 'NIK wajib diisi dan tidak boleh kosong.',
        'nik.unique' => 'NIK ini sudah terdaftar di sistem Bumiloo.',
        'nik.digits' => 'Format salah! Nomor NIK harus tepat berukuran 16 digit.', // Ini peringatan untuk aturan 16 digitnya!
        
        'nama.required' => 'Nama lengkap ibu hamil wajib diisi.',
        'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
        'tgl_lahir.required' => 'Tanggal lahir wajib ditentukan.',
        'umur.required' => 'Umur wajib diisi.',
        'alamat.required' => 'Alamat lengkap tempat tinggal wajib diisi.',
        'no_hp.required' => 'Nomor HP aktif wajib diisi.',
        'agama.required' => 'Agama wajib dipilih.',
        'pendidikan.required' => 'Pendidikan terakhir wajib dipilih.',
        'gol_darah.required' => 'Golongan darah wajib dipilih.',
        'pekerjaan.required' => 'Pekerjaan wajib diisi atau dipilih.',
        'nama_suami.required' => 'Nama suami wajib diisi.',
        'tgllahir_suami.required' => 'Tanggal lahir suami wajib ditentukan.',
        'usia_suami.required' => 'Usia suami wajib diisi.',
        'hpht.required' => 'Tanggal HPHT wajib ditentukan untuk menghitung usia kehamilan.',
    ]);

    // Mengambil ID user ibu hamil yang sedang login
    $validated['user_id'] = Auth::id();

    if ($request->pekerjaan === 'lainnya') {
        $validated['pekerjaan'] = $request->pekerjaan_lainnya;
    }

    // Eksekusi simpan ke database lewat Eloquent Model
    Pendaftaran::create($validated);

    // Arahkan dengan selamat ke dashboard ibu hamil
    return redirect()->route('bumil.dashboard')->with('success', 'Pendaftaran data diri berhasil disimpan!');
}
}