<?php

use App\Http\Controllers\Dash\Authentications\GrantAccessController;
use App\Http\Controllers\Dash\HomeController;
use App\Http\Controllers\Dash\Root\MobileSettingController;
use App\Http\Controllers\Dash\Root\Offices\{
    DepartmentController, DeviceController, PeopleController
};
use App\Http\Controllers\Dash\Root\Reports\{
    AttendanceController, SubmissionController
};
use App\Http\Controllers\Dash\Root\SystemSettingController;
use App\Http\Controllers\Dash\Root\Users\Accounts\UserAccountController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [GrantAccessController::class, 'index'])->name('login');

Route::middleware(['auth', 'accepted.role'])->group(function () {
    Route::post('logout', [GrantAccessController::class, 'logout'])->name('logout');
    //Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    //Route::get('profile/backup', [ProfileController::class, 'backup'])->name('profile.backup');

    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::middleware('role:root')->group(function () {
        // [START-DASHBOARD]
        // Route::get('dashboard/summaries', [])->name('');
        // Route::get('dashboard/department', [])->name('');
        // [END-DASHBOARD]

        // [START-REPORT]
         Route::get('reports/submissions', [
            SubmissionController::class, 'index'
         ])->name('reports.submissions');
         Route::get('reports/attendances/{type}', [
            AttendanceController::class, 'index'
         ])->name('reports.attendances');
        // [END-REPORT]

        // [START-OFFICE]
        Route::get('offices/departments', [
            DepartmentController::class, 'index'
        ])->name('offices.departments');
        Route::get('offices/devices', [
            DeviceController::class, 'index'
        ])->name('offices.devices');
        Route::get('offices/peoples', [
            PeopleController::class, 'index'
        ])->name('offices.peoples');
        // [END-OFFICE]

        Route::get('users/accounts', [
            UserAccountController::class, 'index'
        ])->name('users.accounts');

        // [START-SETTING]
         Route::get('settings/system', [
             SystemSettingController::class, 'index'
         ])->name('settings.system');
         Route::get('settings/mobile', [
             MobileSettingController::class, 'index'
         ])->name('settings.mobile');
        // [END--SETTING]
    });

    Route::middleware('role:admin')->group(function () {
        // TODO NEXT
        // [START-DEPARTMENT]
        // Route::get('department/peoples', [])->name('');
        // Route::get('department/devices', [])->name('');
        // Route::get('department/settings', [])->name('');
        // [END-DEPARTMENT]
    });

    Route::middleware('role:admin,operator')->group(function () {
        // TODO NEXT
        // [START-QRCODE]
        // Route::get('qrcode/scanner', [])->name('');
        // Route::get('qrcode/generator', [])->name('');
        // [END-QRCODE]

        // [START-ATTENDANCE]
        // Route::get('attendances/excel-file', [])->name('');
        // Route::get('attendances/manual-input', [])->name('');
        // Route::get('attendances/verify-submission', [])->name('');
        // [END-ATTENDANCE]

        // [START-REPORT]
        // Route::get('reports/summaries', [])->name('');
        // Route::get('reports/locations', [])->name('');
        // Route::get('reports/peoples', [])->name('');
        // Route::get('reports/days', [])->name('');
        // [END-REPORT]
    });
});
