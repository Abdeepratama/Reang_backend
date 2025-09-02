<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoKerja extends Model
{
    use HasFactory;

    protected $table = 'info_kerja';

    protected $fillable = [
        'name',
        'foto',
        'judul',
        'alamat',
        'gaji',
        'nomor_telepon',
        'waktu_kerja',
        'jenis_kerja',
        'fitur',
        'deskripsi',
        'kategori_id',
    ];

    // tambahkan ini supaya ikut di JSON/API
    protected $appends = ['gaji_formatted', 'whatsapp_link'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function getGajiFormattedAttribute()
    {
        if (is_numeric($this->gaji)) {
            return 'Rp ' . number_format($this->gaji, 0, ',', '.');
        }

        $parts = explode('-', $this->gaji);
        if (count($parts) === 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
            return 'Rp ' . number_format($parts[0], 0, ',', '.') . ' - Rp ' . number_format($parts[1], 0, ',', '.');
        }

        return $this->gaji;
    }

    public function getWhatsappLinkAttribute()
    {
        if (!$this->nomor_telepon) {
            return null;
        }

        $number = preg_replace('/\D/', '', $this->nomor_telepon);

        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        }

        return "https://wa.me/{$number}";
    }
}
