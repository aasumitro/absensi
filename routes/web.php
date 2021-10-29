<?php

use App\Http\Controllers\Api\Web\QrCodeController;
use App\Http\Controllers\Dash\Authentications\GrantAccessController;
use App\Http\Controllers\Dash\HomeController;
use App\Http\Controllers\Dash\Root\Dashboard\{
    SummaryDashboardController,
    ByOfficeDashboardController
};
use App\Http\Controllers\Dash\Root\MobileSettingController;
use App\Http\Controllers\Dash\Root\SystemSettingController;
use App\Http\Controllers\Dash\Staff\Reports\{
    ByPeopleReportController as DepartmentByPeopleReportController,
    ByDateRangeReportController as DepartmentByDateRangeReportController
};
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
//use App\Http\Controllers\Dash\Root\Reports\{
//    AttendanceController, SubmissionController
//};
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

    Route::get('home', HomeController::class)->name('home');

    Route::middleware('role:root')->group(function () {
        // [START-DASHBOARD]
         Route::get('dashboard/summaries', SummaryDashboardController::class)->name('dashboard.summary');
         Route::get('dashboard/department', ByOfficeDashboardController::class)->name('dashboard.scope-office');
        // [END-DASHBOARD]

        // [START-REPORT]
        // Route::get('reports/submissions', SubmissionController::class)->name('reports.submissions');
        // Route::get('reports/attendances/{type}', AttendanceController::class)->name('reports.attendances');
        // [END-REPORT]

        // [START-OFFICE]
        Route::get('offices/departments', DepartmentController::class)->name('offices.departments');
        Route::get('offices/devices', DeviceController::class)->name('offices.devices');
        Route::get('offices/peoples', PeopleController::class)->name('offices.peoples');
        // [END-OFFICE]

        // [START-USERS]
        Route::get('users/accounts', UserAccountController::class)->name('users.accounts');
        Route::get('users/submissions', UserSubmissionController::class)->name('users.submissions');
        // [END--USERS]

        // [START-SETTING]
         Route::get('settings/system', SystemSettingController::class)->name('settings.system');
         Route::get('settings/mobile', MobileSettingController::class)->name('settings.mobile');
        // [END--SETTING]
    });

    Route::prefix('staff')->group(function () {
        Route::middleware('role:admin')->group(function () {
            // [START-DEPARTMENT]
             Route::get('department/peoples', DepartmentPeopleController::class)->name('staff.department.people');
             Route::get('department/devices', DepartmentDeviceController::class)->name('staff.department.device');
             Route::get('department/settings', DepartmentSettingController::class)->name('staff.department.setting');
            // [END-DEPARTMENT]
        });

        Route::middleware('role:admin,operator')->group(function () {
            // [START-QRCODE]
            Route::prefix('qrcode')->group(function () {
                Route::get('/scanner', QrScannerController::class)->name('staff.qrcode.scanner');
                Route::get('/generator',  QrGeneratorController::class)->name('staff.qrcode.generator');
            });
            // [END-QRCODE]

            // [START-ATTENDANCE]
            Route::prefix('attendances')->group(function () {
                Route::get('/excel-file', ExcelImportController::class)->name('staff.attendance.excel-file');
                Route::get('/manual-input', ManualInputController::class)->name('staff.attendance.manual-input');
                Route::get('/verify-submission', SubmissionVerificationController::class)->name('staff.attendance.verify-submission');
            });
            // [END-ATTENDANCE]

            // [START-REPORT]
            Route::prefix('reports')->group(function () {
                Route::get('/peoples', DepartmentByPeopleReportController::class)->name('staff.reports.by-people');
                Route::get('/dates', DepartmentByDateRangeReportController::class)->name('staff.reports.by-dates');
            });
            // [END-REPORT]
        });
    });
});
