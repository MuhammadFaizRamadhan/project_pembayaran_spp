<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function showProfile()
    {
        $user = Siswa::find(session('logged_in_siswa'));

        return view('user.profile_user', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Siswa::findOrFail(session('logged_in_siswa'));

        $request->validate([
            'nama'   => 'required|string|max:255',
            'email'  => 'required|email|unique:siswa,email,' . $user->id,
            'alamat' => 'required|string|max:255',
            'foto'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nama', 'email', 'alamat']);

        // Jika ada upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists('foto_siswa/' . $user->foto)) {
                Storage::disk('public')->delete('foto_siswa/' . $user->foto);
            }

            // Simpan foto baru
            $data['foto'] = $request->file('foto')->store('foto_siswa', 'public');
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
