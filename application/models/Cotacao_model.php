<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cotacao_model extends CI_Model {

	public $id_revenda;
	public $cd_produto;
	public $nm_usuario;
	public $nr_mes_periodo_vigencia;
	public $nr_cpf_cnpj_cliente;
	public $nome_cliente;
	public $nr_cep;
	public $cd_tipo_pessoa;
	public $id_marca;
	public $id_veiculo;
	public $id_modelo;
	public $dv_auto_zero;
	public $marca;
	public $cd_fipe;
	public $veiculo;
	public $preco;
	public $referencia;
	public $nr_ano_auto;
	public $cd_categoria_tarifaria;
	public $id_auto_combustivel;
	public $id_produto_cobertura;
	public $vl_lmi_cobertura;
	public $nr_cotacao;
	public $id_cotacao_proposta;
	public $vl_premio_tarifario;
	public $vl_lmi;
	public $vl_iof;
	public $vl_franquia;
	public $vl_franquia_cobertura;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('encrypt');
	}

	public function solicitar_cotacao()
	{		
		ini_set("soap.wsdl_cache_enabled", "0");		
		$cotacao = new SoapClient("https://www.usebens.com.br/homologacao/webservice/i4prowebservicetestador.aspx");		
		return $cotacao;
	}
	
	public function inserir($dados)
	{
		$this->id_revenda 				= $dados['id_revenda'];
		$this->cd_produto 				= $dados['cd_produto'];
		$this->nm_usuario 				= $dados['nm_usuario'];
		$this->nr_mes_periodo_vigencia 	= $dados['nr_mes_periodo_vigencia'];
		$this->nr_cpf_cnpj_cliente 		= $dados['nr_cpf_cnpj_cliente'];
		$this->nome_cliente 			= $dados['nome_cliente'];
		$this->nr_cep 					= $dados['nr_cep'];
		$this->cd_tipo_pessoa 			= $dados['cd_tipo_pessoa'];
		$this->id_marca 				= $dados['id_marca'];
		$this->id_veiculo 				= $dados['id_veiculo'];
		$this->id_modelo 				= $dados['id_modelo'];
		$this->dv_auto_zero 			= $dados['dv_auto_zero'];
		$this->marca 					= $dados['marca'];
		$this->cd_fipe 					= $dados['cd_fipe'];
		$this->veiculo 					= $dados['veiculo'];
		$this->preco 					= $dados['preco'];
		$this->referencia 				= $dados['referencia'];
		$this->nr_ano_auto 				= $dados['nr_ano_auto'];
		$this->cd_categoria_tarifaria	= $dados['cd_categoria_tarifaria'];
		$this->id_auto_combustivel 		= $dados['id_auto_combustivel'];
		$this->id_produto_cobertura 	= $dados['id_produto_cobertura'];
		$this->vl_lmi_cobertura			= $dados['vl_lmi_cobertura'];
		$this->nr_cotacao 				= $dados['nr_cotacao'];
		$this->id_cotacao_proposta 		= $dados['id_cotacao_proposta'];
		$this->vl_premio_tarifario 		= $dados['vl_premio_tarifario'];
		$this->vl_lmi 					= $dados['vl_lmi'];
		$this->vl_iof 					= $dados['vl_iof'];
		$this->vl_franquia 				= $dados['vl_franquia'];
		$this->vl_franquia_cobertura 	= $dados['vl_franquia_cobertura'];
		
		$this->db->insert('tabcotacao', $this);
		//echo $this->db->last_query();
		return $this->db->affected_rows()? $this->db->insert_id() : FALSE;
	}
	
	public function get_cotacao($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('tabcotacao');
		#echo $this->db->last_query();
		return $query->row_array();
	}
	
	public function get_clientes_cprf($dados)
	{
		$this->db->where('nr_cpf_cnpj_cliente', $dados);
		$query = $this->db->get('tabcotacao');
		return $query->result_array();
	}
	
	public function get_clientes_nome($dados)
	{
		$this->db->like('nome_cliente', $dados);
		$query = $this->db->get('tabcotacao');
		return $query->result_array();
	}
	
	public function alterar_formato_cpf($dados)
	{
		$alterar = array(
				'cprf'=> $dados['cprf']
		);
		$this->db->where('id', $dados['id']);
		$this->db->update('tabclientes', $alterar);
		#echo $this->db->last_query();
		return $this->db->affected_rows();
	}

}

