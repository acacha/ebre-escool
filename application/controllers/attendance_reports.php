<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "skeleton_main.php";

class attendance_reports extends skeleton_main {
	
	function __construct()
    {
        parent::__construct();
        
        $this->load->library('ebre_escool_ldap');
        
        $this->load->add_package_path(APPPATH.'third_party/fpdf-codeigniter/application/');
        $this->load->library('pdf'); // Load library
		$this->pdf->fontpath = 'font/'; // Specify font folder
		
		// Load the language file
        $this->lang->load('ebre_escool_ldap','catalan');
        $this->load->helper('language');
        
	}

    /* ASSISTÈNCIA - INFORMES DE CENTRE */

    function informe_centre_d_h_1() {
        $data['hores'] = array( 1 => '8:00-9:00', 2 => '9:00-10:00', 3 => '10:00-11:00', 4 => '11:30-12:30', 
                                 5 => '12:30-13:30', 6 => '13:30-14:30', 7 => '15:30-16:30', 8 => '16:30-17:30',
                                 9 => '7:30-18:30', 10 => '19:00-20:00', 11 => '20:00-21:00', 12 => '21:00-22:00');
        $this->load_header();  
        $this->load->view('attendance_reports/informe_centre_d_h_1.php',$data);     
        $this->load_footer();
    }

    function informe_centre_di_df_1() {
           
        $this->load_header();   
        $this->load->view('attendance_reports/informe_centre_di_df_1.php');     
        $this->load_footer();
    }

    function informe_centre_ranking_di_df_1() {

        $this->load_header();   
        $this->load->view('attendance_reports/informe_centre_ranking_di_df_1.php');     
        $this->load_footer();    
    }

    function Llistat_grup_tutor() {

        $this->load_header();  
        $this->load->view('attendance_reports/Llistat_grup_tutor.php');     
        $this->load_footer();     
    }     

    function mailing_list_report() {

        $this->load_header();    
        $this->load->view('attendance_reports/mailing_list_report.php');     
        $this->load_footer();      
    }  

    /* ASSISTÈNCIA - INFORMES DE GRUP */

    function class_list_report() {

        $data['grups'] = array( "1AF" => "1AF - *1r Adm.Finan (S) - CF",
                                "1APD" => "1APD - *1r Atenc. Persones Dep.M) - CF",
                                "1ASIX-DAM" => "1ASIX-DAM - *1r Inform. superior (S)L - CF",
                                "1DIE" => "1DIE - 1r Diet - CF",
                                "1EE" => "1EE - *1r Efic. Energ.(S) L - CF",
                                "1EIN" => "1EIN - *1r Educaci - CF",
                                "1ES" => "1ES - *1r Emerg. Sanit.(M)L - CF",
                                "1FAR" => "1FAR - *1r Farm - CF",
                                "1GAD" => "1GAD - *Gesti - CF",
                                "1IEA" => "1IEA - *1r Ins.Elec. Autom(M)L - CF",
                                "1IME" => "1IME - *1r Ins. Mant. Elec.(M) - CF",
                                "1INS A" => "1INS A - *1r Int.Soc.(S)L - CF",
                                "1INS B" => "1INS B - 1r Int. Soc.(S)L - CF",
                                "1LDC" => "1LDC - *1r Lab. Diagnosi C (S). - CF",
                                "1MEC" => "1MEC - *1r Mecanitzaci - CF",
                                "1PM" => "1PM - *1r Prod. Mecanitza(S)L. - CF",
                                "1PRO" => "1PRO - *1r D. A. Projec. C (S) L - CF",
                                "1PRP" => "1PRP - 1r Prev. Riscos Prof.(S) - CF",
                                "1SEA" => "1SEA - i automa (S) - CF",
                                "1SMX A" => "1SMX A - *1r Inform Mitj - CF",
                                "1SMX B" => "1SMX B - *1r Inform. mitj - CF",
                                "1STI" => "1STI - 1r Sis. Teleco. Infor (S) - CF",
                                "2AF" => "2AF - 2n Ad. Finan (S) - CF",
                                "2APD" => "2APD - 2n Atenc. Persones Dep.M) - CF",
                                "2ASIX" => "2ASIX - 2n Adm Sist Inf xarxa(S)L - CF",
                                "2DAM" => "2DAM - 2n Desenv Aplic Mult (S)L - CF",
                                "2DIE" => "2DIE - 2n Diet - CF",
                                "2EE" => "2EE - 2 Efic.Energ.(S) L - CF",
                                "2EIN" => "2EIN - 2n Educaci - CF",
                                "2ES" => "2ES - 2n Emerg. Sanit.(M) - CF",
                                "2FAR" => "2FAR - 2n Farm - CF",
                                "2GAD" => "2GAD - 2n Gest. Adm. (M)L - CF",
                                "2IEA" => "2IEA - *2n Ins.Elec,Autom(M)L - CF",
                                "2IME" => "2IME - 2n Ins. Mant. Elec.(M) - CF",
                                "2INS A" => "2INS A - 2n Integraci - CF",
                                "2INS B" => "2INS B - 2n Integraci - CF",
                                "2LDC" => "2LDC - 2n Lab. Diagnosi C(S) - CF",
                                "2MEC" => "2MEC - 2n Mecanitzaci - CF",
                                "2PM" => "2PM - *2n Prod. Mecanitza.(S) L - CF",
                                "2PRO" => "2PRO - 2n D. A. Projec. C (S) - CF",
                                "2PRP" => "2PRP - 2n Prev. Riscos Prof.(S) - CF",
                                "2SEA" => "2SEA - *2n Sist. Electri i automa (S) - CF",
                                "2SIC" => "2SIC - 2n Soldadura i caldereria (M)  - CF",
                                "2SMX" => "2SMX - 2n Inform. Mitj - CF",
                                "2STI" => "2STI - 2n Sis. teleco. Infor (S) - CF",
                                "CAIA" => "CAIA - *Cures Auxiliar Inf(M) - CF",
                                "CAIB" => "CAIB - *Cures Auxiliar Inf(M) - CF",
                                "CAIC" => "CAIC - Cures Auxiliar Inf(M) - CF",
                                "CAM" => "CAM - *Curs Acc - CF",
                                "CAS A" => "CAS A - *Curs Acc - CF",
                                "CAS B" => "CAS B - *Curs Acc - CF",
                                "CAS C" => "CAS C - Curs Acc - CF",
                                "COM" => "COM - *Comer - CF",
                                "GCM" => "GCM - Ges. Comer. Mar.(S) - CF",
                                "SE" => "SE - Secretariat (S) - CF"
            );

        $this->load_header();  
        $this->load->view('attendance_reports/class_list_report.php',$data);     
        $this->load_footer();      
    }

    function class_sheet_report() {

        $data['grups'] = array( "1AF" => "1AF - *1r Adm.Finan (S) - CF",
                                "1APD" => "1APD - *1r Atenc. Persones Dep.M) - CF",
                                "1ASIX-DAM" => "1ASIX-DAM - *1r Inform. superior (S)L - CF",
                                "1DIE" => "1DIE - 1r Diet - CF",
                                "1EE" => "1EE - *1r Efic. Energ.(S) L - CF",
                                "1EIN" => "1EIN - *1r Educaci - CF",
                                "1ES" => "1ES - *1r Emerg. Sanit.(M)L - CF",
                                "1FAR" => "1FAR - *1r Farm - CF",
                                "1GAD" => "1GAD - *Gesti - CF",
                                "1IEA" => "1IEA - *1r Ins.Elec. Autom(M)L - CF",
                                "1IME" => "1IME - *1r Ins. Mant. Elec.(M) - CF",
                                "1INS A" => "1INS A - *1r Int.Soc.(S)L - CF",
                                "1INS B" => "1INS B - 1r Int. Soc.(S)L - CF",
                                "1LDC" => "1LDC - *1r Lab. Diagnosi C (S). - CF",
                                "1MEC" => "1MEC - *1r Mecanitzaci - CF",
                                "1PM" => "1PM - *1r Prod. Mecanitza(S)L. - CF",
                                "1PRO" => "1PRO - *1r D. A. Projec. C (S) L - CF",
                                "1PRP" => "1PRP - 1r Prev. Riscos Prof.(S) - CF",
                                "1SEA" => "1SEA - i automa (S) - CF",
                                "1SMX A" => "1SMX A - *1r Inform Mitj - CF",
                                "1SMX B" => "1SMX B - *1r Inform. mitj - CF",
                                "1STI" => "1STI - 1r Sis. Teleco. Infor (S) - CF",
                                "2AF" => "2AF - 2n Ad. Finan (S) - CF",
                                "2APD" => "2APD - 2n Atenc. Persones Dep.M) - CF",
                                "2ASIX" => "2ASIX - 2n Adm Sist Inf xarxa(S)L - CF",
                                "2DAM" => "2DAM - 2n Desenv Aplic Mult (S)L - CF",
                                "2DIE" => "2DIE - 2n Diet - CF",
                                "2EE" => "2EE - 2 Efic.Energ.(S) L - CF",
                                "2EIN" => "2EIN - 2n Educaci - CF",
                                "2ES" => "2ES - 2n Emerg. Sanit.(M) - CF",
                                "2FAR" => "2FAR - 2n Farm - CF",
                                "2GAD" => "2GAD - 2n Gest. Adm. (M)L - CF",
                                "2IEA" => "2IEA - *2n Ins.Elec,Autom(M)L - CF",
                                "2IME" => "2IME - 2n Ins. Mant. Elec.(M) - CF",
                                "2INS A" => "2INS A - 2n Integraci - CF",
                                "2INS B" => "2INS B - 2n Integraci - CF",
                                "2LDC" => "2LDC - 2n Lab. Diagnosi C(S) - CF",
                                "2MEC" => "2MEC - 2n Mecanitzaci - CF",
                                "2PM" => "2PM - *2n Prod. Mecanitza.(S) L - CF",
                                "2PRO" => "2PRO - 2n D. A. Projec. C (S) - CF",
                                "2PRP" => "2PRP - 2n Prev. Riscos Prof.(S) - CF",
                                "2SEA" => "2SEA - *2n Sist. Electri i automa (S) - CF",
                                "2SIC" => "2SIC - 2n Soldadura i caldereria (M)  - CF",
                                "2SMX" => "2SMX - 2n Inform. Mitj - CF",
                                "2STI" => "2STI - 2n Sis. teleco. Infor (S) - CF",
                                "CAIA" => "CAIA - *Cures Auxiliar Inf(M) - CF",
                                "CAIB" => "CAIB - *Cures Auxiliar Inf(M) - CF",
                                "CAIC" => "CAIC - Cures Auxiliar Inf(M) - CF",
                                "CAM" => "CAM - *Curs Acc - CF",
                                "CAS A" => "CAS A - *Curs Acc - CF",
                                "CAS B" => "CAS B - *Curs Acc - CF",
                                "CAS C" => "CAS C - Curs Acc - CF",
                                "COM" => "COM - *Comer - CF",
                                "GCM" => "GCM - Ges. Comer. Mar.(S) - CF",
                                "SE" => "SE - Secretariat (S) - CF"
            );

        $this->load_header();   
        $this->load->view('attendance_reports/class_sheet_report.php', $data);     
        $this->load_footer();       
    }

    function informe_resum_grup_di_df_1() {

        $data['grups'] = array( "1AF" => "1AF",
                                "1APD" => "1APD",
                                "1ASIX-DAM" => "1ASIX-DAM",
                                "1DIE" => "1DIE",
                                "1EE" => "1EE",
                                "1EIN" => "1EIN",
                                "1ES" => "1ES",
                                "1FAR" => "1FAR",
                                "1GAD" => "1GAD",
                                "1IEA" => "1IEA",
                                "1IME" => "1IME",
                                "1INS A" => "1INS A",
                                "1INS B" => "1INS B",
                                "1LDC" => "1LDC",
                                "1MEC" => "1MEC",
                                "1PM" => "1PM",
                                "1PRO" => "1PRO",
                                "1PRP" => "1PRP",
                                "1SEA" => "1SEA",
                                "1SMX A" => "1SMX A",
                                "1SMX B" => "1SMX B",
                                "1STI" => "1STI",
                                "2AF" => "2AF",
                                "2APD" => "2APD",
                                "2ASIX" => "2ASIX",
                                "2DAM" => "2DAM",
                                "2DIE" => "2DIE",
                                "2EE" => "2EE",
                                "2EIN" => "2EIN",
                                "2ES" => "2ES",
                                "2FAR" => "2FAR",
                                "2GAD" => "2GAD",
                                "2IEA" => "2IEA",
                                "2IME" => "2IME",
                                "2INS A" => "2INS A",
                                "2INS B" => "2INS B",
                                "2LDC" => "2LDC",
                                "2MEC" => "2MEC",
                                "2PM" => "2PM",
                                "2PRO" => "2PRO",
                                "2PRP" => "2PRP",
                                "2SEA" => "2SEA",
                                "2SIC" => "2SIC",
                                "2SMX" => "2SMX",
                                "2STI" => "2STI",
                                "CAIA" => "CAIA",
                                "CAIB" => "CAIB",
                                "CAIC" => "CAICF",
                                "CAM" => "CAM",
                                "CAS A" => "CAS A",
                                "CAS B" => "CAS B",
                                "CAS C" => "CAS C",
                                "COM" => "COM",
                                "GCM" => "GCM",
                                "SE" => "SE"
            );

        $this->load_header(); 
        $this->load->view('attendance_reports/informe_resum_grup_di_df_1.php',$data);     
        $this->load_footer();    
    }

    function informe_resum_grup_faltes_mes_1() {

        $this->load_header();  
        $this->load->view('attendance_reports/informe_resum_grup_faltes_mes_1.php');     
        $this->load_footer();    
    }

    function load_header() {

        if (!$this->skeleton_auth->logged_in())
        {
            //redirect them to the login page
            redirect($this->skeleton_auth->login_page, 'refresh');
        }

        $header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");
        //JS
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/jquery-1.9.1.js");
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/ui/1.10.3/jquery-ui.js");   

        $this->_load_html_header($header_data); 
        $this->_load_body_header();
    }

    function load_footer() {

        $this->_load_body_footer();    

    }

 }   
