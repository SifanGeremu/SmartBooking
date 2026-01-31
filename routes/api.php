<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;

// ---------------------------
// Public Auth Routes
// ---------------------------
Route::post('/register', [AuthController::class, 'Register'])->name('register');
Route::post('/login', [AuthController::class, 'Login'])->name('login');

// ---------------------------
// Protected Routes (Sanctum)
// ---------------------------
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'Logout'])->name('logout');

    // ---------------------------
    // Appointment Routes
    // ---------------------------

    // Create Appointment (any authenticated user)
    Route::post('/appointments', [AppointmentController::class, 'store']);

    // List Appointments
    Route::get('/appointments', [AppointmentController::class, 'index']);

    // View single appointment
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);

    // Update appointment (ownership/admin logic inside controller)
    Route::put('/appointments/{id}', [AppointmentController::class, 'update']);

    // Delete appointment (ownership/admin logic inside controller)
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
});
