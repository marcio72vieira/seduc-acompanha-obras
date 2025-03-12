<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    public function index()
    {
        // Recuperando usuários
        $users = User::orderBy('nome')->paginate(10);
        return view('admin.users.index', [ 'users' => $users ]);
    }


    public function create()
    {
        return view('admin.users.create');
    }


    public function store(UserRequest $request)
    {
        // Validar o formulário
        $request->validated();

        try {
            // Cadastrar no banco de dados na tabela usuários
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

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('user.index')->with('success', 'Usuário cadastrado com sucesso!');

        } catch (Exception $e) {
            // Mantém o usuário na mesma página(back), juntamente com os dados digitados(withInput) e enviando a mensagem correspondente.
            return back()->withInput()->with('error-exception', 'Usuário não cadastrado. Tente mais tarde!'. $e->getMessage());
        }
    }


    // Excluir o usuário do banco de dados
    public function destroy(User $user)
    {
        try {
            // Excluir o registro do banco de dados
            $user->delete();

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('user.index')->with('success', 'Usuário excluído com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('user.index')->with('error-exception', 'Usuário não excluído. Tente mais tarde!');
        }
    }

}
