<body>
  <div class="navbar" id="navbar">
      <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
      </script>

      <div class="navbar-inner">
        <div class="container-fluid">
          <a href="#" class="brand">
            <small>
              <i class="icon-leaf"></i>
              Ebre-escool
            </small>
          </a><!-- /.brand -->


          <ul class="nav ace-nav pull-right">
            <?php if ($this->session->userdata('is_admin')): ?>
            <li class="grey" style="">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="icon-tasks"></i>
                <span class="badge badge-grey">4</span>
              </a>

              <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-closer">
                <li class="nav-header">
                  <i class="icon-ok"></i>
                  4 Tasks to complete
                </li>

                <li>
                  <a href="#">
                    <div class="clearfix">
                      <span class="pull-left">Software Update</span>
                      <span class="pull-right">65%</span>
                    </div>

                    <div class="progress progress-mini ">
                      <div style="width:65%" class="bar"></div>
                    </div>
                  </a>
                </li>

                <li>
                  <a href="#">
                    <div class="clearfix">
                      <span class="pull-left">Hardware Upgrade</span>
                      <span class="pull-right">35%</span>
                    </div>

                    <div class="progress progress-mini progress-danger">
                      <div style="width:35%" class="bar"></div>
                    </div>
                  </a>
                </li>

                <li>
                  <a href="#">
                    <div class="clearfix">
                      <span class="pull-left">Unit Testing</span>
                      <span class="pull-right">15%</span>
                    </div>

                    <div class="progress progress-mini progress-warning">
                      <div style="width:15%" class="bar"></div>
                    </div>
                  </a>
                </li>

                <li>
                  <a href="#">
                    <div class="clearfix">
                      <span class="pull-left">Bug Fixes</span>
                      <span class="pull-right">90%</span>
                    </div>

                    <div class="progress progress-mini progress-success progress-striped active">
                      <div style="width:90%" class="bar"></div>
                    </div>
                  </a>
                </li>

                <li>
                  <a href="#">
                    See tasks with details
                    <i class="icon-arrow-right"></i>
                  </a>
                </li>
              </ul>
            </li>

            <li class="purple" style="">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="icon-bell-alt icon-animated-bell"></i>
                <span class="badge badge-important">8</span>
              </a>

              <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-closer">
                <li class="nav-header">
                  <i class="icon-warning-sign"></i>
                  8 Notifications
                </li>

                <li>
                  <a href="#">
                    <div class="clearfix">
                      <span class="pull-left">
                        <i class="btn btn-mini no-hover btn-pink icon-comment"></i>
                        New Comments
                      </span>
                      <span class="pull-right badge badge-info">+12</span>
                    </div>
                  </a>
                </li>

                <li>
                  <a href="#">
                    <i class="btn btn-mini btn-primary icon-user"></i>
                    Bob just signed up as an editor ...
                  </a>
                </li>

                <li>
                  <a href="#">
                    <div class="clearfix">
                      <span class="pull-left">
                        <i class="btn btn-mini no-hover btn-success icon-shopping-cart"></i>
                        New Orders
                      </span>
                      <span class="pull-right badge badge-success">+8</span>
                    </div>
                  </a>
                </li>

                <li>
                  <a href="#">
                    <div class="clearfix">
                      <span class="pull-left">
                        <i class="btn btn-mini no-hover btn-info icon-twitter"></i>
                        Followers
                      </span>
                      <span class="pull-right badge badge-info">+11</span>
                    </div>
                  </a>
                </li>

                <li>
                  <a href="#">
                    See all notifications
                    <i class="icon-arrow-right"></i>
                  </a>
                </li>
              </ul>
            </li>

            <li class="green" style="">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="icon-envelope icon-animated-vertical"></i>
                <span class="badge badge-success">5</span>
              </a>

              <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-closer">
                <li class="nav-header">
                  <i class="icon-envelope-alt"></i>
                  5 Messages
                </li>

                <li>
                  <a href="#">
                    <img src="<?php echo base_url('assets/avatars/avatar.png');?>" class="msg-photo" alt="Alex's Avatar" />
                    <span class="msg-body">
                      <span class="msg-title">
                        <span class="blue">Alex:</span>
                        Ciao sociis natoque penatibus et auctor ...
                      </span>

                      <span class="msg-time">
                        <i class="icon-time"></i>
                        <span>a moment ago</span>
                      </span>
                    </span>
                  </a>
                </li>

                <li>
                  <a href="#">
                    <img src="<?php echo base_url('assets/avatars/avatar3.png');?>" class="msg-photo" alt="Susan's Avatar" />
                    <span class="msg-body">
                      <span class="msg-title">
                        <span class="blue">Susan:</span>
                        Vestibulum id ligula porta felis euismod ...
                      </span>

                      <span class="msg-time">
                        <i class="icon-time"></i>
                        <span>20 minutes ago</span>
                      </span>
                    </span>
                  </a>
                </li>

                <li>
                  <a href="#">
                    <img src="<?php echo base_url('assets/avatars/avatar4.png');?>" class="msg-photo" alt="Bob's Avatar" />
                    <span class="msg-body">
                      <span class="msg-title">
                        <span class="blue">Bob:</span>
                        Nullam quis risus eget urna mollis ornare ...
                      </span>

                      <span class="msg-time">
                        <i class="icon-time"></i>
                        <span>3:15 pm</span>
                      </span>
                    </span>
                  </a>
                </li>

                <li>
                  <a href="#">
                    See all messages
                    <i class="icon-arrow-right"></i>
                  </a>
                </li>
              </ul>
            </li>


            

              <li class="dark-blue">
                <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                  Administrador <i class="icon-caret-down"></i>
                </a>

                <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
                  <li>
                    <a href="#">
                      <i class="icon-cog"></i>
                      Configuració general (TODO)
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <i class="icon-user"></i>
                      Suplantació d'identitat
                    </a>
                  </li>

                  <li class="divider"></li>

                  <li>
                    <a href="#">
                      Altres
                    </a>
                  </li>
                </ul>
              </li>

            <?php endif; ?>

            <li class="light-blue">
              <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                <img class="nav-user-photo" src="<?php echo base_url('uploads/person_photos/' . $this->session->userdata('photo'));?>" 
                  style="max-height: 36px !important;" alt="Foto de <?php echo $this->session->userdata('username');?>" />
                <span class="user-info" style="line-height: 16px;">
                  <small><?php echo lang('Welcome'); ?></small>
                  <?php echo $this->session->userdata('username');?>
                </span>

                <i class="icon-caret-down"></i>
              </a>

              <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
                
                <li>
                  <a href="#">
                    <i class="icon-cog"></i>
                    <?php echo lang('configuration'); ?>
                  </a>
                </li>

                <li>
                  <a href="<?php echo base_url('/index.php/managment/change_password')?>">
                    <i class="icon-key"></i>
                    <?php echo lang('change_password'); ?>
                  </a>
                </li>

                <li>
                  <a href="<?php echo base_url('/index.php/persons/persons/profile')?>" alt="Foto de <?php echo $this->session->userdata('username');?>">
                    <i class="icon-user"></i>
                    <?php echo lang('profile'); ?>
                  </a>
                </li>

                <li class="divider"></li>

                <li>
                  <a href="<?php echo base_url('/index.php/skeleton_auth/ebre_escool_auth/logout'); ?>">
                    <i class="icon-off"></i>
                    <?php echo lang('Exit'); ?>
                  </a>
                </li>
              </ul>
            </li>


          </ul><!-- /.ace-nav -->

        </div><!-- /.container-fluid -->
      </div><!-- /.navbar-inner -->
    </div>



    <div class="main-container container-fluid">
      <a class="menu-toggler" id="menu-toggler" href="#">
        <span class="menu-text"></span>
      </a>

      <div class="sidebar" id="sidebar">
        <script type="text/javascript">
          try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
        </script>

        <div class="sidebar-shortcuts" id="sidebar-shortcuts">
          <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <a href="<?php echo base_url('/index.php/dashboard'); ?>">
              <button class="btn btn-small btn-success">
                <i class="icon-signal"></i>
              </button>
            </a>

            <a href="#" data-toggle="dropdown" class="dropdown-toggle">
              <button class="btn btn-small btn-info">
                <i class="icon-flag"></i>
              </button>
            </a>
            <ul class="dropdown-menu light-blue dropdown-closer" style="margin-top:35px;margin-left:45px">
              <li><a href="<?=base_url()?>index.php/skeleton_main/change_language/catalan"><?php echo lang('catalan');?></a></li>
              <li><a href="<?=base_url()?>index.php/skeleton_main/change_language/spanish"><?php echo lang('spanish');?></a></li>
              <li><a href="<?=base_url()?>index.php/skeleton_main/change_language/english"><?php echo lang('english');?></a></li>                           
            </ul>

            <?php if ($this->session->userdata('is_admin')): ?> 
              <a href="<?php echo base_url('index.php/skeleton/users');?>">    
                <button class="btn btn-small btn-warning">
                  <i class="icon-group"></i>
                </button>
              </a>  
            <?php else: ?>            
              <a href="<?php echo base_url('index.php/persons/persons/profile');?>">    
                <button class="btn btn-small btn-warning">
                  <i class="icon-user"></i>
                </button>
              </a> 
            <?php endif; ?>
              
            <a href="<?php echo base_url('index.php/skeleton/preferences');?>">
              <button class="btn btn-small btn-danger">
                <i class="icon-cogs"></i>
              </button>
            </a>  
          </div>

          <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
          </div>
        </div><!-- #sidebar-shortcuts -->



<?php 
  /* Getting Active Menu */
  //$menu = $this->session->flashdata('menu');
  //print_r($menu); 
  $menu = json_encode($menu);
  echo "<script>var menu = ". $menu . ";</script>";

  if ( ! isset($is_teacher) ) {
    $is_teacher = $this->session->userdata('is_teacher');
  }
?>

        <ul class="nav nav-list">
         <!-- PANELL DE CONTROL -->
         <?php if ( ! $this->session->userdata('is_student')) : ?>

            <li id="dashboard" class="active">
              <a href="<?php echo base_url('/index.php/dashboard'); ?>">
                <i class="icon-dashboard"></i>
                <span class="menu-text"> <?php echo lang('control_panel'); ?> </span>
              </a>
            </li>
          <?php endif; ?> 


          <!-- PASSAR LLISTA -->
          

          <?php $is_admin = $this->session->userdata('is_admin');if ( isset( $is_teacher ) || isset($is_admin) ): ?>
           <?php if ( $is_teacher || $this->session->userdata('is_admin')) : ?>
            <li id="check_attendance">
              <a href="<?php echo base_url('/index.php/attendance/check_attendance'); ?>">
                <i class="icon-bell"></i>
                <span class="menu-text"> <?php echo lang('check_attendance');?> </span>
              </a>
            </li>  
           <?php endif; ?>
          <?php endif; ?> 

          

          <!-- TUTORIA -->
          <li id="mentoring">
            <a href="#" class="dropdown-toggle">
              <i class="icon-eye-open"></i>
              <span class="menu-text"> <?php echo lang('mentoring');?> </span>
              <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
              <?php if ( $this->session->userdata('is_student') || ($this->session->userdata('is_admin'))) : ?>

                <li id="mentoring_check_attendance">
                    <a href="#">
                      <i class="icon-double-angle-right"></i>
                      <?php echo "Consulta faltes. Pendent.";?>
                    </a>
                </li>
              <?php endif ?>  

              <?php if ( $this->session->userdata('is_teacher') || ($this->session->userdata('is_admin'))) : ?>
                  
                  <!-- Llistes de classe -->
                  <li id="mentoring_classlists">
                    <a href="<?=base_url()?>index.php/reports/mentoring_classlists">
                      <i class="icon-double-angle-right"></i>
                      <?php echo lang('mentoring_classlists');?>
                    </a>
                  </li>


                  <!-- tutoritza els teus grups -->
                  <li id="mentoring_groups">
                    <a href="<?=base_url()?>index.php/attendance/mentoring_groups">
                      <i class="icon-double-angle-right"></i>
                      <?php echo lang('mentoring_groups_mentoring');?>
                    </a>
                  </li>
                  <!-- llistat de faltes per alumne -->
                  <li id="mentoring_attendance_by_student">
                    <a href="<?=base_url()?>index.php/attendance/mentoring_attendance_by_student">
                      <i class="icon-double-angle-right"></i>
                      <?php echo lang('mentoring_attendance_by_student');?>
                    </a>
                  </li>
              <?php endif ?>

              </ul>

              
              
          <!-- HORARIS -->
          <li id="timetables">
            <a href="#" class="dropdown-toggle">
              <i class="icon-calendar"></i>
              <span class="menu-text"> <?php echo lang('timetables');?> </span>
              <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
              <!-- els meus horaris -->
              <li id="mytimetables">
                <a href="<?php echo base_url('/index.php/timetables/mytimetables'); ?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('my_timetables');?>
                </a>
              </li>
              <!-- horaris de tots els professors -->
              <li id="allteacherstimetables">
                <a href="<?php echo base_url('/index.php/timetables/allteacherstimetables'); ?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('all_teachers_timetables');?>
                </a>
              </li>
              <!-- tots els horaris de grups -->
              <li id="allgroupstimetables">
                <a href="<?php echo base_url('/index.php/timetables/allgroupstimetables'); ?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('all_groups_timetables');?>
                </a>
              </li>

            </ul>
          </li>

          <!-- Matrícula -->
          <li id="enrollment_wizard">
            <a href="#" class="dropdown-toggle">
              <i class="icon-calendar"></i>
              <span class="menu-text"> <?php echo lang('enrollment');?> </span>
              <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
              <!-- Enrollment wizard -->
              <?php if ($this->session->userdata('is_admin')): ?>
              <li id="wizard">
                <a href="<?php echo base_url('/index.php/enrollment/wizard'); ?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('enrollment');?>
                </a>
              </li>
              <?php endif?>

              <!-- Enrollment wizard without modifyng user data including not modifying passwords-->
              <?php if ($this->session->userdata('is_admin')): ?>
              <li id="wizard">
                <a href="<?php echo base_url('/index.php/enrollment/wizard_without_modify_person_and_user_data'); ?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('enrollment_without_modify_person_and_user_data');?>
                </a>
              </li>
              <?php endif?>
              
              <!-- Enrollment query by person -->
              <li id="enrollment_query_by_person">
                <a href="<?php echo base_url('/index.php/enrollment/enrollment_query_by_person'); ?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('enrollment_query_by_person');?>
                </a>
              </li>

              <!-- Change classroom_group -->
              <?php if ($this->session->userdata('is_admin')): ?>
              <li id="enrollment_modify">
                <a href="<?php echo base_url('/index.php/enrollment/enrollment_modify'); ?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('enrollment_modify');?>
                </a>
              </li>
              <?php endif?>

              <!-- Change classroom_group -->
              <?php if ($this->session->userdata('is_admin')): ?>
              <li id="enrollment_change_classroomgroup">
                <a href="<?php echo base_url('/index.php/enrollment/change_classroom_group'); ?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('enrollment_change_classroomgroup');?>
                </a>
              </li>
              <?php endif?>

              <!-- Enrollment delete -->
              <?php if ($this->session->userdata('is_admin')): ?>
              
              <li id="enrollment_delete">
                <a href="<?php echo base_url('/index.php/enrollment/enrollment_delete'); ?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('enrollment_delete');?>
                </a>
              </li>
              

              <!-- enrollment_modify_person -->
              <li id="enrollment_modify_person">
                <a href="<?php echo base_url('/index.php/enrollment/enrollment_modify_person'); ?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('enrollment_modify_person');?>
                </a>
              </li>

              <?php endif?>

              <!-- person delete -->
              <?php if ($this->session->userdata('is_admin')): ?>
              <li id="enrollment_delete">
                <a href="<?php echo base_url('/index.php/persons/delete_person'); ?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo "TODO" . lang('enrollment_delete_user');?>
                </a>
              </li>
              <?php endif?>              



            </ul>
          </li>
          

          <!-- INFORMES -->
          <?php if ( ( $this->session->userdata('is_teacher') ) || ($this->session->userdata('is_admin')) ) : ?>

          <li id="reports">
            <a href="#" class="dropdown-toggle">
              <i class="icon-file-text"></i>
              <span class="menu-text"> <?php echo lang('reports');?> </span>
              <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
              <!-- GENERAL SHEET -->
              <li id="general_sheet_report">
                <a href="<?php echo base_url('/index.php/reports/general_sheet'); ?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo "Llençol general del centre";?>
                </a>
              </li>

              <!-- TEACHERS REPORTS -->
              <li id="teachers_reports">
                <a href="#" class="dropdown-toggle">
                  <i class="icon-double-angle-right"></i>

                  <?php echo "Professors";?>
                  <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">

                  <!-- TEACHERS SHEET -->
    
                  <li id="teachers_sheet_report">
                    <a href="<?php echo base_url('/index.php/teachers/teacher_sheet'); ?>">
                      <?php echo "Llençol de professors";?>
                    </a>
                  </li>

                  <?php if ($this->session->userdata('is_admin')): ?>
                    <li id="report_teachers_list">
                      <a href="<?php echo base_url('/index.php/teachers/report_teachers_list'); ?>">
                        <?php echo lang('reports_teachers_list');?>
                      </a>
                    </li>
                  <?php endif;?>  

                  <li id="reports_mentor_list">
                    <a href="<?php echo base_url('/index.php/teachers/tutors_report'); ?>">
                      <?php echo lang('reports_educational_center_reports_grup_mentors');?>
                    </a>
                  </li>

                </ul>                  
              </li>  

              <!-- STUDENTS REPORTS -->
              <li id="students_reports">
                <a href="#" class="dropdown-toggle">
                  <i class="icon-double-angle-right"></i>

                  <?php echo "Alumnes";?>
                  <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">

                  <li id="report_class_list">
                    <a href="<?php echo base_url('/index.php/attendance/attendance_reports/class_list_report'); ?>">
                        <?php echo lang('reports_group_reports_class_list');?>
                    </a>
                  </li>

                  <li id="report_class_sheet">
                    <a href="<?php echo base_url('/index.php/attendance/attendance_reports/class_sheet_report'); ?>">
                      <?php echo lang('reports_group_reports_student_sheet');?>
                    </a>
                  </li>

                  <!-- STUDENTS MAILING LIST-->    
                  <li id="report_mailing_list">
                    <a href="<?php echo base_url('/index.php/attendance/attendance_reports/mailing_list_report'); ?>">
                      <?php echo lang('reports_educational_center_reports_student_emails');?>
                    </a>
                  </li>

                </ul>                  
              </li> 

              <!-- CURRICULUM REPORTS -->
              <li id="curriculum_reports">
                <a href="#" class="dropdown-toggle">
                  <i class="icon-double-angle-right"></i>

                  <?php echo "Currículum";?>
                  <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">

                  <li id="curriculum_reports_departments">
                    <!--<a href="http://domini/ebre-escool/index.php/managment/users_in_group">-->
                    <a href="<?php echo base_url('/index.php/managment/curriculum_reports_departments'); ?>">
                      Departaments
                    </a>
                  </li>

                  <li id="curriculum_reports_study">
                    <!--<a href="http://domini/ebre-escool/index.php/managment/users_in_group">-->
                    <a href="<?php echo base_url('/index.php/managment/curriculum_reports_study'); ?>">
                      Estudis
                    </a>
                  </li>

                  <!--<li id="curriculum_reports_cicle">
                    <a href="<?php echo base_url('/index.php/managment/curriculum_reports_cicle'); ?>">
                      Cicles
                    </a>
                  </li>
                -->

                  <li id="curriculum_reports_course">
                    <!--<a href="http://domini/ebre-escool/index.php/managment/users_in_group">-->
                    <a href="<?php echo base_url('/index.php/managment/curriculum_reports_course'); ?>">
                      Curs
                    </a>
                  </li>

                  <li id="curriculum_reports_classgroup">
                    <!--<a href="http://domini/ebre-escool/index.php/managment/users_in_group">-->
                    <a href="<?php echo base_url('/index.php/managment/curriculum_reports_classgroup'); ?>">
                      Grups classe
                    </a>
                  </li>

                  <li id="curriculum_reports_studymodules">
                    <!--<a href="http://domini/ebre-escool/index.php/managment/users_in_group">-->
                    <a href="<?php echo base_url('/index.php/managment/curriculum_reports_studymodules'); ?>">
                      Mòduls professionals
                    </a>
                  </li>

                  <li id="curriculum_reports_studysubmodules">
                    <!--<a href="http://domini/ebre-escool/index.php/managment/users_in_group">-->
                    <a href="<?php echo base_url('/index.php/managment/curriculum_reports_studysubmodules'); ?>">
                      Unitat formatives
                    </a>
                  </li>

                  <!--
                  <li id="curriculum_reports_statistics_checkings_groups">

                    <a href="<?php echo base_url('/index.php/managment/statistics_checkings_groups'); ?>">
                        <?php echo lang('classroom_groups'); ?>

                    <a href="<?php echo base_url('/index.php/managment/statistics_checkings_groups');?>">
                        Grups de classe 1
                    </a>
                  </li>
                  -->
                  <!--
                  <li id="curriculum_reports_users_in_group">
                    <a href="<?php echo base_url('/index.php/managment/users_in_group'); ?>">
                      <?php echo lang('users_in_classroom_group'); ?>
                    </a>
                  </li>
                  -->
                  <!-- STUDENTS MAILING LIST-->    
                  <!--
                  <li id="curriculum_reports_lessons">
                    <a href="<?php echo base_url('/index.php/managment/statistics_checkings_groups');?>">
                      <?php echo "statistics_checkings_groups"; ?>
                    </a>
                  </li>
                  -->

                  <!-- LESSONS -->    
                  <li id="curriculum_reports_lessons">
                    <a href="<?php echo base_url('/index.php/managment/curriculum_reports_lessons');?>">
                      <?php echo lang('lessons'); ?>
                    </a>
                  </li>

                </ul>                  
              </li> 

              <!-- ENROLLMENT REPORTS -->
              <li id="enrollment_reports">
                <a href="#" class="dropdown-toggle">
                  <i class="icon-double-angle-right"></i>

                  <?php echo "Matrícula";?>
                  <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">

                  <li id="enrollment_reports_by_academic_period">
                    <!--<a href="http://domini/ebre-escool/index.php/managment/users_in_group">-->
                    <a href="<?php echo base_url('/index.php/managment/enrollment_reports_by_academic_period'); ?>">
                      Matrícula per períodes acadèmics
                    </a>
                  </li>

                  <li id="enrollment_reports_by_studies">
                    <!--<a href="http://domini/ebre-escool/index.php/managment/users_in_group">-->
                    <a href="<?php echo base_url('/index.php/managment/enrollment_reports_by_studies'); ?>">
                      Matrícula per estudis
                    </a>
                  </li>

                  <li id="enrollment_reports_all_enrolled_persons_by_academic_period">
                    <!--<a href="http://domini/ebre-escool/index.php/managment/users_in_group">-->
                    <a href="<?php echo base_url('/index.php/managment/enrollment_reports_all_enrolled_persons_by_academic_period'); ?>">
                      Tots els matriculats per període acadèmic 
                    </a>
                  </li>

                </ul>                  
              </li> 

              <!-- ATTENDANCE REPORTS -->
              <li id="attendance_reports">
                <a href="#" class="dropdown-toggle">
                  <i class="icon-double-angle-right"></i>

                  <?php echo "Assistència";?>
                  <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">

                  <?php if ($this->session->userdata('is_admin')): ?>
                      <li id="attendance_reports_all_incidents">
                        <!--<a href="http://domini/ebre-escool/index.php/attendance/attendance_reports/attendance_reports_all_incidents">-->
                        <a href="<?php echo base_url('/index.php/attendance/attendance_reports/attendance_reports_all_incidents'); ?>">
                          Totes les incidències per període acadèmic 
                        </a>
                      </li>
                  <?php endif?>

                  <!-- Assistència informes del centre -->
                  <li id="reports_educational_center">
                    <a href="#" class="dropdown-toggle">
                      <?php echo lang('attendance'). ".<br/>" . lang('reports_educational_center_reports');?>
                      <b class="arrow icon-angle-down"></b>
                    </a>

                    <ul class="submenu">
                      <li id="reports_center_by_d_h_1">
                        <a href="<?php echo base_url('/index.php/attendance/attendance_reports/all_attendance_incidents_at_day_and_hour_report'); ?>">
                          <?php echo lang('reports_educational_center_reports_incidents_by_day_and_hour');?>
                        </a>
                      </li>

                      <li id="reports_center_by_id_fd_1">
                        <a href="<?php echo base_url('/index.php/attendance/attendance_reports/all_attendance_incidents_day_range_report'); ?>">
                          <?php echo lang('reports_educational_center_reports_incidents_by_date');?>
                        </a>
                      </li>
                      
                      <li id="reports_center_ranking_id_fd_1">
                        <a href="<?php echo base_url('/index.php/attendance/attendance_reports/all_attendance_incidents_ranking_report'); ?>">
                          <?php echo lang('reports_educational_center_reports_incidents_by_date_ranking');?>
                        </a>
                      </li>
                    </ul>
                  </li>



                <!-- Assistència informes de grup -->
              <li id="report_group">
                <a href="#" class="dropdown-toggle">
                  <?php echo lang('attendance'). ".<br/> " . lang('reports_group_reports');?>
                  <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                  
                  <li id="report_group_incidents_by_id_fd_1">
                    <a href="<?php echo base_url('/index.php/attendance/attendance_reports/attendace_incidents_classgroup_summary_report'); ?>">
                      <?php echo lang('reports_group_reports_incidents_by_date');?>
                    </a>
                  </li>

                  <li id="report_group_monthly">
                    <a href="<?php echo base_url('/index.php/attendance/attendance_reports/attendance_incidents_classroomgroup_month_summary_report'); ?>">
                      <?php echo lang('reports_group_reports_monthly_report');?>
                    </a>
                  </li>

                </ul>
                
              </li>







                </ul>                  
              </li> 

              

              


              <!-- Inventari. Informes -->
              <li id="inventory_reports">
                <a href="#" class="dropdown-toggle">
                  <i class="icon-double-angle-right"></i>

                  <?php echo lang('inventory_reports'); ?>
                  <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                  <li id="inventory_reports_filters">
                    <a href="<?php echo base_url('/index.php/inventory/inventory_reports/inventory'); ?>">
                        <?php echo lang('all_inventory_with_filter_options'); ?>
                    </a>
                  </li>

                </ul>
              </li>

            </ul>
          </li>
          
          <?php endif?>
          <!-- INFORMES END --> 
          
          <!-- INVENTARI -->
          <?php if ($this->session->userdata('is_admin')): ?>
          <li id="inventory">
            <a href="<?=base_url()?>index.php/inventory/inventory">
              <i class="icon-check"></i>
              <span class="menu-text"><?php echo lang('inventory'); ?></span>
            </a>
          </li>
          <?php endif?>




          <!-- MANTENIMENTS professors -->
          <?php if ( $this->session->userdata('is_admin') || $this->session->userdata('is_teacher') ): ?>


           <li id="maintenances_teachers">
            <a href="#" class="dropdown-toggle">
              <i class="icon-briefcase"></i>
              <span class="menu-text">
                <?php echo lang('maintenances');?>
              </span>
              <b class="arrow icon-angle-down"></b>
            </a>

         
              
              <ul class="submenu">
              <!-- Persones -->
              <li id="maintenances_teachers_curriculum">
                <a href="#" class="dropdown-toggle">
                  <i class="icon-double-angle-right"></i>

                  <?php echo "Curriculum";?>

                  <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                  <li id="maintenances_teachers_curriculum_study_submodules_dates">
                    <a href="<?php echo base_url('/index.php/managment/study_submodules_dates'); ?>">
                       <?php echo "Dates UFs/UDs";?>
                    </a>
                  </li>

                  <li id="maintenances_teachers_curriculum_study_submodule_dates">
                    <a href="<?php echo base_url('/index.php/managment/study_submodule_dates'); ?>">
                       <?php echo "Dates d'una UF concreta";?>
                    </a>
                  </li>

                </ul>
              </li> 

            </ul>
          </li>    
          
          <?php endif;?>
           <!-- FI MANTENIMENTS PROFES-->



          
          <!-- MANTENIMENTS -->
          <?php if ( $this->session->userdata('is_admin') ) : ?>


          <li id="maintenances">
            <a href="#" class="dropdown-toggle">
              <i class="icon-briefcase"></i>
              <span class="menu-text">
                <?php echo lang('maintenances');?>
              </span>
              <b class="arrow icon-angle-down"></b>
            </a>

         
              
              <ul class="submenu">
              <!-- Persones -->
              <li id="persons">
                <a href="#" class="dropdown-toggle">
                  <i class="icon-double-angle-right"></i>

                  <?php echo lang('persons');?>

                  <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                  <li id="person">
                    <a href="<?php echo base_url('/index.php/persons'); ?>">
                       <?php echo lang('persons');?>
                    </a>
                  </li>
                  <li id="person_alt">
                    <a href="<?php echo base_url('/index.php/enrollment/enrollment_query_by_person/true'); ?>">
                       <?php echo "Persones vista alternativa";?>
                    </a>
                  </li>

                  <li id="teachers">
                    <a href="<?php echo base_url('/index.php/teachers'); ?>">
                      <?php echo lang('teachers');?>
                    </a>
                  </li>/

                  <li id="teachers_by_academic_period">
                    <a href="<?php echo base_url('/index.php/teachers/teachers_by_academic_period'); ?>">
                      <?php echo lang('teachers_by_academic_period');?>
                    </a>
                  </li>

                  <li id="employees">
                    <a href="<?php echo base_url('/index.php/employees'); ?>">
                      <?php echo lang('employees');?>
                    </a>
                  </li>

                  <li id="employees_type">
                    <a href="<?php echo base_url('/index.php/employees/employees_type'); ?>">
                      <?php echo lang('employees_type');?>
                    </a>
                  </li>                  

                  <li id="students">
                    <a href="<?php echo base_url('/index.php/students'); ?>">
                      <?php echo lang('students');?>
                    </a>
                  </li>
                  
                  <li id="person_official_id_type">
                    <a href="<?php echo base_url('/index.php/persons/person_official_id_type'); ?>">
                      <?php echo lang('personal_id_type');?>
                    </a>
                  </li>

                  <li id="localities">
                    <a href="<?php echo base_url('/index.php/persons/localities'); ?>">
                      <?php echo "Poblacions";?>
                    </a>
                  </li>

                  <li id="states">
                    <a href="<?php echo base_url('/index.php/persons/states'); ?>">
                      <?php echo "Províncies";?>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- Unitats Organitzatives -->
              <li id="organizational_unit">
                <a href="<?php echo base_url('/index.php/curriculum/organizational_unit'); ?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('organizationalunit_menu');?>
                </a>
              </li>
              <!-- Espais -->
              <li id="location">
                <a href="<?php echo base_url('/index.php/location/location'); ?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('location_menu');?>
                </a>
              </li>
              
              <!-- currículum -->
         <li id="curriculum">
          <a href="#" class="dropdown-toggle">
            <i class="icon-double-angle-right"></i>
            <?php echo lang("curriculum");?>

                  <b class="arrow icon-angle-down"></b>
          </a>
            <ul class="submenu">
              <!-- Manteniments -->
              <li id="academic_periods">
                <a href="<?php echo base_url('index.php/curriculum/academic_periods');?>">
                  <?php echo "Períodes acadèmics"; ?>
                </a>
              </li>
              <li id="studies_organizational_unit"><a href='<?=base_url()?>index.php/curriculum/studies_organizational_unit'><?php echo lang('organizational_unit_studies');?></a></li>
              <li id="departments"><a href='<?=base_url()?>index.php/curriculum/departments'><?php echo lang('departments');?></a></li>
              <li id="studies"><a href='<?=base_url()?>index.php/curriculum/studies'><?php echo lang('studies');?></a></li>
              <li id="studieslaw"><a href='<?=base_url()?>index.php/curriculum/studieslaw'><?php echo lang('studieslaw');?></a></li>
              <li id="cycle"><a href='<?=base_url()?>index.php/curriculum/cycle'><?php echo lang('cycles');?></a></li>
              <li id="course"><a href='<?=base_url()?>index.php/curriculum/course'><?php echo lang('course');?></a></li>
              <li id="classroom_group"><a href='<?=base_url()?>index.php/curriculum/classroom_group'><?php echo lang('classroom_group') . " (tots)";?></a></li>
              <li id="classroom_group_by_academic_period"><a href='<?=base_url()?>index.php/curriculum/classroom_group_by_academic_period'><?php echo lang('classroom_group') . " (anys)";?></a></li>
              <li id="study_module"><a href='<?=base_url()?>index.php/curriculum/study_module'><?php echo lang('study_module');?></a></li><!-- Assignatura -->
              <li id="study_module_academic_periods"><a href='<?=base_url()?>index.php/curriculum/study_module_academic_periods'><?php echo lang('study_module_academic_periods_alt');?></a></li>
              <li id="study_module_type"><a href='<?=base_url()?>index.php/curriculum/study_module_type'><?php echo lang('study_module_type_menuname');?></a></li><!-- Assignatura -->
              <li id="study_module_subtype"><a href='<?=base_url()?>index.php/curriculum/study_module_subtype'><?php echo lang('study_module_subtype_menuname');?></a></li><!-- Assignatura -->
              <li id="study_submodules"><a href='<?=base_url()?>index.php/curriculum/study_submodules'><?php echo lang('study_submodules');?></a></li><!-- Unitat Formativa -->
              <li id="study_submodules_academic_periods"><a href='<?=base_url()?>index.php/curriculum/study_submodules_academic_periods'><?php echo lang('study_submodules_academic_periods');?></a></li><!-- Unitat Formativa -->
              <li id="lessons"><a href='<?=base_url()?>index.php/curriculum/lessons'><?php echo lang('lessons');?></a></li><!-- Lliçons -->              
            </ul>
         </li>  
         
         <!-- matricula -->
         <li id="enrollment_menu">
          <a href="#" class="dropdown-toggle">
          <i class="icon-double-angle-right"></i>
            <?php echo lang('enrollment');?>
                  <b class="arrow icon-angle-down"></b>             
          </a>
           
            <ul class="submenu">
              <!-- Matrícules -->
              <li id="enrollment"><a href='<?=base_url()?>index.php/enrollment/enrollment'><?php echo lang('enrollment');?></a></li>              
              <li id="enrollment_only_current_period"><a href='<?=base_url()?>index.php/enrollment/enrollment_only_current_period'><?php echo lang('enrollment_only_current_period');?></a></li>              
              <li id="enrollment_submodules"><a href='<?=base_url()?>index.php/enrollment/enrollment_submodules'><?php echo lang('enrollment_submodules');?></a></li>                            
            </ul>                                                                                                                                                                                                                                                                                                                                      
         </li>      

        <!-- matricula -->
         <li id="attendance_maintainance">
          <a href="#" class="dropdown-toggle">
          <i class="icon-double-angle-right"></i>
            <?php echo lang('attendance');?>
                  <b class="arrow icon-angle-down"></b>             
          </a>
           
            <ul class="submenu">
              <!-- Matrícules -->
              <li id="attendance_incident"><a href='<?=base_url()?>index.php/attendance/incident'><?php echo lang('attendance_incidents');?></a></li>              
              <li id="attendance_incident_type"><a href='<?=base_url()?>index.php/attendance/incident_type'><?php echo lang('attendance_incident_types');?></a></li>
              <!--<li id="classroom_groups"><a href="<?php echo base_url('/index.php/attendance/classroom_groups'); ?>"><?php echo lang('classroom_groups')?></a></li>-->
              <li id="time_slots"><a href="<?php echo base_url('/index.php/attendance/time_slots'); ?>"><?php echo lang('time_slots')?></a></li>              
              <li id="hidden_students"><a href="<?php echo base_url('/index.php/attendance/hidden_students'); ?>"><?php echo lang('hidden_students')?></a></li>
            </ul>                                                                                                                                                                                                                                                                                                                                      
         </li> 

         <!-- Hores no lectives-->
         <li id="timetable">
          <a href="#" class="dropdown-toggle">
          <i class="icon-double-angle-right"></i>
            <?php echo lang('timetables');?>
                  <b class="arrow icon-angle-down"></b>             
          </a>
           
            <ul class="submenu">
              <li id="non_lective_hours"><a href='<?=base_url()?>index.php/timetables/non_lective_hours'><?php echo lang('non_lective_hours');?></a></li>              
              <li id="non_lective_lessons"><a href='<?=base_url()?>index.php/timetables/non_lective_lessons'><?php echo lang('non_lective_lessons');?></a></li>
              <li id="shift"><a href='<?=base_url()?>index.php/timetables/shift'><?php echo lang('shift');?></a></li>
            </ul>                                                                                                                                                                                                                                                                                                                                      
         </li> 
         <!-- Inventari -->
         <li id="inventory_menu">
          <a href="#" class="dropdown-toggle">
          <i class="icon-double-angle-right"></i>
            <?php echo lang('inventory');?>
                  <b class="arrow icon-angle-down"></b>             
          </a>
           
            <ul class="submenu">
              <li id="externalIDType"><a href='<?=base_url()?>index.php/inventory/externalIDType'><?php echo lang('externalid_menu');?></a></li>
              <li id="material_menu"><a href='<?=base_url()?>index.php/inventory/material'><?php echo lang('material_menu');?></a></li>
              <li id="brand_menu"><a href='<?=base_url()?>index.php/inventory/brand'><?php echo lang('brand_menu');?></a></li>
              <li id="model_menu"><a href='<?=base_url()?>index.php/inventory/model'><?php echo lang('model_menu');?></a></li>
              <li id="provider_menu"><a href='<?=base_url()?>index.php/inventory/provider'><?php echo lang('provider_menu');?></a></li>    
              <li id="money_source_menu"><a href='<?=base_url()?>index.php/inventory/money_source'><?php echo lang('money_source_menu');?></a></li>              
              <li id="barcode_menu"><a href='<?=base_url()?>index.php/inventory/barcode'><?php echo lang('barcode_menu');?></a></li>
            </ul>                                                                                                                                                                                                                                                                                                                                      
         </li> 

         <!-- Dades Bancaries -->
         <li id="bank_data">
          <a href="#" class="dropdown-toggle">
          <i class="icon-double-angle-right"></i>
            <?php echo lang('bank_data');?>
                  <b class="arrow icon-angle-down"></b>             
          </a>

            <ul class="submenu">
              <li id="bank_account"><a href='<?=base_url()?>index.php/banks/bank_account'><?php echo lang('bank_account');?></a></li>
              <li id="bank"><a href='<?=base_url()?>index.php/banks/bank'><?php echo lang('bank');?></a></li>
              <li id="bank_office"><a href='<?=base_url()?>index.php/banks/bank_office'><?php echo lang('bank_office');?></a></li>
              <li id="bank_account_type"><a href='<?=base_url()?>index.php/banks/bank_account_type'><?php echo lang('bank_account_type');?></a></li>
            </ul>                                                                                                                                                                                                                                                                                                                                      
         </li>


            </ul>

          </li>
          
          
          <?php endif?>
          <!-- END ADMIN MENUS -->

          <!-- GESTIÓ -->
          <?php if ($this->session->userdata('is_admin')): ?>
          <li id="managment">
            <a href="#" class="dropdown-toggle">
              <i class="icon-cog"></i>

              <span class="menu-text">
                <?php echo lang('managment');?>
              </span>

              <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">

              <!--<li id="managment_users">
                <a href="<?php echo base_url('index.php/skeleton/users');?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('users'); ?>
                </a>
              </li>-->

              <li id="managment_persons">
                <a href="<?php echo base_url('index.php/managment/persons');?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('persons'); ?>
                </a>
              </li>

              <li id="managment_users_not_gc">
                <a href="<?php echo base_url('index.php/managment/users');?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('users'); ?>
                </a>
              </li>

              <li id="managment_users">
                <a href="<?php echo base_url('index.php/users');?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('users'); ?> GC
                </a>
              </li>

              <li id="managment_users_google_apps">
                <a href="<?php echo base_url('index.php/managment/users_google_apps');?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('users_google_apps'); ?>
                </a>
              </li>

              <li id="managment_users_ldap">
                <a href="<?php echo base_url('index.php/managment/users_ldap');?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('users_ldap'); ?>
                </a>
              </li>

              <li id="managment_users_ldap">
                <a href="<?php echo base_url('index.php/managment/change_password/1');?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('change_password'); ?>
                </a>
              </li>

              <li id="managment_users_ldap">
                <a href="<?php echo base_url('index.php/managment/create_initial_password');?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('create_initial_password'); ?>
                </a>
              </li>

              <li id="managment_groups">
                <a href="<?php echo base_url('index.php/skeleton/groups');?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('groups'); ?>
                </a>
              </li>

              <li id="managment_massive_change_password">
                <a href="<?php echo base_url('index.php/managment/massive_change_password');?>">
                  <i class="icon-double-angle-right"></i>
                    <?php echo lang('massive_change_password'); ?>
                </a>
              </li>

              

              <li id="managment_preferences">
                <a href="<?php echo base_url('index.php/skeleton/preferences');?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('preferences'); ?>
                </a>
              </li>

              <li id="user_profile">
                <a href="<?php echo base_url('index.php/persons/persons/profile');?>">
                  <i class="icon-double-angle-right"></i>
                  <?php echo lang('user_profile'); ?>
                </a>
              </li>
              <?php endif?>

              <!--
              <li id="faq">
                <a href="faq.html">
                  <i class="icon-double-angle-right"></i>
                  FAQ
                </a>
              </li>
              -->
            </ul>
          </li>


        </ul><!-- /.nav-list -->

        <div class="sidebar-collapse" id="sidebar-collapse">
          <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
        </div>

        <script type="text/javascript">
          try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
        </script>
      </div><!-- /.sidebar -->
<!-- END OF body_header. DO NOT CLOSE main-container tag!!!!!. Closed in body footer-->