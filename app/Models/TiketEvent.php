<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketEvent extends Model
{
    use HasFactory;

    protected $table = 'tiket_event';

    protected $fillable = [
        'id_mitra',
        'nama_event',
        'kategori_event',
        'deskripsi',
        'lokasi',
        'tanggal_event',
        'jam_event',
        'foto_utama',
        'is_active',
    ];

    public function mitra()
    {
        return $this->belongsTo(MitraPlesir::class, 'id_mitra');
    }

    public function galeri()
    {
        return $this->hasMany(GaleriEvent::class, 'id_tiket_event');
    }

    public function varians()
    {
        return $this->hasMany(VarianTiketEvent::class, 'id_tiket_event');
    }
}
