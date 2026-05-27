<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien; 

class InputPasienController extends Controller
{
    public function indexPasien()
    {
        $pasien = Pasien::latest()->get(); 

        $totalPasien = Pasien::count() + 1;
        $noPasienOtomatis = '0' . str_pad($totalPasien, 4, '0', STR_PAD_LEFT);

        return view('bidan.inputDaftarPasien', compact('pasien', 'noPasienOtomatis'));
    }

    public function storePasien(Request $request)
    {
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

        if ($request->id) {
            $pasienLama = Pasien::findOrFail($request->id);
            $no_pasien = $pasienLama->no_pasien;
        } else {
            $totalPasien = Pasien::count() + 1;
            $no_pasien = '0' . str_pad($totalPasien, 4, '0', STR_PAD_LEFT);
        }

        $pekerjaan = $request->pekerjaan;
        if ($pekerjaan === 'Lainnya') {
            $pekerjaan = $request->pekerjaan_lainnya;
            }

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
                'pekerjaan'      => $pekerjaan,
                'nama_suami'     => $request->nama_suami,
            ]
        );

if ($request->id) {
    return redirect()->route('bidan.inputDaftarPasien', ['pasien_id' => $pasienSimpan->id])
                     ->with('sukses', 'Data Ibu Hamil Berhasil Diperbarui!')
                     ->with('edited_id', $pasienSimpan->id);
}

        return redirect()->route('bidan.inputDaftarPasien')->with('sukses', 'Data Ibu Hamil Berhasil Disimpan!');
    }

     public function showPasien($id)
    {
        $pasien = Pasien::findOrFail($id);
        return response()->json($pasien);
    }
}