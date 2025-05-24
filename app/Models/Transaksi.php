<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 'user_id', 'id_data_pembayaran',
        'tgl_transaksi', 'total_pembayaran', 'bukti_bayar'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'user_id');
    }

    public function dataPembayaran()
    {
        return $this->belongsTo(DataPembayaran::class, 'id_data_pembayaran');
    }
}