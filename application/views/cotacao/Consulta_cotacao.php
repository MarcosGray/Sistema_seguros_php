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
					<strong>Cotação</strong>
					<a href="<?php echo base_url('cotacao') ?>">
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
					 <?php
					
					 ?>					
					<form action="<?php echo base_url('cotacao/enviar_cotacao_webservice_salvar_base') ?>" method="post" id="formulario_cotacao" >
						<div class="row">
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label for="id_revenda">Código revenda</label>
								<input type="text" class="form-control" id="id_revenda" name="id_revenda" value="<?php echo $revenda['id_revenda'] ?>" readonly="readonly" >
							</div>
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label for="cd_produto">Código produto</label>
								<input type="text" class="form-control" id="cd_produto" name="cd_produto" value="<?php echo $revenda['cd_produto'] ?>" readonly="readonly" >
							</div>
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label for="nm_usuario">Usuário</label>
								<input type="text" class="form-control" id="nm_usuario" name="nm_usuario" value="<?php echo  $revenda['nm_usuario'] ?>" readonly="readonly" >
							</div>
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label class="control-label" for="nr_mes_periodo_vigencia">Vigencia</label>
								<select class="form-control" id="nr_mes_periodo_vigencia" name="nr_mes_periodo_vigencia" autofocus="autofocus" >
									<option value="12">12 meses</option>
									<option value="24">24 meses</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label for="nr_cpf_cnpj_cliente">CPF/CNPJ Cliente*</label>
								<input type="text" class="form-control" id="nr_cpf_cnpj_cliente" name="nr_cpf_cnpj_cliente" value="<?php echo $cliente['cprf'] ?>"  >
								<input type="hidden" id="cliente_id" name="cliente_id" value="<?php echo $cliente['id'] ?>" >
							</div>
							<div class="form-group col-xs-12 col-sm-4 col-md-4">
								<label for="nome_cliente">Nome Cliente*</label>
								<input type="text" class="form-control" id="nome_cliente" name="nome_cliente" value="<?php echo $cliente['nome_razao'] ?>"  >
							</div>
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label for="nr_cep">CEP Cliente*</label>
								<input type="text" class="form-control cep" id="nr_cep" name="nr_cep" value="<?php echo $this->funcoes->somente_numero($cliente['cep']) ?>"  >
							</div>
							<?php 
							if ($cliente !== NULL)
							{
							?>
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label for="cd_tipo_pessoa">Tipo Cliente*</label>
								<?php 
								if ($cliente['tipo_cliente'] === '1')
								{
									$tipo_cliente = 'Pessoa Física';
								}
								elseif ($cliente['tipo_cliente'] === '2')
								{
									$tipo_cliente = 'Pessoa Jurídica';
								}
								else
								{
									$tipo_cliente = '';
								}
								?>
								<input type="text" class="form-control" id="cd_tipo_pessoa" name="cd_tipo_pessoa" value="<?php echo ($tipo_cliente != '')? $tipo_cliente : html_escape(set_value('cd_tipo_pessoa'))?>"  >
							</div>
							<?php } else { ?>
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label class="control-label" for="cd_tipo_pessoa">Situação veículo*</label>
								<select class="form-control" id="cd_tipo_pessoa" name="cd_tipo_pessoa" autofocus="autofocus" >
									<option value="Pessoa Física">Pessoa Física</option>
									<option value="Pessoa Jurídica">Pessoa Jurídica</option>
								</select>
							</div>
							<?php } ?>
						</div>
						<div class="row">

						</div>
						<div class="row">
							<div class="col-lg-2 col-sm-2">
								<div class="form-group">
                                	<label class="control-label" for="id_marca">Marcas - tabela FIPE*</label>
                                    <select id="id_marca" name="id_marca" class="form-control m-bot15"  >
                                    	<option value="0">Escolha uma marca</option>
                                      	<?php foreach ($marcas as $marca) {?>
                                        <option value="<?php echo $marca['id'] ?>" <?php echo (isset($marca_escolhida)  && ($marca_escolhida== $marca['id']))? 'selected="selected"' : '' ?> ><?php echo $marca['name'] ?></option>
                                      	<?php } ?>
                                    </select>
                                </div>
							</div>
							<div class="col-lg-4 col-sm-4">
								<div class="form-group">
                                	<label class="control-label" for="id_veiculo">Veículos - tabela FIPE*</label>
                                    <select id="id_veiculo" name="id_veiculo" class="form-control m-bot15"></select>
                                </div>
							</div>
							<div class="col-lg-2 col-sm-2">
								<div class="form-group">
                                	<label class="control-label" for="id_modelo">Modelos - tabela FIPE*</label>
                                    <select id="id_modelo" name="id_modelo" class="form-control m-bot15"></select>
                                </div>
							</div>
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label class="control-label" for="dv_auto_zero">Situação veículo*</label>
								<select class="form-control" id="dv_auto_zero" name="dv_auto_zero" autofocus="autofocus" >
									<option value="1">Novo</option>
									<option value="2">Usado</option>
								</select>
							</div>
						</div>
						<div class="row">
							<!-- <div class="col-lg-4 col-sm-4" id="tabela_fipe"></div> -->
							<div id="codigo_fipe">
								<div class="form-group col-lg-2 col-sm-2" >
									<label for="cd_fipe">Código FIPE*</label>
									<input type="text" class="form-control" id="cd_fipe" name="cd_fipe" value="" readonly="readonly" >
								</div>
								<div class="form-group col-lg-2 col-sm-2" >
									<label for="nr_ano_auto">Ano do veículo*</label>
									<input type="text" class="form-control" id="nr_ano_auto" name="nr_ano_auto" value="" readonly="readonly" >
								</div>
								<div class="form-group col-lg-2 col-sm-2" >
									<label for="cd_categoria_tarifaria">Categoria Tarifária*</label>
									<input type="text" class="form-control" id="cd_categoria_tarifaria" name="cd_categoria_tarifaria" value="" readonly="readonly" >
								</div>
							</div>
							<div class="form-group col-lg-4 col-sm-4">
                            	<label class="control-label" for="id_auto_combustivel">Tipos de combustiveis*</label>
                                <select id="id_auto_combustivel" name="id_auto_combustivel" class="form-control m-bot15"  >
                                	<!-- <option value="0">Escolha um tipo de combustível</option> -->
                                    <?php foreach ($combustiveis as $combustivel) {?>
                                    <option value="<?php echo $combustivel['id'] ?>" <?php echo (isset($combustivel_escolhida)  && ($combustivel_escolhida == $combustivel['id']))? 'selected="selected"' : '' ?> ><?php echo $combustivel['id'] . ' - ' . $combustivel['nome_combustivel'] ?></option>
                                    <?php } ?>
                                </select>
							</div>
						</div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <label class="control-label" for="id_produto_cobertura">Coberturas da apólice</label>
                            </div>
                        </div>
                        <hr>
						<div class="row">
							<div class="col-lg-12 col-sm-12">							
							<?php							
							$qt = count($coberturas);
							for ($i=0; $i < $qt; $i++) {
								echo '<div class="form-group col-lg-4 col-sm-4" >';
                                echo '  <div class="checkbox">';
                                echo '      <label>';
                                echo '          <input type="checkbox" id="id_produto_cobertura" name="id_produto_cobertura[]" value="'.$coberturas[$i]->id_produto_cobertura.'-'.$coberturas[$i]->vl_limite_indenizacao.'" > ' . $coberturas[$i]->id_produto_cobertura .' - '.$coberturas[$i]->nm_cobertura;
                                echo '      </label>';
                                echo '  </div>';
                                echo '</div>';
							}							
							?>							
							</div>
						</div>
						<hr>
						<div class="row">
						<div class="col-lg-3 col-sm-3">
								<div class="form-group">
									<button type="submit" id="cadastrar" name="cadastrar" value="cadastrar" class="btn btn-primary">Gerar Cotação</button>
								</div>
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
