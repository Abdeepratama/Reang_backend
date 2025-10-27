<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_umkm', 'id_user', 'id_produk', 'no_transaksi', 'no_resi',
        'alamat', 'jumlah', 'harga', 'total', 'subtotal', 'catatan',
        'status', 'jasa_pengiriman'
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'id_umkm');
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
