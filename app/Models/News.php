<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     * Secara default Laravel akan menggunakan nama plural dari nama model (news -> news).
     * Jika nama tabel Anda berbeda (misal 'articles'), Anda bisa menentukannya secara eksplisit:
     * protected $table = 'articles';
     */
    protected $table = 'news'; // Sesuaikan jika nama tabel Anda berbeda, misal 'articles'

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Contoh kolom yang mungkin ada di tabel 'news':
     * - title (judul berita)
     * - slug (URL ramah SEO)
     * - content (isi berita)
     * - author_id (ID penulis/admin yang memposting berita)
     * - image (nama file gambar utama berita)
     * - published_at (tanggal publikasi)
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'author_id',
        'image',
        'published_at',
        // Tambahkan kolom lain yang relevan di sini
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     * Contoh: 'published_at' => 'datetime'
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Relasi dengan model User (jika ada).
     * Sebuah berita mungkin memiliki penulis (admin/user).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}