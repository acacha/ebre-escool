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
                    <?php echo lang("curriculum");?>
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Departaments
                    </small>
                </h1>
</div><!-- /.page-header -->

<div style='height:10px;'></div>
	<div style="margin:10px;">
   		



      <script>
      $(function(){

              $('#all_groups').dataTable( {
                      "aLengthMenu": [[10, 25, 50,100,200,-1], [10, 25, 50,100,200, "<?php echo lang('All');?>"]],
                      "sDom": 'TRC<"clear">lfrtip',
                      "oColVis": {
                          "buttonText": "Mostrar / amagar columnes"
                      },
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
                                              "sPdfMessage": "<?php echo lang("all_groups");?>",
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

          $( "#academic_period_picker" ).change(function() {
              //academic_period_picker
              academic_period_id = $("#academic_period_picker").val();
              console.log("academic_period_id: " + academic_period_id);
//              value = $("#show_compact_timetable").bootstrapSwitch('state');

              var pathArray = window.location.pathname.split( '/' );
              var secondLevelLocation = pathArray[1];
              var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/managment/curriculum_reports_departments";

              window.location.href = baseURL + "/" + academic_period_id;
          });

});


</script>

<div class="container">

    <div class="row-fluid">
        <div class="span3"></div>
        <div class="span6">
            <div class="widget-box collapsed">
                <div class="widget-header">
                    <h5>Filtres</h5>

                    <div class="widget-toolbar">


                        <a href="#" data-action="collapse">
                            <i class="icon-chevron-up"></i>
                        </a>

                        <a href="#" data-action="close">
                            <i class="icon-remove"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main">

                        <div class="row-fluid">

                            <div class="span4">Període acadèmic: </div>

                            <div class="span4">

                                <select id="academic_period_picker">
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

                            </div>

                            <div class="span4"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="span3"></div>

    </div>

<table class="table table-striped table-bordered table-hover table-condensed" id="all_groups">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="9" style="text-align: center;"> <h4>
      <a href="<?php echo base_url('/index.php/curriculum/departments') ;?>">
        <?php echo $departments_table_title . " ( " . $academic_periods[$selected_academic_period_id]->name . " )"?>
      </a>
      </h4></td>
  </tr>
  <tr> 
     <th><?php echo lang('department_id')?></th>
     <th><?php echo lang('department_shortname')?></th>
     <th><?php echo lang('department_name')?></th>
     <th><?php echo lang('department_head')?></th>
     <th><?php echo lang('department_organizational_unit')?></th>
     <th><?php echo lang('department_location')?></th>
     <th><?php echo lang('department_parentDepartment')?></th>
     <th><?php echo lang('department_numberOfTeachers')?></th>
     <th><?php echo lang('department_numberOfStudies')?></th>
  </tr>
 </thead>
 <tbody> 
  <?php $this->session->set_flashdata('studies_by_department', $studies_by_department);?>
  <?php $this->session->set_flashdata('teachers_by_department', $teachers_by_department);?>

  <!-- Iteration that shows departments-->
  <?php if (is_array($all_departments) or ($all_departments instanceof Traversable)): ?>
   <?php foreach ($all_departments as $department_key => $department) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">   
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/departments/read/' . $department->id ) ;?>">
          <?php echo $department->id;?>
      </a> 
     </td>
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/departments/edit/' . $department->id ) ;?>">
          <?php echo $department->shortname;?>
      </a> 
     </td>
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/departments/edit/' . $department->id ) ;?>">
          <?php echo $department->name;?>
      </a> 
     </td>
     <td>
      ( <a href="<?php echo base_url('/index.php/teachers/teachers/index/edit/' . $department->head_id ) ;?>">
          <?php echo $department->head_code ;?>
      </a> ) <a href="<?php echo base_url('/index.php/persons/persons/index/edit/' . $department->head_personid ) ;?>">
          <?php echo $department->head_fullname; ;?>
      </a>
     </td>
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/organizational_unit/edit/' . $department->organizational_unit_id ) ;?>">
          <?php echo $department->organizational_unit; ;?>
      </a>
     </td>
     <td>
      <a href="<?php echo base_url('/index.php/location/location/index/edit/' . $department->location_id ) ;?>">
          <?php echo $department->location;?>
      </a>
     </td>
     <td><?php echo $department->parentDepartment;?></td>
     <td>
      <a href="<?php echo base_url('/index.php/teachers/teachers/index/' . $department->id ) ;?>">
          <?php echo $department->numberOfTeachers;?>
      </a>
      
     </td>
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/studies/' . $department->id ) ;?>">
          <?php echo $department->numberOfStudies;?>
      </a>
      
     </td>
   </tr>
  <?php endforeach; ?>
  <?php endif;?>
 </tbody>
</table> 

</div>

<div class="space-30"></div>

	</div>	
</div>