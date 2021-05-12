<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServicoController extends Controller
{
    public function index()
    {
        @session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('servicos.admin.index');
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('servicos.manager.index');
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('servicos.user.index');
        }
    }

    public function create()
    {
        session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('servicos.admin.create');
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('servicos.manager.create');
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('servicos.user.create');
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
            return view('servicos.admin.edit');
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('servicos.manager.edit');
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('servicos.user.edit');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
