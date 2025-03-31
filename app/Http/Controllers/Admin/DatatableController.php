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


    /* public function store(UserRequest $request)
    {
        // Validar o formulário
        $request->validated();

        try {
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



            // ENVIO DE EMAIL DIRETAMENTE
            // Dados que serão enviados ao construtor da classe EmailAcesso
            $dados = [
                'nome' => $request->nomecompleto,
                'email' => $request->email,
                'senha' => $request->password,
                'perfil' => ($request->perfil == "adm" ? "Administrador" : ($request->perfil == "con" ? "Consultor" : "Operador"))
            ];

            $envioEmail = Mail::to($request->email, $request->nome)->send(new EmailAcesso($dados));

            if($envioEmail){
                // Redirecionar o usuário, enviar a mensagem de sucesso
                return redirect()->route('user.index')->with('success', 'Usuário cadastrado com sucesso!');
            } else {
                // Redirecionar o usuário, enviar a mensagem de sucesso
                return redirect()->route('user.index')->with('success', 'Usuário cadastrado com sucesso, mas houve falha no envio do E-mail!');
            }


            // ENVIO DE EMAIL INDIRETAMENTE, VIA FILA (Passando o Id do Usuário e sua senha não criptografada)
            // JobSendEmailAcesso::dispatch($user->id, $request->password)->onQueue('default');
            // Redirecionar o usuário, enviar a mensagem de sucesso
            // return redirect()->route('user.index')->with('success', 'Usuário cadastrado com sucesso!');

        } catch (Exception $e) {
            // Mantém o usuário na mesma página(back), juntamente com os dados digitados(withInput) e enviando a mensagem correspondente.
            return back()->withInput()->with('error-exception', 'Usuário não cadastrado. Tente mais tarde!'. $e->getMessage());
        }
    }
    */

    public function store(UserRequest $request)
    {
        // Validar o formulário
        $dados_validados = $request->validated();

        if(!$dados_validados){
            return response()->json([
                'status' => 400,
                'errors' => $dados_validados->messages()
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
                'errors' => "Usuário cadastrado com sucesso!"
            ]);

        }
    }

}


