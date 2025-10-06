<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TempatSekolah extends Model
{
    // Nama tabel di database
    protected $table = 'tempat_sekolahs';

    public $timestamps = false;  

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'address',
        'fitur',
        'foto'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return Storage::url($this->foto);
        }

        return asset('images/default-sekolah.jpg');
    }
}
