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
	?>
</head>
<body>
	<?php $this->load->helper('menu'); ?>
	<div class="container-fluid">
		<br>
		<div class="row">
			<form class="navbar-form navbar-left" role="search" action="<?php echo base_url('cotacao/pesquisa_cotacao_gravada') ?>" method="post" >
			  <div class="form-group">
			    <input type="text" id="cprf" name="cprf" value="<?php echo htmlentities(set_value('cprf')) ?>" class="form-control" placeholder="Digite o CPF/CNPJ">
			    <button type="submit" id="pesquisar_cpf" name="pesquisar_cpf" value="pesquisar_cpf" class="btn nabtn-default">Pesquisar</button>
			  </div>
			  <div class="form-group">
			    <input type="text" id="cliente" name="cliente" value="<?php echo htmlentities(set_value('cliente')) ?>" class="form-control" placeholder="Digite o nome do cliente">
			    <button type="submit" id="pesquisar_cliente" name="pesquisar_cliente" value="pesquisar_cliente" class="btn nabtn-default">Pesquisar</button>
			  </div>
			  	
			</form>
		</div>		
		<div class="row">
			<div class="panel panel-default">
				<header class="panel-heading">
					<strong>Gerar proposta - Pesquisa cotações gravadas</strong>
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
					  		<th width="8%">Código</th>
					  		<th width="15%">CPF</th>
					  		<th>Nome do cliente</th>
					  		<th width="10%">Nº Cotação</th>	
					  		<th>Veículo</th>	
					  		<th width="15%">Valor prêmio</th>			  		
					  		<th width="6%">Ações</th>
					  	</tr>
					  </thead>
					  <tbody>
					  	<?php 
				  		if (isset($cotacoes) && !empty($cotacoes))
				  		{
				  			$i = 0;
				  			foreach ($cotacoes as $cotacao)
				  			{
					  	?>
					  	<tr>
					  		<td><?php echo $cotacao['id'] ?></td>
					  		<td><?php echo $cotacao['nr_cpf_cnpj_cliente'] ?></td>
					  		<td><?php echo $cotacao['nome_cliente'] ?></td>
					  		<td><?php echo $cotacao['nr_cotacao'] ?></td>
					  		<td><?php echo $cotacao['veiculo'] ?></td>
					  		<td><?php echo 'R$ ' . number_format($cotacao['vl_premio_tarifario'], 2,',','.') ?></td>
					  		<td>
					  			<a href="<?php echo base_url('cotacao/selecionar_cotacao/'.$cotacao['id']) ?>" data-toggle="tooltip" data-placement="top" title="Selecionar esta cotação">
					  				<span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>
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
					  		<td colspan="7" >Não foram encontrados registros</td>
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
