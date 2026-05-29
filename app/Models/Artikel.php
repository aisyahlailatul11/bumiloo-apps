<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    // Daftarkan nama tabel dan kolom yang boleh diisi
    protected $table = 'artikels';
    
    protected $fillable = [
        'judul', 
        'kategori', 
        'deskripsi', 
        'gambar'
    ];
}