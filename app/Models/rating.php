<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'info_plesir_id',
        'user_id',
        'rating',
        'comment',
    ];

    public function infoPlesir()
    {
        return $this->belongsTo(InfoPlesir::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}