<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarPasien extends Model
{
    protected $table = 'daftar_pasien';

    protected $fillable = [
        'no_pasien',
        'nik',
        'nama_pasien',
        'tempat_lahir',
        'tanggal_lahir',
        'umur',
        'golongan_darah',
        'alamat',
        'no_hp',
        'pendidikan',
        'agama',
        'pekerjaan',
        'nama_suami',
    ];
}