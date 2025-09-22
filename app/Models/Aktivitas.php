<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Model
{
    use HasFactory;

    protected $table = 'aktivitas'; // opsional, kalau nama tabel tidak standar

    protected $fillable = [
        'keterangan',
        'tipe',
        'url',
        'item_id',
        'dibaca',
        'role',
        'dinas'
    ];
}
