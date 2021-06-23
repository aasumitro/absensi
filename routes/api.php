<?php

use App\Http\Controllers\Api\Device\GrantAccessController;
use App\Http\Controllers\Api\Device\ScanQrCodeController;
use App\Http\Controllers\Api\Device\StreamQrCodeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1/devices')->name('api.device.')->group(function () {
    Route::post('login', [GrantAccessController::class, 'index'])->name('login');

    Route::middleware('auth:device-api')->group(function () {
        Route::post('scan', [ScanQrCodeController::class, 'index'])->name('scan');
        Route::get('stream', [StreamQrCodeController::class, 'index'])->name('stream');
    });
});

Route::prefix('/v1/mobile')->name('api.mobile.')->group(function () {
    //Route::post('login', [])->name('login');
    //Route::post('login/grant', [])->name('login');

    Route::middleware('auth:api')->group(function () {
        // Route::get('logout', [])->name('logout');

        Route::prefix('references')->name('references.')->group(function () {
            // Route::get('absent-type', [])->name('absent_type');
            // Route::get('announcement', [])->name('announcement');
            // Route::get('sliders', [])->name('sliders');
        });

        Route::prefix('profiles')->name('profiles.')->group(function () {
            // Route::get('avatar', [])->name('avatar');
            // Route::get('telegram-id', [])->name('telegram_id');
            // Route::get('phone-id', [])->name('phone_id');
            // Route::get('fcm-token', [])->name('fcm_token');
        });

        // consideration
        // Route::prefix('messages')->name('messages.')->group(function () {
            // Route::get('', [])->name('');
            // Route::get('', [])->name('');
        // });

        Route::prefix('submissions')->name('submissions.')->group(function () {
            // Route::get('/', [])->name('list');
            // Route::post('/', [])->name('issue');
        });

        Route::prefix('submissions')->name('submissions.')->group(function () {
            // Route::get('/', [])->name('list');
            // Route::post('/', [])->name('issue');
        });

        Route::prefix('attendances')->name('attendances.')->group(function () {
            // Route::get('/', [])->name('list');
            // Route::post('scan', [])->name('issue');
            // Route::post('take', [])->name('issue');
            // Route::post('token', [])->name('issue');
        });
    });
});
