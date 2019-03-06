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
  <div class="container-fluid">
    <div class="row-fluid" >
        <div class="col-lg-offset-4 col-lg-4 col-md-offset-4 col-md-4 col-xs-offset-4 col-xs-4" id="box">
			<a class="center" id="logo" href="#"><img class="center" alt="logo" src="<?php echo base_url('img/logo.png') ?>" width="95%" height="30%"></a>
			<p><div class="pull-right texto_branco">&nbsp; MtrackSeguros versão <strong>1.0.0</strong></div></p>			
			<hr>
			<?php if ($alerta != NULL){ ?>
			<div class="alert alert-<?php echo $alerta["class"]; ?>" >
			  	<?php echo $alerta["mensagem"];  ?>
			</div>
			<?php } ?>
           	<form class="form-horizontal" action="<?php echo base_url() ?>" method="post" id="contact_form">
           	  <input type="hidden" id="captcha" name="captcha" value="" />
              <fieldset>
                <div class="form-group">
                   <div class="col-md-12">
                    <div class="input-group">
                     	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                     	<input type="text" id="usu_login" name="usu_login" placeholder="Login" class="form-control" autofocus>                     	
                    </div>
                   </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                      <input type="password" id="usu_senha" name="usu_senha" placeholder="Senha" class="form-control" >
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-12">
                  	<button type="submit" class="btn btn-md btn-danger pull-right" id="entrar" name="entrar" value="entrar" >Entrar</button>
               		</div>
                </div>
              </fieldset>
            </form>
       </div>
			 <!-- <p class="footer">Multtrack versão <strong>1.0.0</strong></p> -->
		</div>
	</div>
	<?php $this->load->helper('js'); ?>
</body>
</html>
