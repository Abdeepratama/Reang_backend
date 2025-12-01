<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $table = 'toko';

    protected $fillable = [
        'id_user',
        'nama',
        'deskripsi',
        'alamat',
        'no_hp',
        'foto',
        'email_toko',
        'nama_pemilik',
        'tahun_berdiri',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }
        public function getFotoAttribute($value)
    {
        if ($value) {
            return asset('storage/' . $value);
        }
        return null;
    }
}