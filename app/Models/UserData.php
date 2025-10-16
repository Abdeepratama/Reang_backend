<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    protected $table = 'user_data';
    public $timestamps = false; // 🟢 Tambahkan baris ini

    protected $fillable = [
        'id_admin',
        'id_instansi',
        'nama',
        'email',
        'no_hp',
    ];


    /**
     * Relasi ke model Admin
     * Satu user_data dimiliki oleh satu admin
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }

    /**
     * Relasi ke laporan DUMAS (jika ada)
     */
    public function dumas()
    {
        return $this->hasMany(Dumas::class, 'user_id', 'id');
    }

    /**
     * Relasi ke tabel Instansi (jika ada)
     */
    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'id_instansi');
    }
}
