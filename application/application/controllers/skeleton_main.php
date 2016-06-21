<?php defined('BASEPATH') OR exit('No direct script access allowed');


require_once "application/third_party/skeleton/application/controllers/skeleton_main.php";

class skeleton extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php' ;

  	public $body_header_lang_file ='ebre_escool_body_header' ;

  	public $html_header_view ='include/ebre_escool_html_header' ;

	public $body_footer_view ='include/ebre_escool_body_footer' ;

    public $error_page_404 = "include/404.php"; 

    public $users_view = "include/users_view.php";

    public $groups_view = "include/groups_view.php";

    public $preferences_page = "skeleton/user_preferences";

    public $skeleton_grocery_crud_default_view = 'include/skeleton_object_view.php';

    public $preferences_view = 'include/preferences.php';

    public $user_preferences_NOT_yet_header_view = "include/user_preferences_NOT_yet_header.php";

    public $user_preferences_for_admin_header_view = "include/user_preferences_for_admin_header.php";

	public $header_data;

    public $active_menu = array();

	function __construct()
    {
		parent::__construct();

        //$params = array('model' => "skeleton_auth_model");
        //$this->load->library('skeleton_auth',$params);
        
        //CONFIG skeleton_auth library:
        $this->skeleton_auth->login_page="skeleton_auth/ebre_escool_auth/login";
        
	}
	
	public function index() {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		redirect('attendance/check_attendance','refresh');
		
	}

    public function users() {
        
        $this->active_menu['menu']='#managment';
        $this->active_menu['submenu1']='#managment_users';

        parent::users();

    }

    public function groups() {
        
        $this->active_menu['menu']='#managment';
        $this->active_menu['submenu1']='#managment_groups';

        //echo "TEST1";

        parent::groups();

    }

    public function preferences() {
        
        $this->active_menu['menu']='#managment';
        $this->active_menu['submenu1']='#managment_preferences';

        parent::preferences();

    }

    public function user_preferences() {
        
        $this->active_menu['menu']='#managment';
        $this->active_menu['submenu1']='#managment_preferences';

        parent::user_preferences();

    }

    public function error404() {
        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }
        parent::error404();
    }

    protected function _get_html_header_data() {

        $header_data = parent::_get_html_header_data();
        $header_data = $this->load_ace_files($header_data); 

        return $header_data;
    }

	function load_ace_files($init_header_data){

		$header_data= $this->add_css_to_html_header_data(
            $init_header_data,
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
            base_url('assets/css/no_padding_top.css'));  


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


        $header_data['menu']= $this->active_menu;
        return $header_data;
}

}

