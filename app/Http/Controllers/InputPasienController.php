<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien; // Memanggil Model Pasien yang terhubung ke tabel daftar_pasien

class InputPasienController extends Controller
{
    // 1. Menampilkan halaman form & tabel pasien
    public function indexPasien()
    {
        $pasien = Pasien::latest()->get(); 
        $totalPasien = Pasien::count() + 1;
        $noPasienOtomatis = '0' . str_pad($totalPasien, 4, '0', STR_PAD_LEFT);

        return view('bidan.inputDaftarPasien', compact('pasien', 'noPasienOtomatis'));
    }

    public function storePasien(Request $request)
    {
        // Validasi: NIK harus 16 digit dan tidak boleh kembar di database
        $request->validate([
            'nik' => $request->id 
                ? 'required|numeric|digits:16|unique:daftar_pasien,nik,' . $request->id 
                : 'required|numeric|digits:16|unique:daftar_pasien,nik',
            'nama_pasien' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'golongan_darah' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ], [
            'nik.unique' => 'NIK sudah terpakai!',
            'nik.digits' => 'NIK harus berjumlah 16 digit angka.',
            'nik.required' => 'Kolom NIK wajib diisi.',
            'nama_pasien.required' => 'Nama Pasien wajib diisi.',
        ]);

        // Kunci No Pasien: Kalau sedang EDIT pakai nomor lama, kalau BARU buat nomor urut baru
        if ($request->id) {
            $pasienLama = Pasien::findOrFail($request->id);
            $no_pasien = $pasienLama->no_pasien;
        } else {
            $totalPasien = Pasien::count() + 1;
            $no_pasien = '0' . str_pad($totalPasien, 4, '0', STR_PAD_LEFT);
        }

        // Simpan data ke tabel database 'daftar_pasien'
        $pasienSimpan = Pasien::updateOrCreate(
            ['id' => $request->id], 
            [
                'no_pasien'      => $no_pasien,
                'nik'            => $request->nik,
                'nama_pasien'    => $request->nama_pasien,
                'tempat_lahir'   => $request->tempat_lahir,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'umur'           => $request->umur,
                'golongan_darah' => $request->golongan_darah,
                'alamat'         => $request->alamat,
                'no_hp'          => $request->no_hp,
                'pendidikan'     => $request->pendidikan,
                'agama'          => $request->agama,
                'pekerjaan'      => $request->pekerjaan,
                'nama_suami'     => $request->nama_suami,
            ]
        );

        // Jika yang diedit/diperbarui adalah PASIEN LAMA, langsung oper otomatis ke menu selanjutnya
        // Jika yang diedit/diperbarui adalah PASIEN LAMA, langsung oper otomatis ke menu selanjutnya
if ($request->id) {
    return redirect()->back()
    ->with('sukses', 'Data Ibu Hamil Berhasil Diperbarui!')
    ->with('edited_id', $pasienSimpan->id);
}

// Jika pasien BARU, biarkan tetap di halaman ini agar pop-up sukses muncul di atas tabel
return redirect()->route('bidan.inputDaftarPasien')->with('sukses', 'Data Ibu Hamil Berhasil Disimpan!');
    }

    // 3. API Fetch JSON untuk fitur onclick tabel
    public function showPasien($id)
    {
        $pasien = Pasien::findOrFail($id);
        return response()->json($pasien);
    }
}