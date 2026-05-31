<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    // UBAH DI SINI: Arahkan ke nama tabel asli di database kamu, yaitu 'edukasis'
    protected $table = 'edukasis';
    
    protected $fillable = [
        'judul', 
        'kategori', 
        'deskripsi', 
        'gambar'
    ];
}