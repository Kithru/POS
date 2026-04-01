<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', [ItemController::class, 'categoryLanding'])->name('landing');

// Home page
Route::get('/home', [ItemController::class, 'getItemsForHome'])->name('home');

// Category selection
Route::get('/select-category/{id}', [ItemController::class, 'selectCategory'])->name('select.category');

// About page
Route::view('/about', 'about')->name('about');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard (Protected)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [ItemController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Category
|--------------------------------------------------------------------------
*/

Route::get('/category/add', [CategoryController::class, 'index'])->name('category.add');
Route::post('/category/add', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/manage', [CategoryController::class, 'manage'])->name('category.manage');
Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

/*
|--------------------------------------------------------------------------
| Subcategory
|--------------------------------------------------------------------------
*/

Route::get('/subcategory/add', [SubcategoryController::class, 'create'])->name('subcategory.create');
Route::post('/subcategory/add', [SubcategoryController::class, 'store'])->name('subcategory.store');
Route::get('/subcategory/manage', [SubcategoryController::class, 'manage'])->name('subcategory.manage');
Route::get('/subcategory/deactivate/{id}', [SubcategoryController::class, 'deactivate'])->name('subcategory.deactivate');
Route::get('/subcategory/activate/{id}', [SubcategoryController::class, 'activate'])->name('subcategory.activate');
Route::get('/subcategory/edit/{id}', [SubcategoryController::class, 'edit'])->name('subcategory.edit');
Route::put('/subcategory/edit/{id}', [SubcategoryController::class, 'update'])->name('subcategory.update');

/*
|--------------------------------------------------------------------------
| Items
|--------------------------------------------------------------------------
*/

Route::get('/add-item', [ItemController::class, 'create'])->name('item.add');
Route::post('/save-item', [ItemController::class, 'store'])->name('item.save');
Route::get('/items/manage', [ItemController::class, 'manage'])->name('item.manage');
Route::get('/items/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
Route::put('/items/update/{id}', [ItemController::class, 'update'])->name('item.update');

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/

Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
Route::get('/cart', [CartController::class,'index'])->name('cart.index');

/*
|--------------------------------------------------------------------------
| Orders
|--------------------------------------------------------------------------
*/

Route::get('/checkout', [OrderController::class, 'index'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

Route::get('/order/receipt/{order_id}', [OrderController::class, 'receipt'])->name('order.receipt');
Route::get('/order/pdf/{order_id}', [OrderController::class, 'downloadPdf'])->name('order.pdf');