<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/login',function(){
    return view('auth.login');
});

Route::get('auth/google', [AuthController::class, 'signInwithGoogle'])->name('google-auth');
Route::get('callback/google', [AuthController::class, 'callbackToGoogle'])->name('google-callback');
