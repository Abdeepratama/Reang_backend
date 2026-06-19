<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class GaleriWisata extends Model
{
    use HasFactory;

    protected $table = 'galeri_wisata';

    protected $fillable = [
        'id_tiket_wisata',
        'foto',
    ];

    public function tiket()
    {
        return $this->belongsTo(TiketWisata::class, 'id_tiket_wisata');
    }
}
