<?php

use App\Models\User;
use Illuminate\Http\Request;
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

Route::get('/publicar', function () {
    return view('nueva-publicacion');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/register/verify/{id}/{hash}', function (Request $request, int $id, string $hash) {
    $user = User::findOrFail($id);

    abort_unless(hash_equals($hash, sha1($user->email)), 403);

    if (!$user->email_verified_at) {
        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();
    }

    return view('registro-confirmado');
})->middleware('signed')->name('register.verify');

Route::get('/agenda', function () {
    return view('agenda');
});

Route::middleware(['auth', 'client'])->group(function () {
    Route::get('/agenda/create', [\App\Http\Controllers\AgendaController::class, 'create'])->name('agenda.create');
    Route::post('/agenda', [\App\Http\Controllers\AgendaController::class, 'store'])->name('agenda.store');
    Route::delete('/agenda/{id}', [\App\Http\Controllers\AgendaController::class, 'destroy'])->name('agenda.destroy');
});
