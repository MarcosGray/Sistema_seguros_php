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
		$this->load->helper('mascara_data_js');
	?>	
</head>
<body>
	<?php $this->load->helper('menu'); ?>
	<div class="container-fluid" >
		<div class="row">
			<br>
			<div class="panel panel-default">
				<header class="panel-heading">
					<strong>Proposta - Gerar venda</strong>
					<a href="<?php echo base_url('cotacao/gerar_venda') ?>">
						<button type="button" class="btn btn-info btn-xs pull-right">Pesquisar outro cliente</button>
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
						<form action="<?php echo base_url('cotacao/gerar_venda') ?>" method="post" id="formulario_cotacao" >
							<div class="row">
								<?php 
								if ($acao === 'PESQUISA')
								{
									$id = $retornos['id'];
									$id_revenda = $retornos['id_revenda'];
									$nm_usuario = $retornos['nm_usuario'];
									$nr_cotacao_i4pro = $retornos['nr_cotacao_i4pro'];
									$cd_proposta = $retornos['cd_proposta'];
									$id_endosso = $retornos['id_endosso'];
									$pe_fipe = $retornos['pe_fipe'];
									$nm_aceitacao =  $retornos['nm_aceitacao'];
									$cd_status_proposta = $retornos['cd_status_proposta'];									
								}
								?>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="id_revenda">Código revenda</label>
									<input type="text" class="form-control" id="id_revenda" name="id_revenda" value="<?php echo $id_revenda ?>" readonly="readonly" >
									<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id ?>"  >
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
									<input type="text" class="form-control" id="cd_proposta" name="cd_proposta" value="<?php echo $cd_proposta ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="id_endosso">ID Proposta</label>
									<input type="text" class="form-control" id="id_endosso" name="id_endosso" value="<?php echo $id_endosso ?>" readonly="readonly" >
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
							<label>Informações sobre rastreador</label>						
							<div class="row">
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="dt_instala_rastreador">Data Instalação*</label>
									<input type="text"  class="form-control mascara_data" id="dt_instala_rastreador" name="dt_instala_rastreador" value="<?php echo html_escape(set_value('dt_instala_rastreador')) ?>"  >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="dt_ativa_rastreador">Data Ativação</label>
									<input type="text"  class="form-control mascara_data" id="dt_ativa_rastreador" name="dt_ativa_rastreador" value="<?php echo html_escape(set_value('dt_ativa_rastreador')) ?>"  >
								</div>	
							</div>	
							<hr>						
							<div class="row">
							<div class="col-lg-9 col-sm-9">
									<div class="form-group">
										<button type="submit" id="venda" name="venda" value="venda" class="btn btn-primary">Gerar venda</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->helper('script_data'); ?>
</body>
</html>
