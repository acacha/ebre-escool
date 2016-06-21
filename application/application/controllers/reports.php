<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "skeleton_main.php";

class reports extends skeleton_main {
	
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
        
        $this->_init_config();
	}
	
	protected function _init_config() {
		$this->rules_url="http://moodle.iesebre.com/normesTIC";
		$this->services_url="http://moodle.iesebre.com/serveisTIC";
		
		$this->high_school_name="Institut de l'Ebre";
		$this->high_school_suffix_email="iesebre.com"; 
		
		$this->document_name_suffix="_matriculaTIC.pdf";
		$this->window_header_title="Matrícula TIC de l'alumne";
		
		//IMAGES PATHS
		$this->logo_image="/usr/share/gosa/html/pdfreports/images/logo1.jpeg";
		$this->signature_image="/usr/share/gosa/html/pdfreports/images/signature.jpeg";
		
		//STRINGS
		$this->enrollment_str_title=lang("enrollment_str_title");
		$this->enrollment_str_user=lang("enrollment_str_user");
		$this->enrollment_str_password=lang("enrollment_str_password");
		$this->enrollment_str_internalid=lang("enrollment_str_internalid");
		$this->enrollment_str_email=lang("enrollment_str_email");
		$this->enrollment_str_corporative_email=lang("enrollment_str_corporative_email");
		$this->enrollment_str_userSignature=lang("enrollment_str_userSignature");
		$this->enrollment_str_school_signature=lang("enrollment_str_school_signature");
		$this->enrollment_str_userPageType=lang("enrollment_str_userPageType");
		$this->enrollment_str_school_page_type=lang("enrollment_str_school_page_type");
		$this->enrollment_str_tutor_page_type=lang("enrollment_str_tutor_page_type");
		$this->enrollment_str_important_note=lang("enrollment_str_important_note");
		
	

		$this->enrollment_text2 = lang("enrollment_text2");
		$this->enrollment_text3 = lang("enrollment_text3");
		$this->enrollment_text4 = lang("enrollment_text4");
		$this->enrollment_text5 = lang("enrollment_text5");
	
	}
	
	public function print_massive_enrollment () {
		$all_group_students_dns = (array) $this->session->flashdata('all_group_students_dns');
		$new_passwords_array = (array) $this->session->flashdata('new_passwords_array');
		$group_code = $this->session->flashdata('group_code');
		$url_after_download = $this->session->flashdata('url_after_download');
		
		ob_start();
		/* UNCOMMENT THIS TO ACTIVATE ERROR REPORTING! */
		/*error_reporting(E_ALL);
		ini_set("display_errors", 1);
		*/
		
		error_reporting(0);
		ini_set("display_errors", 0);

		// Mountain Standard Time (MST) Time Zone
		$date= date('j-m-y');	
		setlocale(LC_TIME, "ca_ES.UTF-8");

		//FPDF needs a clean output --> force:
		ob_end_clean();
		
		//CREATE PDF OUPUT:

		//DOCUMENT TITLE: Appears at PDF window title 
		$this->pdf->SetTitle(utf8_decode($this->window_header_title)." ". utf8_decode($fullName), false);
		
		//$all_group_students_dns

		//ONE PAGE PER USER
		$numPages=count($all_group_students_dns);	
		$this->pdf->SetMargins(20, 20, 20);
		$this->pdf->SetLeftMargin(20);
		
		for ($i = 0; $i <= $numPages-1; $i++) {
			//Obtain enrollment data.
			if (!isset($all_group_students_dns[$i]))	{
				continue;
			}
			$enrollment_data= $this->ebre_escool_ldap->getEnrollmentData($all_group_students_dns[$i]);
		
			if ($enrollment_data == "") {
				echo "<br/>Fatal Error! No enrollment data found for DN: " . $all_group_students_dns[$i];
				exit(1);
			}

			$givenName = $enrollment_data['givenname']['0'];
			$internalID = $enrollment_data['highschooluserid']['0'];
			$employeeNumber = $enrollment_data['employeenumber']['0'];
			$externalID = $enrollment_data['irispersonaluniqueid']['0'];
			$personal_email = $enrollment_data['highschoolpersonalemail']['0'];
			$emailCorporatiu = $enrollment_data['email']['0'];
			$uid = $enrollment_data['uid']['0'];
			$sn1 = $enrollment_data['sn1']['0'];
			$sn2 = $enrollment_data['sn2']['0'];


			//PDF Document Name when downloading:
			$documentName=$group_code.$this->document_name_suffix;
			$fullName= $givenName ." ". $sn1 . " " . $sn2;

			$this->pdf->AddPage();
			$this->pdf->SetFont('Times','',18);
			
			//HEADER IMAGE
			$this->pdf->Image($this->logo_image,$this->pdf->GetX(),$this->pdf->GetY());
			
			//TITLE
			$this->pdf->SetY(45);
			$this->pdf->Cell(170,10,utf8_decode($this->enrollment_str_title),1,2,'C');
			
			//TEXTS
			$this->enrollment_text1 = <<<EOF
En/Na $givenName $sn1 $sn2, amb número identificatiu $externalID, ha estat matriculat/da el $date per tal de tenir accés als recursos TIC de l'$this->high_school_name. Les dades que heu d'utilitzar per accedir als recursos TIC del centre són:
EOF;
	
			//TEXT1
			$this->pdf->SetFont('Times','',10);	
			$this->pdf->Ln();
			$this->pdf->write(5,utf8_decode($this->enrollment_text1));
			
			//ENROLLMENT DATA
			//USER
			$this->pdf->Ln();
			$this->pdf->Ln();
			$this->pdf->SetX($this->pdf->GetX()+10);	
			$this->pdf->SetFont('Times','B',10); 
			$this->pdf->write(5,"- ". utf8_decode($this->enrollment_str_user).": ",0);
			$this->pdf->SetFont('Times','',10); 
			$this->pdf->write(5,utf8_decode($uid),0);
			$this->pdf->Ln();
			
			$this->pdf->SetX($this->pdf->GetX()+10);	
			$this->pdf->SetFont('Times','B',10); 
			$this->pdf->write(5,"- ". utf8_decode($this->enrollment_str_password).": ",0);
			$this->pdf->SetFont('Times','',10); 
			$this->pdf->write(5,utf8_decode($new_passwords_array[$i]),0);
			$this->pdf->Ln();
	
			$this->pdf->SetX($this->pdf->GetX()+10);	
			$this->pdf->SetFont('Times','B',10); 
			$this->pdf->write(5,"- ". utf8_decode($this->enrollment_str_internalid).": ",0);
			$this->pdf->SetFont('Times','',10); 
			$this->pdf->write(5,utf8_decode($internalID),0);
			$this->pdf->Ln();
	
			$this->pdf->SetX($this->pdf->GetX()+10);	
			$this->pdf->SetFont('Times','B',10); 
			$this->pdf->write(5,"- ". utf8_decode($this->enrollment_str_email).": ",0);
			$this->pdf->SetFont('Times','',10); 
			$this->pdf->write(5,utf8_decode($personal_email),0);
			$this->pdf->Ln();
	
			$this->pdf->SetX($this->pdf->GetX()+10);	
			$this->pdf->SetFont('Times','B',10); 
			$this->pdf->write(5,"- ". utf8_decode($this->enrollment_str_corporative_email).": ",0);
			$this->pdf->SetFont('Times','',10); 
			$this->pdf->write(5,utf8_decode($uid."@".$this->high_school_suffix_email),0);
			$this->pdf->Ln();
	
			//TEXT 2
			$this->pdf->Ln();		
			$this->pdf->write(5,utf8_decode($this->enrollment_text2));
	
			//RULES URL
			$this->pdf->SetX($this->pdf->GetX()+10);	
			$this->pdf->SetFont('Times','B',10); 
			$this->pdf->write(5,utf8_decode($this->rules_url));
			$this->pdf->Ln();
			$this->pdf->Ln();

			//IMPORTANT NOTE
			$this->pdf->SetFont('Times','',10);	
			$this->pdf->SetLeftMargin(20+10); 
			$this->pdf->SetRightMargin(20+10); 
			$this->pdf->MultiCell(0,5,utf8_decode($this->enrollment_str_important_note),1,"L");
			$this->pdf->SetLeftMargin(20); 
			$this->pdf->SetRightMargin(20); 
			$this->pdf->Ln();
	
			//TEXT3
			$this->pdf->write(5,utf8_decode($this->enrollment_text3));
		
			//SERVICES URL
			$this->pdf->SetX($this->pdf->GetX()+10);	
			$this->pdf->SetFont('Times','B',10); 
			$this->pdf->write(5,utf8_decode($this->services_url));
			$this->pdf->Ln();
			$this->pdf->Ln();
	
			//TEXT 4
			$this->pdf->SetFont('Times','',10); 
			$this->pdf->write(5,utf8_decode($this->enrollment_text4));
			$this->pdf->Ln();
		
			//USER_SIGNATURE
			$this->pdf->SetFont('Times','',10); 
			$this->pdf->write(5,utf8_decode($this->enrollment_str_userSignature. ","));
			$this->pdf->Ln();
	
			//FOOTNOTE
			$this->pdf->SetY(-50);
			$this->pdf->SetFont('Times','',10);	
			$this->pdf->write(5,utf8_decode($this->enrollment_text5));
	
			//OFICIAL SIGNATURE
			$this->pdf->Ln();
			$this->pdf->Image($this->signature_image,$this->pdf->GetX()-3, $this->pdf->GetY());
			$this->pdf->write(5,utf8_decode($this->enrollment_str_school_signature),0);
		
			//TYPE    
			$this->pdf->Ln();
			$this->pdf->Line($this->pdf->GetX(), $this->pdf->GetY(), $this->pdf->GetX()+170, $this->pdf->GetY());
			$this->pdf->SetX(133);
	}
	
	$this->pdf->Output($documentName,"D");
	
	redirect($url_after_download, 'refresh');

}
	
	
	public function print_enrollment () {
		ob_start();
	
		/* UNCOMMENT THIS TO ACTIVATE ERROR REPORTING!
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		*/
		error_reporting(0);
		ini_set("display_errors", 0);
		
		//$old_level_reporting=error_reporting();
		//error_reporting(0);
		require_once ("../../include/php_setup.inc");
		require_once ("functions.inc");
		require_once ("../../plugins/admin/HighSchoolUsers/functions.php");
		require_once ("/usr/share/php/fpdf/fpdf.php");
               


		/////////////////// DO NOT TOUCH WHEN CONFIGURING 

$dn=$_GET['dn'];
$password=$_GET['password'];

if ($dn== "") {
	echo "<br/>Fatal Error! No DN provided at query string!";
	exit(1);
}

if ($password== "") {
	echo "<br/>Fatal Error! No Password provided at query string!";
	exit(1);
}

//Obtain enrollment data.
$enrollment_data=getEnrollmentData($dn);

if ($enrollment_data== "") {
	echo "<br/>Fatal Error! No enrollment data found for DN: " . $dn;
	exit(1);
}

$givenName = $enrollment_data['givenName']['0'];
$internalID = $enrollment_data['highSchoolUserId']['0'];
$employeeNumber = $enrollment_data['employeeNumber']['0'];
$externalID = $enrollment_data['irisPersonalUniqueID']['0'];
$personal_email = $enrollment_data['highSchoolPersonalEmail']['0'];
$emailCorporatiu = $enrollment_data['email']['0'];
$uid = $enrollment_data['uid']['0'];
$sn1 = $enrollment_data['sn1']['0'];
$sn2 = $enrollment_data['sn2']['0'];

// Assuming today is March 10th, 2001, 5:16:18 pm, and that we are in the
// Mountain Standard Time (MST) Time Zone
$date= date('j-m-y');	
setlocale(LC_TIME, "ca_ES.UTF-8");
$day_of_month = strftime("%e");
$month = strftime("%B");
$year = strftime("%G");
//$date2= strftime("%B");

/////////////////// END DO NOT TOUCH WHEN CONFIGURING 

//*******************************************************************
//**          		  CONFIGURATION	END							   **			
//*******************************************************************


//PDF Document Name when downloading:
$documentName=$externalID."_".$internalID.$this->document_name_suffix;
$fullName= $givenName ." ". $sn1 . " " . $sn2;

//uncomment when debugging
//exit();

//FPDF needs a clean output --> force:
ob_end_clean();

//CREATE PDF OUPUT:

//DOCUMENT TITLE: Appears at PDF window title 
$this->pdf->SetTitle(utf8_decode($this->window_header_title)." ". utf8_decode($fullName), false);


//CREATE PAGES: Multiple similar pages with some changes

$numPages=3;
$pageTypes=array("user","school","tutor");

$this->pdf->SetMargins(20, 20, 20);
$this->pdf->SetLeftMargin(20);

for ($i = 1; $i <= $numPages; $i++) {
	$this->pdf->AddPage();
	$this->pdf->SetFont('Times','',18);

	//HEADER IMAGE
	$this->pdf->Image($this->logo_image,$this->pdf->GetX(),$this->pdf->GetY());
	
	//TITLE
	$this->pdf->SetY(45);
	$this->pdf->Cell(170,10,utf8_decode($this->enrollment_str_title),1,2,'C');
	
	//TEXTS
	$this->enrollment_text1 = <<<EOF
En/Na $givenName $sn1 $sn2, amb número identificatiu $externalID, ha estat matriculat/da el $date per tal de tenir accés als recursos TIC de l'$this->high_school_name. Les dades que heu d'utilitzar per accedir als recursos TIC del centre són:
EOF;
	
	//TEXT1
	$this->pdf->SetFont('Times','',10);	
	$this->pdf->Ln();
	$this->pdf->write(5,utf8_decode($this->enrollment_text1));
	
	//ENROLLMENT DATA
	//USER
	$this->pdf->Ln();
	$this->pdf->Ln();
	$this->pdf->SetX($this->pdf->GetX()+10);	
	$this->pdf->SetFont('Times','B',10); 
	$this->pdf->write(5,"- ". utf8_decode($this->enrollment_str_user).": ",0);
	$this->pdf->SetFont('Times','',10); 
	$this->pdf->write(5,utf8_decode($uid),0);
	$this->pdf->Ln();
	
	$this->pdf->SetX($this->pdf->GetX()+10);	
	$this->pdf->SetFont('Times','B',10); 
	$this->pdf->write(5,"- ". utf8_decode($this->enrollment_str_password).": ",0);
	$this->pdf->SetFont('Times','',10); 
	$this->pdf->write(5,utf8_decode($password),0);
	$this->pdf->Ln();
	
	$this->pdf->SetX($this->pdf->GetX()+10);	
	$this->pdf->SetFont('Times','B',10); 
	$this->pdf->write(5,"- ". utf8_decode($this->enrollment_str_internalid).": ",0);
	$this->pdf->SetFont('Times','',10); 
	$this->pdf->write(5,utf8_decode($internalID),0);
	$this->pdf->Ln();
	
	$this->pdf->SetX($this->pdf->GetX()+10);	
	$this->pdf->SetFont('Times','B',10); 
	$this->pdf->write(5,"- ". utf8_decode($this->enrollment_str_email).": ",0);
	$this->pdf->SetFont('Times','',10); 
	$this->pdf->write(5,utf8_decode($personal_email),0);
	$this->pdf->Ln();
	
	$this->pdf->SetX($this->pdf->GetX()+10);	
	$this->pdf->SetFont('Times','B',10); 
	$this->pdf->write(5,"- ". utf8_decode($this->enrollment_str_corporative_email).": ",0);
	$this->pdf->SetFont('Times','',10); 
	$this->pdf->write(5,utf8_decode($uid."@".$this->high_school_suffix_email),0);
	$this->pdf->Ln();
	
	//TEXT 2
	$this->pdf->Ln();		
	$this->pdf->write(5,utf8_decode($this->enrollment_text2));
	
	//RULES URL
	$this->pdf->SetX($this->pdf->GetX()+10);	
	$this->pdf->SetFont('Times','B',10); 
	$this->pdf->write(5,utf8_decode($this->rules_url));
	$this->pdf->Ln();
		$this->pdf->Ln();

		//IMPORTANT NOTE
		$this->pdf->SetFont('Times','',10);	
		$this->pdf->SetLeftMargin(20+10); 
		$this->pdf->SetRightMargin(20+10); 
		$this->pdf->MultiCell(0,5,utf8_decode($this->enrollment_str_important_note),1,"L");
		$this->pdf->SetLeftMargin(20); 
		$this->pdf->SetRightMargin(20); 
		$this->pdf->Ln();
	
		//TEXT3
		$this->pdf->write(5,utf8_decode($this->enrollment_text3));
	
		//SERVICES URL
		$this->pdf->SetX($this->pdf->GetX()+10);	
		$this->pdf->SetFont('Times','B',10); 
		$this->pdf->write(5,utf8_decode($this->services_url));
		$this->pdf->Ln();
		$this->pdf->Ln();
	
		//TEXT 4
		$this->pdf->SetFont('Times','',10); 
		$this->pdf->write(5,utf8_decode($this->enrollment_text4));
		$this->pdf->Ln();
		
		//USER_SIGNATURE
		$this->pdf->SetFont('Times','',10); 
		$this->pdf->write(5,utf8_decode($this->enrollment_str_userSignature. ","));
		$this->pdf->Ln();
	
		//FOOTNOTE
		$this->pdf->SetY(-50);
		$this->pdf->SetFont('Times','',10);	
		$this->pdf->write(5,utf8_decode($this->enrollment_text5));
	
		//OFICIAL SIGNATURE
		$this->pdf->Ln();
		$this->pdf->Image($this->signature_image,$this->pdf->GetX()-3, $this->pdf->GetY());
		$this->pdf->write(5,utf8_decode($this->enrollment_str_school_signature),0);
		
		//TYPE    
		$this->pdf->Ln();
		$this->pdf->Line($this->pdf->GetX(), $this->pdf->GetY(), $this->pdf->GetX()+170, $this->pdf->GetY());
		$this->pdf->SetX(133);
	
		switch ($pageTypes[$i-1]) {
			case "user":
				$this->pdf->write(5,utf8_decode($this->enrollment_str_userPageType),0);
				break;
			case "school":
				$this->pdf->write(5,utf8_decode($this->enrollment_str_school_page_type),0);
				break;
			case "tutor":
				$this->pdf->write(5,utf8_decode($this->enrollment_str_tutor_page_type),0);
				break;
		}
	}
	
	$this->pdf->Output($documentName,"D");


	}
	
	public function index() {
		$this->massive_change_password();
	}
	
	
}
