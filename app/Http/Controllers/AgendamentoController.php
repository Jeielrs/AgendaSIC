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
            return view('agendamentos.admin.create', ['clientes' => $clientes], ['tecnicos' => $tecnicos], ['veiculos' => $veiculos], ['padroes' => $padroes]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('agendamentos.manager.create', ['clientes' => $clientes], ['tecnicos' => $tecnicos], ['veiculos' => $veiculos], ['padroes' => $padroes]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('agendamentos.user.create', ['clientes' => $clientes], ['tecnicos' => $tecnicos], ['veiculos' => $veiculos], ['padroes' => $padroes]);
        }
        
    }

    /**
     * Sincroniza e envia dados via Ajax.
     */
    public function loadservices(Request $request)
    {
        $servicos = Servico::latest()->get();
        for ($i=1; $i <= $request->numitens; $i++) { 
            echo
				'<div id="servico_'.$i.'">
                    <div class="row">
                        <div class="col-lg-10">
                            <label class="labelform mt-2 mb-0">'.$i.'º Serviço: </label>
        		  	        <input type="search" name="servico_'.$i.'" id="servico_'.$i.'" list="servicos" placeholder="Pesquisar serviços..." class="custom-select" required>
          			        <datalist id="servicos">';
                                foreach ($servicos as $servico) {
                                    echo '<option value="' . $servico['codigo_servico_omie'] . ' - ' . $servico['descricao'] . '"></option>';
                                }
            echo            '</datalist>
                        </div>
                        <div class="col-lg-2">
                            <label class="labelform mt-2 mb-0">Quantidade: </label>
                            <input type="number" name="qtd_'.$servico['codigo_servico_omie'].'" min="0" value="1" class="form-control"  required>
                        </div>
                    </div>
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
