<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('users', UserController::class);
Route::resource('products', ProductController::class);

Route::patch('/{id}/update-stock', [ProductController::class, 'updateStock'])->name('updateStock');
