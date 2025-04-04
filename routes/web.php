<?php

use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Pdf\PdfController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [ViewController::class, 'index'])->name('home');
Route::view('/booking', 'bookings.index')->name('booking');
Route::get('/reservas/{courtId}/{start}', [ViewController::class, 'bookingsForLandingPage']);
