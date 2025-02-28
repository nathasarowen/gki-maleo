<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Tentukan tabel yang digunakan
    protected $table = 'user';

    // Tentukan primary key yang digunakan
    protected $primaryKey = 'id_user';

    // Kolom yang bisa diisi (fillable)
    protected $fillable = [
        'username',
        'password',
        'is_admin',
    ];

    // Kolom yang disembunyikan
    protected $hidden = [
        'password',
    ];

    // Casting kolom tertentu (jika diperlukan)
    protected $casts = [
        'password' => 'hashed', // Laravel akan otomatis mengenkripsi password
    ];

    // Nonaktifkan timestamps karena tabel tidak memiliki created_at & updated_at
    public $timestamps = false;
}
