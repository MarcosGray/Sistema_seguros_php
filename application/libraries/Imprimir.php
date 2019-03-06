<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imprimir {

	public function pdf($view, $dados)
	{
		// Instancia a classe mPDF
		$mpdf = new mPDF('','', 0, '', 15, 15, 16, 16, 9, 9, 'L');
		/* $css = file_get_contents('css/style_pdf.css');
		 $mpdf->WriteHTML($css,1); */
		// Ao invés de imprimir a view 'welcome_message' na tela, passa o código
		// HTML dela para a variável $html
		$html = $this->load->view($view,$dados,TRUE);
		//$html = '<a href="'.base_url('impressao/Relatorio_recebimento_operador').'" target="_blank"></a>';
		// Define um Cabeçalho para o arquivo PDF
		$mpdf->SetHeader('Crediário Web - Sistema de controle de crediário');
		// Define um rodapé para o arquivo PDF, nesse caso inserindo o número da
		// página através da pseudo-variável PAGENO
		$mpdf->SetFooter('{PAGENO}');
		// Insere o conteúdo da variável $html no arquivo PDF
		$mpdf->writeHTML($html);
		// Cria uma nova página no arquivo
		//$mpdf->AddPage();
		// Insere o conteúdo na nova página do arquivo PDF
		//$mpdf->WriteHTML('<p><b>Minha nova página no arquivo PDF</b></p>');
		// Gera o arquivo PDF
		$mpdf->Output();
		
		exit();
	}
	
	
	public function converter_base64_pdf_baixar($titulo_arq,$base64)
	{
		$decoded = base64_decode($base64);
		$file = $titulo_arq . '.pdf';
		file_put_contents($file, $decoded);
		
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			readfile($file);
			exit;
		}
	}
	
	public function converter_base64_pdf_imprimir($titulo_arq,$base64)
	{
		$decoded = base64_decode($base64);
		$file = $titulo_arq . '.pdf';
		header('Content-Type: application/pdf');
		echo $decoded;
	}
	
}
