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

// Routes with preventBack middleware
Route::middleware('preventBack')->group(function(){
    Route::get('/login',function(){
        return view('login');
    })->name('login');
    
    Route::get('/register',function(){
        return view('register');
    })->name('register');
    
    // New routes for OTP verification during registration
    Route::get('/verify-registration', [UserController::class, 'showVerifyRegistrationForm'])->name('verify.registration.form');
});

// Authentication routes
Route::post('/saveRegister',[UserController::class,'register'])->name('saveRegister');
Route::post('/saveLogin',[UserController::class,'login'])->name('saveLogin');

// New routes for completing registration with OTP
Route::post('/verify-registration', [UserController::class, 'verifyRegistration'])->name('verify.registration');
Route::post('/resend-registration-otp', [UserController::class, 'resendRegistrationOtp'])->name('resend.registration.otp');

// Password reset routes
Route::get('/forgot-password', [UserController::class, 'showForgotForm'])->name('forgot.form');
Route::post('/send-otp', [UserController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('verify.otp');
Route::get('/reset-password', [UserController::class, 'showResetForm'])->name('reset.form');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset.password');

// Authenticated routes
Route::middleware('auth')->group(function(){
    Route::post('/logout',[UserController::class,'logout'])->name('logout');
    Route::get('/home',function(){
        return view('home');
    })->middleware('preventSite')->name('home');
});