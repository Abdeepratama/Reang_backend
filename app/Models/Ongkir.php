<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ongkir extends Model
{
    use HasFactory;

    protected $table = 'ongkir';

    protected $fillable = [
        'id_toko',
        'dareah',
        'harga',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }
}

