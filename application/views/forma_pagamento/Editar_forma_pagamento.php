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
					<strong>Editar forma de pagamento</strong>
					<a href="<?php echo base_url('forma_pagamento') ?>">
						<button type="button" class="btn btn-info btn-xs pull-right">Pesquisar formas de pagamentos</button>
					</a>
			  	</header>	
				<div class="panel-body">
					<?php if ($alerta != NULL){ ?>
					<div class="alert alert-<?php echo $alerta["class"]; ?>" >
					  	<?php echo $alerta["mensagem"];  ?>
					</div>
					<?php } ?>
					<form action="<?php base_url('forma_pagamento/edicao') ?>" method="post" >
						<div class="row">
							<div class="form-group col-xs-12 col-sm-2 col-md-2">
								<label for="cd_forma_pagamento">Código</label>
								<input type="text" class="form-control" id="cd_forma_pagamento" name="cd_forma_pagamento" value="<?php echo $forma['cd_forma_pagamento'] ?>"  >
								<input type="hidden"  id="id" name="id" value="<?php echo $forma['id'] ?>"  >
							</div>
							<div class="form-group col-xs-12 col-sm-10 col-md-10">
								<label for="nm_forma_pagamento">Forma de pagamento</label>
								<input type="text" class="form-control" id="nm_forma_pagamento" name="nm_forma_pagamento" value="<?php echo html_escape($forma['nm_forma_pagamento']) ?>" >
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
