<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Models\Obra;
use App\Models\Tipoobra;
use App\Models\Objeto;
use App\Models\Estatu;
use App\Models\Regional;
use App\Models\Municipio;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    public function index(Request $request)
    {
        // Definindo mês para computo dos dados OK!
        // $mes_corrente = date('m');   // número do mês no formato 01, 02, 03, 04 ..., 09, 10, 11, 12
        $mes_corrente = date('n');      // número do mês no formato 1, 2, 3, 4 ..., 9, 10, 11, 12
        $ano_corrente = date('Y');

        // Meses e anos para popular campos selects.
        // Obs: os índices do array não pode ser: 01, 02, 03, etc... por isso a configuração acima: $mes_corrente = date('n');
        //      caso os índices pudesser ser: 01, 02, 03, etc..., seria nno formato: $mes_corrente = date('m');
        $mesespesquisa = [
            '1' => 'janeiro', '2' => 'fevereiro', '3' => 'março', '4' => 'abril', '5' => 'maio', '6' => 'junho',
            '7' => 'julho', '8' => 'agosto', '9' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];

        $anoimplantacao = 2025;
        $anoatual = date("Y");
        $anospesquisa = [];
        $anos = [];

        if($anoimplantacao >= $anoatual){
            $anospesquisa[] = $anoatual;
        }else{
            $qtdanosexibicao = $anoatual - $anoimplantacao;
            for($a = $qtdanosexibicao; $a >= 0; $a--){
                $anos[] = $anoatual - $a;   // $anoatual - 0 (quando $a for igual a zero) será igual ao ano corrente.
            }
            $anospesquisa = array_reverse($anos);
        }

        // Estatus pra exibir os cards
        $estatuscards = Estatu::orderBy('id')->get();

        // Tipos de obras para pesquisa
        $tipoobras = Tipoobra::orderBy('nome')->get();
        $objetos = Objeto::orderBy('nome')->get();
        $regionais = Regional::orderBy('nome')->get();
        $municipios = Municipio::orderBy('nome')->get();
        $users =  User::orderBy('nome')->get();
        $estatus = Estatu::orderBy('nome')->get();




        /***** INICIO PESQUISA PARA FILTRO DO DASHBOARD */
        // Ordem, Sentido e Paginação da Exibição dos registros.
        // Se a variável foi definida e não é nulla, assume o primiero operando, caso contrário assume o segundos(valores padrões)
        //
        $ordenacao = $request->ordenacao ?? 'atividades.progresso';
        $sentido =  $request->sentido ?? 'desc';
        $paginacao = $request->paginacao ?? 10;

        // Query de recuperação de registros
        $obras = DB::table('obras')                                                                                 // RELACIONAMENTOS ENTRE
            ->join('tipoobras', 'tipoobras.id', '=', 'obras.tipoobra_id')                                           // tipoobra x obra
            ->join('escolas', 'escolas.id', '=', 'obras.escola_id')                                                 // escolas  x obra
            ->join('estatus', 'estatus.id', '=', 'obras.estatu_id')                                                 // estatus x obra
            ->join('atividades', 'atividades.obra_id', '=', 'obras.id')                                             // atividades x obra
            ->join('regionais', 'regionais.id', '=', 'escolas.regional_id')                                         // regionais x escola (pois na escola existe id da regional)
            ->join('municipios', 'municipios.id', '=', 'escolas.municipio_id')                                      // municipios x escola (pois na escola existe id do municipio)
            ->join('municipios AS municipiodaregional', 'municipiodaregional.regional_id', '=', 'regionais.id')     // municpios x regional (pois no município existe o id da regionl. O aplido "AS municipiodaregional" foi utilizado, porque municpios já foi utilizado no relcionmento anterior municipios x escolas)
            ->join('obra_user', 'obra_user.obra_id', '=', 'obras.id')                                               // obra_user x obra (pois obra_user possui o id da obra)
            ->join('users', 'users.id', '=', 'obra_user.user_id')                                                   // obra_user x user (pois obra_user possui o id do usuário)
            ->join('objeto_obra', 'objeto_obra.obra_id', '=', 'obras.id')                                           // objeto_obra x obra (pois objeto_obra possui o id da obra)
            ->join('objetos', 'objetos.id', '=', 'objeto_obra.objeto_id')                                           // objeto_obra x obra (pois objeto_obra possui o id do objeto)

            // Campos a serem recuperados
            ->select(
                'obras.id','obras.data_inicio AS datainicio','obras.data_fim AS datafim','obras.ativo',
                'tipoobras.nome AS tipo',
                'escolas.nome AS escola',
                'estatus.id AS estatu', 'estatus.nome AS nomeestatus', 'estatus.cor',
                'regionais.nome AS regional',
                'municipios.nome AS municipio',
                // Agrupa várias linhas referente ao usuário e ao fone em um só campo, no caso: responsáveis e contato, de forma distinta, ou seja, sem repetir o registro
                //DB::raw('GROUP_CONCAT(DISTINCT users.nome SEPARATOR ", ") as responsaveis, GROUP_CONCAT(DISTINCT users.fone SEPARATOR ", ") as contato'),
                // Concatena dois campos da tabela em um só e o nomeia para responsáveis
                //DB::raw('CONCAT(users.nome, " ", users.fone) responsaveis'),
                // Concatena nome e fone separados por "espaço em branco" e agrupa os vários registro de forma distinta seprados por "vírgula"
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(users.nome, " ", users.fone) SEPARATOR ", " ) as responsaveiscontato'),
                // Agrupa várias linhas do campo objeto referente ao registro da obra corrente, de forma distinta.
                DB::raw('GROUP_CONCAT(DISTINCT objetos.nome SEPARATOR ", ") as objetos'),
                DB::raw('max(atividades.progresso) AS progressomaximo'),
                DB::raw('max(DATE(atividades.updated_at)) AS registromaisrecente')    // DATE(), obtém só a data da coluna "updated_at" que é do tipo "timestamp", desprezado o tempo.
            )


            // Se os campos foram preenchidos, adicione à query já existente mais condições
            ->when($request->has('tipoobra'), function($query) use($request) {
                $query->where('tipoobras.nome', 'like', '%'. $request->tipoobra . '%');
            })
            ->when($request->has('objeto'), function($query) use($request) {
                $query->where('objetos.nome', 'like', '%'. $request->objeto . '%');
            })
            ->when($request->has('regional'), function($query) use($request) {
                $query->where('regionais.nome', 'like', '%'. $request->regional . '%');
            })
            ->when($request->has('municipio'), function($query) use($request) {
                $query->where('municipios.nome', 'like', '%'. $request->municipio . '%');
            })
            ->when($request->has('user'), function($query) use($request) {
                $query->where('users.nome', 'like', '%'. $request->user . '%');
            })
            ->when($request->has('estatu'), function($query) use($request) {
                $query->where('estatus.nome', 'like', '%'. $request->estatu . '%');
            })
            ->when($request->filled('datainicio'), function($query) use($request) {
                $query->where('obras.data_inicio', '>=', \Carbon\Carbon::parse($request->datainicio)->format('Y-m-d'));
            })
            ->when($request->filled('datafim'), function($query) use($request) {
                $query->where('obras.data_fim', '<=', \Carbon\Carbon::parse($request->datafim)->format('Y-m-d'));
            })

        ->where('obras.estatu_id', '!=', 3) // Só recupera as obras que não estão concluídas.
        ->groupBy('atividades.obra_id')
        ->orderBy($ordenacao, $sentido)     //->orderBy('tipoobras.nome')
        ->paginate($paginacao);                     //->paginate(10);

       // Se a pesquisa foi submetida e seu valor for started, exibe o formulário de pesquisa, caso contrário esconde o formulário.
        if($request->pesquisar == "started"){
            $flag = '';
        }else{
            $flag = 'none';
        }

        /***** FINAL PESQUISA PARA FILTRO DO DASHBOARD */

        return view('admin.monitores.monitor', compact(
            'mes_corrente','ano_corrente','mesespesquisa', 'anospesquisa',
            'estatuscards', 'estatus', 'flag',
            'obras', 'tipoobras', 'objetos', 'regionais', 'municipios', 'users'
        ));
    }
}
