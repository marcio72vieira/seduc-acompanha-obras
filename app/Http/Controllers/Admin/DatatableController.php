<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;

class DatatableController extends Controller
{
    public function index()
    {
        return view('admin.datatables.index');
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


            // ações
            $acaoshow = "<button type='button'  id='btnVisualizarUsuario' data-idusuario=".$user->id." class='mb-1 btn btn-secondary btn-sm me-1' title='visualizar'  data-bs-toggle='modal' data-bs-target='#modalVisualizarUsuario'> <i class='fa-regular fa-eye'></i> visualizar </button>";
            $acaoedit = "<button type='button'  class='mb-1 btn btn-secondary btn-sm me-1' title='editar'> <i class='fa-solid fa-pen-to-square'></i> editar</button>";
            $acaodelete = $user->perfil == 'adm' ?  "<button type='button'  class='btn btn-outline-secondary btn-sm me-1 mb-1' title='apagar'> <i class='fa-solid fa-ban'></i> Apagar </button>" :
                                                    "<button type='button'  class='mb-1 btn btn-secondary btn-sm me-1' title='apagar'> <i class='fa-regular fa-trash-can'></i> Apagar";



            $acoes = $acaoshow." ".$acaoedit." ".$acaodelete;


            $data_arr[] = array(
                "id" => $id,
                "nomecompleto" => $nomecompleto,
                "cpf" => $cpf,
                "cargo" => $cargo,
                "perfil" => $perfil,
                "contato" => $contato,
                "acoes" => $acoes
            );
        }

        // Obs: iTotalRecordes o "i" é referente a information. aaData o "a" é referente a Ajax
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => intval($totalRecords),
            "iTotalDisplayRecords" => intval($totalRecordswithFilter),
            "aaData" => $data_arr
        );

        // echo json_encode($response); // exit;
        return response()->json($response);
    }


    public function store(UserRequest $request)
    {
        // Validar o formulário
        // Em requisições Ajax, caso a validação falhe, Laravel irá lança o código de erro 422(unproecessed entity)
        // naturalmente. Se a validação passar, o fluxo da execução do programa segue naturalmente.
        $request->validated();

        // Cadastrar no banco de dados na tabela usuários.
        User::create([
            'nomecompleto' => $request->nomecompleto,
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'cargo' => $request->cargo,
            'fone' => $request->fone,
            'perfil' => $request->perfil,
            'email' => $request->email,
            'password' => $request->password,
            'ativo' => $request->ativo,
            'primeiroacesso' => 1
        ]);

        return response()->json([
            'msg_sucesso' => "Usuário cadastrado com sucesso!"
        ]);

    }

    // Recupera o usuário pelo ID
    public function ajaxgetuser(User $user)
    {
        $user = User::findOrFail($user->id);

        return response()->json($user);
    }


    /*
    public function store(UserRequest $request)
    {
        // Validar o formulário
        $dados_validados = $request->validated();

        if(!$dados_validados){
        // if($dados_validados->fails()){
        // if(!$dados_validados->passes()){
            return response()->json([
                'status' => 400,
                'errors' => $dados_validados->messages()
                //'error' => $dados_validados->errors()->toArray()
            ]);
        } else {
            // Cadastrar no banco de dados na tabela usuários
            $user = User::create([
                'nomecompleto' => $request->nomecompleto,
                'nome' => $request->nome,
                'cpf' => $request->cpf,
                'cargo' => $request->cargo,
                'fone' => $request->fone,
                'perfil' => $request->perfil,
                'email' => $request->email,
                'password' => $request->password,
                'ativo' => $request->ativo,
                'primeiroacesso' => 1
            ]);

            return response()->json([
                'status' => 200,
                'msg' => "Usuário cadastrado com sucesso!"
            ]);

        }
    }
    */

}


