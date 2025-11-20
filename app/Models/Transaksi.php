<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';

    protected $fillable = [
        'id_user',
        'id_toko', 
        'no_transaksi', 
        'alamat', 
        'id_ongkir', 
        'jumlah', 
        'harga', 
        'total', 
        'subtotal', 
        'catatan',
        'status', 
        'jasa_pengiriman', 
        'nomor_resi' 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'no_transaksi', 'no_transaksi');
    }

    public function items()
    {         
        return $this->hasMany(DetailTransaksi::class, 'no_transaksi', 'no_transaksi');
    }
}