<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Usuario_model');
		$this->load->library('encrypt');
		$this->load->library('session');
		date_default_timezone_set('America/Recife');

	}

	public function index()
	{	
		$alerta = NULL;
		if ($this->input->post('entrar') && $this->input->post('entrar') === 'entrar')
		{
			if ($this->input->post('captcha'))
				redirect('login/entrar');

			$login = $this->input->post('usu_login');
			$senha = $this->CriptografarSenhaMd5($this->input->post('usu_senha'));
			
			if ($this->Usuario_model->get_login_senha($login, $senha))
			{				
				$this->load->view('home/Painel');
			}
			else 
			{
				$alerta = array (
						"class" => "danger",
						"mensagem" => "O login ou senha estão incorretos."
				);
				$dados = array(
						'alerta' => $alerta
				);
				$this->load->view('login/Login', $dados);
			}

		}
		else
		{			
			$dados = array(
				'alerta' => $alerta
			);
			$this->load->view('login/Login', $dados);
		}
	}
	
	
	public function home()
	{
		$this->load->view('home/Painel');
	}


	// Criptografar senhas (128 bist)
	function CriptografarSenhaMd5($senha) {
		return md5($senha);
	}

	public function sair()
	{
		$alerta = NULL;
		$this->session->sess_destroy();
		$dados = array(
				'alerta' => $alerta
		);
		$this->load->view('login/Login', $dados);
	}


}
