<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = ['name', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];

    public function userData()
    {
        return $this->hasOne(UserData::class, 'id_admin');
    }

    public function getIdInstansiAttribute()
    {
        return $this->userData->id_instansi ?? null;
    }

    public function getIdPuskesmasAttribute()
    {
        return $this->userData->id_puskesmas ?? null;
    }

    public function hasAccess($fitur)
    {
        $instansi = strtolower($this->userData->instansi->nama ?? '');

        $mapping = [
            'kesehatan'   => ['sehat'],
            'dinas pendidikan'  => ['sekolah'],
            'dinas perdagangan' => ['pasar'],
            'dinas pariwisata'  => ['plesir'],
            'dinas keagamaan'   => ['ibadah'],
            'dinas pekerjaan'   => ['kerja'],
            'dinas perpajakan'  => ['pajak'],
        ];

        foreach ($mapping as $namaInstansi => $fiturs) {
            if ($instansi === $namaInstansi && in_array($fitur, $fiturs)) {
                return true;
            }
        }

        return false;
    }

    public function instansi()
    {
        return $this->hasOneThrough(
            Instansi::class,     // model tujuan akhir
            UserData::class,     // model perantara
            'id_admin',          // foreign key di user_data
            'id',                // foreign key di instansi
            'id',                // local key di admin
            'id_instansi'        // foreign key di user_data yg menunjuk ke instansi
        );
    }

    public function puskesmas()
    {
        return $this->hasOneThrough(
            Puskesmas::class,
            UserData::class,
            'id_admin',
            'id',
            'id',
            'id_puskesmas'
        );
    }

    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'id_admin');
    }
}
