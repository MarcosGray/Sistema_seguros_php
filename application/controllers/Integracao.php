<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Integracao extends CI_Controller {

		
	public function __construct()
	{
		parent::__construct();		
		date_default_timezone_set('America/Fortaleza');
	}
	
	/* Usar o web service GerarCotacaoAutoConfiguravel */
	public function gerar_cotacao_auto_configuravel()
	{
		
	}
	
	/* Usar o web service GerarPropostaAutoConfiguravel */
	public function gerar_proposta_auto_configuravel()
	{
	
	}
	
	/* Utilizar o serviço EfetivarVendaAutoConfiguravel */
	public function efetivar_venda_auto_configuravel()
	{
	
	}
	
}
