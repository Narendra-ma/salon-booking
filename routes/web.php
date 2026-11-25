<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryPhotoController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/layanan', [ServiceController::class, 'index'])->name('services.index');
Route::get('/galeri', [PageController::class, 'gallery'])->name('gallery');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');

Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::get('/booking/slots', [BookingController::class, 'slots'])
    ->middleware('throttle:60,1')
    ->name('booking.slots');
Route::post('/booking', [BookingController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('booking.store');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('booking', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('booking/{booking}/setujui', [AdminBookingController::class, 'approve'])->name('bookings.approve');
    Route::patch('booking/{booking}/batalkan', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');

    Route::resource('galeri', GalleryPhotoController::class)
        ->parameters(['galeri' => 'gallery'])
        ->names('gallery')
        ->only(['index', 'store', 'destroy']);

    Route::resource('layanan', AdminServiceController::class)
        ->parameters(['layanan' => 'service'])
        ->names('services')
        ->except('show');
});

require __DIR__.'/auth.php';
