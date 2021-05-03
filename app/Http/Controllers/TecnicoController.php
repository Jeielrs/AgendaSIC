<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use Illuminate\Http\Request;

class TecnicoController extends Controller
{
    
    public function index()
    {
        @session_start();
        //$tecnicos = Tecnico::all(); //busca todos os registros da tabela
        $tecnicos = Tecnico::paginate(15);
        return view('tecnicos.index', ['tecnicos' => $tecnicos]);
    }

    public function create()
    {
        @session_start();
        return view('tecnicos.create');
    }

    public function show($id)
    {
        @session_start();
        return view('tecnicos.show');
    }

    public function edit()
    {
        @session_start();
        return view('tecnicos.edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
