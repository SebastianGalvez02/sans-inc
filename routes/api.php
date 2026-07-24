<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\CommentController;


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
    Route::put('/user/profile', [ProfileController::class, 'updateProfile']);
    Route::put('/user/password', [ProfileController::class, 'updatePassword']);

    // Add more protected routes here...
});

/**
 * Rutas para consultar productos activos.
 *
 * Expone el listado general, el filtro por categoryId y la consulta
 * individual de productos mediante ProductController.
 *
 * @author Equipo Sans Inc.
 * @version 1.0
 */
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::patch('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

Route::get('/publications', [PublicationController::class, 'index']);
Route::get('/publications/{id}', [PublicationController::class, 'show']);
Route::middleware('auth.jwt')->group(function () {
    Route::post('/publications', [PublicationController::class, 'store']);
    Route::put('/publications/{id}', [PublicationController::class, 'update']);
    Route::patch('/publications/{id}', [PublicationController::class, 'update']);
    Route::delete('/publications/{id}', [PublicationController::class, 'destroy']);
});

Route::middleware(['auth.jwt', 'client'])->group(function () {
    Route::get('/agenda', [AgendaController::class, 'index']);
    Route::post('/agenda', [AgendaController::class, 'store']);
    Route::delete('/agenda/{id}', [AgendaController::class, 'destroy']);
});

// Comments
Route::get('/comments', [CommentController::class, 'index']);
Route::get('/comments/{id}', [CommentController::class, 'show']);
Route::middleware('auth.jwt')->group(function () {
    Route::post('/comments', [CommentController::class, 'store']);
    Route::put('/comments/{id}', [CommentController::class, 'update']);
    Route::patch('/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
});
