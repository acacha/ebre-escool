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
                        Mòduls professionals / Crèdits
                    </small>
                </h1>
</div><!-- /.page-header -->

<div style='height:10px;'></div>
	<div style="margin:10px;">




      <script>
      $(function(){

              //Jquery select plugin: https://ivaynberg.github.io/select2/
              $("#select_study_module_academic_period_filter").select2();

              $('#select_study_module_academic_period_filter').on("change", function(e) {
                  var selectedValue = $("#select_study_module_academic_period_filter").select2("val");
                  var pathArray = window.location.pathname.split( '/' );
                  var secondLevelLocation = pathArray[1];
                  var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/managment/curriculum_reports_studymodules";
                  //alert(baseURL + "/" + selectedValue);
                  window.location.href = baseURL + "/" + selectedValue;

              });

              var all_study_modules_table = $('#all_study_modules').DataTable( {
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
                                              "sPdfMessage": "<?php echo lang("all_study_modules");?>",
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

        $("#select_study_module_study_code_filter").select2({ width: 'resolve',placeholder: "Seleccioneu un estudi", allowClear: true });
        $("#select_study_module_study_code_filter").on( 'change', function () {
            var val = $(this).val();

            all_study_modules_table.column(4).search( val ? '^'+$(this).val()+'$' : val, true, false ).draw();
        } );

        all_study_modules_table.column(4).data().unique().sort().each( function ( d, j ) {
                $("#select_study_module_study_code_filter").append( '<option value="'+d+'">'+d+'</option>' )
        } );

        $("#select_study_module_bcourse_code_filter").select2({ width: 'resolve', placeholder: "Seleccioneu un curs", allowClear: true });
        $("#select_study_module_bcourse_code_filter").on( 'change', function () {
            var val = $(this).val();

            all_study_modules_table.column(6).search( val ? '^'+$(this).val()+'$' : val, true, false ).draw();
        } );

        all_study_modules_table.column(6).data().unique().sort().each( function ( d, j ) {
                $("#select_study_module_bcourse_code_filter").append( '<option value="'+d+'">'+d+'</option>' )
        } );

});
</script>

<div class="container">

<table class="table table-striped table-bordered table-hover table-condensed" id="all_study_modules_filter">
  <thead style="background-color: #d9edf7;">
    <tr>
      <td colspan="13" style="text-align: center;"> <h4>Filtres per columnes
        </h4></td>
    </tr>
    <tr>
       <td><?php echo lang('study_module_academic_period')?>:
          <select id="select_study_module_academic_period_filter">
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
       <td><?php echo lang('study_module_study_code')?>: <select id="select_study_module_study_code_filter"><option value=""></option></select></td>
       <td><?php echo lang('study_module_bcourse_code')?>: <select id="select_study_module_bcourse_code_filter"><option value=""></option></select></td>
    </tr>
  </thead>
</table>

<table class="table table-striped table-bordered table-hover table-condensed" id="all_study_modules">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="14" style="text-align: center;"> <h4>
      <a href="<?php echo base_url('/index.php/curriculum/study_modules') ;?>">
        <?php echo $study_modules_table_title?>
      </a>
      </h4></td>
  </tr>
  <tr>
     <th><?php echo lang('study_module_id')?></th>
     <th><?php echo lang('study_module_code')?></th>
     <th><?php echo lang('study_module_shortname')?></th>
     <th><?php echo lang('study_module_name')?></th>
     <th><?php echo lang('study_module_study_code')?></th>
     <th><?php echo lang('study_module_study')?></th>
     <th><?php echo lang('study_module_bcourse_code')?></th>
     <th><?php echo lang('study_module_bcourse')?></th>
     <th><?php echo lang('study_module_hoursPerWeek')?></th>
     <th><?php echo lang('study_module_order')?></th>
     <th><?php echo lang('study_module_initialDate')?></th>
     <th><?php echo lang('study_module_endDate')?></th>
     <th><?php echo lang('study_module_type')?></th>
     <th><?php echo lang('study_module_subtype')?></th>
  </tr>
 </thead>
 <tbody>

  <!-- Iteration that shows study_modules-->
  <?php if (is_array($all_studymodules)): ?>
  <?php foreach ($all_studymodules as $study_module_key => $study_module) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/study_module/edit/' . $study_module->id ) ;?>">
          <?php echo $study_module->id;?>
      </a>
     </td>
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/study_module/read/' . $study_module->id ) ;?>">
          <?php echo $study_module->code;?>
      </a>
     </td>
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/study_module/read/' . $study_module->id ) ;?>">
          <?php echo $study_module->shortname;?>
      </a>
     </td>
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/study_module/read/' . $study_module->id ) ;?>">
          <?php echo $study_module->name;?>
      </a>
     </td>

     <td>
        <?php
          $num_courses = count($study_module->courses);
          if ($num_courses > 0) {
              echo $study_module->courses[0]->studies_shortname . ". " . $study_module->courses[0]->studies_name . " - " . $study_module->courses[0]->studies_law_name . " -" . $study_module->courses[0]->studies_law_shortname;
          } else {
              echo "";
          }
        ?>

     </td>

     <td>
          <?php

          if ($num_courses > 0) {
              echo "<a href=\"" . base_url('/index.php/curriculum/studies/read/' . $study_module->courses[0]->study_id ) . "\">" .
                  $study_module->courses[0]->studies_shortname . ". " . $study_module->courses[0]->studies_name . " - " . $study_module->courses[0]->studies_law_name . " -" . $study_module->courses[0]->studies_law_shortname . "</a>" .
                  " ( <a href=\" " . base_url('/index.php/curriculum/studies/edit/' . $study_module->courses[0]->study_id ) . "\">" . $study_module->courses[0]->study_id . "</a> )";
          } else {
              echo "";
          }



          ?>
     </td>

     <td>
          <?php

          $num_courses = count($study_module->courses);
          $i=1;
          foreach ($study_module->courses as $course_key => $course) {
            echo $course->shortname . ". " . $course->name;
            if ($i < $num_courses) {
              echo ", ";
            }
            $i++;
          }

          ?>
     </td>

     <td>
          <?php

          $num_courses = count($study_module->courses);
          $i=1;
          foreach ($study_module->courses as $course_key => $course) {
            echo "<a href=\"" . base_url('/index.php/curriculum/course/read/' . $course->id ) . "\">" .
            $course->shortname . ". " . $course->name . "</a>" .
            " ( <a href=\" " . base_url('/index.php/curriculum/course/edit/' . $course->id ) . "\">" . $course->id . "</a> )";
            if ($i < $num_courses) {
              echo ", ";
            }
            $i++;
          }

          ?>

     </td>

     <td>
      <?php echo $study_module->study_module_hoursPerWeek;?>
    </td>

    <td>
      <?php echo $study_module->study_module_order;?>
    </td>

    <td>
      <?php echo $study_module->study_module_initialDate;?>
    </td>

    <td>
      <?php echo $study_module->study_module_endDate;?>
    </td>

    <td>
      <?php echo $study_module->study_module_type;?>
    </td>


    <td>
      <?php echo $study_module->study_module_subtype;?>
    </td>



   </tr>
   <?php endforeach; ?>
  <?php endif; ?>
 </tbody>
</table>

</div>

<div class="space-30"></div>

	</div>
</div>
