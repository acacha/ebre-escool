<?php defined('BASEPATH') OR exit('No direct script access allowed');

//include "skeleton_main.php";
include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class location extends skeleton_main {
	
    public $body_header_view ='include/ebre_escool_body_header.php' ;
    public $body_header_lang_file ='ebre_escool_body_header' ;

    public $html_header_view ='include/ebre_escool_html_header' ;

    public $body_footer_view ='include/ebre_escool_body_footer' ;

	function __construct()
    {
        parent::__construct();
        
        $this->load->model('location_model');
        //$this->config->load('curriculum');        
        
        /* Set language */
        $current_language=$this->session->userdata("current_language");
        if ($current_language == "") {
            $current_language= $this->config->item('default_language');
        }
        
        // Load the language file
        $this->lang->load('location',$current_language);
        $this->load->helper('language');

	}
	
	public function index() {
		$this->location();
	}

	public function location() {
		
        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#location';

        $this->check_logged_user(); 

        $header_data= $this->load_ace_template($active_menu);  

		/* Grocery Crud */
		$this->current_table="location";
        $this->grocery_crud->set_table($this->current_table);
        
        $this->session->set_flashdata('table_name', $this->current_table); 
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('location'));   

        $this->common_callbacks($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_Id',lang($this->current_table.'_id'));
        $this->grocery_crud->display_as($this->current_table.'_name',lang($this->current_table.'_name'));
        $this->grocery_crud->display_as($this->current_table.'_external_code',lang($this->current_table.'_external_code'));
        $this->grocery_crud->display_as($this->current_table.'_shortName',lang($this->current_table.'_shortName')); 
        $this->grocery_crud->display_as($this->current_table.'_parentLocation',lang($this->current_table.'_parentLocation'));
        $this->grocery_crud->display_as($this->current_table.'_description',lang($this->current_table.'_description'));
        $this->grocery_crud->display_as($this->current_table.'_department_id',lang($this->current_table.'_department_id'));
        $this->grocery_crud->display_as($this->current_table.'_organizational_unit_id',lang($this->current_table.'_organizational_unit_id'));

        $this->grocery_crud->display_as($this->current_table.'_entryDate',lang($this->current_table.'_entryDate'));
        $this->grocery_crud->display_as($this->current_table.'_last_update',lang($this->current_table.'_last_update'));
        $this->grocery_crud->display_as($this->current_table.'_creationUserId',lang($this->current_table.'_creationUserId'));                  
        $this->grocery_crud->display_as($this->current_table.'_lastupdateUserId',lang($this->current_table.'_lastupdateUserId'));   
        $this->grocery_crud->display_as($this->current_table.'_markedForDeletion',lang($this->current_table.'_markedForDeletion'));       
        $this->grocery_crud->display_as($this->current_table.'_markedForDeletionDate',lang($this->current_table.'_markedForDeletionDate'));   

        $this->grocery_crud->set_relation($this->current_table.'_parentLocation','location','{location_shortName} - {location_name}');    
        $this->grocery_crud->set_relation($this->current_table.'_department_id','department','department_name');    
        $this->grocery_crud->set_relation($this->current_table.'_organizational_unit_id','organizational_unit','organizational_unit_name');    



        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
   		
        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails("location_creationUserId","location_lastupdateUserId");
   
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
    
//-->

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

function renderitzar($table_name,$header_data = null)
{
       $output = $this->grocery_crud->render();

       // HTML HEADER
       
        $this->_load_html_header($header_data,$output); 
        $this->_load_body_header();      

      // $this->_load_html_header($this->_get_html_header_data(),$output); 
       
       //      BODY       

       //$this->_load_body_header();
       
       $default_values=$this->_get_default_values();
       $default_values["table_name"]=$table_name;
       $default_values["field_prefix"]=$table_name."_";
       $this->load->view('defaultvalues_view.php',$default_values); 

       $this->load->view($table_name.'.php',$output);     
       
       //      FOOTER     
       $this->_load_body_footer();  

}

  public function load_ace_template($active_menu) {
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

        $header_data['menu']= $active_menu;
        return $header_data;

  }

}
