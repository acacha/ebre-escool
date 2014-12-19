<?php defined('BASEPATH') OR exit('No direct script access allowed');

//include "skeleton_main.php";
include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class managment extends skeleton_main {
	
    public $body_header_view ='include/ebre_escool_body_header.php' ;
    public $body_header_lang_file ='ebre_escool_body_header' ;

    public $html_header_view ='include/ebre_escool_html_header' ;

    public $body_footer_view ='include/ebre_escool_body_footer' ;       

	function __construct()
    {
        parent::__construct();
        
        //CHANGE: Sergi Tur. Move all function form attendance model to managment model
        //$this->load->model('attendance_model');
        $this->load->model('managment_model');
        $this->load->library('ebre_escool_ldap');
        $this->load->library('ebre_escool');
        //$this->config->load('managment');        
        $this->config->load('ebre-escool',true);
        $this->config->load('auth_ldap',true);

        //Google Apps library
        
        //TODO Third Party!
        
        //$this->load->add_package_path(APPPATH.'third_party/googleapps-codeigniter/application/');
        $this->load->library('googleapps'); // Load library
        
        /* Set language */
        $current_language=$this->session->userdata("current_language");
        if ($current_language == "") {
            $current_language= $this->config->item('default_language');
        }
        
        // Load the language file
        $this->lang->load('managment',$current_language);
        $this->load->helper('language');

	}
	
	protected function _getvar($name){
		if (isset($_GET[$name])) return $_GET[$name];
		else if (isset($_POST[$name])) return $_POST[$name];
		else return false;
	}
	
	public function massive_change_password_print() {
		$group_code=$this->_getvar("group_code");
		$only_students_with_all_data=$this->_getvar("only_students_with_all_data");
		
		if ($group_code) {
			//Obtain groupdn
			$students_base_dn= $this->config->item('students_base_dn','skeleton_auth');
            $all_groups_dns= $this->ebre_escool_ldap->getAllGroupsDNs($students_base_dn);

			$group_dn="";
			if (array_key_exists($group_code,$all_groups_dns))	{
				$group_dn=$all_groups_dns[$group_code];
			}
			if ($group_dn != "") {
				$new_passwords_array=array();
				$all_group_students_dns = $this->ebre_escool_ldap->getAllGroupStudentsDNs($group_dn);
				
				$i=0;
				$number_of_users= count($all_group_students_dns);
				$new_passwords = array();
				$new_passwords= $this->ebre_escool_ldap->propose_passwords($number_of_users);		
				foreach ($all_group_students_dns as $student_key => $student) {
					
					$user_data= $this->ebre_escool_ldap->getEmailAndPhotoData($student);
					if ($user_data == "") {
						echo "<br/>Fatal Error! No enrollment data found for DN: " . $all_group_students_dns[$i];
						exit(1);
					}
					$personal_email = (isset($user_data['highschoolpersonalemail']['0'])) ? $user_data['highschoolpersonalemail']['0'] : "";
					$photo = (isset($user_data['jpegphoto']['0'])) ? $user_data['jpegphoto']['0'] : "";

					$skip=false;
					switch ($only_students_with_all_data) {
						case 1:
							$skip = ( ($personal_email != "") &&  ($photo != "") ) ? false : true;
							break;
						case 2:
							$skip = ( ($personal_email != "")) ? false : true;
							break;
						case 3:
							$skip = ( ($photo != "") ) ? false : true;
							break;
						case 4:
							break;
					}
					
					if (!$skip) {
						//Generate new password
						if (!$this->ebre_escool_ldap->change_password($student,$new_passwords[$i])) {
							show_error("Password not changed correctly!");
						}
					} else {
						unset($all_group_students_dns[$student_key]);
						unset($new_passwords[$student_key]);
					}
					$i++;
				}
				
				$all_group_students_dns = array_values($all_group_students_dns);
				$new_passwords = array_values($new_passwords);
				//echo "<br/>new_passwords:" . print_r($new_passwords) . "<br/>";
				//echo "<br/>all_group_students_dns:" . print_r($all_group_students_dns) . "<br/>";
				//echo "<br/>group_code:" . $group_code . "<br/>";
				//CALL CONTROLLER print_massive_enrollment with arrays				
				$this->session->set_flashdata('all_group_students_dns', $all_group_students_dns);
				$this->session->set_flashdata('new_passwords_array', $new_passwords);
				$this->session->set_flashdata('group_code', $group_code);
				$this->session->set_flashdata('url_after_download', "http://localhost/ebre-escool/index.php/managment/massive_change_password");
				redirect("reports/print_massive_enrollment", 'refresh');
			}
		}
	}

	public function change_study_submodule_final_date() {

		$study_submodule_id = null;
	    if(isset($_POST['study_submodule_id'])) {
        	$study_submodule_id = $_POST['study_submodule_id'];
	        
	    }
		$new_finalDate = null;
	    if(isset($_POST['new_finalDate'])) {
        	$new_finalDate = $_POST['new_finalDate'];
	    }
	    

	    $result = new stdClass();
		$result->result = false;
		$result->message = "Not all mandatory parameters exists. study_submodule_id: " . $study_submodule_id . " new_finalDate: " . $new_finalDate;
	    if ( ($study_submodule_id != null) &&  ($new_finalDate != null) ) {
	    	$result = $this->managment_model->change_study_submodule_final_date($study_submodule_id,$new_finalDate);
	    } 

	    print_r(json_encode($result));

	}

	public function change_study_submodule_final_date_planned() {

		$study_submodule_id = null;
	    if(isset($_POST['study_submodule_id'])) {
        	$study_submodule_id = $_POST['study_submodule_id'];
	        
	    }
		$new_finalDate_planned = null;
	    if(isset($_POST['new_finalDate_planned'])) {
        	$new_finalDate_planned = $_POST['new_finalDate_planned'];
	    }
	    

	    $result = new stdClass();
		$result->result = false;
		$result->message = "Not all mandatory parameters exists. study_submodule_id: " . $study_submodule_id . " new_finalDate_planned: " . $new_finalDate_planned;
	    if ( ($study_submodule_id != null) &&  ($new_finalDate_planned != null) ) {
	    	$result = $this->managment_model->change_study_submodule_final_date_planned($study_submodule_id,$new_finalDate_planned);
	    } 

	    print_r(json_encode($result));

	}


	public function change_study_submodule_initial_date() {

		$study_submodule_id = null;
	    if(isset($_POST['study_submodule_id'])) {
        	$study_submodule_id = $_POST['study_submodule_id'];
	        
	    }
		$new_initialDate = null;
	    if(isset($_POST['new_initialDate'])) {
        	$new_initialDate = $_POST['new_initialDate'];
	    }
	    

	    $result = new stdClass();
		$result->result = false;
		$result->message = "Not all mandatory parameters exists. study_submodule_id: " . $study_submodule_id . " new_initialDate: " . $new_initialDate;
	    if ( ($study_submodule_id != null) &&  ($new_initialDate != null) ) {
	    	$result = $this->managment_model->change_study_submodule_initial_date($study_submodule_id,$new_initialDate);
	    } 

	    print_r(json_encode($result));

	}

	public function change_study_submodule_initial_date_planned() {

		$study_submodule_id = null;
	    if(isset($_POST['study_submodule_id'])) {
        	$study_submodule_id = $_POST['study_submodule_id'];
	        
	    }
		$new_initialDate_planned = null;
	    if(isset($_POST['new_initialDate_planned'])) {
        	$new_initialDate_planned = $_POST['new_initialDate_planned'];
	    }
	    

	    $result = new stdClass();
		$result->result = false;
		$result->message = "Not all mandatory parameters exists. study_submodule_id: " . $study_submodule_id . " new_initialDate_planned: " . $new_initialDate_planned;
	    if ( ($study_submodule_id != null) &&  ($new_initialDate_planned != null) ) {
	    	$result = $this->managment_model->change_study_submodule_initial_date_planned($study_submodule_id,$new_initialDate_planned);
	    } 

	    print_r(json_encode($result));

	}


	public function change_study_submodule_total_hours() {

		$study_submodule_id = null;
	    if(isset($_POST['study_submodule_id'])) {
        	$study_submodule_id = $_POST['study_submodule_id'];
	        
	    }
		$new_total_hours = null;
	    if(isset($_POST['new_total_hours'])) {
        	$new_total_hours = $_POST['new_total_hours'];
	    }
	    

	    $result = new stdClass();
		$result->result = false;
		$result->message = "Not all mandatory parameters exists. study_submodule_id: " . $study_submodule_id . " totalHours: " . $new_total_hours;
	    if ( ($study_submodule_id != null) &&  ($new_total_hours != null) ) {
	    	$result = $this->managment_model->change_study_submodule_total_hours($study_submodule_id,$new_total_hours);
	    } 

	    print_r(json_encode($result));

	}

	

	public function study_submodules_dates($academic_period_id = null,$teacher_code = null, $classroom_group_id = null) {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}

		$user_is_admin = $this->ebre_escool->user_is_admin();
		$user_is_teacher = $this->session->userdata('is_teacher');

		if ( !($user_is_admin || $user_is_teacher) ) {
			echo "Access not allowed!";
		}

		$selected_academic_period_id = false;

		$current_academic_period_id = null;

		if ($academic_period_id == null) {
			$database_current_academic_period =  $this->managment_model->get_current_academic_period();
			
			if ($database_current_academic_period->id) {
				$current_academic_period_id = $database_current_academic_period->id;
			} else {
				$current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');	
			}
			
			$academic_period_id=$current_academic_period_id ;	
		} else {
			$selected_academic_period_id = $academic_period_id;
		}

		$mentor_classroom_group_ids = $this->managment_model->is_mentor_return_classroom_group_id($this->session->userdata('person_id'), $academic_period_id);
		$user_teacher_code = $this->managment_model->get_teacher_code_by_personid($this->session->userdata('person_id'));

		$user_is_mentor=true;
		if ($mentor_classroom_group_ids == false) {
			$user_is_mentor=false;	
		} 

		$active_menu = array();
		$active_menu['menu']='#maintenances_teachers';
		$active_menu['submenu1']='#maintenances_teachers_curriculum';
		$active_menu['submenu2']='#maintenances_teachers_curriculum_study_submodules_dates';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		$header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/datepicker.css'));	
		$header_data = $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery.gritter.css')); 

		//JS			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");
		$header_data= $this->add_javascript_to_html_header_data(
	        $header_data,
	        base_url('assets/js/jquery.gritter.min.js')); 
		$header_data= $this->add_javascript_to_html_header_data(
	        $header_data,
	        base_url('assets/js/jquery-ui-1.10.3.full.min.js')); 
		$header_data= $this->add_javascript_to_html_header_data(
	        $header_data,
	        base_url('assets/js/jquery.jeditable.mini.js')); 
		$header_data= $this->add_javascript_to_html_header_data(
	        $header_data,
	        base_url('assets/js/bootstrap-datepicker.js')); 
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.ca.js'));
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url('assets/js/bootstrap-datepicker.es.js'));
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$data['study_submodules_table_title'] = "Unitats formatives / Unitats didàctiques";
		
		$academic_periods = $this->managment_model->get_all_academic_periods();	

		$data['academic_periods'] = $academic_periods;

		$data['selected_academic_period_id'] = $selected_academic_period_id;

		$dates = $this->managment_model->get_academic_period_dates($academic_period_id);
		
		$data['selected_academic_period_initial_date'] = $dates->initial_date;
		$data['selected_academic_period_final_date'] = $dates->final_date;
		$data['selected_academic_period_initial_date_planned'] = $dates->initial_date;
		$data['selected_academic_period_final_date_planned'] = $dates->final_date;

		$teachers_array = array();
		//Load teachers from Model
		$teachers_array = $this->managment_model->get_all_teachers_ids_and_names();
		$data['teachers'] = $teachers_array;

		$data['default_teacher'] = null;
		if ($teacher_code != null ) {
			if ($teacher_code == "void") {
				$data['default_teacher'] = null;
			} else {
				$data['default_teacher'] = $teacher_code;	
			}
		} else {
			if ($user_teacher_code != false) {
				$data['default_teacher'] = $user_teacher_code;	
			} else {
				$data['default_teacher'] = null;
			}
		}

		$all_classroom_groups = array();
		$all_classroom_groups = $this->managment_model->get_all_classroomgroups($academic_period_id);
		$data['classroom_groups'] = $all_classroom_groups;

		$data['default_classroom_group_id'] = null;
		if ( ($classroom_group_id != null) && ($classroom_group_id != "void") ) {
			$data['default_classroom_group_id'] = $classroom_group_id;
		}

		//GET STUDY SUBMODULES. TAKE IN ACCOUNT CURRENT SELECTED FILTERS
		//FILTERS $teacher_code = null, $classroom_group_id = null
		$study_submodules = array();	
		
		$teacher_filter_exists = false;
		if ( $teacher_code == null ) {
			if ($user_teacher_code != false) {
				$teacher_filter_exists = true;
			} else {
				$teacher_filter_exists = false;
			}
			
		} else {
			if ( $teacher_code ==  "void") {
				$teacher_filter_exists = false;
			} else {
				$teacher_filter_exists = true;
			}
		}

		$classroom_group_id_filter_exists = false;
		if ( $classroom_group_id == null ) {
			$classroom_group_id_filter_exists = false;
		} else {
			if ( $classroom_group_id ==  "void") {
				$classroom_group_id_filter_exists = false;
			} else {
				$classroom_group_id_filter_exists = true;
			}
		}
		
		/* DEBUG:
		echo "teacher_filter_exists: " . $teacher_filter_exists . "<br/>";
		echo "classroom_group_id_filter_exists: " . $classroom_group_id_filter_exists . "<br/>";
		*/
		if ( ($teacher_filter_exists == false) && ($classroom_group_id_filter_exists == false) ) {
			//NO FILTERS APPLY
			$study_submodules = $this->managment_model->get_all_study_submodules_report_info($academic_period_id);
		} else {
			//FILTERS ARE SET
			if ( ($teacher_filter_exists == true) && ($classroom_group_id_filter_exists == false) ) {
				//ONLY FILTER BY TEACHER
				if (($teacher_code != "") && ($teacher_code != null)) {
					$study_submodules = $this->managment_model->get_all_study_submodules_report_info_by_teacher_code($academic_period_id,$teacher_code);
				} else {
					if (($user_teacher_code != "") && ($user_teacher_code != null)) {
						$study_submodules = $this->managment_model->get_all_study_submodules_report_info_by_teacher_code($academic_period_id,$user_teacher_code);
					}
				}
				
			}

			if ( ($teacher_filter_exists == false) && ($classroom_group_id_filter_exists == true) ) {
				//ONLY FILTER BY CLASSROOMGROUPID
				$study_submodules = $this->managment_model->get_all_study_submodules_report_info_by_classroomgroupid($academic_period_id,$classroom_group_id);
			}

			if ( ($teacher_filter_exists == true) && ($classroom_group_id_filter_exists == true) ) {
				//FILTER BY TEACHER AND CLASSROOMGROUPID
				if (($teacher_code != "") && ($teacher_code != null)) {
					$study_submodules = $this->managment_model->get_all_study_submodules_report_info_by_classroomgroupid_and_teacher_code($academic_period_id,$teacher_code,$classroom_group_id);
				} else {
					if (($user_teacher_code != "") && ($user_teacher_code != null)) {
						$study_submodules = $this->managment_model->get_all_study_submodules_report_info_by_classroomgroupid_and_teacher_code($academic_period_id,$user_teacher_code,$classroom_group_id);
					}
				}
			}

		}

		$data['study_submodules'] = $study_submodules;

		$editable_study_submodules_ids = array();

		if ($user_is_admin) {
			$all_study_submodules = $this->managment_model->get_all_study_submodules_report_info($academic_period_id);
			$editable_study_submodules_ids=array_keys($all_study_submodules);
		} else {
			if ($user_is_teacher) {
				if ($user_is_mentor) {
					//GET LISTS OF STUDY_MODULES IDS OF GROUPS TEACHERS IS MENTOR
					$mentor_study_submodules = $this->managment_model->get_all_study_submodules_id_by_mentor_id($academic_period_id,$user_teacher_code); 
					//GET LIST OF STUDYMOUDLES IDS OF TEACHER
					$user_study_submodules = $this->managment_model->get_all_study_submodules_report_info_by_teacher_code($academic_period_id,$user_teacher_code);
					$editable_study_submodules_ids = array_merge($mentor_study_submodules, array_keys($user_study_submodules));
				} else {
					//GET LIST OF STUDYMOUDLES IDS OF TEACHER
					$user_study_submodules = $this->managment_model->get_all_study_submodules_report_info_by_teacher_code($academic_period_id,$user_teacher_code);
					$editable_study_submodules_ids = array_keys($user_study_submodules);
				}	
			}
		}
		$data['editable_study_submodules_ids'] = $editable_study_submodules_ids;

		$this->load->view('study_submodules_dates.php',$data);	
		$this->_load_body_footer();	
		
	}

	public function curriculum_reports_lessons($academic_period_id = null) {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#reports';
		$active_menu['submenu1']='#curriculum_reports';
		$active_menu['submenu2']='#curriculum_reports_lessons';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		$header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
		$header_data = $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery.gritter.css'));  

		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");
		$header_data= $this->add_javascript_to_html_header_data(
	        $header_data,
	        base_url('assets/js/jquery.gritter.min.js')); 

			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$data['lessons_table_title'] = "Lliçons";
		$selected_academic_period_id = false;

		$current_academic_period_id = null;

		if ($academic_period_id == null) {
			$database_current_academic_period =  $this->managment_model->get_current_academic_period();
			
			if ($database_current_academic_period->id) {
				$current_academic_period_id = $database_current_academic_period->id;
			} else {
				$current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');	
			}
			
			$academic_period_id=$current_academic_period_id ;	
		} else {
			$selected_academic_period_id = $academic_period_id;
		}

		$academic_periods = $this->managment_model->get_all_academic_periods();	
		$all_lessons = $this->managment_model->get_all_lessons_report_info($academic_period_id);

		$data['all_lessons'] = $all_lessons;

		$data['academic_periods'] = $academic_periods;
		$data['selected_academic_period_id'] = $selected_academic_period_id;

		$this->load->view('curriculum_reports_lessons.php',$data);
		
		
		$this->_load_body_footer();	
		
	}


	public function create_initial_password() {
		if (!$this->session->userdata('is_admin')) {
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');	
		}


		$header_data = $this->load_ace_files();	

		//CSS
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/jquery-ui.css'));		
		
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js"));			
		
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();
		$data['result_message_exists']=false;


		$new_password = "";
		$username = "";

		//var_dump($_POST)."<br/>";

		if(isset($_POST['username'])) {
			$username = $_POST['username'];
		}

		if(isset($_POST['new_password'])) {
			$new_password = $_POST['new_password'];
		}

		//VALIDATE FORM
		if ( count($_POST) > 0) {

			if ($username === "") {
				$data['result_message_exists']=true;
				$data['result_message_ok'] = false;
				$data['result_message'] = "Cal indicar un nom d'usuari";
			} else {
				if ($new_password === "") {
					$data['result_message_exists']=true;
					$data['result_message_ok'] = false;
					$data['result_message'] = "Cal indicar una nova paraula de pas inicial!";
				} else {
					//Form Ok. Change password
					//Get user id from session
					$result = $this->managment_model->create_initial_password( $username ,$new_password);
					if ($result) {

						if ($result === -2) {
							$data['result_message_exists']=true;
							$data['result_message_ok'] = false;
							$data['result_message'] = "No s'ha trobat l'usuari!";	
						} else {
							$data['result_message_exists']=true;
							$data['result_message_ok'] = true;
							$data['result_message'] = "La paraula de pas s'ha modificat correctament!";
						}
					} else {
						
							$data['result_message_exists']=true;
							$data['result_message_ok'] = false;
							$data['result_message'] = "Hi hagut un error al modificar la paraula de pas!";
					}							
				}
			}
		}

		$data['all_usernames'] = array();
		$all_usernames = $this->managment_model->all_usernames();
		$data['all_usernames'] = $all_usernames;	

		$this->load->view('create_initial_password.php',$data);
		$this->_load_body_footer();	

	}

	public function change_password($change_password_by_admin = 0) {

		if ($change_password_by_admin != 0) {
			if (!$this->session->userdata('is_admin')) {
				//redirect them to the login page
				redirect($this->skeleton_auth->login_page, 'refresh');	
			}
		}

		$force_change_password_message = false;
		if ($change_password_by_admin == 0) {
			//print_r($this->session->userdata);
	        if (!$this->session->userdata('logged_in_change_password')) {
				if (!$this->skeleton_auth->logged_in())
				{
					//redirect them to the login page
					redirect($this->skeleton_auth->login_page, 'refresh');
				}
			} else  {
				$force_change_password_message = true;
			}
		}
		
		$header_data = $this->load_ace_files();	

		//CSS
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/jquery-ui.css'));		
		
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js"));			
		
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$form_field_pass0 = "";
		$form_field_pass1 = "";
		$form_field_pass2 = "";
		$username = "";

		//var_dump($_POST)."<br/>";

		if(isset($_POST['username'])) {
			$username = $_POST['username'];
		}

		if(isset($_POST['form-field-pass0'])) {
			$form_field_pass0 = $_POST['form-field-pass0'];
		}

		if(isset($_POST['form-field-pass1'])) {
			$form_field_pass1 = $_POST['form-field-pass1'];
		}

		if(isset($_POST['form-field-pass2'])) {
			$form_field_pass2 = $_POST['form-field-pass2'];
		}

		//echo "form_field_pass0: " . $form_field_pass0."<br/>";
		//echo "form_field_pass1: " . $form_field_pass1."<br/>";
		//echo "form_field_pass2: " . $form_field_pass2."<br/>";

		$data = array();
		$data['result_message_exists']=false;
		$data['force_change_password_message']=$force_change_password_message;

		//VALIDATE FORM
		if ( count($_POST) > 0) {
			//Validate form
			if ($change_password_by_admin == 0) {
				if ($form_field_pass0 === "") {
					$data['result_message_exists']=true;
					$data['result_message_ok'] = false;
					$data['result_message'] = "Cal indicar la paraula de pas actual!";
				} else {
					if ($form_field_pass1 === "") {
						$data['result_message_exists']=true;
						$data['result_message_ok'] = false;
						$data['result_message'] = "Cal indicar una nova paraula de pas!";
					} else {
						if ($form_field_pass2 === "") {
							$data['result_message_exists']=true;
							$data['result_message_ok'] = false;
							$data['result_message'] = "Cal confirmar la nova paraula de pas!";
						} else {
							if ($form_field_pass1 != $form_field_pass2) {
								$data['result_message_exists']=true;
								$data['result_message_ok'] = false;
								$data['result_message'] = "La paraula de pas nova i el camp de confirmació no coincideixen!";
							} else {
								//Form Ok. Change password
								//Get user id from session

								$new_password = $form_field_pass1;
								$old_password = $form_field_pass0;
								$result = $this->managment_model->change_password( $this->session->userdata('username') ,$new_password,$old_password);
								if ($result) {
									if ($result === -1) {
										$data['result_message_exists']=true;
										$data['result_message_ok'] = false;
										$data['result_message'] = "La paraula de pas antiga és incorrecte!";	
									} else {
										$data['result_message_exists']=true;
										$data['result_message_ok'] = true;
										$data['result_message'] = "La paraula de pas s'ha modificat correctament!";

										$sessiondata_change_password = array(
							                   'logged_in' => true,
							                   'logged_in_change_password' => false,
							               );
							            $this->session->set_userdata($sessiondata_change_password);
									}
									
								} else {
									
										$data['result_message_exists']=true;
										$data['result_message_ok'] = false;
										$data['result_message'] = "Hi hagut un error al modificar la paraula de pas!";
								}							
							}
						}
					}				
				}
			}
			else {
				if ($username === "") {
					$data['result_message_exists']=true;
					$data['result_message_ok'] = false;
					$data['result_message'] = "Cal indicar un nom d'usuari";
				} else {
					if ($form_field_pass1 === "") {
						$data['result_message_exists']=true;
						$data['result_message_ok'] = false;
						$data['result_message'] = "Cal indicar una nova paraula de pas!";
					} else {
						if ($form_field_pass2 === "") {
							$data['result_message_exists']=true;
							$data['result_message_ok'] = false;
							$data['result_message'] = "Cal confirmar la nova paraula de pas!";
						} else {
							if ($form_field_pass1 != $form_field_pass2) {
								$data['result_message_exists']=true;
								$data['result_message_ok'] = false;
								$data['result_message'] = "La paraula de pas nova i el camp de confirmació no coincideixen!";
							} else {
								//Form Ok. Change password
								//Get user id from session

								$new_password = $form_field_pass1;
								$result = $this->managment_model->force_change_password( $username ,$new_password);
								if ($result) {
									if ($result === -2) {
										$data['result_message_exists']=true;
										$data['result_message_ok'] = false;
										$data['result_message'] = "No s'ha trobat l'usuari!";	
									} else {
										$data['result_message_exists']=true;
										$data['result_message_ok'] = true;
										$data['result_message'] = "La paraula de pas s'ha modificat correctament!";

										$sessiondata_change_password = array(
							                   'logged_in' => true,
							                   'logged_in_change_password' => false,
							               );
							            $this->session->set_userdata($sessiondata_change_password);
									}
									
								} else {
									
										$data['result_message_exists']=true;
										$data['result_message_ok'] = false;
										$data['result_message'] = "Hi hagut un error al modificar la paraula de pas!";
								}							
							}
						}
					}
				}
			}

				



		}

		$data['change_password_by_admin'] = false;
		$data['all_usernames'] = array();
		if ($change_password_by_admin == 1) {

			$all_usernames = $this->managment_model->all_usernames();
			
			$data['all_usernames'] = $all_usernames;	
			$data['change_password_by_admin'] = true;			
		}

		$this->load->view('change_password.php',$data);
		$this->_load_body_footer();	

	}

	public function users_ldap_activate($userid = null, $force_sync = true,$password = null) {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}

		if (!$this->session->userdata('is_admin')) {
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');	
		}

		//IF NOT EXISTS CREATE USER IN LDAP 

		//Get user_id
		if ($userid === null) {
			//Try to get user from post data
			if(isset($_POST['userid'])) {
		        $userid = $_POST['userid'];
		    } else {
		    	echo "Error. Not user specified!";
		    	return false;
		    }
		}
		//echo "USER ID: $userid<br/>";

		//GET USER DATA FORM DATABASE
		$user_data = new stdClass();
		$user_data = $this->managment_model->get_user_data($userid);

		if ( ($user_data->ldap_dn != "") && ($force_sync == false) ) {
			//LDAP DN ALREADY EXISTS
			echo "ERROR. LDAP DN ALREADY EXISTS ON DATABASE: $user_data->ldap_dn<br/>";

			//TODO

		} else {
			
			//Calculate new DN
			//$basedn = $this->config->item('basedn');		
			$active_users_basedn = $this->config->item('active_users_basedn');

			//echo "BASEDN: $basedn<br/>";
			//echo "BASEDN WHERE INSERT NEW LDAP USER: " . $user_data->basedn_where_insert_new_ldap_user . "<br/>";
			//echo "USER CN: " . $user_data->cn . "<br/>";
			//echo "USER DN: " . $user_data->dn . "<br/>";

			//TODO
			if ($password == null) {
				//TODO: generate random password?
				$user_data->password = "password";				
			} else {
				$user_data->password = $password;				
			}
			

			//Debug
			//echo "USER data:<br/>";		
			//var_export($user_data);

			//Check if user exists
			//NOTE: uid=username is UNIQUE INDEX in users database. If ldap users are created only from mysql sync proces no repeated uids occurrs
			//echo "Username: " . $user_data->username . "<br/>";
			//echo "Active_users_basedn: " . $active_users_basedn. "<br/>";

			$user_exists=$this->managment_model->user_exists($user_data->username,$active_users_basedn);
			if ($user_exists) {
				if ($force_sync) {
					//echo "DN ALREADY EXISTS. FORCE SYNC IS ACTIVE. THEN FIRST WE WILL DELETE LDAP USER<br/>";
					//Delete existing user and substitute by new one?
					if ($user_exists === $user_data->dn) {
						$this->managment_model->deleteLdapUser($user_data->dn);
					} else {
						echo "ERROR! DNs not match!<br/>";
						return false;
					}
					//INSERT NEW LDAP USER
					$this->managment_model->addLdapUser($user_data->dn,$user_data);
					$this->managment_model->update_user_ldap_dn($user_data->username, $user_data->dn);
				} else {
					echo "ERROR. USER ALREADY EXISTS<br/>";
				}
			} else {
				//INSERT NEW LDAP USER
				$this->managment_model->addLdapUser($user_data->dn,$user_data);
				$this->managment_model->update_user_ldap_dn($user_data->username, $user_data->dn);
			}
		}
	}

	public function get_users_ldap($academic_period_id = null) {

		$users_ldap = array();
	    $users_ldap = $this->managment_model->get_all_ldap_users($academic_period_id);    

	    echo '{
	    "aaData": ';

	    print_r(json_encode($users_ldap));

	    echo '}';
	}

	public function get_persons() {

		$persons = array();
	    
	    $persons = $this->managment_model->get_all_persons();    

	    echo '{
	    "aaData": ';

	    print_r(json_encode($persons));

	    echo '}';
	}

	public function get_users() {

		$users = array();
	    
	    $users = $this->managment_model->get_all_users();    

	    echo '{
	    "aaData": ';

	    print_r(json_encode($users));

	    echo '}';
	}

	public function get_users_google_apps($academic_period_id = null) {

		$users_google_apps = array();


		$users_google_apps = $this->googleapps->get_all_users();
	    
	    echo '{
	    "aaData": ';

	    print_r(json_encode($users_google_apps));

	    echo '}';
	}

	

	public function users_google_apps($academic_period_id=null) {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#managment';
		$active_menu['submenu1']='#managment_users_google_apps';

		$header_data = $this->load_ace_files($active_menu);

		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/dataTables.colReorder.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/dataTables.colVis.css'));
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		$header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
		$header_data = $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery.gritter.css'));  

		//JS
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js'));

		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));
		$header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/dataTables.colReorder.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/dataTables.colVis.js'));

		$header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");
		$header_data= $this->add_javascript_to_html_header_data(
	        $header_data,
	        base_url('assets/js/jquery.gritter.min.js')); 
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$selected_academic_period_id = false;
        $current_academic_period_id = null;

        if ($academic_period_id == null) {
            $database_current_academic_period =  $this->managment_model->get_current_academic_period();
            
            if ($database_current_academic_period->id) {
                $current_academic_period_id = $database_current_academic_period->id;
            } else {
                $current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');  
            }
            
            $academic_period_id=$current_academic_period_id ;   
        } else {
            $selected_academic_period_id = $academic_period_id;
        }

        $academic_periods = $this->managment_model->get_all_academic_periods();

		$data['user_ldap_table_title'] = "Usuaris Google Apps";
		$data['academic_periods'] = $academic_periods;
        $data['selected_academic_period_id'] = $selected_academic_period_id;
        $data['academic_period_id'] = $academic_period_id;
		
		$this->load->view('users_google_apps.php',$data);
		
		
		$this->_load_body_footer();	
		
	}

	public function persons() {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}

		$active_menu = array();
		$active_menu['menu']='#managment';
		$active_menu['submenu1']='#managment_persons';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/dataTables.colReorder.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/dataTables.colVis.css'));
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		$header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
		$header_data = $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery.gritter.css'));  

		//JS
		
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js'));

		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));
		$header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/dataTables.colReorder.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/dataTables.colVis.js'));

		$header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");
		$header_data= $this->add_javascript_to_html_header_data(
	        $header_data,
	        base_url('assets/js/jquery.gritter.min.js')); 
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$this->load->view('persons.php',$data);
		
		
		$this->_load_body_footer();	

	}

	public function users() {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}

		$active_menu = array();
		$active_menu['menu']='#managment';
		$active_menu['submenu1']='#managment_users_not_gc';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/dataTables.colReorder.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/dataTables.colVis.css'));
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		$header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
		$header_data = $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery.gritter.css'));  

		//JS
		
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js'));

		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));
		$header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/dataTables.colReorder.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/dataTables.colVis.js'));

		$header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");
		$header_data= $this->add_javascript_to_html_header_data(
	        $header_data,
	        base_url('assets/js/jquery.gritter.min.js')); 
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$data['posible_duplicated_users']= $this->managment_model->get_posible_duplicated_users();

		$this->load->view('users.php',$data);
		
		
		$this->_load_body_footer();	

	}
	
	public function users_ldap($academic_period_id=null) {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#managment';
		$active_menu['submenu1']='#managment_users_ldap';

		$header_data = $this->load_ace_files($active_menu);

		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		$header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
		$header_data = $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery.gritter.css'));  

		//JS
		
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js'));

		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));

		$header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");
		$header_data= $this->add_javascript_to_html_header_data(
	        $header_data,
	        base_url('assets/js/jquery.gritter.min.js')); 
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$selected_academic_period_id = false;
        $current_academic_period_id = null;

        if ($academic_period_id == null) {
            $database_current_academic_period =  $this->managment_model->get_current_academic_period();
            
            if ($database_current_academic_period->id) {
                $current_academic_period_id = $database_current_academic_period->id;
            } else {
                $current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');  
            }
            
            $academic_period_id=$current_academic_period_id ;   
        } else {
            $selected_academic_period_id = $academic_period_id;
        }

        $academic_periods = $this->managment_model->get_all_academic_periods();

		$data['user_ldap_table_title'] = "Usuaris ldap";
		$data['academic_periods'] = $academic_periods;
        $data['selected_academic_period_id'] = $selected_academic_period_id;
        $data['academic_period_id'] = $academic_period_id;
		
		$this->load->view('users_ldap.php',$data);
		
		
		$this->_load_body_footer();	
		
	}

	

	

	public function sync_mysql_password_to_ldap () {


		$result = "No values especified!";
	    if(isset($_POST['values'])) {
        	$values = $_POST['values'];
	        $result = $this->managment_model->sync_mysql_password_to_ldap($values);
	    }
	    echo '{
	    "aaData": ';

	    print_r(json_encode($result));

	    echo '}';


	}

	public function interchange_windows_passwords () {


		$result = "No values especified!";
	    if(isset($_POST['values'])) {
        	$values = $_POST['values'];
	        $result = $this->managment_model->interchange_windows_passwords($values);
	    }
	    echo '{
	    "aaData": ';

	    print_r(json_encode($result));

	    echo '}';


	}

	public function avoid_change_of_password_on_windows () {


		$result = "No values especified!";
	    if(isset($_POST['values'])) {
        	$values = $_POST['values'];
	        $result = $this->managment_model->avoid_change_of_password_on_windows($values);
	    }
	    echo '{
	    "aaData": ';

	    print_r(json_encode($result));

	    echo '}';


	}



	public function sync_mysql_ldap () {


		$result = "No values especified!";
	    if(isset($_POST['values'])) {
        	$values = $_POST['values'];
	        $result = $this->managment_model->sync_mysql_ldap($values);
	    }
	    echo '{
	    "aaData": ';

	    print_r(json_encode($result));

	    echo '}';


	}	

	public function assign_multiple_ldap_roles () {


		$result = "No values especified!";
	    if(isset($_POST['values'])) {
        	$values = $_POST['values'];
	        $result = $this->managment_model->assign_multiple_ldap_roles($values);
	    }
	    echo '{
	    "aaData": ';

	    print_r(json_encode($result));

	    echo '}';


	}

		

	public function calculate_study_module () {


		$result = "No values especified!";
	    if(isset($_POST['values'])) {
        	$values = $_POST['values'];
	        $result = $this->managment_model->calculate_study_module($values);
	    }
	    echo '{
	    "aaData": ';

	    print_r(json_encode($result));

	    echo '}';


	}

	public function create_multiple_study_submodules_logse () {

		$result = "No values especified!";
	    if(isset($_POST['values'])) {
        	$values = $_POST['values'];
	        $result = $this->managment_model->create_multiple_study_submodules_logse($values);
	    }
	    echo '{
	    "aaData": ';

	    print_r(json_encode($result));

	    echo '}';


	}

	public function create_multiple_autoenrollments() {

		$result = "No values especified!";
	    if(isset($_POST['values'])) {
        	$values = $_POST['values'];
	        $result = $this->managment_model->create_multiple_autoenrollments($values);
	    }
	    echo '{
	    "aaData": ';

	    print_r(json_encode($result));

	    echo '}';


	}

	public function create_multiple_initial_passwords () {


		$result = "No values especified!";
	    if(isset($_POST['values'])) {
        	$values = $_POST['values'];
	        $result = $this->managment_model->create_multiple_initial_passwords($values);
	    }
	    echo '{
	    "aaData": ';

	    print_r(json_encode($result));

	    echo '}';


	}

	/*
		OBSOLET?
	*/
	public function lessons($lesson_code=null) {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/jquery-ui.css'));		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));		


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
			base_url("assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js"));			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));			
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
			base_url("assets/js/jquery.tooltipster.min.js"));		
        
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace.min.js'));   		


			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data['all_lessons']=null;

		$exists_assignatures_table=$this->config->item('exists_assignatures_table');		

		$data['exists_assignatures_table']=false;
		if ($exists_assignatures_table)		{
			$data['all_lessons']= $this->managment_model->getAllLessons(true)->result();
			$data['exists_assignatures_table']=true;			                
		}
		else
			$data['all_lessons']= $this->managment_model->getAllLessons()->result();
		
		$default_lesson_code = $this->config->item('default_group_code');
		if ($lesson_code==null) {
			$lesson_code=$default_lesson_code;
		}
		
		if (isset($lesson_code)) {
			$data['selected_lesson']= urldecode($lesson_code);
		}	else {
			$data['selected_lesson']=$default_lesson_code;
		}

		$this->load->view('managment/lessons',$data);
		
		$this->_load_body_footer();
	}

	public function users_in_group($group_code=null) {
		if (!$this->skeleton_auth->logged_in()){
		
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#reports';
		$active_menu['submenu1']='#curriculum_reports';
		$active_menu['submenu2']='#curriculum_reports_users_in_group';

        $data['title']=lang('reports_group_reports_class_list');

		$header_data = $this->load_ace_files($active_menu);

		$default_group_code = $this->config->item('default_group_code');
		$default_group_id = $this->config->item('default_group_id');
/*
		if ($group_code==null) {
			$group_code=$default_group_code;
		} else {
			$group_code = $_POST['grup'];
		}

        $data['group_code']=$group_code;
*/

/* THIS CODE HAS BEEN MOVED TO $this->set_header_data();		

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/jquery-ui.css'));		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));			
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js"));			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));			
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
			base_url("assets/js/jquery.tooltipster.min.js"));		
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();
*/

		//Load CSS & JS
		$this->set_header_data($header_data);		

		// Get All groups
        $grups = $this->managment_model->get_all_groups();
        $data['grups'] = $grups;

        $organization = $this->config->item('organization','skeleton_auth');

        $header_data['header_title']=lang("all_students") . ". " . $organization;

        //Load CSS & JS
        //$this->set_header_data();
        $test = $this->load->model("attendance/attendance_model");
        
        $all_groups = $this->attendance_model->get_all_classroom_groups();
        $data['all_groups']=$all_groups->result();
        
        if(isset($_POST['grup'])) {
            $data['selected_group']= urldecode($_POST['grup']);
        }   else {
            $data['selected_group']=$default_group_id;
        }


/*		
		$all_groups = $this->managment_model->get_all_classroom_groups();
		
		//$data['all_groups']=$all_groups->result();
		$data['all_groups']=$all_groups;
				
		if (isset($group_code)) {
			$data['selected_group']= urldecode($group_code);
		}	else {
			$data['selected_group']=$default_group_code;
		}
*/		
		$students_base_dn= $this->config->item('students_base_dn','skeleton_auth');
		$default_group_dn=$students_base_dn;
		/*
		if ($data['selected_group']!="ALL_GROUPS")
			$default_group_dn=$this->ebre_escool_ldap->getGroupDNByGroupCode($data['selected_group']);
		*/
		if ($data['selected_group']=="ALL_GROUPS")
			$data['selected_group_names']= array (lang("all_students_table_title"),"");
		else
			//echo $data['selected_group'];

			//$data['selected_group_names']= $this->managment_model->getGroupNamesByGroupCode($data['selected_group']);
		

		//$data['all_students_in_group']= $this->ebre_escool_ldap->getAllGroupStudentsInfo($default_group_dn);
		$data['all_students_in_group']= $this->attendance_model->getAllGroupStudentsInfo($data['selected_group']);

		$this->load->view('managment/users_in_group',$data);
		
		$this->_load_body_footer();	
	}
	
	public function massive_change_password($group_code=null) {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$default_group_code = $this->config->item('default_group_code');
		if ($group_code==null) {
			$group_code=$default_group_code;
		}

		$organization = $this->config->item('organization','skeleton_auth');

		$header_data['header_title']=lang("students_of_a_group") . ". " . $organization;

/* THIS CODE HAS BEEN MOVED TO $this->set_header_data();	

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/jquery-ui.css'));				
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));		
					
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js"));			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));	
			
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
			base_url("assets/js/jquery.tooltipster.min.js"));	
		
//		$organization = $this->config->item('organization','skeleton_auth');

//		$header_data['header_title']=lang("students_of_a_group") . ". " . $organization;
				
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();
*/

		//Load CSS & JS
		$this->set_header_data();

		$all_groups = $this->managment_model->get_all_classroom_groups();
		
		$data['all_groups']=$all_groups->result();
		
		if (isset($group_code)) {
			$data['selected_group']= urldecode($group_code);
		}	else {
			$data['selected_group']=$default_group_code;
		}
		
		$students_base_dn= $this->config->item('students_base_dn','skeleton_auth');
		$default_group_dn=$students_base_dn;
		if ($data['selected_group']!="ALL_GROUPS")
			$default_group_dn=$this->ebre_escool_ldap->getGroupDNByGroupCode($data['selected_group']);
		
		if ($data['selected_group']=="ALL_GROUPS")
			$data['selected_group_names']= array (lang("all_students_table_title"),"");
		else
			$data['selected_group_names']= $this->managment_model->getGroupNamesByGroupCode($data['selected_group']);
		
		$data['all_students_in_group']= $this->ebre_escool_ldap->getAllGroupStudentsInfo($default_group_dn);

		$this->load->view('managment/massive_change_password',$data);
		
		$this->_load_body_footer();	
	}
	
	public function index() {
		$this->massive_change_password();
	}

	public function curriculum_reports_studysubmodules($academic_period_id = null) {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#reports';
		$active_menu['submenu1']='#curriculum_reports';
		$active_menu['submenu2']='#curriculum_reports_studysubmodules';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		$header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");

		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$data['study_submodules_table_title'] = "Unitats formatives / Unitats didàctiques";
		$selected_academic_period_id = false;

		$current_academic_period_id = null;

		if ($academic_period_id == null) {
			$database_current_academic_period =  $this->managment_model->get_current_academic_period();
			
			if ($database_current_academic_period->id) {
				$current_academic_period_id = $database_current_academic_period->id;
			} else {
				$current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');	
			}
			
			$academic_period_id=$current_academic_period_id ;	
		} else {
			$selected_academic_period_id = $academic_period_id;
		}

		$academic_periods = $this->managment_model->get_all_academic_periods();	
		$all_study_submodules = $this->managment_model->get_all_study_submodules_report_info($academic_period_id);

		$data['all_study_submodules'] = $all_study_submodules;

		$data['academic_periods'] = $academic_periods;
		$data['selected_academic_period_id'] = $selected_academic_period_id;

		$this->load->view('curriculum_reports_studysubmodules.php',$data);
		
		
		$this->_load_body_footer();	
		
	}

	public function curriculum_reports_studymodules($academic_period_id = null) {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#reports';
		$active_menu['submenu1']='#curriculum_reports';
		$active_menu['submenu2']='#curriculum_reports_studymodules';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		$header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");

			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$data['study_modules_table_title'] = "Mòduls professionals / Crèdits";
		$selected_academic_period_id = false;

		$current_academic_period_id = null;

		if ($academic_period_id == null) {
			$database_current_academic_period =  $this->managment_model->get_current_academic_period();
			
			if ($database_current_academic_period->id) {
				$current_academic_period_id = $database_current_academic_period->id;
			} else {
				$current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');	
			}
			
			$academic_period_id=$current_academic_period_id ;	
		} else {
			$selected_academic_period_id = $academic_period_id;
		}

		$academic_periods = $this->managment_model->get_all_academic_periods();	
		$all_studymodules = $this->managment_model->get_all_studymodules_report_info($academic_period_id);


		$data['all_studymodules'] = $all_studymodules;
		$data['academic_periods'] = $academic_periods;
		$data['selected_academic_period_id'] = $selected_academic_period_id;

		$this->load->view('curriculum_reports_studymodules.php',$data);
		
		$this->_load_body_footer();	
		
	}

	public function curriculum_reports_studymodules_admin($academic_period_id = null) {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#reports';
		$active_menu['submenu1']='#curriculum_reports';
		$active_menu['submenu2']='#curriculum_reports_studymodules_admin';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		$header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");

			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$data['study_modules_table_title'] = "Mòduls professionals / Crèdits";
		$selected_academic_period_id = false;

		$current_academic_period_id = null;

		if ($academic_period_id == null) {
			$database_current_academic_period =  $this->managment_model->get_current_academic_period();
			
			if ($database_current_academic_period->id) {
				$current_academic_period_id = $database_current_academic_period->id;
			} else {
				$current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');	
			}
			
			$academic_period_id=$current_academic_period_id ;	
		} else {
			$selected_academic_period_id = $academic_period_id;
		}

		$academic_periods = $this->managment_model->get_all_academic_periods();	
		$all_studymodules = $this->managment_model->get_all_studymodules_report_info($academic_period_id);


		$data['all_studymodules'] = $all_studymodules;
		$data['academic_periods'] = $academic_periods;
		$data['selected_academic_period_id'] = $selected_academic_period_id;

		$this->load->view('curriculum_reports_studymodules_admin.php',$data);
		
		$this->_load_body_footer();	
		
	}

	public function curriculum_reports_classgroup($academic_period_id = null) {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#reports';
		$active_menu['submenu1']='#curriculum_reports';
		$active_menu['submenu2']='#curriculum_reports_classgroup';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));
		$header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
                    		
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");

		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$data['classgroup_table_title'] = "Grups de classe";
		$selected_academic_period_id = false;
		

		$current_academic_period_id = null;

		if ($academic_period_id == null) {
			$database_current_academic_period =  $this->managment_model->get_current_academic_period();
			
			if ($database_current_academic_period->id) {
				$current_academic_period_id = $database_current_academic_period->id;
			} else {
				$current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');	
			}
			
			$academic_period_id=$current_academic_period_id ;	
		} else {
			$selected_academic_period_id = $academic_period_id;
		}

		$academic_periods = $this->managment_model->get_all_academic_periods();		
		$all_classgroups = $this->managment_model->get_all_classgroups_report_info($academic_period_id);

		$data['all_classgroups'] = $all_classgroups;
		$data['academic_periods'] = $academic_periods;
		$data['selected_academic_period_id'] = $selected_academic_period_id;

		$this->load->view('curriculum_reports_classgroups.php',$data);
		
		$this->_load_body_footer();	
		
	}

	public function curriculum_reports_course() {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#reports';
		$active_menu['submenu1']='#curriculum_reports';
		$active_menu['submenu2']='#curriculum_reports_course';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$data['courses_table_title'] = "Cursos";

		$all_courses = $this->managment_model->get_all_courses_report_info();
		
		//$studies_by_studymodule = $this->managment_model->get_studies_by_department(false);
		//$teachers_by_department = $this->managment_model->get_teachers_by_department(false);

		$data['all_courses'] = $all_courses;
		
		//$data['studies_by_department'] = $studies_by_department;
		//$data['teachers_by_department'] = $teachers_by_department;

		$this->load->view('curriculum_reports_courses.php',$data);
		
		$this->_load_body_footer();	
		
	}

	public function curriculum_reports_cicle() {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#reports';
		$active_menu['submenu1']='#curriculum_reports';
		$active_menu['submenu2']='#curriculum_reports_departments';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$data['departments_table_title'] = "Departaments";

		$all_departments = $this->managment_model->get_all_departments_report_info();
		$studies_by_department = $this->managment_model->get_studies_by_department(false);
		$teachers_by_department = $this->managment_model->get_teachers_by_department(false);

		/*
		$all_departments = array();

		$department1 = new stdClass;

		$department1->shortname = "Elèctrics";
		$department1->name = "Departament d'electrics";
		$department1->head = "Richard Stallman";
		$department1->location = "Aula 45";
		$department1->numberOfTeachers = 7;
		$department1->numberOfStudies = 2;

		$department2 = new stdClass;

		$department2->shortname = "Informàtica";
		$department2->name = "Departament d'informàtica";
		$department2->head = "Linus Torvalds";
		$department2->location = "Espai";
		$department2->numberOfTeachers = 6;
		$department2->numberOfStudies = 3;

		$all_departments[] = $department1;
		$all_departments[] = $department2;
		*/

		$data['all_departments'] = $all_departments;
		$data['studies_by_department'] = $studies_by_department;
		$data['teachers_by_department'] = $teachers_by_department;

		$this->load->view('curriculum_reports_departments.php',$data);
		
		$this->_load_body_footer();	
		
	}

	public function curriculum_reports_study() {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#reports';
		$active_menu['submenu1']='#curriculum_reports';
		$active_menu['submenu2']='#curriculum_reports_study';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$data['studies_table_title'] = "Estudis";

		$all_studies = $this->managment_model->get_all_studies_report_info();

		$data['all_studies'] = $all_studies;

		$this->load->view('curriculum_reports_study.php',$data);
		
		$this->_load_body_footer();	
		
	}

	public function curriculum_reports_departments() {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#reports';
		$active_menu['submenu1']='#curriculum_reports';
		$active_menu['submenu2']='#curriculum_reports_departments';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$data['departments_table_title'] = "Departaments";

		$all_departments = $this->managment_model->get_all_departments_report_info();

		$studies_by_department = $this->managment_model->get_studies_by_department(false);
		$teachers_by_department = $this->managment_model->get_teachers_by_department(false);

		/*
		$all_departments = array();

		$department1 = new stdClass;

		$department1->shortname = "Elèctrics";
		$department1->name = "Departament d'electrics";
		$department1->head = "Richard Stallman";
		$department1->location = "Aula 45";
		$department1->numberOfTeachers = 7;
		$department1->numberOfStudies = 2;

		$department2 = new stdClass;

		$department2->shortname = "Informàtica";
		$department2->name = "Departament d'informàtica";
		$department2->head = "Linus Torvalds";
		$department2->location = "Espai";
		$department2->numberOfTeachers = 6;
		$department2->numberOfStudies = 3;

		$all_departments[] = $department1;
		$all_departments[] = $department2;
		*/

		$data['all_departments'] = $all_departments;
		$data['studies_by_department'] = $studies_by_department;
		$data['teachers_by_department'] = $teachers_by_department;

		$this->load->view('curriculum_reports_departments.php',$data);
		
		$this->_load_body_footer();	
		
	}
	
	public function statistics_checkings_groups() {
		
		$skeleton_admin_group = $this->config->item('skeleton_admin_group','skeleton_auth');
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#reports';
		$active_menu['submenu1']='#curriculum_reports';
		$active_menu['submenu2']='#curriculum_reports_statistics_checkings_groups';


		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();
		
		$data['all_groups_table_title']=lang("all_groups");
		
		$all_groups = $this->managment_model->get_all_classroom_groups();

		$data['all_groups']=array();
		
		if ($all_groups) {
			$data['all_groups']=$all_groups;
		}
		else {
			$this->load->view('managment/statistics_checkings_groups.php',$data);		
			$this->_load_body_footer();	
			return;
		}
		
		$students_base_dn= $this->config->item('students_base_dn','skeleton_auth');

		/* LDAP */
		/*
		$all_groups_dns= $this->ebre_escool_ldap->getAllGroupsDNs($students_base_dn);

		$all_groups_totals= array();
		foreach ($all_groups_dns as $groupdn) {
			if ($groupdn != ""){
				$group_total = $this->ebre_escool_ldap->getGroupTotals($groupdn);
				$all_groups_totals += array( $groupdn => $group_total);
			}
		}
		*/

		/* MYSQL */
		$all_groups_totals_sql = array();		
		foreach($all_groups as $key => $value){
			$all_students_in_group = $this->managment_model->getAllGroupStudentsInfo($key);
			$count_alumnes = count($all_students_in_group);
			$all_groups_totals_sql[$key] = $count_alumnes;
		}

		$data['all_groups_totals_sql'] = $all_groups_totals_sql;

		$teachers_base_dn= $this->config->item('teachers_base_dn','skeleton_auth');                     		                

		/* LDAP */
		/*
		$all_teachers= $this->ebre_escool_ldap->getAllTeachers($teachers_base_dn);
		*/

		/* MYSQL */
		$all_teachers_sql = $this->managment_model->get_all_teachers();
		$data['all_teachers_sql'] = $all_teachers_sql;


/*
		foreach ($data['all_groups'] as $group_key => $group) {

			$personname="";
			if (array_key_exists($group->group_mentorId,$all_teachers))	{
				$personname=$all_teachers[$group->group_mentorId];
			}		
			$group->mentor_name=$personname;
			
			$group_dn="";
			if (array_key_exists($group->group_code,$all_groups_dns))	{
				$group_dn=$all_groups_dns[$group->group_code];
			}
			$group->ldap_dn=$group_dn;
			
			$group_total=0;
			if (array_key_exists($group_dn,$all_groups_totals))	{
				$group_total=$all_groups_totals[$group_dn];
			}
			$group->total_students=$group_total;
		}
*/
		
		$this->load->view('statistics_checkings_groups.php',$data);
		
		$this->_load_body_footer();	
	}





	public function enrollment_reports_by_studies() {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#reports';
		$active_menu['submenu1']='#enrollment_reports';
		$active_menu['submenu2']='#enrollment_reports_by_studies';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$all_studies = $this->managment_model->get_all_studies_report_info();

		$data['enrollment_reports_by_studies_table_title'] = "Dades estudis / matrícula";

		$data['all_studies'] = $all_studies;

		$this->load->view('enrollment_reports_by_studies.php',$data);
		
		$this->_load_body_footer();

	}

	public function enrollment_reports_all_enrolled_persons_by_academic_period($academic_period_id=null) {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#reports';
		$active_menu['submenu1']='#enrollment_reports';
		$active_menu['submenu2']='#enrollment_reports_all_enrolled_persons_by_academic_period';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		$header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");
			

			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$selected_academic_period_id = false;
        $current_academic_period_id = null;

        if ($academic_period_id == null) {
            $database_current_academic_period =  $this->managment_model->get_current_academic_period();
            
            if ($database_current_academic_period->id) {
                $current_academic_period_id = $database_current_academic_period->id;
            } else {
                $current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');  
            }
            
            $academic_period_id=$current_academic_period_id ;   
        } else {
            $selected_academic_period_id = $academic_period_id;
        }

        $academic_periods = $this->managment_model->get_all_academic_periods();

		$data['enrollment_reports_all_enrolled_persons_by_academic_period_title'] = "Matrículats per període acadèmic";

		$data['all_enrollments'] = $this->managment_model->get_enrollment_reports_all_enrolled_persons_by_academic_period($academic_period_id);
		$data['academic_periods'] = $academic_periods;
        $data['selected_academic_period_id'] = $selected_academic_period_id;
        $data['academic_period_id'] = $academic_period_id;

		$this->load->view('enrollment_reports_all_enrolled_persons_by_academic_period.php',$data);
		
		$this->_load_body_footer();	
	
	}

	public function enrollment_reports_by_academic_period() {

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		$active_menu = array();
		$active_menu['menu']='#reports';
		$active_menu['submenu1']='#enrollment_reports';
		$active_menu['submenu2']='#enrollment_reports_by_academic_period';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();

		$data = array();

		$data['enrollment_reports_by_academic_period_title'] = "Total matrículats per període acadèmic";

		$data['academic_periods'] = $this->managment_model->get_all_enrollment_academic_periods();;

		$this->load->view('enrollment_reports_by_academic_period.php',$data);
		
		$this->_load_body_footer();	
		
	}






	
	public function statistics_checkings() {
		$this->statistics_checkings_groups();
	}

/* Menú Manteniment -> Pla Estudis */

	public function course() {

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

		/* Grocery Crud */
		$this->current_table="course";
        $this->grocery_crud->set_table($this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('course'));       

        //Relació de Taules
        $this->grocery_crud->set_relation('course_cycle_id','cycle','cycle_shortname'); 
		$this->grocery_crud->set_relation('course_estudies_id','studies','studies_shortname');        

	    //Param 1: The name of the field that we have the relation in the basic table (course_cycle_id)
    	//Param 2: The relation table (cycle)
    	//Param 3: The 'title' field that we want to use to recognize the relation (cycle_shortname)

		//Mandatory fields
        $this->grocery_crud->required_fields('course_name','course_shortname','course_markedForDeletion');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('course_entryDate',array($this,'add_field_callback_course_entryDate'));
        $this->grocery_crud->callback_edit_field('course_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('course_last_update',array($this,'edit_field_callback_lastupdate'));

        //Express fields
        $this->grocery_crud->express_fields('course_name','course_shortname');
        //$this->grocery_crud->express_fields('course_name','course_shortname','parentLocation');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('course_shortname',lang('shortName'));
        $this->grocery_crud->display_as('course_name',lang('name'));
        $this->grocery_crud->display_as('course_number',lang('course_number'));
        $this->grocery_crud->display_as('course_cycle_id',lang('course_cycle_id')); 
        $this->grocery_crud->display_as('course_estudies_id',lang('course_estudies_id'));
        $this->grocery_crud->display_as('course_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('course_last_update',lang('last_update'));
        $this->grocery_crud->display_as('course_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('course_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('course_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('course_markedForDeletionDate',lang('markedForDeletionDate'));              

/*       
        //Relacions entre taules
        $this->grocery_crud->set_relation('parentLocation','location','{name}',array('markedForDeletion' => 'n'));
*/        
         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('course_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('course_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'course_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('course_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'course_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("course_creationUserId","course_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'course_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="course_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('managment/course.php',$output);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

/* GRUP */

	public function classroom_group() {

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

		/* Grocery Crud */
		$this->current_table="classroom_group";
        $this->grocery_crud->set_table($this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('classroom_group'));       

		//Mandatory fields
        $this->grocery_crud->required_fields('group_name','group_shortname','group_markedForDeletion');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('group_entryDate',array($this,'add_field_callback_course_entryDate'));
        $this->grocery_crud->callback_edit_field('group_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('group_lastupdate',array($this,'edit_callback_last_update'));

        //Express fields
        $this->grocery_crud->express_fields('group_name','group_shortname');
        //$this->grocery_crud->express_fields('course_name','course_shortname','parentLocation');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_shortname',lang('shortName'));
        $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
        $this->grocery_crud->display_as($this->current_table.'_number',lang($this->current_table.'_number'));


        $this->grocery_crud->display_as($this->current_table.'_shortName',lang('shortName'));
        $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
        $this->grocery_crud->display_as($this->current_table.'_code',lang($this->current_table.'_code'));  
        $this->grocery_crud->display_as($this->current_table.'_lastupdate',lang('last_update'));        
        $this->grocery_crud->display_as($this->current_table.'_creationUserId',lang('creationUserId'));	
        $this->grocery_crud->display_as($this->current_table.'_lastupdateUserId',lang('lastupdateUserId')); 
		$this->grocery_crud->display_as($this->current_table.'_entryDate',lang('entryDate'));   
		$this->grocery_crud->display_as($this->current_table.'_course_id',lang('course')); 
        $this->grocery_crud->display_as($this->current_table.'_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as($this->current_table.'_markedForDeletionDate',lang('markedForDeletionDate'));		

//      RELACIONS
        $this->grocery_crud->set_relation('group_course_id','course','course_shortname'); 
/*		$this->grocery_crud->set_relation('course_estudies_id','studies','studies_shortname');        
        $this->grocery_crud->set_relation('parentLocation','location','{name}',array('markedForDeletion' => 'n'));
	    Param 1: The name of the field that we have the relation in the basic table (course_cycle_id)
    	Param 2: The relation table (cycle)
    	Param 3: The 'title' field that we want to use to recognize the relation (cycle_shortname)        
*/        
         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('group_lastupdate');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('group_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'group_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        //$this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'group_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("group_creationUserId","group_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'group_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="group_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('managment/classroom_group.php',$output);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

/* FI GRUP */

	public function study_submodule_dates($study_module_id = null , $academic_period_id = null) {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}

		$user_is_admin = $this->ebre_escool->user_is_admin();
		$user_is_teacher = $this->session->userdata('is_teacher');

		if ( !($user_is_admin || $user_is_teacher) ) {
			echo "Access not allowed!";
		}

		$selected_academic_period_id = false;

		$current_academic_period_id = null;

		if ($academic_period_id == null) {
			$database_current_academic_period =  $this->managment_model->get_current_academic_period();
			
			if ($database_current_academic_period->id) {
				$current_academic_period_id = $database_current_academic_period->id;
			} else {
				$current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');	
			}
			
			$academic_period_id=$current_academic_period_id ;	
		} else {
			$selected_academic_period_id = $academic_period_id;
		}

		$active_menu = array();
		$active_menu['menu']='#maintenances_teachers';
		$active_menu['submenu1']='#maintenances_teachers_curriculum';
		$active_menu['submenu2']='#maintenances_teachers_curriculum_study_submodule_dates';

		$header_data = $this->load_ace_files($active_menu);

		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));	
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			"http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");					
			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));	
			
		$this->_load_html_header($header_data); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
	   $data = array();

	   $academic_periods = $this->managment_model->get_all_academic_periods();	

		$data['academic_periods'] = $academic_periods;

		$data['selected_academic_period_id'] = $selected_academic_period_id;

		$dates = $this->managment_model->get_academic_period_dates($academic_period_id);
		
		$data['selected_academic_period_initial_date'] = $dates->initial_date;
		$data['selected_academic_period_final_date'] = $dates->final_date;
		$data['selected_academic_period_initial_date_planned'] = $dates->initial_date;
		$data['selected_academic_period_final_date_planned'] = $dates->final_date;
		
	   $this->load->view('managment/study_submodule_dates.php',$data);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	

	}

	
	

/* ASSIGNATURA */

	public function study_module() {

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

		/* Grocery Crud */
		$this->current_table="study_module";
        $this->grocery_crud->set_table($this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('study_module'));       

		//Mandatory fields
        $this->grocery_crud->required_fields('study_module_name','study_module_shortname','study_module_markedForDeletion');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('study_module_entryDate',array($this,'add_field_callback_study_module_entryDate'));
        $this->grocery_crud->callback_edit_field('study_module_entryDate',array($this,'edit_field_callback_study_module_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('study_module_last_update',array($this,'edit_field_callback_lastupdate'));

        //Express fields
        $this->grocery_crud->express_fields('study_module_name','study_module_shortname');
        //$this->grocery_crud->express_fields('course_name','course_shortname','parentLocation');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('study_module_shortname',lang('shortName'));
		$this->grocery_crud->display_as('study_module_name',lang('name'));
        $this->grocery_crud->display_as('study_module_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('study_module_last_update',lang('last_update'));
        $this->grocery_crud->display_as('study_module_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('study_module_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('study_module_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('study_module_markedForDeletionDate',lang('markedForDeletionDate'));        		
		$this->grocery_crud->display_as('study_module_hoursPerWeek',lang('study_module_hoursPerWeek'));
        
        $this->grocery_crud->display_as('study_module_initialDate',lang('study_module_initialDate'));
        $this->grocery_crud->display_as('study_module_endDate',lang('study_module_endDate'));          
        $this->grocery_crud->display_as('study_module_type',lang('type'));   
        $this->grocery_crud->display_as('study_module_subtype',lang('subtype'));        

        //RELACIONS
        
/*
	    Param 1: The name of the field that we have the relation in the basic table (course_cycle_id)
    	Param 2: The relation table (cycle)
    	Param 3: The 'title' field that we want to use to recognize the relation (cycle_shortname)        
*/        
         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('study_module_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('study_module_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'study_module_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        //$this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'study_module_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("study_module_creationUserId","study_module_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'study_module_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="study_module_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('managment/study_module.php',$output);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

/* FI ASSIGNATURA */

/* UNITATS FORMATIVES */

	public function study_submodules() {

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

		/* Grocery Crud */
		$this->current_table="study_submodules";
        $this->grocery_crud->set_table($this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('study_submodules'));       

		//Mandatory fields
        $this->grocery_crud->required_fields('study_submodules_name','study_submodules_shortname','study_submodules_markedForDeletion');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('study_submodules_entryDate',array($this,'add_field_callback_study_submodules_entryDate'));
        $this->grocery_crud->callback_edit_field('study_submodules_entryDate',array($this,'edit_field_callback_study_submodules_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('study_submodules_last_update',array($this,'edit_field_callback_lastupdate'));

        //Express fields
        $this->grocery_crud->express_fields('study_submodules_name','study_submodules_shortname');
        //$this->grocery_crud->express_fields('course_name','course_shortname','parentLocation');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('study_submodules_shortname',lang('shortName'));
		$this->grocery_crud->display_as('study_submodules_name',lang('name'));
        $this->grocery_crud->display_as('study_submodules_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('study_submodules_last_update',lang('last_update'));
        $this->grocery_crud->display_as('study_submodules_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('study_submodules_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('study_submodules_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('study_submodules_markedForDeletionDate',lang('markedForDeletionDate'));        		

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('study_submodules_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('study_submodules_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'study_submodules_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        //$this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'study_submodules_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("study_submodules_creationUserId","study_submodules_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//      $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'study_submodules_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="study_submodules_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('managment/study_submodules.php',$output);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

/* FI UNITATS FORMATIVES */

/* ENROLLMENT */

	public function enrollment() {

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

		/* Grocery Crud */
		$this->current_table="enrollment";
        $this->grocery_crud->set_table($this->current_table);
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment'));       

		//Mandatory fields
        

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('enrollment_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('enrollment_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('enrollment_last_update',array($this,'edit_callback_last_update'));

        //Express fields
        

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //SPECIFIC COLUMNS

        $this->grocery_crud->display_as('enrollment_periodid',lang('enrollment_periodid'));        
        $this->grocery_crud->display_as('enrollment_personid',lang('enrollment_personid'));

        $this->grocery_crud->display_as('enrollment_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('enrollment_last_update',lang('last_update'));
        $this->grocery_crud->display_as('enrollment_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('enrollment_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('enrollment_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('enrollment_markedForDeletionDate',lang('markedForDeletionDate'));        		

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('enrollment_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('enrollment_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('enrollment_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("enrollment_creationUserId","study_submodules_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//      $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="enrollment_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('managment/enrollment.php',$output);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

/* FI ENROLLMENT */

/* ENROLLMENT STUDIES */

	public function enrollment_studies() {

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

		/* Grocery Crud */
		$this->current_table="enrollment_studies";
        $this->grocery_crud->set_table($this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment_studies'));       

		//Mandatory fields
        

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('enrollment_studies_entryDate',array($this,'add_field_callback_enrollment_studies_entryDate'));
        $this->grocery_crud->callback_edit_field('enrollment_studies_entryDate',array($this,'edit_field_callback_enrollment_studies_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('enrollment_studies_last_update',array($this,'edit_field_callback_lastupdate'));

        //Express fields
        

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('enrollment_studies_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('enrollment_studies_last_update',lang('last_update'));
        $this->grocery_crud->display_as('enrollment_studies_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('enrollment_studies_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('enrollment_studies_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('enrollment_studies_markedForDeletionDate',lang('markedForDeletionDate'));        		

        $this->grocery_crud->display_as('enrollment_studies_periodid',lang('enrollment_studies_periodid'));          
        $this->grocery_crud->display_as('enrollment_studies_personid',lang('enrollment_studies_personid'));   
        $this->grocery_crud->display_as('enrollment_studies_study_id',lang('enrollment_studies_study_id'));        		

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('enrollment_studies_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('enrollment_studies_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_studies_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        //$this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_studies_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("enrollment_studies_creationUserId","study_submodules_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//      $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_studies_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="enrollment_studies_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('managment/enrollment_studies.php',$output);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

/* FI ENROLLMENT STUDIES */

/* ENROLLMENT CLASS GROUP */

	public function enrollment_class_group() {

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

		/* Grocery Crud */
		$this->current_table="enrollment_class_group";
        $this->grocery_crud->set_table($this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment_class_group'));       

		//Mandatory fields
        

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('enrollment_class_group_entryDate',array($this,'add_field_callback_enrollment_class_group_entryDate'));
        $this->grocery_crud->callback_edit_field('enrollment_class_group_entryDate',array($this,'edit_field_callback_enrollment_class_group_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('enrollment_class_group_last_update',array($this,'edit_field_callback_lastupdate'));

        //Express fields
        

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('enrollment_class_group_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('enrollment_class_group_last_update',lang('last_update'));
        $this->grocery_crud->display_as('enrollment_class_group_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('enrollment_class_group_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('enrollment_class_group_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('enrollment_class_group_markedForDeletionDate',lang('markedForDeletionDate'));        		

        $this->grocery_crud->display_as('enrollment_class_group_periodid',lang('enrollment_class_group_periodid'));
        $this->grocery_crud->display_as('enrollment_class_group_personid',lang('enrollment_class_group_personid'));          
        $this->grocery_crud->display_as('enrollment_class_group_study_id',lang('enrollment_class_group_study_id'));   
        $this->grocery_crud->display_as('enrollment_class_group_group_id',lang('enrollment_class_group_group_id'));        		

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('enrollment_class_group_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('enrollment_class_group_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_class_group_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        //$this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_class_group_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("enrollment_class_group_creationUserId","study_submodules_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//      $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_class_group_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="enrollment_class_group_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('managment/enrollment_class_group.php',$output);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

/* FI ENROLLMENT CLASS GROUP */

/* ENROLLMENT MODULES */

	public function enrollment_modules() {

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

		/* Grocery Crud */
		$this->current_table="enrollment_modules";
        $this->grocery_crud->set_table($this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment_modules'));       

		//Mandatory fields
        

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('enrollment_modules_entryDate',array($this,'add_field_callback_enrollment_modules_entryDate'));
        $this->grocery_crud->callback_edit_field('enrollment_modules_entryDate',array($this,'edit_field_callback_enrollment_modules_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('enrollment_modules_last_update',array($this,'edit_field_callback_lastupdate'));

        //Express fields
        

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('enrollment_modules_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('enrollment_modules_last_update',lang('last_update'));
        $this->grocery_crud->display_as('enrollment_modules_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('enrollment_modules_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('enrollment_modules_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('enrollment_modules_markedForDeletionDate',lang('markedForDeletionDate'));        		

        $this->grocery_crud->display_as('enrollment_modules_periodid',lang('enrollment_modules_periodid'));
        $this->grocery_crud->display_as('enrollment_modules_personid',lang('enrollment_modules_personid'));
        $this->grocery_crud->display_as('enrollment_modules_study_id',lang('enrollment_modules_study_id'));          
        $this->grocery_crud->display_as('enrollment_modules_group_id',lang('enrollment_modules_group_id'));   
        $this->grocery_crud->display_as('enrollment_modules_moduleid',lang('enrollment_modules_moduleid'));        		

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('enrollment_modules_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('enrollment_modules_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_modules_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        //$this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_modules_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("enrollment_modules_creationUserId","study_submodules_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//      $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_modules_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="enrollment_modules_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('managment/enrollment_modules.php',$output);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

/* FI ENROLLMENT MODULES */

/* ENROLLMENT SUBMODULES */

	public function enrollment_submodules() {

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

		/* Grocery Crud */
		$this->current_table="enrollment_submodules";
        $this->grocery_crud->set_table($this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment_submodules'));       

		//Mandatory fields
        

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('enrollment_submodules_entryDate',array($this,'add_field_callback_enrollment_submodules_entryDate'));
        $this->grocery_crud->callback_edit_field('enrollment_submodules_entryDate',array($this,'edit_field_callback_enrollment_submodules_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('enrollment_submodules_last_update',array($this,'edit_field_callback_lastupdate'));

        //Express fields
        

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('enrollment_submodules_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('enrollment_submodules_last_update',lang('last_update'));
        $this->grocery_crud->display_as('enrollment_submodules_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('enrollment_submodules_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('enrollment_submodules_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('enrollment_submodules_markedForDeletionDate',lang('markedForDeletionDate'));        		

        $this->grocery_crud->display_as('enrollment_submodules_periodid',lang('enrollment_submodules_periodid'));
        $this->grocery_crud->display_as('enrollment_submodules_personid',lang('enrollment_submodules_personid'));
        $this->grocery_crud->display_as('enrollment_submodules_study_id',lang('enrollment_submodules_study_id'));          
        $this->grocery_crud->display_as('enrollment_submodules_group_id',lang('enrollment_submodules_group_id'));   
        $this->grocery_crud->display_as('enrollment_submodules_moduleid',lang('enrollment_submodules_moduleid'));        		
		$this->grocery_crud->display_as('enrollment_submodules_submoduleid',lang('enrollment_submodules_submoduleid'));        		

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('enrollment_submodules_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('enrollment_submodules_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_submodules_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        //$this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_submodules_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("enrollment_submodules_creationUserId","study_submodules_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//      $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'enrollment_submodules_markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="enrollment_submodules_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('managment/enrollment_submodules.php',$output);     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

/* FI ENROLLMENT SUBMODULES */


	public function studies() {
		/* Grocery Crud */
		$this->current_table="studies";
        $this->grocery_crud->set_table($this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('studies'));          

		//Mandatory fields
        $this->grocery_crud->required_fields('studies_name','studies_shortname','studies_markedForDeletion');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('studies_entryDate',array($this,'add_field_callback_studies_entryDate'));
        $this->grocery_crud->callback_edit_field('studies_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('studies_last_update',array($this,'edit_field_callback_lastupdate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('studies_last_update',array($this,'edit_field_callback_lastupdate'));

        //Express fields
        $this->grocery_crud->express_fields('studies_name','studies_shortname');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

         //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('studies_shortname',lang('shortName'));
        $this->grocery_crud->display_as('studies_name',lang('name'));
        $this->grocery_crud->display_as('studies_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('studies_last_update',lang('last_update'));
        $this->grocery_crud->display_as('studies_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('studies_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('studies_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('studies_markedForDeletionDate',lang('markedForDeletionDate')); 

         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('studies_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('studies_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'studies_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('studies_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'studies_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("studies_creationUserId","studies_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'studies_markedForDeletion','n');

        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();

		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="studies_";
		$this->load->view('defaultvalues_view.php',$default_values); 
	   
               $this->load->view('managment/studies.php');     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

	public function cycle() {
		/* Grocery Crud */
		$this->current_table="cycle";
        $this->grocery_crud->set_table($this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('cycles'));          

		//Mandatory fields
        $this->grocery_crud->required_fields('cycle_name','cycle_shortname','cycle_markedForDeletion');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('cycle_entryDate',array($this,'add_field_callback_cycle_entryDate'));
        $this->grocery_crud->callback_edit_field('cycle_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('cycle_last_update',array($this,'edit_field_callback_lastupdate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('cycle_last_update',array($this,'edit_field_callback_lastupdate'));

        //Express fields
        $this->grocery_crud->express_fields('cycle_name','cycle_shortname');
        
        //COMMON_COLUMNS               
        $this->set_common_columns_name();

         //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('cycle_shortname',lang('shortName'));
        $this->grocery_crud->display_as('cycle_name',lang('name'));
        $this->grocery_crud->display_as('cycle_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('cycle_last_update',lang('last_update'));
        $this->grocery_crud->display_as('cycle_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('cycle_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('cycle_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('cycle_markedForDeletionDate',lang('markedForDeletionDate')); 

         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('cycle_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('cycle_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'cycle_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('cycle_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'cycle_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("cycle_creationUserId","cycle_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'cycle_markedForDeletion','n');

        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header(); 

		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="cycle_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('managment/cycle.php');     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}			

	public function studies_organizational_unit() {
		/* Grocery Crud */
		$this->current_table="studies_organizational_unit";
        $this->grocery_crud->set_table($this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('organizational_unit'));          

		//Mandatory fields
        $this->grocery_crud->required_fields('studiesOU_name','studiesOU_shortname','studiesOU_markedForDeletion');

        //CALLBACKS        
        $this->grocery_crud->callback_add_field('studiesOU_entryDate',array($this,'add_field_callback_studiesOU_entryDate'));
        $this->grocery_crud->callback_edit_field('studiesOU_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('studiesOU_last_update',array($this,'edit_field_callback_lastupdate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('studiesOU_last_update',array($this,'edit_field_callback_lastupdate'));

        //Express fields
        $this->grocery_crud->express_fields('studiesOU_name','studiesOU_shortname');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

         //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('studiesOU_shortname',lang('shortName'));
        $this->grocery_crud->display_as('studiesOU_name',lang('name'));
        $this->grocery_crud->display_as('studiesOU_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('studiesOU_last_update',lang('last_update'));
        $this->grocery_crud->display_as('studiesOU_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('studiesOU_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('studiesOU_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('studiesOU_markedForDeletionDate',lang('markedForDeletionDate')); 
 
         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('studiesOU_last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('studiesOU_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'studiesOU_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('studiesOU_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'studiesOU_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("studiesOU_creationUserId","studiesOU_lastupdateUserId");
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
//        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'studiesOU_markedForDeletion','n');

        $output = $this->grocery_crud->render();

       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();

		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]="studiesOU_";
		$this->load->view('defaultvalues_view.php',$default_values); 

        $this->load->view('managment/studies_organizational_unit.php');     
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	
	}

	private function set_header_data($header_data = false) {

		if($header_data==false){

			$header_data= $this->add_css_to_html_header_data(
				$this->_get_html_header_data(),
				base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));	
		} else {
			$header_data= $this->add_css_to_html_header_data(
				$header_data,
				base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));				
		}
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/jquery-ui.css'));		
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));	
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			base_url('assets/css/tooltipster.css'));			
		//JS
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js"));			
		$header_data= $this->add_javascript_to_html_header_data(
			$header_data,
			base_url("assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js"));			
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
			base_url("assets/js/jquery.tooltipster.min.js"));		
		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ebre-escool.js'));
			
		$this->_load_html_header($header_data); 
		
		$this->_load_body_header();		

	}

  public function load_ace_files($active_menu=false) {
        $header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
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

        if($active_menu!=false){
            $header_data['menu']= $active_menu;
        }
        return $header_data;

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
 // PROVA Executar funcions d'altres mòduls
	public function va(){
		echo "Estic a Managments<br />";
		$params = "Això són paràmetres";
		echo Modules::run('attendance/test', $params);
		//$this->load->module('attendance');
		//$this->attendance->test($params);

	}

}
