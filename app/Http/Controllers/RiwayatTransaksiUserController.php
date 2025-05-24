<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataPembayaran;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class RiwayatTransaksiUserController extends Controller
{
    public function index(Request $request)
    {
        // Ambil user dari session
        $user = Siswa::find(session('logged_in_siswa'));

        if (!$user) {
            return redirect('/login')->with('error', 'Sesi login tidak ditemukan.');
        }

        // Ambil parameter filter
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Query data pembayaran lunas milik user
        $query = DataPembayaran::with('transaksi')
            ->where('user_id', $user->id)
            ->where('status', 'lunas');

        if ($bulan) {
            $query->where('bulan', $bulan);
        }

        if ($tahun) {
            $query->where('tahun', $tahun);
        }

        $tagihans = $query->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->get();

        return view('user.riwayat_transaksi_user', compact('tagihans', 'user'));
    }
}