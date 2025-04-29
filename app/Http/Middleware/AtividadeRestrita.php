<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AtividadeRestrita
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Dados da atividade
        $parametros = !is_null($request->route('atividade')) ? $request->route()->parameters() : NULL;
        
        // Recupera o id da atividade vinda na URL
        $idAtividade = $parametros['atividade']['id'];

        // Se o usuário autenticado não é administrador, realiza as verificações
        if(Auth::user()->perfil != 'adm'){

            // Recupera o id do usuário autenticado
            $idUsuario =  Auth::user()->id;

            // Retorna 1 se o usuário é dono da atividade colocada na URL  ou Retorna 0 se o mesmo não é dono
            $usuariodonoatividade = DB::table('atividades')->where('id', '=', $idAtividade)->where('user_id', '=', $idUsuario)->count();

            // Verifica se o usuário não é dono da atividade
            if ($usuariodonoatividade == 0) {
            
                // Redireciona o usuário para a página anterior.
                return back()->withInput()->with('warning', 'Tentativa INAPROPRIADA!');
                
            }
        }

        // Se o usuário é dono da atividade, segue o fluxo!
        return $next($request);
    }
}
