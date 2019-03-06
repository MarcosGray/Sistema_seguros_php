<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forma_pagamento extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('Forma_pagamento_model');
	}

	public function index($alerta = NULL)
	{
		$formas_pagamento = $this->Forma_pagamento_model->get_todas_formas_pagamento();
		$dados = array(
			'alerta'	=> $alerta,
			'formas' 	=> $formas_pagamento
		);
		$this->load->view('forma_pagamento/Consulta_forma_pagamento', $dados);
	}

	public function cadastro()
	{
		$alerta = NULL;
		if ($this->input->post('cadastrar') && $this->input->post('cadastrar') === 'cadastrar')
		{
			$forma_pagamento = $this->input->post();
			$erro_forma_pagamento = array(
					'required' 		=> 'O campo Forma de pagamento é obrigatório.',
					'is_unique'		=> 'Essa Forma de pagamento já foi cadastrada.'
			);
			$this->form_validation->set_rules('nm_forma_pagamento', 'Forma de pagamento', 'required|is_unique[tabforma_pagamento.nm_forma_pagamento]', $erro_forma_pagamento);
			$erro_forma_pagamento = array(
					'required' 		=> 'O campo Código é obrigatório.',
					'is_unique'		=> 'Esse Código já foi cadastrado.'
			);
			$this->form_validation->set_rules('cd_forma_pagamento', 'Código', 'required|is_unique[tabforma_pagamento.cd_forma_pagamento]', $erro_forma_pagamento);
			if ($this->form_validation->run() === FALSE)
			{
				$alerta = array (
					"class" => "danger",
					"mensagem" => "<strong>Atenção!</strong> <br/>Falha na validação do formulário <br>" . validation_errors ('<li>','</li>')
				);
				$dados = array(
					'alerta' => $alerta
				);
				$this->load->view('forma_pagamento/Cadastro_forma_pagamento', $dados);
			}
			else
			{
				$insert = $this->Forma_pagamento_model->insert($forma_pagamento);
				$this->index();
			}
		}
		else
		{
			$dados = array(
					'alerta' => $alerta
			);
			$this->load->view('forma_pagamento/Cadastro_forma_pagamento', $dados);
		}

	}


	public function edicao($id = NULL)
	{
		$alerta = NULL;
		if ($this->input->post('editar') && $this->input->post('editar') === 'editar')
		{
			$forma_pagamento = $this->input->post();
			$alterou = $this->Forma_pagamento_model->update($forma_pagamento);
			if ($alterou)
			{
				$this->index();
			}
			else
			{
				$forma_pagamento = $this->Forma_pagamento_model->get_forma_pagamento_id($forma_pagamento['id']);
				$alerta = array (
					"class" => "danger",
					"mensagem" => "<strong>Atenção!</strong> <br/>Não foi possível realizar a alteração na forma de pagamento."
				);
				$dados = array(
					'alerta' 		=> $alerta,
					'forma'	=> $forma_pagamento
				);
				$this->load->view('forma_pagamento/Editar_forma_pagamento', $dados);
			}
		}
		else
		{
			$forma_pagamento = $this->Forma_pagamento_model->get_forma_pagamento_id($id);
			$dados = array(
				'alerta' 	=> $alerta,
				'forma'	=> $forma_pagamento
			);
			$this->load->view('forma_pagamento/Editar_forma_pagamento', $dados);
		}

	}


	public function exclusao()
	{
		$forma_pagamento = $this->input->post();
		$excluiu = $this->Forma_pagamento_model->delete($forma_pagamento['id']);
		if ($excluiu)
		{
			$alerta = array (
				"class" => "success",
				"mensagem" => "<strong><i class='glyphicon glyphicon-ok-sign'></i> Sucesso!</strong> <br/>Forma de pagamento  <strong>" .
					$forma_pagamento['nm_forma_pagamento']."</strong>, foi excluído com sucesso."
			);
		}
		else
		{
			$alerta = array (
					"class" => "danger",
					"mensagem" => "<strong><i class='glyphicon glyphicon-remove-sign'></i> Atenção!</strong> <br/>Não foi possível
						realizar a exclusão da forma de pagamento <strong>".$forma_pagamento['nome_forma_pagamento']."</strong> "
			);
		}
		$this->index($alerta);
	}


	public function pesquisa()
	{
		$alerta = NULL;
		$forma_pagamento = $this->input->post();
		if (isset($forma_pagamento['pesquisar']) && $forma_pagamento['pesquisar'] === 'pesquisar')
		{
			$pesquisa = $this->Forma_pagamento_model->get_forma_pagamento_like($forma_pagamento['busca_forma_pagamento']);			
		}
		$dados = array(
				'alerta'	 => $alerta,
				'formas' => $pesquisa
		);
		$this->load->view('forma_pagamento/Consulta_forma_pagamento', $dados);
	}

}
