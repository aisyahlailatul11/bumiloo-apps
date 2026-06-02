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
            // Tambahkan pesan error lain jika perlu
        ]);

        // 2. Logika Pekerjaan
        if ($request->pekerjaan === 'Lainnya') {
            $validated['pekerjaan'] = $request->input('pekerjaan_lainnya', 'Lainnya');
        }

        // 3. Gabungkan data validasi dengan data tambahan
        $data_final = array_merge($validated, [
        'email'             => auth()->user()->email, 
        'status_konsultasi' => 'menunggu',
        'created_by'        => 'pasien', 
        'user_id'           => auth()->id(), 
    ]);

        // 4. Simpan ke Database menggunakan $data_final
        Pendaftaran::create($data_final);

        // 5. Arahkan ke Dashboard
        return redirect()->route('bumil.dashboard')->with('success', 'Data pendaftaran berhasil disimpan!');
    }
}