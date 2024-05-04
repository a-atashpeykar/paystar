<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class,'index'])->name('users.index');
Route::post('/store', [UserController::class,'store'])->name('user.store');
Route::get('/show/{user}', [UserController::class,'show'])->name('user.show');
Route::get('/edit/{user}', [UserController::class,'edit'])->name('user.edit');
Route::post('/update/{user}', [UserController::class,'update'])->name('user.update');
Route::delete('/delete/{user}', [UserController::class,'destroy'])->name('user.destroy');
