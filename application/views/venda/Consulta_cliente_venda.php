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
			<form class="navbar-form navbar-left" role="search" action="<?php echo base_url('venda') ?>" method="post" >
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
					<strong>Vendas - Pesquisa de vendas efetivadas</strong>
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
					  		<th width="15%">CPF</th>
					  		<th >Nome do cliente</th>
					  		<th width="8%">Apolice</th>
					  		<th width="8%">Endosso</th>
					  		<th >Veículo</th>
					  		<th width="8%">Prêmio</th>
					  		<th width="80px">Ações</th>
					  	</tr>
					  </thead>
					  <tbody>
					  	<?php 
				  		if (isset($vendas) && !empty($vendas))
				  		{
				  			$i = 0;
				  			foreach ($vendas as $venda)
				  			{
					  	?>
					  	<tr>
					  		<td><?php echo $venda['nr_cpf_cnpj_cliente'] ?></td>
					  		<td><?php echo $venda['nome_cliente'] ?></td>
					  		<td><?php echo $venda['cd_apolice'] ?></td>
					  		<td><?php echo $venda['id_endosso'] ?></td>
					  		<td><?php echo $venda['veiculo'] ?></td>
					  		<td><?php echo $venda['vl_premio_tarifario'] ?></td>
					  		<td>
					  			<a href="#" onclick="javascript:novaJanela('<?php echo base_url('venda/gerar_impressao/imprimir/793/'.$venda['id']) ?>')" data-toggle="tooltip" data-placement="top" title="Imprimir apólice"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
					  			&nbsp;&nbsp;
					  			<a href="<?php echo base_url('venda/gerar_impressao/baixar/793/'.$venda['id']) ?>" data-toggle="tooltip" data-placement="top" title="Baixar apólice"><span class="glyphicon glyphicon-save" aria-hidden="true"></span></a>
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
