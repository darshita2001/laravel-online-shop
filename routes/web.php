<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;

Route::view('/','master');
Route::view('/login','auth.login');


Route::get('auth/google', [AuthController::class, 'signInwithGoogle'])->name('google-auth');
Route::get('callback/google', [AuthController::class, 'callbackToGoogle'])->name('google-callback');

Route::resource('categories',CategoryController::class);
