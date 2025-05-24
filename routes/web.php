<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TagihanUserController;
use App\Http\Controllers\RiwayatTransaksiUserController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->middleware('web');
Route::get('/dashboard/user', [DashboardController::class, 'user'])->middleware('web');

// admin site (CRUD Siswa)
Route::get('/admin/data_siswa', [SiswaController::class, 'index'])->name('siswa.index');
Route::post('/admin/data_siswa', [SiswaController::class, 'store'])->name('siswa.store');
Route::put('/admin/data_siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
Route::delete('/admin/data_siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

// admin site (profile admin)
Route::get('/admin/profile_admin', [AdminController::class, 'showProfile'])->name('admin.profile');
Route::put('/admin/profile_admin', [AdminController::class, 'updateProfile'])->name('admin.updateProfile'); 

// admin site CRUD data pembayaran
Route::resource('/admin/data_pembayaran', PembayaranController::class)->except('show')->names('data_pembayaran');

// admin site CRUD Transaksi
// Untuk halaman riwayat transaksi admin
Route::get('/admin/riwayat_transaksi', [TransaksiController::class, 'index'])->name('admin.riwayat_transaksi');

// Untuk update status
Route::put('/admin/riwayat_transaksi/status/{id}', [TransaksiController::class, 'updateStatus'])->name('admin.riwayat_transaksi.updateStatus');

// user site (profile user)
Route::get('/profile/user', [UserController::class, 'showProfile'])->name('user.profile');
Route::put('/profile/user', [UserController::class, 'updateProfile'])->name('user.updateProfile');

// user site (tagihan_user)
Route::get('user/tagihan_user', [App\Http\Controllers\TagihanUserController::class, 'index'])->name('tagihan.index');
Route::post('user/tagihan_user/store', [App\Http\Controllers\TagihanUserController::class, 'store'])->name('tagihan.store');

// user site (tagihan_user)
Route::get('user/riwayat_transaksi_user', [RiwayatTransaksiUserController::class, 'index'])->name('riwayat.index');

// // CRUD Admin
// Route::resource('/admin', AdminController::class)->middleware('auth');

// // CRUD User/Siswa
// Route::resource('/siswa', SiswaController::class)->middleware('auth');

