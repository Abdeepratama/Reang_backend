<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'id_instansi',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'id_instansi');
    }

    public function hasAccess($module)
    {
        // Superadmin selalu boleh
        if ($this->role === 'superadmin') {
            return true;
        }

        // Kalau tidak punya instansi → tolak
        if (!$this->instansi) {
            return false;
        }

        // Mapping modul ke id_instansi
        $map = [
            'dumas'    => [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13], // semua instansi
            'sehat'    => [2], // hanya dinas kesehatan
            'sekolah'  => [4], // hanya pendidikan
            'pajak'    => [5], // hanya perpajakan
            'pasar'    => [7], // hanya perdagangan
            'kerja'    => [6], // hanya dinas kerja
            'plesir'   => [8], // hanya pariwisata
            'ibadah'   => [9], // hanya keagamaan
            'adminduk' => [10], // hanya kependudukan
            'renbang'  => [12], // hanya pembangunan
            'izin'     => [13], // hanya perizinan
            'wifi'     => [1], // misalnya informatika
        ];

        // Kalau modul tidak ada → default tolak
        if (!isset($map[$module])) {
            return false;
        }

        // Cek apakah id_instansi user ada di list modul
        return in_array($this->id_instansi, $map[$module]);
    }
}
