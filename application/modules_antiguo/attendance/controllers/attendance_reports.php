<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";

class attendance_reports extends skeleton_main {

    public $body_header_view ='include/ebre_escool_body_header.php' ;
    public $body_header_lang_file ='ebre_escool_body_header' ;
    public $html_header_view ='include/ebre_escool_html_header' ;
    public $body_footer_view ='include/ebre_escool_body_footer' ;
	
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('attendance_model');
        $this->load->library('ebre_escool_ldap');
        $this->config->load('managment');

        // Load FPDF        
        $this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
        $params = array ('orientation' => 'P', 'unit' => 'mm', 'size' => 'A4', 'font_path' => 'font/');        
        $this->load->library('pdf',$params); // Load library

        /* Set language */
        $current_language=$this->session->userdata("current_language");
        if ($current_language == "") {
            $current_language= $this->config->item('default_language');
        }

        $this->lang->load('ebre_escool_ldap', $current_language);
        $this->lang->load('attendance',$current_language);        
        
        //LANGUAGE HELPER:
        $this->load->helper('language');
        
	}

    function get_all_incidents(){

        if (!$this->skeleton_auth->logged_in()) {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $all_incidents = array();
        
        $all_incidents = $this->attendance_model->get_all_incidents();
       
        echo '{
           "aaData": ';

            print_r(json_encode($all_incidents));

        echo '}';
    
    }

    function get_student_incidents($academic_period_id = null, $student_id = null, $classroom_group_id = null,$initial_date=null,$final_date=null){
        if ($student_id == null) {
            if(isset($_POST['student_id'])){
                $student_id=$_POST['student_id'];
            }
        }

        if ($academic_period_id == null) {
            if(isset($_POST['academic_period_id'])){
                $academic_period_id=$_POST['academic_period_id'];
            }
        }

        if ($classroom_group_id == null) {
            if(isset($_POST['classroom_group_id'])){
                $classroom_group_id=$_POST['classroom_group_id'];
            }
        }

        if ($initial_date == null) {
            if(isset($_POST['initial_date'])){
                $initial_date=$_POST['initial_date'];
            }
        }

        if ($final_date == null) {
            if(isset($_POST['final_date'])){
                $final_date=$_POST['final_date'];
            }
        }

        if (!$this->skeleton_auth->logged_in()) {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $student_incidents = array();

        if ($student_id != "") {
            $student_incidents = $this->attendance_model->get_student_incidents($academic_period_id,$student_id,
                $classroom_group_id,$initial_date,$final_date);    
        }
       
        echo '{
           "aaData": ';

            print_r(json_encode($student_incidents));

        echo '}';
    
    }

    function get_student_incidents_by_study_modules($academic_period_id = null, $student_id = null, $classroom_group_id = null,$initial_date=null,$final_date=null){
        if ($student_id == null) {
            if(isset($_POST['student_id'])){
                $student_id=$_POST['student_id'];
            }
        }

        if ($academic_period_id == null) {
            if(isset($_POST['academic_period_id'])){
                $academic_period_id=$_POST['academic_period_id'];
            }
        }

        if ($classroom_group_id == null) {
            if(isset($_POST['classroom_group_id'])){
                $classroom_group_id=$_POST['classroom_group_id'];
            }
        }

        if ($initial_date == null) {
            if(isset($_POST['initial_date'])){
                $initial_date=$_POST['initial_date'];
            }
        }

        if ($final_date == null) {
            if(isset($_POST['final_date'])){
                $final_date=$_POST['final_date'];
            }
        }

        if (!$this->skeleton_auth->logged_in()) {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $student_incidents = array();

        if ($student_id != "") {
            $student_incidents = $this->attendance_model->get_student_incidents_by_study_modules($academic_period_id,$student_id,
                $classroom_group_id,$initial_date,$final_date);    
        }
       
        echo '{
           "aaData": ';

            print_r(json_encode($student_incidents));

        echo '}';
    
    }

    function get_student_incidents_by_study_submodules($academic_period_id = null, $student_id = null, $classroom_group_id = null,$initial_date=null,$final_date=null){
        if ($student_id == null) {
            if(isset($_POST['student_id'])){
                $student_id=$_POST['student_id'];
            }
        }

        if ($academic_period_id == null) {
            if(isset($_POST['academic_period_id'])){
                $academic_period_id=$_POST['academic_period_id'];
            }
        }

        if ($classroom_group_id == null) {
            if(isset($_POST['classroom_group_id'])){
                $classroom_group_id=$_POST['classroom_group_id'];
            }
        }

        if ($initial_date == null) {
            if(isset($_POST['initial_date'])){
                $initial_date=$_POST['initial_date'];
            }
        }

        if ($final_date == null) {
            if(isset($_POST['final_date'])){
                $final_date=$_POST['final_date'];
            }
        }

        if (!$this->skeleton_auth->logged_in()) {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $student_incidents = array();

        if ($student_id != "") {
            $student_incidents = $this->attendance_model->get_student_incidents_by_study_submodules($academic_period_id,$student_id,
                $classroom_group_id,$initial_date,$final_date);    
        }
       
        echo '{
           "aaData": ';

            print_r(json_encode($student_incidents));

        echo '}';
    
    }

    

    function attendance_reports_all_incidents($academic_period_id = null) { 
        if (!$this->skeleton_auth->logged_in()) {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $active_menu = array();
        $active_menu['menu']='#attendance_reports';
        $active_menu['submenu1']='#attendance_reports_all_incidents';

        $this->load_datatables_data($active_menu);

        if ($academic_period_id == null) {
            $academic_period_id = $this->attendance_model->get_current_academic_period_id();
        }

        $academic_periods = $this->attendance_model->get_all_academic_periods();

        $data = array();

        $data['academic_periods'] = $academic_periods;
        $data['selected_academic_period_id'] = $academic_period_id;

        $this->load->view('attendance_reports/attendance_reports_all_incidents.php',$data);     
        $this->load_footer(); 
    }

    /* ASSISTÈNCIA - INFORMES DE CENTRE */

    function all_attendance_incidents_at_day_and_hour_report() { // Incidències del centre del dia d hora h

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#reports_educational_center';
        $active_menu['submenu2']='#reports_center_by_d_h_1';

        $this->load_datatables_data($active_menu);

        $data = array();
        $data['title']=lang('reports_educational_center_reports_incidents_by_day_and_hour');
        $data['post'] = $_POST;

        // Hores de classe
        /*
        array( 1 => '8:00-9:00', 2 => '9:00-10:00', 3 => '10:00-11:00', 4 => '11:30-12:30', 
               5 => '12:30-13:30', 6 => '13:30-14:30', 7 => '15:30-16:30', 8 => '16:30-17:30',
               9 => '17:30-18:30', 10 => '19:00-20:00', 11 => '20:00-21:00', 12 => '21:00-22:00');
        */
        $data['time_slots'] = $this->attendance_model->getAllTimeSlots()->result_array();

        // Guardo els tipus de falta que s'han sel·leccionat
        $selected_incident_type = array();
        foreach($_POST as $k=>$v){
            if($k!="data" && $k!="hora"){
                $selected_incident_type[] = $v;    
            }    
        }
        if(count($selected_incident_type)==0){
            $selected_incident_type='';
        }

        $falta ='';

        // Mirar als elements del $_POST si hi ha algun tipus de falta sel·leccionat
        foreach ($_POST as $key=>$val){
            if($key!='data' and $key!='hora'){
                $falta .= $key." ";
            }
        }
        
        // Guardem la data i hora sel·leccionades, si ho hi ha data i hora selecionades per defecte és la data d'avui i el primer timeslot
        $group = new stdClass;
        if(isset($_POST['data'])){
            $selected_date=$_POST['data'];
        } else {
            $selected_date=date("d-m-Y");
        }
        if(isset($_POST['hora'])){
            $selected_hour=$_POST['hora'];            
        } else {
            $selected_hour=1;
        }

        $faltes = $this->attendance_model->getAllIncidentsByDateTime($selected_date,$selected_hour,$selected_incident_type);

        $num_faltes = count($faltes);

        $i=0;
        if($faltes){
        foreach($faltes as $falta){
            $data['incident'][$i]['student'] = "(".$falta->student_id.") ".$falta->student_name." ".$falta->student_sn1." ".$falta->student_sn2;
            $data['incident'][$i]['teacher'] = "(".$falta->teacher_id.") ".$falta->teacher_name." ".$falta->teacher_sn1." ".$falta->teacher_sn2;
            switch($falta->type){
                case 1: $data['incident'][$i]['incident'] = 'F'; break;
                case 2: $data['incident'][$i]['incident'] = 'FJ'; break;
                case 3: $data['incident'][$i]['incident'] =  'R'; break;
                case 4: $data['incident'][$i]['incident'] = 'RJ'; break;
                case 5: $data['incident'][$i]['incident'] =  'E'; break;
                default: $data['incident'][$i]['incident'] =  ''; break;
            }

            //$data['incidencia'][$i]['incidencia'] = $falta->type;
            $data['incident'][$i]['day'] = date("d-m-Y", strtotime($falta->day));
            $data['incident'][$i]['hour'] = $falta->timeslot;

            $data['incident'][$i]['start_time'] = $data['time_slots'][($falta->timeslot)-1]['time_slot_start_time'];
            $data['incident'][$i]['end_time'] = $data['time_slots'][($falta->timeslot)-1]['time_slot_end_time'];

            $data['incident'][$i]['group'] = $falta->group;
            $data['incident'][$i]['study_module'] = $falta->study_module;

            $i++;
            }
        } else {
            $data['incident'] = false;
        }

        //$this->load_header();  
        $this->load->view('attendance_reports/all_attendance_incidents_at_day_and_hour_report.php',$data);     
        $this->load_footer();
    }

    function all_attendance_incidents_day_range_report() { // Incidències del centre entre una data inicial i una data final

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#reports_educational_center';
        $active_menu['submenu2']='#reports_center_by_id_fd_1';

        $this->load_datatables_data($active_menu);

        $data= array();
        $data['title']=lang('reports_educational_center_reports_incidents_by_date');
        $data['post'] = $_POST;

        // Guardo els tipus de falta que s'han sel·leccionat
        $selected_incident_type = array();
        foreach($_POST as $k=>$v){
            if($k!="data_inicial" && $k!="data_final"){
                $selected_incident_type[] = $v;    
            }    
        }
        if(count($selected_incident_type)==0){
            $selected_incident_type='';
        }

        $falta ='';

        $data['time_slots'] = $this->attendance_model->getAllTimeSlots()->result_array();        

        // Mirar als elements del $_POST si hi ha algun tipus de falta sel·leccionat
        foreach ($_POST as $key=>$val){
            if($key!='data_inicial' and $key!='data_final'){
                $falta .= $key." ";
            }
        }
        
        // Guardem la data i hora sel·leccionades, si ho hi ha data i hora selecionades per defecte és la data d'avui i el primer timeslot
        $group = new stdClass;
        if(isset($_POST['data_inicial'])){
            $first_selected_date=$_POST['data_inicial'];
        } else {
            $first_selected_date=date("d-m-Y");
        }
        if(isset($_POST['data_final'])){
            $last_selected_date=$_POST['data_final'];            
        } else {
            $last_selected_date=date("d-m-Y");
        }

        $faltes = $this->attendance_model->getAllIncidentsBetweenDates($first_selected_date,$last_selected_date,$selected_incident_type);

        $num_faltes = count($faltes);

        $i=0;
        if($faltes){
        foreach($faltes as $falta){
            $data['incident'][$i]['student'] = "(".$falta->student_id.") ".$falta->student_name." ".$falta->student_sn1." ".$falta->student_sn2;
            $data['incident'][$i]['teacher'] = "(".$falta->teacher_id.") ".$falta->teacher_name." ".$falta->teacher_sn1." ".$falta->teacher_sn2;
            switch($falta->type){
                case 1: $data['incident'][$i]['incident'] = 'F'; break;
                case 2: $data['incident'][$i]['incident'] = 'FJ'; break;
                case 3: $data['incident'][$i]['incident'] =  'R'; break;
                case 4: $data['incident'][$i]['incident'] = 'RJ'; break;
                case 5: $data['incident'][$i]['incident'] =  'E'; break;
                default: $data['incident'][$i]['incident'] =  ''; break;
            }

            //$data['incidencia'][$i]['incidencia'] = $falta->type;
            $data['incident'][$i]['day'] = date("d-m-Y", strtotime($falta->day));
            $data['incident'][$i]['hour'] = $data['time_slots'][($falta->timeslot)-1]['time_slot_start_time']."-".$data['time_slots'][($falta->timeslot)-1]['time_slot_end_time'];
            $data['incident'][$i]['group'] = $falta->group;
            $data['incident'][$i]['study_module'] = $falta->study_module;

            $i++;
            }
        } else {
            $data['incident'] = false;
        }

        //$this->load_header();  
        $this->load->view('attendance_reports/all_attendance_incidents_day_range_report.php',$data);     
        $this->load_footer();


    }

    function all_attendance_incidents_ranking_report() { // Rànquing incidències del centre entre una data inicial i una data final

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#reports_educational_center';
        $active_menu['submenu2']='#reports_center_ranking_id_fd_1';

        $this->load_datatables_data($active_menu);

        $data= array();
        $data['title']=lang('reports_educational_center_reports_incidents_by_date_ranking');
        $data['post'] = $_POST;

        $top = 10;

        // $top = nº incidències a mostrar
        if(isset($_POST['top']))
        {
            $top = $_POST['top'];
        }
        $data['top'] = $top;

        // Guardo els tipus de falta que s'han sel·leccionat
        $selected_incident_type = array();
        foreach($_POST as $key=>$val){
            if($key!="data_inicial" && $key!="data_final" && $key!='top'){
                $selected_incident_type[] = $val;    
            }    
        }
        if(count($selected_incident_type)==0){
            $selected_incident_type='';
        }

        $data['time_slots'] = $this->attendance_model->getAllTimeSlots()->result_array();        
        
        // Guardem la data i hora sel·leccionades, si ho hi ha data i hora selecionades per defecte és la data d'avui i el primer timeslot
        $group = new stdClass;
        if(isset($_POST['data_inicial'])){
            $first_selected_date=$_POST['data_inicial'];
        } else {
            $first_selected_date=date("d-m-Y");
        }
        if(isset($_POST['data_final'])){
            $last_selected_date=$_POST['data_final'];            
        } else {
            $last_selected_date=date("d-m-Y");
        }

        $faltes = $this->attendance_model->getAllIncidentsBetweenDates($first_selected_date,$last_selected_date,$selected_incident_type,$top);

        $num_faltes = count($faltes);

        $i=0;
        if($faltes){
        foreach($faltes as $falta){
            $data['incident'][$i]['student'] = "(".$falta->student_id.") ".$falta->student_name." ".$falta->student_sn1." ".$falta->student_sn2;
            $data['incident'][$i]['teacher'] = "(".$falta->teacher_id.") ".$falta->teacher_name." ".$falta->teacher_sn1." ".$falta->teacher_sn2;
            switch($falta->type){
                case 1: $data['incident'][$i]['incident'] = 'F'; break;
                case 2: $data['incident'][$i]['incident'] = 'FJ'; break;
                case 3: $data['incident'][$i]['incident'] =  'R'; break;
                case 4: $data['incident'][$i]['incident'] = 'RJ'; break;
                case 5: $data['incident'][$i]['incident'] =  'E'; break;
                default: $data['incident'][$i]['incident'] =  ''; break;
            }

            //$data['incidencia'][$i]['incidencia'] = $falta->type;
            $data['incident'][$i]['day'] = date("d-m-Y", strtotime($falta->day));
            $data['incident'][$i]['hour'] = $data['time_slots'][($falta->timeslot)-1]['time_slot_start_time']."-".$data['time_slots'][($falta->timeslot)-1]['time_slot_end_time'];
            $data['incident'][$i]['group'] = $falta->group;
            $data['incident'][$i]['study_module'] = $falta->study_module;

            $i++;
            }
        } else {
            $data['incident'] = false;
        }

        //$this->load_header();   
        $this->load->view('attendance_reports/all_attendance_incidents_ranking_report.php',$data);     
        $this->load_footer();    
    }

    function mailing_list_report() {

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#students_reports';
        $active_menu['submenu2']='#report_mailing_list';

        $all_students_mail = $this->attendance_model->getAllStudentsMail();
/*
        echo "<pre>";
        print_r($all_students_mail);
        echo "</pre>";
*/
        $this->load_header($active_menu);    

        $data['title']=lang('reports_educational_center_reports_student_emails');

        if(isset($_POST['opcio'])){
            $data['opcio'] = $_POST['opcio'];
        } else {
            $data['opcio'] = false;
        }

        $data['all_students_mail'] = $all_students_mail;

        $this->load->view('attendance_reports/mailing_list_report.php',$data);     

        $this->load_footer();      
    }  

    /* ASSISTÈNCIA - INFORMES DE GRUP */

    function class_list_report($academic_period_id=null, $classroom_group_code = null, $with_photo = null ) {
        
        $selected_academic_period_id = false;
        $current_academic_period_id = null;

        if ($academic_period_id == null) {
            $database_current_academic_period =  $this->attendance_model->get_current_academic_period();
            
            if ($database_current_academic_period->id) {
                $current_academic_period_id = $database_current_academic_period->id;
            } else {
                $current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');  
            }
            
            $academic_period_id=$current_academic_period_id ;   
        } else {
            $selected_academic_period_id = $academic_period_id;
        }

        $academic_periods = $this->attendance_model->get_all_academic_periods();

        $data['academic_periods'] = $academic_periods;
        $data['selected_academic_period_id'] = $selected_academic_period_id;
        $data['academic_period_id'] = $academic_period_id;

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#students_reports';
        $active_menu['submenu2']='#report_class_list';

        $data['title']=lang('reports_group_reports_class_list');
        
        $this->load_datatables_data($active_menu);

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        // Get All groups
        $grups = $this->attendance_model->get_all_groups_by_academic_period($academic_period_id);
        $data['grups'] = $grups;

        $default_group_code = $this->config->item('default_group_code');
        $default_group_id = $this->config->item('default_group_id');
        $group_code=$default_group_code;
        $data['group_code']=$group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $header_data['header_title']=lang("all_students") . ". " . $organization;

        //Load CSS & JS
        //$this->set_header_data();
        $all_groups = $this->attendance_model->get_all_classroom_groups();
        $data['all_groups']=$all_groups->result();
        $photo = false;
        if ($_POST) {

            $data['selected_group']= urldecode($_POST['grup']);
            if (isset($_POST['foto'])){
                $photo= true;
            }
        }   else {
            if ( ($classroom_group_code != null) && ( $with_photo != null)) {
                $data['selected_group'] = $classroom_group_code;
                if ($with_photo == "true") {
                    $photo = true;
                } else {
                    $photo = false;
                }
            } else {
                $data['selected_group'] = $default_group_id;    
            }
            
        }
/*
        if ($data['selected_group']!="ALL_GROUPS")
            $default_group_dn=$this->ebre_escool_ldap->getGroupDNByGroupCode($data['selected_group']);
*/        
        if ($data['selected_group']=="ALL_GROUPS")
            $data['selected_group_names']= array (lang("all_tstudents"),"");
        else
            $data['selected_group_names']= $this->attendance_model->getGroupNamesByGroupCode($data['selected_group']);

        $all_students_in_group = $this->attendance_model->getAllGroupStudentsInfo($data['selected_group'],$academic_period_id);
        $group_name = $this->attendance_model->getGroupCodeByGroupID($data['selected_group']);
/*  
        $data['classroom_group_students'] = array ();
        $base_photo_url = "uploads/person_photos";

        //Total Alumnes
        $data['count_alumnes'] = count($all_students_in_group);
*/

        //print_r($all_students_in_group);

/* Student Object */

        $classroom_group_students = array ();
        $base_photo_url = "uploads/person_photos";
        
        foreach($all_students_in_group as $student) {

            $studentObject = new stdClass;
            
            $studentObject->person_id = $student->person_id;
            $studentObject->givenName = $student->givenName;
            $studentObject->sn1 = $student->sn1;
            $studentObject->sn2 = $student->sn2;
            $studentObject->username = $student->username;
            $studentObject->email = $student->email;
            $studentObject->person_official_id = $student->person_official_id;
            
            //TODO: get incident notes!
            $studentObject->notes = "nota";

            if ($student->photo_url != "") {
                $student->photo_url = $base_photo_url."/".$student->photo_url;  
            }   else {
                $studentObject->photo_url = '/assets/img/alumnes/foto.png';             
            }
            

            $classroom_group_students[]=$student;
        }

        //Total d'alumnes
        $count_alumnes = count($all_students_in_group);

//      $this->load_header();  

        $show_pdf = false;
        if ($_POST) {
            $show_pdf = true;
        } else {
            if ( ($classroom_group_code != null) && ( $with_photo != null)) {
                $show_pdf = true;
            }
        }

        if(!$show_pdf){
            $this->load->view('attendance_reports/class_list_report.php', $data); 

        } else {
            //$this->load->view('attendance_reports/class_list_report.php', $data); 
            //$this->load->view('attendance_reports/class_list_report_pdf.php', $data); 
            $number_returned = $count_alumnes;
            //$codi_grup = $group_code;
            $codi_grup = $group_name;
            $contador=0;
            $alumne =array();
//print_r($_POST);
            foreach($classroom_group_students as $student){

            $jpeg_data_size = @filesize($student->photo_url);

            if (!file_exists($student->photo_url))
            {
                $student->photo_url='assets/img/alumnes/foto.png';
                if ($jpeg_data_size < 6)
                {
                    $student->photo_url='assets/img/alumnes/foto.png';
                }
            } else {
                if( $jpeg_data_size < 6 )
                {
                    $student->photo_url='assets/img/alumnes/foto.png';
                }
            }

            $alumne[$contador]['jpegPhoto']=$student->photo_url;
            $alumne[$contador]['givenName']=$student->givenName;
            $alumne[$contador]['sn1']=$student->sn1;
            $alumne[$contador]['sn2']=$student->sn2;
            $alumne[$contador]['person_official_id']=$student->person_official_id;

            $contador++;
            }

            //Crido la classe
            $pdf = new FPDF('P', 'mm', 'A4','font/');
            //Defineixo els marges
            $pdf->SetMargins(10,10,10);
            //Obro una pàgina
            $pdf->AddPage();
            //$pdf->AddPage("P","A3");
            //Es la posicio exacta on comença a escriure
            $x=7;//10
            $y=15;//24
            $pdf->Image(base_url('/uploads/person_photos/logo_iesebre_2010_11.jpg'),$x+2,5,40,15);
            //Defineixo el tipus de lletra, si és negreta (B), si és cursiva (L), si és normal en blanc
            $pdf->SetFont('Arial','',10);
            //$pdf->Cell(Amplada, altura, text, marc, on es comença a escriure després, alineació)
            $pdf->SetXY(10,10);
            $any_comencament = 2014;
            $any_finalitzacio = 2015;
            $date = date('d-m-Y');
            $pdf->Cell(190,6,"Curs: ".$any_comencament."-".$any_finalitzacio,0,0,'R');
            $pdf->ln();
            $pdf->Cell(190,6,"Data: ".$date,0,0,'R');
            $pdf->ln();
            $pdf->Cell(190,6,utf8_decode("Pàgina: ".$pdf->PageNo()),0,0,'R');
            $pdf->ln();
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(190,6,"Llistat Alumnes Grup: ".utf8_decode($codi_grup." (".$codi_grup.")"),0,0,'C');

            /**/
            $pdf->SetFillColor(150,150,150);
            $fill=true;
            //Salt de línia
            $pdf->Ln(7);
            $pdf->SetFont('Arial','',8);

            $pdf->Cell(10,8,utf8_decode("Núm."),1,0,'C',$fill);
            if($photo){
                $pdf->Cell(8,8,utf8_decode("Foto"),1,0,'L',$fill);
                $pdf->Cell(70,8,utf8_decode("Alumne/a"),1,0,'L',$fill);
                $pdf->Cell(100,8,utf8_decode("Observacions"),1,0,'C',$fill);    
            } else {
                $pdf->Cell(70,8,utf8_decode("Alumne/a"),1,0,'L',$fill);
                $pdf->Cell(110,8,utf8_decode("Observacions"),1,0,'C',$fill);
            }
            $pdf->Ln();

            //Dades
            $pdf->SetFillColor(219,219,219);
            $fill=false;
            $pdf->SetFont('Arial','',8);
            //recorrem la matriu de dades i imprimim cada camp en una casella
            $x=0;
            for($t=0;$t<$number_returned;$t++){

                $pdf->Cell(10,8,utf8_decode($t+1),1,0,'C',$fill);
                if($photo){
                    $pdf->Cell(8,8,$pdf->Image($alumne[$t]['jpegPhoto'],$pdf->GetX()+1,$pdf->GetY(),6),1,0,'C',$fill);  
                    //$pdf->Cell(8,8,$pdf->Image(base_url("/assets/img/alumnes")."/".$alumne[$t]['jpegPhoto']/*/tmp/".$alumne[$t]['jpegPhoto']*/,$pdf->GetX()+1,$pdf->GetY(),6),1,0,'C',$fill);
                    $pdf->Cell(70,8,utf8_decode($alumne[$t]['sn1']." ".$alumne[$t]['sn2']. ", " . $alumne[$t]['givenName'] . " - ". $alumne[$t]['person_official_id']),1,0,'L',$fill);
                    $pdf->Cell(100,8,utf8_decode(""),1,0,'C',$fill);        
                } else {    
                    $pdf->Cell(70,8,utf8_decode($alumne[$t]['sn1']." ".$alumne[$t]['sn2']. ", " . $alumne[$t]['givenName'] . " - " . $alumne[$t]['person_official_id'] ),1,0,'L',$fill);
                    $pdf->Cell(110,8,utf8_decode(""),1,0,'C',$fill);
                }   
                //$fill=!$fill;
                $pdf->Ln();
            }
            //enviem tot al pdf
            $today = date('Y_m_d');   
            //$pdf->Output();
            $pdf->Output($today."_".$codi_grup.".pdf","I");

        } 
        
        $this->load_footer();      
    }

    public function mentoring_attendance_by_student_pdf_report(
        $academic_period_id, $student_id,$classroom_group_id,$initial_date,$final_date){

        //DEBUG:
        /*
        echo "academic_period_id: " . $academic_period_id . "<br/>";
        echo "student_id: " . $student_id . "<br/>";
        echo "classroom_group_id: " . $classroom_group_id . "<br/>";
        echo "initial_date: " . $initial_date . "<br/>";
        echo "final_date: " . $final_date . "<br/>";*/

        //Check if student_id is a single value or multiple values separrated by -

        $separator_character_position = strpos ( $student_id , "-");
        $student_ids = array();
        $student_id_single_value = TRUE;
        if ($separator_character_position == FALSE) {
            //SINGLE VALUE
            $student_id_single_value = TRUE;
        } else {
            //Multiple values. 
            $student_ids = explode("-", $student_id);
            $student_id_single_value = FALSE;
        }
        
        $data_reports = array();
        if ($student_id_single_value) {
            $data_report = new stdClass();
            $data_report = $this->attendance_model->get_mentoring_attendance_by_student_pdf_report_data(
                $academic_period_id, $student_id,$classroom_group_id,$initial_date,$final_date);
                array_push($data_reports, $data_report);
        } else {
            $data_reports = $this->attendance_model->get_mentoring_attendance_by_students_pdf_report_data(
                $academic_period_id, $student_ids,$classroom_group_id,$initial_date,$final_date);
        }

        /* EXAMPLE data-report
        $data_report->fullname = "David Tomàs Vergés";
        $data_report->classroom_group_full_name = "SMX 1 A";
        $data_report->num_total_incidents = "50";
        $data_report->incidents_fj = "50";
        $data_report->incidents_fi = "50";
        $data_report->incidents_r = "50";
        $data_report->incidents_e = "50";
        */
        
        // BEGIN FIXED STRINGS -->
        $initial_date_array = explode("-", $initial_date);
        $final_date_array = explode("-", $final_date);

        $initial_date = $initial_date_array[2] . "/". $initial_date_array[1] . "/" . $initial_date_array[0];
        $final_date = $final_date_array[2] . "/". $final_date_array[1] . "/" . $final_date_array[0];
 
        $FOOT_TEXT_LEFT="El tutor/la tutora";
        $FOOT_TEXT_RIGHT="El pare/mare/tutor legal";

        setlocale(LC_TIME, "ca_ES"); 
        $formatted_time = strftime("%e de %B del %Y", time());
        
        //$FOOT_LOCATION_AND_DATE="Tortosa, 6 de novembre de 2014";
        $FOOT_LOCATION_AND_DATE = "Tortosa, " . $formatted_time;

        // <-- BEGIN FIXED STRINGS

        $pdf = new FPDF('P', 'mm', 'A4','font/'); 
        foreach ($data_reports as $data_report_key => $data_report) {

            $student_full_name =  $data_report->fullname;
            $classroom_group_full_name = $data_report->classroom_group_full_name;
            $num_total_incidents=$data_report->num_total_incidents;

            if ($num_total_incidents == "1") {
                $hours_text="hora";
            } else {
                $hours_text="hores";
            }

            $incidents_fj = $data_report->incidents_fj;
            if ($incidents_fj == "1") {
                $incidents_fj_hours_text="hora";
            } else {
                $incidents_fj_hours_text="hores";
            }

            $incidents_fi = $data_report->incidents_fi;
            if ($incidents_fi == "1") {
                $incidents_fi_hours_text="hora";
            } else {
                $incidents_fi_hours_text="hores";
            }

            $incidents_r = $data_report->incidents_r;
            if ($incidents_r == "1") {
                $incidents_r_hours_text="hora";
            } else {
                $incidents_r_hours_text="hores";
            }
            $incidents_e = $data_report->incidents_e;
            if ($incidents_e == "1") {
                $incidents_e_hours_text="hora";
            } else {
                $incidents_e_hours_text="hores";
            }    

            $TEXT = "L'alumne/a " . $student_full_name . " del grup " . $classroom_group_full_name . " ha realitzat un total de ";
            $TEXT = $TEXT . $num_total_incidents . " " . $hours_text . " d'incidències des del dia " . $initial_date;
            $TEXT = $TEXT . " fins al dia " . $final_date . ", de les quals " . $incidents_fj . " " . $incidents_fj_hours_text;
            $TEXT = $TEXT . " són faltes justificades, " . $incidents_fi . " " . $incidents_fi_hours_text;
            $TEXT = $TEXT . " són faltes injustificades, " . $incidents_r . " " . $incidents_r_hours_text;
            $TEXT = $TEXT . " són retards no justificats i " . $incidents_e . " " . $incidents_e_hours_text;
            $TEXT = $TEXT . " són expulsions de classe, cosa que poso en coneixement de vostè.";

            $pdf->SetMargins(30,15,30);
            $pdf->AddPage();
            $pdf->SetFont('Times','B',16);

            //Exact position start writing
            $pdf->Image(base_url('/uploads/person_photos/logo_iesebre_2010_11.jpg'),30,10,40,15);

            $TITLE_CENTER_TEXT_LINE1 = "PROCEDIMENT DE GESTIÓ";
            $TITLE_CENTER_TEXT_LINE2 = "DE L'ACCIÓ TUTORIAL";
            $TITLE_RIGHT_TEXT = "PGQ14-D07";
            $SUBTITLE_LINE_1 = "COMUNICAT DE FALTES D'ASSISTÈNCIA";
            $SUBTITLE_LINE_2 = "DE L'ALUMNAT";

            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(160,6,utf8_decode($TITLE_CENTER_TEXT_LINE1),0,0,'C');
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(0,6,utf8_decode($TITLE_RIGHT_TEXT),0,0,'R');
            $pdf->ln();
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(160,6,utf8_decode($TITLE_CENTER_TEXT_LINE2),0,0,'C');
            
            $pdf->Line(30, 27, 210-30, 27); // 30mm from each edge

            $pdf->ln();
            $pdf->ln();

            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(160,6,utf8_decode($SUBTITLE_LINE_1),0,0,'C');
            $pdf->ln();
            $pdf->Cell(160,6,utf8_decode($SUBTITLE_LINE_2),0,0,'C');

            $pdf->ln();
            $pdf->ln();
            $pdf->ln();
            $pdf->SetFont('Arial','',11);
            $pdf->MultiCell(0, 7, utf8_decode($TEXT));

            $pdf->ln();
            $pdf->ln();

            $pdf->Cell(0, 6, utf8_decode($FOOT_TEXT_LEFT),0,0,'L');
            $pdf->Cell(0, 6, utf8_decode($FOOT_TEXT_RIGHT),0,0,'R');
            $pdf->ln();
            $pdf->ln();
            $pdf->Cell(0, 6, utf8_decode($FOOT_LOCATION_AND_DATE),0,0,'L');

            $pdf->ln();
            $pdf->ln();
            $cx = $pdf->GetX();
            $cy = $pdf->GetY();

            $pdf->Image(base_url('/assets/img/scissors.png'),$cx,$cy-1.5,3,3);
            $pdf->Line(30, $cy, 210-30, $cy); // 30mm from each edge

            //REPEAT:
            $pdf->ln();
            $pdf->ln();

            $cx = $pdf->GetX();
            $cy = $pdf->GetY();

            $pdf->Image(base_url('/uploads/person_photos/logo_iesebre_2010_11.jpg'),$cx,$cy-5,40,15);

            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(160,6,utf8_decode($TITLE_CENTER_TEXT_LINE1),0,0,'C');
            $pdf->Cell(160,6,utf8_decode($TITLE_CENTER_TEXT_LINE2),0,0,'C');
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(0,6,utf8_decode($TITLE_RIGHT_TEXT),0,0,'R');
            $pdf->ln();
            $cy = $pdf->GetY();
            $pdf->Line(30, $cy+5, 210-30, $cy+5); // 30mm from each edge

            $pdf->ln();
            $pdf->ln();
            $pdf->ln();
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(160,6,utf8_decode($SUBTITLE_LINE_1),0,0,'C');
            $pdf->ln();
            $pdf->Cell(160,6,utf8_decode($SUBTITLE_LINE_2),0,0,'C');

            $pdf->ln();
            $pdf->ln();
            $pdf->ln();
            $pdf->SetFont('Arial','',12);
            $pdf->MultiCell(0, 7, utf8_decode($TEXT));

            $pdf->ln();
            $pdf->ln();
            $pdf->ln();

            $pdf->Cell(0, 6, utf8_decode($FOOT_TEXT_LEFT),0,0,'L');
            $pdf->Cell(0, 6, utf8_decode($FOOT_TEXT_RIGHT),0,0,'R');
            $pdf->ln();
            $pdf->ln();
            $pdf->Cell(0, 6, utf8_decode($FOOT_LOCATION_AND_DATE),0,0,'L');
        }
        $pdf->Output();
    }

    function class_sheet_report($academic_period_id = null, $classroom_group_id = null) {

        $selected_academic_period_id = false;
        $current_academic_period_id = null;

        if ($academic_period_id == null) {
            $database_current_academic_period =  $this->attendance_model->get_current_academic_period();
            
            if ($database_current_academic_period->id) {
                $current_academic_period_id = $database_current_academic_period->id;
            } else {
                $current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');  
            }
            
            $academic_period_id=$current_academic_period_id ;   
        } else {
            $selected_academic_period_id = $academic_period_id;
        }

        $academic_periods = $this->attendance_model->get_all_academic_periods();

        $data['academic_periods'] = $academic_periods;
        $data['selected_academic_period_id'] = $selected_academic_period_id;
        $data['academic_period_id'] = $academic_period_id;


        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#students_reports';
        $active_menu['submenu2']='#report_class_sheet';

        $data['title'] = lang('reports_group_reports_student_sheet');

        $this->load_datatables_data($active_menu);

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        // Get All groups
        $grups = $this->attendance_model->get_all_groups_by_academic_period($academic_period_id);
        //print_r($grups);
        $data['grups'] = $grups;
        
        $default_group_code = $this->config->item('default_group_code');
        $default_group_id = $this->config->item('default_group_id');
        $group_code=$default_group_code;
        $data['group_code']=$group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $header_data['header_title']=lang("all_students") . ". " . $organization;

        //Load CSS & JS
        //$this->set_header_data();
        //$all_groups = $this->attendance_model->get_all_classroom_groups();
        $all_groups = $this->attendance_model->get_all_groups_by_academic_period($academic_period_id);

        $data['all_groups']=$all_groups;
        //$data['photo'] = true;
        if ($_POST) {
            $data['selected_group']= urldecode($_POST['grup']);
        }   else {
            if ($classroom_group_id != null) {
                $data['selected_group']=$classroom_group_id;
            } else {
                $data['selected_group']=$default_group_id;
            }
        }

//echo $data['selected_group'];

        $students_base_dn= $this->config->item('students_base_dn','skeleton_auth');
        $default_group_dn=$students_base_dn;

/*
        if ($data['selected_group']!="ALL_GROUPS")
            $default_group_dn=$this->ebre_escool_ldap->getGroupDNByGroupCode($data['selected_group']);
*/  
        //echo $default_group_dn;
        if ($data['selected_group']=="ALL_GROUPS")
            $data['selected_group_names']= array (lang("all_tstudents"),"");
        else
            $data['selected_group_names']= $this->attendance_model->getGroupNamesByGroupCode($data['selected_group']);
  
        //$estudiants_grup = $this->attendance_model->getAllGroupStudentInfo($data['selected_group']);
        //$data['all_students_in_group'] = $estudiants_grup;
        //$data['all_students_in_group']= $this->ebre_escool_ldap->getAllGroupStudentsInfo($default_group_dn);
        //$data['all_students_in_group']= $this->attendance_model->getAllGroupStudentsInfo(11);
         
        $all_students_in_group = $this->attendance_model->getAllGroupStudentsInfo($data['selected_group'],$academic_period_id);
        $group_name = $this->attendance_model->getGroupCodeByGroupID($data['selected_group']);
        //print_r($all_students_in_group);

/* Student Object */

        $classroom_group_students = array ();
        $base_photo_url = "uploads/person_photos";
        
        foreach($all_students_in_group as $student) {

            $studentObject = new stdClass;
            
            $studentObject->person_id = $student->person_id;
            $studentObject->givenName = $student->givenName;
            $studentObject->sn1 = $student->sn1;
            $studentObject->sn2 = $student->sn2;
            $studentObject->username = $student->username;
            $studentObject->email = $student->email;
            
            //TODO: get incident notes!
            $studentObject->notes = "nota";

            if ($student->photo_url != "") {
                $student->photo_url = $base_photo_url."/".$student->photo_url;  
            }   else {
                $studentObject->photo_url = '/assets/img/alumnes/foto.png';             
            }

            $classroom_group_students[]=$student;
        }

        //Total d'alumnes
        $count_alumnes = count($all_students_in_group);

        $show_pdf = false;
        if ($_POST) {
            $show_pdf = true;
        } else {
            if ($classroom_group_id != null) {
                $show_pdf = true;
            }    
        }

        //$this->load_header();
        if(!$show_pdf){
            $this->load->view('attendance_reports/class_sheet_report.php', $data); 
        } else {

            /* GENERAR PDF */

            $number_returned = $count_alumnes;
            $codi_grup = $group_name;
            $contador=0;
            $alumne =array();

            foreach($classroom_group_students as $student){

            $jpeg_data_size = @filesize($student->photo_url);

            if (!file_exists($student->photo_url))
            {
                $student->photo_url='assets/img/alumnes/foto.png';
                if ($jpeg_data_size < 6)
                {
                    $student->photo_url='assets/img/alumnes/foto.png';
                }
            } else {
                if( $jpeg_data_size < 6 )
                {
                    $student->photo_url='assets/img/alumnes/foto.png';
                }
            }

            $alumne[$contador]['jpegPhoto']=$student->photo_url;
            $alumne[$contador]['givenName']=$student->givenName;
            $alumne[$contador]['sn1']=$student->sn1;
            $alumne[$contador]['sn2']=$student->sn2;

            $contador++;
            }

            //Crido la classe
            $pdf = new FPDF('P', 'mm', 'A4','font/');
            //Defineixo els marges
            $pdf->SetMargins(10,10,10);
            //Obro una pàgina
            $pdf->AddPage();
            //$pdf->AddPage("P","A3");
            //Es la posicio exacta on comença a escriure
            $x=7;//10
            $y=15;//24
            $pdf->Image(base_url('/uploads/person_photos/logo_iesebre_2010_11.jpg'),$x+2,5,40,15);
            //Defineixo el tipus de lletra, si és negreta (B), si és cursiva (L), si és normal en blanc
            $pdf->SetFont('Arial','',10);
            //$pdf->Cell(Amplada, altura, text, marc, on es comença a escriure després, alineació)
            $pdf->SetXY(10,10);
            $any_comencament = 2014;
            $any_finalitzacio = 2015;
            $date = date('d-m-Y');
            $pdf->Cell(190,6,"Curs: ".$any_comencament."-".$any_finalitzacio,0,0,'R');
            $pdf->ln();
            $pdf->Cell(190,6,"Data: ".$date,0,0,'R');
            $pdf->ln();
            $pdf->Cell(190,6,utf8_decode("Pàgina: ".$pdf->PageNo()),0,0,'R');
            $pdf->ln();
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(190,6,"FOTOGRAFIES DELS ALUMNES",0,0,'C');
            $pdf->Ln(5);
            $pdf->Cell(120,0,"Grup: ".utf8_decode($codi_grup." (".$codi_grup.")"),0,0,'T');
            //$pdf->Cell(120,0,utf8_decode("En aquest grup hi ha ".$number_returned." Alumnes"),0,0,'T');
            //Salt de línia
            $pdf->Ln(7);

            $pdf->SetFont('Arial','',10);
            //$pos = strpos($all_students_in_group[1]->dn,',');
            //$dn = substr($all_students_in_group[1]->dn,($pos+1),strlen($all_students_in_group[1]->dn));

            //Dades
            $pdf->SetFillColor(219,219,219);
            $fill=false;
            $pdf->SetFont('Arial','',8);
            //recorrem la matriu de dades i imprimim cada camp en una casella
            $z=0;
            $pc=0;
            $test=0;
            //echo count($alumne);

            for($j=0; $j<$number_returned;$j++){


                if(($z%6)==0) {
                    $pdf->Ln();
                    for($test=$pc;$test<$z=$j;$test++){

                        $nom_alumne = $alumne[$test]['sn1'].", ".$alumne[$test]['givenName']." ";

                        if(strlen($nom_alumne)>18){
                            $pdf->SetFont('Arial','',6);
                        } else if (strlen($nom_alumne)>22) {
                            $pdf->SetFont('Arial','',5);
                        } else {
                            $pdf->SetFont('Arial','',7);
                        }

                        $pdf->Cell(28.75,8, utf8_decode($nom_alumne),1,0,'L',$fill);
                        $pc++;
                    }   
                    $pdf->Ln();

                if($z==30){
                    $pdf->AddPage();
                }

                }
                        $pdf->Cell(28.75,38.5,$pdf->Image($alumne[$j]['jpegPhoto'],$pdf->GetX(),$pdf->GetY(),28.75),1,0,'C',$fill);                 
                        $z++;
                }

            if($z==$number_returned){
                $pdf->Ln();
                    for($test=$pc;$test<$z=$j;$test++){

                        $nom_alumne = $alumne[$test]['sn1'].", ".$alumne[$test]['givenName']." ";

                        if(strlen($nom_alumne)>18){
                            $pdf->SetFont('Arial','',6);
                        } else if (strlen($nom_alumne)>22) {
                            $pdf->SetFont('Arial','',5);
                        } else {
                            $pdf->SetFont('Arial','',7);
                        }

                        $pdf->Cell(28.75,8, utf8_decode($nom_alumne),1,0,'L',$fill);
                        $pc++;
                    }

            }

            //enviem tot al pdf
            $today = date('Y_m_d');   
            //$pdf->Output();
            $pdf->Output("Llençol_".$today."_".$codi_grup.".pdf","I");

        }
        $this->load_footer();       
    }

    function attendace_incidents_classgroup_summary_report() {

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#report_group';
        $active_menu['submenu2']='#report_group_incidents_by_id_fd_1';

        $data['title'] = lang('reports_group_reports_incidents_by_date');

        // Get All groups
        $grups = $this->attendance_model->get_all_groups();

        //print_r($grups);
        $data['grups'] = $grups;

        $this->load_datatables_data($active_menu);

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }
        
        $default_group_code = $this->config->item('default_group_code');
        $group_code=$default_group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $all_groups = $this->attendance_model->get_all_classroom_groups()->result();

        $data['group_code']=$group_code;
        $data['all_groups']=$all_groups;
        if ($_POST) {
            $data['selected_group']= urldecode($_POST['grup']);
            $data['ini'] = strtotime($_POST['data_inici']);
            $data['fi'] = strtotime($_POST['data_fi']);
        } else {
            $data['selected_group']=$default_group_code;
            $data['ini'] = strtotime(date("d-m-Y"));
            $data['fi'] = strtotime(date("d-m-Y"));            
        }
/*
        if ($data['selected_group']!="ALL_GROUPS")
            $default_group_dn=$this->ebre_escool_ldap->getGroupDNByGroupCode($data['selected_group']);
*/
        if ($data['selected_group']=="ALL_GROUPS")
            $data['selected_group_names']= array (lang("all_tstudents"),"");
        else
            $data['selected_group_names']= $this->attendance_model->getGroupNamesByGroupCode($data['selected_group']);

        $all_students_in_group = $this->attendance_model->getAllGroupStudentsInfo($data['selected_group'],$academic_period_id);

        //$data['all_students_in_group']= $this->ebre_escool_ldap->getAllGroupStudentsInfo($default_group_dn);
        $data['all_students_in_group'] = $all_students_in_group;
        $data['count_alumnes'] = count($all_students_in_group);

        /* Faltes per alumne */
        $all_incidents_in_group = $this->attendance_model->getAllIncidentsGroupByDate($data['selected_group'],date("Y-m-d",$data['ini']),date("Y-m-d",$data['fi']));        
        $data['all_incidents_in_group'] = $all_incidents_in_group;

//        $this->load_header(); 
        $this->load->view('attendance_reports/attendace_incidents_classgroup_summary_report.php',$data);     
        $this->load_footer();    
    }

    function attendance_incidents_classroomgroup_month_summary_report() {

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#report_group';
        $active_menu['submenu2']='#report_group_monthly';

        $data['title'] = lang('reports_group_reports_monthly_report');

        $default_group_code = $default_group_code = $this->config->item('default_group_code');

        // Get All groups
        $grups = $this->attendance_model->get_all_groups();
        $data['grups'] = $grups;

        if ($_POST) {
            $data['selected_group']= urldecode($_POST['grup']);
            $data['month'] = $_POST['mes'];
            $data['year'] = $_POST['any'];
        } else {
            $data['selected_group']=$default_group_code;
            $data['month'] = date('n');
            $data['year'] = date('Y');
        }

        $data['mes'] = array( "1" => "Gener",
                              "2" => "Febrer",
                              "3" => "Març",
                              "4" => "Abril",
                              "5" => "Maig",
                              "6" => "Juny",
                              "7" => "Juliol",
                              "8" => "Agost",
                              "9" => "Setembre",
                             "10" => "Octubre",
                             "11" => "Novembre",
                             "12" => "Desembre"
            );

            $data['any'] = array(   "2014" => "2014",
                                    "2013" => "2013",
                                    "2012" => "2012",
                                    "2011" => "2011",
                                    "2010" => "2010",
                                    "2009" => "2009",
                                    "2008" => "2008"
            );

        $this->load_datatables_data($active_menu);

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }
        
        $default_group_code = $this->config->item('default_group_code');
        $group_code=$default_group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $all_groups = $this->attendance_model->get_all_classroom_groups();

        $data['group_code']=$group_code;
        $data['all_groups']=$all_groups->result();
        if ($_POST) {
            $data['selected_group']= urldecode($_POST['grup']);
        } else {
            $data['selected_group']=$default_group_code;
        }
/*
        if ($data['selected_group']!="ALL_GROUPS")
            $default_group_dn=$this->ebre_escool_ldap->getGroupDNByGroupCode($data['selected_group']);
*/
        if ($data['selected_group']=="ALL_GROUPS")
            $data['selected_group_names']= array (lang("all_tstudents"),"");
        else
            $data['selected_group_names']= $this->attendance_model->getGroupNamesByGroupCode($data['selected_group']);
        
        //$data['all_students_in_group']= $this->ebre_escool_ldap->getAllGroupStudentsInfo($default_group_dn);

        /* Faltes per alumne */
        $all_incidents_in_group = $this->attendance_model->getAllIncidentsGroupByMonth($data['selected_group'],$data['month'],$data['year']);        
        $data['all_incidents_in_group'] = $all_incidents_in_group;

        $all_students_in_group = $this->attendance_model->getAllGroupStudentsInfo($data['selected_group']);
        $data['all_students_in_group'] = $all_students_in_group;
        $data['count_alumnes'] = count($data['all_students_in_group']);


//        $this->load_header(); 
        $this->load->view('attendance_reports/attendance_incidents_classroomgroup_month_summary_report.php',$data);     
        $this->load_footer();    
    }

    function load_header($active_menu) {

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/select2.css'));
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
            base_url('assets/js/select2.min.js'));

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

        $this->_load_html_header($header_data); 
        $this->_load_body_header();
    }

    function load_footer() {

        $this->_load_body_footer();    

    }

    public function load_datatables_data($active_menu) {

        //CSS
        $header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            'http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css');
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/jquery-ui.css'));  
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/css/TableTools.css'));  
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/select2.css'));

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
            "http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js");                     
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/TableTools.js"));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url("assets/grocery_crud/themes/datatables/extras/TableTools/media/js/ZeroClipboard.js")); 
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url("assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js"));   
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/select2.min.js'));        
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

        $this->_load_html_header($header_data);
        //$this->_load_html_header($header_data); 
        
        $this->_load_body_header();     

    }
/*
    public function load_active_menu($active_menu){
        $header_data['menu']= $active_menu;
        $this->_load_html_header($header_data);
        $this->_load_body_header();

    }
*/
    public function informeGuifi() {

        $this->load_header();   
        $this->load->view('attendance_reports/informe_guifi.php');     
        $this->load_footer();

    }

 }   
