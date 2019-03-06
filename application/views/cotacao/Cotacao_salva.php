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
    $this->load->helper('valida_data'); 
	?>
</head>
<body>
	<?php $this->load->helper('menu'); ?>
	<div class="container-fluid" >
		<div class="row">
			<br>
			<div class="panel panel-default">
				<header class="panel-heading">
					<?php if (!isset($titulo)) { ?>
					<strong>Cotação - Retorno API Usebens</strong>
					<a href="<?php echo base_url('cotacao') ?>">
						<button type="button" class="btn btn-info btn-xs pull-right">Pesquisar outro cliente</button>
					</a>
					<?php } else {?>
					<strong><?php echo $titulo ?></strong>
					<a href="<?php echo base_url('cotacao/pesquisa_cotacao_gravada') ?>">
						<button type="button" class="btn btn-info btn-xs pull-right">Pesquisar outra cotação</button>
					</a>
					<?php } ?>
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
					 /* echo '<pre>';
					 print_r($cliente);
					 print_r($cotacao);
					 echo '</pre>'; */
					 ?>				
					 <div class="col-sm-9 col-md-9"> 
						<form action="<?php echo base_url('cotacao/gerar_proposta') ?>" method="post" id="formulario_proposta" >
							<div class="row">
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="id_revenda">Código revenda</label>
									<input type="text" class="form-control" id="id_revenda" name="id_revenda" value="<?php echo $cotacao['id_revenda'] ?>" readonly="readonly" >
									<input type="hidden" class="form-control" id="cd_produto" name="cd_produto" value="<?php echo $cotacao['cd_produto'] ?>"  >
									<input type="hidden" class="form-control" id="nr_mes_periodo_vigencia" name="nr_mes_periodo_vigencia" value="<?php echo $cotacao['nr_mes_periodo_vigencia']?>"  >
									<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $cotacao['id']?>"  >
								</div>							
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">Usuário</label>
									<input type="text" class="form-control" id="nm_usuario" name="nm_usuario" value="<?php echo $cotacao['nm_usuario'] ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">Nº cotação</label>
									<input type="text" class="form-control" id="nr_cotacao" name="nr_cotacao" value="<?php echo $cotacao['nr_cotacao'] ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">ID cotação</label>
									<input type="text" class="form-control" id="id_cotacao_proposta" name="id_cotacao_proposta" value="<?php echo $cotacao['id_cotacao_proposta'] ?>" readonly="readonly" >
								</div>							
							</div>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">Valor do premio</label>
									<input type="text" style="text-align: right;" class="form-control" id="vl_premio_tarifario" name="vl_premio_tarifario" value="<?php echo  'R$ ' . $cotacao['vl_premio_tarifario'] ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">Limite máximo de indenização</label>
									<input type="text" style="text-align: right;" class="form-control" id="vl_lmi" name="vl_lmi" value="<?php echo  'R$ ' . $cotacao['vl_lmi'] ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">IOF</label>
									<input type="text" style="text-align: right;" class="form-control" id="vl_iof" name="vl_iof" value="<?php echo  'R$ ' . $cotacao['vl_iof'] ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nm_usuario">Franquia</label>
									<input type="text" style="text-align: right;" class="form-control" id="vl_franquia" name="vl_franquia" value="<?php echo  'R$ ' . $cotacao['vl_franquia'] ?>" readonly="readonly" >
								</div>
							</div>							
							<div class="row">														
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="id_marca">ID marca</label>
									<input type="text" class="form-control" id="id_marca" name="id_marca" value="<?php echo  $cotacao['id_marca']?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="id_veiculo">ID veículo</label>
									<input type="text" class="form-control" id="id_veiculo" name="id_veiculo" value="<?php echo  $cotacao['id_veiculo']?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="id_modelo">ID modelo</label>
									<input type="text" class="form-control" id="id_modelo" name="id_modelo" value="<?php echo  $cotacao['id_modelo']?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="cd_categoria_tarifaria">Categoria tarifária</label>
									<input type="text" class="form-control" id="cd_categoria_tarifaria" name="cd_categoria_tarifaria" value="<?php echo  $cotacao['cd_categoria_tarifaria']?>" readonly="readonly" >
								</div>	
							</div>
							<div class="row">															
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="cd_fipe">Cod. fipe</label>
									<input type="text" class="form-control" id="cd_fipe" name="cd_fipe" value="<?php echo  $cotacao['cd_fipe']?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nr_ano_auto">Ano veículo</label>
									<input type="text" class="form-control" id="nr_ano_auto" name="nr_ano_auto" value="<?php echo  $cotacao['nr_ano_auto']?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="dv_auto_zero">Est. veículo</label>
									<input type="text" class="form-control" id="estado_veiculo" name="estado_veiculo" value="<?php echo $estado_veiculo = ($cotacao['dv_auto_zero'] === '1')? 'Novo' : 'Usado'; ?>" readonly="readonly" >
									<input type="hidden" class="form-control" id="dv_auto_zero" name="dv_auto_zero" value="<?php echo $cotacao['dv_auto_zero'] ?>"  >
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="dv_auto_zero">Combustível</label>
									<input type="text" class="form-control" id="nome_combustivel" name="nome_combustivel" value="<?php echo $combustivel['nome_combustivel'] ?>" readonly="readonly" >
									<input type="hidden" class="form-control" id="id_auto_combustivel" name="id_auto_combustivel" value="<?php echo $cotacao['id_auto_combustivel']?>"  >
									<input type="hidden" class="form-control" id="veiculo" name="veiculo" value="<?php echo $cotacao['veiculo']?>"  >
                                    <input type="hidden" class="form-control" id="marca" name="marca" value="<?php echo $cotacao['marca']?>"  >
                                    <input type="hidden" class="form-control" id="preco" name="preco" value="<?php echo $cotacao['preco']?>"  >
                                    <input type="hidden" class="form-control" id="referencia" name="referencia" value="<?php echo $cotacao['referencia']?>"  >
                                    <input type="hidden" class="form-control" id="id_produto_cobertura" name="id_produto_cobertura" value="<?php echo $cotacao['id_produto_cobertura']?>"  >
                                    <input type="hidden" class="form-control" id="vl_lmi_cobertura" name="vl_lmi_cobertura" value="<?php echo $cotacao['vl_lmi_cobertura']?>"  >
								</div>	
							</div>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nr_cpf_cnpj_cliente">CPF cliente</label>
									<input type="text"  class="form-control" id="nr_cpf_cnpj_cliente" name="nr_cpf_cnpj_cliente" value="<?php echo $cotacao['nr_cpf_cnpj_cliente'] ?>" readonly="readonly" >
								</div>
								<div class="form-group col-xs-12 col-sm-9 col-md-9">
									<label for="nome_cliente">Nome cliente</label>
									<input type="text" class="form-control" id="nome_cliente" name="nome_cliente" value="<?php echo $cotacao['nome_cliente'] ?>" readonly="readonly" >
								</div>
							</div>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="cd_tipo_pessoa">Tipo pessoa</label>
									<input type="text" class="form-control" id="cd_tipo_pessoa" name="cd_tipo_pessoa" value="<?php echo ($cotacao['cd_tipo_pessoa'] === '1')? 'Pessoa Física' : 'Pessoa Jurídica' ?>" readonly="readonly" >
								</div>	
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="sexo">Sexo</label>
									<input type="text" class="form-control" id="id_sexo" name="id_sexo" value="<?php echo $cliente['sexo']?>"  >
								</div>
								<div class="col-lg-3 col-sm-3">
									<div class="form-group">
	                                	<label class="control-label" for="estado_civil">Estado civil*</label>
	                                    <select id="estado_civil" name="estado_civil" class="form-control m-bot15" <?php echo ($cotacao['cd_tipo_pessoa'] === '1')? '' : 'disabled="disabled"' ?>   >
	                                    	<option value="0"></option>
	                                      	<?php foreach ($estados as $estado) {?>
	                                        <option value="<?php echo $estado['id'] ?>" <?php echo (isset($estado_escolhido)  && ($estado_escolhido== $estado['id']))? 'selected="selected"' : '' ?> ><?php echo $estado['estado_civil'] ?></option>
	                                      	<?php } ?>
	                                    </select>
	                                </div>
								</div>
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="dt_nascimento"> <?php echo ($cotacao['cd_tipo_pessoa'] === '1')? 'Dt nascimento' : 'Dt constituição' ?>*</label>
									<input type="text" class="form-control mascara_data" id="dt_nascimento" name="dt_nascimento" onBlur="return valData(this.value,this.id)" value="<?php echo  $cliente['dtnascimento']?>" >
								</div>			
							</div>
							<hr>
							<div class="row">
								<div class="checkbox col-xs-12 col-sm-6 col-md-6">
									<label>
										<input type="checkbox" id="nm_resp1" name="nm_resp1" value="1"  > Exerceu nos últimos 5 (cinco) anos ou
																exerce, atualmente, no Brasil ou fora
																dele, cargos, empregos ou funções
																públicas relevantes?
																<br>
																<strong>* Obrigatório somente se pessoa for física</strong>
									</label>
								</div>
								<div class="checkbox col-xs-12 col-sm-6 col-md-6">
									<label>
										<input type="checkbox" id="nm_resp2" name="nm_resp2" value="1"  > Possui representantes, familiares(pais,
																filhos, cônjuge, companheiro(a) e
																enteado(a)) ou pessoas de seu
																relacionamento próximo que exerceram
																nos últimos 5 anos, ou exercem,
																atualmente, no Brasil ou fora dele,
																cargos, empregos ou funções públicas?
																<br>
																<strong>* Obrigatório somente se pessoa for física</strong>
									</label>
								</div>							
							</div>	
							<hr>
							<div class="row">
								<div class="form-group col-xs-4 col-sm-1 col-md-1">
									<label for="nr_ddd_res">DDD*</label>
									<input type="text" maxlength="2" class="form-control" id="nr_ddd_res" name="nr_ddd_res" value="<?php echo html_escape(set_value('nr_ddd_res'))  ?>"  >
								</div>
								<div class="form-group col-xs-8 col-sm-2 col-md-2">
									<label for="nm_fone_res">Fone residencia*</label>
									<input type="text" maxlength="9" class="form-control" id="nm_fone_res" name="nm_fone_res" value="<?php echo html_escape(set_value('nm_fone_res'))  ?>"  >
								</div>
								<div class="form-group col-xs-4 col-sm-1 col-md-1">
									<label for="nr_ddd_cel">DDD</label>
									<input type="text" maxlength="2" class="form-control" id="nr_ddd_cel" name="nr_ddd_cel" value="<?php echo html_escape(set_value('nr_ddd_cel'))  ?>"  >
								</div>
								<div class="form-group col-xs-8 col-sm-2 col-md-2">
									<label for="nm_fone_cel">Fone celular</label>
									<input type="text" maxlength="9" class="form-control" id="nm_fone_cel" name="nm_fone_cel" value="<?php echo html_escape(set_value('nm_fone_cel'))  ?>"  >
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-6">
									<label for="nm_email">E-mail*</label>
									<input type="text" maxlength="40" class="form-control" id="nm_email" name="nm_email" value="<?php echo  $cliente['email']?>" >
								</div>	
							</div>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-10 col-md-10">
									<label for="nm_endereco">Endereço*</label>
									<input type="text" maxlength="80" class="form-control" id="nm_endereco" name="nm_endereco" value="<?php echo  $cliente['endereco']?>" >
								</div>
								<div class="form-group col-xs-8 col-sm-2 col-md-2">
									<label for="nr_endereco">Nº*</label>
									<input type="text" maxlength="10" class="form-control" id="nr_endereco" name="nr_endereco" value="<?php echo $cliente['numero'] ?>"  >
								</div>
							</div>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-8 col-md-8">
									<label for="nm_complemento">Complemento</label>
									<input type="text" maxlength="60" class="form-control" id="nm_complemento" name="nm_complemento" value="<?php echo  $cliente['complemento']?>" >
								</div>
								<div class="form-group col-xs-12 col-sm-4 col-md-4">
									<label for="nm_bairro">Bairro*</label>
									<input type="text" maxlength="50" class="form-control"  id="nm_bairro" name="nm_bairro" value="<?php echo  $cliente['bairro']?>" >
								</div>
								
							</div>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-6 col-md-6">
									<label for="nm_cidade">Cidade*</label>
									<input type="text" maxlength="50" class="form-control" id="nm_cidade" name="nm_cidade" value="<?php echo  $cliente['cidade'] ?>"  >
								</div>
								<div class="col-lg-3 col-sm-3">
									<div class="form-group">
	                                	<label class="control-label" for="cd_uf">UF*</label>
	                                    <select id="cd_uf" name="cd_uf" class="form-control m-bot15"  >
	                                    	<option value="0"></option>
	                                      	<?php 	                                      	
	                                      	foreach ($unidades as $unidade) 
	                                      	{	
	                                      		$unidade_lista = $unidade->attributes()->nm_estado;
	                                      	?>
	                                        <option <?php echo ($unidade_lista === $cliente['uf'])? 'selected="selected"' : '' ?> value="<?php echo $unidade->attributes()->cd_uf ?>" > <?php echo $unidade->attributes()->nm_estado ?> </option>
	                                      	<?php 
	                                      	} 
	                                      	?>
	                                    </select>
	                                </div>
								</div>								
								<div class="form-group col-xs-12 col-sm-3 col-md-3">
									<label for="nr_cep">CEP</label>
									<input type="text"  class="form-control" id="nr_cep" name="nr_cep" value="<?php echo $cotacao['nr_cep'] ?>" readonly="readonly" >
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-sm-4">
									<div class="form-group">
	                                	<label class="control-label" for="cd_profissao">Profissão*</label>
	                                    <select id="cd_profissao" name="cd_profissao" class="form-control m-bot15" <?php echo ($cotacao['cd_tipo_pessoa'] === '1')? '' : 'disabled="disabled"' ?> >
	                                    	<option value="0"></option>
	                                      	<?php 	                                      	
	                                      	foreach ($profissoes as $profissao) {	                                      	
	                                      	?>
	                                        <option value="<?php echo $profissao->attributes()->cd_profissao?>" > <?php echo $profissao->attributes()->cd_profissao .' - '. $profissao->attributes()->nm_profissao ?> </option>
	                                      	<?php 
	                                      	} 
	                                      	?>
	                                    </select>
	                                </div>
								</div>
								<div class="col-lg-8 col-sm-8">
									<div class="form-group">
	                                	<label class="control-label" for="id_ramo_atividade">Ramo de atividade*</label>
	                                    <select id="id_ramo_atividade" name="id_ramo_atividade" class="form-control m-bot15" <?php echo ($cotacao['cd_tipo_pessoa'] === '1')? 'disabled="disabled"' : '' ?> >
	                                    	<option value="0"></option>
	                                      	<?php 	                                      	
	                                      	foreach ($ramos as $ramo) {	                                      	
	                                      	?>
	                                        <option value="<?php echo $ramo->attributes()->id_ramo_atividade?>" > <?php echo $ramo->attributes()->id_ramo_atividade.' - '. $ramo->attributes()->nm_ramo_atividade?> </option>
	                                      	<?php 
	                                      	} 
	                                      	?>
	                                    </select>
	                                </div>
								</div>		
							</div>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-2 col-md-2">
									<label for="nm_placa">Placa*</label>
									<input type="text" maxlength="10" class="form-control" id="nm_placa" name="nm_placa" value="<?php echo html_escape(set_value('nm_placa'))  ?>"  >
								</div>
								<div class="form-group col-xs-12 col-sm-6 col-md-6">
									<label for="nm_chassis">Chassis*</label>
									<input type="text" maxlength="20" class="form-control" id="nm_chassis" name="nm_chassis" value="<?php echo html_escape(set_value('nm_chassis'))  ?>"  >
								</div>
								<div class="form-group col-xs-12 col-sm-2 col-md-2">
									<label class="control-label" for="dv_segurado_proprietario">Proprietário do veículo</label>
									<select class="form-control" id="dv_segurado_proprietario" name="dv_segurado_proprietario" autofocus="autofocus" >
										<option value="0">Não</option>
										<option value="1">Sim</option>
									</select>
								</div>
								<div class="form-group col-xs-12 col-sm-2 col-md-2">
									<label class="control-label" for="id_auto_utilizacao">Utilização</label>
									<select class="form-control" id="id_auto_utilizacao" name="id_auto_utilizacao" autofocus="autofocus" >
										<option value="1" <?php echo ($cotacao['cd_tipo_pessoa'] === '1')? 'selected="selected"' : '' ?> >Particular</option>
										<option value="2" <?php echo ($cotacao['cd_tipo_pessoa'] === '2')? 'selected="selected"' : ''?> >Comercial</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 col-sm-4">
									<div class="form-group">
	                                	<label class="control-label" for="cd_forma_pagamento_parcela">Forma de pagamento*</label>
	                                    <select id="cd_forma_pagamento_parcela" name="cd_forma_pagamento_parcela" class="form-control m-bot15"  >
	                                    	<option value="0"></option>
	                                      	<?php foreach ($formas as $forma) {?>
	                                        <option value="<?php echo $forma['cd_forma_pagamento'] ?>" <?php echo (isset($forma_escolhida)  && ($forma_escolhida == $forma['cd_forma_pagamento']))? 'selected="selected"' : '' ?> ><?php echo $forma['nm_forma_pagamento'] ?></option>
	                                      	<?php } ?>
	                                    </select>
	                                </div>
								</div>
								<div class="col-lg-4 col-sm-4">
									<div class="form-group">
	                                	<label class="control-label" for="id_produto_parc_premio">Parcelamento*</label>
	                                    <select id="id_produto_parc_premio" name="id_produto_parc_premio" class="form-control m-bot15"  >
	                                    	<option value="0"></option>
	                                      	<?php 	                                      	
	                                      	foreach ($parcelamentos as $parcelamento) {	                                      	
	                                      	?>
	                                        <option value="<?php echo $parcelamento->attributes()->id_produto_parc_premio ?>" > <?php echo $parcelamento->attributes()->ds_parcelamento ?> </option>
	                                      	<?php 
	                                      	} 
	                                      	?>
	                                    </select>
	                                </div>
								</div>
								<!-- CD_FORMA_PAGAMENTO_PPARCELA / ID_PRODUTO_PARC_PREMIO -->
							</div>
							<hr>
							<div class="row">
								<div class="col-lg-12 col-sm-12">
								<?php								
								foreach ($coberturas as $linha)
								{									
									echo '<li>ID Cobertura: <strong>'.$linha['id_cobertura'].'</strong> Limite Cobertura: <strong>R$ '.$linha['limite_cobertura'].'</strong> Franquia:  <strong>R$ '.$linha['franquia'].'</strong></li>';
								}
								?>	
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									
								</div>
							</div>							
							<div class="row">
								<div class="col-lg-9 col-sm-9">
									<div class="form-group">
										<?php $campo  = ($st === 'GRAVOU')? ' class="btn btn-default" disabled="disabled" ' : 'class="btn btn-primary"'  ?>
										<button type="submit" id="proposta" name="proposta" value="proposta" <?php echo $campo ?> >Gerar proposta</button>
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
	
	<?php 
	$this->load->helper('script_data');
	$this->load->helper('js');		 
	?>
</body>
</html>
