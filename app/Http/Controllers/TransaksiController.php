<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Admin;
use App\Models\Siswa;
use App\Models\DataPembayaran;
use Illuminate\Support\Facades\Storage;
use PDF;

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

    // untuk halaman rekap_pembayaran.blade.php 
    public function rekapPembayaran(Request $request)
    {
        $bulanList = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $query = DataPembayaran::select('bulan', 'tahun')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN status = 'lunas' THEN 1 ELSE 0 END) as lunas")
            ->selectRaw("SUM(CASE WHEN status = 'belum dibayar' THEN 1 ELSE 0 END) as belum_dibayar")
            ->groupBy('bulan', 'tahun');

        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $rekap = $query
            ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->orderBy('tahun', 'desc')
            ->get();

        // Data per siswa per bulan
        $dataSiswa = Siswa::with(['pembayaran'])->get();
        $rekapSiswa = [];

        foreach ($dataSiswa as $siswa) {
            $rekapSiswa[$siswa->nama] = [];
            foreach ($bulanList as $bulan) {
                $pembayaran = $siswa->pembayaran->firstWhere('bulan', $bulan);
                $rekapSiswa[$siswa->nama][$bulan] = $pembayaran && $pembayaran->status === 'lunas' ? number_format($pembayaran->tagihan, 0) : '';
            }
        }

        return view('admin.rekap_pembayaran', compact('rekap', 'bulanList', 'rekapSiswa'));
    }


    public function exportPDF(Request $request)
    {
        $bulanList = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $query = DataPembayaran::select('bulan', 'tahun')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN status = 'lunas' THEN 1 ELSE 0 END) as lunas")
            ->selectRaw("SUM(CASE WHEN status = 'belum dibayar' THEN 1 ELSE 0 END) as belum_dibayar")
            ->groupBy('bulan', 'tahun');

        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $rekap = $query
            ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')")
            ->orderBy('tahun', 'desc')
            ->get();

        // Opsional: jika ingin rekap siswa juga dalam PDF
        $dataSiswa = Siswa::with(['pembayaran'])->get();
        $rekapSiswa = [];

        foreach ($dataSiswa as $siswa) {
            $rekapSiswa[$siswa->nama] = [];
            foreach ($bulanList as $bulan) {
                $pembayaran = $siswa->pembayaran->firstWhere('bulan', $bulan);
                $rekapSiswa[$siswa->nama][$bulan] = $pembayaran && $pembayaran->status === 'lunas' ? number_format($pembayaran->tagihan, 0) : '';
            }
        }

        $pdf = PDF::loadView('admin.rekap_pembayaran_pdf', compact('rekap', 'bulanList', 'rekapSiswa'));
        return $pdf->download('rekap_pembayaran.pdf');
    }


}