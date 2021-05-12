<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PadraoController extends Controller
{
    public function index()
    {
        session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('padroes.admin.index');
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('padroes.manager.index');
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('padroes.user.index');
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

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit()
    {
        session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('padroes.admin.edit');
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('padroes.manager.edit');
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('padroes.user.edit');
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
