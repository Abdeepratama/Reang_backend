<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Renbang extends Model
{
    use HasFactory;

    protected $table = 'renbangs_deskripsi';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'fitur',
        'alamat',
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

        return asset('images/default-plesir.jpg');
    }
}