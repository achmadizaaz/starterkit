<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SettingController;
use App\Http\Middleware\EnsureUserCanManageSystem;
use App\Http\Middleware\EnsureUserIsActive;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'userCount' => User::count(),
        'roleCount' => Role::count(),
        'permissionCount' => Permission::count(),
    ]);
})->middleware(['auth', EnsureUserIsActive::class, 'verified'])->name('dashboard');

Route::middleware(['auth', EnsureUserIsActive::class, 'verified'])->prefix('dashboard')->group(function () {

    Route::middleware(EnsureUserCanManageSystem::class)->group(function () {
        Route::controller(UserController::class)->prefix('user')->whereNumber('id')->group(function(){
            Route::get('/', 'index')->name('user.index');
            Route::post('/', 'store')->name('user.store');
            Route::get('/{id}', 'show')->name('user.show');
            Route::put('/{id}', 'update')->name('user.update');
            Route::put('/{id}/password', 'updatePassword')->name('user.password.update');
            Route::patch('/{id}/status', 'updateStatus')->name('user.status.update');
            Route::delete('/{id}', 'destroy')->name('user.destroy');
        });

        Route::controller(RoleController::class)->prefix('role')->whereUlid('id')->group(function(){
            Route::get('/', 'index')->name('role.index');
            Route::post('/', 'store')->name('role.store');
            Route::put('/{id}', 'update')->name('role.update');
            Route::delete('/{id}', 'destroy')->name('role.destroy');
        });

        Route::controller(PermissionController::class)->prefix('permission')->whereUlid('id')->group(function(){
            Route::get('/', 'index')->name('permission.index');
            Route::post('/', 'store')->name('permission.store');
            Route::put('/{id}', 'update')->name('permission.update');
            Route::delete('/{id}', 'destroy')->name('permission.destroy');
        });

        Route::controller(PermissionGroupController::class)->prefix('permission-group')->whereNumber('id')->group(function(){
            Route::get('/', 'index')->name('permission-group.index');
            Route::post('/', 'store')->name('permission-group.store');
            Route::patch('/{id}/move-up', 'moveUp')->name('permission-group.move-up');
            Route::patch('/{id}/move-down', 'moveDown')->name('permission-group.move-down');
            Route::put('/{id}', 'update')->name('permission-group.update');
            Route::delete('/{id}', 'destroy')->name('permission-group.destroy');
        });

        Route::controller(RolePermissionController::class)->prefix('role-permission')->whereUlid('roleId')->group(function(){
            Route::get('/', 'index')->name('role-permission.index');
            Route::get('/{roleId}', 'show')->name('role-permission.show');
            Route::put('/{roleId}', 'update')->name('role-permission.update');
        });

        Route::controller(SettingController::class)->prefix('settings')->group(function(){
            Route::get('/', 'index')->name('settings.index');
            Route::put('/', 'update')->name('settings.update');
        });
    });

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.change.password');
});

require __DIR__.'/auth.php';
