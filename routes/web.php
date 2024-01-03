<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::post('user-registration',[UserController::class,'UserRegistration']);
Route::post('user-login',[UserController::class,'UserLogin']);
Route::post('user-otp',[UserController::class,'SendOtpCode']);
