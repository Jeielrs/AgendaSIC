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
        $tecnicos = Tecnico::orderby('name', 'asc')->paginate(); //busca com paginação
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

    public function insert(Request $request)
    {   #o que vem da request é atribuido na classe tecnico
        $tecnico = new Tecnico();
        $tecnico->name = $request->nome;
        $tecnico->birth = $request->nascimento;
        $tecnico->rg = $request->rg;
        $tecnico->cpf = $request->cpf;
        $tecnico->cnh = $request->cnh;
        $tecnico->ctps = $request->ctps;
        $tecnico->phone = $request->telefone;
        $tecnico->validity_aso = $request->validade_aso;
        $tecnico->validity_epi = $request->validade_epi;
        $tecnico->validity_nr10 = $request->validade_nr10;
        $tecnico->validity_nr11 = $request->validade_nr11;
        $tecnico->validity_nr35 = $request->validade_nr35;
        $tecnico->situation = $request->situacao;
        $tecnico->obs = $request->obs;
        $tecnico->save();
        return redirect()->route('tecnicos');
    }

    public function show($id)
    {
        @session_start();
        return view('tecnicos.manager.show', ['id'=> $id]);
    }

    public function edit($id)
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

    public function delete($id)
    {
        
    }

    public function destroy($id)
    {
        //
    }
}
