<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forma_pagamento_model extends CI_Model {

	public $cd_forma_pagamento;
	public $nm_forma_pagamento;

	public function __construct()
	{
		parent::__construct();
	}

	public function get_todas_formas_pagamento()
	{
		$query = $this->db->get('tabforma_pagamento');
		return $query->result_array();
	}

	public function get_forma_pagamento_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('tabforma_pagamento');
		#echo $this->db->last_query();
		return $query->row_array();
	}


	public function get_forma_pagamento_like($dados)
	{
		$this->db->like('nm_forma_pagamento', $dados);
		$query = $this->db->get('tabforma_pagamento');
		#echo $this->db->last_query();
		return $query->result_array();
	}

	public function insert($dados)
	{
		$this->cd_forma_pagamento = $dados['cd_forma_pagamento'];
		$this->nm_forma_pagamento = $dados['nm_forma_pagamento'];
		$this->db->insert('tabforma_pagamento', $this);
		return $this->db->affected_rows()? TRUE : FALSE;
	}


	public function update($dados)
	{
		$alterar = array(
				'cd_forma_pagamento'=> $dados['cd_forma_pagamento'],
				'nm_forma_pagamento'=> $dados['nm_forma_pagamento']
		);
		$this->db->where('id', $dados['id']);
		$this->db->update('tabforma_pagamento', $alterar);
		#echo $this->db->last_query();
		return $this->db->affected_rows();
	}


	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('tabforma_pagamento');
		#echo $this->db->last_query();
		return $this->db->affected_rows();
	}



}
