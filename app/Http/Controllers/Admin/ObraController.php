<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ObraRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Escola;
use App\Models\Obra;
use App\Models\Objeto;
use Exception;


class ObraController extends Controller
{
    public function index()
    {
        //$obras = Obra::with(['regional', 'municipio', 'escola', 'objeto'])->orderBy('descricao')->paginate(10);
        //$obras = Obra::with(['regional:nome', 'municipio:nome', 'escola:nome'])->orderBy('data_inicio')->paginate(10);
        $obras = Obra::with(['regional', 'municipio', 'escola'])->orderBy('data_inicio')->paginate(10);

        return view('admin.obras.index', ['obras' => $obras]);
    }

    public function create()
    {
        $escolas = Escola::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $objetos = Objeto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        return view('admin.obras.create', ['escolas' => $escolas, 'objetos' => $objetos]);
    }


    public function store(ObraRequest $request)
    {
        // Validar o formulário
        $request->validated();


        // Marcar o ponto inicial de uma transação
        DB::beginTransaction();

        try {

            // Obtém o id da Regional através do relacionamento existente entre escola e regional
            $idRegionalObra = Escola::find($request->escola_id)->regional->id;

            // Obtém o id do Municipio através do relacionamento existente entre escola e municipio
            $idMunicipioObra = Escola::find($request->escola_id)->municipio->id;

            $obra = Obra::create([
                'descricao' => $request->descricao,
                'escola_id' => $request->escola_id,
                'regional_id' => $idRegionalObra,
                'municipio_id' => $idMunicipioObra,
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim,
                'estatus' => 1,     // Obra criada/cadastrada
                'ativo' => $request->ativo,
            ]);

            if($request->has('objetos')){
                $obra->objetos()->sync($request->objetos);
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
        $escolas = Escola::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $objetos = Objeto::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        return view('admin.obras.edit', ['obra' => $obra, 'escolas' => $escolas, 'objetos' => $objetos]);

    }





    public function update(ObraRequest $request, Obra $obra)
    {
        // Validar o formulário
        $request->validated();


        // Marcar o ponto inicial de uma transação
        DB::beginTransaction();

        try {

            // Obtém o id da Regional através do relacionamento existente entre escola e regional
            $idRegionalObra = Escola::find($request->escola_id)->regional->id;

            // Obtém o id do Municipio através do relacionamento existente entre escola e municipio
            $idMunicipioObra = Escola::find($request->escola_id)->municipio->id;

            $obra->update([
                'descricao' => $request->descricao,
                'escola_id' => $request->escola_id,
                'regional_id' => $idRegionalObra,
                'municipio_id' => $idMunicipioObra,
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim,
                'estatus' => 1,     // Obra criada/cadastrada
                'ativo' => $request->ativo,
            ]);

            if($request->has('objetos')){
                $obra->objetos()->sync($request->objetos);
            }

            DB::commit();

             // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('obra.index')->with('success', 'Obra editada com sucesso!');

        } catch (Exception $e) {

            // Operação não é concluiída com êxito
            DB::rollBack();

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Obra não editada!');
        }
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

}

