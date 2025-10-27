<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkm';

    protected $fillable = [
        'nama', 'deskripsi', 'alamat', 'no_hp', 'foto'
    ];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_umkm');
    }

    public function owner()
    {
        return $this->hasOne(Owner::class, 'id_umkm');
    }
}
