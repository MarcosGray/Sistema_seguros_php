<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria_tarifaria_model extends CI_Model {

	public $codigo;
	public $nome_categoria;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_todas_categorias()
	{
		$query = $this->db->get('tabcategoria_tarifaria');
		return $query->result_array();
	}
	
	public function get_categoria_tarifaria_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('tabcategoria_tarifaria');
		#echo $this->db->last_query();
		return $query->row_array();
	}
	
	public function get_categoria_tarifaria_codigo($codigo)
	{
		$this->db->where('codigo', $codigo);
		$query = $this->db->get('tabcategoria_tarifaria');
		return $query->result_array();
	}
	
	public function get_categoria_like($dados)
	{
		$this->db->like('nome_categoria', $dados);
		$query = $this->db->get('tabcategoria_tarifaria');
		#echo $this->db->last_query();
		return $query->result_array();
	}
	
	public function insert($dados)
	{			
		$this->codigo 			= $dados['codigo'];
		$this->nome_categoria 	= $dados['nome_categoria'];
		$this->db->insert('tabcategoria_tarifaria', $this);
		return $this->db->affected_rows()? TRUE : FALSE;
	}
	
	
	public function update($dados)
	{
		$alterar = array(
			'codigo' 		=> $dados['codigo'],
			'nome_categoria'=> $dados['nome_categoria']
		);
		$this->db->where('id', $dados['id']);
		$this->db->update('tabcategoria_tarifaria', $alterar);
		#echo $this->db->last_query();
		return $this->db->affected_rows();
	}
	
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('tabcategoria_tarifaria');
		#echo $this->db->last_query();
		return $this->db->affected_rows();
	}
	
	public function get_modelo_categoria_tarifaria($dados)
	{
		$this->db->where('cod_fipe', $dados);
		$query = $this->db->get('tabmodelo_categoria_tarifaria');
		return $query->row_array();
	}

}
