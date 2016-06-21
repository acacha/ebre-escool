<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "application/third_party/skeleton/application/controllers/skeleton_main.php";


class inventory_reports extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php' ;

	public $body_header_lang_file ='ebre_escool_body_header' ;

    public $html_header_view ='include/ebre_escool_html_header' ;

    public $body_footer_view ='include/ebre_escool_body_footer' ;   

function __construct()	{
		parent::__construct();

		$this->load->model('inventory_model');
		$this->load->library('session');

		/* Set language */
		$current_language=$this->session->userdata("current_language");
		if ($current_language == "") {
			$current_language= $this->config->item('default_language');
		}
		
		$this->config->load('config');

		$this->lang->load('inventory', $current_language);		
        //LANGUAGE HELPER:
        $this->load->helper('language');
	}	

public function inventory($filter=null)	{
	$this->index($filter);
}

public function index($filter=null)	{

    //Get selected options from URL
    $options = $this->uri->uri_to_assoc(4);
    $selected =array();
    foreach($options as $key=>$value){
        if($value != 'all'){
            $selected[$key] = $value;
        } else {
            $selected[$key] = '';
        }
    }

    // Active menu element 
    $active_menu = array();
    $active_menu['menu']='#reports';
    $active_menu['submenu1']='#inventory_reports';
    $active_menu['submenu2']='#inventory_reports_filters';

    $this->check_logged_user();

	// Ace 
    $header_data = $this->load_ace_files($active_menu);  

    $output = array();   
    
    $all_inventory_objects = array();
    $all_inventory_objects = $this->inventory_model->getAllInventoryObjects();

    // Filter conditions
    $filter = array();
    if(isset($selected['material'])){
        $filter['inventory_object_materialId'] = $selected['material'];
    }
    if(isset($selected['brand'])){
        $filter['inventory_object_brandId'] = $selected['brand'];
    }
    if(isset($selected['model'])){
        $filter['inventory_object_modelId'] = $selected['model'];
    }
    if(isset($selected['money_source'])){
        $filter['inventory_object_moneySourceId'] = $selected['money_source'];
    }
    if(isset($selected['provider'])){
        $filter['inventory_object_providerId'] = $selected['provider'];
    }
    if(isset($selected['creation_user'])){
        $filter['inventory_object_creationUserId'] = $selected['creation_user'];
    }    
    if(isset($selected['modification_user'])){
        $filter['inventory_object_lastupdateUserId'] = $selected['modification_user'];
    }    
    if(isset($selected['organizational_unit'])){
        $filter['inventory_object_mainOrganizationalUnitId'] = $selected['organizational_unit'];
    }
    if(isset($selected['location'])){
        $filter['inventory_object_location'] = $selected['location'];
    }

    // Get all inventory objects
    $all_organizational_units = array();
    $all_organizational_units = $this->inventory_model->getAllorganizationalUnits();    


    // Get only filtered objects from Database
    $filtered_inventory_object = array();
    $filtered_inventory_object = $this->inventory_model->getAllInventoryObjects($filter);

    $all_materials = array();
    $all_materials = $this->inventory_model->getAllMaterials();

    $all_locations = array();
    $all_locations = $this->inventory_model->getAllLocations();    

    $all_brands = array();
    $all_brands = $this->inventory_model->getAllBrands(); 

    $all_models = array();
    $all_models = $this->inventory_model->getAllModels(); 

    $all_providers = array();
    $all_providers = $this->inventory_model->getAllProviders(); 

    $all_users = array();
    $all_users = $this->inventory_model->getAllUsers(); 

    $all_money_sources = array();
    $all_money_sources = $this->inventory_model->getAllMoneySources(); 


    //Aply filters TODO
    // If no element selected from dropdowns show all, else show filtered
    if (count(array_filter($selected)) == 0){
	   $output['inventory_objects'] = $all_inventory_objects;
    } else {
       $output['inventory_objects'] = $filtered_inventory_object;
    }
    
    //echo count(array_filter($selected));
    $output['organizational_units'] = $all_organizational_units;
    $output['materials'] = $all_materials;
    $output['locations'] = $all_locations;
    $output['brands'] = $all_brands;
    $output['models'] = $all_models;
    $output['providers'] = $all_providers;
    $output['users'] = $all_users;
    $output['money_sources'] = $all_money_sources;
    $output['selected'] = $selected;


	$this->_load_html_header($header_data,$output); 
    $this->_load_body_header();      
    
    $this->load->view('inventory_reports.php',$output);     
       
    $this->_load_body_footer();  
                
}
	
function load_ace_files($active_menu){

	$header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
/*
	$header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));  
*/ 
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/ColReorder/media/css/ColReorder.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/ColVis/media/css/ColVis.css'));
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
                "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");        


        //JS
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "https://code.jquery.com/jquery-1.11.0.min.js");
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/jquery-migrate-1.2.1.min.js");
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/ui/1.10.3/jquery-ui.js");  
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/js/jquery.dataTables.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/jquery.dataTables.bootstrap.js'));
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
                base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/ColReorder/media/js/ColReorder.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/grocery_crud/themes/datatables/extras/ColVis/media/js/ColVis.min.js')); 
        $header_data= $this->add_javascript_to_html_header_data(
                $header_data,
                "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");


        $header_data['menu']= $active_menu;
        return $header_data; 
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

}
/* End of file inventory_reports.php */
/* Location: ./application/modules/inventory/controllers/inventory_reports.php */