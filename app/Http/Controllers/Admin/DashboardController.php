<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Models\User;
use App\Models\Obra;
use App\Models\Estatu;
use App\Models\Regional;
use App\Models\Municipio;
use App\Models\Tipoobra;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // if($request->tipoobra_id){ dd($request->all()); }

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
        $estatus = Estatu::orderBy('id')->get();

        // Tipos de obras para pesquisa
        $tipoobras = Tipoobra::orderBy('nome')->get();
        $regionais = Regional::orderBy('nome')->get();
        $municipios = Municipio::orderBy('nome')->get();



        /***** INICIO PESQUISA PARA FILTRO DO DASHBOARD */
        // Só recupera as OBRAS que possuem ATIVIDADES (->join('atividades', 'atividades.obra_id', '=', 'obras.id')), e com
        // a cláusula: DB::raw('max(atividades.progresso) AS progressomaximo'), recupera o valor máximo da coluna progresso
        // do conjunto de registros retornados pela clausula "->groupBy('atividades.obra_id')".
        // Obs: Lembrar que a tabela "escolas" possui relacionamento tanto com obras quanto com regionais e municipios, logo
        //      deve-se fazer a junção de escolas com obras (->join('escolas', 'escolas.id', '=', 'obras.escola_id')) e a
        //      junção de escola com regionais (->join('escolas AS escreg', 'escreg.regional_id', '=', 'regionais.id')) e
        //      junção de escola com municipios (->join('escolas AS escmun', 'escmun.municipio_id', '=', 'municipios.id')).
        //      Em ambos os caso, como a table "escola" já foi utilizada para o relacionamento com obras, houve a necessidde
        //      de apelidar( AS ) as tabelas comoo descrito: "escolas AS escreg" e "escolas AS escmun" 

        // Query com filtro. Só está funcionando se o usuário informar obrigatoriamente os campos tipo regional e municipio
        $obras = DB::table('obras')
            ->join('tipoobras', 'tipoobras.id', '=', 'obras.tipoobra_id')
            ->join('escolas', 'escolas.id', '=', 'obras.escola_id')
            ->join('regionais', 'regionais.id', '=', 'obras.regional_id')
            ->join('municipios', 'municipios.id', '=', 'obras.municipio_id')
            ->join('estatus', 'estatus.id', '=', 'obras.estatu_id')
            ->join('atividades', 'atividades.obra_id', '=', 'obras.id')
            ->join('escolas AS escolreg', 'escolreg.regional_id', '=', 'regionais.id')
            ->join('escolas AS escolmun', 'escolmun.municipio_id', '=', 'municipios.id')
            ->select(
                'obras.id',
                'tipoobras.nome AS tipo',
                'escolas.nome AS escola',
                'regionais.nome AS regional',
                'municipios.nome AS municipio',
                'escolreg.id AS idescolreg',
                'escolmun.id AS idescolmun',
                'estatus.id AS estatu', 'estatus.nome AS nomeestatus', 'estatus.cor',
                 DB::raw('max(atividades.progresso) AS progressomaximo')
            )
            ->when($request->has('tipoobra_id'), function($query) use($request) {
                $query->where('tipoobra_id', '=', $request->tipoobra_id);
            })
            ->when($request->has('regional_id'), function($query) use($request) {
                $query->where('escolreg.regional_id', '=', $request->regional_id);
            })
            ->when($request->has('municipio_id'), function($query) use($request) {
                $query->where('escolmun.municipio_id', '=', $request->municipio_id);
            })
        ->groupBy('atividades.obra_id')
        ->orderBy('tipoobras.nome')
        ->paginate(10);


        // Se a pesquisa foi submetida e seu valor for started, exibe o formulário de pesquisa, caso contrário esconde o formulário.
        if($request->pesquisar == "started"){
            $flag = '';
        }else{
            $flag = 'none';
        }

        /***** FINAL PESQUISA PARA FILTRO DO DASHBOARD */

        return view('admin.dashboards.dashboard', compact(
            'mes_corrente','ano_corrente','mesespesquisa', 'anospesquisa', 
            'estatus', 'flag', 
            'obras', 'tipoobras', 'regionais', 'municipios'
        ));
    }


    // Método utilizado com Biblioteca Spatie-Simple-Excel
    public function gerarexcel(Request $request)
    {

        $mes = $request->mesexcel;
        $ano = $request->anoexcel;
        $tipo = $request->tipoexcelcsv;


        // Testa se todos os parâmetros são válidos
        // if($mes != 0 && $ano != 0 && $tipo != 0){
        if($tipo != 0){

            // Adiciona um 0 (zero) na frente do mês de 01 a 09
            $mes = ($mes < 10) ? "0".$mes : $mes;

            // Define o nome do arquivo(formado por mês e ano ou apenas o ano)
            $referencia = ($mes == "00") ? $ano : $mes."_".$ano;

            // Define o tipo de arquivo a ser gerado
            $tipoextensao = ($tipo == 1) ? 'xlsx' : 'csv';

            // Definindo a query para recuperar os registros
            if($mes == 0){
                $records = DB::table('users')->selectRaw(
                    'id, nomecompleto, nome, cpf, cargo, fone, perfil, email, ativo, DATE_FORMAT(created_at,"%d/%m/%Y") AS cadastrado')
                ->whereYear('created_at', $ano)
                ->get();

            }else{

                $records = DB::table('users')->selectRaw(
                    'id, nomecompleto, nome, cpf, cargo, fone, perfil, email, ativo, DATE_FORMAT(created_at,"%d/%m/%Y") AS cadastrado')
                ->whereMonth('created_at', $mes)
                ->whereYear('created_at', $ano)
                ->get();
            }

            // Definindo o cabeçalho das colunas no arquivo Excel gerado.
            $writer = SimpleExcelWriter::streamDownload("seducobras_$referencia.$tipoextensao")->addHeader([
                'Registro', 'Nome Completo', 'Usuário', 'CPF', 'Cargo', 'Fone', 'Pefil', 'E-mail', 'Ativo', 'Cadastrado'
            ]);


            // Contador para esvaziar buffer com flush()
            $countbuffer = 1;

            foreach ($records as $record ) {
                $writer->addRow([
                    'id' => $record->id,
                    'nomecompleto' => $record->nomecompleto,
                    'nome' => $record->nome,
                    'cpf' => $record->cpf,
                    'cargo' => $record->cargo,
                    'fone' => $record->fone,
                    'perfil' => $record->perfil,
                    'email' => $record->email,
                    'ativo' => ($record->ativo == 1 ? 'sim' : 'não'),
                    'created_at' => $record->cadastrado,
                ]);

                // Limpa o buffer a cada mil linhas
                $countbuffer++;

                if($countbuffer % 1000 === 0){
                    flush();
                }
            }

            $writer->toBrowser();

        } else {
            return redirect()->route('dashboard.index')->with('error', 'Escolha um tipo de arquivo: Excel ou CSV, para ser gerado!');;
        }

    }

}
