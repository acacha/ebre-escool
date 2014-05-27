<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "application/third_party/skeleton/application/controllers/skeleton_main.php";


class inventory extends skeleton_main {

	public $body_header_view ='include/ebre_escool_body_header.php' ;

	public $html_header_view ='/include/ebre_escool_html_header.php';

	public $body_footer_view ='include/ebre_escool_body_footer.php' ;

	public $body_header_lang_file ='ebre_escool_body_header' ;


function __construct()	{


		parent::__construct();

		$this->load->model('inventory_model');

		//GROCERY CRUD
		$this->load->add_package_path(APPPATH.'third_party/grocery-crud/application/');
        $this->load->library('grocery_CRUD');
        $this->load->add_package_path(APPPATH.'third_party/image-crud/application/');
		$this->load->library('image_CRUD');  

        
    	$this->load->library('ebre_escool');


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

public function images(){
	    if (!$this->skeleton_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
		
		$this->image_crud = new image_CRUD();
		
		//CHECK IF USER IS READONLY --> unset upload & delete actions
		$readonly_group = $this->config->item('readonly_group');
		if ($this->skeleton_auth->in_group($readonly_group)) {
			$this->image_crud->unset_upload();
			$this->image_crud->unset_delete();
		}

		$this->current_table = "inventory_images";
	
		$this->image_crud->set_table($this->current_table);
	
		$this->image_crud->set_primary_key_field('imageId');
		$this->image_crud->set_url_field('url');
		$this->image_crud->set_title_field('title');
		$this->image_crud->set_ordering_field('priority');
		$this->image_crud->set_image_path('uploads/inventory_files');
		$this->image_crud->set_relation_field('inventory_objectId');
		
		$this->set_theme($this->grocery_crud);
		$this->set_dialogforms($this->grocery_crud);
		
		$active_menu = array();
	        $active_menu['menu']='#inventory';
	
		/* Ace */
        	$header_data = $this->load_ace_files( $active_menu ); 

	    $this->image_crud_render($this->current_table,$header_data);
	}	

public function inventory_object($organizational_unit="")	{

	$active_menu = array();
	$active_menu['menu']='#inventory';

	$this->check_logged_user();

	/* Ace */
    $header_data = $this->load_ace_files($active_menu);  

	$data = array();

	//ESPECIFIC CUSTOM ACTIONS
    $this->grocery_crud->add_action(lang('Images'),base_url('assets/img/images.png'), '/inventory/images',"images_button");
    $this->grocery_crud->add_action(lang('QRCode'),base_url('assets/img/qr_code.png'), '/inventory/qr/generate',"qr_button");
		
    // Grocery Crud 
    $this->current_table="inventory_object";
    $this->grocery_crud->set_table($this->current_table);
        
    $this->session->set_flashdata('table_name', $this->current_table); 
       
    //Establish subject:
    $this->grocery_crud->set_subject(lang('object_subject'));
                        
    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);

    //ESPECIFIC COLUMNS                                            
    $this->grocery_crud->display_as($this->current_table.'_publicId',lang('publicId'));
    $this->grocery_crud->display_as($this->current_table.'_externalID',lang('externalId')); 
    $this->grocery_crud->display_as($this->current_table.'_externalID1',lang('externalId1')); 
    $this->grocery_crud->display_as($this->current_table.'_externalID2',lang('externalId2')); 
    $this->grocery_crud->display_as($this->current_table.'_externalIDType',lang('externalIDType')); 
	$this->grocery_crud->display_as($this->current_table.'_externalIDType1',lang('externalIDType1')); 
	$this->grocery_crud->display_as($this->current_table.'_externalIDType2',lang('externalIDType2'));     
    $this->grocery_crud->display_as($this->current_table.'_materialId',lang('materialId'));
    $this->grocery_crud->display_as($this->current_table.'_brandId',lang('brandId'));
    $this->grocery_crud->display_as($this->current_table.'_modelId',lang('modelId'));
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
    $this->grocery_crud->display_as($this->current_table.'_description',lang('description'));    
    $this->grocery_crud->display_as($this->current_table.'_manualEntryDate',lang('manualEntryDate'));   
    $this->grocery_crud->display_as($this->current_table.'_parent',lang('inventory_object_parent'));
    $this->grocery_crud->display_as($this->current_table.'_manualLast_update',lang('manual_last_update'));      
    $this->grocery_crud->display_as($this->current_table.'_shortName',lang('shortName'));    
    $this->grocery_crud->display_as($this->current_table.'_location',lang('location'));
    $this->grocery_crud->display_as($this->current_table.'_mainOrganizationalUnitId',lang('main_user_organizational_unit'));
    $this->grocery_crud->display_as($this->current_table.'_quantityInStock',lang('quantityInStock'));
    $this->grocery_crud->display_as($this->current_table.'_price',lang('price'));
    $this->grocery_crud->display_as($this->current_table.'_moneySourceId',lang('moneySourceIdcolumn'));
    $this->grocery_crud->display_as($this->current_table.'_providerId',lang('providerId'));
    $this->grocery_crud->display_as($this->current_table.'_preservationState',lang('preservationState'));                
    $this->grocery_crud->display_as($this->current_table.'_file_url',lang('file_url'));
    $this->grocery_crud->display_as('OwnerOrganizationalUnit',lang('OwnerOrganizationalUnit'));
    $this->grocery_crud->display_as($this->current_table.'_mainOrganizationaUnitId',lang('mainOrganizationaUnitId'));
    $this->grocery_crud->display_as($this->current_table.'_study_id',lang('Study'));
        
        
    //Establish fields/columns order and wich camps to show
    //example: $this->grocery_crud->columns("inventory_objectId","name","shortName");       
    //$this->grocery_crud->columns($this->session->userdata('inventory_object_current_fields_to_show'));       
        
    //Mandatory fields
    $this->grocery_crud->required_fields($this->current_table.'_name',$this->current_table.'_shortName',
    	$this->current_table.'_location',$this->current_table.'_markedForDeletion',$this->current_table.'_quantityInStock',
    	$this->current_table.'_mainOrganizationalUnitId');
    //$this->grocery_crud->required_fields('externalCode','name','shortName','location','markedForDeletion');
        
    //Express fields
    $this->grocery_crud->express_fields($this->current_table.'_name',$this->current_table.'_shortName');

	//Do not show in add form
    $this->grocery_crud->unset_add_fields($this->current_table.'_manualLast_update',$this->current_table.'_last_update');
               
    //ExternalID types
    $this->grocery_crud->set_relation($this->current_table.'_externalIDType','externalIDType','{externalIDType_name}',array('externalIDType_markedForDeletion' => 'n'));
       
    //BRAND RELATION
    $this->grocery_crud->set_relation($this->current_table.'_brandId','brand','{brand_name}',array('brand_markedForDeletion' => 'n'));
        
    //MODEL RELATION
    $this->grocery_crud->set_relation($this->current_table.'_modelId','model','{model_name}',array('model_markedForDeletion' => 'n'));
        
    //MATERIAL RELATION
    $this->grocery_crud->set_relation($this->current_table.'_materialId','material','{material_name}',array('material_markedForDeletion' => 'n'));
        
    //ORGANIZATIONAL UNIT
    $this->grocery_crud->set_relation_n_n('OwnerOrganizationalUnit', 'inventory_object_organizational_unit', 'organizational_unit', 'inventory_objectId','organitzational_unitId', 'organizational_unit_name','priority');
    
    //MAIN ORGANIZATIONAL UNIT
    $this->grocery_crud->set_relation($this->current_table.'_mainOrganizationalUnitId','organizational_unit','{organizational_unit_shortName}',array('organizational_unit_markedForDeletion' => 'n'));
    
    //STUDIES
    $this->grocery_crud->set_relation($this->current_table.'_study_id','studies','{studies_shortname} - {studies_name}',array('studies_markedForDeletion' => 'n'));         
        
    //LOCATION
    $this->grocery_crud->set_relation($this->current_table.'_location','location','{location_name}',array('location_markedForDeletion' => 'n'));
        
    //PROVIDERS
    $this->grocery_crud->set_relation($this->current_table.'_providerId','provider','{provider_name}',array('provider_markedForDeletion' => 'n'));
        
    //MONEYSOURCEID
    $this->grocery_crud->set_relation($this->current_table.'_moneySourceId','moneySource ','{moneySource_name}',array('moneySource_markedForDeletion' => 'n'));
                
    //Validation example. Natural non zero
    $this->grocery_crud->set_rules($this->current_table.'_quantityInStock','Quantitat','is_natural_no_zero');
       	
    //Show current datetime
	//$this->grocery_crud->callback_add_field($this->current_table.'_entryDate',array($this,'add_field_callback_entryDate'));
			
    //RELATION
    //PARENT OBJECT
    $this->grocery_crud->set_relation($this->current_table.'_parent',$this->current_table,$this->current_table.'_name');

    //QUANTITY
    //DEFAULT VALUE=1
	$this->grocery_crud->callback_add_field($this->current_table.'_quantityInStock',array($this,'add_field_callback_quantityInStock'));
	$this->session->set_flashdata('quantityInStock', $this->current_table."_quantityInStock"); 

    //PRICE
    //€ 
 	$this->grocery_crud->callback_column($this->current_table.'_price',array($this,'valueToEuro'));

	//ENTRY DATE
	//DEFAULT VALUE=NOW. ONLY WHEN ADDING
	//EDITING: SHOW CURRENT VALUE READONLY
	$this->grocery_crud->callback_add_field($this->current_table.'_entryDate',array($this,'add_field_callback_entryDate'));
	$this->grocery_crud->callback_edit_field($this->current_table.'_entryDate',array($this,'edit_field_callback_entryDate'));
		
	//LAST UPDATE
	//DEFAULT VALUE=NOW. ONLY WHEN ADDING
	//EDITING: SHOW CURRENT VALUE READONLY
	$this->grocery_crud->callback_add_field($this->current_table.'_last_update',array($this,'add_callback_last_update'));
	$this->grocery_crud->callback_edit_field($this->current_table.'_last_update',array($this,'edit_callback_last_update'));

		//TODO
		//$this->grocery_crud->callback_column('price',array($this,'valueToEuro'));
		$this->grocery_crud->callback_field('Link_Imatges',array($this,'field_callback_Link'));
		
	//UPDATE AUTOMATIC FIELDS
	$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));

	$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
		
    $this->grocery_crud->set_field_upload($this->current_table.'_file_url','uploads/inventory_files');
        
    //USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
    $this->grocery_crud->set_relation($this->current_table.'_creationUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_creationUserId',$this->session->userdata('user_id'));

    //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
    $this->grocery_crud->set_relation($this->current_table.'_lastupdateUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_lastupdateUserId',$this->session->userdata('user_id'));
        
    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");
    
	//DEFAULT VALUES
	//$this->grocery_crud->set_default_value($table_name,"materialId","2");
	$this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_preservationState','Good');
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

	//$this->set_theme($this->grocery_crud);
	$this->grocery_crud->set_theme("datatables");
	$this->set_dialogforms($this->grocery_crud);

	$data= array();
	$organizational_units = array();

	$user_main_organizational_unit = array();
	$selected_organizational_unit = array();
	$selected_organizational_unit_name = "";
	$data['all_organizational_units_text'] = "Totes les unitats organitzatives";
	
	$userid=$this->session->userdata('id');

	$user_main_organizational_unit = $this->inventory_model->getUserMainOrganizationalUnit($userid);

	if ( $organizational_unit != "") {
		if ( $organizational_unit != "All") {
			//echo "$organizational_unit";
			$selected_organizational_unit_name = $this->inventory_model->getUserOrganizationalUnitNameFromId($organizational_unit);
		}	else {
			$selected_organizational_unit_name = $data['all_organizational_units_text'];
		}
		$selected_organizational_unit = array ( $organizational_unit => $selected_organizational_unit_name);
	}

	$user_main_organizational_unit_name = $user_main_organizational_unit->organizational_unit_name;
	$user_main_organizational_unit_id = $user_main_organizational_unit->organizational_unit_Id;

	//TODO: Get values from config file
	$default_user_main_organizational_unit_name = "ERROR. PENDENT DEFINIR DEFAULT";
	$default_user_main_organizational_unit_id = 99; 


	if ($user_main_organizational_unit_name == "" || $user_main_organizational_unit_id == "") {
		$user_main_organizational_unit_name = $default_user_main_organizational_unit_name;
		$user_main_organizational_unit_id = $default_user_main_organizational_unit_id;
	}

	//TODO
	$user_is_admin = $this->ebre_escool->user_is_admin();

	$data['user_is_admin'] = $user_is_admin;

	if ($user_is_admin) {
		$all_organizational_units = $this->inventory_model->getAllorganizationalUnits();
		$organizational_units = $all_organizational_units;
	} else {
		$organizational_units = array ( $user_main_organizational_unit_id => $user_main_organizational_unit_name );
	}
	
	$data['organizational_units'] = $organizational_units;

	if ( $organizational_unit != "" && $user_is_admin) {
		$data['selected_organizational_unit'] = $selected_organizational_unit;
		$data['selected_organizational_unit_key'] = $organizational_unit;
	} else {
		$data['selected_organizational_unit'] = $user_main_organizational_unit_name;	
		$data['selected_organizational_unit_key'] = $user_main_organizational_unit_id;
	}
	

	

	//Providers
	//TODO: Get values from config file
	$data['default_selected_provider_name'] = "Tots" ;
	$data['selected_provider_name'] = "Tots" ;	
	$data['selected_provider_id'] = 0 ;

	$data['providers'] = array();

	if ($user_is_admin) {
		$providers = $this->inventory_model->getAllProviders();
	} else {
		$providers = $this->inventory_model->getAllProvidersByOrganizationalUnit($data['selected_organizational_unit_key']);
	}

	$data['providers'] = $providers;

	$data['default_selected_material_name'] = "Tots";
	$data['selected_material_name'] = "Tots";
	$data['selected_material_id'] = 0;

	$data['materials'] = $this->inventory_model->getAllMaterials();

	$data['default_selected_location_name'] = "Totes";
	$data['selected_location_name'] = "Totes";
	$data['selected_location_id'] = 0;

	$data['locations'] = $this->inventory_model->getAllLocations();

	//Filters
	//Organizational Unit
	//Material
	//location
	//Provider


	//$this->grocery_crud->where('inventory_object_mainOrganizationalUnitId','TODO');
	if ( $data['selected_organizational_unit_key'] != 0 ) {
		$this->grocery_crud->where('inventory_object.inventory_object_mainOrganizationalUnitId', $data['selected_organizational_unit_key']);
	}
	if ( $data['selected_material_id'] !=0 ) {
		$this->grocery_crud->where('inventory_object_materialId', $data['selected_material_id']);
	}
	if ( $data['selected_location_id'] !=0 ) {
		$this->grocery_crud->where('inventory_object_location', $data['selected_location_id']);
	}
	if ( $data['selected_provider_id'] !=0 ) {
		$this->grocery_crud->where('inventory_object_providerId', $data['selected_provider_id']);
	}


	$this->renderitzar($this->current_table,$header_data,$data);
}


public function index()	{

	redirect(base_url('index.php/inventory/inventory_object'), 'refresh');

}
	
 
public function externalIDType()	{

	$active_menu = array();
	$active_menu['menu']='#maintenances';
	$active_menu['submenu1']='#inventory_menu';	
	$active_menu['submenu2']='#externalIDType';

	$this->check_logged_user();

	/* Ace */
    $header_data = $this->load_ace_files($active_menu);  

	// Grocery Crud 
	$this->current_table="externalIDType";
    $this->grocery_crud->set_table($this->current_table);

        
    $this->session->set_flashdata('table_name', $this->current_table); 
        
    //ESTABLISH SUBJECT
    $this->grocery_crud->set_subject(lang('externalIDType'));   
                        
    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);


    $this->common_callbacks($this->current_table);

    //SPECIFIC COLUMNS
    $this->grocery_crud->display_as($this->current_table.'_id',lang('id'));
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
    $this->grocery_crud->display_as($this->current_table.'_shortName',lang('shortName')); 
    $this->grocery_crud->display_as($this->current_table.'_description',lang('description'));
    $this->grocery_crud->display_as($this->current_table.'_barcodeId',lang('barcodeId'));    

	//$this->grocery_crud->set_relation('location_parentLocation','location','{location_shortName} - {location_name}');    
	$this->grocery_crud->set_relation($this->current_table.'_barcodeId','barcode','{barcode_name}');    

    //UPDATE AUTOMATIC FIELDS
	$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
	$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
    
    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
		
    $this->userCreation_userModification($this->current_table);

    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");

    $this->set_theme($this->grocery_crud);
    $this->set_dialogforms($this->grocery_crud);
    
    //Default values:
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data);
	}
	
public function material()	{

	$active_menu = array();
	$active_menu['menu']='#maintenances';
	$active_menu['submenu1']='#inventory_menu';	
	$active_menu['submenu2']='#material_menu';

	$this->check_logged_user();

	/* Ace */
    $header_data = $this->load_ace_files($active_menu);  

	// Grocery Crud 
	$this->current_table="material";
       $this->grocery_crud->set_table($this->current_table);

        
    $this->session->set_flashdata('table_name', $this->current_table); 
        
    //ESTABLISH SUBJECT
    $this->grocery_crud->set_subject(lang('material_subject'));   
                        
    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);

    $this->common_callbacks($this->current_table);

    //SPECIFIC COLUMNS
    $this->grocery_crud->display_as($this->current_table.'_id',lang('id'));
    $this->grocery_crud->display_as($this->current_table.'_internalCode',lang('internalCode'));
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
    $this->grocery_crud->display_as($this->current_table.'_shortName',lang('shortName')); 
    $this->grocery_crud->display_as($this->current_table.'_description',lang('description'));
    $this->grocery_crud->display_as($this->current_table.'_parentMaterialId',lang('parentMaterialId'));    

    $this->grocery_crud->set_relation('material_parentMaterialId','material','material_name');
	//$this->grocery_crud->set_relation('material_id','`material`','`material_shortName`');    

    //UPDATE AUTOMATIC FIELDS
	$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
	$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
    
    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
		
    $this->userCreation_userModification($this->current_table);

    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");

    $this->set_theme($this->grocery_crud);
    $this->set_dialogforms($this->grocery_crud);
    
    //Default values:
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data);
	}

public function brand()	{

	$active_menu = array();
	$active_menu['menu']='#maintenances';
	$active_menu['submenu1']='#inventory_menu';	
	$active_menu['submenu2']='#brand_menu';

	$this->check_logged_user();

	/* Ace */
    $header_data = $this->load_ace_files($active_menu);  

	// Grocery Crud 
	$this->current_table="brand";
       $this->grocery_crud->set_table($this->current_table);

        
    $this->session->set_flashdata('table_name', $this->current_table); 
        
    //ESTABLISH SUBJECT
    $this->grocery_crud->set_subject(lang('brand'));   
                        
    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);

    $this->common_callbacks($this->current_table);

    //SPECIFIC COLUMNS
    $this->grocery_crud->display_as($this->current_table.'_id',lang('id'));
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
    $this->grocery_crud->display_as($this->current_table.'_shortName',lang('shortName')); 
    $this->grocery_crud->display_as($this->current_table.'_description',lang('description'));
    $this->grocery_crud->display_as($this->current_table.'_parentMaterialId',lang('parentMaterialId'));    

	//$this->grocery_crud->set_relation('location_parentLocation','location','{location_shortName} - {location_name}');    

    //UPDATE AUTOMATIC FIELDS
	$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
	$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
    
    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
		
    $this->userCreation_userModification($this->current_table);

    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");

    $this->set_theme($this->grocery_crud);
    $this->set_dialogforms($this->grocery_crud);
    
    //Default values:
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data);
	}

public function model()	{

	$active_menu = array();
	$active_menu['menu']='#maintenances';
	$active_menu['submenu1']='#inventory_menu';	
	$active_menu['submenu2']='#model_menu';

	$this->check_logged_user();

	/* Ace */
    $header_data = $this->load_ace_files($active_menu);  

	// Grocery Crud 
	$this->current_table="model";
       $this->grocery_crud->set_table($this->current_table);

        
    $this->session->set_flashdata('table_name', $this->current_table); 
        
    //ESTABLISH SUBJECT
    $this->grocery_crud->set_subject(lang('model_subject'));   
                        
    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);

    $this->common_callbacks($this->current_table);

    //SPECIFIC COLUMNS
    $this->grocery_crud->display_as($this->current_table.'_id',lang('id'));
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
    $this->grocery_crud->display_as($this->current_table.'_shortName',lang('shortName')); 
    $this->grocery_crud->display_as($this->current_table.'_description',lang('description'));
    $this->grocery_crud->display_as($this->current_table.'_brandId',lang('brandId'));    

	$this->grocery_crud->set_relation('model_brandId','brand','brand_name');    

    //UPDATE AUTOMATIC FIELDS
	$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
	$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
    
    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
		
    $this->userCreation_userModification($this->current_table);

    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");

    $this->set_theme($this->grocery_crud);
    $this->set_dialogforms($this->grocery_crud);
    
    //Default values:
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data);
	}

public function provider()	{

	$active_menu = array();
	$active_menu['menu']='#maintenances';
	$active_menu['submenu1']='#inventory_menu';	
	$active_menu['submenu2']='#provider_menu';

	$this->check_logged_user();

	/* Ace */
    $header_data = $this->load_ace_files($active_menu);  

	// Grocery Crud 
	$this->current_table="provider";
       $this->grocery_crud->set_table($this->current_table);

        
    $this->session->set_flashdata('table_name', $this->current_table); 
        
    //ESTABLISH SUBJECT
    $this->grocery_crud->set_subject(lang('provider_subject'));   
                        
    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);

    $this->common_callbacks($this->current_table);

    //SPECIFIC COLUMNS
    $this->grocery_crud->display_as($this->current_table.'_id',lang('id'));
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
    $this->grocery_crud->display_as($this->current_table.'_shortName',lang('shortName')); 
    $this->grocery_crud->display_as($this->current_table.'_description',lang('description'));

	//$this->grocery_crud->set_relation('location_parentLocation','location','{location_shortName} - {location_name}');    

    //UPDATE AUTOMATIC FIELDS
	$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
	$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
    
    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
		
    $this->userCreation_userModification($this->current_table);

    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");

    $this->set_theme($this->grocery_crud);
    $this->set_dialogforms($this->grocery_crud);
    
    //Default values:
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data);
	}

public function money_source()	{

	$active_menu = array();
	$active_menu['menu']='#maintenances';
	$active_menu['submenu1']='#inventory_menu';	
	$active_menu['submenu2']='#money_source_menu';

	$this->check_logged_user();

	/* Ace */
    $header_data = $this->load_ace_files($active_menu);  

	// Grocery Crud 
	$this->current_table="moneySource";
       $this->grocery_crud->set_table($this->current_table);

        
    $this->session->set_flashdata('table_name', $this->current_table); 
        
    //ESTABLISH SUBJECT
    $this->grocery_crud->set_subject(lang('moneySource_subject'));   
                        
    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);

    $this->common_callbacks($this->current_table);

    //SPECIFIC COLUMNS
    $this->grocery_crud->display_as($this->current_table.'_id',lang('id'));
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
    $this->grocery_crud->display_as($this->current_table.'_shortName',lang('shortName')); 
    $this->grocery_crud->display_as($this->current_table.'_description',lang('description'));

	//$this->grocery_crud->set_relation('location_parentLocation','location','{location_shortName} - {location_name}');    

    //UPDATE AUTOMATIC FIELDS
	$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
	$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
    
    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
		
    $this->userCreation_userModification($this->current_table);

    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");

    $this->set_theme($this->grocery_crud);
    $this->set_dialogforms($this->grocery_crud);
    
    //Default values:
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data);
	}

	
public function barcode()	{

	$active_menu = array();
	$active_menu['menu']='#maintenances';
	$active_menu['submenu1']='#inventory_menu';	
	$active_menu['submenu2']='#barcode_menu';

	$this->check_logged_user();

	/* Ace */
    $header_data = $this->load_ace_files($active_menu);  

	// Grocery Crud 
	$this->current_table="barcode";
       $this->grocery_crud->set_table($this->current_table);

        
    $this->session->set_flashdata('table_name', $this->current_table); 
        
    //ESTABLISH SUBJECT
    $this->grocery_crud->set_subject(lang('barcode_subject'));   
                        
    //COMMON_COLUMNS               
    $this->set_common_columns_name($this->current_table);

    $this->common_callbacks($this->current_table);

    //SPECIFIC COLUMNS
    $this->grocery_crud->display_as($this->current_table.'_id',lang('id'));
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
    $this->grocery_crud->display_as($this->current_table.'_shortName',lang('shortName')); 
    $this->grocery_crud->display_as($this->current_table.'_description',lang('description'));

	//$this->grocery_crud->set_relation('location_parentLocation','location','{location_shortName} - {location_name}');    

    //UPDATE AUTOMATIC FIELDS
	$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
	$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
    
    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
		
    $this->userCreation_userModification($this->current_table);

    $this->grocery_crud->unset_dropdowndetails($this->current_table."_creationUserId",$this->current_table."_lastupdateUserId");

    $this->set_theme($this->grocery_crud);
    $this->set_dialogforms($this->grocery_crud);
    
    //Default values:
    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data);
	}


function image_crud_render($table_name,$header_data)
{
       $output = $this->image_crud->render();

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

protected function _get_html_header_data() {

		$skeleton_css_files=array();
		
		$bootstrap_min=base_url("assets/css/bootstrap.min.css");
		$bootstrap_responsive=base_url("assets/css/bootstrap-responsive.min.css");
		$font_awesome=base_url("assets/css/font-awesome.min.css");
				
		array_push($skeleton_css_files, $bootstrap_min, $bootstrap_responsive,$font_awesome);
		$header_data['skeleton_css_files']=$skeleton_css_files;			
		
		$skeleton_js_files=array();

		$lodash_js="http://cdnjs.cloudflare.com/ajax/libs/lodash.js/1.2.1/lodash.min.js";

		if (defined('ENVIRONMENT') && ENVIRONMENT=="development") {
			$lodash_js= base_url('assets/js/lodash.min.js');	
		}

		//Sergi Tur: 16/03/2014: Need to use jquery-1.10.2.min.js from Grocery Crud it have incorporated Jquery Migrate 1.2.1 
		$jquery_js= base_url('assets/grocery_crud/js/jquery-1.10.2.min.js');
		
		//$lazyload_js=base_url("assets/grocery_crud/js/common/lazyload-min.js");
		$bootstrap_js=base_url("assets/js/bootstrap.min.js");
		
		array_push($skeleton_js_files, $lodash_js ,$jquery_js , $bootstrap_js);
		$header_data['skeleton_js_files']=$skeleton_js_files;	
		
		return $header_data;
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
            base_url('assets/css/select2.css'));  
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/ace.min.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/ace-responsive.min.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/ace-skins.min.css'));              
        
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
                base_url('assets/js/select2.min.js')); 
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ebre-escool.js'));
                  

		$header_data['menu']= $active_menu;        

        return $header_data;
}

public function add_callback_last_update(){  
   
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';
}

public function add_field_callback_entryDate(){  
      $data= date('d/m/Y H:i:s', time());
      return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
}

public function add_field_callback_quantityInStock(){  
      return '<input type="text" maxlength="19" value="1" name="'.$this->session->flashdata('table_name').'_quantityInStock">';    
}

public function edit_field_callback_entryDate($value, $primary_key){  
    //$this->session->flashdata('table_name');
      return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
    }
    
public function edit_callback_last_update($value, $primary_key){ 
    //$this->session->flashdata('table_name'); 
     return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', time()) .'"  name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';
    }    

public function valueToEuro($value, $row)
{
    return $value.' &euro;';
}

//UPDATE AUTOMATIC FIELDS BEFORE INSERT
function before_insert_object_callback($post_array, $primary_key) {
        //UPDATE LAST UPDATE FIELD
        $data= date('d/m/Y H:i:s', time());
        $post_array['entryDate'] = $data;
        $post_array['quantityInStock'] = $this->session->flashdata('quantityInStock');
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

function renderitzar($table_name,$header_data = null, $data=array())
{

	   $state = $this->grocery_crud->getState();
    
       //echo "state: $state <br/>";

       $output = $this->grocery_crud->render();
       
       // HTML HEADER
       
        $this->_load_html_header($header_data,$output); 
        $this->_load_body_header();      
       
       $default_values=$this->_get_default_values();
       $default_values["table_name"]=$table_name;
       $default_values["field_prefix"]=$table_name."_";


       if ($state != "list" ) {
       		$this->load->view('defaultvalues_view.php',$default_values); 	
       }	else {
       		//echo "test";
       }
       

	   //example:
	   //$output->content_view='crud_content_view'; //we add a new attribute called content_view
	   //because our template loads the view content_view for the content.
	   //if we want to pass data, try this.
	   $data['grocery_crud_state']=$state;
	   
	   $output->data=$data;
		
       $this->load->view($table_name.'.php',$output);     
       
       //FOOTER     
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


}
/* End of file inventory.php */
/* Location: ./application/modules/inventory/controllers/inventory.php */