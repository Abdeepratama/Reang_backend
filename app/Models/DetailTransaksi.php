<?php

// Lokasi: app/Models/DetailTransaksi.php (File Baru)

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    
    /**
     * Nama tabel untuk menyimpan item-item pesanan.
     */
    protected $table = 'detail_transaksi';

    /**
     * Kita tidak perlu created_at/updated_at di tabel ini
     * (kecuali Anda memang membuatnya).
     */
    public $timestamps = false; 

    protected $fillable = [
        'id_transaksi', // (Foreign key ke tabel 'transaksi')
        'no_transaksi', // (Atau bisa pakai 'no_transaksi' jika itu key Anda)
        'id_toko',
        'id_produk',
        'jumlah',
        'harga',
        'subtotal'
    ];

    /**
     * Relasi kembali ke Induk Transaksi.
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id');
    }

    /**
     * Relasi ke data produk.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}