<?php

use App\Http\Controllers\loginController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ImageGeneratorController;

Route::post('/generate-image', [ImageGeneratorController::class, 'generate']);

Route::view('/', 'app');


Route::post('/login/google', [loginController::class, 'loginByGoogle'])->name('login.google');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::middleware(['auth'])->group(function (){
//     Route::get('/', function (){
//         return view('/');
//     });
// });