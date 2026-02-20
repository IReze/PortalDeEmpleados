<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware(['auth', 'verified']);

//edit profile
Route::view('profile/edit', 'profile.edit')->name('profile.edit')->middleware('auth', 'verified');
Route::view('profile/password', 'profile.password')->name('profile.password')->middleware('auth', 'verified');