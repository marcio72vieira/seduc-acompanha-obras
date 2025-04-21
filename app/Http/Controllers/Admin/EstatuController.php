<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estatu;
use App\Http\Requests\EstatuRequest;
use Exception;
use Illuminate\Support\Str;

class EstatuController extends Controller
{
    public function index()
    {
        $estatus = Estatu::orderBy('valormin')->paginate(10);
        return view('admin.estatus.index', ['estatus' => $estatus]);
    }


    public function create()
    {
        return view('admin.estatus.create');
    }


    public function store(EstatuRequest $request)
    {
        // Validar o formulário
        $request->validated();

        try {

            Estatu::create([
                'nome' => Str::upper($request->nome),
                'valormin' => $request->valormin,
                'valormax' => $request->valormax,
                'cor' => $request->cor,
                'ativo' => $request->ativo,
            ]);

             // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('estatu.index')->with('success', 'Estatus cadastrado com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Estatus não cadastrado!');
        }
    }


    // Carregar o formulário editar unidade de atendimento
    public function edit(Estatu $estatu)
    {
        return view('admin.estatus.edit', ['estatu' => $estatu]);
    }

    // Atualizar no banco de dados a escola
    public function update(EstatuRequest $request, Estatu $estatu)
    {
        // Validar o formulário
        $request->validated();

        try{
            $estatu->update([
                'nome' => Str::upper($request->nome),
                'valormin' => $request->valormin,
                'valormax' => $request->valormax,
                'cor' => $request->cor,
                'ativo' => $request->ativo,
            ]);

            return  redirect()->route('estatu.index')->with('success', 'Estatus editado com sucesso!');

        } catch(Exception $e) {

            // Mantém o usuário na mesma página(back), juntamente com os dados digitados(withInput) e enviando a mensagem correspondente.
            return back()->withInput()->with('error-exception', 'Estatus não editado. Tente mais tarde!');

        }

    }


    // Excluir o estatus do banco de dados
    public function destroy(Estatu $estatu)
    {
        try {
            // Excluir o registro do banco de dados
            $estatu->delete();

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('estatu.index')->with('success', 'EstatuS excluído com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('estatu.index')->with('error-exception', 'Estatus não excluido. Tente mais tarde!');
        }
    }

    



}
