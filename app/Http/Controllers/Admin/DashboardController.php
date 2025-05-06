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

class DashboardController extends Controller
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
                DB::raw('GROUP_CONCAT(DISTINCT users.nome SEPARATOR ", ") as responsaveis'),
                DB::raw('GROUP_CONCAT(DISTINCT objetos.nome SEPARATOR ", ") as objetos'),
                DB::raw('max(atividades.progresso) AS progressomaximo')
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

        return view('admin.dashboards.dashboard', compact(
            'mes_corrente','ano_corrente','mesespesquisa', 'anospesquisa',
            'estatuscards', 'estatus', 'flag',
            'obras', 'tipoobras', 'objetos', 'regionais', 'municipios', 'users'
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


    public function gerarpdf(Request $request)
    {
        $ordenacao = $request->ordenacao ?? 'atividades.progresso';
        $sentido =  $request->sentido ?? 'desc';

        // Query de recuperação de registros
        $obras = DB::table('obras')
            ->join('tipoobras', 'tipoobras.id', '=', 'obras.tipoobra_id')
            ->join('escolas', 'escolas.id', '=', 'obras.escola_id')
            ->join('estatus', 'estatus.id', '=', 'obras.estatu_id')
            ->join('atividades', 'atividades.obra_id', '=', 'obras.id')
            ->join('regionais', 'regionais.id', '=', 'escolas.regional_id')
            ->join('municipios', 'municipios.id', '=', 'escolas.municipio_id')
            ->join('municipios AS municipiodaregional', 'municipiodaregional.regional_id', '=', 'regionais.id')
            ->join('obra_user', 'obra_user.obra_id', '=', 'obras.id')
            ->join('users', 'users.id', '=', 'obra_user.user_id')
            ->join('objeto_obra', 'objeto_obra.obra_id', '=', 'obras.id')
            ->join('objetos', 'objetos.id', '=', 'objeto_obra.objeto_id')

            // Campos a serem recuperados
            ->select(
                'obras.id','obras.data_inicio AS datainicio','obras.data_fim AS datafim','obras.ativo',
                'tipoobras.nome AS tipo',
                'escolas.nome AS escola',
                'estatus.id AS estatu', 'estatus.nome AS nomeestatus', 'estatus.cor',
                'regionais.nome AS regional',
                'municipios.nome AS municipio',
                DB::raw('GROUP_CONCAT(DISTINCT users.nome SEPARATOR ", ") as responsaveis'),
                DB::raw('GROUP_CONCAT(DISTINCT objetos.nome SEPARATOR ", ") as objetos'),
                DB::raw('max(atividades.progresso) AS progressomaximo')
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

        ->groupBy('atividades.obra_id')
        ->orderBy($ordenacao, $sentido)
        ->get();

        // Evita o "estouro" de memória pela quantidade de registros recuperados a partir do total registros recuperados
        $totalRecords =  $obras->count('id');

        // Verifica se a quantidade de registros retorndos, ultrapassa o limite estabelecido para gerar o relatório PDF
        if($totalRecords > 2){
            // Redireciona o usuário e envia a mensagem de error
            return redirect()->route('dashboard.index')->with('warningpdf', 'Limite de registro ultrapassado. Refine sua pesquisa!');

        } else {
            // Inicio carregar Rel PDF FILTRO OBRAS

            // Obtendo os dados. Os dados já foram obtidos na Query anterior: $obras = DB::table('obras')->join...
            // $obras = Obra::orderBy('id')->get();

            // Definindo o nome do arquivo a ser baixado
            $fileName = ('Obrasfiltradas.pdf');

            // Invocando a biblioteca mpdf e definindo as margens do arquivo
            $mpdf = new \Mpdf\Mpdf([
                'orientation' => 'L',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 30,
                'margin_bottom' => 15,
                'margin-header' => 10,
                'margin_footer' => 5
            ]);

            // Configurando o cabeçalho da página
            $mpdf->SetHTMLHeader('
                <table style="width:1080px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                    <tr>
                        <td style="width: 140px">
                            <img src="images/logo_seduc2.png" width="120"/>
                        </td>
                        <td style="width: 400px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                            Governo do Estado do Maranhão<br>
                            Secretaria de Estado da Educação / SEDUC<br>
                            Agência de Tecnologia da Informação / ATI<br>
                            Acompanhamento de Execução de Obras
                        </td>
                        <td style="width: 540px;" class="titulo-rel">
                            OBRAS
                        </td>
                    </tr>
                </table>
                <table style="width:1080px; border-collapse: collapse">
                    <tr>
                        <td width="40px" class="col-header-table">ID</td>
                        <td width="110px" class="col-header-table">TIPO</td>
                        <td width="250px" class="col-header-table">ESCOLA</td>
                        <td width="170px" class="col-header-table">OBJETOS</td>
                        <td width="100px" class="col-header-table">REGIONAL</td>
                        <td width="100px" class="col-header-table">REGIONAL</td>
                        <td width="100px" class="col-header-table">RESPONSÁVEIS</td>
                        <td width="140px" class="col-header-table">DATAs DE INÍCIO E FIM</td>
                        <td width="70px" class="col-header-table">PROGRESSO</td>
                    </tr>
                </table>
            ');

            // Configurando o rodapé da página
            $mpdf->SetHTMLFooter('
                <table style="width:1080px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                    <tr>
                        <td width="200px">São Luis(MA) {DATE d/m/Y}</td>
                        <td width="830px" align="center"></td>
                        <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                    </tr>
                </table>
            ');

            // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
            $html = \View::make('admin.dashboards.pdfs.pdf_list_filtroobras', compact('obras'));
            $html = $html->render();

            // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.users.pdfs.pdf_users')
            $stylesheet = file_get_contents('css/pdf/mpdf.css');
            $mpdf->WriteHTML($stylesheet, 1);

            // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
            $mpdf->WriteHTML($html);
            $mpdf->Output($fileName, 'I');  // Exibe o arquivo no browse   || $mpdf->Output($fileName, 'F');  Gera o arquivo na pasta pública

            // Fim carregar Rel PDF FILTRO OBRAS

        }


    }


}
