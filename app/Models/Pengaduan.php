<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'jenis_laporan',
        'kategori_laporan',
        'lokasi_laporan',
        'deskripsi',
        'bukti_laporan',
        'pernyataan',
        'status',
        'tanggapan'
    ];
}