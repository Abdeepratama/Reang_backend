<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriEvent extends Model
{
    use HasFactory;
    protected $table = 'galeri_event';
    protected $fillable = ['id_tiket_event', 'foto'];

    // Accessor untuk mengubah path foto galeri Event menjadi URL lengkap
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
