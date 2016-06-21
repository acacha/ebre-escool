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
                        Lliçons
                    </small>
                </h1>
</div><!-- /.page-header -->

<div style='height:10px;'></div>
	<div style="margin:10px;">
   		



      <script>
      $(function(){

              $("#select_all").click(function() {

                $('input:checkbox').map(function () {
                  this.checked = true;
                }).get(); 
                
              });

              $("#unselect_all").click(function() {

                $('input:checkbox').map(function () {
                  this.checked = false;
                }).get(); 
                
              });

              //Jquery select plugin: http://ivaynberg.github.io/select2/
              $("#select_lessons_academic_period_filter").select2();

              $('#select_lessons_academic_period_filter').on("change", function(e) {  
                  var selectedValue = $("#select_lessons_academic_period_filter").select2("val");
                  var pathArray = window.location.pathname.split( '/' );
                  var secondLevelLocation = pathArray[1];
                  var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/managment/curriculum_reports_lessons";
                  //alert(baseURL + "/" + selectedValue);
                  window.location.href = baseURL + "/" + selectedValue;

              });

              var all_lessons_table = $('#all_lessons').DataTable( {
                      "columnDefs": [
                                      { "type": "html", "targets": 3 }
                                    ],
                      "aLengthMenu": [[10, 25, 50,100,200,-1], [10, 25, 50,100,200, "<?php echo lang('All');?>"]],                      
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
                                              "sPdfMessage": "<?php echo lang("all_lessons");?>",
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

        $("#calculate_study_module").click(function() {
              var txt;
              var r = confirm("Esteu segurs que voleu fer aquest càlcul per a tots els mòduls seleccionats?");
              if (r == true) {

                  var values = $('input:checkbox:checked.ace').map(function () {
                    return this.id;
                  }).get(); 
                  
                  //AJAX
                  $.ajax({
                  url:'<?php echo base_url("index.php/managment/calculate_study_module");?>',
                  type: 'post',
                  data: {
                      values: values,
                  },
                  datatype: 'json',
                  statusCode: {
                    404: function() {
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/managment/calculate_study_module' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    },
                    500: function() {
                      $("#response").html('A server-side error has occurred.');
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/managment/calculate_study_module ' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    }
                  },
                  error: function() {
                    $.gritter.add({
                        title: 'Error!',
                        text: 'Ha succeït un error!' ,
                        class_name: 'gritter-error gritter-center'
                      });
                  },
                  success: function(data) {
                    //console.debug("data:" + JSON.stringify(data));
                    //console.debug(JSON.stringify(all_ldap_users_table));
                    //all_lessons_table.ajax.reload();
                    location.reload();
                  }
                }).done(function(data){
                    //TODO: Something to check?
                

                });
              }

        });

        $("#select_all_lessons_study_code_filter").select2({ width: 'resolve', placeholder: "Seleccioneu un estudi", allowClear: true });

        $("#select_all_lessons_study_code_filter").on( 'change', function () {
            var val = $(this).val();
            all_lessons_table.column(3).search( val , false, true ).draw();
        } );

        all_lessons_table.column(3).data().unique().sort().each( function ( d, j ) {
                var StrippedString = d.replace(/(<([^>]+)>)/ig,"");
                var textToSearch = StrippedString.slice(0,StrippedString.indexOf("(")-1).trim();
                $("#select_all_lessons_study_code_filter").append( '<option value="'+ textToSearch  +'">'+ textToSearch +'</option>' )
        } );
        
        $("#select_all_lessons_course_code_filter").select2({ width: 'resolve', placeholder: "Seleccioneu un curs", allowClear: true });
        $("#select_all_lessons_course_code_filter").on( 'change', function () {
            var val = $(this).val();

            all_lessons_table.column(4).search( val , false, true ).draw();
        } );

        all_lessons_table.column(4).data().unique().sort().each( function ( d, j ) {
                var StrippedString = d.replace(/(<([^>]+)>)/ig,"");
                var textToSearch = StrippedString.slice(0,StrippedString.indexOf("(")-1).trim();
                $("#select_all_lessons_course_code_filter").append( '<option value="'+textToSearch+'">'+textToSearch+'</option>' )
        } );

        $("#select_all_lessons_classroomgroup_filter").select2({ width: 'resolve', placeholder: "Seleccioneu un grup de classe", allowClear: true });
        $("#select_all_lessons_classroomgroup_filter").on( 'change', function () {
            var val = $(this).val();

            all_lessons_table.column(5).search( val, false, true ).draw();
        } );

        all_lessons_table.column(5).data().unique().sort().each( function ( d, j ) {
                var StrippedString = d.replace(/(<([^>]+)>)/ig,"");
                var textToSearch = StrippedString.slice(0,StrippedString.indexOf("(")-1).trim();
                $("#select_all_lessons_classroomgroup_filter").append( '<option value="'+textToSearch+'">'+textToSearch+'</option>' )
        } );


        $("#select_all_lessons_study_module_filter").select2({ width: 'resolve', placeholder: "Seleccioneu un MP/Crèdit", allowClear: true });
        $("#select_all_lessons_study_module_filter").on( 'change', function () {
            var val = $(this).val();

            all_lessons_table.column(7).search( val, false, true ).draw();
        } );

        all_lessons_table.column(7).data().unique().sort().each( function ( d, j ) {
                var StrippedString = d.replace(/(<([^>]+)>)/ig,"");
                var textToSearch = StrippedString.slice(0,StrippedString.indexOf("(")-1).trim();
                $("#select_all_lessons_study_module_filter").append( '<option value="'+textToSearch+'">'+textToSearch+'</option>' )
        } );

        $("#select_all_lessons_teacher_filter").select2({ width: 'resolve', placeholder: "Seleccioneu un professor", allowClear: true });
        $("#select_all_lessons_teacher_filter").on( 'change', function () {
            var val = $(this).val();

            all_lessons_table.column(6).search( val, false, true ).draw();
        } );

        all_lessons_table.column(6).data().unique().sort().each( function ( d, j ) {
                var StrippedString = d.replace(/(<([^>]+)>)/ig,"");
                var textToSearch = StrippedString.slice(0,StrippedString.indexOf("(")-1).trim();
                $("#select_all_lessons_teacher_filter").append( '<option value="'+textToSearch+'">'+textToSearch+'</option>' )
        } );

        $("#select_all_lessons_location_filter").select2({ width: 'resolve', placeholder: "Seleccioneu un espai", allowClear: true });
        $("#select_all_lessons_location_filter").on( 'change', function () {
            var val = $(this).val();

            all_lessons_table.column(8).search( val, false, true ).draw();
        } );

        all_lessons_table.column(8).data().unique().sort().each( function ( d, j ) {
                var StrippedString = d.replace(/(<([^>]+)>)/ig,"");
                var textToSearch = StrippedString.slice(0,StrippedString.indexOf("(")-1).trim();
                $("#select_all_lessons_location_filter").append( '<option value="'+textToSearch+'">'+textToSearch+'</option>' )
        } );

        $("#select_all_lessons_day_filter").select2({ width: 'resolve', placeholder: "Seleccioneu un dia", allowClear: true });
        $("#select_all_lessons_day_filter").on( 'change', function () {
            var val = $(this).val();

            all_lessons_table.column(9).search( val, false, true ).draw();
        } );

        all_lessons_table.column(9).data().unique().sort().each( function ( d, j ) {
                var StrippedString = d.replace(/(<([^>]+)>)/ig,"");
                var textToSearch = StrippedString.slice(0,StrippedString.indexOf("(")-1).trim();
                $("#select_all_lessons_day_filter").append( '<option value="'+textToSearch+'">'+textToSearch+'</option>' )
        } );

        $("#select_all_lessons_time_slot_filter").select2({ width: 'resolve', placeholder: "Seleccioneu una franja horària", allowClear: true });
        $("#select_all_lessons_time_slot_filter").on( 'change', function () {
            var val = $(this).val();

            all_lessons_table.column(10).search( val, false, true ).draw();
        } );

        all_lessons_table.column(10).data().unique().sort().each( function ( d, j ) {
                var StrippedString = d.replace(/(<([^>]+)>)/ig,"");
                var textToSearch = StrippedString.slice(0,StrippedString.indexOf("(")-1).trim();
                $("#select_all_lessons_time_slot_filter").append( '<option value="'+textToSearch+'">'+textToSearch+'</option>' )
        } );

});
</script>

<div class="container">

<table class="table table-striped table-bordered table-hover table-condensed" id="all_all_lessonss_filter">
  <thead style="background-color: #d9edf7;">
    <tr>
      <td colspan="6" style="text-align: center;"> <h4>Filtres per columnes
        </h4></td>
    </tr>
    <tr> 
       <td><?php echo lang('lessons_academic_period')?>: </td>
       <td>
          <select id="select_lessons_academic_period_filter">
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
       <td><?php echo lang('lesson_study_code')?>:</td>
       <td>
        <select id="select_all_lessons_study_code_filter"><option value=""></option></select>
      </td>
       <td><?php echo lang('lesson_course_code')?>:</td>
       <td>
        <select id="select_all_lessons_course_code_filter">
          <option value=""></option>
        </select>
      </td>
    </tr>

    <tr> 
       <td><?php echo lang('lesson_classroom_group')?>:</td>
       <td>
        <select id="select_all_lessons_classroomgroup_filter">
          <option value=""></option>
        </select>
       </td>       
      <td><?php echo lang('lesson_study_module')?>:</td>
      <td>
        <select id="select_all_lessons_study_module_filter"><option value=""></option></select>
      </td>
       <td><?php echo lang('lesson_teacher')?>:</td>
       <td>
        <select id="select_all_lessons_teacher_filter">
          <option value=""></option>
        </select>
      </td>
    </tr>
    <tr> 
       <td><?php echo lang('lesson_location')?>:</td>
       <td>
        <select id="select_all_lessons_location_filter">
          <option value=""></option>
        </select>
       </td>       
      <td><?php echo lang('lessons_day')?>:</td>
      <td>
        <select id="select_all_lessons_day_filter"><option value=""></option></select>
      </td>
      <td><?php echo lang('lessons_time_slot')?>:</td>
      <td>
        <select id="select_all_lessons_time_slot_filter">
          <option value=""></option>
        </select>
      </td>
    </tr>
    <tr>
      <td colspan="7" style="text-align: center;"> <strong>Accions massives (aplica l'acció sobre tots els usuaris seleccionats)
        </strong></td>
    </tr>
    <tr> 
       <td>
        <button class="btn btn-mini btn-danger" id="select_all">
          <i class="icon-bolt"></i>
          Selecionar tots
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="unselect_all">
          <i class="icon-bolt"></i>
          Deselecionar tots
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td colspan="4">
        <button class="btn btn-mini btn-info" id="calculate_study_module">
          <i class="icon-bolt"></i>
          Calcular Mòdul professional/Crèdit
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
    </tr>
  </thead>  
</table> 

<table class="table table-striped table-bordered table-hover table-condensed" id="all_lessons">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="15" style="text-align: center;"> <h4>
      <a href="<?php echo base_url('/index.php/curriculum/lessons') ;?>">
        <?php echo $lessons_table_title?>
      </a>
      </h4></td>
  </tr>
  <tr>
     <th>&nbsp;</th>
     <th><?php echo lang('lesson_id')?></th>
     <th><?php echo lang('lesson_academic_period')?></th>
     <th><?php echo lang('lesson_code')?></th>
     <th><?php echo lang('lesson_study')?></th>
     <th><?php echo lang('lesson_course')?></th>
     <th><?php echo lang('lesson_classroom_group')?></th>
     <th><?php echo lang('lesson_teacher')?></th>
     <th><?php echo lang('lesson_study_module_name_from_external_app')?></th>
     <th><?php echo lang('lesson_study_module')?></th>
     <th><?php echo lang('lesson_location')?></th>
     <th><?php echo lang('lessons_day')?></th>
     <th><?php echo lang('lessons_time_slot')?></th>
     <th><?php echo lang('lesson_lective')?></th>
     <th><?php echo lang('lesson_order')?></th>
  </tr>
 </thead>
 <tbody> 

  <!-- Iteration that shows lessons-->

  <?php if (is_array($all_lessons) ) : ?>
  <?php foreach ($all_lessons as $lesson_key => $lesson) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">   
     <td><label><input class="ace" type="checkbox" name="form-field-checkbox" id="<?php echo $lesson->id;?>"><span class="lbl">&nbsp;</span></label></td>
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/lessons/read/' . $lesson->id ) ;?>">
          <?php echo $lesson->id;?>
      </a> 
      (<a href="<?php echo base_url('/index.php/curriculum/lessons/edit/' . $lesson->id ) ;?>">
          edit
      </a>)
     </td>

     <td>
      <a href="<?php echo base_url('/index.php/curriculum/academic_periods/read/' . $lesson->academic_period ) ;?>">
          <?php echo $lesson->academic_period_shortname;?>
      </a> 
      (<a href="<?php echo base_url('/index.php/curriculum/academic_periods/edit/' . $lesson->academic_period ) ;?>">
          <?php echo $lesson->academic_period;?>
      </a> )
     </td>

     <td>
      <?php echo $lesson->code;?>      
     </td>

     <td>
      <a href="<?php echo base_url('/index.php/curriculum/studies/read/' . $lesson->studies_id ) ;?>">
          <?php echo $lesson->studies_shortname . ". " . $lesson->studies_name ;?>
      </a> 
      (<a href="<?php echo base_url('/index.php/curriculum/studies/edit/' . $lesson->studies_id ) ;?>">
          <?php echo $lesson->studies_id;?>
      </a> )
     </td>

     <td>
      <a href="<?php echo base_url('/index.php/curriculum/course/read/' . $lesson->course_id ) ;?>">
          <?php echo $lesson->course_shortname . ". " . $lesson->course_name ;?>
      </a> 
      (<a href="<?php echo base_url('/index.php/curriculum/course/edit/' . $lesson->course_id ) ;?>">
          <?php echo $lesson->course_id;?>
      </a> )
     </td>

     <td>
          <a href="<?php echo base_url('/index.php/curriculum/classroom_group/read/' . $lesson->classroom_group_id ) ;?>">
            <?php echo $lesson->classroom_group_code . " - " . $lesson->classroom_group_shortName . ". " . $lesson->classroom_group_name ;?>
          </a> 
          (<a href="<?php echo base_url('/index.php/curriculum/classroom_group/edit/' . $lesson->classroom_group_id ) ;?>">
            <?php echo $lesson->classroom_group_id;?>
          </a> )
     </td>

     <td>
          <a href="<?php echo base_url('/index.php/teachers/index/read/' . $lesson->teacher_id ) ;?>">
            <?php echo $lesson->teacher_code . " - " . $lesson->givenName . " " . $lesson->sn1 . " " .  $lesson->sn2;?>
          </a> 
          (<a href="<?php echo base_url('/index.php/teachers/index/edit/' . $lesson->teacher_id ) ;?>">
            <?php echo $lesson->teacher_id;?>
          </a> )
     </td>
     
     <td>
        <?php echo $lesson->codi_assignatura;?>
     </td>

     <td>
      <a href="<?php echo base_url('/index.php/curriculum/study_module/read/' . $lesson->study_module_id ) ;?>">
          <?php echo $lesson->study_module_shortname . ". " . $lesson->study_module_name;?>
      </a>
      ( <a href="<?php echo base_url('/index.php/curriculum/study_module/edit/' . $lesson->study_module_id ) ;?>">
          <?php echo $lesson->study_module_id ;?>
      </a> )
     </td>

     <td>
      <?php if ( $lesson->location_id == 0 || trim($lesson->location_shortName) == "" ) : ?>
        No disponible
      <?php  else : ?>

      <a href="<?php echo base_url('/index.php/location/location/index/read/' . $lesson->location_id ) ;?>">
          <?php echo $lesson->location_shortName . ". " . $lesson->location_name;?>
      </a>
      ( <a href="<?php echo base_url('/index.php/location/location/index/edit/' . $lesson->location_id ) ;?>">
          <?php echo $lesson->location_id ;?>
      </a> )

    <?php endif; ?>
     </td>
 
    <td>
      <?php echo $lesson->day;?>
    </td>

     <td>
      <a href="<?php echo base_url('/index.php/attendance/time_slots/read/' . $lesson->time_slot_id ) ;?>">
          <?php echo $lesson->start_time . " - " .$lesson->end_time;?>
      </a>
      ( <a href="<?php echo base_url('/index.php/attendance/time_slots/edit/' . $lesson->time_slot_id ) ;?>">
          <?php echo $lesson->time_slot_id ;?>
      </a> )
    </td>

    <td>
      <?php echo $lesson->lective;?>
    </td>

    <td>
      <?php echo $lesson->order;?>
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