<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoKeagamaan extends Model
{
    protected $table = 'info_keagamaans';

    protected $fillable = [
        'foto', 'judul', 'tanggal', 'waktu', 'deskripsi', 'lokasi', 'alamat', 'fitur'
    ];
}
