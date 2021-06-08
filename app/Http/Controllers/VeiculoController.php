<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    public function index()
    {
        session_start();

        $veiculos = Veiculo::paginate();

        if($_SESSION['nivel'] == 'admin'){
            return view('veiculos.admin.index', ['veiculos' => $veiculos]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('veiculos.manager.index', ['veiculos' => $veiculos]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('veiculos.user.index', ['veiculos' => $veiculos]);
        }
    }

    public function create()
    {
        session_start();

        $tecnicos = Tecnico::all();
        
        if($_SESSION['nivel'] == 'admin'){
            return view('veiculos.admin.create', ['tecnicos' => $tecnicos]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('veiculos.manager.create', ['tecnicos' => $tecnicos]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('veiculos.user.create', ['tecnicos' => $tecnicos]);
        }
    }

    public function insert(Request $request){

        #se for nulo recebe null, senão pega apenas o numero antes do hífen #ternária
        $num_usuario = is_null($request->usuario) ? null : (explode(" -", $request->usuario))[0];
        
        $veiculo = new Veiculo();        
        $veiculo->vehicle_plate = $request->placa;
        $veiculo->vehicle_user = $num_usuario;
        $veiculo->brand = $request->marca;
        $veiculo->model = $request->modelo;
        $veiculo->km = $request->km;
        $veiculo->situation = $request->situacao;
        $veiculo->owner = $request->proprietario;
        $veiculo->rent_date = $request->data_locacao;
        $veiculo->rental_term = $request->prazo_locacao;
        $veiculo->obs = $request->obs;
        
        $itens = $veiculo::where('vehicle_plate', '=', $request->placa)->count();
        if ($itens > 0) {
            echo "<script language='javascript'> window.alert('Já existe um veículo cadastrado com essa placa!') </script>";
            session_start();
            return view('veiculos.manager.create');
        }else {
            $veiculo->save();
            echo "<script language='javascript'> window.alert('Veículo cadastrado com sucesso!') </script>";
            session_start();
            return view('veiculos.manager.create');
        }
        
    }

    public function show($id)
    {
        //
    }

    public function edit()
    {
        session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('veiculos.admin.edit');
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('veiculos.manager.edit');
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('veiculos.user.edit');
        }
    }
    
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
