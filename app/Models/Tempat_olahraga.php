<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Tempat_olahraga extends Model
{
    use HasFactory;

    protected $table = 'tempat_olahraga'; 

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'address',
        'foto'
    ];

    public function getPhotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return Storage::url($this->foto);
        }

        return asset('images/default-olahraga.jpg');
    }
}
