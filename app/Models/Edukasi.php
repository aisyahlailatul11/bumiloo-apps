<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    use HasFactory;

    protected $table = 'edukasis';
    protected $fillable = ['judul_edukasi', 'kategori', 'konten_edukasi', 'gambar'];
}