<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ibadah extends Model
{
    // beri tahu Laravel bahwa nama tabelnya bukan 'ibadahs', tapi 'tempat_ibadah'
    protected $table = 'tempat_ibadah';

    protected $fillable = ['name', 'address', 'latitude', 'longitude'];
}