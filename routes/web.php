<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

// Dashboard & Overview
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Quick Stock Adjustment (Business Rule Stok P4)
Route::patch('products/{product}/stock', [ProductController::class, 'updateStock'])->name('products.update-stock');

// Resource CRUD for Products (Plants)
Route::resource('products', ProductController::class);

// Resource CRUD for Categories
Route::resource('categories', CategoryController::class);

// Resource CRUD for P4 Sales (Riwayat Penjualan Florist P4)
Route::resource('sales', SaleController::class);

