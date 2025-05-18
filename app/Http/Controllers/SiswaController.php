<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Admin;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $siswa = Siswa::when($keyword, function ($query) use ($keyword) {
            $query->where('NISN', 'like', "%$keyword%")
                ->orWhere('nama', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%");
        })->get();

        return view('admin.data_siswa', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NISN' => 'required|unique:siswa,NISN',
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        Siswa::create([
            'NISN' => $request->NISN,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'NISN' => 'required|unique:siswa,NISN,' . $id,
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
        ]);

        $siswa->update([
            'NISN' => $request->NISN,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        Siswa::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Siswa berhasil dihapus');
    }
}