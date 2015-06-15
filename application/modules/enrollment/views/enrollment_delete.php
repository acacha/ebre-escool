<div class="main-content" >

  <!-- Breadcrumbs -->
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
      <li class="active"><?php echo "Matrícula"?></li>
    </ul>
  </div><!-- /breadcrumbds -->

  <!-- Page Header -->
  <div class="page-header position-relative">
    <h1>
      <?php echo "Matrícula";?>
      <small>
        <i class="icon-double-angle-right"></i>
        <?php echo "Esborrar matrícula";?>
      </small>
    </h1>
  </div><!-- /.page-header -->	

  <div style='height:10px;'></div>  
  
  <div style="margin:10px;">

    <!-- PAGE CONTENT BEGINS -->
    <div class="row-fluid">
      

                    <div class="widget-box">
                      <div class="widget-header" style="text-align: center;">
                      <!-- /widget-header -->
                        <span >
                          <small class="green" >
                           <b><?php echo lang("enrollment_student_personal_data");?></b>
                          </small>
                        </span>
                        <div class="widget-toolbar">
                          <a href="#" data-action="collapse">
                            <i class="icon-chevron-up"></i>
                          </a>
                        </div>
                      </div>
                      <div class="widget-body">

                          <form id="validation-form">

                          <div class="row-fluid">
                            <div class="span12">

                                <div id="user-profile-1" class="user-profile row-fluid">
                                  
                                  <!-- AVATAR -->
                                  <div class="span3 center">
                                    
                                    <div class="span2"></div>
                                    <div class="span8 center">
                                      <div class="space-4"></div>
                                      
                                      <!-- Student Photo -->
                                      <div id="student_photo">
                                        <span class="profile-picture">
                                          <img id="avatar" style="height: 100px;" class="editable img-responsive editable-click" src="<?php echo base_url('assets/img/alumnes').'/foto.png';?>" alt="photo" />
                                        </span>
                                      </div>                                        

                                      <div id="student_full_name" class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                        <div class="inline position-relative">
                                          <i class="icon-circle light-green middle"></i> <span class="white">Alumne</span>
                                        </div>
                                      </div>                                      
                                    </div>  
                                    <div class="space-4"></div>
                                  </div>
                                  <!-- AVATAR END -->

                                  <div class="span9">
                                      
                                    <!-- DNI  -->
                                    <div class="span11" >
                                      
                                        <div class="span4" >                                  
                                          <label id="lbl_student_official_id" for="student_official_id" class="control-label no-padding-right"><?php echo "DNI/NIF/Passaport";?>&nbsp;</label>
                                          <div class="controls">
                                            <input type="hidden" id="person_id" name="person_id" />
                                            <input type="text" id="student_official_id" name="student_official_id" placeholder="Escriu el <?php echo lang('wizzard_official_DNI');?>" />
                                          </div>
                                        </div>
                                      
                                        <div class="span3">
                                          <label class="control-label" for="person_secondary_official_id"><?php echo lang('wizzard_secondary_official_id');?>&nbsp;</label>
                                          <input type="text" name="person_secondary_official_id" readonly="true"/>
                                        </div>

                                    </div>


                                    <div class="span11" >
                                           
                                          <div class="span4">
                                            <label class="control-label" for="student_date_of_birth"><?php echo lang('wizzard_date_of_birth');?>&nbsp;</label>
                                            <div class="input-prepend">
                                              <span class="add-on">
                                               <i class="icon-calendar bigger-110"></i>
                                              </span> 
                                              <input class="form-control date-picker span11 input-mask-date" type="text" name="person_date_of_birth" data-date-format="dd-mm-yyyy" readonly="true"/>                                                                    
                                            </div>  
                                          </div>

                                          
                                          <div class="span4">
                                            <label for="Tipus" >Sexe</label>
                                            <div class="span4">
                                              <label>
                                                <input name="sexe" type="radio" class="ace" value="M" checked="checked" readonly="true" />
                                                <span class="lbl"> Home</span>
                                              </label>                                      
                                            </div>
                                            <div class="span4">
                                              <label>
                                                <input name="sexe" type="radio" class="ace" value="F" readonly="true"/>
                                                <span class="lbl"> Dona</span>
                                              </label>                                      
                                            </div>
                                          </div>    

                                    </div>




                                    </div>
                                    
                                  </div>

                                  <div class="span11">
                                    <div class="span3">
                                        <div class="control-group">
                                          <label class="control-label" for="student_givenName"><?php echo lang('wizzard_givenName');?></label>

                                          <div class="controls">
                                             <input id="givenName" type="text" name="person_givenName"  readonly="true"/>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="control-group">
                                          <label class="control-label"><?php echo lang('wizzard_sn1');?></label>

                                          <div class="controls">
                                             <input id="sn1" type="text" name="person_sn1" readonly="true"/>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                      <label class="control-label" for="student_sn2"><?php echo lang('wizzard_sn2');?>&nbsp;</label>
                                      <input id="sn2" type="text" name="person_sn2"  readonly="true" />
                                    </div>
                                    <div class="span3">
                                      <label class="control-label" for="student_username">Username:&nbsp;</label>
                                      <input id="username" type="text" name="person_username" readonly="true" />                                    
                                    </div>
                                  </div>
                                  
                                  <div class="span11" >
                                    
                                    
                                    <div class="span3">
                                      <label class="control-label" for="student_telephoneNumber"><?php echo lang('wizzard_telephoneNumber');?>&nbsp;</label>
                                      <div class="input-prepend">                         
                                        <span class="add-on">
                                          <i class="icon-phone"></i>
                                        </span>
                                        <input type="text" name="person_telephoneNumber" id="person_telephoneNumber" readonly="true" />                          
                                      </div>
                                    </div>
                           
                                    <div class="span3">
                                      <label class="control-label" for="student_mobile"><?php echo lang('wizzard_mobile');?>&nbsp;</label>  
                                      <div class="input-prepend">                         
                                        <span class="add-on">
                                          <i class="icon-phone"></i>
                                        </span>                                     
                                        <input type="text" name="person_mobile" readonly="true"/>                      
                                      </div>
                                    </div>
                                    
                                    <div class="span3">
                                      <div class="control-group">
                                        <label class="control-label" for="student_email"><?php echo lang('wizzard_email');?>&nbsp;</label>    
                                        <div class="controls">                      
                                          <input type="text" id="person_email" name="person_email" readonly="readonly" value="" readonly="true"/>                         
                                        </div>  
                                      </div>  
                                    </div>  

                                    <div class="span3">
                                      <div class="control-group">
                                        <label class="control-label" for="student_email"><?php echo lang('wizzard_personal_email');?>&nbsp;</label>    
                                        <div class="controls">                      
                                          <input type="text" name="person_secondary_email" id="person_secondary_email" readonly="true"/>                         
                                        </div>  
                                      </div>  
                                    </div>

                                  </div>                                  
                            
                                  <div class="span11" >
                                    <div class="span7">
                                      <label class="control-label" for="student_homePostalAddress"><?php echo lang('wizzard_homePostalAddress');?>&nbsp;</label>
                                      <input class="span12" type="text" name="person_homePostalAddress" readonly="true" />                          
                                    </div>
                                    <div class="span5">
                                      <div class="span4">
                                        <label class="control-label" for="student_postal_code"><?php echo lang('wizzard_postal_code');?>&nbsp;</label> 
                                        <input class="span12 input-mask-postalcode" type="text" name="postalcode_code" id="postalcode_code" value="" readonly="true"/>
                                      </div>  
                                      <div class="span8">
                                        <label class="control-label" for="student_locality"><?php echo lang('wizzard_locality_name');?>&nbsp;</label>
                                        <select id="person_locality_id" name="person_locality_id" class="select2 span4" style="width:300px" readonly="true">
                                          <? foreach($localities as $locality): ?>
                                          <option id="locality_postal_code_<?php echo $locality['locality_postal_code'];;?>" value="<?php echo $locality['locality_id']; ?>" <?php if ( $this->config->item('default_locality_id') == $locality['locality_id'] ) { echo "selected=\"selected\""; } ;?> ><?php echo $locality['locality_name']; ?></option>
                                          <? endforeach; ?>
                                        </select>

                                      </div>                            
                                    </div>                                    
                                  </div>

                                  
                              </div><!-- /.span -->
                            </div><!-- /.row-fluid -->
                      </form>
                      </div>
                    </div> <!-- widget-box -->

                    <!-- !!! PREVIOUS ENROLLMENT PERIODS!!!! --> 
                    <div class="widget-box">
                      <div class="widget-header" style="text-align: center;">
                      <!-- /widget-header -->
                        <span >
                          <small class="green" >
                           <b><?php echo "Matrícules";?></b>
                          </small>
                        </span>
                        <div class="widget-toolbar">
                          <a href="#" data-action="collapse">
                            <i class="icon-chevron-up"></i>
                          </a>
                        </div>
                      </div>
                      <div class="widget-body">
                        <div style="margin:10px;">
                          <table class="table table-striped table-bordered table-hover table-condensed" id="previous_enrollments">
                            <thead style="background-color: #d9edf7;">
                              <tr>
                                <td colspan="6" style="text-align: center;"> <strong>Accions massives (aplica l'acció sobre tots els usuaris seleccionats)
                                  </strong></td>
                              </tr>
                              <tr> 
                                 <td>
                                   Seleccionar:
                                 </td>
                                 <td>
                                  <button class="btn btn-mini btn-info" id="delete_enrollment">
                                    <i class="icon-bolt"></i>
                                    Eliminar
                                    <i class="icon-arrow-right icon-on-right"></i>
                                  </button>
                                 </td>
                                 <td>
                                  <button class="btn btn-mini btn-danger" id="select_all">
                                    <i class="icon-bolt"></i>
                                    Selecionar tots
                                    <i class="icon-arrow-right icon-on-right"></i>
                                  </button>
                                 </td>
                                 <td colspan="3">
                                  <button class="btn btn-mini btn-danger" id="unselect_all">
                                    <i class="icon-bolt"></i>
                                    Deselecionar tots
                                    <i class="icon-arrow-right icon-on-right"></i>
                                  </button>
                                 </td>
                            </tr>
                            <tr>
                               <th>&nbsp;</th> 
                               <th>Període acadèmic</th>
                               <th>Id</th>
                               <th>Estudi</th>
                               <th>Curs</th>
                               <th>Grup de classe</th>
                            </tr>
                           </thead>
                          </table> 

                        </div>          
                      </div>
                    </div>  

                        <!-- !!! END PREVIOUS ENROLLMENT PERIODS!!!! --> 

                    <!-- WIDGET BOX ENROLLMENT INFO -->
                    <div class="widget-box">
                      <div class="widget-header" style="text-align: center;">
                      <!-- /widget-header -->
                        <span >
                          <small class="green" >
                           <b><?php echo "Informació de matrícula període";?> <span id="period_title"/></b>
                          </small>
                        </span>
                        <div class="widget-toolbar">
                          <a href="#" data-action="collapse">
                            <i class="icon-chevron-up"></i>
                          </a>
                        </div>
                      </div>
                      <div class="widget-body">
                        <div style="margin:10px;">
                          <div class="row-fluid">
                            <div class="span12">
                                <div class="span1">
                                    <div class="control-group">
                                      <label class="control-label" for="student_givenName"><?php echo "Id"?></label>

                                      <div class="controls">
                                         <input id="enrollment_id" type="text" name="enrollment_id"  readonly="true" style="width:100%;"/>
                                      </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                      <label class="control-label" for="student_givenName"><?php echo "Estudi"?></label>

                                      <div class="controls">
                                         <input id="enrollment_study" type="text" name="enrollment_study"  readonly="true" style="width:100%;"/>
                                      </div>
                                    </div>
                                </div>
                                <div class="span5">
                                    <div class="control-group">
                                      <label class="control-label" for="student_givenName"><?php echo "Curs"?></label>

                                      <div class="controls">
                                         <input id="enrollment_course" type="text" name="enrollment_course"  readonly="true" style="width:90%;"/>
                                      </div>
                                    </div>
                                </div>
                            </div>
                          </div>  
                          <div class="row-fluid">
                            <div class="span12">
                                <div class="span6">
                                    <div class="control-group">
                                      <label class="control-label" for="student_givenName"><?php echo "Grup de classe"?></label>

                                      <div class="controls">
                                         <input id="enrollment_classroom_group" type="text" name="enrollment_classroom_group"  readonly="true" style="width:100%;"/>
                                      </div>
                                    </div>
                                </div>
                                <div class="span2">
                                    <div class="control-group">
                                      <label class="control-label" for="student_givenName"><?php echo "Matrícula curs complet"?></label>

                                      <div class="controls">
                                         <input id="enrollment_full_course" type="text" name="enrollment_full_course"  readonly="true" style="width:90%;" value="TODO"/>
                                      </div>
                                    </div>
                                </div>
                                <div class="span2">
                                    <div class="control-group">
                                      <label class="control-label" for="student_givenName"><?php echo "# Mòduls matrículats"?></label>

                                      <div class="controls">
                                         <input id="enrollment_num_study_modules" type="text" name="enrollment_num_study_modules"  readonly="true" style="width:90%;"/>
                                      </div>
                                    </div>
                                </div>
                                <div class="span2">
                                    <div class="control-group">
                                      <label class="control-label" for="student_givenName"><?php echo "# Unitats formatives"?></label>

                                      <div class="controls">
                                         <input id="enrollment_num_study_submodules" type="text" name="enrollment_num_study_submodules"  readonly="true" style="width:90%;"/>
                                      </div>
                                    </div>
                                </div>
                            </div>  
                          </div>  
                          <div class="row-fluid">
                            <table class="table table-striped table-bordered table-hover table-condensed" id="study_modules_table">
                             <thead style="background-color: #d9edf7;">
                              <tr> 
                                 <th colspan="6"><b>Mòduls professionals<b/></th>
                              </tr>
                              <tr> 
                                 <th>Id</th>
                                 <th>Codi</th>
                                 <th>Nom curt</th>
                                 <th>Nom</th>
                                 <th>Curs</th>
                                 <th>Hores setmanals</th>
                                 <!-- study_module_description: mostrar al posar-se a sobre una estona-->
                              </tr>
                             </thead>
                            </table> 
                            <table class="table table-striped table-bordered table-hover table-condensed" id="study_submodules_table">
                             <thead style="background-color: #d9edf7;">
                              <tr> 
                                 <th colspan="9" ><b>Unitats formatives<b/></th>
                              </tr>
                              <tr> 
                                 <th>Id</th>
                                 <th>Mòdul professional</th>
                                 <th>Nom curt</th>
                                 <th>Nom</th>
                                 <th>Curs</th>
                                 <th># hores</th>
                                 <th>Data inici</th>
                                 <th>Data fi</th>                                 
                              </tr>
                             </thead>
                            </table> 
                          </div>  
                        </div>      
                      </div>
                    </div>  

                    <!-- END WIDGET BOX ENROLLMENT INFO -->    

                    <!-- DATATABLES WITH STUDY SUBMODULES-->












        </div> <!-- /row-fluid -->            
    </div> <!-- margin:10px; -->

</div>
<!-- PAGE CONTENT ENDS -->

<!--  
  JAVASCRIPT
-->  
<script type="text/javascript">
  if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>

<!-- inline scripts related to this page -->
<script type="text/javascript">

//DEFAULT PERIOD
var periode = "2015-16";
var enrollment_id = "";
$('#period_title').html(periode);

var previous_enrollments_table;


function refresh_enrollment_info(person_id, periode, enrollment_id) {

  current_enrollment_id = "";

  //Change enrollment table title
  $('#period_title').html(periode);

  $.ajax({
      url:'<?php echo base_url("index.php/enrollment/get_student_enrollment_info");?>',
      type: 'post',
      data: {
          person_id : person_id,
          period_id : periode,
          enrollment_id : enrollment_id
      },
      datatype: 'json',
      statusCode: {
        404: function() {
          $.gritter.add({
            title: 'Error connectant amb el servidor!',
            text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/get_student_enrollment_info ' ,
            class_name: 'gritter-error gritter-center'
          });
        },
        500: function() {
          $("#response").html('A server-side error has occurred.');
          $.gritter.add({
            title: 'Error connectant amb el servidor!',
            text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/get_student_enrollment_info ' ,
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
        
        if ( data!=false ) { //ENROLLMENT INFO EXISTS
          var all_data = $.parseJSON(data);
          
          //DEBUG
          /*
          console.debug(JSON.stringify(all_data));          
          $.each(all_data, function(idx,obj) {  
            console.debug("idx:" + idx);
            console.debug("set value to:" + obj);
          });
          */

          studies_name = all_data['studies_shortname'] + ". " + all_data['studies_name']; 
          course_name = all_data['course_shortname'] + ". " + all_data['course_name']; 
          classroom_group_name = all_data['classroom_group_code'] + ". " + all_data['classroom_group_name'];
          enrollment_id = all_data['enrollment_id'];
          
          $("input[name$='enrollment_study']").val(studies_name);
          $("input[name$='enrollment_course']").val(course_name);
          $("input[name$='enrollment_classroom_group']").val(classroom_group_name);
          $("input[name$='enrollment_id']").val(enrollment_id);
          
          //RELOAD STUDY MODULES DATATABLES
          get_enrollment_study_modules_url = "<?php echo base_url('index.php/enrollment/get_enrollment_study_modules');?>/";
          complete_url = get_enrollment_study_modules_url + enrollment_id + "/" + periode;
          study_modules_table.api().ajax.url(complete_url);
          study_modules_table.api().ajax.reload(); 

          //RELOAD STUDY MODULES DATATABLES
          get_enrollment_study_modules_url = "<?php echo base_url('index.php/enrollment/get_enrollment_study_submodules');?>/";
          complete_url = get_enrollment_study_modules_url + enrollment_id + "/" + periode;
          //console.debug(complete_url);
          study_submodules_table.api().ajax.url(complete_url);
          study_submodules_table.api().ajax.reload(); 

        } else { //ENROLLMENT INFO NOT EXISTS
          console.debug("Enrollment data does not exists");
        }

  });
  
  return current_enrollment_id;
}




jQuery(function($) {

  var availableTags = <?php echo json_encode($all_person_official_ids);?>;
  student_official_id = $('#student_official_id');
  student_official_id.autocomplete({
    source: availableTags
  });

  $.gritter.add({
    title: 'Consulta de dades personals i matrícula per NIF/Passaport/NIE',
    text: 'Escriviu el NIF/Passaport/NIE de l\'alumne i tabuleu per cercar les dades de matrícula' ,
    class_name: 'gritter-warning'
  });

  student_official_id = "";

  previous_enrollments_table = $('#previous_enrollments').dataTable( {
    "bDestroy": true,
    ajax: "<?php echo base_url('index.php/enrollment/get_previous_enrollments');?>/" + student_official_id,
    "aoColumns": [
      { "mData": function(source, type, full) {
        return '<label><input class="ace" type="checkbox" name="form-field-checkbox" id="' + source.enrollment_id + '"><span class="lbl">&nbsp;</span></label>';
      }},
      { "mData": "enrollment_periodid" },
      { "mData": function ( source, type, val ) {
            return "<a href='<?php echo base_url('index.php/enrollment/enrollment/index/read');?>/" + source.enrollment_id + "'>" + source.enrollment_id + "</a> | <a href='<?php echo base_url('index.php/enrollment/enrollment/index/edit');?>/" + source.enrollment_id + "'>modificar</a> ";
          }
      },
      { "mData": function ( source, type, val ) {
            return "<a href='<?php echo base_url('index.php/curriculum/studies/read');?>/" + source.studies_id + "'>" + source.studies + "</a> | <a href='<?php echo base_url('index.php/curriculum/studies/edit');?>/" + source.studies_id + "'> " + source.studies_id + "</a>";
          }
      },
      { "mData": "course_shortname" },
      { "mData": "classroomgroup_shortname" }
    ],
    "bPaginate": false,
    "bFilter": false,
    "bInfo": false,
    "bSort": false,
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
  } );
  
  study_modules_table = $('#study_modules_table').dataTable( {
    "bDestroy": true,
    ajax: "<?php echo base_url('index.php/enrollment/get_enrollment_study_modules');?>/" + enrollment_id + "/" + periode,
    "aoColumns": [
      { "mData": "study_module_id" },
      { "mData": "study_module_external_code" },
      { "mData": "study_module_shortname" },
      { "mData": "study_module_name" },
      { "mData": function ( source, type, val ) { 

            json_courses = JSON.stringify(source.courses);

            course_str = "";
            data = JSON.parse(json_courses);
            $.each(data, function(i, course) {
                course_full_name =  course.shortname + ". " + course.name;
                course_str = course_str + course_full_name;
                if (i < (data.length-1)) {
                  course_str = course_str + ", ";  
                }
            });

            return course_str;
          }
      },
      { "mData": "study_module_hoursPerWeek" }
    ],
    "bPaginate": false,
    "bFilter": false,
    "bInfo": false,
    "bSort": false,
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
  } );

study_submodules_table = $('#study_submodules_table').dataTable( {
    "bDestroy": true,
    ajax: "<?php echo base_url('index.php/enrollment/get_enrollment_study_submodules');?>/" + enrollment_id + "/" + periode,
    "aoColumns": [
      { "mData": "study_submodules_id" },
      { "mData": "study_submodules_module" },
      { "mData": "study_submodules_shortname" },
      { "mData": "study_submodules_name" },      
      { "mData": "study_submodules_course" },
      { "mData": "study_submodules_totalHours" },
      { "mData": "study_submodules_initialDate" },
      { "mData": "study_submodules_endDate"}
    ],
    "bPaginate": false,
    "bFilter": false,
    "bInfo": false,
    "bSort": false,
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
  } );

  $("#delete_enrollment").click(function() {

    
    var txt;
    var r = confirm("Esteu segurs que voleu eliminar aquestes matrícules?");
    if (r == true) {

        var values = $('input:checkbox:checked.ace').map(function () {
          return this.id;
        }).get(); 
        
        //alert(values);

        //AJAX
        $.ajax({
        url:'<?php echo base_url("index.php/enrollment/delete_enrollments");?>',
        type: 'post',
        data: {
            values: values,
        },
        datatype: 'json',
        statusCode: {
          404: function() {
            $.gritter.add({
              title: 'Error connectant amb el servidor!',
              text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/managment/delete_enrollments' ,
              class_name: 'gritter-error gritter-center'
            });
          },
          500: function() {
            $("#response").html('A server-side error has occurred.');
            $.gritter.add({
              title: 'Error connectant amb el servidor!',
              text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/managment/delete_enrollments ' ,
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
          previous_enrollments_table.api().ajax.reload();
        }
      }).done(function(data){
          //TODO: Something to check?
      
      });
    }
    
  });

  $('#previous_enrollments tbody').on( 'click', 'tr', function () {
      //console.debug("click on row!");
      //change period
      periode = $(this).closest('tr').find('td:first').text();
      enrollment_id = $(this).closest('tr').find('td:nth-child(2)').text();
      person_id = $('#person_id').val();

      console.debug("periode: " + periode);
      console.debug("person_id: " + person_id);
      console.debug("enrollment_id: " + enrollment_id);

      if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            previous_enrollments_table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
      }
      
      //Refresh enrollment info AND STUDY MODULES $ STUDY_SUBMODULES DATATABLES
      refresh_enrollment_info(person_id,periode,enrollment_id);

  } );

//END SHOW PREVIOUS ENROLLMENTS

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



  $("#student_official_id").change(function(){
    //console.debug("change event");
    student = $(this).val();

    //Check if is a valid DNI

        $.ajax({
          url:'<?php echo base_url("index.php/enrollment/check_student");?>',
          type: 'post',
          data: {
              student_official_id : student
          },
          datatype: 'json',
          statusCode: {
            404: function() {
              $.gritter.add({
                title: 'Error connectant amb el servidor!',
                text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/check_student ' ,
                class_name: 'gritter-error gritter-center'
              });
            },
            500: function() {
              $("#response").html('A server-side error has occurred.');
              $.gritter.add({
                title: 'Error connectant amb el servidor!',
                text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/check_student ' ,
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

          /* Student Exists */
          if(data != false) {
   
            $.gritter.add({
              // (string | mandatory) the heading of the notification
              title: 'S\'ha trobat la persona!',
              // (string | mandatory) the text inside the notification
              text: "<i class='icon-exclamation-sign'></i> Us hem omplert tots els camps amb les dades de la persona. <button class='close' data-dismiss='alert' type='button'><i class='icon-remove'></i></button>",
            });
          
            var all_data = $.parseJSON(data);
            //console.debug(JSON.stringify(all_data));
            $.each(all_data, function(idx,obj) {
              
              /* Fill form with student data from Database */
              //console.debug("idx:" + idx);
              //console.debug("set value to:" + obj);
              $("input[name$="+idx+"]").val(obj);
              
              if(idx=='person_locality_id') {
                  //console.debug("test");
                  $('#person_locality_id').val(obj);
                  $('#person_locality_id').select2();
              }

              student_full_name = $('#student_full_name').find("span.white");
              if(idx=='person_photo'){
                var student_photo = $('#student_photo');

                //Sergi Tur: change only img source not all span!!
                //student_photo.html('<span class="profile-picture"><img id="avatar" style="height: 150px;" class="editable img-responsive editable-click" src="<?php echo base_url('uploads/person_photos'); ?>/'+obj+'" alt="'+ obj +'"/></span>');
                $('#avatar').attr("src","<?php echo base_url('uploads/person_photos');?>/"+obj);
              }
              if(idx=='person_gender'){
                if(obj == 'M'){
                  $('input:radio[name=sexe]').val(['M']);  
                } else if(obj == 'F'){
                  $('input:radio[name=sexe]').val(['F']);  
                }
                
              }
                student_full_name.text(all_data['person_givenName']+" "+all_data['person_sn1']+" "+all_data['person_sn2']);
            });
            
            //RELOAD PREVIOUS ENROLLMENTS:
            get_previous_enrollments_url = "<?php echo base_url('index.php/enrollment/get_previous_enrollments');?>/";
            //console.debug(previous_enrollments_table);
            //console.debug(JSON.stringify(previous_enrollments_table));
            previous_enrollments_table.api().ajax.url(get_previous_enrollments_url + all_data['person_official_id']);
            previous_enrollments_table.api().ajax.reload();

            //GET/REFRESH ENROLLMENT_INFO AND STUDY MODULES ANS SUBMODULES TABLES
            enrollment_id = refresh_enrollment_info(all_data['person_id'],periode,false);

          /* Student doesn't exists, clear form data */
          } else {
              $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'NO s\'ha trobat la persona!',
                // (string | mandatory) the text inside the notification
                text: "<i class='icon-exclamation-sign'></i> No s'ha trobat cap persona amb el DNI/NIF/Passaport indicat!. <button class='close' data-dismiss='alert' type='button'><i class='icon-remove'></i></button>",
                class_name: 'gritter-error gritter-center'
              });
              empty_student = {"person_id":"",
              "person_photo":"","person_secondary_official_id":"","person_givenName":"",
              "person_sn1":"","person_sn2":"","person_email":"","person_secondary_email":"","person_date_of_birth":"",
              "person_gender":"","person_homePostalAddress":"","postalcode_code":"","person_locality_id":"","username":"",
              "person_telephoneNumber":"","person_mobile":""}

              /*value_to_select= $('#locality_postal_code_' + postalcode).val(); 
              $('#person_locality_id').val(value_to_select);
              $('#person_locality_id').select2();*/

              /*
              student_photo = $('#student_photo');
              student_photo.html('<span class="profile-picture"><img id="avatar" style="height: 150px;" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url('assets/img/alumnes/foto.png'); ?>" alt="photo"/></span>');                  
              student_full_name.text('Alumne');*/

              $.each(empty_student, function(idx,obj) {
                $("#input[name$="+idx+"]").val(obj);
              });
          }

        });

  //editableAvatar();          

  });

});

</script>

<div style="height: 35px;"></div>    
