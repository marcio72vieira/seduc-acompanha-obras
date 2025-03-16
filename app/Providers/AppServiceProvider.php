<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Incluir a paginação do Bootstrap 5
        Paginator::useBootstrapFive();

        // Define o acesso apenas de quem é Administrdor
        Gate::define('onlyAdm', function($user) {
            return $user->perfil == 'adm'
                ? Response::allow()
                : Response::deny('Acesso não autorizado!');
        });


        // Define o acesso apenas de quem é Administrador ou Consultor
        Gate::define('onlyAdmCon', function($user) {
            return $user->perfil == 'adm' || $user->perfil == 'con'
                ? Response::allow()
                : Response::deny('Acesso não autorizado!');
        });


        // Define o acesso apenas de quem é Administrador ou Operador.
        Gate::define('onlyAdmOpe', function($user) {
            return $user->perfil == 'adm' || $user->perfil == 'ope'
                ? Response::allow()
                : Response::deny('Acesso não autorizado!');
        });

        // Evita o erro de select dependentes em requisições Ajax no modo de Produção nos servidores da SEATI
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }


    }
}
