<?php

use App\Http\Controllers\Report\UserReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('reports')->group(function () {

    Route::controller(UserReportController::class)->prefix('user')->group(function(){
        Route::get('/', 'index')->name('report.users');
        Route::post('/show', 'show')->name('report.users.show');
    });
});