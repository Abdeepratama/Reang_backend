<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanikButton extends Model
{
    use HasFactory;

    protected $table = 'panik_button';

    protected $fillable = ['name', 'nomer'];
}
