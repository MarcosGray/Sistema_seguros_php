<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcoes {

	public function __construct()
	{

	}

	public function calcula_dias($inicial, $final)
	{		
		// Define os valores a serem usados
		$data_inicial 	= $inicial;
		$data_final 	= $final;
		
		// Cria uma função que retorna o timestamp de uma data no formato DD/MM/AAAA
		function geraTimestamp($data) {
			$partes = explode('-', $data);
			return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
		}
		
		// Usa a função criada e pega o timestamp das duas datas:
		$time_inicial = geraTimestamp($data_inicial);
		$time_final = geraTimestamp($data_final);
		
		// Calcula a diferença de segundos entre as duas datas:
		$diferenca = $time_final - $time_inicial; // 19522800 segundos
		// Calcula a diferença de dias
		$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
		// Exibe uma mensagem de resultado:
		return $dias;
		
	}

	public function somente_numero($dados)
	{
		$dados = trim($dados);
		$dados = str_replace(".", "", $dados);
		$dados = str_replace(",", "", $dados);
		$dados = str_replace("-", "", $dados);
		$dados = str_replace("/", "", $dados);
		return $dados;
	}
	
	public function somente_numero_fone($telefone)
	{
		$telefone = trim($telefone);
		$telefone = str_replace(".", "", $telefone);
		$telefone = str_replace(",", "", $telefone);
		$telefone = str_replace("-", "", $telefone);
		$telefone = str_replace("/", "", $telefone);
		return $telefone;
	}

}
