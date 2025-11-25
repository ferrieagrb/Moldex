<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('home');
});

Route::get('/register', [UserController::class, 'showRegisterForm']);
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

Route::get('/documents', function () {
    return view('documents');
})->middleware('auth');


Route::get('/help', function () {
    return view('help');
})->middleware('auth');


Route::get('/maintenance', function () {
    return view('maintenance');
})->middleware('auth');

Route::get('/announcements', function () {
    return view('announcements');
})->middleware('auth');

Route::get('/adminlogin', function () {
    return view('adminlogin');
});

Route::post('/adminlogin', [UserController::class,'adminLogin']);

Route::get('/admindash', function () {
    return view('admindash');
})->middleware('auth');

Route::get('/adminlogout', function () {
    return view('adminlogin');
});

Route::post('/adminlogout', [UserController::class,'adminlogout']);

Route::get('/admincreate', function () {
    return view('admincreate');
})->middleware('auth');

Route::get('/adminforums', function () {
    return view('adminforums');
})->middleware('auth');

Route::get('/adminresidents', function () {
    return view('adminresidents');
})->middleware('auth');

Route::get('/adminunits', function () {
    return view('adminunits');
})->middleware('auth');


