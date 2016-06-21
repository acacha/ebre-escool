<!-- Date Picker -->
<script>
$(function() {
$( "#data_inicial" ).datepicker({ dateFormat: 'dd-mm-yy' });
$( "#data_final" ).datepicker({ dateFormat: 'dd-mm-yy' });
});
</script>
<!-- Data Table -->
<script>
$(document).ready( function () {

	$('#ranking_initial_date_end_date').dataTable( {
		"bFilter": false,
		"bInfo": true,
		"sDom": 'T<"clear">lfrtip',
		"aLengthMenu": [[10, 25, 50,100,200,500,1000,-1], [10, 25, 50,100,200,500,1000, "All"]],		
		"oTableTools": {
			"sSwfPath": "<?php echo base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf');?>",
				"aButtons": [
					{
						"sExtends": "copy",
						"sButtonText": "<?php echo lang("Copy");?>",
						"mColumns": "visible"
					},
					{
						"sTitle": "<?php echo lang('ranking_incidents_by_date_1').$_POST['data_inicial'].lang('incidents_by_date_2').$_POST['data_final'];?>",
						"sExtends": "csv",
						"sButtonText": "CSV",
						"mColumns": "visible"
					},
					{
						"sTitle": "<?php echo lang('ranking_incidents_by_date_1').$_POST['data_inicial'].lang('incidents_by_date_2').$_POST['data_final'];?>",
						"sExtends": "xls",
						"sButtonText": "XLS",
						"mColumns": "visible"
					},
					{
						"sTitle": "<?php echo lang('ranking_incidents_by_date_1').$_POST['data_inicial'].lang('incidents_by_date_2').$_POST['data_final'];?>",
						"sExtends": "pdf",
						"sPdfOrientation": "portrait",
						"sButtonText": "PDF",
						"mColumns": "visible"
					},
					{
						"sExtends": "print",
						"sButtonText": "<?php echo lang("Print");?>",
						"mColumns": "visible"
					},
				]
},
        "iDisplayLength": 50,
        "aaSorting": [[ 1, "desc" ]],
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
	if(isset($_POST['data_inicial'])){
		$data_ini=strtotime($_POST['data_inicial']);
	}
	if(isset($_POST['data_final'])){
		$data_fi=strtotime($_POST['data_final']);
	}	

?>
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
                                <?php echo lang('reports_educational_center_reports_incidents_by_date_ranking');?>
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
		<form method="post" action="all_attendance_incidents_ranking_report" class="form-horizontal" role="form">
			<table class="table table-bordered" cellspacing="10" cellpadding="5">
				<div class="form-group">
					<tr>
						<td><label for="data_inicial"><?php echo lang('select_initial_date');?></label></td>
						<td><input class="form-control" id="data_inicial" type="text" name="data_inicial" value="<?php if(isset($data_ini)){ echo date('d-m-Y',$data_ini); } else { echo date('d-m-Y'); } ?>"/></td>
					</tr>
				</div>		

				<div class="form-group">
					<tr>
						<td><label for="data_final"><?php echo lang('select_end_date');?></label></td>
						<td><input class="form-control" id="data_final" type="text" name="data_final" value="<?php if(isset($data_fi)){ echo date('d-m-Y',$data_fi); } else { echo date('d-m-Y'); } ?>"/></td>
					</tr>
				</div>

				<div class="form-group">
					<tr>
						<td><label for="top"><?php echo lang('write_max_results');?></label></td>
						<td><input class="form-control" id="top" type="text" name="top" value="<?php echo $top; ?>"/></td>
					</tr>
				</div>

				<div class="form-group">
					<tr>
						<td valign="top"><label for="incident"><?php echo lang('select_type_of_incident');?></label></td>
						<td>
							<input type="checkbox" name="F" value="1" <?php if(isset($_POST['F'])){ ?>checked <?php } ?> > F<br />
							<input type="checkbox" name="FJ" value="2" <?php if(isset($_POST['FJ'])){ ?>checked <?php } ?> > FJ<br />
							<input type="checkbox" name="R" value="3" <?php if(isset($_POST['R'])){ ?>checked <?php } ?> > R<br />
							<input type="checkbox" name="RJ" value="4" <?php if(isset($_POST['RJ'])){ ?>checked <?php } ?> > RJ<br />
							<input type="checkbox" name="E" value="5" <?php if(isset($_POST['E'])){ ?>checked <?php } ?> > E
						</td>
					</tr>	
				</div>
				<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Veure l'informe" class="btn btn-primary"/></td></tr>
			</table>
		</form>

<!-- DATATABLES -->

<?php

if($_POST){  
	//$contador = count($_POST);	
	$i=0;

	$num_incidents = count($incident);

	if($num_incidents>0 and $incident!=false){

	foreach($incident as $falta):

		// Si hi ha resultats entre les dates indicades
		//if( ($falta['data'] >= $data_ini) && ($falta['data'] <= $data_fi)){
			// La primera iteració mostrem el títol i les capçaleres de la taula
			if($i==0){
				echo "<h4><center>".lang('ranking_incidents_by_date_1').$_POST['data_inicial'].lang('incidents_by_date_2').$_POST['data_final']."</center></h4>";

// mostrem la taula
	$posicio=1;
?>

<table class="table table-striped table-bordered table-hover table-condensed" id="ranking_initial_date_end_date">
 <thead style="background-color: #d9edf7;">
  <tr>
	 <th>Posició</th>   	
     <th>Dia</th> 
     <th>Hora</th> 
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
	// Si no hem arribat al max. elements a mostrar continuem mostrant		
	if($posicio <= $top){ ?>
		<tr align="center" class="{cycle values='tr0,tr1'}">
			<td><?php echo $posicio;$posicio++;?></td>
     		<td><?php echo date("d-m-Y",strtotime($falta['day']));?></td>
     		<td><?php echo $falta['hour'];?></td>
	 		<td><?php echo $falta['group'];?></td>     
     		<td><?php echo $falta['study_module'];?></td>
     		<td><?php echo $falta['student'];?></td>
     		<td><?php echo $falta['incident'];?></td>
     		<td><?php echo $falta['teacher'];?></td>
		</tr>
   <?php 
	} // if($posicio <= $top)
//} // Hi ha resultats
endforeach; 
} // fi num_incidents > 0
if($i==0) { echo "No hi ha incidències per a aquest rang de dades."; }
} ?>
 </tbody>
</table>

</div>		
</div>