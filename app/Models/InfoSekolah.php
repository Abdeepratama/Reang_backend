<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfoSekolah extends Model
{
    use HasFactory;

    // Nama tabel (opsional, kalau sama dengan plural nama model, bisa dihapus)
    protected $table = 'info_sekolah';

    // Field yang bisa diisi
    protected $fillable = [
        'foto',
        'judul',
        'deskripsi',
    ];
}
