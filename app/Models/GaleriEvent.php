<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriEvent extends Model
{
    use HasFactory;
    protected $table = 'galeri_event';
    protected $fillable = ['id_tiket_event', 'foto'];
}
