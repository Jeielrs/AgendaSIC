<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        session_start();
        $clientes = Cliente::paginate(); //busca com paginação
        if($_SESSION['nivel'] == 'admin'){
            return view('clientes.admin.index', ['clientes'=> $clientes]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('clientes.manager.index', ['clientes'=> $clientes]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('clientes.user.index', ['clientes'=> $clientes]);
        }
    }

    /**
     * Abre a Tela de Sincronização.
     *
     * @return \Illuminate\Http\Response
     */
    public function synchronize()
    {
        session_start();
        $clientes = Cliente::all(); //busca com paginação
        if($_SESSION['nivel'] == 'admin'){
            return view('clientes.admin.synchronize', ['clientes'=> $clientes]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('clientes.manager.synchronize', ['clientes'=> $clientes]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('clientes.user.synchronize', ['clientes'=> $clientes]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
