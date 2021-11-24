<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Padrao;
use App\Models\Padroes_agendamento;
use App\Models\Servico;
use App\Models\Servicos_agendamento;
use App\Models\Tecnico;
use App\Models\Tecnicos_agendamento;
use App\Models\Veiculo;
use App\Models\Veiculos_agendamento;
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
        
        $agendamentos = Agendamento::orderByDesc('id')->get();
        //dd($agendamentos);
        $arrayEventos = array();
        
        $x = 0; 
        foreach ($agendamentos as $key => $evento) {   
        #gerando array de tecnicos
            $tecnicos = Tecnicos_agendamento::leftJoin("tecnicos", function($join){
                $join->on("tecnicos_agendamentos.id_tecnico", "=", "tecnicos.id");
            })
            ->select("tecnicos_agendamentos.id_agendamento", "tecnicos_agendamentos.id_tecnico", "tecnicos.name")
            ->where("tecnicos_agendamentos.id_agendamento", "=", $evento->id)
            ->get();
        #gerando array de servicos
            $servicos = Servicos_agendamento::leftJoin("servicos", function($join){
                $join->on("servicos_agendamentos.id_servico", "=", "servicos.id");
            })
            ->select("servicos_agendamentos.id_agendamento", "servicos_agendamentos.id_servico", "servicos.codigo_servico_omie", "servicos.descricao", "servicos_agendamentos.qtd")
            ->where("servicos_agendamentos.id_agendamento", "=", $evento->id)
            ->get();
        #gerando array de padroes
            $padroes = Padroes_agendamento::leftJoin("padroes", function($join){
                $join->on("padroes_agendamentos.id_padrao", "=", "padroes.id");
            })
            ->select("padroes_agendamentos.id_agendamento", "padroes_agendamentos.id_padrao", "padroes.tag", "padroes.description")
            ->where("padroes_agendamentos.id_agendamento", "=", $evento->id)
            ->get();
        #gerando array de veiculos
            $veiculos = Veiculos_agendamento::leftJoin("veiculos", function($join){
                $join->on("veiculos_agendamentos.id_veiculo", "=", "veiculos.id");
            })
            ->select("veiculos_agendamentos.id_agendamento", "veiculos_agendamentos.id_veiculo", "veiculos.vehicle_plate", "veiculos.brand", "veiculos.model")
            ->where("veiculos_agendamentos.id_agendamento", "=", $evento->id)
            ->get();
        #criando as variaveis $nomes_tecnicos e $nome_cliente p/ exibir no titulo do evento
            for ($i=0; $i < count($tecnicos); $i++) { 
                $arrayNomesTecnicos[$i] = $tecnicos[$i]->name;
            }
            $nomes_tecnicos = implode(", ", $arrayNomesTecnicos);   //transforma array de nomes em string
            $nome_cliente = Cliente::where('id', '=', $evento->id_cliente)->first()->nome_fantasia;
        #criando array de eventos
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
                'array_servicos' => $servicos,
                'array_tecnicos' =>$tecnicos,
                'array_padroes' =>$padroes,
                'array_veiculos' =>$veiculos,
                'cliente' => $nome_cliente,
                'obs' => $evento->obs,
                'created_at' => $evento->created_at,
                'updated_at' => $evento->updated_at,
                'alterado_por' => $evento->alterado_por,
                'color' => $this->colorSelect($evento->compromisso),
            );
        #
            $x++;
        } //end foreach
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
     **Seleciona a cor de acordo com o compromisso
     */
    public function colorSelect($compromisso)
    {
        switch ($compromisso) {
            case 'Confirmado':
                $color = '#15b800';
                break;

            case 'Ag. Confirmação':
                $color = '#0d00ab';
                break;

            case 'Cancelado':
                $color = '#ff160e';
                break;

            case 'Empréstimo':
                $color = '#ff5fc7';
                break;

            case 'Férias':
                $color = '#fffa43';
                break;

            case 'Outros':
                $color = '#e6d8ff';
                break;
            
            default:
                $color = '#ffffff';
                break;
        }

        return $color;
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
     * Exclui um servico de um agendamento.
     * @param  str  $codigos
     */
    public function excluirServico($codigos)
    {
        $id_agendamento = explode('|', $codigos)[0];    //id do agendamento
        $id_servico = explode('|', $codigos)[1];    //id do servico a ser excluido
        //$codigoServico = $codigoServico[0]->codigo_servico_omie;
        Servicos_agendamento::where('id_agendamento', '=', $id_agendamento)
        ->where('id_servico', '=', $id_servico)->delete();
    }

    /**
     * Exclui um tecnico de um agendamento.
     * @param  str  $codigos
     */
    public function excluirTecnico($codigos)
    {
        $id_agendamento = explode('|', $codigos)[0];    //id do agendamento
        $id_tecnico = explode('|', $codigos)[1];    //id do tecnico a ser excluido
        Tecnicos_agendamento::where('id_agendamento', '=', $id_agendamento)
        ->where('id_tecnico', '=', $id_tecnico)->delete();
    }

    /**
     * Exclui um padrao de um agendamento.
     * @param  str  $codigos
     */
    public function excluirPadrao($codigos)
    {
        $id_agendamento = explode('|', $codigos)[0];    //id do agendamento
        $id_padrao = explode('|', $codigos)[1];    //id do padrao a ser excluido
        Padroes_agendamento::where('id_agendamento', '=', $id_agendamento)
        ->where('id_padrao', '=', $id_padrao)->delete();
    }

    /**
     * Exclui um veiculo de um agendamento.
     * @param  str  $codigos
     */
    public function excluirVeiculo($codigos)
    {
        $id_agendamento = explode('|', $codigos)[0];    //id do agendamento
        $id_veiculo = explode('|', $codigos)[1];    //id do veiculo a ser excluido
        Veiculos_agendamento::where('id_agendamento', '=', $id_agendamento)
        ->where('id_veiculo', '=', $id_veiculo)->delete();
    }

}
