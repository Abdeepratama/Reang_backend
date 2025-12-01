<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasan';

    protected $fillable = [
        'id_user',
        'id_produk',
        'no_transaksi',
        'rating',
        'komentar',
        'foto',
    ];

    // Relasi ke User (untuk menampilkan nama pereview)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}