<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    // Masukkan nama tabel database kamu di bawah ini jika namanya bukan 'artikels' (misal: 'tb_artikel')
    // protected $table = 'tb_artikel';
    protected $table = 'edukasis';

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment).
     * Kolom-kolom ini wajib didaftarkan agar bisa diproses oleh fungsi Artikel::create() di Controller.
     */
    protected $fillable = [
        'judul_edukasi',
        'kategori',
        'konten_edukasi',
        'gambar',
    ];
}