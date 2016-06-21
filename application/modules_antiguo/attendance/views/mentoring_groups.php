<div class="main-content">

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
  <?php echo lang('mentoring_groups_mentoring');?>
  <small>
   <i class="icon-double-angle-right"></i>
    <span id="teacher_name"></span>
  </small>
 </h1>
</div>

<div class="space-5"></div>

<!--DEBUG-->
<?php //var_export($teachers); 
//echo $default_teacher;
?>

<div class="container">

<?php if ( (!$is_mentor) && (!$user_is_admin) ) : ?>
              <div class="alert alert-block alert-warning">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="icon-remove"></i>
                </button>

                <i class="icon-ok green"></i>

                
                <strong class="green">
                  ATENCIÓ : 
                </strong>
                No sou tutor ni usuari amb permisos d'administrador! No podeu utilitzar aquest apartat
              </div>
<?php else : ?>
  <div class="row-fluid">
            <div class="span4"></div>
        <div class="span4">
          <select id="teacher" style="width: 100%">
                 <option></option>
           <?php foreach( (array) $teachers as $teacher_id => $teacher_name): ?>
               <?php if( $teacher_id == $default_teacher_code): ?>
                    <option value="<?php echo $teacher_id; ?>" selected="selected"><?php echo $teacher_name; ?></option>
                   <?php else: ?> 
                    <option value="<?php echo $teacher_id; ?>" ><?php echo $teacher_name; ?></option>
                   <?php endif; ?> 
           <?php endforeach; ?> 
          </select> 

        </div>
          <div class="span4"><a id="link_to_teacher_timetable" href="<?php echo base_url('/index.php/timetables/allteacherstimetables');?>" style="text-decoration:none;color: inherit;"><i class="icon-calendar"></i> Horari</a></div>
      </div>

      <div class="space-8"></div>

      <table class="table table-striped table-bordered table-hover table-condensed" id="TODO_filter">
          <thead style="background-color: #d9edf7;">
            <tr>
              <td colspan="4" style="text-align: center;"> <strong>Filtres
                </strong></td>
            </tr>
            <tr> 
              <td><?php echo "Grup de classe: "?></td>
              <td>
                <select id="classroom_groups" style="width: 400px">
                       <option></option>
                 <?php foreach( (array) $classroom_groups as $classroom_group_id => $classroom_group): ?>
                     <?php if( $classroom_group_id == $default_classroom_group_id): ?>
                          <option value="<?php echo $classroom_group_id; ?>" selected="selected"><?php echo $classroom_group; ?></option>
                         <?php else: ?> 
                          <option value="<?php echo $classroom_group_id; ?>" ><?php echo $classroom_group; ?></option>
                         <?php endif; ?> 
                 <?php endforeach; ?> 
                </select> 
              </td>


               <td><?php echo "Data: "?></td>
               <td>
                <div class="input-append date" class="span4">
                    <input id="selected_date" type="text" value="<?php echo $check_attendance_date;?>"/><span class="add-on"><i class="icon-calendar"></i></span>
                </div>
               </td>
            </tr>
          </thead>  
        </table> 

        <center>
          <button class="btn btn-large btn-success" id="button_check_attendance_classroom_group">
            <i class="icon-ok bigger-150"></i>
            Tutoritzar el grup
          </button>
        </center>   
<?php endif; ?>

</div>

</div>


<script>

$(function() {

  $("#teacher").select2(); 

  var teacher_name = $("#teacher").select2('data').text;
  $("#teacher_name").text(teacher_name);

  $('#teacher').on("change", function(e) {  
        var teacherselectedValue = $("#teacher").select2("val");
        var teachertheSelection = $("#teacher").select2('data').text;
        var class_room_group_id = $("#classroom_groups").select2("val");

        $("#teacher_name").text(teachertheSelection);
        var pathArray = window.location.pathname.split( '/' );
        var secondLevelLocation = pathArray[1];
        var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/mentoring_groups";
        //alert(baseURL + "/" + selectedValue);
window.location.href = baseURL + "/" + class_room_group_id + "/" + teacherselectedValue;

    });

  //***********************
  //* Datepicker         **
  //***********************
  $('.input-append.date').datepicker({
      format: "dd/mm/yyyy",
      weekStart: 1,
      todayBtn: true,
      language: "ca",
      daysOfWeekDisabled: "0,6",
      autoclose: true,
      todayHighlight: true
    });


    //*****************************
    //* CLASSROOMGROUP DROPDOWN  **
    //*****************************

    //Jquery select plugin: http://ivaynberg.github.io/select2/

    $("#classroom_groups").select2(); 
    $('#classroom_groups').on("change", function(e) {   
        class_room_group_id = $("#classroom_groups").select2("val");
        var teacherselectedValue = $("#teacher").select2("val");
        var teachertheSelection = $("#teacher").select2('data').text;
        $("#teacher_name").text(teachertheSelection);
        var pathArray = window.location.pathname.split( '/' );
        var secondLevelLocation = pathArray[1];
        var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/mentoring_groups";
        //alert(baseURL + "/" + selectedValue);
        window.location.href = baseURL + "/" + class_room_group_id + "/" + teacherselectedValue;

    });

    $( "#button_check_attendance_classroom_group" ).click(function() {
        class_room_group_id = $("#classroom_groups").select2("val");
        var teacherselectedValue = $("#teacher").select2("val");
        var teachertheSelection = $("#teacher").select2('data').text;
        $("#teacher_name").text(teachertheSelection);

        var selected_date = $("#selected_date").val();

        //console.debug("selected date: " + selected_date);        

        var pathArray = window.location.pathname.split( '/' );
        var secondLevelLocation = pathArray[1];
        var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/check_attendance_classroom_group";
        

        //console.debug(baseURL + "/" + class_room_group_id + "/" + teacherselectedValue + "/0/0/" + selected_date);

        if (class_room_group_id == "") {
          alert ("Cal seleccionar un grup de classe");
          return false;
        }
        
        window.location.href = baseURL + "/" + class_room_group_id + "/" + teacherselectedValue + "/0/0/" + selected_date;

    });

    



});
</script>