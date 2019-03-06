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
					<strong>Cadastro da revenda</strong>
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
					<form action="<?php base_url('revenda') ?>" method="post" >
						<div class="row">
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label for="id_revenda">Código revenda</label>
								<input type="text" class="form-control" id="id_revenda" name="id_revenda" value="<?php echo (empty($revenda['id_revenda']))? html_escape(set_value('id_revenda')) : $revenda['id_revenda'] ?>" >
							</div>
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label for="cd_produto">Código produto</label>
								<input type="text" class="form-control" id="cd_produto" name="cd_produto" value="<?php echo (empty($revenda['id_revenda']))? html_escape(set_value('cd_produto')) : $revenda['cd_produto'] ?>" >
							</div>
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label for="nm_usuario">Usuário</label>
								<input type="text" class="form-control" id="nm_usuario" name="nm_usuario" value="<?php echo (empty($revenda['nm_usuario']))? html_escape(set_value('nm_usuario')) : $revenda['nm_usuario'] ?>" >
							</div>
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label for="id_apolice">Apólice</label>
								<input type="text" class="form-control" id="id_apolice" name="id_apolice" value="<?php echo (empty($revenda['id_apolice']))? html_escape(set_value('id_apolice')) : $revenda['id_apolice'] ?>" >
							</div>
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label for="id_sub">ID Sub</label>
								<input type="text" class="form-control" id="id_sub" name="id_sub" value="<?php echo (empty($revenda['id_sub']))? html_escape(set_value('id_sub')) : $revenda['id_sub'] ?>" >
							</div>
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label for="nr_ramo">Nº do Ramo</label>
								<input type="text" class="form-control" id="nr_ramo" name="nr_ramo" value="<?php echo (empty($revenda['nr_ramo']))? html_escape(set_value('nr_ramo')) : $revenda['nr_ramo'] ?>" >
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
