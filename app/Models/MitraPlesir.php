<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraPlesir extends Model
{
    use HasFactory;

    // --- PERUBAHAN DI SINI: Sesuaikan dengan nama tabel baru ---
    protected $table = 'mitra_plesir';

    protected $fillable = [
        'id_user',
        'nama',
        'deskripsi',
        'alamat',
        'kontak',
        'foto',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
