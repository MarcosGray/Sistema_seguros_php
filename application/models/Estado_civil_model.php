<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estado_civil_model extends CI_Model {

	public $estado_civil;

	public function __construct()
	{
		parent::__construct();
	}

	public function get_todos_estados_civis()
	{
		$query = $this->db->get('tabestado_civil');
		return $query->result_array();
	}

	public function get_estado_civil_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('tabestado_civil');
		#echo $this->db->last_query();
		return $query->row_array();
	}


	public function get_estado_civil_like($dados)
	{
		$this->db->like('estado_civil', $dados);
		$query = $this->db->get('tabestado_civil');
		#echo $this->db->last_query();
		return $query->result_array();
	}

	public function insert($dados)
	{
		$this->estado_civil = $dados['estado_civil'];
		$this->db->insert('tabestado_civil', $this);
		return $this->db->affected_rows()? TRUE : FALSE;
	}


	public function update($dados)
	{
		$alterar = array(
			'estado_civil'=> $dados['estado_civil']
		);
		$this->db->where('id', $dados['id']);
		$this->db->update('tabestado_civil', $alterar);
		#echo $this->db->last_query();
		return $this->db->affected_rows();
	}


	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('tabestado_civil');
		#echo $this->db->last_query();
		return $this->db->affected_rows();
	}



}
