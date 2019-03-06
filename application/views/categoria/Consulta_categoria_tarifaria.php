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
			<form class="navbar-form navbar-left" role="search" action="<?php echo base_url('categoria_tarifaria/pesquisa') ?>" method="post" >
			  <div class="form-group">
			    <input type="text" id="codigo" name="codigo" value="<?php echo htmlentities(set_value('codigo')) ?>" class="form-control" placeholder="Digite o código">
			    <button type="submit" id="pesquisar_codigo" name="pesquisar_codigo" value="pesquisar_codigo" class="btn nabtn-default">Pesquisar</button>
			  </div>
			  <div class="form-group">
			    <input type="text" id="categoria" name="categoria" value="<?php echo htmlentities(set_value('categoria')) ?>" class="form-control" placeholder="Digite a categoria">
			    <button type="submit" id="pesquisar_categoria" name="pesquisar_categoria" value="pesquisar_categoria" class="btn nabtn-default">Pesquisar</button>
			  </div>
			  	
			</form>
		</div>		
		<div class="row">
			<div class="panel panel-default">
				<header class="panel-heading">
					<strong>Consulta de categoria tarifária</strong>
					<a href="<?php echo base_url('categoria_tarifaria/cadastro') ?>">
						<button type="button" class="btn btn-info btn-xs pull-right">Cadastro de categorias tarifárias</button>
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
					  		<th>Nome da categoria</th>					  		
					  		<th width="6%">Ações</th>
					  	</tr>
					  </thead>
					  <tbody>
					  	<?php 
				  		if (isset($categorias) && !empty($categorias))
				  		{
				  			$i = 0;
				  			foreach ($categorias as $categoria)
				  			{
					  	?>
					  	<tr>
					  		<td><?php echo $categoria['codigo'] ?></td>
					  		<td><?php echo $categoria['nome_categoria'] ?></td>
					  		<td>
					  			<a href="<?php echo base_url('categoria_tarifaria/edicao/'.$categoria['id']) ?>" data-toggle="tooltip" data-placement="top" title="Alterar cadastro">
					  				<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								</a>
								<!-- <a href="<?php #echo base_url('categoria_tarifaria/exclusao/'.$categoria['id']) ?>" data-toggle="tooltip" data-placement="top" title="Excluir cadastro">
									<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
								</a> -->
								<a data-toggle="modal" href="#myModal<?php echo $i ?>">												
									<!-- <button data-trigger="hover" data-placement="top" class="btn btn-warning btn-xs popovers"><i class="glyphicon icon-user"></i></button>	 -->
									<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>											
								</a>
								<!-- Tela de cadastro de cliente -->
								<form id="formulario_cadastro" name="formulario_cadastro" role="form" action="<?php echo base_url('categoria_tarifaria/exclusao') ?>" method="post" >																								
									<input type="hidden" name="modulo" value="popup_excluir" >
									<input type="hidden" name="id" value="<?php echo $categoria['id'] ?>" >
									<input type="hidden" name="nome_categoria" value="<?php echo $categoria['nome_categoria'] ?>" >
									<div class="modal fade" id="myModal<?php echo $i ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title">Exclusão de registros</h4>
												</div>
												<div class="modal-body">
													Tem certeza que deseja excluir a categoria tarifária <strong><?php echo $categoria['nome_categoria'] ?></strong>?
												</div>																
												<div class="modal-footer">
													<button data-dismiss="modal" class="btn btn-danger" type="button">Não</button>
													<button type="submit" id="editar" name="editar" value="editar" class="btn btn-success" >Sim</button>
												</div>
											</div>
										</div>
									</div>
								</form>											
								<!-- Fim tela de cadastro de cliente -->
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
