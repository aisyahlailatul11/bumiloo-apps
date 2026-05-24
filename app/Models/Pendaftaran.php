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

    // --- TARUH DI SINI (Di bawah fungsi user) ---
    /**
     * Accessor untuk menghitung usia kehamilan secara otomatis dari kolom hpht
     */
    public function getUsiaKehamilanAttribute()
    {
        if (!$this->hpht) {
            return '0 Minggu';
        }

        $tanggalHpht = \Carbon\Carbon::parse($this->hpht);
        $sekarang = \Carbon\Carbon::now();
        
        // Menghitung selisih minggu dari HPHT sampai sekarang
        $selisihMinggu = $tanggalHpht->diffInWeeks($sekarang);

        return $selisihMinggu . ' Minggu';
    }
} // <-- Ini kurung kurawal tutup paling akhir dari class Pendaftaran