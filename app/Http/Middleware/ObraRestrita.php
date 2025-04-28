<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ObraRestrita
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Recupara todos os parâmetros que vem na requisição para ser tratado pelo middleware
        // dd($request->route()->parameters());

        // Dados da obra
        $parametros = !is_null($request->route('obra')) ? $request->route()->parameters() : NULL;  

        // Recupera o id da obra vinda na URL
        $idObra = $parametros['obra']['id'];
        
        // Recupera o id do usuário autenticado
        $idUsuario =  Auth::user()->id;

        // Retorna 1 se o usuário pertence à obra colocada na URL  ou Retorna 0 se o mesmo não pertence
        $usuarioresponsavelpelaobra = DB::table('obra_user')->where('obra_id', '=', $idObra)->where('user_id', '=', $idUsuario)->count();

        // Verifica se o usuário não é responsável pela obra
        if ($usuarioresponsavelpelaobra == 0) {

            /*
            // Deslogar o usuário
            Auth::logout();
            // Redireciona o usuário enviando a mensagem de aviso
            return redirect()->route('login.index')->with('warning', 'Operação ilegal!'); 
            */

            
            // Redireciona o usuário para a página anterior.
            return back()->withInput()->with('warning', 'Tentativa INAPROPRIADA!');
           
        }

        // Se o usuário é responsável pela obra, segue o fluxo!
        return $next($request);
    }
}
