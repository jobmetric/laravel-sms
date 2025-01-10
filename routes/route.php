<?php

use Illuminate\Support\Facades\Route;
use JobMetric\Panelio\Facades\Middleware;
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
        Route::options('sms_gateway', [SmsGatewayController::class, 'options'])->name('sms_gateway.options');
        Route::resource('sms_gateway', SmsGatewayController::class)->except(['show', 'destroy']);
    });
});
