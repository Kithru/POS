<?php

use Illuminate\Support\Facades\Route;

// Default home page
Route::get('/', function () {return view('home');})->name('home');

// Login page
Route::get('/login', function () { return view('welcome'); })->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


