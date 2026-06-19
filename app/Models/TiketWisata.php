<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketWisata extends Model
{
    use HasFactory;

    protected $table = 'tiket_wisata';

    protected $fillable = [
        'id_mitra',
        'nama_wisata',
        'kategori_wisata',
        'deskripsi',
        'fasilitas',
        'alamat',
        'jam_operasional',
        'harga_tiket',
        'kuota_per_hari',
        'foto_utama',
        'is_active',
    ];

    // Mengubah JSON di database menjadi array secara otomatis
    protected $casts = [
        'fasilitas' => 'array',
    ];

    public function mitra()
    {
        return $this->belongsTo(MitraPlesir::class, 'id_mitra');
    }

    public function galeri()
    {
        return $this->hasMany(GaleriWisata::class, 'id_tiket_wisata');
    }
}
