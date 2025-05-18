<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class UserController extends Controller
{
    public function showProfile()
    {
        // Mengambil data siswa yang sedang login dari session
        $user = Siswa::find(session('logged_in_siswa'));

        return view('user.profile_user', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // Ambil user dari session
        $user = Siswa::find(session('logged_in_siswa'));

        $request->validate([
            'nama'   => 'required|string|max:255',
            'email'  => 'required|email|unique:siswa,email,' . $user->id,
            'alamat' => 'required|string|max:255',
        ]);

        $user->update([
            'nama'   => $request->nama,
            'email'  => $request->email,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
