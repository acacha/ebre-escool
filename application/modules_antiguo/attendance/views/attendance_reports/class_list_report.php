<script>
$(document).ready(function() { 
	
	$("#grup").select2(); 

	$("#select_class_list_academic_period_filter").select2();

    $('#select_class_list_academic_period_filter').on("change", function(e) {  
        var selectedValue = $("#select_class_list_academic_period_filter").select2("val");
        var pathArray = window.location.pathname.split( '/' );
        var secondLevelLocation = pathArray[1];
        var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/attendance_reports/class_list_report";
        //alert(baseURL + "/" + selectedValue);
        window.location.href = baseURL + "/" + selectedValue;

    });
});
</script>

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
                                <?php echo lang('reports_group_reports_class_list');?>
                            </small>
                        </h1>
        </div><!-- /.page-header -->

<!-- TITLE -->
<div style='height:10px;'></div>
	<div style="margin:10px; text-align:center;">
		<h2><?php echo $title; ?></h2>
	</div>  


	<!-- FORM -->    
	<div style="width:60%; margin:0px auto;">
		<form method="post" action="#" class="form-horizontal" role="form">
			<table class="table table-bordered" cellspacing="10" cellpadding="5">
				<div class="form-group ui-widget">
					
					<tr>
						<td><label for="grup" style="width:150px;">Període acadèmic:</label></td>
						<td>
			                <select id="select_class_list_academic_period_filter">
			                <?php foreach ($academic_periods as $academic_period_key => $academic_period_value) : ?>
			                  <?php if ( $selected_academic_period_id) : ?>
			                    <?php if ( $academic_period_key == $selected_academic_period_id) : ?>
			                      <option selected="selected" value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
			                    <?php else: ?>
			                        <option value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
			                    <?php endif; ?>
			                  <?php else: ?>   
			                      <?php if ( $academic_period_value->current == 1) : ?>
			                        <option selected="selected" value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
			                      <?php else: ?>
			                        <option value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
			                      <?php endif; ?> 
			                  <?php endif; ?> 
			                <?php endforeach; ?>
			                </select>    
			              </td>
   					</tr>	
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
						<td colspan="2" style="text-align:center;"><input type="checkbox" name="foto" value="foto" checked> Amb foto</input></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center;"><input type="checkbox" name="all_students" value="all_students" checked> Tots els estudiants (UFs soltes)</input></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center;"><input type="submit" value="Veure l'informe" class="btn btn-primary"/></td>
					</tr>
			</table>
		</form>
	</div>	
</div>	