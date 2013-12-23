<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class attendance extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php' ;

	public $body_header_lang_file ='ebre_escool_body_header' ;
	
	function __construct()
    {
        parent::__construct();
        
        //$this->load->library('attendance');
        $this->load->model('attendance_model');
        $this->load->library('ebre_escool_ldap');

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

/* proves ajax, json */

	public function prova () {

		//CSS
		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			"http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
			
		$this->_load_html_header($header_data); 
		$this->_load_body_header();
        $this->load->view('attendance/prova.php');    
		$this->_load_body_footer();	
	}

	public function read($table=null){

		$this->db->select('alumne, incidencia, data, hora, posicio, observacions');
		$this->db->where('alumne', $_POST['alumne']); 
		//$this->db->where('hora', $_POST['hora']);
		$this->db->where('posicio', $_POST['posicio']);
		$query = $this->db->get($table);
		$resultat = array();
		$resultat[] = "Alumne  - Incidencia - Data - Hora - Observacions";

		foreach ($query->result() as $row)
		{
		    $resultat[] = $row->alumne ." - ".$row->incidencia." - ".$row->data." - ".$row->hora." - ".$row->observacions;
		}
		//print_r($resultat);
		print_r(json_encode($resultat));
	}	

	public function insert($table=null){
		//echo $table;
		/*
		$observacions =array();
		if(isset($_POST['pk'])){
			$observacions['observacions']=$_POST['value'];
		} else {
			$observacions=$_POST;
		}
		*/
		$this->db->insert($table, $_POST); 
		$rows = $this->db->affected_rows();
		print_r(json_encode($this->db->affected_rows()));
		//$this->db->insert($table, $data); 
		//print_r(json_encode($data));
	}		

	public function update($table=null){
		//echo $_POST['pk'];
		$observacions =array();
		if(isset($_POST['pk'])){
			$observacions['observacions']=$_POST['value'];
		} else {
			$observacions=$_POST;
		}
		$this->db->where('posicio', $_POST['pk']);
		$this->db->update($table, $observacions); 
		print_r(json_encode($observacions));
	}	

	public function delete(){
		$data = array(
			'Esborrat' => 'id 8'		
		);
		$this->db->where('cycle_id', '8');
		$this->db->delete('cycle'); 
		print_r(json_encode($data));
	}	

/* fi proves ajax json */	

	public function mentoring_groups () {

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			"http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/jquery-1.9.1.js");
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/ui/1.10.3/jquery-ui.js");	
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();
		
		echo "TODO";	

		$this->_load_body_footer();		

	}

	public function mentoring_attendance_by_student () {
		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			"http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/jquery-1.9.1.js");
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/ui/1.10.3/jquery-ui.js");	
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();
		
		echo "TODO";	

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
		//Cargar la llibreria fpdf
		$this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
		#$this->load->library('fpdf');
		$this->load->library('pdf');
		$pdf=new PDF();




		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			"http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/jquery-1.9.1.js");
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/ui/1.10.3/jquery-ui.js");	
			

		$this->current_table="classroom_group";
        $this->grocery_crud->set_table($this->current_table);

        //ESTABLISH SUBJECT        
        $this->grocery_crud->set_subject(lang('ClassroomGroup'));

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

		//Mandatory fields
        $this->grocery_crud->required_fields('group_name','group_shortName','group_markedForDeletion');
        
        //express fields
        $this->grocery_crud->express_fields('name','shortName','externalCode');

        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_add_field('group_lastupdate',array($this,'add_field_callback_last_update'));
      
        //CALLBACKS        
        $this->grocery_crud->callback_add_field('group_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('group_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('group_lastupdate',array($this,'edit_field_callback_lastupdate'));
        
        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
   		$this->grocery_crud->unset_add_fields('group_lastupdate');
        
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('group_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'group_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('group_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'group_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("group_creationUserId","group_lastupdateUserId","group_parentLocation");
        
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
        $this->grocery_crud->set_default_value($this->current_table,'group_parentLocation',1);
        
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'group_markedForDeletion','n');

        $this->grocery_crud->display_as('groupCode',lang('GroupCode'));
		$this->grocery_crud->display_as('groupShortName',lang('GroupShortName'));
		$this->grocery_crud->display_as('groupName',lang('GroupName'));
		$this->grocery_crud->display_as('groupDescription',lang('GroupDescription'));
		$this->grocery_crud->display_as('educationalLevelId',lang('EducationalLevelId'));
		$this->grocery_crud->display_as('mentorId',lang('MentorId'));

		/* show only specified columns */
		$this->grocery_crud->columns('group_id','group_code','group_shortName','group_name','group_description','group_mentorId','group_entryDate','group_lastupdate','group_creationUserId','group_lastupdateUserId');

		$output = $this->grocery_crud->render();
                        
        $this->_load_html_header($header_data,$output); 
	    $this->_load_body_header();
			
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="group_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('attendance/classroom_groups_view.php',$output);     


		$this->_load_body_footer();

	}
	
	public function check_attendance($grup = null) {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			"http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/jquery-1.9.1.js");
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://code.jquery.com/ui/1.10.3/jquery-ui.js");	
			
		$this->_load_html_header($header_data); 
		
		/*******************
		/*      BODY     *
		/******************/
		$this->_load_body_header();
		
		//Obtain all teacher groups for selected date
		
		//$teacher_code = $_SESSION['codi_professor'];
		
		//$teacher_code = $_SESSION['codi_professor'];
		
		$teacher_code = 41;
		
		//teacher: teacher_code:
		//day
		
		
		$data= array();

		if(isset($grup)){
			$data['grup'] = $grup;	
		}

		$data['check_attendance_day']="TODO";
		$data['check_attendance_table_title']=lang('check_attendance_table_title');
		$data['choose_date_string']=lang('choose_date_string');
		$data['today']=date('d-m-Y');

		$teacher_groups_current_day=array();
		$hores = array(
				"15:30",
				"16:30",
				"17:30",
				"19:00",
				"20:00",
				"21:00"
			);

		$data['hores']=$hores;		
		
		$group = new stdClass;
		$group->time_interval="16:30 - 17:30";
		//$group->group_url=base_url("attendance/select_student/codi_dia=1&codi_hora=1&codi_grup=1SEA&codi_ass=M%201&time_interval=8:00%20-%209:00&optativa=0");
		//$group->group_name="i automa (S)";
		$group->group_code="M 7";
		$group->group_url=base_url("index.php?/attendance/check_attendance/2ASIX");
		$group->group_name="2ASIX";
		
		$teacher_groups_current_day['key1']= $group;
		
		$group1 = new stdClass;
		$group1->time_interval="15:30 - 16:30";
		//$group1->group_url=base_url("attendance/select_student/codi_dia=1&codi_hora=1&codi_grup=1SEA&codi_ass=M%201&time_interval=8:00%20-%209:00&optativa=0");
		//$group1->group_name="GRUP MPROVA";
		$group1->group_code="M 8";
		$group1->group_url=base_url("index.php?/attendance/check_attendance/2DAM");
		$group1->group_name="2DAM";

		$group2 = new stdClass;
		$group2->time_interval="11:00 - 12:00";
		//$group2->group_url=base_url("attendance/select_student/codi_dia=1&codi_hora=1&codi_grup=1SEA&codi_ass=M%201&time_interval=8:00%20-%209:00&optativa=0");
		//$group2->group_name="GRUP M9";
		$group2->group_code="M 9";
		$group2->group_url=base_url("index.php?/attendance/check_attendance/1AF");
		$group2->group_name="1AF";		
		
		$teacher_groups_current_day['key2']=$group;
		$teacher_groups_current_day['key3']=$group1;
		$teacher_groups_current_day['key4']=$group;
		$teacher_groups_current_day['key4']=$group2;
		
		$data['teacher_groups_current_day']=$teacher_groups_current_day;
		
/* Llista alumnes grup */

        $default_group_code = $grup;
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
        if ($grup) {
            $data['selected_group']= urldecode($grup);
                $data['photo'] = true;
        }   else {
            $data['selected_group']=$default_group_code;
        }
       // echo $data['selected_group'];
       // $students_base_dn= $this->config->item('students_base_dn','skeleton_auth');
       // $default_group_dn=$students_base_dn;
        if ($data['selected_group']!="ALL_GROUPS")
            $default_group_dn=$this->ebre_escool_ldap->getGroupDNByGroupCode($data['selected_group']);
        
        if ($data['selected_group']=="ALL_GROUPS")
            $data['selected_group_names']= array (lang("all_tstudents"),"");
        else
            $data['selected_group_names']= $this->attendance_model->getGroupNamesByGroupCode($data['selected_group']);
        
        $data['all_students_in_group']= $this->ebre_escool_ldap->getAllGroupStudentsInfo($default_group_dn);
        //print_r($data['all_students_in_group']);       
        //$data['all_students']= $this->ebre_escool_ldap->getAllGroupStudentsInfo("ou=Alumnes,ou=All,dc=iesebre,dc=com");
        //Total de professors
        $data['count_alumnes'] = count($data['all_students_in_group']);


/* fi llista alumnes grup */
		$this->load->view('attendance/check_attendance',$data);
		
		 
		/*******************
		/*      FOOTER     *
		*******************/
		$this->_load_body_footer();		
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
	
}
