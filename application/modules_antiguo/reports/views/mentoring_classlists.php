<div class="main-content">

<style TYPE="text/css"> 
.row-highlight {
  background-color: #e4efc9;
}
#reportrange {
    background: #ffffff;
    -webkit-box-shadow: 0 1px 3px rgba(0,0,0,.25), inset 0 -1px 0 rgba(0,0,0,.1);
    -moz-box-shadow: 0 1px 3px rgba(0,0,0,.25), inset 0 -1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 3px rgba(0,0,0,.25), inset 0 -1px 0 rgba(0,0,0,.1);
    color: #333333;
    padding: 8px;
    line-height: 18px;
    cursor: pointer;
  }
  #reportrange .caret {
    margin-top: 8px;
    margin-left: 2px;
  }
  #reportrange span {
    padding-left: 3px;
  }
</style>

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
  <li class="active"><?php echo lang('mentoring');?></li>
 </ul>
</div>

<div class="page-content">

<div class="page-header position-relative">
 <h1>
  <?php echo lang('mentoring');?>
  <small>
   <i class="icon-double-angle-right"></i>
    <?php echo "Llistes de classe"; ?>
  </small>
 </h1>
</div>

<div class="alert alert-block alert-warning">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="icon-remove"></i>
                </button>

                <i class="icon-ok green"></i>

                
                <strong class="green">
                  ATENCIÓ : 
                </strong>
                Per mostrar tots els grups a la llista de grups elimineu el filtre de tutor (no seleccioneu cap tutor).
              </div>


<div class="space-5"></div>
  <div style="margin:10px;">
    <div class="container">

      <div class="row-fluid">
          <div class="span4"></div>
      <div class="span4">
        <select id="teacher" style="width: 100%">
               <option></option>
         <?php foreach( (array) $teachers as $teacher_id => $teacher_name): ?>
             <?php if( $teacher_id == $default_teacher): ?>
                  <option value="<?php echo $teacher_id; ?>" selected="selected"><?php echo $teacher_name; ?></option>
                 <?php else: ?> 
                  <option value="<?php echo $teacher_id; ?>" ><?php echo $teacher_name; ?></option>
                 <?php endif; ?> 
         <?php endforeach; ?> 
        </select> 

        </div>
          <div class="span4"><a id="link_to_teacher_timetable" href="<?php echo base_url('/index.php/timetables/allteacherstimetables');?>" style="text-decoration:none;color: inherit;"><i class="icon-calendar"></i> Horari</a>
        </div>
      </div>

      <div class="space-8"></div>

      <div class="row-fluid">
      <table class="table table-striped table-bordered table-hover table-condensed" id="table_filter" width="90%">
          <thead style="background-color: #d9edf7;">
            <tr>
              <td colspan="6" style="text-align: center;"> <strong>Filtres
                </strong></td>
            </tr>
            <tr> 
              <td><?php echo "Període acadèmic"?>:</td>
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


               <td><?php echo "Tutors"?>:</td>
               <td>

                <select id="select_class_list_mentor_filter">
                 <option value=""></option>
                <?php foreach ($mentors as $mentor_key => $mentor_value) : ?>
                 <?php if ( $mentor_id ) : ?>
                  <?php if ( $mentor_key == $mentor_id) : ?>
                     <option selected="selected" value="<?php echo $mentor_key ;?>"><?php echo $mentor_value->code . " - " .  $mentor_value->sn1 . " " . $mentor_value->sn2 . ", " . $mentor_value->givenName . " ( càrrec:" . $mentor_value->charge_full . " ) (" . $mentor_value->id  . ")" ;?></option>
                  <?php else: ?>   
                     <option value="<?php echo $mentor_key ;?>"><?php echo $mentor_value->code . " - " .  $mentor_value->sn1 . " " . $mentor_value->sn2 . ", " . $mentor_value->givenName . " ( càrrec:" . $mentor_value->charge_full . " )  (" . $mentor_value->id  . ")";?></option>
                  <?php endif; ?>   
                  <?php else: ?> 
                     <option value="<?php echo $mentor_key ;?>"><?php echo $mentor_value->code . " - " .  $mentor_value->sn1 . " " . $mentor_value->sn2 . ", " . $mentor_value->givenName . " ( càrrec:" . $mentor_value->charge_full . " )  (" . $mentor_value->id  . ")" ;?></option>
                 <?php endif; ?>
                <?php endforeach; ?>
                </select> 

               </td>
               <td><?php echo "Grup de classe"?>:</td>
               <td>
                <select id="select_class_list_classgroup_filter">
                <?php if ( !$mentor_id ) : ?>  
                 <option value=""></option>
                <?php endif; ?>    
                <?php foreach ($all_classgroups as $classgroup_key => $classgroup_value) : ?>
                  <?php if ( $classgroup_key == $default_classroom_group_id) : ?>
                    <option selected="selected" value="<?php echo $classgroup_key ;?>"><?php echo $classgroup_value->code . " - " .  $classgroup_value->name;?></option>
                  <?php else : ?>
                    <option value="<?php echo $classgroup_key ;?>"><?php echo $classgroup_value->code . " - " .  $classgroup_value->name;?> (<?php echo $classgroup_value->id;?>)</option>
                  <?php endif;?>
                <?php endforeach; ?>
                </select> 

              </td>
            </tr>
          </thead>  
        </table> 

        </div>

        <div class="span2"></div>

        <div class="widget-box span4 collapsed">
                        <div class="widget-header widget-header-small header-color-green">
                          <h6>Filtres alumnes</h6>

                          <span class="widget-toolbar">
                            <a href="#" data-action="collapse">
                              <i class="icon-chevron-down"></i>
                            </a>

                            <a href="#" data-action="close">
                              <i class="icon-remove"></i>
                            </a>
                          </span>
                        </div>

                        <div class="widget-body">
                          <div class="widget-main">
                            
                            <ol class="dd-list">
                      <li class="dd-item dd2-item" data-id="21">
                        <div class="dd-handle dd2-handle">
                          <label><input class="ace" type="checkbox" name="form-field-checkbox" id="checkbox_show_all_students" checked="true"><span class="lbl">&nbsp;</span></label>
                        </div>
                        <div class="dd2-content">Mostrar els estudiants amb UFS soltes</div>
                      </li>

                      <li class="dd-item dd2-item" data-id="13">
                        <div class="dd-handle dd2-handle">
                          <label><input class="ace" type="checkbox" name="form-field-checkbox" id="checkbox_show_all_group_enrolled_students" checked="true"><span class="lbl">&nbsp;</span></label>
                        </div>
                        <div class="dd2-content">Mostrar els alumnes matrículats al grup</div>
                      </li>

                      <li class="dd-item dd2-item" data-id="15">
                        <div class="dd-handle dd2-handle">
                          <label><input class="ace" type="checkbox" name="form-field-checkbox" id="checkbox_show_hide_students"><span class="lbl">&nbsp;</span></label>
                        </div>
                        <div class="dd2-content">Mostrar els alumnes amagats</div>

                      </li>


                    </ol>

                          </div>
                        </div>
                      </div>





      <div class="span4 widget-container-span">
                  <div class="widget-box collapsed">
                    <div class="widget-header widget-header-small header-color-orange">
                      <h6>
                        <i class="icon-sort"></i>
                        Llistats de classe
                      </h6>

                      <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                          <i class="icon-chevron-down"></i>
                        </a>

                        <a href="#" data-action="close">
                          <i class="icon-remove"></i>
                        </a>
                      </div>
                    </div>

                    <div class="widget-body">
                      <div class="widget-main">                        

                    <ol class="dd-list">

                      <li class="dd-item dd2-item" data-id="13">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt orange bigger-130"></i>
 
                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a target="_blank" href="<?php echo base_url('/index.php/attendance/attendance_reports/class_list_report/' . $academic_period_id . '/' . $default_classroom_group_id . '/true' ); ?>">Llista dels estudiants del grup (amb foto | PDF)</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="15">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a target="_blank" href="<?php echo base_url('/index.php/attendance/attendance_reports/class_list_report/' . $academic_period_id . '/' . $default_classroom_group_id . '/false'); ?>">Llista dels estudiants del grup (sense foto | PDF)</a></div>

                      </li>

                      <li class="dd-item dd2-item" data-id="19">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt orange bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a target="_blank" href="<?php echo base_url('/index.php/attendance/attendance_reports/class_sheet_report/' . $academic_period_id . '/' . $default_classroom_group_id);?>">Llençol amb les fotos dels estudiants (PDF)</a></div>
                      </li>
                    </ol>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>          
      </div>  

      <span style="display:none;" id="selected_initial_date" value="-1"></span> 
      <span style="display:none;" id="selected_final_date" value="-1"></span>

      <div class="widget-box">
          <div class="widget-header header-color-dark">
            <h5 class="bigger lighter">Llista de classe. Període acadèmic: <span id="academic_period_text"></span></h5>

            <div class="widget-toolbar">
              # alumnes: <span id="number_of_students"></span>
              <a data-action="collapse" href="#">
                <i class="icon-chevron-up"></i>
              </a>
              <a data-action="close" href="#">
                <i class="icon-remove"></i>
              </a>
            </div>
          </div>
          <div class="widget-body">

            <div class="widget-toolbox" style="line-height: 35px;">
              <i class="icon-arrow-down bigger-110"></i>
              &nbsp;Accions amb els alumnes seleccionats: &nbsp;
              <div class="btn-group">
                <button class="btn btn-mini btn-danger" id ="print_incidents_report">
                  <i class="icon-bell bigger-110"></i>
                  Imprimir informe de faltes d'assistència
                </button>
                <button class="btn btn-mini btn-success" id="select_all">
                  <i class="icon-bolt"></i>
                  Seleccionar tots
                  <i class="icon-arrow-right icon-on-right"></i>
                </button>
                <button class="btn btn-mini btn-primary" id="unselect_all">
                  <i class="icon-bolt"></i>
                  Deseleccionar tots
                  <i class="icon-arrow-right icon-on-right"></i>
                </button>
              </div>
              <div id="reportrange" class="pull-right">
                <i class="icon-calendar"></i>
                <span>Rang de dates</span>
                <b class="caret" style="position: relative; top: -5px"></b>
              </div>
            </div>

            <div class="widget-toolbox" style="line-height: 25px;">
              <span class="badge badge-warning"><i class="icon-group"></i></span> Grup de classe: 
              <span id="selected_classgroup_code"></span>. <span id="selected_classgroup_name"></span>  
              <span class="label label-info" style="float:right;">
                <i class="icon-user"></i>
                Tutor: <span id="selected_classgroup_mentor"></span>
              </span> 
              
            </div>
            

            <div class="space-10"></div>

            <table class="table table-striped table-bordered table-hover table-condensed" id="class_list">
               <thead style="background-color: #d9edf7;">
                <tr>
                   <th>&nbsp;<i class="icon-check"></i></th>
                   <th><?php echo lang('mentoring_classlists_num')?></th>
                   <th title="<?php echo lang('mentoring_classlists_type_full');?>"><?php echo lang('mentoring_classlists_type');?></th>
                   <th><?php echo lang('mentoring_classlists_hidden')?></th>
                   <th><?php echo lang('mentoring_classlists_photo')?></th>
                   <th><?php echo lang('mentoring_classlists_student')?></th>
                   <th><?php echo lang('mentoring_classlists_officialid')?></th>
                   <th><?php echo lang('mentoring_classlists_username')?></th>
                   <th><?php echo lang('mentoring_classlists_initial_password')?></th>
                   <th><?php echo lang('mentoring_classlists_last_login')?></th>
                   <th><?php echo lang('mentoring_classlists_personal_email')?></th>
                   <th><?php echo lang('mentoring_classlists_corporative_email')?></th>
                   <th>Accions&nbsp;&nbsp;&nbsp;&nbsp;</th>
                </tr>
               </thead>
               
              </table> 

          </div>
        </div>
        

        

    

    <div class="space-30"></div>


</div>

<script>

formatted_date = function(date){
      var m = ("0"+ (date.getMonth()+1)).slice(-2); // in javascript month start from 0.
      var d = ("0"+ date.getDate()).slice(-2); // add leading zero
      var y = date.getFullYear();
      return  d +'-'+m+'-'+y;
}

mysql_formatted_date = function(date){
      var m = ("0"+ (date.getMonth()+1)).slice(-2); // in javascript month start from 0.
      var d = ("0"+ date.getDate()).slice(-2); // add leading zero
      var y = date.getFullYear();
      return  y +'-'+m+'-'+d;
}

function get_initial_date(){
  return $("#selected_initial_date").html();
  
}

function get_final_date(){
  return $("#selected_final_date").html();
}

var class_list_table;

function click_on_hidden_student(element) {
  var person_id = element.getAttribute("person_id");
  var action = element.getAttribute("action");
  var classroom_group_id = get_selected_classroom_group_id();
  var teacher_id = $("#teacher").val();
  var academic_period_id = $("#select_class_list_academic_period_filter").val();

  //DEBUG:
  //console.debug("person_id: " + person_id);
  //console.debug("classroom_group_id: " + classroom_group_id);
  //console.debug("teacher_id: " + teacher_id);
  //console.debug("academic_period_id: " + academic_period_id);

  //console.debug("action: " + action);

  //AJAX: hide/unhide student on database:
  //AJAX TO HIDE STUDENT
  $.ajax({
      url:'<?php echo base_url("/index.php/reports/hide_unhide_student_on_classroom_group");?>',
      type: 'post',
      data: {
          person_id : person_id,
          classroom_group_id : classroom_group_id,
          teacher_id : teacher_id,
          academic_period_id : academic_period_id,
          action : action,
      },
      datatype: 'json',
      statusCode: {
        404: function() {
          $.gritter.add({
            title: 'Error connectant amb el servidor!',
            text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/reports/hide_unhide_student_on_classroom_group ' ,
            class_name: 'gritter-error gritter-center'
          });
        },
        500: function() {
          $("#response").html('A server-side error has occurred.');
          $.gritter.add({
            title: 'Error connectant amb el servidor!',
            text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/reports/hide_unhide_student_on_classroom_group' ,
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
    }).done(function(data){
      
      var all_data = $.parseJSON(data);

      //console.debug (all_data);

      result = all_data.result;
      result_message = all_data.message;

      if (result) {
        console.debug(result_message);
      } else {
        $.gritter.add({
          title: 'Error amagant la persona a la base de dades!',
          text: 'No s\'ha pogut amagar la persona a la base de dades. Missatge d\'error:  ' + result_message ,
          class_name: 'gritter-error'
        });
      }

    });

  //RELOAD DATATABLES!
  class_list_table.ajax.reload();
  
}

var mentor_names = [];
var group_codes = [];
var group_names = [];

<?php if(is_array ($all_classgroups)) : ?>
  <?php foreach ($all_classgroups as $classgroup_key => $classgroup_value) : ?>
  mentor_names[<?php echo $classgroup_key ;?>] = "<?php echo $classgroup_value->mentor_code . ' - ' . $classgroup_value->mentor_sn1 . ' ' . $classgroup_value->mentor_sn2 . ', ' . $classgroup_value->mentor_givenname . ' (' . $classgroup_value->mentor_id . ')' ;?>";
  group_codes[<?php echo $classgroup_key ;?>] = "<?php echo $classgroup_value->code . ' (' . $classgroup_value->id . ')';?>";
  group_names[<?php echo $classgroup_key ;?>] = "<?php echo $classgroup_value->course_name . ' (' . $classgroup_value->course_id . ')';?>";
  <?php endforeach; ?>
<?php endif; ?>  




function get_selected_classroom_group_id(){

  selected_group = $("#select_class_list_classgroup_filter").val();
  //console.debug(selected_group);
  return selected_group;
}

function selectedcheckbox1(){
  selected_checkbox_show_all_group_enrolled_students = $("#checkbox_show_all_group_enrolled_students").prop('checked');
  return selected_checkbox_show_all_group_enrolled_students;
}

function selectedcheckbox2(){
  selected_checkbox_show_all_students = $("#checkbox_show_all_students").prop('checked');
  return selected_checkbox_show_all_students;
}

function selectedcheckbox3(){
  selected_checkbox_show_hide_students = $("#checkbox_show_hide_students").prop('checked');
  return selected_checkbox_show_hide_students;
}

function selectedteacherid(){
  selected_teacher_id = $("#teacher").val();
  //console.debug(selected_group);
  return selected_teacher_id;
}

function get_selected_academic_period_id(){
  selected_academic_period_id = $("#select_class_list_academic_period_filter").val();
  //console.debug(selected_academic_period_id;
  return selected_academic_period_id;
}


$(function() {

  $("#select_all").click(function() {

    $('input:checkbox[name="student-checkbox"]').map(function () {
      this.checked = true;
    }).get(); 
    
  });

  $("#unselect_all").click(function() {

    $('input:checkbox[name="student-checkbox"]').map(function () {
      this.checked = false;
    }).get(); 
    
  });

  //Default DATE RANGE. Current month
  var curr_date =new Date();
  var first_day = new Date(curr_date.getFullYear(), curr_date.getMonth(), 1);
  var last_day = new Date(curr_date.getFullYear(), curr_date.getMonth() + 1, 0);

  var current_date =formatted_date(curr_date);
  var month_start_date = formatted_date(first_day);                 
  var month_end_date = formatted_date(last_day);
  var month_start_date_mysql =mysql_formatted_date(first_day);                 
  var month_end_date_mysql =mysql_formatted_date(last_day);

  //console.debug("current_date: " + current_date);
  //console.debug("month_start_date: " + month_start_date);
  //console.debug("month_end_date: " + month_end_date);

  $("#selected_initial_date").html(month_start_date_mysql);
  $("#selected_final_date").html(month_end_date_mysql);

  $('#reportrange').daterangepicker(
    {
      locale: {
        applyLabel: 'Seleccionar',
        cancelLabel: 'Netejar',
        fromLabel: 'De',
        toLabel: 'A',
        customRangeLabel: 'Rang de dates',
        daysOfWeek: ['dl', 'dt', 'dc', 'dj', 'dv', 'ds','dg'],
        monthNames: ['Gener', 'Febrer', 'Març', 'Abril', 'Maig', 'Juny', 'Juliol', 'Agost', 'Setembre', 'Octubre', 'Novembre', 'Desembre'],
        firstDay: 1
      },
      ranges: {
         'Avui': [moment(), moment()],
         'Ahir': [moment().subtract('days', 1), moment().subtract('days', 1)],
         'Últims 7 dies': [moment().subtract('days', 6), moment()],
         'Últims 30 dies': [moment().subtract('days', 29), moment()],
         'Mes actual': [moment().startOf('month'), moment().endOf('month')],
         'Mes anterior': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
      },
      startDate: moment(month_start_date, "DD-MM-YYYY") ,
      endDate: moment(month_end_date, "DD-MM-YYYY") ,
    },
    function(start, end) {
        $('#reportrange span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
        $("#selected_initial_date").html(start.format('YYYY-MM-DD'));
        $("#selected_final_date").html(end.format('YYYY-MM-DD'));
    }
  );

  $('#reportrange span').html(month_start_date + ' - ' + month_end_date);

    $("#teacher").select2(); 

    $("#select_class_list_academic_period_filter").select2();

    $("#academic_period_text").text( $("#select_class_list_academic_period_filter").select2("data").text);

    $('#select_class_list_academic_period_filter').on("change", function(e) {  
        var selectedValue = $("#select_class_list_academic_period_filter").select2("val");
        var pathArray = window.location.pathname.split( '/' );
        var secondLevelLocation = pathArray[1];
        var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/reports/mentoring_classlists";
        //alert(baseURL + "/" + selectedValue);
        window.location.href = baseURL + "/" + selectedValue;

        var selectedValue = $("#select_class_list_classgroup_filter").select2("val");
        $("#selected_classgroup_name").text(group_names[selectedValue]);
        $("#selected_classgroup_code").text(group_codes[selectedValue]);
        $("#selected_classgroup_mentor").text(mentor_names[selectedValue]);

    });

    $("#select_class_list_mentor_filter").select2({ width: 'element', placeholder: "Seleccioneu un tutor", allowClear: true });

    $('#select_class_list_mentor_filter').on("change", function(e) {  
        var selectedValue = $("#select_class_list_mentor_filter").select2("val");

        //console.debug("selectedValue: " + selectedValue);

        if (selectedValue == "") {
          selectedValue = "void";
        }
        
        var pathArray = window.location.pathname.split( '/' );
        var secondLevelLocation = pathArray[1];
        var academic_period_id = $("#select_class_list_academic_period_filter").select2("val");
        var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/reports/mentoring_classlists/" + academic_period_id;
        //alert(baseURL + "/" + selectedValue);
        window.location.href = baseURL + "/" + selectedValue;

        var selectedValue = $("#select_class_list_classgroup_filter").select2("val");
        $("#selected_classgroup_name").text(group_names[selectedValue]);
        $("#selected_classgroup_code").text(group_codes[selectedValue]);
        $("#selected_classgroup_mentor").text(mentor_names[selectedValue]);
      
    });

    //classroom_group_id = 3;
    //console.debug("selected_classroom_group_id: " + get_selected_classroom_group_id());

    class_list_table = $('#class_list').DataTable( {
                      "bDestroy": true,
                      "sServerMethod": "POST",
                      "sAjaxSource": "<?php echo base_url('index.php/reports/get_class_list');?>", 
                      "fnServerParams": function ( aoData ) {
                          aoData.push( { "name": "classroom_group_id", "value": get_selected_classroom_group_id() });
                          aoData.push( { "name": "academic_period_id", "value": <?php echo $academic_period_id;?> });
                          aoData.push( { "name": "checkbox_show_all_group_enrolled_students", "value": selectedcheckbox1() });
                          aoData.push( { "name": "checkbox_show_all_students", "value": selectedcheckbox2() });
                          aoData.push( { "name": "checkbox_show_hide_students", "value": selectedcheckbox3() });
                          aoData.push( { "name": "teacher_id", "value": selectedteacherid() });
                      },
                      "fnDrawCallback": function () {
                          students_shown = this.fnSettings().fnRecordsTotal();
                          //console.debug( students_shown);

                          number_of_students_text = " | | (" + students_shown + " )";

                          $("#number_of_students").html(number_of_students_text);

                          $('.image-thumbnail').fancybox();
                      },
                      "aoColumns": [
                        { "mData": function(data, type, full) {
                                    return '<label><input class="ace" type="checkbox" name="student-checkbox" id="' + data.person_id + '"><span class="lbl">&nbsp;</span></label>';
                                  }},
                        { "mData": function(data, type, full) {
                                    return data.number;
                                  }},
                        { "mData": function(data, type, full) {
                                  //DEBUG:
                                  //console.debug(data.sn1 + " " + data.sn2 + ", " + data.givenName + " (" + data.person_id + ") type:" + data.type);
                                  if (data.type == "*") {
                                      return '<span title="Alumne matrículat oficialment al grup">*</span>';
                                  } else if (data.type == "#")  {
                                      return '<span title="Alumne matrículat de MPs/Crèdits o UFs/UDs soltes">#</span>';
                                  }
                                    
                                  }},          
                        { "mData": function(data, type, full) {
                                    if (data.hidden) {
                                      return "Sí";
                                    } else {
                                      return "No";
                                    }
                                  }},          
                        { "mData": function(data, type, full) {
                                    photos_base_url = "<?php echo base_url('/uploads/person_photos');?>";
                                    student_full_name = data.sn1 + " " + data.sn2 + ", " + data.givenName + " (" + data.person_id + ")";
                                    return '<a class="image-thumbnail" href="' + photos_base_url + '/' + data.photo_url + '"><img data-rel="tooltip" class="msg-photo" alt="'+ student_full_name +'" title="'+ student_full_name +'" src="' + photos_base_url + '/' + data.photo_url + '" style="width:75px;"></img></a>';
                                  }},
                        { "mData": function(data, type, full) {
                                    return data.sn1 + " " + data.sn2 + ", " + data.givenName + " (" + data.person_id + ")";
                                  }},
                        { "mData": "person_official_id" },
                        { "mData": function(data, type, full) {
                                    if (data.multiple_usernames == "true") {
                                      return data.username + " (Atenció: té més d'un usuari!)";
                                    } else {
                                      return data.username;
                                    }
                                  }},
                        { "mData": "initial_password" },
                        { "mData": "last_login" },
                        { "mData": "personal_email" },
                        { "mData": "corporative_email","bVisible": false },
                        { "mData": function(data, type, full) {
                            var eyeiconclass = "icon-eye-close";
                            var color_class = "purple";
                            var title = "Amagar alumne";
                            var action = "hide";
                            
                            if (data.hidden) {
                                eyeiconclass = "icon-eye-open";
                                color_class = "red";
                                title = "Mostrar alumne";
                                var action = "unhide";
                            }
                            
                            var url1 = "<?php echo base_url('/index.php/enrollment/enrollment_query_by_person/false/');?>/" + data.person_official_id;

                            selected_academic_period_id = get_selected_academic_period_id();
                            selected_classroom_group_id = get_selected_classroom_group_id();
                            //http://localhost/ebre-escool/index.php/attendance/mentoring_attendance_by_student/5/2930/34
                            var url2 = "<?php echo base_url('/index.php/attendance/mentoring_attendance_by_student/');?>/" + selected_academic_period_id + "/" + data.person_id + "/" + selected_classroom_group_id;

                            return '<div class="hidden-phone visible-desktop action-buttons"><a class="blue" href="' + url1 + '" target="_blank"><i class="icon-zoom-in bigger-130" title="Consulta matrícula"></i></a><?php if ( $user_is_admin ) : ?><a class="green" href="#" title="Modificar matrícula"><i class="icon-pencil bigger-130" title="Modificar matrícula"></i></a><?php endif;?><a class="orange" target="_blank" href="' + url2 + '"><i class="icon-bell bigger-130" title="Consulta incidències"></i></a><a person_id="' + data.person_id + '" id="hide_student_id_' + data.person_id + '" class="' + color_class + '" href="#"  action="' + action + '" title="' + title + '" onclick="event.preventDefault();click_on_hidden_student(this);"><i class="' + eyeiconclass + ' bigger-130" id="icon_hide_student_id_' + data.person_id + '" title="' + title + '"></i></a></div><div class="hidden-desktop visible-phone"><div class="inline position-relative"><button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown"><i class="icon-caret-down icon-only bigger-120"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close"><li><a href="#" class="tooltip-info" data-rel="tooltip" title="View"><span class="blue"><i class="icon-zoom-in bigger-120"></i>1</span></a></li><li><a href="#" class="tooltip-success" data-rel="tooltip" title="Edit"><span class="green"><i class="icon-edit bigger-120"></i></span></a></li><li><a href="#" class="tooltip-error" data-rel="tooltip" title="' + title + '"><span class="red" title="' + title + '"><i class="' + eyeiconclass + ' bigger-120" title="Amagar alumne"></i></span></a></li></ul></div></div>'
                        }},
                      ],
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
                                              "sPdfMessage": "<?php echo lang("class_list");?>",
                                              "sTitle": "llista_de_classe",
                                              "sButtonText": "PDF"
                                      },
                                      {
                                              "sExtends": "print",
                                              "sButtonText": "<?php echo lang("Print");?>",
                                              "sToolTip": "Vista impressió",
                                              "sMessage": "<center><h2>Llistat de clase</h2></center>",
                                              "sInfo": "<h6>Vista impressió</h6><p>Si us plau utilitzeu l'opció d'imprimir del vostre navegador (Ctrl+P) per "+
                                                       "imprimir. Feu clic a la tecla Esc per tornar.",
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

    $("#checkbox_show_all_group_enrolled_students").change(function() {
      class_list_table.ajax.reload();
    });

    $("#checkbox_show_all_students").change(function() {
      class_list_table.ajax.reload();
    });

    $("#checkbox_show_hide_students").change(function() {
      class_list_table.ajax.reload();
    });

    $("#select_class_list_classgroup_filter").select2({ width: 'element', placeholder: "Seleccioneu un grup de classe", allowClear: true });

    $('#select_class_list_classgroup_filter').on("change", function(e) {  
        var selectedValue = $("#select_class_list_classgroup_filter").select2("val");
        //console.debug("selectedValue: " + selectedValue)
        //json_all_classgroups = "<?php echo json_encode($all_classgroups);?>";

        $("#selected_classgroup_name").text(group_names[selectedValue]);
        $("#selected_classgroup_code").text(group_codes[selectedValue]);
        $("#selected_classgroup_mentor").text(mentor_names[selectedValue]);
        
        class_list_table.ajax.reload();
    });

    var selectedValue = $("#select_class_list_classgroup_filter").select2("val");
    $("#selected_classgroup_name").text(group_names[selectedValue]);
    $("#selected_classgroup_code").text(group_codes[selectedValue]);
    $("#selected_classgroup_mentor").text(mentor_names[selectedValue]);

    $("#print_incidents_report").click(function() {
        var txt;
        var r = confirm("Esteu segurs que voleu crear l'informe PDF per als alumnes seleccionats?");
        if (r == true) {
          console.debug("True selected!!!");

          var values = $('input:checkbox[name="student-checkbox"]:checked.ace').map(function () {
            return this.id;
          }).get(); 
          console.debug("values: " + values);

          if (values != "") {
            //Open report in pdf

            values = String(values).replace(/,/g, '-');
            console.debug("values: " + values);

            var selectedAcademicPeriodValue = $("#select_class_list_academic_period_filter").select2("val");
            var selected_classroom_group_id = $("#select_class_list_classgroup_filter").select2("val");
            var initial_date = get_initial_date();
            var final_date = get_final_date();
            
            var pathArray = window.location.pathname.split( '/' );
            var secondLevelLocation = pathArray[1];
            
            var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/attendance_reports/mentoring_attendance_by_student_pdf_report";    
            //console.debug(baseURL + "/" + selectedAcademicPeriodValue + "/" + selected_student + "/" + selected_classroom_group_id + "/" + initial_date + "/" + final_date);    

            window.open(
              baseURL + "/" + selectedAcademicPeriodValue + "/" + values + "/" + selected_classroom_group_id + "/" + initial_date + "/" + final_date,
              '_blank');
          } else {
            alert ("Marqueu almenys un alumne!");
          }
        }
    });

});


</script>