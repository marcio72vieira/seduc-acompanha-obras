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

            // Resgatando todos os Estatus cujo tipo seja do tipo progressivo
            $estatusprogressivos = Estatu::where('tipo', '=', 'progressivo')->get();

            foreach($estatusprogressivos as $estatu){
                // Obs: intval(), transforma a string retornada em "$request->progresso" em um número inteiro, para que o mesmo seja comparado com os
                // valores inteiros $estatu->valormin e $estatu->valormax.
                if((intval($request->progresso) >= $estatu->valormin) && (intval($request->progresso) <= $estatu->valormax)){
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
            return redirect()->route('atividade.index')->with('success', 'Atividade registrada com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Atividade não registrada!');
        }
    }

    public function indexregistros(Obra $obra)
    {
        // Recupera todas as atividades da obra do funcionário autenticado, evitando que um funcionário leia, edit ou exclua as atividades de outro usuário, mesmo que os dois pertençam a mesma obra.
        $atividades = Atividade::where('obra_id', '=', $obra->id)->where('user_id', '=', Auth::user()->id)->orderByDesc('data_registro')->get();

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
                $ultimo_progressocadastrado =  $obra->ultimoprogresso($obra->id);
                
                // Resgatando todos os Estatus cujo tipo seja do tipo progressivo
                $estatusprogressivos = Estatu::where('tipo', '=', 'progressivo')->get();

                foreach($estatusprogressivos as $estatu){
                    
                    if(($ultimo_progressocadastrado >= $estatu->valormin) && ($ultimo_progressocadastrado <= $estatu->valormax)){
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

}
