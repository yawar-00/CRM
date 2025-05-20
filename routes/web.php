<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;

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
        return view('auth.login');
    })->name('login');
    
    Route::get('/register',function(){
        return view('auth.register');
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::post('/logout',[UserController::class,'logout'])->name('logout');
    Route::get('/home',function(){
        return view('home');
    })->middleware('preventSite')->name('home');

    // Roles and Permission
    Route::resource('permission',PermissionController::class);
    Route::post('permission/store',[PermissionController::class,'store']);
    Route::get('permission/{id}/destroy',[PermissionController::class,'destroy']);
    Route::resource('users',UserController::class);
    Route::post('users/store',[UserController::class,'store']);
    Route::get('users/{Id}/destroy',[UserController::class,'destroy']);
    Route::resource('role',RoleController::class);
    Route::post('role/store',[RoleController::class,'store']);
    Route::get('role/{id}/destroy',[RoleController::class,'destroy']);
    Route::get('role/{id}/give-permissions',[RoleController::class,'addPermissionToRole']);
    Route::put('role/{id}/give-permissions',[RoleController::class,'givePermissionToRole']);



});