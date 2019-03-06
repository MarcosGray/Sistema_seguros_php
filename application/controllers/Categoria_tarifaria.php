<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria_tarifaria extends CI_Controller {

		
	public function __construct()
	{
		parent::__construct();	
		$this->load->model('Categoria_tarifaria_model');
	}
	
	public function index($alerta = NULL)
	{
		$categorias = $this->Categoria_tarifaria_model->get_todas_categorias();
		$dados = array(
			'alerta'	 => $alerta,
			'categorias' => $categorias	
		);
		$this->load->view('categoria/Consulta_categoria_tarifaria', $dados);
	}

	public function cadastro()
	{
		$alerta = NULL;
		if ($this->input->post('cadastrar') && $this->input->post('cadastrar') === 'cadastrar')
		{
			$catedoria = $this->input->post();
			$erro_codigo = array(
					'required' 		=> 'O campo Código Categoria é obrigatório.',
					'is_unique'		=> 'Esse código da categoria tarifária já foi cadastrado.'
			);
			$this->form_validation->set_rules('codigo', 'Código Categoria', 'required|is_unique[tabcategoria_tarifaria.codigo]', $erro_codigo);
			$erro_categoria = array(
					'required' 		=> 'O campo Nome Categoria é obrigatório.',
					'is_unique'		=> 'Esse nome da categoria tarifária já foi cadastrado.'
			);
			$this->form_validation->set_rules('nome_categoria', 'Nome Categoria', 'required|is_unique[tabcategoria_tarifaria.nome_categoria]', $erro_categoria);
			if ($this->form_validation->run() === FALSE)
			{
				$alerta = array (
					"class" => "danger",
					"mensagem" => "<strong>Atenção!</strong> <br/>Falha na validação do formulário <br>" . validation_errors ('<li>','</li>')
				);
				$dados = array(
					'alerta' => $alerta
				);
				$this->load->view('categoria/Cadastro_categoria_tarifaria', $dados);
			}
			else 
			{
				$insert = $this->Categoria_tarifaria_model->insert($catedoria);
				$this->index();
			}
		}
		else 
		{
			$dados = array(
					'alerta' => $alerta
			);
			$this->load->view('categoria/Cadastro_categoria_tarifaria', $dados);
		}
		
	}
	
	
	public function edicao($id = NULL)
	{
		$alerta = NULL;
		if ($this->input->post('editar') && $this->input->post('editar') === 'editar')
		{
			$categoria = $this->input->post();
			$alterou = $this->Categoria_tarifaria_model->update($categoria);
			if ($alterou)
			{
				$this->index();
			}
			else 
			{
				$categoria = $this->Categoria_tarifaria_model->get_categoria_tarifaria_id($categoria['id']);
				$alerta = array (
					"class" => "danger",
					"mensagem" => "<strong>Atenção!</strong> <br/>Não foi possível realizar a alteração da Categoria tarifária."
				);
				$dados = array(
					'alerta' 	=> $alerta,
					'categoria'	=> $categoria
				);
				$this->load->view('categoria/Editar_categoria_tarifaria', $dados);
			}
		}
		else
		{
			$categoria = $this->Categoria_tarifaria_model->get_categoria_tarifaria_id($id);
			$dados = array(
				'alerta' 	=> $alerta,
				'categoria'	=> $categoria
			);
			$this->load->view('categoria/Editar_categoria_tarifaria', $dados);
		}
	
	}
	
	
	public function exclusao()
	{
		$categoria = $this->input->post();
		$excluiu = $this->Categoria_tarifaria_model->delete($categoria['id']);
		if ($excluiu)
		{
			$alerta = array (
				"class" => "success",
				"mensagem" => "<strong><i class='glyphicon glyphicon-ok-sign'></i> Sucesso!</strong> <br/>Categoria tarifária  <strong>" . 
					$categoria['nome_categoria']."</strong>, foi excluída com sucesso."
			);			
		}
		else 
		{
			$alerta = array (
					"class" => "danger",
					"mensagem" => "<strong><i class='glyphicon glyphicon-remove-sign'></i> Atenção!</strong> <br/>Não foi possível 
						realizar a exclusão da Categoria tarifária <strong>".$categoria['nome_categoria']."</strong> "
			);
		}
		$this->index($alerta);
	}
	
	
	public function pesquisa()
	{
		$alerta = NULL;
		$categoria = $this->input->post();
		if (isset($categoria['pesquisar_codigo']) && $categoria['pesquisar_codigo'] === 'pesquisar_codigo')
		{
			$pesquisa = $this->Categoria_tarifaria_model->get_categoria_tarifaria_codigo($categoria['codigo']);
		}
		elseif (isset($categoria['pesquisar_categoria']) && $categoria['pesquisar_categoria'] === 'pesquisar_categoria')
		{
			$pesquisa = $this->Categoria_tarifaria_model->get_categoria_like($categoria['categoria']);
		}
		$dados = array(
				'alerta'	 => $alerta,
				'categorias' => $pesquisa
		);
		$this->load->view('categoria/Consulta_categoria_tarifaria', $dados);
	}
	
}
