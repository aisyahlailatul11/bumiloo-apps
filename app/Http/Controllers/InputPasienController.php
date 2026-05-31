<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien; 
use App\Models\DaftarPasien;
use App\Models\Pendaftaran;
use Carbon\Carbon;

class InputPasienController extends Controller
{
    public function indexPasien($id)
    {
        $pendaftaranData = Pendaftaran::find($id);

        $pasien = null;
        $noPasienOtomatis = null;
        $statusPasien = 'baru'; // Default status awal

        if ($pendaftaranData) {
            // cek apakah pasien dengan NIK ini sudah ada
            $pasienLama = Pasien::where('nik', $pendaftaranData->nik)->first();

            if ($pasienLama) {
                // pasien lama → pakai data lama
                $pasien = $pasienLama;
                $statusPasien = 'lama'; // Tandai sebagai pasien lama
            } else {
                // pasien baru → isi dari pendaftaran
                $pasien = new Pasien();
                $pasien->nik            = $pendaftaranData->nik;
                $pasien->nama_pasien    = $pendaftaranData->nama;
                $pasien->tempat_lahir   = $pendaftaranData->tempat_lahir;
                $pasien->tanggal_lahir  = $pendaftaranData->tgl_lahir;
                $pasien->umur           = Carbon::parse($pendaftaranData->tgl_lahir)->age;
                $pasien->alamat         = $pendaftaranData->alamat;
                $pasien->no_hp          = $pendaftaranData->no_hp;
                $pasien->agama          = $pendaftaranData->agama;
                $pasien->pendidikan     = $pendaftaranData->pendidikan;
                $pasien->golongan_darah = $pendaftaranData->gol_darah;
                $pasien->pekerjaan      = $pendaftaranData->pekerjaan;
                $pasien->nama_suami     = $pendaftaranData->nama_suami;

                // generate nomor baru
                $totalPasien = Pasien::count() + 1;
                $noPasienOtomatis = '0' . str_pad($totalPasien, 4, '0', STR_PAD_LEFT);
            }
        }

        $pasienListMaster = Pasien::latest()->get();

        return view('bidan.inputDaftarPasien', [
            'pasien' => $pasien,
            'pasienMaster' => $pasienListMaster,
            'noPasienOtomatis' => $noPasienOtomatis,
            'statusPasien' => $statusPasien, // Dikirim ke view
            'pendaftaran_id' => $id // Mengirim ID pendaftaran agar redirect store tidak error
        ]);
    }

    public function storePasien(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|digits:16',
            'nama_pasien' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'golongan_darah' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        $umur = Carbon::parse($request->tanggal_lahir)->age;

        $pekerjaan = $request->pekerjaan === 'Lainnya'
            ? $request->pekerjaan_lainnya
            : $request->pekerjaan;

        $pasienLama = Pasien::where('nik', $request->nik)->first();

        if ($pasienLama) {
            $no_pasien = $pasienLama->no_pasien;
        } else {
            $totalPasien = Pasien::count() + 1;
            $no_pasien = '0' . str_pad($totalPasien, 4, '0', STR_PAD_LEFT);
        }

        Pasien::updateOrCreate(
            ['nik' => $request->nik],
            [
                'no_pasien'      => $no_pasien,
                'nama_pasien'    => $request->nama_pasien,
                'tempat_lahir'   => $request->tempat_lahir,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'umur'           => $umur,
                'golongan_darah' => $request->golongan_darah,
                'alamat'         => $request->alamat,
                'no_hp'          => $request->no_hp,
                'pendidikan'     => $request->pendidikan,
                'agama'          => $request->agama,
                'pekerjaan'      => $pekerjaan,
                'nama_suami'     => $request->nama_suami,
            ]
        );

        // Diperbaiki: Supaya setelah submit, halaman tidak error/kosong, dia kembali membawa ID pendaftaran asal
        return redirect()->route('bidan.inputDaftarPasien', ['id' => $request->pendaftaran_id])
            ->with('sukses', 'Data Pemeriksaan Ibu Hamil Berhasil Disimpan!');
    }

    public function showPasien($id)
    {
        $pasien = Pasien::findOrFail($id);
        return response()->json($pasien);
    }
}