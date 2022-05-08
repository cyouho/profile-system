<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;

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
});
