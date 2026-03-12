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

// Login submit
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Dashboard route
Route::get('/dashboard', function () {return view('dashboard'); })->middleware('auth')->name('dashboard');
Route::get('/dashboard', [ItemController::class, 'dashboard'])->name('dashboard');

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
Route::get('/save-item', function() { return redirect()->route('item.add');});
Route::get('/get-subcategories/{category_id}', [ItemController::class,'getSubcategories']);

// Manage items page
Route::get('/items/manage', [ItemController::class, 'manage'])->name('item.manage');
Route::get('/items/activate/{id}', [ItemController::class, 'activate'])->name('item.activate');
Route::get('/items/deactivate/{id}', [ItemController::class, 'deactivate'])->name('item.deactivate');
Route::get('/items/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');

Route::get('/items/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
// Route::post('/items/update/{id}', [ItemController::class, 'update'])->name('item.update');
Route::put('/items/update/{id}', [ItemController::class, 'update'])->name('item.update');
Route::get('/items/view', [ItemController::class, 'viewItems'])->name('item.view');

Route::get('/', [ItemController::class, 'getItemsForHome'])->name('home');

// Item search for Home
Route::get('/search-items', [ItemController::class, 'mainSearch'])->name('item.search');
