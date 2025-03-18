<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserPerfilRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Mail\EmailAcesso;
use Illuminate\Support\Facades\Mail;

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

            // Redirecionar o usuário, enviar a mensagem de sucesso
            // return redirect()->route('user.index')->with('success', 'Usuário cadastrado com sucesso!');

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


    public function relpdflistusers()
    {
        // Obtendo os dados
        $users = User::orderBy('nomecompleto')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Usuarios_lista.pdf');

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
                        USUÁRIOS
                    </td>
                </tr>
            </table>
            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td width="40px" class="col-header-table">ID</td>
                    <td width="275px" class="col-header-table">NOME</td>
                    <td width="100px" class="col-header-table">PERFIL</td>
                    <td width="315px" class="col-header-table">CAGO</td>
                    <td width="200px" class="col-header-table">E-mal</td>
                    <td width="100px" class="col-header-table">Telefone</td>
                    <td width="50px" class="col-header-table">ATIVO</td>
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
        $html = \View::make('admin.users.pdfs.pdf_list_users', compact('users'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.users.pdfs.pdf_users')
        $stylesheet = file_get_contents('css/pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');
    }


}
