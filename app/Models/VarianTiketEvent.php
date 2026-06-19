<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VarianTiketEvent extends Model
{
    use HasFactory;
    protected $table = 'varian_tiket_event';
    protected $fillable = ['id_tiket_event', 'nama_kelas', 'harga', 'kuota'];
}
