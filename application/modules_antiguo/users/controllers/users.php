<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";


class users extends skeleton_main {
	
	public $body_header_view ='include/ebre_escool_body_header.php' ;

  public $body_header_lang_file ='ebre_escool_body_header' ;

  public $html_header_view ='include/ebre_escool_html_header' ;

  public $body_footer_view ='include/ebre_escool_body_footer' ;
	
	function __construct()
    {
    parent::__construct();

        //GROCERY CRUD
		$this->load->add_package_path(APPPATH.'third_party/grocery-crud/application/');
        $this->load->library('grocery_CRUD');
        $this->load->add_package_path(APPPATH.'third_party/image-crud/application/');
		$this->load->library('image_CRUD');  

		/* Set language */
		$current_language=$this->session->userdata("current_language");
		if ($current_language == "") {
			$current_language= $this->config->item('default_language');
		}
		$this->lang->load('users', $current_language);	       

		
        //LANGUAGE HELPER:
    $this->load->helper('language');

    $this->load->model('users_model');
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
        
        $this->grocery_crud->add_fields('first_name','last_name','username','password','verify_password','person_id','mainOrganizationaUnitId','email','active','company','phone','groups','created_on','ip_address');
        $this->grocery_crud->edit_fields('first_name','last_name','username','password','verify_password','person_id','mainOrganizationaUnitId','email','active','company','phone','groups','last_login','ip_address');
        

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

        //Person
        $this->grocery_crud->set_relation('person_id','person','{person_givenName} {person_sn1} {person_sn2}');
        
        //USER MAIN ORGANIZATIONAL UNIT
        //$this->grocery_crud->set_relation('mainOrganizationaUnitId','organizational_unit','{name}',array('markedForDeletion' => 'n'));
        $this->grocery_crud->set_relation('mainOrganizationaUnitId','organizational_unit','{organizational_unit_name}',array('organizational_unit_markedForDeletion' => 'n'));
        
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
     
       
       $this->load->view($this->users_view,$output);
       //$this->load->view('include/footer');      
       
       /*******************
     /*      FOOTER     *
     *******************/
     $this->_load_body_footer();   
               
}



  
	
	public function index() {
		$this->users();
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
                base_url('assets/js/jquery.slimscroll.min.js'));    
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ebre-escool.js'));


        $header_data['menu']= $active_menu;
        return $header_data;
}

  //CALLBACKS
function common_callbacks()
{
        //CALLBACKS        
        $this->grocery_crud->callback_add_field($this->session->flashdata('table_name').'_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field($this->session->flashdata('table_name').'_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field($this->session->flashdata('table_name').'_last_update',array($this,'edit_callback_last_update'));
}

  public function edit_field_callback_entryDate($value, $primary_key){
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
  }

  public function edit_callback_last_update($value, $primary_key){

    $data = date('d/m/Y H:i:s', time());
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. $data .'"  name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';

  }

  public function before_update_last_update($post_array, $primary_key) {
    $data= date('d/m/Y H:i:s', time());
    $post_array[$this->session->flashdata('table_name').'_last_update'] = $data;
    //$post_array['lastupdateUserId'] = $this->session->userdata('user_id');
    return $post_array;
}  

public function add_field_callback_entryDate(){  

    $data= date('d/m/Y H:i:s', time());
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
}

public function add_callback_last_update(){  
   
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';
}  

}
