<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ibadah extends Model
{
    // beri tahu Laravel bahwa nama tabelnya bukan 'ibadahs', tapi 'tempat_ibadah'
    protected $table = 'tempat_ibadah';

    protected $fillable = [
        'name', 'latitude', 'longitude', 'address', 'fitur'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
