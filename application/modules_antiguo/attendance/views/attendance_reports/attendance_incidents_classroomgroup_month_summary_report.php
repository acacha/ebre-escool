<!-- Select2-->
<script>
$(function() { 
	$("#grup").select2(); 
	$("#mes").select2(); 
	$("#any").select2(); 
});
</script>

<!-- Data Table -->
<script>
$(document).ready( function () {

	$('#month_summary').dataTable( {
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
						"sTitle": "<?php echo lang('reports_group_reports_monthly_report').'-'.$_POST['mes'].'-'.$_POST['any'];?>",
						"sExtends": "csv",
						"sButtonText": "CSV"
					},
					{
						"sTitle": "<?php echo lang('reports_group_reports_monthly_report');?>",
						"sExtends": "xls",
						"sButtonText": "XLS"
					},
					{
						"sTitle": "<?php echo lang('reports_group_reports_monthly_report').'-'.$mes[$_POST['mes']].'-'.$_POST['any'];?>",
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
	$alumnes =array();
	$contador = 0;
	if(is_array($all_incidents_in_group)){
		foreach($all_incidents_in_group as $student){
			$alumnes[$contador]['codi']= $student->student_id;
			$alumnes[$contador]['nom']= $student->givenName." ".$student->sn1." ".$student->sn2;
			$alumnes[$contador]['incident_type']= $student->incident_type;
			$alumnes[$contador]['incident_date']= $student->incident_date;		
			$contador++;
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
	</div>
	<div class="page-header position-relative">
		<h1>
			<?php echo lang("attendance").". ".lang("reports_group_reports");?>
			<small>
				<i class="icon-double-angle-right"></i>
				<?php echo lang('reports_group_reports_monthly_report');?>
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
		<form method="post" action="attendance_incidents_classroomgroup_month_summary_report" class="form-horizontal" role="form">
			<table class="table table-bordered" cellspacing="10" cellpadding="5">
				<div class="form-group">
					<tr>
						<td><label for="data_informe">Select Group:</label></td>
						<td>
							<select data-place_holder="TODO" style="width:400px;" id="grup" name="grup" data-size="5" data-live-search="true">
							<?php foreach ($grups as $key => $value) { ?>
								<option value="<?php echo $key ?>" <?php if(isset($_POST['grup']) && $key==$_POST['grup']){ ?> selected <?php }?> > <?php echo $value ?></option>
							<?php } ?>
							</select>
						</td>
					</tr>
				</div>		
				<div class="form-group">
					<tr>
						<td><laber for="hora_informe">Select Month:</label></td>
						<td>
							<select data-place_holder="TODO" style="width:400px;" id="mes" name="mes" data-size="5" data-live-search="true">
							<?php foreach ($mes as $key => $value) { ?>
								<option value="<?php echo $key ?>" <?php if(isset($_POST['mes']) && $key==$_POST['mes']){ ?> selected <?php }?> > <?php echo $value ?></option>
							<?php } ?>
							</select>		
						</td>
					</tr>	
				</div>
				<div class="form-group">
					<tr>
						<td valign="top"><label for="incident">Select Year:</label></td>
						<td>
							<select data-place_holder="TODO" style="width:400px;" id="any" name="any" data-size="5" data-live-search="true">
							<?php foreach ($any as $key => $value) { ?>
								<option value="<?php echo $key; ?>" <?php if(isset($_POST['any']) && $value==$_POST['any']){ ?> selected <?php }?> > <?php echo $value ?></option>
							
							<?php } ?>
							</select>		
						</td>
					</tr>	
				</div>
				<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Veure l'informe" class="btn btn-primary"/></td></tr>
			</table>
		</form>	
		
<!-- Proves datatables -->

<?php 

if($_POST){
	$contador = count($_POST);	
	echo "<h4><center>".lang('reports_group_reports_monthly_report')."</center></h4>";
?>

<table class="table table-striped table-bordered table-hover table-condensed" id="month_summary">
	<thead style="background-color: #d9edf7;">
		<tr>
			<th>Id Alumne</th>
			<th>Alumne</th>
			<th>Data</th>
			<th>Tipus Incident</th>
		</tr>
	</thead>
	<tbody>
	<!-- Iteration that shows teacher groups for selected day-->
   <?php foreach($alumnes as $alumne): ?>
	   <tr align="center" class="{cycle values='tr0,tr1'}">
			<td><?php echo $alumne['codi'];?></td>     
	    	<td><?php echo $alumne['nom'];?></td>
	    	<td><?php echo $alumne['incident_date'];?></td>
			<td><?php echo $alumne['incident_type'];?></td>     
	   </tr>
   <?php endforeach; ?>
	</tbody>
</table>
<?php } ?>

<!-- Fi proves datatable -->		
</div>
</div>