<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $table = 'owner'; // nama tabel kamu

    protected $fillable = [
        'id_umkm',
        'nama',
        'foto',
        'no_hp',
        'alamat',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'id_umkm');
    }
}
