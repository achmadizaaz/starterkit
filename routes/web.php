<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\DatabaseBackupController;
use App\Http\Controllers\SystemHealthController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\MfaController;
use App\Http\Controllers\ImpersonationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Middleware\EnsureUserIsActive;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard', [
        'userCount' => User::count(),
        'roleCount' => Role::count(),
        'permissionCount' => Permission::count(),
    ]);
})->middleware(['auth', EnsureUserIsActive::class])->name('dashboard');

Route::middleware(['auth', EnsureUserIsActive::class])->prefix('dashboard')->group(function () {
    Route::get('/global-search', GlobalSearchController::class)
        ->middleware('throttle:60,1')
        ->name('global-search');

    Route::controller(UserController::class)->prefix('user')->whereUlid('id')->group(function(){
            Route::get('/', 'index')->middleware('can:read-user')->name('user.index');
            Route::get('/deleted', 'deleted')->middleware('can:read-deleted-user')->name('user.deleted.index');
            Route::patch('/deleted/{id}/restore', 'restore')->middleware('can:restore-user')->name('user.deleted.restore');
            Route::delete('/deleted/{id}', 'forceDelete')->middleware('can:force-delete-user')->name('user.deleted.force-delete');
            Route::post('/', 'store')->middleware('can:create-user')->name('user.store');
            Route::get('/{username}', 'show')
                ->where('username', '[A-Za-z0-9._-]+')
                ->middleware('can:read-user')
                ->name('user.show');
            Route::put('/{id}', 'update')->middleware('can:update-user')->name('user.update');
            Route::put('/{id}/password', 'updatePassword')->middleware('can:update-user')->name('user.password.update');
            Route::patch('/{id}/status', 'updateStatus')->middleware('can:update-user')->name('user.status.update');
            Route::delete('/{id}', 'destroy')->middleware('can:delete-user')->name('user.destroy');
        });

        Route::controller(RoleController::class)->prefix('role')->whereUlid('id')->group(function(){
            Route::get('/', 'index')->middleware('can:read-role')->name('role.index');
            Route::post('/', 'store')->middleware('can:create-role')->name('role.store');
            Route::put('/{id}', 'update')->middleware('can:update-role')->name('role.update');
            Route::delete('/{id}', 'destroy')->middleware('can:delete-role')->name('role.destroy');
        });

        Route::controller(PermissionController::class)->prefix('permission')->whereUlid('id')->group(function(){
            Route::get('/', 'index')->middleware('can:read-permission')->name('permission.index');
            Route::post('/', 'store')->middleware('can:create-permission')->name('permission.store');
            Route::put('/{id}', 'update')->middleware('can:update-permission')->name('permission.update');
            Route::delete('/{id}', 'destroy')->middleware('can:delete-permission')->name('permission.destroy');
        });

        Route::controller(PermissionGroupController::class)->prefix('permission-group')->whereNumber('id')->group(function(){
            Route::get('/', 'index')->middleware('can:read-permission-group')->name('permission-group.index');
            Route::post('/', 'store')->middleware('can:create-permission-group')->name('permission-group.store');
            Route::patch('/{id}/move-up', 'moveUp')->middleware('can:update-permission-group')->name('permission-group.move-up');
            Route::patch('/{id}/move-down', 'moveDown')->middleware('can:update-permission-group')->name('permission-group.move-down');
            Route::put('/{id}', 'update')->middleware('can:update-permission-group')->name('permission-group.update');
            Route::delete('/{id}', 'destroy')->middleware('can:delete-permission-group')->name('permission-group.destroy');
        });

        Route::controller(RolePermissionController::class)->prefix('role-permission')->whereUlid('roleId')->group(function(){
            Route::get('/', 'index')->middleware('can:read-role-permission')->name('role-permission.index');
            Route::get('/{roleId}', 'show')->middleware('can:read-role-permission')->name('role-permission.show');
            Route::put('/{roleId}', 'update')->middleware('can:update-role-permission')->name('role-permission.update');
        });

        Route::controller(SettingController::class)->prefix('settings')->group(function(){
            Route::get('/', 'index')->middleware('can:read-settings')->name('settings.index');
            Route::put('/', 'update')->middleware('can:update-settings')->name('settings.update');
        });

        Route::controller(AuditLogController::class)->prefix('audit-log')->group(function(){
            Route::get('/', 'index')->middleware('can:read-activity-log')->name('audit-log.index');
            Route::get('/export', 'export')->middleware('can:export-activity-log')->name('audit-log.export');
        });

        Route::controller(DatabaseBackupController::class)->prefix('backup-database')->group(function(){
            Route::get('/', 'index')->middleware('can:read-backup-database')->name('backup.index');
            Route::post('/', 'store')->middleware('can:create-backup-database')->name('backup.store');
            Route::put('/policy', 'updatePolicy')->middleware('can:update-backup-policy')->name('backup.policy.update');
            Route::post('/{backup}/dry-run', 'dryRun')->middleware('can:restore-backup-database')->name('backup.restore.dry-run');
            Route::post('/{backup}/restore', 'restore')->middleware('can:restore-backup-database')->name('backup.restore');
            Route::get('/{backup}/download', 'download')->middleware('can:download-backup-database')->name('backup.download');
            Route::delete('/{backup}', 'destroy')->middleware('can:delete-backup-database')->name('backup.destroy');
        });

        Route::get('/system-health', [SystemHealthController::class, 'index'])->middleware('can:read-system-health')->name('system-health.index');

        Route::controller(AdminNotificationController::class)->prefix('notifications')->group(function(){
            Route::get('/', 'index')->middleware('can:read-notification')->name('notifications.index');
            Route::patch('/read-all', 'readAll')->middleware('can:update-notification')->name('notifications.read-all');
            Route::patch('/{notification}', 'read')->middleware('can:update-notification')->name('notifications.read');
        });

    Route::post('/impersonate/{user}', [ImpersonationController::class, 'store'])
        ->whereUlid('user')
        ->middleware('can:impersonate-user')
        ->name('impersonate.store');
    Route::delete('/impersonate', [ImpersonationController::class, 'destroy'])->name('impersonate.destroy');

    Route::controller(ReportController::class)->prefix('reports')->group(function () {
        Route::get('/users', 'users')->middleware('can:read-user-report')->name('reports.users');
        Route::get('/login-activities', 'loginActivities')->middleware('can:read-login-activity-report')->name('reports.login-activities');
    });

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.change.password');
    Route::put('/profile/mfa/enable', [MfaController::class, 'enable'])->name('profile.mfa.enable');
    Route::put('/profile/mfa/disable', [MfaController::class, 'disable'])->name('profile.mfa.disable');
    Route::put('/profile/mfa/recovery-codes', [MfaController::class, 'regenerateRecoveryCodes'])->name('profile.mfa.recovery-codes.regenerate');
});

require __DIR__.'/auth.php';
