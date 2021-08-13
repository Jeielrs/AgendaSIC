<?php
if (!class_exists("CBSoapClient")) {
	class CBSoapClient extends SoapClient {
	    public function __doRequest($request, $location, $action, $version, $one_way = 0) {
	        $xmlRequest = new DOMDocument("1.0");
	        $xmlRequest->loadXML($request);
	        $header = $xmlRequest->createElement("SOAP-ENV:Header");
	        if (defined("OMIE_APP_KEY")) { $header->appendChild( $xmlRequest->createElement("app_key", OMIE_APP_KEY) ); }
	        if (defined("OMIE_APP_SECRET")) { $header->appendChild( $xmlRequest->createElement("app_secret", OMIE_APP_SECRET) ); }
	        if (defined("OMIE_USER_LOGIN")) { $header->appendChild( $xmlRequest->createElement("user_login", OMIE_USER_LOGIN) ); }
	        if (defined("OMIE_USER_PASSWORD")) { $header->appendChild( $xmlRequest->createElement("user_password", OMIE_USER_PASSWORD) ); }
	        $envelope = $xmlRequest->firstChild;
	        $envelope->insertBefore($header, $envelope->firstChild);
	        $request = $xmlRequest->saveXML();
	        return parent::__doRequest($request, $location, $action, $version, $one_way);
	    }
	}
}
/**
 * @service ServicosSoapClient
 * @author omie
 */
class ServicosSoapClient {
	/**
	 * The WSDL URI
	 *
	 * @var string
	 */
	public static $_WsdlUri='https://app.omie.com.br/api/v1/servicos/servico/?WSDL';
	/**
	 * The PHP SoapClient object
	 *
	 * @var object
	 */
	public static $_Server=null;

	/**
	 * Send a SOAP request to the server
	 *
	 * @param string $method The method name
	 * @param array $param The parameters
	 * @return mixed The server response
	 */
	public static function _Call($method,$param){
		if(is_null(self::$_Server))
			self::$_Server=new CBSoapClient(self::$_WsdlUri);
		return self::$_Server->__soapCall($method,$param);
	}

	/**
	 * Inclusão de serviço.
	 *
	 * @param srvIncluirRequest $srvIncluirRequest Requisição de inclusão do cadastro do serviço.
	 * @return srvIncluirResponse Resposta da solicitação de inclusão do cadastro do serviço.
	 */
	public function IncluirCadastroServico($srvIncluirRequest){
		return self::_Call('IncluirCadastroServico',Array(
			$srvIncluirRequest
		));
	}

	/**
	 * Alteração de Serviço.
	 *
	 * @param srvEditarRequest $srvEditarRequest Requisição de alteração do cadastro do serviço.
	 * @return srvEditarResponse Resposta da solicitação de alteração do cadastro do serviço.
	 */
	public function AlterarCadastroServico($srvEditarRequest){
		return self::_Call('AlterarCadastroServico',Array(
			$srvEditarRequest
		));
	}

	/**
	 * Upsert de serviço.
	 *
	 * @param srvUpsertRequest $srvUpsertRequest Requisição de upsert do cadastro do serviço.
	 * @return srvUpsertResponse Resposta da solicitação de upsert do cadastro do serviço.
	 */
	public function UpsertCadastroServico($srvUpsertRequest){
		return self::_Call('UpsertCadastroServico',Array(
			$srvUpsertRequest
		));
	}

	/**
	 * Exclusão do cadastro de serviço.
	 *
	 * @param srvExcluirRequest $srvExcluirRequest Requisição da exclusão do Serviço.
	 * @return srvExcluirResponse Resposta da solicitação de exclusão do cadastro do serviço.
	 */
	public function ExcluirCadastroServico($srvExcluirRequest){
		return self::_Call('ExcluirCadastroServico',Array(
			$srvExcluirRequest
		));
	}

	/**
	 * Consulta do cadastro de serviço.
	 *
	 * @param srvConsultarRequest $srvConsultarRequest Requisição da consulta do serviço.
	 * @return srvConsultarResponse Resposta da requisição de consulta de serviços.
	 */
	public function ConsultarCadastroServico($srvConsultarRequest){
		return self::_Call('ConsultarCadastroServico',Array(
			$srvConsultarRequest
		));
	}

	/**
	 * Lista os serviços cadastrados.
	 *
	 * @param srvListarRequest $srvListarRequest Solicitação da listagem de serviços.
	 * @return srvListarResponse Resposta da solicitação da listagem de serviços.
	 */
	public function ListarCadastroServico($srvListarRequest){
		return self::_Call('ListarCadastroServico',Array(
			$srvListarRequest
		));
	}

	/**
	 * Associa um Código de Integração a um serviço.
	 *
	 * @param srvAssociarRequest $srvAssociarRequest Requisição da associação do código de integração do cadastro do serviço.
	 * @return srvAssociarResponse Resposta da solicitação de associação do código de integração do cadastro do serviço.
	 */
	public function AssociarCodIntServico($srvAssociarRequest){
		return self::_Call('AssociarCodIntServico',Array(
			$srvAssociarRequest
		));
	}
}

/**
 * Dados do Serviço.
 *
 * @pw_element string $cDescricao Descrição Resumida do serviço prestado.
 * @pw_element string $cCodigo Código do Serviço.
 * @pw_element string $cIdTrib ID da Tributação dos Serviços.
 * @pw_element string $cCodServMun Código do Serviço Municipal.
 * @pw_element string $cCodLC116 Código do Serviço LC 116.
 * @pw_element string $nIdNBS Id do NBS.
 * @pw_element decimal $nPrecoUnit Preço Unitário do Serviço.
 * @pw_element string $cCodCateg Código da Categoria.
 * @pw_complex cabecalho
 */
class cabecalho{
	/**
	 * Descrição Resumida do serviço prestado.
	 *
	 * @var string
	 */
	public $cDescricao;
	/**
	 * Código do Serviço.
	 *
	 * @var string
	 */
	public $cCodigo;
	/**
	 * ID da Tributação dos Serviços.
	 *
	 * @var string
	 */
	public $cIdTrib;
	/**
	 * Código do Serviço Municipal.
	 *
	 * @var string
	 */
	public $cCodServMun;
	/**
	 * Código do Serviço LC 116.
	 *
	 * @var string
	 */
	public $cCodLC116;
	/**
	 * Id do NBS.
	 *
	 * @var string
	 */
	public $nIdNBS;
	/**
	 * Preço Unitário do Serviço.
	 *
	 * @var decimal
	 */
	public $nPrecoUnit;
	/**
	 * Código da Categoria.
	 *
	 * @var string
	 */
	public $cCodCateg;
}

/**
 * Lista os cadastros encontrados.
 *
 * @pw_element intListar $intListar Dados da integração do serviço.
 * @pw_element cabecalho $cabecalho Dados do Serviço.
 * @pw_element descricao $descricao Descrição do Serviço.
 * @pw_element impostos $impostos Impostos e Retenções do serviço.
 * @pw_element info $info Dados da registro.
 * @pw_complex cadastros
 */
class cadastros{
	/**
	 * Dados da integração do serviço.
	 *
	 * @var intListar
	 */
	public $intListar;
	/**
	 * Dados do Serviço.
	 *
	 * @var cabecalho
	 */
	public $cabecalho;
	/**
	 * Descrição do Serviço.
	 *
	 * @var descricao
	 */
	public $descricao;
	/**
	 * Impostos e Retenções do serviço.
	 *
	 * @var impostos
	 */
	public $impostos;
	/**
	 * Dados da registro.
	 *
	 * @var info
	 */
	public $info;
}


/**
 * Dados da integração do serviço.
 *
 * @pw_element string $cCodIntServ Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
 * @pw_element integer $nCodServ Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
 * @pw_complex intListar
 */
class intListar{
	/**
	 * Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
	 *
	 * @var string
	 */
	public $cCodIntServ;
	/**
	 * Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
	 *
	 * @var integer
	 */
	public $nCodServ;
}

/**
 * Descrição do Serviço.
 *
 * @pw_element string $cDescrCompleta Descrição completa do serviço prestado.
 * @pw_complex descricao
 */
class descricao{
	/**
	 * Descrição completa do serviço prestado.
	 *
	 * @var string
	 */
	public $cDescrCompleta;
}

/**
 * Impostos e Retenções do serviço.
 *
 * @pw_element decimal $nAliqISS Alíquota de ISS.
 * @pw_element string $cRetISS ISS Retido (S/N).
 * @pw_element decimal $nAliqPIS Alíquota do PIS.
 * @pw_element string $cRetPIS PIS Retido (S/N).
 * @pw_element decimal $nAliqCOFINS Alíquota de COFINS.
 * @pw_element string $cRetCOFINS COFINS Retido (S/N).
 * @pw_element decimal $nAliqCSLL Alíquota de CSLL.
 * @pw_element string $cRetCSLL CSLL Retido (S/N).
 * @pw_element decimal $nAliqIR Alíquota do IR.
 * @pw_element string $cRetIR IR Retido (S/N).
 * @pw_element decimal $nAliqINSS Alíquota de INSS.
 * @pw_element string $cRetINSS INSS Retido (S/N).
 * @pw_element decimal $nRedBaseINSS Redução da Base de Cálculo de INSS.
 * @pw_complex impostos
 */
class impostos{
	/**
	 * Alíquota de ISS.
	 *
	 * @var decimal
	 */
	public $nAliqISS;
	/**
	 * ISS Retido (S/N).
	 *
	 * @var string
	 */
	public $cRetISS;
	/**
	 * Alíquota do PIS.
	 *
	 * @var decimal
	 */
	public $nAliqPIS;
	/**
	 * PIS Retido (S/N).
	 *
	 * @var string
	 */
	public $cRetPIS;
	/**
	 * Alíquota de COFINS.
	 *
	 * @var decimal
	 */
	public $nAliqCOFINS;
	/**
	 * COFINS Retido (S/N).
	 *
	 * @var string
	 */
	public $cRetCOFINS;
	/**
	 * Alíquota de CSLL.
	 *
	 * @var decimal
	 */
	public $nAliqCSLL;
	/**
	 * CSLL Retido (S/N).
	 *
	 * @var string
	 */
	public $cRetCSLL;
	/**
	 * Alíquota do IR.
	 *
	 * @var decimal
	 */
	public $nAliqIR;
	/**
	 * IR Retido (S/N).
	 *
	 * @var string
	 */
	public $cRetIR;
	/**
	 * Alíquota de INSS.
	 *
	 * @var decimal
	 */
	public $nAliqINSS;
	/**
	 * INSS Retido (S/N).
	 *
	 * @var string
	 */
	public $cRetINSS;
	/**
	 * Redução da Base de Cálculo de INSS.
	 *
	 * @var decimal
	 */
	public $nRedBaseINSS;
}

/**
 * Dados da registro.
 *
 * @pw_element string $dInc Data da Inclusão.
 * @pw_element string $hInc Hora da Inclusão.
 * @pw_element string $uInc Usuário da Inclusão.
 * @pw_element string $dAlt Data da Alteração.
 * @pw_element string $hAlt Hora da Alteração.
 * @pw_element string $uAlt Usuário da Alteração.
 * @pw_element string $cImpAPI Importado pela API (S/N).
 * @pw_element string $inativo Indica se o serviço está inativo (S/N).
 * @pw_complex info
 */
class info{
	/**
	 * Data da Inclusão.
	 *
	 * @var string
	 */
	public $dInc;
	/**
	 * Hora da Inclusão.
	 *
	 * @var string
	 */
	public $hInc;
	/**
	 * Usuário da Inclusão.
	 *
	 * @var string
	 */
	public $uInc;
	/**
	 * Data da Alteração.
	 *
	 * @var string
	 */
	public $dAlt;
	/**
	 * Hora da Alteração.
	 *
	 * @var string
	 */
	public $hAlt;
	/**
	 * Usuário da Alteração.
	 *
	 * @var string
	 */
	public $uAlt;
	/**
	 * Importado pela API (S/N).
	 *
	 * @var string
	 */
	public $cImpAPI;
	/**
	 * Indica se o serviço está inativo (S/N).
	 *
	 * @var string
	 */
	public $inativo;
}

/**
 * Dados da integração do serviço.
 *
 * @pw_element string $cCodIntServ Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
 * @pw_complex intIncluir
 */
class intIncluir{
	/**
	 * Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
	 *
	 * @var string
	 */
	public $cCodIntServ;
}

/**
 * Requisição da associação do código de integração do cadastro do serviço.
 *
 * @pw_element string $cCodIntServ Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
 * @pw_element integer $nCodServ Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
 * @pw_complex srvAssociarRequest
 */
class srvAssociarRequest{
	/**
	 * Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
	 *
	 * @var string
	 */
	public $cCodIntServ;
	/**
	 * Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
	 *
	 * @var integer
	 */
	public $nCodServ;
}

/**
 * Resposta da solicitação de associação do código de integração do cadastro do serviço.
 *
 * @pw_element string $cCodIntServ Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
 * @pw_element integer $nCodServ Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
 * @pw_element string $cCodStatus Código do Status
 * @pw_element string $cDescStatus Descrição do Status
 * @pw_complex srvAssociarResponse
 */
class srvAssociarResponse{
	/**
	 * Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
	 *
	 * @var string
	 */
	public $cCodIntServ;
	/**
	 * Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
	 *
	 * @var integer
	 */
	public $nCodServ;
	/**
	 * Código do Status
	 *
	 * @var string
	 */
	public $cCodStatus;
	/**
	 * Descrição do Status
	 *
	 * @var string
	 */
	public $cDescStatus;
}

/**
 * Requisição da consulta do serviço.
 *
 * @pw_element string $cCodIntServ Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
 * @pw_element integer $nCodServ Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
 * @pw_complex srvConsultarRequest
 */
class srvConsultarRequest{
	/**
	 * Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
	 *
	 * @var string
	 */
	public $cCodIntServ;
	/**
	 * Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
	 *
	 * @var integer
	 */
	public $nCodServ;
}

/**
 * Resposta da requisição de consulta de serviços.
 *
 * @pw_element intListar $intListar Dados da integração do serviço.
 * @pw_element cabecalho $cabecalho Dados do Serviço.
 * @pw_element descricao $descricao Descrição do Serviço.
 * @pw_element impostos $impostos Impostos e Retenções do serviço.
 * @pw_element info $info Dados da registro.
 * @pw_complex srvConsultarResponse
 */
class srvConsultarResponse{
	/**
	 * Dados da integração do serviço.
	 *
	 * @var intListar
	 */
	public $intListar;
	/**
	 * Dados do Serviço.
	 *
	 * @var cabecalho
	 */
	public $cabecalho;
	/**
	 * Descrição do Serviço.
	 *
	 * @var descricao
	 */
	public $descricao;
	/**
	 * Impostos e Retenções do serviço.
	 *
	 * @var impostos
	 */
	public $impostos;
	/**
	 * Dados da registro.
	 *
	 * @var info
	 */
	public $info;
}

/**
 * Requisição de alteração do cadastro do serviço.
 *
 * @pw_element intEditar $intEditar Dados da integração do serviço.
 * @pw_element cabecalho $cabecalho Dados do Serviço.
 * @pw_element descricao $descricao Descrição do Serviço.
 * @pw_element impostos $impostos Impostos e Retenções do serviço.
 * @pw_complex srvEditarRequest
 */
class srvEditarRequest{
	/**
	 * Dados da integração do serviço.
	 *
	 * @var intEditar
	 */
	public $intEditar;
	/**
	 * Dados do Serviço.
	 *
	 * @var cabecalho
	 */
	public $cabecalho;
	/**
	 * Descrição do Serviço.
	 *
	 * @var descricao
	 */
	public $descricao;
	/**
	 * Impostos e Retenções do serviço.
	 *
	 * @var impostos
	 */
	public $impostos;
}

/**
 * Dados da integração do serviço.
 *
 * @pw_element string $cCodIntServ Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
 * @pw_element integer $nCodServ Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
 * @pw_complex intEditar
 */
class intEditar{
	/**
	 * Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
	 *
	 * @var string
	 */
	public $cCodIntServ;
	/**
	 * Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
	 *
	 * @var integer
	 */
	public $nCodServ;
}

/**
 * Resposta da solicitação de alteração do cadastro do serviço.
 *
 * @pw_element string $cCodIntServ Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
 * @pw_element integer $nCodServ Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
 * @pw_element string $cCodStatus Código do Status
 * @pw_element string $cDescStatus Descrição do Status
 * @pw_complex srvEditarResponse
 */
class srvEditarResponse{
	/**
	 * Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
	 *
	 * @var string
	 */
	public $cCodIntServ;
	/**
	 * Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
	 *
	 * @var integer
	 */
	public $nCodServ;
	/**
	 * Código do Status
	 *
	 * @var string
	 */
	public $cCodStatus;
	/**
	 * Descrição do Status
	 *
	 * @var string
	 */
	public $cDescStatus;
}

/**
 * Requisição da exclusão do Serviço.
 *
 * @pw_element string $cCodIntServ Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
 * @pw_element integer $nCodServ Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
 * @pw_complex srvExcluirRequest
 */
class srvExcluirRequest{
	/**
	 * Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
	 *
	 * @var string
	 */
	public $cCodIntServ;
	/**
	 * Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
	 *
	 * @var integer
	 */
	public $nCodServ;
}

/**
 * Resposta da solicitação de exclusão do cadastro do serviço.
 *
 * @pw_element string $cCodIntServ Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
 * @pw_element integer $nCodServ Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
 * @pw_element string $cCodStatus Código do Status
 * @pw_element string $cDescStatus Descrição do Status
 * @pw_complex srvExcluirResponse
 */
class srvExcluirResponse{
	/**
	 * Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
	 *
	 * @var string
	 */
	public $cCodIntServ;
	/**
	 * Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
	 *
	 * @var integer
	 */
	public $nCodServ;
	/**
	 * Código do Status
	 *
	 * @var string
	 */
	public $cCodStatus;
	/**
	 * Descrição do Status
	 *
	 * @var string
	 */
	public $cDescStatus;
}

/**
 * Requisição de inclusão do cadastro do serviço.
 *
 * @pw_element intIncluir $intIncluir Dados da integração do serviço.
 * @pw_element cabecalho $cabecalho Dados do Serviço.
 * @pw_element descricao $descricao Descrição do Serviço.
 * @pw_element impostos $impostos Impostos e Retenções do serviço.
 * @pw_complex srvIncluirRequest
 */
class srvIncluirRequest{
	/**
	 * Dados da integração do serviço.
	 *
	 * @var intIncluir
	 */
	public $intIncluir;
	/**
	 * Dados do Serviço.
	 *
	 * @var cabecalho
	 */
	public $cabecalho;
	/**
	 * Descrição do Serviço.
	 *
	 * @var descricao
	 */
	public $descricao;
	/**
	 * Impostos e Retenções do serviço.
	 *
	 * @var impostos
	 */
	public $impostos;
}

/**
 * Resposta da solicitação de inclusão do cadastro do serviço.
 *
 * @pw_element string $cCodIntServ Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
 * @pw_element integer $nCodServ Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
 * @pw_element string $cCodStatus Código do Status
 * @pw_element string $cDescStatus Descrição do Status
 * @pw_complex srvIncluirResponse
 */
class srvIncluirResponse{
	/**
	 * Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
	 *
	 * @var string
	 */
	public $cCodIntServ;
	/**
	 * Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
	 *
	 * @var integer
	 */
	public $nCodServ;
	/**
	 * Código do Status
	 *
	 * @var string
	 */
	public $cCodStatus;
	/**
	 * Descrição do Status
	 *
	 * @var string
	 */
	public $cDescStatus;
}

/**
 * Solicitação da listagem de serviços.
 *
 * @pw_element integer $nPagina Número da página retornada
 * @pw_element integer $nRegPorPagina Número de registros retornados na página.
 * @pw_element string $cOrdenarPor Ordem de exibição dos dados. Padrão: Código.
 * @pw_element string $cOrdemDecrescente Se a lista será apresentada em ordem decrescente.
 * @pw_element string $dInclusaoInicial Data da Inclusão Inicial.
 * @pw_element string $dInclusaoFinal Data da Inclusão final
 * @pw_element string $dAlteracaoInicial Data da Alteração Inicial.
 * @pw_element string $dAlteracaoFinal Data da Alteração final.
 * @pw_element string $hInclusaoInicial Hora da Inclusão Inicial.
 * @pw_element string $hInclusaoFinal Hora da Inclusão Final.
 * @pw_element string $hAlteracaoInicial Hora da Alteração Inicial.
 * @pw_element string $hAlteracaoFinal Hora da Alteração Final.
 * @pw_element string $cDescricao Descrição Resumida do serviço prestado.
 * @pw_element string $cCodigo Código do Serviço.
 * @pw_element string $inativo Indica se o serviço está inativo (S/N).
 * @pw_complex srvListarRequest
 */
class srvListarRequest{
	/**
	 * Número da página retornada
	 *
	 * @var integer
	 */
	public $nPagina;
	/**
	 * Número de registros retornados na página.
	 *
	 * @var integer
	 */
	public $nRegPorPagina;
	/**
	 * Ordem de exibição dos dados. Padrão: Código.
	 *
	 * @var string
	 */
	public $cOrdenarPor;
	/**
	 * Se a lista será apresentada em ordem decrescente.
	 *
	 * @var string
	 */
	public $cOrdemDecrescente;
	/**
	 * Data da Inclusão Inicial.
	 *
	 * @var string
	 */
	public $dInclusaoInicial;
	/**
	 * Data da Inclusão final
	 *
	 * @var string
	 */
	public $dInclusaoFinal;
	/**
	 * Data da Alteração Inicial.
	 *
	 * @var string
	 */
	public $dAlteracaoInicial;
	/**
	 * Data da Alteração final.
	 *
	 * @var string
	 */
	public $dAlteracaoFinal;
	/**
	 * Hora da Inclusão Inicial.
	 *
	 * @var string
	 */
	public $hInclusaoInicial;
	/**
	 * Hora da Inclusão Final.
	 *
	 * @var string
	 */
	public $hInclusaoFinal;
	/**
	 * Hora da Alteração Inicial.
	 *
	 * @var string
	 */
	public $hAlteracaoInicial;
	/**
	 * Hora da Alteração Final.
	 *
	 * @var string
	 */
	public $hAlteracaoFinal;
	/**
	 * Descrição Resumida do serviço prestado.
	 *
	 * @var string
	 */
	public $cDescricao;
	/**
	 * Código do Serviço.
	 *
	 * @var string
	 */
	public $cCodigo;
	/**
	 * Indica se o serviço está inativo (S/N).
	 *
	 * @var string
	 */
	public $inativo;
}

/**
 * Resposta da solicitação da listagem de serviços.
 *
 * @pw_element integer $nPagina Número da página retornada
 * @pw_element integer $nTotPaginas Número total de páginas
 * @pw_element integer $nRegistros Número de registros retornados na página.
 * @pw_element integer $nTotRegistros total de registros encontrados
 * @pw_element cadastrosArray $cadastros Lista os cadastros encontrados.
 * @pw_complex srvListarResponse
 */
class srvListarResponse{
	/**
	 * Número da página retornada
	 *
	 * @var integer
	 */
	public $nPagina;
	/**
	 * Número total de páginas
	 *
	 * @var integer
	 */
	public $nTotPaginas;
	/**
	 * Número de registros retornados na página.
	 *
	 * @var integer
	 */
	public $nRegistros;
	/**
	 * total de registros encontrados
	 *
	 * @var integer
	 */
	public $nTotRegistros;
	/**
	 * Lista os cadastros encontrados.
	 *
	 * @var cadastrosArray
	 */
	public $cadastros;
}

/**
 * Requisição de upsert do cadastro do serviço.
 *
 * @pw_element intEditar $intEditar Dados da integração do serviço.
 * @pw_element cabecalho $cabecalho Dados do Serviço.
 * @pw_element descricao $descricao Descrição do Serviço.
 * @pw_element impostos $impostos Impostos e Retenções do serviço.
 * @pw_complex srvUpsertRequest
 */
class srvUpsertRequest{
	/**
	 * Dados da integração do serviço.
	 *
	 * @var intEditar
	 */
	public $intEditar;
	/**
	 * Dados do Serviço.
	 *
	 * @var cabecalho
	 */
	public $cabecalho;
	/**
	 * Descrição do Serviço.
	 *
	 * @var descricao
	 */
	public $descricao;
	/**
	 * Impostos e Retenções do serviço.
	 *
	 * @var impostos
	 */
	public $impostos;
}

/**
 * Resposta da solicitação de upsert do cadastro do serviço.
 *
 * @pw_element string $cCodIntServ Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
 * @pw_element integer $nCodServ Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
 * @pw_element string $cCodStatus Código do Status
 * @pw_element string $cDescStatus Descrição do Status
 * @pw_complex srvUpsertResponse
 */
class srvUpsertResponse{
	/**
	 * Código de Integração do Serviço.<BR>(Utilizado em serviços criados via API, não é visualizado na tela)
	 *
	 * @var string
	 */
	public $cCodIntServ;
	/**
	 * Código do serviço.<BR>(Gerado internamente, não é visualizado na tela)
	 *
	 * @var integer
	 */
	public $nCodServ;
	/**
	 * Código do Status
	 *
	 * @var string
	 */
	public $cCodStatus;
	/**
	 * Descrição do Status
	 *
	 * @var string
	 */
	public $cDescStatus;
}

/**
 * Erro gerado pela aplicação.
 *
 * @pw_element integer $code Codigo do erro
 * @pw_element string $description Descricao do erro
 * @pw_element string $referer Origem do erro
 * @pw_element boolean $fatal Indica se eh um erro fatal
 * @pw_complex omie_fail
 */
if (!class_exists('omie_fail')) {
class omie_fail{
	/**
	 * Codigo do erro
	 *
	 * @var integer
	 */
	public $code;
	/**
	 * Descricao do erro
	 *
	 * @var string
	 */
	public $description;
	/**
	 * Origem do erro
	 *
	 * @var string
	 */
	public $referer;
	/**
	 * Indica se eh um erro fatal
	 *
	 * @var boolean
	 */
	public $fatal;
}
}