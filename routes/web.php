<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Publico\LoginController;
use App\Http\Controllers\Publico\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;



//---------------------------------------
//     ROTAS TESTE ENVIO DE EMAIL      //
//---------------------------------------
Route::get('enviaremail', function() {
    $destinatario = 'diego.cicero@seati.ma.gov.br';
    $mensagem = "Olá, este é um e-mail de teste apenas em texto!";

    Mail::raw($mensagem, function ($message) use ($destinatario) {
        $message->to($destinatario)
                ->subject('Assunto do E-mail');
    });

});



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





//------------------------------------------------------------------------------
//           ROTAS RESTRITAS  PARA AUTENTICADOS COM O MIDDLEWARE AUTH         //
//------------------------------------------------------------------------------
Route::group(['middleware' => 'auth'], function(){


    // Acesso a todos que estiverem autenticados: Administradores, Consultores e Operadores. Todos poderão alterar seus respectivos perfis
    // DASHBOARD
    Route::get('/index-dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/index-dashboard/gerarexcel', [DashboardController::class, 'gerarexcel'])->name('dashboard.gerarexcel');

    Route::get('/edit-profile-user', [UserController::class, 'editprofile'])->name('user.editprofile');
    Route::put('/update-profile-user/{user}', [UserController::class, 'updateprofile'])->name('user.updateprofile');


    // Acesso apenas a usuários Admnistradores (onlyAdm)
    Route::group(['middleware' => 'can:onlyAdm'], function(){

        // USUÁRIO
        Route::get('/index-user', [UserController::class, 'index'])->name('user.index');
        Route::get('/create-user', [UserController::class, 'create'])->name('user.create');
        Route::post('/store-user', [UserController::class, 'store'])->name('user.store');
        Route::get('/show-user/{user}', [UserController::class, 'show'])->name('user.show');
        Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('pdf-user/relpdflistusers', [UserController::class, 'relpdflistusers'])->name('user.pdflistusers');

    });// Final das rotas de acesso a usuários administradores (onlyAdm)


    // Acesso apenas a usuários Admnistradores e Consultores (onlyAdmCon)
    Route::group(['middleware' => 'can:onlyAdmCon'], function(){



    });// Final das rotas de acesso a usuários administradores e consultores (onlyAdmCon)


}); // Final das rotas de quem deve está autenticado


