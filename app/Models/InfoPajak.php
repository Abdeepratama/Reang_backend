<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfoPajak extends Model
{
    use HasFactory;

    // Nama tabel (opsional kalau sesuai default plural: info_pajaks)
    protected $table = 'info_pajak';

    // Field yang bisa diisi
    protected $fillable = [
        'foto',
        'judul',
        'deskripsi',
    ];
}
