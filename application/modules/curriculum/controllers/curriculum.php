<?php defined('BASEPATH') OR exit('No direct script access allowed');

//include "skeleton_main.php";
include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class curriculum extends skeleton_main {
	
    public $body_header_view ='include/ebre_escool_body_header.php' ;
    public $body_header_lang_file ='ebre_escool_body_header' ;

    public $html_header_view ='include/ebre_escool_html_header' ;

    public $body_footer_view ='include/ebre_escool_body_footer' ;       

	function __construct()
    {
        parent::__construct();
        
        $this->load->model('curriculum_model');
        //$this->config->load('curriculum');        
        
        /* Set language */
        $current_language=$this->session->userdata("current_language");
        if ($current_language == "") {
            $current_language= $this->config->item('default_language');
        }
        
        // Load the language file
        $this->lang->load('curriculum',$current_language);
        $this->load->helper('language');

	}
	
	protected function _getvar($name){
		if (isset($_GET[$name])) return $_GET[$name];
		else if (isset($_POST[$name])) return $_POST[$name];
		else return false;
	}
	
	public function index() {
		$this->lessons();
	}


    public function organizational_unit() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#organizational_unit';
        
        $this->check_logged_user(); 

        /* Ace */
        $header_data = $this->load_ace_files($active_menu);        

        /* Grocery Crud */
        $this->current_table="organizational_unit";
        $this->grocery_crud->set_table("organizational_unit");
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('organizational_unit'));          

        //Mandatory fields
        $this->grocery_crud->required_fields($this->current_table.'_name',$this->current_table.'_shortname',$this->current_table.'_markedForDeletion');

        $this->common_callbacks($this->current_table);

        //Express fields
        $this->grocery_crud->express_fields($this->current_table.'_name',$this->current_table.'_shortname');

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

         //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_shortName',lang('shortName'));
        $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
        $this->grocery_crud->display_as($this->current_table.'_description',lang('description'));        
        $this->grocery_crud->display_as($this->current_table.'_location',lang('location'));            
        $this->grocery_crud->display_as($this->current_table.'_externalCode',lang('external_code'));
        $this->grocery_crud->display_as($this->current_table.'_parent',lang($this->current_table.'_parent'));

        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_parent',$this->current_table,$this->current_table.'_name');
        $this->grocery_crud->set_relation($this->current_table.'_location','location','location_name');

        //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));

        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

       $this->renderitzar($this->current_table,$header_data);

    }


    public function studies_organizational_unit() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#curriculum';
        $active_menu['submenu2']='#studies_organizational_unit';

        $this->check_logged_user(); 

        /* Ace */
        $header_data = $this->load_ace_files($active_menu);        

        /* Grocery Crud */
        $this->current_table="studies_organizational_unit";
        $this->grocery_crud->set_table("studies_organizational_unit");
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('organizational_unit'));          

        //Mandatory fields
        $this->grocery_crud->required_fields($this->current_table.'_name',$this->current_table.'_shortname',$this->current_table.'_markedForDeletion');

        $this->common_callbacks($this->current_table);

        //Express fields
        $this->grocery_crud->express_fields($this->current_table.'_name',$this->current_table.'_shortname');

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

         //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_shortname',lang('shortName'));
        $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));

         //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_unit_creationUserId',$this->current_table.'_unit_lastupdateUserId');
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

       $this->renderitzar($this->current_table,$header_data);

    }

    public function departments_families() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#curriculum';
        $active_menu['submenu2']='#departments_families';

        $this->check_logged_user(); 

        /* Ace */
        $header_data = $this->load_ace_files($active_menu);
        

        /* Grocery Crud */
        $this->current_table="department";
        $this->grocery_crud->set_table($this->current_table);
        $this->session->set_flashdata('table_name', $this->current_table); 
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('department'));       

        //Relació de Taules
        $this->grocery_crud->set_relation($this->current_table.'_parent_department_id','department','{department_shortname} - {department_name} ({department_id})'); 
        $this->grocery_crud->set_relation($this->current_table.'_location_id','location','location_name'); 
        
        //Mandatory fields
        //$this->grocery_crud->required_fields($this->current_table.'_code',$this->current_table.'_classroom_group_id',$this->current_table.'_teacher_id',$this->current_table.'_day',$this->current_table.'_time_slot_id');

        $this->common_callbacks($this->current_table);

        //Express fields
        //$this->grocery_crud->express_fields($this->current_table.'_code',$this->current_table.'_day');
        
        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_shortname',lang($this->current_table.'_shortname'));
        $this->grocery_crud->display_as($this->current_table.'_name',lang($this->current_table.'_name'));
        $this->grocery_crud->display_as($this->current_table.'_organizational_unit_id',lang($this->current_table.'_organizational_unit_id'));
        $this->grocery_crud->display_as($this->current_table.'_head',lang($this->current_table.'_head'));
        $this->grocery_crud->display_as($this->current_table.'_parent_department_id',lang($this->current_table.'_parent_department_id'));
        $this->grocery_crud->display_as($this->current_table.'_location_id',lang($this->current_table.'_location_id'));        

        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_head','teacher','teacher_code');
        $this->grocery_crud->set_relation($this->current_table.'_organizational_unit_id','organizational_unit','organizational_unit_name');

         //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');
                   
        $this->renderitzar('department',$header_data);

    }

    public function studies() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#curriculum';
        $active_menu['submenu2']='#studies';

        $this->check_logged_user(); 

        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

        /* Grocery Crud */
        $this->current_table="studies";
        $this->grocery_crud->set_table($this->current_table);
        
        $this->session->set_flashdata('table_name', $this->current_table);

        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('studies'));          

        //Mandatory fields
        $this->grocery_crud->required_fields($this->current_table.'_name',$this->current_table.'_shortname',$this->current_table.'_markedForDeletion');

        $this->common_callbacks($this->current_table);
    
        //Express fields
        $this->grocery_crud->express_fields($this->current_table.'_name',$this->current_table.'_shortname');

        //RELATIONS
        $this->grocery_crud->set_relation_n_n($this->current_table.'_departments', 'study_department', 'department', 'study_id', 'department_id', 'department_name');

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        $this->grocery_crud->add_fields($this->current_table.'_shortname', $this->current_table.'_name', $this->current_table.'_departments' ,  $this->current_table.'_entryDate', $this->current_table.'_creationUserId', 
            $this->current_table.'_lastupdateUserId', $this->current_table.'_markedForDeletion', $this->current_table.'_markedForDeletionDate');

        $this->grocery_crud->edit_fields($this->current_table.'_shortname', $this->current_table.'_name', $this->current_table.'_departments' ,  $this->current_table.'_entryDate',  $this->current_table.'_last_update', $this->current_table.'_creationUserId', 
            $this->current_table.'_lastupdateUserId', $this->current_table.'_markedForDeletion', $this->current_table.'_markedForDeletionDate');

         //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_shortname',lang('shortName'));
        $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
        $this->grocery_crud->display_as($this->current_table.'_departments',lang($this->current_table.'_departments'));

         //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

        $this->renderitzar($this->current_table,$header_data);

    }

    public function cycle() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#curriculum';
        $active_menu['submenu2']='#cycle';

        $this->check_logged_user(); 

        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

        /* Grocery Crud */
        $this->current_table="cycle";
        $this->grocery_crud->set_table($this->current_table);

        $this->session->set_flashdata('table_name', $this->current_table);

        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('cycles'));          

        //Mandatory fields
        $this->grocery_crud->required_fields($this->current_table.'_name',$this->current_table.'_shortname',$this->current_table.'_markedForDeletion');

        $this->common_callbacks($this->current_table);

        //Express fields
        $this->grocery_crud->express_fields($this->current_table.'_name',$this->current_table.'_shortname');
        
        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

         //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_shortname',lang('shortName'));
        $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));

         //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

        $this->renderitzar($this->current_table,$header_data);

    }           


    public function course() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#curriculum';
        $active_menu['submenu2']='#course';

        $this->check_logged_user(); 

        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

        /* Grocery Crud */
        $this->current_table="course";
        $this->grocery_crud->set_table($this->current_table);
        
        $this->session->set_flashdata('table_name', $this->current_table); 

        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('course'));       

        //Relació de Taules
        $this->grocery_crud->set_relation($this->current_table.'_cycle_id','cycle','cycle_shortname'); 
        $this->grocery_crud->set_relation($this->current_table.'_estudies_id','studies','studies_shortname');        

        //Param 1: The name of the field that we have the relation in the basic table (course_cycle_id)
        //Param 2: The relation table (cycle)
        //Param 3: The 'title' field that we want to use to recognize the relation (cycle_shortname)

        //Mandatory fields
        $this->grocery_crud->required_fields($this->current_table.'_name',$this->current_table.'_shortname',$this->current_table.'_markedForDeletion');

        $this->common_callbacks($this->current_table);

        //Express fields
        $this->grocery_crud->express_fields($this->current_table.'_name',$this->current_table.'_shortname');
        //$this->grocery_crud->express_fields($this->current_table.'_name',$this->current_table.'_shortname','parentLocation');

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_shortname',lang('shortName'));
        $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
        $this->grocery_crud->display_as($this->current_table.'_number',lang($this->current_table.'_number'));
        $this->grocery_crud->display_as($this->current_table.'_cycle_id',lang($this->current_table.'_cycle_id')); 
        $this->grocery_crud->display_as($this->current_table.'_estudies_id',lang($this->current_table.'_estudies_id'));

/*       
        //Relacions entre taules
        $this->grocery_crud->set_relation('parentLocation','location','{name}',array('markedForDeletion' => 'n'));
*/        
         //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

        $this->renderitzar($this->current_table,$header_data);
                   
    }

/* GRUP */

    public function classroom_group() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#curriculum';
        $active_menu['submenu2']='#classroom_group';

        $this->check_logged_user(); 

        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

        /* Grocery Crud */
        $this->current_table="classroom_group";
        $this->grocery_crud->set_table("classroom_group");
        
        $this->session->set_flashdata('table_name', $this->current_table); 

        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('classroom_group'));       

        //Mandatory fields
        $this->grocery_crud->required_fields($this->current_table.'_name',$this->current_table.'_shortsame',$this->current_table.'_markedForDeletion');

        $this->common_callbacks($this->current_table);

        //Express fields
        $this->grocery_crud->express_fields($this->current_table.'_name',$this->current_table.'_shortname');
        //$this->grocery_crud->express_fields('course_name','course_shortname','parentLocation');

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS
        
        $this->grocery_crud->display_as($this->current_table.'_code',lang('group_code'));  
        $this->grocery_crud->display_as($this->current_table.'_shortName',lang('shortName'));
        $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
        $this->grocery_crud->display_as($this->current_table.'_course_id',lang('course'));
        $this->grocery_crud->display_as($this->current_table.'_description',lang('description'));
        $this->grocery_crud->display_as($this->current_table.'_mentorId',lang('mentor_code'));
        $this->grocery_crud->display_as($this->current_table.'_shift',lang($this->current_table.'_shift'));
        $this->grocery_crud->display_as($this->current_table.'_location_id',lang('location'));       
        $this->grocery_crud->display_as($this->current_table.'_parentLocation',lang($this->current_table.'_parentLocation'));       
        $this->grocery_crud->display_as($this->current_table.'_educationalLevelId',lang($this->current_table.'_educationalLevelId'));       
                
        
        //Not necessary. Classroom_group have a course that have a cicle and that and study and Studies have Organizational Unit study.
        //The last one is the same as educationalLevelId
        //$this->grocery_crud->display_as($this->current_table.'_educationalLevelId',lang('group_EducationalLevelId')); 

//      RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_course_id','course','{course_name} ({course_shortname} - {course_id})');
        $this->grocery_crud->set_relation($this->current_table.'_mentorId','teacher','teacher_code');
        $this->grocery_crud->set_relation($this->current_table.'_location_id','location','location_name');
        $this->grocery_crud->set_relation($this->current_table.'_shift','shift','shift_name');

        //$this->grocery_crud->set_relation('group_course_id','course','{course_name} ({course_shortname} - {course_id})',array('status' => 'active'));

/*      $this->grocery_crud->set_relation('course_estudies_id','studies','studies_shortname');        
        $this->grocery_crud->set_relation('parentLocation','location','{name}',array('markedForDeletion' => 'n'));
        Param 1: The name of the field that we have the relation in the basic table (course_cycle_id)
        Param 2: The relation table (cycle)
        Param 3: The 'title' field that we want to use to recognize the relation (cycle_shortname)        
*/        
         //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');

        $this->userCreation_userModification($this->current_table);         

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

        $this->renderitzar($this->current_table,$header_data);
                   
    }

/* FI GRUP */


/* ASSIGNATURA */

    public function study_module() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#curriculum';
        $active_menu['submenu2']='#study_module';

        $this->check_logged_user(); 

        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

        /* Grocery Crud */
        $this->current_table="study_module";
        $this->grocery_crud->set_table($this->current_table);
        
        $this->session->set_flashdata('table_name', $this->current_table); 

        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('study_module'));       

        //Mandatory fields
        $this->grocery_crud->required_fields($this->current_table.'_name',$this->current_table.'_shortname',$this->current_table.'_markedForDeletion');

        $this->common_callbacks($this->current_table);

        //Express fields
        $this->grocery_crud->express_fields($this->current_table.'_name',$this->current_table.'_shortname');
        //$this->grocery_crud->express_fields('course_name','course_shortname','parentLocation');

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_shortname',lang('shortName'));
        $this->grocery_crud->display_as($this->current_table.'_external_code',lang($this->current_table.'_external_code'));
        $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
        $this->grocery_crud->display_as($this->current_table.'_hoursPerWeek',lang($this->current_table.'_hoursPerWeek'));
        $this->grocery_crud->display_as($this->current_table.'_courseid',lang($this->current_table.'_courseid'));        
        $this->grocery_crud->display_as($this->current_table.'_teacher_id',lang($this->current_table.'_teacher_id'));
        $this->grocery_crud->display_as($this->current_table.'_initialDate',lang($this->current_table.'_initialDate'));
        $this->grocery_crud->display_as($this->current_table.'_endDate',lang($this->current_table.'_endDate'));          
        $this->grocery_crud->display_as($this->current_table.'_type',lang($this->current_table.'_type'));   
        $this->grocery_crud->display_as($this->current_table.'_subtype',lang($this->current_table.'_subtype'));        
        $this->grocery_crud->display_as($this->current_table.'_classroom_group_id',lang($this->current_table.'_classroom_group_id'));
        $this->grocery_crud->display_as($this->current_table.'_order',lang($this->current_table.'_order'));
        $this->grocery_crud->display_as($this->current_table.'_description',lang($this->current_table.'_description'));

        //RELACIONS
        //$this->grocery_crud->set_relation($this->current_table.'_course_id','course','course_shortname'); 
        $this->grocery_crud->set_relation($this->current_table.'_teacher_id','teacher','({teacher_code} - {teacher_id})');
        $this->grocery_crud->set_relation($this->current_table.'_classroom_group_id','classroom_group','({classroom_group_id} - {classroom_group_code} | {classroom_group_shortName})');
        $this->grocery_crud->set_relation($this->current_table.'_courseid','course','({course_id} - {course_shortname})');
        
        /*
        Param 1: The name of the field that we have the relation in the basic table (course_cycle_id)
        Param 2: The relation table (cycle)
        Param 3: The 'title' field that we want to use to recognize the relation (cycle_shortname)        
        */        

         //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

        $this->renderitzar($this->current_table,$header_data);
                   
    }

/* FI ASSIGNATURA */

/* UNITATS FORMATIVES */

    public function study_submodules() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#curriculum';
        $active_menu['submenu2']='#study_submodules';

        $this->check_logged_user(); 

        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

        /* Grocery Crud */
        $this->current_table="study_submodules";
        $this->grocery_crud->set_table($this->current_table);

        $this->session->set_flashdata('table_name', $this->current_table);        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('study_submodules'));       

        //Mandatory fields
        $this->grocery_crud->required_fields($this->current_table.'_name',$this->current_table.'_shortname',$this->current_table.'_markedForDeletion');

        $this->common_callbacks($this->current_table);

        //Express fields
        $this->grocery_crud->express_fields($this->current_table.'_name',$this->current_table.'_shortname');
        //$this->grocery_crud->express_fields('course_name','course_shortname','parentLocation');

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_shortname',lang('shortName'));
        $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
        $this->grocery_crud->display_as($this->current_table.'_study_module_id',lang($this->current_table.'_study_module_id'));        
        $this->grocery_crud->display_as($this->current_table.'_courseid',lang($this->current_table.'_courseid'));
        $this->grocery_crud->display_as($this->current_table.'_initialDate',lang($this->current_table.'_initialDate'));
        $this->grocery_crud->display_as($this->current_table.'_endDate',lang($this->current_table.'_endDate'));
        $this->grocery_crud->display_as($this->current_table.'_totalHours',lang($this->current_table.'_totalHours'));
        $this->grocery_crud->display_as($this->current_table.'_order',lang($this->current_table.'_order'));
        $this->grocery_crud->display_as($this->current_table.'_description',lang($this->current_table.'_description'));

        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_study_module_id','study_module','({nom_grup} - {study_module_name})');
        $this->grocery_crud->set_relation($this->current_table.'_courseid','course','({course_id} - {course_shortname})');
        //$this->grocery_crud->set_relation($this->current_table.'_study_module_id','study_module','({study_module_id} - {study_module_name})');

        //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//      $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

        $this->renderitzar($this->current_table,$header_data);
                   
    }

/* FI UNITATS FORMATIVES */


	
	/* Menú Managment -> Curricul | Manteniment -> Pla Estudis */

	public function lessons($department_code=null) {
		
        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#curriculum';
        $active_menu['submenu2']='#lessons';

        $this->check_logged_user(); 

        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

		/* Grocery Crud */
		$this->current_table="lesson";
        $this->grocery_crud->set_table($this->current_table);
        
        $this->session->set_flashdata('table_name', $this->current_table); 
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('lesson'));       

        //Relació de Taules
        $this->grocery_crud->set_relation($this->current_table.'_classroom_group_id','classroom_group','{classroom_group_code} - {classroom_group_shortName} ({classroom_group_id})'); 
		$this->grocery_crud->set_relation($this->current_table.'_teacher_id','teacher','{teacher_code} - ({teacher_id})');        
		$this->grocery_crud->set_relation($this->current_table.'_location_id','location','{location_Id} ({location_name})');
		$this->grocery_crud->set_relation($this->current_table.'_time_slot_id','time_slot','{time_slot_start_time} - {time_slot_end_time} ({time_slot_id})');

		//Mandatory fields
        $this->grocery_crud->required_fields($this->current_table.'_code',$this->current_table.'_classroom_group_id',$this->current_table.'_teacher_id',$this->current_table.'_day',$this->current_table.'_time_slot_id');

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        $this->common_callbacks($this->current_table);

        //Express fields
        //$this->grocery_crud->express_fields($this->current_table.'_code',$this->current_table.'_day');

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_code',lang($this->current_table.'_code'));
        $this->grocery_crud->display_as($this->current_table.'_codi_assignatura',lang($this->current_table.'_codi_assignatura'));        
        $this->grocery_crud->display_as($this->current_table.'_codi_grup',lang($this->current_table.'_codi_grup'));           
        $this->grocery_crud->display_as($this->current_table.'_codi_professor',lang($this->current_table.'_codi_professor')); 
        $this->grocery_crud->display_as($this->current_table.'_classroom_group_id',lang($this->current_table.'_classroom_group_id'));
        $this->grocery_crud->display_as($this->current_table.'_teacher_id',lang($this->current_table.'_teacher_id'));
        $this->grocery_crud->display_as($this->current_table.'_study_module_id',lang($this->current_table.'_study_module_id'));
        $this->grocery_crud->display_as($this->current_table.'_location_id',lang($this->current_table.'_location_id')); 
        $this->grocery_crud->display_as($this->current_table.'_day',lang($this->current_table.'_day'));
        $this->grocery_crud->display_as($this->current_table.'_time_slot_id',lang($this->current_table.'_time_slot_id'));        

         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
   		
        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

        $this->renderitzar($this->current_table,$header_data);
                   
	}


public function add_callback_last_update(){  
   
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';
}

public function add_field_callback_entryDate(){  
      $data= date('d/m/Y H:i:s', time());
      return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
}

public function edit_field_callback_entryDate($value, $primary_key){  
    //$this->session->flashdata('table_name');
      return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
    }
    
public function edit_callback_last_update($value, $primary_key){ 
    //$this->session->flashdata('table_name'); 
     return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', time()) .'"  name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';
    }    

//UPDATE AUTOMATIC FIELDS BEFORE INSERT
function before_insert_object_callback($post_array, $primary_key) {
        //UPDATE LAST UPDATE FIELD
        $data= date('d/m/Y H:i:s', time());
        $post_array['entryDate'] = $data;
        
        $post_array['creationUserId'] = $this->session->userdata('user_id');
        return $post_array;
}

//UPDATE AUTOMATIC FIELDS BEFORE UPDATE
function before_update_object_callback($post_array, $primary_key) {
        //UPDATE LAST UPDATE FIELD
        $data= date('d/m/Y H:i:s', time());
        $post_array['last_update'] = $data;
        
        $post_array['lastupdateUserId'] = $this->session->userdata('user_id');
        return $post_array;
}

function check_logged_user()
{
    if (!$this->skeleton_auth->logged_in())
    {
        //redirect them to the login page
        redirect($this->skeleton_auth->login_page, 'refresh');
    }

    //CHECK IF USER IS READONLY --> unset add, edit & delete actions
    $readonly_group = $this->config->item('readonly_group');
    if ($this->skeleton_auth->in_group($readonly_group)) {
        $this->grocery_crud->unset_add();
        $this->grocery_crud->unset_edit();
        $this->grocery_crud->unset_delete();
    }
}

function common_callbacks()
{
        //CALLBACKS        
        $this->grocery_crud->callback_add_field($this->session->flashdata('table_name').'_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field($this->session->flashdata('table_name').'_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field($this->session->flashdata('table_name').'_last_update',array($this,'edit_callback_last_update'));
}

function userCreation_userModification($table_name)
{   
    //USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
    $this->grocery_crud->set_relation($table_name.'_creationUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($table_name,$table_name.'_creationUserId',$this->session->userdata('user_id'));

    //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
    $this->grocery_crud->set_relation($table_name.'_lastupdateUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($table_name,$table_name.'_lastupdateUserId',$this->session->userdata('user_id'));
}

function renderitzar($table_name,$header_data)
{
       $output = $this->grocery_crud->render();

       // HTML HEADER
       
       $this->_load_html_header($header_data,$output); 
    
       // BODY       

       $this->_load_body_header();
       
       $default_values=$this->_get_default_values();
       $default_values["table_name"]=$table_name;
       $default_values["field_prefix"]=$table_name."_";
       $this->load->view('defaultvalues_view.php',$default_values); 

       //$this->load->view('course.php',$output);     
       $this->load->view($table_name.'.php',$output);     
       
       //      FOOTER     
       $this->_load_body_footer();  

}

function set_common_columns_name($table_name){
    $this->grocery_crud->display_as($table_name.'_entryDate',lang('entryDate'));
    $this->grocery_crud->display_as($table_name.'_last_update',lang('last_update'));
    $this->grocery_crud->display_as($table_name.'_creationUserId',lang('creationUserId'));                  
    $this->grocery_crud->display_as($table_name.'_lastupdateUserId',lang('lastupdateUserId'));   
    $this->grocery_crud->display_as($table_name.'_markedForDeletion',lang('markedForDeletion'));       
    $this->grocery_crud->display_as($table_name.'_markedForDeletionDate',lang('markedForDeletionDate')); 
}

function load_ace_files($active_menu){

$header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/ace-fonts.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/ace.min.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/ace-responsive.min.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/ace-skins.min.css'));
/*                      
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));  
*/

        //JS
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/jquery-1.9.1.js");
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/ui/1.10.3/jquery-ui.js");   

        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace.min.js')); 
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ebre-escool.js'));           

        $header_data['menu']= $active_menu;
        return $header_data;
}

}
