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
        $this->load->model('enrollment_model');
        //$this->load->library('ebre_escool_ldap');
        //$this->config->load('managment');
        $this->config->load('wizard');
        $this->config->load('auth_ldap');

         // Load FPDF
        $this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
        $params = array ('orientation' => 'P', 'unit' => 'mm', 'size' => 'A4', 'font_path' => 'font/');
        $this->load->library('pdf',$params); // Load library

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

    public function enrollment_only_current_period(){
        $valuetoreturn =  $this->enrollment(true);

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment_submodules';

        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

        return $valuetoreturn;
    }



/* ENROLLMENT */

	public function enrollment($only_current_academic_period = false) {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment_only_current_period';

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
        $this->grocery_crud->display_as($this->current_table.'_id',lang('enrollment_id'));
        $this->grocery_crud->display_as($this->current_table.'_periodid',lang('periodid'));
        $this->grocery_crud->display_as($this->current_table.'_personid',lang('personid'));
        $this->grocery_crud->display_as($this->current_table.'_study_id',lang('enrollment_studies'));
        $this->grocery_crud->display_as($this->current_table.'_course_id',lang('enrollment_courses'));
        $this->grocery_crud->display_as($this->current_table.'_group_id',lang('enrollment_classgroups'));


        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_personid','person','{person_sn1} {person_sn2}, {person_givenName} - {person_official_id} ');
        $this->grocery_crud->set_relation($this->current_table.'_study_id','studies','{studies_shortname} - {studies_name}');
        $this->grocery_crud->set_relation($this->current_table.'_course_id','course','{course_shortname} - {course_shortname}');
        $this->grocery_crud->set_relation($this->current_table.'_group_id','classroom_group','{classroom_group_code} -  {classroom_group_name}');

        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));

        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');

        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId','study_submodules_lastupdateUserId');

        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);

        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

        if ($only_current_academic_period) {
            $this->grocery_crud->where($this->current_table.'_periodid','2018-19');
        }

        $this->grocery_crud->columns($this->current_table.'_id',$this->current_table.'_periodid',$this->current_table.'_personid',
            $this->current_table.'_study_id',$this->current_table.'_course_id',$this->current_table.'_group_id',
            $this->current_table.'_entryDate',$this->current_table.'_last_update',$this->current_table.'_creationUserId',
            $this->current_table.'_lastupdateUserId',$this->current_table.'_markedForDeletion',$this->current_table.'_markedForDeletionDate');

        $this->renderitzar($this->current_table,$header_data);

	}

/* FI ENROLLMENT */

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

        ///SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_id',lang('enrollment_id'));
        $this->grocery_crud->display_as($this->current_table.'_moduleid',lang('moduleid'));
        $this->grocery_crud->display_as($this->current_table.'_submoduleid',lang('submoduleid'));

        //RELACIONS
        $this->grocery_crud->set_relation($this->current_table.'_enrollment_id','enrollment','{enrollment_periodid} - {enrollment_personid} - {enrollment_study_id} - {enrollment_course_id} - {enrollment_group_id}');
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

        $this->grocery_crud->columns($this->current_table.'_id',$this->current_table.'_enrollment_id',$this->current_table.'_moduleid',
            $this->current_table.'_submoduleid',$this->current_table.'_entryDate',$this->current_table.'_last_update',
            $this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId',$this->current_table.'_markedForDeletion',
            $this->current_table.'_markedForDeletionDate');

        $this->renderitzar($this->current_table,$header_data);  ;
    }

/* FI ENROLLMENT SUBMODULES */

/* ENROLLMENT STUDIES */

	/*OBSOLET
    public function enrollment_studies() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment_studies';

        $this->check_logged_user();

        //Ace
        $header_data = $this->load_ace_files($active_menu);

		//Grocery Crud
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

 FI ENROLLMENT STUDIES */

/* OBSOLET! ENROLLMENT CLASS GROUP

	public function enrollment_class_group() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment_class_group';

        $this->check_logged_user();

        //Ace
        $header_data = $this->load_ace_files($active_menu);

		// Grocery Crud
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

 FI ENROLLMENT CLASS GROUP */

/* OBSOLET! ENROLLMENT MODULES

	public function enrollment_modules() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#enrollment_menu';
        $active_menu['submenu2']='#enrollment_modules';

        $this->check_logged_user();

        // Ace
        $header_data = $this->load_ace_files($active_menu);

		// Grocery Crud
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



	private function set_header_data() {

		$header_data= $this->add_css_to_html_header_data(
			$this->_get_html_header_data(),
			base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'));
		$header_data= $this->add_css_to_html_header_data(
			$header_data,
			'https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');
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
			"https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");
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

function load_wizard_files($active_menu){

    //CSS
    $header_data= $this->add_css_to_html_header_data(
        $this->_get_html_header_data(),
        "https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");

    $header_data = $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery.gritter.css'));

    $header_data= $this->add_css_to_html_header_data(
        $header_data,
            base_url('assets/css/select2.css'));
    $header_data= $this->add_css_to_html_header_data(
        $header_data,
            base_url('assets/css/modifications_select2.css'));
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
            'https://cdn.datatables.net/1.10.0/css/jquery.dataTables.css');
    $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/datepicker.css'));
    /*
    $header_data= $this->add_css_to_html_header_data(
        $header_data,
        base_url('assets/css/no_padding_top.css'));
    */

    //JS
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        "https://code.jquery.com/jquery-1.9.1.js");
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        "https://code.jquery.com/ui/1.10.3/jquery-ui.js");

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

    /*
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        "https://code.jquery.com/jquery-1.9.1.js");
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        "https://code.jquery.com/ui/1.10.3/jquery-ui.js");
    */

    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/select2.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/jquery.gritter.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/fuelux.spinner.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/bootstrap-editable.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/ace-editable.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/bootstrap.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/fuelux.wizard.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/typeahead-bs2.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/jquery.validate.min.js'));
    /*$header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/jquery.validate.messages_ca.js'));*/
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/bootbox.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/jquery.maskedinput.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/ebre-escool.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        "https://cdn.datatables.net/1.10.0/js/jquery.dataTables.js");
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/bootstrap-datepicker.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/bootstrap-datepicker.ca.js'));
    /*
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/bootstrap-datepicker.es.js'));*/
    /*
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/fuelux.wizard.min.js'));
    */

    $header_data['menu']= $active_menu;

    return $header_data;

}

function load_wizard_files1($active_menu){

    //CSS
    $header_data= $this->add_css_to_html_header_data(
        $this->_get_html_header_data(),
        "https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");

    $header_data = $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery.gritter.css'));

    $header_data= $this->add_css_to_html_header_data(
        $header_data,
            base_url('assets/css/select2.css'));
    $header_data= $this->add_css_to_html_header_data(
        $header_data,
            base_url('assets/css/modifications_select2.css'));
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
            'https://cdn.datatables.net/1.10.0/css/jquery.dataTables.css');
    $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/datepicker.css'));
    /*
    $header_data= $this->add_css_to_html_header_data(
        $header_data,
        base_url('assets/css/no_padding_top.css'));
    */

    //JS
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        "https://code.jquery.com/jquery-1.9.1.js");
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        "https://code.jquery.com/ui/1.10.3/jquery-ui.js");

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

    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/select2.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/jquery.gritter.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/fuelux.spinner.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/bootstrap-editable.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/ace-editable.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/bootstrap.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/typeahead-bs2.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        base_url('assets/js/jquery.maskedinput.min.js'));
    $header_data= $this->add_javascript_to_html_header_data(
        $header_data,
        "https://cdn.datatables.net/1.10.0/js/jquery.dataTables.js");
    $header_data['menu']= $active_menu;

    return $header_data;

}

function load_ace_files($active_menu,$header_data=false){


    //CSS
    if($header_data != false)   {
            $header_data= $this->add_css_to_html_header_data(
            $header_data,
            "https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
    } else {
            $header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            "https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
    }

        $header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            "https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/select2.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/modifications_select2.css'));


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
            "https://code.jquery.com/jquery-1.9.1.js");
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "https://code.jquery.com/ui/1.10.3/jquery-ui.js");

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



public function upload_photo() {

     //please note that the request will fail if you upload a file larger than what is supported by your PHP or Webserver settings

     $ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest';

     $result = array();

     $file = $_FILES['avatar'];
     if(!preg_match('/^image\//' , $file['type'])
        || !preg_match('/\.(jpe?g|gif|png)$/' , $file['name'])
            || getimagesize($file['tmp_name']) === FALSE
        ) {
        $result['status'] = 'ERR';
        $result['message'] = 'Invalid file format!';
     }
     else if($file['size'] > 110000) {
        $result['status'] = 'ERR';
        $result['message'] = 'Please choose a smaller file!';
     }
     else if($file['error'] != 0 || !is_uploaded_file($file['tmp_name'])) {
        $result['status'] = 'ERR';
        $result['message'] = 'Unspecified error!';
     }
     else {

        //$filename = $file['name'];
        $extension = strtolower(preg_replace('/^.*\./', '', $file['name']));
        $base_filename = $_POST['official_id'] . "_" . $_POST['username'];
        $filename = $base_filename . "." . $extension;
        $filename1 = $base_filename . "_" . $file['name'] . "." . $extension;
        $filename_thumb = $base_filename . "_thumb." . $extension;
        $save_path = "/usr/share/ebre-escool/uploads/person_photos/" . $filename;
        $save_path1 = "/usr/share/ebre-escool/uploads/person_photos/" . $filename1;
        $thumb_path = "/usr/share/ebre-escool/uploads/person_photos/" . $filename_thumb;

        //echo "save_path: " . $save_path . "\n";
        //echo "save_path1: " . $save_path1 . "\n";
        //echo "thumb_path: " . $thumb_path . "\n";

        if(
            ! move_uploaded_file($file['tmp_name'] , $save_path)
            OR
            ! copy($save_path, $save_path1)
            OR
            !$this->resize($save_path, $thumb_path, 150)
          )
        {
            $result['status'] = 'ERR';
            $result['message'] = 'Unable to save file!';
        }

        else {
            $result['status'] = 'OK';
            $result['message'] = 'Avatar changed successfully!';
            $result['url'] = base_url('uploads/person_photos') . "/" . $filename_thumb;
            $result['person_photo'] = $filename_thumb;
        }
     }


     $result = json_encode($result);
     if($ajax) {
        echo $result;
     }
     else {
        //for browsers that don't support uploading via ajax,
        //we have used an iframe instead and the response is sent as a script
        echo '<script language="javascript" type="text/javascript">';
        echo 'var iframe = window.top.window.jQuery("#'.$_POST['temporary-iframe-id'].'").data("deferrer").resolve('.$result.');';
        echo '</script>';
     }

}

protected function resize($in_file, $out_file, $new_width, $new_height=FALSE)
{
    $image = null;
    $extension = strtolower(preg_replace('/^.*\./', '', $in_file));
    switch($extension)
    {
        case 'jpg':
        case 'jpeg':
            $image = imagecreatefromjpeg($in_file);
        break;
        case 'png':
            $image = imagecreatefrompng($in_file);
        break;
        case 'gif':
            $image = imagecreatefromgif($in_file);
        break;
    }
    if(!$image || !is_resource($image)) return false;


    $width = imagesx($image);
    $height = imagesy($image);
    if($new_height === FALSE)
    {
        $new_height = (int)(($height * $new_width) / $width);
    }


    $new_image = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    $ret = imagejpeg($new_image, $out_file, 80);

    imagedestroy($new_image);
    imagedestroy($image);

    return $ret;
}

public function get_last_study_id () {

    if(isset($_POST['student_id'])) {
        $person_id = $_POST['student_id'];
    }

    $last_study_id = $this->enrollment_model->get_last_study_id($person_id);

    echo '{
    "aaData": ';

    print_r(json_encode($last_study_id));

    echo '}';
}

public function get_previous_enrollments( $person_official_id = false ) {

    $previous_enrollments = array();

    if ( ! ($person_official_id == false) ) {
        $previous_enrollments = $this->enrollment_model->get_previous_enrollments($person_official_id);
    }


    echo '{
    "aaData": ';

    print_r(json_encode($previous_enrollments));

    echo '}';

}

public function get_simultaneous_studies( $person_official_id = false,$period = false) {

    $simultaneous_studies = array();

    if ( ! ($person_official_id == false) ) {
        if ( ! ($period == false) ) {
            $period_id = $this->enrollment_model->get_academic_period_id_by_period($period);
            $simultaneous_studies = $this->enrollment_model->get_simultaneous_studies($person_official_id,$period_id);
        }
    }


    echo '{
    "aaData": ';

    print_r(json_encode($simultaneous_studies));

    echo '}';

}



public function get_enrollment_study_modules( $enrollment_id = false, $period = false) {

    $study_modules = array();

    if ( ! ($enrollment_id == false) && ! ( $period == false ) ) {
        $study_modules = $this->enrollment_model->get_enrollment_study_modules_by_enrollment_id_and_period($enrollment_id,$period );
    }

    echo '{
    "aaData": ';

    print_r(json_encode($study_modules));

    echo '}';

}

public function get_enrollment_study_submodules( $enrollment_id = false, $period = false ) {

    $study_submodules = array();

    if ( ! ($enrollment_id == false) && ! ( $period == false )) {
        $study_submodules = $this->enrollment_model->get_enrollment_study_submodules_by_enrollment_id_and_period($enrollment_id,$period );
    }


    echo '{
    "aaData": ';

    print_r(json_encode($study_submodules));

    echo '}';

}

    public function wizard_without_modify_person_and_user_data($study=false,$classroom_group=false,$study_modules=false) {

        $this->check_logged_user();

        $user_is_admin = $this->session->userdata('is_admin');
        if (!$user_is_admin) {
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $active_menu = array();
        $active_menu['menu']='#enrollment_wizard';
        $active_menu['submenu1']='#wizard_without_modify_person_and_user_data';

        /* Wizard */
        //$header_data = $this->load_wizard_files();

        /* Ace */
        //$header_data= $this->load_ace_files($active_menu,$header_data);

        $header_data= $this->load_wizard_files($active_menu);

        if($study == false){
            $study = 2;
        }

        if($classroom_group == false){
            $classroom_group = 3;
        }

        if($study_modules == false){
            $study_modules = array();
            $study_modules[]=282;   //  "M1"
            $study_modules[]=268;   //  "M2";
        }

       $this->_load_html_header($header_data);

       $data = array();

       $enrollment_studies = $this->enrollment_model->get_enrollment_studies();
       $localities = $this->enrollment_model->get_localities();

       $all_person_official_ids = $this->enrollment_model->get_all_person_official_ids();

       $data['user_is_admin'] = $user_is_admin;


       $data['all_person_official_ids'] = $all_person_official_ids;

       $data['enrollment_studies'] = $enrollment_studies;
       $data['localities'] = $localities;
       $enrollment_classroom_groups = $this->enrollment_model->get_enrollment_classroom_groups($study);
       $data['enrollment_classroom_groups'] = $enrollment_classroom_groups;
       $enrollment_study_modules = $this->enrollment_model->get_enrollment_study_modules($classroom_group);
       $data['enrollment_study_modules'] = $enrollment_study_modules;
       $enrollment_study_submodules = $this->enrollment_model->get_enrollment_study_submodules($study_modules);
       $data['enrollment_study_submodules'] = $enrollment_study_submodules;
       $enrollment_students = $this->enrollment_model->get_students();
       $data['enrollment_students'] = $enrollment_students;

       // print_r($enrollment_students);

       // BODY
       $this->_load_body_header();
       $this->load->view('wizard_without_modify_person_and_user_data.php',$data);

       // FOOTER
       $this->_load_body_footer();


    }


/* Enrollment Wizzard */

    public function wizard($study=false,$classroom_group=false,$study_modules=false) {

        $this->check_logged_user();

        $user_is_admin = $this->session->userdata('is_admin');

        if (!$user_is_admin) {
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $active_menu = array();
        $active_menu['menu']='#enrollment_wizard';
        $active_menu['submenu1']='#wizard';

        /* Wizard */
        //$header_data = $this->load_wizard_files();

        /* Ace */
        //$header_data= $this->load_ace_files($active_menu,$header_data);

        $header_data= $this->load_wizard_files($active_menu);

        if($study == false){
            $study = 2;
        }

        if($classroom_group == false){
            $classroom_group = 3;
        }

        if($study_modules == false){
            $study_modules = array();
            $study_modules[]=282;   //  "M1"
            $study_modules[]=268;   //  "M2";
        }

       $this->_load_html_header($header_data);

       $data = array();

       $enrollment_studies = $this->enrollment_model->get_enrollment_studies();
       $localities = $this->enrollment_model->get_localities();

       $all_person_official_ids = $this->enrollment_model->get_all_person_official_ids();

       $data['user_is_admin'] = $user_is_admin;

       $data['all_person_official_ids'] = $all_person_official_ids;

       $data['enrollment_studies'] = $enrollment_studies;
       $data['localities'] = $localities;
       $enrollment_classroom_groups = $this->enrollment_model->get_enrollment_classroom_groups($study);
       $data['enrollment_classroom_groups'] = $enrollment_classroom_groups;
       $enrollment_study_modules = $this->enrollment_model->get_enrollment_study_modules($classroom_group);
       $data['enrollment_study_modules'] = $enrollment_study_modules;
       $enrollment_study_submodules = $this->enrollment_model->get_enrollment_study_submodules($study_modules);
       $data['enrollment_study_submodules'] = $enrollment_study_submodules;
       $enrollment_students = $this->enrollment_model->get_students();
       $data['enrollment_students'] = $enrollment_students;

       // print_r($enrollment_students);

       // BODY
       $this->_load_body_header();
       $this->load->view('wizard.php',$data);

       // FOOTER
       $this->_load_body_footer();

    }

    public function change_classroom_group($academic_period_id = null) {

        $active_menu = array();
        $active_menu['menu']='#enrollment_wizard';
        $active_menu['submenu1']='#enrollment_change_classroomgroup';

        $this->check_logged_user();

        if (!$this->session->userdata('is_admin')) {
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        /* Ace */
        $header_data= $this->load_wizard_files1($active_menu);
        $this->_load_html_header($header_data);


        $data = array();

        //$all_person_official_ids = $this->enrollment_model->get_all_person_official_ids();

        //ONLY WITH ENROLLMENT IN CURRENT PERIOD
        if ($academic_period_id == null) {
            $academic_period_id = $this->enrollment_model->get_current_academic_period_id();
        }
        $all_person_official_ids = $this->enrollment_model->get_all_person_official_ids_by_enrollment_period($academic_period_id);

        $data['all_person_official_ids'] = $all_person_official_ids;

        // BODY
        $this->_load_body_header();

        $this->load->view('change_classroom_group.php',$data);

        // FOOTER
        $this->_load_body_footer();

    }

    public function enrollment_delete() {

        $active_menu = array();
        $active_menu['menu']='#enrollment_wizard';
        $active_menu['submenu1']='#enrollment_query_by_person';

        $this->check_logged_user();

        if (!$this->session->userdata('is_admin')) {
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        /* Ace */
        $header_data= $this->load_wizard_files1($active_menu);
        $this->_load_html_header($header_data);


        $data = array();

        $all_person_official_ids = $this->enrollment_model->get_all_person_official_ids();
        $localities = $this->enrollment_model->get_localities();

        $data['all_person_official_ids'] = $all_person_official_ids;
        $data['localities'] = $localities;

        // BODY
        $this->_load_body_header();


        $this->load->view('enrollment_delete.php',$data);
        // FOOTER
        $this->_load_body_footer();

    }



    public function enrollment_modify_person() {

        $active_menu['menu']='#enrollment_wizard';
        $active_menu['submenu1']='#enrollment_modify_person';

        $this->check_logged_user();

        if (!$this->session->userdata('is_admin')) {
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        /* Ace */
        $header_data= $this->load_wizard_files($active_menu);
        $this->_load_html_header($header_data);

        $data = array();

        $all_person_official_ids = $this->enrollment_model->get_all_person_official_ids();
        $localities = $this->enrollment_model->get_localities();

        $data['all_person_official_ids'] = $all_person_official_ids;
        $data['localities'] = $localities;

        // BODY
        $this->_load_body_header();

        $this->load->view('enrollment_modify_person.php',$data);

        // FOOTER
        $this->_load_body_footer();
    }

    public function enrollment_modify($student_official_id = null) {
        $data = array();
        $active_menu = array();

        $active_menu['menu']='#enrollment_wizard';
        $active_menu['submenu1']='#enrollment_modify';

        $data["student_official_id"] = false;

        if ($student_official_id != null ) {
            $data["student_official_id"] = $student_official_id;
        }


        $this->check_logged_user();
        if ( ! $this->session->userdata('is_admin')) {
            echo "Access not allowed!";
            return;
        }

        /* Ace */
        $header_data= $this->load_wizard_files1($active_menu);
        $this->_load_html_header($header_data);


        $all_person_official_ids = $this->enrollment_model->get_all_person_official_ids();
        $localities = $this->enrollment_model->get_localities();

        $data['all_person_official_ids'] = $all_person_official_ids;
        $data['localities'] = $localities;

        // BODY
        $this->_load_body_header();

        $this->load->view('enrollment_modify.php',$data);

        // FOOTER
        $this->_load_body_footer();
    }

    public function enrollment_query_by_person($only_person_data = false, $student_official_id = null) {

        $data = array();
        $active_menu = array();
        if ($only_person_data == false) {
            $active_menu['menu']='#enrollment_wizard';
            $active_menu['submenu1']='#enrollment_query_by_person';
        } else {
            $active_menu['menu']='#maintenances';
            $active_menu['submenu1']='#persons';
            $active_menu['submenu2']='#person_alt';
        }

        $data["student_official_id"] = false;

        if ($student_official_id != null ) {
            $data["student_official_id"] = $student_official_id;
        }


        $this->check_logged_user();

        /* Ace */
        $header_data= $this->load_wizard_files1($active_menu);
        $this->_load_html_header($header_data);




        $all_person_official_ids = $this->enrollment_model->get_all_person_official_ids();
        $localities = $this->enrollment_model->get_localities();

        $data['all_person_official_ids'] = $all_person_official_ids;
        $data['localities'] = $localities;

        // BODY
        $this->_load_body_header();

        if ( $this->session->userdata('is_admin')) {
            $this->load->view('enrollment_query_by_person.php',$data);
        } elseif ( $this->session->userdata('is_teacher')) {
            $this->load->view('enrollment_query_by_person.php',$data);
        } elseif ( $this->session->userdata('is_student'))   {
            $this->load->view('enrollment_query_by_person_for_students.php',$data);
        }
        // FOOTER
        $this->_load_body_footer();
    }

    public function get_study_law($study_id=false){

        $study_id=1;

        if(isset($_POST['study_id'])) {
            $study_id = $_POST['study_id'];
        }

        $study_law = $this->enrollment_model->get_study_law($study_id);
        if($study_law){
            print_r(json_encode($study_law));
        } else {
            return false;
        }

    }

    public function delete_enrollments () {


        $result = "No values especified!";
        if(isset($_POST['values'])) {
            $values = $_POST['values'];
            $result = $this->enrollment_model->delete_enrollments($values);
        }
        echo '{
        "aaData": ';

        print_r(json_encode($result));

        echo '}';


    }

    public function check_enrollment($selected_student=false,$academic_period=false){

        $selected_student=1;
        $academic_period=1;

        if(isset($_POST['selected_student'])) {
            $selected_student = $_POST['selected_student'];
        }

        if(isset($_POST['academic_period'])) {
            $academic_period = $_POST['academic_period'];
        }

        $check_enrollment = $this->enrollment_model->check_enrollment($selected_student,$academic_period);

        if($check_enrollment){
            print_r(json_encode($check_enrollment));
        } else {
            return false;
        }

    }

    public function get_study_type($study_id=false){

        $study_id=1;

        if(isset($_POST['study_id'])) {
            $study_id = $_POST['study_id'];
        }

        $study_type = $this->enrollment_model->get_study_type($study_id);
        if($study_type){
            print_r(json_encode($study_type));
        } else {
            return false;
        }

    }

    public function get_student_enrollment_info($person_id=false, $period_id=false, $enrollment_id=false) {

        if ( ( $enrollment_id != false ) || (isset($_POST['enrollment_id']) && $_POST['enrollment_id'] != "false" ) ) {
            if ( $enrollment_id != false ) {
                $student_enrollment_data = $this->enrollment_model->get_student_enrollment_data_by_enrollment_id($enrollment_id);
            } else {
                $student_enrollment_data = $this->enrollment_model->get_student_enrollment_data_by_enrollment_id($_POST['enrollment_id']);
            }

            if($student_enrollment_data){
                print_r(json_encode($student_enrollment_data));
                return;
            } else {
                return false;
            }
        }

        if($person_id==false){
            if(isset($_POST['person_id'])){
                if($period_id==false){
                    if(isset($_POST['period_id'])) {
                        $person_id = $_POST['person_id'];
                        $period_id = $_POST['period_id'];
                        $student_enrollment_data = $this->enrollment_model->get_student_enrollment_data($person_id,$period_id);
                        if($student_enrollment_data){
                            print_r(json_encode($student_enrollment_data));
                        } else {
                            return false;
                        }
                    }
                    else {
                        return false;
                    }
                } else {
                    $person_id = $_POST['person_id'];
                    $student_enrollment_data = $this->enrollment_model->get_student_enrollment_data($person_id,$period_id);
                    if($student_enrollment_data){
                        print_r(json_encode($student_enrollment_data));
                    } else {
                        return false;
                    }
                }

            } else {
                return false;
            }
        } else {
            if($period_id==false) {
                if(isset($_POST['period_id'])) {
                    $period_id = $_POST['period_id'];
                    $student_enrollment_data = $this->enrollment_model->get_student_enrollment_data($person_id,$period_id);
                    if($student_enrollment_data){
                        print_r(json_encode($student_enrollment_data));
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                $student_enrollment_data = $this->enrollment_model->get_student_enrollment_data($person_id,$period_id);
                if($student_enrollment_data){
                    print_r(json_encode($student_enrollment_data));
                } else {
                    return false;
                }
            }
        }
    }

    public function change_classroom_group_action($enrollment_id=false, $current_group=false, $new_group=false) {
        if($enrollment_id==false) {
            if(isset($_POST['enrollment_id'])){
                $enrollment_id = $_POST['enrollment_id'];
            }
            if(isset($_POST['current_group'])){
                $current_group = $_POST['current_group'];
            }
            if(isset($_POST['new_group'])){
                $new_group = $_POST['new_group'];
            }

            //echo "enrollment_id: " . $enrollment_id ."\n";
            //echo "current_group: " . $current_group ."\n";
            //echo "new_group: " . $new_group ."\n";


            if ( ($enrollment_id != false) && ($current_group != false) && ($new_group != false) ) {
                $result = $this->enrollment_model->change_enrollment_classroom_group($enrollment_id,$current_group,$new_group);
                if ($result) {
                    echo json_encode("Ok");
                } else {
                    echo json_encode("Error updating database!");
                }
            } else {
                echo json_encode("Not enough parameters specified");
            }
        } else {
            if ( ($enrollment_id != false) && ($current_group != false) && ($new_group != false) ) {
                $result = $this->enrollment_model->change_enrollment_classroom_group($enrollment_id,$current_group,$new_group);
                if ($result) {
                    echo json_encode("Ok");
                } else {
                    echo json_encode("Error updating database!");
                }
            } else {
                echo json_encode("Not enough parameters specified");
            }

        }
    }

    public function check_student_change_classroomgroup($person_official_id=false) {

        if($person_official_id==false){
            if(isset($_POST['student_official_id'])){
                $official_id = $_POST['student_official_id'];
                $student_data = $this->enrollment_model->get_student_data_with_enrollment_info($official_id);
                if($student_data){
                    print_r(json_encode($student_data));
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            $official_id = $person_official_id;
            $student_data = $this->enrollment_model->get_student_data_with_enrollment_info($official_id);
            if($student_data){
                print_r(json_encode($student_data));
            } else {

                return false;
            }
        }


    }

    public function get_classroom_groups_from_same_study($current_group=false){

        if($current_group==false){
            if(isset($_POST['current_group'])){
                $current_group = $_POST['current_group'];
                $group_siblings = $this->enrollment_model->get_classroom_groups_from_same_study($current_group);
                if($group_siblings){
                    print_r(json_encode($group_siblings));
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            $group_siblings = $this->enrollment_model->get_classroom_groups_from_same_study($current_group);
            if($group_siblings){
                print_r(json_encode($group_siblings));
            } else {

                return false;
            }
        }

    }


    public function check_student($person_official_id=false) {


        if($person_official_id==false){
            if(isset($_POST['student_official_id'])){
                $official_id = $_POST['student_official_id'];
                $student_data = $this->enrollment_model->get_student_data($official_id);
                if($student_data){
                    print_r(json_encode($student_data));
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            $official_id = $person_official_id;
            $student_data = $this->enrollment_model->get_student_data($official_id);
            if($student_data){
                print_r(json_encode($student_data));
            } else {

                return false;
            }
        }

    }

    public function courses() {

        if(isset($_POST['study_id'])){
            $study_id = $_POST['study_id'];
            $resultat = array();
            $enrollment_courses = $this->enrollment_model->get_enrollment_courses($study_id);
            foreach($enrollment_courses as $key => $value){
                $resultat[$key]=$value;
            }
            print_r(json_encode($resultat));
        } else {
            return false;
        }
    }

    public function get_user_by_username() {

        if(isset($_POST['username'])){
            $username = $_POST['username'];
                $index=1;
                /*
                $user_exists = $this->enrollment_model->get_student_by_username($username);
                if($user_exists){
                    $username = $username . $index;
                }
                echo $username;
                */
                $user_new = $username;
                do{
                    $user_exists = $this->enrollment_model->get_student_by_username($user_new);
                    if($user_exists){
                        $user_new = $username . $index;
                        $index++;
                    }
                }while($user_exists==true);
            echo $user_new;
        } else {
            return false;
        }
    }

    public function generate_password() {

        $length = 10;

        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = array();

        $password['password'] = substr(str_shuffle($chars),0,$length);

        print_r(json_encode($password));
    }

    public function classroom_group() {

        if(isset($_POST['study_id']) && isset($_POST['course_id'])){
            $resultat = array();

            $enrollment_classroom_groups = $this->enrollment_model->get_enrollment_classroom_groups($_POST['study_id'],$_POST['course_id']);
            if (is_array($enrollment_classroom_groups)) {
                foreach($enrollment_classroom_groups as $key => $value){
                    $resultat[$key]=$value;
                }
            }
            print_r(json_encode($resultat));
        } else {
            return false;
        }
    }

    public function study_modules() {

        $course_id = $_POST['course_id'];
        $courses_ids = $_POST['courses_ids'];

        $resultat = array();

        $enrollment_study_modules = $this->enrollment_model->get_enrollment_study_modules($courses_ids,$course_id,"asc","order");

        $courses = array();
        foreach($enrollment_study_modules as $key => $value){
            $resultat[$key]=$value;
            $courses[] = $value['study_module_ap_courses_course_id'];
        }

        $courses = array_unique($courses);
        $res = array();

        foreach ($courses as $course)
        {
            foreach ($enrollment_study_modules as $enrollment_study_module){
                if($enrollment_study_module['study_module_ap_courses_course_id'] == $course){
                    $res[$course][]=$enrollment_study_module;
                }

            }
        }

        //print_r(json_encode($resultat));
        print_r(json_encode($res));

    }

    public function study_modules_by_classroomgroups() {
        //echo $classroom_group;

        $classroom_group = $_POST['classroom_group_id'];
        $classroom_groups = $_POST['classroom_groups'];

        $resultat = array();

        $enrollment_study_modules = $this->enrollment_model->get_enrollment_study_modules($classroom_groups,$classroom_group,"asc","order");

        $grups = array();
        foreach($enrollment_study_modules as $key => $value){
            $resultat[$key]=$value;
            $grups[] = $value['classroom_group_code'];
        }
                $grups = array_unique($grups);
                $res = array();
                foreach ($grups as $grup)
                {
                    foreach ($enrollment_study_modules as $enrollment_study_module){
                        if($enrollment_study_module['classroom_group_code'] == $grup){
                            $res[$grup][]=$enrollment_study_module;
                        }

                    }
                }

        //print_r(json_encode($resultat));
        print_r(json_encode($res));

    }

    public function all_study_submodules_by_study() {

        $study_id = $_POST['study_id'];

        $resultat = array();

        $enrollment_study_submodules = $this->enrollment_model->get_enrollment_all_study_submodules_by_study(
            $study_id,"asc","order");
    //    $enrollment_classroom_groups = $this->enrollment_model->get_enrollment_classroom_groups_from_id($classroom_groups);


            foreach($enrollment_study_submodules as $key => $value){
               $resultat[$key]=$value;
            }
/*
                echo "Grups de classe --><pre>";
                print_r($classroom_groups);
                echo "</pre>";
*/
        print_r(json_encode($resultat));
    }

    public function all_study_submodules_by_modules() {

        $study_module_ids = $_POST['study_module_ids'];

        $course_id = $_POST['course_id'];

        $modules = explode("-",$study_module_ids);

        $resultat = array();

        $enrollment_study_submodules = $this->enrollment_model->get_enrollment_all_study_submodules_by_modules(
            $modules,$course_id,"asc","order");
    //    $enrollment_classroom_groups = $this->enrollment_model->get_enrollment_classroom_groups_from_id($classroom_groups);


            foreach($enrollment_study_submodules as $key => $value){
               $resultat[$key]=$value;
            }
/*
                echo "Grups de classe --><pre>";
                print_r($classroom_groups);
                echo "</pre>";
*/
        print_r(json_encode($resultat));
    }

    public function study_submodules() {

        $modules = $_POST['study_module_ids'];
        $classroom_group_id = $_POST['classroom_group_id'];
        $classroom_groups = $_POST['classroom_groups'];

        $modules = explode("-",$modules);

        $resultat = array();

        $enrollment_study_submodules = $this->enrollment_model->get_enrollment_study_submodules($modules,$classroom_group_id,"asc","order");
    //    $enrollment_classroom_groups = $this->enrollment_model->get_enrollment_classroom_groups_from_id($classroom_groups);


            foreach($enrollment_study_submodules as $key => $value){
               $resultat[$key]=$value;
            }
/*
                echo "Grups de classe --><pre>";
                print_r($classroom_groups);
                echo "</pre>";
*/
        print_r(json_encode($resultat));
    }

    public function enrollment_wizard() {

            $resultat = array();

            $period_id = $_POST['period_id'];
            $person_id = $_POST['person_id'];
            $study_id = $_POST['study_id'];
            $course_id = $_POST['course_id'];
            $classroom_group_id = $_POST['classroom_group_id'];
            $study_module_ids = "";
            if ( isset($_POST['study_module_ids']) ) {
                $study_module_ids = $_POST['study_module_ids'];
            }
            $study_submodules_ids = "";
            if ( isset($_POST['study_submodules_ids']) ) {
                $study_submodules_ids = $_POST['study_submodules_ids'];
            }

            //print_r("prova:" . $_POST['study_submodules_ids']);
            $study_module_ids_array = array();
            if ( $study_module_ids != "") {
                $study_module_ids = explode('-',$study_module_ids);
            }
            $study_submodules_ids_array = array();
            if ( $study_submodules_ids != "") {
                $study_submodules_ids_array = explode('-',$study_submodules_ids);
            }

            //CHECKS:
            //person_id: Integer > 0 . Check person exists?

            if ( !is_numeric($person_id) || ! ($person_id > 0)) {
                $resultat['result_code'] = 201;
                $resultat['result_message'] = "person_id is not numeric or is 0 or negative";
                print_r(json_encode($resultat));
                return false;
            }

            if ( !is_numeric($study_id) || ! ($study_id > 0)) {
                $resultat['result_code'] = 202;
                $resultat['result_message'] = "study_id is not numeric or is 0 or negative";
                print_r(json_encode($resultat));
                return false;
            }

            if ( !is_numeric($course_id) || ! ($course_id > 0)) {
                $resultat['result_code'] = 203;
                $resultat['result_message'] = "course_id is not numeric or is 0 or negative";
                print_r(json_encode($resultat));
                return false;
            }

            if ( !is_numeric($classroom_group_id) || ! ($classroom_group_id > 0)) {
                $resultat['result_code'] = 204;
                $resultat['result_message'] = "classroom_group_id is not numeric or is 0 or negative";
                print_r(json_encode($resultat));
                return false;
            }

            //echo "<script>alert(".print_r($study_module_ids).")</script>";die();
            /*echo "<script>alert(".print_r($study_submodules_ids_array).")</script>";die();*/

            $enrollment = $this->enrollment_model->insert_enrollment($period_id, $person_id, $study_id, $course_id, $classroom_group_id);

            //CHECK IF CORRECT THEN CONTINUE
            if ( $enrollment != false) {
                $enrollment_id  = $this->db->insert_id();
                //WHEN LOGSE SUBMODULES NOT EXISTS! -->
                //TODO LOGSE: study_module_ids is void. Create with study_module_ids and study_submodules_ids to NULL
                //print_r("1 : ".$study_submodules_ids);
                //print_r("2 : ". print_r($study_submodules_ids_array));
                //print_r("3 : ". $study_submodules_ids);
                //print_r("4 : ". print_r($study_submodules_ids_array));
                //echo "Count study_submodules_ids: " . count($study_submodules_ids) . "\n";
                if ( count($study_submodules_ids_array) == 0 )  {
                    //NOT INSERT ANY RECORD TO TABLE enrollment_submodules
                    //LOGSE STUDIES HAVE MODULES BUT NO SUBMODULES
                    /****************************************
                    *****************************
                    // TODO DESPRES ESTIU!!!!!!!!!!!!!!!
                    *****************************************
                    *///////////////
                    //$enrollment_submodules = $this->enrollment_model->insert_enrollment_submodules($enrollment_id, $study_module_ids_array);
                    $enrollment_submodules = array();
                    $resultat['result_code'] = 1;
                    $resultat['result_message'] = "Enrollment done without errors. LOGSE? Any record inserted to enrollment_submodules table";
                    $resultat['enrollment'] = $enrollment;
                    $resultat['enrollment_submodules'] = $enrollment_submodules;
                }   else {
                    $enrollment_submodules = $this->enrollment_model->insert_enrollment_submodules($enrollment_id, $study_submodules_ids_array);
                    if ($enrollment_submodules != false) {
                        $resultat['result_code'] = 0;
                        $resultat['result_message'] = "Enrollment done without errors";
                        $resultat['enrollment'] = $enrollment;
                        $resultat['enrollment_submodules'] = $enrollment_submodules;
                    } else {
                        $resultat['result_code'] = 101;
                            $resultat['result_message'] = "Error inserting enrollment to enrollment_submodules table!";
                        }
                }

            }
            else {
                //ERROR
                $resultat['result_code'] = 100;
                $resultat['result_message'] = "Error inserting enrollment to enrollment table!";
            }

            print_r(json_encode($resultat));

            //OBSOLET
            //$enrollment = $this->enrollment_model->insert_enrollment($period_id, $person_id);
            //$enrollment_studies = $this->enrollment_model->insert_enrollment_studies($period_id, $person_id, $study_id);
            //$enrollment_class_group = $this->enrollment_model->insert_enrollment_class_group($period_id, $person_id, $study_id, $classroom_group_id);

            //$enrollment_modules = $this->enrollment_model->insert_enrollment_modules($period_id, $person_id, $study_id, $classroom_group_id, $study_module_ids);



            /*
            CREATE TABLE IF NOT EXISTS `enrollment` (
              `enrollment_id` int(11) NOT NULL AUTO_INCREMENT,
              `enrollment_periodid` varchar(50) CHARACTER SET utf8 NOT NULL,
              `enrollment_personid` varchar(50) CHARACTER SET utf8 NOT NULL,
              `enrollment_study_id` varchar(50) CHARACTER SET utf8 NOT NULL,
              `enrollment_course_id` int(11) NOT NULL,
              `enrollment_group_id` varchar(50) CHARACTER SET utf8 NOT NULL,
              `enrollment_entryDate` datetime NOT NULL,
              `enrollment_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              `enrollment_creationUserId` int(11) DEFAULT NULL,
              `enrollment_lastupdateUserId` int(11) DEFAULT NULL,
              `enrollment_markedForDeletion` enum('n','y') NOT NULL,
              `enrollment_markedForDeletionDate` datetime NOT NULL,
              PRIMARY KEY (`enrollment_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


            CREATE TABLE IF NOT EXISTS `enrollment_submodules` (
              `enrollment_submodules_id` int(11) NOT NULL AUTO_INCREMENT,
              `enrollment_submodules_enrollment_id` int(11) DEFAULT NULL,
              `enrollment_submodules_moduleid` int(11) DEFAULT NULL,
              `enrollment_submodules_submoduleid` int(11) DEFAULT NULL,
              `enrollment_submodules_entryDate` datetime NOT NULL,
              `enrollment_submodules_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              `enrollment_submodules_creationUserId` int(11) DEFAULT NULL,
              `enrollment_submodules_lastupdateUserId` int(11) DEFAULT NULL,
              `enrollment_submodules_markedForDeletion` enum('n','y') NOT NULL,
              `enrollment_submodules_markedForDeletionDate` datetime NOT NULL,
              PRIMARY KEY (`enrollment_submodules_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
            */
    }

function enrollment_pdf() {

$password = "";

if(isset($_GET['password'])){
    $password = $_GET['password'];
}

$person_id = "";

if(isset($_GET['person_id'])){
    $person_id = $_GET['person_id'];
}

ob_start();

// UNCOMMENT THIS TO ACTIVATE ERROR REPORTING!

error_reporting(E_ALL);
ini_set("display_errors", 1);

//error_reporting(0);
//ini_set("display_errors", 0);
//$old_level_reporting=error_reporting();
//error_reporting(0);


/*
require_once ("../../include/php_setup.inc");
require_once ("functions.inc");
require_once ("../../plugins/admin/HighSchoolUsers/functions.php");
require_once ("/usr/share/php/fpdf/fpdf.php");
*/

/*
session::start();
$config= session::global_get('config');
*/

//*******************************************************************
//**                  CONFIGURATION                                **
//*******************************************************************

//GENERAL CONFIG

//URL LINKS
$rulesURL= $this->config->item('rulesURL');
$servicesURL= $this->config->item('servicesURL');

$HIGHSCHOOLSNAME = $this->config->item('highSchoolName');
$HIGHSCHOOLSUFFIXEMAIL = $this->config->item('highSchoolSuffixEmail');

/////////////////// DO NOT TOUCH WHEN CONFIGURING
//PDF DOCUMENT
// DOCUMENT NAME= externalID_internalID_documentNameSufix
$documentNameSufix= $this->config->item('documentNameSufix');

//WINDOWS HEADER AT PDF DOCUMENT
// TITLE USER FULL NAME
$windowheadertitle= $this->config->item('windowheadertitle');

//IMAGES PATHS
$logo_image= $this->config->item('logo_image');
$signature_image=$this->config->item('signature_image');

//STRINGS
$STR_TITLE= $this->config->item('STR_Title');
$STR_User= $this->config->item('STR_User');
$STR_Password= $this->config->item('STR_Password');
$STR_PersonalEmail= $this->config->item('STR_PersonalEmail');
$STR_Email= $this->config->item('STR_Email');
$STR_UserSignature= $this->config->item('STR_UserSignature');
$STR_SchoolSignature= $this->config->item('STR_SchoolSignature');
$STR_UserPageType= $this->config->item('STR_UserPageType');
$STR_SchoolPageType= $this->config->item('STR_SchoolPageType');
$STR_TutorPageType= $this->config->item('STR_TutorPageType');

$IMPORTANT_NOTE= $this->config->item('IMPORTANT_NOTE');

$LOCALITY_NAME = $this->config->item('Locality');

/////////////////// DO NOT TOUCH WHEN CONFIGURING

if ($password== "") {
    echo "<br/>Fatal Error! No Password provided at query string!";
    exit(1);
}

//Obtain enrollment data.
/*
$enrollment_data=getEnrollmentData($dn);

if ($enrollment_data== "") {
    echo "<br/>Fatal Error! No enrollment data found for DN: " . $dn;
    exit(1);
}*/

$enrollment_data = $this->enrollment_model->getEnrollmentDataforPDF($person_id);

$givenName = $enrollment_data->person_givenName;
$externalID = $enrollment_data->person_official_id;
$personal_email = $enrollment_data->person_secondary_email;
$emailCorporatiu = $enrollment_data->person_email;
$uid = $enrollment_data->username;
$sn1 = $enrollment_data->person_sn1;
$sn2 = $enrollment_data->person_sn2;

//TODO
$academic_period= "2018-19";


/*
$givenName = "Name here";
//$internalID = "Internal ID Here";
//$employeeNumber = "employee number here";
$externalID = "DNI/ID HERE";
$personal_email = "EMAIL HERE";
$emailCorporatiu = "EMAIL CORPORATIU HERE";
$uid = "UID HERE";
$sn1 = "SN1 HERE";
$sn2 = "SN2 HERE";
$academic_period="2014-15";
*/
// Assuming today is March 10th, 2001, 5:16:18 pm, and that we are in the
// Mountain Standard Time (MST) Time Zone
$date= date('j-m-y');
setlocale(LC_TIME, "ca_ES.UTF-8");
$day_of_month = strftime("%e");
$month = strftime("%B");
$year = strftime("%G");
//$date2= strftime("%B");

/////////////////// END DO NOT TOUCH WHEN CONFIGURING

//TEXTS

$text1 = <<<EOF
En/Na $givenName $sn1 $sn2, amb número identificatiu $externalID, ha estat matriculat/da el $date per tal de tenir accés als recursos TIC de l'$HIGHSCHOOLSNAME. Les dades que heu d'utilitzar per accedir als recursos TIC del centre són:
EOF;

$text2 = <<<EOF
En firmar aquesta matrícula esteu acceptant les normes d'ús dels recursos TIC del centre. Les normes les podeu consultar a:


EOF;

$text3 = <<<EOF
Amb el vostre compte d'usuari de centre podeu accedir a una sèrie de serveis que us ofereix el centre i que podeu consultar a:


EOF;

$text4 = <<<EOF
En aquesta pàgina web també podeu trobar les instruccions per tal de modificar la vostra paraula de pas. És important que escolliu una paraula de pas prou segura i que us sigui fàcil de recordar.

IMPORTANT: Si oblideu la vosta paraula de pas, la forma de recuperar-la serà enviar-vos una de nova a la vostra adreça de correu electrònic personal, per tant és molt important que ens proporcioneu una adreça de correu electrònic vàlida.

EOF;

$text5 = <<<EOF
$LOCALITY_NAME, $day_of_month de $month de $year
EOF;


//*******************************************************************
//**                  CONFIGURATION END                            **
//*******************************************************************


//PDF Document Name when downloading:
$documentName=$externalID."_".$academic_period.$documentNameSufix;
$fullName= $givenName ." ". $sn1 . " " . $sn2;

//uncomment when debugging
//exit();

//FPDF needs a clean output --> force:
ob_end_clean();

//CREATE PDF OUPUT:
$pdf = new FPDF('P', 'mm', 'A4','font/');


//DOCUMENT TITLE: Appears at PDF window title
$pdf->SetTitle(utf8_decode($windowheadertitle)." ". utf8_decode($fullName), false);


//CREATE PAGES: Multiple similar pages with some changes

$numPages=3;
$pageTypes=array("user","school","tutor");

$pdf->SetMargins(20, 20, 20);
$pdf->SetLeftMargin(20);

for ($i = 1; $i <= $numPages; $i++) {
    $pdf->AddPage();
    $pdf->SetFont('Times','',18);

    //HEADER IMAGE
    $pdf->Image($logo_image,$pdf->GetX(),$pdf->GetY());

    //TITLE
    $pdf->SetY(45);
    $pdf->Cell(170,10,utf8_decode($STR_TITLE),1,2,'C');

    //TEXT1
    $pdf->SetFont('Times','',10);
    $pdf->Ln();
    $pdf->write(5,utf8_decode($text1));

    //ENROLLMENT DATA
    //USER
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetX($pdf->GetX()+10);
    $pdf->SetFont('Times','B',10);
    $pdf->write(5,"- ". utf8_decode($STR_User).": ",0);
    $pdf->SetFont('Times','',10);
    $pdf->write(5,utf8_decode($uid),0);
    $pdf->Ln();

    $pdf->SetX($pdf->GetX()+10);
    $pdf->SetFont('Times','B',10);
    $pdf->write(5,"- ". utf8_decode($STR_Password).": ",0);
    $pdf->SetFont('Times','',10);
    $pdf->write(5,utf8_decode($password),0);
    $pdf->Ln();

    $pdf->SetX($pdf->GetX()+10);
    $pdf->SetFont('Times','B',10);
    $pdf->write(5,"- ". utf8_decode($STR_PersonalEmail).": ",0);
    $pdf->SetFont('Times','',10);
    $pdf->write(5,utf8_decode($personal_email),0);
    $pdf->Ln();

    $pdf->SetX($pdf->GetX()+10);
    $pdf->SetFont('Times','B',10);
    $pdf->write(5,"- ". utf8_decode($STR_Email).": ",0);
    $pdf->SetFont('Times','',10);
    $pdf->write(5,utf8_decode($emailCorporatiu),0);
    $pdf->Ln();

    //TEXT 2
    $pdf->Ln();
    $pdf->write(5,utf8_decode($text2));

    //RULES URL
    $pdf->SetX($pdf->GetX()+10);
    $pdf->SetFont('Times','B',10);
    $pdf->write(5,utf8_decode($rulesURL));
    $pdf->Ln();
    $pdf->Ln();

    //IMPORTANT NOTE
    $pdf->SetFont('Times','',10);
    $pdf->SetLeftMargin(20+10);
    $pdf->SetRightMargin(20+10);
    $pdf->MultiCell(0,5,utf8_decode($IMPORTANT_NOTE),1,"L");
    $pdf->SetLeftMargin(20);
    $pdf->SetRightMargin(20);
    $pdf->Ln();

    //TEXT3
    $pdf->write(5,utf8_decode($text3));

    //SERVICES URL
    $pdf->SetX($pdf->GetX()+10);
    $pdf->SetFont('Times','B',10);
    $pdf->write(5,utf8_decode($servicesURL));
    $pdf->Ln();
    $pdf->Ln();

    //TEXT 4
    $pdf->SetFont('Times','',10);
    $pdf->write(5,utf8_decode($text4));
    $pdf->Ln();

    //USER_SIGNATURE
    $pdf->SetFont('Times','',10);
    $pdf->write(5,utf8_decode($STR_UserSignature. ","));
    $pdf->Ln();

    //FOOTNOTE
    $pdf->SetY(-50);
    $pdf->SetFont('Times','',10);
    $pdf->write(5,utf8_decode($text5));

    //OFICIAL SIGNATURE
    $pdf->Ln();
    $pdf->Image($signature_image,$pdf->GetX()-3, $pdf->GetY());
    $pdf->write(5,utf8_decode($STR_SchoolSignature),0);

    //TYPE
    $pdf->Ln();
    $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX()+170, $pdf->GetY());
    $pdf->SetX(133);

    switch ($pageTypes[$i-1]) {
        case "user":
            $pdf->write(5,utf8_decode($STR_UserPageType),0);
            break;
        case "school":
            $pdf->write(5,utf8_decode($STR_SchoolPageType),0);
            break;
        case "tutor":
            $pdf->write(5,utf8_decode($STR_TutorPageType),0);
            break;
    }
}

$pdf->Output($documentName,"D");

}

function get_user_data_by_username($username) {
    return $this->get_user_data($username,true);
}

function get_user_data($userid,$user_id_is_username=false) {

    /* Example
    SELECT id, users.person_id, username, password, mainOrganizationaUnitId,ldap_dn, person_givenName,person_sn1,
           person_sn2,person_email,person_secondary_email,person_terciary_email,person_official_id,person_official_id_type,
           person_date_of_birth,person_gender,person_secondary_official_id,person_secondary_official_id_type,
           person_homePostalAddress, person_photo, person_locality_id, person_telephoneNumber, person_mobile
    FROM users
    INNER JOIN person ON users.person_id = person.person_id
    WHERE id = 1
    */

    $this->db->select('id, users.person_id, username, password, mainOrganizationaUnitId,ldap_dn, person_givenName,person_sn1,
           person_sn2,person_email,person_secondary_email,person_terciary_email,person_official_id,person_official_id_type,
           person_date_of_birth,person_gender,person_secondary_official_id,person_secondary_official_id_type,
           person_homePostalAddress, person_photo, person_locality_id,locality_name,postalcode_code, person_telephoneNumber, person_mobile');
    $this->db->from('users');
    $this->db->join('person','users.person_id = person.person_id');
    $this->db->join('locality','locality.locality_id = person.person_locality_id',"left");
    $this->db->join('postalcode','postalcode.postalcode_localityid = locality.locality_id',"left");
    if ($user_id_is_username) {
        $this->db->where('username',$userid);
    } else {
        $this->db->where('id',$userid);
    }

    $this->db->limit(1);

    $query = $this->db->get();

    //echo $this->db->last_query();

    $user_data = new stdClass();
    if ($query->num_rows() == 1){
        $row = $query->row();

        $user_data->id = $row->id;
        $user_data->person_id = $row->person_id;
        $user_data->username = $row->username;
        $user_data->password = $row->password;
        $user_data->ldap_dn = $row->ldap_dn;
        $user_data->person_givenName = $row->person_givenName;
        $user_data->person_sn1 = $row->person_sn1;
        $user_data->person_sn2 = $row->person_sn2;

        $user_data->photo = $row->person_photo;
        $user_data->mobile = $row->person_mobile;
        $user_data->telephoneNumber = $row->person_telephoneNumber;
        //$user_data->st = $row->st;
        $user_data->l = $row->locality_name;
        $user_data->postalCode = $row->postalcode_code;
        $user_data->dateOfBirth = $row->person_date_of_birth;
        $user_data->email = $row->person_secondary_email;
        $user_data->gender = $row->person_gender;
        $user_data->homePostalAddress = $row->person_homePostalAddress;
        $user_data->irisPersonalUniqueID = $row->person_official_id;
        $user_data->irisPersonalUniqueIDType = $row->person_official_id_type;

        $user_data->user_type = 3;

        $user_data->basedn_where_insert_new_ldap_user = $this->config->item('active_students_basedn');

        //echo "user_data->basedn_where_insert_new_ldap_user: " . $user_data->basedn_where_insert_new_ldap_user;

        $user_data->cn = trim($user_data->person_givenName . " " . $user_data->person_sn1 . " " . $user_data->person_sn2);
        $user_data->sn = trim($user_data->person_sn1 . " " . $user_data->person_sn2);
        $user_data->dn = "cn=" . $user_data->cn . ",". $user_data->basedn_where_insert_new_ldap_user;

        return $user_data;
    }
    else
        return false;


}

function insert_update_user() {

    //var_export($_POST);

    $result = false;
    $partial_message ="";
    $inserted_student = "";

    $current_userid = $this->session->userdata("user_id");
    $student = array();
    $user = array();

    $person_id = -1;

    $action = $_POST['action'];

    //var_export($_POST);

    if(isset($_POST['student_person_id'])){
        $person_id = $_POST['student_person_id'];
    }

    //Not to be saved at table persons instead on users table. The existent username field in person table
    //is a temporal one for migration purposes
    //$student['username'] = $_POST['student_username'];
    $user['username'] = $_POST['student_username'];

    $student_generated_password = $_POST['student_generated_password'];
    $student_password = $_POST['student_password'];
    $student_verify_password = $_POST['student_verify_password'];

    $student_not_change_user_data=false;
    if ( isset($_POST['student_not_change_user_data']) ) {
        $student_not_change_user_data = $_POST['student_not_change_user_data'];
    }

    $student['person_official_id'] = $_POST['student_official_id'];
    $student['person_official_id_type'] = $_POST['student_official_id_type'];
    $student['person_secondary_official_id'] = $_POST['student_secondary_official_id'];
    //TSI always code 4 TODO: put harcoded value in config file
    $student['person_secondary_official_id_type'] = 4;

    $student['person_givenName'] = $_POST['student_givenName'];
    $student['person_sn1'] = $_POST['student_sn1'];
    $student['person_sn2'] = $_POST['student_sn2'];

    $student['person_email'] = $_POST['student_username'] . "@iesebre.com";

    $student['person_secondary_email'] = "";
    if ($_POST['student_secondary_email'] != "") {
        $student['person_secondary_email'] = $_POST['student_secondary_email'];
    }


    $student['person_homePostalAddress'] = $_POST['student_homePostalAddress'];

    $student['person_locality_id'] = $_POST['student_locality'];
    //$student['student_postal_code'] = $_POST['student_postal_code'];
    $postalcode = $_POST['student_postal_code'];

    $student['person_telephoneNumber'] = $_POST['student_telephoneNumber'];
    $student['person_mobile'] = $_POST['student_mobile'];

    //CONVERT TO MYSQL FORMAT DATE OF BIRTH DATE
    $date = date('Y-m-d', strtotime($_POST['student_date_of_birth']));

    $student['person_date_of_birth'] = $date;

    $student['person_gender'] = $_POST['student_gender'];

    if (isset($_POST['student_photo']) ) {
        $student['person_photo'] = $_POST['student_photo'];
    }

    $student['person_lastupdateUserId'] = $current_userid;
    $date = date('Y-m-d H:i:s');
    $student['person_last_update'] = $date;
    $student['person_markedForDeletion'] = "n";
    $student['person_markedForDeletionDate'] = "0000-00-00 00:00:00";

    //print_r($student);
    //print_r($user);

    //echo "person_email: " . $student['person_email'] . "\n";
    //echo "person_personal_email: " . $student['person_secondary_email']. "\n";
    //echo "username: " . $user['username'] . "\n";
    //echo "student_generated_password: " . $student_generated_password . "\n";
    //echo "student_password: " . $student_password . "\n";
    //echo "student_verify_password: " . $student_verify_password . "\n";

    //Data validation for update and insert
    //Email: correct format
    if (!filter_var($student['person_email'], FILTER_VALIDATE_EMAIL)) {
        $result_json_object = new stdClass();
        $result_json_object->error = true;
        $result_json_object->message = "Invalid person_email format";
        echo json_encode($result_json_object);
        return false;
    }
    //person_secondary_email is not mandatory! Check if exists!
    if ($student['person_secondary_email'] != "") {

        if (!filter_var($student['person_secondary_email'], FILTER_VALIDATE_EMAIL)) {
            $result_json_object = new stdClass();
            $result_json_object->error = true;
            $result_json_object->message = "Invalid person_personal_email format";
            echo json_encode($result_json_object);
            return false;
        }
    }

    $ldap_password="";
    //echo "action:" . $action;
    if($action=='update'){

        // *********** UPDATE USER

        /* TODO: Eliminar. Crec és un error?
        $updated_password="";
        //ONLY UPDATE PASSWORD IF CHANGED OF IF CONFIGURATION FORCE NEW PASSWORD FOR NEW ENROLLMENTS
        if ($student_password != "") {
            if ($student_password  == $student_verify_password ) {
                $updated_password=$student_password;
            } else {
                echo "Passwords doesn't match\n";
                return false;
            }
        } else {
            $force_new_password_on_every_new_enrollment = $this->config->item('force_new_password_on_every_new_enrollment');
            if ($force_new_password_on_every_new_enrollment == true ) {
                if ($student_generated_password  != "" ) {
                    $updated_password=$student_generated_password;
                } else {
                    echo "Password not especified!\n";
                    return false;
                }
            }
        }
        */

        //Username not changes if action is update
        //FIRST UPDATE TABLE PERSON
        if ($person_id != -1 ) {
            $result = $this->enrollment_model->update_student_data($person_id, $student);
            if ($result) { //UPDATE user table is correct
                $partial_message = "Dades personals canviades correctament!";
                if (!$student_not_change_user_data) {
                    //Check if password is set. Then update users table
                    $new_calculated_md5_password="";
                    if ($student_password != "") {
                        $new_calculated_md5_password = md5($student_password);
                        $ldap_password = $student_password;
                    } else {
                        if ($student_generated_password!=""){
                            $new_calculated_md5_password = md5($student_generated_password);
                            $ldap_password = $student_generated_password;
                            $user['initial_password'] = $student_generated_password;
                            $user['force_change_password_next_login'] = "y";
                        } else {
                            $result_json_object = new stdClass();
                            $result_json_object->error = true;
                            $result_json_object->message = "Error. No password specified!";
                            echo json_encode($result_json_object);
                            return false;
                        }
                    }

                    $user['password'] = $new_calculated_md5_password;
                    $user['last_modification_user'] = $this->session->userdata('user_id');

                    //Last user to modify
                    $result = $this->enrollment_model->update_user_data($user['username'], $user);

                    if (!$result) {
                        $result_json_object = new stdClass();
                        $result_json_object->error = true;
                        $result_json_object->message = "Error updating users table!";
                        echo json_encode($result_json_object);
                        return false;
                    } else {
                        $rows_changed = $this->db->affected_rows();

                        if ($rows_changed == 1) {
                            $partial_message = "User " . $user['username'] . " updated correctly!";
                        }
                        elseif ($rows_changed == 0) {
                            $partial_message = "User " . $user['username'] . " updated correctly. Nothing to change";
                        } else {
                            $result_json_object = new stdClass();
                            $result_json_object->error = true;
                            $result_json_object->message = "ERROR in number of affected rows updating the user!";
                            echo json_encode($result_json_object);
                            return false;
                        }
                    }
                }
            }
        } else {
            $result_json_object = new stdClass();
            $result_json_object->error = true;
            $result_json_object->message = "Person id not specified!";
            echo json_encode($result_json_object);
            return false;
        }

    } else {
        // *********** CREATE NEW USER

        $updated_password="";

        if ($student_password != "") {
            if ($student_password  == $student_verify_password ) {
            $updated_password=$student_password;
            } else {
                $result_json_object = new stdClass();
                $result_json_object->error = true;
                $result_json_object->message = "Passwords doesn't match!";
                echo json_encode($result_json_object);
                return false;
            }
        }
        else { //USE GENERATED PASSWORD IF PASSWORD IS NOT ESPECIFIED
            if ($student_generated_password  != "" ) {
                $updated_password=$student_generated_password;
            } else {
                $result_json_object = new stdClass();
                $result_json_object->error = true;
                $result_json_object->message = "Passwords not especified!";
                echo json_encode($result_json_object);
                return false;
            }
        }


        //Data validation for insert
        //Mandatory fields: person_givenName, person_sn1, person_official_id, person_official_id_type
        if ( $student['person_givenName'] == "" || $student['person_sn1'] == "" | $student['person_official_id'] == "" || $student['person_official_id_type'] == "") {
            $result_json_object = new stdClass();
            $result_json_object->error = true;
            $result_json_object->message = "Some of the mandatory files are not specified!";
            echo json_encode($result_json_object);
            return false;
        }

        $student['person_sn1'] = $_POST['student_sn1'];

        $student['person_creationUserId'] = $current_userid;
        $date = date('Y-m-d H:i:s');
        $student['person_entryDate'] = $date;

        //echo "Student:\n";
        //print_r($student);

        $result = $this->enrollment_model->insert_student_data($student);
        if($result){
            $inserted_student = $result;
            if (!$student_not_change_user_data) {
                $calculated_md5_password = md5($updated_password);
                $ldap_password = $updated_password;
                $user['password'] = $calculated_md5_password;
                //NEW USER: then set initial password and force to change
                $user['initial_password'] = $updated_password;
                $user['force_change_password_next_login'] = "y";
                $user['creation_user'] = $this->session->userdata('user_id');
                $user['last_modification_user'] = $this->session->userdata('user_id');
                $user['person_id'] = $result;
                $user['created_on'] = $date;
                $user['active'] = 1;

                //echo "User:\n";
                //print_r($user);
                $result = $this->enrollment_model->insert_user_data($user);

                if ($result == false) {
                    $result_json_object = new stdClass();
                    $result_json_object->error = true;
                    $result_json_object->message = "Error inserting user data to users table!";
                    echo json_encode($result_json_object);
                    return false;
                }
                $partial_message = "User " . $user['username'] . " inserted correctly!";
            }
        } else {
            $result_json_object = new stdClass();
            $result_json_object->error = true;
            $result_json_object->message = "Error inserting person data to persons table!";
            echo json_encode($result_json_object);
            return false;
        }
    }

    if ($result) {

        //SYNC DATA TO LDAP
        $active_users_basedn = $this->config->item('active_users_basedn','auth_ldap');
        //echo "active_users_basedn: " . $active_users_basedn;
        //GET USER DATA FORM DATABASE
        $user_data = new stdClass();

        $user_data = $this->get_user_data_by_username($user['username']);
        //echo "user name: " . $user_data->username;
        $user_exists=$this->enrollment_model->user_exists($user_data->username,$active_users_basedn);

        $ldap_passwords=false;
        if ($user_exists) {
            //Check if we have to change user data:
            //Username nevers changes: never changes on original MySQL.Nothing to do. ONLY PASSWORD IS IMPORTANT
            if (!$student_not_change_user_data) {
                $user_data->password = $ldap_password;
                $ldap_passwords=false;
            } else {
                //NOT CHANGE LDAP PASSWORD: Recover first the passwords
                $ldap_passwords = $this->enrollment_model->get_ldap_passwords($user_data->username);
            }

            //echo "ldap_passwords: " . var_export($ldap_passwords);
            if ($user_exists === $user_data->dn) {
                $this->enrollment_model->deleteLdapUser($user_data->dn);
            } else {
                //Debug
                //echo "ERROR! DNs not match!<br/>";
                $this->enrollment_model->deleteLdapUser($user_exists);
                $user_data->dn = $user_exists;
            }
        } else {
            $user_data->password = $ldap_password;
            $ldap_passwords=false;
        }

        //echo "user_data->dn : " . $user_data->dn;
        //echo "user_data dn: " . $user_data->dn;
        $result = $this->enrollment_model->addLdapUser($user_data,$ldap_passwords);
        if (!$result) {
            $result_json_object = new stdClass();
            $result_json_object->error = true;
            $result_json_object->message = "Error afegint l'usuari a ldap!";
            echo json_encode($result_json_object);
            return false;
        }
        $this->enrollment_model->update_user_ldap_dn($user_data->username, $user_data->dn);

        $result_json_object = new stdClass();
        $result_json_object->error = false;
        $result_json_object->message = $partial_message . " | " . " Usuari ldap sincronitzat correctament!";
        $result_json_object->inserted_person_id = $inserted_student;
        echo json_encode($result_json_object);
        return true;
    } else {
        $result_json_object = new stdClass();
        $result_json_object->error = true;
        $result_json_object->message = "Error creant o actualitzant les dades d'usuari";
        echo json_encode($result_json_object);
        return false;
    }
    }
}
