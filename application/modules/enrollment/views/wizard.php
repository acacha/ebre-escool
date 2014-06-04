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
        <?php echo lang('wizard');?>
      </small>
    </h1>
  </div><!-- /.page-header -->	

  <div style='height:10px;'></div>  
  <div style="margin:10px;">

    <!-- PAGE CONTENT BEGINS -->
    <div class="row-fluid">
      <div class="widget-box">
        <div class="widget-header widget-header-blue widget-header-flat">
          <h4 class="lighter"><?php echo lang('new_enrollment');?></h4>
          <div class="widget-toolbar">
            <label>
              <small class="green">
                <b><?php echo lang('validation');?></b>
              </small>
              <input id="skip-validation" type="checkbox" class="ace ace-switch ace-switch-4" />
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
                  <span class="title">Alta alumne</span>
                </li>

                <li data-target="#step1">
                  <span class="step">1</span>
                  <span class="title"><?php echo lang('enrollment');?></span>
                </li>

                <li data-target="#step2">
                  <span class="step">2</span>
                  <span class="title"><?php echo lang('enrollment_studies');?></span>
                </li>

                <li data-target="#step3">
                  <span class="step">3</span>
                  <span class="title"><?php echo lang('enrollment_courses');?></span>
                </li>

                <li data-target="#step4">
                  <span class="step">4</span>
                  <span class="title"><?php echo lang('enrollment_classgroups');?></span>
                </li>

                <li data-target="#step5">
                  <span class="step">5</span>
                  <span class="title"><?php echo lang('enrollment_modules');?></span>
                </li>

                <li data-target="#step6">
                  <span class="step">6</span>
                  <span class="title"><?php echo lang('enrollment_submodules');?></span>
                </li>
              </ul>
            </div> <!-- /fuelux-wizard -->

            <hr />

            <div class="step-content row-fluid position-relative" id="step-container">

<!--  
STEP 0 - STUDENT DATA
-->                
              <div class="step-pane active" id="step0">

                <!-- Show notification if student exists -->
                <div id="student_exists"></div>
                <!-- /Show notification if student exists -->

                <div class="row-fluid center">
                  <h3 class="lighter block green">Alta Alumne</h3>
                  Dades personals
                </div>
                <br />
                <!--<form class="form-horizontal" id="standard-form" method="get">-->
                <form class="form-horizontal" id="validation-form" method="get">
                  <input type="hidden" id="person_id" name="person_id"  />
                  
                  <div class="col-xs-12 col-sm-3 center">
                    
                    <!-- Student Photo -->
                    <div id="student_photo">
                      <span class="profile-picture">
                        <img id="avatar" style="height: 150px;" class="editable img-responsive editable-click" src="<?php echo base_url('assets/img/alumnes').'/foto.png';?>" alt="photo" />
                      </span>
                    </div>  

                    <br />
                    <div id="student_full_name" class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                      <div class="inline position-relative">
                        <span class="white">Alumne</span>
                      </div>
                    </div>
                  </div>
                  <div class="space-6"></div>
                  <div class="widget-box">
                    <div class="widget-header">
                      <h4>Dades de l'alumne</h4>
                    </div>
                    <div class="widget-body">
                      <div class="widget-main">
                        <div class="form-group">
                          <!-- Student Official ID -->
                          <div class="form-group">
                            <!-- Official id type -->
                            <label class="control-label" for="official_id_type"><?php echo lang('wizzard_official_id_type');?>&nbsp;</label><br /><br />
                            <input type="radio" name="official_id_type" id="rb_is_dni" value="1"><span><?php echo lang('wizzard_official_DNI');?>&nbsp;</span><br />
                            <input type="radio" name="official_id_type" value="2"><span><?php echo lang('wizzard_official_NIE');?>&nbsp;</span><br />
                            <input type="radio" name="official_id_type" value="3"><span><?php echo lang('wizzard_official_passport');?>&nbsp;</span><br />
                          </div>
                          <br />

                          <div class="form-group">
                            <label id="lbl_student_official_id" for="student_official_id" class="control-label col-xs-12 col-sm-3 no-padding-right"><?php echo lang('wizzard_official_DNI');?>&nbsp;</label>
                            <div class="col-xs-12 col-sm-9">
                              <div class="clearfix">
                                <input type="text" class="col-xs-12 col-sm-4" id="student_official_id" name="student_official_id" placeholder="Escriu el <?php echo lang('wizzard_official_DNI');?>" />
                              </div>
                            </div>
                          </div>





                          <!--
                          <div class="form-group">                          
                            <label class="control-label" for="student_official_id"><?php echo lang('wizzard_official_id');?>&nbsp;</label>
                            <input type="text" id="student_official_id" name="student_official_id" placeholder="Escriu el DNI" />
                          </div>
                          -->  
                          <br />
                          <!-- Student Secondary Official ID -->
                          <div class="form-group">
                            <label class="control-label" for="person_secondary_official_id"><?php echo lang('wizzard_secondary_official_id');?>&nbsp;</label>
                            <input type="text" name="person_secondary_official_id" placeholder="Escriu el nº TSI" />
                          </div>
                          <br />
                          <!-- Student Name -->
                          <div class="form-group">
                            <label class="control-label" for="student_givenName"><?php echo lang('wizzard_givenName');?>&nbsp;</label>
                            <input id="givenName" type="text" name="person_givenName" placeholder="Escriu un nom d'alumne" />
                          </div>
                          <br />
                          <!-- Student Sn1 -->
                          <div class="form-group">
                            <label class="control-label" for="student_sn1"><?php echo lang('wizzard_sn1');?>&nbsp;</label>
                            <input id="sn1" type="text" name="person_sn1" placeholder="Escriu el Primer Cognom" />
                          </div>
                          <br />
                          <!-- Student Sn2 -->
                          <div class="form-group">
                            <label class="control-label" for="student_sn2"><?php echo lang('wizzard_sn2');?>&nbsp;</label>
                            <input type="text" name="person_sn2" placeholder="Escriu el Segon Cognom" />
                          </div>
                          <br />


                          <!-- Student username -->
                          <div class="form-group">
                            <label class="control-label" for="student_username">Username:&nbsp;</label>
                            <input id="username" type="text" name="person_username" placeholder="Username" disabled />
                          </div>
                          <br />
                          <!-- Student generated password -->
                          <div class="form-group">
                            <label class="control-label" for="student_generated_password">Generated Password:&nbsp;</label>
                            <input id="generated_password" type="text" name="person_generated_password" placeholder="Generated Password" disabled />
                          </div>
                          <br />
                          <!-- Student Password -->
                          <div class="form-group">
                            <label class="control-label" for="student_password">Password:&nbsp;</label>
                            <input type="password" name="person_password" id="person_password" placeholder="Password"/>
                          </div>
                          <br />
                          <!-- Student Verify Password -->
                          <div class="form-group">
                            <label class="control-label" for="student_verify_password">Verify Password:&nbsp;</label>
                            <input type="password" name="person_verify_password" placeholder="Verify Password"/>
                          </div>
                          <br />


                          <!-- Student Telephone Number -->
                          <div class="form-group">
                            <label class="control-label" for="student_telephoneNumber"><?php echo lang('wizzard_telephoneNumber');?>&nbsp;</label>
                            <input type="text" name="person_telephoneNumber" id="person_telephoneNumber" placeholder="Escriu el telèfon fixe" />
                          </div>
                          <br />
                          <!-- Student Mobile Number -->
                          <div class="form-group">
                            <label class="control-label" for="student_mobile"><?php echo lang('wizzard_mobile');?>&nbsp;</label>
                            <input type="text" name="person_mobile" placeholder="Escriu el telèfon mòbil" />
                          </div>
                          <br />
                          <!-- Student Email -->
                          <div class="form-group">
                            <label class="control-label" for="student_email"><?php echo lang('wizzard_email');?>&nbsp;</label>
                            <input type="text" name="person_email" placeholder="Escriu el Correu electrònic" />
                          </div>
                          <br />
                          <!-- Student Address -->
                          <div class="form-group">
                            <label class="control-label" for="student_homePostalAddress"><?php echo lang('wizzard_homePostalAddress');?>&nbsp;</label>
                            <input type="text" name="person_homePostalAddress" placeholder="Escriu l'Adreça" />
                          </div>
                          <br />
                          <!-- Student Locality -->
                          <div class="form-group">
                            <label class="control-label" for="student_locality_name"><?php echo lang('wizzard_locality_name');?>&nbsp;</label>
                            <input type="text" name="person_locality_name" placeholder="Escriu la Localitat" />
                          </div>
                          <br />
                          <!-- Student Birth Date -->
                          <div class="form-group">
                            <label class="control-label" for="student_date_of_birth"><?php echo lang('wizzard_date_of_birth');?>&nbsp;</label>
                            <input type="text" name="person_date_of_birth" placeholder="Escriu la Data de naixement" />
                          </div>
                          <br />
                          <!-- Student Gender -->
                          <div class="form-group">
                            <label class="control-label" for="student_gender"><?php echo lang('wizzard_gender');?>&nbsp;</label>
                            <input type="text" name="person_gender" placeholder="Escriu el Sexe" />
                          </div>
                        </div><!-- /form-group -->
                      </div><!-- /widget-main -->
                    </div><!-- /widget-body -->  
                  </div><!-- -/widget-box -->
                </form>
              </div><!-- /step0 -->

<!--  
STEP 1 - ACADEMIC PERIOD AND STUDENT
-->
              <div class="step-pane" id="step1">
                <div class="row-fluid center">
                  <h3 class="lighter block green"><?php echo lang('enrollment');?></h3>
                  <?php echo lang('person_and_academinc_period'); ?>
                </div>
                <div class="step1_student"></div>
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4>Periode Acadèmic i Alumne</h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
                      <form class="form-horizontal" id="validation-form" method="get">
                        <!-- Academin Period -->
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
                        <select id="student" name="student" class="select2" data-placeholder="Selecciona un Estudiant" style="width:800px;">
                          <option value=""></option>
                          <? foreach($enrollment_students as $enrollment_student): ?>
                          <option value="<?php echo $enrollment_student['student_person_id']; ?>"><?php echo $enrollment_student['student_fullName']; ?></option>
                          <? endforeach; ?>
                        </select>
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
                <div class="row-fluid center">
                  <h3 class="blue lighter"><?php echo lang('enrollment_studies');?></h3>
                  Seleccionar un Studi.
                </div>
                <div class="step1_student"></div>
                <div class="step2_selected_academic_period"></div>
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4>Estudi</h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
                      <form class="form-horizontal" id="enrollment_study-form" method="get">
                        <label class="control-label" for="enrollment_study">Estudi:&nbsp;&nbsp;</label>
                        <select id="enrollment_study" name="enrollment_study" class="select2" data-placeholder="Selecciona un Estudi">
                          <option value=""></option>
                          <? foreach($enrollment_studies as $enrollment_study): ?>
                          <option value="<?php echo $enrollment_study['studies_id']; ?>"><?php echo $enrollment_study['studies_shortname']; ?></option>
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
                <div class="row-fluid center">
                  <h3 class="blue lighter"><?php echo lang('enrollment_courses');?></h3>
                  Seleccionar un Curs.
                </div>
                <div class="step1_student"></div>
                <div class="step2_selected_academic_period"></div>
                <div class="step3_selected_study"></div> 
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4>Curs</h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
                      <form class="form-horizontal" id="enrollment_course-form" method="get">
                        <label class="control-label" for="enrollment_course">Curs:&nbsp;&nbsp;</label>
                        <select id="enrollment_course" name="enrollment_course" class="select2" data-placeholder="Selecciona un Curs">
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
                <div class="center">
                  <h3 class="blue lighter"><?php echo lang('enrollment_classgroups');?></h3>
                  Han de sortir els grups de classe de l'estudi.
                </div>
                <div class="step1_student"></div>
                <div class="step2_selected_academic_period"></div>
                <div class="step3_selected_study"></div>                
                <div class="step4_selected_course"></div>
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4>Grup de Classe</h4>
                  </div>
                  <div class="widget-body">
                    <div class="widget-main">
                      <form class="form-horizontal" id="classroom_group-form" method="get">
                        <div id="step4_classroom_group" class="form-group">
                          <label class="control-label" for="enrollment_study">Grups de Classe:&nbsp;&nbsp;</label>
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
                <div class="center">
                  <h3 class="green"><?php echo lang('enrollment_modules');?></h3>
                  Per defecte tots els mòduls marcats.
                </div>
                <div class="step1_student"></div>
                <div class="step2_selected_academic_period"></div>
                <div class="step3_selected_study"></div>                
                <div class="step4_selected_course"></div>
                <div class="step5_selected_classroom_group"></div>
                <div class="widget-box ">
                  <div class="widget-header">
                    <h4>Mòdul</h4>
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
                <div class="center">
                  <h3 class="green"><?php echo lang('enrollment_submodules');?></h3>
                  Unitats formatives - Tots marcats de tots els MPS del pas anterior.
                </div>
                <div class="step1_student"></div>
                <div class="step2_selected_academic_period"></div>
                <div class="step3_selected_study"></div>                
                <div class="step4_selected_course"></div>
                <div class="step5_selected_classroom_group"></div>                            
                <div class="step6_selected_study_module"></div>

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
    <!-- COURSE WIDGET -->
                      <div class="step6_course_widget"></div>
    <!-- /COURSE WIDGET -->
                    </div><!-- /widget-main -->
                  </div><!-- /widget-body -->
                </div><!-- /widget-box -->
<!-- /STUDY WIDGET -->

              </div><!-- /step6 -->
            </div><!-- /step-container -->
            <hr />
            <div class="row-fluid wizard-actions">
              <button class="btn btn-prev">
                <i class="icon-arrow-left"></i>
                Prev
              </button>
              <button class="btn btn-success btn-next" data-last="Finish ">
                Next
                <i class="icon-arrow-right icon-on-right"></i>
              </button>
            </div><!-- /wizard-actions -->
          </div><!-- /widget-main -->
        </div><!-- /widget-body -->
      </div><!-- /widget-box -->
    </div><!-- /row-fluid -->
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
      jQuery(function($) {
      
      student_official_id = $('#student_official_id');
      student_official_id_label = $('#lbl_student_official_id');

      rb_official_id_type = $("input[name=official_id_type]:radio");
      official_id_type = rb_official_id_type.val();
      official_id_type_text = $("input:checked + span").text();

      rb_official_id_type.change(function () {
        official_id_type = $(this).val();
        official_id_type_text = $("input:checked + span").text();
        student_official_id.attr("placeholder", "Escriu el "+official_id_type_text);  
        student_official_id_label.text(official_id_type_text);      

      });

        $('[data-rel=tooltip]').tooltip();

/******************
 *  Editable Avatar
 ******************/

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
              btn_choose: 'Change Avatar',
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
                    title: 'File is not an image!',
                    text: 'Please choose a jpg|gif|png image!',
                    class_name: 'gritter-error gritter-center'
                  });
                } else if(code == 2) {//file size rror
                  last_gritter = $.gritter.add({
                    title: 'File too big!',
                    text: 'Image size should not exceed 100Kb!',
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
              // ***UPDATE AVATAR HERE*** //
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
                  title: 'Avatar Updated!',
                  text: 'Uploading to server can be easily implemented. A working example is included with the template.',
                  class_name: 'gritter-info gritter-center'
                });
                
               } , parseInt(Math.random() * 800 + 800))
      
              return deferred.promise();
            },
            
            success: function(response, newValue) {
            }
          })
        }catch(e) {}
        

/******************
 *  /Editable Avatar
 ******************/


        $('select.academic_period').select2();
       
        $(".select2").css('width','400px').select2({
          allowClear:true
        }).on('change', function(){
          $(this).closest('form').validate().element($(this));
        }); 
  
        var actual_step = $('ul.wizard-steps').children().hasClass('active');      
        if(actual_step == false){
          $('ul.wizard-steps li').first().addClass('active');
          $('#step-container div').first().addClass('active');
        } 

        /* username */
        username = $('#username');
        givenName_input = $('#givenName');
        sn1_input = $('#sn1');                

        givenName = givenName_input.val();
        sn1 = sn1_input.val();

        givenName_input.change(function(){
          //alert(givenName_input.val());
          givenName = givenName_input.val();
          username.val(accent_fold(givenName.toLowerCase()+sn1.toLowerCase()));
        });

        sn1_input.change(function(){
          sn1 = sn1_input.val();
          username.val(accent_fold(givenName.toLowerCase()+sn1.toLowerCase()));
        });        

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
                datatype: 'json'
              }).done(function(data){
                data = $.parseJSON(data);
                password = data['password'];
                $('#generated_password').val(password);
              });


        /* DNI blur action -> gets student data from database */
        $("#student_official_id").change(function(){
          student = $(this).val();

              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/check_student");?>',
                type: 'post',
                data: {
                    student_official_id : student
                },
                datatype: 'json'
              }).done(function(data){

                /* Student Exists */
                if(data != false){
                  var student_exist = $("#student_exists");
                  student_exist.html("<i class='icon-ok green'></i> L'alumne ja existeix <button class='close' data-dismiss='alert' type='button'><i class='icon-remove'></i></button>")
                  .addClass("alert alert-block alert-success");

                  /* Show notification during 5 seconds */
                  setTimeout(function(){
                    student_exist.html('');
                    student_exist.removeClass("alert alert-block alert-success")
                  },5000);

                  var all_data = $.parseJSON(data);

                $.each(all_data, function(idx,obj) {
                  
                  /* Fill form with student data from Database */
                  $("#step0 input[name$="+idx+"]").val(obj);
                    student_full_name = $('#student_full_name').find("span.white");
                  if(idx=='person_photo'){
                    var student_photo = $('#student_photo');

                    student_photo.html('<span class="profile-picture"><img id="avatar" style="height: 150px;" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url('uploads/person_photos'); ?>/'+obj+'" alt="'+ obj +'"/></span>');
                  }
                    student_full_name.text(all_data['person_givenName']+" "+all_data['person_sn1']+" "+all_data['person_sn2']);
                });

                /* Student doesn't exists, clear form data */
                } else {

                    empty_student = {"person_id":"",
                    "person_photo":"","person_secondary_official_id":"","person_givenName":"",
                    "person_sn1":"","person_sn2":"","person_email":"","person_date_of_birth":"",
                    "person_gender":"","person_homePostalAddress":"","person_locality_name":"",
                    "person_telephoneNumber":"","person_mobile":""}

                    student_photo = $('#student_photo');
                    student_photo.html('<span class="profile-picture"><img id="avatar" style="height: 150px;" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url('assets/img/alumnes/foto.png'); ?>" alt="photo"/></span>');                  
                    student_full_name.text('Alumne');
                    $.each(empty_student, function(idx,obj) {
                      $("#step0 input[name$="+idx+"]").val(obj);
                    });
                }

              });

        });

      $(".btn-next").click(function(){

        step = $("#step-container div.active").attr("id");

/***********
 *  STEP 0 - Student Personal Data
 ***********/

        if(step == "step0"){

          /* store student data from form */
          student_person_id = $("#"+step+" input[name$='person_id']").val();
          student_givenName = $("#"+step+" input[name$='person_givenName']").val();
          student_sn1 = $("#"+step+" input[name$='person_sn1']").val();
          student_sn2 = $("#"+step+" input[name$='student_sn2']").val();

          student_username = $("#"+step+" input[name$='person_username']").val();
          student_generated_password = $("#"+step+" input[name$='person_generated_password']").val();
          student_password = $("#"+step+" input[name$='person_password']").val();
          student_verify_password = $("#"+step+" input[name$='person_verify_password']").val();

          student_email = $("#"+step+" input[name$='student_email']").val();
          student_official_id = $("#"+step+" input[name$='student_official_id']").val();
          student_secondary_official_id = $("#"+step+" input[name$='student_secondary_official_id']").val();
          student_date_of_birth = $("#"+step+" input[name$='student_date_of_birth']").val();
          student_gender = $("#"+step+" input[name$='student_gender']").val();
          student_homePostalAddress = $("#"+step+" input[name$='student_homePostalAddress']").val();
          student_locality_name = $("#"+step+" input[name$='student_locality_name']").val();
          student_telephoneNumber = $("#"+step+" input[name$='student_telephoneNumber']").val();
          student_mobile = $("#"+step+" input[name$='student_mobile']").val();

if(student_password != student_verify_password){
  //alert("NO");
} else {
  //alert("SI");
}

          $("#student option[value=" + student_person_id +"]").attr("selected","selected");
          $("#student").select2();

          $(".step1_student").html("<p>Alumne: "+student_givenName+" ("+student_official_id+") </p>");          

// End step 0
        
/***********
 *  STEP 1 - Academic Period and Student Data
 ***********/

        } else if(step == "step1"){

          academic_period = $("#academic_period option:selected").text();
          student_dni = $("#"+step+" input[name$='student_personal_id']").val();
          student_name = $("#student option:selected").text();
          student_id = $("#student option:selected").val();
          
          //$(".step2_selected_student").html("<p>Periode Acadèmic: "+academic_period+"</p><p>Alumne: "+student_name+" ("+student_id+") </p>");          
          $(".step2_selected_academic_period").html("<p>Periode Acadèmic: "+academic_period+" </p>");          

// End step 1
        
/***********
 *  STEP 2 - Study Data
 ***********/

        } else if(step == "step2"){
        
          study_id = $("#enrollment_study").val();
          
          study_name = $("#enrollment_study option:selected").text();
          $("#enrollment_study").change(function(){
              study_id = $("#enrollment_study").val();
              study_name = $("#enrollment_study option:selected").text();

          });    
 
              // AJAX get Classroom_Group from Study for step 4
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/classroom_course");?>',
                type: 'post',
                data: {
                    study_id : study_id
                },
                datatype: 'json'
              }).done(function(data){
              
                courses = [];
                var $_courses = $('select#enrollment_course');
                var $_course_widget = $('div.step6_course_widget');
                $_courses.empty();
                $.each(JSON.parse(data), function(idx, obj) {
                  $_courses.append($('<option></option>').attr("value",obj.course_id).text(obj.course_name));
                  courses.push(obj.course_id);

                  $_course_widget.append("<div class='widget-box'>"+
                                            "<div class='widget-header'>"+
                                              "<h4>"+obj.course_name+"</h4>"+
                                              "<div class='widget-toolbar'>"+
                                                "<a data-action='collapse' href='#'>"+
                                                  "<i class='icon-chevron-up'></i>"+
                                                "</a>"+
                                              "</div><!-- /widget-toolbar -->"+
                                            "</div><!-- /widget-header -->"+
                                            "<div class='widget-body'>"+
                                              "<div class='widget-main'>"+
                                                "<div class='module_widget'></div>"+
                                              "</div><!-- /widget-main -->"+
                                            "</div><!-- /widget-body -->"+
                                          "</div><!-- /widget-box -->");
                });
              
              });

              $(".step3_selected_study").html("<p>Estudi: "+study_name+" ("+study_id+") </p>");  
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
                    study_id : study_id
                },
                datatype: 'json'
              }).done(function(data){
                classroom_groups = [];
                var $_classroom_group = $('select#classroom_group');
                
                $_classroom_group.empty();
                $.each(JSON.parse(data), function(idx, obj) {
                  $_classroom_group.append($('<option></option>').attr("value",obj.classroom_group_id).text(obj.classroom_group_name));
                  classroom_groups.push(obj.classroom_group_id);
                });

              });

              $(".step4_selected_course").html("<p>Curs: "+course_name+" ("+course_id+") </p>");         
              $("#course_name").text(course_name);
// End step 3

/***********
 *  STEP 4 - Classroom Group Data
 ***********/

        } else if(step == "step4") {

          //alert(classroom_groups);

          classroom_group_name = $("select#classroom_group option:selected").text();
          classroom_group_id = $("select#classroom_group option:selected").val();

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
                    classroom_group_id : classroom_group_id,
                    classroom_groups : classroom_groups
                },
                datatype: 'json'
              }).done(function(data){

                var $_study_module = $('#checkbox_study_module');
                var $_module_widget = $('div.module_widget');   
                $_study_module.empty();
                
                $.each(JSON.parse(data), function(idx, obj) {
                  
                  //console.log("Data: "+data);
                  //$_study_module.append('<h3>'+idx+'</h3>');
                  $_study_module.append("<div class='widget-box'>"+
                                            "<div class='widget-header'>"+
                                              "<h3>"+idx+"</h3>"+
                                              "<div class='widget-toolbar'>"+
                                                "<a data-action='collapse' href='#'>"+
                                                  "<i class='icon-chevron-up'></i>"+
                                                "</a>"+
                                              "</div><!-- /widget-toolbar -->"+
                                            "</div><!-- /widget-header -->"+
                                            "<div class='widget-body'>"+
                                              "<div class='step4_widget-main_"+idx+" widget-main'>");  
                        var $_step4_widget_main = $(".step4_widget-main_"+idx);
                        $_step4_widget_main.empty();
                        $.each(obj, function(index, object){
                          //console.log("Object: "+object);

                          if(object.selected_classroom_group=="yes"){
                            checked = 'checked';
                          } else {
                            checked = '';
                          }

                          $_step4_widget_main.append('<input class="ace" type="checkbox" '+ checked +' name="'+object.study_module_shortname+'" value="'+object.study_module_id+'"/> <span class="lbl">  ('+object.classroom_group_code+') '+object.study_module_shortname+' - '+object.study_module_name+' ('+object.study_module_id+')</span><br />');

                          $_module_widget.append("<div class='widget-box'>"+
                                                  "<div class='widget-header'>"+
                                                    "<h4>"+object.study_module_name+"</h4>"+
                                                    "<div class='widget-toolbar'>"+
                                                      "<a data-action='collapse' href='#'>"+
                                                        "<i class='icon-chevron-up'></i>"+
                                                      "</a>"+
                                                    "</div><!-- /widget-toolbar -->"+
                                                  "</div><!-- /widget-header -->"+
                                                  "<div class='widget-body'>"+
                                                    "<div class='widget-main'>"+
                                                      "<div class='submodule_widget'></div><!-- /submodule-widget -->"+
                                                    "</div><!-- /widget-main -->"+
                                                  "</div><!-- /widget-body -->"+
                                                "</div><!-- /widget-box -->");

                          });
                  
                  $_study_module.append("</div><!-- /widget-main -->"+
                                        "</div><!-- /widget-body -->"+
                                        "</div><!-- /widget-box --><br />");
                });                  

            });
              
              $(".step5_selected_classroom_group").html("<p>Grup de classe: "+classroom_group_name+"</p>");          

// End step 4

/***********
 *  STEP 5 - Study Modules
 ***********/

        } else if(step == "step5") {
          
        study_module_names = $('#checkbox_study_module input:checked').map(function(){
          return this.name;
        }).get();

        study_module_ids = $('#checkbox_study_module input:checked').map(function(){
          return $(this).val()
        }).get();
        study_module_ids = study_module_ids.toString().replace(/,/g ,"-");

              //AJAX get Study_Submodules from Study_Modules for step 6
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/study_submodules");?>',
                type: 'post',
                data: {
                    study_module_ids : study_module_ids,
                    classroom_group_id : classroom_group_id,
                    classroom_groups : classroom_groups
                },
                datatype: 'json'
              }).done(function(data){

               var $_study_submodule = $('#checkbox_study_submodules');
               $_study_submodule.empty();

                $.each(JSON.parse(data), function(idx, obj) {
                $_study_submodule.append($('<input type="checkbox" checked name="'+obj.study_submodules_shortname+'" value="'+obj.study_submodules_study_module_id+'#'+obj.study_submodules_id+'"/> ('+obj.study_module_shortname+') '+obj.study_submodules_shortname+' - '+obj.study_submodules_name+' ('+obj.study_submodules_id+')<br />'));

                });
              }).fail(function(){
                //alert(data);
              });

        $(".step6_selected_study_modules").html("<p>Mòduls sel·leccionats: "+study_module_names+"</p>");
        $("#study_module_name").text(study_module_names);
// End step 5

/***********
 *  STEP 6 - Study Submodules Data
 ***********/

        } else if(step == "step6") {

        var study_submodules_names = $('#checkbox_study_submodules input:checked').map(function(){
          return this.name;
        }).get();

        var study_submodules_ids = $('#checkbox_study_submodules input:checked').map(function(){
          return $(this).val()
        }).get();
        study_submodules_ids = study_submodules_ids.toString().replace(/,/g ,"-");

          alert("Alumne: "+student_name+"\nEstudi: "+study_name+"\nGrup de Classe: "+classroom_group_name+"\nMòduls: "+study_module_names+" ("+study_module_ids+") \nUnitats Formatives: "+study_submodules_names+" ("+study_submodules_ids+")");

              // AJAX insert Enrollment data into database
              $.ajax({
                url:'<?php echo base_url("index.php/enrollment/enrollment_wizard");?>',
                type: 'post',
                data: { person_id: student_id,
                        period_id: academic_period,
                        study_id: study_id,
                        classroom_group_id: classroom_group_id,
                        study_module_ids: study_module_ids,
                        study_submodules_ids: study_submodules_ids
                      },
                datatype: 'json'
              }).done(function(data){

                //alert(data);
              });
        }
      });  

// End step 6



        var $validation = false;
        $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
          if(info.step == 1 && $validation) {
            if(!$('#validation-form').valid()) return false;
          }
        }).on('finished', function(e) {
          bootbox.dialog({
            message: "Thank you! Your information was successfully saved!", 
            buttons: {
              "success" : {
                "label" : "OK",
                "className" : "btn-sm btn-primary"
              }
            }
          });
        }).on('stepclick', function(e){
          //return false;//prevent clicking on steps
        });
      
        $('#skip-validation').removeAttr('checked').on('click', function(){
          $validation = this.checked;
          /*
          if(this.checked) {
            $('#sample-form').hide();
            $('#validation-form').removeClass('hide');
          }
          else {
            $('#validation-form').addClass('hide');
            $('#sample-form').show();
          }
          */
        });

        //documentation : http://docs.jquery.com/Plugins/Validation/validate
      
      
        $.mask.definitions['~']='[+-]';
        $('#person_telephoneNumber').mask('(999) 999-9999');
      
        /* VALIDAR DNI */

        jQuery.validator.addMethod( "student_official_id", function ( value, element ) {
         "use strict";
         
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
        
        }, "Please specify a valid NIF number.");
        /* /Validar dni */

        /*
        jQuery.validator.addMethod("person_telephoneNumber", function (value, element) {
          return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
        }, "Enter a valid phone number.");
        */

        $('#validation-form').validate({
          errorElement: 'div',
          errorClass: 'help-block',
          focusInvalid: false,
          rules: {
            student_official_id: {required: function(element) {
                  return $('input[name="official_id_type"]:checked').val() == 1;
            }

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
              required: true,
              person_telephoneNumber: 'required'
            },
            
            gender: 'required',
            agree: 'required'
          },
      
          messages: {
            person_email: {
              required: "Please provide a valid email.",
              email: "Please provide a valid email."
            },
            person_password: {
              required: "Please specify a password.",
              minlength: "Please specify a secure password."
            },
            subscription: "Please choose at least one option",
            gender: "Please choose gender",
            agree: "Please accept our policy"
          },
      
          invalidHandler: function (event, validator) { //display error alert on form submit   
            $('.alert-danger', $('.login-form')).show();
          },
      
          highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
          },
      
          success: function (e) {
            $(e).closest('.form-group').removeClass('has-error').addClass('has-info');
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
            else error.insertAfter(element.parent());
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