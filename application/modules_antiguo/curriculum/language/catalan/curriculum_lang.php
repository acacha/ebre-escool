<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 *  Name:  curriculum lang - Catalan
 *
 * Author: Sergi Tur Badenas
 * 		   sergiturbadenas@gmail.com
 *
 * Created:  24.12.2013
 *
 * Description:  Catalan language file for curriculum module
 *
 */
 
$lang['curriculum']   = "Pla d'estudis";

$lang['department']   = "Departament/Família";

$lang['external_code']   = "Codi Extern";

$lang['organizational_unit_parent']   = "Unitat Organitzativa Pare";

$lang['department_shortname']   = "Nom curt";
$lang['department_head']   = "Cap de departament";
$lang['department_organizational_unit_id']   = "Unitat Organitzativa";
$lang['department_location_id']   = "Espai";
$lang['department_name']   = "Nom";
$lang['department_parent_department_id']   = "Departament/Família pare";
$lang['department_entryDate']   = "Data de creació";
$lang['department_last_update']   = "Data última modificació";
$lang['department_creationUserId']   = "Usuari de creació";
$lang['department_lastupdateUserId']   = "Usuari última modificació";
$lang['department_markedForDeletion']   = "Baixa?";
$lang['department_markedForDeletionDate']   = "Data de baixa";

//FIELD NAMES
$lang['lesson_academic_period_id']   = "Període acadèmic";
$lang['lesson_code']   = "Codi extern";
$lang['lesson_codi_assignatura']   = "Codi assignatura";
$lang['lesson_codi_grup']   = "Codi grup";
$lang['lesson_codi_professor']   = "Codi professor";
$lang['lesson_classroom_group_id']   = "Grup classe";
$lang['lesson_teacher_id']   = "Professor";
$lang['lesson_study_module_id']   = "Mòdul professional";
$lang['lesson_location_id']   = "Espai";
$lang['lesson_day']   = "Codi dia";
$lang['lesson_time_slot_id']   = "Codi hora";
$lang['lesson_entryDate']   = "Data de creació";
$lang['lesson_last_update']   = "Data última modificació";
$lang['lesson_creationUserId']   = "Usuari de creació";
$lang['lesson_lastupdateUserId']   = "Usuari última modificació";
$lang['lesson_markedForDeletion']   = "Baixa?";
$lang['lesson_markedForDeletionDate']   = "Data de baixa";

$lang['studies_departments']   = "Departaments";

$lang['study_module_hoursPerWeek']="Hores Setmanals";
//Sergi Tur 15 juny 2014: Els estudis no estan associats a grups de classse! Associats a cursos. Els grups de classe si estan associats a cursos
//$lang['study_module_bclassroom_group_id']="Id Grup";
$lang['study_module_id']="Id";
$lang['study_module_order']="Ordre";
$lang['study_module_description']="Descripció";
$lang['study_module_initialDate']="Data inici";
$lang['study_module_endDate']="Data fí";          
$lang['study_module_external_code']="Codi extern";          
$lang['study_module_type']="Tipus";   
$lang['study_module_subtype']="Subtipus";   
$lang['study_module_academic_periods']="Períodes acadèmics";   
$lang['study_module_entryDate']   = "Data de creació";
$lang['study_module_last_update']   = "Data última modificació";


$lang['study_modules_id']="Id";
$lang['study_submodules_study_module_id']="Mòdul Professional";   
$lang['study_submodules_courseid']="Curs";   
$lang['study_submodules_initialDate']="Data inici";
$lang['study_submodules_endDate']="Data fi";
$lang['study_submodules_totalHours']="Hores totals";
$lang['study_submodules_order']="Ordre";
$lang['study_submodules_description']="Descripció";
$lang['study_submodules_academic_periods']="Períodes acadèmics";

$lang['study_submodules_academic_periods_id']="Id";
$lang['study_submodules_academic_periods_study_submodules_id']="Unitats Formativa/ Didàctica";
$lang['study_submodules_academic_periods_academic_period_id']="Període acadèmic";
$lang['study_submodules_academic_periods_initialDate']="Data inici";
$lang['study_submodules_academic_periods_endDate']="Data fi";
$lang['study_submodules_academic_periods_totalHours']="Hores totals";


$lang['study_module_academic_periods_id']="Id";
$lang['study_module_academic_periods_study_module_id']="MP/Crèdit";
$lang['study_module_academic_periods_academic_period_id']="Període acadèmic";
$lang['study_module_academic_periods_external_code']="Codi extern";
$lang['study_module_academic_periods_initialDate']="Data inici";
$lang['study_module_academic_periods_endDate']="Data fi";

$lang['type']="Tipus";   
$lang['subtype']="Subtipus"; 

//Course
$lang['course_entryDate']   = "Data de creació";
$lang['course_last_update']   = "Data última modificació";
$lang['course_creationUserId']   = "Usuari de creació";
$lang['course_lastupdateUserId']   = "Usuari última modificació";
$lang['course_markedForDeletion']   = "Baixa?";
$lang['course_markedForDeletionDate']   = "Data de baixa";
$lang['course_academic_periods']   = "Períodes acadèmics";


//Classroom_group

$lang['classroom_group_code']="Codi";
$lang['classroom_group_name']="Nom";
$lang['classroom_group_shortName']="Nom curt";
$lang['classroom_group_course']="Curs"; 
$lang['classroom_group_description']="Descripció"; 
$lang['classroom_group_mentor_code']="Codi Tutor"; 
$lang['classroom_group_shift']="Torn (matí/tarda)";
$lang['classroom_group_location']="Espai";
$lang['classroom_group_academic_periods'] = "Períodes acadèmics";
#$lang['classroom_group_educationalLevelId']="Nivell Educatiu";
$lang['classroom_group_entryDate']   = "Data de creació";
$lang['classroom_group_lastupdate']   = "Data última modificació";
$lang['classroom_group_creationUserId']   = "Usuari de creació";
$lang['classroom_group_lastupdateUserId']   = "Usuari última modificació";
$lang['classroom_group_markedForDeletion']   = "Baixa?";
$lang['classroom_group_markedForDeletionDate']   = "Data de baixa";

//Classroom_group by academic period

$lang['classroom_group_academic_periods_classroom_group_id']="Grup";
$lang['classroom_group_academic_periods_academic_period_id']="Període acadèmic";
$lang['classroom_group_academic_periods_shortName']="Nom curt";
$lang['classroom_group_academic_periods_course']="Curs"; 
$lang['classroom_group_academic_periods_description']="Descripció"; 
$lang['classroom_group_academic_periods_mentor_code']="Codi Tutor"; 
$lang['classroom_group_academic_periods_shift']="Torn (matí/tarda)";
$lang['classroom_group_academic_periods_location']="Espai";
$lang['classroom_group_academic_periods_academic_periods'] = "Períodes acadèmics";
#$lang['classroom_group_academic_periods_educationalLevelId']="Nivell Educatiu";
$lang['classroom_group_academic_periods_entryDate']   = "Data de creació";
$lang['classroom_group_academic_periods_lastupdate']   = "Data última modificació";
$lang['classroom_group_academic_periods_creationUserId']   = "Usuari de creació";
$lang['classroom_group_academic_periods_lastupdateUserId']   = "Usuari última modificació";
$lang['classroom_group_academic_periods_markedForDeletion']   = "Baixa?";
$lang['classroom_group_academic_periods_markedForDeletionDate']   = "Data de baixa";


$lang['studies_studies_organizational_unit_id'] = "Tipus d'estudi";
$lang['studies_studies_law_id'] = "Llei";
$lang['studies_academic_periods'] = "Períodes acadèmics";
 	
$lang['academic_periods'] = "Períodes acadèmics";
$lang['alt_name'] = "Nom alternatiu";
$lang['current_academic_period'] = "Actual";