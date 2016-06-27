<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class reports extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php';
	//public $html_header_view ='/include/ebre_escool_html_header.php';

	public $body_header_lang_file ='ebre_escool_body_header' ;

	public $html_header_view ='include/ebre_escool_html_header' ;
	public $body_footer_view ='include/ebre_escool_body_footer' ;


	function __construct()
    {
        parent::__construct();
        
        $this->load->library('ebre_escool_ldap');

        $this->load->library('ebre_escool');
        
        // Load FPDF        
        $this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
        $params = array ('orientation' => 'P', 'unit' => 'mm', 'size' => 'A4', 'font_path' => 'font/');        
        $this->load->library('pdf',$params); // Load library

        /* Set language */
        $current_language=$this->session->userdata("current_language");
        if ($current_language == "") {
            $current_language= $this->config->item('default_language');
        }
        
        // Load the language file
        $this->lang->load('reports',$current_language);
        $this->load->helper('language');
        
	}

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

        $header_data = $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery.gritter.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/daterangepicker.css'));

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
			"http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js");

        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.min.js'));
         $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/dataTables.colReorder.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/dataTables.colVis.js'));


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
                    base_url('assets/js/jquery.gritter.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/date-time/moment.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/date-time/daterangepicker.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/date-time/locales/bootstrap-datepicker.ca.js'));

		$header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ebre-escool.js'));


		$header_data['menu']= $active_menu;
		return $header_data; 
        
    }

	function check_logged_user() {
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

	function get_class_list($classroom_group_id=null, $academic_period=null, $checkbox_show_all_group_enrolled_students=null,
                            $checkbox_show_all_students=null, $checkbox_show_hide_students=null, $teacher_id=null) {

    	if (!$this->skeleton_auth->logged_in()) {
	        //redirect them to the login page
	        redirect($this->skeleton_auth->login_page, 'refresh');
	    }

		if ($classroom_group_id == null) {
			if(isset($_POST['classroom_group_id'])) {
				$classroom_group_id = $_POST['classroom_group_id'];
			} elseif (isset($_GET['classroom_group_id'])) {
				$classroom_group_id = $_GET['classroom_group_id'];
			}
		} 

		if ($academic_period == null) {
			if(isset($_POST['academic_period_id'])) {
				$academic_period = $_POST['academic_period_id'];
			} elseif (isset($_GET['academic_period_id'])) {
				$classroom_group_id = $_GET['academic_period_id'];
			}	
		} 

        if ($checkbox_show_all_group_enrolled_students == null) {
            if(isset($_POST['checkbox_show_all_group_enrolled_students'])) {
                $checkbox_show_all_group_enrolled_students = $_POST['checkbox_show_all_group_enrolled_students'];
            } elseif (isset($_GET['checkbox_show_all_group_enrolled_students'])) {
                $checkbox_show_all_group_enrolled_students = $_GET['checkbox_show_all_group_enrolled_students'];
            }
        } 

        if ($checkbox_show_all_students == null) {
            if(isset($_POST['checkbox_show_all_students'])) {
                $checkbox_show_all_students = $_POST['checkbox_show_all_students'];
            } elseif (isset($_GET['checkbox_show_all_students'])) {
                $checkbox_show_all_students = $_GET['checkbox_show_all_students'];
            }
        } 

        if ($checkbox_show_hide_students == null) {
            if(isset($_POST['checkbox_show_hide_students'])) {
                $checkbox_show_hide_students = $_POST['checkbox_show_hide_students'];
            } elseif (isset($_GET['checkbox_show_hide_students'])) {
                $checkbox_show_hide_students = $_GET['checkbox_show_hide_students'];
            }
        }

        if ($teacher_id == null) {
            if(isset($_POST['teacher_id'])) {
                $teacher_id = $_POST['teacher_id'];
            } elseif (isset($_GET['teacher_id'])) {
                $teacher_id = $_GET['teacher_id'];
            }
        } 

        //DEBUG
        //echo "classroom_group_id 2: " . $classroom_group_id . " || ";
        //echo "academic_period 2: " . $academic_period . " || ";
        //echo "checkbox_show_all_group_enrolled_students 2: " . $checkbox_show_all_group_enrolled_students . " || ";
        //echo "checkbox_show_all_students 2: " . $checkbox_show_all_students . " || ";
        //echo "checkbox_show_hide_students 2: " . $checkbox_show_hide_students . " || ";
        //echo "teacher_id 2: " . $teacher_id . " || ";

		$this->load->model('reports_model');

		$class_list = array();
		if ($classroom_group_id != null &&  $academic_period != null) {
			$class_list = $this->reports_model->get_class_list($classroom_group_id,$academic_period,
                $checkbox_show_all_group_enrolled_students,$checkbox_show_all_students,$checkbox_show_hide_students,$teacher_id);    	
		}
	    
	    if (is_array($class_list)) {
	    	echo '{
		    "aaData": ';

		    print_r(json_encode($class_list));

		    echo '}';
	    } else {
	    	echo '{
	    	"error_message": ';
	    	echo json_encode($class_list);
		    echo ',
		    "aaData": ';

		    print_r(json_encode(array()));

		    echo '}';
	    }

	    
	}

    function hide_unhide_student_on_classroom_group( $person_id = null, $classroom_group_id = null, $teacher_id = null, $academic_period_id = null, $action = null) {

        if (!$this->skeleton_auth->logged_in()) {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $result = new stdClass();
        $result->result = false;
        $result->message = "No enough values especified!";

        if ($person_id == null) {
            if(isset($_POST['person_id'])) {
                $person_id = $_POST['person_id'];
            } elseif (isset($_GET['person_id'])) {
                $person_id = $_GET['person_id'];
            } else {
                return $result;
            }
        } 

        if ($classroom_group_id == null) {
            if(isset($_POST['classroom_group_id'])) {
                $classroom_group_id = $_POST['classroom_group_id'];
            } elseif (isset($_GET['classroom_group_id'])) {
                $classroom_group_id = $_GET['classroom_group_id'];
            } else {
                return $result;
            }   
        } 

        if ($teacher_id == null) {
            if(isset($_POST['teacher_id'])) {
                $teacher_id = $_POST['teacher_id'];
            } elseif (isset($_GET['teacher_id'])) {
                $teacher_id = $_GET['teacher_id'];
            } else {
                return $result;
            }
        } 

        if ($academic_period_id == null) {
            if(isset($_POST['academic_period_id'])) {
                $academic_period_id = $_POST['academic_period_id'];
            } elseif (isset($_GET['academic_period_id'])) {
                $academic_period_id = $_GET['academic_period_id'];
            } else {
                return $result;
            }
        } 

        if ($action == null) {
            if(isset($_POST['action'])) {
                $action = $_POST['action'];
            } elseif (isset($_GET['action'])) {
                $action = $_GET['action'];
            } else {
                return $result;
            }
        } 

        $this->load->model('reports_model');
        if ($action == "hide") {
            $result = $this->reports_model->hide_student_on_classroom_group($person_id , $classroom_group_id, $teacher_id,$academic_period_id);
        } elseif ($action == "unhide") {
            $result = $this->reports_model->unhide_student_on_classroom_group($person_id , $classroom_group_id, $teacher_id,$academic_period_id);
        } else {
            $result->result = false;
            $result->message = "Action incorrect!";
            return $result;
        }

        print_r(json_encode($result));
    }



	function mentoring_classlists($academic_period_id = null,$mentor_id = null, $classroom_group_id = null,$teacher_id = null){
		$active_menu = array();
		$active_menu['menu']='#mentoring';
		$active_menu['submenu1']='#mentoring_classlists';

    	$this->check_logged_user();

        //check if user is teacher or admin. IF not doesn't allow to show this view!
        if (! (($this->session->userdata('is_admin') || ($this->session->userdata('is_teacher'))) ) ) {
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

		$header_data = $this->load_header_data($active_menu);

        $this->_load_html_header($header_data);
		
		$this->_load_body_header();

		//Check if user is manager -> Show all groups

		// IF USER IS NOT MANAGER -> IS MENTOR? -> SHOW GROUPS user is mentor

		$data = array();

		$this->load->model('reports_model');

		$selected_academic_period_id = false;
        $current_academic_period_id = null;

        if ($academic_period_id == null) {
            $database_current_academic_period =  $this->reports_model->get_current_academic_period();
            
            if ($database_current_academic_period->id) {
                $current_academic_period_id = $database_current_academic_period->id;
            } else {
                $current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');  
            }
            
            $academic_period_id=$current_academic_period_id ;   
        } else {
            $selected_academic_period_id = $academic_period_id;
        }

        $academic_periods = $this->reports_model->get_all_academic_periods();

        $mentors = $this->reports_model->get_mentors($academic_period_id);

        //Check if user is a teacher-> Then if is a mentor. Use this mentor as selected mentor in mentors list
        $default_classroom_group_id = null;

        if ($classroom_group_id != null) {
            $default_classroom_group_id = $classroom_group_id;
        } else {
            if ($mentor_id == null) {
                if ($this->session->userdata('is_teacher')) {
                    //IS MENTOR?
                    if ( $this->reports_model->is_mentor($this->session->userdata('teacher_id'),$academic_period_id) ) {
                        $mentor_id = $this->session->userdata('teacher_id');
                    } else {
                        //GET FIRST CLASSROOM GROUP TEACHER IMPARTS. Use as default classroomgroup show at classromgroups list
                        $default_classroom_group_id = $this->reports_model->get_first_classroom_group_id($this->session->userdata('teacher_id'),$academic_period_id);
                    }
                }
            } elseif ($mentor_id == "void") {
                $mentor_id = false;
                $default_classroom_group_id = $this->reports_model->get_first_classroom_group_id($this->session->userdata('teacher_id'),$academic_period_id);
            }
        }

        
        
        $all_classgroups = array();
        if ($mentor_id == null) {
        	$all_classgroups = $this->reports_model->get_all_classgroups_report_info($academic_period_id);
        } else {
            if ($mentor_id == "void") {
                $all_classgroups = $this->reports_model->get_all_classgroups_report_info($academic_period_id);
            } else {
                $all_classgroups = $this->reports_model->get_all_classgroups_report_info_by_mentor_id($academic_period_id,$mentor_id);    
            }
        }
        

		$data['all_classgroups'] = $all_classgroups;

        $data['default_classroom_group_id'] = $default_classroom_group_id;    
       
        $data['academic_periods'] = $academic_periods;
        $data['selected_academic_period_id'] = $selected_academic_period_id;
        $data['academic_period_id'] = $academic_period_id;
        $data['mentors'] = $mentors;
        $data['mentor_id'] = $mentor_id;

        $person_id=$this->session->userdata('person_id');
        
        //$user_teacher_code = $this->reports_model->get_teacher_code_by_personid($person_id);
        
        $user_teacher_id = $this->reports_model->get_teacher_id_by_personid($person_id);

        if ($teacher_id == null) {
            $teacher_id = $user_teacher_id;
        } else {
            if (!$user_is_admin) { 
                $teacher_id = $user_teacher_id; 
            }
        }

        $user_is_admin = $this->ebre_escool->user_is_admin();
        $data['user_is_admin'] = $user_is_admin;

        if ($user_is_admin) {
            //Load teachers from Model
            $teachers_array = $this->reports_model->get_all_teachers_ids_and_names();

            $data['teachers'] = $teachers_array;
        } else {
            //Show Only one teacher
            $teachers_array = $this->reports_model->get_teacher_ids_and_names($teacher_id);
            $data['teachers'] = $teachers_array;
        }


        //$data['default_teacher_code'] = $teacher_code;
        $data['default_teacher'] = $teacher_id;

		$this->load->view('mentoring_classlists',$data);	

		$this->_load_body_footer();		
	}

    function general_sheet_by_ap($academic_period_id = null) {

        $data = array();

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#general_sheet_report_by_ap';

        $this->check_logged_user();

        //check if user is teacher or admin. IF not doesn't allow to show this view!
        if (! (($this->session->userdata('is_admin') || ($this->session->userdata('is_teacher'))) ) ) {
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $header_data = $this->load_header_data($active_menu);

        $this->_load_html_header($header_data);

        $this->_load_body_header();

        $this->load->model('reports_model');

        $selected_academic_period_id = false;
        $current_academic_period_id = null;

        if ($academic_period_id == null) {
            $database_current_academic_period =  $this->reports_model->get_current_academic_period();

            if ($database_current_academic_period->id) {
                $current_academic_period_id = $database_current_academic_period->id;
            } else {
                $current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');
            }

            $academic_period_id=$current_academic_period_id ;
        } else {
            $selected_academic_period_id = $academic_period_id;
        }

        $academic_periods = $this->reports_model->get_all_academic_periods();

        $data['academic_periods'] = $academic_periods;
        $this->load->view('general_sheet_by_ap',$data);

        $this->_load_body_footer();
    }
	
	/*
	 * Include teachers sheet and other info like employees
	 */
	function general_sheet($academic_period_id = null) {

		if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }
		
		$this->load->model('reports_model');

        if ($academic_period_id==null) {
            $academic_period_id = $this->reports_model->get_current_academic_period()->id;
        }

        $all_teachers = $this->reports_model->get_all_teachers($academic_period_id);

        if ($academic_period_id != null ) {
        	$academic_period = $this->reports_model->get_academic_period_by_id($academic_period_id);
        } else {
        	$academic_period = $this->reports_model->get_current_academic_period();
        }

        $all_conserges = $this->reports_model->get_all_conserges();
        $all_secretaria = $this->reports_model->get_all_secretaria();
        
        $default_group_code = $this->config->item('default_group_code');

        $group_code=$default_group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $header_data['header_title']=lang("all_teachers") . ". " . $organization;
    
//        $all_teachers = $this->ebre_escool_ldap->getAllTeachers("ou=Profes,ou=All,dc=iesebre,dc=com");
//        $all_conserges = $this->ebre_escool_ldap->getAllTeachers("ou=Consergeria,ou=Personal,ou=All,dc=iesebre,dc=com");
//        $all_secretaria = $this->ebre_escool_ldap->getAllTeachers("ou=Secretaria,ou=Personal,ou=All,dc=iesebre,dc=com");
/*
echo "<pre>";
print_r($all_conserges);
echo "</pre>";
*/
/*
echo "<pre>";
print_r($all_secretaria);
echo "</pre>";
*/
/*
$all_conserges = array();
$all_conserges[0]['name']='Jordi';
$all_conserges[0]['sn']='Caudet';
$all_conserges[0]['photo']='jcaudet.jpg';
$all_conserges[1]['name']='Jaume';
$all_conserges[1]['sn']='Benaiges';
$all_conserges[1]['photo']='jbenaiges.jpg';
$all_conserges[2]['name']='Leonor';
$all_conserges[2]['sn']='Agramunt Lleixà';
$all_conserges[2]['photo']='leonoragramunt.jpg';

$all_secretaria = array();
$all_secretaria[0]['name']='Ariadna';
$all_secretaria[0]['sn']='Arasa Bonavila';
$all_secretaria[0]['photo']='aarasa.jpg';
$all_secretaria[1]['name']='Sònia';
$all_secretaria[1]['sn']='Alegria Sol';
$all_secretaria[1]['photo']='soniaalegria.jpg';
$all_secretaria[2]['name']='Yolanda';
$all_secretaria[2]['sn']='Domingo Vallés';
$all_secretaria[2]['photo']='yolandadomingo.jpg';
$all_secretaria[3]['name']='Maria Cinta';
$all_secretaria[3]['sn']='Tomàs Fàbregues';
$all_secretaria[3]['photo']='ctomas.jpg';
$all_secretaria[4]['name']='Lluïsa';
$all_secretaria[4]['sn']='Garcia Gil';
$all_secretaria[4]['photo']='lluisagarcia.jpg';
$all_secretaria[5]['name']='Jordi';
$all_secretaria[5]['sn']='Vega';
$all_secretaria[5]['photo']='jvega.jpg';
*/
/*
echo "Conserges<br/>";
foreach($all_conserges as $conserge){
	echo $conserge['name']."<br />";
}

echo "<br />Secretaries<br />";
foreach($all_secretaria as $secretaria){
	echo $secretaria['name']."<br />";
}
*/

        //print_r(array_keys($all_teachers[0]));
        
		$contador = 0;
		$professor = array();
		$conserge = array();
		$secretaria = array();
        $teacher = null;

		/* CONSERGES */
		//echo "CONSERGES:<br/>";
		//print_r($all_conserges);
		foreach($all_conserges as $cons) {
/*
echo $cons->givenName;
echo $cons->sn1;
echo $cons->sn2;
echo $cons->photo_url;
*/
			//$nom = explode(" ",rtrim($cons['name']));
			//echo "&nbsp;NOM: $cons->givenName<br/>";
			$conserge[$contador]['name']=$cons->givenName;//$nom[0];
			$conserge[$contador]['sn']=$cons->sn1." ".$cons->sn2;//$nom[1];
			$conserge[$contador]['photo']=base_url('uploads/person_photos')."/".$cons->photo_url;

			if( file_exists(getcwd().'/uploads/person_photos/'.$cons->photo_url)) {
			
				$conserge[$contador]['photo']=base_url('uploads/person_photos')."/".$cons->photo_url;
			} else {
				$conserge[$contador]['photo']=base_url('assets/img/alumnes/foto.png');
			}

/*
			$tipus = substr($conserge[$contador]['photo'],0,10);

			if(strlen($tipus)==8){
				$extensio = "cap";
			} else {
				$isJPG  = strpos($tipus, 'JFIF');
				if($isJPG){
					$extensio = ".jpg";
				} else {
					$isPNG = strpos($tipus, 'PNG');
					if($isPNG){
					$extensio = ".png";
					}
				}
			}

			$jpeg_filename="/tmp/".$conserge[$contador]['name'].$conserge[$contador]['sn'].$extensio;
			$jpeg_file_cons[$contador]="/tmp/".$conserge[$contador]['name'].$conserge[$contador]['sn'].$extensio;

			$outjpeg = fopen($jpeg_filename, "wb");
			fwrite($outjpeg, $conserge[$contador]['photo']);
			fclose ($outjpeg);
			$jpeg_data_size = filesize( $jpeg_filename );
*/
			$contador++;
		}

		$contador = 0;

		/* SECRETARIES */
		//echo "SECRETARIES:<br/<";
		//print_r($all_secretaria);
		foreach($all_secretaria as $secr) {

			//echo "&nbsp;NOM: $secr->givenName<br/>";
			$secretaria[$contador]['name']=$secr->givenName;//$nom[0];
			$secretaria[$contador]['sn']=$secr->sn1." ".$secr->sn2;//$nom[1];
			$secretaria[$contador]['photo']=base_url('uploads/person_photos')."/".$secr->photo_url;

			if( file_exists(getcwd().'/uploads/person_photos/'.$secr->photo_url)) {
			
				$secretaria[$contador]['photo']=base_url('uploads/person_photos')."/".$secr->photo_url;
			} else {
				$secretaria[$contador]['photo']=base_url('assets/img/alumnes/foto.png');
			}
			//echo "<img src='".$secretaria[$contador]['photo']."'/>";
/*
			$nom = explode(" ",rtrim($secr['name']));

			$secretaria[$contador]['name']=$nom[0];
			$secretaria[$contador]['sn']=$nom[1];
			$secretaria[$contador]['photo']=$secr['photo'];

			$tipus = substr($secretaria[$contador]['photo'],0,10);

			if(strlen($tipus)==8){
				$extensio = "cap";
			} else {
				$isJPG  = strpos($tipus, 'JFIF');
				if($isJPG){
					$extensio = ".jpg";
				} else {
					$isPNG = strpos($tipus, 'PNG');
					if($isPNG){
					$extensio = ".png";
					}
				}
			}

			$jpeg_filename="/tmp/".$secretaria[$contador]['name'].$secretaria[$contador]['sn'].$extensio;
			$jpeg_file_secr[$contador]="/tmp/".$secretaria[$contador]['name'].$secretaria[$contador]['sn'].$extensio;

			$outjpeg = fopen($jpeg_filename, "wb");
			fwrite($outjpeg, $secretaria[$contador]['photo']);
			fclose ($outjpeg);
			$jpeg_data_size = filesize( $jpeg_filename );
*/
			$contador++;
		}

		$contador = 0;

		/* PROFESSORS */
		// Guardo les dades dels professors en un array
		//echo "TEACHERS:<br/<";
        if (is_array($all_teachers) or ($all_teachers instanceof Traversable)) {
            foreach($all_teachers as $teacher) {
                //echo "$teacher->givenName $teacher->sn1 $teacher->sn2 FOTO: $teacher->photo_url | teacher code: $teacher->teacher_code<br/>";

                $professor[$contador]['code']=$teacher->teacher_code;
                $professor[$contador]['teacher_charge_short']=$teacher->teacher_charge_short;
                $professor[$contador]['teacher_charge_full']=$teacher->teacher_charge_full;
                $professor[$contador]['name']=$teacher->givenName;
                $professor[$contador]['sn1']=$teacher->sn1;
                $professor[$contador]['sn2']=$teacher->sn2;
                $professor[$contador]['teacher_charge_sheet_line1']=$teacher->teacher_charge_sheet_line1;
                $professor[$contador]['teacher_charge_sheet_line2']=$teacher->teacher_charge_sheet_line2;
                $professor[$contador]['teacher_charge_sheet_line3']=$teacher->teacher_charge_sheet_line3;
                $professor[$contador]['teacher_charge_sheet_line4']=$teacher->teacher_charge_sheet_line4;

                $photo_url = trim($teacher->photo_url);

                if ($photo_url != "") {
                    if( file_exists(getcwd().'/uploads/person_photos/'.$photo_url )) {

                        $professor[$contador]['photo']=base_url('uploads/person_photos')."/".$teacher->photo_url;
                    } else {
                        $professor[$contador]['photo']=base_url('assets/img/alumnes/foto.png');
                    }
                } else {
                    $professor[$contador]['photo']=base_url('assets/img/alumnes/foto.png');
                }


                $professor[$contador]['carrec_line1']=$professor[$contador]['teacher_charge_sheet_line1'];
                $professor[$contador]['carrec_line2']=$professor[$contador]['teacher_charge_sheet_line2'];
                $professor[$contador]['carrec_line3']=$professor[$contador]['teacher_charge_sheet_line3'];
                $professor[$contador]['carrec_line4']=$professor[$contador]['teacher_charge_sheet_line4'];

                /*
                            $tipus = substr($professor[$contador]['photo'],0,10);

                            if(strlen($tipus)==8){
                                $extensio = "cap";
                            } else {
                                $isJPG  = strpos($tipus, 'JFIF');
                                if($isJPG){
                                    $extensio = ".jpg";
                                } else {
                                    $isPNG = strpos($tipus, 'PNG');
                                    if($isPNG){
                                    $extensio = ".png";
                                    }
                                }
                            }

                            $jpeg_filename="/tmp/".$professor[$contador]['code'].$extensio;
                            $jpeg_file[$contador]="/tmp/".$professor[$contador]['code'].$extensio;

                            $outjpeg = fopen($jpeg_filename, "wb");
                            fwrite($outjpeg, $professor[$contador]['photo']);
                            fclose ($outjpeg);
                            $jpeg_data_size = filesize( $jpeg_filename );
                */
                $contador++;
            }
        }



		$count = count($professor);

		//Crido la classe
		$pdf = new FPDF('P', 'mm', 'A4','font/');
		//Defineixo els marges
		$pdf->SetMargins(10,10,10);
		//Obro una pàgina
		$pdf->AddPage();
				//$pdf->Image($jpeg_file_cons[0],166,222,10);        
		//$pdf->AddPage("P","A3");
		//Es la posicio exacta on comença a escriure
		$x=7;//10
		$y=15;//24

		//Logo
		//$pdf->Image(base_url().APPPATH.'third_party/skeleton/assets/img/logo_iesebre_2010_11.jpg',$x+2,5,40,15);
		$pdf->Image(base_url('uploads/person_photos'). "/logo_iesebre_2010_11.jpg",$x+2,5,40,15);

        $photo_url = "";
        if (!is_null($teacher)) {
            $photo_url = $teacher->photo_url;;
        }

        $professor[$contador]['photo']=base_url('uploads/person_photos')."/". $photo_url;

		//Defineixo el tipus de lletra, si és negreta (B), si és cursiva (L), si és normal en blanc
		$pdf->SetFont('Arial','B',15);
		//$pdf->Cell(Amplada, altura, text, marc, on es comença a escriure després, alineació)
		$pdf->SetXY(10,10);
	
		$pdf->Cell(190,6,"PROFESSORAT ". $academic_period->shortname ,0,0,'C');
		$y=$y+6;

		//Guardo les coordenades inicials de x i y
		$x_start=$x;
		$y_start=$y;

		//Inicio les columnes i les files a 0
		$col=0;
		$row=0;

		//Paràmetres de tamany de les fotos, $xx indica l'amplada de la foto, $yy indica
		//l'altura de cada camp del professor, l'altura de la foto es 3 vegades aquest valor
		//En cas de tocar aquest paràmetres caldria revisar el màxim de columnes i files  
		$xx=11;//10//Amplada horitzontal de cada professor es tocada segons el nombre de professors que hi haguin

		//Sergi Tur
		//Si no s'indica l'amplada vertical es posa el que toca per mantenir les proporcions
		//Fotos originals: 147x186:1.265306122
		//Mida: 12x15,183673464
		//$yy=5;//3//Amplada vertical de cada professor es tocada segons el nombre de professors que hi haguin

		//No és l'açada de la FOTO! És la alçada del que ocupa cada bloc de profe (foto+dades)
		$yy=4.75;

		//Amb aquestes fòrmules defineixo les coordenades de cada camp de cada professor
		//Fòrmula: posició inicial de x/y * columna * camps de cada professor 

		//Ampla de la columna amb el nom i cognoms del professor
		$x_name=12;
		//Ampla de la columna de carrecs
		$x_post=9;

		$x=$x_start+$col*($xx+$x_name+$x_post);
		$x1=$x_start+$col*($xx+$x_name+$x_post)+$x_name;
		$x2=$x_start+$col*($xx+$x_name+$x_post)+$x_name+$x_post;

		$y=$y_start+$row*$yy*3;
		$y1=$y_start+$row*$yy*3+$yy;
		$y2=$y_start+$row*$yy*3+$yy*2;
		$y3=$y_start+$row*$yy*3+$yy*2;

		//La i és el marge entre professors
		$i=0;
		$page_one=true;

		//Imprimeixo sempre els conserges i secretàries en una posició fixa el primer cop
		//TODO: Obtenir les dades de les carpetes personal de Gosa:
				
		//Posició inicial conserges:

			$initial_x_personal=166;
			$initial_y_personal=222;

			$width_personal_foto=10;
					
			$pdf->SetFont('Arial','B',8);
			$pdf->Text($initial_x_personal+3,$initial_y_personal-2,utf8_decode("CONSERGES"));                
			$pdf->SetFont('Arial','',4); 	
			
			$x_personal=$initial_x_personal;
			$y_personal=$initial_y_personal;
			for($cont=0;$cont<count($conserge);$cont++){

				$pdf->Image($conserge[$cont]['photo'],$x_personal,$y_personal,$width_personal_foto); 
				$pdf->Text($x_personal,$y_personal+15,utf8_decode($conserge[$cont]['name']));                
				$pdf->Text($x_personal,$y_personal+17,utf8_decode($conserge[$cont]['sn']));   
				$x_personal=$x_personal+14;
				if(($cont+1)%3==0){
					$x_personal=$initial_x_personal;
					$y_personal=$initial_y_personal+40;			
				}		
			}	

			$pdf->SetFont('Arial','B',8);   
			$pdf->Text($initial_x_personal+3,$initial_y_personal+22,utf8_decode("SECRETÀRIES"));	
			$pdf->SetFont('Arial','',4); 

			$x_personal=$initial_x_personal;
			$y_personal=$initial_y_personal+24;
			for($cont=0;$cont<count($secretaria);$cont++){

				$pdf->Image($secretaria[$cont]['photo'],$x_personal,$y_personal,$width_personal_foto); 
				$pdf->Text($x_personal,$y_personal+15,utf8_decode(ucfirst($secretaria[$cont]['name'])));                
				$pdf->Text($x_personal,$y_personal+17,utf8_decode(ucfirst($secretaria[$cont]['sn'])));   
				$x_personal=$x_personal+14;
				if(($cont+1)%3==0){
					$x_personal=$initial_x_personal;
					$y_personal=$initial_y_personal+42;			
				}
			}	

		/*	
			//Foto                
			$pdf->Image($jpeg_file_cons[0],$initial_x_personal,$initial_y_personal,$width_personal_foto);                
			$pdf->SetFont('Arial','',5);                
			//Nom                
			$pdf->Text($initial_x_personal+1,$initial_y_personal+15,utf8_decode($conserge[0]['name']));                
			//Cognom                
			$pdf->Text($initial_x_personal+1,$initial_y_personal+17,utf8_decode($conserge[0]['sn']));                
			$pdf->Image($jpeg_file_cons[1],$initial_x_personal+14,$initial_y_personal,$width_personal_foto);                
			$pdf->Text($initial_x_personal+15,$initial_y_personal+14,utf8_decode($conserge[1]['name']));                  
			$pdf->Text($initial_x_personal+15,$initial_y_personal+16,utf8_decode($conserge[1]['sn']));                
			$pdf->Image($jpeg_file_cons[2],$initial_x_personal+28,$initial_y_personal,$width_personal_foto);                
			$pdf->Text($initial_x_personal+30,$initial_y_personal+14,utf8_decode($conserge[2]['name']));                
			$pdf->Text($initial_x_personal+30,$initial_y_personal+16,utf8_decode($conserge[2]['sn']));                
		*/
			/*
			$pdf->SetFont('Arial','B',8);                
			$pdf->Text($initial_x_personal+3,$initial_y_personal+21,utf8_decode("SECRETÀRIES"));                

			$pdf->Image(base_url()."application/views/attendance_reports/foto.jpg",$initial_x_personal,$initial_y_personal+22,$width_personal_foto);                
			$pdf->SetFont('Arial','',5);                
			$pdf->Text($initial_x_personal+1,$initial_y_personal+36,utf8_decode("Cinta"));                
			$pdf->Text($initial_x_personal+1,$initial_y_personal+38,utf8_decode("Tomas"));                
			$pdf->Image(base_url()."application/views/attendance_reports/foto.jpg",$initial_x_personal+14,$initial_y_personal+22,$width_personal_foto);                
			$pdf->Text($initial_x_personal+15,$initial_y_personal+36,utf8_decode("Yolanda"));                
			$pdf->Text($initial_x_personal+15,$initial_y_personal+38,utf8_decode("Domingo"));                
			$pdf->Image(base_url()."application/views/attendance_reports/foto.jpg",$initial_x_personal+28,$initial_y_personal+22,$width_personal_foto);                
			$pdf->Text($initial_x_personal+29,$initial_y_personal+36,utf8_decode("Lluisa"));                
			$pdf->Text($initial_x_personal+29,$initial_y_personal+38,utf8_decode("Gárcia"));                
			$pdf->Image(base_url()."application/views/attendance_reports/foto.jpg",$initial_x_personal,$initial_y_personal+40,$width_personal_foto);
			$pdf->Text($initial_x_personal,$initial_y_personal+54,utf8_decode("Sònia"));
			$pdf->Text($initial_x_personal,$initial_y_personal+56,utf8_decode("Alegria"));
		*/
		//Si escrivim per la sortida aleshores no es podrà utilitzar PDF (headers already sent...)
		//echo "prova!";

		function cmpTeachers($a, $b)	{
			return strnatcmp($a->code, $b->code);
		}

		{

		$x = $x -22;
		//$y = 21;
		for($j=0;$j<$count; $j++) {

				$pdf->SetFont('Arial','B',6);
				$pdf->SetTextColor(255,0,0);
				
				$pdf->Text($x+22,$y,utf8_decode($professor[$j]['code']));
				
				$pdf->SetFont('Arial','',4);
				$pdf->SetTextColor(0,0,0);		
				$pdf->Text($x+44,$y,utf8_decode($professor[$j]['carrec_line1']));
				$pdf->Text($x+44,$y1-1,utf8_decode($professor[$j]['carrec_line2']));
				$pdf->Text($x+22,$y1-1,utf8_decode($professor[$j]['name']));
				$pdf->Text($x+22,$y2-2,utf8_decode($professor[$j]['sn1']));
				$pdf->Text($x+44,$y2-2,utf8_decode($professor[$j]['carrec_line3']));
				$pdf->Text($x+22,$y+11,utf8_decode($professor[$j]['sn2']));
				$pdf->Text($x+44,$y+11,utf8_decode($professor[$j]['carrec_line4']));
				//$pdf->Image($jpeg_file[$j],$x1-2,$y-2,$xx);                
				$pdf->Image($professor[$j]['photo'],$x1-2,$y-2,$xx);                
			//incremento la fila
			$row++;
			//incremento el marge
			$i=$i+0.3;

			//Recàlculo les coordenades
			$y=$y_start+$i+$row*$yy*3;
			$y1=$y_start+$i+$row*$yy*3+$yy;
			$y2=$y_start+$i+$row*$yy*3+$yy*2;

			//màxim de files per pàgina 
			if($row>17){//26//Maxim de registre per columnes si es toca el tamny del professor tambe es tocara aquesta dada.
				//incremento la columna
				$col++;
				//reinicio les files i el marge
				$row=0;
				$i=0;
				//Recàlculo les coordenades
				$x=$x_start+$col*($xx+$x_name+$x_post)-22;   
				$x1=$x_start+$col*($xx+$x_name+$x_post)+$x_name;
				$x2=$x_start+$col*($xx+$x_name+$x_post)+$x_name+$x_post;
				
				$y=$y_start+$i+$row*$yy*3;
				$y1=$y_start+$i+$row*$yy*3+$yy;
				$y2=$y_start+$i+$row*$yy*3+$yy*2;

			}
			//Quan arribem a la última fila vigilem de no escriure a sobre dels conserges i secretàries
			if($col==5 && $row==21 && $page_one){
				//Ho tornem a posar tot a 0 i obrim una nova pàgina
				$col=0;
				$row=0;
				$i=0;
				$x=$x_start+$col*$xx;
				$x1=$x_start+$col*$xx*3+$xx;
				$x2=$x_start+$col*$xx*3+$xx*2;

				$y=$y_start+$i+$row*$yy*3;
				$y1=$y_start+$i+$row*$yy*3+$yy;
				$y2=$y_start+$i+$row*$yy*3+$yy*2;
				$page_one=false;
				$pdf->AddPage();
			}
		}
		}

		//enviem tot al pdf
		$pdf->Output("Professorat_". $academic_period->shortname ."_(".date("d-m-Y").").pdf", "I");

		
	}

	/*
	 * Only teachers: at teachers module
	 */
	/*function teacher_sheet() {
		echo "TODO";
	}*/

}
