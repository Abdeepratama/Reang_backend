<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoPlesir extends Model
{
    protected $table = 'info_plesir';

    protected $fillable = [
        'judul', 'alamat', 'rating', 'deskripsi', 'foto', 'fitur'
    ];
}
