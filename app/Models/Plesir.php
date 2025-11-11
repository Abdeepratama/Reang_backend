<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Plesir extends Model
{
    // beri tahu Laravel bahwa nama tabelnya bukan 'ibadahs', tapi 'tempat_ibadah'
    protected $table = 'tempat_plesirs';

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
        return $this->belongsTo(Kategori::class, 'fitur', 'id');
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return Storage::url($this->foto);
        }

        return asset('images/default-plesir.jpg');
    }
}
