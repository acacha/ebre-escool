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
  <li>
    <i class="icon-bell bell-icon"></i>
    <a href="<?php echo base_url('/index.php/attendance/check_attendance');?>">Passar llista</a>       
  <span class="divider">
    <i class="icon-angle-right arrow-icon"></i>
   </span>
  </li>
  <li class="active">
   Grup classe
  </li> 

 </ul>
</div>

<div class="page-content">
<div class="page-header position-relative">
 <h1>
  Grup classe
  <small>
   <i class="icon-double-angle-right"></i>
      <?php echo $academic_period_name ;?>
   <i class="icon-double-angle-right"></i>
    <?php echo "( " . $selected_classroom_group_code . " ) " . $selected_classroom_group . " ( Id: " . $selected_classroom_group_key . " )";?>
  </small>
 </h1>
</div>

<?php if ( $selected_study_module_error ): ?>

  <div class="alert alert-block alert-error" style="">
    <button type="button" class="close" data-dismiss="alert">
      <i class="icon-remove"></i>
    </button>

    <i class="icon-ok red"></i>

    
    <strong class="red">
      IMPORTANT : 
    </strong>
     <?php echo $selected_study_module_error_message ;?>
  </div>

<?php endif;?>  



<div class="alert alert-block alert-error" style="display:none;">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="icon-remove"></i>
                </button>

                <i class="icon-ok red"></i>

                
                <strong class="red">
                  IMPORTANT : 
                </strong>
                No passeu faltes fins que no rebeu un correu conforme ja està activada la funcionalitat. Estem treballant per posar en marxa aquesta funcionalitat.
              </div>


<div class="space-3"></div>

              <div class="row-fluid">

                <div class="widget-box span4 collapsed">
                        <div class="widget-header widget-header-small header-color-green">
                          <h6>Filtres</h6>

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
                        <div class="dd2-content">Mostrar els estudiants no matrículats al grup però amb UFS/Mòduls soltes del grup</div>
                      </li>

                      <li class="dd-item dd2-item" data-id="13">
                        <div class="dd-handle dd2-handle">
                          <label><input class="ace" type="checkbox" name="form-field-checkbox" id="checkbox_show_all_group_enrolled_students" checked="true"><span class="lbl">&nbsp;</span></label>
                        </div>
                        <div class="dd2-content">Mostrar els alumnes matrículats al grup</div>
                      </li>

                      <li class="dd-item dd2-item" data-id="15">
                        <div class="dd-handle dd2-handle">
                          <label><input class="ace" type="checkbox" name="form-field-checkbox" id="checkbox_show_hidden_students"><span class="lbl">&nbsp;</span></label>
                        </div>
                        <div class="dd2-content">Mostrar alumnes amagats</div>

                      </li>


                    </ol>

                          </div>
                        </div>
                      </div>

                <div class="widget-box span4 collapsed">
                        <div class="widget-header widget-header-small header-color-green">
                          <h6>Data i franja: <?php echo $days_of_week[$day_of_week_number] . " " . $check_attendance_date_alt . " " . $selected_time_slot;?></h6>

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
                            <label for="id-date-picker-1_label"><span class="input-group-addon">
                                    <i class="icon-calendar bigger-110"></i>
                                  </span>Escolliu la data:</label>

                                <div class="input-group">                                  
                                  <input class="form-control date-picker" id="datepicker" type="text" data-date-format="dd/mm/yyyy" value="<?php echo $check_attendance_date_alt;?>" /> 
                                </div> 
                            

                            <label for="timepicker1"><span class="input-group-addon">
                                <i class="icon-time bigger-110"></i>
                              </span>Escolliu la franja horaria</label>

                            <div class="input-group bootstrap-timepicker">
                              <select id="time_slots_select" data-placeholder="Escolliu la franja horaria">                                
                                <option value=""> </option>
                                <?php foreach ($time_slots as $time_slot_key => $time_slot): ?>
                                  <option value="<?php echo $time_slot_key;?>" <?php if ($selected_time_slot_id == $time_slot_key ) { echo 'selected="selected"';};?>>
                                    <?php echo $time_slot->range;?>
                                  </option>
                                <?php endforeach;?>
                              </select>

                              
                            </div>

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
                      <li class="dd-item dd2-item" data-id="21">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>
 
                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a target="_blank" href="<?php echo base_url('/index.php/reports/mentoring_classlists/' . $academic_period_id . "/void/" . $selected_classroom_group_key); ?>">Llista dels estudiants del grup ( apartat tutoria)</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="13">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt orange bigger-130"></i>
 
                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a target="_blank" href="<?php echo base_url('/index.php/attendance/attendance_reports/class_list_report/' . $academic_period_id . '/' . $selected_classroom_group_key . '/true' ); ?>">Llista dels estudiants del grup (amb foto | PDF)</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="15">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a target="_blank" href="<?php echo base_url('/index.php/attendance/attendance_reports/class_list_report/' . $academic_period_id . '/' . $selected_classroom_group_key . '/false'); ?>">Llista dels estudiants del grup (sense foto | PDF)</a></div>

                      </li>

                      <li class="dd-item dd2-item" data-id="19">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt orange bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a target="_blank" href="<?php echo base_url('/index.php/attendance/attendance_reports/class_sheet_report/' . $academic_period_id . '/' . $selected_classroom_group_key);?>">Llençol amb les fotos dels estudiants (PDF)</a></div>
                      </li>
                    </ol>






                        </p>
                      </div>
                    </div>
                  </div>
                </div>

                

              <div class="span2"></div>
            </div>


<?php if ($students_with_errors_num > 0 ) :?>
<?php else:?>
  <div class="space-8"></div>
<?php endif;?>

<div class="row-fluid">

  <?php if ($students_with_errors_num > 0 ) :?>

                  <div class="table-header" style="background-color: red;">
                    <i class="icon-group"></i> 
                    <div class="inline position-relative">
                      Alumnes amb errors!!                           
                    </div>
                  </div>

                  <table id="students_with_errors" class="table table-striped table-bordered table-hover">
                    <thead> 
                      <tr>
                        <th>Foto</th>
                        <th>#</th>
                        <th>Típus error</th>
                        <th>Primer cognom</th>
                        <th>Segon cognom</th>
                        <th>Nom</th>
                        <th>
                          <i class="icon-user"></i> User 
                        </th>  
                        <th>
                          <i>@</i> Email 
                        </th>  
                        <th>Accions&nbsp;&nbsp;&nbsp;&nbsp;</th>
                      </tr>  
                    </thead>    
                    <tbody>
                      <?php foreach ($students_with_errors as $student_with_error_key => $student_with_error): ?>

                        <?php $student_witherror_fullname = $student_with_error->givenName . " " . $student_with_error->sn1 . " " . $student_with_error->sn2;?>
                             
                           <td>
                            <a class="image-thumbnail" href="<?php echo base_url($student_with_error->photo_url)?>">
                             <img data-rel="tooltip" style="max-width:35px;";
                              title="<?php echo $student_witherror_fullname . "( " . $student_with_error->person_official_id . ")";?>" class="msg-photo" alt="<?php echo $student_witherror_fullname . "( " . $student_with_error->person_official_id . ")";?>" 
                              src="<?php echo base_url("/uploads/person_photos/" . $student_with_error->photo_url)?>"/>
                            </a>
                          </td>
                          <td>
                            <a href="<?php echo base_url('/index.php/persons/index/read/' . $student_with_error->person_id );?>"><?php echo $student_with_error->person_id;?></a>
                          </td>
                          <td>
                            <?php echo $student_with_error->errorType;?>
                          </td>
                          <td>
                            <?php echo $student_with_error->sn1;?>
                          </td>
                          <td>
                            <?php echo $student_with_error->sn2;?>
                          </td>
                          <td>
                            <?php echo $student_with_error->givenName;?>
                          </td>
                          <td>
                            <div title="<?php echo $student_with_error->username . " ( " . $student_with_error->userid . ")";?>"><a href="<?php echo base_url('/index.php/users/index/read/' . $student_with_error->userid ) ;?>"><?php echo $student_with_error->username;?></a></div>
                          </td>
                          <td>
                            <?php echo $student_with_error->email;?>
                          </td>

                          <td>
                            <div class="hidden-phone visible-desktop action-buttons">
                              <a class="blue" href="<?php echo base_url('/index.php/enrollment/enrollment_query_by_person/false/' . $student_with_error->person_official_id);?>" target="_blank">
                                <i class="icon-zoom-in bigger-130" title="Consulta matrícula"></i>
                              </a>

                              <a class="orange" href="<?php echo base_url('/index.php/attendance/mentoring_attendance_by_student/' . $academic_period_id . '/' . $student_with_error->person_id . '/' . $selected_classroom_group_key);?>" target="_blank">
                                <i class="icon-bell bigger-130" title="Consulta incidències"></i>
                              </a>
                              
                              <?php if ( $user_is_admin ) : ?>
                              <a class="green" href="#">
                                <i class="icon-pencil bigger-130" title="Modificació de matrícula"></i>
                              </a>
                              <?php endif;?>
                            </div>
                          </td>

                        </tr>  

                      <?php endforeach; ?>  
                   
                    </tbody>  

                  </table>     

  <?php endif;?>

   <div class="widget-box">
      <div class="widget-header header-color-dark">
        Professor/a: <span id ="current_selected_teacher" teacher_code="<?php echo $teacher_code;?>" title="<?php echo $teacher_givenName . " " . $teacher_sn1 . " " . $teacher_sn2 . " ( codi: " . $teacher_code . " | " . $teacher_id  . " )";?>"><strong><?php echo $teacher_givenName . " " . $teacher_sn1 . " " . $teacher_sn2 . " ( codi: " . $teacher_code . " )";   ?></strong></span> 

        <div class="widget-toolbar">
          Professors/es del grup: 
              <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                            <?php echo $selected_group_teacher;?>
                            <i class="icon-angle-down icon-on-right bigger-110"></i>
                          </button>

                          <ul class="dropdown-menu pull-right dropdown-125 dropdown-lighter dropdown-caret">
                          <?php foreach ($group_teachers as $group_teacher_key => $group_teacher): ?>
                            <li <?php if ($group_teachers_default_teacher_key == $group_teacher_key ) { echo 'class="active"';} ?> >
                              <a href="#" 
                                <?php if ($group_teachers_default_teacher_key == $group_teacher_key ) { echo 'class="blue"';}?> >
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                <?php echo $group_teacher->sn1 . " " . $group_teacher->sn2 . ", " . $group_teacher->givenName; ?>
                              </a>
                            </li>      
                          <?php endforeach; ?>
                          </ul>
        </div>
      </div>
     
    </div>

  <div class="table-header">
    
    <i class="icon-group"></i> 
    
    <div class="inline position-relative">
              <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                            <?php echo $selected_department_name;?>
                            <i class="icon-angle-down icon-on-right bigger-110"></i>
                          </button>

                          <ul class="dropdown-menu pull-right dropdown-125 dropdown-lighter dropdown-caret">
                          <?php foreach ($departments as $department_key => $department): ?>
                            <li <?php if ($selected_department_key == $department_key ) { echo 'class="active"';} ?> >
                              <a href="#" 
                                <?php if ($selected_department_key == $department_key ) { echo 'class="blue"';}?> >
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                <?php echo $department; ?>
                              </a>
                            </li>      
                          <?php endforeach; ?>
                          </ul>
    </div>
    
    <i class="icon-double-angle-right"></i> 
    
    <div class="inline position-relative">
              <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" id="selected_classroom_group_id" selected_classroom_group_id="<?php echo $selected_classroom_group_key;?>">
                            <?php echo $selected_classroom_group_shortname;?>
                            <i class="icon-angle-down icon-on-right bigger-110"></i>
                          </button>

                          <ul class="dropdown-menu pull-right dropdown-125 dropdown-lighter dropdown-caret">
                          <?php foreach ($classroom_groups as $classroom_group_key => $classroom_group): ?>
                            <li <?php if ($selected_classroom_group_key == $classroom_group_key ) { echo 'class="active"';} ?> >
                              <a href="#" 
                                <?php if ($selected_classroom_group_key == $classroom_group_key ) { echo 'class="blue"';}?> >
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                <?php echo $classroom_group; ?>
                              </a>
                            </li>      
                          <?php endforeach; ?>
                          </ul>
    </div>

    <i class="icon-double-angle-right"></i> 
    
    <div class="inline position-relative">
              <button id="current_selected_study_module" study_module_id="<?php echo $selected_study_module_key ;?>" class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                            <?php echo $selected_study_module_shortname;?>
                            <i class="icon-angle-down icon-on-right bigger-110"></i>
                          </button>

                          <ul class="dropdown-menu pull-right dropdown-125 dropdown-lighter dropdown-caret">
                          <?php foreach ($study_modules as $study_module_key => $study_module): ?>
                            <li <?php if ($selected_study_module_key == $study_module_key ) { echo 'class="active"';} ?> >
                              <a href="#" 
                                <?php if ($selected_study_module_key == $study_module_key ) { echo 'class="blue"';}?> >
                                <i class="icon-caret-right bigger-110">&nbsp;</i>
                                <?php echo $study_module->name; ?>
                              </a>
                            </li>      
                          <?php endforeach; ?>
                          </ul>
    </div>

    <i class="icon-double-angle-right"></i>
    <button id="current_selected_lesson_id" lesson_id="<?php echo $selected_lesson_id ;?>" class="btn btn-minier btn-primary">
      <?php echo $selected_lesson_id;?>
    </button>
                           

    <i class="icon-user" style="margin-left:50px;"></i> Alumnes: <span title="Alumnes totals de tots els tipus"><?php echo " " . $total_number_of_students;?></span>  | <span title="Alumnes matrículats al grup"><?php echo " " . $official_students_in_group_num;?></span> | <span title="Alumnes ocultson"><?php echo " " . $hidden_students_in_group_num;?></span>

    <i class="icon-calendar" style="margin-left:50px;"></i> Data: <?php echo $days_of_week[$day_of_week_number] . " " . $check_attendance_date_alt;?>
    <a href="<?php echo base_url('/index.php/timetables/allgroupstimetables/' . $selected_classroom_group_key) ?>" style="text-decoration:none;color: inherit;"><i class="icon-calendar" style="margin-left:50px;"></i> Horari de grup</a>

    
</div><!-- TABLE HEADER END!-->

<?php //var_export($incidents); ?>

<div class="row-fluid">
 <table id="students_table" class="table table-striped table-bordered table-hover">
                  <thead> 
                    <tr>
                      <th>Foto</th>
                      <th title="Person Id">#</th>
                      <th title="Tipus">T</th>
                      <th title="Ocult">O</th>
                      <th>Primer cognom</th>
                      <th>Segon cognom</th>
                      <th>Nom</th>
                      <th>
                        <i class="icon-user"></i> User 
                      </th>  
                      <th>
                        <i>@</i> Email 
                      </th>  


                      <?php foreach ( $time_slots as $time_slot_key => $time_slot): ?>

                        <th <?php if ( $selected_time_slot_id == $time_slot->id ) { echo 'class="red"';}?> ><center>
                             <span data-rel="tooltip" title="<?php echo $time_slot->range;?>" <?php if ( $selected_time_slot_id == $time_slot->id ) { echo 'class="bigger-120"';}?>>
                               <?php if ( $selected_time_slot_id == $time_slot->id ):?>
                                    <i class="icon-check bigger-120"></i>
                               <?php endif; ?>
                               <?php echo $time_slot->hour;?>
                             </span>
                             <?php if (isset ($time_slot->study_module_id)): ?>
                              <p>
                               <span class="label <?php if ( array_key_exists ( $teacher_id , $time_slot->teachers ) ) { echo 'label-purple';};?>" data-rel="tooltip" 
                                title="<?php echo $time_slot->study_module_name . " ( " . $time_slot->study_module_id . " ). ";  foreach ($time_slot->teachers as $teacher_key => $teacher) {  echo $teacher->teacher_name . " ( " . $teacher->teacher_code . " ) ";}?>"
                                studymoduleid="<?php echo  $time_slot->study_module_id;?>" id="span_study_module_<?php echo  $time_slot->study_module_id;?>" ondblclick="study_module_onclick(this);">
                                <i class="icon-group bigger-120"></i><?php echo $time_slot->study_module_shortname;?>
                               </span>
                              </p>
                              <div class="btn-group" id="btn_group_<?php echo $time_slot->id;?>_<?php echo $time_slot->study_module_id;?>">

                               <?php if (is_array ($time_slot->study_submodules)): ?>  
                                <?php foreach ( $time_slot->study_submodules as $study_submodule_key => $study_submodule): ?>
                                 <button style="font-size: x-small;" id="btn_group_<?php echo $time_slot->id;?>_<?php echo $time_slot->study_module_id?>_<?php echo $study_submodule_key;?>" 
                                  class="btn btn-minier <?php if ($study_submodule->active) { echo 'btn-inverse'; } else { echo 'btn-grey'; }?>" data-rel="tooltip" 
                                  onclick="study_submodule_on_click(this,'btn_group_<?php echo $time_slot->id;?>_<?php echo $time_slot->study_module_id;?>',<?php echo $study_submodule_key;?>,<?php echo $time_slot->id;?>);"
                                  title="<?php echo $study_submodule->shortname . ". " . $study_submodule->name . " (" . $study_submodule_key . ") ( " . $study_submodule->startdate . " - " . $study_submodule->finaldate . " )";?>" >
                                  <?php echo $study_submodule->shortname;?> 
                                    <i class="icon-check bigger-120" id="btn_group_icon_<?php echo $time_slot->id;?>_<?php echo $time_slot->study_module_id?>_<?php echo $study_submodule_key;?>" style="display:<?php if($study_submodule->active) { echo 'inline'; } else { echo 'none'; } ;?>"></i>
                                 </button> 
                                <?php endforeach; ?>
                               <?php endif; ?> 

                              </div>
                             <?php endif; ?>                             
                        </th>  

                      <?php endforeach; ?>
                      
                      <th class="hidden-480">Observacions</th>
                      <th>Accions&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                  </thead>

                  <tbody>
                    
                    <?php foreach ($classroom_group_students as $student_key => $student): ?>

                    <?php $student_fullname = $student->givenName . " " . $student->sn1 . " " . $student->sn2;?>

                    <?php if ($student->official == true ) : ?>
                        <tr id = "student_tr_<?php echo $student->person_id;?>" official="true">        
                    <?php else : ?>            
                        <tr id = "student_tr_<?php echo $student->person_id;?>" official="false">
                    <?php endif; ?>                                
                       <td>
                        <a class="image-thumbnail" href="<?php echo base_url($student->photo_url)?>">
                         <img data-rel="tooltip" style="max-width:35px;";
                          title="<?php echo $student_fullname;?>" class="msg-photo" alt="<?php echo $student_fullname . "( " . $student->person_official_id . ")";?>" 
                          src="<?php echo base_url($student->photo_url)?>"/>
                        </a>
                      </td>
                      <td>
                        <a href="<?php echo base_url('/index.php/persons/index/read/' . $student->person_id );?>"><?php echo $student->person_id;?></a>
                      </td>
                      <td>
                        <?php if ($student->official == true ) : ?><span title="Alumne matrículat oficialment al grup">*</span><?php else: ?><span title="Alumne matrículat de UFs/UDs soltes o MPs/Crèdits solts">#</span><?php endif; ?>
                      </td>
                      <td>
                        <?php if ($student->hidden == true ) : ?>Sí<?php else: ?>No<?php endif;?>
                      </td>
                      <td>
                        <?php echo $student->sn1;?>
                      </td>
                      <td>
                        <?php echo $student->sn2;?>
                      </td>
                      <td>
                        <?php echo $student->givenName;?>
                      </td>
                      <td>
                        <div title="<?php echo $student->username . " ( " . $student->userid . ")";?>"><a href="<?php echo base_url('/index.php/users/index/read/' . $student->userid ) ;?>"><?php echo $student->username;?></a></div>
                      </td>
                      <td>
                        <?php echo $student->email;?>
                      </td> 

                      <?php foreach ( $time_slots as $time_slot_key => $time_slot): ?>

                        <td>
                          <?php //echo print_r($time_slot);?>

                          <?php if (isset ($time_slot->study_module_id)): ?>
                            <center>

                              <?php if (is_array($time_slot->study_submodules)): ?>
                                <?php foreach ($time_slot->study_submodules as $study_submodules_key => $study_submodule): ?>
                                  <?php 
                                  $select_id = $time_slot->id . "_" . $study_submodule->id . "_check_attendance_select_" . $student->person_id;
                                  $span_select_id = $time_slot->id . "_" . $study_submodule->id . "_check_attendance_span_" . $student->person_id;
                                  $icon_id = $time_slot->id . "_" . $study_submodule->id . "_check_attendance_icon_" . $student->person_id;
                                  $select_have_incident = false; 
                                  $current_incident_type = 0 ; 
                                  if (is_array($incidents)) {
                                    if ( array_key_exists ( $select_id, $incidents ) ){
                                      //echo "TEST: " . $incidents[$select_id]->type_code;
                                      $select_have_incident = true; 
                                      $current_incident_type = $incidents[$select_id]->type_code; 
                                      $current_incident_type_shortName = $incidents[$select_id]->type_shortName; 
                                      $current_incident_type_name = $incidents[$select_id]->type_name; 

                                      if ( ! $study_submodule->active) {
                                        //Study_module_not_active and there are incidents!
                                        $title = "Hi ha incidències a la UF/UD " . $study_submodule->shortname  . ". " . $study_submodule->name  . " (" . $study_submodule->id . ")";
                                        echo "<i class=\"icon-warning-sign red bigger-130\" title=\"" . $title . "\" id=\"" . $icon_id . "\"></i>";
                                      }
                                    
                                    } 
                                  }


                                  ?>
                                  <?php //DEBUG //echo "teacher_id: " . $teacher_id . " |||||  time slot teachers: " . var_export($time_slot->teachers) ?>

                                  <?php 
                                    $teacher_is_in_time_slot = array_key_exists($teacher_id, $time_slot->teachers);
                                    if($user_is_admin || $teacher_is_in_time_slot || $teacher_is_mentor): ?>
                                    <select studysubmoduleid="<?php echo $study_submodule->id;?>" id="<?php echo $select_id;?>" width="50" 
                                      onchange="check_attendance_select_on_click(this,<?php echo $student->person_id;?>,<?php echo $time_slot->id;?>,<?php echo $day_of_week_number;?>,'<?php echo $check_attendance_date_mysql_format?>')" 

                                      <?php if ($study_submodule->active): ?> 
                                        style="width: 50px;display:inline;"
                                      <?php else: ?>
                                        style="width: 50px;display:none;"
                                      <?php endif; ?>
                                      >

                                      <option value="0">--</option>
                                      <?php foreach ($incident_types as $incident_type_key => $incident_type): ?>

                                        <?php if ($select_have_incident && ( $current_incident_type == $incident_type->code)) : ?>
                                          <option value="<?php echo $incident_type->code; ?>" selected="selected"><?php echo $incident_type->shortname; ?></option>
                                        <?php else: ?>
                                          <option value="<?php echo $incident_type->code; ?>"><?php echo $incident_type->shortname; ?></option>
                                        <?php endif; ?>                                
                                        
                                      <?php endforeach;?> 
                                    </select>

                                  <?php else: ?>

                                      <span studysubmoduleid="<?php echo $study_submodule->id;?>" id="<?php echo $span_select_id;?>" title="<?php if ( isset($current_incident_type_name) ) { echo $current_incident_type_name; } else { echo "No hi ha cap incidència";}?>"
                                        
                                        <?php if ($study_submodule->active): ?> 
                                          style="width: 50px;display:inline;"
                                        <?php else: ?>
                                          style="width: 50px;display:none;"
                                        <?php endif; ?>
                                        >
                                        <?php 
                                        if ($select_have_incident) {
                                          echo $current_incident_type_shortName;
                                        } else {
                                          echo "--";
                                        }
                                        ?>
                                          
                                      </span>

                                  <?php endif; ?>

                                  

                                <?php endforeach; ?>
                              <?php endif; ?>
                            <?php if ( $selected_time_slot_id == $time_slot->id ):?>
                              <i class="icon-star red smaller-80"></i>      
                            <?php endif; ?>
                            </center>
                          <?php else: ?>                          
                              <center><i class="icon-remove gray smaller-80"></center></i>
                          <?php endif; ?>

                        </td>                        

                      <?php endforeach; ?>

                      <td class="hidden-480">
                        <textarea id="comments" class="autosize-transition span12" rows="1">Pendent</textarea>
                      </td>

                      <td>
                        <div class="hidden-phone visible-desktop action-buttons">
                          <a class="blue" href="<?php echo base_url('/index.php/enrollment/enrollment_query_by_person/false/' . $student->person_official_id);?>" target="_blank">
                              <i class="icon-zoom-in bigger-130" title="Consulta matrícula"></i>
                          </a>

                          <a class="orange" href="<?php echo base_url('/index.php/attendance/mentoring_attendance_by_student/' . $academic_period_id . '/' . $student->person_id . '/' . $selected_classroom_group_key);?>" target="_blank">
                            <i class="icon-bell bigger-130" title="Consulta incidències"></i>
                          </a>

                          <?php if ( $user_is_admin ) : ?>
                          <a class="green" href="#">
                            <i class="icon-pencil bigger-130"></i>
                          </a>
                          <?php endif;?>
                            <?php if ($student->hidden == true ) : ?>
                              <a class="red" href="#" title="Mostrar alumne" action="unhide" day="<?php echo $day_of_week_number;?>" academic_period_id="<?php echo $academic_period_id;?>" teacher="<?php echo $teacher_id;?>" classroomgroupid="<?php echo $selected_classroom_group_key;?>" person_id="<?php echo $student->person_id;?>" id="hide_student_id_<?php echo $student->person_id;?>" onclick="event.preventDefault();click_on_hidden_student(this);">
                                <i class="icon-eye-open bigger-130"></i>
                              </a>  
                            <?php else: ?>
                              <a class="purple" href="#" action="hide" day="<?php echo $day_of_week_number;?>" academic_period_id="<?php echo $academic_period_id;?>" teacher="<?php echo $teacher_id;?>" classroomgroupid="<?php echo $selected_classroom_group_key;?>" person_id="<?php echo $student->person_id;?>" id="hide_student_id_<?php echo $student->person_id;?>" onclick="event.preventDefault();click_on_hidden_student(this);">
                                <i class="icon-eye-close bigger-130" title="Amagar alumne"></i>
                              </a> 
                            <?php endif;?>
                            
                          </a>
                        </div>

                        <div class="hidden-desktop visible-phone">
                          <div class="inline position-relative">
                            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                              <i class="icon-caret-down icon-only bigger-120"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                              <li>
                                <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
                                  <span class="blue">
                                    <i class="icon-zoom-in bigger-120"></i>Pendent
                                  </span>
                                </a>
                              </li>

                              <li>
                                <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                  <span class="green">
                                    <i class="icon-edit bigger-120"></i>
                                  </span>
                                </a>
                              </li>

                              <li>
                                <a href="#" class="tooltip-error" data-rel="tooltip" title="Ocultar">
                                  <span class="red">
                                    <i class="icon-eye-close bigger-120"></i>
                                  </span>
                                </a>
                              </li>
                            </ul>
                          </div>
                        </div>

                      </td>
                    </tr>
                    <?php endforeach;?>
                  </tbody>
  </table>                
 </div>
 
 <div class="space-30"/>

</div>
</div>
</div>
<script type="text/javascript">

var oTable1;

function click_on_hidden_student(element) {
  var person_id = element.getAttribute("person_id");
  var classroom_group_id = element.getAttribute("classroomgroupid");
  var teacher_id = element.getAttribute("teacher");
  var academic_period_id = element.getAttribute("academic_period_id");
  var action = element.getAttribute("action");
  var day = element.getAttribute("day");

  //DEBUG:
  //console.debug("person_id: " + person_id);
  //console.debug("classroom_group_id: " + classroom_group_id);
  //console.debug("teacher_id: " + teacher_id);
  //console.debug("academic_period_id: " + academic_period_id);
  //console.debug("action: " + action);
  //console.debug("day: " + day);

  //AJAX: hide/unhide student on database:
  //AJAX TO HIDE STUDENT
  $.ajax({
      url:'<?php echo base_url("/index.php/attendance/hide_unhide_student_on_classroom_group_and_day");?>',
      type: 'post',
      data: {
          person_id : person_id,
          classroom_group_id : classroom_group_id,
          teacher_id : teacher_id,
          academic_period_id : academic_period_id,
          action : action,
          day : day,
      },
      datatype: 'json',
      statusCode: {
        404: function() {
          $.gritter.add({
            title: 'Error connectant amb el servidor!',
            text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/attendance/hide_unhide_student_on_classroom_group_and_day ' ,
            class_name: 'gritter-error gritter-center'
          });
        },
        500: function() {
          $("#response").html('A server-side error has occurred.');
          $.gritter.add({
            title: 'Error connectant amb el servidor!',
            text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/attendance/hide_unhide_student_on_classroom_group_and_day' ,
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

      //RELOAD PAGE
       location.reload();       

    });


  
}

function study_module_onclick(element) {
    id = element.id;
    //console.debug("id:" + id);
    studymoduleid = $("#"+id).attr("studymoduleid");  
    //console.debug("studymoduleid:" + studymoduleid);
    window.open(
      '<?php echo base_url();?>index.php/managment/study_submodule_dates/' + studymoduleid ,
      '_blank' // <- This is what makes it open in a new window.
    );
}

function check_attendance_select_on_click(element,person_id,time_slot_id,day,date){
  id = element.id;
  study_submodule_id = $("#"+id).attr("studysubmoduleid");
  selected_value = $("#"+id).val();
  previous_selected_value = $("#"+id).val();

  //DEBUG INFO:
  /*console.debug("check_attendance_select_on_click!!!");
  console.debug("id: " + id);
  console.debug("person_id: " + person_id);
  console.debug("time_slot_id: " + time_slot_id);
  console.debug("day: " + day);  
  console.debug("date: " + date);  
  console.debug("study_submodule_id: " + study_submodule_id);
  console.debug("selected_value: " + selected_value);
  */
  //AJAX
  $.ajax({
    url:'<?php echo base_url("/index.php/attendance/crud_incidence");?>',
    type: 'post',
    data: {
        person_id : person_id,
        time_slot_id : time_slot_id,
        day : day,
        date : date,
        study_submodule_id: study_submodule_id,
        absence_type : selected_value  
    },
    datatype: 'json',
    statusCode: {
      404: function() {
        $.gritter.add({
          title: 'Error connectant amb el servidor!',
          text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/attendance/crud_incidence ' ,
          class_name: 'gritter-error gritter-center'
        });
      },
      500: function() {
        $("#response").html('A server-side error has occurred.');
        $.gritter.add({
          title: 'Error connectant amb el servidor!',
          text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/attendance/crud_incidence ' ,
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
        title: 'Error guardant la incidència a la base de dades!',
        text: 'No s\'ha pogut guardar la incidència. Missatge d\'error:  ' + result_message ,
        class_name: 'gritter-error'
      });
    }

  });




}

function study_submodule_change(study_submodule_button, study_module_button_id, study_submodule_id, time_slot_id) {

  $('#' + study_module_button_id).children('button').each(function () {
      //console.debug(this.id); // "this" is the current element in the loop
      button_id = this.id;
      if ( button_id == id ) {
        $('#' + button_id).removeClass('btn-grey');
        $('#' + button_id).addClass('btn-inverse');
        $('#' + button_id).children('i').show();
      } else {
        $('#' + button_id).removeClass('btn-inverse');
        $('#' + button_id).addClass('btn-grey');
        $('#' + button_id).children('i').hide();
      }
    });

    //Hide all current visible selects
    $("select[id^=" + time_slot_id +"]:visible").each(function (i,select) {
      select_id = select.id;
      //console.debug("select_id previous: " + select_id);
      //Hide all current selects
      $('#' + select_id).toggle();
    });

    //SHOW ALL NEW STUDY_SUBMODULE SELECTS:
    $("select[id^=" + time_slot_id + "_" + study_submodule_id +"]").each(function (i,select) {
      select_id = select.id;
      //console.debug("New select_id: " + select_id);
      //Hide all current selects
      $('#' + select_id).toggle();
    });

    //Hide all current visible spans
    $("span[id^=" + time_slot_id +"]:visible").each(function (i,select) {
      select_id = select.id;
      //console.debug("select_id previous: " + select_id);
      //Hide all current selects
      $('#' + select_id).toggle();
    });

    //SHOW ALL NEW STUDY_SUBMODULE spans:
    $("span[id^=" + time_slot_id + "_" + study_submodule_id +"]").each(function (i,select) {
      select_id = select.id;
      //console.debug("New select_id: " + select_id);
      //Hide all current selects
      $('#' + select_id).toggle();
    });

    //Show all icons of same time_slot
    $("i[id^=" + time_slot_id +"]").each(function (i,select) {
      select_id = select.id;
      //console.debug("New select_id: " + select_id);
      //Hide all current selects
      $('#' + select_id).show();
    });

    //hide all icons of same study_module_id and time_slot
    $("i[id^=" + time_slot_id + "_" + study_submodule_id +"]").each(function (i,select) {
      select_id = select.id;
      //console.debug("New select_id: " + select_id);
      //Hide all current selects
      $('#' + select_id).hide();
    });

}


function study_submodule_on_click(study_submodule_button, study_module_button_id, study_submodule_id, time_slot_id) {
  //console.debug("click on study_submodule_on_click!");
  id = study_submodule_button.id;
  
  //console.debug("study_submodule_id: " + study_submodule_id);

  //Search for existing incidents on study submodule siblings:
  exists_incidents_on_study_submodule_siblings = false;
  $("select[id^=" + time_slot_id +"]:visible").each(function (i,select) {
    select_id = select.id;
    value = $('#' + select_id).val();
    if (value != 0) {
      exists_incidents_on_study_submodule_siblings = true;
    }
  });

  if (exists_incidents_on_study_submodule_siblings){
    var r = confirm("Esteu segurs que voleu canviar d'UF/UD? Ja hi ha faltes d'assistència posades per una altra UF/UD! Normalment abans voldreu esborrar les incidències de l'altra UF/UD...");
    if (r == true) {
      study_submodule_change(study_submodule_button, study_module_button_id, study_submodule_id, time_slot_id);
    } else {
      return false;
    }  
  } else {
    study_submodule_change(study_submodule_button, study_module_button_id, study_submodule_id, time_slot_id);
  }
}

$.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ) {

        var checkbox_show_all_group_enrolled_students_selected = $("#checkbox_show_all_group_enrolled_students").prop('checked');
        var checkbox_show_all_students_selected = $("#checkbox_show_all_students").prop('checked');
        var checkbox_show_hidden_students_selected = $("#checkbox_show_hidden_students").prop('checked');

        //DEBUG:
        //console.debug("checkbox_show_all_group_enrolled_students_selected: " + checkbox_show_all_group_enrolled_students_selected);
        //console.debug("checkbox_show_all_students_selected: " + checkbox_show_all_students_selected);
        //console.debug("checkbox_show_hidden_students_selected: " + checkbox_show_hidden_students_selected);
        
        //GET COLUMN TYPE
        
        var student_type = aData[2];
        var student_hidden = aData[3];
        
        //DEBUG:
        //var sn1 = aData[4];
        //var sn2 = aData[5];
        //var givenName = aData[6];

        //console.debug("student: " + sn1 + " " + sn2 + ", " + givenName);
        //console.debug("student_type: " + student_type);
        //console.debug("student_hidden: " + student_hidden);

        student_type_text = jQuery(student_type).text();

        //console.debug("student_type_text: " + student_type_text);
        
        if (checkbox_show_all_group_enrolled_students_selected) {
          if (student_type_text == "*") {
            if (checkbox_show_hidden_students_selected) {
              return true;
            } else {
              if (student_hidden == "No") {
                return true;
              }
            }
          }
        }

        if (checkbox_show_all_students_selected) {
          if (student_type_text == "#") {
            if (checkbox_show_hidden_students_selected) {
              return true;
            } else {
              if (student_hidden == "No") {
                return true;
              }
            }
          }
        }

        return false;
       
    }
);

jQuery(function($) {

        var students_with_errors_num = <?php echo $students_with_errors_num;?>;

        if (students_with_errors_num > 0 ) {
          alert ("Atenció! Hi ha alumnes amb dades inconsistents o errors de matrícula. Consulteu la llista d'alumnes amb errors i informeu al administrador del sistema!");
        }


        //Check filters an show only students according to filters

        var checkbox_show_all_group_enrolled_students_selected = $("#checkbox_show_all_group_enrolled_students").prop('checked');
        var checkbox_show_all_students_selected = $("#checkbox_show_all_students").prop('checked');
        
        //By default not show hidden usersº
        //var checkbox_show_hidden_students_selected = $("#checkbox_show_hidden_students").prop('checked');

        //$(".check_attendance_select2").select2({placeholder: "Select report type", allowClear: true});

        number_of_time_slots = <?php echo count($time_slots);?>;
        console.debug("number_of_time_slots: " + number_of_time_slots);

        var datatables_columns = [{ "bSortable": false },{"bVisible": false},{ "sType": "html","type": "html"},null,null,null,null,{"bVisible": false},{"bVisible": false}]; 
        
        for (i = 0; i < number_of_time_slots; i++) {
          datatables_columns.push({ "bSortable": false });
        }
        
        datatables_columns.push(null);
        datatables_columns.push({ "bSortable": false });

        console.debug(datatables_columns);

        oTable1 = $('#students_table').DataTable( {
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
                                              "sMessage": "<center><h2>Llistat de faltes</h2></center>",
                                              "sInfo": "<h6>Vista impressió</h6><p>Si us plau utilitzeu l'opció d'imprimir del vostre navegador (Ctrl+P) per "+
                                                       "imprimir. Feu clic a la tecla Esc per tornar.",
                                      },
                              ]

              },
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
        "aoColumns": datatables_columns 
        });

        $("#checkbox_show_all_group_enrolled_students").change(function() {
          oTable1.fnDraw();
        });

        $("#checkbox_show_all_students").change(function() {
          oTable1.fnDraw();
        });

        $("#checkbox_show_all_students_selected").change(function() {
          oTable1.fnDraw();
        });

        $("#checkbox_show_hidden_students").change(function() {
          oTable1.fnDraw();
        });


  $('.date-picker').datepicker({
          format: "dd/mm/yyyy",
          weekStart: 1,
          todayBtn: true,
          language: "ca",
          daysOfWeekDisabled: "0,6",
          autoclose: true,
          todayHighlight: true
          }).next().on(ace.click_event, function(){
          $(this).prev().focus();
        });

  $('[data-rel=tooltip]').tooltip();
  //$('[data-rel=popover]').popover({html:true});        

  //Jquery select plugin: http://ivaynberg.github.io/select2/
  //"#time_slots").select2();  

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
        teacher_code = $("#teachers").select2("val");
        selected_date = $('.input-append.date').datepicker('getDate');
        day=selected_date.getDate();
        month = parseInt(selected_date.getMonth());
        converted_month = month +1 ;
        year=selected_date.getFullYear();
        formated_selectedDate = day + "/" + converted_month + "/" + year;

        /*
        alert ( "Day: " + day);
        alert ( "Month: " + converted_month );
        alert ( "Year: " + year);
        */

        //var pathArray = window.location.pathname.split( '/' );
        //var secondLevelLocation = pathArray[1];
        //var  baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/check_attendance";
        //alert(baseURL + "/" + selectedValue);
        //window.location.href = baseURL + "/" + teacher_code + "/" + formated_selectedDate;
    });
        
  })

  $("#datepicker").change(function(){
    
    selected_classroom_group_id  = $("#selected_classroom_group_id").attr("selected_classroom_group_id");
    selected_teacher_code  = $("#current_selected_teacher").attr("teacher_code");
    selected_study_module_id  = $("#current_selected_study_module").attr("study_module_id");
    selected_lesson_id  = $("#current_selected_lesson_id").attr("lesson_id");
    selected_date = $("#datepicker").val();
    selected_time_slot_id = $("#time_slots_select").val();

    //DEBUG:
    /*
    console.debug("selected_classroom_group_id: " + selected_classroom_group_id);
    console.debug("selected_teacher_code: " + selected_teacher_code);
    console.debug("selected_study_module_id: " + selected_study_module_id);
    console.debug("selected_lesson_id: " + selected_lesson_id);
    console.debug("Data changed to: " + selected_date);
    */

    console.debug("selected_time_slot_id: " + selected_time_slot_id);

    var pathArray = window.location.pathname.split( '/' );
    var secondLevelLocation = pathArray[1];
    var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/check_attendance_classroom_group";
    
    //alert(baseURL + "/" + selected_classroom_group_id + "/" + selected_teacher_code +  "/" + selected_study_module_id +  "/" + selected_lesson_id +  "/" + selected_date + "/" + selected_time_slot_id);
    
    window.location.href = baseURL + "/" + selected_classroom_group_id + "/" + selected_teacher_code +  "/" + selected_study_module_id +  "/" + selected_lesson_id +  "/" + selected_date + "/" + selected_time_slot_id;


  });

  $("#time_slots_select").change(function(){
    
    selected_classroom_group_id  = $("#selected_classroom_group_id").attr("selected_classroom_group_id");
    selected_teacher_code  = $("#current_selected_teacher").attr("teacher_code");
    selected_study_module_id  = $("#current_selected_study_module").attr("study_module_id");
    selected_lesson_id  = $("#current_selected_lesson_id").attr("lesson_id");
    selected_date = $("#datepicker").val();
    selected_time_slot_id = $("#time_slots_select").val();

    //DEBUG:
    /*
    console.debug("selected_classroom_group_id: " + selected_classroom_group_id);
    console.debug("selected_teacher_code: " + selected_teacher_code);
    console.debug("selected_study_module_id: " + selected_study_module_id);
    console.debug("selected_lesson_id: " + selected_lesson_id);
    console.debug("Data changed to: " + selected_date);
    */
    console.debug("selected_time_slot_id: " + selected_time_slot_id);

    var pathArray = window.location.pathname.split( '/' );
    var secondLevelLocation = pathArray[1];
    var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/attendance/check_attendance_classroom_group";
    
    //alert(baseURL + "/" + selected_classroom_group_id + "/" + selected_teacher_code +  "/" + selected_study_module_id +  "/" + selected_lesson_id +  "/" + selected_date);
    
    window.location.href = baseURL + "/" + selected_classroom_group_id + "/" + selected_teacher_code +  "/" + selected_study_module_id +  "/" + selected_lesson_id +  "/" + selected_date + "/" + selected_time_slot_id


  });

  
  $('.image-thumbnail').fancybox(); 

</script>
