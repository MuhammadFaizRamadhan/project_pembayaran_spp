<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminController extends Controller
{
    public function showProfile()
    {
        $admin = Admin::find(session('logged_in_admin')); // mengambil admin yang sedang login

        return view('admin.profile_admin', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        // Pastikan admin yang login
        $admin = Admin::find(session('logged_in_admin'));

        $request->validate([
            'nama'   => 'required|string|max:255',
            'email'  => 'required|email|unique:admins,email,' . $admin->id,
            'alamat' => 'required|string|max:255',
        ]);

        $admin->update([
            'nama'   => $request->nama,
            'email'  => $request->email,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
