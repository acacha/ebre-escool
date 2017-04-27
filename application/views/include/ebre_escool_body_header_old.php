<div class="navbar navbar-inverse navbar-fixed-top">
 <div class="navbar-inner">
   <div class="container">
    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="brand" href="#"> <i class="icon-home"> </i>Ebre-escool</a>

    <div class="nav-collapse collapse">


     <ul class="nav">

       <li class="active"> <a href='<?=base_url()?>index.php/attendance/check_attendance'><?php echo lang('check_attendance');?></a> </li>


      <li class="dropdown">
       <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-toogle="tab"><?php echo lang('mentoring');?> <b class="caret"></b></a>
       <ul class="dropdown-menu">
         <li><a href="<?=base_url()?>index.php/attendance/mentoring_groups"><?php echo lang('mentoring_groups_mentoring');?></a></li>
         <li><a href="<?=base_url()?>index.php/attendance/mentoring_attendance_by_student"><?php echo lang('mentoring_attendance_by_student');?></a></li>
       </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-toogle="tab"><?php echo lang('timetables');?> <b class="caret"></b></a>
         <ul class="dropdown-menu">
          <li><a href="<?=base_url()?>index.php/timetables/mytimetables"><?php echo lang('my_timetables');?></a></li>
          <li><a href="<?=base_url()?>index.php/timetables/allteacherstimetables"><?php echo lang('all_teachers_timetables');?></a></li>
          <li><a href="<?=base_url()?>index.php/timetables/allgroupstimetables"><?php echo lang('all_groups_timetables');?></a></li>
         </ul>
      </li>


      <li class="dropdown">
       <!-- Informes -->
       <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-toogle="tab"><?php echo lang('reports');?> <b class="caret"></b></a>
       <ul class="dropdown-menu">
          <li class="dropdown-submenu">
			<a tabindex="-1" href="#"><?php echo lang('attendance'). ". " . lang('reports_educational_center_reports');?></a>
			<ul class="dropdown-menu">
				<li><a href="<?=base_url()?>index.php/attendance/attendance_reports/informe_centre_d_h_1"><?php echo lang('reports_educational_center_reports_incidents_by_day_and_hour');?></a></li>
				<li><a href="<?=base_url()?>index.php/attendance/attendance_reports/informe_centre_di_df_1"><?php echo lang('reports_educational_center_reports_incidents_by_date');?></a></li>
				<li><a href="<?=base_url()?>index.php/attendance/attendance_reports/informe_centre_ranking_di_df_1"><?php echo lang('reports_educational_center_reports_incidents_by_date_ranking');?></a></li>
				<li><a href="<?=base_url()?>index.php/attendance/attendance_reports/Llistat_grup_tutor"><?php echo lang('reports_educational_center_reports_grup_mentors');?></a></li>
				<li><a href="<?=base_url()?>index.php/attendance/attendance_reports/mailing_list_report"><?php echo lang('reports_educational_center_reports_student_emails');?></a></li>
			</ul>
		  </li>
		  <li class="dropdown-submenu">
			<a tabindex="-1" href="#"><?php echo lang('attendance'). ". " . lang('reports_group_reports');?></a>
			<ul class="dropdown-menu">
				<li><a href="<?=base_url()?>index.php/attendance/attendance_reports/class_list_report"><?php echo lang('reports_group_reports_class_list');?></a></li>
				<li><a href="<?=base_url()?>index.php/attendance/attendance_reports/class_sheet_report"><?php echo lang('reports_group_reports_student_sheet');?></a></li>
				<li><a href="<?=base_url()?>index.php/attendance/attendance_reports/informe_resum_grup_di_df_1"><?php echo lang('reports_group_reports_incidents_by_date');?></a></li>
				<li><a href="<?=base_url()?>index.php/attendance/attendance_reports/informe_resum_grup_faltes_mes_1"><?php echo lang('reports_group_reports_monthly_report');?></a></li>
			</ul>
		  </li>
          <li><a href="<?=base_url()?>index.php/attendance/attendance_reports/informeGuifi"><?php echo lang('reports_guifi');?></a></li>
      </ul>
      </li>

      <li class="dropdown">
       <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-toogle="tab"><?php echo "Inventari";?> <b class="caret"></b></a>
       <ul class="dropdown-menu">
         <li><a href="<?=base_url()?>index.php/inventory/inventory"><?php echo "Inventari";?></a></li>
       </ul>
      </li>

      <?php if ($show_maintenace_menu): ?>

      <li class="dropdown">
       <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-toogle="tab"><?php echo lang('maintenances');?> <b class="caret"></b></a>
       <ul class="dropdown-menu">

         <li class="dropdown-submenu">
          <a tabindex="-1" href="#"><?php echo lang('persons');?></a>
            <ul class="dropdown-menu">
               <li><a href="<?=base_url()?>index.php/teachers"><?php echo lang('teachers');?></a></li>
               <li><a href="<?=base_url()?>index.php/students"><?php echo lang('students');?></a></li>
               <li><a href="<?=base_url()?>index.php/persons"><?php echo lang('persons');?></a></li>
               <li><a href="<?=base_url()?>index.php/persons/person_official_id_type"><?php echo "Tipus identificador personal";?></a></li>
               <li><a href="<?=base_url()?>index.php/persons/localities"><?php echo "Poblacions";?></a></li>
               <li><a href="<?=base_url()?>index.php/persons/states"><?php echo "Províncies";?></a></li>
            </ul>
         </li>


         <li><a href="<?=base_url()?>index.php/skeleton_main/organizational_unit"><?php echo lang('organizationalunit_menu');?></a></li>
         <li><a href="<?=base_url()?>index.php/location/location"><?php echo lang('location_menu');?></a></li>

         <li class="dropdown-submenu">
          <a tabindex="-1" href="#"><?php echo lang('attendance_managment');?></a>
            <ul class="dropdown-menu">
               <li><a href="<?=base_url()?>index.php/attendance/classroom_groups"><?php echo lang('classroom_groups')?></a></li>
               <li><a href="<?=base_url()?>index.php/attendance/time_slots"><?php echo lang('time_slots')?></a></li>
               <li><a href="<?=base_url()?>index.php/attendance/todo"><?php echo "TODO"?></a></li>
            </ul>
         </li>

         <li class="dropdown-submenu">
          <a tabindex="-1" href="#"><?php echo lang("curriculum");?></a>
            <ul class="dropdown-menu">
              <!-- Manteniments -->
              <li><a href='<?=base_url()?>index.php/curriculum/studies_organizational_unit'><?php echo lang('organizational_unit_studies');?></a></li>
              <li><a href='<?=base_url()?>index.php/curriculum/departments_families'><?php echo lang('departments_families');?></a></li>
              <li><a href='<?=base_url()?>index.php/curriculum/studies'><?php echo lang('studies');?></a></li>
              <li><a href='<?=base_url()?>index.php/curriculum/cycle'><?php echo lang('cycles');?></a></li>
              <li><a href='<?=base_url()?>index.php/curriculum/course'><?php echo lang('course');?></a></li>
              <li><a href='<?=base_url()?>index.php/curriculum/classroom_group'><?php echo lang('classroom_group');?></a></li>
              <li><a href='<?=base_url()?>index.php/curriculum/study_module'><?php echo lang('study_module');?></a></li><!-- Assignatura -->
              <li><a href='<?=base_url()?>index.php/curriculum/study_submodules'><?php echo lang('study_submodules');?></a></li><!-- Unitat Formativa -->
              <li><a href='<?=base_url()?>index.php/curriculum/lessons'><?php echo lang('lessons');?></a></li><!-- Lliçons -->
            </ul>
         </li>

         <li class="dropdown-submenu">
          <a tabindex="-1" href="#"><?php echo "Matrícula";?></a>
            <ul class="dropdown-menu">
              <!-- Matrícules -->
              <li><a href='<?=base_url()?>index.php/enrollment/enrollment'><?php echo lang('enrollment');?></a></li>
              <li><a href='<?=base_url()?>index.php/enrollment/enrollment_studies'><?php echo lang('enrollment_studies');?></a></li>
              <li><a href='<?=base_url()?>index.php/enrollment/enrollment_class_group'><?php echo lang('enrollment_class_group');?></a></li>
              <li><a href='<?=base_url()?>index.php/enrollment/enrollment_modules'><?php echo lang('enrollment_modules');?></a></li>
              <li><a href='<?=base_url()?>index.php/enrollment/enrollment_submodules'><?php echo lang('enrollment_submodules');?></a></li>
            </ul>
         </li>

         <li class="dropdown-submenu">
          <a tabindex="-1" href="#"><?php echo lang('timetables');?></a>
            <ul class="dropdown-menu">
              <!-- Matrícules -->
              <li><a href='<?=base_url()?>index.php/timetables/non_lective_hours'><?php echo lang('non_lective_hours');?></a></li>
              <li><a href='<?=base_url()?>index.php/timetables/non_lective_lessons'><?php echo lang('non_lective_lessons');?></a></li>
            </ul>
         </li>

         <li class="dropdown-submenu">
          <a tabindex="-1" href="#"><?php echo "Inventari";?></a>
            <ul class="dropdown-menu">
              <li><a href='<?php echo site_url('main/externalIDType')?>'><?php echo lang('externalid_menu');?></a></li>
              <li><a href='<?php echo site_url('main/material')?>'><?php echo lang('material_menu');?></a></li>
              <li><a href='<?php echo site_url('main/brand')?>'><?php echo lang('brand_menu');?></a></li>
              <li><a href='<?php echo site_url('main/model')?>'><?php echo lang('model_menu');?></a></li>
              <li><a href='<?php echo site_url('main/provider')?>'><?php echo lang('provider_menu');?></a></li>
              <li><a href='<?php echo site_url('main/money_source')?>'><?php echo lang('money_source_menu');?></a></li>
              <li><a href='<?php echo site_url('main/barcode')?>'><?php echo lang('barcode_menu');?></a></li>
            </ul>
         </li>

         <li class="dropdown-submenu">
          <a tabindex="-1" href="#"><?php echo "Dades bancàries";?></a>
           <ul class="dropdown-menu">
            <li><a href='<?=base_url()?>index.php/banks/bank_account')?><?php echo "Comptes";?></a></li>
            <li><a href='<?=base_url()?>index.php/banks/bank')?><?php echo "Bancs";?></a></li>
            <li><a href='<?=base_url()?>index.php/banks/bank_office')?><?php echo "Oficines";?></a></li>
            <li><a href='<?=base_url()?>index.php/banks/bank_account_type')?><?php echo "Tipus de compte";?></a></li>
           </ul>
         </li>
      </ul>
    </li>
      <?php endif; ?>

      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('managment');?> <b class="caret"></b></a>
          <ul class="dropdown-menu">
			  <?php if ($show_managment_menu): ?>
            <li><a href='<?=base_url()?>index.php/skeleton/users'><?php echo lang('users');?></a></li>
            <li><a href='<?=base_url()?>index.php/skeleton/groups'><?php echo lang('groups');?></a></li>
            <li><a href='<?=base_url()?>index.php/managment/massive_change_password'><?php echo lang('massive_change_password');?></a></li>
            <li class="dropdown-submenu">
				<a tabindex="-1" href="#"><?php echo lang('statistics_checkings')?></a>
					<ul class="dropdown-menu">
						<li><a href='<?=base_url()?>index.php/managment/statistics_checkings_groups'><?php echo lang('statistics_checkings_groups');?></a></li>
						<li><a href='<?=base_url()?>index.php/managment/users_in_group'><?php echo lang('users_in_group');?></a></li>
						<li><a href='<?=base_url()?>index.php/managment/lessons'><?php echo lang('lessons');?></a></li>
					</ul>
			</li>
			  <?php endif; ?>
            <li><a href='<?=base_url()?>index.php/main/preferences'><?php echo lang('preferences');?></a></li>
          </ul>
      </li>

          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
    ...

      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('language');?> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>index.php/skeleton_main/change_language/catalan"><?php echo lang('catalan');?></a></li>
            <li><a href="<?=base_url()?>index.php/skeleton_main/change_language/spanish"><?php echo lang('spanish');?></a></li>
            <li><a href="<?=base_url()?>index.php/skeleton_main/change_language/english"><?php echo lang('english');?></a></li>
          </ul>
      </li>
     </ul>
   </div>
   <div class="pull-right navbar-text">
	   (<?php echo lang('language')." : ".lang($this->session->userdata('current_language'));?>)
     <img src="https://placehold.it/30x30">
      <a href="<?=base_url()?>index.php/skeleton_main/user_info" style="color:grey"><?php echo $this->session->userdata('username');?></a>
      <a href="<?=base_url()?>index.php/skeleton_auth/auth/logout"><?php echo lang('CloseSession');?></a>
   </div>
  </div>
 </div>
</div>
