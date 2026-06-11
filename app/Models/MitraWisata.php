<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraWisata extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit sesuai migrasi kamu
    protected $table = 'mitra_wisata';

    protected $fillable = [
        'user_id',
        'nama_wisata',
        'alamat',
        'no_whatsapp',
        'deskripsi',
        'status',
        'foto_wisata',
        'latitude',
        'longitude',
    ];

    /**
     * Relasi ke model User
     * Setiap data mitra wisata pasti dimiliki oleh satu User (yang bertindak sebagai admin wisata)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}