<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaftarPasienController extends Controller
{
    public function index()
    {
        // Dummy data array
        $pasienList = [
            (object)[
                'id' => 1,
                'nama_pasien' => 'Siti Aminah',
                'jadwal_kontrol' => '09:00 WIB',
                'kategori' => 'Pemeriksaan'
            ],
            (object)[
                'id' => 2,
                'nama_pasien' => 'Dewi Lestari',
                'jadwal_kontrol' => '13:30 WIB',
                'kategori' => 'Kontrol'
            ],
            (object)[
                'id' => 3,
                'nama_pasien' => 'Rina Kartika',
                'jadwal_kontrol' => '15:00 WIB',
                'kategori' => 'Imunisasi'
            ],
        ];

        // kirim ke view
        return view('bidan.daftarPasien', compact('pasienList'));
    }
}
