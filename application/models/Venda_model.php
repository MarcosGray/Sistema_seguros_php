<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venda_model extends CI_Model {

	public $id_revenda;
	public $nm_usuario;	
	public $nr_cotacao_i4pro;
	public $id_proposta;
	public $id_apolice;
	public $cd_apolice;
	public $id_endosso;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('encrypt');
	}

		
	public function inserir($dados)
	{
		$this->id_revenda 		= $dados['id_revenda'];		
		$this->nm_usuario 		= $dados['nm_usuario'];
		$this->nr_cotacao_i4pro = $dados['nr_cotacao_i4pro'];
		$this->id_proposta		= $dados['cd_proposta'];
		$this->id_apolice		= $dados['id_apolice'];
		$this->cd_apolice		= $dados['cd_apolice'];			
		$this->id_endosso		= $dados['id_endosso'];
		
		$this->db->insert('tabvenda', $this);
		//echo $this->db->last_query();
		return $this->db->affected_rows()? $this->db->insert_id() : FALSE;
	}
	
	
	public function get_venda_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('tabvenda');
		#echo $this->db->last_query();
		return $query->row_array();
	}
	
	public function get_venda_cprf($dados = NULL)
	{
		$this->db->select('tabvenda.id, tabvenda.cd_apolice, tabvenda.id_apolice, 
    					tabvenda.id_endosso, tabvenda.id_proposta, tabvenda.id_revenda, 
						tabvenda.nm_usuario, tabvenda.nr_cotacao_i4pro, tabcotacao.nr_cpf_cnpj_cliente, 
						tabcotacao.nome_cliente, tabcotacao.veiculo, tabcotacao.vl_premio_tarifario');
		$this->db->from('tabvenda');
		$this->db->join('tabcotacao', 'tabcotacao.nr_cotacao = tabvenda.nr_cotacao_i4pro');
		$this->db->where('tabcotacao.nr_cpf_cnpj_cliente', $dados);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_venda_nome_cliente($dados = NULL)
	{
		$this->db->select('tabvenda.id, tabvenda.cd_apolice, tabvenda.id_apolice,
    					tabvenda.id_endosso, tabvenda.id_proposta, tabvenda.id_revenda,
						tabvenda.nm_usuario, tabvenda.nr_cotacao_i4pro, tabcotacao.nr_cpf_cnpj_cliente,
						tabcotacao.nome_cliente, tabcotacao.veiculo, tabcotacao.vl_premio_tarifario');
		$this->db->from('tabvenda');
		$this->db->join('tabcotacao', 'tabcotacao.nr_cotacao = tabvenda.nr_cotacao_i4pro');
		$this->db->like('tabcotacao.nome_cliente', $dados);
		$query = $this->db->get();
		return $query->result_array();
	}

}

