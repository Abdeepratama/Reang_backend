<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPlesir extends Model
{
    protected $table = 'transaksi_plesir';

    // 👇 Menggunakan fillable dan menghapus guarded agar lebih aman
    protected $fillable = [
        'user_id',
        'id_mitra', // <--- Tambahan id_mitra
        'metode_pembayaran_id',
        'kode_invoice',
        'kode_tiket',
        'kategori_tiket',
        'wisata_id',
        'event_id',
        'varian_id',
        'tanggal_kunjungan',
        'jumlah_tiket',
        'total_harga',
        'status_pembayaran',
        'bukti_pembayaran',
        'keterangan_admin',
    ];

    // Accessor otomatis untuk URL bukti pembayaran (Support Ngrok)
    public function getBuktiPembayaranAttribute($value)
    {
        if ($value) {
            $host = request()->getHttpHost();
            $scheme = str_contains($host, 'ngrok') ? 'https' : request()->getScheme();
            return $scheme . '://' . $host . '/storage/' . $value;
        }
        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function wisata()
    {
        return $this->belongsTo(TiketWisata::class, 'wisata_id');
    }

    public function event()
    {
        return $this->belongsTo(TiketEvent::class, 'event_id');
    }

    // Jika event memiliki varian kelas
    public function varian()
    {
        return $this->belongsTo(VarianTiketEvent::class, 'varian_id');
    }

    public function tiketUsers()
    {
        return $this->hasMany(TiketPlesirUser::class, 'transaksi_id');
    }

    // 👇 Tambahkan relasi ini agar Admin bisa melihat jenis bank & rekening pembeli (dari Controller sebelumnya)
    public function metodePembayaran()
    {
        // 👇 Ubah relasinya agar menunjuk tepat ke metode yang dipilih user
        return $this->belongsTo(MetodePembayaranPlesir::class, 'metode_pembayaran_id');
    }
}
