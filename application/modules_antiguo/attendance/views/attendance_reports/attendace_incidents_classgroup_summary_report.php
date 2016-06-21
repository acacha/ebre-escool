<!-- Date Picker -->
<script>
$(function() {
$( "#data_inicial" ).datepicker({ dateFormat: 'dd-mm-yy' });
$( "#data_final" ).datepicker({ dateFormat: 'dd-mm-yy' });
});
</script>
<!--Select2 -->
<script>
$(function() { 
	$("#grup").select2(); 
});
</script>

<!-- Data Table -->
<script>
$(document).ready( function () {

	$('#groups_fault_reports').dataTable( {
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
						"sTitle": "<?php echo lang('group_incidents_summary').$selected_group.lang('group_incidents_summary_between').$_POST['data_inici'].lang('incidents_by_date_2').$_POST['data_fi'];?>",
						"sExtends": "csv",
						"sButtonText": "CSV"
					},
					{
						"sTitle": "<?php echo lang('group_incidents_summary').$selected_group.lang('group_incidents_summary_between').$_POST['data_inici'].lang('incidents_by_date_2').$_POST['data_fi'];?>",
						"sExtends": "xls",
						"sButtonText": "XLS"
					},
					{
						"sTitle": "<?php echo lang('group_incidents_summary').$selected_group.lang('group_incidents_summary_between').$_POST['data_inici'].lang('incidents_by_date_2').$_POST['data_fi'];?>",
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

<?php 

$students = array();
$contador = 0;
/*
if($_POST){

	$ini = strtotime($_POST['data_inici']);
	$fi = strtotime($_POST['data_fi']);

} else {

	$ini = strtotime(date("d-m-Y"));
	$fi = strtotime(date("d-m-Y"));
}
*/
/*
	if(is_array($all_incidents_in_group)){	
				echo "<pre>";
				print_r($all_incidents_in_group);
				echo "</pre>";
	}
*/
	if(is_array($all_incidents_in_group)){	
		foreach($all_incidents_in_group as $student_incident_in_group){

			$students[$student_incident_in_group->student_id]['fullName'] = $student_incident_in_group->givenName." ".$student_incident_in_group->sn1." ".$student_incident_in_group->sn2;
			
			if(!isset($students[$student_incident_in_group->student_id]['F'])){
				$students[$student_incident_in_group->student_id]['F'] = 0;
			}
			if(!isset($students[$student_incident_in_group->student_id]['FJ'])){
				$students[$student_incident_in_group->student_id]['FJ'] = 0;
			}
			if(!isset($students[$student_incident_in_group->student_id]['R'])){
				$students[$student_incident_in_group->student_id]['R'] = 0;
			}
			if(!isset($students[$student_incident_in_group->student_id]['RJ'])){
				$students[$student_incident_in_group->student_id]['RJ'] = 0;
			}
			if(!isset($students[$student_incident_in_group->student_id]['E'])){
				$students[$student_incident_in_group->student_id]['E'] = 0;
			}										

			if($student_incident_in_group->incident_type == 1){
				$students[$student_incident_in_group->student_id]['F'] = $students[$student_incident_in_group->student_id]['F']+1;
			} else if($student_incident_in_group->incident_type == 2){
				$students[$student_incident_in_group->student_id]['FJ'] = $students[$student_incident_in_group->student_id]['FJ']+1;
			} else if($student_incident_in_group->incident_type == 3){
				$students[$student_incident_in_group->student_id]['R'] = $students[$student_incident_in_group->student_id]['R']+1;
			} else if($student_incident_in_group->incident_type == 4){
				$students[$student_incident_in_group->student_id]['RJ'] = $students[$student_incident_in_group->student_id]['RJ']+1;
			} else if($student_incident_in_group->incident_type == 5){
				$students[$student_incident_in_group->student_id]['E'] = $students[$student_incident_in_group->student_id]['E']+1;
			}									

			$students[$student_incident_in_group->student_id]['incident_type'] = $student_incident_in_group->incident_type;
			$students[$student_incident_in_group->student_id]['incident_date'] = $student_incident_in_group->incident_date;

			$suma = $students[$student_incident_in_group->student_id]['F']+$students[$student_incident_in_group->student_id]['FJ']+$students[$student_incident_in_group->student_id]['R']+$students[$student_incident_in_group->student_id]['RJ']+$students[$student_incident_in_group->student_id]['E'];		
			$students[$student_incident_in_group->student_id]['Total']=$suma;				
			$contador++;
/*
			$suma = 0;
			$student[$contador]['fullName'] = $student_in_group->givenName." ".$student_in_group->sn1." ".$student_in_group->sn2;
// Simular Faltes Assistència
			
		
			$aleatori = rand(0,3);
			if($aleatori!=0){
				$fecha_rand=rand($ini,$fi);
				$student[$contador]['F']=$aleatori." ".date($fecha_rand);
			} else {
				$student[$contador]['F']=$aleatori;
			}
			$aleatori = rand(0,3);
			if($aleatori!=0){
				$fecha_rand=rand($ini,$fi);
				$student[$contador]['FJ']=$aleatori." ".date($fecha_rand);
			} else {
				$student[$contador]['FJ']=$aleatori;
			}
			$aleatori = rand(0,3);
			if($aleatori!=0){
				$fecha_rand=rand($ini,$fi);
				$student[$contador]['R']=$aleatori." ".date($fecha_rand);
			} else {
				$student[$contador]['R']=$aleatori;
			}
			$aleatori = rand(0,3);
			if($aleatori!=0){
				$fecha_rand=rand($ini,$fi);
				$student[$contador]['RJ']=$aleatori." ".date($fecha_rand);
			} else {
				$student[$contador]['RJ']=$aleatori;
			}
			$aleatori = rand(0,3);
			if($aleatori!=0){
				$fecha_rand=rand($ini,$fi);
				$student[$contador]['E']=$aleatori." ".date($fecha_rand);
			} else {
				$student[$contador]['E']=$aleatori;
			}
// Fi Simular Faltes Assistència

			$suma = $student[$contador]['F']+$student[$contador]['FJ']+$student[$contador]['R']+$student[$contador]['RJ']+$student[$contador]['E'];		
			$student[$contador]['Total']=$suma;										
			$contador++;
		*/	
		}
	}


?>
<div class="main-content" >
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
</div><!-- /.breadcrumbs -->
	<div class="page-header position-relative">
		<h1>
			<?php echo lang("attendance").". ".lang("reports_group_reports");?>
			<small>
				<i class="icon-double-angle-right"></i>
				<?php echo lang('reports_group_reports_incidents_by_date');?>
			</small>
		</h1>
	</div><!-- /.page-header -->

<!-- TITLE -->
<div style='height:10px;'></div>
	<div style="margin:10px; text-align:center;">
		<h2><?php echo $title; ?></h2>
	</div>  


	<!-- FORM -->    
	<div style="width:50%; margin:0px auto;">
		<form method="post" action="#" class="form-horizontal" role="form">
			<table class="table table-bordered" cellspacing="10" cellpadding="5">
				<div class="form-group">
					<tr>
						<td><label for="grup" style="width:150px;">Selecciona el grup:</label></td>
						<td><select data-place_holder="TODO" style="width:580px;" id="grup" name="grup" data-size="5" data-live-search="true">
							<?php foreach ($grups as $key => $value) { ?>
								<option value="<?php echo $key ?>" ><?php echo $value ?></option>
							<?php } ?>
							</select>	
						</td>
					</tr>
				</div>

				<div class="form-group">
					<tr>
						<td><label for="data_inicial">Write the initial Date:</label></td>
						<td><input class="form-control" id="data_inicial" type="text" name="data_inici" value="<?php echo date("d-m-Y",$ini)?>"/></td>
					</tr>
				</div>		

				<div class="form-group">
					<tr>
						<td><label for="data_final">Write the end Date:</label></td>
						<td><input class="form-control" id="data_final" type="text" name="data_fi" value="<?php echo date("d-m-Y",$fi)?>"/></td>
					</tr>
				</div>

				<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Veure l'informe" class="btn btn-primary"/></td></tr>
			</table>
		</form>

<?php if(is_array($all_incidents_in_group)){ ?>
<!-- Proves datatables -->
<?php if($_POST){ ?>

<table class="table table-striped table-bordered table-hover table-condensed" id="groups_fault_reports">
 <thead style="background-color: #d9edf7;">
  <tr>
     <th>Alumne</th>   	
     <th>F</th> 
     <th>FJ</th>
     <th>R</th>
     <th>RJ</th>
     <th>E</th>
     <th>Total</th>
  </tr>
 </thead>
 <tbody>
  <!-- Iteration that shows teacher groups for selected day-->
<?php 
	//for($i=0; $i<$count_alumnes; $i++){
foreach($students as $student){
?>

   <tr align="center" class="{cycle values='tr0,tr1'}">
     <td><?php echo $student['fullName'];?></td>   	
     <td><?php if($student['F']==0){ echo $student['F']; } else { $faltes = explode(" ",$student['F']); echo $faltes[0]; }?></td>
	 <td><?php if($student['FJ']==0){ echo $student['FJ']; } else { $faltes = explode(" ",$student['FJ']); echo $faltes[0]; }?></td>
     <td><?php if($student['R']==0){ echo $student['R']; } else { $faltes = explode(" ",$student['R']); echo $faltes[0]; }?></td>
     <td><?php if($student['RJ']==0){ echo $student['RJ']; } else { $faltes = explode(" ",$student['RJ']); echo $faltes[0]; }?></td>
     <td><?php if($student['E']==0){ echo $student['E']; } else { $faltes = explode(" ",$student['E']); echo $faltes[0]; }?></td>
     <td><?php echo $student['Total'];?></td>
   </tr>
<?php
	}
	//}
?>
 </tbody>
</table>
<?php } ?> <!-- Fi proves datatable -->
<?php } else echo "No hi ha resultats per al grup i data seleccionats." ?> <!-- Fi is_array() -->
	</div>		
</div>	
</div>