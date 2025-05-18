<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang benar
    protected $table = 'siswa'; // ✅ Pastikan ini adalah nama tabel yang benar

    // Jika kamu memiliki kolom lain yang perlu diatur
    protected $fillable = ['NISN', 'nama', 'alamat', 'email', 'password']; 
}