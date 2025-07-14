<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;

    protected $table = 'infos'; // nama tabel (bisa diubah sesuai kebutuhan)

    protected $fillable = [
        'judul',
        'isi',
        'gambar', // jika ingin menyimpan path gambar
    ];
}
