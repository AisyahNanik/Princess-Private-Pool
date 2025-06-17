<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SwimmingpoolController as AdminSwimmingpoolController;
use App\Http\Controllers\User\SwimmingpoolController as UserSwimmingpoolController;
use App\Http\Controllers\SwimmingpoolController;
use App\Http\Controllers\Admin\AllotmentController as AdminAllotmentController;
use App\Http\Controllers\AllotmentController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\User\PaymentController as UserPaymentController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\RoleMiddleware;
// use App\Http\Controllers\MidtransCallbackController;

// 🔹 Halaman utama
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

// 🔹 Middleware untuk user yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('customer.dashboard');
    })->name('dashboard');

    // 🔹 Profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🔹 Route global tanpa role
Route::resource('swimmingpools', SwimmingpoolController::class);
Route::resource('allotments', AllotmentController::class);
Route::resource('bookings', BookingController::class);
Route::resource('payments', PaymentController::class);
// Route::post('/midtrans/callback', [MidtransCallbackController::class, 'receive']);

// 🔹 Route notifikasi Midtrans (TIDAK pakai middleware auth!)
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');

// 🔹 Route untuk Admin
Route::middleware(['auth', RoleMiddleware::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Menggunakan DashboardController
    Route::resource('swimmingpools', AdminSwimmingpoolController::class);
    Route::resource('allotments', AdminAllotmentController::class);
    Route::resource('bookings', AdminBookingController::class);
    Route::resource('payments', AdminPaymentController::class);
});

// 🔹 Route untuk Customer
Route::middleware(['auth', RoleMiddleware::class.':customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard'); 
    Route::resource('swimmingpools', UserSwimmingpoolController::class);
    Route::resource('bookings', UserBookingController::class);
    Route::resource('payments', UserPaymentController::class);
});

// 🔹 Route auth bawaan Laravel
require __DIR__.'/auth.php';
