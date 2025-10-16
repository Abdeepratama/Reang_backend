<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenbangAjuan extends Model
{
    use HasFactory;

    protected $table = 'renbang'; 
    
    protected $fillable = [
        'user_id',
        'judul',
        'kategori',
        'lokasi',
        'deskripsi',
        'status',
        'tanggapan',
    ];

    protected $attributes = [
        'status' => 'menunggu',
    ];

    // Relasi ke user (jika ada)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
