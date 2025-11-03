<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_toko', 'nama', 'foto', 'harga', 'variasi',
        'deskripsi', 'spesifikasi', 'lokasi', 'fitur', 'stok'
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }
}
