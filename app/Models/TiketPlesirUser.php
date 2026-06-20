<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiketPlesirUser extends Model
{
    protected $table = 'tiket_plesir_user';
    protected $guarded = ['id'];

    public function transaksi()
    {
        return $this->belongsTo(TransaksiPlesir::class, 'transaksi_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
