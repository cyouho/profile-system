<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

/*
|--------------------------------------------------------------------------
| Web Routes For Customs
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth.check'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterPage'])->withoutMiddleware(['auth.check']);
    Route::get('/login', [AuthController::class, 'showLoginPage'])->withoutMiddleware(['auth.check']);
    Route::get('/logout', [AuthController::class, 'doLogout'])->withoutMiddleware(['auth.check']);

    Route::post('/doRegister', [AuthController::class, 'doRegister'])->withoutMiddleware(['auth.check']);
    Route::post('/doLogin', [AuthController::class, 'doLogin'])->withoutMiddleware(['auth.check']);

    Route::get('/profile', [HomeController::class, 'profile']);
    Route::get('/setting', [HomeController::class, 'setting']);
    Route::get('/', [HomeController::class, 'home']);

    Route::post('/resetUserName', [SettingController::class, 'resetUserName']);
});
