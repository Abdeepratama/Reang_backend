<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    use HasFactory;

    protected $table = 'metode_pembayaran';

    protected $fillable = [
        'id_toko',
        'nama_metode',
        'jenis',
        'nama_penerima',
        'nomor_tujuan',
        'foto_qris',
        'keterangan',
    ];
}
