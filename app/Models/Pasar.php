<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasar extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'latitude', 'longitude','fitur'];

    protected $table = 'tempat_pasars'; // Sesuaikan jika nama tabel kamu bukan "pasars"
}
