<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AtividadeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Obra;
use App\Models\User;
use App\Models\Atividade;
use App\Models\Estatu;
use Exception;

class AtividadeController extends Controller
{
    public function index()
    {
        // Ref.: https://kinsta.com/pt/blog/relacoes-eloquent-laravel/?utm_source=pocket_shared
        //       $employee = Employee::find(1)->roles()->orderBy('name')->where('name', 'admin')->get();

        // Recupera o usuário autenticado
        $user = User::find(Auth::user()->id);

        // Recupera todas as obras do usuário autenticado, através do relacionamento ManyToMany tando em obras quanto em usuarios
        $obras = $user->obras()->orderBy('id')->where('ativo', '=', '1')->paginate(10);

        return view('admin.atividades.index', ['user' => $user, 'obras' => $obras]);
    }

    public function create(Obra $obra)
    {
        return view('admin.atividades.create', ['obra' => $obra]);
    }

    public function store(AtividadeRequest $request)
    {
        // Validar o formulário
        $request->validated();

        try {
            // Gravar dados no banco
            Atividade::create([
                'user_id' => $request->user_hidden,
                'obra_id' => $request->obra_hidden,
                'data_registro' => $request->data_registro,
                'registro' => $request->registro,
                'progresso' => $request->progresso,
                'obraconcluida' => $request->obraconcluida,
                'observacao' => $request->observacao,
            ]);

            // Recuperando a Obra, cujo, "estatus" deverá ser atualizado com base no valor do campo "progresso"
            // $obra = Obra::where('id', '=', intval($request->obra_hidden))->first();
            $obra = Obra::where('id', '=', $request->obra_hidden)->first();

            // Recupera o valor máximo do campo progresso no banco, para definir o estatu da obra com base no valor máximo retornado.
            $valorprogressomaximo = DB::table('atividades')->where('obra_id', '=', $request->obra_hidden)->max('progresso');

            // Resgatando todos os Estatus cujo tipo seja do tipo progressivo
            $estatusprogressivos = Estatu::where('tipo', '=', 'progressivo')->get();

            foreach($estatusprogressivos as $estatu){
                // Obs: intval(), transforma a string retornada em "$request->progresso" em um número inteiro, para que o mesmo seja comparado com os
                // valores inteiros $estatu->valormin e $estatu->valormax.
                // if((intval($request->progresso) >= $estatu->valormin) && (intval($request->progresso) <= $estatu->valormax)){
                if(($valorprogressomaximo >= $estatu->valormin) && ($valorprogressomaximo <= $estatu->valormax)){
                    $obra->update([
                        'estatu_id' => $estatu->id
                    ]);
                }
            }

            // Se o operador determinar que  obra está concluída após definir o "progresso" como sendo igual a 100, atribui o estatu de obra = 3(concluída)
            if($request->obraconcluida == 1){
                $obra->update([
                    'estatu_id' => 3 // Estatu com id = 3 é a obra concluida.
                ]);
            }

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('atividade.indexregistros', ['obra' => $obra->id])->with('success', 'Atividade registrada com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Atividade não registrada!');
        }
    }


    public function edit(Atividade $atividade)
    {
        // Recuperando a Obra da atividade. first(), porque só existem uma obra por atividade, se fosse mais de uma seria get()
        $obra = $atividade->obra()->first();

        return view('admin.atividades.edit', ['obra' => $obra, 'atividade' => $atividade]);
    }


    public function update(AtividadeRequest $request, Atividade $atividade)
    {
        // Validar o formulário
        $request->validated();

        try {
            // Gravar dados no banco
            $atividade->update([
                'user_id' => $request->user_hidden,
                'obra_id' => $request->obra_hidden,
                'data_registro' => $request->data_registro,
                'registro' => $request->registro,
                'progresso' => $request->progresso,
                'obraconcluida' => $request->obraconcluida,
                'observacao' => $request->observacao,
            ]);

            // Recupera o valor máximo do campo progresso no banco, para definir o estatu da obra com base no valor máximo.
            $valorprogressomaximo = DB::table('atividades')->where('obra_id', '=', $request->obra_hidden)->max('progresso');
            

            // Recuperando a Obra, cujo, "estatus" deverá ser atualizado com base no valor do campo "progresso"
            // $obra = Obra::where('id', '=', intval($request->obra_hidden))->first();
            $obra = Obra::where('id', '=', $request->obra_hidden)->first();

            // Resgatando todos os Estatus cujo tipo seja do tipo progressivo
            $estatusprogressivos = Estatu::where('tipo', '=', 'progressivo')->get();

            foreach($estatusprogressivos as $estatu){
                // Obs: intval(), transforma a string retornada em "$request->progresso" em um número inteiro, para que o mesmo seja comparado com os
                // valores inteiros $estatu->valormin e $estatu->valormax.
                // if((intval($request->progresso) >= $estatu->valormin) && (intval($request->progresso) <= $estatu->valormax)){
                if(($valorprogressomaximo >= $estatu->valormin) && ($valorprogressomaximo <= $estatu->valormax)){
                    $obra->update([
                        'estatu_id' => $estatu->id
                    ]);
                }
            }

            // Se o operador determinar que  obra está concluída após definir o "progresso" como sendo igual a 100, atribui o estatu de obra = 3(concluída)
            if($request->obraconcluida == 1){
                $obra->update([
                    'estatu_id' => 3 // Estatu com id = 3 é a obra concluida.
                ]);
            }

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('atividade.indexregistros', ['obra' => $obra->id])->with('success', 'Atividade editada com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Atividade não editada!');
        }
    }



    public function indexregistros(Obra $obra)
    {
        // Recupera todas as atividades da obra do funcionário autenticado, evitando que um funcionário leia, edit ou exclua as atividades de outro usuário, mesmo que os dois pertençam a mesma obra.
        $atividades = Atividade::where('obra_id', '=', $obra->id)->where('user_id', '=', Auth::user()->id)->orderByDesc('data_registro')->get();
        //$atividades = Atividade::where('obra_id', '=', $obra->id)->where('user_id', '=', Auth::user()->id)-where('created_at', '<', )->orderByDesc('data_registro')->get();

        return view('admin.atividades.indexregistros', ['obra' => $obra, 'atividades' => $atividades]);
    }


    // Excluir o municipio do banco de dados
    public function destroy(Atividade $atividade)
    {
        // Recuperando de forma indireta, a obra que possui a atividade que será deletada.
        // $atividadeatual =  Atividade::find($atividade->id); $obra = $atividadeatual->obra()->first();

        // Recuperando de forma direta, a obra que possui a atividade que será deletada. A recuperação deve ser feita antes da exclusão da atividade.
        $obra = $atividade->obra()->first();
        
        
        try {
            // Excluir o registro do banco de dados
            $atividade->delete();

            // Verifica se a obra não possui registros de atividades cadastradas, para configuar seu "status" para 1(criada)
            if($obra->atividades->count() == 0){
                $obra->update([
                    'estatu_id' => 1    // Estatu 1 = criada
                ]);
            }else{
                // Verifica o último progresso cadastrado após excluir a atividade para preservar o "estatus" correto.
                // Recupera o últimom progresso da atividade anterior a atividade que foi excluída, para manter a cor do status atualizaa conforme o número do progresso.
                // $ultimo_progressocadastrado =  $obra->ultimoprogresso($obra->id);

                // Recupera o valor máximo do campo progresso no banco, para definir o estatu da obra com base no valor máximo.
                $valorprogressomaximo = DB::table('atividades')->where('obra_id', '=', $obra->id)->max('progresso');
                
                // Resgatando todos os Estatus cujo tipo seja do tipo progressivo
                $estatusprogressivos = Estatu::where('tipo', '=', 'progressivo')->get();

                foreach($estatusprogressivos as $estatu){
                    
                    // if(($ultimo_progressocadastrado >= $estatu->valormin) && ($ultimo_progressocadastrado <= $estatu->valormax)){
                    if(($valorprogressomaximo >= $estatu->valormin) && ($valorprogressomaximo <= $estatu->valormax)){
                        $obra->update([
                            'estatu_id' => $estatu->id
                        ]);
                    }
                }
            }

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('atividade.indexregistros', ['obra' => $obra->id])->with('success', 'Atividae excluída com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('atividade.index')->with('error', 'Atividade não excluída!');
        }
    }


    public function relpdfatividade(Obra $obra)
    {
        // Obtendo os dados
        $obra = Obra::findOrFail($obra->id);

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Atividades_lista.pdf');

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
                    <td style="width: 377px; font-size: 12px;" class="titulo-rel">
                        REGISTRO DE ATIVIDADES <br>'.$obra->tipoobra->nome.' '.$obra->escola->nome.'
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
        $html = \View::make('admin.atividades.pdfs.pdf_atividades', compact('obra'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.users.pdfs.pdf_users')
        $stylesheet = file_get_contents('css/pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');  // Exibe o arquivo no browse   || $mpdf->Output($fileName, 'F');  Gera o arquivo na pasta pública

    }    

}
