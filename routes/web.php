<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Dashboard & Overview
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Quick Stock Adjustment (Business Rule Stok P4)
Route::patch('products/{product}/stock', [ProductController::class, 'updateStock'])->name('products.update-stock');

// Resource CRUD for Products (Plants)
Route::resource('products', ProductController::class);

// Resource CRUD for Categories
Route::resource('categories', CategoryController::class);

