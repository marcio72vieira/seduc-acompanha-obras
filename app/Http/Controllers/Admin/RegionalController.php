<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegionalRequest;
use App\Models\Regional;
use App\Models\Municipio;
use Exception;
use Illuminate\Support\Str;

class RegionalController extends Controller
{

    public function index()
    {
        // Recuperar os registros do banco dados sem pesquisa
        $regionais = Regional::orderByDesc('created_at')->paginate(10);

        return view('admin.regionais.index', ['regionais' => $regionais]);
    }

    public function escolasregional(Regional $regional)
    {
        // Recupera a reginal, para que depois na view sejam recuperada as escolas da regional
        // $regional = Regional::findOrFail($regional->id);
        // return view('admin.regionais.index_regionaisescolas', ['regional' => $regional]);
        //
        // na view, para recuperar as escolas deve-se proceder como abaixo:
        // @forelse ($regional->escolasDaRegional as $escola)
        //    {{ $escola->nome }}
        // @endforelse
        
        $regional = Regional::findOrFail($regional->id);
        // $escolas = $regional->escolasDaRegional()->get();
        $escolas = $regional->escolasDaRegional()->paginate(10);
        return view('admin.regionais.escolasregional', ['regional' => $regional, 'escolas' => $escolas]);

    }


    public function municipiosregional(Regional $regional)
    {   
        $regional = Regional::findOrFail($regional->id);
     
        //$municipios = Municipio::where('regional_id', '=', $regional->id)->paginate(10);
        $municipios = $regional->municipios()->orderBy('nome')->paginate(10);

        return view('admin.regionais.municipiosregional', ['regional' => $regional, 'municipios' => $municipios]);

    }    


    public function create()
    {
        return view('admin.regionais.create');
    }


    public function store(RegionalRequest $request)
    {
        // Validar o formulário
        $request->validated();

        try {

            // Gravar dados no banco
            // Regional::create($request->all());
            Regional::create([
                'nome' => Str::upper($request->nome),
                'ativo' => $request->ativo
            ]);

             // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('regional.index')->with('success', 'Regional cadastrada com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Regional não cadastrada!');
        }
    }


    // Carregar o formulário editar regional
    public function edit(Regional $regional)
    {
        // carregar a view
        return view('admin.regionais.edit', ['regional' => $regional]);
    }

    // Atualizar no banco de dados a regional
    public function update(RegionalRequest $request, Regional $regional)
    {
        // Validar o formulário
        $request->validated();

        try{
            $regional->update([
                'nome' => Str::upper($request->nome),
                'ativo' => $request->ativo
            ]);

            return  redirect()->route('regional.index')->with('success', 'Regional editada com sucesso!');

        } catch(Exception $e) {

            // Mantém o usuário na mesma página(back), juntamente com os dados digitados(withInput) e enviando a mensagem correspondente.
            return back()->withInput()->with('error', 'Regional não editada. Tente outra vez!');

        }

    }


    // Excluir o regional do banco de dados
    public function destroy(Regional $regional)
    {
        try {
            // Excluir o registro do banco de dados
            $regional->delete();

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('regional.index')->with('success', 'Regional excluída com sucesso!');

        } catch (Exception $e) {


            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('regional.index')->with('error', 'Regional não excluída!');
        }
    }



    public function relpdflistregionais()
    {
        // Obtendo os dados
        $regionais = Regional::orderBy('nome')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Regionais_lista.pdf');

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
                        REGIONAIS
                    </td>
                </tr>
            </table>
            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td width="40px" class="col-header-table">ID</td>
                    <td width="690px" class="col-header-table">NOME</td>
                    <td width="50px" class="col-header-table">ATIVO</td>
                    <td width="100px" class="col-header-table">MUNICÍPIOS</td>
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
        $html = \View::make('admin.regionais.pdfs.pdf_list_regionais', compact('regionais'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.users.pdfs.pdf_users')
        $stylesheet = file_get_contents('css/pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');  // Exibe o arquivo no browse   || $mpdf->Output($fileName, 'F');  Gera o arquivo na pasta pública

    }


    public function relpdflistmunicipiosregional(Regional $regional)
    {
        // Obtendo os dados
        $regional =  $regional::findOrFail($regional->id);

        $municipios = $regional->municipios()->orderBy('nome')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('municipiosregional_'.$regional->nome.'.pdf');

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
                        MUNICÍPIOS DA REGIONAL: '.$regional->nome.'
                    </td>
                </tr>
            </table>
            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td width="40px" class="col-header-table">ID</td>
                    <td width="790px" class="col-header-table">NOME</td>
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
        $html = \View::make('admin.regionais.pdfs.pdf_list_municipiosregional', compact('municipios'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.users.pdfs.pdf_users')
        $stylesheet = file_get_contents('css/pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');  // Exibe o arquivo no browse   || $mpdf->Output($fileName, 'F');  Gera o arquivo na pasta pública

    }
    
    

    public function relpdflistescolasregional(Regional $regional)
    {
        // Obtendo os dados
        $regional =  $regional::findOrFail($regional->id);

        // Obtendo as escolas através do relacionamento direto
        // $escolas = $regional->escolas()->orderBy('nome')->get();

        // Obtendo as escolas através do relacionamento indireto(hasManyThrough)
        $escolas = $regional->escolasdaregional()->orderBy('nome')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('escolasregional_'.$regional->nome.'.pdf');

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
                        ESCOLAS DA REGIONAL: '.$regional->nome.'
                    </td>
                </tr>
            </table>
            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td width="40px" class="col-header-table">ID</td>
                    <td width="290px" class="col-header-table">NOME</td>
                    <td width="50px" class="col-header-table">ATIVO</td>
                    <td width="500px" class="col-header-table">ENDEREÇO</td>
                    <td width="100px" class="col-header-table">MUNICIPIO</td>
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
        $html = \View::make('admin.regionais.pdfs.pdf_list_escolasregional', compact('escolas'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.users.pdfs.pdf_users')
        $stylesheet = file_get_contents('css/pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');  // Exibe o arquivo no browse   || $mpdf->Output($fileName, 'F');  Gera o arquivo na pasta pública

    }    

}
