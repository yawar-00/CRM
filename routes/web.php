<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('preventBack')->group(function(){
    Route::get('/login',function(){
        return view('login');
    })->name('login');
    Route::get('/register',function(){
        return view('register');
    })->name('register');
});
Route::middleware('auth')->group(function(){
Route::post('/logout',[UserController::class,'logout'])->name('logout');
Route::get('/home',function(){
    return view('home');
})->middleware('preventSite')->name('home');
});
Route::post('/saveRegister',[UserController::class,'register'])->name('saveRegister');
Route::post('/saveLogin',[UserController::class,'login'])->name('saveLogin');



Route::get('/forgot-password', [UserController::class, 'showForgotForm'])->name('forgot.form');
Route::post('/send-otp', [UserController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('verify.otp');

Route::get('/reset-password', [UserController::class, 'showResetForm'])->name('reset.form');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset.password');