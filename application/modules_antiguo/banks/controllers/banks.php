<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";


class banks extends skeleton_main {
	
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
		$this->load->add_package_path(APPPATH.'third_party/skeleton/application/');


		$current_language=$this->session->userdata("current_language");
		if ($current_language == "") {
			$current_language= $this->config->item('default_language');
		}

		$this->lang->load('banks', $current_language);

		$this->load->library('skeleton_auth');
	}
	
	
	public function index() {
		$this->bank();
	}

	//UPDATE AUTOMATIC FIELDS BEFORE INSERT
    function before_insert_object_callback($post_array, $primary_key) {
		//UPDATE LAST UPDATE FIELD
		$data= date('d/m/Y H:i:s', time());
		$post_array['bank_account_last_update'] = $data;
		$post_array['bank_account_entryDate'] = $data;
		
		$user_id=$this->session->userdata('user_id');
		$post_array['bank_account_creationUserId'] = $user_id;
		$post_array['bank_account_lastupdateUserId'] = $user_id;
		
		return $post_array;
    }

    //UPDATE AUTOMATIC FIELDS BEFORE INSERT
    function before_insert_user_preference_callback($post_array, $primary_key) {
		//UPDATE LAST UPDATE FIELD
		$data= date('d/m/Y H:i:s', time());
		$post_array['bank_account_last_update'] = $data;
		$post_array['bank_account_entryDate'] = $data;
		
		$user_id=$this->session->userdata('user_id');
		$post_array['userId'] = $user_id;
		$post_array['bank_account_creationUserId'] = $user_id;
		$post_array['bank_account_lastupdateUserId'] = $user_id;
		
		
		return $post_array;
    }

    //UPDATE AUTOMATIC FIELDS BEFORE UPDATE
    function before_update_object_callback($post_array, $primary_key) {
		//UPDATE LAST UPDATE FIELD
		$data= date('d/m/Y H:i:s', time());
		$post_array['bank_account_last_update'] = $data;
		
		$post_array['bank_account_lastupdateUserId'] = $this->session->userdata('user_id');
		return $post_array;
	}
    
    //UPDATE AUTOMATIC FIELDS BEFORE UPDATE
    // ONLY CALLED BY USERS NOT ADMINS!
    function before_update_user_preference_callback($post_array, $primary_key) {
		//UPDATE LAST UPDATE FIELD
		$data= date('d/m/Y H:i:s', time());
		$post_array['bank_account_last_update'] = $data;
		
		$user_id=$this->session->userdata('user_id');
		$post_array['userId'] = $user_id;
		$post_array['bank_account_lastupdateUserId'] = $user_id;
		return $post_array;
    }
	
	public function bank_account() {

    $active_menu = array();
    $active_menu['menu']='#maintenances';
    $active_menu['submenu1']='#bank_data'; 
    $active_menu['submenu2']='#bank_account';

    $this->check_logged_user();

    /* Ace */
    $header_data = $this->load_ace_files($active_menu);   

    /* Grocery Crud */
    $this->current_table="bank_account";
    $this->grocery_crud->set_table($this->current_table);
    $this->session->set_flashdata('table_name', $this->current_table);
    
    //Establish subject:
    $this->grocery_crud->set_subject(lang("bank_account"));

		$this->grocery_crud->columns($this->current_table.'_id',$this->current_table.'_owner_id',$this->current_table.'_type_id',$this->current_table.'_entity_code',
			$this->current_table.'_office_code',$this->current_table.'_control_digit_code',$this->current_table.'_number',$this->current_table.'_entryDate',
			$this->current_table.'_last_update',$this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId',$this->current_table.'_markedForDeletion',
			$this->current_table.'_markedForDeletionDate');

		$this->grocery_crud->add_fields($this->current_table.'_owner_id',$this->current_table.'_type_id',$this->current_table.'_entity_code',
			$this->current_table.'_office_code',$this->current_table.'_control_digit_code',$this->current_table.'_number',$this->current_table.'_entryDate',
			$this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId',$this->current_table.'_markedForDeletion',
			$this->current_table.'_markedForDeletionDate');        

		$this->grocery_crud->edit_fields($this->current_table.'_owner_id',$this->current_table.'_type_id',$this->current_table.'_entity_code',
			$this->current_table.'_office_code',$this->current_table.'_control_digit_code',$this->current_table.'_number',$this->current_table.'_entryDate',
			$this->current_table.'_last_update',$this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId',$this->current_table.'_markedForDeletion',
			$this->current_table.'_markedForDeletionDate');
        
        //COMMON_COLUMNS               
        $this->set_common_columns_name($this->current_table);    

        $this->grocery_crud->display_as($this->current_table.'_id',lang($this->current_table.'_id'));
       	$this->grocery_crud->display_as($this->current_table.'_owner_id',lang($this->current_table.'_owner_id'));       
       	$this->grocery_crud->display_as($this->current_table.'_type_id',lang($this->current_table.'_type_id'));
       	$this->grocery_crud->display_as($this->current_table.'_entity_code',lang($this->current_table.'_entity_code'));
       	$this->grocery_crud->display_as($this->current_table.'_office_code',lang($this->current_table.'_office_code'));
       	$this->grocery_crud->display_as($this->current_table.'_control_digit_code',lang($this->current_table.'_control_digit_code'));
       	$this->grocery_crud->display_as($this->current_table.'_number',lang($this->current_table.'_number'));
       	$this->grocery_crud->display_as($this->current_table.'_type_id',lang($this->current_table.'_type_id'));
       	$this->grocery_crud->display_as($this->current_table.'_num_persona',lang($this->current_table.'_num_persona'));

  		$this->grocery_crud->unset_dropdowndetails("bank_account_type_id");

  		//Mandatory fields
        //$this->grocery_crud->required_fields('name','shortName','location','markedForDeletion');
        //$this->grocery_crud->required_fields('externalCode','name','shortName','location','markedForDeletion');
        
        //Express fields
        //$this->grocery_crud->express_fields('name','shortName');


   	    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_type_id',1);
   	    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_entity_code',2100);
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

   	    $complete_ccc=$this->input->post($this->current_table.'_entity_code').$this->input->post($this->current_table.'_office_code').$this->input->post($this->current_table.'_control_digit_code').$this->input->post($this->current_table.'_number');
   	    
   	    // IF ACCOUNT IS CCC
   	    if ($this->input->post($this->current_table.'_type_id') == 1 ) {
   	    	$this->grocery_crud->set_rules($this->current_table.'_number',lang($this->current_table.'_number'),'callback_ccc_valido['. $complete_ccc . ']');	
   	    }
   	    
   	    $this->grocery_crud->set_relation($this->current_table.'_owner_id','person','{person_sn1} {person_sn2},{person_givenName} ({person_official_id}) - {person_id} ');    
    		$this->grocery_crud->set_relation($this->current_table.'_type_id',$this->current_table.'_type','{bank_account_type_name}');
        $this->grocery_crud->set_relation($this->current_table.'_entity_code','bank','{bank_code}-{bank_name}');
        //$this->grocery_crud->set_relation($this->current_table.'_office_code','bank_office','{bank_office_code}-{bank_office_name}');

    $this->common_callbacks($this->current_table);
		
		$admin_group = ($this->config->item('admin_group') == "") ? 'intranet_admin' : $this->config->item('admin_group');
		
		//UPDATE AUTOMATIC FIELDS
		if ($this->skeleton_auth->in_group($admin_group)) {
			$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
			$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
		} else {
			//If not admin user, force UserId always to be the userid of actual user
			$this->grocery_crud->callback_before_insert(array($this,'before_insert_user_preference_callback'));
			$this->grocery_crud->callback_before_update(array($this,'before_update_user_preference_callback'));
		}

    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
    $this->userCreation_userModification($this->current_table);
    $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');

    $this->renderitzar($this->current_table,$header_data);
	}

	public function ccc_valido($field,$ccc)	{
    	//EJEMPLO de $ccc sería el 20770338793100254321
    	$valido = true;
    	
    	$this->form_validation->set_message(__FUNCTION__, lang("bank_account_incorrect") . "(".$ccc.")");

    	///////////////////////////////////////////////////
    	//    Dígito de control de la entidad y sucursal:
    	//Se multiplica cada dígito por su factor de peso
    	///////////////////////////////////////////////////
    	$suma = 0;
    	$suma += $ccc[0] * 4;
    	$suma += $ccc[1] * 8;
    	$suma += $ccc[2] * 5;
    	$suma += $ccc[3] * 10;
    	$suma += $ccc[4] * 9;
    	$suma += $ccc[5] * 7;
	    $suma += $ccc[6] * 3;
    	$suma += $ccc[7] * 6;

    	$division = floor($suma/11);
    	$resto    = $suma - ($division  * 11);
    	$primer_digito_control = 11 - $resto;
    	if($primer_digito_control == 11)
	        $primer_digito_control = 0;

	    if($primer_digito_control == 10)
        	$primer_digito_control = 1;

	    if($primer_digito_control != $ccc[8])
        	$valido = false;

    	///////////////////////////////////////////////////
    	//            Dígito de control de la cuenta:
    	///////////////////////////////////////////////////
    	$suma = 0;
    	$suma += $ccc[10] * 1;
    	$suma += $ccc[11] * 2;
    	$suma += $ccc[12] * 4;
    	$suma += $ccc[13] * 8;
    	$suma += $ccc[14] * 5;
    	$suma += $ccc[15] * 10;
    	$suma += $ccc[16] * 9;
	    $suma += $ccc[17] * 7;
	    $suma += $ccc[18] * 3;
    	$suma += $ccc[19] * 6;

    	$division = floor($suma/11);
    	$resto = $suma-($division  * 11);
    	$segundo_digito_control = 11- $resto;

	    if($segundo_digito_control == 11)
        	$segundo_digito_control = 0;
    	if($segundo_digito_control == 10)
        	$segundo_digito_control = 1;

    	if($segundo_digito_control != $ccc[9])
    	    $valido = false;

    	return $valido;
	}

	
	public function bank() {

    $active_menu = array();
    $active_menu['menu']='#maintenances';
    $active_menu['submenu1']='#bank_data'; 
    $active_menu['submenu2']='#bank';

    $this->check_logged_user();

    /* Ace */
    $header_data = $this->load_ace_files($active_menu);   

    /* Grocery Crud */
    $this->current_table="bank";
    $this->grocery_crud->set_table($this->current_table);
    $this->session->set_flashdata('table_name', $this->current_table);
		
		//Establish subject:
    $this->grocery_crud->set_subject("banc");

    $this->common_callbacks($this->current_table);
        
    //UPDATE AUTOMATIC FIELDS
    $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
    $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));

    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);    

    //SPECIFIC COLUMNS
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));        
    $this->grocery_crud->display_as($this->current_table.'_code',lang($this->current_table.'_code'));


    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
    $this->userCreation_userModification($this->current_table);
    $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');

    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data);

	}				
	
	public function bank_account_type() {

    $active_menu = array();
    $active_menu['menu']='#maintenances';
    $active_menu['submenu1']='#bank_data'; 
    $active_menu['submenu2']='#bank_account_type';

    $this->check_logged_user();

    /* Ace */
    $header_data = $this->load_ace_files($active_menu);   

    /* Grocery Crud */
    $this->current_table="bank_account_type";
    $this->grocery_crud->set_table($this->current_table);
    $this->session->set_flashdata('table_name', $this->current_table);
    
    //Establish subject:
    $this->grocery_crud->set_subject(lang("bank_account_type"));

    $this->common_callbacks($this->current_table);
        
    //UPDATE AUTOMATIC FIELDS
    $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
    $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));

    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);    

    //SPECIFIC COLUMNS
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));        
    $this->grocery_crud->display_as($this->current_table.'_id',lang($this->current_table.'_id'));    


    //RELATIONS
    //$this->grocery_crud->set_relation($this->current_table.'_bank_id','bank','{bank_code}-{bank_name}');


    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
    $this->userCreation_userModification($this->current_table);
    $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');

    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data);

	}
	
	public function bank_office() {

    $active_menu = array();
    $active_menu['menu']='#maintenances';
    $active_menu['submenu1']='#bank_data'; 
    $active_menu['submenu2']='#bank_office';

    $this->check_logged_user();

    /* Ace */
    $header_data = $this->load_ace_files($active_menu);   

    /* Grocery Crud */
    $this->current_table="bank_office";
    $this->grocery_crud->set_table($this->current_table);
    $this->session->set_flashdata('table_name', $this->current_table);
    
    //Establish subject:
    $this->grocery_crud->set_subject(lang("bank_office"));

    $this->common_callbacks($this->current_table);
        
    //UPDATE AUTOMATIC FIELDS
    $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
    $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));

    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);    

    //SPECIFIC COLUMNS
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));        
    $this->grocery_crud->display_as($this->current_table.'_code',lang($this->current_table.'_code'));
    $this->grocery_crud->display_as($this->current_table.'_bank_id',lang($this->current_table.'_bank_id'));    

    //RELATIONS
    $this->grocery_crud->set_relation($this->current_table.'_bank_id','bank','{bank_code}-{bank_name}');


    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
    $this->userCreation_userModification($this->current_table);
    $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');

    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data);

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

        $header_data['menu'] = $active_menu;
        return $header_data;
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
