<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPlesir extends Model
{
    protected $table = 'transaksi_plesir';
    protected $guarded = ['id'];

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
        return $this->belongsTo(User::class);
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
}
