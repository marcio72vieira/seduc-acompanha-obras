<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // Carregar o formulário recuperar senha
    public function showForgotPassword()
    {
        // Carregar a VIEW
        return view('publico.login.forgotPassword');
    }

    public function submitForgotPassword(Request $request)
    {
        // Validar o formulário
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Necessário enviar e-mail válido.',
        ]);

        // Verificar se existe usuário no banco de dados com o e-mail
        $user = User::where('email', $request->email)->first();

        // Verificar se encontrou o usuário. Se for diferente de 'true' significa que não encontrou o usuário no banco de dados
        if(!$user){

            // Salvar log
            Log::warning('Tentativa de recuperar senha com e-mail não cadastrado.', ['email' => $request->email]);

            // Redirecionar o usuário, enviando os dados digitados e a mensagem de erro
            return back()->withInput()->with('error', 'E-mail não enontrado!');
        }

        try{

            // Salvar o token recuperar senha e enviar e-mail. Obs: verificar se foi importada a classe: "use Illuminate\Support\Facades\Password" corretamente
            $status = Password::sendResetLink(
                $request->only('email')
            );

            // Salvar log
            Log::info('Recuperar senha.', ['status' => $status, 'email' => $request->email]);

            // Redirecionar o usuário, enviando os dados digitados e a mensagem de sucesso
            return redirect()->route('login.index')->with('success', 'Enviado e-mail com instruçõẽs para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!');

        } catch(Exception $e){

            // Salvar log
            Log::warning('Erro recuperar senha.', ['error' => $e->getMessage(), 'email' => $request->email]);

            // Redirecionar o usuário, enviando os dados digitados e a mensagem de erro
            return back()->withInput()->with('error', 'Tente mais tarde!');


        }

    }


    // Este método é invocado pelo link do botão "recuperar senha", que está contido no corpo do e-mail enviado ao usuário
    // que deseja recuperar sua senha. Exemplo: http://localhost:8080/reset-password/tokenf682fbf6610e...?email=marcio%40email.com.br
    // Carregar o formulário atualizar a senha
    public function showResetPassword(Request $request)
    {
        // Carregar a view
        return view('publico.login.resetPassword', ['token' => $request->token]);

    }


    public function submitResetPassword(Request $request)
    {
        // Validar os dados do formulário
        $request->validate([
            'email' => 'required|email|exists:users',   //exists;users = deve existir este email na tabela users
            'password' => 'required|min:6|confirmed',
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Necessário enviar e-mail válido.',
            'email.exists' => 'Este email não existe na base de dados.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'O campo senha deve ter no mínimo :min caracteres.',
            'password.confirmed' => 'O campo confirmar senha difere do campo senha.',
        ]);

        try {

            // Redefine a senha através do método 'reset'
            $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'),
                        function(User $user, string $password){
                            $user->forceFill([
                                'password' => Hash::make($password)
                            ]);
                            $user->save();
                        }
                      );

            // Salvar log
            Log::info('Senha atualizada.', ['resposta' => $status, 'email' => $request->email]);

            // Redirecionar o usuário, enviando os dados digitados e a mensagem de sucesso se na variável status existe PASSWORD_RESET indicando que tudo ocorreu bem
            return $status === Password::PASSWORD_RESET ?
                redirect()->route('login.index')->with('success', 'Senha atualizada com sucesso!') :
                redirect()->route('login.index')->with('error', __($status));



        } catch(Exception $e){

            // Salvar log
            Log::warning('Erro atualizar a senha.', ['error' => $e->getMessage(), 'email' => $request->email]);

            // Redirecionar o usuário, enviando os dados digitados e a mensagem de erro
            return back()->withInput()->with('error', 'Tente mais tarde!');

        }

    }


}
