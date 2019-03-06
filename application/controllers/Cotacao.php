<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cotacao extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('Cotacao_model');
		$this->load->model('Revenda_model');
		$this->load->model('Clientes_model');
		$this->load->model('Combustivel_model');
		$this->load->model('Categoria_tarifaria_model');
		$this->load->model('Estado_civil_model');
		$this->load->model('Forma_pagamento_model');
		$this->load->model('Proposta_model');
		$this->load->model('Venda_model');
		$this->load->library('funcoes');
		$this->load->helper('file');
		date_default_timezone_set('America/Fortaleza');
		ini_set('default_socket_timeout', 600);
	}

	public function index()
	{
		$alerta = NULL;
		$clientes = NULL;
		$retornos = NULL;
		$campos = $this->input->post();
		if (isset($campos['pesquisar_cpf']) && $campos['pesquisar_cpf'] === 'pesquisar_cpf')
		{
			$clientes = $this->Clientes_model->get_clientes_cprf($campos['cprf']);
		}
		elseif (isset($campos['pesquisar_cliente']) && $campos['pesquisar_cliente'] === 'pesquisar_cliente')
		{
			$clientes = $this->Clientes_model->get_clientes_nome($campos['cliente']);
		}
		$dados = array(
				'alerta'	=> $alerta,
				'clientes'	=> $clientes,
				'retornos'	=> $retornos
		);		
		$this->load->view('cotacao/Consulta_cliente_cotacao', $dados);
	}


	public function pesquisa_marcas_fipe($id = NULL, $alerta = NULL)
	{
		($id === NULL)? $cliente = NULL : $cliente = $this->Clientes_model->get_cliente_id($id);
		$cobertura = $this->apolice_cobertura_retorno_usebens();
		$marca = read_file('http://fipeapi.appspot.com/api/1/carros/marcas.json');
		
		if (!isset($marca) && empty($marca))
		{
			$resultado = NULL;
			$revenda = NULL;
			$cliente = NULL;
			$combustiveis = NULL;
			$cobertura = NULL;
			
		}
		else 
		{
			$resultado = json_decode($marca, true);
			$revenda = $this->Revenda_model->get_revenda();
			$combustiveis = $this->Combustivel_model->get_todos_combustiveis();	
		}
		$dados = array(
				'alerta' => $alerta,
				'marcas' => $resultado,
				'revenda'=> $revenda,
				'cliente'=> $cliente,
				'combustiveis' => $combustiveis,
				'coberturas' => $cobertura
		);
		$this->load->view('cotacao/Consulta_cotacao', $dados);
	}

	public function apolice_cobertura_retorno_usebens()
	{
		$apolice = $this->pesquisar_apolice_sub_cobertura_auto();
		$apolice2 = (array) $apolice;
		$sxml = new SimpleXMLElement($apolice2['ExecutarResult']);
		$qt = count($sxml->servico->revenda->apolice->sub_estipulante->coberturas);
		for ($i = 0; $i < $qt; $i++)
		{
			$cobertura[] = $sxml->servico->revenda->apolice->sub_estipulante->coberturas[$i]->attributes();
		}
		return $cobertura;
	}


	public function pesquisa_veiculo_fipe()
	{
		$id = $this->input->post('id_marca');
		$veiculo = read_file('http://fipeapi.appspot.com/api/1/carros/veiculos/'.$id.'.json');
		$resultado_veiculo = json_decode($veiculo, true);
		$this->select_veiculos_fipe($resultado_veiculo);
	}


	public function select_veiculos_fipe($dados = NULL)
	{
		$options = '<option value=""> Selecione o veículo</options>';
		foreach ($dados as $linha)
		{
			$options .= '<option value="'.$linha['id'].'">'.$linha['name'].'</option>';
		}
		echo $options;
	}

	public function pesquisa_modelo_fipe()
	{
		$id = $this->input->post('id_marca');
		$id_veiculo= $this->input->post('id_veiculo');
		$modelo = read_file('http://fipeapi.appspot.com/api/1/carros/veiculo/'.$id.'/'.$id_veiculo.'.json');
		
		$resultado_modelo = json_decode($modelo, true);
		$this->select_modelos_fipe($resultado_modelo);
	}

	public function select_modelos_fipe($dados = NULL)
	{
		
		$options = '<option value=""> Selecione o modelo</options>';
		foreach ($dados as $linha)
		{
			$options .= '<option value="'.$linha['id'].'">'.$linha['name'].'</option>';
		}
		echo $options;
	}

	public function pesquisa_tabela_fipe()
	{
		$id = $this->input->post('id_marca');
		$id_veiculo= $this->input->post('id_veiculo');
		$id_modelo = $this->input->post('id_modelo');
		$tabela = read_file('http://fipeapi.appspot.com/api/1/carros/veiculo/'.$id.'/'.$id_veiculo.'/'.$id_modelo.'.json');
		$resultado_tabela = json_decode($tabela, true);
		$categoria_tarifaria = $this->Categoria_tarifaria_model->get_modelo_categoria_tarifaria($resultado_tabela['fipe_codigo']);
		
		$cdfipe = '
					<div class="form-group col-lg-2 col-sm-2" >
						<label for="cd_fipe">Código FIPE*</label>
						<input type="text" class="form-control" id="cd_fipe" name="cd_fipe" value="'.$resultado_tabela['fipe_codigo'].'" readonly="readonly" >
						<input type="hidden" id="marca" name="marca" value="'.$resultado_tabela['marca'].'" >
						<input type="hidden" id="veiculo" name="veiculo" value="'.$resultado_tabela['veiculo'].'" >
						<input type="hidden" id="preco" name="preco" value="'.$resultado_tabela['preco'].'" >
						<input type="hidden" id="referencia" name="referencia" value="'.$resultado_tabela['referencia'].'" >
					</div>
					<div class="form-group col-lg-2 col-sm-2" >
						<label for="nr_ano_auto">Ano do veículo*</label>
						<input type="text" class="form-control" id="nr_ano_auto" name="nr_ano_auto" value="'.$resultado_tabela['ano_modelo'].'" readonly="readonly" >
					</div>
					<div class="form-group col-lg-2 col-sm-2" >
						<label for="cd_categoria_tarifaria">Categoria Tarifária*</label>
						<input type="text" class="form-control" id="cd_categoria_tarifaria" name="cd_categoria_tarifaria" value="'.$categoria_tarifaria['categoria_tarifaria'].'"  readonly="readonly" >
					</div>
				';

		echo $cdfipe;
	}


	public function enviar_cotacao_webservice_salvar_base()
	{
		$cotacao = $this->input->post();
		
		$acao = NULL;
		$cotacao['nr_cpf_cnpj_cliente'] = $this->funcoes->somente_numero($this->input->post('nr_cpf_cnpj_cliente'));
        $id_produto_cobertura = '';
        $vl_limite_indenizacao = '';
		
		if (isset($cotacao['id_produto_cobertura']))
		{
			foreach($cotacao['id_produto_cobertura'] as $linha)
	        {
	            $parte = explode('-', $linha);
	            $idproduto = $parte[0];
	            $id_produto_cobertura .= $parte[0]. ';';
	            if ($idproduto === '521')
	            {
	            	$vl_limite_indenizacao = '0.00;';
	            }
	            else
	            {
	            	$vl_limite_indenizacao .= $parte[1]. ';';
	            }
	            
	        }
	        $size = strlen($id_produto_cobertura);
	        $id_produto_cobertura = substr($id_produto_cobertura,0, $size-1);
	        $size_vl = strlen($vl_limite_indenizacao);
	        $vl_limite_indenizacao = substr($vl_limite_indenizacao, 0, $size_vl-1);
	        $cotacao['id_produto_cobertura'] = $id_produto_cobertura;
	        $cotacao['vl_lmi_cobertura'] = $vl_limite_indenizacao;
		}
		
        $this->form_validation->set_rules ('id_revenda', 'ID Revenda', 'required', array(
					'required' => 'O campo Código revenda é obrigatório'
        ));
        $this->form_validation->set_rules ('cd_produto', 'Código Produto', 'required', array(
					'required' => 'O campo Código produto é obrigatório'
        ));
        $this->form_validation->set_rules ('nm_usuario', 'Usuário', 'required', array(
					'required' => 'O campo Usuário é obrigatório'
        ));
        $this->form_validation->set_rules ('nr_mes_periodo_vigencia', 'Vigencia', 'required', array(
					'required' => 'O campo Vigencia é obrigatório'
        ));
        $this->form_validation->set_rules ('nr_cpf_cnpj_cliente', 'CPF/CNPJ', 'required', array(
					'required' => 'CPF/CNPJ é obrigatório'
        ));
        $this->form_validation->set_rules ('nr_cep', 'CEP', 'required', array(
					'required' => 'O campo CEP é obrigatório'
        ));
        $this->form_validation->set_rules ('cd_tipo_pessoa', 'Tipo Cliente', 'required', array(
					'required' => 'O campo Tipo cliente é obrigatório'
        ));
        $this->form_validation->set_rules ('dv_auto_zero', 'Situação veículo', 'required', array(
					'required' => 'O campo Situação veículo é obrigatório'
        ));
        $this->form_validation->set_rules ('cd_fipe', 'Código FIPE', 'required', array(
		 			'required' => 'O campo Código FIPE é obrigatório'
        ));
        $this->form_validation->set_rules ('nr_ano_auto', 'Ano do veículo', 'required', array(
		 			'required' => 'O campo Ano do veículo é obrigatório'
        ));
        $this->form_validation->set_rules ('cd_categoria_tarifaria', 'Categoria Tarifária', 'required', array(
		 			'required' => 'O campo Categoria Tarifária é obrigatório'
        ));
        $this->form_validation->set_rules ('id_auto_combustivel', 'Tipos de combustiveis', 'required', array(
					'required' => 'O campo Tipos de combustiveis é obrigatório'
        ));
        if ($this->form_validation->run() === TRUE)
        {
			$cotacao_usebens = $this->gerar_cotacao_auto_configuravel($cotacao);

			$cotacao_usebens = (array) $cotacao_usebens;
			$sxml = new SimpleXMLElement($cotacao_usebens['ExecutarResult']);
						
			if (isset($sxml->retorno))
			{
				$codigo = $sxml->retorno->attributes()->cd_retorno;
				$mensagem = $sxml->retorno->attributes()->nm_retorno;
				if ($codigo > 0)
				{
					$tipo_alerta = 'danger';
				}
				else 
				{
					$tipo_alerta = 'info';
				}
				$alerta = array (
						'class' => $tipo_alerta,
						'mensagem' => '<strong>Atenção!</strong> <br/>Mensagem: '.$mensagem
				);
			}
	        if (isset($sxml) && !empty($sxml))
	        {
	        	$retornos = $sxml;
	        }
	        else 
	        {
	        	$retornos = NULL;
	        }
	        $combustivel 	= $this->Combustivel_model->get_combustivel_id($cotacao['id_auto_combustivel']);
	        $estado_veiculo	= ($cotacao['dv_auto_zero'] === '1')? 'Novo' : 'Usado'; 
			$dados = array(
					'alerta' 		=> $alerta,
					'acao'			=> $acao,
					'retornos'		=> $retornos,
					'cotacao'		=> $cotacao,
					'combustivel'	=> $combustivel,
					'estado_veiculo'=> $estado_veiculo,
					'st'			=> ''
			);  
			$this->load->view('cotacao/Retorno_cotacao', $dados);			
        }
        else
        {
            $alerta = array (
						'class' => 'danger',
						'mensagem' => '<strong>Atenção!</strong> <br/>Falha na validação do formulário <br>' . validation_errors('<li>','</li>')
            );
            $this->pesquisa_marcas_fipe($cotacao['cliente_id'], $alerta);
        }

	}


	public function pesquisar_apolice_sub_cobertura_auto()
	{
		#Homologação
		//Url do serviço
		/* $servicoSeguradora = 'https://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx?wsdl'; */
		
		#Produção
		//Url do serviço
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
		$servico = 'pesquisarapolicesubcoberturaauto';
		//$xmlEntradaDados = string contendo xml montado.
		$xmlEntradaDados = '<i4proerp>
							<pesquisar_apolice_sub_cobertura_auto
												id_revenda = "1322391"
												nr_ramo = "31"
												id_apolice = "175664"
												id_sub = "183368"
												nm_usuario = "testeweb" />
						</i4proerp>';

		$servicoInstanciadoResult = $client->Executar(array('Servico'=>"$servico", 'conteudoXML'=>"$xmlEntradaDados"));

		return $servicoInstanciadoResult;
	}
	
	public function pesquisa_codigo_profissao()
	{
		#Homologação
		//Url do serviço
		/* $servicoSeguradora = 'https://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx?wsdl'; */
		
		#Produção
		//Url do serviço
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
		$servico = 'PesquisaProfissao';
		//$xmlEntradaDados = string contendo xml montado.
		$xmlEntradaDados = '<i4proerp>
							<profissao />
							</i4proerp>';
		
		$servicoInstanciadoResult = $client->Executar(array('Servico'=>"$servico", 'conteudoXML'=>"$xmlEntradaDados"));
		
		return $servicoInstanciadoResult;
	}
	
	public function pesquisa_uf()
	{
		#Homologação
		//Url do serviço
		/* $servicoSeguradora = 'https://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx?wsdl'; */
		
		#Produção
		//Url do serviço
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
		$servico = 'PesquisaUf';
		//$xmlEntradaDados = string contendo xml montado.
		$xmlEntradaDados = '<i4proerp>
							<uf />
							</i4proerp>';
		
		$servicoInstanciadoResult = $client->Executar(array('Servico'=>"$servico", 'conteudoXML'=>"$xmlEntradaDados"));
		
		return $servicoInstanciadoResult;
	}
	
	public function pesquisa_ramo_atividade()
	{
		#Homologação
		//Url do serviço
		/* $servicoSeguradora = 'https://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx?wsdl'; */
		
		#Produção
		//Url do serviço
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
		$servico = 'PesquisaRamoAtividade';
		//$xmlEntradaDados = string contendo xml montado.
		$xmlEntradaDados = '<i4proerp>
							<ramo_atividade />
							</i4proerp>';
		
		$servicoInstanciadoResult = $client->Executar(array('Servico'=>"$servico", 'conteudoXML'=>"$xmlEntradaDados"));
		
		return $servicoInstanciadoResult;
	}
	
	public function pesquisa_parcelamento()
	{
		#Homologação
		//Url do serviço
		/* $servicoSeguradora = 'https://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx?wsdl'; */
		
		#Produção
		//Url do serviço
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
		$servico = 'PesquisaParcelamento';
		//$xmlEntradaDados = string contendo xml montado.
		$xmlEntradaDados = '<i4proerp>
							<parcelamento
									cd_produto= "97" />
							</i4proerp>';
		
		$servicoInstanciadoResult = $client->Executar(array('Servico'=>"$servico", 'conteudoXML'=>"$xmlEntradaDados"));
		
		return $servicoInstanciadoResult;
	}

    public function gerar_cotacao_auto_configuravel($cotacao)
    {        
        $cotacao['cd_tipo_pessoa'] = ($cotacao['cd_tipo_pessoa'] === 'Pessoa Física')? '1' : '2';
        
        #Homologação
		//Url do serviço
		/* $servicoSeguradora = 'https://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx?wsdl'; */
		
		#Produção
		//Url do serviço
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
		$servico = 'gerarcotacaoautoconfiguravel';
		//$xmlEntradaDados = string contendo xml montado.
		$xmlEntradaDados = '<i4proerp>
		 					<cotacao_auto_configuravel
		 										id_revenda 				= "'.$cotacao['id_revenda'].'"
		 										nm_usuario 				= "'.$cotacao['nm_usuario'].'"
                                                cd_tipo_pessoa			= "'.$cotacao['cd_tipo_pessoa'].'"
                                                nr_cpf_cnpj_cliente		= "'.$cotacao['nr_cpf_cnpj_cliente'].'"
                                                nr_cep 					= "'.$cotacao['nr_cep'].'"
                                                cd_fipe 				= "'.$cotacao['cd_fipe'].'"
                                                nr_ano_auto 			= "'.$cotacao['nr_ano_auto'].'"
                                                dv_auto_zero 			= "'.$cotacao['dv_auto_zero'].'"
                                                id_auto_combustivel 	= "'.$cotacao['id_auto_combustivel'].'"
                                                cd_categoria_tarifaria	= "'.$cotacao['cd_categoria_tarifaria'].'"
                                                cd_produto 				= "'.$cotacao['cd_produto'].'"
                                                nr_mes_periodo_vigencia = "'.$cotacao['nr_mes_periodo_vigencia'].'"
                                                id_produto_cobertura 	= "'.$cotacao['id_produto_cobertura'].'"
                                                vl_lmi_cobertura 		= "'.$cotacao['vl_lmi_cobertura'].'"
                                                 />
		 				</i4proerp>';
		
		$servicoInstanciadoResult = $client->Executar(array('Servico'=>"$servico", 'conteudoXML'=>"$xmlEntradaDados"));

		return $servicoInstanciadoResult;
    }
    
    
    public function gerar_proposta()
    {
    	$proposta = $this->input->post();
    	$acao = 'GERANDO';
    	
    	
    	if (isset($proposta['proposta']) && $proposta['proposta'] === 'proposta')
    	{    		
    		if ($proposta['cd_tipo_pessoa'] != 'Pessoa Jurídica')
    		{
	    		$this->form_validation->set_rules ('estado_civil', 'Estado Civil', 'required', array(
	    				'required' => 'O campo Estado civil é obrigatório'
	    		));
    		}
    		$data = ($proposta['cd_tipo_pessoa'] != 'Pessoa Jurídica')? 'Dt Nascimento': 'Dt Constituição';
    		$this->form_validation->set_rules ('dt_nascimento', $data, 'required', array(
    				'required' => 'O campo '.$data.' é obrigatório'
    		));
    		$this->form_validation->set_rules ('nr_ddd_res', 'DDD', 'required', array(
    				'required' => 'O campo DDD é obrigatório'
    		));
    		$this->form_validation->set_rules ('nm_fone_res', 'Fone residencia', 'required', array(
    				'required' => 'O campo Fone residencia é obrigatório'
    		));
    		$this->form_validation->set_rules ('nm_email', 'E-mail', 'required', array(
    				'required' => 'O campo E-mail é obrigatório'
    		));
    		$this->form_validation->set_rules ('nm_endereco', 'Endereco', 'required', array(
    				'required' => 'O campo Endereço é obrigatório'
    		));
    		$this->form_validation->set_rules ('nr_endereco', 'Nº', 'required', array(
    				'required' => 'O campo Nº é obrigatório'
    		));
    		$this->form_validation->set_rules ('nm_bairro', 'Bairro', 'required', array(
    				'required' => 'O campo Bairro é obrigatório'
    		));
    		$this->form_validation->set_rules ('nm_cidade', 'Cidade', 'required', array(
    				'required' => 'O campo Cidade é obrigatório'
    		));
    		$this->form_validation->set_rules ('cd_uf', 'UF', 'required', array(
    				'required' => 'O campo uf é obrigatório'
    		));
    		if ($proposta['cd_tipo_pessoa'] != 'Pessoa Jurídica')
    		{
    			$this->form_validation->set_rules ('cd_profissao', 'Profissão', 'required', array(
    					'required' => 'O campo Profissão é obrigatório'
    			));
    		}
    		if ($proposta['cd_tipo_pessoa'] === 'Pessoa Jurídica')
    		{
	    		$this->form_validation->set_rules ('id_ramo_atividade', 'Ramo de Atividade', 'required', array(
	    				'required' => 'O campo Ramo de Atividade é obrigatório'
	    		));    			
    		}
    		$this->form_validation->set_rules ('nm_placa', 'Placa', 'required', array(
    				'required' => 'O campo Placa é obrigatório'
    		));
    		$this->form_validation->set_rules ('nm_chassis', 'Chassis', 'required', array(
    				'required' => 'O campo Chassis é obrigatório'
    		));
    		$this->form_validation->set_rules ('cd_forma_pagamento_parcela', 'Forma de pagamento', 'required', array(
    				'required' => 'O campo Forma de pagamento é obrigatório'
    		));
    		$this->form_validation->set_rules ('id_produto_parc_premio', 'Parcelamento', 'required', array(
    				'required' => 'O campo Parcelamento é obrigatório'
    		));
    		if ($this->form_validation->run() === TRUE)
    		{    		
    			if ($proposta['cd_tipo_pessoa'] === 'Pessoa Jurídica')
    			{
    				$proposta['id_sexo'] = '';
    			}
    			else
    			{
    				$proposta['id_sexo'] = (strtoupper($proposta['id_sexo']) === 'MASCULINO')? '1' : '2';
    			}
    			$dtnascimento = explode('/', $proposta['dt_nascimento']);
    			$proposta['dt_nascimento'] = $dtnascimento[2].$dtnascimento[1].$dtnascimento[0];
    			$proposta['nm_resp1'] = (isset($proposta['nm_resp1']))? 'SIM' : 'NAO';
    			$proposta['nm_resp2'] = (isset($proposta['nm_resp2']))? 'SIM' : 'NAO';
    			
    			$proposta_usebens = $this->gerar_proposta_auto_configuravel($proposta);    			
    			$proposta_usebens = (array) $proposta_usebens;
    			$sxml = new SimpleXMLElement($proposta_usebens['ExecutarRowResult']);
    			
    			if (isset($sxml->retorno))
    			{
    				$codigo = $sxml->retorno->attributes()->cd_retorno;
    				$mensagem = $sxml->retorno->attributes()->nm_retorno;
    				if ($codigo > 0)
    				{
    					$tipo_alerta = 'danger';
    				}
    				else
    				{
    					$tipo_alerta = 'info';
    				}
    				$alerta = array (
    						'class' => $tipo_alerta,
    						'mensagem' => '<strong>Atenção!</strong> <br/>Mensagem: '.$mensagem
    				);
    			}
    			
    			if (isset($sxml) && !empty($sxml))
    			{
    				$retornos = $sxml;
    			}
    			else
    			{
    				$retornos = NULL;
    			}
    			$dados = array(
    					'alerta' 	=> $alerta,
    					'acao'		=> $acao,
    					'retornos'	=> $retornos,
    					'st'		=> ''
    			);
    			
    			$this->load->view('cotacao/Retorno_proposta', $dados);
    		}
    		else
    		{
    			$alerta = array (
    					'class' => 'danger',
    					'mensagem' => '<strong>Atenção!</strong> <br/>Falha na validação do formulário <br>' . validation_errors('<li>','</li>')
    			);
    			$this->selecionar_cotacao($proposta['id'], $alerta);
    		}
    		
    	}
    	
    }
        
    public function gerar_proposta_auto_configuravel($cotacao)
    {
    	
    	#Homologação
    	//Url do serviço
    	/* $servicoSeguradora = 'https://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx?wsdl'; */
    	
    	#Produção
    	//Url do serviço
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
    	$servico = 'GerarPropostaAutoConfiguravel';
    	if ($cotacao['cd_tipo_pessoa'] === 'Pessoa Jurídica')
    	{
    		//$xmlEntradaDados = string contendo xml montado para pessoa jurídica.
    		$xmlEntradaDados = '<i4proerp>
			 					<proposta_auto_configuravel
			 										id_revenda 					= "'.$cotacao['id_revenda'].'"
			 										nm_usuario 					= "'.$cotacao['nm_usuario'].'"
	                                                nr_cotacao_i4pro			= "'.$cotacao['nr_cotacao'].'"
													nm_pessoa					= "'.$cotacao['nome_cliente'].'"
	                                                dt_nascimento 				= "'.$cotacao['dt_nascimento'].'"
	                                                nr_ddd_res 					= "'.$cotacao['nr_ddd_res'].'"
	                                                nm_fone_res 				= "'.$cotacao['nm_fone_res'].'"
	                                                nr_ddd_cel 					= "'.$cotacao['nr_ddd_cel'].'"
	                                                nm_fone_cel 				= "'.$cotacao['nm_fone_cel'].'"
	                                                nm_email 					= "'.$cotacao['nm_email'].'"
	                                                nm_endereco 				= "'.$cotacao['nm_endereco'].'"
													nr_endereco 				= "'.$cotacao['nr_endereco'].'"
													nm_complemento 				= "'.$cotacao['nm_complemento'].'"
													nm_cidade	 				= "'.$cotacao['nm_cidade'].'"
													cd_uf		 				= "'.$cotacao['cd_uf'].'"
													id_ramo_atividade 			= "'.$cotacao['id_ramo_atividade'].'"
													nm_placa	 				= "'.$cotacao['nm_placa'].'"
													nm_chassis	 				= "'.$cotacao['nm_chassis'].'"
													dv_segurado_proprietario	= "'.$cotacao['dv_segurado_proprietario'].'"
													id_auto_utilizacao	 		= "'.$cotacao['id_auto_utilizacao'].'"
													cd_forma_pagamento_pparcela	= "'.$cotacao['cd_forma_pagamento_parcela'].'"
													id_produto_parc_premio 		= "'.$cotacao['id_produto_parc_premio'].'"
	                                                 />
			 				</i4proerp>'; 
    	}
    	else 
    	{
	    	//$xmlEntradaDados = string contendo xml montado para pessoa física.
	    	$xmlEntradaDados = '<i4proerp>
			 					<proposta_auto_configuravel
			 										id_revenda 					= "'.$cotacao['id_revenda'].'"
			 										nm_usuario 					= "'.$cotacao['nm_usuario'].'"
	                                                nr_cotacao_i4pro			= "'.$cotacao['nr_cotacao'].'"
													nm_pessoa					= "'.$cotacao['nome_cliente'].'"
	                                                id_sexo 					= "'.$cotacao['id_sexo'].'"
	                                                id_estado_civil				= "'.$cotacao['estado_civil'].'"
	                                                dt_nascimento 				= "'.$cotacao['dt_nascimento'].'"
	                                                nm_resp1 					= "'.$cotacao['nm_resp1'].'"
	                                                nm_resp2 					= "'.$cotacao['nm_resp2'].'"
	                                                nr_ddd_res 					= "'.$cotacao['nr_ddd_res'].'"
	                                                nm_fone_res 				= "'.$cotacao['nm_fone_res'].'"
	                                                nr_ddd_cel 					= "'.$cotacao['nr_ddd_cel'].'"
	                                                nm_fone_cel 				= "'.$cotacao['nm_fone_cel'].'"
	                                                nm_email 					= "'.$cotacao['nm_email'].'"
	                                                nm_endereco 				= "'.$cotacao['nm_endereco'].'"
													nr_endereco 				= "'.$cotacao['nr_endereco'].'"
													nm_complemento 				= "'.$cotacao['nm_complemento'].'"
													nm_cidade	 				= "'.$cotacao['nm_cidade'].'"
													cd_uf		 				= "'.$cotacao['cd_uf'].'"
													cd_profissao 				= "'.$cotacao['cd_profissao'].'"
													nm_placa	 				= "'.$cotacao['nm_placa'].'"
													nm_chassis	 				= "'.$cotacao['nm_chassis'].'"
													dv_segurado_proprietario	= "'.$cotacao['dv_segurado_proprietario'].'"
													id_auto_utilizacao	 		= "'.$cotacao['id_auto_utilizacao'].'"
													cd_forma_pagamento_pparcela	= "'.$cotacao['cd_forma_pagamento_parcela'].'"
													id_produto_parc_premio 		= "'.$cotacao['id_produto_parc_premio'].'"
	                                                 />
			 				</i4proerp>';    		
    	}
    	
    	$servicoInstanciadoResult = $client->ExecutarRow(array('Servico'=>"$servico", 'conteudoXML'=>"$xmlEntradaDados"));
    	
    	//print_r($servicoInstanciadoResult);
    	return $servicoInstanciadoResult;
    	
    }
    
    public function gravar_cotacao()
    {
    	$cotacao = $this->input->post();
    	
    	$acao	 = NULL;   	
    	$cotacao['cd_tipo_pessoa'] 			= ($cotacao['cd_tipo_pessoa'] === 'Pessoa Física')? '1' : '2';
    	$cotacao['nr_mes_periodo_vigencia'] = trim($cotacao['nr_mes_periodo_vigencia']);
    	$cotacao['vl_premio_tarifario'] 	= trim(str_replace("R$", "", $cotacao['vl_premio_tarifario']));
    	$cotacao['vl_lmi'] 					= trim(str_replace("R$", "", $cotacao['vl_lmi']));
    	$cotacao['vl_iof'] 					= trim(str_replace("R$", "", $cotacao['vl_iof']));
    	$cotacao['vl_franquia'] 			= trim(str_replace("R$", "", $cotacao['vl_franquia']));
    	$cotacao['preco'] 					= trim(str_replace("R$", "", $cotacao['preco']));
    	$cotacao['preco'] 					= str_replace(".", "", $cotacao['preco']);
    	$cotacao['preco'] 					= str_replace(",", ".", $cotacao['preco']);
    	
    	if (isset($cotacao['cadastrar']) && $cotacao['cadastrar'] == 'cadastrar')
    	{
    		$gravou = $this->Cotacao_model->inserir($cotacao);
    		if ($gravou)
    		{
    			$alerta = array (
    					'class' => 'success',
    					'mensagem' => '<strong>Parabens!</strong> <br/>Cotação salva com sucesso.'
    			);
    			$cotacao_inserida 				= $this->Cotacao_model->get_cotacao($gravou);
    			$cotacao_inserida['cliente_id']	= $cotacao['cliente_id'];
    			//$cotacao						= $this->Clientes_model->get_clientes_cprf($cotacao_inserida['nr_cpf_cnpj_cliente']);
    			$combustivel					= $this->Combustivel_model->get_combustivel_id($cotacao_inserida['id_auto_combustivel']);
    			$estado_veiculo					= ($cotacao_inserida['dv_auto_zero'] === '1')? 'Novo' : 'Usado';
    			$id_cobertura 					= explode(';', $cotacao_inserida['id_produto_cobertura']);
    			$limite_cobertura 				= explode(';', $cotacao_inserida['vl_lmi_cobertura']);
    			$franquia 						= explode(';', $cotacao_inserida['vl_franquia_cobertura']);
    			$qt_ids 						= count($id_cobertura);
    			$n = 0;
    			$acao = 'INSERIR';
    			while ($n < $qt_ids)
    			{
    				$coberturas[$n] = array(
    						'id_cobertura'		=> $id_cobertura[$n],
    						'limite_cobertura'	=> $limite_cobertura[$n],
    						'franquia'			=> $franquia[$n]
    				);
    				++$n;
    			}
    			$dados = array(
    					'alerta'		=> $alerta,
    					'acao'			=> $acao,
    					'retornos'		=> $cotacao_inserida,
    					'cotacao'		=> $cotacao_inserida,
    					'combustivel'	=> $combustivel,
    					'estado_veiculo'=> $estado_veiculo,
    					'st'			=> 'GRAVOU'
    			);
    			$this->load->view('cotacao/Retorno_cotacao', $dados);	
    		}
    		else 
    		{
    			$alerta = array (
    					'class' => 'danger',
    					'mensagem' => '<strong>Atenção!</strong> <br/>Problemas ao tentar gravar a cotação. Tente novamente, caso não consiga, entre em contato com o suporte.'
    			); 
    			$acao = 'INSERIR';
    			$cotacao_inserida		= $cotacao;
    			$combustivel			= $this->Combustivel_model->get_combustivel_id($cotacao_inserida['id_auto_combustivel']);
    			$estado_veiculo			= ($cotacao_inserida['dv_auto_zero'] === '1')? 'Novo' : 'Usado';
    			$dados = array(
    					'alerta'		=> $alerta,
    					'acao'			=> $acao,
    					'retornos'		=> $cotacao_inserida,
    					'cotacao'		=> $cotacao_inserida,
    					'combustivel'	=> $combustivel,
    					'estado_veiculo'=> $estado_veiculo,
    					'st'			=> ''
    			);
    			$this->load->view('cotacao/Retorno_cotacao', $dados);
    		}
    		
    	}
    	
    }
    
    
    public function gravar_proposta()
    {
    	$alerta = NULL;
    	$proposta = $this->input->post();
    	$acao = 'GRAVANDO';
    	if (isset($proposta['cadastrar']) && $proposta['cadastrar'] === 'cadastrar')
    	{
    		$gravou = $this->Proposta_model->inserir($proposta);
    		if ($gravou)
    		{
    			$tipo_alerta = 'success';
    			$mensagem = '<strong>Parabéns!</strong> <br/>Mensagem: Proposta salva com sucesso.'; 
    			$proposta_salva = $this->Proposta_model->get_proposta_id($gravou);
    			$proposta = $proposta_salva;
    		}
    		else
    		{
    			$tipo_alerta = 'danger';
    			$mensagem = '<strong>Atenção!</strong> <br/>Mensagem: Não foi possivel salvar a proposta';
    		}
    		
    		$alerta = array (
    				'class' => $tipo_alerta,
    				'mensagem' => $mensagem
    		);
    	}
    	$dados = array(
    			'alerta'	=> $alerta,
    			'acao'		=> $acao,
    			'retornos'	=> $proposta,
    			'st'		=> 'GRAVOU'
    	);
    	$this->load->view('cotacao/Retorno_proposta', $dados);
    }
    
        
    public function pesquisa_cotacao_gravada()
    {
    	$alerta = NULL;
    	$cotacoes = NULL;
    	$campos = $this->input->post();    	
    	if (isset($campos['pesquisar_cpf']) && $campos['pesquisar_cpf'] === 'pesquisar_cpf')
    	{
    		$cotacoes = $this->Cotacao_model->get_clientes_cprf($campos['cprf']);
    	}
    	elseif (isset($campos['pesquisar_cliente']) && $campos['pesquisar_cliente'] === 'pesquisar_cliente')
    	{
    		$cotacoes = $this->Cotacao_model->get_clientes_nome($campos['cliente']);
    	}
    	$dados = array(
    			'alerta'	=> $alerta,
    			'cotacoes'	=> $cotacoes
    	);
    	$this->load->view('cotacao/Consulta_cotacao_gerar_proposta', $dados);
    }
    
    public function pesquisa_proposta_gravada()
    {
    	$alerta = NULL;
    	$proposta = NULL;
    	$campos = $this->input->post();
    	
    	if (isset($campos['pesquisar_cpf']) && $campos['pesquisar_cpf'] === 'pesquisar_cpf')
    	{
    		if ($campos['nr_cpf_cnpj_cliente'] != NULL && $campos['nr_cpf_cnpj_cliente'] != '')
    		{
    			$proposta = $this->Proposta_model->get_proposta_cprf($campos['nr_cpf_cnpj_cliente']);
    		}
    	}
    	elseif (isset($campos['pesquisar_cliente']) && $campos['pesquisar_cliente'] === 'pesquisar_cliente')
    	{
    		$proposta = $this->Proposta_model->get_proposta_nome_cliente($campos['nome_cliente']);
    	}
    	$dados = array(
    			'alerta'	=> $alerta,
    			'propostas'	=> $proposta
    	);
    	$this->load->view('cotacao/Consulta_proposta_gerar_venda', $dados);
    }
    
    public function selecionar_cotacao($id, $alerta = NULL)
    {
    	$cotacao_inserida 	= $this->Cotacao_model->get_cotacao($id);
    	$combustivel		= $this->Combustivel_model->get_combustivel_id($cotacao_inserida['id_auto_combustivel']);
    	$infocliente			= $this->Clientes_model->get_clientes_cprf($cotacao_inserida['nr_cpf_cnpj_cliente']);
    	$cliente = (!empty($infocliente))? $infocliente : NULL;
    	$profissao			= $this->pesquisa_codigo_profissao();    	
    	$profissao			= (array) $profissao;
    	$sxml 				= new SimpleXMLElement($profissao['ExecutarResult']);    	
    	foreach ($sxml->retorno->profissao as $linha)
    	{
    		$profissoes[] = $linha;
    	}
    	$atividade			= $this->pesquisa_ramo_atividade();
    	$atividade			= (array) $atividade;
    	$sxml_atividade			= new SimpleXMLElement($atividade['ExecutarResult']);
    	foreach ($sxml_atividade->retorno->ramo_atividade as $linha)
    	{
    		$ramos_atividade[] = $linha;
    	}
    	$parcelamento		= $this->pesquisa_parcelamento();
    	$parcelamento		= (array) $parcelamento;
    	$sxml_parcelamento = new SimpleXMLElement($parcelamento['ExecutarResult']);
    	foreach ($sxml_parcelamento->retorno->parcelamento as $linha)
    	{
    		$forma_parcelamento[] = $linha;
    	}
    	
    	$uf		= $this->pesquisa_uf();
    	$uf= (array) $uf;
    	$sxml_uf = new SimpleXMLElement($uf['ExecutarResult']);
    	foreach ($sxml_uf->retorno->uf as $linha)
    	{
    		$unidade_federal[] = $linha;
    	}
    	
    	$estado_civil		= $this->Estado_civil_model->get_todos_estados_civis();
    	$forma_pagamento	= $this->Forma_pagamento_model->get_todas_formas_pagamento();
    	$id_cobertura = explode(';', $cotacao_inserida['id_produto_cobertura']);
    	$limite_cobertura = explode(';', $cotacao_inserida['vl_lmi_cobertura']);
    	$franquia = explode(';', $cotacao_inserida['vl_franquia_cobertura']);
    	$qt_ids = count($id_cobertura);
    	$n = 0;
    	
    	while ($n < $qt_ids)
    	{
    		$coberturas[$n] = array(
    				'id_cobertura'		=> $id_cobertura[$n],
    				'limite_cobertura'	=> $limite_cobertura[$n],
    				'franquia'			=> $franquia[$n]
    		);
    		++$n;
    	}
    	$dados = array(
    			'alerta'		=> $alerta,
    			'cotacao'		=> $cotacao_inserida,
    			'combustivel'	=> $combustivel,
    			'coberturas'	=> $coberturas,
    			'titulo'		=> 'Cotação - Gerar Proposta',
    			'cliente'		=> $cliente[0],
    			'estados'		=> $estado_civil,
    			'profissoes'	=> $profissoes,
    			'ramos'			=> $ramos_atividade,
    			'parcelamentos'	=> $forma_parcelamento,
    			'formas'		=> $forma_pagamento,
    			'unidades'		=> $unidade_federal,
    			'st'			=> ''
    	);
    	$this->load->view('cotacao/Cotacao_salva', $dados);
    }
    
    public function seleciona_proposta_salva($id, $alerta = NULL)
    {    	
    	$proposta = $this->Proposta_model->get_proposta_id($id);
    	$acao = 'PESQUISA';
    	$dados = array(
    			'alerta'	=> $alerta,
    			'acao'		=> $acao,
    			'retornos'	=> $proposta
    	);
    	$this->load->view('cotacao/Gerar_venda', $dados);
    }
    
    /* ESTA FUNÇÃO SÓ DEVE SER USADA PARA ALTERAR O FORMATO DO CPRF NA TABELA CLIENTE */
    public function manutencao_cpf()
    {
    	$clientes = $this->Clientes_model->get_todos_clientes();    	
    	foreach ($clientes as $cliente)
    	{
    		$cprf = str_replace('.', '', $cliente['cprf']);
    		$cprf = str_replace('-', '', $cprf);
    		
    		$dados = array(
    				'id'	=> $cliente['id'],
    				'cprf'	=> $cprf
    		);
    		$this->Cotacao_model->alterar_formato_cpf($dados);
    	}
    	
    	$alerta = array (
    			"class" => "success",
    			"mensagem" => "<strong><i class='glyphicon glyphicon-ok-sign'></i> Sucesso!</strong> <br/>" .
    			"Importação finalizada."
    	);
    	$dados = array(
    			'alerta' => $alerta
    	);
    	$this->load->view('importar/Importar_xml', $dados);
    }
    
    public function gerar_venda()
    {
    	$venda 	= $this->input->post();
    	$alerta	= NULL; 
    	$acao	= 'VENDA';
    	
    	if (isset($venda['venda']) && $venda['venda'] === 'venda')
    	{
    		$this->form_validation->set_rules ('dt_instala_rastreador', 'Data Instalação', 'required', array(
    				'required' => 'O campo Data Instalação é obrigatório o preenchimento'
    		));
    		$this->form_validation->set_rules ('dt_ativa_rastreador', 'Data Ativação', 'required', array(
    				'required' => 'O campo Data Ativação é obrigatório o preenchimento'
    		));
    		if ($this->form_validation->run() === TRUE)
    		{
    			$dtinstalacao = explode('/', $venda['dt_instala_rastreador']);
    			$venda['dt_instala_rastreador'] = $dtinstalacao[2].$dtinstalacao[1].$dtinstalacao[0];
    			$dtativacao = explode('/', $venda['dt_ativa_rastreador']);
    			$venda['dt_ativa_rastreador'] = $dtativacao[2].$dtativacao[1].$dtativacao[0];
    			$venda_usebens = $this->efetivar_venda_auto_configuravel($venda);
    			$venda_usebens= (array) $venda_usebens;
    			$sxml = new SimpleXMLElement($venda_usebens['ExecutarResult']);    			
    			if (isset($sxml->retorno))
    			{
    				$codigo = $sxml->retorno->attributes()->cd_retorno;
    				$mensagem = $sxml->retorno->attributes()->nm_retorno;
    				if ($codigo > 0)
    				{
    					$tipo_alerta = 'danger';
    				}
    				else
    				{
    					$tipo_alerta = 'info';
    				}
    				$alerta = array (
    						'class' => $tipo_alerta,
    						'mensagem' => '<strong>Atenção!</strong> <br/>Mensagem: '.$mensagem
    				);
    			}
    			if (isset($sxml) && !empty($sxml))
    			{
    				$retornos = $sxml;
    			}
    			else
    			{
    				$retornos = NULL;
    			}
    			$dados = array(
    					'alerta'	=> $alerta,
    					'acao'		=> $acao,
    					'retornos'	=> $retornos,
    					'st'		=> ''
    			);
    			
    			$this->load->view('cotacao/Retorno_venda', $dados);
    		}
    		else
    		{
    			$alerta = array (
    					'class' => 'danger',
    					'mensagem' => '<strong>Atenção!</strong> <br/>Falha na validação do formulário <br>' . validation_errors('<li>','</li>')
    			);
    			
    			$this->seleciona_proposta_salva($venda['id'], $alerta);    			
    		}
    		
    	}
	    	
    }
    
    public function efetivar_venda_auto_configuravel($venda)
    {
    	#Homologação
    	//Url do serviço
    	/* $servicoSeguradora = 'https://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx?wsdl'; */
    	
    	#Produção
    	//Url do serviço
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
    	$servico = 'EfetivarVendaAutoConfiguravel';
    	//$xmlEntradaDados = string contendo xml montado.
    	$xmlEntradaDados = '<i4proerp>
		 					<venda_auto_configuravel
		 										id_revenda 					= "'.$venda['id_revenda'].'"
		 										nm_usuario 					= "'.$venda['nm_usuario'].'"
                                                nr_cotacao_i4pro			= "'.$venda['nr_cotacao_i4pro'].'"
												id_proposta					= "'.$venda['id_endosso'].'"
                                                dt_instala_rastreador		= "'.$venda['dt_instala_rastreador'].'"
                                                dt_ativa_rastreador			= "'.$venda['dt_ativa_rastreador'].'"
                                                 />
		 				</i4proerp>';
    	
    	$servicoInstanciadoResult = $client->Executar(array('Servico'=>"$servico", 'conteudoXML'=>"$xmlEntradaDados"));
    	
    	return $servicoInstanciadoResult;
    	
    }
    
    public function gravar_venda()
    {
    	$venda 	= $this->input->post();
    	$alerta = NULL;
    	$st 	= '';
    	$acao = 'GRAVANDO';
    	if (isset($venda['cadastrar']) && $venda['cadastrar'] === 'cadastrar')
    	{
	    	$gravou = $this->Venda_model->inserir($venda);
	    	if ($gravou)
	    	{
	    		$tipo_alerta = 'success';
	    		$mensagem = '<strong>Parabéns!</strong> <br/>Mensagem: Venda salva com sucesso.';
	    		$venda_salva = $this->Venda_model->get_venda_id($gravou);
	    		$venda = $venda_salva;
	    		$st = 'GRAVOU';
	    	}
	    	else
	    	{
	    		$tipo_alerta = 'danger';
	    		$mensagem = '<strong>Atenção!</strong> <br/>Mensagem: Não foi possivel salvar a venda';
	    	}
	    	
	    	$alerta = array (
	    			'class' => $tipo_alerta,
	    			'mensagem' => $mensagem
	    	);
    	}
    	$dados = array(
    			'alerta'	=> $alerta,
    			'acao'		=> $acao,
    			'retornos'	=> $venda,
    			'st'		=> $st
    	);
    	$this->load->view('cotacao/Retorno_venda', $dados);
    }

}
