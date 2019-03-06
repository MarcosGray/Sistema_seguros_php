<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venda extends CI_Controller {

		
	public function __construct()
	{
		parent::__construct();	
		$this->load->model('Venda_model');
		$this->load->model('Proposta_model');
		$this->load->library('imprimir');
	}
	
	public function index()
	{
		$alerta = NULL;
		$vendas = NULL;
		$campos = $this->input->post();
		if (isset($campos['pesquisar_cpf']) && $campos['pesquisar_cpf'] === 'pesquisar_cpf')
		{
			$vendas = $this->Venda_model->get_venda_cprf($campos['cprf']);
		}
		elseif (isset($campos['pesquisar_cliente']) && $campos['pesquisar_cliente'] === 'pesquisar_cliente')
		{
			$vendas = $this->Venda_model->get_venda_nome_cliente($campos['cliente']);
		}
		$dados = array(
			'alerta' => $alerta,
			'vendas' => $vendas
		);
		$this->load->view('venda/Consulta_cliente_venda', $dados);
	}

	public function gerar_impressao($acao, $tipo, $id)
	{
		if ($tipo === '793')
		{
			$endosso = $this->Venda_model->get_venda_id($id);			
		}
		else 
		{
			$endosso = $this->Proposta_model->get_proposta_id($id);
		}
		$apolice = $this->obter_relatorio_pdf($endosso, $tipo);
		$apolice2 = (array) $apolice;
		$sxml = new SimpleXMLElement($apolice2['ExecutarResult']);
		$imp = (string) $sxml->resultado;
		/* 
		 * 790 = impressão proposta
		 * 793 = impressão apólice 
		 * */
		if ($tipo === '793')
		{
			if ($acao === 'baixar')
			{
				$this->imprimir->converter_base64_pdf_baixar('Apolice', $imp);			
			}
			else 
			{
				$this->imprimir->converter_base64_pdf_imprimir('Apolice', $imp);
			}			
		}
		else 
		{
			if ($acao === 'baixar')
			{
				$this->imprimir->converter_base64_pdf_baixar('Proposta', $imp);
			}
			else
			{
				$this->imprimir->converter_base64_pdf_imprimir('Proposta', $imp);
			}
		}
	}
	
	
	
	public function obter_relatorio_pdf($endosso, $tipo)
	{
		#Homologação
		/* $servicoSeguradora = 'https://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx?wsdl'; */
		
		#Produção
		$servicoSeguradora = 'https://www.usebens.com.br/i4pro/webservice/i4prowebservice.asmx?wsdl';
		// parametros
		$params = array(
				'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
				'trace' => 1,
				'exceptions' => 1,
				'soap_version' => SOAP_1_1,
				'style' => SOAP_DOCUMENT,
				'use' => SOAP_LITERAL,
				'encoding' => 'UTF-8',
				'connection_timeout' => 90
		);
		// Conectar a API UseBens
		$client = new SoapClient($servicoSeguradora, $params);
		//$servico - Nome do serviço a ser chamado
		$servico = 'RelatorioPDF';
		//$xmlEntradaDados = string contendo xml montado.
		$xmlEntradaDados = '<i4proerp>
			 					<obter_relatorio_pdf
			 										id_relatorio	= "'.$tipo.'"
			 										cd_empresa		= "80"
	                                                id_endosso		= "'.$endosso['id_endosso'].'">
								</obter_relatorio_pdf>
		 					</i4proerp>';
		
		$servicoInstanciadoResult = $client->Executar(array('Servico'=>"$servico", 'conteudoXML'=>"$xmlEntradaDados"));
		return $servicoInstanciadoResult;
	}
	
}
