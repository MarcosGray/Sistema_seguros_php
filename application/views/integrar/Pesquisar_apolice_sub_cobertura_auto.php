<?php

	//Url do serviço
	$servicoSeguradora = 'https://www.usebens.com.br/homologacao2/webservice/i4prowebservice.asmx?wsdl';
	#$servicoSeguradora = 'http://www.usebens.com.br/homologacao/webservice/i4prowebservice.asmx?wsdl';
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
	
	$client = new SoapClient($servicoSeguradora, $params);
	//$servico - Nome do serviço a ser chamado
	//$xmlEntradaDados = string contendo xml montado.
	$servico = 'PesquisaUF';
	$xmlEntradaDados = '<i4proerp>
							<uf />
						</i4proerp>';
	
	$servicoInstanciadoResult = $client->ExecutarRow(array('Servico'=>"$servico", 'conteudoXML'=>"$xmlEntradaDados"));
	#$servicoInstanciadoResult = $client->Executar(array('Servico'=>"$servico", 'conteudoXML'=>"$xmlEntradaDados"));
	print_r($servicoInstanciadoResult);
	
	
	
	
	
	
	/* $servico = 'pesquisarapolicesubcoberturaauto';
	$xmlEntradaDados = '<i4proerp>
							<pesquisar_apolice_sub_cobertura_auto
												id_revenda = "1033597"
												nr_ramo = "31"
												id_apolice = "149947"
												id_sub = "157624"
												nm_usuario = "ghlima" />
						</i4proerp>'; */