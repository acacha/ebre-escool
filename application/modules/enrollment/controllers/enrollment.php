<?php defined('BASEPATH') OR exit('No direct script access allowed');

//include "skeleton_main.php";
include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class enrollment extends skeleton_main {
	
    public $body_header_view ='include/ebre_escool_body_header.php' ;
    public $body_header_lang_file ='ebre_escool_body_header' ;

    public $html_header_view ='include/ebre_escool_html_header' ;

    public $body_footer_view ='include/ebre_escool_body_footer' ;       

	function __construct()
    {
        parent::__construct();
        
        //$this->load->model('attendance_model');
        //$this->load->model('enrollment_model');
        //$this->load->library('ebre_escool_ldap');
        //$this->config->load('managment');        
        
        /* Set language */
        $current_language=$this->session->userdata("current_language");
        if ($current_language == "") {
            $current_language= $this->config->item('default_language');
        }
        
        // Load the language file
        $this->lang->load('enrollment',$current_language);
        $this->load->helper('language');

	}
	
	protected function _getvar($name){
		if (isset($_GET[$name])) return $_GET[$name];
		else if (isset($_POST[$name])) return $_POST[$name];
		else return false;
	}

	public function index() {
		$this->enrollment();
	}

/* ENROLLMENT */

	public function enrollment() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment';

        $this->check_logged_user();
		
        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

		/* Grocery Crud */
		$this->current_table="enrollment";
        $this->grocery_crud->set_table($this->current_table);
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment'));       
 
        $this->common_callbacks($this->current_table);

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS

        $this->grocery_crud->display_as($this->current_table.'_periodid',lang('periodid'));        
        $this->grocery_crud->display_as($this->current_table.'_personid',lang('personid'));

        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_personid','person','{person_givenName} {person_sn1} {person_sn2}');

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
   		
        $this->userCreation_userModification($this->current_table);
        
        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId','study_submodules_lastupdateUserId');
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

        $this->renderitzar($this->current_table,$header_data);                   

	}

/* FI ENROLLMENT */

/* ENROLLMENT STUDIES */

	public function enrollment_studies() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment_studies';

        $this->check_logged_user();
        
        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

		/* Grocery Crud */
		$this->current_table="enrollment_studies";
        $this->grocery_crud->set_table($this->current_table);
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment_studies'));       
        
        $this->common_callbacks($this->current_table);

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_periodid',lang('periodid'));          
        $this->grocery_crud->display_as($this->current_table.'_personid',lang('personid'));   
        $this->grocery_crud->display_as($this->current_table.'_study_id',lang('study_id'));        		

        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_personid','person','{person_givenName} {person_sn1} {person_sn2}');
        $this->grocery_crud->set_relation($this->current_table.'_study_id','studies','{studies_shortname}');

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
   		
        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId','study_submodules_lastupdateUserId');

        $this->userCreation_userModification($this->current_table);        
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');
                   
        $this->renderitzar($this->current_table,$header_data);
	}

/* FI ENROLLMENT STUDIES */

/* ENROLLMENT CLASS GROUP */

	public function enrollment_class_group() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment_class_group';

        $this->check_logged_user();
        
        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

		/* Grocery Crud */
		$this->current_table="enrollment_class_group";
        $this->grocery_crud->set_table($this->current_table);
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment_class_group'));       

        $this->common_callbacks($this->current_table);

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_periodid',lang('periodid'));
        $this->grocery_crud->display_as($this->current_table.'_personid',lang('personid'));          
        $this->grocery_crud->display_as($this->current_table.'_study_id',lang('study_id'));   
        $this->grocery_crud->display_as($this->current_table.'_group_id',lang('group_id'));        		

        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_personid','person','{person_givenName} {person_sn1} {person_sn2}');
        $this->grocery_crud->set_relation($this->current_table.'_study_id','studies','{studies_shortname}');
        $this->grocery_crud->set_relation($this->current_table.'_group_id','classroom_group','{classroom_group_code}');        

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId','study_submodules_lastupdateUserId');

        $this->userCreation_userModification($this->current_table);
           
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);

        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');
                   
        $this->renderitzar($this->current_table,$header_data);	
	}

/* FI ENROLLMENT CLASS GROUP */

/* ENROLLMENT MODULES */

	public function enrollment_modules() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment_modules';

        $this->check_logged_user();
        
        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

		/* Grocery Crud */
		$this->current_table="enrollment_modules";
        $this->grocery_crud->set_table($this->current_table);
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment_modules'));       

        $this->common_callbacks($this->current_table);

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_periodid',lang('periodid'));
        $this->grocery_crud->display_as($this->current_table.'_personid',lang('personid'));
        $this->grocery_crud->display_as($this->current_table.'_study_id',lang('study_id'));          
        $this->grocery_crud->display_as($this->current_table.'_group_id',lang('group_id'));   
        $this->grocery_crud->display_as($this->current_table.'_moduleid',lang('moduleid'));        		

        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_personid','person','{person_givenName} {person_sn1} {person_sn2}');
        $this->grocery_crud->set_relation($this->current_table.'_study_id','studies','{studies_shortname}');
        $this->grocery_crud->set_relation($this->current_table.'_group_id','classroom_group','{classroom_group_code}');      
        $this->grocery_crud->set_relation($this->current_table.'_moduleid','study_module','{study_module_name}');      

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId','study_submodules_lastupdateUserId');

        $this->userCreation_userModification($this->current_table);
           
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);

        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');
                   
        $this->renderitzar($this->current_table,$header_data);  ;
	}

/* FI ENROLLMENT MODULES */

/* ENROLLMENT SUBMODULES */

	public function enrollment_submodules() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment_submodules';

        $this->check_logged_user();
        
        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

		/* Grocery Crud */
		$this->current_table="enrollment_submodules";
        $this->grocery_crud->set_table($this->current_table);
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('enrollment_submodules'));       

        $this->common_callbacks($this->current_table);

        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_periodid',lang('periodid'));
        $this->grocery_crud->display_as($this->current_table.'_personid',lang('personid'));
        $this->grocery_crud->display_as($this->current_table.'_study_id',lang('study_id'));          
        $this->grocery_crud->display_as($this->current_table.'_group_id',lang('group_id'));   
        $this->grocery_crud->display_as($this->current_table.'_moduleid',lang('moduleid'));        		
		$this->grocery_crud->display_as($this->current_table.'_submoduleid',lang('submoduleid'));        		

        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_personid','person','{person_givenName} {person_sn1} {person_sn2}');
        $this->grocery_crud->set_relation($this->current_table.'_study_id','studies','{studies_shortname}');
        $this->grocery_crud->set_relation($this->current_table.'_group_id','classroom_group','{classroom_group_code}');      
        $this->grocery_crud->set_relation($this->current_table.'_moduleid','study_module','{study_module_name}');      
        $this->grocery_crud->set_relation($this->current_table.'_submoduleid','study_submodules','{study_submodules_name}');      

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId','study_submodules_lastupdateUserId');

        $this->userCreation_userModification($this->current_table);
           
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);

        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');
                   
        $this->renderitzar($this->current_table,$header_data);  ;
	}

/* FI ENROLLMENT SUBMODULES */

	private function set_header_data() {

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
            base_url('assets/css/no_padding_top.css'));  


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

function renderitzar($table_name,$header_data)
{
       $output = $this->grocery_crud->render();

       // HTML HEADER
       
       $this->_load_html_header($header_data,$output); 
    
       //      BODY       

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

function set_common_columns_name($table_name){
    $this->grocery_crud->display_as($table_name.'_entryDate',lang('entryDate'));
    $this->grocery_crud->display_as($table_name.'_last_update',lang('last_update'));
    $this->grocery_crud->display_as($table_name.'_creationUserId',lang('creationUserId'));                  
    $this->grocery_crud->display_as($table_name.'_lastupdateUserId',lang('lastupdateUserId'));   
    $this->grocery_crud->display_as($table_name.'_markedForDeletion',lang('markedForDeletion'));       
    $this->grocery_crud->display_as($table_name.'_markedForDeletionDate',lang('markedForDeletionDate')); 
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

        $header_data['menu']= $active_menu;
        return $header_data;
}

}
