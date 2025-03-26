<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EscolaRequest;
use Illuminate\Http\Request;
use App\Models\Municipio;
use App\Models\Escola;
use Exception;
use Illuminate\Support\Str;


class EscolaController extends Controller
{
    public function index()
    {
        $escolas = Escola::with(['regional', 'municipio'])->orderBy('nome')->paginate(10);
        return view('admin.escolas.index', ['escolas' => $escolas]);
    }

    public function create()
    {
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        return view('admin.escolas.create', [
            'municipios' => $municipios,
        ]);
    }

    public function store(EscolaRequest $request)
    {
        // Validar o formulário
        $request->validated();

        try {

            // Obtém o id da Regional através do relacionamento existente entre município e regional
            $idRegionalMunicipio = Municipio::find($request->municipio_id)->regional->id;

            Escola::create([
                'nome' => Str::upper($request->nome),
                'endereco' => $request->endereco,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'cep' => $request->cep,
                'fone' => $request->fone,
                'regional_id' => $idRegionalMunicipio,
                'municipio_id' => $request->municipio_id,
                'ativo' => $request->ativo,
            ]);

             // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('escola.index')->with('success', 'Escola cadastrada com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Escola não cadastrada!');
        }
    }


    // Carregar o formulário editar unidade de atendimento
    public function edit(Escola $escola)
    {
        // carregar a view
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        return view('admin.escolas.edit', ['escola' => $escola, 'municipios' => $municipios]);
    }

    // Atualizar no banco de dados a escola
    public function update(EscolaRequest $request, Escola $escola)
    {
        // Validar o formulário
        $request->validated();

        // Obtém o id da Regional através do relacionamento existente entre município e regional
        $idRegionalMunicipio = Municipio::find($request->municipio_id)->regional->id;

        try{
            $escola->update([
                'nome' => Str::upper($request->nome),
                'endereco' => $request->endereco,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'cep' => $request->cep,
                'fone' => $request->fone,
                'regional_id' => $idRegionalMunicipio,
                'municipio_id' => $request->municipio_id,
                'ativo' => $request->ativo,
            ]);

            return  redirect()->route('escola.index')->with('success', 'Escola editada com sucesso!');

        } catch(Exception $e) {

            // Mantém o usuário na mesma página(back), juntamente com os dados digitados(withInput) e enviando a mensagem correspondente.
            return back()->withInput()->with('error-exception', 'Escola não editada. Tente mais tarde!');

        }

    }

    public function show(Escola $escola)
    {
        // Exibe os detalhes da escola
        return view('admin.escolas.show', ['escola' => $escola]);

    }


    // Excluir a unidade de atendimento do banco de dados
    public function destroy(Escola $escola)
    {
        try {
            // Excluir o registro do banco de dados
            $escola->delete();

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('escola.index')->with('success', 'Escola excluída com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('escola.index')->with('error-exception', 'Escola não excluida. Tente mais tarde!');
        }
    }


    public function relpdflistescolas()
    {
        // Obtendo os dados
        $escolas = Escola::orderBy('nome')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Escolas_lista.pdf');

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
                        ESCOLAS
                    </td>
                </tr>
            </table>
            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td width="40px" class="col-header-table">ID</td>
                    <td width="300px" class="col-header-table">NOME</td>
                    <td width="290px" class="col-header-table">ENDEREÇO</td>
                    <td width="150px" class="col-header-table">REGIONAL</td>
                    <td width="150px" class="col-header-table">MUNICÍPIO</td>
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
        $html = \View::make('admin.escolas.pdfs.pdf_list_escolas', compact('escolas'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.users.pdfs.pdf_users')
        $stylesheet = file_get_contents('css/pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');  // Exibe o arquivo no browse   || $mpdf->Output($fileName, 'F');  Gera o arquivo na pasta pública

    }
    

}
