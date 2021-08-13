<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use srvListarRequest;
use ServicosSoapClient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;
use DateTime;
use ServicosJsonClient;

class ServicoController extends Controller
{
    /**
     * Exibe uma listagem dos serviços
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {       
        if ($request->ajax()) {            
            $data = Servico::latest()->get();
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
                ->editColumn('descricao', function($row) {
                    $bugados = array('&gt;', '&gt;', '&quot;');
                    $correcoes = array('>', '<', '"',);
                    $descricao = str_replace($bugados, $correcoes, $row->descricao);
                    return $descricao;
                })
                ->setRowClass(function ($row) {
                    return $row->status == 'inativo' ? 'alert-warning' : 'alert';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        session_start();
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

    /**
     * Abre a Tela de Sincronização.
     *
     * @return \Illuminate\Http\Response
     */
    public function synchronize()
    {
        session_start();
        $servicos = Servico::simplePaginate(); //busca com paginação
        if($_SESSION['nivel'] == 'admin'){
            return view('servicos.admin.synchronize', ['servicos'=> $servicos]);
        }        
        elseif ($_SESSION['nivel'] == 'manager') {
            return view('servicos.manager.synchronize', ['servicos'=> $servicos]);
        }        
        elseif ($_SESSION['nivel'] == 'user') {
            return view('servicos.user.synchronize', ['servicos'=> $servicos]);
        }
    }

    /**
     * Sincroniza e envia dados via Ajax.
     */
    public function sync(Request $request)
    {
        $tempo_inicio = microtime( true );

        $logCadastro = "<br><br><h5 class='text-center'>Relatório de Sincronização</h5><hr>Buscando por serviços ainda não cadastrados...<br><br>";

        //buscando servicos no omie
		$i = 1;
		$page = 0;
		while ($i < 2) {
			$page = $page + 1;
			$retorno = $this->listarServicos($page);
			$continue = $retorno['continue'];
			if ($page < 2) {
				$arrayServicos = $retorno['arrayServicos'];
                //echo "<pre>" . print_r($arrayServicos, true);
			} else {
				$arrayServicos = array_merge($arrayServicos, $retorno['arrayServicos']);
                //echo "<pre>" . print_r($arrayServicos, true);
			}
			if ($continue == "N") {
				$i++;
			}
		}
        
        //echo  "<pre>" . print_r($arrayServicos, true);exit();

        $logUpdate =  "Buscando por Serviços desatualizados...<br><br>";
        $servicosAtualizados = 0;
        $servicosCadastrados = 0;

        foreach ($arrayServicos as $key => $servicoOmie) {
            $servicoBase = Servico::where('codigo_servico_omie', "=", $servicoOmie['codigo_servico_omie'])->first();
            if (isset($servicoBase->id)) {
                $lastUpdateOmie = $servicoOmie['data_Inc'];
                $lastUpdateBase = Servico::where('id', "=", $servicoBase->id)->first();
                $dtOmie = strtotime($lastUpdateOmie);
                $dtBase = strtotime($lastUpdateBase->updated_at);
                $agora = new DateTime();
                if ($dtOmie > $dtBase) {
                    $updatedId = $this->update($servicoOmie);
                    $servicosAtualizados++;
                    $logUpdate .= "Update Omie = ".$lastUpdateOmie." ///// Update Base = ".$lastUpdateBase->updated_at."<br>";
                    $logUpdate .= "> Serviço ".$servicoOmie['codigo_servico_omie']." - ".$servicoOmie['descricao']. " atualizado com sucesso!<br>";
                }
                //else {
                //}
            } else {
                $insertedId = $this->insert($servicoOmie);
                $servicosCadastrados++;
                $logCadastro .= "> Novo Serviço ".$servicoOmie['codigo_servico_omie']." - ".$servicoOmie['descricao']. " cadastrado com a ID ".$insertedId."<br>";
            }
        }

        if ($servicosCadastrados == 0) {
            $logCadastro .= "<b>Não foram encontrados novos registros.</b><hr>";
        } else {
            $logCadastro .= "<br><b>Total de ".$servicosCadastrados." serviços cadastrados.</b><hr>";
        }
        if ($servicosAtualizados == 0) {
            $logUpdate .= "<b>Não foram encontrados registros desatualizados.</b><hr>";
        } else {
            $logUpdate .= "<br><b>Total de ".$servicosAtualizados." serviços atualizados.</b><hr>";
        }

        $tempo_fim = microtime( true );
        $tempo_execucao = substr((($tempo_fim - $tempo_inicio)/60), 0, 4);
        $logCompleto = $logCadastro;
        $logCompleto .= $logUpdate;
        $logCompleto .= 'Tempo de Execução: '.$tempo_execucao.' min.';
        echo $logCompleto; //para aparecer na tela
    }

    /**
     * Lista todos os Serviços do Omie
     */
    public function listarServicos($pagina) {
        $retornoOmie = $this->configServicosOmie($pagina);
        $arrayServicos = array();
        $x = 0;

        //echo  "<pre>" . print_r($retornoOmie, true);exit();
        //echo  "<pre>" . print_r($retornoOmie->cadastros[0]->info->inativo, true);exit();

        foreach ($retornoOmie->cadastros as $key => $servico) {
            #TRATAMENTO DOS DADOS RECEBIDOS DO OMIE
            $status = ($servico->info->inativo == "N")?"ativo":"inativo";
            $pieces = explode(" | ", $servico->descricao->cDescrCompleta);
            $escopo = $pieces[0];
            $local = isset($pieces[1])?$pieces[1]:'';
            $certificacao = isset($pieces[2])?$pieces[2]:'';
            $procedimento = isset($pieces[3])?$pieces[3]:'';
            $data_alt = $servico->info->dAlt." ".$servico->info->hAlt;
            $data_inc = $servico->info->dInc." ".$servico->info->hInc;
            #TRATAMENTO DOS DADOS RECEBIDOS DO OMIE

            $arrayServicos[$x] = array(
                "codigo_servico_omie" => $servico->cabecalho->cCodigo,
                "descricao" => $servico->cabecalho->cDescricao,
                "escopo" => $escopo,
                "local" => $local,
                "certificacao" => $certificacao,
                "procedimento" => $procedimento,
                "status" => $status,
                "data_Alt" => date_create_from_format("d/m/Y H:i:s", $data_alt)->format("Y-m-d H:i:s"),
                "data_Inc" => date_create_from_format("d/m/Y H:i:s", $data_inc)->format("Y-m-d H:i:s"),
            );
            $x++;
        }

        if ($retornoOmie->nTotPaginas == $retornoOmie->nPagina) {
            $continue = "N";
        } else {
            $continue = "S";
        }

        $retorno = array(
            "continue" => $continue,
            "arrayServicos" => $arrayServicos,
            "total_de_paginas" =>$retornoOmie->nTotPaginas,
        );
        return $retorno;
    }

    /**
     * Configura a busca dos Serviços do Omie
     */
    public function configServicosOmie($pagina)
    {
        require_once "assets/omie/OmieAppAuth.php";
        require_once "assets/omie/ServicosJsonClient.php";
            
        $servicos = new ServicosJsonClient();            
        $request = new srvListarRequest();
            
        $request->nPagina = $pagina;
        $request->nRegPorPagina = 300 ;
        //$request->apenas_importado_api = "N" ;
            
        $result = $servicos->ListarCadastroServico($request);

        return $result;
    }

    /*
     * Insere Serviços na tabela
     */
    public function insert($array){
        $servico = new Servico;
        $servico->codigo_servico_omie = $array['codigo_servico_omie'];
        $servico->status = $array['status'];
        $servico->descricao = $array['descricao'];
        $servico->escopo = $array['escopo'];
        $servico->local = $array['local'];
        $servico->certificacao = $array['certificacao'];
        $servico->procedimento = $array['procedimento'];
        $servico->save();
        $insertedId = $servico->id;
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
            $data = Servico::findOrFail($id);
            return response()->json(['result' => $data]);
        }
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
        $servico = Servico::where('codigo_servico_omie', "=", $array['codigo_servico_omie'])->first();
        $servico->codigo_servico_omie = $array['codigo_servico_omie'];
        $servico->status = $array['status'];
        $servico->descricao = $array['descricao'];
        $servico->escopo = $array['escopo'];
        $servico->local = $array['local'];
        $servico->certificacao = $array['certificacao'];
        $servico->procedimento = $array['procedimento'];
        $servico->updated_at = $array['data_Inc'];
        $servico->save();
        $updatedId = $servico->id;
        return $updatedId;
    }
}
