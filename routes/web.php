<?php

use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Pdf\PdfController;
use App\Http\Controllers\User\UserController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('getBookingsByHour', [BookingController::class, 'getBookingsByHour']);

Route::get('users', [PdfController::class, 'pdfUsers']);
Route::get('bookings/pdf/{month}/{year}', [PdfController::class, 'exportBookingsForMonthPf']);