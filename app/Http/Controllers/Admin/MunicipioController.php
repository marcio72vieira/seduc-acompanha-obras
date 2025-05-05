<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MunicipioRequest;
use App\Models\Municipio;
use App\Models\Regional;
use Exception;
use Illuminate\Support\Str;

class MunicipioController extends Controller
{
    public function index()
    {
        // Recuperar os registros do banco dados sem pesquisa
        // $municipios = Municipio::orderByDesc('created_at')->paginate(10);

        $municipios = Municipio::with('regional')->orderByDesc('created_at')->paginate(10);
        return view('admin.municipios.index', ['municipios' => $municipios]);

    }


    public function escolasmunicipio(Municipio $municipio)
    {
        $municipio = Municipio::findOrFail($municipio->id);

        //$escolas = Municipio::where('regional_id', '=', $regional->id)->paginate(10);
        $escolas = $municipio->escolas()->orderBy('nome')->paginate(10);

        return view('admin.municipios.escolasmunicipio', ['municipio' => $municipio, 'escolas' => $escolas]);

    }


    public function obrasmunicipio(Municipio $municipio)
    {
        $municipio = Municipio::findOrFail($municipio->id);

        $obras = $municipio->obrasdomunicipio()->orderBy('id')->paginate(10);

        return view('admin.municipios.obrasmunicipio', ['municipio' => $municipio, 'obras' => $obras]);

    }




    public function create()
    {
        $regionais = Regional::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        return view('admin.municipios.create', ['regionais' => $regionais]);
    }


    public function store(MunicipioRequest $request)
    {
        // Validar o formulário
        $request->validated();

        try {

            // Gravar dados no banco
            // Municipio::create($request->all());
            Municipio::create([
                'nome' => Str::upper($request->nome),
                'ativo' => $request->ativo,
                'regional_id' => $request->regional_id,
            ]);

             // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('municipio.index')->with('success', 'Municipio cadastrado com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Município não cadastrado!');
        }
    }


    // Carregar o formulário editar municipio
    public function edit(Municipio $municipio)
    {
        // carregar a view
        $regionais = Regional::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        return view('admin.municipios.edit', ['regionais' => $regionais, 'municipio' => $municipio]);
    }

    // Atualizar no banco de dados a regional
    public function update(MunicipioRequest $request, Municipio $municipio)
    {
        // Validar o formulário
        $request->validated();

        try{
            $municipio->update([
                'nome' => Str::upper($request->nome),
                'ativo' => $request->ativo,
                'regional_id' => $request->regional_id,
            ]);

            return  redirect()->route('municipio.index')->with('success', 'Municipio editado com sucesso!');

        } catch(Exception $e) {

            // Mantém o usuário na mesma página(back), juntamente com os dados digitados(withInput) e enviando a mensagem correspondente.
            return back()->withInput()->with('error', 'Municipio não editado. Tente outra vez!');

        }

    }


    // Excluir o municipio do banco de dados
    public function destroy(Municipio $municipio)
    {
        try {
            // Excluir o registro do banco de dados
            $municipio->delete();

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('municipio.index')->with('success', 'Municipio excluído com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('municipio.index')->with('error', 'Municipio não excluído!');
        }
    }


    public function relpdflistmunicipios()
    {
        // Obtendo os dados
        $municipios = Municipio::orderBy('nome')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Municipios_lista.pdf');

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
                        MUNICIPIOS
                    </td>
                </tr>
            </table>
            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td width="40px" class="col-header-table">ID</td>
                    <td width="540px" class="col-header-table">NOME</td>
                    <td width="250px" class="col-header-table">REGIONAL</td>
                    <td width="50px" class="col-header-table">ATIVO</td>
                    <td width="100px" class="col-header-table">ESCOLAS</td>
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
        $html = \View::make('admin.municipios.pdfs.pdf_list_municipios', compact('municipios'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.users.pdfs.pdf_users')
        $stylesheet = file_get_contents('css/pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');  // Exibe o arquivo no browse   || $mpdf->Output($fileName, 'F');  Gera o arquivo na pasta pública

    }


    public function relpdflistescolasmunicipio(Municipio $municipio)
    {
        // Obtendo os dados
        $municipio =  $municipio::findOrFail($municipio->id);

        // Obtendo as escolas através do relacionamento direto
        $escolas = $municipio->escolas()->orderBy('nome')->get();



        // Definindo o nome do arquivo a ser baixado
        $fileName = ('escolasmunicipio_'.$municipio->nome.'.pdf');

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
                        ESCOLAS DO MUNICÍPIO: '.$municipio->nome.'
                    </td>
                </tr>
            </table>
            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td width="40px" class="col-header-table">ID</td>
                    <td width="290px" class="col-header-table">NOME</td>
                    <td width="50px" class="col-header-table">ATIVO</td>
                    <td width="400px" class="col-header-table">ENDEREÇO</td>
                    <td width="100px" class="col-header-table">MUNICIPIO</td>
                    <td width="100px" class="col-header-table">REGIONAL</td>
                    <td width="100px" class="col-header-table">CADASTRADO</td>
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
        $html = \View::make('admin.municipios.pdfs.pdf_list_escolasmunicipio', compact('escolas'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.users.pdfs.pdf_users')
        $stylesheet = file_get_contents('css/pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');  // Exibe o arquivo no browse   || $mpdf->Output($fileName, 'F');  Gera o arquivo na pasta pública

    }

}
