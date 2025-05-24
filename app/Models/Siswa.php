<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    // Tambahkan 'foto' agar bisa disimpan ke database
    protected $fillable = ['NISN', 'nama', 'alamat', 'email', 'password', 'foto'];
}