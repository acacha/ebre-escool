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
                        Grups de classe
                    </small>
                </h1>
</div><!-- /.page-header -->

<div style='height:10px;'></div>
	<div style="margin:10px;">

      <div class="alert alert-block alert-success">
        <button type="button" class="close" data-dismiss="alert">
          <i class="icon-remove"></i>
        </button>

        <i class="icon-ok green"></i>
         També us pot interessar l'<strong class="green"><a href="<?php echo base_url('/index.php/teachers/tutors_report');?>">
          informe de tutors
        </strong></a> que mostra informació completa sobre tots els grups de classe del centre
      </div>


      <script>

      $(function(){

        //Jquery select plugin: https://ivaynberg.github.io/select2/
        $("#select_classroom_group_academic_period_filter").select2();

        $('#select_classroom_group_academic_period_filter').on("change", function(e) {
            var selectedValue = $("#select_classroom_group_academic_period_filter").select2("val");
            var pathArray = window.location.pathname.split( '/' );
            var secondLevelLocation = pathArray[1];
            var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/managment/curriculum_reports_classgroup";
            //alert(baseURL + "/" + selectedValue);
            window.location.href = baseURL + "/" + selectedValue;

        });

          var all_groups_table = $('#all_groups').DataTable( {
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

        $("#select_classroom_group_study_code_filter").on( 'change', function () {
            var val = $(this).val();

            all_groups_table.column(5).search( val ? '^'+$(this).val()+'$' : val, true, false ).draw();
        } );

        all_groups_table.column(5).data().unique().sort().each( function ( d, j ) {
                $("#select_classroom_group_study_code_filter").append( '<option value="'+d+'">'+d+'</option>' )
        } );

        $("#select_classroom_group_shift").on( 'change', function () {
            var val = $(this).val();

            all_groups_table.column(7).search( val ? '^'+$(this).val()+'$' : val, true, false ).draw();
        } );

        all_groups_table.column(7).data().unique().sort().each( function ( d, j ) {
                $("#select_classroom_group_shift").append( '<option value="'+d+'">'+d+'</option>' )
        } );





});
</script>

<div class="container">

<table class="table table-striped table-bordered table-hover table-condensed" id="all_groups_filter">
  <thead style="background-color: #d9edf7;">
    <tr>
      <td colspan="13" style="text-align: center;"> <h4>Filtres per columnes
        </h4></td>
    </tr>
    <tr>
       <td><?php echo lang('classroom_group_academic_period')?>:
          <select id="select_classroom_group_academic_period_filter">
          <?php foreach ($academic_periods as $academic_period_key => $academic_period_value) : ?>

            selected_academic_period_id

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
       <td><?php echo lang('classroom_group_study_code')?>: <select id="select_classroom_group_study_code_filter"><option value=""></option></select></td>
       <td><?php echo lang('classroom_group_shift')?>: <select id="select_classroom_group_shift"><option value=""></option></select></td>
    </tr>
  </thead>
</table>

<table class="table table-striped table-bordered table-hover table-condensed" id="all_groups">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="13" style="text-align: center;"> <h4>
      <a href="<?php echo base_url('/index.php/curriculum/classroom_groups') ;?>">
        <?php echo $classgroup_table_title?>
      </a>
      </h4></td>
  </tr>

  <tr>
     <th><?php echo lang('classroom_group_id')?></th>
     <th><?php echo lang('classroom_group_code')?></th>
     <th><?php echo lang('classroom_group_name')?></th>
     <th><?php echo lang('classroom_group_mentor')?></th>
     <th><?php echo lang('classroom_group_course')?></th>
     <th><?php echo lang('classroom_group_study_code')?></th>
     <th><?php echo lang('classroom_group_study')?></th>
     <th><?php echo lang('classroom_group_shift')?></th>
     <th><?php echo lang('classroom_group_location')?></th>
     <th><?php echo lang('classroom_group_num_students')?></th>
     <th><?php echo lang('classroom_group_num_modules')?></th>
     <th><?php echo lang('classroom_group_num_submodules')?></th>
     <th><?php echo lang('classroom_group_description')?></th>
  </tr>
 </thead>

 <tfoot>
    <tr>
     <th><?php echo lang('classroom_group_id')?></th>
     <th><?php echo lang('classroom_group_code')?></th>
     <th><?php echo lang('classroom_group_name')?></th>
     <th><?php echo lang('classroom_group_mentor')?></th>
     <th><?php echo lang('classroom_group_course')?></th>
     <th><?php echo lang('classroom_group_study_code')?></th>
     <th><?php echo lang('classroom_group_study')?></th>
     <th><?php echo lang('classroom_group_shift')?></th>
     <th><?php echo lang('classroom_group_location')?></th>
     <th><?php echo lang('classroom_group_num_students')?></th>
     <th><?php echo lang('classroom_group_num_modules')?></th>
     <th><?php echo lang('classroom_group_num_submodules')?></th>
     <th><?php echo lang('classroom_group_description')?></th>
    </tr>
 </tfoot>
 <tbody>
  <!-- Iteration that shows classroom_groups-->
   <?php if (is_array($all_classgroups) or ($all_classgroups instanceof Traversable)): ?>
    <?php //var_dump($all_classgroups);
      foreach ($all_classgroups as $classroom_group_key => $classroom_group) : ?>
       <tr align="center" class="{cycle values='tr0,tr1'}">
         <td>
          <a href="<?php echo base_url('/index.php/curriculum/classroom_group/edit/' . $classroom_group->id ) ;?>">
              <?php echo $classroom_group->id;?>
          </a>
         </td>
         <td>
              <?php echo $classroom_group->code;?>
         </td>
         <td>
          <a href="<?php echo base_url('/index.php/curriculum/classroom_group/read/' . $classroom_group->id ) ;?>">
              <?php echo $classroom_group->name;?>
          </a>
         </td>

            <?php $mentor_fullname =  $classroom_group->mentor_givenname . " " . $classroom_group->mentor_sn1 . " " . $classroom_group->mentor_sn2; ?>
         <td>
          ( <a href="<?php echo base_url('/index.php/teachers/teachers/index/edit/' . $classroom_group->mentor_id ) ;?>">
              <?php echo $classroom_group->mentor_code ;?>
          </a> ) <a href="<?php echo base_url('/index.php/persons/persons/index/read/' . $classroom_group->mentor_person_id ) ;?>">
              <?php echo $mentor_fullname;?>
          ( person id: <a href="<?php echo base_url('/index.php/persons/index/edit/' . $classroom_group->mentor_id ) ;?>">
              <?php echo $classroom_group->mentor_person_id ;?>
          </a> )
          </a>
         </td>
         <td>
          <a href="<?php echo base_url('/index.php/curriculum/course/edit/' . $classroom_group->course_id ) ;?>">
              <?php echo "( " . $classroom_group->course_id . " ) " ;?><a href="<?php echo base_url('/index.php/curriculum/course/read/' . $classroom_group->course_id ) ;?>"><?php echo $classroom_group->course_shortname . ". " . $classroom_group->course_name ;?></a>
          </a>
         </td>

         <td><?php echo $classroom_group->study_shortname;?></td>

         <td>
          (<a href="<?php echo base_url('/index.php/curriculum/studies/edit/' . $classroom_group->study_id ) ;?>"><?php echo $classroom_group->study_id;?></a>)
          <a href="<?php echo base_url('/index.php/curriculum/studies/read/' . $classroom_group->study_id ) ;?>">
              <?php echo $classroom_group->study_shortname . ". " . $classroom_group->study_name . " - " . $classroom_group->study_law_shortname . " - " . $classroom_group->study_law_name;?>
          </a>
         </td>

         <td>
              <?php echo $classroom_group->shift_name;?>
         </td>

         <td>
          <a href="<?php echo base_url('/index.php/location/location/index/read/' . $classroom_group->location_id ) ;?>">
              <?php echo $classroom_group->location_shortname;?>
          </a>
         </td>

         <td>TODO</td>
         <td>
          TODO
         </td>
         <td>
          TODO
         </td>
         <td>
          <?php echo $classroom_group->description;?>
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
