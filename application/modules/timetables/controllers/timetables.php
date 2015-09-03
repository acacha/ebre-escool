<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class timetables extends skeleton_main {
	
    public $body_header_view ='include/ebre_escool_body_header' ;

    public $body_header_lang_file ='ebre_escool_body_header' ;

    public $html_header_view ='include/ebre_escool_html_header' ;

    public $body_footer_view ='include/ebre_escool_body_footer' ;

    public function load_header_data($active_menu){

              
            // CSS
            $header_data= $this->add_css_to_html_header_data(
                $this->_get_html_header_data(),
                    "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/tribal-timetable.css'));        
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.css");
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    "http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css"); 
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/bootstrap-switch.min.css'));
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/bootstrap.min.extracolours.css'));
            $header_data= $this->add_css_to_html_header_data(
                $header_data,
                    base_url('assets/css/horaris.css'));            

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



            // JAVASCRIPT
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/jquery-1.9.1.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://code.jquery.com/ui/1.10.3/jquery-ui.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/jquery.ba-resize.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-tooltip.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-collapse.js'));                
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal-shared.js'));        
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/tribal-timetable.js'));
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://cdn.jsdelivr.net/select2/3.4.5/select2.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    "http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");
            $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-switch.min.js'));

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

	function __construct()
    {
        parent::__construct();

        $this->load->model('timetables_model');
        $this->config->load('config');

        /* Set language */
        $current_language=$this->session->userdata("current_language");
        if ($current_language == "") {
            $current_language= $this->config->item('default_language','skeleton_auth');
        }
        $this->grocery_crud->set_language($current_language);
        $this->lang->load('skeleton', $current_language);          
        
        $this->lang->load('timetables', $current_language);

        $this->load->helper('language');
        $this->load->helper('url');


	}

    public function allteacherstimetables($teacher_code = null, $academic_period_id = null) {
        $active_menu = array();
        $active_menu['menu']='#timetables';
        $active_menu['submenu1']='#allteacherstimetables';

        if ($academic_period_id == null) {
            $academic_period_id = $this->timetables_model->get_current_academic_period_id();
        }


            $this->check_logged_user();

            $header_data = $this->load_header_data($active_menu);

            $this->_load_html_header($header_data);
            $this->_load_body_header();

            //TODO: select current user (sessions user as default teacher)
            $teacher_id = 0;
            if ($teacher_code == null) {

                    //TODO: set teacher id by session values (current session user)
                    $person_id = $this->session->userdata['person_id'];

                    if($this->session->userdata['is_teacher'] == 1) {
                        $teacher_id = $this->timetables_model->get_teacher_id_from_person_id($person_id);
                    } else {
                        $teacher_id=40;                
                    }
        //            print_r($this->session->userdata);           

                    $teacher_code = $this->timetables_model->get_teacher_code_from_teacher_id($teacher_id);   
            }

            $teacher_id=$this->timetables_model->get_teacher_id_from_teacher_code($teacher_code);//;

            $data["teacher_code"] = $teacher_code;
            $data["teacher_id"] = $teacher_id;

            //$teacher_id=39;
        
            //Load teachers from Model
            $teachers_array = $this->timetables_model->get_all_teachers_ids_and_names("asc",$academic_period_id);
            $data['teachers'] = $teachers_array;

            //TODO: select current user (sessions user as default teacher)
            $data['default_teacher'] = $teacher_code;                           

            /* Get Timeslots */            
            $timeslots = $this->get_time_slots("",$teacher_id);
            foreach($timeslots as $key => $value){
                $data[$key] = $value;
            }

            /* Get All Lective Days */
            $days = $this->timetables_model->getAllLectiveDays();
            $data['days']=$days;

            /* Get All Timetable Lessons For Teacher */
            $lessonsfortimetablebyteacherid = array();
            $lessonsfortimetablebyteacherid = $this->timetables_model->get_all_lessonsfortimetablebyteacherid($teacher_id, $academic_period_id);

            /*
               foreach ($lessonsfortimetablebyteacherid as $key => $value) {
                   # code...
                   echo "key: " . $key . "<br/>";
                   echo "lesson: " . var_export($value) . "<br/>";
               }*/

            if ($lessonsfortimetablebyteacherid != false) {
                $lessonsfortimetablebyteacherid = $this->add_breaks($lessonsfortimetablebyteacherid,$data['first_time_slot_order'],$data['last_time_slot_order']);
            } else {
                $lessonsfortimetablebyteacherid = array();
            }

            $data['lessonsfortimetablebyteacherid']= $lessonsfortimetablebyteacherid;

            /* Get All teacher Study Modules */
            $all_teacher_study_modules = array();
            $all_teacher_study_modules_query = $this->timetables_model->get_all_teacher_study_modules($teacher_id, $academic_period_id);

            if ($all_teacher_study_modules_query != false) {
                $all_teacher_study_modules = $all_teacher_study_modules_query->result();
            }

            $data['all_teacher_study_modules']= $all_teacher_study_modules;

            $group_by_study_modules = $this->getGroupByStudyModules($teacher_id, $academic_period_id);
            $data['group_by_study_modules'] = $group_by_study_modules;

            $data['selected_academic_period_id'] = $academic_period_id;
            $academic_periods = $this->timetables_model->get_all_academic_periods();
            $data['academic_periods'] = $academic_periods;

            $hours = array();

            foreach($all_teacher_study_modules as $module){
                $num_hours = $this->timetables_model->get_module_hours_per_week($module->study_module_id,null,$teacher_id,$academic_period_id);

                $hours[] = $num_hours;

                $num_morning_hours = $this->timetables_model->get_module_morning_hours($module->study_module_id,null,$teacher_id, $academic_period_id);
                $num_hours_morning[] = $num_morning_hours;

                $num_afternoon_hours = $this->timetables_model->get_module_afternoon_hours($module->study_module_id,null,$teacher_id, $academic_period_id);
                $num_hours_afternoon[] = $num_afternoon_hours;
            }

            $data['all_teacher_study_modules_hours_per_week'] = $hours;

            /* Get Week hours */
            $total_week_hours = 0;
            $total_morning_week_hours = 0;
            $total_afternoon_week_hours = 0;

            $total_week_hours = $this->timetables_model->get_real_total_hours_by_teacher_id($teacher_id,$academic_period_id);
            $total_morning_week_hours = $this->timetables_model->get_real_total_morning_hours_by_teacher_id($teacher_id,$academic_period_id);
            $total_afternoon_week_hours = $this->timetables_model->get_real_total_afternoon_hours_by_teacher_id($teacher_id,$academic_period_id);


            $data['total_week_hours'] = $total_week_hours;
            $data['total_morning_week_hours']= $total_morning_week_hours;
            $data['total_afternoon_week_hours']= $total_afternoon_week_hours;

            /* Get StudyModules Colours */
            $study_modules_colours = $this->_assign_colours_to_study_modules($all_teacher_study_modules);
            $data['study_modules_colours']= $study_modules_colours;

            /* Get all teacher groups */
            $all_teacher_groups = array();

            $all_teacher_groups_result = $this->timetables_model->get_all_groups_byteacherid($teacher_id,"asc",$academic_period_id);
            if ($all_teacher_groups_result != false) {
                $all_teacher_groups = $this->timetables_model->get_all_groups_byteacherid($teacher_id,"asc",$academic_period_id);
            }
            $data['all_teacher_groups']= $all_teacher_groups;

            $array_all_teacher_groups_time_slots = array();
            $lessonsfortimetablebygroupid = array();
            $first_time_slot_orderbygroupid = array();
            foreach ($all_teacher_groups as $teacher_group) {
                # code...
                $classroom_group_id = $teacher_group['classroom_group_id'];
                $shift = $this->timetables_model->get_group_shift($classroom_group_id);
                $array_all_teacher_groups_time_slots[$classroom_group_id] = $this->timetables_model->get_time_slots_byShift($shift)->result_array();

                //TODO: Pametritzar time slot orders defineixen mati tarda
                $time_slot_order = $this->time_slot_order($shift);
                $shift_first_time_slot_order = $time_slot_order['first'];
                $shift_last_time_slot_order = $time_slot_order['last'];

                $temp = $this->timetables_model->get_all_lessonsfortimetablebygroupid($classroom_group_id,$academic_period_id);

                $lessonsfortimetablebygroupid[$classroom_group_id] = $this->add_breaks($temp,$shift_first_time_slot_order,$shift_last_time_slot_order);
                $first_time_slot_orderbygroupid[$classroom_group_id] = $shift_first_time_slot_order;
            }

            $data['array_all_teacher_groups_time_slots'] = $array_all_teacher_groups_time_slots;
            $data['lessonsfortimetablebygroupid'] = $lessonsfortimetablebygroupid;
            $data['first_time_slot_orderbygroupid'] = $first_time_slot_orderbygroupid;

            $all_teacher_groups_list = $this->get_teacher_group_list($all_teacher_groups);
            $data['all_teacher_groups_list']= $all_teacher_groups_list;
            $data['all_teacher_groups_count']= count($all_teacher_groups);

            //$all_teacher_study_modules_count = 11;
            $all_teacher_study_modules_count = count($all_teacher_study_modules);

            $data['all_teacher_study_modules_count'] = $all_teacher_study_modules_count;

            $teacher_study_modules_list_result = $this->timetables_model->get_all_teacher_study_modules($teacher_id,$academic_period_id);

            $teacher_study_modules_list = array();
            if ($teacher_study_modules_list_result != false) {
                $teacher_study_modules_list = $teacher_study_modules_list_result->result_array();
            }

            $all_teacher_study_modules_list = $this->get_teacher_study_modules_list($teacher_study_modules_list);
            $data['all_teacher_study_modules_list'] = $all_teacher_study_modules_list;

            $this->load->view('timetables/allteacherstimetables',$data);
            
            $this->_load_body_footer();
    }

    public function allgroupstimetables($classroom_group_id = null) {
        
            $active_menu = array();
            $active_menu['menu']='#timetables';
            $active_menu['submenu1']='#allgroupstimetables';


            $this->check_logged_user();

            $header_data = $this->load_header_data($active_menu);            
            $this->_load_html_header($header_data);
            $this->_load_body_header();

            //Load classroom_groups from Model
            $classroom_groups_array = $this->timetables_model->get_all_classroom_groups_ids_and_names();
            $data['classroom_groups'] = $classroom_groups_array;

            //TODO: Get default group id by User Session? or by config file?
            if ($classroom_group_id == null)
                $classroom_group_id = 25;//$classroom_group_id = 4;
            
            $data['default_classroom_group'] = $classroom_group_id; 

            /* Get Timeslots */  
            $timeslots = $this->get_time_slots(false,false,$classroom_group_id);
            foreach($timeslots as $key => $value){
                $data[$key] = $value;
            }

            /* Get All Lective Days */
            $days = $this->timetables_model->getAllLectiveDays();
            $data['days']=$days;

            /* Lessons For Timetable By Group Id */
            $temp = $this->timetables_model->get_all_lessonsfortimetablebygroupid($classroom_group_id);
            $lessonsfortimetablebygroupid = $this->add_breaks($temp,$data['first_time_slot_order'],$data['last_time_slot_order']);
            $data['lessonsfortimetablebygroupid']= $lessonsfortimetablebygroupid;
            
            /* All Group Study Modules  */
            $all_group_study_modules = $this->timetables_model->get_all_group_study_modules($classroom_group_id)->result();
            $data['all_group_study_modules']= $all_group_study_modules;

            /* Get Week hours */
            
            foreach($all_group_study_modules as $module){
                $num_hours = $this->timetables_model->get_real_module_hours_per_week($module->study_module_id,$classroom_group_id);
                $hours[] = $num_hours;
            }

            $total_week_hours = 0;
            $total_week_hours = $this->timetables_model->get_real_total_hours_by_group_id($classroom_group_id);

            $data['total_week_hours'] = $total_week_hours;
            $data['all_teacher_study_modules_hours_per_week'] = $hours;

            /* Get Modules Colors */
            $study_modules_colours = $this->_assign_colours_to_study_modules($all_group_study_modules);
            $study_modules_alternate_colours = $this->_assign_alternate_colours_to_study_modules($all_group_study_modules);
            $data['study_modules_colours']= $study_modules_colours;
            $data['study_modules_alternate_colours']= $study_modules_alternate_colours;

            $data['group_mentor'] = $this->timetables_model->get_mentor($classroom_group_id);


            $all_group_teachers = array();
            
            $all_group_teachers = $this->timetables_model->get_teachers_list($classroom_group_id);

            $data['all_group_teachers'] = $all_group_teachers;

            $this->load->view('timetables/allgroupstimetables',$data);
            
            $this->_load_body_footer();   
    }
	
	public function mytimetables($compact = "no", $academic_period_id = null) {

            $active_menu = array();
            $active_menu['menu']='#timetables';
            $active_menu['submenu1']='#mytimetables';

            if (!$this->skeleton_auth->logged_in())
            {
                //redirect them to the login page
                redirect($this->skeleton_auth->login_page, 'refresh');
            }

            $this->check_logged_user();

            $header_data = $this->load_header_data($active_menu);
            $this->_load_html_header($header_data);

            $this->_load_body_header();

            $data = array();
            if ($academic_period_id == null) {
                $academic_period_id = $this->timetables_model->get_current_academic_period_id();
            }
            $data['selected_academic_period_id'] = $academic_period_id;
            $academic_periods = $this->timetables_model->get_all_academic_periods();
            $data['academic_periods'] = $academic_periods;

            //TODO: set teacher id by session values (current session user)
            $person_id = $this->session->userdata['person_id'];

            if($this->session->userdata['is_teacher'] == 1) {
                $teacher_id = $this->timetables_model->get_teacher_id_from_person_id($person_id);
            } else {
                $teacher_id=40;                
            }
//            print_r($this->session->userdata);           

            $teacher_code = $this->timetables_model->get_teacher_code_from_teacher_id($teacher_id, $academic_period_id);
            $teacher_full_name = $this->timetables_model->get_teacher_fullname_from_teacher_id($teacher_id);
            $data["teacher_code"] = $teacher_code;
            $data["teacher_id"] = $teacher_id;
            $data["teacher_full_name"] = $teacher_full_name;

            /* Get Timeslots */            
            $timeslots = $this->get_time_slots($compact,$teacher_id);
            foreach($timeslots as $key => $value){
                $data[$key] = $value;
            }

            /* Get All Lective Days */
            $days = $this->timetables_model->getAllLectiveDays();
            $data['days']=$days;

            /* Get All Timetable Lessons For Teacher */
            $lessonsfortimetablebyteacherid = $this->timetables_model->get_all_lessonsfortimetablebyteacherid($teacher_id,$academic_period_id);

            if ($lessonsfortimetablebyteacherid != false ) {
                $lessonsfortimetablebyteacherid = $this->add_breaks($lessonsfortimetablebyteacherid,$data['first_time_slot_order'],$data['last_time_slot_order']);
            } else {
                $lessonsfortimetablebyteacherid = array();
            }

            $data['lessonsfortimetablebyteacherid']= $lessonsfortimetablebyteacherid;

            /* Get All teacher Study Modules */
            $all_teacher_study_modules_prev = $this->timetables_model->get_all_teacher_study_modules($teacher_id,$academic_period_id);


            $all_teacher_study_modules = array();
            if ( $all_teacher_study_modules_prev !=false ) {
                $all_teacher_study_modules = $all_teacher_study_modules_prev->result();
            }

            $data['all_teacher_study_modules']= $all_teacher_study_modules;

            $group_by_study_modules = $this->getGroupByStudyModules($teacher_id, $academic_period_id);
            $data['group_by_study_modules'] = $group_by_study_modules;

            $hours = array();
            foreach($all_teacher_study_modules as $module){
                $num_hours = $this->timetables_model->get_module_hours_per_week($module->study_module_id,null,$teacher_id,$academic_period_id);
                $hours[] = $num_hours;

                $num_morning_hours = $this->timetables_model->get_module_morning_hours($module->study_module_id,null,$teacher_id,$academic_period_id);
                $num_hours_morning[] = $num_morning_hours;

                $num_afternoon_hours = $this->timetables_model->get_module_afternoon_hours($module->study_module_id,null,$teacher_id,$academic_period_id);
                $num_hours_afternoon[] = $num_afternoon_hours;
            }

            $data['all_teacher_study_modules_hours_per_week'] = $hours;

            /* Get Week hours */
            $total_week_hours = 0;
            $total_morning_week_hours = 0;
            $total_afternoon_week_hours = 0;

            $total_week_hours = $this->timetables_model->get_real_total_hours_by_teacher_id($teacher_id,$academic_period_id);
            $total_morning_week_hours = $this->timetables_model->get_real_total_morning_hours_by_teacher_id($teacher_id,$academic_period_id);
            $total_afternoon_week_hours = $this->timetables_model->get_real_total_afternoon_hours_by_teacher_id($teacher_id,$academic_period_id);

            $data['total_week_hours'] = $total_week_hours;
            $data['total_morning_week_hours']= $total_morning_week_hours;
            $data['total_afternoon_week_hours']= $total_afternoon_week_hours;


            /* Get StudyModules Colours */
            $study_modules_colours = $this->_assign_colours_to_study_modules($all_teacher_study_modules);
            $data['study_modules_colours']= $study_modules_colours;

            $data['compact']= $compact;

            /* Get all teacher groups */
            $all_teacher_groups = array();
            $all_teacher_groups = $this->timetables_model->get_all_groups_byteacherid($teacher_id,"asc",$academic_period_id);

            if ($all_teacher_groups == false) {
                $all_teacher_groups = array();
            }
            $data['all_teacher_groups']= $all_teacher_groups;

            $array_all_teacher_groups_time_slots = array();
            $lessonsfortimetablebygroupid = array();
            $first_time_slot_orderbygroupid = array();

            foreach ($all_teacher_groups as $teacher_group) {
                # code...
                $classroom_group_id = $teacher_group['classroom_group_id'];
                $shift = $this->timetables_model->get_group_shift($classroom_group_id);
                $array_all_teacher_groups_time_slots[$classroom_group_id] = $this->timetables_model->get_time_slots_byShift($shift)->result_array();

                //TODO: Parametritzar time slot orders defineixen mati tarda
                $time_slot_order = $this->time_slot_order($shift);
                $shift_first_time_slot_order = $time_slot_order['first'];
                $shift_last_time_slot_order = $time_slot_order['last'];

                $temp = $this->timetables_model->get_all_lessonsfortimetablebygroupid($classroom_group_id,$academic_period_id);
                if ($temp != false) {
                        $lessonsfortimetablebygroupid[$classroom_group_id] = $this->add_breaks($temp,$shift_first_time_slot_order,$shift_last_time_slot_order);
                }

                $first_time_slot_orderbygroupid[$classroom_group_id] = $shift_first_time_slot_order;
            }

            $data['array_all_teacher_groups_time_slots'] = $array_all_teacher_groups_time_slots;
            $data['lessonsfortimetablebygroupid'] = $lessonsfortimetablebygroupid;
            $data['first_time_slot_orderbygroupid'] = $first_time_slot_orderbygroupid;

            $all_teacher_groups_list = $this->get_teacher_group_list($all_teacher_groups);
            $data['all_teacher_groups_list']= $all_teacher_groups_list;
            $data['all_teacher_groups_count']= count($all_teacher_groups);

            //$all_teacher_study_modules_count = 11;
            $all_teacher_study_modules_count = count($all_teacher_study_modules);

            $data['all_teacher_study_modules_count'] = $all_teacher_study_modules_count;

            //$teacher_study_modules_list = $this->timetables_model->get_all_teacher_study_modules($teacher_code)->result_array();
            $teacher_study_modules_list_prev = $this->timetables_model->get_all_teacher_study_modules($teacher_id,$academic_period_id);

            $teacher_study_modules_list = array();
            if ($teacher_study_modules_list_prev != false) {
                $teacher_study_modules_list = $teacher_study_modules_list_prev->result_array();
            }

            $all_teacher_study_modules_list = $this->get_teacher_study_modules_list($teacher_study_modules_list);


            $data['all_teacher_study_modules_list'] = $all_teacher_study_modules_list;

            $this->load->view('timetables/mytimetables',$data);

            $this->_load_body_footer();
    }

    protected function _assign_alternate_colours_to_study_modules($study_modules) {
        $study_modules_alternate_colours = array();
        /*$bootstrap_button_colours = 
            array( 1 => "btn-primary" ,
                   2 => "btn-info"    ,
                   3 => "btn-warning" ,
                   4 => "btn-success" ,
                   5 => "btn-danger"  ,
                   6 => "btn-sadlebrown" ,
                   7 => "btn-purple" ,
                   8 => "btn-gold" ,
                   9 => "btn-palegreen" ,
                   10 => "btn-lightgray" ,
                   11 => "btn-yellow" ,
                   12 => "btn-chocolate",
                   13 => "btn-coral",
                   14 => "btn-olivedrab",
                   15 => "btn-yellowgreen",
                   16 => "btn-mignightblue",
                   17 => "btn-darkred",
                   18 => "btn-crimson",
                   19 => "btn-default",
                   20 => "btn-darkslategray"
                   );*/
            
            $bootstrap_button_colours = 
            array( 1 => "rgba(34,131,197,0.5)" ,
                   2 => "rgba(111,179,224,0.5)"    ,
                   3 => "rgba(255,183,82,0.5)" ,
                   4 => "rgba(135,184,127,0.5)" ,
                   5 => "rgba(209,91,71,0.5)"  ,
                   6 => "rgba(139,69,19,0.5)" ,
                   7 => "rgba(160,32,240,0.5)" ,
                   8 => "rgba(255,215,0,0.5)" ,
                   9 => "rgba(152,251,152,0.5)" ,
                   10 => "rgba(211,211,211,0.5)" ,
                   11 => "rgba(255,255,0,0.5)" ,
                   12 => "rgba(210,105,30,0.5)",
                   13 => "rgba(255,127,80,0.5)",
                   14 => "rgba(107,142,35,0.5)",
                   15 => "rgba(154,205,50,0.5)",
                   16 => "rgba(25,25,112,0.5)",
                   17 => "rgba(139,0,0,0.5)",
                   18 => "rgba(214,105,127,0.5)",
                   19 => "rgba(171,186,195,0.5)",
                   20 => "rgba(47,79,79,0.5)"
                   );

            
        $index=1;
        foreach ($study_modules as $study_module) {
            $study_modules_alternate_colours[$study_module->study_module_id] = $bootstrap_button_colours[$index];
            $index++;
        }
            
        return $study_modules_alternate_colours;
    }            

    protected function _assign_colours_to_study_modules($study_modules) {
        $study_modules_colours = array();
        $bootstrap_button_colours = 
            array( 1 => "btn-primary" ,
                   2 => "btn-info"    ,
                   3 => "btn-warning" ,
                   4 => "btn-success" ,
                   5 => "btn-danger"  ,
                   6 => "btn-sadlebrown" ,
                   7 => "btn-purple" ,
                   8 => "btn-gold" ,
                   9 => "btn-palegreen" ,
                   10 => "btn-lightgray" ,
                   11 => "btn-yellow" ,
                   12 => "btn-chocolate",
                   13 => "btn-coral",
                   14 => "btn-olivedrab",
                   15 => "btn-yellowgreen",
                   16 => "btn-mignightblue",
                   17 => "btn-darkred",
                   18 => "btn-crimson",
                   19 => "btn-default",
                   20 => "btn-darkslategray"
                   );
        $index=1;
        foreach ($study_modules as $study_module) {
            $study_modules_colours[$study_module->study_module_id] = $bootstrap_button_colours[$index];
            $index++;
        }
            
        return $study_modules_colours;
    }

    public function add_breaks($lessons,$first_time_slot_order,$last_time_slot_order) {
        
        $days = $this->timetables_model->getAllLectiveDays();

        //ADD BREAKS
        $not_lective_time_slots_array = $this->timetables_model->getNotLectiveTimeSlots()->result_array();

        foreach ($days as $day) {
            $day_number = $day->day_number;
            //echo $day->day_shortname . " : " . print_r($lessons[$day_number]) . "<br/><br/>";

            if (!array_key_exists ( $day_number , $lessons ))    {
                $day_lessons = array();
            } else {
                $day_lessons = $lessons[$day_number]->lesson_by_day;    
            }
                

            foreach ($not_lective_time_slots_array as $not_lective_time_slot)   {
                $time_slot_start_time = $not_lective_time_slot['time_slot_start_time'];
                
                $lesson_data = new stdClass;
                
                $lesson_data->time_slot_order = $not_lective_time_slot['time_slot_order'];

                if ($first_time_slot_order >= $lesson_data->time_slot_order || $lesson_data->time_slot_order  >= $last_time_slot_order) {
                    continue;
                }

                $lesson_data->time_slot_lective = false;
                $lesson_data->group_shortName ="";
                $lesson_data->group_id = "";
                $lesson_data->study_module_id="";
                $lesson_data->group_code = "";
                $lesson_data->location_code="";
                $lesson_data->location_id="";
                $lesson_data->groups=array();
                
                if ($time_slot_start_time == "14:30") {
                    $lesson_data->study_module_shortname= strtoupper(lang("lunch_break"));
                    $lesson_data->study_module_name= strtoupper(lang("lunch_break"));
                } else {
                    $lesson_data->study_module_shortname= strtoupper(lang("patio_break"));
                    $lesson_data->study_module_name= strtoupper(lang("patio_break"));    
                }
                
                $lesson_data->duration= 1;

                $day_lessons[$time_slot_start_time] = $lesson_data;
            }

            ksort ($day_lessons);

            $lessons[$day_number]->lesson_by_day = $day_lessons;
        }
        
        return $lessons;
    }
	
	public function index() {
		$this->mytimetables();
	}
	
    public function time_slot_order($shift){

        if ($shift == 2) {
            $shift_first_time_slot_order = $this->config->item('afternoon_first_time_slot');//9;
            $shift_last_time_slot_order = $this->config->item('afternoon_last_time_slot');//15;
        }
        else {
            $shift_first_time_slot_order = $this->config->item('morning_first_time_slot');//1;
            $shift_last_time_slot_order = $this->config->item('morning_last_time_slot');//7;
        }
        $time_slot_order['first'] = $shift_first_time_slot_order;
        $time_slot_order['last'] = $shift_last_time_slot_order;
        return $time_slot_order;
    }

    public function get_time_slots($compact,$teacher_id,$classroom_group_id=null)
    {
            $complete_time_slots_array = $this->timetables_model->getAllTimeSlots()->result_array();
            $data['complete_time_slots_count'] = count($complete_time_slots_array);            

            if($classroom_group_id){
                $shift = $this->timetables_model->get_group_shift($classroom_group_id);
                $all_teacher_groups_time_slots[$classroom_group_id] = $this->timetables_model->get_time_slots_byShift($shift)->result_array();
                $time_slots_array = $this->timetables_model->get_time_slots_byShift($shift)->result_array();
            } else {

                //$time_slots_array = $this->get_time_slots_array($compact,$teacher_id);
                if ($compact!="no") {
                    $time_slots_array = $complete_time_slots_array;
                } else {
                    $time_slots_array = $this->timetables_model->getCompactTimeSlotsForTeacher($teacher_id)->result_array();
                }
            }

            $data['time_slots_array'] = $time_slots_array;

            //Get first and last time slot order
            $keys = array_keys($time_slots_array);
            $first_time_slot_order = $time_slots_array[$keys[0]]['time_slot_order'];
            $data['first_time_slot_order'] = $first_time_slot_order;            
            $last_time_slot_order = $time_slots_array[$keys[count($time_slots_array)-1]]['time_slot_order'];
            $data['last_time_slot_order'] = $last_time_slot_order;

            foreach ($time_slots_array as $time_slot)   {
                $time_slot_data = new stdClass;
                $time_slot_data->time_slot_start_time = $time_slot['time_slot_start_time'];
                $time_slot_data->time_interval = $time_slot['time_slot_start_time'] . " - " . $time_slot['time_slot_end_time'];
                $time_slot_data->time_slot_lective = $time_slot['time_slot_lective'];

                $time_slots[$time_slot['time_slot_id']] = $time_slot_data;
            }

            $data['time_slots'] = $time_slots;
            $data['time_slots_count'] = count($time_slots);

            return $data;
    }

    public function get_teacher_group_list($all_teacher_groups)
    {
            $all_teacher_groups_list = array();
            foreach($all_teacher_groups as $teacher_group_list){
                    $all_teacher_groups_list[] = $teacher_group_list['classroom_group_code'];
                }
            return $all_teacher_groups_list;
    }

    public function get_teacher_study_modules_list($teacher_study_modules_list)
    {
            $module_list = array();
            foreach ($teacher_study_modules_list as $mod_list){
                $module_list[] = $mod_list['study_module_shortname'];
            }
            $module_list = array_unique($module_list);

            $all_teacher_study_modules_list = array();
            foreach ($module_list as $study_module_list)
            {
                    $all_teacher_study_modules_list[] = $study_module_list;
            }
            return $all_teacher_study_modules_list;
    }
	
    public function classroom_group_info($id_group){

            $this->check_logged_user();

            $header_data = $this->load_header_data();

            $this->_load_html_header($header_data);
            $this->_load_body_header();     

            $data['id_group'] = $id_group;

            $this->load->view('timetables/groupinfo',$data);

            $this->_load_body_footer();       

    }

    public function study_module_info($id_study_module){

            $this->check_logged_user();

            $header_data = $this->load_header_data();

            $this->_load_html_header($header_data);
            $this->_load_body_header();     

            $data['id_study_module'] = $id_study_module;

            $this->load->view('timetables/studymoduleinfo',$data);

            $this->_load_body_footer();     

    }

    public function location_info($id_location){

            $this->check_logged_user(); 

            $header_data = $this->load_header_data();

            $this->_load_html_header($header_data);
            $this->_load_body_header();     

            $data['id_location'] = $id_location;

            $this->load->view('timetables/locationinfo',$data);

            $this->_load_body_footer(); 

    }        

    public function getGroupByStudyModules($teacher_id,$academic_period_id=null){
            
            $all_teacher_study_modules_prev = $this->timetables_model->get_all_teacher_study_modules($teacher_id,$academic_period_id);

            $all_teacher_study_modules = array();

            if ($all_teacher_study_modules_prev != false) {
                $all_teacher_study_modules = $all_teacher_study_modules_prev->result();
            }
            $data['all_teacher_study_modules']= $all_teacher_study_modules;

            $group_by_study_modules = array();
            for($i=0;$i<count($all_teacher_study_modules);$i++)
            {
                $study_module_id = $all_teacher_study_modules[$i]->study_module_id;
                $group_by_study_modules[$study_module_id] = $this->timetables_model->get_all_group_by_study_module($study_module_id,$teacher_id);                       
            }
            return $group_by_study_modules;
    }

    public function non_lective_hours() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#timetable';
        $active_menu['submenu2']='#non_lective_hours';

        $this->check_logged_user(true); 

        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

        /* Grocery Crud */
        $this->current_table="non_lective_hours";
        $this->grocery_crud->set_table("non_lective_hours");
        $this->session->set_flashdata('table_name', $this->current_table);

        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('non_lective_hours'));          

        //Mandatory fields
        $this->grocery_crud->required_fields($this->current_table.'_name',$this->current_table.'_shortname',$this->current_table.'_markedForDeletion');

        $this->common_callbacks($this->current_table);

        //Express fields
        $this->grocery_crud->express_fields($this->current_table.'_name',$this->current_table.'_shortname');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

         //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_code',lang('code'));
        $this->grocery_crud->display_as($this->current_table.'_description',lang('description'));        
        $this->grocery_crud->display_as($this->current_table.'_shortname',lang('shortName'));
        $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
        $this->grocery_crud->display_as($this->current_table.'_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as($this->current_table.'_last_update',lang('last_update'));
        $this->grocery_crud->display_as($this->current_table.'_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as($this->current_table.'_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as($this->current_table.'_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as($this->current_table.'_markedForDeletionDate',lang('markedForDeletionDate')); 
 
         //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');

        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
       
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

        $this->renderitzar($this->current_table,$header_data);

    }

    public function non_lective_lessons() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#timetable';
        $active_menu['submenu2']='#non_lective_lessons';

        $this->check_logged_user(true); 

        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

        /* Grocery Crud */
        $this->current_table="non_lective_lessons";
        $this->grocery_crud->set_table("non_lective_lessons");
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('non_lective_lessons'));          

        //Mandatory fields
        $this->grocery_crud->required_fields($this->current_table.'_name',$this->current_table.'_shortname',$this->current_table.'_markedForDeletion');

        $this->common_callbacks($this->current_table);

        //Express fields
        $this->grocery_crud->express_fields($this->current_table.'_name',$this->current_table.'_shortname');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

         //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_non_lective_hours_id',lang('non_lective_hours_id'));
        $this->grocery_crud->display_as($this->current_table.'_teacher_id',lang('teacher_id'));  
        $this->grocery_crud->display_as($this->current_table.'_lesson_day',lang('lesson_day'));
        $this->grocery_crud->display_as($this->current_table.'_time_slot_id',lang('time_slot_id'));
        $this->grocery_crud->display_as($this->current_table.'_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as($this->current_table.'_last_update',lang('last_update'));
        $this->grocery_crud->display_as($this->current_table.'_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as($this->current_table.'_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as($this->current_table.'_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as($this->current_table.'_markedForDeletionDate',lang('markedForDeletionDate')); 
 
        $this->grocery_crud->set_relation($this->current_table.'_non_lective_hours_id','non_lective_hours','{non_lective_hours_name}');
        
        /*
        relation n n ($field_name,$relation_table,$selection_table,$primary_key_alias_to_this_table,$primary_key_alias_to_selection_table,
        $title_field_selection_table,[$priority_field_relation])
        */
        //$this->grocery_crud->set_relation_n_n($this->current_table.'_teacher_id', 'teacher', 'person', 'teacher_code', 'teacher_person_id', '{person_givenName} {person_sn1} {person_sn2}');

        $this->grocery_crud->set_relation($this->current_table.'_teacher_id','teacher','{teacher_id} ({teacher_code})');
        $this->grocery_crud->set_relation($this->current_table.'_time_slot_id','time_slot','{time_slot_start_time} - {time_slot_end_time}');

         //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //markedForDeletion
        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

        $this->renderitzar($this->current_table,$header_data);

    }


    public function shift() {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#timetable';
        $active_menu['submenu2']='#shift';

        $this->check_logged_user(true); 

        /* Ace */
        $header_data = $this->load_ace_files($active_menu);

        /* Grocery Crud */
        $this->current_table="shift";
        $this->grocery_crud->set_table("shift");
        $this->session->set_flashdata('table_name', $this->current_table);
        
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('shift'));          

        //Mandatory fields
        $this->grocery_crud->required_fields($this->current_table.'_name',$this->current_table.'_markedForDeletion');

        $this->common_callbacks($this->current_table);

        //Express fields
        $this->grocery_crud->express_fields($this->current_table.'_name');

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

         //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));
        $this->grocery_crud->display_as($this->current_table.'_entryDate',lang('entryDate'));        
        $this->grocery_crud->display_as($this->current_table.'_last_update',lang('last_update'));
        $this->grocery_crud->display_as($this->current_table.'_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as($this->current_table.'_lastupdateUserId',lang('lastupdateUserId'));          
        $this->grocery_crud->display_as($this->current_table.'_markedForDeletion',lang('markedForDeletion'));   
        $this->grocery_crud->display_as($this->current_table.'_markedForDeletionDate',lang('markedForDeletionDate')); 
 
         //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');
   
        $this->set_theme($this->grocery_crud);
        $this->set_dialogforms($this->grocery_crud);
        
        //markedForDeletion
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

function check_logged_user($is_grocery = null)
{
    if (!$this->skeleton_auth->logged_in())
    {
        //redirect them to the login page
        redirect($this->skeleton_auth->login_page, 'refresh');
    }

    if($is_grocery){
        //CHECK IF USER IS READONLY --> unset add, edit & delete actions
        $readonly_group = $this->config->item('readonly_group');
        if ($this->skeleton_auth->in_group($readonly_group)) {
            $this->grocery_crud->unset_add();
            $this->grocery_crud->unset_edit();
            $this->grocery_crud->unset_delete();
        }
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

function renderitzar($table_name,$header_data=false)
{
       $output = $this->grocery_crud->render();

       // HTML HEADER
       if($header_data){
            $this->_load_html_header($header_data,$output); 
       } else {
            $this->_load_html_header($this->_get_html_header_data(),$output);         
       }

       
       // BODY       
       $this->_load_body_header();
       
       $default_values=$this->_get_default_values();
       $default_values["table_name"]=$table_name;

       $default_values["field_prefix"]=$table_name."_";
       $this->load->view('defaultvalues_view.php',$default_values); 

       $this->load->view($table_name.'.php',$output);     
       
       // FOOTER     
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
                    
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));     
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

        $header_data['menu'] = $active_menu;
        return $header_data;
}

}
