<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolahs'; // atau 'sekolah' jika kamu tidak pakai plural

    protected $fillable = [
        'jenis_laporan',
        'kategori_laporan',
        'lokasi_laporan',
        'status',
        'bukti_laporan',
        'deskripsi',
        'pernyataan',
    ];
}
