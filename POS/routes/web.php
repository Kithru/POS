<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ItemController;

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

// Sub Category
Route::get('/subcategory/add', [SubcategoryController::class, 'create'])->name('subcategory.create');
Route::post('/subcategory/add', [SubcategoryController::class, 'store'])->name('subcategory.store');
Route::get('/subcategory/manage', [SubcategoryController::class, 'manage'])->name('subcategory.manage');
Route::get('/subcategory/deactivate/{id}', [SubcategoryController::class, 'deactivate'])->name('subcategory.deactivate');
Route::get('/subcategory/activate/{id}', [SubcategoryController::class, 'activate'])->name('subcategory.activate');
Route::get('/subcategory/edit/{id}', [SubcategoryController::class, 'edit'])->name('subcategory.edit');   // show edit form
Route::put('/subcategory/edit/{id}', [SubcategoryController::class, 'update'])->name('subcategory.update');
Route::get('/subcategory/view', [SubcategoryController::class, 'view'])->name('subcategory.view');

// Items
Route::get('/add-item', [ItemController::class, 'create'])->name('item.add');
Route::post('/save-item', [ItemController::class, 'store'])->name('item.save');
Route::get('/get-subcategories/{category_id}', [ItemController::class,'getSubcategories']);


