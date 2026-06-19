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
    // Accessor untuk mengubah path foto profil Mitra menjadi URL lengkap
    // (Asumsi nama kolom di tabel database kamu adalah 'foto')
    public function getFotoAttribute($value)
    {
        if ($value) {
            $host = request()->getHttpHost();
            // Otomatis pakai https kalau terdeteksi pakai ngrok
            $scheme = str_contains($host, 'ngrok') ? 'https' : request()->getScheme();

            return $scheme . '://' . $host . '/storage/' . $value;
        }
        return null;
    }
}
