<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plesir extends Model
{
    protected $table = 'plesirs'; // Pastikan tabel ini sudah dibuat di database
    protected $fillable = ['name', 'address', 'latitude', 'longitude'];
}
