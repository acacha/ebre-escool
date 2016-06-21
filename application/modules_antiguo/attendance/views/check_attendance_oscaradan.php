<script>

$(function() {

	//toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'popup';     
    
    //make username editable
    $('.obs_').editable();

	//Datatable
	//TODO
	//Obtenir les dades corresponents al dropdown escollit (alumne, hora i incidència) i insertar-los a la BD

	//***********************
	//* TEACHERS DROPDOWN  **
	//***********************

	//Jquery select plugin: http://ivaynberg.github.io/select2/
	$("#teachers").select2(); 

	$('#teachers').on("change", function(e) {	
		selectedValue = $("#teachers").select2("val");
		var pathArray = window.location.pathname.split( '/' );
		var secondLevelLocation = pathArray[1];
		var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/check_attendance";
		//alert(baseURL + "/" + selectedValue);
		window.location.href = baseURL + "/" + selectedValue;

	}); 

	//***********************
	//* Datepicker         **
	//***********************
	$('.input-append.date').datepicker({
    	format: "dd/mm/yyyy",
    	weekStart: 1,
    	todayBtn: true,
    	language: "ca",
    	daysOfWeekDisabled: "0,6",
    	autoclose: true,
    	todayHighlight: true
    });


	//***************************
	//* CHECK ATTENDANCE TABLE **
	//***************************

     $('#groups_by_teacher_an_date').dataTable( {
                "oLanguage": {
                        "sProcessing":   "Processant...",
                        "sLengthMenu":   "Mostra _MENU_ registres",
                        "sZeroRecords":  "No s'han trobat registres.",
                        "sInfo":         "Mostrant de _START_ a _END_ de _TOTAL_ registres",
                        "sInfoEmpty":    "Mostrant de 0 a 0 de 0 registres",
                        "sInfoFiltered": "(filtrat de _MAX_ total registres)",
                        "sInfoPostFix":  "",
                        "sSearch":       "Filtrar:",
                        "sUrl":          "",
                        "oPaginate": {
                                "sFirst":    "Primer",
                                "sPrevious": "Anterior",
                                "sNext":     "Següent",
                                "sLast":     "Últim"
                        }
            },
                "bPaginate": false,
                "bFilter": false,
        "bInfo": false,
        });





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
	 	insert_value(alumne,hora,incidencia);
	 	//read_value(alumne,hora);
	});

    //$('#groups_by_teacher_an_date1').dataTable();
    //console.log("HEY YOU1");
	
	//Datepicker
	var data;
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

	data = $( "#datepicker" ).datepicker($.datepicker.regional['ca']);
	//alert("la data es: "+data.val());
});

</script>

<?php 

	/* Urls per a fer el Insertar, Editar, Llegir i Esborrar */
	$url_insert = ('http://localhost/ebre-escool/index.php/attendance/insert/prova_incidencies');
	$url_read = ('http://localhost/ebre-escool/index.php/attendance/read/prova_incidencies');
	$url_update = ('http://localhost/ebre-escool/index.php/attendance/update/prova_incidencies');
	$url_delete = ('http://localhost/ebre-escool/index.php/attendance/delete/prova_incidencies');
?>

<script type="text/javascript">

function get_student(fila){
	alumne = $("#nom_"+fila).text();
	return alumne;
}

function get_hour(columna){
	hora = $(".hora_"+columna).text();
	return hora;
}

function insert_value(alumne,hora,incidencia){
	jQuery.ajax({
		url:'<?php echo $url_insert;?>',
		data: {
				alumne: alumne,
				incidencia: incidencia,
				hora: hora
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

function read_value(alumne,hora){
	jQuery.ajax({
		url:'<?php echo $url_read;?>',
		data: {
				alumne: alumne,
				hora: hora
			},
			type: 'post',
			dataType: 'json'
		}).done(
			function (data) 
			{
				alert("S'ha llegit " + data + ".");
			}
		).fail(
			function() 
			{
				alert( "No s'ha pogut obtenir cap valor" );
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
		<img src="<?php echo $alumne[$contador]['jpegPhoto']; ?>" />
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
		<img src="<?php echo $alumne[$contador]['jpegPhoto']; ?>" />
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

<div class="container">
<?php 

	if(isset($grup)) { 
		
?>
	<center>
		    
	<table class="table table-striped table-bordered table-hover table-condensed" id="selected_group">
	 <thead style="background-color: #d9edf7;">
	  <tr>
	    <td colspan="7" style="text-align: center;"> <h4 class="title"><?php echo $check_attendance_table_title?> | Dia: <span class="dia"></span></h4></td>
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
	     <td id="nom_<?php echo $fila; ?>"><img src="<?php echo $alumne[$fila]['jpegPhoto']?>"/>
	     <?php $nom = $alumne[$fila]['sn1']." ".$alumne[$fila]['sn2'].", ".$alumne[$fila]['givenName']." (".$alumne[$fila]['uidnumber'].")";?>	
	     <?php echo "<br />".$nom;?></td>
	     <?php for($col=0; $col<count($hores);$col++){
	     	?><td style='width:110px;'>
			     	<select style="width:50px;" id="<?php echo $col.'-'.$fila; ?>">
			     		<option value="0" selected ></option>
					    <option value="1">F</option>
						<option value="2">FJ</option>
						<option value="3">R</option>
						<option value="4">RJ</option>
						<option value="5">E</option>
					</select>
					<a href="" class="obs_" data-placeholder="Escriu una observació" data-type="text" data-pk="1" data-url="/post" data-title="Introdueix una observació per a <?php echo $alumne[$fila]['sn1']." ".$alumne[$fila]['sn2'].", ".$alumne[$fila]['givenName'];?>">Observ.</a>
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
     <td><a href="<?php echo $teacher_group->group_url;?> "><?php echo $teacher_group->group_name;?></a></td>
     <td><?php echo $teacher_group->group_code;?></td>
   </tr>
  <?php endforeach; ?>
 </tbody>
</table>

</center>
<?php } //if !(isset($grup)) ?>

<<<<<<< HEAD
 <div class="timetable" data-days="5" data-hours="15" style="visibility: hidden">
            <ul class="tt-events">
				<li class="tt-event btn-inverse" data-id="10" data-day="0" data-start="4" data-duration="1">
                    DESCANS
                </li>
                <li class="tt-event btn-inverse" data-id="10" data-day="0" data-start="7" data-duration="1">
                    MIGDIA
                </li>
				<li class="tt-event btn-inverse" data-id="10" data-day="0" data-start="11" data-duration="1">
                    DESCANS
                </li>
                <li class="tt-event btn-success" data-id="10" data-day="0" data-start="12" data-duration="1">
                    2 DAM M9<br />
                    20.2<br />
                </li>
                <li class="tt-event btn-warning" data-id="10" data-day="0" data-start="13" data-duration="2">
                    2 ASIX M16<br />
                    20.4<br />
                </li>
                <li class="tt-event btn-inverse" data-id="10" data-day="1" data-start="4" data-duration="1">
                    DESCANS
                </li>
                <li class="tt-event btn-inverse" data-id="10" data-day="1" data-start="7" data-duration="1">
                    MIGDIA
                </li>
                <li class="tt-event btn-inverse" data-id="10" data-day="1" data-start="11" data-duration="1">
                    DESCANS
                </li>
                <li class="tt-event btn-danger" data-id="10" data-day="1" data-start="13" data-duration="2">
                    2 DAM M8<br />
                    20.2<br />
                </li>
                </li>
                <li class="tt-event btn-inverse" data-id="10" data-day="2" data-start="4" data-duration="1">
                    DESCANS
                </li>
                <li class="tt-event btn-inverse" data-id="10" data-day="2" data-start="7" data-duration="1">
                    MIGDIA
                </li>
                <li class="tt-event btn-info" data-id="10" data-day="2" data-start="9" data-duration="2">
                    2 ASIX M7<br />
                    20.4<br />
                </li>
                <li class="tt-event btn-inverse" data-id="10" data-day="2" data-start="11" data-duration="1">
                    DESCANS
                </li>
                <li class="tt-event btn-success" data-id="10" data-day="2" data-start="12" data-duration="2">
                    2 DAM M9<br />
                    20.2<br />
                </li>
                </li>
                <li class="tt-event btn-inverse" data-id="10" data-day="3" data-start="4" data-duration="1">
                    DESCANS
                </li>
                <li class="tt-event btn-inverse" data-id="10" data-day="3" data-start="7" data-duration="1">
                    MIGDIA
                </li>
                <li class="tt-event btn-inverse" data-id="10" data-day="3" data-start="11" data-duration="1">
                    DESCANS
                </li>
                <li class="tt-event btn-info" data-id="10" data-day="3" data-start="12" data-duration="2">
                    2 ASIX M7<br />
                    20.4<br />
                </li>
                <li class="tt-event btn-primary	" data-id="10" data-day="3" data-start="14" data-duration="1">
                    2 ASIX M11<br />
                    20.4<br />
                </li>
                </li>
                <li class="tt-event btn-inverse" data-id="10" data-day="4" data-start="4" data-duration="1">
                    DESCANS
                </li>
                <li class="tt-event btn-inverse" data-id="10" data-day="4" data-start="7" data-duration="1">
                    MIGDIA
                </li>
                <li class="tt-event btn-primary" data-id="10" data-day="4" data-start="8" data-duration="1">
                    2 ASIX M11<br />
                    20.4<br />
                </li>
                <li class="tt-event btn-danger" data-id="10" data-day="4" data-start="9" data-duration="2">
                    2 DAM M8<br />
                    20.2<br />
                </li>
                <li class="tt-event btn-inverse" data-id="10" data-day="4" data-start="11" data-duration="1">
                    DESCANS
                </li>
                <li class="tt-event btn-primary" data-id="10" data-day="4" data-start="12" data-duration="2">
                    2 ASIX M11<br />
                    20.4<br />
                </li>

            </ul>
            <div class="tt-times">
				<div class="tt-time" data-time="0">
                    08<span class="hidden-phone">:00</span></div>
                <div class="tt-time" data-time="0">
                    09<span class="hidden-phone">:00</span></div>
                <div class="tt-time" data-time="1">
                    10<span class="hidden-phone">:00</span></div>
                <div class="tt-time" data-time="2">
                    11</div>
                <div class="tt-time" data-time="3">
                    11:30</div>
                <div class="tt-time" data-time="4">
                    12:30</div>
                <div class="tt-time" data-time="5">
                    13:30</div>
                <div class="tt-time" data-time="6">
                    14:30</div>
                <div class="tt-time" data-time="7">
                    15:30</div>
                <div class="tt-time" data-time="8">
                    16:30</div>
                <div class="tt-time" data-time="9">
                    17:30</div>
                <div class="tt-time" data-time="10">
                    18:30</div>
                <div class="tt-time" data-time="11">
                    19<span class="hidden-phone">:00</span></div>
                <div class="tt-time" data-time="12">
                    20<span class="hidden-phone">:00</span></div>    
                <div class="tt-time" data-time="13">
                    21<span class="hidden-phone">:00</span></div>    
            </div>
            <div class="tt-days">
                <div class="tt-day" data-day="0">
                    Dl.</div>
                <div class="tt-day" data-day="1">
                    Dt.</div>
                <div class="tt-day" data-day="2">
                    Dc.</div>
                <div class="tt-day" data-day="3">
                    Dj.</div>
                <div class="tt-day" data-day="4">
                    Dv.</div>
            </div>
        </div>
=======
>>>>>>> parent of 46147af... Multiple changes: New module curriculum with curriculum maintenances menu before this menus where at managment module
</div>
