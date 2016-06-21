<div class="main-content">
 <style TYPE="text/css"> 
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
  <?php echo lang('mentoring_attendance_by_student');?>
  <small>
   <i class="icon-double-angle-right"></i>
    <span id="title_student_name"></span>
  </small>
 </h1>
</div>

<div class="row-fluid">

   <div class="span2 center">
      <div></div>
    </div>
    <div class="span7 center">
       <!-- FILTERS -->    
       <div style="width:90%; margin:0px auto;">
        
          <table class="table table-bordered" cellspacing="10" cellpadding="5">
            <div class="form-group ui-widget">
              <tr>
                <td><label for="grup" style="width:150px;">Període acadèmic:</label></td>
                <td>
                          <select id="select_class_list_academic_period_filter">
                          <?php foreach ($academic_periods as $academic_period_key => $academic_period_value) : ?>
                            <?php if ( $selected_academic_period_id) : ?>
                              <?php if ( $academic_period_key == $selected_academic_period_id) : ?>
                                <option initial_date="<?php echo $academic_period_value->initial_date ;?>" final_date="<?php echo $academic_period_value->final_date ;?>" selected="selected" value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                              <?php else: ?>
                                  <option initial_date="<?php echo $academic_period_value->initial_date ;?>" final_date="<?php echo $academic_period_value->final_date ;?>" value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                              <?php endif; ?>
                            <?php else: ?>   
                                <?php if ( $academic_period_value->current == 1) : ?>
                                  <option initial_date="<?php echo $academic_period_value->initial_date ;?>" final_date="<?php echo $academic_period_value->final_date ;?>" selected="selected" value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                                <?php else: ?>
                                  <option initial_date="<?php echo $academic_period_value->initial_date ;?>" final_date="<?php echo $academic_period_value->final_date ;?>" value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                                <?php endif; ?> 
                            <?php endif; ?> 
                          <?php endforeach; ?>
                          </select>    
                        </td>
                </tr> 
              <tr>
                <td><label for="student">Selecciona l'alumne:</label></td>
                <td><select data-place_holder="TODO" id="selected_student" name="student" data-size="5" data-live-search="true">
                  <option></option>
                  <?php foreach ($students as $student_key => $student) { ?>
                    <?php if ( $student_key == $default_student_key ) : ?>
                      <option enrollment_ids="<?php echo implode(',', $student->enrollments);?>" enrollment_classroom_groups="<?php echo implode(',', $student->enrolled_classroom_groups);?>" enrollment_classroom_groups_fullnames="<?php echo implode(',', $student->enrolled_classroom_groups_full_names);?>" selected="selected" value="<?php echo $student_key ?>" ><?php echo $student->fullname_alt; ?></option>
                    <?php else: ?>  
                      <option enrollment_ids="<?php echo implode(',', $student->enrollments);?>" enrollment_classroom_groups="<?php echo implode(',', $student->enrolled_classroom_groups);?>" enrollment_classroom_groups_fullnames="<?php echo implode(',', $student->enrolled_classroom_groups_full_names);?>" value="<?php echo $student_key ?>" ><?php echo $student->fullname_alt; ?></option>  
                    <?php endif;?>

                  <?php } ?>
                  </select> 
                </td>
              </tr> 
              <tr id="selected_classroom_group_tr" style="display:none;">
                <td><label for="classroom_group">Selecciona el grup de classe:</label></td>
                <td><select data-place_holder="TODO" id="selected_classroom_group" name="classroom_group" data-size="5" data-live-search="true">
                  <option value="-1">---</option>
                  </select> 
                </td>
              </tr> 
            </div>
          </table>
        </div>
      </div>
    <div class="span2 center">
      <div>
        <div class="space-6" ></div>
         <button id="button_report1" class="btn btn-app btn-grey radius-4" style="display:none;">
          <i class="icon-save bigger-160"></i>
           <h6>Informe tutor/a</h6>
         </button>
        </div>
    </div>  
</div>    
<div class="row-fluid">
                  <div class="widget-box collapsed" id="student_statistics_widget-box">
                    <div class="widget-header widget-header-flat widget-header-small">
                      <h5>
                        <i class="icon-signal"></i>
                        <span class="green">Dades glogals Alumne. 
                        </span> <span class="green" id="selected_student_title"></span> 
                        <span style="display:none;" id="selected_initial_date" value="-1"></span> 
                        <span style="display:none;" id="selected_final_date" value="-1"></span>
                      </h5>
                     

                      <div class="widget-toolbar no-border">
                        <div id="reportrange" class="pull-right">
                          <i class="icon-calendar"></i>
                          <span>Rang de dates</span>
                          <b class="caret" style="position: relative; top: -5px"></b>
                        </div>
                      </div>
                      <div class="widget-toolbar">
                        <a data-action="collapse" href="#">
                        <i class="icon-chevron-up"></i>
                        </a>
                      </div>
                    </div>

                    <div class="widget-body">
                      <div class="widget-main">
                        <div class="clearfix">
                          <div class="grid3">
                            <span class="grey">
                              <i class="icon-bell icon-2x red"></i>
                              &nbsp; Incidències totals
                            </span>
                            <h4 class="bigger pull-right"><span title="TODO" id="total_incidents_current_academic_period">---</span></h4>
                            <div class="space-6"></div>
                              <i class="icon-bell icon-2x purple"></i>
                              &nbsp; Tipus 
                            </span>
                            <h5 class="pull-right"><span title="TODO" id="total_incidents_current_academic_period_by_type">---</span></h4>
                            <div class="space-6"></div>
                              <i class="icon-bell icon-2x green"></i>
                              &nbsp; Dies 
                            </span>
                            <h5 class="smaller pull-right"><span title="TODO" id="total_incidents_by_day">---</span></h4>
                            <div class="space-6"></div>
                              <i class="icon-bell icon-2x orange2"></i>
                              &nbsp; Franjes h. 
                            </span>
                            <h5 class="smaller pull-right"><span title="TODO" id="total_incidents_by_time_slot">---</span></h4>
                          </div>

                          <div class="grid3">
                            <span class="grey">
                              <div id="piechart-placeholder1">MPs/Cs</div>
                          </div>

                          <div class="grid3">
                            <span class="grey">
                              <div id="piechart-placeholder">UFs/UDs</div>
                            </span>
                            
                          </div>
                        </div>

                        <div class="hr hr8 hr-double"></div>

                        <div class="clearfix">
                          <div class="grid3">
                            <span class="grey">
                              <div class="infobox infobox-orange2" style="width: 100%;" >
                                <div class="infobox-chart" style="width: 60px;">
                                  <span data-values="0,0,0,0,0" class="sparkline" id="sparkline_days"><canvas style="display: inline-block; width: 65px; height: 29px; vertical-align: top;" width="65" height="29"></canvas></span>
                                </div>

                                <div class="infobox-data" style="padding-left: 25px;">
                                  <span class="infobox-data-number" id="day_of_week_total">---</span>
                                  <div class="infobox-content">Dies de la setmana</div>
                                </div>
                              </div>  
                          </div>

                          <div class="grid3">
                            <span class="grey">
                              <div class="infobox infobox-red" style="width: 100%;" >
                                <div class="infobox-chart" style="width: 77px;">
                                  <span data-values="0,0,0,0,0" class="sparkline" id="sparkline_time_slots"><canvas style="display: inline-block; width: 77px; height: 29px; vertical-align: top;" width="77" height="29"></canvas></span>
                                </div>

                                <div class="infobox-data" style="padding-left: 25px;">
                                  <span class="infobox-data-number" id="time_slots_total">---</span>
                                  <div class="infobox-content">Franjes horàries. Torn: <span id="shift_span"></span><span id="shift_id" style="display:none;"></span></div>
                                </div>
                              </div>
                          </div>

                          <div class="grid3">
                            <span class="grey">
                               Pendent estadístiques Avaluació continuada
                          </div>
                        </div>

                      </div><!-- /widget-main -->
                    </div><!-- /widget-body -->
                  </div><!-- /widget-box -->











    <center><i id="spinner" class="icon-spinner icon-spin orange bigger-300" style="display: none;"></i></center>

    <div class="widget-box collapsed" id="student_statistics_by_study_modules_submodules_widget_box">
      <div class="widget-header widget-header-flat widget-header-small">
        <h5>
          <i class="icon-group"></i>
          <span class="green">Dades per Mòduls professionals/Crèdits i Unitats Formatives/Unitats didàctiques
        </h5>

        <div class="widget-toolbar">
          <a data-action="collapse" href="#">
            <i class="icon-chevron-up"></i>
          </a>
        </div>
      </div>

      <div class="widget-body">
        <div class="widget-main">
          <div class="clearfix">
          <div class="span6">
            <div class="table-header" style="text-align:center;">
              Mòduls professionals/Crèdits
            </div>
              <table class="table table-striped table-bordered table-hover table-condensed" id="study_modules_table">
               <thead style="background-color: #d9edf7;">
                <tr>      
                   <th><?php echo lang('attendance_reports_student_incidents_study_module')?></th>
                   <th><?php echo lang('attendance_reports_student_incidents_study_module_total_incidents')?></th>
                   <th><?php echo lang('attendance_reports_student_incidents_study_module_total_hours')?></th>
                   <th><?php echo lang('attendance_reports_student_incidents_study_module_incidents_percent')?></th>
                </tr>
               </thead>  
             </table> 
          </div>
          <div class="span6">
              <div class="table-header" style="text-align:center;">
                Unitats formàtives/Unitats didàctiques
              </div>
              <table class="table table-striped table-bordered table-hover table-condensed" id="study_submodules_table">
               <thead style="background-color: #d9edf7;">
                <tr>      
                   <th><?php echo lang('attendance_reports_student_incidents_study_module')?></th> 
                   <th><?php echo lang('attendance_reports_student_incidents_study_submodule')?></th>
                   <th><?php echo lang('attendance_reports_student_incidents_study_submodule_total_incidents')?></th>
                   <th><?php echo lang('attendance_reports_student_incidents_study_submodule_total_hours')?></th>
                   <th><?php echo lang('attendance_reports_student_incidents_study_submodule_incidents_percent')?></th>
                </tr>
               </thead>  
             </table> 
          </div>
        </div>
      </div> 

    </div>   

    <div class="space-6" ></div>

    <!-- DEBUG --> 
    <?php //var_export($students);?>

    <div class="table-header" style="text-align:center;">
      Incidències
    </div>
    <table class="table table-striped table-bordered table-hover table-condensed" id="student_incidents">

       <thead style="background-color: #d9edf7;">
        <tr>      
           <th><?php echo lang('attendance_reports_student_incidents_id')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_date')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_day')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_time_slot')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_incident_type')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_study_submodule')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_study_module')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_course')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_entryDate')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_last_update')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_creationUserId')?></th>
           <th><?php echo lang('attendance_reports_student_incidents_lastupdateUserId')?></th>
        </tr>
       </thead>  
     </table>   

    <br/><br/><br/><br/><br/>


</div>



<script>

var student_incidents_table;

function get_selected_student() {
  var selected_student = $("#selected_student").select2("val");
  //console.debug("selected_student: " + selected_student);
  return selected_student;
}

function get_selected_academic_period_id() {
  $("#spinner").show();   // Show the spinner
  var selected_academic_period_id = $("#select_class_list_academic_period_filter").select2("val");
  //console.debug("selected_academic_period_id: " + selected_academic_period_id);
  return selected_academic_period_id;
}

function get_selected_academic_period_initial_date() {
  var selectedValue = $("#select_class_list_academic_period_filter").select2("val");
  var selected_academic_period_initial_date = $('option[value="'+selectedValue+'"]').attr("initial_date");
  return selected_academic_period_initial_date;
}

function get_selected_academic_period_final_date() {
  var selectedValue = $("#select_class_list_academic_period_filter").select2("val");
  var selected_academic_period_final_date = $('option[value="'+selectedValue+'"]').attr("final_date");
  return selected_academic_period_final_date;
}

function get_selected_classroom_group_id() {
  var selected_classroom_group_id = $("#selected_classroom_group").select2("val");
  return selected_classroom_group_id;
}

function reload_incidents_statistics_by_student() {

  var selected_student = get_selected_student();
  var student_id = selected_student;
  var selected_classroom_group_id = get_selected_classroom_group_id();
  var classroom_group_id = selected_classroom_group_id;
  //AJAX. get_incidents_statistics_by_student
    $.ajax({
      url:'<?php echo base_url("index.php/attendance/get_incidents_statistics_by_student");?>',
      type: 'post',
      datatype: 'json',
      data: {
          student_id : student_id,
          classroom_group_id : classroom_group_id,
          initial_date: get_initial_date(),
          final_date: get_final_date(),
      },
      statusCode: {
        404: function() {
          $.gritter.add({
            title: 'Error connectant amb el servidor!',
            text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/attendance/get_incidents_statistics_by_student' ,
            class_name: 'gritter-error gritter-center'
          });
        },
        500: function() {
          $("#response").html('A server-side error has occurred.');
          $.gritter.add({
            title: 'Error connectant amb el servidor!',
            text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/attendance/get_incidents_statistics_by_student' ,
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
      data = $.parseJSON(data);
      
      //console.debug("totalIncidents: " + data.totalIncidents  );
      //console.debug("totalIncidents_current_academic_period: " + data.totalIncidents_current_academic_period );

      //$("#total_incidents").html(data.totalIncidents);
      totalIncidents = data.totalIncidents_current_academic_period;
      $("#total_incidents_current_academic_period").html(totalIncidents);
      $("#day_of_week_total").html(totalIncidents);
      $("#time_slots_total").html(totalIncidents);

      var str_total_incidents_current_academic_period_by_type="";
      $.each(data.incident_types, function( index, value ) {
        //console.debug( value.shortName + " (" + index + ")" + ": " + value.subtotal );
        str_total_incidents_current_academic_period_by_type = str_total_incidents_current_academic_period_by_type + "<strong>" + value.shortName + "</strong>: " + value.subtotal + " ";
      });
      $("#total_incidents_current_academic_period_by_type").html(str_total_incidents_current_academic_period_by_type);

      //Days sparkline
      var str_total_incidents_by_day="";
      var str_array_total_incidents_by_day="";
      $.each(data.incident_days, function( index, value ) {
        //console.debug( value.shortName + " (" + index + ")" + ": " + value.subtotal );
        str_total_incidents_by_day = str_total_incidents_by_day + "<strong>" + value.shortName + "</strong>: " + value.subtotal + " ";
        str_array_total_incidents_by_day = str_array_total_incidents_by_day + value.subtotal + ",";
      });
      str_array_total_incidents_by_day = str_array_total_incidents_by_day.substring(0,str_array_total_incidents_by_day.length - 1);
      $("#total_incidents_by_day").html(str_total_incidents_by_day);
      $("#sparkline_days").attr("data-values",str_array_total_incidents_by_day);

      //Time slots sparkline
      var str_total_incidents_by_time_slot="";
      var str_array_total_incidents_by_time_slot="";
      $.each(data.incident_time_slots, function( index, value ) {
        //console.debug( value.external_code + " " + value.shortName + " (" + index + ")" + ": " + value.subtotal );
        str_total_incidents_by_time_slot = str_total_incidents_by_time_slot + "<span title=\"" + value.shortName +"\"><strong>" + value.external_code + "</strong></span>: " + value.subtotal + " ";
        str_array_total_incidents_by_time_slot = str_array_total_incidents_by_time_slot + value.subtotal + ",";
      });
      str_array_total_incidents_by_time_slot = str_array_total_incidents_by_time_slot.substring(0,str_array_total_incidents_by_time_slot.length - 1);
      
      $("#total_incidents_by_time_slot").html(str_total_incidents_by_time_slot);
      $("#sparkline_time_slots").attr("data-values",str_array_total_incidents_by_time_slot);

      $("#shift_span").html(data.shift.name);
      $("#shift_id").html(data.shift.id);

      colors_array = ["#68BC31","#2091CF","#AF4E96","#DA5430","#FEE074","#119966","#00FFFF","#FFA500","#A52A2A","#8B0000","#ADFF2F","#808000","#AFEEEE","#FF00FF"];
      
      //console.debug(JSON.stringify(colors_array));

      //STUDY SUBMODULES
      var study_submodules_array = [];
      var str_total_incidents_by_study_submodule="";
      var str_array_total_incidents_by_study_submodule="";
      var counter = 0;
      $.each(data.incident_study_submodules, function( index, value ) {
        //console.debug( value.name + " " + value.shortName + " (" + index + ")" + ": " + value.subtotal );
        str_total_incidents_by_study_submodule = str_total_incidents_by_study_submodule + "<span title=\"" + value.name +"\"><strong>" + value.shortName + "</strong></span>: " + value.subtotal + " ";
        str_array_total_incidents_by_study_submodule = str_array_total_incidents_by_study_submodule + value.subtotal + ",";

        study_submodules_array.push({
            label: value.shortName + "." + value.name,
            data: value.subtotal,
            color: colors_array[counter],
        });
        counter++;
      });
      str_array_total_incidents_by_study_submodule = str_array_total_incidents_by_study_submodule.substring(0,str_array_total_incidents_by_time_slot.length - 1);
      $("#total_incidents_by_study_submodule").html(str_total_incidents_by_study_submodule);
      //console.debug(str_total_incidents_by_study_submodule);

      //console.debug(JSON.stringify(study_submodules_array));

      //STUDY MODULES
      study_modules_array = [];
      var str_total_incidents_by_study_module="";
      var str_array_total_incidents_by_study_module="";
      var counter = 0;
      $.each(data.incident_study_modules, function( index, value ) {
        //console.debug( value.name + " " + value.shortName + " (" + index + ")" + ": " + value.subtotal );
        str_total_incidents_by_study_module = str_total_incidents_by_study_module + "<span title=\"" + value.name +"\"><strong>" + value.shortname + "</strong></span>: " + value.subtotal + " ";
        str_array_total_incidents_by_study_module = str_array_total_incidents_by_study_module + value.subtotal + ",";

        study_modules_array.push({
            label: value.shortName + "." + value.name,
            data: value.subtotal,
            color: colors_array[counter],
        });
        counter++;
      });
      str_array_total_incidents_by_study_module = str_array_total_incidents_by_study_module.substring(0,str_array_total_incidents_by_time_slot.length - 1);
      $("#total_incidents_by_study_module").html(str_total_incidents_by_study_module);
      //console.debug(str_total_incidents_by_study_module);

      //console.debug(JSON.stringify(study_modules_array));

      $("#student_statistics_widget-box").removeClass("collapsed");    

      /*var data_piechart_study_submodules = [
        { label: "UF1",  data: 38.7, color: "#68BC31"},
        { label: "UF2",  data: 24.5, color: "#2091CF"},
        { label: "UF3",  data: 8.2, color: "#AF4E96"},
        { label: "UF4",  data: 18.6, color: "#DA5430"},
        { label: "UF5",  data: 10, color: "#FEE074"}
        ];
      */
        /*
      var data_piechart_study_modules = [
        { label: "MP1",  data: 38.7, color: "#68BC31"},
        { label: "MP2",  data: 24.5, color: "#2091CF"},
        { label: "MP3",  data: 8.2, color: "#AF4E96"},
        { label: "MP4",  data: 18.6, color: "#DA5430"},
        { label: "MP5",  data: 10, color: "#FEE074"}
        ];*/

      if ( (study_modules_array.length == 0) || (study_submodules_array.length == 0) ) {
        console.debug("No data values for pie chart. Skipping update_statistics_graphs... Resettings graphs");
        update_statistics_graphs(study_modules_array,study_submodules_array,true);  
      } else {
        update_statistics_graphs(study_modules_array,study_submodules_array);  
      }
      

      //$("#").html(totalIncidents_current_academic_period);
    });

}

function update_statistics_graphs(data_piechart_study_modules,data_piechart_study_submodules,total_is_zero){

  var $box = $('#sparkline_days').closest('.infobox');
  var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
  $('#sparkline_days').sparkline('html', {tagValuesAttribute:'data-values', type: 'bar',
    tooltipFormat: '{{offset:offset}} {{value}}',
    tooltipValueLookups: {
      'offset': {
          0: 'Dilluns',
          1: 'Dimarts',
          2: 'Dimecres',
          3: 'Dijous',
          4: 'Divendres',
     }
    }, barWidth: 12, barColor: barColor , chartRangeMin:$('#sparkline_days').data('min') || 0} );

  var $box = $('#sparkline_time_slots').closest('.infobox');
  var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';

  
  shift_id = $("#shift_id").html();
  if (shift_id==2) {
      $('#sparkline_time_slots').sparkline('html', {tagValuesAttribute:'data-values', type: 'bar',
      tooltipFormat: '{{offset:offset}} {{value}}',
      tooltipValueLookups: {
        'offset': {
            0: '15:30 - 16:30',
            1: '16:30 - 17:30',
            2: '17:30 - 18:30',
            3: '19:00 - 20:00',
            4: '20:00 - 21:00',
            5: '21:00 - 22:00',
       }
      }, barWidth: 12, barColor: barColor , chartRangeMin:$('#sparkline_time_slots').data('min') || 0} );
  } else {
      $('#sparkline_time_slots').sparkline('html', {tagValuesAttribute:'data-values', type: 'bar',
      tooltipFormat: '{{offset:offset}} {{value}}',
      tooltipValueLookups: {
        'offset': {
            0: '08:00 - 9:00',
            1: '09:00 - 10:00',
            2: '10:00 - 11:00',
            3: '11:30 - 12:30',
            4: '12:30 - 13:30',
            5: '13:30 - 14:30',
       }
      }, barWidth: 12, barColor: barColor , chartRangeMin:$('#sparkline_time_slots').data('min') || 0} );
  }

  
  

  // UF PIE CHART
  if (total_is_zero) {
    $('#piechart-placeholder').html("UFs/UDs");
    $('#piechart-placeholder1').html("MPs/Cs");
    return;
  }
  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'170px'});
  function drawPieChart(placeholder, data, position) {

    data_length = data.length;

    number_of_columns=1;
    margin1 = 20;
    if (data_length < 9) {
      number_of_columns=1;
      margin1 = 20;
    } else if (number_of_columns > 17) {
      number_of_columns=3;
      margin1 = -40;
    } else {
      number_of_columns=2;
      margin1 = -10;
    }    

    $.plot(placeholder, data, {
    series: {
      pie: {
        show: true,
        tilt:0.8,
        highlight: {
          opacity: 0.25
        },
        stroke: {
          color: '#fff',
          width: 2
        },
        startAngle: 2
      }
    },
    legend: {
      labelFormatter: function(label, series) {
          var labels = label.split(".");
          return '<span title="' + labels[0] + ". " + labels[1] + ' (' + series.data[0][1] + ')">'+labels[0] + '</span>';
      },
      show: true,
      noColumns: number_of_columns,
      position: position || "ne", 
      labelBoxBorderColor: null,
      margin:[margin1,-10]
    }
    ,
    grid: {
      hoverable: true,
      clickable: true
    }
   })
   };

   if (typeof data_piechart_study_submodules !== 'undefined') {
      //console.debug("data_piechart_study_submodule:" + data_piechart_study_submodule);
      drawPieChart(placeholder, data_piechart_study_submodules);
   }
   

   /**
   we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
   so that's not needed actually.
   */
   placeholder.data('chart', data_piechart_study_submodules);
   placeholder.data('draw', drawPieChart);
  
  
  
    var $tooltip = $("<div class='tooltip top in hide'><div class='tooltip-inner'></div></div>").appendTo('body');
    var previousPoint = null;
  
    placeholder.on('plothover', function (event, pos, item) {
    if(item) {
      if (previousPoint != item.seriesIndex) {
        previousPoint = item.seriesIndex;
        var tip = item.series['label'] + " : " + parseFloat(item.series['percent']).toFixed(2)+'% ' + '('+ item.series.data[0][1]+')';
        $tooltip.show().children(0).text(tip);
      }
      $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
    } else {
      $tooltip.hide();
      previousPoint = null;
    }
    
   });

  // END UF PIE CHART

  // MP PIE CHART
  var placeholder1 = $('#piechart-placeholder1').css({'width':'90%' , 'min-height':'150px'});
  drawPieChart(placeholder1, data_piechart_study_modules);

   /**
   we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
   so that's not needed actually.
   */
   placeholder1.data('chart', data_piechart_study_modules);
   placeholder1.data('draw', drawPieChart);

   placeholder1.on('plothover', function (event, pos, item) {
    if(item) {
      if (previousPoint != item.seriesIndex) {
        previousPoint = item.seriesIndex;
        var tip = item.series['label'] + " : " + parseFloat(item.series['percent']).toFixed(2)+'% ' + '('+ item.series.data[0][1]+')';
        $tooltip.show().children(0).text(tip);
      }
      $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
    } else {
      $tooltip.hide();
      previousPoint = null;
    }
    
   });  
  // END MP PIE CHART
}

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


$(function() { 

  $("#select_class_list_academic_period_filter").select2({dropdownAutoWidth: 'true'});

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

  //console.debug("moment: " +moment());
  //console.debug("moment(month_start_date_mysql, \"YYYY-MM-DD\"): " + moment(month_start_date_mysql, "YYYY-MM-DD"));
  //console.debug("moment(month_end_date_mysql, \"YYYY-MM-DD\"): " + moment(month_end_date_mysql, "YYYY-MM-DD"));
  //console.debug("get_selected_academic_period_initial_date: " + get_selected_academic_period_initial_date());
  //console.debug("get_selected_academic_period_final_date: " + get_selected_academic_period_final_date());

  //console.debug("month_start_date: " + month_start_date);
  //console.debug("month_end_date: " + month_end_date);


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
         'Tot l\'any': [moment(get_selected_academic_period_initial_date(), "YYYY-MM-DD"), moment(get_selected_academic_period_final_date(), "YYYY-MM-DD")],
      },
      startDate: moment(month_start_date, "DD-MM-YYYY") ,
      endDate: moment(month_end_date, "DD-MM-YYYY") ,
    },
    function(start, end) {
        $('#reportrange span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));

        $("#selected_initial_date").html(start.format('YYYY-MM-DD'));
        $("#selected_final_date").html(end.format('YYYY-MM-DD'));

        var selected_student = get_selected_student();
        if (selected_student != "") {
          //RELOAD STATISTICS
          reload_incidents_statistics_by_student();

          //RELOAD INCIDENT LIST DATATABLES
          student_incidents_table.ajax.reload();
          study_modules_table.ajax.reload();
          study_submodules_table.ajax.reload();
        } else {
          console.debug("Nothing to reload. no student selected!");
        }
        
    }
  );

  $('#reportrange span').html(month_start_date + ' - ' + month_end_date);

  $("#selected_student").select2({placeholder: "Seleccioneu un alumne...",allowClear: true,dropdownAutoWidth: 'true'});

  $("#selected_classroom_group").select2({placeholder: "Seleccioneu un grup de classe...",allowClear: true,dropdownAutoWidth: 'true'});

  $('#select_class_list_academic_period_filter').on("change", function(e) {  
        var selectedValue = $("#select_class_list_academic_period_filter").select2("val");
        var pathArray = window.location.pathname.split( '/' );
        var secondLevelLocation = pathArray[1];
        var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/mentoring_attendance_by_student";
        //alert(baseURL + "/" + selectedValue);
        window.location.href = baseURL + "/" + selectedValue;

    });

  $('#selected_student').on("change", function(e) {  
        console.debug("selected_student on change!");
        var selected_student = $("#selected_student").select2("val");
        var theSelection = "";
        if (selected_student!="") {
          theSelection = $("#selected_student").select2('data').text;  
        } 
        
        //console.debug("selected_student: " + selected_student);

        $("#title_student_name").html(theSelection);

        selected_student_text = "";
        if (selected_student != "") {
          var selected_student_text = $("#selected_student").select2('data').text;
          $("#button_report1").show();
        } else {
          $("#button_report1").hide();
        }       
        //console.debug("selected_student onchange: " + selected_student);
        $("#selected_student_title").html(selected_student_text);

        if (selected_student != "") {
          $("#selected_classroom_group_tr").show();

          //POPULATE classroom_group SELECT2 id: selected_classroom_group
          // Info ara in options :
          // Example1:                   <option enrollment_ids="6012" enrollment_classroom_groups="53" value="3933" >Abdelghani , Carxofa - X3480024P ( 3333 )</option>  
          // Example2: <option enrollment_ids="6010,4577" enrollment_classroom_groups="34,43" value="2930" >Abella Pepiton, Marco - 45670085N ( 2933 )</option>  

          var enrollment_classroom_groups = $("option[value='" + selected_student + "']").attr("enrollment_classroom_groups");        
          var enrollment_classroom_groups_fullnames = $("option[value='" + selected_student + "']").attr("enrollment_classroom_groups_fullnames");
          var enrollment_ids = $("option[value='" + selected_student + "']").attr("enrollment_ids");  


          //console.debug("enrollment_ids: " + enrollment_ids);      
          //console.debug("enrollment_classroom_groups: " + enrollment_classroom_groups); 

          $('#selected_classroom_group').find('option').remove();

          var enrollment_classroom_groupsSplit= enrollment_classroom_groups.split(',');
          var enrollment_classroom_groupsFullNamesSplit= enrollment_classroom_groups_fullnames.split(',');
          $.each(enrollment_classroom_groupsSplit,function(enrollment_classroom_group_id){
                //console.debug("enrollment_classroom_group_id: " + enrollment_classroom_groupsSplit[enrollment_classroom_group_id]);
                $("#selected_classroom_group").append('<option value="'+enrollment_classroom_groupsSplit[enrollment_classroom_group_id]+'">'+enrollment_classroom_groupsFullNamesSplit[enrollment_classroom_group_id]+'</option>');
          });
          
          $("#selected_classroom_group").select2("val", enrollment_classroom_groupsSplit[0]);
          $("#selected_classroom_group").select2();

          reload_incidents_statistics_by_student();

        } else {
          $("#student_statistics_widget-box").addClass("collapsed");
        }

        //Reload datatables
        student_incidents_table.ajax.reload();
        study_modules_table.ajax.reload();
        study_submodules_table.ajax.reload();
});

$('#selected_classroom_group').on("change", function(e) { 
      var selected_student = $("#selected_classroom_group").select2("val");
      console.debug("selected_classroom_group: " + selected_classroom_group);

      reload_incidents_statistics_by_student();
      //Reload datatables
      student_incidents_table.ajax.reload();
      study_modules_table.ajax.reload();
      study_submodules_table.ajax.reload();
});

    
    study_modules_table = $("#study_modules_table").DataTable( {
      "bDestroy": true,
      "sServerMethod": "POST",
      "sAjaxSource": "<?php echo base_url('index.php/attendance/attendance_reports/get_student_incidents_by_study_modules');?>", 
      "fnServerParams": function ( aoData ) {
          aoData.push( { "name": "academic_period_id", "value": get_selected_academic_period_id() });
          aoData.push( { "name": "student_id", "value": get_selected_student() });
          aoData.push( { "name": "classroom_group_id", "value": get_selected_classroom_group_id() });
          aoData.push( { "name": "initial_date", "value": get_initial_date() });
          aoData.push( { "name": "final_date", "value": get_final_date() });
      },
      "aoColumns": [
          { "mData": function(data, type, full) {
                      return data.study_module_shortname + ". " + data.study_module_name + " (" + data.study_module_id + ")";
                    }},
          { "mData": function(data, type, full) {
                      return data.study_module_total_incidents;
                    }},
          { "mData": function(data, type, full) {
                      return data.study_module_total_hours;
                    }},   
          { "mData": function(data, type, full) {
                      return data.study_module_total_incidents_percent;
                    }},
        ],
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
            },
      "bPaginate": false,
      "bFilter": false,
      "bInfo": false,
    });
    study_submodules_table = $("#study_submodules_table").DataTable( {
      "bDestroy": true,
      "sServerMethod": "POST",
      "sAjaxSource": "<?php echo base_url('index.php/attendance/attendance_reports/get_student_incidents_by_study_submodules');?>", 
      "fnServerParams": function ( aoData ) {
          aoData.push( { "name": "academic_period_id", "value": get_selected_academic_period_id() });
          aoData.push( { "name": "student_id", "value": get_selected_student() });
          aoData.push( { "name": "classroom_group_id", "value": get_selected_classroom_group_id() });
          aoData.push( { "name": "initial_date", "value": get_initial_date() });
          aoData.push( { "name": "final_date", "value": get_final_date() });
      },
      "aoColumns": [
          { "mData": function(data, type, full) {
                      return data.study_module_shortname + ". " + data.study_module_name + " (" + data.study_module_id + ")";
                    }},
          { "mData": function(data, type, full) {
                      return data.study_submodules_shortname + ". " + data.study_submodules_name + " (" + data.study_submodule_id + ")";
                    }},          
          { "mData": function(data, type, full) {
                      return data.study_submodule_total_incidents;
                    }},
          { "mData": function(data, type, full) {
                      return data.study_submodule_total_hours;
                    }},   
          { "mData": function(data, type, full) {
                      return data.study_submodule_total_incidents_percent;
                    }},
        ],
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
            },
      "bPaginate": false,
      "bFilter": false,
      "bInfo": false,
    });

    student_incidents_table = $('#student_incidents').DataTable( {
                      "order": [[ 1, "desc" ],[3, "desc"]],
                      "bDestroy": true,
                      "sServerMethod": "POST",
                      "sAjaxSource": "<?php echo base_url('index.php/attendance/attendance_reports/get_student_incidents');?>", 
                      "fnServerParams": function ( aoData ) {
                          aoData.push( { "name": "academic_period_id", "value": get_selected_academic_period_id() });
                          aoData.push( { "name": "student_id", "value": get_selected_student() });
                          aoData.push( { "name": "classroom_group_id", "value": get_selected_classroom_group_id() });
                          aoData.push( { "name": "initial_date", "value": get_initial_date() });
                          aoData.push( { "name": "final_date", "value": get_final_date() });
                      },
                      "fnDrawCallback": function () {
                          $("#spinner").hide();   // Hide the spinner
                      },
                      "aoColumns": [
                        { "mData": function(data, type, full) {
                                    return data.id;
                                  },"bVisible": false },
                        { "mData": function(data, type, full) {
                                    return data.date;
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
                                    url = "<?php echo base_url('/index.php/curriculum/course/read/')?>/" +  data.study_submodules_courseid;
                                    return '<a href="' + url + '" title="' + data.course_shortname + '">' + data.course_shortname + ' (' + data.study_submodules_courseid + ')</a>';
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
                  "sDom": 'TRfC<"clear">lrtip', 
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
                                              "sPdfMessage": "TODO",
                                              "sTitle": "TODO",
                                              "sButtonText": "PDF"
                                      },
                                      {
                                              "sExtends": "print",
                                              "sButtonText": "<?php echo lang("Print");?>",
                                              "sToolTip": "Vista impressió",
                                              "sMessage": "<center><h2>Llistat de faltes</h2></center>",
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

  $("#button_report1").click(function() {
    //console.debug( "Click on report button!");

    //Open report in pdf

    var selectedAcademicPeriodValue = $("#select_class_list_academic_period_filter").select2("val");
    var selected_student = $("#selected_student").select2("val");
    var selected_classroom_group_id = get_selected_classroom_group_id();
    var initial_date = get_initial_date();
    var final_date = get_final_date();
    
    var pathArray = window.location.pathname.split( '/' );
    var secondLevelLocation = pathArray[1];
    
    var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/attendance_reports/mentoring_attendance_by_student_pdf_report";    
    //console.debug(baseURL + "/" + selectedAcademicPeriodValue + "/" + selected_student + "/" + selected_classroom_group_id + "/" + initial_date + "/" + final_date);    

    window.open(
      baseURL + "/" + selectedAcademicPeriodValue + "/" + selected_student + "/" + selected_classroom_group_id + "/" + initial_date + "/" + final_date,
      '_blank');

    });

    

    // CHECK IF ALL NECESSARY DATA IS ALREADY GIVEN THEN RELOAD EVERYTHING


    var selected_student2 = get_selected_student();

    if (selected_student2 != "") {
      $("#selected_classroom_group_tr").show();
      $("#button_report1").show();

      //POPULATE classroom_group SELECT2 id: selected_classroom_group
      // Info ara in options :
      // Example1:                   <option enrollment_ids="6012" enrollment_classroom_groups="53" value="3933" >Abdelghani , Carxofa - X3480024P ( 3333 )</option>  
      // Example2: <option enrollment_ids="6010,4577" enrollment_classroom_groups="34,43" value="2930" >Abella Pepiton, Marco - 45670085N ( 2933 )</option>  

      var enrollment_classroom_groups = $("option[value='" + selected_student2 + "']").attr("enrollment_classroom_groups");        
      var enrollment_classroom_groups_fullnames = $("option[value='" + selected_student2 + "']").attr("enrollment_classroom_groups_fullnames");
      var enrollment_ids = $("option[value='" + selected_student2 + "']").attr("enrollment_ids");  

      //console.debug("enrollment_ids: " + enrollment_ids);      
      //console.debug("enrollment_classroom_groups: " + enrollment_classroom_groups); 

      $('#selected_classroom_group').find('option').remove();

      var default_classroom_group_id = "";
      <?php 
      if ($classroom_group_id!="") {
        echo 'var default_classroom_group_id = "' . $classroom_group_id . '";';
      }
      ?>

      var enrollment_classroom_groupsSplit= enrollment_classroom_groups.split(',');
      var enrollment_classroom_groupsFullNamesSplit= enrollment_classroom_groups_fullnames.split(',');
      $.each(enrollment_classroom_groupsSplit,function(enrollment_classroom_group_id){
            //console.debug("enrollment_classroom_group_id: " + enrollment_classroom_groupsSplit[enrollment_classroom_group_id]);
            if ((default_classroom_group_id != "") && (default_classroom_group_id == enrollment_classroom_group_id)) {
              $("#selected_classroom_group").append('<option selected="selected" value="'+enrollment_classroom_groupsSplit[enrollment_classroom_group_id]+'">'+enrollment_classroom_groupsFullNamesSplit[enrollment_classroom_group_id]+'</option>');
            } else {
              $("#selected_classroom_group").append('<option value="'+enrollment_classroom_groupsSplit[enrollment_classroom_group_id]+'">'+enrollment_classroom_groupsFullNamesSplit[enrollment_classroom_group_id]+'</option>');
            }
      });
      
      $("#selected_classroom_group").select2("val", enrollment_classroom_groupsSplit[0]);
      $("#selected_classroom_group").select2();

      reload_incidents_statistics_by_student();

      //Reload datatables
      student_incidents_table.ajax.reload();
      study_modules_table.ajax.reload();
      study_submodules_table.ajax.reload();
    } 

});
</script>