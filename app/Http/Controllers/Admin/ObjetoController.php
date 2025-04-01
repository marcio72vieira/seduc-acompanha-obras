<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ObjetoRequest;
use App\Models\Objeto;
use Exception;
use Illuminate\Support\Str;

class ObjetoController extends Controller
{
    public function index()
    {
        // Recuperar os registros do banco dados sem pesquisa
        $objetos = Objeto::orderByDesc('created_at')->paginate(10);

        return view('admin.objetos.index', ['objetos' => $objetos]);
    }

    public function create()
    {
        return view('admin.objetos.create');
    }

    public function store(ObjetoRequest $request)
    {
        // Validar o formulário
        $request->validated();

        try {

            // Gravar dados no banco
            // Objeto::create($request->all());
            Objeto::create([
                'nome' => Str::upper($request->nome),
                'ativo' => $request->ativo
            ]);

             // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('objeto.index')->with('success', 'Objeto cadastrado com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Objeto não cadastrado!');
        }
    }



    // Carregar o formulário editar objeto
    public function edit(Objeto $objeto)
    {
        // carregar a view
        return view('admin.objetos.edit', ['objeto' => $objeto]);
    }

    // Atualizar no banco de dados o objeto
    public function update(ObjetoRequest $request, Objeto $objeto)
    {
        // Validar o formulário
        $request->validated();

        try{
            $objeto->update([
                'nome' => Str::upper($request->nome),
                'ativo' => $request->ativo
            ]);

            return  redirect()->route('objeto.index')->with('success', 'Objeto editado com sucesso!');

        } catch(Exception $e) {

            // Mantém o usuário na mesma página(back), juntamente com os dados digitados(withInput) e enviando a mensagem correspondente.
            return back()->withInput()->with('error', 'Objeto não editado. Tente outra vez!');

        }

    }



    // Excluir o objeto do banco de dados
    public function destroy(Objeto $objeto)
    {
        try {
            // Excluir o registro do banco de dados
            $objeto->delete();

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('objeto.index')->with('success', 'Objeto excluído com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('objeto.index')->with('error', 'Objeto não excluído!');
        }
    }


    public function relpdflistobjetos()
    {
        // Obtendo os dados
        $objetos = Objeto::orderBy('nome')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Objetos_lista.pdf');

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
                        OBJETOS
                    </td>
                </tr>
            </table>
            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td width="40px" class="col-header-table">ID</td>
                    <td width="890px" class="col-header-table">NOME</td>
                    <td width="50px" class="col-header-table">ATIVO</td>
                    <td width="100px" class="col-header-table">CADASTRO</td>
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
        $html = \View::make('admin.objetos.pdfs.pdf_list_objetos', compact('objetos'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.users.pdfs.pdf_users')
        $stylesheet = file_get_contents('css/pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');  // Exibe o arquivo no browse   || $mpdf->Output($fileName, 'F');  Gera o arquivo na pasta pública

    }

}
