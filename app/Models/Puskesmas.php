<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puskesmas extends Model
{
  use HasFactory;

  protected $table = 'puskesmas';

  protected $fillable = ['nama', 'alamat', 'latitude','longitude', 'jam'];

  public $timestamps = false;

  public function dokter()
  {
    return $this->hasMany(Dokter::class, 'id_puskesmas');
  }

  public function instansi()
  {
    return $this->belongsTo(Instansi::class, 'id_instansi');
  }
}
