<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Importacao_model extends CI_Model {

		
	public function __construct()
	{
		parent::__construct();
		$this->load->library('encrypt');
	}

	public function inserir_marcas($dados)
	{		
		$inserir =  array(
			'marca'					=> $dados['marca'],
			'modelo'				=> $dados['modelo'],
			'cod_fipe'				=> $dados['cod_fipe'],
			'categoria_tarifaria'	=> $dados['categoria_tarifaria']
		);
		$this->db->insert('tabmodelo_categoria_tarifaria', $inserir);
		//return $this->db->affected_rows()? TRUE : FALSE;
	}

}
