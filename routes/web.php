<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\User;

// Publik
Route::get('/', fn () => view('welcome'))->name('home');

Route::get('/konsultasi', [ConsultationController::class, 'index'])
    ->middleware('guest.once')->name('konsultasi.index');
Route::post('/konsultasi/submit', [ConsultationController::class, 'submit'])
    ->name('konsultasi.submit');
Route::get('/konsultasi/hasil/{token}', [ConsultationController::class, 'hasilGuest'])
    ->name('konsultasi.hasil.guest');

// Auth bawaan Breeze sudah otomatis ada di routes/auth.php (di-require dari web.php)

// User
Route::middleware(['auth', 'role:user'])->prefix('dashboard')->name('user.')->group(function () {
    Route::get('/', [User\DashboardController::class, 'index'])->name('dashboard');
    Route::get('riwayat', [User\RiwayatController::class, 'index'])->name('riwayat');
    Route::get('riwayat/{konsultasi}', [User\RiwayatController::class, 'show'])->name('riwayat.show');

    Route::get('profile', [User\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [User\ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [User\ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::post('fcm-token', [User\NotificationController::class, 'updateToken'])->name('fcm.update');

    // Ditambahkan: halaman notifikasi user — sebelumnya hanya admin yang punya notif.index,
    // padahal layout user (bel notifikasi di navbar) sudah memanggil route ini.
    Route::get('notification', [User\NotificationController::class, 'index'])
        ->name('notif.index');
});

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('gejala', Admin\GejalaController::class);
    Route::patch('gejala/{gejala}/toggle-active', [Admin\GejalaController::class, 'toggleActive'])
        ->name('gejala.toggle-active');

    Route::resource('rekomendasi', Admin\RekomendasiController::class);
    Route::resource('playlist', Admin\PlaylistController::class);
    Route::resource('users', Admin\UserController::class);

    // Reset password pengguna oleh admin
    Route::put('users/{user}/reset-password', [Admin\UserController::class, 'resetPassword'])
        ->name('users.reset-password');

    Route::get('notification', [Admin\NotificationController::class, 'index'])
        ->name('notif.index');
    Route::post('notification/broadcast', [Admin\NotificationController::class, 'broadcast'])
        ->name('notif.broadcast');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';