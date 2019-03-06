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
			<div class=" ">				
				<div class="panel-body">
					<?php if ($alerta != NULL){ ?>
					<div class="alert alert-<?php echo $alerta["class"]; ?>" >
					  	<?php echo $alerta["mensagem"];  ?>
					</div>
					<?php } ?>
					<form action="<?php base_url('usuario/exclusao/'.$usuario['id']) ?>" method="post" >
						<div class="row">
							<div class="jumbotron">
							  <h3><strong>Atenção!</strong></h3>
							  <p>Deseja realmente excluir o usuário <strong><?php echo $usuario['nome'] ?></strong> ? </p>
							  <p>
							  	<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $usuario['id'] ?>" >
							  	<button type="submit" id="excluir" name="excluir" value="excluir" class="btn btn-primary btn-lg">Sim, quero excluir</button>
							  	<a class="btn btn-danger btn-lg" href="<?php echo base_url('usuario/consulta') ?>" role="button">Não quero excluir</a>
							  </p>
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
