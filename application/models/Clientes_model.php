<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends CI_Model {

	public $nome_combustivel;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_clientes_cprf($dados)
	{
		$this->db->where('cprf', $dados);
		$query = $this->db->get('tabclientes');
		return $query->result_array();
	}
	
	public function get_clientes_nome($dados)
	{
		$this->db->like('nome_razao', $dados);
		$query = $this->db->get('tabclientes');
		return $query->result_array();
	}
	
	public function get_cliente_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('tabclientes');
		return $query->row_array();
	}
	
	public function get_todos_clientes()
	{
		
		$query = $this->db->get('tabclientes');
		return $query->result_array();
	}
	
	

}
