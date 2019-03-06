<script>
	function valData(data, campo)
	{//dd/mm/aaaa
	
		dia = data.substring(0,2);		
		mes = data.substring(3,5);
		ano = data.substring(6,10);
		
		if( (mes==01) || (mes==03) || (mes==05) || (mes==07) || (mes==08) || (mes==10) || (mes==12) )    
		{//mes com 31 dias
			if( (dia < 01) || (dia > 31) )
			{
			    alert('Data inválida');
			    document.getElementById(campo).value = '';
				document.getElementById(campo).focus();
			}
		} 
		else 
		{
		
			if( (mes==04) || (mes==06) || (mes==09) || (mes==11) )
			{//mes com 30 dias
				if( (dia < 01) || (dia > 30) )
				{
				    alert('Data inválida');
				    document.getElementById(campo).value = '';
					document.getElementById(campo).focus();
				}
			} 
			else 
			{
		
				if( (mes==02) )
				{//February and leap ano
					if( (ano % 4 == 0) && ( (ano % 100 != 0) || (ano % 400 == 0) ) )
					{
						if( (dia < 01) || (dia > 29) )
						{
						    alert('Data inválida');
						    document.getElementById(campo).value = '';
							document.getElementById(campo).focus();
						}
					} 
					else 
					{
						if( (dia < 01) || (dia > 28) )
						{
							alert('Data inválida');
							document.getElementById(campo).value = '';
							document.getElementById(campo).focus();
						}
					}
				} 
				else
				{
					if( (mes > 12) )
					{
						alert('Data inválida');
						document.getElementById(campo).value = '';
						document.getElementById(campo).focus();
						
					}
					else
					{
						if( (mes == 00) )
						{							
							document.getElementById(campo).focus();
						}
					}					
				}
			}
		}
		
	}
</script>