<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    protected $table = 'instansi';
    protected $fillable = ['nama', 'jenis'];

    public function userData()
    {
        return $this->hasMany(UserData::class, 'id_instansi');
    }
}
