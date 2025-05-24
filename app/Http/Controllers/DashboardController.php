<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Siswa;
use App\Models\DataPembayaran;
use App\Models\Transaksi; // ✅ Tambahkan model Transaksi

class DashboardController extends Controller
{
    public function admin()
    {
        $admin = Admin::find(session('logged_in_admin'));

        $transaksis = Transaksi::with(['siswa', 'dataPembayaran'])
            ->where('admin_id', $admin->id)
            ->get();

        $totalSiswa = Siswa::count();
        $totalLunas = DataPembayaran::where('status', 'lunas')->count();
        $totalBelumBayar = DataPembayaran::where('status', '!=', 'lunas')->count();
        $totalTransaksi = $transaksis->count();

        return view('dashboard.admin', compact(
            'admin',
            'transaksis',
            'totalSiswa',
            'totalLunas',
            'totalBelumBayar',
            'totalTransaksi'
        ));
    }


    public function user()
    {
        $user = Siswa::find(session('logged_in_siswa'));

        $tagihanBelumBayar = DataPembayaran::where('user_id', $user->id)
            ->where('status', '!=', 'lunas')
            ->get();

        return view('dashboard.user', compact('user', 'tagihanBelumBayar'));
    }

    public function dataSiswa()
    {
        $admin = Admin::find(session('logged_in_admin'));
        $siswa = Siswa::all();
        return view('admin.data_siswa', compact('admin', 'siswa'));
    }
}
