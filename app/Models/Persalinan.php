<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persalinan extends Model
{
    use HasFactory;

    protected $table = 'persalinan';
    protected $guarded = ['id'];

    public function perkembangan()
    {
        return $this->belongsTo(Perkembangan::class, 'perkembangan_id');
    }
}