<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ObraRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tipoobra;
use App\Models\Municipio;
use App\Models\Escola;
use App\Models\Obra;
use App\Models\Objeto;
use App\Models\Estatu;
use App\Models\User;
use Exception;


class ObraController extends Controller
{
    public function index()
    {
        //$obras = Obra::with(['regional', 'municipio', 'escola', 'objeto'])->orderBy('descricao')->paginate(10);
        //$obras = Obra::with(['regional:nome', 'municipio:nome', 'escola:nome'])->orderBy('data_inicio')->paginate(10);
        #_$obras = Obra::with(['regional', 'municipio', 'escola'])->orderBy('data_inicio')->paginate(10);
        $obras = Obra::with(['escola'])->orderBy('data_inicio')->paginate(10);

        return view('admin.obras.index', ['obras' => $obras]);
    }

    public function create()
    {
        $tipoobras = Tipoobra::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $escolas = Escola::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $objetos = Objeto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $users = User::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        return view('admin.obras.create', ['tipoobras' => $tipoobras, 'municipios' => $municipios, 'escolas' => $escolas, 'objetos' => $objetos, 'users' => $users]);

    }


    public function ajaxescolasmunicipio(Request $request)
    {
        $condicoes = [
            ['municipio_id', '=', $request->municipio_id],
            ['ativo', '=', 1]
        ];

        $data['escolas'] = Escola::where($condicoes)->orderBy('nome', 'ASC')->get();
        return response()->json($data);
    }


    public function store(ObraRequest $request)
    {
        // Validar o formulário
        $request->validated();

        // Marcar o ponto inicial de uma transação
        DB::beginTransaction();

        try {

            // Obtém o id da Regional através do relacionamento existente entre escola e regional
            #_$idRegionalObra = Escola::find($request->escola_id)->regional->id;

            // Obtém o id do Municipio através do relacionamento existente entre escola e municipio
            // $idMunicipioObra = Escola::find($request->escola_id)->municipio->id;

            $obra = Obra::create([
                'tipoobra_id' => $request->tipoobra_id,
                'escola_id' => $request->escola_id,
                #_'regional_id' => $idRegionalObra,
                #_'municipio_id' => $request->municipio_id,          // 'municipio_id' => $idMunicipioObra,
                'estatu_id' => $request->ativo == 1 ? 1 : 2,       // Obra criada (padrão). Obs: Será um caso raro o administrador criar uma obra e inativá-la(ativo = 0), setando seu estatus para 2(parada). Mas o sistema contempla essa situação.
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim,
                'ativo' => $request->ativo,
                'descricao' => $request->descricao,
            ]);

            if($request->has('objetos')){
                $obra->objetos()->sync($request->objetos);
            }

            if($request->has('users')){
                $obra->users()->sync($request->users);
            }

            DB::commit();

             // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('obra.index')->with('success', 'Obra cadastrada com sucesso!');

        } catch (Exception $e) {

            // Operação não é concluiída com êxito
            DB::rollBack();

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Obra não cadastrada!');
        }
    }


    public function edit(Obra $obra)
    {
        $tipoobras = Tipoobra::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $municipios = Municipio::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $escolas = Escola::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $objetos = Objeto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $users = User::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        return view('admin.obras.edit', ['tipoobras' => $tipoobras, 'municipios' => $municipios, 'obra' => $obra, 'escolas' => $escolas, 'objetos' => $objetos, 'users' => $users]);
    }


    public function update(ObraRequest $request, Obra $obra)
    {
        // Validar o formulário
        $request->validated();

        // Marcar o ponto inicial de uma transação
        DB::beginTransaction();

        try {

            // Obtém o id da Regional através do relacionamento existente entre escola e regional
            #_$idRegionalObra = Escola::find($request->escola_id)->regional->id;

            // Obtém o id do Municipio através do relacionamento existente entre escola e municipio
            // $idMunicipioObra = Escola::find($request->escola_id)->municipio->id;

            // Se a obra possui atividades, recupera o último progresso da atividade, e com base neste progresso, recupera o indicador de status pelo "id".
            // Caso contrário, define o  estatus_restaurado com o valor seu valor atual.
            if($obra->atividades->count() > 0){

                // Recuperando o estatu de acordo com o registro do último progresso, na situação da obra ser inativada e depois voltar a ser ativada novamente.
                // $ultimo_progressocadastrado =  $obra->ultimoprogresso($obra->id);
                //
                // Resgatando todos os Estatus cujo tipo seja do tipo progressivo
                // $estatusprogressivos = Estatu::where('tipo', '=', 'progressivo')->get();
                //
                // foreach($estatusprogressivos as $indicador){
                //     if(($ultimo_progressocadastrado >= $indicador->valormin) && ($ultimo_progressocadastrado <= $indicador->valormax)){
                //         $estatus_restaurado = $indicador->id;
                //     }
                // }

                // Recupera o valor máximo do campo progresso no banco, para definir o estatu da obra com base no valor máximo.
                $valorprogressomaximo = DB::table('atividades')->where('obra_id', '=', $obra->id)->max('progresso');

                // Resgatando todos os Estatus cujo tipo seja do tipo progressivo
                $estatusprogressivos = Estatu::where('tipo', '=', 'progressivo')->get();

                foreach($estatusprogressivos as $estatu){
                    if(($valorprogressomaximo >= $estatu->valormin) && ($valorprogressomaximo <= $estatu->valormax)){
                        // $obra->update([
                        //     'estatu_id' => $estatu->id
                        // ]);
                        $estatus_restaurado = $estatu->id;
                    }
                }

            }else{
                //$estatus_restaurado = $request->obra_estatus_hidden;
                $estatus_restaurado = 1;
            }


            $obra->update([
                'tipoobra_id' => $request->tipoobra_id,
                'escola_id' => $request->escola_id,
                #_'regional_id' => $idRegionalObra,
                #_'municipio_id' => $request->municipio_id,                       // 'municipio_id' => $idMunicipioObra,
                'estatu_id' => $request->ativo == 1 ? $estatus_restaurado : 2, // Se a obra for ativa(1), presenva o staus que possui, se for inativa(0) o estatus será 2("parada" assumindo a cor vermelha como padrão)
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim,
                'ativo' => $request->ativo,
                'descricao' => $request->descricao,
            ]);

            if($request->has('objetos')){
                $obra->objetos()->sync($request->objetos);
            }

            if($request->has('users')){
                $obra->users()->sync($request->users);
            }

            DB::commit();

             // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('obra.index')->with('success', 'Obra editada com sucesso!');

        } catch (Exception $e) {

            // Operação não é concluiída com êxito
            DB::rollBack();

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Obra não editada!'.$e->getMessage());
        }
    }



    public function show(Obra $obra)
    {
        // Exibe os detalhes da obra
        return view('admin.obras.show', ['obra' => $obra]);
    }



    // Excluir a obra do banco de dados
    public function destroy(Obra $obra)
    {
        try {
            // Excluir o registro do banco de dados
            $obra->delete();

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('obra.index')->with('success', 'Obra excluída com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('obra.index')->with('error', 'Obra não excluída!');
        }
    }




    public function relpdflistobras()
    {
        // Obtendo os dados
        $obras = Obra::orderBy('id')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Obras_lista.pdf');

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
                        OBRAS
                    </td>
                </tr>
            </table>
            <table style="width:1080px; border-collapse: collapse">
                <tr>
                    <td width="40px" class="col-header-table">ID</td>
                    <td width="180px" class="col-header-table">TIPO</td>
                    <td width="250px" class="col-header-table">ESCOLA</td>
                    <td width="150px" class="col-header-table">REGIONAL</td>
                    <td width="150px" class="col-header-table">MUNICÍPIO</td>
                    <td width="140px" class="col-header-table">DATAs DE INÍCIO E FIM</td>
                    <td width="170px" class="col-header-table">OBJETOS</td>
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
        $html = \View::make('admin.obras.pdfs.pdf_list_obras', compact('obras'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.users.pdfs.pdf_users')
        $stylesheet = file_get_contents('css/pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');  // Exibe o arquivo no browse   || $mpdf->Output($fileName, 'F');  Gera o arquivo na pasta pública

    }


    public function relpdfobra(Obra $obra)
    {
        // Obtendo os dados
        $obra = Obra::findOrFail($obra->id);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Obra_lista.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'P',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 25,
            'margin_bottom' => 10,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:717px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 140px text-align:left">
                        <img src="images/logo_seduc2.png" width="120"/>
                    </td>
                    <td style="width: 200px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Estado da Educação / SEDUC<br>
                        Agência de Tecnologia da Informação / ATI<br>
                        Acompanhamento de Execução de Obras
                    </td>
                    <td style="width: 377px;" class="titulo-rel">
                        OBRA: '.$obra->tipoobra->nome.'<br>'.$obra->escola->nome.'
                    </td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:717px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y}</td>
                    <td width="467px" align="center"></td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');

        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.obras.pdfs.pdf_obra', compact('obra'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.users.pdfs.pdf_users')
        $stylesheet = file_get_contents('css/pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');  // Exibe o arquivo no browse   || $mpdf->Output($fileName, 'F');  Gera o arquivo na pasta pública

    }



    public function relpdfobraatividade(Obra $obra)
    {
        // Obtendo os dados
        $obra = Obra::findOrFail($obra->id);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Obra_lista.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'orientation' => 'P',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 25,
            'margin_bottom' => 10,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:717px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 140px text-align:left">
                        <img src="images/logo_seduc2.png" width="120"/>
                    </td>
                    <td style="width: 200px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Estado da Educação / SEDUC<br>
                        Agência de Tecnologia da Informação / ATI<br>
                        Acompanhamento de Execução de Obras
                    </td>
                    <td style="width: 377px;" class="titulo-rel">
                        REGISTRO DE ATIVIDADES: '.$obra->tipoobra->nome.'<br>'.$obra->escola->nome.'
                    </td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:717px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="200px">São Luis(MA) {DATE d/m/Y}</td>
                    <td width="467px" align="center"></td>
                    <td width="50px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');

        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.obras.pdfs.pdf_obraatividade', compact('obra'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.users.pdfs.pdf_users')
        $stylesheet = file_get_contents('css/pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');  // Exibe o arquivo no browse   || $mpdf->Output($fileName, 'F');  Gera o arquivo na pasta pública

    }

}

