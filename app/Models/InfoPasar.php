<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoPasar extends Model
{
    use HasFactory;

    protected $table = 'info_pasar';

    protected $fillable = [
        'nama',
        'alamat',
        'foto',
        'fitur',
        'latitude',
        'longitude',
    ];

    // Relasi ke kategori (opsional)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'fitur', 'fitur');
    }
}

