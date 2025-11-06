<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    protected $table = 'user_data';

    public $timestamps = false;

    protected $fillable = [
        'id_admin',
        'id_instansi',
        'id_puskesmas',
        'nama',
        'email',
        'no_hp',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }

    public function dumas()
    {
        return $this->hasMany(Dumas::class, 'user_id', 'id');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'id_instansi');
    }

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'id_puskesmas');
    }
}
