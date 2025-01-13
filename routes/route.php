<?php

use Illuminate\Support\Facades\Route;
use JobMetric\Panelio\Facades\Middleware;
use JobMetric\Sms\Http\Controllers\SmsController;
use JobMetric\Sms\Http\Controllers\SmsGatewayController;

/*
|--------------------------------------------------------------------------
| Laravel Sms Routes
|--------------------------------------------------------------------------
|
| All Route in Laravel Sms package
|
*/

// sms
Route::prefix('p/{panel}/{section}/sms')->name('sms.')->namespace('JobMetric\Sms\Http\Controllers')->group(function () {
    Route::middleware(Middleware::getMiddlewares())->group(function () {
        Route::get('sms-gateway/get-fields', [SmsGatewayController::class, 'getFields'])->name('sms-gateway.get-fields');
        Route::options('sms-gateway', [SmsGatewayController::class, 'options'])->name('sms-gateway.options');
        Route::resource('sms-gateway', SmsGatewayController::class)->except(['show', 'destroy']);
        Route::get('sms', [SmsController::class, 'index'])->name('sms.index');
    });
});
