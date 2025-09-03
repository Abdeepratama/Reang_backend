<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfoAdminduk extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'info_adminduk';

    // Kolom yang bisa diisi
    protected $fillable = [
        'judul',
        'deskripsi',
    ];
}
