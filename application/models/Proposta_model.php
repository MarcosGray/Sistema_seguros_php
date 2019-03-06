<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposta_model extends CI_Model {

	public $id_revenda;
	public $nm_usuario;	
	public $nr_cotacao_i4pro;
	public $cd_proposta;
	public $id_endosso;
	public $cd_status_proposta;
	public $pe_fipe;
	public $nm_aceitacao;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('encrypt');
	}

		
	public function inserir($dados)
	{
		$this->id_revenda = $dados['id_revenda'];		
		$this->nm_usuario = $dados['nm_usuario'];
		$this->nr_cotacao_i4pro = $dados['nr_cotacao_i4pro'];
		$this->cd_proposta = $dados['cd_proposta'];
		$this->id_endosso = $dados['id_endosso'];
		$this->cd_status_proposta = $dados['cd_status_proposta'];			
		$this->pe_fipe = $dados['pe_fipe'];
		$this->nm_aceitacao = $dados['nm_aceitacao'];
		
		
		$this->db->insert('tabproposta', $this);
		//echo $this->db->last_query();
		return $this->db->affected_rows()? $this->db->insert_id() : FALSE;
	}
	
	
	public function get_proposta_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('tabproposta');
		#echo $this->db->last_query();
		return $query->row_array();
	}
	
	public function get_proposta_cprf($dados = NULL)
	{
		$this->db->select('tabcotacao.nr_cpf_cnpj_cliente, tabcotacao.nome_cliente, 
						   tabproposta.nr_cotacao_i4pro, tabproposta.cd_proposta,
						   tabproposta.id_endosso, tabproposta.cd_status_proposta, 
						   tabproposta.pe_fipe, tabproposta.nm_aceitacao, tabproposta.id');
		$this->db->from('tabproposta');
		$this->db->join('tabcotacao', 'tabcotacao.nr_cotacao = tabproposta.nr_cotacao_i4pro');
		$this->db->where('tabcotacao.nr_cpf_cnpj_cliente', $dados);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_proposta_nome_cliente($dados = NULL)
	{
		$this->db->select('tabcotacao.nr_cpf_cnpj_cliente, tabcotacao.nome_cliente,
						   tabproposta.nr_cotacao_i4pro, tabproposta.cd_proposta,
						   tabproposta.id_endosso, tabproposta.cd_status_proposta,
						   tabproposta.pe_fipe, tabproposta.nm_aceitacao, tabproposta.id');
		$this->db->from('tabproposta');
		$this->db->join('tabcotacao', 'tabcotacao.nr_cotacao = tabproposta.nr_cotacao_i4pro');
		$this->db->like('tabcotacao.nome_cliente', $dados);
		$query = $this->db->get();
		return $query->result_array();
	}

}

