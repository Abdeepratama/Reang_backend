<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DumasRating extends Model
{
    use HasFactory;

    protected $fillable = ['dumas_id', 'user_id', 'rating', 'comment'];

    public function dumas()
    {
        return $this->belongsTo(Dumas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
