<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LoginPrimeiroAcessoRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;


class LoginController extends Controller
{
    // Login
    public function index()
    {
        // Carregar a view
        return view('publico.login.index');
    }



    // Validar os dados do usuário no login
    public function processalogin(LoginRequest $request)
    {
        // Validar o formulário
        $request->validated();

        // Validar o usuário e a senha com as informações do banco de dados
        $authenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        // Se o usuário não foi autenticado (!), significa que os dados estão incorretos
        if(!$authenticated){

            // Redirecionar o usuário para página anterior "login(área restrita)", mantendo os dados digitados e enviar a mensagem de erro
            return back()->withInput()->with('error', 'E-mail ou senha inválidos!');
        }

        // Depois de autenticado, deve-se obter o usuário autenticado
        $user = Auth::user();
        $user = User::find($user->id);

        // Vefifica se o usuário autentica está inativo(0)
        if($user->ativo == 0){
            // Deslogar o usuário
            Auth::logout();

            // Redireciona o usuário para a página anterior.
            return back()->withInput()->with('error', 'Você está inativo!');
        }


        if($user->primeiroacesso == 1){

            // Redireciona o usuário para a página para alterar senha fornecida pelo administrador
            // Obs: Neste ponto, o usuário já estará autenticado no sistema mesmo que o mesmo seja direcionado para a página de
            // redefinir nova senha. Neste caso, deve-se, validar os dados do usuário buscando o email e nome do usuário e o id
            // e depois de o mesmo ter alterado sua senha, deve-se deslogá-lo e redirecioná-lo para a página de login novamente.
            return redirect()->route('login.create-primeiroacesso', ['user' => Auth::user()->id])->with('warning', 'Olá '. Auth::user()->nome .', é necessário que você redefina sua senha!');

        } else {

            // Redireciona o usuário conforme seu perfil
            if($user->perfil == "adm"){
                return redirect()->route('dashboard.index')->with('success', Auth::user()->nome .', Bem vindo!');
            }

            if($user->perfil == "con"){
                return redirect()->route('dashboard.index')->with('success', Auth::user()->nome .', Bem vindo!');
            }

            if($user->perfil == "ope"){
                return redirect()->route('atividade.index')->with('success', Auth::user()->nome .', Bem vindo!');
            }
        }

    }


    // Carregar o formulário recadastrar senha no caso do primeiro acesso
    public function createprimeiroacesso(User $user)
    {
        // Carregr a view
        return view('publico.login.primeiroacesso', ['user' => $user]);
    }


    public function store(LoginPrimeiroAcessoRequest $request)
    {
        // Validar o formulário
        $request->validated();

        // Recupera o usuário com o e-mail fornecido
        $user = User::where('email', $request->email)->first();

        // Verifica a existência do usuário
        if($user){
            // Recupera a senha cadastrada no banco
            $passwordDb = $user->password;
            // Checa se a senha atual digitada e a senha cadastrada no banco coincidem
            $passwordChecked = Hash::check($request->passwordatual, $passwordDb);

        } else {
            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'E-mail ou Senha atual não existente!');
        }

        if($passwordChecked){
            try {
                // Cadastrar no banco de dados na tabela usuários
                $user->update([
                    'password' => $request->password,
                    'primeiroacesso' => 0
                ]);

                // Verifica se o usuário já está autenticado no sistema.
                if (Auth::check()) {

                    // Deslogar o usuário
                    Auth::logout();

                    // Redirecionar o usuário, enviar a mensagem de sucesso
                    // return redirect()->route('login.logout')->with('success', 'Senha atualizada com sucesso!');
                    return redirect()->route('login.index')->with('success', 'Senha atualizada com sucesso! Efetue o login com a nova senha.');
                }

            } catch (Exception $e) {

                // Redirecionar o usuário, enviar a mensagem de erro
                return back()->withInput()->with('error', 'Senha não atualizada. Tente mais tarde!');
            }

        } else {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'E-mail ou Senha atual não existente!');
        }

    }


    // Deslogar o usuário
    public function logout()
    {
        // Deslogar o usuário
        Auth::logout();

        // Redireciona o usuário enviando a mensagem de sucesso
        return redirect()->route('login.index')->with('success', 'Deslogado com sucesso!');

    }


}
