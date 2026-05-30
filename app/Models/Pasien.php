<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

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
        'nama_suami'
    ];

    // Accessor agar seragam dengan Pendaftaran
    public function getNamaAttribute() {
        return $this->nama_pasien;
    }

    public function getTglLahirAttribute() {
        return $this->tanggal_lahir;
    }

    public function getGolDarahAttribute() {
        return $this->golongan_darah;
    }
}
