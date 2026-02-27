<?php

use Illuminate\Support\Facades\Route;

// Default home page
Route::get('/', function () {return view('home');})->name('home');

// Login page
Route::get('/login', function () { return view('welcome'); })->name('login');


