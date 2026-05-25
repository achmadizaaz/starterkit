<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('dashboard')->group(function () {

    Route::controller(UserController::class)->prefix('user')->group(function(){
        Route::get('/', 'index')->name('user.index');
        Route::post('/', 'store')->name('user.store');
        Route::put('/{id}', 'update')->name('user.update');
        Route::delete('/{id}', 'destroy')->name('user.destroy');
    });



    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.change.password');
});

require __DIR__.'/auth.php';
