<!-- jquery -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<!-- x-editable-->
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js"></script>

<!--
	<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
-->

<?php 

	/* Urls per a fer el Insertar, Editar, Llegir i Esborrar */
	$url_insert = ('http://localhost/ebre-escool/index.php/attendance/insert/prova_incidencies');
	$url_read = ('http://localhost/ebre-escool/index.php/attendance/read/prova_incidencies');
	$url_update = ('http://localhost/ebre-escool/index.php/attendance/update/prova_incidencies');
	$url_delete = ('http://localhost/ebre-escool/index.php/attendance/delete/prova_incidencies');
?>

<script>
// x-editable
$(function() {

	//toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'popup';     
    
    //observacions editable
    $('.observacions').editable({
    	ajaxOptions: {
		url: '<?php echo $url_update; ?>',
		type: 'post',
		dataType: 'json'
    	}
    });

//Datatable
//TODO

//Obtenir les dades corresponents al dropdown escollit (alumne, hora i incidència) i insertar-los a la BD
$("select").change(function(){
	var fila = null;
	var columna = null;
	var hora = null;
	var alumne = null;
	var observacions = null;	
	var incidencia = $("option:selected", this).val();
	var id = $(this).attr('id');

		//obtenir la fila i columna a partir de l'identificador
	 	text = id.split("-");
	 	fila = text[1];
	 	columna = text[0];
	 	//hora = $(".hora_"+columna).text();
	 	hora= get_hour(columna);
	 	//alumne = $("#nom_"+fila).text();
	 	alumne = get_student(fila);
	 	posicio=columna+fila;
	 	//alert(posicio);
	 	date = get_date();
	 	insert_value(alumne,hora,incidencia,posicio,date);
	 	//read_value(alumne,posicio);
	 });

    //$('#groups_by_teacher_an_date1').dataTable();
    //console.log("HEY YOU1");
	
	//Datepicker
	//var data;
	$.datepicker.regional['ca'] = {
					onSelect: function(date) {
			            data = date;
			        },
	                closeText: 'Tancar',
	                prevText: '&#x3c;Ant',
	                nextText: 'Seg&#x3e;',
	                currentText: 'Avui',
	                monthNames: ['Gener','Febrer','Mar&ccedil;','Abril','Maig','Juny',
	                'Juliol','Agost','Setembre','Octubre','Novembre','Desembre'],
	                monthNamesShort: ['Gen','Feb','Mar','Abr','Mai','Jun',
	                'Jul','Ago','Set','Oct','Nov','Des'],
	                dayNames: ['Diumenge','Dilluns','Dimarts','Dimecres','Dijous','Divendres','Dissabte'],
	                dayNamesShort: ['Dug','Dln','Dmt','Dmc','Djs','Dvn','Dsb'],
	                dayNamesMin: ['Dg','Dl','Dt','Dc','Dj','Dv','Ds'],
	                weekHeader: 'Sm',
	                dateFormat: 'dd/mm/yy',
	                firstDay: 1,
	                isRTL: false,
	                showMonthAfterYear: false,
	                yearSuffix: ''};

	data = get_date();
	//alert("la data es: "+data.val());
});


</script>

<script type="text/javascript">

function myFunction(destination_url){


}

function get_student(fila){
	alumne = $("#nom_"+fila).text();
	return alumne;
}

function get_hour(columna){
	hora = $(".hora_"+columna).text();
	return hora;
}

function get_date(){
	date = $( "#datepicker" ).datepicker($.datepicker.regional['ca']);
	return date.val();
}

function insert_value(alumne,hora,incidencia,posicio,fecha){
	jQuery.ajax({
		url:'<?php echo $url_insert;?>',
		data: {
				alumne: alumne.trim(),
				incidencia: incidencia,
				hora: hora,
				posicio: posicio,
				Data_incidencia: fecha
			},
			type: 'post',
			dataType: 'json'
		}).done(
			function (data) 
			{
				alert("S'ha insertat " + data + " fila.");
			}
		).fail(
			function() 
			{
				alert( "No s'ha pogut obtenir cap valor" );
			});
}	

function read_value(alumne,posicio){
	jQuery.ajax({
		url:'<?php echo $url_read;?>',
		data: {
				alumne: alumne,
				posicio: posicio
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
				alert("S'ha llegit " + data + ".");
			}
		).fail(
			function() 
			{
				alert( "No hi ha res encara" );
			});
}

</script>

<?php

/* Fi insertar dades */
/* Obtenir foto */
/*
	echo "<pre>";
	print_r($all_students_in_group[1]);
	echo "</pre>";
*/
$number_returned = $count_alumnes;
$contador=0;
//print_r($all_students_in_group[1]);
$alumne =array();

foreach($all_students_in_group as $student){
if($photo){
	/* Detectar tipus d'imatge (PNG o JPG) */
	$tipus = substr($student->jpegPhoto,0,10);

	$isJPG  = strpos($tipus, 'JFIF');
	if($isJPG){
		$extensio = ".jpg";
	} else {
		$isPNG  = strpos($tipus, 'PNG');
		if($isPNG){
		$extensio = ".png";
		}
	}

?>
	<!--<img src='data:image/jpeg;base64,<?php echo $student->jpegPhoto;?>'>-->
<?php
	$jpeg_filename="/tmp/".$student->irisPersonalUniqueID.$extensio;
	$jpeg_file[$contador]=$student->irisPersonalUniqueID.$extensio;
	$alumne[$contador]['jpegPhoto']="/tmp/".$student->irisPersonalUniqueID.$extensio;
	$outjpeg = fopen($jpeg_filename, "wb");
	fwrite($outjpeg, $student->jpegPhoto);
	fclose ($outjpeg);
	$jpeg_data_size = filesize( $jpeg_filename );

	if( $jpeg_data_size < 6 ) {
		$jpeg_file[$contador]='foto.png';
		$alumne[$contador]['jpegPhoto']='/tmp/foto.png';
		?>
		<!--<img src="<?php echo $alumne[$contador]['jpegPhoto']; ?>" />-->
		<?php
	}

}
$alumne[$contador]['givenName']=$student->givenName;
$alumne[$contador]['sn1']=$student->sn1;
$alumne[$contador]['sn2']=$student->sn2;
$alumne[$contador]['uidnumber']=$student->uidnumber;
$contador++;
}
/* fí Obtenir foto */

?>
<div id="resultat"></div>
<div class="container">
<?php 
	if(isset($grup)) { 
?>
	<center>
		    
	<table class="table table-striped table-bordered table-hover table-condensed" id="selected_group">
	 <thead style="background-color: #d9edf7;">
	  <tr>
	    <td colspan="7" style="text-align: center;"> <h4 class="title"><?php echo $check_attendance_table_title?> | Dia: <input type="text" id="datepicker" class="" value="<?php echo date('d/m/Y');//if(isset($_GET['date'])){ echo $_GET['date']; } else { echo date('d/m/Y'); } ?>"/><span class="dia"></span></h4></td>
	  </tr>
	  <tr>
	     <th>Alumnes:</th>
	     <th class="hora_0"><?php echo $hores[0]; ?></th>
	     <th class="hora_1"><?php echo $hores[1]; ?></th>
	     <th class="hora_2"><?php echo $hores[2]; ?></th>
	     <th class="hora_3"><?php echo $hores[3]; ?></th>
	     <th class="hora_4"><?php echo $hores[4]; ?></th>
	     <th class="hora_5"><?php echo $hores[5]; ?></th>
	  </tr>
	 </thead>
	 <tbody>
	  <!-- Iteration that shows teacher groups for select ed day-->
	  <?php for($fila=0; $fila<$contador; $fila++){ ?>
	   <tr align="center" class="{cycle values='tr0,tr1'}">
	     <td id="nom_<?php echo $fila; ?>"><!--<img src="<?php echo $alumne[$fila]['jpegPhoto']?>"/>-->
	     <?php $nom = $alumne[$fila]['sn1']." ".$alumne[$fila]['sn2'].", ".$alumne[$fila]['givenName']." (".$alumne[$fila]['uidnumber'].")";?>	
	     <?php echo $nom;?></td>
	     <?php for($columna=0; $columna<count($hores);$columna++){
	     	?><td style='width:110px;'>
			     	<select style="width:50px;" id="<?php echo $columna.'-'.$fila; ?>">
			     		<option value="0" selected ></option>
					    <option value="1">F</option>
						<option value="2">FJ</option>
						<option value="3">R</option>
						<option value="4">RJ</option>
						<option value="5">E</option>
					</select>
					<a href="" class="observacions" data-type="text" data-pk="<?php echo $columna.$fila ?>" data-url="/post" data-title="Introdueix una observació per a <?php echo $alumne[$fila]['sn1']." ".$alumne[$fila]['sn2'].", ".$alumne[$fila]['givenName'];?>">Observ.</a>
	     		</td>
	     <?php } ?>

	   </tr>
	  <?php } ?>
	 </tbody>
	</table>

	</center>

<?php
	} else {
?>

<center>
 <!--<?php echo $choose_date_string?> : -->

<script>data = get_date();</script>	
<table class="table table-striped table-bordered table-hover table-condensed" id="groups_by_teacher_an_date">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="3" style="text-align: center;"> <h4 class="title"><?php echo $check_attendance_table_title?> | Dia: <input type="text" id="datepicker" class="" value="<?php if(isset($_POST['data'])){ echo $_POST['data']; } else { echo date('d/m/Y'); } ?>"/></h4></td>
  </tr>
  <tr>
     <th>Column 1</th>
     <th>Column 2</th>
     <th>Column 3</th>
  </tr>
 </thead>
 <tbody>
  <!-- Iteration that shows teacher groups for selected day-->
  <?php foreach ($teacher_groups_current_day as $key => $teacher_group) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">
     <td><?php echo $teacher_group->time_interval;?></td>
     <!-- onclick="myFunction('<?php echo $teacher_group->group_url; ?>')"-->
     <td><a class="<?php echo $teacher_group->group_name;?>" href="<?php echo $teacher_group->group_url;?>" onclick=""; ><?php echo $teacher_group->group_name;?></a></td>
     <td><?php echo $teacher_group->group_code;?></td>
   </tr>
  <?php endforeach; ?>
 </tbody>
</table>

</center>
<?php } //if !(isset($grup)) ?>

</div>
