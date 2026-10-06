<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Login;
use App\Http\Controllers\Register;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Pegawai;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('pegawai.dashboard');
    }

    return redirect()->route('login');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [Login::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin/login', [Login::class, 'adminLogin'])->name('admin.login.submit');

    Route::get('/register', [Register::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [Register::class, 'register']);
    
    Route::get('/login', [Login::class, 'showLoginForm'])->name('login');
    Route::post('/login', [Login::class, 'login']);
});

// Authenticated Routes (Harus Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [Login::class, 'logout'])->name('logout');
    Route::get('/file/download/{file}', [FileController::class, 'download'])->name('file.download');

    // Route khusus Admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::redirect('/', '/admin/dashboard')->name('index');
        Route::get('/dashboard', [Admin::class, 'index'])->name('dashboard');
        Route::get('/arsip-semua', [FileController::class, 'allFiles'])->name('arsip.index');
        Route::put('/file/{file}', [FileController::class, 'update'])->name('file.update');
        Route::delete('/file/{file}', [FileController::class, 'destroy'])->name('file.delete');
    });

    // Route khusus Pegawai
    Route::middleware(['role:pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('/dashboard', [Pegawai::class, 'index'])->name('dashboard');
        Route::get('/arsip-saya', [FileController::class, 'myFiles'])->name('arsip.index');
        Route::post('/upload', [FileController::class, 'upload'])->name('arsip.upload');
    });
});
