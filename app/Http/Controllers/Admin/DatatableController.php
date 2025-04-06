<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Validator;
use Exception;

class DatatableController extends Controller
{
    public function index()
    {
        return view('admin.datatables.index');
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


