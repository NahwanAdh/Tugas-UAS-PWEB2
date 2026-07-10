<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FieldController as AdminFieldController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ---------- Halaman Umum ----------
Route::get('/', [FieldController::class, 'index'])->name('home');
Route::get('/dashboard', function () {
       return auth()->user()->isAdmin()
           ? redirect()->route('admin.dashboard')
           : redirect()->route('fields.index');
   })->middleware('auth')->name('dashboard');

// ---------- Rute untuk User yang sudah login ----------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Lapangan (lihat detail & booking)
    Route::get('/fields', [FieldController::class, 'index'])->name('fields.index');
    Route::get('/fields/{field}', [FieldController::class, 'show'])->name('fields.show');

    Route::get('/fields/{field}/booking', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/fields/{field}/booking', [BookingController::class, 'store'])->name('bookings.store');

    // Riwayat booking milik user sendiri
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::patch('/my-bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// ---------- Rute khusus Admin ----------
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('fields', AdminFieldController::class)->except(['show']);

    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/approve', [AdminBookingController::class, 'approve'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [AdminBookingController::class, 'reject'])->name('bookings.reject');
    Route::patch('/bookings/{booking}/complete', [AdminBookingController::class, 'complete'])->name('bookings.complete');
});

require __DIR__.'/auth.php';
