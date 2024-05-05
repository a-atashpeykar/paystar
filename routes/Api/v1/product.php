<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class,'index'])->name('products.index');
Route::post('/store', [ProductController::class,'store'])->name('product.store');
Route::get('/show/{product}', [ProductController::class,'show'])->name('product.show');
Route::get('/edit/{product}', [ProductController::class,'edit'])->name('product.edit');
Route::put('/update/{product}', [ProductController::class,'update'])->name('product.update');
Route::delete('/delete/{product}', [ProductController::class,'destroy'])->name('product.destroy');
