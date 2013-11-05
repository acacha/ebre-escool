<?php defined('BASEPATH') OR exit('No direct script access allowed');

class skeleton_main extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
        
        $this->load->add_package_path(APPPATH.'third_party/skeleton/application/',true);
    	$params = array('model' => "skeleton_auth_model");
		$this->load->library('skeleton_auth',$params);
		
		//CONFIG skeleton_auth library:
		$this->skeleton_auth->login_page="skeleton_auth/auth/login";
		
		//LOAD SKELETON_AUTH MODEL
		$this->load->model('skeleton_auth_model');
		
		//GROCERY CRUD
		$this->load->add_package_path(APPPATH.'third_party/grocery-crud/application/');
        $this->load->library('grocery_CRUD');
        $this->load->add_package_path(APPPATH.'third_party/image-crud/application/');
		$this->load->library('image_CRUD');  
		       
        //Helpers
        $this->load->helper('url');
                
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
	
	protected function _load_html_header($html_header_data=array(),$grocery_crud_data=array()) {
		
		$data=array();
		
		//print_r($html_header_data);
		
		$header_title = array_key_exists("header_title",$html_header_data) ? $html_header_data['header_title'] : $this->config->item('header_title', 'skeleton_auth');
		$header_description = array_key_exists("header_description",$html_header_data) ? $html_header_data['header_description'] : $this->config->item('header_description', 'skeleton_auth');
		$header_authors = array_key_exists("header_authors",$html_header_data) ? $html_header_data['header_authors'] : $this->config->item('header_authors', 'skeleton_auth');
		
		$skeleton_css_files = array_key_exists("skeleton_css_files",$html_header_data) ? $html_header_data['skeleton_css_files'] : array();
		$skeleton_js_files = array_key_exists("skeleton_js_files",$html_header_data) ? $html_header_data['skeleton_js_files'] : array();
		
		$data['header_title'] = $header_title ;
		$data['header_description'] = $header_description ;
		$data['header_authors'] = $header_authors ;
		$data['skeleton_css_files'] = $skeleton_css_files ;
		$data['skeleton_js_files'] = $skeleton_js_files ;
		
		$this->load->view('include/html_header',array_merge((array) $grocery_crud_data,$data));
	}
	
	protected function _load_body_header() {
		$data=array();
		
		//Default permissions
		$data['show_managment_menu']=false;
		$data['show_maintenace_menu']=false;
		$data['check_attendance']=false;
		$data['mentoring']=false;
		$data['reports']=false;
		
		$skeleton_admin_group = $this->config->item('skeleton_admin_group','skeleton_auth');

		if ($this->skeleton_auth->in_group($skeleton_admin_group)) {
			$data['show_managment_menu']=true;
			$data['show_maintenace_menu']=true;
			$data['check_attendance']=true;
			$data['mentoring']=true;
			$data['reports']=true;
		}
		
		$data['show_managment_menu']=true;
			$data['show_maintenace_menu']=true;
			$data['check_attendance']=true;
			$data['mentoring']=true;
			$data['reports']=true;
		
		// TODO: check others roles if allowed to show management menu and show_maintenace_menu
		
		$data['body_header_app_name']="Skeleton";
		$this->load->view('include/ebre_escool_body_header',$data);
	}

	protected function _load_body() {
		$data=array();
		$this->load->view('include/body',$data);		
	}
	
	public function change_language($language) {
		$this->session->set_userdata('current_language', $language);
		redirect($_SERVER[‘HTTP_REFERER’]);
	}
	
	protected function _load_body_footer() {
		$data=array();
		$data['body_footer_entity_url'] = "http://www.ebretic.com/";
		$data['body_footer_entity_url_name'] = "www.ebretic.com";
		$data['body_footer_entity_name'] = "EBRETIC ENGINYERA SL";
		$data['body_footer_entity_image_url'] = base_url('assets/img/ebretic_100x36.jpg');
		$data['body_footer_copyright_date'] = "2013";
		$data['body_footer_wiki_url'] = "http://acacha.org/mediawiki/index.php/skeleton";
		$data['body_footer_github_url'] = "https://github.com/acacha/skeleton";
		$data['body_footer_authors'] = '<a href="http://acacha.org">Sergi Tur Badenas</a>';

		$this->load->view('include/body_footer',$data);
	}
	
	public function index() {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		redirect('attendance/check_attendance','refresh');
	}
	
	protected function add_javascript_to_html_header_data($html_header_data,$js_file) {		
		array_push($html_header_data['skeleton_js_files'],$js_file);
		return $html_header_data;
	} 
	
	protected function add_css_to_html_header_data($html_header_data,$css_file) {		
		array_push($html_header_data['skeleton_css_files'],$css_file);
		return $html_header_data;
	} 
	
	protected function _get_html_header_data() {

		$skeleton_css_files=array();
		
		$bootstrap_min=base_url("assets/css/bootstrap.min.css");
		$bootstrap_responsive=base_url("assets/css/bootstrap-responsive.min.css");
		$font_awesome=base_url("assets/css/font-awesome.css");
				
		array_push($skeleton_css_files, $bootstrap_min, $bootstrap_responsive,$font_awesome);
		$header_data['skeleton_css_files']=$skeleton_css_files;			
		
		$skeleton_js_files=array();
		
		$lodash_js="http://cdnjs.cloudflare.com/ajax/libs/lodash.js/1.2.1/lodash.min.js";
		$jquery_js=base_url("assets/grocery_crud/js/jquery-1.10.2.min.js");
		$lazyload_js=base_url("assets/grocery_crud/js/common/lazyload-min.js");
		$bootstrap_js=base_url("assets/js/bootstrap.min.js");
		
		array_push($skeleton_js_files, $lodash_js ,$jquery_js , $bootstrap_js, $lazyload_js);
		$header_data['skeleton_js_files']=$skeleton_js_files;	
		
		return $header_data;
	}
	
	public function location()
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
		
		$this->current_table="location";
        $this->grocery_crud->set_table($this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('location_subject'));                
        
        //Mandatory fields
        $this->grocery_crud->required_fields('name','shortName','markedForDeletion');
        
        //Express fields
        $this->grocery_crud->express_fields('name','shortName','parentLocation');
        
        //CALLBACKS        
        $this->grocery_crud->callback_add_field('entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('last_update',array($this,'edit_field_callback_lastupdate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('last_update',array($this,'edit_field_callback_lastupdate'));
        
        //COMMON_COLUMNS               
        $this->set_common_columns_name();
               
        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('parentLocation',lang('parentLocation'));
        
        //Establish fields/columns order and wich camps to show
        //$this->grocery_crud->columns($this->session->userdata('location_current_fields_to_show'));
        
        //Relacions entre taules
        $this->grocery_crud->set_relation('parentLocation','location','{name}',array('markedForDeletion' => 'n'));
        
         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("creationUserId","lastupdateUserId","parentLocation");
        
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
        $this->grocery_crud->set_default_value($this->current_table,'parentLocation',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'markedForDeletion','n');
                   
        $output = $this->grocery_crud->render();
                        
        $this->_load_html_header($this->_get_html_header_data(),$output); 
	    $this->_load_body_header();
		
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$this->load->view('defaultvalues_view.php',$default_values); 
			
        $this->load->view('location_view.php',$output);     

	    $this->_load_body_footer();	         
        
    } 
	
	public function organizational_unit()
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
		
        $this->current_table="organizational_unit";
        $this->grocery_crud->set_table($this->current_table);
        
        //Establish subject:
        $this->grocery_crud->set_subject(lang('organizationalunit_subject'));
                  
        //COMMON_COLUMNS               
        $this->set_common_columns_name();
        
        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('externalCode',lang('code'));
        $this->grocery_crud->display_as('location',lang('location'));
        
        //Establish fields/columns order and wich camps to show
        //$this->grocery_crud->columns($this->session->userdata('organizational_unit_current_fields_to_show'));
                                                         
        //Mandatory fields
        $this->grocery_crud->required_fields('name','shortName','markedForDeletion');
        
        //express fields
        $this->grocery_crud->express_fields('name','shortName','externalCode');

        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_add_field('last_update',array($this,'add_field_callback_last_update'));
        
        //Relacions entre taules
        $this->grocery_crud->set_relation('location','location','{name}',array('markedForDeletion' => 'n'));
        
        //CALLBACKS        
        $this->grocery_crud->callback_add_field('entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('last_update',array($this,'edit_field_callback_lastupdate'));
        
        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
   		$this->grocery_crud->unset_add_fields('last_update');
   		
   		//USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("creationUserId","lastupdateUserId");
        
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //Default values:
        $this->grocery_crud->set_default_value($this->current_table,'location',1);
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,'markedForDeletion','n');
        
        $output = $this->grocery_crud->render();
           
		$this->_load_html_header($this->_get_html_header_data(),$output); 
	    $this->_load_body_header();
		
		$default_values=$this->_get_default_values();
		$default_values["table_name"]=$this->current_table;
		$default_values["field_prefix"]='';
		$this->load->view('defaultvalues_view.php',$default_values); 
	    
        $this->load->view('organizational_unit_view.php',$output);     
 
	    $this->_load_body_footer();	 
 
	}
	
	public function users() {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		//CHECK IF USER IS READONLY --> unset add, edit & delete actions
		$readonly_group = $this->config->item('skeleton_readonly_group','skeleton_auth');
		if ($this->skeleton_auth->in_group($readonly_group)) {
			$this->grocery_crud->unset_add();
			$this->grocery_crud->unset_edit();
			$this->grocery_crud->unset_delete();
	    }
		$user_groups = $this->skeleton_auth->get_users_groups($this->session->userdata('user_id'))->result();
		
		$table_name="users";
	    $this->current_table=$table_name;
        $this->grocery_crud->set_table($this->current_table);  
        
        $this->grocery_crud->add_fields('first_name','last_name','username','password','verify_password','mainOrganizationaUnitId','email','active','company','phone','groups','created_on','ip_address');
        $this->grocery_crud->edit_fields('first_name','last_name','username','password','verify_password','mainOrganizationaUnitId','email','active','company','phone','groups','last_login','ip_address');
        
        //CHECK IF STATE IS UPDATE o UPDATE_VALIDATION
        $state = $this->grocery_crud->getState();
        if ($state == "update" || $state == "update_validation" || $state == "edit") {
			$this->grocery_crud->required_fields('username','email','active','groups');
			$this->grocery_crud->set_rules('password', lang('password'), 'min_length[' . $this->config->item('min_password_length', 'skeleton_auth') . ']|max_length[' . $this->config->item('max_password_length', 'skeleton_auth') . ']|md5');
			$this->grocery_crud->set_rules('verify_password', lang('verify_password'), 'matches[password]');
		} else {
			$this->grocery_crud->required_fields('username','password','verify_password','email','active','groups');
			$this->grocery_crud->set_rules('password', lang('password'), 'required|min_length[' . $this->config->item('min_password_length', 'skeleton_auth') . ']|max_length[' . $this->config->item('max_password_length', 'skeleton_auth') . ']|md5');
			$this->grocery_crud->set_rules('verify_password', lang('verify_password'), 'required|matches[password]');
		}

        //Establish subject:
        $this->grocery_crud->set_subject(lang('users_subject'));
        
        //COMMON_COLUMNS               
        $this->set_common_columns_name();
        
        //ESPECIFIC COLUMNS                                            
        $this->grocery_crud->display_as('verify_password',lang('verify_password'));
        $this->grocery_crud->display_as('mainOrganizationaUnitId',lang('MainOrganizationaUnitId'));
        $this->grocery_crud->display_as('ip_address',lang('ip_address'));
        $this->grocery_crud->display_as('username',lang('username')); 
        $this->grocery_crud->display_as('password',lang('Password')); 
        $this->grocery_crud->display_as('email',lang('email'));
        $this->grocery_crud->display_as('activation_code',lang('activation_code'));
        $this->grocery_crud->display_as('forgotten_password_code',lang('forgotten_password_code'));
        $this->grocery_crud->display_as('forgotten_password_time',lang('forgotten_password_time'));
        $this->grocery_crud->display_as('remember_code',lang('remember_code'));
        $this->grocery_crud->display_as('created_on',lang('created_on'));                
        $this->grocery_crud->display_as('active',lang('active'));
        $this->grocery_crud->display_as('first_name',lang('first_name'));
        $this->grocery_crud->display_as('last_name',lang('last_name'));
        $this->grocery_crud->display_as('company',lang('company'));
        $this->grocery_crud->display_as('phone',lang('phone'));
        
        //Establish fields/columns order and wich camps to show
        $this->grocery_crud->columns('username','email','created_on','last_login','active','first_name','last_name','company','phone');

        //FIELD TYPES
        $this->grocery_crud->field_type('password', 'password');
        $this->grocery_crud->field_type('verify_password', 'password');
        $this->grocery_crud->field_type('created_on', 'datetime');
		$this->grocery_crud->field_type('last_login', 'datetime');
		$this->grocery_crud->field_type('active', 'dropdown',
		            array('1' => lang('Yes'), '2' => lang('No')));
		$this->grocery_crud->field_type('ip_address', 'invisible');
		$this->grocery_crud->field_type('created_on', 'invisible');
		
		//RULES
		$this->grocery_crud->set_rules('email', lang('email'), 'required|valid_email');
        
        $this->grocery_crud->unset_add_fields('ip_address','salt','activation_code','forgotten_password_code','forgotten_password_time','remember_code','last_login','created_on');
        $this->grocery_crud->unset_edit_fields('ip_address','salt','activation_code','forgotten_password_code','forgotten_password_time','remember_code','last_login','created_on');
        
        $this->grocery_crud->unique_fields('username','email');

	    //GROUPS
        $this->grocery_crud->set_relation_n_n('groups', 'users_groups','groups', 'user_id', 'group_id', 'name');
        
        //USER MAIN ORGANIZATIONAL UNIT
        $this->grocery_crud->set_relation('mainOrganizationaUnitId','organizational_unit','{name}',array('markedForDeletion' => 'n'));
        
        $this->grocery_crud->callback_before_insert(array($this,'callback_unset_verification_and_hash_and_extra_actions'));
		$this->grocery_crud->callback_before_update(array($this,'callback_unset_verification_and_hash_and_extra_actions'));
		
		//ON UPDATE SHOW VOID PASSWORD FIELDS
		$this->grocery_crud->callback_edit_field('password',array($this,'edit_field_callback_password'));
		
		$this->set_theme($this->grocery_crud);
		$this->set_dialogforms($this->grocery_crud);
		
		//Default values
        $this->grocery_crud->set_default_value($this->current_table,'active',1);
        //$this->grocery_crud->set_default_value($this->current_table,'groups',1);
        $this->grocery_crud->set_default_value($this->current_table,'mainOrganizationaUnitId',1);
        
        //Express fields
        $this->grocery_crud->express_fields('username','password','verify_password','email','groups');
        
        try {
			
        $output = $this->grocery_crud->render();
        
        } catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
        
        //DEFAULT VALUES
       // TODO
       
       
       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
       
       $this->load->view('users_view.php',$output);
       //$this->load->view('include/footer');      
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	 
               
}
	
	function user_info() {
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
	       
        $current_rol_id = $this->session->userdata('role');
		$current_role_name = $this->_get_rolename_byId($current_rol_id);


        $user_groups_in_database= $this->skeleton_auth->get_users_groups()->result();
        $user_groups_in_database_names=array();

        foreach ($user_groups_in_database as $user_group_in_database) {
			$user_groups_in_database_names[]=$user_group_in_database->name;
		}
		
		$userid=$this->session->userdata('user_id');
		$user=$this->skeleton_auth->user($userid)->row();
		       
        $data['fields']=array (
			lang('user_id_title') => $userid,
			lang('username_title') => $this->session->userdata('username'),
			lang('name_title') => $user->first_name,
			lang('surname_title') => $user->last_name,
			lang('email_title') => $this->session->userdata('email'),
			lang('user_groups_in_database') => implode(", ",$user_groups_in_database_names),
			lang('rol_title') => $current_role_name,
			lang('realm_title') => $this->session->userdata('default_realm'),
			lang('main_user_organizational_unit') => $this->skeleton_auth_model->get_main_organizational_unit_name_from_userid($userid),
        );
		
		$output= array();
		$array_css_files = array();
		$array_js_files = array();

		array_push($array_css_files, base_url("assets/grocery_crud/themes/flexigrid/css/flexigrid.css"));
		//TODO: bos doesn't collapse!
		//array_push($array_js_files, base_url("assets/grocery_crud/js/jquery-1.10.2.min.js"));
		//array_push($array_js_files, base_url("assets/grocery_crud/themes/flexigrid/js/flexigrid.js"));		
		$output['css_files'] =  $array_css_files;
		$output['js_files'] = $array_js_files;
		
		$this->_load_html_header($this->_get_html_header_data(),$output); 
		$this->_load_body_header();
		
		$this->load->view('user_info_view',$data); 
                
		$this->_load_body_footer();	 
		
	}
	
	public function user_preferences() {
		//IF USER IS NOT LOGGED REDIRECT TO LOGIN PAGE: PROTECTED PAGE
		if (!$this->skeleton_auth->logged_in()) {	
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		//OBTAIN GROUPS/ROLES
		$readonly_group = $this->config->item('skeleton_readonly_group','skeleton_auth');	
		$organizationalunit_group = $this->config->item('organizationalunit_group');
		$dataentry_group = $this->config->item('dataentry_group');
		$skeleton_admin_group = $this->config->item('skeleton_admin_group','skeleton_auth');
		
		//NOT ALL USERS HAVE PREFERENCES: IN CASE no preferences then
		//default ones are applied
		$user_have_preferences=false;
		$user_id = $this->session->userdata('user_id');
		
		$user_have_preferences=$this->skeleton_auth_model->user_have_preferences($user_id);
		$user_preferences_id=null;
		if ($user_have_preferences) {
			$user_preferences_id = $this->skeleton_auth_model->get_user_preferencesId($user_id);  
		}
		
		//GET STATE AND STATE INFO
		try {
			$state = $this->grocery_crud->getState();
			$state_info = $this->grocery_crud->getStateInfo();
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
			
		$skip_grocerycrud=false;		
		$default_values2 = array();
		
		//SKIP IS USER IS ADMIN	
		if (!$this->skeleton_auth->in_group($skeleton_admin_group)) {
			//CHECK OPERATIONS DONE BY NO ADMIN USERS DEPENDING ON STATE
			if($state == 'add')	{
				//Prepare add form to force userId
				$this->grocery_crud->required_fields('markedForDeletion','language','theme');
				$this->grocery_crud->unset_back_to_list();
				$this->grocery_crud->field_type('userId', 'hidden', $user_id);
				//IF USER have preferences an is not admin then operation not permited
				//Avoid adding to times same register
				if ($user_have_preferences) {
					$skip_grocerycrud=true;
					$alternate_view_to_grocerycrud="insert_not_allowed.php";
				}
				
			} 
			elseif($state == 'insert_validation') {
				//CHECK IF EDIT IS ALLOWED DEPENDING ON USER ROLES	
				$primary_key = $state_info->primary_key;
				
				$skip_grocerycrud=true;
				$alternate_view_to_grocerycrud="insert_not_allowed.php";
				
				if (!($primary_key == $user_preferences_id)) {			
					//CHECK IF PRIMARY KEY TO EDIT IS OWNED BY USER
					//NOT ALLOWED
					$skip_grocerycrud=true;
					$alternate_view_to_grocerycrud="insert_not_allowed.php";				
				}					
			}
			elseif($state == 'edit') {
				$this->grocery_crud->unset_back_to_list();
				if ($this->skeleton_auth->in_group($organizationalunit_group) || 
					$this->skeleton_auth->in_group($dataentry_group) ) {
						//Prepare edit form to force userId
						$this->grocery_crud->required_fields('markedForDeletion','language','theme');
						$this->grocery_crud->unset_back_to_list();
						$this->grocery_crud->field_type('userId', 'hidden', $user_id);
				}
				
				//******* TODO****************
				//CHECK IF EDIT IS ALLOWED DEPENDING ON USER ROLES	
				$primary_key = $state_info->primary_key;
				if (!($primary_key == $user_preferences_id)) {			
					//CHECK IF PRIMARY KEY TO EDIT IS OWNED BY USER
					//NOT ALLOWED
					$skip_grocerycrud=true;
					$alternate_view_to_grocerycrud="edit_not_allowed.php";				
				}					
			} elseif ($state == 'list' || $state == 'ajax_list' || $state == 'success') {
				//******* TODO****************
				if ($this->skeleton_auth->in_group($readonly_group) || 
					$this->skeleton_auth->in_group($organizationalunit_group) || 
					$this->skeleton_auth->in_group($dataentry_group) ) {
						$this->grocery_crud->unset_operations();
				}
				if ($this->skeleton_auth->in_group($organizationalunit_group) || 
					$this->skeleton_auth->in_group($dataentry_group) ) {
						$this->grocery_crud->unset_list();
				}
			}
			else {
				$this->grocery_crud->required_fields('userId','markedForDeletion','language','theme');
			}	
		} else {
			//USER IS ADMIN
			$this->grocery_crud->required_fields('userId','markedForDeletion','language','theme');
		}
		$this->grocery_crud->unique_fields('userId');
		
		$this->current_table="user_preferences";
        $this->grocery_crud->set_table($this->current_table);
        
        //Establish subject:
        $this->grocery_crud->set_subject(lang('user_preferences_subject'));
                        
        //COMMON_COLUMNS               
        $this->set_common_columns_name();
        
        //ESPECIFIC COLUMNS                                            
        $this->grocery_crud->display_as('userId',lang('userId'));
        $this->grocery_crud->display_as('language',lang('language'));
        $this->grocery_crud->display_as('theme',lang('theme'));
        $this->grocery_crud->display_as('dialogforms',lang('dialogforms'));
        
        //Establish fields/columns order and wich camps to show
        //$this->grocery_crud->columns($this->session->userdata('user_preferences_current_fields_to_show'));       
        
        $this->grocery_crud->unset_add_fields('last_update','manualLast_update');
        
        //ExternID types
        $this->grocery_crud->set_relation('userId','users','{username}');
        
        //$this->grocery_crud->unset_dropdowndetails("userId");
		//$this->grocery_crud->set_default_value($this->current_table,'userId',$this->session->userdata('username'));
		
		//ENTRY DATE
		//DEFAULT VALUE=NOW. ONLY WHEN ADDING
		//EDITING: SHOW CURRENT VALUE READONLY
		$this->grocery_crud->callback_add_field('entryDate',array($this,'add_field_callback_entryDate'));
		$this->grocery_crud->callback_edit_field('entryDate',array($this,'edit_field_callback_entryDate'));
		
		//LAST UPDATE
		//DEFAULT VALUE=NOW. ONLY WHEN ADDING
		//EDITING: SHOW CURRENT VALUE READONLY
		$this->grocery_crud->callback_add_field('last_update',array($this,'add_callback_last_update'));
		$this->grocery_crud->callback_edit_field('last_update',array($this,'edit_callback_last_update'));
		
		//UPDATE AUTOMATIC FIELDS
		if ($this->skeleton_auth->in_group($skeleton_admin_group)) {
			$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		} else {
			//If not admin user, force UserId always to be the userid of actual user
			$this->grocery_crud->callback_before_insert(array($this,'before_insert_user_preference_callback'));
		}
		
		if ($this->skeleton_auth->in_group($skeleton_admin_group)) {
			$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
		} else {
			//If not admin user, force UserId always to be the userid of actual user
			$this->grocery_crud->callback_before_update(array($this,'before_update_user_preference_callback'));
		}
        
        //USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($this->current_table,'lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("creationUserId","lastupdateUserId");
        
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
		
		try{
			$output = $this->grocery_crud->render();
			//$this->load_header($output,true,false);
               
			//TODO: Default values

			//ADMIN USER: SHOW HELPER TO EDIT HIS PREFERENCES: SHORTCUT
			//GROCERYCRUD VIEW
        
			$data = array( 'user_preferences_id' => $user_preferences_id );

			if($state == 'list') {
				// IF USER HAVE NO PREFERENCES YES SHOW MESSAGE
				if (!$user_have_preferences){
					$this->load->view('user_preferences_NOT_yet_header.php',$data);                
				} else {
				$this->load->view('user_preferences_for_admin_header.php',$data);                
				}
			}
            
            $this->_load_html_header($this->_get_html_header_data(),$output); 
			$this->_load_body_header();
                
			//GROCERYCRUD VIEW
			if ($skip_grocerycrud) {
				$this->load->view($alternate_view_to_grocerycrud,$output);
			}
			else{	
				$this->load->view('skeleton_object_view.php',$output);     
			}
			$this->_load_body_footer();	 
			} catch(Exception $e){
				show_error($e->getMessage().' --- '.$e->getTraceAsString());
			}   
	}
    
    public function preferences() {
		
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
		//CHECK IF USER IS READONLY --> REDIRECT TO LIST
		$readonly_group = $this->config->item('skeleton_readonly_group','skeleton_auth');
		if ($this->skeleton_auth->in_group($readonly_group)) {
			redirect("skeleton_main/user_preferences", 'refresh');
		}
		
		//CHECK IF USER IS ADMIN --> REDIRECT TO LIST ALL USER 
		//PREFERENCES
		$skeleton_admin_group = $this->config->item('skeleton_admin_group','skeleton_auth');
		if ($this->skeleton_auth->in_group($skeleton_admin_group)) {
			redirect("skeleton_main/user_preferences", 'refresh');
		}
		
		$user_have_preferences=false;
		$user_id = $this->session->userdata('user_id');
		$user_have_preferences=$this->skeleton_auth_model->user_have_preferences($user_id);
		$user_preferences_id=null;
		if ($user_have_preferences) {
			$user_preferences_id = $this->skeleton_auth_model->get_user_preferencesId($user_id);  
			redirect("skeleton_main/user_preferences/edit/". $user_preferences_id);
		}
		else {
			redirect("skeleton_main/user_preferences/add");
		}
		
	}
	
	public function groups(){
	   if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		//CHECK IF USER IS READONLY --> unset add, edit & delete actions
		$readonly_group = $this->config->item('skeleton_readonly_group','skeleton_auth');
		if ($this->skeleton_auth->in_group($readonly_group)) {
			$this->grocery_crud->unset_add();
			$this->grocery_crud->unset_edit();
			$this->grocery_crud->unset_delete();
	   }
	   
	   $table_name="groups";
	   $this->current_table=$table_name;
       $this->grocery_crud->set_table($this->current_table);  
       
       $this->grocery_crud->required_fields('name');

       //Establish subject:
        $this->grocery_crud->set_subject(lang('groups_subject'));
        
       //COMMON_COLUMNS               
       $this->set_common_columns_name();

       //Establish fields/columns order and wich camps to show
       //TODO
       //$this->grocery_crud->columns($this->session->userdata('groups_current_fields_to_show'));
       
       $this->grocery_crud->set_relation_n_n('users', 'users_groups','users', 'group_id', 'user_id', 'username');
       
       //ESPECIFIC COLUMNS                                            
	   $this->grocery_crud->display_as('users',lang('users'));
       
       $this->set_theme($this->grocery_crud);
       $this->set_dialogforms($this->grocery_crud);
            
       $output = $this->grocery_crud->render();
       
       //DEFAULT VALUES
       // TODO
       
       
       /*******************
	   /* HTML HEADER     *
	   /******************/
	   $this->_load_html_header($this->_get_html_header_data(),$output); 
	   
	   /*******************
	   /*      BODY       *
	   /******************/
	   $this->_load_body_header();
	   
       
       $this->load->view('groups_view.php',$output);
       //$this->load->view('include/footer');      
       
       /*******************
	   /*      FOOTER     *
	   *******************/
	   $this->_load_body_footer();	                    
} 

protected function set_common_columns_name()
{
       //COMMON_COLUMNS                      
       $this->set_express_common_columns_name();
      
       $this->grocery_crud->display_as('description',lang('description'));       
       $this->grocery_crud->display_as('entryDate',lang('entryDate'));       
       $this->grocery_crud->display_as('manualEntryDate',lang('manualEntryDate'));       
       $this->grocery_crud->display_as('last_update',lang('last_update')); 
       $this->grocery_crud->display_as('manualLast_update',lang('manual_last_update')); 
       $this->grocery_crud->display_as('creationUserId',lang('creationUserId'));
       $this->grocery_crud->display_as('lastupdateUserId',lang('lastupdateUserId'));  
       $this->grocery_crud->display_as('markedForDeletion',lang('markedForDeletion'));
       $this->grocery_crud->display_as('markedForDeletionDate',lang('markedForDeletionDate'));
}     

protected function set_express_common_columns_name()
{
       //COMMON_COLUMNS                      
       $this->grocery_crud->display_as('name',lang('name'));       
       $this->grocery_crud->display_as('shortName',lang('shortName'));       
}

protected function set_theme($grocery_crud) {
		
		$userid = $this->session->userdata('user_id');
		$user_theme = $this->skeleton_auth_model->get_user_theme($userid);
		
		$all_themes = (array) $this->config->item('supported_themes','skeleton_auth');
		if (!in_array($user_theme, $all_themes)) {
			//DEFAULT THEME IF USER NOT CHOOSED ONE
			$user_theme = $this->config->item('default_theme','skeleton_auth');
		}
		
		if ($user_theme=="twitter-bootstrap") {
			$grocery_crud = $grocery_crud->unset_bootstrap();
		}

		$grocery_crud->set_theme($user_theme);
	}

protected function set_dialogforms($grocery_crud) {
		$userid = $this->session->userdata('user_id');
		$user_fialogforms = $this->skeleton_auth_model->get_user_dialogforms($userid);
		if ($user_fialogforms == "n") {
			$grocery_crud->unset_dialogforms();
		}	
		
}

public function edit_field_callback_password($value, $primary_key)
{
    return '<input id="field-password" name="password" type="password" value="">';
}

function add_field_callback_entryDate(){  
	  $data= date('d/m/Y H:i:s', time());
	  return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="entryDate" id="field-entryDate" readonly>';    
}

function add_field_callback_course_entryDate(){  
	  $data= date('d/m/Y H:i:s', time());
	  return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="course_entryDate" id="field-entryDate" readonly>';    
}

function add_field_callback_cycle_entryDate(){  
	  $data= date('d/m/Y H:i:s', time());
	  return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="cycle_entryDate" id="field-entryDate" readonly>';    
}

function add_field_callback_studies_entryDate(){  
	  $data= date('d/m/Y H:i:s', time());
	  return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="studies_entryDate" id="field-entryDate" readonly>';    
}

function add_field_callback_studiesOU_entryDate(){  
	  $data= date('d/m/Y H:i:s', time());
	  return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="studiesOU_entryDate" id="field-entryDate" readonly>';    
}

function edit_field_callback_entryDate($value, $primary_key){  
	  return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="entryDate" id="field-entryDate" readonly>';    
    }
    
function edit_callback_last_update($value, $primary_key){  
	 return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'"  name="last_update" id="field-last_update" readonly>';
    }    

//UPDATE AUTOMATIC FIELDS BEFORE INSERT
function before_insert_user_preference_callback($post_array, $primary_key) {
		//UPDATE LAST UPDATE FIELD
		$data= date('d/m/Y H:i:s', time());
		$post_array['last_update'] = $data;
		
		$user_id=$this->session->userdata('user_id');
		$post_array['userId'] = $user_id;
		$post_array['creationUserId'] = $user_id;
		$post_array['lastupdateUserId'] = $user_id;
		
		
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

//UPDATE AUTOMATIC FIELDS BEFORE UPDATE
// ONLY CALLED BY USERS NOT ADMINS!
function before_update_user_preference_callback($post_array, $primary_key) {
		//UPDATE LAST UPDATE FIELD
		$data= date('d/m/Y H:i:s', time());
		$post_array['last_update'] = $data;
		
		$user_id=$this->session->userdata('user_id');
		$post_array['userId'] = $user_id;
		$post_array['lastupdateUserId'] = $this->session->userdata('session_id');
		return $post_array;
		//TODO:
		//return from_date_to_unix($post_array);
    }
    
protected function _get_rolename_byId($id){
		
		$roles = (array) $this->config->item('roles');		
		return $roles[(int) $id];
	}    
	
function error404()	{
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->skeleton_auth->login_page, 'refresh');
		}
		
	   $this->_load_html_header($this->_get_html_header_data()); 
	   $this->_load_body_header();
	   
       
       $this->load->view('404.php');

	   $this->_load_body_footer();	 
	}
	
function tablenotfound()	{
		$this->load_header();
        $this->load->view('tablenotfound.php');        
        $this->load->view('include/footer');   	
	}	
	
function _get_default_values() {
		
		//TODO
		//$defaultvalues['defaultcreationUserId']= $this->session->userdata('user_id');
		//   
     	//$defaultvalues['defaultfieldLanguage']= $this->config->item('default_language');
     	//$defaultvalues['defaultfieldTheme']= $this->config->item('default_theme');

     	//TRANSLATIONS:
     	$defaultvalues['good_translated']= lang('Good');
     	$defaultvalues['bad_translated']= lang('Bad');
     	$defaultvalues['regular_translated']= lang('Regular');
     	$defaultvalues['yes_translated']= lang('Yes');
     	$defaultvalues['no_translated']= lang('No');
     	
     	//LANGUAGES
     	$defaultvalues['catalan_translated']= lang('catalan');
     	$defaultvalues['spanish_translated']= lang('spanish');
     	$defaultvalues['english_translated']= lang('english');
     	
     	
     	//ORGANIZATIONAL UNIT
     	//if ($this->session->userdata("current_organizational_unit")) {
		//	$defaultvalues['defaultmainOrganizationaUnitId']=$this->session->userdata("current_organizational_unit");
		//}
		
		/*
	    $current_role_id   = $this->session->userdata('role');
        $current_role_name = $this->_get_rolename_byId($current_role_id);
		if ( $current_role_name == $this->config->item('organizationalunit_group')) {
			$defaultvalues['disable_mainOrganizationaUnitId']=true;
		}
		
		*/
     	
     	$default_values['express_form']=false;
     	
		return $defaultvalues;
	}	
	
public function get_dropdown_values($table_name,$field_name) {
		//ONLY LOGGED USERS CAN ACCES TO THIS CONTROLLER
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect( $this->login_page . "?redirect=" . urlencode(uri_string($current_url)), 'refresh');
		}
		//ONLY RESPONSE TO POST AJAX PETITIONS		
		if ($this->_is_ajax()) {
			@ob_end_clean();
			$new_options=array();
			$primary_key=$this->skeleton_auth_model->get_primary_key($table_name);
			$dropdown_values=$this->skeleton_auth_model->get_dropdown_values($table_name,$field_name,$primary_key);
			
			$results= (object)array(
					'output' => $dropdown_values,
					'key'    => $primary_key
			);

			echo json_encode($results);
			die;
		}
	}	
	
protected function _is_ajax()
	{
		return array_key_exists('is_ajax', $_POST) && $_POST['is_ajax'] == 'true' ? true: false;
	}	
	
public function get_last_added_value($table_name) {
		//ONLY LOGGED USERS CAN ACCES TO THIS CONTROLLER
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect( $this->login_page . "?redirect=" . urlencode(uri_string($current_url)), 'refresh');
		}
		//ONLY RESPONSE TO POST AJAX PETITIONS		
		if ($this->_is_ajax()) {
			@ob_end_clean();
			$new_options=array();
			$primary_key=$this->skeleton_auth_model->get_primary_key($table_name);
			$last_added_value=$this->skeleton_auth_model->get_last_added_value($table_name,$primary_key);
			
			$results= (object)array(
					'output' => $last_added_value,
					'key'    => $primary_key
			);

			echo json_encode($results);
			die;
		}
	}
	
public function defaultvalues_view($table_name) {
		//ONLY LOGGED USERS CAN ACCES TO THIS CONTROLLER
		if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect( $this->login_page . "?redirect=" . urlencode(uri_string($current_url)), 'refresh');
		}
		
		//AJAX & POST
		if ($this->_is_ajax()) {
			@ob_end_clean();
			
			// VIEW WITH DINAMIC JAVASCRIPT. Purpose: set default values
			$default_values=$this->_get_default_values();
			$default_values["table_name"]=$table_name;
			$default_values["express_form"]=true;
			$default_values_view_as_string = $this->load->view('defaultvalues_view.php',$default_values,true); 
        
			$results= (object)array(
					'output' => $default_values_view_as_string,
			);

			echo json_encode($results);
			die;
		} else { //SIMPLE GET
			// VIEW WITH DINAMIC JAVASCRIPT. Purpose: set default values
			$default_values=$this->_get_default_values();
			$default_values["table_name"]=$table_name;
			$default_values["express_form"]=true;
			$this->load->view('defaultvalues_view.php',$default_values); 
		}
	}	
	
	function edit_field_callback_lastupdate($value, $primary_key){
	  return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="entryDate" id="field-last_update" readonly>';    	
	}
	
	public function callback_unset_verification_and_hash_and_extra_actions($post_array){
		
	unset($post_array['verify_password']);   
	$password=$post_array['password'];
	   
	if(!empty($password)) {
		$salt       = $this->skeleton_auth->store_salt ? $this->salt() : FALSE;
		$post_array['password']  = $this->skeleton_auth->hash_password($password, $salt);
		if ($this->skeleton_auth->store_salt)	{
			$post_array['salt'] = $salt;
		}
	} else {
		//DON'T SAVE VOID PASSWORD INSTEAD LET THE PASSWORD REMAIN the same
		unset($post_array['password']);
	}
		
	//EXTRA FIELDS:
	//IP ADDRESS
	$post_array['ip_address'] = $this->skeleton_auth->_prepare_ip($this->input->ip_address());
	$post_array['created_on'] = date('Y-m-d H:i:s');

	return $post_array;
}

}
