<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Base URL: /api
*/

// -----------------------------------------------------------------------------
// Authentication routes — no token required
// -----------------------------------------------------------------------------
Route::prefix('auth')->group(function () {

    // Register a new user account
    Route::post('/register', [AuthController::class, 'register']);

    // Authenticate and receive a JWT
    Route::post('/login', [AuthController::class, 'login']);

    // Invalidate the current JWT (blacklist) — token required
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth.jwt');

    // Request a password reset code via email
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

    // Submit the reset code and set a new password
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// -----------------------------------------------------------------------------
// Protected routes — valid, non-blacklisted JWT required
// -----------------------------------------------------------------------------
Route::middleware('auth.jwt')->group(function () {

    // Returns the currently authenticated user
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // Add more protected routes here...
});
