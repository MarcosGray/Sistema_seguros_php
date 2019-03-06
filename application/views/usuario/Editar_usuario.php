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
					<strong>Editar cadastro de usuários</strong>
					<a href="<?php echo base_url('usuario/consulta') ?>">
						<button type="button" class="btn btn-info btn-xs pull-right">Pesquisar usuários</button>
					</a>
			  	</header>	
				<div class="panel-body">
					<?php if ($alerta != NULL){ ?>
					<div class="alert alert-<?php echo $alerta["class"]; ?>" >
					  	<?php echo $alerta["mensagem"];  ?>
					</div>
					<?php } ?>
					<form action="<?php base_url('usuario/edicao') ?>" method="post" >
						<div class="row">
							<div class="form-group col-xs-12 col-sm-6 col-md-6">
								<label for="nome">Nome usuário</label>
								<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $usuario['id'] ?>" >
								<input type="text" class="form-control" id="nome" name="nome" value="<?php echo html_escape($usuario['nome']) ?>" >
							</div>
							<div class="form-group col-xs-12 col-sm-6 col-md-6">
								<label for="login">Login do usuário</label>
								<input type="text" class="form-control" id="login" name="login" value="<?php echo html_escape($usuario['login']) ?>" >
							</div>
						</div>
						<div class="row">
							<div class="form-group col-xs-12 col-sm-6 col-md-6">
								<label for="email">Endereço de e-mail</label>
								<input type="email" class="form-control" id="email" name="email" value="<?php echo html_escape($usuario['email']) ?>" >
							</div>
							<div class="form-group col-xs-12 col-sm-3 col-md-3">
								<label for="dtcadastro">Data cadastro</label>
								<input type="text" readonly="readonly" class="form-control" id="dtcadastro" name="dtcadastro" value="<?php echo $usuario['dtcadastro'] ?> ">
							</div>														
						</div>
						<div class="row">	
							<div class="checkbox col-xs-6 col-sm-6 col-md-6">
								<label><input type="checkbox" id="status" name="status" <?php echo ($usuario['status'] === '1')? 'checked' : '' ?> > Ativar cadastro</label>
							</div>
						</div>
						<div class="row">														
							<div class="checkbox col-xs-6 col-sm-6 col-md-6">							
								<button type="submit" id="alterar" name="alterar" value="alterar" class="btn btn-primary">Enviar</button>
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
