<?php

namespace App\Http\Controllers;

use App\Models\Padrao;
use Illuminate\Http\Request;

class PadraoController extends Controller
{
    public function index()
    {
        session_start();
        $padroes = Padrao::paginate(); //busca com paginação
        if($_SESSION['nivel'] == 'admin'){
            return view('padroes.admin.index', ['padroes'=> $padroes]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('padroes.manager.index', ['padroes'=> $padroes]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('padroes.user.index', ['padroes'=> $padroes]);
        }
    }

    public function create()
    {
        session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('padroes.admin.create');
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('padroes.manager.create');
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('padroes.user.create');
        }
    }

    public function insert(Request $request){
        $padrao = new Padrao();
        $padrao->tag = $request->tag;
        $padrao->description = $request->descricao;
        $padrao->sector = $request->setor;
        $padrao->particularity = $request->particularidade;
        $padrao->calibration_frequency = $request->frequencia;
        $padrao->calibration_date = $request->data;
        $padrao->calibration_validity = $request->validade;
        $padrao->situation = $request->situacao;
        $padrao->obs = $request->obs;
        $padrao->save();
        return redirect()->route('padroes');
    }

    public function show($id)
    {
        session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('padroes.admin.show', ['id'=> $id]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('padroes.manager.show', ['id'=> $id]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('padroes.user.show', ['id'=> $id]);
        }
    }

    public function edit($id)
    {
        session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('padroes.admin.edit', ['id'=> $id]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('padroes.manager.edit', ['id'=> $id]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('padroes.user.edit', ['id'=> $id]);
        }
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function delete($id)
    {
        session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('padroes.admin.delete', ['id'=> $id]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('padroes.manager.delete', ['id'=> $id]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('padroes.user.delete', ['id'=> $id]);
        }
    }
}
