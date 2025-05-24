<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;

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
            'password' => 'required|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foto_siswa', 'public');
        }

        Siswa::create([
            'NISN' => $request->NISN,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'foto' => $foto,
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'NISN' => 'required|unique:siswa,NISN,' . $siswa->id,
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['NISN', 'nama', 'alamat', 'email']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }

            $data['foto'] = $request->file('foto')->store('foto_siswa', 'public');
        }

        $siswa->update($data);

        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus.');
    }

}