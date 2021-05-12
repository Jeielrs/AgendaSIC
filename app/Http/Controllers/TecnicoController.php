<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use Illuminate\Http\Request;

class TecnicoController extends Controller
{
    
    public function index()
    {
        @session_start();
        #$tecnicos = Tecnico::all(); //busca todos os registros da tabela
        $tecnicos = Tecnico::paginate(10000000000); //busca com paginação
        if($_SESSION['nivel'] == 'admin'){
            return view('tecnicos.admin.index', ['tecnicos' => $tecnicos]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('tecnicos.manager.index', ['tecnicos' => $tecnicos]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('tecnicos.user.index', ['tecnicos' => $tecnicos]);
        } 
    }

    public function create()
    {
        @session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('tecnicos.admin.create');
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('tecnicos.manager.create');
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('tecnicos.user.create');
        }    
    }

    public function show($id)
    {
        @session_start();
        return view('tecnicos.show');
    }

    public function edit()
    {
        @session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('tecnicos.admin.edit');
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('tecnicos.manager.edit');
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('tecnicos.user.edit');
        } 
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
