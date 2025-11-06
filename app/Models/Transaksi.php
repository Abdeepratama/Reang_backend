<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';

    protected $fillable = [
        'id_user', 'no_transaksi', 'no_resi',
        'alamat', 'id_ongkir', 'jumlah', 'harga', 'total', 'subtotal', 'catatan',
        'status', 'jasa_pengiriman'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'no_transaksi', 'no_transaksi');
    }

    public function items()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id');
    }
}