<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pasar extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'latitude', 'longitude','fitur'];

    protected $table = 'tempat_pasars'; // Sesuaikan jika nama tabel kamu bukan "pasars"

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
