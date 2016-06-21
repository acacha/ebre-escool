<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";


class students extends skeleton_main {
	
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
		    $this->lang->load('students', $current_language);	       

        //LANGUAGE HELPER:
        $this->load->helper('language');
	}

	public function student() {
		
        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#persons';
        $active_menu['submenu2']='#students';

        $header_data= $this->load_ace_template($active_menu);    

        $table_name="student";
        $this->session->set_flashdata('table_name', $table_name.'_');    
        $this->grocery_crud->set_table($table_name);  
        
	    //Establish subject:
        $this->grocery_crud->set_subject(lang('students'));



        //RELATIONS
        $this->grocery_crud->set_relation('student_person_id','person','{person_sn1} {person_sn2},{person_givenName} ({person_official_id}) - {person_id} '); 
        
        //$this->grocery_crud->unset_dropdowndetails("person_official_id_type");
        
        //$this->grocery_crud->columns('person_id','person_sn1','person_sn2','person_givenName','person_official_id','person_homePostalAddress','person_locality_id','person_email','person_telephoneNumber','person_mobile','person_gender','person_bank_account_id');

        /*$this->grocery_crud->add_fields('person_official_id_type','person_official_id','person_sn1','person_sn2','person_givenName','person_email','person_homePostalAddress','person_gender',
        	'person_locality_id','person_telephoneNumber','person_mobile','person_date_of_birth','person_bank_account_id','person_notes','person_entryDate','person_creationUserId',
        	'person_markedForDeletion','person_markedForDeletionDate');

        $this->grocery_crud->edit_fields('person_official_id_type','person_official_id','person_sn1','person_sn2','person_givenName','person_email','person_homePostalAddress','person_gender',
        	'person_locality_id','person_telephoneNumber','person_mobile','person_date_of_birth','person_bank_account_id','person_notes','person_entryDate','person_last_update','person_creationUserId',
        	'person_lastupdateUserId','person_markedForDeletion','person_markedForDeletionDate');

        $this->grocery_crud->unset_dropdowndetails("person_official_id_type");
        */

        //COLUMN NAMES
        $this->grocery_crud->display_as('student_person_id',lang('student_person_id'));          
        $this->grocery_crud->display_as('student_code',lang('student_code'));  
        $this->grocery_crud->display_as('student_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as('student_last_update',lang('last_update'));
        $this->grocery_crud->display_as('student_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as('student_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as('student_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as('student_markedForDeletionDate',lang('markedForDeletionDate'));              

        //$this->grocery_crud->display_as('person_id',lang('person_id'));
       	//$this->grocery_crud->display_as('person_givenName',lang('person_givenName'));       
       	//$this->grocery_crud->display_as('person_sn1',lang('person_sn1'));       
       	
        //DEFAULT VALUES

        $this->grocery_crud->set_default_value($table_name,'student_markedForDeletion','n');
        //$this->grocery_crud->set_default_value($table_name,'student_creationUserId','TODO');
        //$this->grocery_crud->set_default_value($table_name,'person_markedForDeletion','n');

        //CALLBACKS
//-->
    //Camps last update no editable i automàtic  
        $this->grocery_crud->callback_add_field($table_name.'_entryDate',array($this,'add_field_callback_entryDate')); 
        //$this->grocery_crud->callback_add_field($table_name.'_last_update',array($this,'add_field_callback_last_update'));     
        $this->grocery_crud->callback_edit_field($table_name.'_entryDate',array($this,'edit_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field($table_name.'_last_update',array($this,'edit_callback_last_update'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_last_update'));
//<--        
        //$this->grocery_crud->callback_add_field('student_entryDate',array($this,'add_field_callback_entryDate'));
        //$this->grocery_crud->callback_edit_field('student_entryDate',array($this,'edit_field_callback_entryDate'));

       	//$this->grocery_crud->set_rules('person_official_id',lang('person_official_id'),'callback_valida_nif_cif_nie['.$this->input->post('person_official_id_type').']');
        //$this->grocery_crud->set_rules('person_email',lang('person_email'),'valid_email');
       	
        //USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('student_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($table_name,'student_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('student_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($table_name,'student_lastupdateUserId',$this->session->userdata('user_id'));
        
        $this->grocery_crud->unset_dropdowndetails("student_creationUserId","student_lastupdateUserId");

        //Action
        $this->grocery_crud->add_action('Smileys', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', '','',array($this,'show_photo'));

        $output = $this->grocery_crud->render();
		
        $this->_load_html_header($header_data,$output); 
        $this->_load_body_header();

            $default_values=$this->_get_default_values();
            $default_values["table_name"]=$table_name;
            $default_values["field_prefix"]="student_";
            $this->load->view('defaultvalues_view.php',$default_values); 

		    $this->load->view('students',$output); 
                
		    $this->_load_body_footer();	 
	}

//-->
public function show_photo($primary_key, $row){

    return site_url('students/photo').'/'.$row->student_code;

}
public function photo(){

 $header_data= $this->load_ace_template();  

    $image_crud = new image_CRUD();
    $image_crud->set_table('prova');
    $image_crud->set_primary_key_field('id');
    $image_crud->set_url_field('url');
    $image_crud->set_relation_field('codi');
    $image_crud->set_image_path('assets/img/alumnes');

    $output = $image_crud->render();
        $this->_load_html_header($header_data,$output); 
        $this->_load_body_header();  
    $this->load->view('photo.php',$output);
    $this->_load_body_footer();   

}
/*
function _example_output($output = null)
{
    $this->_load_html_header($this->_get_html_header_data(),$output); 
    $this->_load_body_header();    
    $this->load->view('photo.php',$output);
    $this->_load_body_footer();      
}
*/
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
		$this->student();
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
