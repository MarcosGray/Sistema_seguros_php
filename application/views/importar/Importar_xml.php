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
					<strong>Importação de arquivos</strong>
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
				<?=form_open_multipart('importar/Importar_marca_veiculo'); ?>
	              <div class="form-group col-xs-12 col-sm-10 col-md-10">
	                  <label for="arquivo" >Arquivo</label>
	                  <input type="file" class="form-control" id="arquivo" name="arquivo">
	              </div>
	              <div class="form-group col-xs-12 col-sm-10 col-md-10">
	                  <input type="submit" class="btn btn-primary" id="enviar" name="enviar" value="Enviar">
	              </div>
	          </form>
				</div>
			</div>
		</div>
		<div class="row">
			<br>
			<div class="panel panel-default">
				<header class="panel-heading">
					<strong>Corrigir CPF</strong>
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
					 <form action="<?php echo base_url('cotacao/manutencao_cpf') ?>" method="post" >											
						<div class="row">														
							<div class="checkbox col-xs-6 col-sm-6 col-md-6">							
								<button type="submit" id="cadastrar" name="cadastrar" value="cadastrar" class="btn btn-primary">Corrigir CPF na tabela de clientes</button>
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
