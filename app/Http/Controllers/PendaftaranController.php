<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    /**
     * 🚀 BARU: Menampilkan halaman pendaftaran (Mengatasi error welcome acak-acakan)
     */
    public function index()
    {
        // Langsung arahkan ke file blade pendaftaran kelompokmu
        // Pastikan file blademu ada di: resources/views/pendaftaran/create.blade.php
        return view('pendaftaran.create');
    }

    public function create()
    {
        return view('pendaftaran.create');
    }

    public function store(Request $request)
    {
        // 1. ATURAN VALIDASI (Menentukan syarat field wajib dan panjang karakter)
        $validated = $request->validate([
            'nik' => 'required|unique:tb_pendaftaran|digits:16', 
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
            // 2. KUSTOMISASI PERINGATAN / PESAN ERROR
            'nik.required' => 'NIK wajib diisi dan tidak boleh kosong.',
            'nik.unique' => 'NIK ini sudah terdaftar di sistem Bumiloo.',
            'nik.digits' => 'Format salah! Nomor NIK harus tepat berukuran 16 digit.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tgl_lahir.required' => 'Tanggal lahir wajib ditentukan.',
            'umur.required' => 'Umur wajib diisi.',
            'alamat.required' => 'Alamat lengkap tempat tinggal wajib diisi.',
            'no_hp.required' => 'Nomor HP aktif wajib diisi.',
            'agama.required' => 'Agama wajib dipilih.',
            'pendidikan.required' => 'Pendidikan terakhir wajib dipilih.',
            'gol_darah.required' => 'Golongan darah wajib dipilih.',
            'pekerjaan.required' => 'Pekerjaan wajib diisi.',
            'nama_suami.required' => 'Nama suami wajib diisi.',
            'tgllahir_suami.required' => 'Tanggal lahir suami wajib ditentukan.',
            'usia_suami.required' => 'Usia suami wajib diisi.',
            'hpht.required' => 'Tanggal HPHT wajib ditentukan untuk menghitung usia kehamilan.',
        ]);

        // 💡 KUNCI SINKRONISASI UTAMA:
        $validated['user_id'] = Auth::id();
        $validated['nama'] = Auth::user()->name;

        // Logika pilihan pekerjaan 'lainnya'
        if ($request->pekerjaan === 'lainnya') {
            $validated['pekerjaan'] = $request->pekerjaan_lainnya;
        }

        // 🤰 BONUS FITUR RMIK: Hitung Otomatis Rumus Naegele untuk EDD / HPL (Taksiran Persalinan)
        // Rumus: Hari HPHT + 7, Bulan - 3, Tahun + 1
        $hphtDate = new \DateTime($request->hpht);
        $hphtDate->modify('+7 days');
        $hphtDate->modify('-3 months');
        $hphtDate->modify('+1 year');
        $validated['hpl'] = $hphtDate->format('Y-m-d'); // Otomatis tersimpan ke kolom hpl/edd database!

        // Eksekusi simpan ke database lewat Eloquent Model
        Pendaftaran::create($validated);

        // Arahkan dengan selamat langsung masuk ke dashboard bumil utama
        // Note: Pastikan nama route dashboard bumil kelompokmu sudah sesuai (misal: 'dashboard')
        return redirect()->route('dashboard')->with('success', 'Pendaftaran data diri berhasil diselaraskan dengan akun Anda!');
    }
}