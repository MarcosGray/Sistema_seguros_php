<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Combustivel extends CI_Controller {

		
	public function __construct()
	{
		parent::__construct();	
		$this->load->model('Combustivel_model');
	}
	
	public function index($alerta = NULL)
	{
		$combustiveis = $this->Combustivel_model->get_todos_combustiveis();
		$dados = array(
			'alerta'	 => $alerta,
			'combustiveis' => $combustiveis	
		);
		$this->load->view('combustivel/Consulta_combustivel', $dados);
	}

	public function cadastro()
	{
		$alerta = NULL;
		if ($this->input->post('cadastrar') && $this->input->post('cadastrar') === 'cadastrar')
		{
			$catedoria = $this->input->post();			
			$erro_combustivel = array(
					'required' 		=> 'O campo Nome Combustível é obrigatório.',
					'is_unique'		=> 'Esse nome de combustível já foi cadastrado.'
			);
			$this->form_validation->set_rules('nome_combustivel', 'Nome Combustível', 'required|is_unique[tabcombustivel.nome_combustivel]', $erro_combustivel);
			if ($this->form_validation->run() === FALSE)
			{
				$alerta = array (
					"class" => "danger",
					"mensagem" => "<strong>Atenção!</strong> <br/>Falha na validação do formulário <br>" . validation_errors ('<li>','</li>')
				);
				$dados = array(
					'alerta' => $alerta
				);
				$this->load->view('combustivel/Cadastro_combustivel', $dados);
			}
			else 
			{
				$insert = $this->Combustivel_model->insert($catedoria);
				$this->index();
			}
		}
		else 
		{
			$dados = array(
					'alerta' => $alerta
			);
			$this->load->view('combustivel/Cadastro_combustivel', $dados);
		}
		
	}
	
	
	public function edicao($id = NULL)
	{
		$alerta = NULL;
		if ($this->input->post('editar') && $this->input->post('editar') === 'editar')
		{
			$combustivel = $this->input->post();
			$alterou = $this->Combustivel_model->update($combustivel);
			if ($alterou)
			{
				$this->index();
			}
			else 
			{
				$combustivel = $this->Combustivel_model->get_combustivel_id($combustivel['id']);
				$alerta = array (
					"class" => "danger",
					"mensagem" => "<strong>Atenção!</strong> <br/>Não foi possível realizar a alteração do Combustível."
				);
				$dados = array(
					'alerta' 		=> $alerta,
					'combustivel'	=> $combustivel
				);
				$this->load->view('combustivel/Editar_combustivel', $dados);
			}
		}
		else
		{
			$combustivel = $this->Combustivel_model->get_combustivel_id($id);
			$dados = array(
				'alerta' 	=> $alerta,
				'combustivel'	=> $combustivel
			);
			$this->load->view('combustivel/Editar_combustivel', $dados);
		}
	
	}
	
	
	public function exclusao()
	{
		$combustivel = $this->input->post();
		#print_r($combustivel);exit();
		$excluiu = $this->Combustivel_model->delete($combustivel['id']);
		if ($excluiu)
		{
			$alerta = array (
				"class" => "success",
				"mensagem" => "<strong><i class='glyphicon glyphicon-ok-sign'></i> Sucesso!</strong> <br/>Combustível  <strong>" . 
					$combustivel['nome_combustivel']."</strong>, foi excluída com sucesso."
			);			
		}
		else 
		{
			$alerta = array (
					"class" => "danger",
					"mensagem" => "<strong><i class='glyphicon glyphicon-remove-sign'></i> Atenção!</strong> <br/>Não foi possível 
						realizar a exclusão do Combustível <strong>".$combustivel['nome_combustivel']."</strong> "
			);
		}
		$this->index($alerta);
	}
	
	
	public function pesquisa()
	{
		$alerta = NULL;
		$combustivel = $this->input->post();
		if (isset($combustivel['pesquisar_combustivel']) && $combustivel['pesquisar_combustivel'] === 'pesquisar_combustivel')
		{
			$pesquisa = $this->Combustivel_model->get_combustivel_like($combustivel['combustivel']);
		}
		$dados = array(
				'alerta'	 => $alerta,
				'combustiveis' => $pesquisa
		);
		$this->load->view('combustivel/Consulta_combustivel', $dados);
	}
	
}
