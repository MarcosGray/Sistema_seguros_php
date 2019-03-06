<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="row-fluid" >
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">MtrackSeguros</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="<?php echo base_url('login/home') ?>">Home</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Módulos<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a class="" href="<?php echo base_url('usuario/consulta') ?>">Usuários</a></li>
							<li><a class="" href="<?php echo base_url('categoria_tarifaria') ?>">Categorias tarifárias</a></li>
							<li><a class="" href="<?php echo base_url('combustivel') ?>">Combustível</a></li>
							<li><a class="" href="<?php echo base_url('forma_pagamento') ?>">Forma de Pagamento</a></li>
							<li><a class="" href="<?php echo base_url('revenda') ?>">Revenda</a></li>
							<li role="separator" class="divider"></li>
							<li><a class="" href="<?php echo base_url('cotacao') ?>">Gerar Cotação</a></li>
							<li><a class="" href="<?php echo base_url('cotacao/pesquisa_marcas_fipe') ?>">Gerar Cotação Cliente Novo</a></li>
							<li><a class="" href="<?php echo base_url('cotacao/pesquisa_cotacao_gravada') ?>">Consultar Cotação e Gerar Proposta</a></li>
							<li><a class="" href="<?php echo base_url('cotacao/pesquisa_proposta_gravada') ?>">Consultar Proposta e Gerar Venda</a></li>
							<li><a class="" href="<?php echo base_url('venda') ?>">Consultar vendas</a></li>
						</ul>
					</li>
					<!--<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Consultas de <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a class="" href="#"></a></li>
							<li><a class="" href="#"></a></li>
							<li role="separator" class="divider"></li>
							<li><a class="" href="#"></a></li>
							<li role="separator" class="divider"></li>
							<li><a class="" href="#"></a></li>
						</ul>
					</li> -->
					<!-- <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Configurações <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a class="" href=" --><?php #echo base_url('importar') ?><!-- ">Importar</a></li>
							<li><a class="" href="#"></a></li>
							<li role="separator" class="divider"></li>
							<li><a class="" href="#"></a></li>
							<li role="separator" class="divider"></li>
							<li><a class="" href="#"></a></li>
						</ul>
					</li>  -->
					<!-- <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Impressão de <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a class="" href="#"></a></li>
							<li><a class="" href="#"></a></li>
						</ul>
					</li> -->
					<li><a href="<?php echo base_url('login/sair') ?>">Sair</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</nav>

