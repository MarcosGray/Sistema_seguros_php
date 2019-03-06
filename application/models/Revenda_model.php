<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Revenda_model extends CI_Model {

	public $id_revenda;
	public $cd_produto;
	public $nm_usuario;
	public $id_apolice;
	public $id_sub;
	public $nr_ramo;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('encrypt');
	}

	public function inserir($dados)
	{		
		
		$this->id_revenda = $dados['id_revenda'];
		$this->cd_produto = $dados['cd_produto'];
		$this->nm_usuario = $dados['nm_usuario'];
		$this->id_apolice = $dados['id_apolice'];
		$this->id_sub	  = $dados['id_sub'];
		$this->nr_ramo	  = $dados['nr_ramo'];
		
		$this->db->insert('tabrevenda', $this);
		return $this->db->affected_rows()? TRUE : FALSE;
	}
	
	public function update($dados)
	{
		$this->id_revenda = $dados['id_revenda'];
		$this->cd_produto = $dados['cd_produto'];
		$this->nm_usuario = $dados['nm_usuario'];
		$this->id_apolice = $dados['id_apolice'];
		$this->id_sub	  = $dados['id_sub'];
		$this->nr_ramo	  = $dados['nr_ramo'];
		
		$this->db->update('tabrevenda', $this);
		return $this->db->affected_rows()? TRUE : FALSE;
	}
	
	public function get_revenda()
	{
		$query = $this->db->get('tabrevenda');
		return $query->row_array();
	}

}
