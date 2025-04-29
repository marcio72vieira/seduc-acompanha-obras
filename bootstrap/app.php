<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Rota para a qual o usuário não autenticado deve ser redirecionado
        $middleware->redirectGuestsTo('/');
        // Registrando o middleware obrarestrita
        $middleware->alias([
            'obrarestrita' => \App\Http\Middleware\ObraRestrita::class,
            'atividaderestrita' => \App\Http\Middleware\AtividadeRestrita::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
