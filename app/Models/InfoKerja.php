<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoKerja extends Model
{
    use HasFactory;

    protected $table = 'info_kerja';

    protected $fillable = [
        'foto',
        'judul',
        'alamat',
        'gaji',
        'nomor_telepon',
        'waktu_kerja',
        'jenis_kerja',
        'fitur',
        'deskripsi',
        'kategori_id',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}

