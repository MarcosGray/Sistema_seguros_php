<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

	public $nome;
	public $login;
	public $senha;
	public $email;
	public $status;
	public $dtcadastro;	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('encrypt');
	}

	//Pesquisa usuário pelo ID
	public function get_usuario_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('tabusuarios');
		return $query->row_array(); // traz apenas um registro.
	}
	
	public function get_todos_usuarios()
	{
		$this->db->where('status', '1');
		$query = $this->db->get('tabusuarios');
		return $query->result_array();
	}
	
	public function get_usuarios_like($dados)
	{
		$this->db->like('nome', $dados['nome']);
		$this->db->like('login', $dados['login']);
		$this->db->like('email', $dados['email']);
		$query = $this->db->get('tabusuarios');
		#echo $this->db->last_query();
		return $query->result_array();
	}

	public function get_login_senha($login, $senha)
	{		
		$this->db->where('login', $login);
		$this->db->where('senha', $senha);
		$query = $this->db->get('tabusuarios');
		#echo $this->db->last_query();
		return $query->row_array();
	}
	
	public function insert($dados)
	{
		if (isset($dados['status']))
		{
			$status = 1;
		}
		else 
		{
			$status = 0;
		}
		$this->nome = $dados['nome'];
		$this->login = $dados['login'];
		$this->senha = $dados['senha'];
		$this->email = $dados['email'];
		$this->status = $status;
		$this->dtcadastro = $dados['dtcadastro'];		
		$this->db->insert('tabusuarios', $this);
		return $this->db->affected_rows()? TRUE : FALSE;
	}

	public function update($dados)
	{
		if (isset($dados['status']))
		{
			$status = 1;
		}
		else
		{
			$status = 0;
		}
		$alterar = array(
			'nome' 		=> $dados['nome'],
			'login'		=> $dados['login'],
			'email'		=> $dados['email'],
			'status'	=> $status
		);
		$this->db->where('id', $dados['id']);
		$this->db->update('tabusuarios', $alterar);
		//echo $this->db->last_query();
		return $this->db->affected_rows();
	}
	
	

}
