<?php

use App\Http\Controllers\Dash\Authentications\GrantAccessController;
use App\Http\Controllers\Dash\HomeController;
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

        // [START-REF&MOB]
        // Route::get('references/absent-types', [])->name('');
        // Route::get('mobile-apps/sliders', [])->name('');
        // Route::get('mobile-apps/announcements', [])->name('');
        // [END--REF&MOB]

        // [START-SUBMISSION]
        // Route::get('submissions', [])->name('');
        // [END-SUBMISSION]

        // [START-REPORT]
        // Route::get('reports/summaries', [])->name('');
        // Route::get('reports/employees', [])->name('');
        // Route::get('reports/departments', [])->name('');
        // Route::get('reports/locations', [])->name('');
        // [END-REPORT]

        // [START-OFFICE]
        // Route::get('offices/departments', [])->name('');
        // Route::get('offices/devices', [])->name('');
        // [END-OFFICE]

        // Route::get('peoples/thl', [])->name('');
        Route::get('users/accounts', [UserAccountController::class, 'index'])->name('users.accounts');
        // Route::get('settings', [SettingsController::class, 'index'])->name('root.settings');
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
