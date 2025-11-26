<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'alamat',
        'email',
        'phone',
        'no_ktp',
        'password',
        'fcm_token',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🔹 Relasi ke tabel role
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    // 🔹 Cek apakah user punya role tertentu
    public function hasRole($roleName)
    {
        return $this->role()->where('name', $roleName)->exists();
    }

    // 🔹 Tambahkan role ke user
    public function assignRole($roleName)
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        $this->role()->syncWithoutDetaching([$role->id]);
    }
}