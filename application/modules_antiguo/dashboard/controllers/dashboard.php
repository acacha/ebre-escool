<?php defined('BASEPATH') OR exit('No direct script access allowed');


include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class dashboard extends skeleton_main {
	
	public $body_header_view ='include/ebre_escool_body_header' ;

	public $body_header_lang_file ='ebre_escool_body_header' ;

	public $html_header_view ='include/ebre_escool_html_header' ;

	public $body_footer_view ='include/ebre_escool_body_footer' ;

	public function load_header_data($menu){

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
  			$jquery_url= base_url('assets/js/jquery-1.9.1.js');
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
		//Jquery already load by skeleton main!!!
		//$header_data= $this->add_javascript_to_html_header_data(
		//	$header_data,
		//	$jquery_url);
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

	
	function __construct()
    {
        parent::__construct();

        $this->load->model('dashboard_model');
        
	}
	
	public function index() {		

		$active_menu = array();
		$active_menu['menu']='#dashboard';
		//$this->session->set_flashdata('menu', $active_menu);

		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}

		//$this->session->set_flashdata('categoria','dashboard');
		$header_data = $this->load_header_data($active_menu);
        $this->_load_html_header($header_data);

        /*******************
		/*      BODY     *
		/******************/
		$this->_load_body_header();

		$data = array();

		$person_statistics = $this->dashboard_model->getPersonsStatistics();

		$data['person_statistics'] = $person_statistics;

		$teacher_statistics = $this->dashboard_model->getTeachersStatistics();

		$data['teachers_statistics'] = $teacher_statistics;

		$students_statistics = $this->dashboard_model->getStudentsStatistics();

		$data['students_statistics'] = $students_statistics;

		$employers_statistics = $this->dashboard_model->getEmployersStatistics();

		$data['employers_statistics'] = $employers_statistics;

		$curriculum_statistics = $this->dashboard_model->getCurriculumStatistics();

		$data['curriculum_statistics'] = $curriculum_statistics;

		$enrollment_statistics = $this->dashboard_model->getEnrollmentStatistics();

		$data['enrollment_statistics'] = $enrollment_statistics;

		$data['current_academic_period'] = "2014/15";

		if ($this->session->userdata('is_student')) {
			$this->load->view('dashboard_student',$data); 
		} else {
			$this->load->view('dashboard',$data); 
		}
		
                
		/*******************
		/*      FOOTER     *
		*******************/
		$this->_load_body_footer();		 
	}		

	public function categories()
	{
		//$this->session->set_flashdata('prova','categoria');
		$valor = $_POST['valor'];
		echo $valor;
	}
}
