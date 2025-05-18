<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // ✅ Tambahkan ini
use App\Models\Admin;                // ✅ dan ini
use App\Models\Siswa;                // ✅ dan ini

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'id_login' => 'required',
            'password' => 'required'
        ]);

        // Cek Admin (NIP)
        $admin = Admin::where('NIP', $request->id_login)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['logged_in_admin' => $admin->id]);
            return redirect('/dashboard/admin');
        }

        // Cek Siswa/User (NISN)
        $siswa = Siswa::where('NISN', $request->id_login)->first();
        if ($siswa && Hash::check($request->password, $siswa->password)) {
            session(['logged_in_siswa' => $siswa->id]);
            return redirect('/dashboard/user');
        }

        return back()->with('error', 'ID atau Password salah');
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect('/login');
    }
}
