<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_toko', 'id_user', 'id_produk', 'no_transaksi', 'no_resi',
        'alamat', 'id_ongkir', 'jumlah', 'harga', 'total', 'subtotal', 'catatan',
        'status', 'jasa_pengiriman'
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'no_transaksi', 'no_transaksi');
    }
}
