<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Publico\LoginController;
use App\Http\Controllers\Publico\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RegionalController;
use App\Http\Controllers\Admin\MunicipioController;
use App\Http\Controllers\Admin\EscolaController;
use App\Http\Controllers\Admin\ObjetoController;
use App\Http\Controllers\Admin\ObraController;
use App\Http\Controllers\Admin\ProgramaController;
use App\Http\Controllers\Admin\DatatableController;

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

    Route::get('/ajaxgetusers-dashboard', [DashboardController::class, 'ajaxgetusers'])->name('dashboard.ajaxgetusers');


    // Acesso apenas a usuários Admnistradores (onlyAdm)
    Route::group(['middleware' => 'can:onlyAdm'], function(){

        // USUÁRIO
        Route::get('/index-user', [UserController::class, 'index'])->name('user.index');
        Route::get('/create-user', [UserController::class, 'create'])->name('user.create');
        Route::post('/store-user', [UserController::class, 'store'])->name('user.store');
        Route::get('/show-user/{user}', [UserController::class, 'show'])->name('user.show');
        Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user.update');
        Route::get('/sendemail-user/{user}', [UserController::class, 'sendemail'])->name('user.sendemail');
        Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('pdf-user/relpdflistusers', [UserController::class, 'relpdflistusers'])->name('user.pdflistusers');
        Route::get('pdf-user/relpdflistusers', [UserController::class, 'relpdflistusers'])->name('user.pdflistusers');


        // REGIONAL
        Route::get('/index-regional', [RegionalController::class, 'index'])->name('regional.index');
        Route::get('/create-regional', [RegionalController::class, 'create'])->name('regional.create');
        Route::post('/store-regional', [RegionalController::class, 'store'])->name('regional.store');
        Route::get('/edit-regional/{regional}', [RegionalController::class, 'edit'])->name('regional.edit');
        Route::put('/update-regional/{regional}', [RegionalController::class, 'update'])->name('regional.update');
        Route::delete('/destroy-regional/{regional}', [RegionalController::class, 'destroy'])->name('regional.destroy');
        Route::get('pdf-regional/relpdflistregionais', [RegionalController::class, 'relpdflistregionais'])->name('regional.relpdflistregionais');
        Route::get('/escolas-regional/{regional}', [RegionalController::class, 'escolasregional'])->name('regional.escolas');
        Route::get('/municipios-regional/{regional}', [RegionalController::class, 'municipiosregional'])->name('regional.municipios');
        Route::get('pdf-regional/relpdflistmunicipiosregional/{regional}', [RegionalController::class, 'relpdflistmunicipiosregional'])->name('regional.relpdflistmunicipiosregional');
        Route::get('pdf-regional/relpdflistescolasregional/{regional}', [RegionalController::class, 'relpdflistescolasregional'])->name('regional.relpdflistescolasregional');


        // MUNICIPIO
        Route::get('/index-municipio', [MunicipioController::class, 'index'])->name('municipio.index');
        Route::get('/create-municipio', [MunicipioController::class, 'create'])->name('municipio.create');
        Route::post('/store-municipio', [MunicipioController::class, 'store'])->name('municipio.store');
        Route::get('/edit-municipio/{municipio}', [MunicipioController::class, 'edit'])->name('municipio.edit');
        Route::put('/update-municipio/{municipio}', [MunicipioController::class, 'update'])->name('municipio.update');
        Route::delete('/destroy-municipio/{municipio}', [MunicipioController::class, 'destroy'])->name('municipio.destroy');
        Route::get('pdf-municipio/relpdflistmunicipios', [MunicipioController::class, 'relpdflistmunicipios'])->name('municipio.pdflistmunicipios');
        Route::get('/escolas-municipio/{municipio}', [MunicipioController::class, 'escolasmunicipio'])->name('municipio.escolas');
        Route::get('pdf-municipio/relpdflistescolasmunicipio/{municipio}', [MunicipioController::class, 'relpdflistescolasmunicipio'])->name('municipio.relpdflistescolasmunicipio');

        // ESCOLA
        Route::get('/index-escola', [EscolaController::class, 'index'])->name('escola.index');
        Route::get('/create-escola', [EscolaController::class, 'create'])->name('escola.create');
        Route::post('/store-escola', [EscolaController::class, 'store'])->name('escola.store');
        Route::get('/show-escola/{escola}', [EscolaController::class, 'show'])->name('escola.show');
        Route::get('/edit-escola/{escola}', [EscolaController::class, 'edit'])->name('escola.edit');
        Route::put('/update-escola/{escola}', [EscolaController::class, 'update'])->name('escola.update');
        Route::delete('/destroy-escola/{escola}', [EscolaController::class, 'destroy'])->name('escola.destroy');
        Route::get('pdf-escola/relpdflistescolas', [EscolaController::class, 'relpdflistescolas'])->name('escola.pdflistescolas');


        // OBJETO
        Route::get('/index-objeto', [ObjetoController::class, 'index'])->name('objeto.index');
        Route::get('/create-objeto', [ObjetoController::class, 'create'])->name('objeto.create');
        Route::post('/store-objeto', [ObjetoController::class, 'store'])->name('objeto.store');
        Route::get('/edit-objeto/{objeto}', [ObjetoController::class, 'edit'])->name('objeto.edit');
        Route::put('/update-objeto/{objeto}', [ObjetoController::class, 'update'])->name('objeto.update');
        Route::delete('/destroy-objeto/{objeto}', [ObjetoController::class, 'destroy'])->name('objeto.destroy');
        Route::get('pdf-objeto/relpdflistobjetos', [ObjetoController::class, 'relpdflistobjetos'])->name('objeto.relpdflistobjetos');


        // PROGRAMA
        Route::get('/index-programa', [ProgramaController::class, 'index'])->name('programa.index');
        Route::get('/create-programa', [ProgramaController::class, 'create'])->name('programa.create');
        Route::post('/store-programa', [ProgramaController::class, 'store'])->name('programa.store');
        Route::get('/edit-programa/{programa}', [ProgramaController::class, 'edit'])->name('programa.edit');
        Route::put('/update-programa/{programa}', [ProgramaController::class, 'update'])->name('programa.update');
        Route::delete('/destroy-programa/{programa}', [ProgramaController::class, 'destroy'])->name('programa.destroy');
        Route::get('pdf-programa/relpdflistprogramas', [ProgramaController::class, 'relpdflistprogramas'])->name('programa.relpdflistprogramas');


        // OBRA
        Route::get('/index-obra', [ObraController::class, 'index'])->name('obra.index');
        Route::get('/create-obra', [ObraController::class, 'create'])->name('obra.create');
        Route::post('/store-obra', [ObraController::class, 'store'])->name('obra.store');
        Route::get('/edit-obra/{obra}', [ObraController::class, 'edit'])->name('obra.edit');
        Route::put('/update-obra/{obra}', [ObraController::class, 'update'])->name('obra.update');
        Route::delete('/destroy-obra/{obra}', [ObraController::class, 'destroy'])->name('obra.destroy');
        Route::get('pdf-obra/relpdflistobras', [ObraController::class, 'relpdflistobras'])->name('obra.relpdflistobras');


        // DATATABLE
        Route::get('/ajaxgetusers-datatable', [DatatableController::class, 'ajaxgetusers'])->name('datatable.ajaxgetusers');
        Route::get('/ajaxgetuser-datatable/{user}', [DatatableController::class, 'ajaxgetuser'])->name('datatable.ajaxgetuser');

        Route::get('/index-datatable', [DatatableController::class, 'index'])->name('datatable.index');
        Route::get('/create-datatable', [DatatableController::class, 'create'])->name('datatable.create');
        Route::post('/store-datatable', [DatatableController::class, 'store'])->name('datatable.store');

        Route::get('/edit-datatable/{user}', [DatatableController::class, 'edit'])->name('datatable.edit');
        Route::post('/update-datatable/{user}', [DatatableController::class, 'update'])->name('datatable.update');
        /*
        Route::get('/show-user/{user}', [DatatableController::class, 'show'])->name('user.show');
        Route::get('/edit-user/{user}', [DatatableController::class, 'edit'])->name('user.edit');
        Route::put('/update-user/{user}', [DatatableController::class, 'update'])->name('user.update');
        Route::get('/sendemail-user/{user}', [DatatableController::class, 'sendemail'])->name('user.sendemail');
        Route::delete('/destroy-user/{user}', [DatatableController::class, 'destroy'])->name('user.destroy');
        Route::get('pdf-user/relpdflistusers', [DatatableController::class, 'relpdflistusers'])->name('user.pdflistusers');
        Route::get('pdf-user/relpdflistusers', [DatatableController::class, 'relpdflistusers'])->name('user.pdflistusers');
        */


    });// Final das rotas de acesso a usuários administradores (onlyAdm)


    // Acesso apenas a usuários Admnistradores e Consultores (onlyAdmCon)
    Route::group(['middleware' => 'can:onlyAdmCon'], function(){



    });// Final das rotas de acesso a usuários administradores e consultores (onlyAdmCon)


}); // Final das rotas de quem deve está autenticado


