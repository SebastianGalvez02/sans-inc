<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;


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

    // Profile editing (RF-06) — name and password of the authenticated user
    Route::put('/user/profile',  [ProfileController::class, 'updateProfile']);
    Route::put('/user/password', [ProfileController::class, 'updatePassword']);

    // Add more protected routes here...
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::patch('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
