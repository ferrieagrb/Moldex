<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('home');
});

Route::post('/register', [UserController::class /*call the UserController file*/,'register'/*Call the function inside*/]);
Route::post('/logout', [UserController::class,'logout']);
Route::post('/login', [UserController::class,'login']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/settings', function () {
    return view('settings');
})->middleware('auth')->name('settings');

Route::post('/settings/profile-photo', [ProfileController::class, 'updatePhoto'])
    ->middleware('auth')
    ->name('settings.update.photo');

Route::get('/finance', function () {
    return view('finance');
})->middleware('auth');