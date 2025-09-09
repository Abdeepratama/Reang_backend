<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class InfoAdminduk extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'info_adminduk';

    // Kolom yang bisa diisi
    protected $fillable = [
        'judul',
        'deskripsi',
        'foto',
    ];

    public function getPhotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return Storage::url($this->foto);
        }

        return asset('images/default-adminduk.jpg');
    }
}
