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
					<strong>Editar Combustível</strong>
					<a href="<?php echo base_url('combustivel') ?>">
						<button type="button" class="btn btn-info btn-xs pull-right">Pesquisar combustíveis</button>
					</a>
			  	</header>	
				<div class="panel-body">
					<?php if ($alerta != NULL){ ?>
					<div class="alert alert-<?php echo $alerta["class"]; ?>" >
					  	<?php echo $alerta["mensagem"];  ?>
					</div>
					<?php } ?>
					<form action="<?php base_url('combustivel/edicao') ?>" method="post" >
						<div class="row">
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label for="id">ID</label>
								<input type="text" class="form-control" id="id" name="id" value="<?php echo $combustivel['id'] ?>" readonly="readonly" >
							</div>
							<div class="form-group col-xs-12 col-sm-10 col-md-10">
								<label for="nome_combustivel">Combustível</label>
								<input type="text" class="form-control" id="nome_combustivel" name="nome_combustivel" value="<?php echo html_escape($combustivel['nome_combustivel']) ?>" >
							</div>
						</div>
						<div class="row">														
							<div class="checkbox col-xs-6 col-sm-6 col-md-6">							
								<button type="submit" id="editar" name="editar" value="editar" class="btn btn-primary">Enviar</button>
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
