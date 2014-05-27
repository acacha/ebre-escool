<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";


class employees extends skeleton_main {
	
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
		    $this->lang->load('employees', $current_language);	       

        //LANGUAGE HELPER:
        $this->load->helper('language');
	}



	public function employee() {

    $active_menu = array();
    $active_menu['menu']='#maintenances';
    $active_menu['submenu1']='#persons';
    $active_menu['submenu2']='#employees';

    $this->check_logged_user(); 

    /* Ace */
    $header_data= $this->load_ace_files($active_menu);  

    /* Grocery Crud */ 
    $this->current_table="employees";
    $this->grocery_crud->set_table($this->current_table);
    $this->session->set_flashdata('table_name', $this->current_table); 
    
    //Establish subject:
    $this->grocery_crud->set_subject(lang($this->current_table.'_subject'));
        
    $this->common_callbacks($this->current_table);

    //RELATIONS
    $this->grocery_crud->set_relation($this->current_table.'_person_id','person','{person_sn1} {person_sn2},{person_givenName} ({person_official_id}) - {person_id} '); 
    $this->grocery_crud->set_relation($this->current_table.'_type_id','employees_type','{employees_type_name}');
        
    //COLUMN NAMES
    $this->grocery_crud->display_as($this->current_table.'_person_id',lang($this->current_table.'_person_id'));          
    $this->grocery_crud->display_as($this->current_table.'_code',lang($this->current_table.'_code'));  
    $this->grocery_crud->display_as($this->current_table.'_type_id',lang($this->current_table.'_type_id'));  
     
    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);        
       	
    //UPDATE AUTOMATIC FIELDS
    $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
    $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
    $this->userCreation_userModification($this->current_table);

    $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');

    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data); 

	}

    public function employees_type() {

    $active_menu = array();
    $active_menu['menu']='#maintenances';
    $active_menu['submenu1']='#persons';
    $active_menu['submenu2']='#employees_type';

    $this->check_logged_user(); 

    /* Ace */
    $header_data= $this->load_ace_files($active_menu);  

    /* Grocery Crud */ 
    $this->current_table="employees_type";
    $this->grocery_crud->set_table($this->current_table);
    $this->session->set_flashdata('table_name', $this->current_table); 
    
    //Establish subject:
    $this->grocery_crud->set_subject(lang($this->current_table.'_subject'));
        
    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);    

    $this->common_callbacks($this->current_table);

    //COLUMN NAMES
    $this->grocery_crud->display_as($this->current_table.'_code',lang($this->current_table.'_code'));  
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));  
    $this->grocery_crud->display_as($this->current_table.'_shortName',lang('shortName'));          
           
    
        
    //UPDATE AUTOMATIC FIELDS
    $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
    $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
    $this->userCreation_userModification($this->current_table);

    $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');

    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data); 

    }    

//-->


  public function edit_field_callback_entryDate($value, $primary_key){
    //return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="person_entryDate" id="field-entryDate" readonly>';    
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="'.$this->session->flashdata('table_name').'entryDate" id="field-entryDate" readonly>';    
  }

  public function edit_callback_last_update($value, $primary_key){

    $data = date('d/m/Y H:i:s', time());
    //return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. $data .'"  name="person_last_update" id="field-last_update" readonly>';
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. $data .'"  name="'.$this->session->flashdata('table_name').'last_update" id="field-last_update" readonly>';

  }

  public function before_update_last_update($post_array, $primary_key) {
    $data= date('d/m/Y H:i:s', time());
    //$post_array['person_last_update'] = $data;
    $post_array[$this->session->flashdata('table_name').'last_update'] = $data;
    //$post_array['lastupdateUserId'] = $this->session->userdata('user_id');
    return $post_array;
}  

public function add_field_callback_entryDate(){  

    $data= date('d/m/Y H:i:s', time());
    //return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="person_entryDate" id="field-entryDate" readonly>';    
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="'.$this->session->flashdata('table_name').'entryDate" id="field-entryDate" readonly>';    
}

//<--    


	protected function _unique_field_name($field_name)
    {
    	return 's'.substr(md5($field_name),0,8); //This s is because is better for a string to begin with a letter and not with a number
    }

	
	public function index() {
		$this->employee();
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

function set_common_columns_name($table_name){
    $this->grocery_crud->display_as($table_name.'_entryDate',lang('entryDate'));
    $this->grocery_crud->display_as($table_name.'_last_update',lang('last_update'));
    $this->grocery_crud->display_as($table_name.'_creationUserId',lang('creationUserId'));                  
    $this->grocery_crud->display_as($table_name.'_lastupdateUserId',lang('lastupdateUserId'));   
    $this->grocery_crud->display_as($table_name.'_markedForDeletion',lang('markedForDeletion'));       
    $this->grocery_crud->display_as($table_name.'_markedForDeletionDate',lang('markedForDeletionDate')); 
}

}
