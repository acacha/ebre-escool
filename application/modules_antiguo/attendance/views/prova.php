<?php 
	//Consultar dades
	$url = ('http://localhost/ebre-escool/index.php/attendance/read');
	
	//Insertar dades
	//$url = ('http://localhost/ebre-escool/index.php/attendance/insert');	

	//Actualitzar dades
	//$url = ('http://localhost/ebre-escool/index.php/attendance/update');	

	//Esborrar dades
	//$url = ('http://localhost/ebre-escool/index.php/attendance/delete');	
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">

jQuery.ajax({
	url:'<?php echo $url;?>',
	data: {
			is_ajax: 'true'
		},
		type: 'post',
		dataType: 'json'
	}).done(
		function (data) 
		{
			$("#resultat").html("");
			$.each(data, function(k,v)
			{
				$("#resultat").append("<br />" + k + " | " + v);
			});	
			alert("La consulta s'ha realitzat correctament");
		}
	).fail(
		function() 
		{
			alert( "No s'ha pogut obtenir cap valor" );
		});
</script>
<div id="resultat">

</div>