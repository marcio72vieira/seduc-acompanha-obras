<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Models\User;
use App\Models\Obra;
use App\Models\Estatu;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
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

        $obras = Obra::orderBy('id')->paginate(10);
        $estatus = Estatu::orderBy('id')->get();

        return view('admin.dashboards.dashboard', compact('mes_corrente','ano_corrente','mesespesquisa', 'anospesquisa', 'obras', 'estatus'));
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



    public function ajaxgetusers(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $totalRecords = User::select('count(*) as allcount')->count();
        $totalRecordswithFilter = DB::table('users')
            ->select('count(*) as allcount')
            ->where('users.nomecompleto', 'like', '%' .$searchValue . '%')
            ->orWhere('users.cpf', 'like', '%' . $searchValue . '%' )
            ->orWhere('users.cargo', 'like', '%' . $searchValue . '%' )
            ->orWhere('users.perfil', 'like', '%' . $searchValue . '%' )
            ->count();

        // Fetch records (restaurantes)
        $users = DB::table('users')
        ->select('users.id', 'users.nomecompleto', 'users.cpf', 'users.cargo', 'users.fone', 'users.perfil', 'users.email')
        ->where('users.nomecompleto', 'like', '%' .$searchValue . '%')
        ->orWhere('users.cpf', 'like', '%' .$searchValue . '%')
        ->orWhere('users.cargo', 'like', '%' . $searchValue . '%' )
        ->orWhere('users.perfil', 'like', '%' . $searchValue . '%' )
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();

        foreach($users as $user){
            // campos a serem exibidos no DataTable (Os nomes devem correspoder à propriedde Column:[] da requisição Ajax)
            $id = $user->id;
            $nomecompleto = $user->nomecompleto;
            $cpf = $user->cpf;
            $cargo = $user->cargo;
            $perfil = ($user->perfil == 'adm' ? 'Administrador' : ($user->perfil == 'con' ? 'Consultor' : 'Operador'));
            $contato = $user->fone." / ".$user->email;

            $data_arr[] = array(
                "id" => $id,
                "nomecompleto" => $nomecompleto,
                "cpf" => $cpf,
                "cargo" => $cargo,
                "perfil" => $perfil,
                "contato" => $contato,
            );
        }

        // Obs: iTotalRecordes o "i" é referente a information. aaData o "a" é referente a Ajax
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => intval($totalRecords),
            "iTotalDisplayRecords" => intval($totalRecordswithFilter),
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }    

    

}
