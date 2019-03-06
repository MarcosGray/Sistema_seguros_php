<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>MtrackSeguros - Seguros</title>
	<?php
		$this->load->helper('css');
		$this->load->helper('login');
		$this->load->helper('abrir_janela');
	?>
</head>
<body>
	<?php $this->load->helper('menu'); ?>
	<div class="container-fluid">
		<br>
		<div class="row">
			<form class="navbar-form navbar-left" role="search" action="<?php echo base_url('cotacao/pesquisa_proposta_gravada') ?>" method="post" >
			  <div class="form-group">
			    <input type="text" id="nr_cpf_cnpj_cliente" name="nr_cpf_cnpj_cliente" value="<?php echo htmlentities(set_value('nr_cpf_cnpj_cliente')) ?>" class="form-control" placeholder="Digite o CPF/CNPJ">
			    <button type="submit" id="pesquisar_cpf" name="pesquisar_cpf" value="pesquisar_cpf" class="btn nabtn-default">Pesquisar</button>
			  </div>
			  <div class="form-group">
			    <input type="text" id="nome_cliente" name="nome_cliente" value="<?php echo htmlentities(set_value('nome_cliente')) ?>" class="form-control" placeholder="Digite o nome do cliente">
			    <button type="submit" id="pesquisar_cliente" name="pesquisar_cliente" value="pesquisar_cliente" class="btn nabtn-default">Pesquisar</button>
			  </div>
			  	
			</form>
		</div>		
		<div class="row">
			<div class="panel panel-default">
				<header class="panel-heading">
					<strong>Gerar venda - Pesquisar propostas gravadas</strong>
			  	</header>			
				<div class="panel-body">
					<?php if ($alerta != NULL){ ?>
					<div class="alert alert-<?php echo $alerta["class"]; ?>" >
					  	<?php echo $alerta["mensagem"];  ?>
					</div>
					<?php } ?>
					<table class="table table-striped">
					  <thead>
					  	<tr>
					  		<th width="10%">CPF</th>
					  		<th>Nome do cliente</th>
					  		<th width="10%">Nº Cotação</th>	
					  		<th width="10%">Cod. Cotação</th>	
					  		<th width="10%">Cod. Endosso</th>
					  		<th>Status proposta</th>	
					  		<th width="10%">Percentual da FIPE</th>	
					  		<th>Aceitação</th>	  		
					  		<th width="6%">Ações</th>
					  	</tr>
					  </thead>
					  <tbody>
					  	<?php 
					  	if (isset($propostas) && !empty($propostas))
				  		{
				  			$i = 0;
				  			foreach ($propostas as $proposta)
				  			{
					  	?>
					  	<tr>
					  		<td><?php echo $proposta['nr_cpf_cnpj_cliente'] ?></td>
					  		<td><?php echo $proposta['nome_cliente'] ?></td>
					  		<td><?php echo $proposta['nr_cotacao_i4pro'] ?></td>
					  		<td><?php echo $proposta['cd_proposta'] ?></td>
					  		<td><?php echo $proposta['id_endosso'] ?></td>
					  		<td><?php echo $proposta['cd_status_proposta'] ?></td>
					  		<td><?php echo number_format($proposta['pe_fipe'], 2,',','.') . '%' ?></td>
					  		<td><?php echo $proposta['nm_aceitacao'] ?></td>
					  		<td>
					  			<a href="<?php echo base_url('cotacao/seleciona_proposta_salva/'.$proposta['id']) ?>" data-toggle="tooltip" data-placement="top" title="Selecionar esta cotação">
					  				<span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>
								</a>
								&nbsp;&nbsp;
								<a href="#" onclick="javascript:novaJanela('<?php echo base_url('venda/gerar_impressao/imprimir/790/'.$proposta['id']) ?>')" data-toggle="tooltip" data-placement="top" title="Imprimir proposta">
									<span class="glyphicon glyphicon-print" aria-hidden="true"></span>
								</a>					  			
					  		</td>
					  		
					  	</tr>	
					  	<?php 
					  		++$i;
				  			}
				  		}
				  		else 
				  		{
					  	?>		
					  	<tr>
					  		<td colspan="9" >Não foram encontrados registros</td>
					  	</tr>
					  	<?php 
					  		}
					  	?>
					  </tbody>
					</table>
				
				</div>
			</div>						    
		</div>
	</div>	
	<?php $this->load->helper('js'); ?>
</body>
</html>
