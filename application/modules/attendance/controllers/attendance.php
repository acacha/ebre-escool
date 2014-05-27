<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class attendance extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php';
	//public $html_header_view ='/include/ebre_escool_html_header.php';

	public $body_header_lang_file ='ebre_escool_body_header' ;

	public $html_header_view ='include/ebre_escool_html_header' ;
	public $body_footer_view ='include/ebre_escool_body_footer' ;


	public function load_header_data($menu = false){

		$active_menu = $menu;

		//CSS URLS
		$jquery_ui_css_url = "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
		$jquery_ui_editable_css_url = "http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css";
		$select2_css_url = "http://cdn.jsdelivr.net/select2/3.4.5/select2.css";
		//JS URLS
		$jquery_url= "http://code.jquery.com/jquery-1.9.1.js";
		$jquery_ui_url= "http://code.jquery.com/ui/1.10.3/jquery-ui.js";
		$select2_url= "http://cdn.jsdelivr.net/select2/3.4.5/select2.js";
		$jquery_ui_editable_url= "http://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js";

		if (defined('ENVIRONMENT') && ENVIRONMENT=="development") {
  			$jquery_ui_css_url = base_url('assets/css/jquery-ui.css');
  			$jquery_ui_editable_css_url = base_url('assets/css/jqueryui-editable.css');
  			$select2_css_url = base_url('assets/css/select2.css');

  			//$jquery_url= base_url('assets/js/jquery-1.9.1.js');
  			$jquery_url= base_url('assets/js/jquery-1.10.2.min.js');
			$jquery_ui_url= base_url('assets/js/jquery-ui.js');
			$select2_url= base_url('assets/js/select2.js');
			$jquery_ui_editable_url= base_url('assets/js/jqueryui-editable.min.js');
		}

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			$jquery_ui_css_url);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			$jquery_ui_editable_css_url);

		$header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/datepicker.css'));  

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			$select2_css_url);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
            base_url('assets/css/tribal-timetable.css')); 

		
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap-switch.min.css'));


        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap.min.extracolours.css')); 

//ACE
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

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/css/jquery_plugins/fancybox/jquery.fancybox.css'));

/*        
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));        


        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/chosen.min.css'));        
*/
		//JS Already load at skeleton main!!!
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$jquery_url);

		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$jquery_ui_url);	


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$select2_url);


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			$jquery_ui_editable_url);


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.js'));


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.ca.js'));


		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.es.js'));


		$header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/bootstrap-tooltip.js'));


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/bootstrap-collapse.js'));                


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/tribal.js'));


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/tribal-shared.js'));        


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/tribal-timetable.js'));


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.dataTables.min.js'));


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.dataTables.bootstrap.js'));


        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-switch.min.js'));

 //ACE        
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace.min.js'));
                    
/*
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/chosen.jquery.min.js'));
*/

		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/grocery_crud/js/jquery_plugins/jquery.fancybox-1.3.4.js'));

		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ebre-escool.js'));


		$header_data['menu']= $active_menu;
		return $header_data; 
        
    }


	function __construct()
    {
        parent::__construct();
        
        $this->load->model('attendance_model');
        $this->load->model('timetables_model');
        $this->load->library('ebre_escool_ldap');

        $this->load->library('ebre_escool');

        //GROCERY CRUD
		$this->load->add_package_path(APPPATH.'third_party/grocery-crud/application/');
        $this->load->library('grocery_CRUD');
        $this->load->add_package_path(APPPATH.'third_party/image-crud/application/');
		$this->load->library('image_CRUD');  

		/* Set language */
		$current_language=$this->session->userdata("current_language");
		if ($current_language == "") {
			$current_language= $this->config->item('default_language','skeleton_auth');
		}
		$this->grocery_crud->set_language($current_language);
    	$this->lang->load('skeleton', $current_language);	       
    	
    	$this->lang->load('attendance', $current_language);	
    	
		$this->lang->load('managment', $current_language);        
        
	}


	/*
	TODO: remove

	public function read($table=null){

		$this->db->select('alumne, incidencia, data, hora');
		$this->db->where('alumne', $_POST['alumne']); 
		$this->db->where('hora', $_POST['hora']);
		$query = $this->db->get($table);
		$resultat = array();
		$resultat[] = "Alumne  - Incidencia - Data - Hora";

		foreach ($query->result() as $row)
		{
		    $resultat[] = $row->alumne ." - ".$row->incidencia." - ".$row->data." - ".$row->hora;
		}
		print_r(json_encode($resultat));
	}	

	public function insert($table=null){

		//echo $table;
		$this->db->insert($table, $_POST); 
		$rows = $this->db->affected_rows();
		print_r(json_encode($this->db->affected_rows()));
		//$this->db->insert($table, $data); 
		//print_r(json_encode($data));
	}		

	public function update(){

		$data = array(
           'cycle_shortname' => 'cic mod 1',
           'cycle_name' => 'cicle modificat 1',
           'cycle_entryDate' => date("Y-m-d H:i:s")
        );

		$this->db->where('cycle_id', '6');
		$this->db->update('cycle', $data); 
		print_r(json_encode($data));
	}	

	public function delete(){
		$data = array(
			'Esborrat' => 'id 8'		
		);
		$this->db->where('cycle_id', '8');
		$this->db->delete('cycle'); 
		print_r(json_encode($data));
	}

	fi proves ajax json */	

	public function read_test_incidents_managment_by_ajax () {	

		echo "hola!";
	}

	public function create_test_incidents_managment_by_ajax() {
		$data = array();
        $this->load->view('create_test_incidents_managment_by_ajax.php',$data); 
	}

	public function insert_incidents() {

		if (!$this->skeleton_auth->logged_in())	{
			//TODO check permisions!
        	echo "User not logged";
    	}

		//TODO: validate data	

    	$this->attendance_model->insert_incidence($_POST);

	}
	
	public function test_incidents_managment_by_ajax () {	
		
		$active_menu = array();
		$active_menu['menu']='#maintenances';
		$active_menu['submenu1']='#attendance_managment';
		$active_menu['submenu2']='#time_slots';

	    $this->check_logged_user();

		/* Ace */
	    $header_data = $this->load_ace_files($active_menu); 

		// HTML HEADER
        $this->_load_html_header($header_data); 
        $this->_load_body_header();      
       
       	// BODY       
       	$data = array();
        $this->load->view('test_incidents_managment_by_ajax.php',$data); 

	}

	public function time_slots () {

		$active_menu = array();
		$active_menu['menu']='#maintenances';
		$active_menu['submenu1']='#attendance_managment';
		$active_menu['submenu2']='#time_slots';

	    $this->check_logged_user();

		/* Ace */
	    $header_data = $this->load_ace_files($active_menu);  

	    // Grocery Crud 
	    $this->current_table="time_slot";
	    $this->grocery_crud->set_table($this->current_table);
	        
	    $this->session->set_flashdata('table_name', $this->current_table);     
			
		//Establish subject:
	    $this->grocery_crud->set_subject(lang("time_slot"));

	    //COMMON_COLUMNS               
	    $this->set_common_columns_name($this->current_table);       

	    $this->common_callbacks($this->current_table);

	    //ESPECIFIC COLUMNS  
	    $this->grocery_crud->display_as($this->current_table.'_id',lang('time_slot_id'));
	    $this->grocery_crud->display_as($this->current_table.'_start_time',lang('time_slot_start_time'));       
	    $this->grocery_crud->display_as($this->current_table.'_end_time',lang('time_slot_end_time'));       

	    //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
	    
	    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
			
	    $this->userCreation_userModification($this->current_table);

	    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");

	    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

		$this->renderitzar($this->current_table,$header_data);	

	}

	public function incident () {

		$active_menu = array();
		$active_menu['menu']='#maintenances';
		$active_menu['submenu1']='#attendance_maintainance';
		$active_menu['submenu2']='#attendance_incident';

	    $this->check_logged_user();

		/* Ace */
	    $header_data = $this->load_ace_files($active_menu);  

	    // Grocery Crud 
	    $this->current_table="incident";
	    $this->grocery_crud->set_table($this->current_table);
	        
	    $this->session->set_flashdata('table_name', $this->current_table);     
			
		//Establish subject:
	    $this->grocery_crud->set_subject(lang("incident"));

	    //COMMON_COLUMNS               
	    $this->set_common_columns_name($this->current_table);       

	    $this->common_callbacks($this->current_table);

	    //ESPECIFIC COLUMNS  
	    $this->grocery_crud->display_as($this->current_table.'_student_id',lang('student'));
	    $this->grocery_crud->display_as($this->current_table.'_day',lang('day'));
	    $this->grocery_crud->display_as($this->current_table.'_time_slot_id',lang('time_slot'));
	    $this->grocery_crud->display_as($this->current_table.'_study_submodule_id',lang('study_submodule'));
	    $this->grocery_crud->display_as($this->current_table.'_type',lang('incident_type'));
	    $this->grocery_crud->display_as($this->current_table.'_notes',lang('incident_notes'));
	    
	    //Relations
    	$this->grocery_crud->set_relation($this->current_table.'_student_id','student','{student_person_id} - {student_code}',array('student_markedForDeletion' => 'n'));
    	$this->grocery_crud->set_relation($this->current_table.'_time_slot_id','time_slot','{time_slot_start_time} - {time_slot_end_time}',array('time_slot_markedForDeletion' => 'n'));
		$this->grocery_crud->set_relation($this->current_table.'_study_submodule_id','study_submodules','{study_submodules_id} - {study_submodules_name}',array('study_submodules_markedForDeletion' => 'n'));
    	$this->grocery_crud->set_relation($this->current_table.'_type','incident_type','{incident_type_id} - {incident_type_shortName}',array('incident_type_markedForDeletion' => 'n'));

	    //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
	    
	    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
			
	    $this->userCreation_userModification($this->current_table);

	    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");

	    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

		$this->renderitzar($this->current_table,$header_data);	

	}

	public function incident_type () {

		$active_menu = array();
		$active_menu['menu']='#maintenances';
		$active_menu['submenu1']='#attendance_maintainance';
		$active_menu['submenu2']='#attendance_incident_ype';

	    $this->check_logged_user();

		/* Ace */
	    $header_data = $this->load_ace_files($active_menu);  

	    // Grocery Crud 
	    $this->current_table="incident_type";
	    $this->grocery_crud->set_table($this->current_table);
	        
	    $this->session->set_flashdata('table_name', $this->current_table);     
			
		//Establish subject:
	    $this->grocery_crud->set_subject(lang("incident_type"));

	    //COMMON_COLUMNS               
	    $this->set_common_columns_name($this->current_table);       

	    $this->common_callbacks($this->current_table);

	    //ESPECIFIC COLUMNS  
	    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
	    $this->grocery_crud->display_as($this->current_table.'_shortName',lang('shortName'));
	    $this->grocery_crud->display_as($this->current_table.'_description',lang('description'));
	    $this->grocery_crud->display_as($this->current_table.'_code',lang('code'));
	    
	    //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
	    
	    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
			
	    $this->userCreation_userModification($this->current_table);

	    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");

	    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

		$this->renderitzar($this->current_table,$header_data);	

	}

	
	public function mentoring_groups ( $class_room_group_id = null ) {

		$active_menu = array();
		$active_menu['menu']='#mentoring';
		$active_menu['submenu1']='#mentoring_groups';

    	$this->check_logged_user();

		$header_data = $this->load_header_data($active_menu);

        $this->_load_html_header($header_data);
		
		$this->_load_body_header();

		//Check if user is manager -> Show all groups

		// IF USER IS NOT MANAGER -> IS MENTOR? -> SHOW GROUPS user is mentor

		$data = array();
		$data['default_classroom_group_id'] = 2;

		$data['check_attendance_date'] = date('d/m/Y');

		if ( $class_room_group_id != null ) {
			$data['default_classroom_group_id'] = $class_room_group_id;			
		}
		
		//$data['classroom_groups'] = array ( 1 => "Grup1" , 2 => "Grup 2", 3 => "Grup 3");
		$data['classroom_groups'] = $this->attendance_model->get_all_groups();

		$this->load->view('mentoring_groups',$data);	

		$this->_load_body_footer();		

	}

	public function mentoring_attendance_by_student () {

		$active_menu = array();
		$active_menu['menu']='#mentoring';
		$active_menu['submenu1']='#mentoring_attendance_by_student';

    	$this->check_logged_user();

		$header_data = $this->load_header_data($active_menu);
        $this->_load_html_header($header_data);

		$this->_load_body_header();

		$data = array();
		
		$this->load->view('mentoring_attendance_by_student',$data);	

		$this->_load_body_footer();		
	}

	public function pdf_exemple() {
		$this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
		#$this->load->library('fpdf');
		$this->load->library('fpdf');
		$pdf=new FPDF();
		
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Image('http://fpdf.org/logo.gif');
		$pdf->Cell(0,10,utf8_decode('¡Hola, Món!'),1,2,'L');
		$pdf->Output();
	}




	public function classroom_groups() {

	$active_menu = array();
	$active_menu['menu']='#maintenances';
	$active_menu['submenu1']='#attendance_managment';
	$active_menu['submenu2']='#classroom_groups';
	
	//Cargar la llibreria fpdf
	$this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
	#$this->load->library('fpdf');
	$this->load->library('pdf');
	$pdf=new PDF();

    $this->check_logged_user();

	/* Ace */
    $header_data = $this->load_ace_files($active_menu);  	

    // Grocery Crud 
	$this->current_table="classroom_group";
    $this->grocery_crud->set_table($this->current_table);
    $this->session->set_flashdata('table_name', $this->current_table);

    //ESTABLISH SUBJECT        
    $this->grocery_crud->set_subject(lang('ClassroomGroup'));

    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);

	//Mandatory fields
    $this->grocery_crud->required_fields($this->current_table.'_code',$this->current_table.'_name',$this->current_table.'_shortName',$this->current_table.'_markedForDeletion');
        
    //express fields
    $this->grocery_crud->express_fields($this->current_table.'_name',$this->current_table.'_shortName',$this->current_table.'_code');


    $this->grocery_crud->display_as($this->current_table.'_id',lang('idGroup'));
    $this->grocery_crud->display_as($this->current_table.'_code',lang('GroupCode'));
    $this->grocery_crud->display_as($this->current_table.'_course_id',lang('idCurs'));
    $this->grocery_crud->display_as($this->current_table.'_location_id',lang('location_id'));
    $this->grocery_crud->display_as($this->current_table.'_shift',lang('shift'));
	$this->grocery_crud->display_as($this->current_table.'_shortName',lang('GroupShortName'));
	$this->grocery_crud->display_as($this->current_table.'_name',lang('GroupName'));
	$this->grocery_crud->display_as($this->current_table.'_description',lang('GroupDescription'));
	$this->grocery_crud->display_as($this->current_table.'_educationalLevelId',lang('EducationalLevelId'));
	$this->grocery_crud->display_as($this->current_table.'_mentorId',lang('MentorId'));
    $this->grocery_crud->display_as($this->current_table.'_parentLocation',lang('parentLocation'));      		


    $this->common_callbacks($this->current_table);
        
    //UPDATE AUTOMATIC FIELDS
	$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
	$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
   	$this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
   	//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
    $this->grocery_crud->set_relation($this->current_table.'_creationUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_creationUserId',$this->session->userdata('user_id'));

    //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
    $this->grocery_crud->set_relation($this->current_table.'_lastupdateUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_lastupdateUserId',$this->session->userdata('user_id'));
        
    $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId',$this->current_table.'_parentLocation');
        
    $this->set_theme($this->grocery_crud);
    $this->set_dialogforms($this->grocery_crud);
        
    //Default values:
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_parentLocation',1);
        
	/* show only specified columns */
	$this->grocery_crud->columns($this->current_table.'_id',$this->current_table.'_code',$this->current_table.'_shortName',$this->current_table.'_name',$this->current_table.'_description',$this->current_table.'_mentorId',$this->current_table.'_entryDate',$this->current_table.'_last_update',$this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');

    //markedForDeletion
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

	$this->renderitzar($this->current_table,$header_data);	

	}

	protected function getTimeSlotKeyByTimeSlotId($time_slots,$time_slot_id) {
		foreach ($time_slots as $time_slot_key => $time_slot) {
			if ($time_slot->id == $time_slot_id) {
				return $time_slot_key;
			}
		}
		return -1;
    }

	/*$selected_time_slot_id
	    	$time_slots

	    	$selected_time_slot_key = */

	public function check_attendance_classroom_group( $selected_group_id = 0, $teacher_code = "" , $selected_study_module_id = 0, 
		$lesson_id = 0, $day = 0, $month = 0, $year = 0 ) {

		$this->check_logged_user();	
		$active_menu = array();
		$active_menu['menu']='#check_attendance';
		$header_data = $this->load_header_data($active_menu);
        $this->_load_html_header($header_data);

		$userid=$this->session->userdata('id');
		$person_id=$this->session->userdata('person_id');
		
		//Check if user is a teacher
		$user_is_a_teacher = $this->attendance_model->is_user_a_teacher($person_id);

		$data['is_teacher'] = $user_is_a_teacher;
		
		/*******************
		/*      BODY       *
		/*******************/
		$this->_load_body_header($data);


		if ( !$user_is_a_teacher ) {
			//TODO: Return not allowed page!
			return null;
		}		

		$user_teacher_code = $this->attendance_model->getTeacherCode($person_id);
		
		$user_is_admin = $this->ebre_escool->user_is_admin();
		//TODO: Test. DELETE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	    //$user_is_admin=false;

		if ($teacher_code == null) {
	    	$teacher_code = $user_teacher_code;
	    } else {
	    	if (!$user_is_admin) { 
	    		$teacher_code = $user_teacher_code; 
	    	}
	    }

	    //Teacher info to view
	    $data['teacher_code']= $teacher_code;

	    $teacher_info = $this->attendance_model->get_teacher_info_from_teacher_code($teacher_code);  

	    $teacher_department_id = 2;

		$teacher_id = $teacher_info['teacher_id'];  
		$teacher_givenName = $teacher_info['givenName'];
		$teacher_sn1 = $teacher_info['sn1'];
		$teacher_sn2 = $teacher_info['sn2'];

		//Teacher info to view
	    $data['teacher_code']= $teacher_code;   
	    $data['teacher_id']= $teacher_id;
	    $data['teacher_givenName']= $teacher_givenName;
	    $data['teacher_sn1']= $teacher_sn1;
	    $data['teacher_sn2']= $teacher_sn2;

	    // Obtenir el departament al que pertany un professor (Oscar)
	    //$teacher_departments = $this->attendance_model->get_teacher_departments($teacher_id);
	    //$data['department_id'] = $teacher_departments[1];

	    //echo "teacher_id: $teacher_id<br/>";       
	    //echo "teacher_code: $teacher_code<br/>";   

	    $user_is_teacher=true;

	    //Departaments
	    $data['departments'] = array();
	    $department_info = $this->attendance_model->get_teacher_departmentInfo($teacher_id);
	    $data['selected_department_key'] = $department_info['id'];
	    $data['selected_department_name'] = $department_info['name'];
		if ($user_is_admin) {
	    	//Get all classroom_groups
	    	$data['departments']= $this->attendance_model->get_all_departments();
	    } else {
	    	$data['departments']= $this->attendance_model->get_teacher_departments($teacher_id);
	    }
        
	    #Obtain class_room_groups
	    $data['classroom_groups']=array();

	    if ($user_is_admin) {
	    	//Get all classroom_groups
	    	$data['classroom_groups']= $this->attendance_model->get_all_groupscodenameByDeparment($teacher_department_id);
	    } else {
	    	//IF TEACHER
	    	if($user_is_teacher) {
	    		$data['classroom_groups']=$this->attendance_model->get_all_groupscodenameByTeacher($teacher_id);
	    	}
			//$data['classroom_groups']=array(); //OSCAR
	    }

	    if ($day == 0 ) {
	    	//obtain day from current date
			$day = date("d");
	    }
	    if ($month == 0 ) {
	    	//obtain month from current date
			$month = date("m");
	    }
	    if ($year == 0 ) {
	    	//obtain year from current date
			$year = date("y");
	    }

	    //isodate format: YYYY-MM-DD
		$iso_date = null;
		$data['check_attendance_date'] = "";

	    if ( ($day != null) && ($month != null) && ($year != null) ) {
	    	$data['check_attendance_date'] = $day . "/" . $month . "/" .$year;
	    	$iso_date = $year . "-" .  sprintf('%02s', $month) . "-" . sprintf('%02s', $day);
	    } else {
	    	$data['check_attendance_date'] = date('d/m/Y');	
	    	$iso_date = $year . "-" .  sprintf('%02s', $month) . "-" . sprintf('%02s', $day);
	    }

	    
	    $day_of_week_number = date('N', strtotime($iso_date));

		$days_of_week = array();
		$timestamp = strtotime('next Monday');
		for ($i = 1; $i < 8; $i++) {
 			$days_of_week[$i] = strftime('%A', $timestamp);
 			$timestamp = strtotime('+1 day', $timestamp);
		}

		$data['days_of_week'] = $days_of_week;

		$data['day_of_week_number'] = $day_of_week_number;
		$data['day'] = $day;
		$data['month'] = $month;
		$data['year'] = $year;

		if ($selected_group_id == 0) {
			//TODO: Get default group id
			$selected_group_id = 25; //2ASIX	
		}	else {
			//Check if teacher could use this group
			//TODO
		}

	    $data['selected_classroom_group_key']=$selected_group_id; //2ASIX
	    
	    $data['all_lessons'] =array();
	    
	    if ($user_is_admin){
	    	$all_lessons = $this->attendance_model->getAllLessonsByDay($day_of_week_number,$data['selected_classroom_group_key']);
	    	$data['all_lessons'] = $all_lessons;	    	
	    } else {
	    	$all_lessons = $this->attendance_model->getAllLessonsByTeacherCodeAndDay($teacher_id,$day_of_week_number);
	    	$data['all_lessons'] = $all_lessons;	    	
	    }

	    //OSCAR: Time Slots
		$timeslots = $this->get_time_slots($data['selected_classroom_group_key'],1);	  

		$data['timeslots'] = $timeslots;
		$data['time_slots_lective'] = $timeslots['time_slots_lective'];

		$all_students_in_group= $this->attendance_model->getAllGroupStudentsInfo($selected_group_id);
		$selected_group_info = $this->attendance_model->getGroupInfoByGroupId($selected_group_id);

		$selected_group_id = $selected_group_info['id'];
		$selected_group_name = $selected_group_info['name'];
		$selected_group_shortname = $selected_group_info['shortname'];
		$selected_group_code = $selected_group_info['code'];

		$data['selected_group_id'] = $selected_group_id;
		$data['selected_classroom_group_code'] = $selected_group_code;
	    $data['selected_classroom_group_shortname'] = $selected_group_code;
		$data['selected_classroom_group'] = $selected_group_name;

		/*echo "selected_group_name: $selected_group_name<br/>";
		echo "selected_group_shortname: $selected_group_shortname<br/>";
		echo "selected_group_code: $selected_group_code<br/>";*/

		if ($selected_study_module_id == 0) {
			//TODO: Get default group id
			$selected_study_module_id = 274;	
		}	else {
			//Check if teacher could use this group
			//TODO
		}

		$data['selected_study_module_key']= $selected_study_module_id;

		$selected_study_module_info = $this->attendance_model->getStudyModuleInfoByModuleId($selected_study_module_id);

		$selected_study_module_name = $selected_study_module_info['name'];
		$selected_study_module_shortname = $selected_study_module_info['shortname'];
		$selected_study_module_code = $selected_study_module_info['code'];


		/*
		echo "selected_study_module_name: $selected_study_module_name<br/>";
		echo "selected_study_module_shortname: $selected_study_module_shortname<br/>";
		echo "selected_study_module_code: $selected_study_module_code<br/>";*/

		$data['selected_study_module_code'] = $selected_study_module_code;
	    $data['selected_study_module_shortname'] = $selected_study_module_shortname;
		$data['selected_study_module'] = $selected_study_module_name;


	    $data['study_modules'] = array();
	    
	    if ($user_is_admin) {
	    	//Get all group study modules
	    	$all_group_study_modules = $this->attendance_model->getAllGroupStudymodules( $selected_group_id);
	    	$data['study_modules'] = $all_group_study_modules;
	    } else {
	    	//Get current teacher study modules
	    	$current_teacher_study_modules = $this->attendance_model->getAllTeacherStudymodules( $teacher_id );
			$data['study_modules'] = $current_teacher_study_modules;
	    }

	    $data['time_slots']=array();

	    $time_slots = $this->attendance_model->getTimeSlotsByClassgroupId($selected_group_id,$day_of_week_number);

	    $selected_time_slot_id = $this->attendance_model->getTimeSlotKeyFromLessonId($lesson_id);
	    $selected_time_slot_key = $this->getTimeSlotKeyByTimeSlotId($time_slots,$selected_time_slot_id);

		$data['selected_time_slot_key'] = $selected_time_slot_key;		
		$data['selected_time_slot_id'] = $selected_time_slot_id;

		if (is_array($time_slots)) {
	    	$data['time_slots'] = $time_slots;
	    }

	    $group_teachers_array = $this->attendance_model->getAllTeachersFromClassgroupId( $selected_group_id );
	    $data['group_teachers']= $group_teachers_array;

	    //Tutor is default selected_group_teacher 	    
	    $tutor_teacher_id = $this->attendance_model->getTutorFromClassgroupId( $selected_group_id );

	    //echo "tutor_teacher_id: $tutor_teacher_id<br/>";

	    if ($tutor_teacher_id != "") {
	    	if (array_key_exists($tutor_teacher_id,$group_teachers_array)) {
	    		$selected_group_teacher = $group_teachers_array[$tutor_teacher_id]->sn1 . " " . $group_teachers_array[$tutor_teacher_id]->sn2 . ", " . 	
	    			$group_teachers_array[$tutor_teacher_id]->givenName . "( Tutor/a )";
	    	} else {
	    		$selected_group_teacher = "Error. No s'ha trobat el codi $tutor_teacher_id";
	    	}
	    		
	    } else {
	    	$selected_group_teacher = "Error. No hi ha tutor del grup";
	    }
	    
	    	

	    $data['selected_group_teacher']= $selected_group_teacher;
	    
	    $data['group_teachers_default_teacher_key']= $tutor_teacher_id;

	    
		//TODO: select current user (sessions user as default teacher)
	    $data['default_teacher'] = $teacher_code;

	    $data['selected_time_slot'] = $time_slots[$selected_time_slot_key]->range;

	    $data['total_number_of_students'] = count($all_students_in_group);

		$data['classroom_group_students'] = array ();
		$base_photo_url = "uploads/person_photos";
		
		
		if ( $data['total_number_of_students'] != 0 ) {
			foreach($all_students_in_group as $student)	{

				$studentObject = new stdClass;
			
				$studentObject->person_id = $student->person_id;
				$studentObject->givenName = $student->givenName;
				$studentObject->sn1 = $student->sn1;
				$studentObject->sn2 = $student->sn2;
				$studentObject->username = $student->username;
				$studentObject->email = $student->email;
			
				//TODO: get incident notes!
				$studentObject->notes = "nota";

				if ($student->photo_url != "") {
					$student->photo_url = $base_photo_url."/".$student->photo_url;	
				}	else {
					$studentObject->photo_url = '/assets/img/alumnes/foto.png';				
				}
				$data['classroom_group_students'][]=$student;
			}	
		}
		
		$this->load->view('attendance/check_attendance_classroom_group',$data);
		 
		/*******************
		/*      FOOTER     *
		*******************/
		$this->_load_body_footer();	
	}


	public function check_attendance(
		$teacher_code = null, $day = null, $month = null, $year = null ,$url_group_code = null) {
  
		$this->check_logged_user();

		$active_menu = array();
		$active_menu['menu']='#check_attendance';
		
		$header_data = $this->load_header_data($active_menu);
        $this->_load_html_header($header_data);

		/***************************
		/*      BODY               *
		/***************************/

		$data=array();

		$userid=$this->session->userdata('id');
		$person_id=$this->session->userdata('person_id');
		
		//Check if user is a teacher
		$user_is_a_teacher = $this->attendance_model->is_user_a_teacher($person_id);

		$data['is_teacher']=$user_is_a_teacher;
		$this->_load_body_header($data);

		if ( !$user_is_a_teacher ) {
			//TODO: Return not allowed page!
			return null;
		}		

		$user_teacher_code = $this->attendance_model->getTeacherCode($person_id);
		
		//TODO:
		$user_is_admin = true;


		if ($teacher_code == null) {
	    	$teacher_code = $user_teacher_code;
	    } else {
	    	if (!$user_is_admin) { 
	    		$teacher_code = $user_teacher_code; 
	    	}
	    }

	    $teacher_info = $this->attendance_model->get_teacher_info_from_teacher_code($teacher_code);   

	    $teacher_id = $teacher_info['teacher_id'];
	    $teacher_full_name = $teacher_info['givenName'] . " " . $teacher_info['sn1'] . " " . $teacher_info['sn2'];

	    //echo "teacher_id: $teacher_id<br/>";       
	    //echo "teacher_code: $teacher_code<br/>";       
        
		if ($user_is_admin) {
			//Load teachers from Model
			$teachers_array = $this->attendance_model->get_all_teachers_ids_and_names();

			$data['teachers'] = $teachers_array;
		} else {
			//Show Only one teacher
			$teachers_array = $this->attendance_model->get_teacher_ids_and_names($teacher_id);
			$data['teachers'] = $teachers_array;
		}

	    $data['default_teacher'] = $teacher_code;

		$data['check_attendance_date'] = null;

		//isodate format: YYYY-MM-DD
		$iso_date = null;

	    if ( ($day != null) && ($month != null) && ($year != null) ) {
	    	$data['check_attendance_date'] = $day . "/" . $month . "/" .$year;
	    	$iso_date = $year . "-" .  sprintf('%02s', $month) . "-" . sprintf('%02s', $day);
	    } else {
	    	$data['check_attendance_date'] = date('d/m/Y');	
	    	$iso_date = $year . "-" .  sprintf('%02s', $month) . "-" . sprintf('%02s', $day);
	    }

	    $day_of_week_number = date('N', strtotime($iso_date));

		$data['day_of_week_number'] = $day_of_week_number;
	    $timestamp = strtotime('next Monday');
		$days_of_week = array();
		for ($i = 1; $i < 8; $i++) {
 			$days_of_week[$i] = strftime('%A', $timestamp);
 			$timestamp = strtotime('+1 day', $timestamp);
		}

		$data['days_of_week'] = $days_of_week;

		$data['teacher_code'] = $teacher_code;
		$data['teacher_full_name'] = $teacher_full_name;
		$data['day'] = $day;
		$data['month'] = $month;
		$data['year'] = $year;

		//Obtain Time Slots
    	$time_slots_array = $this->attendance_model->getAllTimeSlots()->result_array();
    	$time_slots_array_byteacher_and_day = null;

    	$time_slots_array_byteacher_and_day = $this->attendance_model->getAllTimeSlotsByTeacherCodeAndDay($teacher_id,$day_of_week_number);

    	if ($time_slots_array_byteacher_and_day != null) {
    		$time_slots_array_byteacher_and_day = $time_slots_array_byteacher_and_day->result_array();
    	} else {
    		$time_slots_array_byteacher_and_day = array();
    	}

    	
    	$lessons_array_byteacher_and_day = $this->attendance_model->getAllLessonsByTeacherCodeAndDay($teacher_id,$day_of_week_number);

	    $data['time_slots_array'] = $time_slots_array;
	    $data['time_slots_array_byteacher_and_day'] = $time_slots_array_byteacher_and_day;

	    //print_r($time_slots_array);

	    $teacher_groups_current_day=array();
	    
	    $all_time_slots=array();
	    $all_time_slots_reduced=array();

	    $classroom_groups_colours = $this->_alt_assign_colours($lessons_array_byteacher_and_day,"classroom_group_code");
		$study_modules_colours = $this->_assign_colours($lessons_array_byteacher_and_day,"study_module_id");

	    foreach ($time_slots_array as $time_slot)	{
	    	$group_id = 0;
	    	$group_code = "";
			$base_url =  "";
			$group_shortname =  "";
			$group_name =  "";
			
			$lesson_id =  "";
			$lesson_code =  "";
			$lesson_shortname =  "";
			$lesson_name =  "";

			$lesson_location =  "";
   			$time_slot_data = new stdClass;
			$time_slot_data->time_interval= $time_slot['time_slot_start_time'] . " - " . $time_slot['time_slot_end_time'];
			$time_slot_data->time_slot_lective = $time_slot['time_slot_lective'];
			$time_slot_id = $time_slot['time_slot_id'];

			$study_module_id = null;
			$group_code = null;
			$time_slot_data->lesson_colour = "btn-default";
			if (is_array($lessons_array_byteacher_and_day)) {
				if (array_key_exists($time_slot_id, $lessons_array_byteacher_and_day)) {
    				$group_id = $lessons_array_byteacher_and_day[$time_slot_id]->group_id;
    				$group_code = $lessons_array_byteacher_and_day[$time_slot_id]->group_code;
					$base_url = $lessons_array_byteacher_and_day[$time_slot_id]->base_url;
					$group_shortname = $lessons_array_byteacher_and_day[$time_slot_id]->group_shortname;	
					$group_name = $lessons_array_byteacher_and_day[$time_slot_id]->group_name;
					$study_module_id = $lessons_array_byteacher_and_day[$time_slot_id]->study_module_id;
					$lesson_id = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_id;
					$lesson_code = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_code;
					$lesson_shortname = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_shortname;
					$lesson_name = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_name;
					$lesson_location = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_location;
				} 
			}
			
			$time_slot_data->group_id = $group_id;
			$time_slot_data->group_code = $group_code;
			$time_slot_data->group_url= $base_url;
			$time_slot_data->group_shortname = $group_shortname;
			$time_slot_data->group_name = $group_name;
			
			$time_slot_data->study_module_id = $study_module_id;

			$time_slot_data->lesson_id = $lesson_id;
			$time_slot_data->lesson_location = $lesson_location;
			$time_slot_data->lesson_code = $lesson_code;
			$time_slot_data->lesson_shortname = $lesson_shortname;
			$time_slot_data->lesson_name = $lesson_name;
			
			$time_slot_data->classroom_group_colour = "btn-default";
			if ( $group_code != null ) {
				if (array_key_exists($group_code, $classroom_groups_colours)) {
					$time_slot_data->classroom_group_colour = $classroom_groups_colours[$group_code];
				} 
			}
			if ( $study_module_id != null ) {
				if (array_key_exists($study_module_id, $study_modules_colours)) {
					$time_slot_data->lesson_colour = $study_modules_colours[$study_module_id];
				} 
			}

   			$all_time_slots[$time_slot_id] = $time_slot_data;
		}

		foreach ($time_slots_array_byteacher_and_day as $time_slot)	{
			$group_id = 0;
			$group_code = "";
			$base_url =  "";
			$group_shortname =  "";
			$group_name =  "";
			
			$lesson_id = 0;
			$lesson_code =  "";
			$lesson_shortname =  "";
			$lesson_name =  "";


			$lesson_location =  "";
   			$time_slot_data = new stdClass;
			$time_slot_data->time_interval= $time_slot['time_slot_start_time'] . " - " . $time_slot['time_slot_end_time'];
			$time_slot_data->time_slot_lective = $time_slot['time_slot_lective'];
			$time_slot_id = $time_slot['time_slot_id'];

			//Obtain lesson for this teacher date and time slot
			$study_module_id = null;
			$time_slot_data->lesson_colour = "btn-default";
			if (array_key_exists($time_slot_id, $lessons_array_byteacher_and_day)) {
				$group_id = $lessons_array_byteacher_and_day[$time_slot_id]->group_id;
				$group_code = $lessons_array_byteacher_and_day[$time_slot_id]->group_code;
				$base_url = $lessons_array_byteacher_and_day[$time_slot_id]->base_url;
				$group_shortname = $lessons_array_byteacher_and_day[$time_slot_id]->group_shortname;
				$group_name = $lessons_array_byteacher_and_day[$time_slot_id]->group_name;
				$study_module_id = $lessons_array_byteacher_and_day[$time_slot_id]->study_module_id;
				$lesson_id = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_id;
				$lesson_code = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_code;
				$lesson_shortname = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_shortname;
				$lesson_name = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_name;
				$lesson_location = $lessons_array_byteacher_and_day[$time_slot_id]->lesson_location;
			}

			$time_slot_data->group_id = $group_id;
			$time_slot_data->group_code = $group_code;
			$time_slot_data->group_url= $base_url;
			$time_slot_data->group_shortname = $group_shortname;
			$time_slot_data->group_name = $group_name;

			$time_slot_data->study_module_id = $study_module_id;

			$time_slot_data->lesson_id = $lesson_id;
			$time_slot_data->lesson_code = $lesson_code;
			$time_slot_data->lesson_shortname = $lesson_shortname;
			$time_slot_data->lesson_name = $lesson_name;
			$time_slot_data->lesson_location = $lesson_location;
			if ( $group_code != null ) {
				if (array_key_exists($group_code, $classroom_groups_colours)) {
					$time_slot_data->classroom_group_colour = $classroom_groups_colours[$group_code];
				} 
			}
			if ( $study_module_id != null ) {
				if (array_key_exists($study_module_id, $study_modules_colours)) {
					$time_slot_data->lesson_colour = $study_modules_colours[$study_module_id];
				}
			}

   			$all_time_slots_reduced[$time_slot_id] = $time_slot_data;
		}
		
		$data['all_time_slots']=$all_time_slots;
		$data['all_time_slots_reduced']=$all_time_slots_reduced;
		
		//Obtain all teacher groups for selected date		

		if(isset($group_code)){
			$data['$group_code'] = $group_code;	
		}	

		$data['check_attendance_day']="TODO";
		$data['check_attendance_table_title']=lang('check_attendance_table_title');
		$data['choose_date_string']=lang('choose_date_string');
		$data['today']=date('d-m-Y');

		$teacher_groups_current_day=array();
		
		/* Llista alumnes grup */

        $default_group_code = $group_code;
        $group_code=$default_group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $header_data['header_title']=lang("all_students") . ". " . $organization;

        //Load CSS & JS
        //$this->set_header_data();
        $all_groups = $this->attendance_model->get_all_classroom_groups();

        $data['group_code']=$group_code;

        $data['all_groups']=$all_groups->result();

        $data['all_groups']=$all_groups->result();
        $data['photo'] = false;
        if ($group_code) {
            $data['selected_group']= urldecode($group_code);
                $data['photo'] = true;
        }   else {
            $data['selected_group']=$default_group_code;
        }
		/* fi llista alumnes grup */
		$this->load->view('attendance/check_attendance',$data);
		 
		/*******************
		/*      FOOTER     *
		*******************/
		$this->_load_body_footer();		
	}

	protected function _alt_assign_colours($items,$item_id) {
        $items_colours = array();
        $bootstrap_button_colours = 
            array( 1 => "btn-greenyellow " ,
                   2 => "btn-darkred",
                   3 => "btn-coral",
                   4 => "btn-olivedrab",
                   5 => "btn-yellowgreen",
                   6 => "btn-mignightblue",
                   7 => "btn-chocolate",
                   8 => "btn-crimson",
                   9 => "btn-default",
                   0 => "btn-darkslategray"
                   );
        $index=1;
        if ( is_array ( $items )) {
        	foreach ($items as $item) {
            	$items_colours[$item->$item_id] = $bootstrap_button_colours[$index];
            	$index++;
        	}
        }
            
        return $items_colours;
    }

	protected function _assign_colours($items,$item_id) {
        $items_colours = array();
        $bootstrap_button_colours = 
            array( 1 => "btn-primary" ,
                   2 => "btn-info"    ,
                   3 => "btn-warning" ,
                   4 => "btn-success" ,
                   5 => "btn-danger"  ,
                   6 => "btn-sadlebrown" ,
                   7 => "btn-purple" ,
                   8 => "btn-gold" ,
                   9 => "btn-palegreen" ,
                   10 => "btn-lightgray" ,
                   11 => "btn-greenyellow" ,
                   12 => "btn-chocolate",
                   13 => "btn-coral",
                   14 => "btn-olivedrab",
                   15 => "btn-yellowgreen",
                   16 => "btn-mignightblue",
                   17 => "btn-darkred",
                   18 => "btn-crimson",
                   19 => "btn-default",
                   20 => "btn-darkslategray"
                   );
        $index=1;
        if ( is_array ( $items )) {
        	foreach ($items as $item) {
            	$items_colours[$item->$item_id] = $bootstrap_button_colours[$index];
            	$index++;
        	}
        }
            
        return $items_colours;
    }

	public function index() {
		$this->check_attendance();
	}

    public function load_datatables_data() {

        //CSS
        $header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery-ui.css'));  
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));  
        //JS
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");                     
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js")); 
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url("assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js"));   
        
        $this->_load_html_header($header_data);
        //$this->_load_html_header($header_data); 
        
        $this->_load_body_header();     

    }	
	
//OSCAR: GET TIME SLOTS
    public function get_time_slots($classroom_group_id=null,$lective)
    {
            $complete_time_slots_array = $this->timetables_model->getAllTimeSlots()->result_array();
            $data['complete_time_slots_count'] = count($complete_time_slots_array);            
            if($classroom_group_id){
                $shift = $this->timetables_model->get_group_shift($classroom_group_id);
			    $all_teacher_groups_time_slots[$classroom_group_id] = $this->timetables_model->get_time_slots_byShift($shift)->result_array();

                $time_slots_array = $this->timetables_model->get_time_slots_byShift($shift)->result_array();
            } else {
                $time_slots_array = $complete_time_slots_array;
            }

            $data['time_slots_array'] = $time_slots_array;

            //Get first and last time slot order
            $keys = array_keys($time_slots_array);
            $first_time_slot_order = $time_slots_array[$keys[0]]['time_slot_order'];
            $data['first_time_slot_order'] = $first_time_slot_order;            
            $last_time_slot_order = $time_slots_array[$keys[count($time_slots_array)-1]]['time_slot_order'];
            $data['last_time_slot_order'] = $last_time_slot_order;

            foreach ($time_slots_array as $time_slot)   {
                $time_slot_data = new stdClass;
                $time_slot_data->time_slot_start_time = $time_slot['time_slot_start_time'];
                $time_slot_data->time_interval = $time_slot['time_slot_start_time'] . " - " . $time_slot['time_slot_end_time'];
                $time_slot_data->time_slot_lective = $time_slot['time_slot_lective'];

                $time_slots[$time_slot['time_slot_id']] = $time_slot_data;
            }
            $time_slots_lective = array();
            $data['time_slots'] = $time_slots;
            foreach($time_slots as $time_slot){
            	if($time_slot->time_slot_lective == $lective){
            		$time_slots_lective[] = $time_slot;
            	}
            }
            $data['time_slots_lective'] = $time_slots_lective;
            $data['time_slots_count'] = count($time_slots);

            return $data;
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
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/test_incidents_managment_by_ajax_css.css'));     
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

        $header_data['menu']= $active_menu;
        return $header_data;
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

function renderitzar($table_name,$header_data = null)
{
       $output = $this->grocery_crud->render();

       // HTML HEADER
        $this->_load_html_header($header_data,$output); 
        $this->_load_body_header();      
       
       // BODY       
       $default_values=$this->_get_default_values();
       $default_values["table_name"]=$table_name;
       $default_values["field_prefix"]=$table_name."_";
       $this->load->view('defaultvalues_view.php',$default_values); 

       $this->load->view($table_name.'.php',$output);     
       
       // FOOTER     
       $this->_load_body_footer();  

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

function set_common_columns_name($table_name){
    $this->grocery_crud->display_as($table_name.'_entryDate',lang('entryDate'));
    $this->grocery_crud->display_as($table_name.'_last_update',lang('last_update'));
    $this->grocery_crud->display_as($table_name.'_creationUserId',lang('creationUserId'));                  
    $this->grocery_crud->display_as($table_name.'_lastupdateUserId',lang('lastupdateUserId'));   
    $this->grocery_crud->display_as($table_name.'_markedForDeletion',lang('markedForDeletion'));       
    $this->grocery_crud->display_as($table_name.'_markedForDeletionDate',lang('markedForDeletionDate')); 
}

}
