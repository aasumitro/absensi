<?php

use App\Http\Controllers\Api\Mobile\References\{
    AbsentTypeController,
    AnnouncementController,
    SliderController
};

use App\Http\Controllers\Api\Device\{
    GrantAccessController as RaspyMobileGrantAccessController,
    ScanQrCodeController as RaspyScanQrCodeController,
    StreamQrCodeController as RaspyStreamQrCodeController
};

use App\Http\Controllers\Api\Mobile\Authentications\{
    GrantAccessController as MobileGrantAccessController,
    VerifyAccessController as MobileVerifyAccessController,
    LogoutController as MobileLogoutController
};

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
    Route::post('login', [
        RaspyMobileGrantAccessController::class, 'index'
    ])->name('login');

    Route::middleware('auth:device-api')->group(function () {
        Route::post('scan', [
            RaspyScanQrCodeController::class, 'index'
        ])->name('scan');
        Route::get('stream', [
            RaspyStreamQrCodeController::class, 'index'
        ])->name('stream');
    });
});

Route::prefix('/v1/mobile')->name('api.mobile.')->group(function () {
    Route::prefix('references')->name('references.')->group(function () {
        Route::get('absent-type', [
            AbsentTypeController::class, 'index'
        ])->name('absent_type');
        Route::get('announcement', [
            AnnouncementController::class, 'index'
        ])->name('announcement');
        Route::get('sliders', [
            SliderController::class , 'index'
        ])->name('sliders');

        // Will do next
        // this action will be connected with existing app
        // Route::get('news', [])->name('news');
    });

    Route::prefix('login')->name('auth.login.')->group(function () {
        Route::post('grant', [
            MobileGrantAccessController::class, 'index'
        ])->name('grant');
        Route::post('verify', [
            MobileVerifyAccessController::class, 'index'
        ])->name('verify');
    });

    Route::middleware('auth:api')->group(function () {
        Route::get('logout', [
             MobileLogoutController::class, 'index'
        ])->name('auth.logout');

        Route::prefix('profiles')->name('profiles.')->group(function () {
            // Route::put('avatar', [])->name('avatar');
            // Route::put('telegram-id', [])->name('telegram_id');
            // Route::put('phone-id', [])->name('phone_id');
            // Route::put('fcm-token', [])->name('fcm_token');
        });

        Route::prefix('submissions')->name('submissions.')->group(function () {
            // Route::get('/', [])->name('list');
            // Route::post('/make', [])->name('issue');
        });

        Route::prefix('attendances')->name('attendances.')->group(function () {
            // Route::get('/', [])->name('list');
            // Route::post('scan', [])->name('issue');
            // Route::post('take', [])->name('issue');
            // Route::get('token', [])->name('issue');
        });
    });
});
