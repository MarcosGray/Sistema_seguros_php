<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Combustivel_model extends CI_Model {

	public $nome_combustivel;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_todos_combustiveis()
	{
		$query = $this->db->get('tabcombustivel');
		return $query->result_array();
	}
	
	public function get_combustivel_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('tabcombustivel');
		#echo $this->db->last_query();
		return $query->row_array();
	}	
	
	
	public function get_combustivel_like($dados)
	{
		$this->db->like('nome_combustivel', $dados);
		$query = $this->db->get('tabcombustivel');
		#echo $this->db->last_query();
		return $query->result_array();
	}
	
	public function insert($dados)
	{			
		$this->nome_combustivel 	= $dados['nome_combustivel'];
		$this->db->insert('tabcombustivel', $this);
		return $this->db->affected_rows()? TRUE : FALSE;
	}
	
	
	public function update($dados)
	{
		$alterar = array(
			'nome_combustivel'=> $dados['nome_combustivel']
		);
		$this->db->where('id', $dados['id']);
		$this->db->update('tabcombustivel', $alterar);
		#echo $this->db->last_query();
		return $this->db->affected_rows();
	}
	
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('tabcombustivel');
		#echo $this->db->last_query();
		return $this->db->affected_rows();
	}
	
	

}
