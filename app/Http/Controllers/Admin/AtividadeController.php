<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Obra;
use App\Models\User;

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

        return view('admin.atividades.index', ['obras' => $obras]);
    }
}
