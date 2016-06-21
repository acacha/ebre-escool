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

<div class="page-content">

    <div class="page-header position-relative">
                    <h1>
                        <?php echo "Informes assistència";?>
                        <small>
                            <i class="icon-double-angle-right"></i>
                            <?php echo "Totes les incidències";?>
                        </small>
                    </h1>
    </div><!-- /.page-header -->

    <div class="space-10"></div>

    <div class="row-fluid">
	 <!-- FILTER FORM -->    
	 <div style="width:60%; margin:0px auto;">
		

		<form method="post" action="" class="form-horizontal" role="form">
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
   					<!--
					<tr>
						<td><label for="grup">Selecciona el grup:</label></td>
						<td><select data-place_holder="TODO" style="width:580px;" id="grup" name="grup" data-size="5" data-live-search="true">
							<?php foreach ($grups as $key => $value) { ?>
								<option value="<?php echo $key ?>" ><?php echo $value ?></option>
							<?php } ?>
							</select>	
						</td>
					</tr>	
					-->
				</div>
			</table>
		 </form>
		</div>




		<table class="table table-striped table-bordered table-hover table-condensed" id="all_incidents">

			 <thead style="background-color: #d9edf7;">
			  <tr>
			    <td colspan="13" style="text-align: center;"> <h4>
			        Totes les incidències
			      </h4></td>
			  </tr>
			  <tr>      
			  	 <th><?php echo lang('attendance_reports_all_incidents_id')?></th>
			     <th><?php echo lang('attendance_reports_all_incidents_date')?></th>
           <th><?php echo lang('attendance_reports_all_incidents_student')?></th>
			     <th><?php echo lang('attendance_reports_all_incidents_day')?></th>
			     <th><?php echo lang('attendance_reports_all_incidents_time_slot')?></th>
			     <th><?php echo lang('attendance_reports_all_incidents_incident_type')?></th>
			     <th><?php echo lang('attendance_reports_all_incidents_study_submodule')?></th>
			     <th><?php echo lang('attendance_reports_all_incidents_study_module')?></th>
			     <th><?php echo lang('attendance_reports_all_incidents_classroom_group')?></th>
			     <th><?php echo lang('attendance_reports_all_incidents_entryDate')?></th>
			     <th><?php echo lang('attendance_reports_all_incidents_last_update')?></th>
			     <th><?php echo lang('attendance_reports_all_incidents_creationUserId')?></th>
			     <th><?php echo lang('attendance_reports_all_incidents_lastupdateUserId')?></th>
			  </tr>
			 </thead>        
		</table>	 
    <br/><br/><br/><br/><br/>
  </div>	
</div>


<script>
$(function() { 
  //$("#grup").select2(); 

  $("#select_class_list_academic_period_filter").select2();

    $('#select_class_list_academic_period_filter').on("change", function(e) {  
        var selectedValue = $("#select_class_list_academic_period_filter").select2("val");
        var pathArray = window.location.pathname.split( '/' );
        var secondLevelLocation = pathArray[1];
        var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/attendance_reports/attendance_reports_all_incidents";
        //alert(baseURL + "/" + selectedValue);
        window.location.href = baseURL + "/" + selectedValue;

    });


    $('#all_incidents').dataTable( {
              "bDestroy": true,
                      "sServerMethod": "POST",
                      "sAjaxSource": "<?php echo base_url('index.php/attendance/attendance_reports/get_all_incidents');?>", 
                      "fnServerParams": function ( aoData ) {
                          aoData.push( { "name": "classroom_group_id", "value": "Prova!" });
                      },
                      "fnDrawCallback": function () {
                          //console.debug("fnDrawCallback");
                      },
                      "aoColumns": [
                        { "mData": function(data, type, full) {
                                    return data.id;
                                  }},
                        { "mData": function(data, type, full) {
                                    return data.date;
                                  }},
                        { "mData": function(data, type, full) {
                                    url = "<?php echo base_url('/index.php/persons/index/read/')?>/" +  data.student_id;
                                    student_fullname = data.person_sn1 + " " + data.person_sn2 + ", " + data.person_givenName;
                                    return '<a href="' + url + '" title="' + student_fullname + '">' + student_fullname + ' (' + data.student_id + ')</a>';
                                  }},                    
                        { "mData": function(data, type, full) {

                                  switch (data.day) {
                                      case "1":
                                          return "1-Dilluns";
                                      case "2":
                                          return "2-Dimarts";
                                      case "3":
                                          return "3-Dimecres";
                                      case "4":
                                          return "4-Dijous";
                                      case "5":
                                          return "5-Divendres";
                                     default:
                                          return "error";
                                  } 
                                    return ;
                                  }},
                        { "mData": function(data, type, full) {
                                    return data.time_slot_start_time + "-" + data.time_slot_end_time + "(" + data.time_slot_id + ")";
                                  }},
                        { "mData": function(data, type, full) {
                                    return '<span title="' + data.incident_type_name + '">' + data.type + "-" + data.incident_type_shortName + "</span>";
                                  }},          
                        { "mData": function(data, type, full) {
                                    url = "<?php echo base_url('/index.php/curriculum/study_submodules/read/')?>/" +  data.study_submodule_id;
                                    return '<a href="' + url + '" title="' + data.study_submodules_name + '">' + data.study_submodules_shortname + ' (' + data.study_submodule_id + ')</a>';
                                  }},          
                        { "mData": function(data, type, full) {
                                    url = "<?php echo base_url('/index.php/curriculum/study_module/read/')?>/" +  data.study_module_id;
                                    return '<a href="' + url + '" title="' + data.study_module_name + '">' + data.study_module_shortname + ' (' + data.study_module_id + ')</a>';
                                  }},  
                        { "mData": function(data, type, full) {
                                    url = "<?php echo base_url('/index.php/curriculum/classroom_group/read/')?>/" +  data.enrollment_group_id;
                                    return '<a href="' + url + '" title="' + data.classroom_group_name + '">' + data.classroom_group_code + ' (' + data.enrollment_group_id + ')</a>';
                                  }}, 
                        { "mData": function(data, type, full) {
                                    return data.entryDate;
                                  }},
                        { "mData": function(data, type, full) {
                                    return data.last_update;
                                  }},
                        { "mData": function(data, type, full) {
                                    url = "<?php echo base_url('/index.php/users/index/read/')?>/" +  data.creationUserId;
                                    return '<a href="' + url + '" title="' + data.creationUserTitle + '">' + data.creationUser + ' (' + data.creationUserId + ')</a>';
                                  }},
                        { "mData": function(data, type, full) {
                                    url = "<?php echo base_url('/index.php/users/index/read/')?>/" +  data.lastupdateUserId;
                                    return '<a href="' + url + '" title="' + data.lastupdateUserTitle + '">' + data.lastupdateUser + ' (' + data.lastupdateUserId + ')</a>';
                                  }},
                      ],
                  "aLengthMenu": [[10, 25, 50,100,200,500,1000,5000,-1], [10, 25, 50,100,200,500,1000,5000,"Totes"]],
                              "oTableTools": {
                  "sSwfPath": "<?php echo base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf');?>",
                              "aButtons": [
                                      {
                                              "sExtends": "copy",
                                              "sButtonText": "<?php echo lang("Copy");?>"
                                      },
                                      {
                                              "sExtends": "csv",
                                              "sButtonText": "CSV"
                                      },
                                      {
                                              "sExtends": "xls",
                                              "sButtonText": "XLS"
                                      },
                                      {
                                              "sExtends": "pdf",
                                              "sPdfOrientation": "landscape",
                                              "sPdfMessage": "TODO",
                                              "sTitle": "TODO",
                                              "sButtonText": "PDF"
                                      },
                                      {
                                              "sExtends": "print",
                                              "sButtonText": "<?php echo lang("Print");?>"
                                      },
                              ]

              },
                "iDisplayLength": 100,
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

});
</script>