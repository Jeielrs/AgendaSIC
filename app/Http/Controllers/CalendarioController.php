<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Padrao;
use App\Models\Tecnico;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session_start();
        $clientes = Cliente::all();
        $tecnicos = Tecnico::all();
        $padroes = Padrao::all();
        $veiculos = Veiculo::all();
        if($_SESSION['nivel'] == 'admin'){
            return view('calendario.admin.index', ['clientes' => $clientes, 'tecnicos' => $tecnicos,'veiculos' => $veiculos, 'padroes' => $padroes]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('calendario.manager.index', ['clientes' => $clientes, 'tecnicos' => $tecnicos,'veiculos' => $veiculos, 'padroes' => $padroes]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('calendario.user.index', ['clientes' => $clientes, 'tecnicos' => $tecnicos,'veiculos' => $veiculos, 'padroes' => $padroes]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Carrega dentro do calendario os agendamentos/eventos cadastrados no bd
     */
    public function loadEvents()
    {
        
        $padroes = Padrao::all();
        $veiculos = Veiculo::all();
        $agendamentos = Agendamento::all();
        $arrayEventos = array();
        
        $x = 0; 
        foreach ($agendamentos as $key => $evento) {   
            $arrayNomesDeTecnicos = array();         
            $id_tecnicos = explode(',', $evento->id_tecnico);   //transforma as id em array            
            $tecnicos = Tecnico::select("name")->whereIn("id", $id_tecnicos)->get();
            $t = 0;            
            if (count($tecnicos) > 1) {
                foreach ($tecnicos as $nome) {
                    $arrayNomesDeTecnicos[$t] = $this->firstName($nome->name);
                    $t++;
                    
                }
            } else {
                $arrayNomesDeTecnicos[$t] = $this->firstName($tecnicos[0]->name);
            }
            
                       
            $nomes_tecnicos = implode (",", $arrayNomesDeTecnicos);   //transforma array de nomes em string
            $nome_cliente = Cliente::where('id', '=', $evento->id_cliente)->first()->nome_fantasia;
            $arrayEventos[$x] = array(
                'id' => $evento->id,
                'title' => $nomes_tecnicos.' | '.$nome_cliente,
                'start' => $evento->data.' '.$evento->horario_inicio,
                'end' => $evento->data.' '.$evento->horario_fim,
                'data' => $evento->data,
                'tipo_servico' => $evento->tipo_servico,
                'tipo_contrato' => $evento->tipo_contrato,
                'compromisso' => $evento->compromisso,
                'tipo_agendamento' => $evento->tipo_agendamento,
                'tempo_servico' => $evento->tempo_servico,
                'horario_inicio' => $evento->horario_inicio,
                'horario_fim' => $evento->horario_fim,
                'dias_semana' => $evento->dias_semana,
                'protocolo' => $evento->protocolo,
                'integracao' => $evento->integracao,
                'hospedagem' => $evento->hospedagem,
                'contato' => $evento->contato,
                'numitens_servicos' => $evento->numitens_servicos,
                'qtd_servicos' => $evento->qtd_servicos,
                'id_servico' => $evento->id_servico,
                'numitens_tecnicos' => $evento->numitens_tecnicos,
                'id_tecnico' => $evento->id_tecnico,
                'numitens_padroes' => $evento->numitens_padroes,
                'id_padrao' => $evento->id_padrao,
                'numitens_veiculos' => $evento->numitens_veiculos,
                'id_veiculo' => $evento->id_veiculo,
                'id_cliente' => $evento->id_cliente,
                'obs' => $evento->obs,
                'created_at' => $evento->created_at,
                'updated_at' => $evento->updated_at,
                'alterado_por' => $evento->alterado_por,
            );
            $x++;
        }
        //dd($arrayEventos);
        //echo "<pre>" . print_r($events[1], true);
        return response()->json($arrayEventos);
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
     **Recupera apenas o primeiro nome antes do espaço na string
     */
    public function firstName($name)
    {
        $firstName = explode(' ', $name);
        return $firstName[0];
    }

    /**
     **Recupera apenas os primeiros 7 caracteres da string
     */
    public function encurtaString($string) {
		$tamanho = strlen($string);
		if ($tamanho > 10) {
			$string = substr($string, 0, 7) . "...";
		}
		return $string;
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
