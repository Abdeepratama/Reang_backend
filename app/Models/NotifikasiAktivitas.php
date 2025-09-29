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
        'dinas',
    ];

    public function scopeUnread($query)
{
    return $query->where('dibaca', 0);
}
}
