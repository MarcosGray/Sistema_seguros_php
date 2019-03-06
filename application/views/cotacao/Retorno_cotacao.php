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
					<strong>Cotação - Retorno API Usebens</strong>
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
					 <?php } 
					 /* echo '<pre>';
					 print_r($cotacao);
					 echo '</pre>'; */
					 if ($cotacao['cd_tipo_pessoa'] === '1')
					 {
					 	$tipo_pessoa = 'Pessoa Física';
					 }
					 elseif ($cotacao['cd_tipo_pessoa'] === '2')
					 {
					 	$tipo_pessoa = 'Pessoa Jurídica';
					 }
					 else 
					 {
					 	$tipo_pessoa = $cotacao['cd_tipo_pessoa'];
					 }
					 
					 if ($acao === 'INSERIR')
					 {
					 	$id_revenda 			= $retornos['id_revenda'];
					 	$nm_usuario 			= $retornos['nm_usuario'];
					 	$nr_cotacao 			= $retornos['nr_cotacao'];
					 	$id_cotacao_proposta 	= $retornos['id_cotacao_proposta'];
					 	$vl_premio_tarifario 	= $retornos['vl_premio_tarifario'];
					 	$vl_lmi 				= 'R$ ' . $retornos['vl_lmi'];
					 	$vl_iof 				= 'R$ ' . $retornos['vl_iof'];
					 	$vl_franquia 			= 'R$ ' . $retornos['vl_franquia'];					 	
					 }
					 else 
					 {
					 	$id_revenda = $retornos->identificacao->attributes()->id_revenda;
					 	$nm_usuario = $retornos->identificacao->attributes()->nm_usuario;
					 	$nr_cotacao = $retornos->identificacao->gerar_cotacao_auto_configuravel->attributes()->nr_cotacao_i4pro;
					 	$id_cotacao_proposta = $retornos->identificacao->gerar_cotacao_auto_configuravel->attributes()->id_cotacao_proposta;
					 	$vl_premio_tarifario = 'R$ ' . $retornos->identificacao->gerar_cotacao_auto_configuravel->attributes()->vl_premio_tarifario;
					 	$vl_lmi = 'R$ ' . $retornos->identificacao->gerar_cotacao_auto_configuravel->attributes()->vl_lmi;
					 	$vl_iof = 'R$ ' . $retornos->identificacao->gerar_cotacao_auto_configuravel->attributes()->vl_iof;
					 	$vl_franquia = 'R$ ' . $retornos->identificacao->gerar_cotacao_auto_configuravel->attributes()->vl_franquia;
					 }
					 
					 ?>
					 <!-- Fim mensagem de alerta -->					
					 <div class="col-sm-9 col-md-9"> 
						<form action="<?php echo base_url('cotacao/gravar_cotacao') ?>" method="post" id="formulario_cotacao" >
							<div class="row">
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="id_revenda">Código revenda</label>
									<input type="text" class="form-control" id="id_revenda" name="id_revenda" value="<?php echo $id_revenda ?>" readonly="readonly" >
									<input type="hidden" class="form-control" id="cd_produto" name="cd_produto" value="<?php echo $cotacao['cd_produto'] ?>"  >
									<input type="hidden" class="form-control" id="nr_mes_periodo_vigencia" name="nr_mes_periodo_vigencia" value="<?php echo $cotacao['nr_mes_periodo_vigencia']?>"  >
								</div>							
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">Usuário</label>
									<input type="text" class="form-control" id="nm_usuario" name="nm_usuario" value="<?php echo $nm_usuario ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">Nº Cotação</label>
									<input type="text" class="form-control" id="nr_cotacao" name="nr_cotacao" value="<?php echo $nr_cotacao ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">ID Cotação</label>
									<input type="text" class="form-control" id="id_cotacao_proposta" name="id_cotacao_proposta" value="<?php echo $id_cotacao_proposta  ?>" readonly="readonly" >
								</div>							
							</div>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">Valor do premio</label>
									<input type="text" style="text-align: right;" class="form-control" id="vl_premio_tarifario" name="vl_premio_tarifario" value="<?php echo $vl_premio_tarifario  ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">Limite máximo de indenização</label>
									<input type="text" style="text-align: right;" class="form-control" id="vl_lmi" name="vl_lmi" value="<?php echo $vl_lmi ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">IOF</label>
									<input type="text" style="text-align: right;" class="form-control" id="vl_iof" name="vl_iof" value="<?php echo $vl_iof ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">Franquia</label>
									<input type="text" style="text-align: right;" class="form-control" id="vl_franquia" name="vl_franquia" value="<?php echo $vl_franquia  ?>" readonly="readonly" >
								</div>
							</div>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nr_cpf_cnpj_cliente">CPF Cliente</label>
									<input type="text"  class="form-control" id="nr_cpf_cnpj_cliente" name="nr_cpf_cnpj_cliente" value="<?php echo $cotacao['nr_cpf_cnpj_cliente'] ?>" readonly="readonly" >
									<input type="hidden" id="cliente_id" name="cliente_id" value="<?php echo $cotacao['cliente_id'] ?>" >
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-6">
									<label for="nome_cliente">Nome Cliente</label>
									<input type="text" class="form-control" id="nome_cliente" name="nome_cliente" value="<?php echo $cotacao['nome_cliente'] ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nr_cep">CEP</label>
									<input type="text"  class="form-control" id="nr_cep" name="nr_cep" value="<?php echo $cotacao['nr_cep'] ?>" readonly="readonly" >
								</div>
							</div>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="cd_tipo_pessoa">Tipo Pessoa</label>
									<input type="text" class="form-control" id="cd_tipo_pessoa" name="cd_tipo_pessoa" value="<?php echo $tipo_pessoa; //$cotacao['cd_tipo_pessoa'] ?>" readonly="readonly" >
								</div>							
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="id_marca">ID Marca</label>
									<input type="text" class="form-control" id="id_marca" name="id_marca" value="<?php echo  $cotacao['id_marca']?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="id_veiculo">ID Veículo</label>
									<input type="text" class="form-control" id="id_veiculo" name="id_veiculo" value="<?php echo  $cotacao['id_veiculo']?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="id_modelo">ID Modelo</label>
									<input type="text" class="form-control" id="id_modelo" name="id_modelo" value="<?php echo  $cotacao['id_modelo']?>" readonly="readonly" >
								</div>	
							</div>
							<div class="row">															
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="cd_fipe">Cod. Fipe</label>
									<input type="text" class="form-control" id="cd_fipe" name="cd_fipe" value="<?php echo  $cotacao['cd_fipe']?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nr_ano_auto">Ano Veículo</label>
									<input type="text" class="form-control" id="nr_ano_auto" name="nr_ano_auto" value="<?php echo  $cotacao['nr_ano_auto']?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-2">
									<label for="cd_categoria_tarifaria">Categoria Tarifária</label>
									<input type="text" class="form-control" id="cd_categoria_tarifaria" name="cd_categoria_tarifaria" value="<?php echo  $cotacao['cd_categoria_tarifaria']?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-1 col-md-2">
									<label for="dv_auto_zero">Est. Veículo</label>
									<input type="text" class="form-control" id="estado_veiculo" name="estado_veiculo" value="<?php echo $estado_veiculo?>" readonly="readonly" >
									<input type="hidden" class="form-control" id="dv_auto_zero" name="dv_auto_zero" value="<?php echo $cotacao['dv_auto_zero']?>"  >
								</div>
								<div class="form-group col-xs-12 col-sm-1 col-md-2">
									<label for="dv_auto_zero">Combustível</label>
									<input type="text" class="form-control" id="nome_combustivel" name="nome_combustivel" value="<?php echo $combustivel['nome_combustivel']?>" readonly="readonly" >
									<input type="hidden" class="form-control" id="id_auto_combustivel" name="id_auto_combustivel" value="<?php echo $cotacao['id_auto_combustivel']?>"  >
									<input type="hidden" class="form-control" id="veiculo" name="veiculo" value="<?php echo $cotacao['veiculo']?>"  >
                                    <input type="hidden" class="form-control" id="marca" name="marca" value="<?php echo $cotacao['marca']?>"  >
                                    <input type="hidden" class="form-control" id="preco" name="preco" value="<?php echo $cotacao['preco']?>"  >
                                    <input type="hidden" class="form-control" id="referencia" name="referencia" value="<?php echo $cotacao['referencia']?>"  >
                                    <input type="hidden" class="form-control" id="id_produto_cobertura" name="id_produto_cobertura" value="<?php echo $cotacao['id_produto_cobertura']?>"  >
                                    
								</div>	
							</div>
							<hr>
							<div class="row">
								<div class="col-lg-12 col-sm-12">
								<?php
								if ($acao === 'INSERIR')
								{
									
									$ids 						= explode(';', $cotacao['id_produto_cobertura']);
									$lmi 						= explode(';', $cotacao['vl_lmi_cobertura']);
									$franquia 					= explode(';', $cotacao['vl_franquia_cobertura']);
									$franquia_acumulada 		= $cotacao['vl_franquia_cobertura'];
									$limite_cobertura_acumulada	= $cotacao['vl_lmi_cobertura'];
									$qt = count($ids);
									for ($i = 0; $i < $qt; $i++)
									{
										echo '<li>ID Cobertura: <strong>'.$ids[$i].'</strong> Limite Cobertura: <strong>R$ '.$lmi[$i].'</strong> Franquia:  <strong>R$ '.$franquia[$i].'</strong></li>';
									}
									/* echo '<pre>';
									print_r($cotacao);
									echo '</pre>'; */
								}
								else 
								{
									$qt = count($retornos->identificacao->gerar_cotacao_auto_configuravel->coberturas);
									$franquia_acumulada			= '';
									$limite_cobertura_acumulada	= '';
									for ($i=0; $i < $qt; $i++)
									{
										$id_cobertura 		= $retornos->identificacao->gerar_cotacao_auto_configuravel->coberturas[$i]->attributes()->id_produto_cobertura;
										$limite_cobertura 	= $retornos->identificacao->gerar_cotacao_auto_configuravel->coberturas[$i]->attributes()->vl_lmi_cobertura;
										$franquia			= $retornos->identificacao->gerar_cotacao_auto_configuravel->coberturas[$i]->attributes()->vl_franquia_cobertura;
										if ($i < ($qt - 1))
										{
											$franquia_acumulada 		.= (empty($franquia))? '0.00;' : $franquia . ';'; 
											$limite_cobertura_acumulada .= (empty($limite_cobertura))? '0.00;' : $limite_cobertura. ';'; 
										}
										else 
										{
											$franquia_acumulada 		.= (empty($franquia))? '0.00' : $franquia;
											$limite_cobertura_acumulada .= (empty($limite_cobertura))? '0.00' : $limite_cobertura;
										}
										if (empty($franquia))
										{
											$franquia = '0.00';
										}
										echo '<li>ID Cobertura: <strong>'.$id_cobertura.'</strong> Limite Cobertura: <strong>R$ '.$limite_cobertura.'</strong> Franquia:  <strong>R$ '.$franquia.'</strong></li>';
									}									
								}
								?>
									<input type="hidden" class="form-control" id="vl_franquia_cobertura" name="vl_franquia_cobertura" value="<?php echo $franquia_acumulada ?>"  >
									<input type="hidden" class="form-control" id="vl_lmi_cobertura" name="vl_lmi_cobertura" value="<?php echo $limite_cobertura_acumulada ?>"  >		
								</div>
							</div>
							<hr>
							<div class="row">
							
							</div>							
							<div class="row">
							<div class="col-lg-9 col-sm-9">
									<div class="form-group">
										<?php $campo  = ($st === 'GRAVOU')? ' class="btn btn-default" disabled="disabled" ' : 'class="btn btn-primary"'  ?>
										<button type="submit" id="cadastrar" name="cadastrar" value="cadastrar" <?php echo $campo ?>  >Gravar cotação</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="col-sm-3 col-md-3">
                      <!--user info table start-->
                      <section class="panel">
                          <table class="table table-hover personal-task">
                              <tbody>
                                <tr>
                                    <td><strong>Tabela FIPE</strong></td>
                                </tr>
                                <tr>
                                    <td><?php echo '<strong>Veículo: </strong>' . $cotacao['veiculo'] ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo '<strong>Marca: </strong>' . $cotacao['marca']?></td>
                                </tr>
                                <tr>
                                    <td><?php echo '<strong>Preço: </strong>' . $cotacao['preco']?></td>
                                </tr>
                                <tr>
                                    <td><?php echo '<strong>Referencia: </strong>' . $cotacao['referencia']?></td>
                                </tr>
                              </tbody>
                          </table>
                          <div class="alert alert-success" role="alert"><?php echo '<strong>Virgencia do plano: </strong>' . $cotacao['nr_mes_periodo_vigencia'] . ' meses' ?></div>
                      </section>
                      <!--user info table end-->						
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->helper('js'); ?>
</body>
</html>
