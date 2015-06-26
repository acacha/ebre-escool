<div class="main-content">

<div id="breadcrumbs" class="breadcrumbs">
 <script type="text/javascript">
  try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
 </script>
 <ul class="breadcrumb">
  <li>
   <i class="icon-home home-icon"></i>
   <a href="<?php echo base_url();?>">Home</a>
   <span class="divider">
    <i class="icon-angle-right arrow-icon"></i>
   </span>
  </li>
  <li class="active"><i class="icon-bell bell-icon"></i> <strong><?php echo lang('check_attendance');?></strong></li>
 </ul>
</div>

<div class="page-content">
<div class="page-header position-relative">
 <h1>Lliçons
  <small>
   <i class="icon-double-angle-right"></i> <strong><?php echo $teacher_full_name . " ( codi: " . $teacher_code . ")";?></strong>
  </small>
 </h1>
</div>

    <div class="alert alert-block alert-error" style="display:yes;">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>

        <i class="icon-ok red"></i>


        <strong class="red">
            IMPORTANT :
        </strong>
        No passeu faltes fins que no rebeu un correu conforme ja està activada la funcionalitat. Estem treballant per posar en marxa aquesta funcionalitat.
    </div>

  <?php if (count($all_time_slots_reduced) == 0) : ?>

      <div class="alert alert-block alert-warning">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="icon-remove"></i>
                </button>

                <strong>
                 <i class="icon-remove"></i>
                  Atenció!
                </strong>
                , no s'ha trobat cap registre pel dia <strong><?php echo $days_of_week[$day_of_week_number] . " " . $check_attendance_date?></strong>! Proveu d'escollir un altre data. 
      </div>


  <?php endif; ?> 




<!-- DEBUG-->
<?php //echo "default_teacher: " . $default_teacher . "<br/>";?>

<div class="row-fluid">

    <div class="span3"></div>

    <div class="span6">

        <div class="widget-box">
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

                    <div class="row-fluid">

                        <div class="span4">Professor: </div>

                        <div class="span4">

                            <select id="teacher" style="width: 400px">
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

                        <div class="span4"><a id="link_to_teacher_timetable" href="<?php echo base_url('/index.php/timetables/allteacherstimetables');?>" style="text-decoration:none;color: inherit;"><i class="icon-calendar"></i> Horari</a></div>

                    </div>

                </div>
            </div>
        </div>





    </div>

    <div class="span3"></div>

</div>

    <div style="height: 10px;"></div>

<center>
  <div class="input-append date">
    	<input type="text" class="span2" value="<?php echo $check_attendance_date;?>"/><span class="add-on"><i class="icon-calendar"></i></span>
  </div>

  <div style="height: 10px;"></div>

  <?php echo "Mostrar horari complet:"; ?> <input id="hide_show_reduced_table" type="checkbox" class="switch-small" 
            data-label-icon="icon-eye-open" 
            data-on-label="<i class='icon-ok'></i>" 
            data-off-label="<i class='icon-remove'></i>"
            data-off="danger">
  
  <div style="height: 10px;"></div>
</center>


 <div id ="check_attendance_table_reduced">

 <table class="table table-striped table-bordered table-hover table-condensed" id="table_check_attendance_table_reduced">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="4" style="text-align: center;"> <h4><?php echo $check_attendance_table_title?> | Dia: <?php echo $days_of_week[$day_of_week_number] . " " . $check_attendance_date?></h4></td>
  </tr>
  <tr>
     <th><?php echo lang("time_slot");?></th>
     <th><?php echo lang("ClassroomGroup");?></th>
     <th>Mòdul Profesional</th>
     <th><?php echo lang("attendances_actions");?></th>
  </tr>
 </thead>
 <tbody>
  <!-- Iteration that shows teacher groups for selected day-->
  <?php foreach ($all_time_slots_reduced as $key => $time_slot) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}" id="tr_<?php echo $key;?>">
     <td><div title="( <?php echo "lesson id: " . $time_slot->lesson_id;?> | <?php echo "lesson_code: " .$time_slot->lesson_code;?> )"><?php echo $time_slot->time_interval;?></div></td>
     <td>
        <?php if ($time_slot->time_slot_lective == 1): ?>
            <li class="tt-event <?php echo $time_slot->classroom_group_colour;?>" style="margin-left: auto;margin-right: auto;position:relative; width: 90%; height:90%;" data-toggle="tooltip" 
              data-original-title="<?php echo $time_slot->group_code?>.  <?php echo $time_slot->group_name;?> ( <?php echo $time_slot->group_id;?> )">
                <a href="<?php echo base_url( '/index.php/curriculum/classroom_group/read/' . $time_slot->group_id) ;?>" style="text-decoration:none;color: inherit;">
                  <?php echo $time_slot->group_code;
                        if ($time_slot->group_name != "") { echo ". " . $time_slot->group_name; } ?></a><br />
                <?php echo "Lloc: " . "<a href=\"" .  base_url( '/index.php/location/location/index/read/' . $time_slot->lesson_location_id)  . "\" style=\"text-decoration:none;color: inherit;\">" . $time_slot->lesson_location . "</a>";?><br />
            </li>
        <?php else: ?>
            <li class="tt-event btn-inverse" style="margin-left: auto;margin-right: auto;position:relative; width: 90%; height: auto;">
                DESCANS<br/>
                &nbsp;<br />
            </li>
        <?php endif; ?>
     </td>

     <td>
        <?php if ($time_slot->time_slot_lective == 1): ?>
            <li class="tt-event <?php echo $time_slot->lesson_colour;?>" style="margin-left: auto;margin-right: auto;position:relative; width: 90%; height:90%;"
                data-toggle="tooltip" 
                data-original-title="<?php echo $time_slot->lesson_shortname?>. <?php echo $time_slot->lesson_name?> ( <?php echo $time_slot->study_module_id;?> ) <?php echo $time_slot->lesson_location;?>  ( <?php echo $time_slot->lesson_location_id?> )">
                <a href="<?php echo base_url( '/index.php/curriculum/study_module/read' . $time_slot->study_module_id) ;?>" style="text-decoration:none;color: inherit;">
                <?php echo $time_slot->lesson_shortname . ". " . $time_slot->lesson_name;?></a><br />
                <?php echo "Lloc: " . "<a href=\"" .  base_url( '/index.php/location/location/index/read/' . $time_slot->lesson_location_id)  . "\" style=\"text-decoration:none;color: inherit;\">" . $time_slot->lesson_location . "</a>";?><br />
            </li>
        <?php else: ?>
            <li class="tt-event btn-inverse" style="margin-left: auto;margin-right: auto;position:relative; width: 90%; height: auto;">
                DESCANS<br/>
                &nbsp;<br />
            </li>
        <?php endif; ?>

     </td>
     <td>
        <?php
        $url_part = $time_slot->group_id . "/" . $teacher_code . "/" . $time_slot->study_module_id
            . "/" . $time_slot->lesson_id . "/" . $day . "/" . $month . "/" . $year . "/0/" . $academic_period_id;
        ?>
        <a href="<?php echo base_url('/index.php/attendance/check_attendance_classroom_group') . "/" . $url_part;?>" class="btn btn-primary">
          <i class="icon-bell icon-white"></i> Passar llista
        </a>
     </td>
   </tr>
        <?php endforeach; ?>
     </tbody>
    </table>

 </div>

 <div id ="check_attendance_table" style="display:none;" >
 
 <table class="table table-striped table-bordered table-hover table-condensed" id="table_check_attendance_table">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="4" style="text-align: center;"> <h4><?php echo $check_attendance_table_title?> | Dia: <?php echo $days_of_week[$day_of_week_number] . " " . $check_attendance_date?></h4></td>
  </tr>
  <tr>
     <th><?php echo lang("time_slot");?></th>
     <th><?php echo lang("ClassroomGroup");?></th>
     <th>TODO Mòdul Profesional</th>
     <th><?php echo lang("attendances_actions");?></th>
  </tr>
 </thead>
 <tbody>
  <!-- Iteration that shows teacher groups for selected day-->
  <?php foreach ($all_time_slots as $key => $time_slot) : ?>
   
   <tr align="center" class="{cycle values='tr0,tr1'}" id="tr_<?php echo $key;?>">
     <td><div title="( <?php echo "lesson id: " . $time_slot->lesson_id;?> | <?php echo "lesson_code: " .$time_slot->lesson_code;?> )"><?php echo $time_slot->time_interval;?></div></td>
     <td>
		<?php if ($time_slot->time_slot_lective == 1): ?>
			<li class="tt-event <?php echo $time_slot->classroom_group_colour;?>" style="margin-left: auto;margin-right: auto;position:relative; width: 90%; height:90%;" data-toggle="tooltip" 
              data-original-title="<?php echo $time_slot->group_code?>.  <?php echo $time_slot->group_name;?> ( <?php echo $time_slot->group_id;?> )">
                <a href="<?php echo base_url( '/index.php/curriculum/classroom_group/read/' . $time_slot->group_id) ;?>" style="text-decoration:none;color: inherit;">
                  <?php echo $time_slot->group_code;
                        if ($time_slot->group_name != "") { echo ". " . $time_slot->group_name; } ?></a><br />
                <?php 
                if ($time_slot->lesson_location != "") {
                  echo "Lloc: " . "<a href=\"" .  base_url( '/index.php/location/location/index/read/' . $time_slot->lesson_location_id)  . "\" style=\"text-decoration:none;color: inherit;\">" . $time_slot->lesson_location . "</a>";
                }
                ?>
                  <br />
            </li>
		<?php else: ?>
			<li class="tt-event btn-inverse" style="margin-left: auto;margin-right: auto;position:relative; width: 90%; height: auto;">
           		DESCANS<br/>
           		&nbsp;<br />
        	</li>
		<?php endif; ?>
     </td>

     <td>
     	<?php if ($time_slot->time_slot_lective == 1): ?>
			<li class="tt-event <?php echo $time_slot->lesson_colour;?>" style="margin-left: auto;margin-right: auto;position:relative; width: 90%; height:90%;"
                data-toggle="tooltip" 
                data-original-title="<?php echo $time_slot->lesson_shortname?>. <?php echo $time_slot->lesson_name?> ( <?php echo $time_slot->study_module_id;?> ) <?php echo $time_slot->lesson_location;?>  ( <?php echo $time_slot->lesson_location_id?> )">
                <?php if ( $time_slot->lesson_shortname != "" ) : ?>
                <a href="<?php echo base_url( '/index.php/curriculum/study_module/read' . $time_slot->study_module_id) ;?>" style="text-decoration:none;color: inherit;">
                <?php echo $time_slot->lesson_shortname . ". " . $time_slot->lesson_name;?></a>
                <?php endif; ?>
                <br />
                <?php 
                if ($time_slot->lesson_location != "") {
                  echo "Lloc: " . "<a href=\"" .  base_url( '/index.php/location/location/index/read/' . $time_slot->lesson_location_id)  . "\" style=\"text-decoration:none;color: inherit;\">" . $time_slot->lesson_location . "</a>";
                }
                ?><br />
            </li>
		<?php else: ?>
			<li class="tt-event btn-inverse" style="margin-left: auto;margin-right: auto;position:relative; width: 90%; height: auto;">
           		DESCANS<br/>
           		&nbsp;<br />
        	</li>
		<?php endif; ?>

	 </td>
	 <td>AAA
    <?php if ($time_slot->time_slot_lective == 1 && ($time_slot->group_code != "")): ?>
        <?php
        $url_part = $time_slot->group_id . "/" . $teacher_code . "/" . $time_slot->study_module_id
            . "/" . $time_slot->lesson_id . "/" . $day . "/" . $month . "/" . $year . "/0/" . $academic_period_id;
        ?>
    <a href="<?php echo base_url('/index.php/attendance/check_attendance_classroom_group') . "/" . $url_part;?>" class="btn btn-primary">
  			<i class="icon-bell icon-white"></i> Passar llista
		</a>
    <?php endif; ?>

	 </td>
   </tr>
  <?php endforeach; ?>
 </tbody>
</table>

</div>

</div>

<script>

$(function() {

    base_teacher_timetable_url = "<?php echo base_url('/index.php/timetables/allteacherstimetables'); ?>";
    base_teacher_timetable_url = base_teacher_timetable_url + "/<?php echo $default_teacher;?>";
    console.debug(base_teacher_timetable_url);
    $('#link_to_teacher_timetable').attr("href", base_teacher_timetable_url);

    $('.tt-event').tooltip();

    $('#hide_show_reduced_table').bootstrapSwitch({});

    $('#hide_show_reduced_table').on('switch-change', function (e, data) {
        var $element = $(data.el),
        value = data.value;
        //console.log(e, $element, value);
        $("#check_attendance_table").slideToggle();
        $("#check_attendance_table_reduced").slideToggle();
    });

  //toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'popup';     
    
    //make username editable
    $('.obs_').editable();

  //Datatable
  //TODO
  //Obtenir les dades corresponents al dropdown escollit (alumne, hora i incidència) i insertar-los a la BD

  //***********************
  //* TEACHERS DROPDOWN  **
  //***********************

  //Jquery select plugin: http://ivaynberg.github.io/select2/
  $("#teacher").select2(); 

  $('#teacher').on("change", function(e) { 
    teacher_code = $("#teacher").select2("val");
    selected_date = $('.input-append.date').datepicker('getDate');
    day= selected_date.getDate();
    month = parseInt(selected_date.getMonth());
    converted_month = month +1 ;
    year=selected_date.getFullYear();
    formated_selectedDate = day + "/" + converted_month + "/" + year;
    //alert (formated_selectedDate);

      //academic_period_picker
      academic_period_id = $("#academic_period_picker").val();

    var pathArray = window.location.pathname.split( '/' );
    var secondLevelLocation = pathArray[1];
    var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/check_attendance";
    //alert(baseURL + "/" + teacher_code);
    window.location.href = baseURL + "/" + teacher_code + "/" + formated_selectedDate + "/" + academic_period_id;

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
    }).on("changeDate", function(e){
        teacher_code = $("#teacher").select2("val");
        selected_date = $('.input-append.date').datepicker('getDate');
        day=selected_date.getDate();
        month = parseInt(selected_date.getMonth());
        converted_month = month +1 ;
        year=selected_date.getFullYear();
        formated_selectedDate = day + "/" + converted_month + "/" + year;

          //academic_period_picker
          academic_period_id = $("#academic_period_picker").val();

        /*
        alert ( "Day: " + day);
        alert ( "Month: " + converted_month );
        alert ( "Year: " + year);
        */

        var pathArray = window.location.pathname.split( '/' );
        var secondLevelLocation = pathArray[1];
        var  baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/check_attendance";
        //alert(baseURL + "/" + selectedValue);
        window.location.href = baseURL + "/" + teacher_code + "/" + formated_selectedDate + "/" + academic_period_id;
    });

    $( "#academic_period_picker" ).change(function() {

        teacher_code = $("#teacher").select2("val");
        selected_date = $('.input-append.date').datepicker('getDate');
        day=selected_date.getDate();
        month = parseInt(selected_date.getMonth());
        converted_month = month +1 ;
        year=selected_date.getFullYear();
        formated_selectedDate = day + "/" + converted_month + "/" + year;

        //academic_period_picker
        academic_period_id = $("#academic_period_picker").val();

        /*
         alert ( "Day: " + day);
         alert ( "Month: " + converted_month );
         alert ( "Year: " + year);
         */

        var pathArray = window.location.pathname.split( '/' );
        var secondLevelLocation = pathArray[1];
        var  baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/check_attendance";
        //alert(baseURL + "/" + selectedValue);
        window.location.href = baseURL + "/" + teacher_code + "/" + formated_selectedDate + "/" + academic_period_id;
    });


  //*****************************
  //* CHECK ATTENDANCES TABLES **
  //*****************************

    

     $('#table_check_attendance_table_reduced').dataTable( {
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


     $('#table_check_attendance_table').dataTable( {
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





  $("select_TODOTODO").change(function(){
    var fila = null;
    var columna = null;
    var hora = null;
    var alumne = null;
    var observacions = null;  
    var incidencia = $("option:selected", this).val();
    var id = $(this).attr('id');

    //obtenir la fila i columna a partir de l'identificador
    text = id.split("-");
    fila = text[1];
    columna = text[0];
    //hora = $(".hora_"+columna).text();
    hora= get_hour(columna);
    //alumne = $("#nom_"+fila).text();
    alumne = get_student(fila);
    insert_value(alumne,hora,incidencia);
    //read_value(alumne,hora);
  });

    //$('#groups_by_teacher_an_date1').dataTable();
    //console.log("HEY YOU1");
  
  //Datepicker
  var data;
  $.datepicker.regional['ca'] = {
          onSelect: function(date) {
                  data = date;
              },
                  closeText: 'Tancar',
                  prevText: '&#x3c;Ant',
                  nextText: 'Seg&#x3e;',
                  currentText: 'Avui',
                  monthNames: ['Gener','Febrer','Mar&ccedil;','Abril','Maig','Juny',
                  'Juliol','Agost','Setembre','Octubre','Novembre','Desembre'],
                  monthNamesShort: ['Gen','Feb','Mar','Abr','Mai','Jun',
                  'Jul','Ago','Set','Oct','Nov','Des'],
                  dayNames: ['Diumenge','Dilluns','Dimarts','Dimecres','Dijous','Divendres','Dissabte'],
                  dayNamesShort: ['Dug','Dln','Dmt','Dmc','Djs','Dvn','Dsb'],
                  dayNamesMin: ['Dg','Dl','Dt','Dc','Dj','Dv','Ds'],
                  weekHeader: 'Sm',
                  dateFormat: 'dd/mm/yy',
                  firstDay: 1,
                  isRTL: false,
                  showMonthAfterYear: false,
                  yearSuffix: ''};

  data = $( "#datepicker" ).datepicker($.datepicker.regional['ca']);
  //alert("la data es: "+data.val());
});

</script>

<?php 

  /* Urls per a fer el Insertar, Editar, Llegir i Esborrar */
  $url_insert = ('http://localhost/ebre-escool/index.php/attendance/insert/prova_incidencies');
  $url_read = ('http://localhost/ebre-escool/index.php/attendance/read/prova_incidencies');
  $url_update = ('http://localhost/ebre-escool/index.php/attendance/update/prova_incidencies');
  $url_delete = ('http://localhost/ebre-escool/index.php/attendance/delete/prova_incidencies');
?>

<script type="text/javascript">

function get_student(fila){
  alumne = $("#nom_"+fila).text();
  return alumne;
}

function get_hour(columna){
  hora = $(".hora_"+columna).text();
  return hora;
}

function insert_value(alumne,hora,incidencia){
  jQuery.ajax({
    url:'<?php echo $url_insert;?>',
    data: {
        alumne: alumne,
        incidencia: incidencia,
        hora: hora
      },
      type: 'post',
      dataType: 'json'
    }).done(
      function (data) 
      {
        alert("S'ha insertat " + data + " fila.");
      }
    ).fail(
      function() 
      {
        alert( "No s'ha pogut obtenir cap valor" );
      });
} 

function read_value(alumne,hora){
  jQuery.ajax({
    url:'<?php echo $url_read;?>',
    data: {
        alumne: alumne,
        hora: hora
      },
      type: 'post',
      dataType: 'json'
    }).done(
      function (data) 
      {
        alert("S'ha llegit " + data + ".");
      }
    ).fail(
      function() 
      {
        alert( "No s'ha pogut obtenir cap valor" );
      });
}
</script>
