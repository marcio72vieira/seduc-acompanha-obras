<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserPerfilRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

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


    public function show(User $user)
    {
        // Exibe os detalhes do usuário
        return view('admin.users.show', ['user' => $user]);

    }


    public function edit(User $user)
    {
        return view('admin.users.edit', [ 'user' => $user]);
    }


    // Atualizar no banco de dados o usuário
    public function update(UserRequest $request, User $user)
    {
        // Validar o formulário
        $request->validated();

        try{
            // Se a senha não foi alterada, mantém a senha antiga e preserva o tipo de acesso 0 ou 1(primeiro acesso)
            if($request->password == ''){
                $passwordUser = $request->old_password_hidden;
                $defAcesso = 0;
            }else{
                $passwordUser = bcrypt($request->password);
                $defAcesso = 1;
            }

            $user->update([
                'nomecompleto' => $request->nomecompleto,
                'nome' => $request->nome,
                'cpf' => $request->cpf,
                'cargo' => $request->cargo,
                'fone' => $request->fone,
                'perfil' => $request->perfil,
                'email' => $request->email,
                'password' => $passwordUser,
                'ativo' => $request->ativo,
                'primeiroacesso' => $defAcesso
            ]);

            return  redirect()->route('user.index')->with('success', 'Usuário editado com sucesso!');

        } catch(Exception $e) {

            // Mantém o usuário na mesma página(back), juntamente com os dados digitados(withInput) e enviando a mensagem correspondente.
            return back()->withInput()->with('error-exception', 'Usuário não editado. Tente mais tarde!'.$e);

        }
    }



    public function editprofile()
    {
        // Obtendo-se o usuário autenticado
        $user = Auth::user();

        return view('admin.users.profile', [ 'user' => $user]);
    }


    // Atualizar no banco de dados o usuário
    public function updateprofile(UserPerfilRequest $request, User $user)
    {

        // Validar o formulário
        $request->validated();

        try{
            // Se a senha não foi alterada, mantém a senha antiga e preserva o tipo de acesso 0 ou 1(primeiro acesso)
            if($request->password == ''){
                $passwordUser = $request->old_password_hidden;
                $defAcesso = 0;
            }else{
                $passwordUser = bcrypt($request->password);
                $defAcesso = 0;
            }

            $user->update([
                'nomecompleto' => $request->nomecompleto,
                'nome' => $request->nome,
                'cpf' => $request->cpf,
                'cargo' => $request->cargo,
                'fone' => $request->fone,
                'perfil' => $request->old_perfil_hidden,
                'email' => $request->email,
                'password' => $passwordUser,
                'ativo' => $request->old_ativo_hidden,
                'primeiroacesso' => $defAcesso
            ]);

            return  redirect()->route('user.editprofile', ['user' => $user->id])->with('success', 'Seu Perfil foi editado com sucesso!');

        } catch(Exception $e) {

            // Mantém o usuário na mesma página(back), juntamente com os dados digitados(withInput) e enviando a mensagem correspondente.
            return back()->withInput()->with('error-exception', 'Usuário não editado. Tente mais tarde!'.$e);

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
