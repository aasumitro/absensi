<?php

use App\Http\Controllers\Api\Device\GrantAccessController;
use App\Http\Controllers\Api\Device\ScanQrCodeController;
use App\Http\Controllers\Api\Device\StreamQrCodeController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1/devices')->name('api.device.')->group( function () {
    Route::post('login', [GrantAccessController::class, 'index'])->name('login');

    Route::middleware('auth:device-api')->group(function () {
        Route::post('scan', [ScanQrCodeController::class, 'index'])->name('scan');
        Route::get('stream', [StreamQrCodeController::class, 'index'])->name('stream');
    });
});
