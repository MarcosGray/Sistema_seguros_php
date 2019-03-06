<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Revenda extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('Revenda_model');
		date_default_timezone_set('America/Fortaleza');
	}

	public function index()
	{
		$campos = $this->input->post();
		$alerta = NULL;
		$revenda = $this->Revenda_model->get_revenda();
		if (isset($campos['cadastrar']) && $campos['cadastrar'] === 'cadastrar')
		{
			if (!empty($revenda))
			{
				$alterar = $this->Revenda_model->update($campos);
				if ($alterar)
				{
					$alerta = array (
							"class" => "success",
							"mensagem" => "<strong>Parabéns!</strong> <br/>Revenda alterada com sucesso."
					);
				}
				else
				{
					$alerta = array (
							"class" => "danger",
							"mensagem" => "<strong>Atenção!</strong> <br/>Operação não realizada."
					);
					
				}
			}
			else 
			{
				$inserir = $this->Revenda_model->inserir($campos);
				if ($inserir)
				{
					$alerta = array (
							"class" => "success",
							"mensagem" => "<strong>Parabéns!</strong> <br/>Revenda cadastrada com sucesso."
					);
				}
				else 
				{
					$alerta = array (
							"class" => "danger",
							"mensagem" => "<strong>Atenção!</strong> <br/>Operação não realizada."
					);
					
				}				
			}
			$revenda = $this->Revenda_model->get_revenda();
		}
        $dados = array(
            'alerta' 	=> $alerta,
        	'revenda'	=> $revenda
        );		
        $this->load->view('revenda/Cadastro_revenda', $dados);
        
	}
	
	

}
