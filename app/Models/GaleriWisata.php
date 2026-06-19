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
    // Accessor untuk mengubah path foto galeri Wisata menjadi URL lengkap
    // (Asumsi nama kolom di database adalah 'foto')
    public function getFotoAttribute($value)
    {
        if ($value) {
            $host = request()->getHttpHost();
            $scheme = str_contains($host, 'ngrok') ? 'https' : request()->getScheme();

            return $scheme . '://' . $host . '/storage/' . $value;
        }
        return null;
    }
}
