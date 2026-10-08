<?php

use App\Http\Controllers\Admin\{AkunController, AuthController, DashboardController, ProfilController, ResourceController};
use App\Http\Controllers\{BeritaController, HomeController, PageController, PeluangController};
use Illuminate\Support\Facades\Route;

// ---- Situs publik ---------------------------------------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::controller(PageController::class)->group(function () {
    Route::get('/tentang', 'tentang')->name('tentang');
    Route::get('/pengurus', 'pengurus')->name('pengurus');
    Route::get('/program-kerja', 'program')->name('program');
    Route::get('/prestasi', 'prestasi')->name('prestasi');
    Route::get('/dokumentasi', 'galeri')->name('galeri');
    Route::get('/panduan-maba', 'panduan')->name('panduan');
    Route::get('/agenda', 'agenda')->name('agenda');
    Route::get('/direktori', 'direktori')->name('direktori');
    Route::get('/budaya', 'budaya')->name('budaya');
});

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{berita:slug}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/beasiswa-magang', [PeluangController::class, 'index'])->name('peluang.index');
Route::get('/beasiswa-magang/{peluang:slug}', [PeluangController::class, 'show'])->name('peluang.show');

// ---- Masuk / keluar (tidak ada di navbar; tautan kecil di footer + alamat /admin) ----
Route::get('/masuk', [AuthController::class, 'form'])->name('login');
Route::post('/masuk', [AuthController::class, 'masuk'])->middleware('throttle:6,1')->name('login.post');
Route::post('/keluar', [AuthController::class, 'keluar'])->middleware('auth')->name('logout');

// ---- Panel admin ----------------------------------------------------------
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/beranda-profil', [ProfilController::class, 'edit'])->name('profil');
    Route::post('/beranda-profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::get('/akun', [AkunController::class, 'edit'])->name('akun');
    Route::put('/akun', [AkunController::class, 'update'])->name('akun.update');

    $res = array_keys(config('admin.resources'));
    Route::get('{resource}', [ResourceController::class, 'index'])->whereIn('resource', $res)->name('res.index');
    Route::get('{resource}/baru', [ResourceController::class, 'create'])->whereIn('resource', $res)->name('res.create');
    Route::post('{resource}', [ResourceController::class, 'store'])->whereIn('resource', $res)->name('res.store');
    Route::get('{resource}/{id}/ubah', [ResourceController::class, 'edit'])->whereIn('resource', $res)->whereNumber('id')->name('res.edit');
    Route::put('{resource}/{id}', [ResourceController::class, 'update'])->whereIn('resource', $res)->whereNumber('id')->name('res.update');
    Route::delete('{resource}/{id}', [ResourceController::class, 'destroy'])->whereIn('resource', $res)->whereNumber('id')->name('res.destroy');
});
