<!-- Data Table -->
<script>
$(document).ready( function () {

	$('#all_teachers_in_group').dataTable( {
		"bFilter": false,
		"bInfo": false,
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
						"sTitle": "<?php echo lang('all_teachers');?>",
						"sExtends": "csv",
						"sButtonText": "CSV"
					},
					{
						"sTitle": "<?php echo lang('all_teachers');?>",
						"sExtends": "xls",
						"sButtonText": "XLS"
					},
					{
						"sTitle": "<?php echo lang('all_teachers');?>",
						"sExtends": "pdf",
						"sPdfOrientation": "landscape",
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

<div style='height:30px;'></div>
	<div style="margin:10px;">
		<?php echo lang('reports_educational_center_reports_grup_mentors'); ?>

	</div>

<div class="container">
	

<div class="row">
 <div class="span12"> </div>
</div>

<?php
	$datasources=array();
	$datasources['mysql']="MySQL";
	$datasources['ldap']="Ldap";
	$selected_datasource="ldap";
	$data_source_additional_parameters="";
?>

<div class="row" style="display:none">
  <div class="span4"> </div>
  <div class="span4" style="padding:5px;">
   <?php echo lang("select_data_source")?> : 
  </div>
</div>  
<?php foreach($all_teachers as $teacher) {
	//echo $teacher."<br />";
}

?>
<table class="table table-striped table-bordered table-hover table-condensed" id="all_teachers_in_group">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="10" style="text-align: center;"> <h4><?php echo lang('all_teachers')?></h4></td>
  </tr>
  <tr>
     <th><font size="-4"><?php echo lang('teacherCode')?></font></th>
     <th><font size="-4"><?php echo lang('givenName')?></font></th>     
     <th><font size="-4"><?php echo lang('sn1')?></font></th>
     <th><font size="-4"><?php echo lang('sn2')?></font></th>
     <th><font size="-4"><?php echo lang('photo')?></font></th>
  </tr>
 </thead>
 <tbody>

 	<?php echo "<pre>"; ?>
 	<?php print_r($all_teachers);?>
 	<?php echo "</pre>"; ?>

  <!-- Iteration that shows teacher groups for selected day-->
  <?php foreach ($all_teachers as $key => $value ) : 
    if(strlen($value)>0) {
 $teacher = explode(" ",$value);?>
   <tr align="center" class="{cycle values='tr0,tr1'}">
     <td><font size="-4"><?php echo $key;?></font></td> 
     <td><font size="-4"><?php echo $teacher[0];?></font></td>
     <td><font size="-4"><?php echo $teacher[1];?></font></td>
     <td><font size="-4"><?php if(array_key_exists(2,$teacher)){ echo $teacher[2];} ?></font></td>
     <td><font size="-4"><?php echo $empleat[1];?></font></td>
   </tr>
   <?php } ?>
  <?php endforeach; ?>
 </tbody>
</table>
</div>
</div>