<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dumas extends Model
{
    protected $fillable = [
        'user_id',
        'id_kategori',
        'jenis_laporan',
        'lokasi_laporan',
        'deskripsi',
        'bukti_laporan',
        'status',
        'tanggapan',
        'pernyataan'
    ];

    protected $table = 'dumas';

    public function ratings()
    {
        return $this->hasMany(DumasRating::class);
    }

    public function kategori()
    {
        return $this->belongsTo(kategori_dumas::class, 'id_kategori');
    }
}
