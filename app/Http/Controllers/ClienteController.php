<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use clientes_list_request;
use ClientesCadastroJsonClient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;

class ClienteController extends Controller
{
    /**
     * Exibe uma listagem dos clientes
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {       
        if ($request->ajax()) {            
            $data = Cliente::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){         
                    $button = '<a href="#" class="show" id="'.$data->id.'"><i class="fas fa-eye text-info"></i></a>';        
                    return $button;
                })
                ->setRowAttr([
                    'style' => function() {
                        return "font-size:14px; white-space : nowrap;";
                    },
                    #'class' => function() {
                    #    return "text-center";
                    #},
                ])
                ->setRowClass(function ($row) {
                    return $row->status == 'inativo' ? 'alert-warning' : 'alert';
                })
                ->editColumn('email', function($row) {
                    $email = (strpos($row->email,',') === false)?$row->email:explode(',', $row->email)[0];
                    return $email;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        session_start();
        if($_SESSION['nivel'] == 'admin'){
            return view('clientes.admin.index');
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('clientes.manager.index');
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('clientes.user.index');
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
        $clientes = Cliente::simplePaginate(); //busca com paginação
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
     * Sincroniza e envia dados via Ajax.
     */
    public function sync(Request $request)
    {
        $tempo_inicio = microtime( true );
        $logCadastro = "<b><h5>Iniciando cadastro, buscando por clientes já cadastrados...</h5></b>";

        //buscando clientes no omie
		$i = 1;
		$page = 0;
		while ($i < 2) {
			$page = $page + 1;
			$retorno = $this->listarClientes($page);
			$continue = $retorno['continue'];
			if ($page < 2) {
				$arrayClientes = $retorno['arrayClientes'];
                //echo "<pre>" . print_r($arrayClientes, true);
			} else {
				$arrayClientes = array_merge($arrayClientes, $retorno['arrayClientes']);
                //echo "<pre>" . print_r($arrayClientes, true);
			}
			if ($continue == "N") {
				$i++;
			}
		}
		
        //$log = "Página : " . print_r($retornoOmie->pagina, true) . "<br>";
        //$log .=  "Total de páginas : " . print_r($retornoOmie->total_de_paginas, true) . "<br>";
        //$log .=  "Registros nessa página : " . print_r($retornoOmie->registros, true) . "<br>";
        //$log .=  "Total de Registros : " . print_r($retornoOmie->total_de_registros, true) . "<br>";
          
        echo  "<pre>" . print_r($arrayClientes, true);

        $logUpdate =  "<b><h5>Buscando por Clientes desatualizados...</h5></b>";

        foreach ($arrayClientes as $key => $clienteOmie) {
            $clienteBase = Cliente::where('codigo_cliente_omie', "=", $clienteOmie['codigo_cliente_omie'])->first();
            if (isset($clienteBase->id)) {
                $logCadastro .= "Cliente ". $clienteOmie['razao_social'] ." já cadastrado na ID ". $clienteBase->id ."... Procurando por atualizações:<br>";
                $lastUpdateOmie = $clienteOmie['data_Alt'];
                $lastUpdateBase = Cliente::where('id', "=", $clienteBase->id)->first();
                $logUpdate .= "Update Omie = ".$lastUpdateOmie." ///// Update Base = ".$lastUpdateBase->updated_at."<br>";
                if ($lastUpdateOmie > $lastUpdateBase) {
                    $updatedId = $this->update($clienteOmie);
                    $logUpdate .= "Cliente ".$clienteOmie['codigo_cliente_omie']." - ".$clienteOmie['razao_social']. " atualizado com sucesso!"."<br>";
                } else {
                    $logUpdate .= "Cliente ".$clienteOmie['codigo_cliente_omie']." - ".$clienteOmie['razao_social']. " já estava atualizado <br>";
                }
            } else {
                $insertedId = $this->insert($clienteOmie);
                $logCadastro .= "Cliente ".$clienteOmie['codigo_cliente_omie']." - ".$clienteOmie['razao_social']. " inserido com a ID ".$insertedId."<br>";
            }
           //$insert = $this->insert($cliente);
           //echo "Cliente ".$cliente['codigo_cliente_omie']." - ".$cliente['razao_social']. "inserido com a ID ".$insert->last_insert_id."<hr>";
        }
        $logCadastro .= "<b><h5>Cadastro finalizado</h5></b><hr>";
        

        //$clientesBase = Cliente::
        //foreach ($arrayClientes as $key => $clienteOmie) {
        //    # code...
        //}

        $logUpdate .= "<b><h5>Atualizações finalizadas.</h5></b><hr>";
        $tempo_fim = microtime( true );
        $tempo_execucao = ($tempo_fim - $tempo_inicio);
        $logCompleto = '<b><h5>Tempo de Execução:</h5></b> '.$tempo_execucao.' Segs <hr>';
        $logCompleto .= $logCadastro;
        $logCompleto .= $logUpdate;
        echo $logCompleto; //para aparecer na tela
    }

    /**
     * Lista todos os Clientes do Omie
     */
    public function listarClientes($pagina) {
        $retornoOmie = $this->configClientesOmie($pagina);
        $arrayClientes = array();
        $x = 0;

        foreach ($retornoOmie->clientes_cadastro as $key => $cliente) {
            #TRATAMENTO DOS DADOS RECEBIDOS DO OMIE
            $email = isset($cliente->email)?$cliente->email:null;
            $telefone_ddd = isset($cliente->telefone1_ddd)?$cliente->telefone1_ddd:'';
            $telefone_num = isset($cliente->telefone1_numero)?$cliente->telefone1_numero:'';
            $telefone = (is_null($telefone_ddd) and is_null($telefone_num))?null:$telefone_ddd." ".$telefone_num;
            $endereco = ($cliente->endereco != "")?$cliente->endereco:null;
            $endereco = ($cliente->endereco_numero != "")?$endereco." | ".$cliente->endereco_numero:$endereco;
            $endereco = ($cliente->bairro != "")?$endereco." | ".$cliente->bairro:$endereco;
            $cidade = explode(" (", $cliente->cidade);
            $cep = ($cliente->cep != "")?$cliente->cep:null;
            $data_alt = $cliente->info->dAlt." ".$cliente->info->hAlt;
            $data_inc = $cliente->info->dInc." ".$cliente->info->hInc;
            $tag_cliente = (isset($cliente->tags[0]->tag) == "Cliente")?"S":"N";
            $observacao = isset($cliente->observacao)?$cliente->observacao:null;
            $tag_segmento = (isset($cliente->tags[1]->tag))?$cliente->tags[1]->tag:null;
            $status = ($cliente->inativo == "N")?"ativo":"inativo";
            $razao_social = (strpos($cliente->razao_social, '&') === false)?$cliente->razao_social:str_replace('&amp;', ' & ', $cliente->razao_social);
            $nome_fantasia = (strpos($cliente->nome_fantasia, '&') === false)?$cliente->nome_fantasia:str_replace('&amp;', ' & ', $cliente->nome_fantasia);
            #TRATAMENTO DOS DADOS RECEBIDOS DO OMIE

            if ($tag_cliente == "S") {
                $arrayClientes[$x] = array(
                    "cnpj_cpf" => $cliente->cnpj_cpf,
                    "codigo_cliente_omie" => $cliente->codigo_cliente_omie,
                    "email" => $email,
                    "endereco" => $endereco,
                    "cidade" => $cidade[0],
                    "estado" => $cliente->estado,
                    "cep" => $cliente->cep,
                    "status" => $status,
                    "data_Alt" => date_create_from_format("d/m/Y H:i:s", $data_alt)->format("Y-m-d H:i:s"),
                    "data_Inc" => date_create_from_format("d/m/Y H:i:s", $data_inc)->format("Y-m-d H:i:s"),
                    "nome_fantasia" => $nome_fantasia,
                    "observacao" => $observacao,
                    "pessoa_fisica" => $cliente->pessoa_fisica,
                    "razao_social" => $razao_social,
                    "segmento" => $tag_segmento,
                    "telefone" => $telefone,
                );
            }
            $x++;
        }

        if ($retornoOmie->total_de_paginas == $retornoOmie->pagina) {
            $continue = "N";
        } else {
            $continue = "S";
        }

        $retorno = array(
            "continue" => $continue,
            "arrayClientes" => $arrayClientes,
            "total_de_paginas" =>$retornoOmie->total_de_paginas,
        );
        return $retorno;
    }

    /**
     * Configura a busca dos Clientes do Omie
     */
    public function configClientesOmie($pagina)
    {
        require_once "assets/omie/OmieAppAuth.php";
        require_once "assets/omie/ClientesCadastroJsonClient.php";
            
        $clientes = new ClientesCadastroJsonClient();            
        $request = new clientes_list_request();
            
        $request->pagina = $pagina;
        $request->registros_por_pagina = 500 ;
        $request->apenas_importado_api = "N" ;
            
        $result = $clientes->ListarClientes($request);

        return $result;
    }

    /*
     * Insere Clientes na tabela
     */
    public function insert($array){
        $cliente = new Cliente;
        $cliente->codigo_cliente_omie = $array['codigo_cliente_omie'];
        $cliente->status = $array['status'];
        $cliente->segmento = $array['segmento'];
        $cliente->razao_social = $array['razao_social'];
        $cliente->cnpj_cpf = $array['cnpj_cpf'];
        $cliente->nome_fantasia = $array['nome_fantasia'];
        $cliente->telefone = $array['telefone'];
        $cliente->endereco = $array['endereco'];
        $cliente->estado = $array['estado'];
        $cliente->cidade = $array['cidade'];
        $cliente->cep = $array['cep'];
        $cliente->email = $array['email'];
        $cliente->observacao = $array['observacao'];
        $cliente->pessoa_fisica = $array['pessoa_fisica'];
        $cliente->save();
        $insertedId = $cliente->id;
        return $insertedId;
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
    * Display the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        if(request()->ajax())
        {
            $data = Cliente::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function teste()
    {
        echo "teste";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($array)
    {
        $cliente = Cliente::find($array['id']);
        $cliente->codigo_cliente_omie = $array['codigo_cliente_omie'];
        $cliente->status = $array['status'];
        $cliente->segmento = $array['segmento'];
        $cliente->razao_social = $array['razao_social'];
        $cliente->cnpj_cpf = $array['cnpj_cpf'];
        $cliente->nome_fantasia = $array['nome_fantasia'];
        $cliente->telefone = $array['telefone'];
        $cliente->endereco = $array['endereco'];
        $cliente->estado = $array['estado'];
        $cliente->cidade = $array['cidade'];
        $cliente->cep = $array['cep'];
        $cliente->email = $array['email'];
        $cliente->observacao = $array['observacao'];
        $cliente->pessoa_fisica = $array['pessoa_fisica'];
        $cliente->save();
        $updatedId = $cliente->id;
        return $updatedId;
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
