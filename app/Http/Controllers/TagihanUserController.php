<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPembayaran;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Storage;

class TagihanUserController extends Controller
{
    public function index(Request $request)
    {
        $user = Siswa::find(session('logged_in_siswa'));
        if (!$user) {
            return redirect('/login')->with('error', 'Sesi login tidak ditemukan.');
        }

        // Ambil filter dari input form
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Query tagihan sesuai filter
        $query = DataPembayaran::where('user_id', $user->id);
        if ($bulan) {
            $query->where('bulan', $bulan);
        }
        if ($tahun) {
            $query->where('tahun', $tahun);
        }
        $tagihans = $query->get();

        return view('user.tagihan_user', compact('tagihans', 'user', 'bulan', 'tahun'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_data_pembayaran' => 'required|exists:data_pembayaran,id',
            'tgl_transaksi' => 'required|date',
            'total_pembayaran' => 'required|numeric',
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $dataPembayaran = DataPembayaran::find($request->id_data_pembayaran);

        if (!$dataPembayaran) {
            return redirect()->back()->with('error', 'Data pembayaran tidak ditemukan.');
        }

        $buktiBayarPath = $request->file('bukti_bayar')->store('bukti_bayar', 'public');

        Transaksi::create([
            'admin_id' => $dataPembayaran->admin_id,
            'user_id' => $dataPembayaran->user_id,
            'id_data_pembayaran' => $dataPembayaran->id,
            'tgl_transaksi' => $request->tgl_transaksi,
            'total_pembayaran' => $request->total_pembayaran,
            'bukti_bayar' => $buktiBayarPath,
        ]);

        $dataPembayaran->update(['status' => 'proses']);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }
}