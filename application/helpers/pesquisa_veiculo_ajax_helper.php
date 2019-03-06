<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript">

	var base_url = "<?php echo base_url('cotacao/pesquisa_veiculo_fipe/')?>";

	$(function(){
		$('#id_marca').change(function(){
			var id_marca = $('#id_marca').val();
			$.post(base_url, 
					{id_marca : id_marca}, 
					function(data){
						//console.log(data);
						$("#id_veiculo").html(data);
					});
		});
	});

	var base_url_modelo = "<?php echo base_url('cotacao/pesquisa_modelo_fipe/')?>";

	$(function(){
		$('#id_veiculo').click(function(){
			var id_marca = $('#id_marca').val();
			var id_veiculo = $('#id_veiculo').val();
			$.post(base_url_modelo, 
					{id_marca : id_marca, id_veiculo : id_veiculo}, 
					function(data){
						//console.log(data);
						$("#id_modelo").html(data);
					});
		});
	});

	var base_url_tabela = "<?php echo base_url('cotacao/pesquisa_tabela_fipe/')?>";

	$(function(){
		$('#id_modelo').click(function(){
			var id_marca = $('#id_marca').val();
			var id_veiculo = $('#id_veiculo').val();
			var id_modelo = $('#id_modelo').val();
			$.post(base_url_tabela, 
					{id_marca : id_marca, id_veiculo : id_veiculo, id_modelo : id_modelo}, 
					function(data){
						//console.log(data);
						//$("#tabela_fipe").html(data);
						$("#codigo_fipe").html(data);
					});
		});
	});
</script>