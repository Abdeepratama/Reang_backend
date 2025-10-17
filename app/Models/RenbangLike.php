<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenbangLike extends Model
{
    protected $table = 'renbang_like';
    protected $fillable = ['id_user', 'id_renbang'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function renbang()
    {
        return $this->belongsTo(Renbang::class, 'id_renbang');
    }
}
