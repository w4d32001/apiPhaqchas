<?php

use App\Http\Controllers\Announcement\AnnouncementController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Field\FieldController;
use App\Http\Controllers\Sport\SportController;
use App\Http\Controllers\User\AdmiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});

Route::apiResource('field', FieldController::class);
Route::apiResource('booking', BookingController::class);
Route::get('bookingsForAdmi/{courtId}/{start}/{end}', [BookingController::class, 'bookingsForAdmi']);
Route::get('bookingsForLandingPage/{courtId}/{start}/{end}', [BookingController::class, 'bookingsForLandingPage']);
Route::get('bookingsForAdmiMonth/{courtId}/{start}/{end}', [BookingController::class, 'bookingsForAdmiMonth']);

Route::apiResource('customer', CustomerController::class);

Route::apiResource('annoucement', AnnouncementController::class);
Route::get('annoucement/updateStatus/{id}', [AnnouncementController::class, 'updateStatus']);
Route::post('annoucement/updateImage/{id}', [AnnouncementController::class, 'updateImage']);

Route::apiResource('admi', AdmiController::class);

Route::apiResource('sport', SportController::class);
Route::post('sport/updatePrice/{id}', [SportController::class, 'updatePrice']);
