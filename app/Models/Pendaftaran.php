<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'tb_pendaftaran';

    protected $fillable = [
        'user_id', 
        'nik',
        'nama',
        'tempat_lahir',
        'tgl_lahir',
        'umur',
        'alamat',
        'no_hp',
        'agama',
        'pendidikan',
        'gol_darah',
        'pekerjaan',
        'nama_suami',
        'tgllahir_suami',
        'usia_suami',
        'hpht'
    ];

    // Relasi ke User (Jika ingin mengambil data akun yang mendaftar)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}