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
        $estatus = Estatu::orderBy('nome')->paginate(10);
        return view('admin.estatus.index', ['estatus' => $estatus]);
    }


    public function create()
    {
        return view('admin.estatus.create');
    }


    public function store(EstatuRequest $request)
    {

        //dd($request);

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



}
