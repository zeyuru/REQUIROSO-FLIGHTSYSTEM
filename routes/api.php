<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserStatusController;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Approve user
Route::prefix('users')->group(function () {
    Route::delete('/{id}', [UserController::class, 'deleteUser']);
    Route::patch('/approve/{id}', [UserController::class, 'approveUser']);
});


// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Resource Routes
    
    Route::apiResource('passengers', PassengerController::class);
    Route::apiResource('flights', FlightController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('user-statuses', UserStatusController::class);

    Route::delete('/delete_flight/{id}', [FlightController::class, 'destroy']);
     Route::patch('/flights/change_status/{id}', [FlightController::class, 'changeStatus']);
});