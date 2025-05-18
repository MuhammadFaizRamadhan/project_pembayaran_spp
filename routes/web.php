<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\UserController;

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


// user site (profile user)
Route::get('/profile/user', [UserController::class, 'showProfile'])->name('user.profile');
Route::put('/profile/user', [UserController::class, 'updateProfile'])->name('user.updateProfile');

// // CRUD Admin
// Route::resource('/admin', AdminController::class)->middleware('auth');

// // CRUD User/Siswa
// Route::resource('/siswa', SiswaController::class)->middleware('auth');

