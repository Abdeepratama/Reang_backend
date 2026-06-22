<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePembayaranPlesir extends Model
{
    use HasFactory;

    protected $table = 'metode_pembayaran_plesir';

    protected $fillable = [
        'id_mitra',
        'nama_metode',
        'jenis_metode',
        'nama_penerima',
        'nomor_rekening',
        'foto_qris',
        'is_active',
    ];

    public function mitra()
    {
        return $this->belongsTo(User::class, 'id_mitra');
    }

    // =========================================================
    // 👇 NAMA FUNGSI SUDAH DIPERBAIKI SESUAI NAMA KOLOM
    // =========================================================
    public function getFotoQrisAttribute($value)
    {
        // Cek jika datanya tidak kosong dan belum diawali 'http'
        if ($value && !str_starts_with($value, 'http')) {
            return asset('storage/' . $value);
        }

        return $value;
    }
}
