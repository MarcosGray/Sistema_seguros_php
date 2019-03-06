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
			<form class="navbar-form navbar-left" role="search" action="<?php echo base_url('forma_pagamento/pesquisa') ?>" method="post" >
			  <div class="form-group">
			    <input type="text" id="busca_forma_pagamento" name="busca_forma_pagamento" value="<?php echo htmlentities(set_value('busca_forma_pagamento')) ?>" class="form-control" placeholder="Forma de pagamento">
			    <button type="submit" id="pesquisar" name="pesquisar" value="pesquisar" class="btn nabtn-default">Pesquisar</button>
			  </div>			  	
			</form>
		</div>		
		<div class="row">
			<div class="panel panel-default">
				<header class="panel-heading">
					<strong>Consulta forma de pagamento</strong>
					<a href="<?php echo base_url('forma_pagamento/cadastro') ?>">
						<button type="button" class="btn btn-info btn-xs pull-right">Cadastro de forma de pagamento</button>
					</a>
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
					  		<th>Forma de pagamento</th>					  		
					  		<th width="6%">Ações</th>
					  	</tr>
					  </thead>
					  <tbody>
					  	<?php 
				  		if (isset($formas) && !empty($formas))
				  		{	
				  			$i = 0;
				  			foreach ($formas as $forma)
				  			{
					  	?>
					  	<tr>
					  		<td><?php echo $forma['cd_forma_pagamento'] ?></td>
					  		<td><?php echo $forma['nm_forma_pagamento'] ?></td>
					  		<td>
					  			<a href="<?php echo base_url('forma_pagamento/edicao/'.$forma['id']) ?>" data-toggle="tooltip" data-placement="top" title="Alterar cadastro">
					  				<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								</a>
								<a data-toggle="modal" href="#myModal<?php echo $i ?>">												
									<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>											
								</a>
								<!-- Janela de exclusão -->
								<form id="formulario_cadastro" name="formulario_cadastro" role="form" action="<?php echo base_url('forma_pagamento/exclusao') ?>" method="post" >																								
									<input type="hidden" name="modulo" value="popup_excluir" >
									<input type="hidden" name="id" name="id" value="<?php echo $forma['id'] ?>" >
									<input type="hidden" name="nm_forma_pagamento" name="nm_forma_pagamento" value="<?php echo $forma['nm_forma_pagamento'] ?>" >
									<div class="modal fade" id="myModal<?php echo $i ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title">Exclusão de registros</h4>
												</div>
												<div class="modal-body">
													Tem certeza que deseja excluir a forma de pagamento <strong><?php echo $forma['nm_forma_pagamento'] ?></strong>?
												</div>																
												<div class="modal-footer">
													<button data-dismiss="modal" class="btn btn-danger" type="button">Não</button>
													<button type="submit" id="editar" name="editar" value="editar" class="btn btn-success" >Sim</button>
												</div>
											</div>
										</div>
									</div>
								</form>											
								<!-- Fim janela exclusão -->
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
