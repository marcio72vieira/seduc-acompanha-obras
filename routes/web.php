<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;


Route::get('/dashboard', function() { return view('admin.dashboard'); });


// USUÁRIO
Route::get('/index-user', [UserController::class, 'index'])->name('user.index');
Route::get('/create-user', [UserController::class, 'create'])->name('user.create');
Route::post('/store-user', [UserController::class, 'store'])->name('user.store');
Route::get('/show-user/{user}', [UserController::class, 'show'])->name('user.show');
Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
Route::get('pdf-user/relpdflistusers', [UserController::class, 'relpdflistusers'])->name('user.pdflistusers');
