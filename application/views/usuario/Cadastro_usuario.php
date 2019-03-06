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
		<div class="row">
			<br>
			<div class="panel panel-default">
				<header class="panel-heading">
					<strong>Cadastro de usuários</strong>
					<a href="<?php echo base_url('usuario/consulta') ?>">
						<button type="button" class="btn btn-info btn-xs pull-right">Pesquisar usuários</button>
					</a>
			  	</header>	
				<div class="panel-body">
	                 <!-- Mensagem de alerta -->
	                 <?php if ($alerta != NULL){ ?>
					 <div class="alert alert-<?php echo $alerta["class"]; ?> alert-block fade in">
					 <?php echo $alerta["mensagem"];  ?>
					 	<button data-dismiss="alert" class="close close-sm" type="button"><i class="icon-remove"></i></button>
					 </div>
					 <?php } ?>  
					 <!-- Fim mensagem de alerta -->
					<form action="<?php base_url('usuario') ?>" method="post" >
						<div class="row">
							<div class="form-group col-xs-12 col-sm-6 col-md-6">
								<label for="nome">Nome usuário</label>
								<input type="text" class="form-control" id="nome" name="nome" value="<?php echo html_escape(set_value('nome'))  ?>" >
							</div>
							<div class="form-group col-xs-12 col-sm-6 col-md-6">
								<label for="login">Login do usuário</label>
								<input type="text" class="form-control" id="login" name="login" value="<?php echo html_escape(set_value('login')) ?>" >
							</div>
						</div>
						<div class="row">
							<div class="form-group col-xs-12 col-sm-6 col-md-6">
								<label for="email">Endereço de e-mail</label>
								<input type="email" class="form-control" id="email" name="email" value="<?php echo html_escape(set_value('email')) ?>" >
							</div>
							<div class="form-group col-xs-12 col-sm-3 col-md-3">
								<label for="dtcadastro">Data cadastro</label>
								<input type="text" readonly="readonly" class="form-control" id="dtcadastro" name="dtcadastro" value="<?php echo date('d-m-Y') ?> ">
							</div>														
						</div>
						<div class="row">	
							<div class="form-group col-xs-12 col-sm-3 col-md-3">
								<label for="senha">Senha</label>
								<input type="password" class="form-control" id="senha" name="senha" value="<?php echo html_escape(set_value('senha')) ?>" >
							</div>
							<div class="form-group col-xs-12 col-sm-3 col-md-3">
								<label for="confima_senha">Confimar Senha</label>
								<input type="password" class="form-control" id="confima_senha" name="confima_senha" value="<?php echo html_escape(set_value('confima_senha')) ?>" >
							</div>
							<div class="checkbox col-xs-6 col-sm-6 col-md-6 pull-right">
								<br>
								<label><input type="checkbox" id="status" name="status" > Ativar cadastro</label>
							</div>
						</div>
						<div class="row">														
							<div class="checkbox col-xs-6 col-sm-6 col-md-6">							
								<button type="submit" id="cadastrar" name="cadastrar" value="cadastrar" class="btn btn-primary">Enviar</button>
							</div>
							
						</div>
							
					</form>					
				</div>
			</div>						    
		</div>
	</div>	
	<?php $this->load->helper('js'); ?>
</body>
</html>
