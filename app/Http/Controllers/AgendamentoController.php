<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAgendamentoRequest;
use App\Jobs\AtualizaStatusPadrao;
use App\Models\Agendamento;
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
        		  	        <input type="search" name="servico['.$i.']" id="servico_'.$i.'" list="itens_servicos" placeholder="Pesquisar serviços..." class="custom-select" required>
          			        <datalist id="itens_servicos">';
                                foreach ($servicos as $servico) {
                                    echo '<option value="'.$servico["id"].' | '.$servico["codigo_servico_omie"].' | '.$servico["descricao"].'"></option>';
                                }
            echo            '</datalist>
                        </div>
                        <div class="col-lg-2">
                            <label class="labelform mt-2 mb-0">Qtd: </label>
                            <input type="number" name="servico_qtd['.$i.']" min="0" value="1" class="form-control"  required>
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
        		  	<input type="search" name="tecnico['.$i.']" id="tecnico_'.$i.'" list="itens_tecnicos" placeholder="Pesquisar técnicos..." class="custom-select" required>
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
        		  	<input type="search" name="padrao['.$i.']" id="padrao_'.$i.'" list="itens_padroes" placeholder="Pesquisar padrões..." class="custom-select" required>
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
        		  	<input type="search" name="veiculo['.$i.']" id="veiculo_'.$i.'" list="itens_veiculos" placeholder="Pesquisar veículos..." class="custom-select" required>
          			<datalist id="itens_veiculos">';
                        foreach ($veiculos as $veiculo) {
                            echo '<option value="'.$veiculo["id"].' | '.$veiculo["vehicle_plate"].' | '.$veiculo["brand"].' | '.$veiculo["model"].'"></option>';
                        }
            echo    '</datalist>
                </div>';
        }
    }

    /**
     * cadastra um novo agendamento
     */
    public function insert(StoreAgendamentoRequest $request)
    {
        //dd($request->all());
        //exit();

        //Atribuição das váriáveis
        $tipo_servico = $request->tipo_servico;
        $tipo_contrato = $request->tipo_contrato;
        $compromisso = $request->compromisso;
        $integracao = $request->compromisso;
        $id_cliente = explode(" | ", $request->cliente)[0];
        $contato = $request->contato;
        $observacao = $request->observacao;
        $protocolo = $request->protocolo;
        $hospedagem = $request->hospedagem;
        $tipo_agendamento = $request->tipo_agendamento;
        $inicio = ($tipo_agendamento == "manual")?$request->inicio_manual:$request->inicio_recorrente;
        $fim = ($tipo_agendamento == "manual")?$request->fim_manual:$request->fim_recorrente;
        $horario_inicio = ($tipo_agendamento == "manual")?$request->horario_inicio_manual:$request->horario_inicio_recorrente;      
        $tempo_servico = ($tipo_agendamento == "manual")?$request->tempo_servico_manual:$request->tempo_servico_recorrente;
        $v = explode(':', $tempo_servico);
        $horario_fim = date('H:i', strtotime("{$horario_inicio} + {$v[0]} hours {$v[1]} minutes"));

        if ($tipo_agendamento == "recorrente") {
            if ($request->segunda = "segunda") {
                $dias_semana[] = ['segunda'];
            }
            if ($request->terca = "terca") {
                $dias_semana[] = ['terca'];
            }
            if ($request->quarta = "quarta") {
                $dias_semana[] = ['quarta'];
            }
            if ($request->quinta = "quinta") {
                $dias_semana[] = ['quinta'];
            }
            if ($request->sexta = "sexta") {
                $dias_semana[] = ['sexta'];
            }
            if ($request->sabado = "sabado") {
                $dias_semana[] = ['sabado'];
            }
            if ($request->domingo = "domingo") {
                $dias_semana[] = ['domingo'];
            }
        }

        dd($dias_semana);exit();

        $array_id_servicos = array();
        $array_qtd_servicos = array();
        if (is_null($request->numitens_servicos)) {
            $numitens_servicos = 0;
        } else {
            $numitens_servicos = $request->numitens_servicos;
            for ($i=1; $i <= $numitens_servicos; $i++) {
                $array_id_servicos[$i] =  explode(" | ", $request->servico[$i])[0];
                $array_qtd_servicos[$i] = $request->servico_qtd[$i];
            }
        }
        $array_id_tecnicos = array();
        if (is_null($request->numitens_tecnicos)) {
            $numitens_tecnicos = 0;
        } else {
            $numitens_tecnicos = $request->numitens_tecnicos;
            for ($i=1; $i <= $numitens_tecnicos; $i++) {
                $array_id_tecnicos[$i] =  explode(" | ", $request->tecnico[$i])[0];
            }
        }
        $array_id_padroes = array();
        if (is_null($request->numitens_padroes)) {
            $numitens_padroes = 0;
        } else {
            $numitens_padroes = $request->numitens_padroes;
            for ($i=1; $i <= $numitens_padroes; $i++) {
                $array_id_padroes[$i] =  explode(" | ", $request->padrao[$i])[0];
            }
        }
        $array_id_veiculos = array();
        if (is_null($request->numitens_veiculos)) {
            $numitens_veiculos = 0;
        } else {
            $numitens_veiculos = $request->numitens_veiculos;
            for ($i=1; $i <= $numitens_veiculos; $i++) {
                $array_id_veiculos[$i] =  explode(" | ", $request->veiculo[$i])[0];
            }
        }

        //Verificação dos itens para permissão
        //$tecnicos = Tecnico::where('situation', 'ativo')->get();
        //$tecnicos_ativos = array();
        //$i = 0;
        //foreach ($tecnicos as $key => $tecnico) {
        //    $tecnicos_ativos[$i] = $tecnico->id;
        //    $i++;
        //}
        //$padroes = Padrao::where('situation', 'ativo')->get();
        //$veiculos = Veiculo::where('situation', 'ativo')->get();

        //dd($tecnicos_ativos);exit();

        //Encaminhamento para variável do BD
        $agendamento = new Agendamento();
        $agendamento->inicio = $inicio;
        $agendamento->fim = $fim;
        $agendamento->tempo_servico = $tempo_servico;
        $agendamento->horario_inicio = $horario_inicio;
        $agendamento->horario_fim = $horario_fim;
        $agendamento->tipo_servico = $tipo_servico;
        $agendamento->tipo_contrato = $tipo_contrato;
        $agendamento->tipo_agendamento = $tipo_agendamento;
        $agendamento->compromisso = $compromisso;
        $agendamento->protocolo = $protocolo;
        $agendamento->integracao = $integracao;
        $agendamento->hospedagem = $hospedagem;
        $agendamento->contato = $contato;
        $agendamento->numitens_servicos = $numitens_servicos;

        if ($numitens_servicos > 0) {
            $agendamento->qtd_servicos = implode("|", $array_qtd_servicos);
            $agendamento->id_servico = implode("|", $array_id_servicos);
        }
        $agendamento->numitens_tecnicos = $numitens_tecnicos;
        if ($numitens_tecnicos > 0) {
            $agendamento->id_tecnico = implode("|", $array_id_tecnicos);
        }
        $agendamento->numitens_padroes = $numitens_padroes;
        if ($numitens_padroes > 0) {
            $agendamento->id_padrao = implode("|", $array_id_padroes);
        }
        $agendamento->numitens_veiculos = $numitens_veiculos;
        if ($numitens_veiculos > 0) {
            $agendamento->id_veiculo = implode("|", $array_id_veiculos);
        }
        $agendamento->id_cliente = $id_cliente;
        $agendamento->obs = $observacao;

        AtualizaStatusPadrao::dispatch($agendamento->id_padrao);

        $agendamento->save();
        dd($agendamento);
        echo "<script language='javascript'> window.alert('Compromisso agendado com sucesso!') </script>";
        session_start();
        return redirect()->route('painel');
               
      
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
