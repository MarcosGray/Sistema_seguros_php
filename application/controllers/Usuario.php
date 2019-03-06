<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

		
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Usuario_model');
		$this->load->library('conversor');
		date_default_timezone_set('America/Recife');
	}
	
	
	public function cadastro()
	{
		$alerta = NULL;
		if ($this->input->post('cadastrar') && $this->input->post('cadastrar') === 'cadastrar')
		{
			$insert = $this->input->post();
			$insert['dtcadastro'] = $this->conversor->data_brasileiro_americano($this->input->post('dtcadastro'));
			
			$this->form_validation->set_rules('nome', 'Nome', 'required', array('required' => 'O campo Nome é obrigatório.'));
			$this->form_validation->set_rules('login', 'Login', 'required', array('required' => 'O campo Login é obrigatório.'));
			$erro_email = array(
				'required' 		=> 'O campo Email é obrigatório.',
				'valid_email'	=> 'Email inválido',
				'is_unique'		=> 'Esse email já foi cadastrado.'
			);
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tabusuarios.email]', $erro_email);
			$erro_senha = array(
				'required'		=> 'O campo Senha é obrigatório.',
				'trim'			=> 'A senha não pode ter espaços.',
				'min_length'	=> 'A senha deve ter no mínimo 6 dígitos.'
			);
			$this->form_validation->set_rules('senha', 'Senha', 'required|trim|min_length[6]', $erro_senha);
			$erro_confirma = array(
				'required'	=> 'O campo Confirma senha é obrigatório.',
				'trim'		=> 'A senha não pode ter espaços.',
				'matches'	=> 'A senha digitada na confirmação está diferente.'
			);
			$this->form_validation->set_rules('confima_senha', 'Confirmar senha', 'required|trim|matches[senha]', $erro_confirma);
			
			if ($this->form_validation->run() === FALSE)
			{
				$alerta = array (
						"class" => "danger",
						"mensagem" => "<strong>Atenção!</strong> <br/>Falha na validação do formulário <br>" . validation_errors ('<li>','</li>')
				);
				$dados = array(
					'alerta' => $alerta	
				);
				$this->load->view('usuario/Cadastro_usuario', $dados);
			}
			else 
			{
				$insert['senha'] = $this->CriptografarSenhaMd5($this->input->post('senha'));
				$this->Usuario_model->insert($insert);
				if ($insert)
				{
					$this->consulta();
				}
			}
				
		}
		else 
		{
			$dados = array(
				'alerta' => $alerta
			);
			$this->load->view('usuario/Cadastro_usuario', $dados);
		}
	}
	
	
	public function consulta()
	{
		$this->load->view('usuario/Consulta_usuario');
	}
	
	public function consulta_like()
	{
		$campos = array(
			'nome' 	=> $this->input->post('pesquisa_nome'),
			'login'	=> $this->input->post('pesquisa_login'),
			'email' => $this->input->post('pesquisa_email')
		);
		$usuarios = $this->Usuario_model->get_usuarios_like($campos);
		$dados = array(
				'usuarios' => $usuarios
		);
		$this->load->view('usuario/Consulta_usuario',$dados);
	}
	
	public function edicao($id)
	{
		$alerta = NULL;
		$usuario = $this->Usuario_model->get_usuario_id($id);
		if ($this->input->post('alterar') && $this->input->post('alterar') === 'alterar')
		{
			$update = $this->input->post();	
			//print_r($update); 
			$alterou = $this->Usuario_model->update($update);
			
			if ($alterou)				
			{
				$usuario = $this->Usuario_model->get_usuario_id($id);
				$alerta = array (
						"class" => "success",
						"mensagem" => "<strong>Parabéns!</strong> <br/>Alteração realizada com sucesso."
				);				
				$dados = array(
						'alerta' => $alerta,
						'usuario'=> $usuario
				);				
			}
			else 				
			{
				$alerta = array (
						"class" => "danger",
						"mensagem" => "<strong>Atenção!</strong> <br/>Operação não realizada."
				);
				$dados = array(
					'alerta' => $alerta,
					'usuario'=> $usuario
				);				
			}
			$this->load->view('usuario/Editar_usuario', $dados);
		}
		else 
		{			
			$dados = array(
				'alerta' => $alerta,
				'usuario'=> $usuario
			);
			$this->load->view('usuario/Editar_usuario', $dados);
		}
			
	}
	
	
	public function exclusao($id)
	{
		$alerta = NULL;
		if ($this->input->post('excluir') && $this->input->post('excluir') === 'excluir')
		{
			$excluiu = $this->Usuario_model->excluir($usuarios);
			if ($excluiu)
			{
				$alerta = array (
						"class" => "success",
						"mensagem" => "<strong>Parabéns!</strong> <br/>Exclusão realizada com sucesso."
				);
			}
			else 
			{
				$alerta = array (
						"class" => "danger",
						"mensagem" => "<strong>Atenção!</strong> <br/>Operação não realizada."
				);
			}
			$this->load->view('usuario/Consulta_usuario',$dados);
		}
		else 
		{
			$usuario = $this->Usuario_model->get_usuario_id($id);
			$dados = array(
					'alerta' => $alerta,
					'usuario'=> $usuario
			);
			$this->load->view('usuario/Excluir_usuario', $dados);
		}
		
	}
	
	// Criptografar senhas (128 bist)
	public function CriptografarSenhaMd5($senha) {
		return md5($senha);
	}
}
