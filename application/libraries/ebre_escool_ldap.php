<?php
/**
 * Attendance Module Ldap Model
 *
 *
 * @package    	Attendance Module Ldap Model
 * @author     	Sergi Tur <sergitur@ebretic.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */

class ebre_escool_ldap  {
	
	private $all_groups_by_groupcode = array();
	private $all_groups_by_groupdn = array();
	
	function __construct()
    {
        $this->ci =& get_instance();
        
        // Load the language file
        $this->ci->lang->load('ebre_escool_ldap','catalan');
        $this->ci->load->helper('language');
        
        log_message('debug', lang('ebre_escool_model_ldap_initialization'));

        // Load the configuration
        $this->ci->load->config('auth_ldap');
        
        $this->_init();
    }
    
    /**
	* @param array $entries
	* @param array $attribs
	* @desc Sort LDAP result entries by multiple attributes.
	*/
	function ldap_multi_sort(&$entries, $attribs){
		for ($i=1; $i<$entries['count']; $i++){
			$index = $entries[$i];
			$j=$i;
			do {
				//create comparison variables from attributes:
				$a = $b = null;
				foreach($attribs as $attrib){
					$a .= $entries[$j-1][$attrib][0];
					$b .= $index[$attrib][0];
				}
				// do the comparison
				if ($a > $b){
					$is_greater = true;
					$entries[$j] = $entries[$j-1];
					$j = $j-1;
				}else{
					$is_greater = false;
				}
			} while ($j>0 && $is_greater);
			
			$entries[$j] = $index;
		}
    return $entries;
	}
    
     /**
     * @access private
     * @return void
     */
    private function _init() {

        // Verify that the LDAP extension has been loaded/built-in
        // No sense continuing if we can't
        if (! function_exists('ldap_connect')) {
            show_error(lang('php_ldap_notpresent'));
            log_message('error', lang('php_ldap_notpresent_log'));
        }

        $this->hosts = $this->ci->config->item('hosts');
        $this->ports = $this->ci->config->item('ports');
        $this->basedn = $this->ci->config->item('basedn');
        $this->account_ou = $this->ci->config->item('account_ou');
        $this->login_attribute  = $this->ci->config->item('login_attribute');
        $this->use_ad = $this->ci->config->item('use_ad');
        $this->ad_domain = $this->ci->config->item('ad_domain');
        $this->proxy_user = $this->ci->config->item('proxy_user');
        $this->proxy_pass = $this->ci->config->item('proxy_pass');
        $this->roles = $this->ci->config->item('roles');
        $this->auditlog = $this->ci->config->item('auditlog');
        $this->member_attribute = $this->ci->config->item('member_attribute');
    }
       
    public function getGroupTotals($groupdn) {
		if ($this->_bind()) {
			$filter = '(objectClass=posixAccount)';
			$search = ldap_search($this->ldapconn, $groupdn, $filter);
        	$allStudents = ldap_get_entries($this->ldapconn, $search);
        	return $allStudents["count"];
		}
	}
    
       
    public function getAllTeachers($basedn = null) {

		$teachernames=array();
		$professor = array();

		// Imatge Genèrica en cas que el professor no tingui foto o estigui danyada
		//$img_file = "/usr/share/ebre-escool/application/views/attendance_reports/foto.png";
		$img_file = APPPATH.'third_party/skeleton/assets/img/foto.png';
		$imgData = file_get_contents($img_file);
		$src = 'data: '.mime_content_type($img_file).';base64,'.$imgData;

		if ($basedn == null)
			$basedn = $this->basedn;
		if ($this->_bind()) {

			$filter = '(employeeNumber=*)';
			
			$search = ldap_search($this->ldapconn, $basedn, $filter,array("employeeNumber","cn","jpegPhoto"));
        	$allteachernames = ldap_get_entries($this->ldapconn, $search);


        	$contador = 0;
        	foreach ($allteachernames as $teacher){

        			if($contador>0){
        				// Guardo les dades dels professors en un array
						$professor[$contador]['code'] = $teacher['employeenumber'][0];
						$professor[$contador]['name'] = $teacher['cn'][0];

						// Si el professor te foto, la guardo, sino, li assigno la foto genèrica
			        	if(isset($teacher['jpegphoto'][0])){
			        		$professor[$contador]['photo']=$teacher['jpegphoto'][0];
			        	} else {

			        		$professor[$contador]['photo']=$imgData;

			        	}
			        }
				$contador++;
			}
				
		}
		// Ordeno l'array de professors
		sort($professor);

		return $professor;





/*
		$teachernames=array();

		if ($basedn == null)
			$basedn = $this->basedn;
		if ($this->_bind()) {

			$filter = '(employeeNumber=*)';
			
			$search = ldap_search($this->ldapconn, $basedn, $filter,array("employeeNumber","cn","jpegPhoto"));
        	$allteachernames = ldap_get_entries($this->ldapconn, $search);
        	

        	foreach ($allteachernames as $teacher_key => $teacher){
				$teacher_code = $teacher['employeenumber'][0];
				$teacher_name = $teacher['cn'][0];
				$teachernames[$teacher_code] = $teacher_name;
			}
				
		}
		return $teachernames;
*/
	}
	
	public function getEmailAndPhotoData ($user_dn) {
		$enrollment_data="";

		$required_attributes=array('highSchoolPersonalEmail','jpegPhoto');
		
		if ($this->_bind()) {
			$filter = '(objectClass=posixAccount)';		
			$search = ldap_search($this->ldapconn, $user_dn, $filter,$required_attributes);
        	$enrollment_data = ldap_get_entries($this->ldapconn, $search);
        	
        	if ($enrollment_data["count"] != 0) {		
				return $enrollment_data['0'];
			}
		}
		return $enrollment_data;
	}
		
	public function getEnrollmentData ($user_dn) {
		$enrollment_data="";
		
		$required_attributes=array('givenname','highSchoolUserId','employeeNumber','irisPersonalUniqueID','highSchoolPersonalEmail','email','uid','sn1','sn2');
		
		if ($this->_bind()) {
			//$filter = '(objectClass=posixAccount)';		
			$filter = "(&(employeeNumber=*)(objectClass=inetOrgPerson))";
			$search = ldap_search($this->ldapconn, $user_dn, $filter,$required_attributes);
        	$enrollment_data = ldap_get_entries($this->ldapconn, $search);
        	
        	if ($enrollment_data["count"] != 0) {		
				return $enrollment_data['0'];
			}
		}
		return $enrollment_data;
	}
	
	protected function generate_md5_hash($pwd)	{
		return  "{MD5}".base64_encode( pack('H*', md5($pwd)));
	}
	
	/*! \brief Generate samba hashes
	*
	* Given a certain password this constructs an array like
	* array['sambaLMPassword'] etc.
	*
	* \param string 'password'
	* \return array contains several keys for lmPassword, ntPassword, pwdLastSet, etc. depending
	* on the samba version
	*/
	protected function generate_smb_nt_hash($password)	{
	
		$password = addcslashes($password, '$'); // <- Escape $ twice for transport from PHP to console-process.
		$password = addcslashes($password, '$'); 
		$password = addcslashes($password, '$'); // <- And again once, to be able to use it as parameter for the perl script.
		
		$command='perl -MCrypt::SmbHash -e "print join(q[:], ntlmgen %password), $/;"';
		$tmp = $command ;
		$tmp = preg_replace("/%userPassword/", escapeshellarg($password), $tmp);
		$tmp = preg_replace("/%password/", escapeshellarg($password), $tmp);
		
		exec($tmp, $ar);
		reset($ar);
		$hash= current($ar);
	
		if ($hash == "") {
			show_error("Configuration error: " . sprintf("Generating SAMBA hash by running %s failed: check %s!", $command, "sambaHashHook"));
			return(array());
		}
		
		list($lm,$nt)= explode(":", trim($hash));
		
		$attrs['sambaLMPassword']= $lm;
		$attrs['sambaNTPassword']= $nt;
		$attrs['sambaPwdLastSet']= date('U');
		$attrs['sambaBadPasswordCount']= "0";
		$attrs['sambaBadPasswordTime']= "0";
		return($attrs);
	}
	
	public function propose_password() {
		$command='/usr/bin/apg -MCLN -m 8 -n1';
		exec($command, $ar);
		//flush();
		reset($ar);
		return current($ar);
	}
	
	public function propose_passwords($number_of_passwords) {
		$command='/usr/bin/apg -MCLN -m 8 -n'.$number_of_passwords . "| xargs";
		exec($command, $ar);
		//flush();
		reset($ar);
		$result=current($ar);
		return explode(" ",$result);
	}
	
	public function changeLdapPassword($user_dn,$attrs) {
		if ($this->_bind()) {
			if (ldap_modify($this->ldapconn,$user_dn,$attrs) === false){
				$error = ldap_error($this->ldapconn);
				$errno = ldap_errno($this->ldapconn);
				show_error("Ldap error changing password: " . $errno . " - " . $error);
				return false;
			} else {
				return true;
			}
		}
		return false;
	}
		
	public function userHaveShadowAccount($dn) {
		$return_value=false;
		
		if ($this->_bind()) {
			$required_attributes=array("objectClass");
			$filter = '(objectClass=posixAccount)';		
			$search = ldap_search($this->ldapconn, $dn, $filter,$required_attributes);
        	$user = ldap_get_entries($this->ldapconn, $search);
        	
        	if ($user["count"] != 0) {		
				print_r($user[0]["objectClass"]);
				if (in_array("shadowAccount", $user[0]["objectClass"])) {
					$return_value=true;	
				}
			}
		}
		return $return_value;
	}
	
	
	
	public function change_password ($dn, $password )	{
		
		$newpass= "";
		// Not sure, why this is here, but maybe some encryption methods require it.
		mt_srand((double) microtime()*1000000);
		
		//GET_CURRENT_VALUES: "shadowLastChange", "userPassword","sambaNTPassword","sambaLMPassword", "uid", "objectClass"
		// Using dn
		$shadowAccountBool=true;
		
		$shadowAccountBool=$this->userHaveShadowAccount($dn);
		
		//Generate HASH NEW PASS for posixAccount
		$newpass= $this->generate_md5_hash($password);
		
		$attrs= array();
		
		$attrs= $this->generate_smb_nt_hash($password);
		if(!count($attrs) || !is_array($attrs)){
			show_error("Error: cannot generate SAMBA hash! ");
			return(FALSE);    
		}
		
		$attrs['userPassword']= $newpass;

        // For posixUsers - Set the last changed value.
        if($shadowAccountBool){
            $attrs['shadowLastChange'] = (int)(date("U") / 86400);
        }
        
        // Perform ldap operations
        return $this->changeLdapPassword($dn,$attrs);
	}
	
	protected function generate_sha1_hash($password)  {
		if (function_exists('sha1')) {
			$hash = "{SHA}" . base64_encode(pack("H*",sha1($password)));
		}elseif (function_exists('mhash')) {
			$hash = "{SHA}" . base64_encode(mHash(MHASH_SHA1, $password));
		}else{
			show_error("Configuration error generating sha1 password");
			return false;
		}
		return $hash; 
	}
	
	public function getAllGroupStudentsDNs($groupdn) {
		$allGroupStudentsDNs=array();

		if ($this->_bind()) {
			$filter = '(objectClass=posixAccount)';		
			$search = ldap_search($this->ldapconn, $groupdn, $filter);
        	$allGroupStudentsDNsentries = ldap_get_entries($this->ldapconn, $search);
      		$this->ldap_multi_sort($allGroupStudentsDNsentries, array("sn","givenname"));

			foreach ($allGroupStudentsDNsentries as $student){		
				$studentdn = $student['dn'];
				if ($studentdn != "")
					array_push($allGroupStudentsDNs,$studentdn);
			}
		}
		return $allGroupStudentsDNs;
	}
	
	protected function init_all_groups($basedn = null) {
		//fill all_groups array
		$groupdns_by_groupcode=array();
		$groupdns_by_groupdn=array();
		if ($basedn == null)
			$basedn = $this->basedn;
		if ($this->_bind()) {
			$needed_attrs = array('physicalDeliveryOfficeName', 'cn','ou','description');
			$filter = '(physicalDeliveryOfficeName=*)';
			$search = ldap_search($this->ldapconn, $basedn, $filter,$needed_attrs);
        	$allgroupdns = ldap_get_entries($this->ldapconn, $search);
        	        	
        	foreach ($allgroupdns as $group){
				$group_code = $group['physicaldeliveryofficename'][0];
				$groupobj = new stdClass;
				$group_dn = $group['dn'];
				$groupobj->dn = $group_dn;
				$groupobj->code = $group_code;
				$groupobj->name = (isset($group['ou'])) ? $group['ou'][0] : "";
				$groupobj->description = (isset($group['description'])) ? $group['description'][0] : "";	
				
				$groupdns_by_groupcode[$group_code] = $groupobj;
				$groupdns_by_groupdn[$group_dn] = $groupobj;
			}
		}
		$this->all_groups_by_groupcode=$groupdns_by_groupcode;
		$this->all_groups_by_groupdn=$groupdns_by_groupdn;
	}
	
	protected function extractGroupNameFromDN($group_dn) {
		if (array_key_exists($group_dn,$this->all_groups_by_groupdn))	{
			return $this->all_groups_by_groupdn[$group_dn]->name;
		} else {
			return false;
		}
	}
	
	protected function extractGroupCodeFromDN($group_dn) {
		if (array_key_exists($group_dn,$this->all_groups_by_groupdn))	{
			return $this->all_groups_by_groupdn[$group_dn]->code;
		} else {
			return false;
		}
	}
	
	protected function obtainGroupDNfromUserDN($dn) {
		$position_of_people=strpos($dn,"ou=people,");
		
		if (!$position_of_people) return false;
		
		$position=$position_of_people + 10;
		return substr($dn,$position);
	}

	public function getAllGroupStudentsInfo($groupdn) {
		$allGroupStudentsInfo=array();

		// Imatge Genèrica
		$img_file = APPPATH.'third_party/skeleton/assets/img/foto.png';
		$imgData = file_get_contents($img_file);
		$src = 'data: '.mime_content_type($img_file).';base64,'.$imgData;


		if ($this->_bind()) {
			$filter = '(&  (objectClass=posixAccount)(!(objectClass=gosaUserTemplate)))';		
			$required_attributes= array("irisPersonalUniqueID","irisPersonalUniqueIDType","highSchoolTSI","highSchoolUserId","employeeNumber","sn","sn1","sn2",
										"givenName","gender","homePostalAddress","l","postalCode","st","mobile","homePhone","dateOfBirth","uid","uidnumber","highSchoolPersonalEmail",
										"jpegPhoto","gidNumber","homeDirectory","loginShell","sambaDomainName","sambaHomeDrive","sambaHomePath","sambaLogonScript","sambaSID","sambaPrimaryGroupSID");
			$search = @ldap_search($this->ldapconn, $groupdn, $filter,$required_attributes);
        	$allGroupStudentsDNsentries = @ldap_get_entries($this->ldapconn, $search);
      		$this->ldap_multi_sort($allGroupStudentsDNsentries, array("sn","givenname"));
      		
      		$students = array();
			$i=0;
			
			$this->init_all_groups();
			
			if (count($allGroupStudentsDNsentries) != 0) {
				foreach ($allGroupStudentsDNsentries as $studententry){		
					if ($i == 0) {
						$i++;
						continue;
					}
					$student = new stdClass;
					
					$dn=$studententry['dn'];
					
					$group_dn=$this->obtainGroupDNfromUserDN($dn);
					
					$group_name = $this->extractGroupNameFromDN($group_dn);
					$group_code = $this->extractGroupCodeFromDN($group_dn);
					
					$student->dn = $dn;		
					$student->group_code = $group_code;
					$student->group_name = $group_name;
					$student->irisPersonalUniqueID = (isset($studententry['irispersonaluniqueid'])) ? $studententry['irispersonaluniqueid'][0] : "";	
					$student->irisPersonalUniqueIDType = (isset($studententry['irispersonaluniqueidtype'])) ? $studententry['irispersonaluniqueidtype'][0] : "";
					$student->highSchoolTSI = (isset($studententry['highschooltsi'])) ? $studententry['highschooltsi'][0] : "";
					$student->highSchoolUserId = (isset($studententry['highschooluserid'])) ? $studententry['highschooluserid'][0] : "";
					$student->employeeNumber = (isset($studententry['employeenumber'])) ? $studententry['employeenumber'][0] : "";
					$student->sn = (isset($studententry['sn'])) ? $studententry['sn'][0] : "";
					$student->sn1 = (isset($studententry['sn1'])) ? $studententry['sn1'][0] : "";
					$student->sn2 = (isset($studententry['sn2'])) ? $studententry['sn2'][0] : "";
					$student->givenName = (isset($studententry['givenname'])) ? $studententry['givenname'][0] : "";
					$student->gender = (isset($studententry['gender'])) ? $studententry['gender'][0] : "";
					$student->homePostalAddress = (isset($studententry['homepostaladdress'])) ? $studententry['homepostaladdress'][0] : "";
					$student->location = (isset($studententry['l'])) ? $studententry['l'][0] : "";
					$student->postalCode = (isset($studententry['postalcode'])) ? $studententry['postalcode'][0] : "";
					$student->st = (isset($studententry['st'])) ? $studententry['st'][0] : "";
					$student->state = (isset($studententry['st'])) ? $studententry['st'][0] : "";
					$student->mobile = (isset($studententry['mobile'])) ? $studententry['mobile'][0] : "";
					$student->homePhone = (isset($studententry['homephone'])) ? $studententry['homephone'][0] : "";
					$student->dateOfBirth = (isset($studententry['dateofbirth'])) ? $studententry['dateofbirth'][0] : "";
					$student->uid = (isset($studententry['uid'])) ? $studententry['uid'][0] : "";
					$student->uidnumber = (isset($studententry['uidnumber'])) ? $studententry['uidnumber'][0] : "";
					$student->highSchoolPersonalEmail = (isset($studententry['highschoolpersonalemail'])) ? $studententry['highschoolpersonalemail'][0] : "";
					//$student->jpegPhoto = (isset($studententry['jpegphoto'])) ? $studententry['jpegphoto'][0] : "";
					$student->jpegPhoto = (isset($studententry['jpegphoto'])) ? $studententry['jpegphoto'][0] : $imgData;

					$student->gidNumber = (isset($studententry['gidnumber'])) ? $studententry['gidnumber'][0] : "";
					$student->homeDirectory = (isset($studententry['homedirectory'])) ? $studententry['homedirectory'][0] : "";
					$student->loginShell = (isset($studententry['loginshell'])) ? $studententry['loginshell'][0] : "";
					$student->sambaDomainName = (isset($studententry['sambadomainname'])) ? $studententry['sambadomainname'][0] : "";
					$student->sambaHomeDrive = (isset($studententry['sambahomedrive'])) ? $studententry['sambahomedrive'][0] : "";
					$student->sambaHomePath = (isset($studententry['sambahomepath'])) ? $studententry['sambahomepath'][0] : "";
					$student->sambaLogonScript = (isset($studententry['sambalogonscript'])) ? $studententry['sambalogonscript'][0] : "";
					$student->sambaSID = (isset($studententry['sambasid'])) ? $studententry['sambasid'][0] : "";
					$student->sambaPrimaryGroupSID = (isset($studententry['sambaprimarygroupsid'])) ? $studententry['sambaprimarygroupsid'][0] : "";
		
					array_push($allGroupStudentsInfo,$student);
				}
			}
		}
		return $allGroupStudentsInfo;
	}
    
    public function getAllGroupsDNs($basedn = null) {
		$groupdns=array();
		if ($basedn == null)
			$basedn = $this->basedn;
		if ($this->_bind()) {
			//$needed_attrs = array('dn', 'cn', $this->login_attribute);
			$filter = '(physicalDeliveryOfficeName=*)';
			$search = ldap_search($this->ldapconn, $basedn, $filter,array("physicalDeliveryOfficeName"));
        	$allgroupdns = ldap_get_entries($this->ldapconn, $search);
        	        	
        	foreach ($allgroupdns as $group){
				$groupdn = $group['dn'];
				$group_code = $group['physicaldeliveryofficename'][0];
				$groupdns[$group_code] = $groupdn;
			}
		}
		return $groupdns;
	}
	
	public function getGroupDNByGroupCode($groupCode,$basedn = null) {
		
		$groupdn="";
		if ($basedn == null)
			$basedn = $this->basedn;
		if ($this->_bind()) {
			//$needed_attrs = array('dn', 'cn', $this->login_attribute);
			$filter = '(physicalDeliveryOfficeName='.$groupCode.')';
			
			$search = ldap_search($this->ldapconn, $basedn, $filter);
        
			$entries = ldap_get_entries($this->ldapconn, $search);
			
			if($entries['count'] != 0) {
				$groupdn = $entries[0]['dn'];
			} else {
				$this->_audit("ERROR!");
				return FALSE;
			}
		}
		return $groupdn;
	}
    
    public function getTeacherNameByEmployeeNumber ($employeeNumber) {
		$basedn="ou=Profes,ou=All,dc=iesdeltebre,dc=net";
		return $this->getPersonNamebyEmployeeNumber($employeeNumber,$basedn);
	}
	
	protected function _close() {
		ldap_close($this->ldapconn);
	}
	
	protected function _bind() {        
        //Connect
        foreach($this->hosts as $host) {
            $this->ldapconn = ldap_connect($host);
            if($this->ldapconn) {
               break;
            }else {
                log_message('info', lang('error_connecting_to'). ' ' .$uri);
            }
        }
        
        // At this point, $this->ldapconn should be set.  If not... DOOM!
        if(! $this->ldapconn) {
            log_message('error', lang('could_not_connect_to_ldap'));
            show_error(lang('error_connecting_to_ldap'));
        }

       
        // These to ldap_set_options are needed for binding to AD properly
        // They should also work with any modern LDAP service.
        ldap_set_option($this->ldapconn, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($this->ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        
        // Find the DN of the user we are binding as
        // If proxy_user and proxy_pass are set, use those, else bind anonymously
        if($this->proxy_user) {
            $bind = @ldap_bind($this->ldapconn, $this->proxy_user, $this->proxy_pass);
        }else {
            $bind = @ldap_bind($this->ldapconn);
        }

        if(!$bind){
            log_message('error', lang('unable_anonymous'));
            show_error(lang('unable_bind'));
            return false;
        }   
        return true;
	}

    /**
     *
     */
    public function getPersonNamebyEmployeeNumber ($employeeNumber,$basedn=null) {
        if ($this->_bind()) {
			//$needed_attrs = array('dn', 'cn', $this->login_attribute);
			$needed_attrs = array('cn');
			$filter = '(employeeNumber='.$employeeNumber.')';
			$search = ldap_search($this->ldapconn, $basedn, $filter, 
                $needed_attrs);
        
			$entries = ldap_get_entries($this->ldapconn, $search);
	
			if($entries['count'] != 0) {
				$cn = $entries[0]['cn'][0];
				return $cn;
			} else {
				$this->_audit("ERROR!");
				return FALSE;
			}
		}
    }
    
    /**
     * @access private
     * @param string $msg
     * @return bool
     */
    private function _audit($msg){
        $date = date('Y/m/d H:i:s');
        if( ! file_put_contents($this->auditlog, $date.": ".$msg."\n",FILE_APPEND)) {
            log_message('info', lang('error_opening_audit_log'). ' '.$this->auditlog);
            return FALSE;
        }
        return TRUE;
    }
}
