<?php

use App\Http\Controllers\ProductViewController; // Vamos criar este controller
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductViewController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductViewController::class, 'create'])->name('products.create');
Route::resource('products', ProductController::class);
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');