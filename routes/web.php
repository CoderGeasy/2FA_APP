<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;


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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/verify-2fa', [TwoFactorController::class, 'showVerifyForm'])->name('verify-2fa');
Route::post('/verify-2fa', [TwoFactorController::class, 'verify']);
Route::post('/resend-2fa', [TwoFactorController::class, 'resend'])->name('resend-2fa');

Route::middleware(['auth', '2fa'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});