<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dumas extends Model
{
    protected $fillable = [
        'jenis_laporan',
        'kategori_laporan',
        'lokasi_laporan',
        'deskripsi',
        'bukti_laporan',
        'status',
        'tanggapan'
    ];

    public function ratings()
    {
        return $this->hasMany(DumasRating::class);
    }
}
