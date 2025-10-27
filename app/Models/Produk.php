<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_umkm', 'nama', 'foto', 'harga', 'variasi',
        'deskripsi', 'spesifikasi', 'lokasi', 'fitur', 'stok'
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'id_umkm');
    }
}
