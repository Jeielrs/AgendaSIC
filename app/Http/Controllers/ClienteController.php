<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use clientes_list_request;
use ClientesCadastroJsonClient;
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
     * Sincroniza e envia dados via Ajax.
     */
    public function sync(Request $request)
    {
        $tempo_inicio = microtime( true );
        $log = "";

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
		//
        //$log = "Página : " . print_r($retornoOmie->pagina, true) . "<br>";
        //$log .=  "Total de páginas : " . print_r($retornoOmie->total_de_paginas, true) . "<br>";
        //$log .=  "Registros nessa página : " . print_r($retornoOmie->registros, true) . "<br>";
        //$log .=  "Total de Registros : " . print_r($retornoOmie->total_de_registros, true) . "<br>";
            
        $log .=  "<pre>" . print_r($arrayClientes, true);

        //foreach ($arrayClientes as $key => $cliente) {
        //    # pra cada cliente pesquisar o codigo omiee cadastrar
        //}
            
        $tempo_fim = microtime( true );
        $tempo_execucao = ($tempo_fim - $tempo_inicio);
        $logCompleto = '<b>Tempo de Execução:</b> '.$tempo_execucao.' Segs <br><br>';
        $logCompleto .= $log;
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
            $endereco = ($cliente->endereco_numero != "")?$endereco.", ".$cliente->endereco_numero:$endereco;
            $endereco = ($cliente->bairro != "")?$endereco." - ".$cliente->bairro:$endereco;
            $cidade = explode(" (", $cliente->cidade);
            $data_alt = $cliente->info->dAlt." ".$cliente->info->hAlt;
            $data_inc = $cliente->info->dInc." ".$cliente->info->hInc;
            $tag_cliente = (isset($cliente->tags[0]->tag) == "Cliente")?"S":"N";
            $observacao = isset($cliente->observacao)?$cliente->observacao:null;
            $tag_segmento = (isset($cliente->tags[1]->tag))?$cliente->tags[1]->tag:null;
            #TRATAMENTO DOS DADOS RECEBIDOS DO OMIE

            if ($tag_cliente == "S") {
                $arrayClientes[$x] = array(
                    "cnpj_cpf" => $cliente->cnpj_cpf,
                    "codigo_cliente_omie" => $cliente->codigo_cliente_omie,
                    "email" => $email,
                    "endereco" => $endereco,
                    "cidade" => $cidade[0],
                    "estado" => $cliente->estado,
                    "inativo" => $cliente->inativo,
                    "data_Alt" => date_create_from_format("d/m/Y H:i:s", $data_alt)->format("Y-m-d H:i:s"),
                    "data_Inc" => date_create_from_format("d/m/Y H:i:s", $data_inc)->format("Y-m-d H:i:s"),
                    "nome_fantasia" => $cliente->nome_fantasia,
                    "observacao" => $observacao,
                    "pessoa_fisica" => $cliente->pessoa_fisica,
                    "razao_social" => $cliente->razao_social,
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
