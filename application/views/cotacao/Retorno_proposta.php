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
		$this->load->helper('pesquisa_veiculo_ajax');
		$this->load->helper('money');
	?>
</head>
<body>
	<?php $this->load->helper('menu'); ?>
	<div class="container-fluid" >
		<div class="row">
			<br>
			<div class="panel panel-default">
				<header class="panel-heading">
					<strong>Proposta - Retorno API Usebens</strong>
					<a href="<?php echo base_url('cotacao/pesquisa_cotacao_gravada') ?>">
						<button type="button" class="btn btn-info btn-xs pull-right">Pesquisar outra proposta</button>
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
					 <div class="col-sm-9 col-md-9"> 
						<form action="<?php echo base_url('cotacao/gravar_proposta') ?>" method="post" id="formulario_cotacao" >
							<div class="row">
								<?php 
								/* echo '<pre>';	
								print_r($retornos);
								echo '</pre>'; */
								if ($acao === 'GRAVANDO')
								{
									$id_revenda = $retornos['id_revenda'];
									$nm_usuario = $retornos['nm_usuario'];
									$nr_cotacao_i4pro = $retornos['nr_cotacao_i4pro'];
									$id_proposta = $retornos['cd_proposta'];
									$id_apolice = $retornos['id_endosso'];
									$pe_fipe = $retornos['pe_fipe'];
									$nm_aceitacao =  $retornos['nm_aceitacao'];
									$cd_status_proposta = $retornos['cd_status_proposta'];
									
								}
								else 
								{
									$id_revenda 		= $retornos->identificacao->attributes()->id_revenda;
									$nm_usuario 		= $retornos->identificacao->attributes()->nm_usuario;
									$nr_cotacao_i4pro 	= $retornos->identificacao->gerar_proposta_auto_configuravel->attributes()->nr_cotacao_i4pro;
									$id_proposta 		= $retornos->identificacao->gerar_proposta_auto_configuravel->attributes()->cd_proposta;
									$id_apolice 		= $retornos->identificacao->gerar_proposta_auto_configuravel->attributes()->id_endosso;
									$pe_fipe 			= $retornos->identificacao->gerar_proposta_auto_configuravel->attributes()->pe_fipe;
									$nm_aceitacao 		= $retornos->identificacao->gerar_proposta_auto_configuravel->attributes()->nm_aceitacao;
									$cd_status_proposta = $retornos->identificacao->gerar_proposta_auto_configuravel->attributes()->cd_status_proposta;
								}
								//exit();
								?>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="id_revenda">Código revenda</label>
									<input type="text" class="form-control" id="id_revenda" name="id_revenda" value="<?php echo $id_revenda ?>" readonly="readonly" >
								</div>							
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">Usuário</label>
									<input type="text" class="form-control" id="nm_usuario" name="nm_usuario" value="<?php echo $nm_usuario ?>" readonly="readonly" >
								</div>						
							</div>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nr_cotacao_i4pro">Nº Cotação</label>
									<input type="text" class="form-control" id="nr_cotacao_i4pro" name="nr_cotacao_i4pro" value="<?php echo $nr_cotacao_i4pro ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="cd_proposta">Código Proposta</label>
									<input type="text" class="form-control" id="cd_proposta" name="cd_proposta" value="<?php echo $id_proposta ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="id_endosso">ID Proposta</label>
									<input type="text" class="form-control" id="id_endosso" name="id_endosso" value="<?php echo $id_apolice ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="pe_fipe">Percentual FIPE</label>
									<input type="text" class="form-control" id="pe_fipe" name="pe_fipe" value="<?php echo $pe_fipe ?>" readonly="readonly" >
								</div>
							</div>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_aceitacao">Aceite</label>
									<input type="text"  class="form-control" id="nm_aceitacao" name="nm_aceitacao" value="<?php echo $nm_aceitacao ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-9 col-md-9">
									<label for="cd_status_proposta">Mensagem de aceite</label>
									<input type="text" class="form-control" id="cd_status_proposta" name="cd_status_proposta" value='<?php echo $cd_status_proposta ?>' readonly="readonly" >
								</div>
							</div>
							<hr>
							
							<div class="row">
							
							</div>							
							<div class="row">
							<div class="col-lg-9 col-sm-9">
									<div class="form-group">
										<?php $campo  = ($st === 'GRAVOU')? ' class="btn btn-default" disabled="disabled" ' : 'class="btn btn-primary"'  ?>
										<button type="submit" id="cadastrar" name="cadastrar" value="cadastrar" <?php echo $campo ?>  >Gravar proposta</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->helper('js'); ?>
</body>
</html>
