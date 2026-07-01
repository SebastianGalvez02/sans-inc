<?php

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

Route::middleware(['auth', 'client'])->group(function () {
    Route::get('/agenda', [\App\Http\Controllers\AgendaController::class, 'index'])->name('agenda.index');
    Route::get('/agenda/create', [\App\Http\Controllers\AgendaController::class, 'create'])->name('agenda.create');
    Route::post('/agenda', [\App\Http\Controllers\AgendaController::class, 'store'])->name('agenda.store');
    Route::delete('/agenda/{id}', [\App\Http\Controllers\AgendaController::class, 'destroy'])->name('agenda.destroy');
});
