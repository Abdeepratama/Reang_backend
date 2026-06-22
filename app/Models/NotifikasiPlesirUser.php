<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiPlesirUser extends Model
{
    use HasFactory;

    protected $table = 'notifikasi_plesir_users';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transaksi()
    {
        return $this->belongsTo(TransaksiPlesir::class, 'transaksi_id');
    }
}
