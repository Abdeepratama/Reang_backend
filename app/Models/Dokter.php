<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';
    public $timestamps = false;

    protected $fillable = [
        'id_puskesmas',
        'nama',
        'pendidikan',
        'fitur',
        'umur',
        'nomer',
        'admin_id',
    ];

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'id_puskesmas');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'fitur', 'nama');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'dokter_id');
    }
}
