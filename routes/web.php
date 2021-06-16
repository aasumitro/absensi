<?php

use App\Http\Controllers\Dash\Authentications\GrantAccessController;
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

Route::get('login', [GrantAccessController::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::post('logout', [GrantAccessController::class, 'logout'])->name('logout');

//    Route::get('home', [HomeController::class, 'index'])->name('home');
//    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
//    Route::get('profile/backup', [ProfileController::class, 'backup'])->name('profile.backup');
});
