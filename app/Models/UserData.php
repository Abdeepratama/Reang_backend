<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    protected $table = 'user_data'; // nama tabel

    protected $primaryKey = 'id'; // primary key

    // Kolom yang bisa diisi massal (fillable)
    protected $fillable = [
        'id_admins',
        'id_instansi',
        'nama',
        'email',
        'no_hp',
    ];

    // Relasi ke Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admins');
    }

    public function dumas()
    {
        return $this->hasMany(Dumas::class, 'user_id', 'id');
    }

    // Relasi ke Instansi (jika ada tabel instansi)
    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'id_instansi');
    }
}
