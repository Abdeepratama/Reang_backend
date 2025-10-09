<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifikasiAktivitas extends Model
{
    protected $fillable = [
        'keterangan',
        'dibaca',
        'url',
        'role',
        'id_instansi',
    ];

    public function scopeUnread($query)
    {
        return $query->where('dibaca', 0);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
