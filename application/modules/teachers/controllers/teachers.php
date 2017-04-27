<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";


class teachers extends skeleton_main {

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

        // Load FPDF
        $this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
        $params = array ('orientation' => 'P', 'unit' => 'mm', 'size' => 'A4', 'font_path' => 'font/');
        $this->load->library('pdf',$params); // Load library

		    /* Set language */
		    $current_language=$this->session->userdata("current_language");
		    if ($current_language == "") {
		      $current_language= $this->config->item('default_language');
		    }
		    $this->lang->load('teachers', $current_language);

        //LANGUAGE HELPER:
        $this->load->helper('language');
	}

    public function load_header_data($menu = false){

        $active_menu = $menu;

        //CSS URLS
        $jquery_ui_css_url = "https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
        $jquery_ui_editable_css_url = "https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css";
        $select2_css_url = "https://cdn.jsdelivr.net/select2/3.4.5/select2.css";
        //JS URLS
        $jquery_url= "https://code.jquery.com/jquery-1.9.1.js";
        $jquery_ui_url= "https://code.jquery.com/ui/1.10.3/jquery-ui.js";
        $select2_url= "https://cdn.jsdelivr.net/select2/3.4.5/select2.js";
        $jquery_ui_editable_url= "https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js";

        if (defined('ENVIRONMENT') && ENVIRONMENT=="development") {
            $jquery_ui_css_url = base_url('assets/css/jquery-ui.css');
            $jquery_ui_editable_css_url = base_url('assets/css/jqueryui-editable.css');
            $select2_css_url = base_url('assets/css/select2.css');

            //$jquery_url= base_url('assets/js/jquery-1.9.1.js');
            $jquery_url= base_url('assets/js/jquery-1.10.2.min.js');
            $jquery_ui_url= base_url('assets/js/jquery-ui.js');
            $select2_url= base_url('assets/js/select2.js');
            $jquery_ui_editable_url= base_url('assets/js/jqueryui-editable.min.js');
        }

        $header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            $jquery_ui_css_url);

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            $jquery_ui_editable_css_url);

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/datepicker.css'));

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            $select2_css_url);

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/tribal-timetable.css'));


        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap-switch.min.css'));


        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/bootstrap.min.extracolours.css'));

//ACE
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
            base_url('assets/grocery_crud/css/jquery_plugins/fancybox/jquery.fancybox.css'));

/*
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));


        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/chosen.min.css'));
*/
        //JS Already load at skeleton main!!!
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            $jquery_url);

        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            $jquery_ui_url);


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            $select2_url);


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            $jquery_ui_editable_url);


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/bootstrap-datepicker.js'));


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/bootstrap-datepicker.ca.js'));


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/bootstrap-datepicker.es.js'));


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
            base_url('assets/js/jquery.dataTables.min.js'));


        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.dataTables.bootstrap.js'));


        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/bootstrap-switch.min.js'));

 //ACE
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ace.min.js'));

/*
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/chosen.jquery.min.js'));
*/

        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/grocery_crud/js/jquery_plugins/jquery.fancybox-1.3.4.js'));
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ebre-escool.js'));

        $header_data['menu']= $active_menu;
        return $header_data;

    }

    public function report_teachers_list($academic_period_id = null) {
        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        if (!$this->session->userdata('is_admin')) {
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#teachers_reports';
        $active_menu['submenu2']='#report_teachers_list';

        $header_data = $this->load_header_data($active_menu);

        $data = array();

        $this->load->model('teachers_model');

        $header_data = $this->_load_html_header($header_data);

        $this->_load_body_header();

        $data['table_title'] = "Llista de professors";

        $current_academic_period_id = null;

        if ($academic_period_id == null) {
            $database_current_academic_period =  $this->teachers_model->get_current_academic_period();

            if ($database_current_academic_period->id) {
                $current_academic_period_id = $database_current_academic_period->id;
            } else {
                $current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');
            }

            $academic_period_id=$current_academic_period_id ;
        }

        $academic_periods = $this->teachers_model->get_all_academic_periods();
        //$all_classgroups = $this->teachers_model->get_all_classgroups_report_info($academic_period_id);
        $all_teachers = $this->teachers_model->get_all_teachers_report_info($academic_period_id);

        $data['all_teachers'] = $all_teachers;

        $data['academic_periods'] = $academic_periods;
        $data['selected_academic_period_id'] = $academic_period_id;

        $this->load->view('report_teachers_list.php',$data);

        $this->_load_body_footer();


    }

    public function teacher_sheet_selector() {
        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#teachers_reports';
        $active_menu['submenu2']='#teachers_sheet_report';

        $header_data = $this->load_header_data($active_menu);

        $data = array();

        $this->load->model('teachers_model');

        $header_data = $this->_load_html_header($header_data);

        $this->_load_body_header();

        $academic_periods = $this->teachers_model->get_all_academic_periods();

        $data['academic_periods'] = $academic_periods;

        $this->load->view('report_teachers_sheet_selector.php',$data);

        $this->_load_body_footer();

    }


    public function teacher_sheet($academic_period_id=null) {

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        //TODO
        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#teachers_reports';
        $active_menu['submenu2']='#teachers_sheet_report';

        $this->load->model('teachers_model');

        if ($academic_period_id==null) {
            $academic_period_id = $this->teachers_model->get_current_academic_period()->id;
        }

        $all_teachers = $this->teachers_model->get_all_teachers($academic_period_id);

        if ($academic_period_id != null ) {
            $academic_period = $this->teachers_model->get_academic_period_by_id($academic_period_id);
        } else {
            $academic_period = $this->teachers_model->get_current_academic_period();
        }

        $default_group_code = $this->config->item('default_group_code');

        $group_code=$default_group_code;

        $organization = $this->config->item('organization','skeleton_auth');

        $header_data['header_title']=lang("all_teachers") . ". " . $organization;

        $contador = 0;
        $professor = array();

        if (is_array($all_teachers)) {
            foreach($all_teachers as $teacher) {

                $professor[$contador]['code']=$teacher->teacher_code;
                $professor[$contador]['teacher_charge_short']=$teacher->teacher_charge_short;
                $professor[$contador]['teacher_charge_full']=$teacher->teacher_charge_full;
                $professor[$contador]['name']=$teacher->givenName;
                $professor[$contador]['sn1']=$teacher->sn1;
                $professor[$contador]['sn2']=$teacher->sn2;
                $professor[$contador]['teacher_charge_sheet_line1']=$teacher->teacher_charge_sheet_line1;
                $professor[$contador]['teacher_charge_sheet_line2']=$teacher->teacher_charge_sheet_line2;
                $professor[$contador]['teacher_charge_sheet_line3']=$teacher->teacher_charge_sheet_line3;
                $professor[$contador]['teacher_charge_sheet_line4']=$teacher->teacher_charge_sheet_line4;

                $photo_url = trim($teacher->photo_url);

                if ($photo_url != "") {

                    if( file_exists(getcwd().'/uploads/person_photos/'. $photo_url)) {

                        $professor[$contador]['photo']=base_url('uploads/person_photos')."/".$teacher->photo_url;
                    } else {
                        $professor[$contador]['photo']=base_url('assets/img/alumnes/foto.png');
                    }
                } else {
                    $professor[$contador]['photo']=base_url('assets/img/alumnes/foto.png');
                }

                $professor[$contador]['carrec_line1']=$professor[$contador]['teacher_charge_sheet_line1'];
                $professor[$contador]['carrec_line2']=$professor[$contador]['teacher_charge_sheet_line2'];
                $professor[$contador]['carrec_line3']=$professor[$contador]['teacher_charge_sheet_line3'];
                $professor[$contador]['carrec_line4']=$professor[$contador]['teacher_charge_sheet_line4'];

                $contador++;
            }
        }


        $count = count($professor);


        //Crido la classe
        $pdf = new FPDF('P', 'mm', 'A4','font/');
        //Defineixo els marges
        $pdf->SetMargins(10,10,10);
        //Obro una pàgina
        $pdf->AddPage();
                //$pdf->Image($jpeg_file_cons[0],166,222,10);
        //$pdf->AddPage("P","A3");
        //Es la posicio exacta on comença a escriure
        $x=7;//10
        $y=15;//24

        //Logo
        //$pdf->Image(base_url().APPPATH.'third_party/skeleton/assets/img/logo_iesebre_2010_11.jpg',$x+2,5,40,15);
        $pdf->Image(base_url('uploads/person_photos'). "/logo_iesebre_2010_11.jpg",$x+2,5,40,15);
        //Defineixo el tipus de lletra, si és negreta (B), si és cursiva (L), si és normal en blanc
        $pdf->SetFont('Arial','B',15);
        //$pdf->Cell(Amplada, altura, text, marc, on es comença a escriure després, alineació)
        $pdf->SetXY(10,10);

        $pdf->Cell(190,6,"PROFESSORAT ".$academic_period->shortname,0,0,'C');
        $y=$y+6;

        //Guardo les coordenades inicials de x i y
        $x_start=$x;
        $y_start=$y;

        //Inicio les columnes i les files a 0
        $col=0;
        $row=0;

        //Paràmetres de tamany de les fotos, $xx indica l'amplada de la foto, $yy indica
        //l'altura de cada camp del professor, l'altura de la foto es 3 vegades aquest valor
        //En cas de tocar aquest paràmetres caldria revisar el màxim de columnes i files
        $xx=11;//10//Amplada horitzontal de cada professor es tocada segons el nombre de professors que hi haguin

        //Sergi Tur
        //Si no s'indica l'amplada vertical es posa el que toca per mantenir les proporcions
        //Fotos originals: 147x186:1.265306122
        //Mida: 12x15,183673464
        //$yy=5;//3//Amplada vertical de cada professor es tocada segons el nombre de professors que hi haguin

        //No és l'açada de la FOTO! És la alçada del que ocupa cada bloc de profe (foto+dades)
        $yy=4.75;

        //Amb aquestes fòrmules defineixo les coordenades de cada camp de cada professor
        //Fòrmula: posició inicial de x/y * columna * camps de cada professor

        //Ampla de la columna amb el nom i cognoms del professor
        $x_name=12;
        //Ampla de la columna de carrecs
        $x_post=9;

        $x=$x_start+$col*($xx+$x_name+$x_post);
        $x1=$x_start+$col*($xx+$x_name+$x_post)+$x_name;
        $x2=$x_start+$col*($xx+$x_name+$x_post)+$x_name+$x_post;

        $y=$y_start+$row*$yy*3;
        $y1=$y_start+$row*$yy*3+$yy;
        $y2=$y_start+$row*$yy*3+$yy*2;
        $y3=$y_start+$row*$yy*3+$yy*2;

        //La i és el marge entre professors
        $i=0;
        $page_one=true;

        //Imprimeixo sempre els conserges i secretàries en una posició fixa el primer cop
        //TODO: Obtenir les dades de les carpetes personal de Gosa:

        //Posició inicial conserges:

            $initial_x_personal=166;
            $initial_y_personal=222;

            $width_personal_foto=10;


        {

        $x = $x -22;
        //$y = 21;
        for($j=0;$j<$count; $j++) {

                $pdf->SetFont('Arial','B',6);
                $pdf->SetTextColor(255,0,0);

                $pdf->Text($x+22,$y,utf8_decode($professor[$j]['code']));

                $pdf->SetFont('Arial','',4);
                $pdf->SetTextColor(0,0,0);
                $pdf->Text($x+44,$y,utf8_decode($professor[$j]['carrec_line1']));
                $pdf->Text($x+44,$y1-1,utf8_decode($professor[$j]['carrec_line2']));
                $pdf->Text($x+22,$y1-1,utf8_decode($professor[$j]['name']));
                $pdf->Text($x+22,$y2-2,utf8_decode($professor[$j]['sn1']));
                $pdf->Text($x+44,$y2-2,utf8_decode($professor[$j]['carrec_line3']));
                $pdf->Text($x+22,$y+11,utf8_decode($professor[$j]['sn2']));
                $pdf->Text($x+44,$y+11,utf8_decode($professor[$j]['carrec_line4']));
                //$pdf->Image($jpeg_file[$j],$x1-2,$y-2,$xx);
                $pdf->Image($professor[$j]['photo'],$x1-2,$y-2,$xx);
            //incremento la fila
            $row++;
            //incremento el marge
            $i=$i+0.3;

            //Recàlculo les coordenades
            $y=$y_start+$i+$row*$yy*3;
            $y1=$y_start+$i+$row*$yy*3+$yy;
            $y2=$y_start+$i+$row*$yy*3+$yy*2;

            //màxim de files per pàgina
            if($row>17){//26//Maxim de registre per columnes si es toca el tamny del professor tambe es tocara aquesta dada.
                //incremento la columna
                $col++;
                //reinicio les files i el marge
                $row=0;
                $i=0;
                //Recàlculo les coordenades
                $x=$x_start+$col*($xx+$x_name+$x_post)-22;
                $x1=$x_start+$col*($xx+$x_name+$x_post)+$x_name;
                $x2=$x_start+$col*($xx+$x_name+$x_post)+$x_name+$x_post;

                $y=$y_start+$i+$row*$yy*3;
                $y1=$y_start+$i+$row*$yy*3+$yy;
                $y2=$y_start+$i+$row*$yy*3+$yy*2;

            }
            //Quan arribem a la última fila vigilem de no escriure a sobre dels conserges i secretàries
            if($col==5 && $row==21 && $page_one){
                //Ho tornem a posar tot a 0 i obrim una nova pàgina
                $col=0;
                $row=0;
                $i=0;
                $x=$x_start+$col*$xx;
                $x1=$x_start+$col*$xx*3+$xx;
                $x2=$x_start+$col*$xx*3+$xx*2;

                $y=$y_start+$i+$row*$yy*3;
                $y1=$y_start+$i+$row*$yy*3+$yy;
                $y2=$y_start+$i+$row*$yy*3+$yy*2;
                $page_one=false;
                $pdf->AddPage();
            }
        }
        }

        //enviem tot al pdf
        $pdf->Output("Professorat_".$academic_period->shortname."_(".date("d-m-Y").").pdf", "I");


//    }

    }

    function mentor_reports($academic_period_id = null){
        $this->tutors_report($academic_period_id);
    }

    function tutors_report($academic_period_id = null) { // Tutors de Grup

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        //TODO
        $active_menu = array();
        $active_menu['menu']='#reports';
        $active_menu['submenu1']='#teachers_reports';
        $active_menu['submenu2']='#reports_mentor_list';

        $header_data = $this->load_header_data($active_menu);

        $data = array();

        $this->load->model('teachers_model');

        $header_data = $this->_load_html_header($header_data);

        $this->_load_body_header();

        $data['classgroup_table_title'] = "Tutors dels grups de classe";

        $selected_academic_period_id = false;


        $current_academic_period_id = null;

        if ($academic_period_id == null) {
            $database_current_academic_period =  $this->teachers_model->get_current_academic_period();

            if ($database_current_academic_period->id) {
                $current_academic_period_id = $database_current_academic_period->id;
            } else {
                $current_academic_period_id = $this->config->item('current_academic_period_id','ebre-escool');
            }

            $academic_period_id=$current_academic_period_id ;
        } else {
            $selected_academic_period_id = $academic_period_id;
        }

        $academic_periods = $this->teachers_model->get_all_academic_periods();
        $all_classgroups = $this->teachers_model->get_all_classgroups_report_info($academic_period_id);

        $data['all_classgroups'] = $all_classgroups;
        $data['academic_periods'] = $academic_periods;
        $data['selected_academic_period_id'] = $selected_academic_period_id;

        $this->load->view('llistat_grup_tutor.php',$data);

        $this->_load_body_footer();

    }

    public function teachers_by_academic_period($department_id = "") {

        /*
        MIGRATION SCRIPT:
        INSERT INTO teacher_academic_periods (`teacher_academic_periods_teacher_id`,`teacher_academic_periods_academic_period_id`,`teacher_academic_periods_code`,`teacher_academic_periods_department_id`,`teacher_academic_periods_charge_full`,`teacher_academic_periods_charge_short`,`teacher_academic_periods_charge2_full`,`teacher_academic_periods_charge2_short`,`teacher_academic_periods_charge_sheet_line1`,`teacher_academic_periods_charge_sheet_line2`,`teacher_academic_periods_charge_sheet_line3`,`teacher_academic_periods_charge_sheet_line4`,`teacher_academic_periods_entryDate`,`teacher_academic_periods_creationUserId`,`teacher_academic_periods_lastupdateUserId`)
        SELECT `teacher_id`,5,`teacher_code`,`teacher_department_id`,`teacher_charge_full`,`teacher_charge_short`,`teacher_charge2_full`,`teacher_charge2_short`,`teacher_charge_sheet_line1`,`teacher_charge_sheet_line2`,`teacher_charge_sheet_line3`,`teacher_charge_sheet_line4`,"2011-09-19 00:00:00",2,2
        FROM teacher;
        */

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#persons';
        $active_menu['submenu2']='#teachers_by_academic_period';

        $this->check_logged_user();

        /* Ace */
        $header_data= $this->load_ace_files($active_menu);

        /* Grocery Crud */
        $this->current_table="teacher_academic_periods";
        $this->grocery_crud->set_table($this->current_table);

        $this->session->set_flashdata('table_name', $this->current_table);

        //Establish subject:
        $this->grocery_crud->set_subject(lang('teachers_by_academic_period'));

        $this->common_callbacks($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_id',lang($this->current_table.'_academic_period_id'));
        $this->grocery_crud->display_as($this->current_table.'_teacher_id',lang($this->current_table.'_teacher_id'));
        $this->grocery_crud->display_as($this->current_table.'_academic_period_id',lang($this->current_table.'_academic_period_id'));
        $this->grocery_crud->display_as($this->current_table.'_code',lang($this->current_table.'_code'));
        $this->grocery_crud->display_as($this->current_table.'_department_id',lang($this->current_table.'_department_id'));
        $this->grocery_crud->display_as($this->current_table.'_charge_full',lang($this->current_table.'_charge_full'));
        $this->grocery_crud->display_as($this->current_table.'_charge_short',lang($this->current_table.'_charge_short'));
        $this->grocery_crud->display_as($this->current_table.'_charge2_full',lang($this->current_table.'_charge2_full'));
        $this->grocery_crud->display_as($this->current_table.'_charge2_short',lang($this->current_table.'_charge2_short'));
        $this->grocery_crud->display_as($this->current_table.'_charge_sheet_line1',lang($this->current_table.'_charge_sheet_line1'));
        $this->grocery_crud->display_as($this->current_table.'_charge_sheet_line2',lang($this->current_table.'_charge_sheet_line2'));
        $this->grocery_crud->display_as($this->current_table.'_charge_sheet_line3',lang($this->current_table.'_charge_sheet_line3'));
        $this->grocery_crud->display_as($this->current_table.'_charge_sheet_line4',lang($this->current_table.'_charge_sheet_line4'));

        $this->grocery_crud->display_as($this->current_table.'_entryDate',lang('entryDate'));
        $this->grocery_crud->display_as($this->current_table.'_last_update',lang('last_update'));
        $this->grocery_crud->display_as($this->current_table.'_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as($this->current_table.'_lastupdateUserId',lang('lastupdateUserId'));
        $this->grocery_crud->display_as($this->current_table.'_markedForDeletion',lang('markedForDeletion'));
        $this->grocery_crud->display_as($this->current_table.'_markedForDeletionDate',lang('markedForDeletionDate'));

        //RELATIONS
        $this->grocery_crud->set_relation($this->current_table.'_department_id','department','{department_shortname}');
        $this->grocery_crud->set_relation($this->current_table.'_academic_period_id','academic_periods','{academic_periods_shortname}');

        //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));

        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');

        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');

        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

        $teachers_by_department = $this->session->flashdata('teachers_by_department');
        $this->session->keep_flashdata('teachers_by_department');

        if ( is_array($teachers_by_department) && $department_id != "" ) {
            $teachers = $teachers_by_department[$department_id];
            foreach ($teachers as $condition) {
                $this->grocery_crud->or_where($this->current_table.'_id',$condition);
            }
        }

        $this->renderitzar($this->current_table,$header_data);


            //$this->grocery_crud->set_rules('person_official_id',lang('person_official_id'),'callback_valida_nif_cif_nie['.$this->input->post('person_official_id_type').']');
            //$this->grocery_crud->set_rules('person_email',lang('person_email'),'valid_email');

    }

	public function teacher($department_id = "") {

        /*
        MIGRATION SCRIPT:
        INSERT INTO teacher_academic_periods (`teacher_academic_periods_teacher_id`,`teacher_academic_periods_academic_period_id`,`teacher_academic_periods_code`,`teacher_academic_periods_department_id`,`teacher_academic_periods_charge_full`,`teacher_academic_periods_charge_short`,`teacher_academic_periods_charge2_full`,`teacher_academic_periods_charge2_short`,`teacher_academic_periods_charge_sheet_line1`,`teacher_academic_periods_charge_sheet_line2`,`teacher_academic_periods_charge_sheet_line3`,`teacher_academic_periods_charge_sheet_line4`,`teacher_academic_periods_entryDate`,`teacher_academic_periods_creationUserId`,`teacher_academic_periods_lastupdateUserId`)
        SELECT `teacher_id`,5,`teacher_code`,`teacher_department_id`,`teacher_charge_full`,`teacher_charge_short`,`teacher_charge2_full`,`teacher_charge2_short`,`teacher_charge_sheet_line1`,`teacher_charge_sheet_line2`,`teacher_charge_sheet_line3`,`teacher_charge_sheet_line4`,"2011-09-19 00:00:00",2,2
        FROM teacher;
        */

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#persons';
        $active_menu['submenu2']='#teachers';

        $this->check_logged_user();

        /* Ace */
        $header_data= $this->load_ace_files($active_menu);

        /* Grocery Crud */
        $this->current_table="teacher";
        $this->grocery_crud->set_table($this->current_table);

        $this->session->set_flashdata('table_name', $this->current_table);

        //Establish subject:
        $this->grocery_crud->set_subject(lang('teacher'));

        $this->common_callbacks($this->current_table);

        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as($this->current_table.'_person_id',lang($this->current_table.'_person_id'));
        $this->grocery_crud->display_as($this->current_table.'_user_id',lang($this->current_table.'_user_id'));
        $this->grocery_crud->display_as($this->current_table.'_person_id',lang($this->current_table.'_person_id'));
        $this->grocery_crud->display_as($this->current_table.'_entryDate',lang('entryDate'));
        $this->grocery_crud->display_as($this->current_table.'_last_update',lang('last_update'));
        $this->grocery_crud->display_as($this->current_table.'_creationUserId',lang('creationUserId'));
        $this->grocery_crud->display_as($this->current_table.'_lastupdateUserId',lang('lastupdateUserId'));
        $this->grocery_crud->display_as($this->current_table.'_markedForDeletion',lang('markedForDeletion'));
        $this->grocery_crud->display_as($this->current_table.'_markedForDeletionDate',lang('markedForDeletionDate'));

        //RELATIONS
        $this->grocery_crud->set_relation('teacher_person_id','person','{person_sn1} {person_sn2},{person_givenName} ({person_official_id}) - {person_id} ');
        $this->grocery_crud->set_relation('teacher_user_id','users','{username}');

        //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));

        $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');

        $this->userCreation_userModification($this->current_table);

        $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');

        $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

        $teachers_by_department = $this->session->flashdata('teachers_by_department');
        $this->session->keep_flashdata('teachers_by_department');

        if ( is_array($teachers_by_department) && $department_id != "" ) {
            $teachers = $teachers_by_department[$department_id];
            foreach ($teachers as $condition) {
                $this->grocery_crud->or_where($this->current_table.'_id',$condition);
            }
        }

        $this->renderitzar($this->current_table,$header_data);


           	//$this->grocery_crud->set_rules('person_official_id',lang('person_official_id'),'callback_valida_nif_cif_nie['.$this->input->post('person_official_id_type').']');
            //$this->grocery_crud->set_rules('person_email',lang('person_email'),'valid_email');

	}

//-->
  //CALLBACKS
function common_callbacks()
{
        //CALLBACKS
        $this->grocery_crud->callback_add_field($this->session->flashdata('table_name').'_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field($this->session->flashdata('table_name').'_entryDate',array($this,'edit_field_callback_entryDate'));

        //Camps last update no editable i automàtic
        $this->grocery_crud->callback_edit_field($this->session->flashdata('table_name').'_last_update',array($this,'edit_callback_last_update'));
}

  public function edit_field_callback_entryDate($value, $primary_key){
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';
  }

  public function edit_callback_last_update($value, $primary_key){

    $data = date('d/m/Y H:i:s', time());
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. $data .'"  name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';

  }

  public function before_update_last_update($post_array, $primary_key) {
    $data= date('d/m/Y H:i:s', time());
    //$post_array['person_last_update'] = $data;
    $post_array[$this->session->flashdata('table_name').'_last_update'] = $data;
    //$post_array['lastupdateUserId'] = $this->session->userdata('user_id');
    return $post_array;
}

public function add_field_callback_entryDate(){

    $data= date('d/m/Y H:i:s', time());
    //return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="person_entryDate" id="field-entryDate" readonly>';
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';
}

public function add_callback_last_update(){

    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';
}

protected function _unique_field_name($field_name)
    {
    	return 's'.substr(md5($field_name),0,8); //This s is because is better for a string to begin with a letter and not with a number
    }


public function index() {
		$this->teacher();
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

public function load_data_tables($header_data){
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.dataTables.min.js'));

        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/jquery.dataTables.bootstrap.js'));

        return $header_data;
}

  public function load_ace_files($active_menu=false) {
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


        if($active_menu==false){
            $header_data['menu']= $active_menu;
        }
        return $header_data;

  }

        function cmpTeachers($a, $b)    {
            return strnatcmp($a->code, $b->code);
        }


}
