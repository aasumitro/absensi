<?php

use App\Http\Controllers\Api\Web\QrCodeController;
use App\Http\Controllers\Dash\Authentications\GrantAccessController;
use App\Http\Controllers\Dash\HomeController;
use App\Http\Controllers\Dash\Root\MobileSettingController;
use App\Http\Controllers\Viewer\PrivateFileViewerController;
use App\Http\Controllers\Dash\Staff\Attendances\{
    ExcelImportController,
    ManualInputController,
    SubmissionVerificationController
};
use App\Http\Controllers\Dash\Staff\Admin\{
    DeviceController as DepartmentDeviceController,
    PeopleController as DepartmentPeopleController,
    SettingController as DepartmentSettingController,
};
use App\Http\Controllers\Dash\Staff\Qrcode\{
    QrGeneratorController, QrScannerController
};
use App\Http\Controllers\Dash\Root\Offices\{
    DepartmentController, DeviceController, PeopleController
};
use App\Http\Controllers\Dash\Root\Reports\{
    AttendanceController, SubmissionController
};
use App\Http\Controllers\Dash\Root\SystemSettingController;
use App\Http\Controllers\Dash\Root\Users\{
    UserAccountController,
    UserSubmissionController
};
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

// [PRIVATE-FILE-ACCESS]
Route::get(
    '/file/{id}',
    [PrivateFileViewerController::class, 'view']
)->name('private.file');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->get('/requests', function () {
    return view('request');
})->name('requests');

Route::get('login', [GrantAccessController::class, 'index'])->name('login');
Route::post('logout', [GrantAccessController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'accepted.role'])->group(function () {
    Route::prefix('v1/web/qrcode')->name('api.web.')->group(function () {
        Route::get('stream', [
            QrCodeController::class, 'stream'
        ])->name('stream');
        Route::post('scan', [
            QrCodeController::class, 'scan'
        ])->name('scan');
    });

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

        // [START-USERS]
        Route::get('users/accounts', [
            UserAccountController::class, 'index'
        ])->name('users.accounts');
        Route::get('users/submissions', [
            UserSubmissionController::class, 'index'
        ])->name('users.submissions');
        // [END--USERS]

        // [START-SETTING]
         Route::get('settings/system', [
             SystemSettingController::class, 'index'
         ])->name('settings.system');
         Route::get('settings/mobile', [
             MobileSettingController::class, 'index'
         ])->name('settings.mobile');
        // [END--SETTING]
    });

    Route::prefix('staff')->group(function () {
        Route::middleware('role:admin')->group(function () {
            // [START-DEPARTMENT]
             Route::get('department/peoples', [
                 DepartmentPeopleController::class, 'index'
             ])->name('staff.department.people');
             Route::get('department/devices', [
                 DepartmentDeviceController::class, 'index'
             ])->name('staff.department.device');
             Route::get('department/settings', [
                DepartmentSettingController::class, 'index'
             ])->name('staff.department.setting');
            // [END-DEPARTMENT]
        });

        Route::middleware('role:admin,operator')->group(function () {
            // [START-QRCODE]
            Route::get('qrcode/scanner', [
                QrScannerController::class, 'index'
            ])->name('staff.qrcode.scanner');
            Route::get('qrcode/generator', [
                QrGeneratorController::class, 'index'
            ])->name('staff.qrcode.generator');
            // [END-QRCODE]

            // [START-ATTENDANCE]
            Route::get('attendances/excel-file', [
                ExcelImportController::class, 'index'
            ])->name('staff.attendance.excel-file');
            Route::get('attendances/manual-input', [
                ManualInputController::class, 'index'
            ])->name('staff.attendance.manual-input');
            Route::get('attendances/verify-submission', [
                SubmissionVerificationController::class, 'index'
            ])->name('staff.attendance.verify-submission');
            // [END-ATTENDANCE]

            // [START-REPORT]
            // Route::get('reports/summaries', [])->name('');
            // Route::get('reports/locations', [])->name('');
            // Route::get('reports/peoples', [])->name('');
            // Route::get('reports/days', [])->name('');
            // [END-REPORT]
        });
    });
});
