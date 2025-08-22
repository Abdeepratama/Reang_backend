<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class InfoPlesir extends Model
{
    protected $table = 'info_plesir'; // tambahkan ini

    protected $fillable = [
        'foto',
        'judul',
        'alamat',
        'rating',
        'deskripsi',
        'fitur',
        'latitude',
        'longitude'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'fitur', 'id');
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return Storage::url($this->foto);
        }

        return asset('images/default-sehat.jpg');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'info_plesir_id');
    }

    // akses rata-rata rating langsung
    protected $appends = ['avg_rating'];

    public function getAvgRatingAttribute()
    {
        $avg = $this->ratings()->avg('rating');   // bisa null
        return $avg !== null ? round((float) $avg, 1) : 0.0;
    }
}
