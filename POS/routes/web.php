<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;

// Default home page
Route::get('/', function () {return view('home');})->name('home');

// Login page
Route::get('/login', function () { return view('welcome'); })->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard route
Route::get('/dashboard', function () {return view('dashboard'); })->middleware('auth')->name('dashboard');

// Category
Route::get('/category/add', [CategoryController::class, 'index'])->name('category.add');
Route::post('/category/add', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/manage', [CategoryController::class, 'manage'])->name('category.manage');
Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');