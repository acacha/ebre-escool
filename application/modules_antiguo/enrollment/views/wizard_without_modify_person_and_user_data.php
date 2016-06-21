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
      <li class="active"><?php echo lang('enrollment');?></li>
    </ul>
  </div><!-- /breadcrumbds -->

  <!-- Page Header -->
  <div class="page-header position-relative">
    <h1>
      <?php echo lang("enrollment");?>
      <small>
        <i class="icon-double-angle-right"></i>
        <?php echo lang('wizard_without_modify_person_and_user_data');?>
      </small>
    </h1>
  </div><!-- /.page-header -->	

  <div style='height:10px;'></div>  
  <div style="margin:10px;">

    <!-- PAGE CONTENT BEGINS -->
    <div class="row-fluid">
      <div class="widget-box">
        <div class="widget-header widget-header-blue widget-header-flat">
          <h4 class="lighter"><?php echo lang('new_enrollment');?></h4> <i class="icon-double-angle-right"></i>

              <span name="step0_title" id="enrollment_breadcump_step1_student" class="step1_student green">
                <small>
                  <b><?php echo lang("enrollment_student_personal_data");?></b>
                </small>
              </span>
              </span>
              <span name="step1_title" id="enrollment_breadcrump_step2_selected_academic_period" class="step2_selected_academic_period"></span>
              <span name="step2_title" id="enrollment_breadcrump_step3_selected_study" class="step3_selected_study"></span>                
              <span name="step3_title" id="enrollment_breadcrump_step4_selected_course" class="step4_selected_course"></span>
              <span name="step4_title" id="enrollment_breadcrump_step5_selected_classroom_group" class="step5_selected_classroom_group"></span>                            
              <span name="step5_title" id="enrollment_breadcrump_step6_selected_study_module" class="step6_selected_study_module"></span>
              <span name="step6_title" id="enrollment_breadcrump_step7_selected_study_submodule" class="step7_selected_study_submodule"></span>
              
          <div class="widget-toolbar">
            <label>
              <small class="green">
                <b><?php echo lang('validation');?></b>
              </small>
              <input id="skip-validation" type="checkbox" class="ace ace-switch ace-switch-4" checked="checked" />
              <span class="lbl"></span>
            </label>
          </div>
        </div> <!-- /widget-header -->

        <div class="widget-body">
          <div class="widget-main">
            <div id="fuelux-wizard" class="row-fluid" data-target="#step-container">
              <ul class="wizard-steps">

                <li data-target="#step0" class="active">
                  <span class="step">0</span>
                  <span class="title"><?php echo lang('student');?></span>
                </li>

                <li data-target="#step1">
                  <span class="step">1</span>
                  <span class="title" id="fuelux-wizard_step1_title"><?php echo lang('enrollment_academic_period');?></span>
                </li>

                <li data-target="#step2">
                  <span class="step">2</span>
                  <span class="title" id="fuelux-wizard_step2_title"><?php echo lang('enrollment_studies');?></span>
                </li>

                <li data-target="#step3">
                  <span class="step">3</span>
                  <span class="title" id="fuelux-wizard_step3_title"><?php echo lang('enrollment_courses');?></span>
                </li>

                <li data-target="#step4">
                  <span class="step">4</span>
                  <span class="title" id="fuelux-wizard_step4_title"><?php echo lang('enrollment_classgroups');?></span>
                </li>

                <li data-target="#step5">
                  <span class="step">5</span>
                  <span class="title" id="fuelux-wizard_step5_title"><?php echo lang('enrollment_modules');?></span>
                </li>

                <li data-target="#step6">
                  <span class="step">6</span>
                  <span class="title" id="fuelux-wizard_step6_title"><?php echo lang('enrollment_submodules');?></span>
                </li>
              </ul>
            </div> <!-- /fuelux-wizard -->

            <hr />

            <div class="step-content row-fluid position-relative" id="step-container">

<!--  
STEP 0 - STUDENT DATA
-->                
              <div class="step-pane active" id="step0">

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
                              <!-- PAGE CONTENT BEGINS -->
                              <div>
                                <div id="user-profile-1" class="user-profile row-fluid">
                                  
                                  <!-- AVATAR -->
                                  <div class="span3 center">
                                    
                                    <div class="span2"></div>
                                    <div class="span8 center">
                                      <div class="space-4"></div>
                                      
                                      <!-- Student Photo -->
                                      <div id="student_photo">
                                        <span class="profile-picture">
                                          <img id="avatar" style="height: 150px;" class="editable img-responsive editable-click" src="<?php echo base_url('assets/img/alumnes').'/foto.png';?>" alt="photo" />
                                          <input id="person_photo" name="person_photo" type="hidden" />  
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


                                      <!-- TIPUS DE DOCUMENT -->

                                      <div class="span12">
                                        <label>&nbsp;</label>
                                        <input class="span12" name="person_id" type="hidden" readonly="true"/>  
                                      </div>                                      

                                      <div class="span7">
                                        <div class="span2">
                                          <input type="radio" name="official_id_type" id="rb_is_dni" value="1" readonly="true" ><span><?php echo lang('wizzard_official_DNI');?>&nbsp;</span>
                                        </div>
                                        <div class="span2">
                                          <input type="radio" name="official_id_type" value="2" readonly="true"><span><?php echo lang('wizzard_official_NIE');?>&nbsp;</span>
                                        </div>
                                        <div class="span4">
                                          <input type="radio" name="official_id_type" value="3" readonly="true"><span><?php echo lang('wizzard_official_passport');?>&nbsp;</span>
                                        </div>
                                        
                                        <?php if ( $user_is_admin ) : ?>
                                          <span id="user_database_info"></span>
                                        <?php endif; ?>

                                      </div>
                                      <!-- /TIPUS DE DOCUMENT -->                               
                                    <!-- DNI / TIS -->
                                    <div class="space-20"></div>                                    
                                    <div class="space-6"></div>
                                    <div class="span11" >
                                      <div class="form-group control-group">  
                                        <div class="span5" >                                  
                                          <label id="lbl_student_official_id" for="student_official_id" class="control-label no-padding-right"><?php echo lang('wizzard_official_DNI');?>&nbsp;</label>
                                          <div class="controls">
                                            <input type="text" id="student_official_id" name="student_official_id" placeholder="Escriu el <?php echo lang('wizzard_official_DNI');?>" />
                                          </div>
                                        </div>
                                      </div>  

                                      <div class="form-group control-group">                                        
                                        <div class="span5">
                                          <label class="control-label" for="person_secondary_official_id"><?php echo lang('wizzard_secondary_official_id');?>&nbsp;</label>
                                          <input type="text" name="person_secondary_official_id" placeholder="Escriu el nº TSI" readonly="true"/>
                                        </div>
                                      </div>  
                                    </div>
                                    
                                    
                                    <!-- /DNI / TIS --> 
                                  </div>

                                  <div class="span11">
                                    <div class="span4">
                                        <div class="control-group">
                                          <label class="control-label" for="student_givenName"><?php echo lang('wizzard_givenName');?></label>

                                          <div class="controls">
                                             <input id="givenName" type="text" name="person_givenName" placeholder="Escriu un nom d'alumne" readonly="true"/>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <div class="control-group">
                                          <label class="control-label"><?php echo lang('wizzard_sn1');?></label>

                                          <div class="controls">
                                             <input id="sn1" type="text" name="person_sn1" placeholder="Escriu el Primer Cognom" readonly="true"/>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                      <label class="control-label" for="student_sn2"><?php echo lang('wizzard_sn2');?>&nbsp;</label>
                                      <input id="sn2" type="text" name="person_sn2" placeholder="Escriu el Segon Cognom" readonly="true"/>
                                    </div>
                                  </div>
                                  
                                  <div class="span11" >
                                    <div class="span3">
                                      <label class="control-label" for="student_username">Username:&nbsp;</label>
                                      <input id="username" type="text" name="person_username" placeholder="Username" readonly="true" />                                    
                                    </div>
                                    
                                    <div class="span3">
                                        <label id="generated_password_label" class="control-label" for="student_generated_password">Paraula de pas autogenerada:&nbsp;</label>
                                        <input id="generated_password" type="text" name="person_generated_password" placeholder="Generated Password" readonly="true" />
                                    </div>
                                    <div class="span3">
                                      <div class="control-group">
                                        <label class="control-label" for="student_password">Paraula de pas:&nbsp;</label>
                                        <div class="controls">
                                          <input type="password" name="person_password" id="person_password" placeholder="Password" readonly="true"/>
                                        </div>    
                                      </div>  
                                    </div>
                                    <div class="span3">
                                      <div class="control-group">
                                        <label class="control-label" for="student_verify_password">Verificació de la paraula de pas:&nbsp;</label>
                                        <div class="controls">
                                          <input type="password" name="person_verify_password" placeholder="Verify Password" readonly="true"/>
                                        </div>    
                                      </div>    
                                    </div>                                    
                                  </div>                                  
                            
                                  <div class="span11" >
                                    <div class="span3">
                                      <label class="control-label" for="student_telephoneNumber"><?php echo lang('wizzard_telephoneNumber');?>&nbsp;</label>
                                      <div class="input-prepend">                         
                                        <span class="add-on">
                                          <i class="icon-phone"></i>
                                        </span>
                                        <input type="text" name="person_telephoneNumber" id="person_telephoneNumber" placeholder="Escriu el telèfon fixe" readonly="true"/>                          
                                      </div>
                                    </div>
                                    
                                    <div class="span3">
                                      <label class="control-label" for="student_mobile"><?php echo lang('wizzard_mobile');?>&nbsp;</label>  
                                      <div class="input-prepend">                         
                                        <span class="add-on">
                                          <i class="icon-phone"></i>
                                        </span>                                     
                                        <input type="text" name="person_mobile" placeholder="Escriu el telèfon mòbil" readonly="true"/>                      
                                      </div>
                                    </div>
                                    <div class="span3">
                                      <div class="control-group">
                                        <label class="control-label" for="student_email"><?php echo lang('wizzard_email');?>&nbsp;</label>    
                                        <div class="controls">                      
                                          <input type="text" id="person_email" name="person_email" readonly="readonly" value="@<?php echo $this->config->item('default_emaildomain');?>" readonly="true"/>                         
                                        </div>  
                                      </div>  
                                    </div>
                                     <div class="span3">
                                      <div class="control-group">
                                        <label class="control-label" for="student_email"><?php echo lang('wizzard_personal_email');?>&nbsp;</label>    
                                        <div class="controls">                      
                                          <input type="text" name="person_secondary_email" id="person_secondary_email" placeholder="Correu electrònic personal" readonly="true"/>                         
                                        </div>  
                                      </div>  
                                    </div>
                                  </div>

                                  <div class="span11" >
                                    <div class="span7">
                                      <label class="control-label" for="student_homePostalAddress"><?php echo lang('wizzard_homePostalAddress');?>&nbsp;</label>
                                      <input class="span12" type="text" name="person_homePostalAddress" placeholder="Escriu l'Adreça" readonly="true"/>                          
                                    </div>
                                    <div class="span5">
                                      <div class="span4">
                                        <label class="control-label" for="student_postal_code"><?php echo lang('wizzard_postal_code');?>&nbsp;</label> 
                                        <input class="span12 input-mask-postalcode" type="text" name="postalcode_code" id="postalcode_code" placeholder="Escriu el codi postal" value="<?php echo $this->config->item('default_postalcode');?>" readonly="true"/>
                                      </div>  
                                      <div class="span8">
                                        <label class="control-label" for="student_locality"><?php echo lang('wizzard_locality_name');?>&nbsp;</label>
                                        <select id="person_locality_id" name="person_locality_id" class="select2 span4" data-placeholder="Escriu la població" style="width:300px" readonly="true">
                                          <? foreach($localities as $locality): ?>
                                          <option id="locality_postal_code_<?php echo $locality['locality_postal_code'];;?>" value="<?php echo $locality['locality_id']; ?>" <?php if ( $this->config->item('default_locality_id') == $locality['locality_id'] ) { echo "selected=\"selected\""; } ;?> ><?php echo $locality['locality_name']; ?></option>
                                          <? endforeach; ?>
                                        </select>

                                      </div>                            
                                    </div>                                    
                                  </div>

                                  <div class="span6" >
                                    <div class="span6">
                                      <label class="control-label" for="student_date_of_birth"><?php echo lang('wizzard_date_of_birth');?>&nbsp;</label>
                                      <div class="input-prepend">
                                        <span class="add-on">
                                         <i class="icon-calendar bigger-110"></i>
                                        </span> 
                                        <input class="form-control date-picker span11 input-mask-date" type="text" name="person_date_of_birth" placeholder="Escriu la Data de naixement" data-date-format="dd-mm-yyyy" readonly="true"/>                                                                    
                                      </div>  
                                    </div>
                                    <label for="Tipus" >Sexe</label>
                                    <div class="span6">
                                      <div class="span4">
                                        <label>
                                          <input name="sexe" type="radio" class="ace" value="M" checked="checked" readonly="true"/>
                                          <span class="lbl"> Home</span>
                                        </label>                                      
                                      </div>
                                      <div class="span4">
                                        <label>
                                          <input name="sexe" type="radio" class="ace" value="F"/ readonly="true">
                                          <span class="lbl"> Dona</span>
                                        </label>                                      
                                      </div>
                                    </div>                                  
                                  </div>
                                </div>
                                <!-- PAGE CONTENT ENDS -->
                              </div><!-- /.span -->
                            </div>
                          </div><!-- /.row-fluid -->

                        </form>




                      </div>  
                    </div>

                        
                        
                      
              </div><!-- /step0 -->

<!--  
STEP 1 - ACADEMIC PERIOD AND STUDENT
-->
              <div class="step-pane" id="step1">

                <!-- !!! PREVIOUS ENROLLMENT WIDGET BOX!!!! --> 
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4><?php echo "Matrícules anteriors"?></h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">

                      <!-- !!! PREVIOUS ENROLLMENT PERIODS!!!! --> 
                      <table class="table table-striped table-bordered table-hover table-condensed" id="previous_enrollments">
                       <thead style="background-color: #d9edf7;">
                        <tr> 
                           <th>Id</th>
                           <th>Període acadèmic</th>
                           <th>Estudi</th>
                           <th>Curs</th>
                           <th>Grup de classe</th>
                        </tr>
                       </thead>
                      </table> 
                      <!-- !!! END PREVIOUS ENROLLMENT PERIODS!!!! --> 



                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->  
                </div><!-- -/widget-box -->    
                <!-- !!! END PREVIOUS ENROLLMENT WIDGET BOX!!!! --> 

                <div class="widget-box ">
                  <div class="widget-header">
                    <h4><?php echo lang("enrollment_academic_period_title")?></h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
                      <form class="form-horizontal" id="validation-form" method="get">
                        <!-- Academic Period -->
                        <label class="control-label" for="academic_period"><?php echo lang('academinc_period'); ?>:&nbsp;&nbsp;</label>
                        <select id="academic_period" name="academic_period" class="select2" >
                          <? foreach($this->config->item('academic_periods') as $key => $periode): ?>
                          <option value="<?php echo $key; ?>" <?php if($periode == $this->config->item('current_period')){ ?> selected <?php } ?> ><?php echo $periode; ?></option>
                          <? endforeach; ?>
                        </select>
                        <br />
                        <br />
                         <!-- Student -->
                        <label class="control-label" for="student"><?php echo lang('student'); ?>:&nbsp;&nbsp;</label>
                        <select id="student" name="student" class="select2" data-placeholder="Selecciona un estudiant..." style="width:500px;">
                          <option value=""></option>
                          <? foreach($enrollment_students as $enrollment_student): ?>
                           <option value="<?php echo $enrollment_student['student_person_id'];?>">
                            <?php echo $enrollment_student['person_official_id'] . ". " . $enrollment_student['student_fullName'] . " (". $enrollment_student['student_person_id'].")"; ?>
                           </option>
                          <? endforeach; ?>
                        </select>
                           <?php echo lang("enrollment_total_students");?>: <?php echo count($enrollment_students);?>
                        <div class="space-2"></div>
                      </form>
                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->  
                </div><!-- -/widget-box -->                         
              </div><!-- /step1 -->
<!--  
STEP 2 - ALL STUDIES
-->                
              <div class="step-pane" id="step2">

                <!-- !!! SIMULTANEOUS STUDIES WIDGET BOX!!!! --> 
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4><?php echo "Estudis simultànis"?></h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">

                      <!-- !!! SIMULTANEOUS STUDIES!!!! --> 
                      <table class="table table-striped table-bordered table-hover table-condensed" id="simultaneous_studies">
                       <thead style="background-color: #d9edf7;">
                        <tr> 
                           <th>Període</th>
                           <th>Estudi</th>
                           <th>Curs</th>
                           <th>Grup de classe</th>
                        </tr>
                       </thead>
                      </table> 
                      <!-- !!! END SIMULTANEOUS STUDIES PERIODS!!!! --> 



                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->  
                </div><!-- -/widget-box -->    
                <!-- !!! END SIMULTANEOUS STUDIES WIDGET BOX!!!! --> 


                <div class="widget-box ">
                  <div class="widget-header">
                    <h4>Estudi</h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
                      <form class="form-horizontal" id="enrollment_study-form" method="get">
                        <label class="control-label" for="enrollment_study">Estudi:&nbsp;&nbsp;</label>
                        <select id="enrollment_study" name="enrollment_study" class="select2" data-placeholder="<?php echo lang('enrollment_select_study_title') ;?>" style="width:700px">
                          <? foreach($enrollment_studies as $enrollment_study): ?>
                          <option value="<?php echo $enrollment_study['studies_id']; ?>" <?php if ( $this->config->item('default_study_id') == $enrollment_study['studies_id'] ) { echo "selected=\"selected\""; } ;?> ><?php echo $enrollment_study['studies_shortname'] . ". " . $enrollment_study['studies_name'] . " ( " . $enrollment_study['studies_law_shortname'] . " - " . $enrollment_study['studies_organizational_unit_shortname'] . " ) (" .  $enrollment_study['studies_id'] . ")"; ?></option>
                          <? endforeach; ?>
                        </select>
                        <div class="space-2"></div>
                      </form>
                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->  
                </div><!-- -/widget-box -->                         
              </div><!-- /step2 -->
<!--  
STEP 3 - ALL COURSES
-->                
              <div class="step-pane" id="step3">
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4>Curs</h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
                      <form class="form-horizontal" id="enrollment_course-form" method="get">
                        <label class="control-label" for="enrollment_course">Curs:&nbsp;&nbsp;</label>
                        <select id="enrollment_course" name="enrollment_course" class="select2" data-placeholder="Selecciona un Curs" style="width:400px">
                          <option value=""></option>                          
                        </select>
                        <div class="space-2"></div>
                      </form>
                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->  
                </div><!-- -/widget-box -->                         
              </div><!-- /step3 -->

<!--  
STEP 4 - ALL CLASSROOM GROUPS FROM SELECTED STUDY
-->                
              <div class="step-pane" id="step4">
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4>Grup de Classe</h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
                      <form class="form-horizontal" id="classroom_group-form" method="get">
                        <div id="step4_classroom_group" class="form-group">
                          <label class="control-label" for="classroom_group">Grups de Classe:&nbsp;&nbsp;</label>
                          <select id="classroom_group" name="classroom_group" class="select2" data-placeholder="Selecciona un Grup de Classe">
                            <option value=""></option>
                          </select>
                        </div>
                        <div class="space-2"></div>
                      </form>
                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->  
                </div><!-- -/widget-box -->                         
              </div><!-- /step4 -->

<!--  
STEP 5 - ALL MODULES FROM SELECTED STUDY
-->                      
              <div class="step-pane" id="step5">
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4>Mòduls professionals</h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
                      <form class="form-horizontal" id="study_module-form" method="get">
                        <div id="step5_study_module" class="form-group">
                          <div id="checkbox_study_module"></div>
                        </div>
                        <div class="space-2"></div>
                      </form>
                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->  
                </div><!-- /widget-box -->                                   
              </div><!-- /step5 -->

<!--  
STEP 6 - ALL SUB-MODULES FROM SELECTED MODULES
-->      

              <div class="step-pane" id="step6">               
                <div id="logse_advise"></div>
                <div id="cam_cas_advise"></div>
<!-- STUDY WIDGET -->
                <div class="widget-box">
                  <div class="widget-header">
                    <h3 id="study_name"></h3>
                      <div class="widget-toolbar">
                        <a data-action="collapse" href="#">
                          <i class="icon-chevron-up"></i>
                        </a>
                      </div>                      
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
    
                      <!--<div id="checkbox_study_submodules"></div>-->
                      <!-- COURSE WIDGET -->
                      <div class="step6_course_widget"></div>
                      <!-- /COURSE WIDGET -->
                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->
                </div><!-- /widget-box -->
<!-- END STUDY WIDGET -->

              </div><!-- /step6 -->
            </div><!-- /step-container -->
            <hr />
            <div class="row-fluid wizard-actions">
              <button id="print_enrollment" class="btn btn-purple">
                Imprimir matrícula
                <i class="icon-print icon-on-right"></i>
              </button>
              <button id="print_tic_enrollment" class="btn btn-info">
                Imprimir matrícula TIC
                <i class="icon-print icon-on-right"></i>
              </button>
              <button class="btn btn-prev">
                <i class="icon-arrow-left"></i>
                Anterior
              </button>
              <button class="btn btn-success btn-next" data-last="Finalitzar ">
                Següent
                <i class="icon-arrow-right icon-on-right"></i>
              </button>
            </div><!-- /wizard-actions -->
          </div><!-- /widget-main -->
        </div><!-- /widget-body -->
      </div><!-- /widget-box -->
    </div><!-- /row-fluid -->
  </div>
    <!-- PAGE CONTENT ENDS -->

  <!-- ENROLLMENT PDF MODAL WINDOW -->  
 
  <div id="enrollment_pdf_dialog" style="display:none"></div> 

  <div style="height: 35px;"></div>  

<!--  
  JAVASCRIPT
-->  
    <script type="text/javascript">
      if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>

    <!-- inline scripts related to this page -->

    <script type="text/javascript">

      var existeix=false;

      function insert_update_user(student,action) {
        $.ajax({
          url:'<?php echo base_url("index.php/enrollment/insert_update_user");?>',
          type: 'post',
          data: {
              student_person_id: student.person_id,
              student_official_id : student.student_official_id,
              student_official_id_type : student.student_official_id_type,   
              student_secondary_official_id : student.student_secondary_official_id,
              student_givenName : student.student_givenName,
              student_sn1 : student.student_sn1,
              student_sn2 : student.student_sn2,
              student_username : student.student_username,
              student_generated_password : student.student_generated_password,
              student_password : student.student_password,
              student_verify_password : student.student_verify_password,
              student_email : student.student_email,
              student_secondary_email : student.student_secondary_email,
              student_homePostalAddress : student.student_homePostalAddress,
              student_locality : student.student_locality,
              student_postal_code : student.student_postal_code,
              student_telephoneNumber : student.student_telephoneNumber,
              student_mobile : student.student_mobile,
              student_date_of_birth : student.student_date_of_birth,
              student_gender : student.student_gender,
              student_photo : student.student_photo,
              action : action
          },
          datatype: 'json',
          statusCode: {
            404: function() {
              $.gritter.add({
                title: 'Error connectant amb el servidor!',
                text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/insert_update_user ' ,
                class_name: 'gritter-error gritter-center'
              });
            },
            500: function() {
              $("#response").html('A server-side error has occurred.');
              $.gritter.add({
                title: 'Error connectant amb el servidor!',
                text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/insert_update_user ' ,
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
            if (action == "insert") {
              var all_data = $.parseJSON(data);
              person_id = all_data.inserted_person_id;
              prepare_step1(student,"student",person_id);
            } else { //update. ot necessary to add new created user/student to student select2
              prepare_step1(student,"student",-1);
            }
            
          }
        }).done(function(data){
            //TODO: Something to check?
        
        });
      }

        

      function get_student_object_from_form_data() {
          
          var student = {
                student_official_id:$("#"+step+" input[name$='student_official_id']").val(),
                student_person_id: $("#"+step+" input[name$='person_id']").val(),
                student_official_id_type: $("#"+step+" input[name$='official_id_type']:checked").val(),
                student_secondary_official_id: $("#"+step+" input[name$='person_secondary_official_id']").val(),
                
                student_givenName: $("#"+step+" input[name$='person_givenName']").val(),
                student_sn1: $("#"+step+" input[name$='person_sn1']").val(),
                student_sn2: $("#"+step+" input[name$='person_sn2']").val(),

                student_username: $("#"+step+" input[name$='person_username']").val(),
                student_generated_password: $("#"+step+" input[name$='person_generated_password']").val(),
                student_password: $("#"+step+" input[name$='person_password']").val(),
                student_verify_password: $("#"+step+" input[name$='person_verify_password']").val(),
                
                student_telephoneNumber: $("#"+step+" input[name$='person_telephoneNumber']").val(),
                student_mobile: $("#"+step+" input[name$='person_mobile']").val(),
                student_email: $("#"+step+" input[name$='person_email']").val(),
                student_secondary_email: $("#"+step+" input[name$='person_secondary_email']").val(),

                student_homePostalAddress: $("#"+step+" input[name$='person_homePostalAddress']").val(),

                student_locality: $("#"+step+" select[name$='person_locality_id']").val(),
                student_postal_code: $("#"+step+" input[name$='postalcode_code']").val(),

                student_date_of_birth: $("#"+step+" input[name$='person_date_of_birth']").val(),
                student_gender: $("input:radio[name=sexe]:checked").val(),
                student_photo: $("#"+step+" input[name$='person_photo']").val(),

            };
  
          return student;
      }



      function selectItemByValue(elmnt, value){

          for(var i=0; i < elmnt.options.length; i++)
          {
            if(elmnt.options[i].value == value)
              elmnt.selectedIndex = i;
          }

      }

      function prepare_step1(student,objecttype,adduser) {
        //Preparing step1
        //SHOW PREVIOUS ENROLLMENTS
        

        //console.debug("Student:");
        //console.debug(student);

        //console.debug("BEGIN get_previous_enrollments");

        if (objecttype == "person") {
          student.student_person_id = student.person_id;
          student.student_sn1 = student.person_sn1;
          student.student_sn2 = student.person_sn2;
          student.student_givenName = student.person_givenName;
        } 
        var ex = document.getElementById('previous_enrollments');
        //if ( ! $.fn.DataTable.isDataTable( ex ) ) {
            $('#previous_enrollments').dataTable( {
              "bDestroy": true,
              "sAjaxSource": "<?php echo base_url('index.php/enrollment/get_previous_enrollments');?>/" + student.student_official_id,
              "aoColumns": [
                { "mData": "enrollment_id" },
                { "mData": "enrollment_periodid" },
                { "mData": "studies" },
                { "mData": "course_fullname" },
                { "mData": "classroomgroup_fullname" }
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
        //END SHOW PREVIOUS ENROLLENTS

        if (adduser === undefined) {
            $("#student option[value=" + student.student_person_id +"]").attr("selected","selected");
        } else {
            if (adduser != -1) {
              //ADD NEW USER TO STUDENTS SELECT AN MARK AS SELECTED!
            var x = document.getElementById("student");
            var option = document.createElement("option");
            //console.debug("adduser:" + adduser);
            //console.debug("student:" + JSON.stringify(student));
            option.value = adduser;
            //Example: 40935441P. Maribel Tur Gisberta
            option.text = $.trim(student.student_official_id + ". " + student.student_givenName + " " +  student.student_sn1 + " " + student.student_sn2 ) + " (" + student.student_person_id + ")";
            x.add(option);            
            selectItemByValue(x,adduser);                      
          } else {
            $("#student option[value=" + student.student_person_id +"]").attr("selected","selected");
          }
        }
        
          
        //CHECK student_person_id if undefined?!!!!!!        
        $("#student").select2();
        
        $(".step1_student").html( student.student_sn1 + " " + student.student_sn2 + ", " + student.student_givenName + " ("+student.student_official_id+") <i class='icon-double-angle-right'></i>");    
        if($.trim($("[name = 'step1_title' ]").html())=='') {
            $("[name = 'step1_title' ]").html("<b><small><?php echo lang('enrollment_academic_period_title');?></b></small>");     
        }
        
        $("[name = 'step1_title' ]").addClass("green");
      }

      function prepare_step2(student_id,academic_period) {
          //If user have previous enrollments propose this study as default selected
          study_id = "";

          //AJAX
          $.ajax({
            url:'<?php echo base_url("index.php/enrollment/get_last_study_id");?>',
            type: 'post',
            data: {
                student_id : student_id
            },
            datatype: 'json',
            statusCode: {
              404: function() {
                $.gritter.add({
                  title: 'Error connectant amb el servidor!',
                  text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/get_last_study_id ' ,
                  class_name: 'gritter-error gritter-center'
                });
              },
              500: function() {
                $("#response").html('A server-side error has occurred.');
                $.gritter.add({
                  title: 'Error connectant amb el servidor!',
                  text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/get_last_study_id ' ,
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
              
                var all_data = $.parseJSON(data);
                study_id = all_data.study_id;
            } else {
                console.debug("ERROR!");
                return false;
            }

          });

          if ( study_id != "" ) {
              $("#enrollment_study option[value=" + study_id +"]").attr("selected","selected");
              $("#enrollment_study").select2();
          }
          //console.debug("academic_period: " + academic_period);
          
          //var ex = document.getElementById('simultaneous_studies');          
          //if ( ! $.fn.DataTable.isDataTable( ex ) ) {
            $('#simultaneous_studies').dataTable( {
              "bDestroy": true,
              "sAjaxSource": "<?php echo base_url('index.php/enrollment/get_simultaneous_studies');?>/" + student_id + "/" + academic_period,
              "aoColumns": [
                { "mData": "periodid" },
                { "mData": "study" },
                { "mData": "course" },
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
            //END SHOW PREVIOUS ENROLLENTS
          //}
          
      }

      /******************
       *  Editable Avatar
      ******************/
      function editableAvatar() {

        //editables on first profile page
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue icon-2x icon-spinner icon-spin'></i></div>";
        
        // *** editable avatar *** //
        try {//ie8 throws some harmless exception, so let's catch it
      
          //it seems that editable plugin calls appendChild, and as Image doesn't have it, it causes errors on IE at unpredicted points
          //so let's have a fake appendChild for it!
          if( /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ) Image.prototype.appendChild = function(el){}
      
          var last_gritter
          $('#avatar').editable({
            type: 'image',
            name: 'avatar',
            value: null,
            image: {
              //specify ace file input plugin's options here
              btn_choose: 'Canvieu el Avatar',
              droppable: true,
              /**
              //this will override the default before_change that only accepts image files
              before_change: function(files, dropped) {
                return true;
              },
              */
      
              //and a few extra ones here
              name: 'avatar',//put the field name here as well, will be used inside the custom plugin
              max_size: 110000,//~100Kb
              on_error : function(code) {//on_error function will be called when the selected file has a problem
                if(last_gritter) $.gritter.remove(last_gritter);
                if(code == 1) {//file format error
                  last_gritter = $.gritter.add({
                    title: 'El fitxer no és una imatge!',
                    text: 'Escolliu un fitxer jpg|gif|png!',
                    class_name: 'gritter-error gritter-center'
                  });
                } else if(code == 2) {//file size rror
                  last_gritter = $.gritter.add({
                    title: 'El fitxer és massa gran!',
                    text: 'La imatge no pot superar els 100Kb!',
                    class_name: 'gritter-error gritter-center'
                  });
                }
                else {//other error
                }
              },
              on_success : function() {
                $.gritter.removeAll();
              }
            },
              url: function(params) {

                    //Get username an DNI
                    username = $("#username").val();
                    sn1 = $("#sn1").val();
                    givenName = $("#givenName").val();
                    official_id = $("#student_official_id").val();

                    //Check values
                    if (official_id == "") {
                      alert ("Si us plau indiqueu abans un NIF correcte!");
                      return false;
                    }

                    if (username == "") {
                      alert ("Si us plau indiqueu abans un nom d'usuari correcte!");
                      return false;
                    }

                    if (givenName == "") {
                      alert ("Si us plau indiqueu abans un nom d'usuari!");
                      return false;
                    }

                    if (givenName == "") {
                      var r = confirm("El primer cognom és buit. Esteu segurs que voleu pujar la imatge igualment?");
                      if (r != true) {
                          return false;
                      }
                    }


                    //please modify submit_url accordingly
                    var submit_url = '<?php echo base_url("index.php/enrollment/upload_photo");?>';
                    var deferred;


                    //if value is empty, means no valid files were selected
                    //but it may still be submitted by the plugin, because "" (empty string) is different from previous non-empty value whatever it was
                    //so we return just here to prevent problems
                    var value = $('#avatar').next().find('input[type=hidden]:eq(0)').val();
                    if(!value || value.length == 0) {
                      deferred = new $.Deferred
                      deferred.resolve();
                      return deferred.promise();
                    }
                    
                    

                    var $form = $('#avatar').next().find('.editableform:eq(0)');
                    $form.append('<input type="hidden" name="username" value="'+username+'" />');
                    $form.append('<input type="hidden" name="official_id" value="'+official_id+'" />');
                    var file_input = $form.find('input[type=file]:eq(0)');

                    //user iframe for older browsers that don't support file upload via FormData & Ajax
                    if( !("FormData" in window) ) {
                      deferred = new $.Deferred

                      var iframe_id = 'temporary-iframe-'+(new Date()).getTime()+'-'+(parseInt(Math.random()*1000));
                      $form.after('<iframe id="'+iframe_id+'" name="'+iframe_id+'" frameborder="0" width="0" height="0" src="about:blank" style="position:absolute;z-index:-1;"></iframe>');
                      $form.append('<input type="hidden" name="temporary-iframe-id" value="'+iframe_id+'" />');
                      

                      $form.next().data('deferrer' , deferred);//save the deferred object to the iframe
                      $form.attr({'method' : 'POST', 'enctype' : 'multipart/form-data',
                            'target':iframe_id, 'action':submit_url});

                      $form.get(0).submit();

                      //if we don't receive the response after 60 seconds, declare it as failed!
                      setTimeout(function(){
                        var iframe = document.getElementById(iframe_id);
                        if(iframe != null) {
                          iframe.src = "about:blank";
                          $(iframe).remove();
                          
                          deferred.reject({'status':'fail','message':'Timeout!'});
                        }
                      } , 60000);
                    }
                    else {
                      var fd = null;
                      try {
                        fd = new FormData($form.get(0));
                      } catch(e) {
                        //IE10 throws "SCRIPT5: Access is denied" exception,
                        //so we need to add the key/value pairs one by one
                        fd = new FormData();
                        $.each($form.serializeArray(), function(index, item) {
                          fd.append(item.name, item.value);
                        });
                        //and then add files because files are not included in serializeArray()'s result
                        $form.find('input[type=file]').each(function(){
                          if(this.files.length > 0) fd.append(this.getAttribute('name'), this.files[0]);
                        });
                      }
                      
                      //if file has been drag&dropped , append it to FormData
                      if(file_input.data('ace_input_method') == 'drop') {
                        var files = file_input.data('ace_input_files');
                        if(files && files.length > 0) {
                          fd.append(file_input.attr('name'), files[0]);
                        }
                      }

                      deferred = $.ajax({
                        url: submit_url,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        data: fd,
                        xhr: function() {
                          var req = $.ajaxSettings.xhr();
                          /*if (req && req.upload) {
                            req.upload.addEventListener('progress', function(e) {
                              if(e.lengthComputable) {  
                                var done = e.loaded || e.position, total = e.total || e.totalSize;
                                var percent = parseInt((done/total)*100) + '%';
                                //bar.css('width', percent).parent().attr('data-percent', percent);
                              }
                            }, false);
                          }*/
                          return req;
                        },
                        beforeSend : function() {
                          //bar.css('width', '0%').parent().attr('data-percent', '0%');
                        },
                        success : function() {
                          //bar.css('width', '100%').parent().attr('data-percent', '100%');
                        }
                      })
                    }



                    deferred.done(function(res){
                      if(res.status == 'OK') {
                        $('#avatar').get(0).src = res.url;
                        $('#person_photo').val (res.person_photo);
                      }
                      else alert(res.message);
                    }).fail(function(res){
                      alert("Failure");
                    });


                    return deferred.promise();




              // ***UPDATE AVATAR HERE*** //
              /*
              //You can replace the contents of this function with examples/profile-avatar-update.js for actual upload
      
              var deferred = new $.Deferred
      
              //if value is empty, means no valid files were selected
              //but it may still be submitted by the plugin, because "" (empty string) is different from previous non-empty value whatever it was
              //so we return just here to prevent problems
              var value = $('#avatar').next().find('input[type=hidden]:eq(0)').val();
              if(!value || value.length == 0) {
                deferred.resolve();
                return deferred.promise();
              }
      
              //dummy upload
              setTimeout(function(){
                if("FileReader" in window) {
                  //for browsers that have a thumbnail of selected image
                  var thumb = $('#avatar').next().find('img').data('thumb');
                  if(thumb) $('#avatar').get(0).src = thumb;
                }
                
                deferred.resolve({'status':'OK'});
      
                if(last_gritter) $.gritter.remove(last_gritter);
                last_gritter = $.gritter.add({
                  title: "Foto actualitzada correctament!",
                  text: "El avatar de l'usuari s'ha modificat correctament!",
                  time: 3000,
                  class_name: 'gritter-info gritter-center'
                });
                
               } , parseInt(Math.random() * 800 + 800))
      
              return deferred.promise();

              */

            },
            
            success: function(response, newValue) {
            }
          })
        }catch(e) {}

      }

      jQuery(function($) {

          $("#print_enrollment").hide();
          

          $('.date-picker').datepicker({"autoclose": true});
          $('.input-mask-date').mask('99-99-9999'); 
          $('.input-mask-postalcode').mask('99999');

          $('#postalcode_code').change(function () {
              postalcode = $('#postalcode_code').val();
              //console.debug("Postal code: " + postalcode);
              _person_locality_id =  $('#person_locality_id');              
              value_to_select= $('#locality_postal_code_' + postalcode).val(); 
              //console.debug("value_to_select: " + value_to_select);

              if (typeof value_to_select === "undefined") {
               alert("El codi postal no correspon a cap població");
              }

              _person_locality_id.val(value_to_select);
              _person_locality_id.select2();


          });

          $('#student').change(function () {
              //console.debug("STUDENT SELECT 2 CHANGED!!!!!!!!!!!");
              student_id = $('#student').val();
              student_text = $('#student').text();
              //console.debug("STUDENT: " + student_id);
              //console.debug("STUDENT TEXT: " + student_text);

              var data = $('#student').select2('data');
              var res = data.text.split("."); 
              student_official_id = res[0].trim();
              //console.debug("STUDENT TEXT: " + data.text);
              //console.debug("student_official_id: " + student_official_id);

              
              //Student object declaration
              student = {};

              //AJAX
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/check_student");?>',
                type: 'post',
                data: {
                    student_official_id : student_official_id
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
                    var all_data = $.parseJSON(data);
                    all_data.student_official_id = student_official_id;
                    prepare_step1(all_data,"person",-1);
                /* Student doesn't exists, clear form data */
                } else {
                    //console.debug("Student doesn't exists!");
                    return false;
                }

              });
          });
          
      
          student_official_id = $('#student_official_id');
          student_official_id_label = $('#lbl_student_official_id');

          rb_official_id_type = $("input[name=official_id_type]:radio");
          official_id_type = rb_official_id_type.val();
          official_id_type_text = $("input:checked + span").text();

          rb_official_id_type.change(function () {
            official_id_type = $(this).val();
            official_id_type_text = $("input[name=official_id_type]:checked + span").text();
            student_official_id.attr("placeholder", "Escriu el "+official_id_type_text);  
            student_official_id_label.text(official_id_type_text);      
          });

           var availableTags = <?php echo json_encode($all_person_official_ids);?>;

           student_official_id.autocomplete({
            source: availableTags
           });

            $('input:radio[name=official_id_type]').val(['1']);

            $('[data-rel=tooltip]').tooltip();

            /******************
            *  /Editable Avatar
            ******************/
            editableAvatar();

            $('select.academic_period').select2();
            $('#person_locality_id').select2();
            
            $("select.academic_period").css('width','400px').select2({
              allowClear:true
            }).on('change', function(){
              $(this).closest('form').validate().element($(this));
            }); 
            
            
            var actual_step = $('ul.wizard-steps').children().hasClass('active');      
            if(actual_step == false){
              $('ul.wizard-steps li').first().addClass('active');
              $('#step-container div').first().addClass('active');
            } 

          /* remove accents */

          var accent_fold = (function () {
              var accent_map = {
                  'à': 'a', 'á': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a', 'å': 'a', // a
                  'ç': 'c',                                                   // c
                  'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e',                     // e
                  'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i',                     // i
                  'ñ': 'n',                                                   // n
                  'ò': 'o', 'ó': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ø': 'o', // o
                  'ß': 's',                                                   // s
                  'ù': 'u', 'ú': 'u', 'û': 'u', 'ü': 'u',                     // u
                  'ÿ': 'y'                                                    // y
              };

              return function accent_fold(s) {
                  if (!s) { return ''; }
                  var ret = '';
                  for (var i = 0; i < s.length; i++) {
                      ret += accent_map[s.charAt(i)] || s.charAt(i);
                  }
                  return ret;
              };
          } ());

/* remove accents */

        /* Get generated password */
              // AJAX get Classroom_Group from Study for step 4
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/generate_password");?>',
                type: 'post',
                datatype: 'json',
                statusCode: {
                  404: function() {
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/generate_password ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                  },
                  500: function() {
                    $("#response").html('A server-side error has occurred.');
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/generate_password ' ,
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
                password = data['password'];
                $('#generated_password').val(password);
              });

        $("#student_official_id").blur( function(){
            //console.debug("Blur event");
            //TODO?
        });  

        $("#student_official_id").change(function(){
          //console.debug("change event");
          student = $(this).val();

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
                  student_exist = $("#student_exists");
                  existeix = true;
         
                  //hide generated_password
                  <?php  
                    $force_new_password_on_every_new_enrollment = $this->config->item('force_new_password_on_every_new_enrollment');
                    if (!$force_new_password_on_every_new_enrollment) :?>
                      $("input[name$='person_generated_password']").hide();
                      $("#generated_password_label").hide();
                  <?php endif;?>    


                  $.gritter.add({
                    // (string | mandatory) the heading of the notification
                    title: 'La persona ja existeix!',
                    // (string | mandatory) the text inside the notification
                    text: "<i class='icon-exclamation-sign'></i> La persona ja existeix a la base de dades. Us hem omplert tots els camps amb les dades de la persona. Comproveu que les dades siguin correctes! <button class='close' data-dismiss='alert' type='button'><i class='icon-remove'></i></button>",
                  });
                
                  var all_data = $.parseJSON(data);

                //console.debug(all_data);

                var user_database_info_text = "";
                $.each(all_data, function(idx,obj) {
                  
                  /* Fill form with student data from Database */
                  //console.debug("idx:" + idx);
                  //console.debug("set value to:" + obj);
                  $("#step0 input[name$="+idx+"]").val(obj);
                  
                  if(idx=='person_locality_id') {
                      //console.debug("test");
                      $('#person_locality_id').val(obj);
                      $('#person_locality_id').select2();
                  }

                  if (idx=="person_id") {
                      user_database_info_text = user_database_info_text + "Person id : " + obj;
                  }

                  if (idx=="userid") {
                      user_database_info_text = user_database_info_text + " User id : " + obj;
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

                if (user_database_info_text != "") {
                   $('#user_database_info').html(user_database_info_text); 
                }

                /* Student doesn't exists, clear form data */
                } else {
                    existeix = false;
                    empty_student = {"person_id":"",
                    "person_photo":"","person_secondary_official_id":"","person_givenName":"",
                    "person_sn1":"","person_sn2":"","person_email":"@<?php echo $this->config->item('default_emaildomain');?>","person_secondary_email":"","person_date_of_birth":"",
                    "person_gender":"","person_homePostalAddress":"","postalcode_code":"<?php echo $this->config->item('default_postalcode');?>","person_locality_id":"","username":"",
                    "person_telephoneNumber":"","person_mobile":""}

                    if (typeof postalcode !== 'undefined') {
                        // variable is undefined
                        value_to_select= $('#locality_postal_code_' + postalcode).val(); 
                        $('#person_locality_id').val(value_to_select);
                        $('#person_locality_id').select2();
                    }
                    

                    /*
                    student_photo = $('#student_photo');
                    student_photo.html('<span class="profile-picture"><img id="avatar" style="height: 150px;" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url('assets/img/alumnes/foto.png'); ?>" alt="photo"/></span>');                  
                    student_full_name.text('Alumne');*/

                    $.each(empty_student, function(idx,obj) {
                      $("#step0 input[name$="+idx+"]").val(obj);
                    });
                }

              });

        editableAvatar();          

        });

        $("#givenName").change(function(){
          student_full_name = $('#student_full_name').find("span.white");
          student_full_name.text( $("#givenName").val() + " " + $("#sn1").val() + " " + $("#sn2").val() );  
          givenName = document.getElementById("givenName"); 
          givenNameValue = givenName.value; 
          //console.debug(givenNameValue.substr(0,1).toUpperCase() + givenNameValue.substr(1));   
          givenName.value = givenNameValue.substr(0,1).toUpperCase() + givenNameValue.substr(1).toLowerCase();

        });

        $("#sn1").change(function(){
          student_full_name = $('#student_full_name').find("span.white");
          student_full_name.text( $("#givenName").val() + " " + $("#sn1").val() + " " + $("#sn2").val() );      
          sn1 = document.getElementById("sn1"); 
          sn1Value = sn1.value; 
          //console.debug(givenNameValue.substr(0,1).toUpperCase() + givenNameValue.substr(1));   
          sn1.value = sn1Value.substr(0,1).toUpperCase() + sn1Value.substr(1).toLowerCase();
        });

        $("#sn2").change(function(){
          student_full_name = $('#student_full_name').find("span.white");
          student_full_name.text( $("#givenName").val() + " " + $("#sn1").val() + " " + $("#sn2").val() );      
          sn2 = document.getElementById("sn2"); 
          sn2Value = sn2.value; 
          //console.debug(givenNameValue.substr(0,1).toUpperCase() + givenNameValue.substr(1));   
          sn2.value = sn2Value.substr(0,1).toUpperCase() + sn2Value.substr(1).toLowerCase();
        });



        /* username i Mostrar correu electrònic de centre */
        username_input = $('#username');
        givenName_input = $('#givenName');
        sn1_input = $('#sn1');                
        person_email = $('#person_email');

        givenName = givenName_input.val();
        sn1 = $.trim(sn1_input.val());
        username = username_input.val();

        givenName_input.blur(function(){
          //console.debug("existeix:" + existeix );
          givenName = $.trim(givenName_input.val());
          if (!existeix) {
             proposed_value = accent_fold(givenName.toLowerCase()+sn1.toLowerCase());
             proposed_value = proposed_value.replace(/\s+/g, '');
             username = username_input.val(proposed_value);  
             person_email.val(proposed_value + "@<?php echo $this->config->item('default_emaildomain');?>" );
          }
          if(givenName!='' && sn1!='' && !existeix){
             generate_username();            
          }
        });

        sn1_input.blur(function(){
          sn1 = $.trim(sn1_input.val());
          if (!existeix) {
            proposed_value = accent_fold(givenName.toLowerCase()+sn1.toLowerCase());
            proposed_value = proposed_value.replace(/\s+/g, '');
            username = username_input.val(proposed_value);
            person_email.val(proposed_value + "@<?php echo $this->config->item('default_emaildomain');?>");
          }
          if(givenName!='' && sn1!='' && !existeix){
            generate_username();
          }
        });
        
        /* END /username */

        function generate_username()  {

              // AJAX get student by username
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/get_user_by_username");?>',
                type: 'post',
                datatype: 'json',
                statusCode: {
                  404: function() {
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/get_user_by_username ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                  },
                  500: function() {
                    $("#response").html('A server-side error has occurred.');
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/get_user_by_username ' ,
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
                data: {
                  username : $("#username").val()
                }
              }).done(function(data){

                if(data!=false){
                  $('#username').val(data);
                  $('#person_email').val(data +"@<?php echo $this->config->item('default_emaildomain');?>");
                }
            });
        }          

      $(".btn-prev").click(function(){
        console.debug("Click on prev button");
        step = $("#step-container div.active").attr("id");
        step_number = parseInt( step.substr(step.length - 1) , 10);
        previous_step_number = step_number -1 ;
        /*console.debug("Step:" + step);
        console.debug("step_number:" + step_number);
        console.debug("step_number -1:" + (step_number -1));
        */
        

        $('[name ^=step][name $=_title]').removeClass("green");
        previous_step_number_string = previous_step_number.toString() ;
        step_to_green = "step" + previous_step_number_string + "_title" ;

        $('[name ^="' + step_to_green + '"]').addClass("green");
      });

      

      $("#print_tic_enrollment").click(function(){
          //console.debug("print_tic_enrollment click!");

          var txt;
          var r = confirm("Esteu segur que voleu imprimir la matrícula TIC? al imprimir la matrícula es canviarà la paraula de pas de i no podrà entrar al sistema fins que li proporcioneu.");
          if (r == true) {
              console.debug("Continue...");
          } else {
              return false;
          }

          //change user password

          student_generated_password = $("#step0 input[name$='person_generated_password']").val();
          student_password = $("#step0 input[name$='person_password']").val();
          student_verify_password = $("#step0 input[name$='person_verify_password']").val();

          password = "";
          if ( student_password == "") {
              password = student_generated_password;            
          } else if ( student_password != student_verify_password ) {
            console.debug("ERROR. student_password and student_verify_password are not the same");
            return false;
          } else {
              password = student_password;
          }

          person_id = $("#step0 input[name$='person_id']").val();

          //console.debug("password: " + password);
          //console.debug("person_id: " + person_id);

          var iframe = $('<iframe height="750" width="1000">');
          iframe.attr("src","<?php echo base_url('index.php/enrollment/enrollment_pdf?password=');?>" + password + "&person_id=" + person_id);
          $('#enrollment_pdf_dialog').append(iframe);



      });

      $("#print_enrollment").click(function(){
          console.debug("print_enrollment click!");
      });
      


      $(".btn-next").click(function(){
        console.debug("Click on next button");
        //console.debug($("#step-container div.step-pane.active"));
        step = $("#step-container div.step-pane.active").attr("id");        
        console.debug("******************* Step:" + step);

        $('[name ^=step][name $=_title]').removeClass("green");
        $('[name ^="' + step + ' _title"]').addClass("green");


/***********
 *  STEPS 
 0 - Student Personal Data
 1 - Academic period. Also select student (by default student selected in previous step)
 2 - Study Data. Select study
 3 - Course Data. Select course
 4 - Classroom Group Data. Select glassroom group
 5 - Study Modules. Select Modul professional
 6 - Study submodules. Select unitats formatives
 ***********/        

/***********
 *  STEP 0 - Student Personal Data
 ***********/

        if(step == "step0") {

          //alert("PROVA: processant step0. Es a dir venim d'step 0");

          continue_processing = true;
          skip_forward_step = false;

          //FIRST VALIDATE FORM. IS NOT VALID DONT FORWARD STEP
          if (! $('#validation-form').valid() ) {
            //console.debug("Form still NOT VALID!!!!");
            continue_processing = false;
          } 

          //TODO RECHECK PASSWORD?
          /*
          if(student_password != student_verify_password){
            //alert("NO");
          } else {
            //alert("SI");
          }
          */

          
          
          if (continue_processing) {

            var student = get_student_object_from_form_data();

            //console.debug("Person:");
            //console.debug(student);

            $.ajax({
                url:'<?php echo base_url("index.php/enrollment/check_student");?>',
                type: 'post',
                data: {
                    student_official_id : student.student_official_id
                },
                datatype: 'json',
                statusCode: {
                  404: function() {
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/check_student ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
                  },
                  500: function() {
                    $("#response").html('A server-side error has occurred.');
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/check_student ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
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

                /* Student NOT Exists */
                if(data == false) {
                    //console.debug("User NOT exists on database");
                    existeix = false;
                    //INSERT

                    // AJAX INSERT! action=insert
                    //insert_update_user(student,"insert");
                    prepare_step1(student,"student",-1);
                    
                    
                } /* Student Exists */
                else {           
                  person = $.parseJSON(data);       
                  //console.debug("User already exists on database");
                  //UPDATE
                  //UPDATE OPERATIONS IN MYSQL RETURN 0 affected rows if nothing is changed SO ALWAYS UPDATE INCLUDE CASES WHERE NO REALLY CHANGES ARE MADE

                  //SEGUR VOLEM MODIFICAR?
                  existeix = true;

                  // AJAX UPDATE. action=update
                  //Add person_id to person object:
                  student.person_id = person.person_id;    

                  //insert_update_user(student,"update");      
                  prepare_step1(student,"student",person.person_id);           

                }
                //END IF ELSE
            }); //END AJAX CHECK STUDENT
          } //END IF CONTINUE PROCESSING
          
// End step 0
        
/***********
 *  STEP 1 - Academic period and student data
 ***********/

        } else if(step == "step1"){

          //alert("PROVA: processant step1. Es a dir venim del pas 1");
         
          //selected_student_fullname = $("#student option:selected").text();
          selected_student = $("#student option:selected").val();
          academic_period = $("#academic_period option:selected").text();

          //alert(selected_student);
          //alert(academic_period);

          //AJAX
          skip_forward_step = true;
          $.ajax({
            url:'<?php echo base_url("index.php/enrollment/check_enrollment");?>',
            type: 'post',
            data: {
                selected_student : selected_student,
                academic_period : academic_period,
            },
            datatype: 'json',
            statusCode: {
                  404: function() {
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/check_enrollment ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
                  },
                  500: function() {
                    $("#response").html('A server-side error has occurred.');
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/check_enrollment ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
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

            student_name = $("#student option:selected").text().trim();
            student_id = $("#student option:selected").val();
            var res = student_name.split("."); 
            student_dni = res[0].trim();

            //console.debug("academic_period: " + academic_period);
            //console.debug("student_dni: " + student_dni);
            //console.debug("student_name: " + student_name);
            //console.debug("student_id: " + student_id);

             if(data == false) {
                //ENROLLMENT DOESN'T EXISTS FOR THIS SELECTED PERSON AND PERIOD. CONTINUE EXECUTION
                skip_forward_step = false;
                prepare_step2(student_id,academic_period);  
                $('ul.wizard-steps li[data-target="#step1"]').removeClass('active').addClass('complete');
                $('ul.wizard-steps li[data-target="#step2"]').addClass('active');
                $('#step-container div.step-pane.active').removeClass('active');
                $('#step-container div#step2.step-pane').addClass('active');

                $(".step2_selected_academic_period").html(academic_period+" <i class='icon-double-angle-right'></i>");  
                if($.trim($("[name = 'step2_title' ]").html())=='') {        
                    $("[name = 'step2_title' ]").html("<b><small><?php echo lang('enrollment_select_study_title');?></b></small>");   
                }
                $("[name = 'step2_title' ]").addClass("green");

               } else {
                  
                  var r = confirm("Ja existeix una o més matrícules per al període indicat i l'alumne escollit. Esteu segurs voleu crear un altre matrícula?");
                  if (r == true) {
                      skip_forward_step = false;
                      prepare_step2(student_id,academic_period);
                      //Active next step and force click to next button
                      $('ul.wizard-steps li.active').removeClass('active');
                      $('ul.wizard-steps li[data-target="#step1"]').removeClass('active').addClass('complete');
                      $('ul.wizard-steps li[data-target="#step2"]').addClass('active');
                      $('#step-container div.step-pane.active').removeClass('active');
                      $('#step-container div#step2.step-pane').addClass('active');

                      /*
                       step = $("#step-container div.active").attr("id");
                       step_number = parseInt( step.substr(step.length - 1) , 10);
                      */                                

                      $(".step2_selected_academic_period").html(academic_period+" <i class='icon-double-angle-right'></i>");  
                      if($.trim($("[name = 'step2_title' ]").html())=='') {        
                          $("[name = 'step2_title' ]").html("<b><small><?php echo lang('enrollment_select_study_title');?></b></small>");   
                      }
                      $("[name = 'step2_title' ]").addClass("green");

                  } else {
                      return false;
                  }

               }
             
          });
// End step 1
        
/***********
 *  STEP 2 - Study Data
 ***********/

        } else if(step == "step2"){

          //console.debug("PROVA: processant step3. Es a dir venim del pas 2");
        
          study_id = $("#enrollment_study").val();
          study_name = $("#enrollment_study option:selected").text();

          //console.debug("study_name:" . study_name);

          //WICH LAW?:
          // AJAX get Classroom_Group from Study for step 4
          $.ajax({
            url:'<?php echo base_url("index.php/enrollment/get_study_law");?>',
            type: 'post',
            data: {
                study_id : study_id,
            },
            datatype: 'json',
            statusCode: {
                  404: function() {
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/get_study_law ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
                  },
                  500: function() {
                    $("#response").html('A server-side error has occurred.');
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/get_study_law ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
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

             if(data != false) {
                study_law = $.parseJSON(data);
                study_law_shortname =study_law.studies_law_shortname
             
                console.debug("study_law.studies_law_shortname: " + study_law.studies_law_shortname);
             
                 switch (study_law_shortname)
                    {
                      case 'LOE': 
                                //Nothing to do. All is configured to LOE by default. Current law at 2014
                                logse = false;
                                break;
                      case 'LOGSE': 
                                //Change titles
                                $("#fuelux-wizard_step5_title").html("Crèdits");
                                $("#fuelux-wizard_step6_title").html("Unitats didàctiques");
                                logse = true;
                                break;
                      default:  console.debug("Unknown Law!")
                    }
             }
             
          });

          //WICH STUDY TYPE?:
          // AJAX get Classroom_Group from Study for step 4
          $.ajax({
            url:'<?php echo base_url("index.php/enrollment/get_study_type");?>',
            type: 'post',
            data: {
                study_id : study_id,
            },
            datatype: 'json',
            statusCode: {
                  404: function() {
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/get_study_type ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
                  },
                  500: function() {
                    $("#response").html('A server-side error has occurred.');
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/get_study_type ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
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

             if(data != false) {
                study_type = $.parseJSON(data);
                study_type_shortname =study_type.studies_organizational_unit_shortname
             
                console.debug("study_type_shortname: " + study_type_shortname);
             
                 switch (study_type_shortname)
                    {
                      case 'FP': 
                                //Nothing to do. Default all is configured for FP
                                cam_cas = false;
                                break;
                      case 'CAM | CAS': 
                                //Change titles
                                //$("#fuelux-wizard_step5_title").html("Crèdits");
                                //$("#fuelux-wizard_step6_title").html("Unitats didàctiques");
                                cam_cas = true;
                                break;
                      default:  console.debug("Unknown study type!")
                    }
             }
             
          });

          $("#enrollment_study").change(function(){
              study_id = $("#enrollment_study").val();
              study_name = $("#enrollment_study option:selected").text();

          });    
 
              // AJAX get Classroom_Group from Study for step 4
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/courses");?>',
                type: 'post',
                data: {
                    study_id : study_id
                },
                datatype: 'json',
                statusCode: {
                  404: function() {
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/courses ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
                  },
                  500: function() {
                    $("#response").html('A server-side error has occurred.');
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/courses ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
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
             
                courses_ids = [];
                courses_shortnames = [];
                courses_names = [];
                var $_courses = $('select#enrollment_course');
                var $_course_widget = $('div.step6_course_widget');
                $_course_widget.empty();
                $_courses.empty();
                first = 1;
                $.each(JSON.parse(data), function(idx, obj) {
                  if (first == 1) {
                    $_courses.append($('<option selected="selected"></option>').attr("value",obj.course_id).text(obj.course_shortname + ". " + obj.course_name + " ("+ obj.course_id + ")"));
                    first = 0;
                  } else {
                    $_courses.append($('<option></option>').attr("value",obj.course_id).text(obj.course_shortname + ". " + obj.course_name + " (" + obj.course_id + ")"));
                  }
                  
                  
                  courses_ids.push(obj.course_id);
                  courses_shortnames.push(obj.course_shortname);
                  courses_names.push(obj.course_name);

                  $_course_widget.append("<div class='widget-box'id='step6_course_" + obj.course_id +  "'>"+
                                            "<div class='widget-header'>"+
                                              "<h4>"+ obj.course_shortname + " - " +  obj.course_name +" (" + obj.course_id + ")</h4>"+
                                              "<div class='widget-toolbar'>"+
                                                "<a data-action='collapse' href='#'>"+
                                                  "<i class='icon-chevron-up'></i>"+
                                                "</a>"+
                                              "</div><!-- /widget-toolbar -->"+
                                            "</div><!-- /widget-header -->"+
                                            "<div class='widget-body'>"+
                                              "<div class='widget-main'>"+
                                                "<div id=step6_module_container_widget_"+obj.course_id+" class='module_widget'></div>"+
                                              "</div><!-- /widget-main -->"+
                                            "</div><!-- /widget-body -->"+
                                          "</div><!-- /widget-box -->");
                });
                $_courses.select2();
              });

              $(".step3_selected_study").html(study_name+" <i class='icon-double-angle-right'></i>");  
              if($.trim($("[name = 'step3_title' ]").html())=='') {
                  $("[name = 'step3_title' ]").html("<b><small><?php echo lang('enrollment_select_course_title');?></b></small>");   
              }
              $("[name = 'step3_title' ]").addClass("green");
              $("#study_name").text(study_name);
// End step 2

/***********
 *  STEP 3 - Course Data
 ***********/

        } else if(step == "step3"){



          course_id = $("#enrollment_course").val();
          course_name = $("#enrollment_course option:selected").text();

          $("#enrollment_course").change(function(){
              course_id = $("#enrollment_course").val();
              course_name = $("#enrollment_course option:selected").text();
          });    

              // AJAX get Classroom_Group from Study for step 4
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/classroom_group");?>',
                type: 'post',
                data: {
                    study_id : study_id,
                    course_id : course_id
                },
                datatype: 'json',
                statusCode: {
                  404: function() {
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/classroom_group ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
                  },
                  500: function() {
                    $("#response").html('A server-side error has occurred.');
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/classroom_group ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
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

                classroom_groups = [];
                var $_classroom_group = $('select#classroom_group');
                
                $_classroom_group.empty();
                first = 1;
                $.each(JSON.parse(data), function(idx, obj) {
                  if (first == 1) {
                    $_classroom_group.append($('<option selected="selected"></option>').attr("value",obj.classroom_group_id).text(obj.classroom_group_name + " (" + obj.classroom_group_id +  ")"));
                    first = 0;
                  }
                  else {
                    $_classroom_group.append($('<option></option>').attr("value",obj.classroom_group_id).text(obj.classroom_group_name + " (" + obj.classroom_group_id +  ")"));
                  }
                  
                  classroom_groups.push(obj.classroom_group_id);
                });
                $_classroom_group.select2();
              });

              $(".step4_selected_course").html(course_name + " <i class='icon-double-angle-right'></i>");      
              if($.trim($("[name = 'step4_title' ]").html())=='') {
                  $("[name = 'step4_title' ]").html("<b><small><?php echo lang('enrollment_select_classroomgroup_title');?></b></small>");   
              }

              $("[name = 'step4_title' ]").addClass("green");   
              $("#course_name").text(course_name);
// End step 3

/***********
 *  STEP 4 - Classroom Group Data
 ***********/

        } else if(step == "step4") {

          //alert(classroom_groups);
          
          //course_id = $("#enrollment_course").val();
          //course_name = $("#enrollment_course option:selected").text();

          classroom_group_name = $("select#classroom_group option:selected").text();
          classroom_group_id = $("select#classroom_group option:selected").val();

          //Wizard could be navigated forward and backwards. Empty first to avoid adding multiple times studymodules!
          var $_module_widget = $('div[id^="step6_module_container_widget_"]');   
          
          //console.debug($_module_widget);
          //console.debug("course_id:" + course_id);
          //console.debug("courses_ids:" + courses_ids);
          //console.debug("courses_shortnames:" + courses_shortnames);
          //console.debug("courses_names:" + courses_shortnames);
          
          $_module_widget.empty(); 

          $("#classroom_group").change(function(){
            classroom_group_name = $("select#classroom_group option:selected").text();
            classroom_group_id = $("select#classroom_group option:selected").val();            
          }); 
              //alert(study_id);
              // AJAX get Study_Modules from Classroom_Group for step 5

              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/study_modules");?>',
                type: 'post',
                data: {
                    course_id : course_id,
                    courses_ids : courses_ids
                },
                datatype: 'json',
                statusCode: {
                  404: function() {
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/study_modules ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
                  },
                  500: function() {
                    $("#response").html('A server-side error has occurred.');
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/study_modules ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
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
                //study_modules_data = data;
                var $_study_module = $('#checkbox_study_module');
                $_study_module.empty();

                $.each(JSON.parse(data), function(idx, obj) {
                  //console.log("Data: "+data);
                  //$_study_module.append('<h3>'+idx+'</h3>');
                  $_study_module.append("<div class='widget-box'>"+
                                            "<div class='widget-header'>"+
                                              "<h3>" + courses_shortnames[jQuery.inArray(idx,courses_ids)] + " - " + courses_names[jQuery.inArray(idx,courses_ids)]  +"</h3>"+
                                              "<div class='widget-toolbar'>"+
                                                "<a data-action='collapse' href='#'>"+
                                                  "<i class='icon-chevron-up'></i>"+
                                                "</a>"+
                                              "</div><!-- /widget-toolbar -->"+
                                            "</div><!-- /widget-header -->"+
                                            "<div class='widget-body'>"+
                                              "<div class='step5_widget-main_"+idx+" widget-main'>");  
                        var $_step4_widget_main = $(".step5_widget-main_"+idx);
                        $_step4_widget_main.empty();
                        $.each(obj, function(index, object){
                          //console.log("Object: "+object);
                          if(object.selected_course=="yes"){
                            checked = 'checked';
                          } else {
                            checked = '';
                          }

                          $_step4_widget_main.append('<input class="ace" type="checkbox" '+ checked +' name="'+object.study_module_shortname+'" value="'+object.study_module_id+'"/> <span class="lbl">  ('+ object.study_module_ap_courses_course_id+') '+object.study_module_shortname+' - '+object.study_module_name+' ('+object.study_module_id+')</span><br />');

                          //console.debug("courseid: " + object.study_module_ap_courses_course_id);

                          var $_module_widget = $('#step6_module_container_widget_' + object.study_module_ap_courses_course_id);   
                          $_module_widget.append("<div class='widget-box'>"+
                                                  "<div class='widget-header'>"+
                                                    "<h4 id='h4_study_module_" + object.study_module_id + "'>" + object.study_module_shortname + " - " + object.study_module_name + " (" + object.study_module_id + ")</h4>" +
                                                    "<div class='widget-toolbar'>"+
                                                      "<a data-action='collapse' href='#'>"+
                                                        "<i class='icon-chevron-up'></i>"+
                                                      "</a>"+
                                                    "</div><!-- /widget-toolbar -->"+
                                                  "</div><!-- /widget-header -->"+
                                                  "<div class='widget-body'>"+
                                                    "<div class='widget-main'>"+
                                                      "<div id='step6_submodule_widget_module_id_"+object.study_module_id+"_"+object.course_id +"' class='submodule_widget'></div><!-- /submodule-widget -->"+
                                                    "</div><!-- /widget-main -->"+
                                                  "</div><!-- /widget-body -->"+
                                                "</div><!-- /widget-box -->");

                          });
                  
                  $_study_module.append("</div><!-- /widget-main -->"+
                                        "</div><!-- /widget-body -->"+
                                        "</div><!-- /widget-box --><br />");
                });                  

            });
              
              $(".step5_selected_classroom_group").html(classroom_group_name + " <i class='icon-double-angle-right'></i>");          
              if($.trim($("[name = 'step5_title' ]").html())=='') {
                  $("[name = 'step5_title' ]").html("<b><small><?php echo lang('enrollment_select_studymodule_title');?></b></small>");   
              }     
              $("[name = 'step5_title' ]").addClass("green");  

              

// End step 4

/***********
 *  STEP 5 - Study Modules
 ***********/

        } else if(step == "step5") {

        if (logse) {
          logse_advise = $("#logse_advise");
          logse_advise.html("<i class='icon-ok green'></i> Atenció. Heu escollit un cicle LOGSE. En aquest tipus de cicles no trobareu indicades les unitats didàctiques ja que no és possible la matrículació per unitat didàctica i a més no necessariament tots els professors imparteixen les mateixes unitats<button class='close' data-dismiss='alert' type='button'><i class='icon-remove'></i></button>")
                .addClass("alert alert-block alert-success");

          /* Show notification during 5 seconds */
          /*setTimeout(function(){
            logse_advise.html('');
            logse_advise.removeClass("alert alert-block alert-success")
          },5000);      */
        }
        try {
          if (cam_cas) {
            cam_cas_advice = $("#cam_cas_advice");
            cam_cas_advice.html("<i class='icon-ok green'></i> Atenció. Heu escollit els estudis de preparació de les proves d'accés. Aquest pas us el podeu saltar<button class='close' data-dismiss='alert' type='button'><i class='icon-remove'></i></button>")
                  .addClass("alert alert-block alert-success");

            /* Show notification during 5 seconds */
            /*setTimeout(function(){
              cam_cas_advice.html('');
              cam_cas_advice.removeClass("alert alert-block alert-success")
            },5000);      */
          } 
        }
        catch(err) {
          
        }
    
        study_module_names = $('#checkbox_study_module input:checked').map(function(){
          return this.name;
        }).get();

        study_module_ids = $('#checkbox_study_module input:checked').map(function(){
          return $(this).val()
        }).get();

        study_module_ids = study_module_ids.toString().replace(/,/g ,"-");

              checked_study_submodules_id = [];
              //AJAX get Study_Submodules from Study_Modules for step 6
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/all_study_submodules_by_modules");?>',
                type: 'post',
                data: {
                    study_module_ids : study_module_ids,
                    course_id : course_id
                },
                datatype: 'json',
                statusCode: {
                  404: function() {
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/all_study_submodules_by_modules ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
                  },
                  500: function() {
                    $("#response").html('A server-side error has occurred.');
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/all_study_submodules_by_modules ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
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

                $.each(JSON.parse(data), function(idx, obj) {
                  //console.debug("idx: " + idx);
                  //console.debug("study_submodules: " + JSON.stringify(obj));
                  //console.debug("study_submodules_id: " + obj.study_submodules_id);
                  //console.debug("study_submodules_shortname: " + obj.study_submodules_shortname);
                  //console.debug("study_submodules_name: " + obj.study_submodules_name);

                  checked_study_submodules_id.push(parseInt(obj.study_submodules_id));
                });
              }).fail(function(){
                //alert(data);
              });

              
              //AJAX get ALL study_Submodules for selected study
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/all_study_submodules_by_study");?>',
                type: 'post',
                data: {
                    study_id : study_id,
                },
                datatype: 'json',
                statusCode: {
                  404: function() {
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/all_study_submodules_by_study ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
                  },
                  500: function() {
                    $("#response").html('A server-side error has occurred.');
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/all_study_submodules_by_study ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
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

                study_module_emptied = [];

                //console.debug("checked_study_submodules_id: " + JSON.stringify(checked_study_submodules_id));
                

                $.each(JSON.parse(data), function(idx, obj) {
                  //console.debug("idx: " + idx);
                  //console.debug("study_submodules: " + JSON.stringify(obj));
                  //console.debug("study_submodules_study_module_id: " + obj.study_submodules_study_module_id);
                  //console.debug("study_submodules_id: " + obj.study_submodules_id);

                  var $_study_module_div_for_submodules = $('#step6_submodule_widget_module_id_' + obj.study_submodules_study_module_id + '_' + obj.study_submodules_courseid);
                           
                  if ( jQuery.inArray( obj.study_submodules_study_module_id , study_module_emptied ) == -1) {
                    $_study_module_div_for_submodules.empty();
                    study_module_emptied.push(obj.study_submodules_study_module_id);
                  }

                  //$("#"+obj.study_submodules_study_module_id).append($('<input type="checkbox" checked name="'+obj.study_submodules_shortname+'" value="'+obj.study_submodules_study_module_id+'#'+obj.study_submodules_id+'"/> ('+obj.study_module_shortname+') '+obj.study_submodules_shortname+' - '+obj.study_submodules_name+' ('+obj.study_submodules_id+')<br />'));
                  
                  var input_id = "step6_checkbox_studysudmodule_id_" + obj.study_submodules_id;
                  if ( (jQuery.inArray (parseInt(obj.study_submodules_id) , checked_study_submodules_id)) != -1 ) {                      
                      if (! document.getElementById(input_id)) {
                        $_study_module_div_for_submodules.append($('<input id="' + input_id + '" type="checkbox" checked="checked" name="'+obj.study_submodules_shortname+'" value="'+obj.study_submodules_study_module_id+'#'+obj.study_submodules_id+'"/> ('+obj.study_module_shortname +' - ' + obj.study_module_id + ') '+obj.study_submodules_shortname+' - '+obj.study_submodules_name+' ('+obj.study_submodules_id+')<br />'));  
                      } 
                      
                  } else {
                    if (! document.getElementById(input_id)) {
                      $_study_module_div_for_submodules.append($('<input id="' + input_id + '" type="checkbox" name="'+obj.study_submodules_shortname+'" value="'+obj.study_submodules_study_module_id+'#'+obj.study_submodules_id+'"/> ('+obj.study_module_shortname +' - ' + obj.study_module_id +') '+obj.study_submodules_shortname+' - '+obj.study_submodules_name+' ('+obj.study_submodules_id+')<br />'));                    
                    }
                  }
                    

                });
              }).fail(function(){
                //alert(data);
              });


        $(".step6_selected_study_module").html( Object.keys(study_module_names).length + " Mòduls Professionals <i class='icon-double-angle-right'></i>");
        $("#study_module_name").text(study_module_names);
        if($.trim($("[name = 'step6_title' ]").html())=='') {
            $("[name = 'step6_title' ]").html("<b><small><?php echo lang('enrollment_select_studysubmodule_title');?></b></small>");   
        }
        $("[name = 'step6_title' ]").addClass("green"); 

        $("#print_enrollment").show();

// End step 5

/***********
 *  STEP 6 - Study Submodules Data
 ***********/

        } else if(step == "step6") {
          //$( "input[name^='news']" )
          var study_submodules_names = $("input[id^='step6_checkbox_studysudmodule_id_']:checked").map(function(){
            return this.name;
          }).get();

          var study_submodules_ids = $("input[id^='step6_checkbox_studysudmodule_id_']:checked").map(function(){
            return $(this).val()
          }).get();

          study_submodules_ids = study_submodules_ids.toString().replace(/,/g ,"-");

          //console.debug("study_submodules_ids:" + study_submodules_ids);

          //alert("Alumne: "+student_name.trim()+"\nPerson Id: "+student_id+"\nPeriod_id: "+academic_period+"\nEstudi: "+study_name+"\nEstudi id: "+study_id+"\nCourse: "+course_name+"\nCourse id: "+course_id+"\nGrup de Classe: "+classroom_group_name+"\nGrup de Classe Id: "+classroom_group_id+"\nMòduls: "+study_module_names+" ("+study_module_ids+") \nUnitats Formatives: "+study_submodules_names+" ("+study_submodules_ids+")");

          console.debug("Before ajax request enrollment_wizard");
          // AJAX insert Enrollment data into database
          $.ajax({
            url:'<?php echo base_url("index.php/enrollment/enrollment_wizard");?>',
            type: 'post',
            data: { 
                    person_id: student_id,
                    period_id: academic_period,
                    study_id: study_id,
                    course_id: course_id,
                    classroom_group_id: classroom_group_id,
                    study_module_ids: study_module_ids,
                    study_submodules_ids: study_submodules_ids
                  },
            datatype: 'json',
            statusCode: {
                  404: function() {
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/enrollment_wizard ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
                  },
                  500: function() {
                    $("#response").html('A server-side error has occurred.');
                    $.gritter.add({
                      title: 'Error connectant amb el servidor!',
                      text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/enrollment_wizard ' ,
                      class_name: 'gritter-error gritter-center'
                    });
                    skip_forward_step = true;
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
              //Check errors!
               console.debug ("******************************** TODO ****************************");
              var all_data = $.parseJSON(data);
              console.debug ("enrollment_wizard result code: " + all_data.result_code);
              console.debug ("enrollment_wizard result_message: " + all_data.result_message);
              console.debug ("enrollment records inserted: " + JSON.stringify(all_data.enrollment));
              console.debug ("enrollment_submodules records inserted: " + JSON.stringify(all_data.enrollment_submodules));

              if ( all_data.result_code != 0 || all_data.result_code != 0 ) {
                //ERROR
                $.gritter.add({
                  title: 'Error al executar index.php/enrollment/enrollment_wizard!',
                  text: 'Error code: ' + all_data.result_code + ' Error message: ' + all_data.result_message,
                  class_name: 'gritter-error gritter-center'
                });
              } else {
                console.debug ("Enrollment OK!");
                bootbox.dialog({
                    message: "La matrícula s'ha realitzat correctament!", 
                    buttons: {
                      "success" : {
                        "label" : "OK",
                        "className" : "btn-sm btn-primary",
                        callback: function() {
                                    window.location.href = "<?php echo base_url('index.php/enrollment/wizard');?>";
                                }
                        }
                      }
                    });  
              }
          });
        }
      });  

// End step 6

        var $validation = true;

        $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
          console.debug("Change on wizard!");
          if ( info != null ) {
            if(info.step == 1 && $validation) {
              if(!$('#validation-form').valid()) {
                console.debug("Cancel step forward");
                return false;
              }
            }  
          }
          
          //console.debug("skip_forward_step:" + skip_forward_step);
          if (skip_forward_step) {
            console.debug("SKIP FORWARD!");
            return false;
          }
          console.debug("End Change on wizard!");
        }).on('finished', function(e) {

          console.debug ("Form wizard finished!");             
          

        }).on('stepclick', function(e){
          //return false;//prevent clicking on steps
          console.debug("STEP CLICK TEST!");

          $('[name ^=step][name $=_title]').removeClass("green");

          step = $("#step-container div.active").attr("id");
          step_number = parseInt( step.substr(step.length - 1) , 10);
          previous_step_number = step_number -1 ;         
          _step_title = $('[name ="step' + previous_step_number + '_title"]')
          _step_title.addClass("green");

        });
      
        //documentation : http://docs.jquery.com/Plugins/Validation/validate
        $('#skip-validation').on('click', function(){
          $validation = this.checked;
        });

      
        $.mask.definitions['~']='[+-]';
        //$('#person_telephoneNumber').mask('(999) 999-9999');
      
        /* VALIDAR DNI */

        jQuery.validator.addMethod( "student_official_id", function ( value, element ) {
         "use strict";
         
         var _placeholder=element.placeholder;
         
         if (_placeholder.search("DNI") == -1) {
          return true;
         }

         value = value.toUpperCase();
         
         // Basic format test
         if ( !value.match('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)') ) {
          return false;
         }
         
         // Test NIF
         if ( /^[0-9]{8}[A-Z]{1}$/.test( value ) ) {
          return ( "TRWAGMYFPDXBNJZSQVHLCKE".charAt( value.substring( 8, 0 ) % 23 ) === value.charAt( 8 ) );
         }
         // Test specials NIF (starts with K, L or M)
         if ( /^[KLM]{1}/.test( value ) ) {
          return ( value[ 8 ] === String.fromCharCode( 64 ) );
         }
         
         return false;
        
        }, "Especifiqueu un NIF vàlid!.");
        /* END /Validar dni */

        /*
        jQuery.validator.addMethod("person_telephoneNumber", function (value, element) {
          return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
        }, "Enter a valid phone number.");
        */

        $.extend($.validator.messages, {
          required: "Aquest camp és obligatori.",
          remote: "Si us plau, omple aquest camp.",
          email: "Si us plau, escriu una adreça de correu-e vàlida",
          url: "Si us plau, escriu una URL vàlida.",
          date: "Si us plau, escriu una data vàlida.",
          dateISO: "Si us plau, escriu una data (ISO) vàlida.",
          number: "Si us plau, escriu un número enter vàlid.",
          digits: "Si us plau, escriu només dígits.",
          creditcard: "Si us plau, escriu un número de tarjeta vàlid.",
          equalTo: "Si us plau, escriu el maateix valor de nou.",
          extension: "Si us plau, escriu un valor amb una extensió acceptada.",
          maxlength: $.validator.format("Si us plau, no escriguis més de {0} caracters."),
          minlength: $.validator.format("Si us plau, no escriguis menys de {0} caracters."),
          rangelength: $.validator.format("Si us plau, escriu un valor entre {0} i {1} caracters."),
          range: $.validator.format("Si us plau, escriu un valor entre {0} i {1}."),
          max: $.validator.format("Si us plau, escriu un valor menor o igual a {0}."),
          min: $.validator.format("Si us plau, escriu un valor major o igual a {0}.")
        });

        $('#validation-form').validate({
          errorElement: 'div',
          errorClass: 'help-inline',
          focusInvalid: false,
          rules: {
            student_official_id: {
              required: true,
              student_official_id: 'required',
            },
            person_givenName: {
              required: true
            },
            person_sn1: {
              required: true
            },
            person_email: {
              required: false,
              email:true
            },
            person_secondary_email: {
              required: false,
              email:true
            },
            person_password: {
              required: false,
              minlength: 6
            },
            person_verify_password: {
              required: false,
              minlength: 6,
              equalTo: "#person_password"
            },
            
            person_telephoneNumber: {
              required: false
            },
            
            gender: 'required'
          },
      
          messages: {
            person_email: {
              required: "Si us plau especifiqueu un email vàlid.",
              email: "Si us plau especifiqueu un email vàlid."
            },
            person_secondary_email: {
              required: "Si us plau especifiqueu un email vàlid.",
              email: "Si us plau especifiqueu un email vàlid."
            },
            person_password: {
              required: "És obligatori especificar una paraula de pas",
              minlength: "Si us plau especifiqueu una paraula de pas segura."
            },
            subscription: "Si us plau escolliu almenys una opció",
            gender: "Si us plau escolliu el gènere"
          },
      
          invalidHandler: function (event, validator) { //display error alert on form submit   
            $('.alert-danger', $('.login-form')).show();
          },
      
          highlight: function (e) {
            $(e).closest('.control-group').removeClass('info').addClass('error');
          },
      
          success: function (e) {
            $(e).closest('.control-group').removeClass('error').addClass('info');
            $(e).remove();
          },
      
          errorPlacement: function (error, element) {
            if(element.is(':checkbox') || element.is(':radio')) {
              var controls = element.closest('div[class*="col-"]');
              if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
              else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            }
            else if(element.is('.select2')) {
              error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            }
            else if(element.is('.chosen-select')) {
              error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            }
            else error.insertAfter(element);
          },
      
          submitHandler: function (form) {
          },
          invalidHandler: function (form) {
          }
        });
        $('#modal-wizard .modal-header').ace_wizard();
        $('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');
      })
    </script>
  
<!-- /Wizard -->
</div>
</div>
<?php


?>
