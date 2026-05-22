<?php

use App\Http\Controllers\HubController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;

// Landing Page — publicly accessible
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes — hanya untuk guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);

    // Register hanya untuk customer
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout — semua user yang sudah login bisa logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── ADMIN ROUTES ──────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('hubs', HubController::class);
    Route::resource('transactions', TransactionController::class);
    Route::get('/laporan', [TransactionController::class, 'report'])->name('reports.index');
    Route::get('/booking', [TransactionController::class, 'bookingList'])->name('transactions.booking');
    Route::put('/booking/{id}/start', [TransactionController::class, 'startBooking'])->name('transactions.start');
});

// ── CUSTOMER ROUTES ───────────────────────────────────────────
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/booking/{hub}', [CustomerController::class, 'bookingForm'])->name('booking');
    Route::post('/booking', [CustomerController::class, 'storeBooking'])->name('store');
});