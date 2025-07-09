<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dumas extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     * Secara default Laravel akan menggunakan nama plural dari nama model (dumas -> dumas).
     * Jika nama tabel Anda berbeda (misal 'complaints'), Anda bisa menentukannya secara eksplisit:
     * protected $table = 'complaints';
     */
    protected $table = 'dumas'; // Sesuaikan jika nama tabel Anda berbeda, misal 'complaints'

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Tambahkan semua kolom yang boleh diisi melalui form.
     * Contoh kolom yang mungkin ada di tabel 'dumas':
     * - user_id (ID pengguna yang membuat pengaduan)
     * - subject (subjek pengaduan)
     * - description (deskripsi detail pengaduan)
     * - status (misal: 'baru', 'diproses', 'selesai', 'ditolak')
     * - attachment (nama file lampiran, jika ada)
     * - category (kategori pengaduan, misal: 'pelayanan publik', 'fasilitas umum')
     */
    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'status',
        'attachment',
        'category',
        // Tambahkan kolom lain yang relevan di sini
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     * Contoh: 'is_resolved' => 'boolean'
     */
    protected $casts = [
        // 'is_resolved' => 'boolean',
    ];

    /**
     * Relasi dengan model User (jika ada).
     * Sebuah pengaduan dimiliki oleh satu pengguna.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}