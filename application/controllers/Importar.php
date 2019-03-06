<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Importar extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		#$this->load->model('Cotacao_model');
		$this->load->model('Importacao_model');
		date_default_timezone_set('America/Fortaleza');
	}

	public function index()
	{
		$alerta = NULL;
        $dados = array(
            'alerta' => $alerta
        );
        $this->load->view('importar/Importar_xml', $dados);
	}
	
	public function Importar_marca_veiculo()
	{
		$alerta = NULL;
		$filename = 'http://localhost/mtrackseguros/importacao/'.$_FILES['arquivo']['name'];
		$arquivo = fopen($filename, 'r');
		$i = 0;
		While(!feof($arquivo))
		{
			$linha = fgets($arquivo, 1024);
			$dados = explode(',', $linha);
			if ($i != 0)
			{	
				$inserir = array(
					'marca'					=> $dados[0],
					'modelo'				=> $dados[1],
					'cod_fipe'				=> $dados[2],
					'categoria_tarifaria'	=> $dados[3]
				);
				$this->Importacao_model->inserir_marcas($inserir);
			}
			++$i;
		}
		$alerta = array (
				"class" => "success",
				"mensagem" => "<strong><i class='glyphicon glyphicon-ok-sign'></i> Sucesso!</strong> <br/>" .
				"Importação finalizada."
		);
		$dados = array(
				'alerta' => $alerta
		);
		$this->load->view('importar/Importar_xml', $dados);
	}
	
	public function marca_fipe()
	{
		$fipe = file_get_contents('http://fipeapi.appspot.com/api/1/carros/marcas.json');
		$resultado = json_decode($fipe, true);
		/* echo '<pre>';
		print_r($resultado);
		echo '</pre>'; */
		$dados = array(
				'alerta' => $alerta,
				'marcas' => $resultado
		);
		$this->load->view('importar/Importar_xml', $dados);
	}
	
	



}
