<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sehat extends Model
{
    use HasFactory;

    protected $table = 'sehats'; // <--- Ini penting!

    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
    ];
}
