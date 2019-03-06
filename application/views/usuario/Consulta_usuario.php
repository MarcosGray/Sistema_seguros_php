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
			<form class="navbar-form navbar-left" role="search" action="<?php echo base_url('usuario/consulta_like') ?>" method="post" >
			  <div class="form-group">
			    <input type="text" id="pesquisa_nome" name="pesquisa_nome" value="<?php echo htmlentities(set_value('pesquisa_nome')) ?>" class="form-control" placeholder="Digite o nome">
			  </div>
			  <div class="form-group">
			    <input type="text" id="pesquisa_login" name="pesquisa_login" value="<?php echo htmlentities(set_value('pesquisa_login')) ?>" class="form-control" placeholder="Digite o login">
			  </div>
			  <div class="form-group">
			    <input type="text" id="pesquisa_email" name="pesquisa_email" value="<?php echo htmlentities(set_value('pesquisa_email')) ?>" class="form-control" placeholder="Digite o e-mail">
			  </div>
			  <button type="submit" id="pesquisar" name="pesquisar" value="pesquisar" class="btn nabtn-default">Pesquisar</button>
			</form>
		</div>		
		<div class="row">
			<div class="panel panel-default">
				<header class="panel-heading">
					<strong>Consulta de usuários</strong>
					<a href="<?php echo base_url('usuario/cadastro') ?>">
						<button type="button" class="btn btn-info btn-xs pull-right">Cadastro usuários</button>
					</a>
			  	</header>			
				<div class="panel-body">
					<table class="table table-striped">
					  <thead>
					  	<tr>
					  		<th>ID</th>
					  		<th>Nome</th>
					  		<th>Login</th>
					  		<th>E-mail</th>
					  		<th>Cadastro</th>
					  		<th>Status</th>
					  		<th width="80">Ações</th>
					  	</tr>
					  </thead>
					  <tbody>
					  	<?php 
				  		if (isset($usuarios) && !empty($usuarios))
				  		{
				  			foreach ($usuarios as $usuario)
				  			{
					  	?>
					  	<tr>
					  		<td><?php echo $usuario['id'] ?></td>
					  		<td><?php echo $usuario['nome'] ?></td>
					  		<td><?php echo $usuario['login'] ?></td>
					  		<td><?php echo $usuario['email'] ?></td>
					  		<td><?php echo $usuario['dtcadastro'] ?></td>
					  		<td><?php echo ($usuario['status'] === '1')? '<span class="label label-success">Ativo</span>' : '<span class="label label-danger">Inativo</span>' ?></td>
					  		<td>
					  			<a href="<?php echo base_url('usuario/edicao/'.$usuario['id']) ?>" data-toggle="tooltip" data-placement="top" title="Alterar cadastro">
					  				<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								</a>
								<!-- <a href="" data-toggle="tooltip" data-placement="top" title="Excluir cadastro">
									<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
								</a> -->
					  		</td>
					  	</tr>	
					  	<?php 
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
