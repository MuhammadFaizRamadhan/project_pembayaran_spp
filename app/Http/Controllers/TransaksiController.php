<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Admin;
use App\Models\Siswa;
use App\Models\DataPembayaran;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['admin', 'siswa', 'dataPembayaran']);

        if ($request->filled('nama')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        if ($request->filled('bulan')) {
            $query->whereHas('dataPembayaran', function ($q) use ($request) {
                $q->where('bulan', $request->bulan);
            });
        }

        if ($request->filled('tahun')) {
            $query->whereHas('dataPembayaran', function ($q) use ($request) {
                $q->where('tahun', $request->tahun);
            });
        }

        if ($request->filled('status')) {
            $query->whereHas('dataPembayaran', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $transaksis = $query->get();

        return view('admin.riwayat_transaksi', compact('transaksis'));
    }



    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:belum dibayar,lunas',
        ]);

        $pembayaran = DataPembayaran::findOrFail($id);
        $pembayaran->status = $request->status;
        $pembayaran->save();

        return redirect()->route('admin.riwayat_transaksi')->with('success', 'Status berhasil diperbarui.');
    }
}