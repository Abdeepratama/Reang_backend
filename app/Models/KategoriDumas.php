<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriDumas extends Model
{
    protected $fillable = ['id_instansi', 'nama_kategori'];

    protected $table = 'kategori_dumas';

    public $timestamps = false;

    public function dumas()
    {
        return $this->hasMany(Dumas::class, 'id_kategori', 'id');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'id_instansi');
    }
}
