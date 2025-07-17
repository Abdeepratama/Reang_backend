<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renbang extends Model
{
    use HasFactory;

    protected $table = 'renbangs_deskripsi'; // Nama tabel (jika tidak pakai plural default)

    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'kategori',
    ];
}
