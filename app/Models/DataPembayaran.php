<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPembayaran extends Model
{
    //
    // Tentukan nama tabel yang benar
    protected $table = 'data_pembayaran';
    protected $fillable = ['admin_id', 'user_id', 'bulan', 'tahun', 'tagihan', 'status'];
    public function siswa()
    {
        return $this->belongsTo(\App\Models\Siswa::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'admin_id');
    }
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'id_data_pembayaran');
    }


}
