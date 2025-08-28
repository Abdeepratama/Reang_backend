<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoKesehatan extends Model
{
    use HasFactory;

    protected $table = 'info_kesehatan';

    protected $fillable = [
        'foto',
        'judul',
        'deskripsi',
        'fitur',
    ];

    public function kategori()
{
    return $this->belongsTo(Kategori::class, 'kategori_id');
}
}
