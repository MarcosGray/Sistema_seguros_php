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
					<strong>Cadastro de combustível</strong>
					<a href="<?php echo base_url('combustivel') ?>">
						<button type="button" class="btn btn-info btn-xs pull-right">Pesquisar combustivel</button>
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
					<form action="<?php base_url('combustivel/cadastro') ?>" method="post" >
						<div class="row">
							<div class="form-group col-xs-12 col-sm-12 col-md-12">
								<label for="nome_combustivel">Nome combustível</label>
								<input type="text" class="form-control" id="nome_combustivel" name="nome_combustivel" value="<?php echo html_escape(set_value('nome_combustivel')) ?>" >
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
