<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Publico\LoginController;
use App\Http\Controllers\Admin\UserController;


Route::get('/dashboard', function() { return view('admin.dashboard'); });

//---------------------------------------
//           ROTAS PÚBLICAS            //
//---------------------------------------
// LOGIN
Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'processalogin'])->name('login.processalogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

// PRIMEIRO ACESSO
Route::get('/create-login-primeiroacesso/{user}', [LoginController::class, 'createprimeiroacesso'])->name('login.create-primeiroacesso');
Route::post('/store-user-login', [LoginController::class, 'store'])->name('login.store-user');

// RECUPERAR SENHA
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPassword'])->name('forgot-password.show');
Route::post('/forgot-password', [ForgotPasswordController::class, 'submitForgotPassword'])->name('forgot-password.submit');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPassword'])->name('reset-password.submit');





//---------------------------------------
//           ROTAS RESTRITAS           //
//---------------------------------------
// USUÁRIO
Route::get('/index-user', [UserController::class, 'index'])->name('user.index');
Route::get('/create-user', [UserController::class, 'create'])->name('user.create');
Route::post('/store-user', [UserController::class, 'store'])->name('user.store');
Route::get('/show-user/{user}', [UserController::class, 'show'])->name('user.show');
Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
Route::get('/edit-profile-user/{user}', [UserController::class, 'editprofile'])->name('user.editprofile');
Route::put('/update-profile-user/{user}', [UserController::class, 'updateprofile'])->name('user.updateprofile');

Route::get('pdf-user/relpdflistusers', [UserController::class, 'relpdflistusers'])->name('user.pdflistusers');
