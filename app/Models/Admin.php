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
}
