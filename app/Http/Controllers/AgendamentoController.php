<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Padrao;
use App\Models\Servico;
use App\Models\Tecnico;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpParser\Node\Stmt\Echo_;

class AgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session_start();
        $clientes = Cliente::all();
        $tecnicos = Tecnico::all();
        $padroes = Padrao::all();
        $veiculos = Veiculo::all();
        if($_SESSION['nivel'] == 'admin'){
            return view('agendamentos.admin.create', ['clientes' => $clientes, 'tecnicos' => $tecnicos,'veiculos' => $veiculos, 'padroes' => $padroes]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('agendamentos.manager.create', ['clientes' => $clientes, 'tecnicos' => $tecnicos,'veiculos' => $veiculos, 'padroes' => $padroes]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('agendamentos.user.create', ['clientes' => $clientes, 'tecnicos' => $tecnicos,'veiculos' => $veiculos, 'padroes' => $padroes]);
        }
        
    }

    /**
     * Carrega listagem de serviços via Ajax.
     */
    public function loadservices(Request $request)
    {
        $servicos = Servico::latest()->get();
        for ($i=1; $i <= $request->numitens; $i++) {
            echo
				'<div id="servico_'.$i.'">
                    <div class="row">
                        <div class="col-lg-10">
                            <label class="labelform mt-2 mb-0">'.$i.'º serviço: </label>
        		  	        <input type="search" name="servico_'.$i.'" id="servico_'.$i.'" list="itens_servicos" placeholder="Pesquisar serviços..." class="custom-select" required>
          			        <datalist id="itens_servicos">';
                                foreach ($servicos as $servico) {
                                    echo '<option value="'.$servico["id"].' | '.$servico["codigo_servico_omie"].' | '.$servico["descricao"].'"></option>';
                                }
            echo            '</datalist>
                        </div>
                        <div class="col-lg-2">
                            <label class="labelform mt-2 mb-0">Qtd: </label>
                            <input type="number" name="qtd_'.$servico['id'].'" min="0" value="1" class="form-control"  required>
                        </div>
                    </div>
                </div>';
        }
    }

    /**
     * Carrega listagem de técnicos via Ajax.
     */
    public function loadtecnicos(Request $request)
    {
        $tecnicos = Tecnico::latest()->get();
        for ($i=1; $i <= $request->numitens; $i++) {
            echo
				'<div id="tecnico_'.$i.'">
                    <label class="labelform mt-2 mb-0">'.$i.'º técnico: </label>
        		  	<input type="search" name="tecnico_'.$i.'" id="tecnico_'.$i.'" list="itens_tecnicos" placeholder="Pesquisar técnicos..." class="custom-select" required>
          			<datalist id="itens_tecnicos">';
                        foreach ($tecnicos as $tecnico) {
                            echo '<option value="'.$tecnico["id"].' | '.$tecnico["name"].'"></option>';
                        }
            echo    '</datalist>
                        </div>';
        }
    }

    /**
     * Carrega listagem de padrões via Ajax.
     */
    public function loadpadroes(Request $request)
    {
        $padroes = Padrao::latest()->get();
        for ($i=1; $i <= $request->numitens; $i++) {
            echo
				'<div id="padrao_'.$i.'">
                    <label class="labelform mt-2 mb-0">'.$i.'º padrão: </label>
        		  	<input type="search" name="padrao_'.$i.'" id="padrao_'.$i.'" list="itens_padroes" placeholder="Pesquisar padrões..." class="custom-select" required>
          			<datalist id="itens_padroes">';
                        foreach ($padroes as $padrao) {
                            echo '<option value="'.$padrao["id"].' | '.$padrao["tag"].' | '.$padrao["description"].'"></option>';
                        }
            echo    '</datalist>
                </div>';
        }
    }

    /**
     * Carrega listagem de padrões via Ajax.
     */
    public function loadveiculos(Request $request)
    {
        $veiculos = Veiculo::latest()->get();
        for ($i=1; $i <= $request->numitens; $i++) {
            echo
				'<div id="veiculo_'.$i.'">
                    <label class="labelform mt-2 mb-0">'.$i.'º veículo: </label>
        		  	<input type="search" name="veiculo_'.$i.'" id="veiculo_'.$i.'" list="itens_veiculos" placeholder="Pesquisar veículos..." class="custom-select" required>
          			<datalist id="itens_veiculos">';
                        foreach ($veiculos as $veiculo) {
                            echo '<option value="'.$veiculo["id"].' | '.$veiculo["vehicle_plate"].' | '.$veiculo["brand"].' | '.$veiculo["model"].'"></option>';
                        }
            echo    '</datalist>
                </div>';
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
