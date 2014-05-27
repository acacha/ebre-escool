<!-- Date Picker -->
<script>
$(function() {

	$( "#data_informe" ).datepicker({ dateFormat: 'dd-mm-yy' });

});

</script>
 <script>
$(function() { 
	$("#hora_informe").select2(); 
});
</script>

<!-- Data Table -->
<script>
$(document).ready( function () {

	$('#date_d_hour_h').dataTable( {
		"bFilter": false,
		"bInfo": true,
		"sDom": 'T<"clear">lfrtip',
		"aLengthMenu": [[10, 25, 50,100,200,500,1000,-1], [10, 25, 50,100,200,500,1000, "All"]],		
		"oTableTools": {
			"sSwfPath": "<?php echo base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf');?>",
				"aButtons": [
					{
						"sExtends": "copy",
						"sButtonText": "<?php echo lang("Copy");?>"
					},
					{
						"sTitle": "<?php echo lang('incidents_by_day_and_hour_1').$_POST['data'].lang('incidents_by_day_and_hour_2').$incident[0]['start_time']."-".$incident[0]['end_time'];?>",
						"sExtends": "csv",
						"sButtonText": "CSV"
					},
					{
						"sTitle": "<?php echo lang('incidents_by_day_and_hour_1').$_POST['data'].lang('incidents_by_day_and_hour_2').$incident[0]['start_time']."-".$incident[0]['end_time'];?>",
						"sExtends": "xls",
						"sButtonText": "XLS"
					},
					{
						"sTitle": "<?php echo lang('incidents_by_day_and_hour_1').$_POST['data'].lang('incidents_by_day_and_hour_2').$incident[0]['start_time']."-".$incident[0]['end_time'];?>",
						"sExtends": "pdf",
						"sPdfOrientation": "portrait",
						"sButtonText": "PDF"
					},
					{
						"sExtends": "print",
						"sButtonText": "<?php echo lang("Print");?>"
					},
				]
},
        "iDisplayLength": 50,
        "aaSorting": [[ 5, "asc" ],[ 6, "asc" ],[ 7, "asc" ]],
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
	    }
		
	});
} );

</script>


<!-- ComboBox -->
 <style>
.custom-combobox {
position: relative;
display: inline-block;
}
.custom-combobox-toggle {
position: absolute;
top: 0;
bottom: 0;
margin-left: -1px;
padding: 0;
/* support: IE7 */
*height: 1.7em;
*top: 0.1em;
}
.custom-combobox-input {
margin: 0;
padding: 0.3em;
}
</style>

<div class="main-content" style="padding-bottom:100px;">

<div id="breadcrumbs" class="breadcrumbs">
 <script type="text/javascript">
  try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
 </script>
 <ul class="breadcrumb">
  <li>
   <i class="icon-home home-icon"></i>
   <a href="#">Home</a>
   <span class="divider">
    <i class="icon-angle-right arrow-icon"></i>
   </span>
  </li>
  <li class="active"><?php echo lang('reports');?></li>
 </ul>
</div>



        <div class="page-header position-relative">
                        <h1>
                            <?php echo lang("attendance").". ".lang("reports_educational_center_reports");?>
                            <small>
                                <i class="icon-double-angle-right"></i>
                                <?php echo lang('reports_educational_center_reports_incidents_by_day_and_hour');?>
                            </small>
                        </h1>
        </div><!-- /.page-header -->

<!-- TITLE -->
<div style='height:10px;'></div>
	<div style="margin:10px; text-align:center;">
		<h2><?php echo $title; ?></h2>
	</div>    

	<!-- FORM -->    
	<div style="width:75%; margin:20px auto;">
		<form method="post" action="all_attendance_incidents_at_day_and_hour_report" class="form-horizontal" role="form">
			<table class="table table-bordered" cellspacing="10" cellpadding="5">
				<div class="form-group">
					<tr>
						<td><label for="data_informe"><?php echo lang('select_date');?></label></td>
						<td><input class="form-control" id="data_informe" type="text" name="data" value="<?php if(isset($_POST['data'])){ echo $_POST['data']; } else { echo date('d-m-Y'); } ?>"/></td>
					</tr>
				</div>		
				<div class="form-group">
					<tr>
						<td><label for="hora_informe"><?php echo lang('select_time');?></label></td>
						<td><select  id="hora_informe" name="hora" style="width:150px;">
							<?php foreach ($time_slots as $hora) { ?>
							<?php $rang=$hora['time_slot_start_time']."-".$hora['time_slot_end_time']; ?>
								<option value="<?php echo $hora['time_slot_id']; ?>" <?php if(isset($_POST['hora']) && $hora['time_slot_id'] == $_POST['hora']){ ?> selected <?php } else {if($hora['time_slot_id']==1){?> selected <?php }} ?> ><?php echo $rang; ?></option>
							<?php } ?>
							</select>		
						</td>
					</tr>	
				</div>
				<div class="form-group">
					<tr>
						<td valign="top"><label for="incident"><?php echo lang('select_type_of_incident');?></label></td>
						<td>
							<input type="checkbox" name="F" value="1" <?php if(isset($_POST['F'])){ ?>checked <?php } ?>> F <br />
							<input type="checkbox" name="FJ" value="2" <?php if(isset($_POST['FJ'])){ ?>checked <?php } ?>> FJ <br />
							<input type="checkbox" name="R" value="3" <?php if(isset($_POST['R'])){ ?>checked <?php } ?>> R <br />
							<input type="checkbox" name="RJ" value="4" <?php if(isset($_POST['RJ'])){ ?>checked <?php } ?>> RJ <br />
							<input type="checkbox" name="E" value="5" <?php if(isset($_POST['E'])){ ?>checked <?php } ?>> E 
						</td>
					</tr>	
				</div>
				<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Veure l'informe" class="btn btn-primary"/></td></tr>
			</table>
		</form>

<!-- DATATABLE -->
<?php 

if($_POST){

	$contador = count($_POST);	
	$i=0;


	$num_incidents = count($incident);

	if($num_incidents>0 and $incident!=false){

	$rang_horari = $incident[0]['start_time']."-".$incident[0]['end_time'];

	foreach($incident as $falta):
		// Si la data, hora i tipus d'incidència sel·leccionades coincideixen amb alguna de les incidències
		//if($_POST['data']==$falta['day'] && $_POST['hora']==$falta['hour'] && array_key_exists($falta['incident'], $_POST)){
			// La primera iteració mostrem el títol i les capçaleres de la taula
			if($i==0){
				echo "<h4><center>".lang('incidents_by_day_and_hour_1').$_POST['data'].
					lang('incidents_by_day_and_hour_2').$rang_horari."</center></h4>";

// Mostrem la taula amb els resultats
?>

<table class="table table-striped table-bordered table-hover table-condensed" id="date_d_hour_h">
 <thead style="background-color: #d9edf7;">
  <tr>
     <th>Grup</th>
     <th>Crèdit</th>
     <th>Alumne</th>
     <th>Incidència</th>
     <th>Professor</th>
  </tr>
 </thead>
 <tbody>
  <?php 
	$i++;
			} // if($i==0)
   ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">
	 <td><?php echo $falta['group'];?></td>   
	 <td><?php echo $falta['study_module'];?></td>  
     <td><?php echo $falta['student'];?></td>
     <td><?php echo $falta['incident'];?></td>
     <td><?php echo $falta['teacher'];?></td>
   </tr>
  <?php 
  	// mirem si hem arribat al últim element
  	if($i==$contador){
  ?>
 </tbody>
</table>
<?php $i++; 
	} // últim element
//} // Hi ha incidències;
	endforeach;
} // fi num_incidents > 0
if($i==0) { echo "No hi ha incidències per a aquesta data i hora."; }
} ?>

</div>
</div>