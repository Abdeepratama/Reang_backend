<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages'; // pastikan sesuai nama tabel di database

    protected $fillable = [
        'user_id',
        'admin_id',
        'dokter_id',
        'message',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
