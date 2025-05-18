<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;  // ✅ Tambahkan ini
use App\Models\Siswa; 

class DashboardController extends Controller
{
    public function admin()
    {
        $admin = Admin::find(session('logged_in_admin'));
        return view('dashboard.admin', compact('admin'));
    }

    public function user()
    {
        $user = Siswa::find(session('logged_in_siswa'));
        return view('dashboard.user', compact('user'));
    }
    public function dataSiswa()
    {
        $admin = Admin::find(session('logged_in_admin'));
        $siswa = Siswa::all();
        return view('admin.data_siswa', compact('admin', 'siswa'));
    }
}