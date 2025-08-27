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
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
