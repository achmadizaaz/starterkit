<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/page', function(){
    return view('page');
});

// Route utama
Route::prefix('dashboard')->middleware('auth')->group(function () {
    
    // dashboard route
    Route::get('/', function () { return view('dashboard');
    })->name('dashboard');

    // user routes
    Route::controller(UserController::class)->prefix('users')->group(function(){
        Route::get('/', 'index')->name('users');
        Route::get('{slug}', 'show')->name('users.show');
        Route::get('create', 'create')->name('users.create');
        Route::post('store', 'store')->name('users.store');
        Route::get('{slug}/edit', 'edit')->name('users.edit');
        Route::put('{id}/update', 'update')->name('users.update');
        Route::delete('{id}/delete', 'destroy')->name('users.delete');
        Route::put('{id}/change-password', 'changePassword')->name('users.change.password');
    });

    // role routes
    Route::controller(RoleController::class)->prefix('roles')->group(function(){
        Route::get('/', 'index')->name('roles');
        Route::get('{id}/show', 'show')->name('roles.show');
        Route::get('create', 'create')->name('roles.create');
        Route::post('store', 'store')->name('roles.store');
        Route::put('{id}/update', 'update')->name('roles.update');
        Route::delete('{id}/delete', 'destroy')->name('roles.delete');
    });

    // sync permission role route
    Route::controller(SyncPermissionController::class)->prefix('sync-permissions')->group(function(){
        Route::get('/', 'index')->name('sync.permissions');
        Route::get('assign', 'assign')->name('sync.permissions.assign');
        Route::post('assign', 'store')->name('sync.permissions.store');
    });
});

require __DIR__.'/auth.php';
