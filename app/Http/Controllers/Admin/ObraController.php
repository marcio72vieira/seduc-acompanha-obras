<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obra;

class ObraController extends Controller
{
    public function index()
    {
        $obras = Obra::with(['regional', 'municipio', 'tipounidade', 'escola', 'objeto'])->orderBy('descricao')->paginate(10);
        return view('admin.obras.index', ['obras' => $obras]);
    }

    public function create()
    {
        return view('admin.obras.create');
    }
}
