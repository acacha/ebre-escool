<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Inventory Lang - Catalan
*
* Author: Sergi Tur Badenas
* 		  sergiturbadenas@gmail.com
*         @sergitur
*
* Author: ...
*         @....
*
*
* Created:  31.05.2013
*
* Description:  Català per a l'aplicació d'inventari
*
*/

//MENUS

//BODY HEADER MENUS & SUBMENUS
$lang['Welcome']   = 'Benvingut/da,';
$lang['configuration']   = 'Configuració';
$lang['change_password']   = 'Canvi password';
$lang['create_initial_password']   = 'Crear password inicial';
$lang['profile']   = 'Perfil';
$lang['Exit']   = 'Sortir';

$lang['control_panel'] = 'Panell de Control';

$lang['check_attendance']   = 'Passar llista';
$lang['mentoring']   = 'Tutoria';
 $lang['mentoring_classlists']   = 'Llistes de classe';
 $lang['mentoring_groups_mentoring']   = 'Tutoritza els teus grups';
 $lang['mentoring_attendance_by_student']   = 'Llistat de faltes per alumne';
$lang['reports']   = 'Informes';
 $lang['reports_educational_center_reports']   = 'Informes de centre';
  $lang['reports_educational_center_reports_incidents_by_day_and_hour']   = "Incidències del centre del dia d a l'hora h";
  $lang['reports_educational_center_reports_incidents_by_date']   = "Incidències del centre entre una data inicial i una data final";
  $lang['reports_educational_center_reports_incidents_by_date_ranking']   =  "Rànquing incidències del centre entre una data inicial i una data final";
  $lang['reports_educational_center_reports_grup_mentors']   = 'Tutors de grup';
  $lang['reports_educational_center_reports_student_emails']   = 'Correus dels estudiants';
 $lang['reports_group_reports']   = 'Informes de grup';
  $lang['reports_group_reports_class_list']   = "Llista de classe";
  $lang['reports_group_reports_student_sheet']   = "Llençol d'estudiants d'un grup";
  $lang['reports_group_reports_incidents_by_date']   = "Resum d'incidències d'un grup entre una data inicial i una data final";
  $lang['reports_group_reports_monthly_report']   = "Informe mensual de faltes injustificades";

  $lang['reports_teachers_list'] = "Llista de professors";

$lang['attendance']   = 'Assistència';  

$lang['timetables']='Horaris';
 $lang['my_timetables']='Els meus horaris'; 
 $lang['all_teachers_timetables']='Horaris de tots els professors'; 
 $lang['all_groups_timetables']='Tots els horaris de grups'; 
      
$lang['devices'] = 'Dispositius';
 $lang['computers'] = 'Ordinadors';
 $lang['others'] = 'Altres';

$lang['maintenances'] = 'Manteniments';
 $lang['teachers'] = 'Professors';
 $lang['teachers_by_academic_period'] = 'Professors per període acadèmic'; 
 $lang['employees'] = 'Personal Laboral';
 $lang['employees_type'] = 'Tipus Personal Laboral';
 $lang['students'] = 'Alumnes'; 
 $lang['persons'] = 'Persones';
 $lang['states'] = 'Províncies';
 $lang['externalid_menu'] = 'Tipus Identificadors externs';
 $lang['personal_id_type'] = 'Tipus identificador personal';
 $lang['organizationalunit_menu'] = 'Unitats Organitzatives';
 $lang['location_menu'] = 'Espais';
 $lang['brand_menu'] = 'Marques';
 $lang['model_menu'] = 'Models';
 $lang['material_menu'] = 'Tipus Material';
 $lang['provider_menu'] = 'Proveïdors';
 $lang['money_source_menu'] = 'Origen Diners';
 $lang['barcode_menu'] = 'Codis de barres';

$lang['attendance_managment'] = 'Gestió assistència';
 $lang['classroom_groups'] = 'Grups de classe';
 $lang['time_slots'] = 'Franjes horàries';

$lang['reports'] = 'Informes';
 $lang['global_reports'] = 'Informes globals';
 $lang['reports_by_organizationalunit'] = 'Informes per unitat organitzativa';

$lang['managment'] = 'Gestió';
 $lang['users'] = 'Usuaris';
 $lang['users_ldap'] = 'Usuaris ldap';
 $lang['users_google_apps'] = 'Usuaris Google Apps';
 $lang['groups'] = 'Grups';
 $lang['massive_change_password']   = 'Canvi massiu de paraules de pas';
 $lang['statistics_checkings']   = 'Estadístiques. Comprovacions';
  $lang['statistics_checkings_groups']   = 'Grups';
  $lang['users_in_classroom_group'] = 'Usuaris per grup de classe';
 $lang['preferences'] = 'Preferències';


 /* Menú manteniments Plans Estudi */
$lang['curriculum']="Pla d'estudis"; 
$lang['organizational_unit_studies']="Unitat Organitzativa. Estudis";
$lang['departments_families']="Departaments/Famílies";
$lang['departments']="Departaments/Famílies";
$lang['studies']="Estudis";
$lang['studieslaw']="Lleis";
$lang['cycles']="Cicles";
$lang['course']="Curs";
    $lang['course_number']="Num. Curs";
    $lang['course_cycle_id']="ID Cicle"; 
    $lang['course_estudies_id']="ID Estudi";  
$lang['classroom_group']="Grup de Classe";
	$lang['group_code']="Codi Grup";
	$lang['group_EducationalLevelId']="Nivell Educatiu";
$lang['study_module']="Assignatura | Mòdul Professional";	
$lang['study_module_academic_periods_alt']="MPs per període"; 
$lang['study_module_type_menuname']="Tipus Mòdul Professional"; 
$lang['study_module_subtype_menuname']="Subtipus Mòdul Professional"; 
$lang['study_submodules']="Unitat Formativa";
$lang['study_submodules_academic_periods']="UFs per període";
$lang['lessons']="Lliçons";
$lang['studies']="Estudis";
$lang['cycles']="Cicle";
$lang['organizational_unit']="Unitat Organitzativa";

//Matrícules
$lang['enrollment']="Matrícula";
$lang['enrollment_without_modify_person_and_user_data']="Matrícula sense modificació dades personals ni password";

$lang['enrollment_query_by_person']="Consulta matrícula";
$lang['enrollment_modify']="Modificació de matrícula";
$lang['enrollment_change_classroomgroup']="Canvi de grup";
$lang['enrollment_delete']="Eliminar matrícula";
$lang['enrollment_delete_user']="Eliminar persona";
$lang['enrollment_modify_person']="Modificar dades personals";

#OBSOLET
#$lang['enrollment_studies']="Estudis Matriculats";
#$lang['enrollment_class_group']="Matrícules de Grups de Classe";
#$lang['enrollment_modules']="Matrícules Mòduls";
$lang['enrollment_submodules']="Matrícula Unitats Formatives";

//Hores i Lliçons No lectives
$lang['non_lective_hours'] = "Hores no lectives";
$lang['non_lective_lessons'] = "Lliçons no lectives";
$lang['shift'] = "Torn";

//Inventari
$lang['inventory']="Inventari";
$lang['inventory_reports'] = "Informes d'Inventari";
$lang['all_inventory_with_filter_options'] = "Tot l'inventar amb opció de filtres";
$lang['material']="Material";

//Dades Bancàries
$lang['bank']="Bancs";
$lang['bank_data']="Dades bancàries";
$lang['bank_account']="Comptes";
$lang['bank_office']="Oficines";
$lang['bank_account_type']="Tipus de compte";

//Usuaris
$lang['creation_user']="Usuari de Creació";
$lang['modification_user']="Usuari de Modificació";

//Usuaris
$lang['attendance_incidents']="Incidènces assistència";
$lang['attendance_incident_types']="Tipus d'incidències d'assistència";


$lang['hidden_students'] = "Estudiants ocults";