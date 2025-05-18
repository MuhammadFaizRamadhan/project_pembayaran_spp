<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPembayaran;
use App\Models\Admin;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = DataPembayaran::with('siswa', 'admin')->latest();

        if ($request->filled('search')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pembayaran = $query->get();
        $siswas = Siswa::all();

        return view('admin.data_pembayaran', compact('pembayaran', 'siswas'));
    }


    public function create()
    {
        $siswa = Siswa::all();
        return view('admin.data_pembayaran.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:siswa,id',
            'semester' => 'required|in:1,2',
            'tahun' => 'required|digits:4',
            'tagihan' => 'required|numeric',
            'status' => 'required|in:belum dibayar,lunas'
        ]);

        $adminId = Admin::find(session('logged_in_admin'))->id;
        $bulanList = $request->semester == 1
            ? ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni']
            : ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        foreach ($bulanList as $bulan) {
            DataPembayaran::create([
                'admin_id' => $adminId,
                'user_id' => $request->user_id,
                'bulan' => $bulan,
                'tahun' => $request->tahun,
                'tagihan' => $request->tagihan,
                'status' => $request->status,
            ]);
        }

        return redirect()->route('data_pembayaran.index')->with('success', 'Tagihan untuk 6 bulan berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $pembayaran = DataPembayaran::findOrFail($id);
        $siswa = Siswa::all();
        return view('admin.data_pembayaran.edit', compact('pembayaran', 'siswa'));
    }

    public function update(Request $request, $id)
    {
        $pembayaran = DataPembayaran::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:siswa,id',
            'bulan' => 'required',
            'tahun' => 'required|digits:4',
            'tagihan' => 'required|numeric',
            'status' => 'required'
        ]);

        $pembayaran->update([
            'user_id' => $request->user_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'tagihan' => $request->tagihan,
            'status' => $request->status
        ]);

        return redirect()->route('data_pembayaran.index')->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pembayaran = DataPembayaran::findOrFail($id);
        $pembayaran->delete();
        return redirect()->route('data_pembayaran.index')->with('success', 'Data pembayaran berhasil dihapus.');
    }
}
