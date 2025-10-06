<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puskesmas extends Model
{
    use HasFactory;

    protected $table = 'puskesmas';
    protected $fillable = ['nama', 'alamat', 'jam'];
    public $timestamps = false; // ✅ ini WAJIB kalau tidak mau pakai timestamps
}