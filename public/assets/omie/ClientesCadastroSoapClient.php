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
 * @service ClientesCadastroSoapClient
 * @author omie
 */
class ClientesCadastroSoapClient {
	/**
	 * The WSDL URI
	 *
	 * @var string
	 */
	public static $_WsdlUri='https://app.omie.com.br/api/v1/geral/clientes/?WSDL';
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
	 * Inclui o cliente no Omie
	 *
	 * @param clientes_cadastro $clientes_cadastro Lista de clientes para cadastro.
	 * @return clientes_status Status de retorno do cadastro de clientes.
	 */
	public function IncluirCliente($clientes_cadastro){
		return self::_Call('IncluirCliente',Array(
			$clientes_cadastro
		));
	}

	/**
	 * Altera os dados do cliente
	 *
	 * @param clientes_cadastro $clientes_cadastro Lista de clientes para cadastro.
	 * @return clientes_status Status de retorno do cadastro de clientes.
	 */
	public function AlterarCliente($clientes_cadastro){
		return self::_Call('AlterarCliente',Array(
			$clientes_cadastro
		));
	}

	/**
	 * Exclui um cliente da base de dados.
	 *
	 * @param clientes_cadastro_chave $clientes_cadastro_chave Chave para pesquisa do cadastro de clientes.
	 * @return clientes_status Status de retorno do cadastro de clientes.
	 */
	public function ExcluirCliente($clientes_cadastro_chave){
		return self::_Call('ExcluirCliente',Array(
			$clientes_cadastro_chave
		));
	}

	/**
	 * Consulta os dados de um cliente
	 *
	 * @param clientes_cadastro_chave $clientes_cadastro_chave Chave para pesquisa do cadastro de clientes.
	 * @return clientes_cadastro Lista de clientes para cadastro.
	 */
	public function ConsultarCliente($clientes_cadastro_chave){
		return self::_Call('ConsultarCliente',Array(
			$clientes_cadastro_chave
		));
	}

	/**
	 * Lista os clientes cadastrados
	 *
	 * @param clientes_list_request $clientes_list_request Lista os clientes cadastrados
	 * @return clientes_listfull_response Lista de clientes cadastrados no omie.
	 */
	public function ListarClientes($clientes_list_request){
		return self::_Call('ListarClientes',Array(
			$clientes_list_request
		));
	}

	/**
	 * Realiza pesquisa dos clientes
	 *
	 * @param clientes_list_request $clientes_list_request Lista os clientes cadastrados
	 * @return clientes_list_response Lista de clientes cadastrados no omie.
	 */
	public function ListarClientesResumido($clientes_list_request){
		return self::_Call('ListarClientesResumido',Array(
			$clientes_list_request
		));
	}

	/**
	 * Rotina para inclusão por lote de clientes.
	 *
	 * @param clientes_lote_request $clientes_lote_request Lote de cadastros de clientes para inclusão, limitado a 50 ocorrências por requisição.
	 * @return clientes_lote_response Resposta do processamento do lote de clientes cadastrados.
	 */
	public function IncluirClientesPorLote($clientes_lote_request){
		return self::_Call('IncluirClientesPorLote',Array(
			$clientes_lote_request
		));
	}

	/**
	 * Realiza o UPSERT da tabela de clientes (INCLUSÃO/ALTERAÇÃO).
	 *
	 * @param clientes_cadastro $clientes_cadastro Lista de clientes para cadastro.
	 * @return clientes_status Status de retorno do cadastro de clientes.
	 */
	public function UpsertCliente($clientes_cadastro){
		return self::_Call('UpsertCliente',Array(
			$clientes_cadastro
		));
	}

	/**
	 * Inclui/Altera clientes por lote.
	 *
	 * @param clientes_lote_request $clientes_lote_request Lote de cadastros de clientes para inclusão, limitado a 50 ocorrências por requisição.
	 * @return clientes_lote_response Resposta do processamento do lote de clientes cadastrados.
	 */
	public function UpsertClientesPorLote($clientes_lote_request){
		return self::_Call('UpsertClientesPorLote',Array(
			$clientes_lote_request
		));
	}

	/**
	 * Associa um código de integração a um cliente cadastrado no Omie.
	 *
	 * @param clientes_cadastro_chave $clientes_cadastro_chave Chave para pesquisa do cadastro de clientes.
	 * @return clientes_status Status de retorno do cadastro de clientes.
	 */
	public function AssociarCodIntCliente($clientes_cadastro_chave){
		return self::_Call('AssociarCodIntCliente',Array(
			$clientes_cadastro_chave
		));
	}
}

/**
 * Características do cliente.
 *
 * @pw_element string $campo Nome da característica.
 * @pw_element string $conteudo Conteúdo do característica.
 * @pw_complex caracteristicas
 */
class caracteristicas{
	/**
	 * Nome da característica.
	 *
	 * @var string
	 */
	public $campo;
	/**
	 * Conteúdo do característica.
	 *
	 * @var string
	 */
	public $conteudo;
}


/**
 * Lista de clientes para cadastro.
 *
 * @pw_element integer $codigo_cliente_omie Código<BR>Interno, gerado automaticamente na inclusão do cliente.<BR>Deve ser informado apenas para alteração/consulta.<BR>Na inclusão utilize a tag "codigo_cliente_integracao".
 * @pw_element string $codigo_cliente_integracao Código de integração do cliente / favorecido.<BR>Código do sistema legado, informe na inclusão do cliente o código que você já utiliza no seu sistema.
 * @pw_element string $razao_social Razão Social<BR>Preenchimento Obrigatório.
 * @pw_element string $cnpj_cpf CNPJ / CPF<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.
 * @pw_element string $nome_fantasia Nome Fantasia<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.
 * @pw_element string $telefone1_ddd DDD Telefone<BR>Preenchimento Opcional.
 * @pw_element string $telefone1_numero Telefone para Contato<BR>Preenchimento Opcional.
 * @pw_element string $contato Nome para contato<BR>Preenchimento Opcional.
 * @pw_element string $endereco Endereço<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
 * @pw_element string $endereco_numero Número do Endereço<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
 * @pw_element string $bairro Bairro<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
 * @pw_element string $complemento Complemento para o Número do Endereço<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
 * @pw_element string $estado Sigla do Estado<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.<BR><BR>Utilize a tag 'cSigla' do método 'ListarEstados' da API<BR>http://app.omie.com.br/api/v1/geral/estados/<BR>para obter essa informação.<BR>
 * @pw_element string $cidade Código da Cidade<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.<BR><BR>Utilize a tag 'cCod' do método 'PesquisarCidades' da API<BR>http://app.omie.com.br/api/v1/geral/cidades/<BR>para obter essa informação.<BR>
 * @pw_element string $cep CEP<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
 * @pw_element string $codigo_pais Código do País<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.<BR><BR>Utilize a tag 'cCodigo' do método 'ListarPaises' da API<BR>http://app.omie.com.br/api/v1/geral/paises/<BR>para obter essa informação.
 * @pw_element string $telefone2_ddd DDD Telefone 2<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
 * @pw_element string $telefone2_numero Telefone 2<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
 * @pw_element string $fax_ddd DDD Fax<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
 * @pw_element string $fax_numero Fax<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
 * @pw_element string $email E-Mail<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
 * @pw_element string $homepage WebSite<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
 * @pw_element string $inscricao_estadual Inscrição Estadual<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
 * @pw_element string $inscricao_municipal Inscrição Municipal<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
 * @pw_element string $inscricao_suframa Inscrição Suframa<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
 * @pw_element string $optante_simples_nacional Indica se o Cliente / Fornecedor é Optante do Simples Nacional <BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informar 'S' ou 'N'.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
 * @pw_element string $tipo_atividade Tipo da Atividade<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.<BR><BR>Utilize a tag 'cCodigo' do método 'ListarTipoAtiv' da API<BR>http://app.omie.com.br/api/v1/geral/tpativ/<BR>para obter essa informação.
 * @pw_element string $cnae Código do CNAE - Fiscal<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.<BR><BR>Utilize a tag 'nCodigo' do método 'ListarCNAE' da API<BR>http://app.omie.com.br/api/v1/produtos/cnae/<BR>para obter essa informação.
 * @pw_element string $produtor_rural Indica se o Cliente / Fornecedor é um Produtor Rural<BR>Preenchimento Opcional.<BR><BR>Informar 'S' ou 'N'.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
 * @pw_element string $contribuinte Indica se o cliente é contribuinte (S/N).<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informar 'S' ou 'N'.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
 * @pw_element string $observacao Observações Internas<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
 * @pw_element string $obs_detalhadas Observações Detalhadas.<BR><BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
 * @pw_element string $recomendacao_atraso Código da Instrução de Protesto<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Recomendações" do cadastro do Cliente.
 * @pw_element tagsArray $tags Tags do Cliente ou Fornecedor<BR>Preenchimento Opcional.
 * @pw_element string $pessoa_fisica Pessoa Física<BR>Preenchimento automático - Não informar.<BR><BR>Informar 'S' ou 'N'.
 * @pw_element string $exterior Indica que é um tomador de serviço localizado no exterior<BR>Preenchimento automático - Não informar.<BR><BR>Informar 'S' ou 'N'.
 * @pw_element string $logradouro DEPRECATED
 * @pw_element string $importado_api Importado pela API (S/N).
 * @pw_element string $bloqueado DEPRECATED
 * @pw_element string $cidade_ibge Código do IBGE para a Cidade.<BR><BR>Essa campo não tem efeito caso informado na inclusão do cliente.<BR><BR>Ela é retornada na listagem de clientes somente.<BR><BR>Não preencher esse campo.<BR><BR>
 * @pw_element decimal $valor_limite_credito Valor do Limite de Crédito Total.<BR><BR>Preenchimento opcional.
 * @pw_element string $bloquear_faturamento Bloquear o faturamento para o cliente (S/N).<BR><BR>Preenchimento opcional.
 * @pw_element recomendacoes $recomendacoes Recomendações do cliente.
 * @pw_element enderecoEntrega $enderecoEntrega Dados do Endereço de Entrega.
 * @pw_element string $nif NIF - Número de Identificação Fiscal.<BR><BR>Apenas para estrangeiros.
 * @pw_element string $documento_exterior Documento no exterior para clientes estrangeiros.
 * @pw_element string $inativo Indica se o cliente está inativo [S/N]
 * @pw_element dadosBancarios $dadosBancarios Dados Bancários do cliente.
 * @pw_element caracteristicasArray $caracteristicas Características do cliente.
 * @pw_element info $info Informações sobre o cadastro do cliente.
 * @pw_element string $bloquear_exclusao Bloqueia a exclusão do registro. (S/N)
 * @pw_complex clientes_cadastro
 */
class clientes_cadastro{
	/**
	 * Código<BR>Interno, gerado automaticamente na inclusão do cliente.<BR>Deve ser informado apenas para alteração/consulta.<BR>Na inclusão utilize a tag "codigo_cliente_integracao".
	 *
	 * @var integer
	 */
	public $codigo_cliente_omie;
	/**
	 * Código de integração do cliente / favorecido.<BR>Código do sistema legado, informe na inclusão do cliente o código que você já utiliza no seu sistema.
	 *
	 * @var string
	 */
	public $codigo_cliente_integracao;
	/**
	 * Razão Social<BR>Preenchimento Obrigatório.
	 *
	 * @var string
	 */
	public $razao_social;
	/**
	 * CNPJ / CPF<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.
	 *
	 * @var string
	 */
	public $cnpj_cpf;
	/**
	 * Nome Fantasia<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.
	 *
	 * @var string
	 */
	public $nome_fantasia;
	/**
	 * DDD Telefone<BR>Preenchimento Opcional.
	 *
	 * @var string
	 */
	public $telefone1_ddd;
	/**
	 * Telefone para Contato<BR>Preenchimento Opcional.
	 *
	 * @var string
	 */
	public $telefone1_numero;
	/**
	 * Nome para contato<BR>Preenchimento Opcional.
	 *
	 * @var string
	 */
	public $contato;
	/**
	 * Endereço<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $endereco;
	/**
	 * Número do Endereço<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $endereco_numero;
	/**
	 * Bairro<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $bairro;
	/**
	 * Complemento para o Número do Endereço<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $complemento;
	/**
	 * Sigla do Estado<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.<BR><BR>Utilize a tag 'cSigla' do método 'ListarEstados' da API<BR>http://app.omie.com.br/api/v1/geral/estados/<BR>para obter essa informação.<BR>
	 *
	 * @var string
	 */
	public $estado;
	/**
	 * Código da Cidade<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.<BR><BR>Utilize a tag 'cCod' do método 'PesquisarCidades' da API<BR>http://app.omie.com.br/api/v1/geral/cidades/<BR>para obter essa informação.<BR>
	 *
	 * @var string
	 */
	public $cidade;
	/**
	 * CEP<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $cep;
	/**
	 * Código do País<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.<BR><BR>Utilize a tag 'cCodigo' do método 'ListarPaises' da API<BR>http://app.omie.com.br/api/v1/geral/paises/<BR>para obter essa informação.
	 *
	 * @var string
	 */
	public $codigo_pais;
	/**
	 * DDD Telefone 2<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $telefone2_ddd;
	/**
	 * Telefone 2<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $telefone2_numero;
	/**
	 * DDD Fax<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $fax_ddd;
	/**
	 * Fax<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $fax_numero;
	/**
	 * E-Mail<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $email;
	/**
	 * WebSite<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $homepage;
	/**
	 * Inscrição Estadual<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $inscricao_estadual;
	/**
	 * Inscrição Municipal<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $inscricao_municipal;
	/**
	 * Inscrição Suframa<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $inscricao_suframa;
	/**
	 * Indica se o Cliente / Fornecedor é Optante do Simples Nacional <BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informar 'S' ou 'N'.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $optante_simples_nacional;
	/**
	 * Tipo da Atividade<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.<BR><BR>Utilize a tag 'cCodigo' do método 'ListarTipoAtiv' da API<BR>http://app.omie.com.br/api/v1/geral/tpativ/<BR>para obter essa informação.
	 *
	 * @var string
	 */
	public $tipo_atividade;
	/**
	 * Código do CNAE - Fiscal<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.<BR><BR>Utilize a tag 'nCodigo' do método 'ListarCNAE' da API<BR>http://app.omie.com.br/api/v1/produtos/cnae/<BR>para obter essa informação.
	 *
	 * @var string
	 */
	public $cnae;
	/**
	 * Indica se o Cliente / Fornecedor é um Produtor Rural<BR>Preenchimento Opcional.<BR><BR>Informar 'S' ou 'N'.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $produtor_rural;
	/**
	 * Indica se o cliente é contribuinte (S/N).<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informar 'S' ou 'N'.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $contribuinte;
	/**
	 * Observações Internas<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $observacao;
	/**
	 * Observações Detalhadas.<BR><BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $obs_detalhadas;
	/**
	 * Código da Instrução de Protesto<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Recomendações" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $recomendacao_atraso;
	/**
	 * Tags do Cliente ou Fornecedor<BR>Preenchimento Opcional.
	 *
	 * @var tagsArray
	 */
	public $tags;
	/**
	 * Pessoa Física<BR>Preenchimento automático - Não informar.<BR><BR>Informar 'S' ou 'N'.
	 *
	 * @var string
	 */
	public $pessoa_fisica;
	/**
	 * Indica que é um tomador de serviço localizado no exterior<BR>Preenchimento automático - Não informar.<BR><BR>Informar 'S' ou 'N'.
	 *
	 * @var string
	 */
	public $exterior;
	/**
	 * DEPRECATED
	 *
	 * @var string
	 */
	public $logradouro;
	/**
	 * Importado pela API (S/N).
	 *
	 * @var string
	 */
	public $importado_api;
	/**
	 * DEPRECATED
	 *
	 * @var string
	 */
	public $bloqueado;
	/**
	 * Código do IBGE para a Cidade.<BR><BR>Essa campo não tem efeito caso informado na inclusão do cliente.<BR><BR>Ela é retornada na listagem de clientes somente.<BR><BR>Não preencher esse campo.<BR><BR>
	 *
	 * @var string
	 */
	public $cidade_ibge;
	/**
	 * Valor do Limite de Crédito Total.<BR><BR>Preenchimento opcional.
	 *
	 * @var decimal
	 */
	public $valor_limite_credito;
	/**
	 * Bloquear o faturamento para o cliente (S/N).<BR><BR>Preenchimento opcional.
	 *
	 * @var string
	 */
	public $bloquear_faturamento;
	/**
	 * Recomendações do cliente.
	 *
	 * @var recomendacoes
	 */
	public $recomendacoes;
	/**
	 * Dados do Endereço de Entrega.
	 *
	 * @var enderecoEntrega
	 */
	public $enderecoEntrega;
	/**
	 * NIF - Número de Identificação Fiscal.<BR><BR>Apenas para estrangeiros.
	 *
	 * @var string
	 */
	public $nif;
	/**
	 * Documento no exterior para clientes estrangeiros.
	 *
	 * @var string
	 */
	public $documento_exterior;
	/**
	 * Indica se o cliente está inativo [S/N]
	 *
	 * @var string
	 */
	public $inativo;
	/**
	 * Dados Bancários do cliente.
	 *
	 * @var dadosBancarios
	 */
	public $dadosBancarios;
	/**
	 * Características do cliente.
	 *
	 * @var caracteristicasArray
	 */
	public $caracteristicas;
	/**
	 * Informações sobre o cadastro do cliente.
	 *
	 * @var info
	 */
	public $info;
	/**
	 * Bloqueia a exclusão do registro. (S/N)
	 *
	 * @var string
	 */
	public $bloquear_exclusao;
}


/**
 * Tags do Cliente ou Fornecedor
 *
 * @pw_element string $tag Tag do Cliente ou Fornecedor
 * @pw_complex tags
 */
class tags{
	/**
	 * Tag do Cliente ou Fornecedor
	 *
	 * @var string
	 */
	public $tag;
}


/**
 * Recomendações do cliente.
 *
 * @pw_element string $numero_parcelas Número de Parcelas padrão para as Vendas.
 * @pw_element integer $codigo_vendedor Código do Vendedor padrão.
 * @pw_element string $email_fatura Enviar a NF-e e Boleto para outro e-mail?
 * @pw_element string $gerar_boletos Por padrão: Gerar Boletos ao Emitir NF-e?
 * @pw_complex recomendacoes
 */
class recomendacoes{
	/**
	 * Número de Parcelas padrão para as Vendas.
	 *
	 * @var string
	 */
	public $numero_parcelas;
	/**
	 * Código do Vendedor padrão.
	 *
	 * @var integer
	 */
	public $codigo_vendedor;
	/**
	 * Enviar a NF-e e Boleto para outro e-mail?
	 *
	 * @var string
	 */
	public $email_fatura;
	/**
	 * Por padrão: Gerar Boletos ao Emitir NF-e?
	 *
	 * @var string
	 */
	public $gerar_boletos;
}

/**
 * Dados do Endereço de Entrega.
 *
 * @pw_element string $entCnpjCpf CNPJ / CPF do recebedor.
 * @pw_element string $entEndereco Endereço.
 * @pw_element string $entNumero Número do endereço.
 * @pw_element string $entComplemento Complemento do endereço.
 * @pw_element string $entBairro Bairro.
 * @pw_element string $entCEP CEP
 * @pw_element string $entEstado Estado.
 * @pw_element string $entCidade Cidade
 * @pw_complex enderecoEntrega
 */
class enderecoEntrega{
	/**
	 * CNPJ / CPF do recebedor.
	 *
	 * @var string
	 */
	public $entCnpjCpf;
	/**
	 * Endereço.
	 *
	 * @var string
	 */
	public $entEndereco;
	/**
	 * Número do endereço.
	 *
	 * @var string
	 */
	public $entNumero;
	/**
	 * Complemento do endereço.
	 *
	 * @var string
	 */
	public $entComplemento;
	/**
	 * Bairro.
	 *
	 * @var string
	 */
	public $entBairro;
	/**
	 * CEP
	 *
	 * @var string
	 */
	public $entCEP;
	/**
	 * Estado.
	 *
	 * @var string
	 */
	public $entEstado;
	/**
	 * Cidade
	 *
	 * @var string
	 */
	public $entCidade;
}

/**
 * Dados Bancários do cliente.
 *
 * @pw_element string $codigo_banco Código do Banco.
 * @pw_element string $agencia Agência
 * @pw_element string $conta_corrente Número da Conta Corrente.
 * @pw_element string $doc_titular CNPJ ou CPF do titular.
 * @pw_element string $nome_titular Nome do titular.
 * @pw_complex dadosBancarios
 */
class dadosBancarios{
	/**
	 * Código do Banco.
	 *
	 * @var string
	 */
	public $codigo_banco;
	/**
	 * Agência
	 *
	 * @var string
	 */
	public $agencia;
	/**
	 * Número da Conta Corrente.
	 *
	 * @var string
	 */
	public $conta_corrente;
	/**
	 * CNPJ ou CPF do titular.
	 *
	 * @var string
	 */
	public $doc_titular;
	/**
	 * Nome do titular.
	 *
	 * @var string
	 */
	public $nome_titular;
}

/**
 * Informações sobre o cadastro do cliente.
 *
 * @pw_element string $dInc Data da Inclusão.<BR>No formato dd/mm/aaaa.
 * @pw_element string $hInc Hora da Inclusão.<BR>No formato hh:mm:ss.
 * @pw_element string $uInc Número da Conta Corrente.
 * @pw_element string $dAlt Data da Alteração.<BR>No formato dd/mm/aaaa.
 * @pw_element string $hAlt Hora da Alteração.<BR>No formato hh:mm:ss.
 * @pw_element string $uAlt Usuário da Alteração.
 * @pw_element string $cImpAPI Importado pela API (S/N).
 * @pw_complex info
 */
class info{
	/**
	 * Data da Inclusão.<BR>No formato dd/mm/aaaa.
	 *
	 * @var string
	 */
	public $dInc;
	/**
	 * Hora da Inclusão.<BR>No formato hh:mm:ss.
	 *
	 * @var string
	 */
	public $hInc;
	/**
	 * Número da Conta Corrente.
	 *
	 * @var string
	 */
	public $uInc;
	/**
	 * Data da Alteração.<BR>No formato dd/mm/aaaa.
	 *
	 * @var string
	 */
	public $dAlt;
	/**
	 * Hora da Alteração.<BR>No formato hh:mm:ss.
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
}

/**
 * Chave para pesquisa do cadastro de clientes.
 *
 * @pw_element integer $codigo_cliente_omie Código<BR>Interno, gerado automaticamente na inclusão do cliente.<BR>Deve ser informado apenas para alteração/consulta.<BR>Na inclusão utilize a tag "codigo_cliente_integracao".
 * @pw_element string $codigo_cliente_integracao Código de integração do cliente / favorecido.<BR>Código do sistema legado, informe na inclusão do cliente o código que você já utiliza no seu sistema.
 * @pw_complex clientes_cadastro_chave
 */
class clientes_cadastro_chave{
	/**
	 * Código<BR>Interno, gerado automaticamente na inclusão do cliente.<BR>Deve ser informado apenas para alteração/consulta.<BR>Na inclusão utilize a tag "codigo_cliente_integracao".
	 *
	 * @var integer
	 */
	public $codigo_cliente_omie;
	/**
	 * Código de integração do cliente / favorecido.<BR>Código do sistema legado, informe na inclusão do cliente o código que você já utiliza no seu sistema.
	 *
	 * @var string
	 */
	public $codigo_cliente_integracao;
}

/**
 * Cadastro reduzido de produtos
 *
 * @pw_element integer $codigo_cliente Código<BR>Interno, gerado automaticamente na inclusão do cliente.<BR>Deve ser informado apenas para alteração/consulta.<BR>Na inclusão utilize a tag "codigo_cliente_integracao".
 * @pw_element string $codigo_cliente_integracao Código de integração do cliente / favorecido.<BR>Código do sistema legado, informe na inclusão do cliente o código que você já utiliza no seu sistema.
 * @pw_element string $razao_social Razão Social<BR>Preenchimento Obrigatório.
 * @pw_element string $nome_fantasia Nome Fantasia<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.
 * @pw_element string $cnpj_cpf CNPJ / CPF<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.
 * @pw_complex clientes_cadastro_resumido
 */
class clientes_cadastro_resumido{
	/**
	 * Código<BR>Interno, gerado automaticamente na inclusão do cliente.<BR>Deve ser informado apenas para alteração/consulta.<BR>Na inclusão utilize a tag "codigo_cliente_integracao".
	 *
	 * @var integer
	 */
	public $codigo_cliente;
	/**
	 * Código de integração do cliente / favorecido.<BR>Código do sistema legado, informe na inclusão do cliente o código que você já utiliza no seu sistema.
	 *
	 * @var string
	 */
	public $codigo_cliente_integracao;
	/**
	 * Razão Social<BR>Preenchimento Obrigatório.
	 *
	 * @var string
	 */
	public $razao_social;
	/**
	 * Nome Fantasia<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.
	 *
	 * @var string
	 */
	public $nome_fantasia;
	/**
	 * CNPJ / CPF<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.
	 *
	 * @var string
	 */
	public $cnpj_cpf;
}


/**
 * Lista os clientes cadastrados
 *
 * @pw_element integer $pagina Número da página retornada
 * @pw_element integer $registros_por_pagina Número de registros retornados na página.
 * @pw_element string $apenas_importado_api Exibir apenas os registros gerados pela API
 * @pw_element string $ordenar_por Ordem de exibição dos dados. Padrão: Código.
 * @pw_element string $ordem_decrescente Se a lista será apresentada em ordem decrescente.
 * @pw_element string $filtrar_por_data_de Filtrar os registros a partir de uma data.
 * @pw_element string $filtrar_por_data_ate Filtrar os registros até uma data.
 * @pw_element string $filtrar_por_hora_de Filtro por hora a apartir de.
 * @pw_element string $filtrar_por_hora_ate Filtro por hora até.
 * @pw_element string $filtrar_apenas_inclusao Filtrar apenas os registros incluídos.
 * @pw_element string $filtrar_apenas_alteracao Filtrar apenas os registros alterados.
 * @pw_element clientesFiltro $clientesFiltro Filtrar cadastro de clientes&nbsp;&nbsp;
 * @pw_element clientesPorCodigoArray $clientesPorCodigo Lista de Códigos para filtro de clientes
 * @pw_element string $exibir_caracteristicas Exibe as caracteristicas do cliente.
 * @pw_element string $ordem_descrescente DEPRECATED
 * @pw_complex clientes_list_request
 */
class clientes_list_request{
	/**
	 * Número da página retornada
	 *
	 * @var integer
	 */
	public $pagina;
	/**
	 * Número de registros retornados na página.
	 *
	 * @var integer
	 */
	public $registros_por_pagina;
	/**
	 * Exibir apenas os registros gerados pela API
	 *
	 * @var string
	 */
	public $apenas_importado_api;
	/**
	 * Ordem de exibição dos dados. Padrão: Código.
	 *
	 * @var string
	 */
	public $ordenar_por;
	/**
	 * Se a lista será apresentada em ordem decrescente.
	 *
	 * @var string
	 */
	public $ordem_decrescente;
	/**
	 * Filtrar os registros a partir de uma data.
	 *
	 * @var string
	 */
	public $filtrar_por_data_de;
	/**
	 * Filtrar os registros até uma data.
	 *
	 * @var string
	 */
	public $filtrar_por_data_ate;
	/**
	 * Filtro por hora a apartir de.
	 *
	 * @var string
	 */
	public $filtrar_por_hora_de;
	/**
	 * Filtro por hora até.
	 *
	 * @var string
	 */
	public $filtrar_por_hora_ate;
	/**
	 * Filtrar apenas os registros incluídos.
	 *
	 * @var string
	 */
	public $filtrar_apenas_inclusao;
	/**
	 * Filtrar apenas os registros alterados.
	 *
	 * @var string
	 */
	public $filtrar_apenas_alteracao;
	/**
	 * Filtrar cadastro de clientes&nbsp;&nbsp;
	 *
	 * @var clientesFiltro
	 */
	public $clientesFiltro;
	/**
	 * Lista de Códigos para filtro de clientes
	 *
	 * @var clientesPorCodigoArray
	 */
	public $clientesPorCodigo;
	/**
	 * Exibe as caracteristicas do cliente.
	 *
	 * @var string
	 */
	public $exibir_caracteristicas;
	/**
	 * DEPRECATED
	 *
	 * @var string
	 */
	public $ordem_descrescente;
}

/**
 * Filtrar cadastro de clientes
 *
 * @pw_element integer $codigo_cliente_omie Código<BR>Interno, gerado automaticamente na inclusão do cliente.<BR>Deve ser informado apenas para alteração/consulta.<BR>Na inclusão utilize a tag "codigo_cliente_integracao".
 * @pw_element string $codigo_cliente_integracao Código de integração do cliente / favorecido.<BR>Código do sistema legado, informe na inclusão do cliente o código que você já utiliza no seu sistema.
 * @pw_element string $cnpj_cpf CNPJ / CPF<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.
 * @pw_element string $razao_social Razão Social<BR>Preenchimento Obrigatório.
 * @pw_element string $nome_fantasia Nome Fantasia<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.
 * @pw_element string $endereco Endereço<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
 * @pw_element string $bairro Bairro<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
 * @pw_element string $cidade Código da Cidade<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.<BR><BR>Utilize a tag 'cCod' do método 'PesquisarCidades' da API<BR>http://app.omie.com.br/api/v1/geral/cidades/<BR>para obter essa informação.<BR>
 * @pw_element string $estado Sigla do Estado<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.<BR><BR>Utilize a tag 'cSigla' do método 'ListarEstados' da API<BR>http://app.omie.com.br/api/v1/geral/estados/<BR>para obter essa informação.<BR>
 * @pw_element string $cep CEP<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
 * @pw_element string $contato Nome para contato<BR>Preenchimento Opcional.
 * @pw_element string $email E-Mail<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
 * @pw_element string $homepage WebSite<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
 * @pw_element string $inscricao_municipal Inscrição Municipal<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
 * @pw_element string $inscricao_estadual Inscrição Estadual<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
 * @pw_element string $inscricao_suframa Inscrição Suframa<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
 * @pw_element string $pessoa_fisica Pessoa Física<BR>Preenchimento automático - Não informar.<BR><BR>Informar 'S' ou 'N'.
 * @pw_element string $optante_simples_nacional Indica se o Cliente / Fornecedor é Optante do Simples Nacional <BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informar 'S' ou 'N'.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
 * @pw_element string $inativo Indica se o cliente está inativo [S/N]
 * @pw_element tagsArray $tags Tags do Cliente ou Fornecedor<BR>Preenchimento Opcional.
 * @pw_complex clientesFiltro
 */
class clientesFiltro{
	/**
	 * Código<BR>Interno, gerado automaticamente na inclusão do cliente.<BR>Deve ser informado apenas para alteração/consulta.<BR>Na inclusão utilize a tag "codigo_cliente_integracao".
	 *
	 * @var integer
	 */
	public $codigo_cliente_omie;
	/**
	 * Código de integração do cliente / favorecido.<BR>Código do sistema legado, informe na inclusão do cliente o código que você já utiliza no seu sistema.
	 *
	 * @var string
	 */
	public $codigo_cliente_integracao;
	/**
	 * CNPJ / CPF<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.
	 *
	 * @var string
	 */
	public $cnpj_cpf;
	/**
	 * Razão Social<BR>Preenchimento Obrigatório.
	 *
	 * @var string
	 */
	public $razao_social;
	/**
	 * Nome Fantasia<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.
	 *
	 * @var string
	 */
	public $nome_fantasia;
	/**
	 * Endereço<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $endereco;
	/**
	 * Bairro<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $bairro;
	/**
	 * Código da Cidade<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.<BR><BR>Utilize a tag 'cCod' do método 'PesquisarCidades' da API<BR>http://app.omie.com.br/api/v1/geral/cidades/<BR>para obter essa informação.<BR>
	 *
	 * @var string
	 */
	public $cidade;
	/**
	 * Sigla do Estado<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.<BR><BR>Utilize a tag 'cSigla' do método 'ListarEstados' da API<BR>http://app.omie.com.br/api/v1/geral/estados/<BR>para obter essa informação.<BR>
	 *
	 * @var string
	 */
	public $estado;
	/**
	 * CEP<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Endereço" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $cep;
	/**
	 * Nome para contato<BR>Preenchimento Opcional.
	 *
	 * @var string
	 */
	public $contato;
	/**
	 * E-Mail<BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $email;
	/**
	 * WebSite<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Telefones e E-mail" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $homepage;
	/**
	 * Inscrição Municipal<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $inscricao_municipal;
	/**
	 * Inscrição Estadual<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $inscricao_estadual;
	/**
	 * Inscrição Suframa<BR>Preenchimento Opcional.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $inscricao_suframa;
	/**
	 * Pessoa Física<BR>Preenchimento automático - Não informar.<BR><BR>Informar 'S' ou 'N'.
	 *
	 * @var string
	 */
	public $pessoa_fisica;
	/**
	 * Indica se o Cliente / Fornecedor é Optante do Simples Nacional <BR>Preenchimento Opcional.<BR>Preenchimento Obrigatório para emissão de NF-e/NFS-e.<BR><BR>Informar 'S' ou 'N'.<BR><BR>Informação localizada na Aba "Inscrições CNAE e Outros" do cadastro do Cliente.
	 *
	 * @var string
	 */
	public $optante_simples_nacional;
	/**
	 * Indica se o cliente está inativo [S/N]
	 *
	 * @var string
	 */
	public $inativo;
	/**
	 * Tags do Cliente ou Fornecedor<BR>Preenchimento Opcional.
	 *
	 * @var tagsArray
	 */
	public $tags;
}

/**
 * Lista de Códigos para filtro de clientes
 *
 * @pw_element integer $codigo_cliente_omie Código<BR>Interno, gerado automaticamente na inclusão do cliente.<BR>Deve ser informado apenas para alteração/consulta.<BR>Na inclusão utilize a tag "codigo_cliente_integracao".
 * @pw_element string $codigo_cliente_integracao Código de integração do cliente / favorecido.<BR>Código do sistema legado, informe na inclusão do cliente o código que você já utiliza no seu sistema.
 * @pw_complex clientesPorCodigo
 */
class clientesPorCodigo{
	/**
	 * Código<BR>Interno, gerado automaticamente na inclusão do cliente.<BR>Deve ser informado apenas para alteração/consulta.<BR>Na inclusão utilize a tag "codigo_cliente_integracao".
	 *
	 * @var integer
	 */
	public $codigo_cliente_omie;
	/**
	 * Código de integração do cliente / favorecido.<BR>Código do sistema legado, informe na inclusão do cliente o código que você já utiliza no seu sistema.
	 *
	 * @var string
	 */
	public $codigo_cliente_integracao;
}


/**
 * Lista de clientes cadastrados no omie.
 *
 * @pw_element integer $pagina Número da página retornada
 * @pw_element integer $total_de_paginas Número total de páginas
 * @pw_element integer $registros Número de registros retornados na página.
 * @pw_element integer $total_de_registros total de registros encontrados
 * @pw_element clientes_cadastro_resumidoArray $clientes_cadastro_resumido Cadastro reduzido de produtos
 * @pw_complex clientes_list_response
 */
class clientes_list_response{
	/**
	 * Número da página retornada
	 *
	 * @var integer
	 */
	public $pagina;
	/**
	 * Número total de páginas
	 *
	 * @var integer
	 */
	public $total_de_paginas;
	/**
	 * Número de registros retornados na página.
	 *
	 * @var integer
	 */
	public $registros;
	/**
	 * total de registros encontrados
	 *
	 * @var integer
	 */
	public $total_de_registros;
	/**
	 * Cadastro reduzido de produtos
	 *
	 * @var clientes_cadastro_resumidoArray
	 */
	public $clientes_cadastro_resumido;
}

/**
 * Lista de clientes cadastrados no omie.
 *
 * @pw_element integer $pagina Número da página retornada
 * @pw_element integer $total_de_paginas Número total de páginas
 * @pw_element integer $registros Número de registros retornados na página.
 * @pw_element integer $total_de_registros total de registros encontrados
 * @pw_element clientes_cadastroArray $clientes_cadastro Lista de clientes para cadastro.
 * @pw_complex clientes_listfull_response
 */
class clientes_listfull_response{
	/**
	 * Número da página retornada
	 *
	 * @var integer
	 */
	public $pagina;
	/**
	 * Número total de páginas
	 *
	 * @var integer
	 */
	public $total_de_paginas;
	/**
	 * Número de registros retornados na página.
	 *
	 * @var integer
	 */
	public $registros;
	/**
	 * total de registros encontrados
	 *
	 * @var integer
	 */
	public $total_de_registros;
	/**
	 * Lista de clientes para cadastro.
	 *
	 * @var clientes_cadastroArray
	 */
	public $clientes_cadastro;
}

/**
 * Lote de cadastros de clientes para inclusão, limitado a 50 ocorrências por requisição.
 *
 * @pw_element integer $lote Número do lote
 * @pw_element clientes_cadastroArray $clientes_cadastro Lista de clientes para cadastro.
 * @pw_complex clientes_lote_request
 */
class clientes_lote_request{
	/**
	 * Número do lote
	 *
	 * @var integer
	 */
	public $lote;
	/**
	 * Lista de clientes para cadastro.
	 *
	 * @var clientes_cadastroArray
	 */
	public $clientes_cadastro;
}

/**
 * Resposta do processamento do lote de clientes cadastrados.
 *
 * @pw_element integer $lote Número do lote
 * @pw_element string $codigo_status Código do status do processamento.<BR>Se o retorno for '0' significa que a solicitação foi executada com sucesso.<BR>Se o retorno for maior que '0' ocorreu algum erro durante o processamento da solicitação.<BR>A tag 'cDesStatus' descreve o problema ocorrido.
 * @pw_element string $descricao_status Descrição do status do processamento.<BR>Essa tag explica o resultado da tag 'cCodigoStatus'.
 * @pw_complex clientes_lote_response
 */
class clientes_lote_response{
	/**
	 * Número do lote
	 *
	 * @var integer
	 */
	public $lote;
	/**
	 * Código do status do processamento.<BR>Se o retorno for '0' significa que a solicitação foi executada com sucesso.<BR>Se o retorno for maior que '0' ocorreu algum erro durante o processamento da solicitação.<BR>A tag 'cDesStatus' descreve o problema ocorrido.
	 *
	 * @var string
	 */
	public $codigo_status;
	/**
	 * Descrição do status do processamento.<BR>Essa tag explica o resultado da tag 'cCodigoStatus'.
	 *
	 * @var string
	 */
	public $descricao_status;
}

/**
 * Status de retorno do cadastro de clientes.
 *
 * @pw_element integer $codigo_cliente_omie Código<BR>Interno, gerado automaticamente na inclusão do cliente.<BR>Deve ser informado apenas para alteração/consulta.<BR>Na inclusão utilize a tag "codigo_cliente_integracao".
 * @pw_element string $codigo_cliente_integracao Código de integração do cliente / favorecido.<BR>Código do sistema legado, informe na inclusão do cliente o código que você já utiliza no seu sistema.
 * @pw_element string $codigo_status Código do status do processamento.<BR>Se o retorno for '0' significa que a solicitação foi executada com sucesso.<BR>Se o retorno for maior que '0' ocorreu algum erro durante o processamento da solicitação.<BR>A tag 'cDesStatus' descreve o problema ocorrido.
 * @pw_element string $descricao_status Descrição do status do processamento.<BR>Essa tag explica o resultado da tag 'cCodigoStatus'.
 * @pw_complex clientes_status
 */
class clientes_status{
	/**
	 * Código<BR>Interno, gerado automaticamente na inclusão do cliente.<BR>Deve ser informado apenas para alteração/consulta.<BR>Na inclusão utilize a tag "codigo_cliente_integracao".
	 *
	 * @var integer
	 */
	public $codigo_cliente_omie;
	/**
	 * Código de integração do cliente / favorecido.<BR>Código do sistema legado, informe na inclusão do cliente o código que você já utiliza no seu sistema.
	 *
	 * @var string
	 */
	public $codigo_cliente_integracao;
	/**
	 * Código do status do processamento.<BR>Se o retorno for '0' significa que a solicitação foi executada com sucesso.<BR>Se o retorno for maior que '0' ocorreu algum erro durante o processamento da solicitação.<BR>A tag 'cDesStatus' descreve o problema ocorrido.
	 *
	 * @var string
	 */
	public $codigo_status;
	/**
	 * Descrição do status do processamento.<BR>Essa tag explica o resultado da tag 'cCodigoStatus'.
	 *
	 * @var string
	 */
	public $descricao_status;
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