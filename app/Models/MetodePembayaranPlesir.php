<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePembayaranPlesir extends Model
{
    use HasFactory;

    // Pastikan menunjuk ke tabel yang benar agar tidak nyasar ke UMKM
    protected $table = 'metode_pembayaran_plesir';

    protected $fillable = [
        'user_id',
        'nama_metode',
        'jenis_metode',
        'nama_penerima',
        'nomor_rekening',
        'foto_qris',
        'is_active',
    ];

    // Jika kamu ingin menambahkan relasi ke tabel User/Mitra
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
