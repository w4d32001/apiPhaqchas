<?php

use App\Http\Controllers\Announcement\AnnouncementController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Field\FieldController;
use App\Http\Controllers\Pdf\PdfController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Role\RolePermissionController;
use App\Http\Controllers\Sport\SportController;
use App\Http\Controllers\User\AdmiController;
use App\Http\Controllers\User\UserController;
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
Route::post('field/updateImage/{id}', [FieldController::class, 'updateImage']);
Route::get('field/updateStatus/{id}', [FieldController::class, 'updateStatus']);

Route::apiResource('booking', BookingController::class);
Route::get('bookingsForAdmi/{courtId}/{start}/{end}', [BookingController::class, 'bookingsForAdmi']);
Route::get('bookingsForLandingPage/{courtId}/{start}/{end}', [BookingController::class, 'bookingsForLandingPage']);
Route::get('bookingsForAdmiMonth/{month}/{year}', [BookingController::class, 'bookingsForAdmiMonth']);
Route::get('/bookings/excel/{month}/{year}', [BookingController::class, 'exportBookingsToExcel']);

Route::apiResource('customer', CustomerController::class);
Route::get('topCustomers/{startDate}/{endDate}', [CustomerController::class, 'topCustomers']);

Route::apiResource('announcement', AnnouncementController::class);
Route::get('activeAnnouncement', [AnnouncementController::class, 'activeAnnouncement']);
Route::get('announcement/updateStatus/{id}', [AnnouncementController::class, 'updateStatus']);
Route::post('announcement/updateImage/{id}', [AnnouncementController::class, 'updateImage']);

Route::apiResource('admi', AdmiController::class);
Route::post('admi/updateAdmi/{admi}/{id}', [AdmiController::class, 'updateAdmi']);
Route::apiResource('user', UserController::class);

Route::apiResource('sport', SportController::class);
Route::post('sport/updatePrice/{id}', [SportController::class, 'updatePrice']);
Route::post('sport/updateImage/{id}', [SportController::class, 'updateImage']);

Route::post('completePayment/{id}', [BookingController::class, 'completePayment']);

Route::get('users/pdf', [PdfController::class, 'pdfUsers']);
Route::get('bookings/pdf/{month}/{year}', [PdfController::class, 'exportBookingsForMonthPf']);

Route::apiResource('role', RoleController::class);
Route::apiResource('permission', PermissionController::class);

Route::post('/users/{userId}/assign-role', [RolePermissionController::class, 'assignRole']);
Route::post('/users/{userId}/remove-role', [RolePermissionController::class, 'removeRole']);

Route::post('/users/{userId}/assign-permission', [RolePermissionController::class, 'assignPermission']);
Route::post('/users/{userId}/remove-permission', [RolePermissionController::class, 'removePermission']);

Route::post('/roles/{roleId}/assign-permissions', [RolePermissionController::class, 'assignPermissionsToRole']);

Route::get('/users/{userId}/roles', [RolePermissionController::class, 'getUserRoles']);
Route::get('/users/{userId}/permissions', [RolePermissionController::class, 'getUserPermissions']);