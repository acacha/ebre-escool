<?php

require_once '/usr/share/php/Crypt/CHAP.php';

/**
 * Attendance_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergiturbadenas@gmail.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class enrollment_model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();


    }
    
    function get_primary_key($table_name) {
		$fields = $this->db->field_data($table_name);
		
		foreach ($fields as $field)	{
			if ($field->primary_key) {
					return $field->name;
			}
		} 	
		return false;
	}


	function user_exists($uid,$basedn="") {
        $this->_init_ldap();
        $filter = '(uid='.$uid.')';        
        if ($basedn=="")     {
            $basedn= $this->active_users_basedn;      
        }

        echo "active_users_basedn : " . $this->active_users_basedn . "\n";
        echo "base dn : " . $basedn . "\n";
        echo "Filter : " . $filter . "\n";
        if ($this->_bind()) {
            $sr = ldap_search($this->ldapconn, $basedn, $filter);
            $entries = ldap_count_entries($this->ldapconn, $sr);
            //echo "Count entries: " . $entries ."<br/>";
            if ($entries == 1) {
                $entryid=ldap_first_entry($this->ldapconn, $sr);
                $dn = ldap_get_dn($this->ldapconn, $entryid);
                ldap_close($this->ldapconn);
                return $dn;
            } else if ($entries > 1) {
                echo "Error. Multiple uids found in Ldap!";
                die();
            }

            ldap_close($this->ldapconn);
        }

        return false;
    }


	function deleteLdapUser($user_dn) {

	    $this->_init_ldap();

	    if ($this->_bind()) {
	        if (ldap_delete($this->ldapconn,$user_dn) === false){
	            $error = ldap_error($this->ldapconn);
	            $errno = ldap_errno($this->ldapconn);
	            show_error("Ldap error deleting user " . $user_dn  . " : " . $errno . " - " . $error);
	            ldap_close($this->ldapconn);
	            return $errno;
	        } else {
	            //echo "Used " . $user_dn . " deleted ok!<br/>" . $user_dn;
	        }

	        ldap_close($this->ldapconn);
	    }

	}

	function _init_ldap() {
        // Load the configuration
        $CI =& get_instance();

        $CI->load->config('auth_ldap'); 


        // Verify that the LDAP extension has been loaded/built-in
        // No sense continuing if we can't
        if (! function_exists('ldap_connect')) {
            show_error(lang('php_ldap_notpresent'));
            log_message('error', lang('php_ldap_notpresent_log'));
        }

        $this->hosts = $CI->config->item('hosts');
        $this->ports = $CI->config->item('ports');
        $this->basedn = $CI->config->item('basedn');
        $this->active_users_basedn = $CI->config->item('active_users_basedn');
        $this->account_ou = $CI->config->item('account_ou');
        $this->login_attribute  = $CI->config->item('login_attribute');
        $this->use_ad = $CI->config->item('use_ad');
        $this->ad_domain = $CI->config->item('ad_domain');
        $this->proxy_user = $CI->config->item('proxy_user');
        $this->proxy_pass = $CI->config->item('proxy_pass');
        $this->roles = $CI->config->item('roles');
        $this->auditlog = $CI->config->item('auditlog');
        $this->member_attribute = $CI->config->item('member_attribute');

        //echo "THIS:";
        //var_export($this);
        
    }

	function _bind() {        
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
	        $bind = ldap_bind($this->ldapconn, $this->proxy_user, $this->proxy_pass);
	    }else {
	        $bind = ldap_bind($this->ldapconn);
	    }

	    if(!$bind){
	        log_message('error', lang('unable_anonymous'));
	        show_error(lang('unable_bind'));
	        return false;
	    }   

	    return true;
	}

function get_ldap_passwords($username) {
    $ldap_passwords = new stdClass();

    $userPassword="";
    $sambaNTPassword="";
    $sambaLMPassword="";

    $this->_init_ldap();
    $filter = "(uid=" . trim($username) . ")";    
    //Get Ldap base DN for active users. It could be different from basedn
    $active_users_basedn = $this->config->item('active_users_basedn');    
    if ($this->_bind()) {
        $sr = ldap_search($this->ldapconn, $active_users_basedn, $filter);
        $entries = ldap_count_entries($this->ldapconn, $sr);
        
        if ($entries == 1) {
            $entryid=ldap_first_entry($this->ldapconn, $sr);
            $userPasswordValues = ldap_get_values($this->ldapconn, $entryid, "userPassword");
            $sambaNTPasswordValues = ldap_get_values($this->ldapconn, $entryid, "sambaNTPassword");
            $sambaLMPasswordValues = ldap_get_values($this->ldapconn, $entryid, "sambaLMPassword");
            //$dn = ldap_get_dn($this->ldapconn, $entryid);
            $userPassword=$userPasswordValues[0];
            $sambaNTPassword=$sambaNTPasswordValues[0];
            $sambaLMPassword=$sambaLMPasswordValues[0];


        } else if ($entries > 1) {
            echo "Error. Multiple uids found in Ldap!";
            ldap_close($this->ldapconn);
            die();
        }
        ldap_close($this->ldapconn);
    }

    $ldap_passwords->userPassword = $userPassword;
    $ldap_passwords->sambaNTPassword = $sambaNTPassword;
    $ldap_passwords->sambaLMPassword = $sambaLMPassword;


    return $ldap_passwords;
}

function remove_diacritics_underscore($data){
    // normalize data (remove accent marks) using PHP's *intl* extension
    $data = normalizer_normalize($data);
    // replace everything NOT in the sets you specified with an underscore
    $data = preg_replace("#[^A-Za-z1-9]#","_", $data);

    return $data;
}

function Unaccent($string)
    {
        if (strpos($string = htmlentities($string, ENT_QUOTES, 'UTF-8'), '&') !== false)
        {
            $string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $string), ENT_QUOTES, 'UTF-8');
        }

        return $string;
    }

function remove_diacritics_not_working($data){
    // normalize data (remove accent marks) using PHP's *intl* extension
    $data = normalizer_normalize($data);

    return $data;
}


    function addLdapUser($user_data,$ldap_passwords=false) {
        $CI =& get_instance();

        $CI->load->config('samba');
        
        $this->_init_ldap();
    
        if ($this->_bind()) {
            // Preparar los datos
            $user_data_array = array();

            $user_data_array["objectClass"][7]="extensibleObject";
            $user_data_array["objectClass"][6]="inetOrgPerson";
            $user_data_array["objectClass"][5]="irisPerson";
            $user_data_array["objectClass"][4]="sambaSAMAccount";
            $user_data_array["objectClass"][3]="shadowAccount";
            $user_data_array["objectClass"][2]="posixAccount";
            $user_data_array["objectClass"][1]="person";
            $user_data_array["objectClass"][0]="top";
            
            $user_data_array["cn"]= $user_data->cn;
            
            if ($user_data->sn != "") {
                $user_data_array["sn"]= $user_data->sn;
            }
            if ($user_data->person_sn1 != "") {
                $user_data_array["sn1"]= $user_data->person_sn1;
            }

            if ($user_data->person_sn2 != "") {
                $user_data_array["sn2"]= $user_data->person_sn2;
            }
            if ($user_data->person_givenName != "") {
                $user_data_array["givenName"]= $user_data->person_givenName;
            }

            $user_data_array["uid"]=$user_data->username;

            if ($user_data->mobile != "") {
                $user_data_array["mobile"]=$user_data->mobile;
            }
            if ($user_data->telephoneNumber != "") {
                $user_data_array["homePhone"]=$user_data->telephoneNumber;
            }
            
            //$user_data_array["st"]=$user_data->st;
            if ($user_data->l != null && $user_data->l !="") {
                $user_data_array["l"]=$user_data->l;    
            }
            if ($user_data->postalCode != null && $user_data->postalCode !="") {
                $user_data_array["postalCode"]=$user_data->postalCode;  
            }           
            
            if ($user_data->dateOfBirth != "") {
                $user_data_array["dateOfBirth"]=$user_data->dateOfBirth;
            }
            if ($user_data->email != "") {
                $user_data_array["email"]=$user_data->email;
            }
            if ($user_data->gender != "") { 
                $user_data_array["gender"]=$user_data->gender;
            }
            
            if ($user_data->homePostalAddress != "") {
                $user_data_array["homePostalAddress"]=$user_data->homePostalAddress;
            }
            
            $user_data_array["irisPersonalUniqueID"]=$user_data->irisPersonalUniqueID;
            
            if ($user_data->irisPersonalUniqueIDType != "") {
                $user_data_array["irisPersonalUniqueIDType"]=$user_data->irisPersonalUniqueIDType;
            }

            //TODO: PHOTO
            //$user_data_array["gender"]=$user_data->gender;
        
            if(class_exists('Imagick')){
                $photo_path = "/usr/share/ebre-escool/uploads/person_photos/" . $user_data->photo;
                //echo $photo_path . "\n";
                if ($user_data->photo != ""){
                    if (file_exists($photo_path)) {
                        $im = new Imagick("/usr/share/ebre-escool/uploads/person_photos/" . $user_data->photo);
                        $im->setImageOpacity(1.0);
                        //$im->resizeImage(147,200,Imagick::FILTER_UNDEFINED,0.5,TRUE);
                        //$im->setCompressionQuality(90);
                        $im->setImageFormat('jpeg');
                        $user_data_array['jpegphoto'] = $im->getImageBlob();
                    }   
                }
                
            } else {
                echo "Error: No Imagick class found<br/>";
            }
                        
            $uidnumber = 1000 + (int )$user_data->id;
            $user_data_array["uidnumber"]= $uidnumber;

            if ( $ldap_passwords == false) {
                $user_data_array["userpassword"]="{MD5}".base64_encode(pack("H*",md5($user_data->password)));
            } else {
                $user_data_array["userpassword"]=$ldap_passwords->userPassword;
            }

            $user_data_array["shadowLastChange"]= floor(time()/86400);

            //TODO: posix config file!
            $user_data_array["loginShell"]="/bin/bash";

            $user_data_array["gidnumber"]=$CI->config->item('samba_newusers_gidnumber');
            $user_data_array["homedirectory"]= $CI->config->item('samba_homes_basepath').$user_data->username;
            $user_data_array["sambaSID"]= $CI->config->item('samba_SID') . ($uidnumber*2);
            $user_data_array["sambaDomainName"] = $CI->config->item('samba_domainName');

            if (isset($user_data->sambaLogonScript)) {
                $user_data_array["sambaLogonScript"]=$user_data->sambaLogonScript;
            } else {
                //Assign sambaLogonScript depending on user type
                switch ($user_data->user_type) {
                    case 1:                                         //TEACHER
                        //TODO: at this time teacher are not touched
                        $user_data_array["sambaLogonScript"]=$CI->config->item('samba_teacher_logonScript');
                        break;
                    case 2:                                         //EMPLOYEE
                        $user_data_array["sambaLogonScript"]=$CI->config->item('samba_default_logonScript');
                        break;
                    case 3:                                         //STUDENT
                        $user_data_array["sambaLogonScript"]=$CI->config->item('samba_student_logonScript');
                        break;    
                    default:
                        $user_data_array["sambaLogonScript"]=$CI->config->item('samba_default_logonScript');
                        break;
                }
                
            }

            $user_data_array["sambaHomeDrive"]=$CI->config->item('samba_homeDrive');
            $user_data_array["sambaHomePath"]= $CI->config->item('samba_homePath') . $user_data->username;
            $user_data_array["sambaAcctFlags"]=$CI->config->item('samba_acctFlags');
            $user_data_array["sambaBadPasswordCount"]=$CI->config->item('samba_badPasswordCount');
            $user_data_array["sambaBadPasswordTime"]=$CI->config->item('samba_badPasswordTime');
            $user_data_array["sambaLogonTime"]=$CI->config->item('samba_logonTime');
            $user_data_array["sambaMungedDial"]=$CI->config->item('samba_mungedDial');
            $user_data_array["sambaPrimaryGroupSID"]=$CI->config->item('samba_primaryGroupSID');

            //TODO. Calculate Windows Passwords         
            $cr = new Crypt_CHAP_MSv1();        

            if ( $ldap_passwords == false) {
                $user_data_array["sambaNTPassword"]=strtoupper(bin2hex($cr->ntPasswordHash($user_data->password)));
                $user_data_array["sambaLMPassword"]=strtoupper(bin2hex($cr->lmPasswordHash($user_data->password)));         
            } else {
                $user_data_array["sambaNTPassword"]=$ldap_passwords->sambaNTPassword;
                $user_data_array["sambaLMPassword"]=$ldap_passwords->sambaLMPassword;       
            }
            
            
            
            //echo "user dn: " . $user_data->dn . "<br/>";
            //echo "user_data_array: " . var_dump($user_data_array) . "<br/>";

            if ($user_data->dn == "") {
                //Calculate user dn using user type
                //$user_data->dn
            }
            //echo "user_data->dn: " . $user_data->dn;
            if (ldap_add($this->ldapconn, $this->Unaccent($user_data->dn),$user_data_array) === false){
                $error = ldap_error($this->ldapconn);
                $errno = ldap_errno($this->ldapconn);
                show_error("Ldap error adding user: " . $errno . " - " . $error);
                ldap_close($this->ldapconn);
                return $errno;
            }

            //Add user to groups depending on role:
            // Roles defined at file third_party/skeleton/application/config/skeleton_auth.php:
            /*
                $config['roles'] = array(
                1 => 'intranet_readonly',
                3 => 'intranet_admin',
                5 => 'intranet_dataentry',
                7 => 'intranet_organizationalunit',
                9 => 'intranet_teacher',
                11 => 'intranet_student'
                );
            */
            // teacher: rol intranet_teacher cn=intranet_teacher,ou=groups,ou=maninfo,ou=Personal,ou=All,dc=iesebre,dc=com
            // student: intranet_student --> cn=intranet_student,ou=groups,ou=maninfo,ou=Personal,ou=All,dc=iesebre,dc=com
            $group_to_search_dn = 'intranet_student';
            if ($group_to_search_dn!=null) {
                //Search group dn
                $group = $this->get_group($group_to_search_dn);

                if ($group->dn) {
                    if (!in_array($user_data->username, $group->users)) {
                        $this->add_uid_to_group($group->dn,$user_data->username);
                    }
                }
            }
            ldap_close($this->ldapconn);
            return true;

        }
        
        return false;
    }

function add_uid_to_group($group_dn,$username) {

		$this->_init_ldap();
		if ($this->_bind()) {

			// first check if username is already in group:
			$entry["memberUid"]=$username;
			$result = ldap_mod_add ( $this->ldapconn , $group_dn , $entry );
			return $result;
		}

		return false;

	}    

function get_group ($group_name) {

		$this->_init_ldap();
		$filter = '(&(objectClass=posixGroup)(cn=' . $group_name . '))';
		$basedn = $this->active_users_basedn;
		if ($this->_bind()) {
            //echo "basedn: " . $basedn;
	     	$sr = ldap_search($this->ldapconn, $basedn, $filter);
            
	     	$entries = ldap_count_entries($this->ldapconn, $sr);
            //echo "entries: " . $entries;
	     	//echo "Count entries: " . $entries ."<br/>";
	     	if ($entries == 1) {
            
	     		$entryid=ldap_first_entry($this->ldapconn, $sr);
            
	     		$dn = ldap_get_dn($this->ldapconn, $entryid);
        
	     		$group = new stdClass();
	     		$group->dn = $dn;
	     		$values = ldap_get_values($this->ldapconn, $entryid, "memberUid");
	     		$group->users = $values;

	     		return $group;
	     	} else if ($entries > 1) {
	     		echo "Error. Multiple uids found in Ldap!";
	     		die();
	     	} else if ($entries == 0) {
	     		return false;
	     	}
		}
		return false;
	}    

function update_user_ldap_dn($username, $ldap_dn) {

        /*Example SQL
        UPDATE `users` 
        SET `ldap_dn`= "new_ldap_dn" 
        WHERE `username`="username"
        */

        $data = array(
               'ldap_dn' => $ldap_dn
            );

        $this->db->where('username', $username);
        $this->db->update('users', $data);

}




















	/* Enrollment Wizard */

	/* Alumnes */
	//NOTE: All users are potential students
	public function get_students($orderby="asc") {

        $this->db->select('person_id,person_givenName,person_sn1,person_sn2,person_official_id');
		$this->db->from('person');
		$this->db->order_by('person_official_id', $orderby);
		       
        $query = $this->db->get();

		if ($query->num_rows() > 0) {

			$student_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
				if ($row['person_official_id'] == "") {
					continue;
				}
   				$student_array[$i]['student_name'] = $row['person_givenName'];
   				$student_array[$i]['student_surname1'] = $row['person_sn1'];
   				$student_array[$i]['student_surname2'] = $row['person_sn2'];
   				$student_array[$i]['student_fullName'] = $row['person_givenName'] .' '.$row['person_sn1'].' '.$row['person_sn2'] ;
   				$student_array[$i]['student_person_id'] = $row['person_id'];
   				$student_array[$i]['person_official_id'] = $row['person_official_id'];
   				$i++;
			}
			return $student_array;
		}			
		else
			return false;
	}	

	public function get_student_by_username($username, $orderby="asc") {

        $this->db->select('username');
		$this->db->from('users');
		$this->db->where('username',$username);
		       
        $query = $this->db->get();
        //echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			return true;
		}			
		else
			return false;
	}

	public function get_all_person_official_ids($orderby = "ASC") {

		/*
		SELECT `person_official_id` FROM `person` WHERE 1
		*/

        $this->db->select('person_official_id');
		$this->db->from('person');
		$this->db->order_by('person_official_id', $orderby);
		       
        $query = $this->db->get();
		$this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$person_official_ids = array();
			foreach ($query->result_array() as $row)	{
				if ($row['person_official_id']!="")
   					$person_official_ids[] = trim($row['person_official_id']);
   			}
			return $person_official_ids;
		}			
		else
			return false;
	}

    public function get_all_person_official_ids_by_enrollment_period($academic_period_id = null ,$orderby = "ASC") {

        if ($academic_period_id == null) {
            $current_academic_period_shortname = $this->get_current_academic_period()->academic_periods_shortname;
        } else {
            $current_academic_period_shortname = $this->get_academic_period_by_period_id($academic_period_id);
        }

        /*
        SELECT DISTINCT `person_official_id`
        FROM `enrollment` 
        INNER JOIN person ON person.person_id = enrollment.`enrollment_personid`
        WHERE `enrollment_periodid`="2014-15"
        */

        $this->db->select('person_official_id');
        $this->db->distinct();
        $this->db->from('enrollment');
        $this->db->join('person','person.person_id = enrollment.enrollment_personid');
        $this->db->where('enrollment_periodid', $current_academic_period_shortname);
        $this->db->order_by('person_official_id', $orderby);
               
        $query = $this->db->get();
        $this->db->last_query();
        
        if ($query->num_rows() > 0) {

            $person_official_ids = array();
            foreach ($query->result_array() as $row)    {
                if ($row['person_official_id']!="")
                    $person_official_ids[] = trim($row['person_official_id']);
            }
            return $person_official_ids;
        }           
        else
            return false;
    }

	public function get_last_study_id($person_id) {

	    $this->db->select('enrollment_id,enrollment_periodid,enrollment_personid,person_sn1,person_sn2,person_givenName,
	    				   person_official_id,enrollment_study_id,studies_shortname,studies_name,studies_id');
		$this->db->from('enrollment');
		$this->db->join('person','person.person_id = enrollment.enrollment_personid');
		$this->db->join('studies','studies.studies_id = enrollment.enrollment_study_id');
		
		$this->db->where('person_id',$person_id);
		$this->db->limit(1);		
		$this->db->order_by('enrollment_periodid', "DESC");
		       
        $query = $this->db->get();

		//echo $this->db->last_query();

		$last_study_id = array();
		
		if ($query->num_rows() == 1) {
			return $query->row();
		}			

		return false;
	}	

	public function get_previous_enrollments($person_official_id,$orderby="desc") {

		/*
	    
		WHERE person_official_id = "47623732R"
	    */

	    $this->db->select('enrollment_id,enrollment_periodid,enrollment_personid,person_sn1,person_sn2,person_givenName,
	    				   person_official_id,enrollment_study_id,studies_shortname,studies_name,studies_id,classroom_group_id,
	    				   classroom_group_code,classroom_group_shortName,course_id,course_shortname,course_name,studies_law_shortname,
	    				   studies_organizational_unit_shortname');
		$this->db->from('enrollment');
		$this->db->join('person','person.person_id = enrollment.enrollment_personid');
		$this->db->join('studies','studies.studies_id = enrollment.enrollment_study_id');
		$this->db->join('course','course.course_id = enrollment.enrollment_course_id');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = enrollment.enrollment_group_id');
		$this->db->join('studies_law','studies.studies_studies_law_id = studies_law.studies_law_id');
		$this->db->join('studies_organizational_unit','studies.studies_studies_organizational_unit_id = studies_organizational_unit.studies_organizational_unit_id');

		$this->db->where('person_official_id',$person_official_id);

		$this->db->order_by('enrollment_periodid', $orderby);

		       
        $query = $this->db->get();

		//echo $this->db->last_query();

		$previous_enrollments = array();
		
		if ($query->num_rows() > 0) {

			$i=0;
			foreach ($query->result_array() as $row)	{
				$previous_enrollments[$i]['enrollment_periodid'] = $row['enrollment_periodid'];
				$previous_enrollments[$i]['enrollment_id'] = $row['enrollment_id'];
   				$previous_enrollments[$i]['studies_shortname'] = $row['studies_shortname'];
   				$previous_enrollments[$i]['studies_name'] = $row['studies_name'];   				
   				$previous_enrollments[$i]['studies'] = $row['studies_shortname'] . ". " . $row['studies_name'] . " - " . $row['studies_law_shortname'] . " - " . $row['studies_organizational_unit_shortname'] . " (" . $row['studies_id'] . ")" ;
   				$previous_enrollments[$i]['studies_id'] = $row['studies_id'];
                $previous_enrollments[$i]['course_id'] = $row['course_id'];
   				$previous_enrollments[$i]['course_shortname'] = $row['course_shortname'];
                $previous_enrollments[$i]['course_name'] = $row['course_name'];
                $previous_enrollments[$i]['course_fullname'] = $row['course_shortname'] . ". " . $row['course_name'] . " (" . $row['course_id'] . ")";
                $previous_enrollments[$i]['classroomgroup_shortname'] = $row['classroom_group_shortName'];
                $previous_enrollments[$i]['classroom_group_id'] = $row['classroom_group_id'];
                $previous_enrollments[$i]['classroom_group_code'] = $row['classroom_group_code'];
   				$previous_enrollments[$i]['classroomgroup_fullname'] = $row['classroom_group_code'] . ". " . $row['classroom_group_shortName'] . " (" . $row['classroom_group_id'] . ")";
   				$i++;
			}
		}			
		return $previous_enrollments;
	}

	public function get_simultaneous_studies($person_id,$period,$orderby="desc") {

		/*
	    
		SELECT `enrollment_periodid`,`enrollment_study_id`,studies.studies_shortname,studies.studies_name,`enrollment_course_id`,
		       course.course_shortname,course.course_name,`enrollment_group_id`, classroom_group.classroom_group_code, 
		       classroom_group.classroom_group_name
			FROM `enrollment` 
			LEFT JOIN studies ON studies.studies_id = enrollment.`enrollment_study_id`
			LEFT JOIN course ON course.course_id = enrollment.`enrollment_course_id`
			LEFT JOIN classroom_group ON classroom_group.classroom_group_id 	 = enrollment.`enrollment_group_id`
			WHERE `enrollment_personid` = 5599 AND `enrollment_periodid` = "2014-15"
	    */

	    $this->db->select('enrollment.enrollment_id, enrollment.enrollment_periodid, enrollment.enrollment_study_id, studies.studies_shortname, studies.studies_name,
	    	   studies_law.studies_law_shortname,studies_law_name, studies.studies_studies_organizational_unit_id, studies.studies_id,
	    	   enrollment.enrollment_course_id, course.course_shortname, course.course_name, enrollment.enrollment_group_id,
	    	   classroom_group.classroom_group_code, classroom_group.classroom_group_name');
		$this->db->from('enrollment');
		$this->db->join('studies','studies.studies_id = enrollment.enrollment_study_id', "left");
		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id', "left");
		$this->db->join('course','course.course_id = enrollment.enrollment_course_id', "left");
		$this->db->join('classroom_group','classroom_group.classroom_group_id = enrollment.enrollment_group_id', "left");

		$this->db->where('enrollment_personid',$person_id);
		$this->db->where('enrollment_periodid',$period);

		$this->db->order_by('enrollment_periodid', $orderby);

		       
        $query = @$this->db->get();

		//echo $this->db->last_query();

		$simultaneous_studies = array();
		
		if ($query->num_rows() > 0) {

			$i=0;
			foreach ($query->result_array() as $row)	{
				$simultaneous_studies[$i]['enrollment_periodid'] = $row['enrollment_periodid'];
				$simultaneous_studies[$i]['enrollment_id'] = $row['enrollment_id'];
   				$simultaneous_studies[$i]['studies_shortname'] = $row['studies_shortname'];
   				$simultaneous_studies[$i]['studies_name'] = $row['studies_name'];   				
   				$simultaneous_studies[$i]['studies'] = $row['studies_shortname'] . ". " . $row['studies_name'] . " - " . $row['studies_law_shortname'] . " - " . $row['studies_organizational_unit_shortname'] ;
   				$simultaneous_studies[$i]['studies_id'] = $row['studies_id'];
   				$simultaneous_studies[$i]['course'] = $row['course_shortname'] . ". " . $row['course_name'];
   				$simultaneous_studies[$i]['classroomgroup_shortname'] = $row['classroom_group_code'] . ". " . $row['classroom_group_shortName'];
   				$i++;
			}
		}			
		return $simultaneous_studies;
	}

	public function get_enrollment_study_submodules_by_enrollment_id_and_period($enrollment_id,$period,$orderby="asc") {

		/*
		SELECT DISTINCT enrollment_periodid,enrollment_id,study_submodules_id, study_module_shortname, study_module_name , study_submodules_shortname, study_submodules_name, study_submodules_courseid,course.course_shortName,course.course_name, 
		study_submodules_academic_periods_initialDate, study_submodules_academic_periods_endDate, study_submodules_academic_periods_totalHours,study_submodules_order
		FROM  study_submodules_academic_periods
		INNER JOIN study_submodules ON study_submodules.study_submodules_id =  study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id
		INNER JOIN study_module ON study_submodules.study_submodules_study_module_id = study_module.study_module_id
		INNER JOIN enrollment_submodules ON enrollment_submodules.enrollment_submodules_submoduleid = study_submodules.study_submodules_id
		INNER JOIN enrollment ON enrollment_submodules.enrollment_submodules_enrollment_id = enrollment.enrollment_id
		INNER JOIN course ON course.course_id = study_submodules.study_submodules_courseid
		WHERE enrollment_periodid = "2014-15" AND enrollment_id=4326 AND study_submodules_academic_periods.study_submodules_academic_periods_academic_period_id=5
		ORDER BY study_module_order ASC,study_submodules_order ASC
		*/

	    $this->db->select('enrollment_periodid,enrollment_id,study_submodules_id, study_module_shortname, study_module_name , 
	    				   study_submodules_shortname, study_submodules_name, study_submodules_courseid,course.course_shortName,
	    				   course.course_name,study_submodules_academic_periods_initialDate, study_submodules_academic_periods_endDate, study_submodules_academic_periods_totalHours,
	    				   study_module_order, study_submodules_order');
	    $this->db->distinct();
		$this->db->from('study_submodules_academic_periods');
		$this->db->join('study_submodules','study_submodules.study_submodules_id =  study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id');
		$this->db->join('study_module','study_submodules.study_submodules_study_module_id = study_module.study_module_id');
		$this->db->join('enrollment_submodules','enrollment_submodules.enrollment_submodules_submoduleid = study_submodules.study_submodules_id');
		$this->db->join('enrollment','enrollment_submodules.enrollment_submodules_enrollment_id = enrollment.enrollment_id');
		$this->db->join('course','course.course_id = study_submodules.study_submodules_courseid');

		$this->db->where('enrollment_periodid',$period);
		$this->db->where('enrollment_id',$enrollment_id);

		$this->db->order_by('study_module_order', $orderby);
		$this->db->order_by('study_submodules_order', $orderby);

		       
        $query = $this->db->get();

		//echo $this->db->last_query();

		$enrollment_study_submodules = array();
		
		if ($query->num_rows() > 0) {

			$i=0;
			foreach ($query->result_array() as $row)	{
				$enrollment_study_submodules[$i]['enrollment_periodid'] = $row['enrollment_periodid'];
				$enrollment_study_submodules[$i]['enrollment_id'] = $row['enrollment_id'];
   				$enrollment_study_submodules[$i]['study_submodules_id'] = $row['study_submodules_id'];
   				$enrollment_study_submodules[$i]['study_submodules_module_name'] = $row['study_module_name'];
   				$enrollment_study_submodules[$i]['study_submodules_module_shortname'] = $row['study_submodules_shortname'];
   				$enrollment_study_submodules[$i]['study_submodules_module'] = $row['study_module_shortname'] . " - " . $row['study_module_name'];
   				$enrollment_study_submodules[$i]['study_submodules_shortname'] = $row['study_submodules_shortname'];
   				$enrollment_study_submodules[$i]['study_submodules_name'] = $row['study_submodules_name'];
   				$enrollment_study_submodules[$i]['study_submodules_courseid'] = $row['study_submodules_courseid'];
   				$enrollment_study_submodules[$i]['study_submodules_course_shortName'] = $row['course_shortName'];
   				$enrollment_study_submodules[$i]['study_submodules_course_name'] = $row['course_name'];
   				$enrollment_study_submodules[$i]['study_submodules_course'] = $row['course_shortName'] . " - " . $row['course_name'];
   				$enrollment_study_submodules[$i]['study_submodules_initialDate'] = $row['study_submodules_academic_periods_initialDate'];
   				$enrollment_study_submodules[$i]['study_submodules_endDate'] = $row['study_submodules_academic_periods_endDate'];
   				$enrollment_study_submodules[$i]['study_submodules_totalHours'] = $row['study_submodules_academic_periods_totalHours'];   				
   				$enrollment_study_submodules[$i]['study_module_order'] = $row['study_module_order'];   				
   				$enrollment_study_submodules[$i]['study_submodules_order'] = $row['study_submodules_order'];   				
   				$i++;
			}
		}			
		return $enrollment_study_submodules;
	}

	function get_current_academic_period() {

		/*
		SELECT academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current FROM academic_periods WHERE academic_periods_current=1
		*/
		$this->db->select('academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current');
		$this->db->from('academic_periods');
		$this->db->where('academic_periods_current',1);
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() == 1){
			$row = $query->row(); 
			return $row;
		}	
		else
			return false;
	}

	function get_current_academic_period_id() {

		/*
		SELECT academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current FROM academic_periods WHERE academic_periods_current=1
		*/
		$this->db->select('academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current');
		$this->db->from('academic_periods');
		$this->db->where('academic_periods_current',1);
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() == 1){
			$row = $query->row(); 
			return $row->academic_periods_id;
		}	
		else
			return false;
	}

	function get_academic_period_id_by_period($period_shortname) {

		/*
		SELECT academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current FROM academic_periods WHERE academic_periods_current=1
		*/
		$this->db->select('academic_periods_id');
		$this->db->from('academic_periods');
		$this->db->where('academic_periods_shortname',$period_shortname);
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() == 1){
			$row = $query->row(); 
			return $row->academic_periods_id;
		}	
		else
			return false;
	}

    function get_academic_period_by_period_id($period_id) {

        /*
        SELECT academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current FROM academic_periods WHERE academic_periods_current=1
        */
        $this->db->select('academic_periods_shortname');
        $this->db->from('academic_periods');
        $this->db->where('academic_periods_id',$period_id);
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1){
            $row = $query->row(); 
            return $row->academic_periods_shortname;
        }   
        else
            return false;
    }


    public function get_courses_study_module($study_module_id,$period=null,$order_by="ASC") {

        //GET period_id
        $period_id = $this->get_current_academic_period_id();
        if ($period!=null) {
            $period_id = $this->get_academic_period_id_by_period($period);    
        }

        /*
        SELECT study_module_ap_courses_course_id,course_shortname,course_name,course_number
        FROM study_module_ap_courses
        INNER JOIN study_module_academic_periods  ON study_module_academic_periods.study_module_academic_periods_id =   study_module_ap_courses.study_module_ap_courses_study_module_ap_id
        INNER JOIN study_module ON study_module.study_module_id  = study_module_academic_periods.study_module_academic_periods_study_module_id
        INNER JOIN course ON course.course_id = study_module_ap_courses.study_module_ap_courses_course_id
        WHERE study_module_academic_periods_academic_period_id=5 AND study_module_id=1
        */

        $this->db->select('study_module_ap_courses_course_id,course_shortname,course_name,course_number,course_cycle_id, course_study_id');
        $this->db->distinct();
        $this->db->from('study_module_ap_courses');
        $this->db->join('study_module_academic_periods','study_module_academic_periods.study_module_academic_periods_id =   study_module_ap_courses.study_module_ap_courses_study_module_ap_id');
        $this->db->join('study_module','study_module.study_module_id  = study_module_academic_periods.study_module_academic_periods_study_module_id');
        $this->db->join('course','course.course_id = study_module_ap_courses.study_module_ap_courses_course_id');

        $this->db->where('study_module_id',$study_module_id);
        $this->db->where('study_module_academic_periods_academic_period_id',$period_id);

        $this->db->order_by('course_number', $order_by);

               
        $query = $this->db->get();

        //echo $this->db->last_query();

        $courses_study_module = array();        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row)    {
                $course = new stdClass();   

                $course->id = $row->study_module_ap_courses_course_id;
                $course->shortname = $row->course_shortname;
                $course->name = $row->course_name;
                $course->number = $row->course_number;

                $course->cycle_id = $row->course_cycle_id;                
                $course->study_id = $row->course_study_id;

                $courses_study_module[]=$course;
            }
        }   
        return $courses_study_module;

    }

	public function get_enrollment_study_modules_by_enrollment_id_and_period($enrollment_id,$period,$orderby="asc") {

		//GET period_id
		$period_id = $this->get_academic_period_id_by_period($period);

		/*
		
		*/

	    $this->db->select('enrollment_periodid,enrollment_id,study_module_id, study_module_academic_periods_external_code,study_module_shortname, study_module_name,
	    				   study_module_hoursPerWeek,study_module_order');
	    $this->db->distinct();
		$this->db->from('study_module_academic_periods');
		$this->db->join('study_module','study_module.study_module_id = study_module_academic_periods.study_module_academic_periods_study_module_id');
		$this->db->join('enrollment_submodules','enrollment_submodules.enrollment_submodules_moduleid = study_module.study_module_id');
		$this->db->join('enrollment','enrollment_submodules.enrollment_submodules_enrollment_id = enrollment.enrollment_id');

		$this->db->where('enrollment_periodid',$period);
		$this->db->where('enrollment_id',$enrollment_id);
		$this->db->where('study_module_academic_periods_academic_period_id',$period_id);

		$this->db->order_by('study_module_order', $orderby);
 
        $query = $this->db->get();

		//echo(arg1)o $this->db->last_query();

		$enrollment_study_modules = array();
		
		if ($query->num_rows() > 0) {
			$i=0;
			foreach ($query->result_array() as $row)	{
                $courses = $this->get_courses_study_module($row['study_module_id'],$period);
				$enrollment_study_modules[$i]['enrollment_periodid'] = $row['enrollment_periodid'];
				$enrollment_study_modules[$i]['enrollment_id'] = $row['enrollment_id'];
   				$enrollment_study_modules[$i]['study_module_id'] = $row['study_module_id'];
   				$enrollment_study_modules[$i]['study_module_external_code'] = $row['study_module_academic_periods_external_code'];
   				$enrollment_study_modules[$i]['study_module_shortname'] = $row['study_module_shortname'];   				
   				$enrollment_study_modules[$i]['study_module_name'] = $row['study_module_name'];
                $enrollment_study_modules[$i]['courses'] = $courses;
   				$enrollment_study_modules[$i]['study_module_hoursPerWeek'] = $row['study_module_hoursPerWeek'];
   				$enrollment_study_modules[$i]['study_module_order'] = $row['study_module_order'];   				
   				$i++;
			}
		}			
		return $enrollment_study_modules;
	}

	/* Localities */
	public function get_localities($orderby="asc") {
		/*
		SELECT locality_id, locality_name, postalcode.postalcode_code, postalcode_name
		FROM (
		`locality`
		)
		INNER JOIN postalcode ON postalcode.postalcode_localityid = locality.locality_id
		ORDER BY `locality_name` ASC
		*/
		$this->db->select('locality_id,locality_name,postalcode_code,postalcode_name');
		$this->db->from('locality');	
		$this->db->join('postalcode','postalcode.postalcode_localityid = locality.locality_id');
	
		$this->db->order_by('locality_name', $orderby);
		       
        $query = $this->db->get();
		$this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$localities = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
   				$localities[$i]['locality_id'] = $row['locality_id'];
   				$localities[$i]['locality_name'] = $row['locality_name'];
   				$localities[$i]['locality_postal_code'] = $row['postalcode_code'];   				
   				$i++;
			}
			return $localities;
		}			
		else
			return false;
	}


	/* Studies */
	public function get_enrollment_studies($orderby="asc") {

        $this->db->select('studies_id,studies_shortname,studies_name,studies_studies_law_id,studies_law_shortname,studies_organizational_unit_shortname');
		$this->db->from('studies');
		$this->db->join('studies_law','studies.studies_studies_law_id = studies_law.studies_law_id');
		$this->db->join('studies_organizational_unit','studies.studies_studies_organizational_unit_id = studies_organizational_unit.studies_organizational_unit_id');
        $this->db->join('studies_academic_periods','studies_academic_periods.studies_academic_periods_study_id = studies.studies_id');
        $this->db->where('studies_academic_periods_academic_period_id',6);

		//$this->db->order_by('studies_id', $orderby);
        $this->db->order_by('studies_shortname', $orderby);
		       
        $query = $this->db->get();
		$this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$studies_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
   				$studies_array[$i]['studies_id'] = $row['studies_id'];
   				$studies_array[$i]['studies_shortname'] = $row['studies_shortname'];
   				$studies_array[$i]['studies_name'] = $row['studies_name'];
   				$studies_array[$i]['studies_law_shortname'] = $row['studies_law_shortname']; 
   				$studies_array[$i]['studies_organizational_unit_shortname'] = $row['studies_organizational_unit_shortname']; 
   				  				
   				$i++;
			}
			return $studies_array;
		}			
		else
			return false;
	}	

    public function is_study_multiple($study_id) {
        //SELECT `studies_multiple` FROM `studies` WHERE `studies_id`=2
        
        $this->db->select('studies_multiple');
        $this->db->from('studies');
        $this->db->where('studies_id',$study_id);
        
        $query = $this->db->get();
        //echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            $row = $query->row();

            if ($row->studies_multiple == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }        

    }

	/* Cursos */
	public function get_enrollment_courses($study=false,$orderby="asc") {

		if(!$study){
			$study=2;	//	"ASIX-DAM"
		}

        $is_study_multiple = $this->is_study_multiple($study);

        //Check if study is multiple

        //TODO: 3x2 ASIX-DAM
        // Courses: 1ASIX-DAM | 2 DAM i 1ASIX-DAM | 2DAM
        // STUDIES:
        // ASIX-DAM: 2
        // DAM : 31
        // ASIX: 29

        // COURSE: ASIX-DAM ha de pertanyar a 3 studies: DAM (31) ASIX (29) i ASIX-DAM (2) 
        // TAULA course_studies relació 1 a n? NO. Camp 3x2 true o false. Si true el codi curs es busqui a un altre taula?

        if ($is_study_multiple) {
            /*
            SELECT `course_studies_course_id`,`course_shortname`,`course_name`
            FROM `course_studies` 
            INNER JOIN course ON course_studies.`course_studies_course_id` =course.course_id
            WHERE `course_studies_study_id`=29
            */

            $this->db->select('course_studies_course_id,course_shortname,course_name');
            $this->db->distinct();
            $this->db->from('course_studies');
            $this->db->join('course','course_studies.course_studies_course_id =course.course_id');
            $this->db->join('courses_academic_periods','courses_academic_periods.courses_academic_periods_course_id = course.course_id');
            $this->db->join('studies_academic_periods','studies_academic_periods.studies_academic_periods_study_id = course_studies.course_studies_study_id');
            $this->db->where('course_studies_study_id',$study);
            $this->db->where('courses_academic_periods_academic_period_id',6);
            $this->db->where('studies_academic_periods_academic_period_id',6);

            
            $query = $this->db->get();
            //echo $this->db->last_query();

            if ($query->num_rows() > 0) { 
                $courses_array = array();
                $i=0;
                foreach ($query->result_array() as $row)    {
                    $courses_array[$i]['course_id'] = $row['course_studies_course_id'];
                    $courses_array[$i]['course_name'] = $row['course_name'];
                    $courses_array[$i]['course_shortname'] = $row['course_shortname'];
                    $i++;
                }
                return $courses_array;
                }
        } else {
            $this->db->select('course_id, course_shortname, course_name');
            $this->db->distinct();
            $this->db->from('course');
            $this->db->join('studies','course_study_id=studies_id');
            $this->db->join('courses_academic_periods','courses_academic_periods.courses_academic_periods_course_id = course.course_id');
            $this->db->join('studies_academic_periods','studies_academic_periods.studies_academic_periods_study_id = studies.studies_id');
            $this->db->where('studies_id',$study);
            $this->db->where('courses_academic_periods_academic_period_id',6);
            $this->db->where('studies_academic_periods_academic_period_id',6);


            
            $query = $this->db->get();
            //echo $this->db->last_query();

            if ($query->num_rows() > 0) {

                $courses_array = array();
                $i=0;
                foreach ($query->result_array() as $row)    {
                    $courses_array[$i]['course_id'] = $row['course_id'];
                    $courses_array[$i]['course_name'] = $row['course_name'];
                    $courses_array[$i]['course_shortname'] = $row['course_shortname'];
                    $i++;
                }
                return $courses_array;
            }           
            else
                return false;

        }
	}	

	/* Grups de classe */
	public function get_enrollment_classroom_groups($study=false,$course_id=false,$orderby="asc") {

		if(!$study){
			$study=2;	//	"ASIX-DAM"
		}

		$this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name,course_shortname,course_name,studies_shortname,studies_name');
		$this->db->from('classroom_group');
		$this->db->join('course','classroom_group_course_id=course_id');
		$this->db->join('studies','course_study_id=studies_id');
        $this->db->join('classroom_group_academic_periods','classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id=classroom_group.classroom_group_id');
		$this->db->where('studies_id',$study);
		$this->db->where('course_id',$course_id);
        $this->db->where('classroom_group_academic_periods_academic_period_id',6);
		$this->db->order_by('classroom_group_id', $orderby);
		
        $query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$classroom_group_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
   				$classroom_group_array[$i]['classroom_group_id'] = $row['classroom_group_id'];
   				$classroom_group_array[$i]['classroom_group_code'] = $row['classroom_group_code'];
   				$classroom_group_array[$i]['classroom_group_shortName'] = $row['classroom_group_shortName'];
   				$classroom_group_array[$i]['classroom_group_name'] = $row['classroom_group_name'];
   				$i++;
			}
			return $classroom_group_array;
		}			
		else
			return false;
	}	

	/* Classroom Groups Names from Classroom Groups ID */
	public function get_enrollment_classroom_groups_from_id($groups_id,$orderby="asc") {

		$this->db->select('classroom_group_code,classroom_group_shortName,classroom_group_name');
		$this->db->from('classroom_group');
		$this->db->where_in('classroom_group_id',$groups_id);
		$this->db->order_by('classroom_group_id', $orderby);
		
        $query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$classroom_group_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
   				$classroom_group_array[$i]['classroom_group_code'] = $row['classroom_group_code'];
   				$classroom_group_array[$i]['classroom_group_shortName'] = $row['classroom_group_shortName'];
   				$classroom_group_array[$i]['classroom_group_name'] = $row['classroom_group_name'];
   				$i++;
			}
			return $classroom_group_array;
		}			
		else
			return false;
	}	


	/* Mòduls */
	public function get_enrollment_study_modules($courses=false, $course_id=false, $orderby="asc",$order_field = "") {
		
        $current_academic_period = $this->get_current_academic_period_id();

		if(!$courses){
			//$course_id=3;	//	"1ASIX-DAM"
		}		
		
        /*
        SELECT DISTINCT study_module_ap_courses_course_id, study_module_academic_periods_study_module_id, course_shortname, course_name, study_module_shortname, study_module_name
        FROM study_module_ap_courses
        INNER JOIN study_module_academic_periods ON study_module_ap_courses.study_module_ap_courses_study_module_ap_id = study_module_academic_periods.study_module_academic_periods_id
        INNER JOIN course ON course.course_id = study_module_ap_courses_course_id
        INNER JOIN study_module ON study_module.study_module_id = study_module_academic_periods_study_module_id
        WHERE study_module_ap_courses_course_id =1
        AND study_module_academic_periods_academic_period_id =5
        */

        $this->db->select('study_module_ap_courses_course_id, study_module_academic_periods_study_module_id, course_id ,course_shortname, course_name, study_module_shortname, study_module_name');
        $this->db->distinct();
		$this->db->from('study_module_ap_courses');
		$this->db->join('study_module_academic_periods','study_module_ap_courses.study_module_ap_courses_study_module_ap_id = study_module_academic_periods.study_module_academic_periods_id');
        $this->db->join('course','course.course_id = study_module_ap_courses_course_id');
        $this->db->join('study_module','study_module.study_module_id = study_module_academic_periods_study_module_id');
		$this->db->where_in('study_module_ap_courses_course_id', $courses);
        $this->db->where('study_module_academic_periods_academic_period_id', $current_academic_period);
		$this->db->order_by('study_module_ap_courses_course_id', $orderby);
		if ($order_field != "") {
			if ($order_field == "order") {
				$this->db->order_by('study_module_order', $orderby);
			}
		} else {
			$this->db->order_by('study_module_shortname', $orderby);	
		}
		
		       
        $query = $this->db->get();

   		//echo $this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$study_module_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
   				$study_module_array[$i]['study_module_id'] = $row['study_module_academic_periods_study_module_id'];
   				$study_module_array[$i]['study_module_shortname'] = $row['study_module_shortname'];
   				$study_module_array[$i]['study_module_name'] = $row['study_module_name'];
   				$study_module_array[$i]['study_module_ap_courses_course_id'] = $row['study_module_ap_courses_course_id'];
                $study_module_array[$i]['course_id'] = $row['course_id'];
   				$study_module_array[$i]['course_shortname'] = $row['course_shortname'];
   				$study_module_array[$i]['course_name'] = $row['course_name'];
   				
   				if($row['study_module_ap_courses_course_id'] == $course_id){
   					$study_module_array[$i]['selected_course'] = 'yes';
   				} else {
					$study_module_array[$i]['selected_course'] = 'no';
   				}

   				$i++;
			}
			return $study_module_array;
		}			
		else
			return false;
	}	


	/* Unitats formatives */
	public function get_enrollment_all_study_submodules_by_study($study_id=false,$orderby="asc",$order_field="") {

        if(!$study_id){
			//TODO set default study by config file
			$study_id=1;
		}

        $current_academic_period_id = $this->get_current_academic_period_id();

        //Check if study is multiple
        $is_study_multiple = $this->is_study_multiple($study_id);        

        if (!$is_study_multiple) {
            $this->db->select('study_submodules_id,study_submodules_shortname,study_submodules_name,study_module_shortname,study_submodules_courseid,
                           study_module_order,study_submodules_study_module_id');
            $this->db->from('study_submodules');
            $this->db->join('study_module','study_submodules_study_module_id=study_module_id');
            $this->db->join('course','course.course_id = study_submodules.study_submodules_courseid');
            $this->db->join('studies','studies.studies_id = course.course_study_id');
            $this->db->join('study_submodules_academic_periods','study_submodules_id=study_submodules_academic_periods_study_submodules_id');
            $this->db->where('studies.studies_id',$study_id);
            $this->db->where('study_submodules_academic_periods_academic_period_id',$current_academic_period_id);

            if ( $order_field != "") {
                if ( $order_field == "order") {
                    $this->db->order_by('study_module_order', $orderby);
                    $this->db->order_by('study_submodules_order', $orderby);                
                }
            } else {
                $this->db->order_by ('study_submodules_id', $orderby);
            }
           
            $query = $this->db->get();
            //echo $this->db->last_query();

            $study_submodules_array = array();
            
            if ($query->num_rows() > 0) {
                $i=0;
                foreach ($query->result_array() as $row)    {
                    $study_submodules_array[$i]['study_module_shortname'] = $row['study_module_shortname'];
                    $study_submodules_array[$i]['study_module_id'] = $row['study_submodules_study_module_id'];
                    $study_submodules_array[$i]['study_submodules_id'] = $row['study_submodules_id'];
                    $study_submodules_array[$i]['study_submodules_shortname'] = $row['study_submodules_shortname'];
                    $study_submodules_array[$i]['study_submodules_name'] = $row['study_submodules_name'];
                    $study_submodules_array[$i]['study_submodules_courseid'] = $row['study_submodules_courseid'];
                    $study_submodules_array[$i]['study_submodules_study_module_id'] = $row['study_submodules_study_module_id'];                 
                    $i++;
                }  
            }           
            return $study_submodules_array;
        } else {
            /*
            SELECT study_submodules_id, study_submodules_shortname, study_submodules_name, study_module_shortname, study_module_order, study_submodules_study_module_id,study_submodules_courseid, studies.studies_id
            FROM (study_submodules)
            JOIN study_module ON study_submodules_study_module_id=study_module_id
            JOIN course_studies ON course_studies.course_studies_course_id   = study_submodules.study_submodules_courseid
            JOIN studies ON studies.studies_id = course_studies.course_studies_study_id
            WHERE studies.studies_id =  '2'
            ORDER BY study_module_order asc, study_submodules_order asc
            */

            $this->db->select('study_submodules_id,study_submodules_shortname,study_submodules_name,study_module_shortname,study_submodules_courseid,
                           study_module_order,study_submodules_study_module_id');
            $this->db->from('study_submodules');
            $this->db->join('study_module','study_submodules_study_module_id=study_module_id');
            $this->db->join('course_studies','course_studies.course_studies_course_id = study_submodules.study_submodules_courseid');
            $this->db->join('studies','studies.studies_id = course_studies.course_studies_study_id');
            $this->db->join('study_submodules_academic_periods','study_submodules_id=study_submodules_academic_periods_study_submodules_id');
            $this->db->where('studies.studies_id',$study_id);
            $this->db->where('study_submodules_academic_periods_academic_period_id',$current_academic_period_id);

            if ( $order_field != "") {
                if ( $order_field == "order") {
                    $this->db->order_by('study_module_order', $orderby);
                    $this->db->order_by('study_submodules_order', $orderby);                
                }
            } else {
                $this->db->order_by ('study_submodules_id', $orderby);
            }
           
            $query = $this->db->get();
            //echo $this->db->last_query();

            $study_submodules_array = array();
            
            if ($query->num_rows() > 0) {
                $i=0;
                foreach ($query->result_array() as $row)    {
                    $study_submodules_array[$i]['study_module_shortname'] = $row['study_module_shortname'];
                    $study_submodules_array[$i]['study_module_id'] = $row['study_submodules_study_module_id'];
                    $study_submodules_array[$i]['study_submodules_id'] = $row['study_submodules_id'];
                    $study_submodules_array[$i]['study_submodules_shortname'] = $row['study_submodules_shortname'];
                    $study_submodules_array[$i]['study_submodules_name'] = $row['study_submodules_name'];
                    $study_submodules_array[$i]['study_submodules_courseid'] = $row['study_submodules_courseid'];
                    $study_submodules_array[$i]['study_submodules_study_module_id'] = $row['study_submodules_study_module_id'];                 
                    $i++;
                }  
            }           
            return $study_submodules_array;

        }
    }	

	/* Unitats formatives */
	public function get_enrollment_all_study_submodules_by_modules($study_modules=false,$course_id=false,$orderby="asc",$order_field="") {

		if(!$study_modules){
			//TODO set default study by config file
			$study_modules[]=282;	//	"M1"
			$study_modules[]=268;	//	"M2"
		}

        $current_academic_period_id = $this->get_current_academic_period_id();

        $this->db->select('study_submodules_id,study_submodules_shortname,study_submodules_name,study_module_shortname,
        				   study_module_order,study_submodules_study_module_id');
		$this->db->from('study_submodules');
		$this->db->join('study_module','study_submodules_study_module_id=study_module_id');
        $this->db->join('study_submodules_academic_periods','study_submodules_id=study_submodules_academic_periods_study_submodules_id');
		$this->db->where_in('study_submodules_study_module_id',$study_modules);
        $this->db->where('study_submodules_academic_periods_academic_period_id',$current_academic_period_id);
        if ($course_id != false) {
            $this->db->where('study_submodules_courseid',$course_id);
        }
		if ( $order_field != "") {
			if ( $order_field == "order") {
				$this->db->order_by('study_module_order', $orderby);
				$this->db->order_by('study_submodules_order', $orderby);				
			}
		} else {
			$this->db->order_by ('study_submodules_id', $orderby);
		}

		
		       
        $query = $this->db->get();
		//echo $this->db->last_query();
		$study_submodules_array = array();

		if ($query->num_rows() > 0) {

			
			$i=0;
			foreach ($query->result_array() as $row)	{
				$study_submodules_array[$i]['study_module_shortname'] = $row['study_module_shortname'];
                $study_submodules_array[$i]['study_module_id'] = $row['study_submodules_study_module_id'];
   				$study_submodules_array[$i]['study_submodules_id'] = $row['study_submodules_id'];
   				$study_submodules_array[$i]['study_submodules_shortname'] = $row['study_submodules_shortname'];
   				$study_submodules_array[$i]['study_submodules_name'] = $row['study_submodules_name'];
   				$study_submodules_array[$i]['study_submodules_study_module_id'] = $row['study_submodules_study_module_id'];   				
   				$i++;
			}
			
		}			
		
		return $study_submodules_array;
	}	

	/* Unitats formatives */
	public function get_enrollment_study_submodules($study_modules=false,$classroom_group=false,$orderby="asc",$order_field="") {

        $current_academic_period_id = $this->get_current_academic_period_id();

		if(!$study_modules){
			//$study_modules[]=282;	//	"M1"
			//$study_modules[]=268;	//	"M2"
		}	

        /*
        SELECT DISTINCT study_submodules_id, study_submodules_shortname, study_submodules_name, study_module_shortname, study_module_order, study_submodules_study_module_id, classroom_group_code
        FROM study_module_ap_courses
        INNER JOIN study_module_academic_periods  ON  study_module_academic_periods.study_module_academic_periods_id = study_module_ap_courses.study_module_ap_courses_study_module_ap_id
        INNER JOIN study_module  ON study_module.study_module_id  = study_module_academic_periods.study_module_academic_periods_study_module_id
        INNER JOIN study_submodules ON study_submodules.study_submodules_study_module_id = study_module.study_module_id
        INNER JOIN classroom_group ON classroom_group.classroom_group_course_id= study_module_ap_courses_course_id
        WHERE study_module_ap_courses_course_id IN (1,2) AND study_module_academic_periods_academic_period_id=5
        */

        $this->db->select('study_submodules_id, study_submodules_shortname, study_submodules_name, study_submodules_order , study_module_shortname, study_module_order, 
            study_submodules_study_module_id, classroom_group_code');
        $this->db->distinct();
		$this->db->from('study_module_ap_courses');
		$this->db->join('study_module_academic_periods','study_module_academic_periods.study_module_academic_periods_id = study_module_ap_courses.study_module_ap_courses_study_module_ap_id');
		$this->db->join('study_module','study_module.study_module_id  = study_module_academic_periods.study_module_academic_periods_study_module_id');
		$this->db->join('study_submodules','study_submodules.study_submodules_study_module_id = study_module.study_module_id');
        $this->db->join('classroom_group','classroom_group.classroom_group_course_id= study_module_ap_courses_course_id');
		$this->db->where_in('study_module_ap_courses_course_id',$study_modules);
        $this->db->where('study_module_academic_periods_academic_period_id',$current_academic_period_id);
		if ( $order_field != "") {
			if ( $order_field == "order") {
				$this->db->order_by('study_module_order', $orderby);
				$this->db->order_by('study_submodules_order', $orderby);				
			}
		} else {
			$this->db->order_by ('study_submodules_id', $orderby);
		}

		
		       
        $query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$study_submodules_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
				$study_submodules_array[$i]['study_module_classroom_group_code'] = $row['classroom_group_code'];
				$study_submodules_array[$i]['study_module_shortname'] = $row['study_module_shortname'];
                $study_submodules_array[$i]['study_module_id'] = $row['study_submodules_study_module_id'];
   				$study_submodules_array[$i]['study_submodules_id'] = $row['study_submodules_id'];
   				$study_submodules_array[$i]['study_submodules_shortname'] = $row['study_submodules_shortname'];
   				$study_submodules_array[$i]['study_submodules_name'] = $row['study_submodules_name'];
   				$study_submodules_array[$i]['study_submodules_study_module_id'] = $row['study_submodules_study_module_id'];   				
   				$i++;
			}
			return $study_submodules_array;
		}			
		else
			return false;
	}	

	/* STUDY LAW */
	public function get_study_law($study_id) {

		$this->db->select('studies_studies_law_id,studies_law_shortname');
		$this->db->from('studies');
		$this->db->join('studies_law','studies.studies_studies_law_id = studies_law.studies_law_id');
		$this->db->where('studies.studies_id',$study_id);
		$this->db->limit(1);		

        $query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		}			
		else
			return false;
	}	

	/* STUDY TYPE */
	public function get_study_type($study_id) {

		$this->db->select('studies_organizational_unit_id,studies_organizational_unit_shortname');
		$this->db->from('studies');
		$this->db->join('studies_organizational_unit','studies_organizational_unit.studies_organizational_unit_id = studies.studies_studies_organizational_unit_id');
		$this->db->where('studies.studies_id',$study_id);
		$this->db->limit(1);		

        $query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		}			
		else
			return false;
	}	

	/* STUDY TYPE */
	public function check_enrollment($selected_student,$academic_period) {
		//SQL EXAMPLE:
		//SELECT * FROM `enrollment` WHERE `enrollment_periodid`="2014-15" AND `enrollment_personid` = 5599

		$this->db->select('*');
		$this->db->from('enrollment');
		$this->db->where('enrollment.enrollment_periodid',$academic_period);
		$this->db->where('enrollment.enrollment_personid',$selected_student);
		$this->db->limit(1);		

        $query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		}			
		else
			return false;
	}

    public function get_study_id_from_classroom_group_id($classroom_group_id) {
        /*
        SELECT `course_study_id`
        FROM `classroom_group_academic_periods` 
        INNER JOIN classroom_group ON classroom_group.`classroom_group_id` = `classroom_group_academic_periods`.`classroom_group_academic_periods_classroom_group_id`
        INNER JOIN course ON course.`course_id` = classroom_group.`classroom_group_course_id`
        WHERE `classroom_group_academic_periods_academic_period_id`=5 AND `classroom_group_academic_periods_classroom_group_id`=3
        */

        $current_academic_period_id = $this->get_current_academic_period_id();

        $this->db->select('course_study_id');
        $this->db->from('classroom_group_academic_periods');
        $this->db->join('classroom_group','classroom_group.classroom_group_id = classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id');
        $this->db->join('course','course.course_id = classroom_group.classroom_group_course_id');
        $this->db->where('classroom_group_academic_periods_classroom_group_id',$classroom_group_id);
        $this->db->where('classroom_group_academic_periods_academic_period_id',$current_academic_period_id);
        $this->db->limit(1);

        $query = $this->db->get();  
        //echo $this->db->last_query();

        if ($query->num_rows() == 1) {

            $row = $query->row(); 
            return $row->course_study_id;
        }           
        else
            return false;
    }

    public function get_courses_id_from_classroom_group_id($classroom_group_id) {

        $study_id = $this->get_study_id_from_classroom_group_id($classroom_group_id);
        $current_academic_period_id = $this->get_current_academic_period_id();
        
        /*
        SELECT `course_id`
        FROM `course` 
        INNER JOIN courses_academic_periods ON courses_academic_periods.`courses_academic_periods_course_id`= course.course_id
        WHERE `course_study_id`=2 AND `courses_academic_periods_academic_period_id`=5
        */

        $this->db->select('course_id');
        $this->db->from('course');
        $this->db->join('courses_academic_periods','courses_academic_periods.courses_academic_periods_course_id= course.course_id');
        $this->db->where('course_study_id',$study_id);
        $this->db->where('courses_academic_periods_academic_period_id',$current_academic_period_id);

        $query = $this->db->get();  
        //echo $this->db->last_query();

        $sibling_courses = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row)    {
                $sibling_courses[]= $row->course_id;
            }
            return $sibling_courses;
        }           
        else {
            return $sibling_courses;
        }

    }

	public function get_course_id_from_classroom_group_id($classroom_group_id) {
		//SELECT `classroom_group_course_id`
		//FROM classroom_group
		//INNER JOIN classroom_group_academic_periods ON classroom_group_academic_periods.`classroom_group_academic_periods_classroom_group_id` = classroom_group.classroom_group_id
		//WHERE `classroom_group_id`=45 AND `classroom_group_academic_periods_academic_period_id`=5

		$current_academic_period_id = $this->get_current_academic_period_id();

		$this->db->select('classroom_group_course_id');
		$this->db->from('classroom_group');
		$this->db->join('classroom_group_academic_periods','classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id = classroom_group.classroom_group_id');
		$this->db->where('classroom_group_id',$classroom_group_id);
		$this->db->where('classroom_group_academic_periods_academic_period_id',$current_academic_period_id);
		$this->db->limit(1);

		$query = $this->db->get();	
		//echo $this->db->last_query();

		if ($query->num_rows() == 1) {

			$row = $query->row(); 
			return $row->classroom_group_course_id;
		}			
		else
			return false;


	}

	
	public function get_classroom_groups_from_same_study($current_group) {

		//GET COURSE
		//$course_id = $this->get_course_id_from_classroom_group_id($current_group); <-- PERMIT GROUP CHANGE IN SAME STUDY NOT ONLY SAME COURSE        
        $sibling_courses_array = $this->get_courses_id_from_classroom_group_id($current_group);
		/*
		SELECT classroom_group_id, classroom_group_code, classroom_group_shortName, classroom_group_name, classroom_group_description, classroom_group_course_id
		FROM classroom_group
		INNER JOIN classroom_group_academic_periods ON classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id = classroom_group.classroom_group_id
		WHERE classroom_group_course_id=46 AND classroom_group_academic_periods_academic_period_id=5
		*/

		$current_academic_period_id = $this->get_current_academic_period_id();

        $this->db->select('classroom_group_id, classroom_group_code, classroom_group_shortName, classroom_group_name, classroom_group_description, classroom_group_course_id');
		$this->db->from('classroom_group');
		$this->db->join('classroom_group_academic_periods','classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id = classroom_group.classroom_group_id');
		$this->db->where('classroom_group_academic_periods_academic_period_id', $current_academic_period_id );

        $this->db->where_in('classroom_group_course_id',$sibling_courses_array);
 
		
		$query = $this->db->get();
	
		//echo $this->db->last_query();

		$groups_array = array();
		if ($query->num_rows() > 0) {
			$i=0;
			foreach ($query->result_array() as $row)	{
   				$groups_array[$i]['classroom_group_id'] = $row['classroom_group_id'];
   				$groups_array[$i]['classroom_group_code'] = $row['classroom_group_code'];
   				$groups_array[$i]['classroom_group_shortName'] = $row['classroom_group_shortName'];
   				$groups_array[$i]['classroom_group_name'] = $row['classroom_group_name'];
   				$groups_array[$i]['classroom_group_description'] = $row['classroom_group_description'];
   				$groups_array[$i]['classroom_group_course_id'] = $row['classroom_group_course_id'];
   				$i++;
			}
			return $groups_array;
		}			
		else {
			return $groups_array;
		}
			
	}	

	function delete_enrollments($values) {
		
		//echo "values: " . print_r($values). "\n";
		foreach ($values as $value) {
			if ($value != "") {
				
				//DELETE ON CASCADE
				//1) enrollment table
				// DELETE FROM `enrollment` WHERE `enrollment_id`=1
				//2)  enrollment_submodules
				// DELETE FROM `enrollment_submodules` WHERE enrollment_submodules_enrollment_id=1

				$this->db->where('enrollment_id', $value);
				$this->db->delete('enrollment');

				if ($this->db->affected_rows() == 1) {
					$this->db->where('enrollment_submodules_enrollment_id', $value);
					$this->db->delete('enrollment_submodules');	
				}
			}
		}		
		return true;
	}

    public function get_course_if_from_classroomgroupid($classroomgroup_id) {
        /*
        SELECT `classroom_group_course_id` 
        FROM `classroom_group` 
        WHERE `classroom_group_id`=1
        */

        $this->db->select('classroom_group_course_id');
        $this->db->from('classroom_group');
        $this->db->where('classroom_group_id',$classroomgroup_id);

        $query = $this->db->get();    
        //echo $this->db->last_query();

        if ($query->num_rows() == 1) {
            $row = $query->row();
            return $row->classroom_group_course_id;
        }           
        else
            return false;
    }

	public function change_enrollment_classroom_group($enrollment_id,$current_group,$new_group) {

        $new_course = $this->get_course_if_from_classroomgroupid($new_group);

        if ( $new_course == false) {
            return false;
        }

        //Obtain course of new group:
		
        // IMPORTANT: BE SURE NOT TO USE THIS FUNCTION WITHOUT CHANGING OR VERIFYING OTHER DATA TO BE CONSISTENT!
        // FOR EXAMPLE: if we change classroom group from classrooom group first course to second course then course have to be changes
        // or changing classroom group to another study study have to change too
        /*
		UPDATE `enrollment` 
		SET enrollment_group_id= 5, enrollment_course_id = 6
		WHERE enrollment_group_id= 6 AND enrollment_id= ID_ENROLLMENT
		*/

		$data = array(
           'enrollment_group_id' => $new_group,
           'enrollment_course_id' => $new_course
        );

		$this->db->where('enrollment_group_id', $current_group);
		$this->db->where('enrollment_id', $enrollment_id);
		$this->db->update('enrollment', $data);

		//echo $this->db->last_query();

		if ($this->db->affected_rows() == 1) {
			return true;
		}			
		else {
			return false;
		}
			
	}

    public function change_enrollment_classroom_group_and_course($enrollment_id,$current_group,$new_group,$current_course,$new_course) {
        
        // IMPORTANT: BE SURE NOT TO USE THIS FUNCTION WITHOUT CHANGING OR VERIFYING OTHER DATA TO BE CONSISTENT!
        // FOR EXAMPLE: if we change classroom group from classrooom group first course to second course then course have to be changes
        // or changing classroom group to another study study have to change too
        /*
        UPDATE `enrollment` 
        SET enrollment_group_id= 5, enrollment_course_id = 7
        WHERE enrollment_group_id= 6 AND enrollment_course_id = 4 enrollment_id= ID_ENROLLMENT
        */

        $data = array(
           'enrollment_group_id' => $new_group,
           'enrollment_course_id' => $new_course,
        );

        $this->db->where('enrollment_group_id', $current_group);
        $this->db->where('enrollment_course_id', $current_course);
        $this->db->where('enrollment_id', $enrollment_id);
        $this->db->update('enrollment', $data);

        //echo $this->db->last_query();

        if ($this->db->affected_rows() == 1) {
            return true;
        }           
        else {
            return false;
        }
            
    }

	/* Student Data */
	public function get_student_data_with_enrollment_info($official_id) {

		$current_academic_period_shortname = $this->get_current_academic_period()->academic_periods_shortname;
		/*
		SELECT `enrollment_id`,`enrollment_study_id`,`studies_shortname`,`studies_name`,`enrollment_course_id`,`enrollment_group_id`,`classroom_group_code`,`classroom_group_shortName`,`classroom_group_name`,`person_official_id`, `person`.`person_id`, `person_photo`, `person_secondary_official_id`, `person_givenName`, `person_sn1`, `person_sn2`, `person_email`, `person_secondary_email`, `person_date_of_birth`, `person_gender`, `person_homePostalAddress`, `person_telephoneNumber`, `person_mobile`, `person_locality_id`, `locality_name`, `postalcode_code`, `users`.`username`
		FROM (`person`)
		LEFT JOIN `locality` ON `locality`.`locality_id` = `person`.`person_locality_id`
		LEFT JOIN `postalcode` ON `postalcode`.`postalcode_localityid` = `locality`.`locality_id`
		LEFT JOIN `users` ON `users`.`person_id` = `person`.`person_id`
		INNER JOIN enrollment ON enrollment.`enrollment_personid`  = `person`.`person_id`
		INNER JOIN studies ON studies.`studies_id`  = `enrollment`.`enrollment_study_id`
		INNER JOIN classroom_group ON classroom_group.`classroom_group_id` = `enrollment`.`enrollment_group_id`
		WHERE `person_official_id` =  '40922142J' AND `enrollment_periodid`="2014-15"
		LIMIT 1
		*/

        $this->db->select('enrollment_id,enrollment_study_id,studies_shortname,studies_name,enrollment_course_id,enrollment_group_id,classroom_group_code,
        	classroom_group_shortName,classroom_group_name,person_official_id, person.person_id, person_photo, person_secondary_official_id, person_givenName, 
        	person_sn1, person_sn2, person_email, person_secondary_email, person_date_of_birth, person_gender, person_homePostalAddress, person_telephoneNumber, 
        	person_mobile, person_locality_id, locality_name, postalcode_code, users.username');
		$this->db->from('person');
		$this->db->join('locality','locality.locality_id = person.person_locality_id',"left");
		$this->db->join('postalcode',' postalcode.postalcode_localityid = locality.locality_id',"left");
		$this->db->join('users','users.person_id = person.person_id',"left");
		$this->db->join('enrollment','enrollment.enrollment_personid = person.person_id');
		$this->db->join('studies','studies.studies_id = enrollment.enrollment_study_id');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = enrollment.enrollment_group_id');

		$this->db->where('person_official_id',$official_id);
		$this->db->where('enrollment_periodid',$current_academic_period_shortname);
		$this->db->limit(1);

		$query = $this->db->get();
	
		//echo $this->db->last_query();

		if ($query->num_rows() == 1) {

			return $query->row();
		}			
		else
			return false;
	}	

	/* Student Data */
	public function get_student_data($official_id) {

        $this->db->select('person_official_id,person_official_id_type,person.person_id, person_photo, person_secondary_official_id, person_givenName, person_sn1, person_sn2, person_email,person_secondary_email, person_date_of_birth, person_gender, 
            				   person_homePostalAddress, person_telephoneNumber, person_mobile, person_locality_id , locality_name, postalcode_code,users.username, users.id as userid');
		$this->db->from('person');
		$this->db->join('locality','locality.locality_id = person.person_locality_id',"left");
		$this->db->join('postalcode',' postalcode.postalcode_localityid = locality.locality_id',"left");
		$this->db->join('users','users.person_id = person.person_id',"left");

		$this->db->where('person_official_id',$official_id);
		$this->db->limit(1);		       
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() == 1) {

			return $query->row();
		}			
		else
			return false;
	}	

	public function get_student_enrollment_data($person_id,$period_id) {

        $this->db->select('person_id, enrollment_id, enrollment_periodid, enrollment_personid, enrollment_study_id, studies_shortname , studies_name,
        				   enrollment_course_id,course_shortname, course_name, enrollment_group_id,classroom_group_code,classroom_group_shortName,
        				   classroom_group_name, enrollment_entryDate, enrollment_last_update,
        				   enrollment_creationUserId, enrollment_lastupdateUserId');
		$this->db->from('person');
		$this->db->join('enrollment','enrollment.enrollment_personid = person.person_id');
		$this->db->join('studies','studies.studies_id = enrollment.enrollment_study_id');
		$this->db->join('course','course.course_id = enrollment.enrollment_course_id');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = enrollment.enrollment_group_id');

		$this->db->where('person.person_id',$person_id);
		$this->db->where('enrollment.enrollment_periodid',$period_id);
		$this->db->limit(1);		       
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() == 1) {

			return $query->row();
		}			
		else
			return false;
	}	

	public function get_student_enrollment_data_by_enrollment_id($enrollment_id) {

        $this->db->select('person_id, enrollment_id, enrollment_periodid, enrollment_personid, enrollment_study_id, studies_shortname , studies_name,
        				   enrollment_course_id,course_shortname, course_name, enrollment_group_id,classroom_group_code,classroom_group_shortName,
        				   classroom_group_name, enrollment_entryDate, enrollment_last_update,
        				   enrollment_creationUserId, enrollment_lastupdateUserId');
		$this->db->from('person');
		$this->db->join('enrollment','enrollment.enrollment_personid = person.person_id');
		$this->db->join('studies','studies.studies_id = enrollment.enrollment_study_id');
		$this->db->join('course','course.course_id = enrollment.enrollment_course_id');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = enrollment.enrollment_group_id');

		$this->db->where('enrollment.enrollment_id',$enrollment_id);
		$this->db->limit(1);		       
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() == 1) {

			return $query->row();
		}			
		else
			return false;
	}	

	/* Update Student Data */
	public function update_student_data($person_id,$student) {


        $this->db->where('person_id', $person_id);
		$this->db->update('person', $student); 
		//echo $this->db->last_query();

		if ($this->db->affected_rows() == 1) {
			return true;
		}			
		else
			return false;
	}	

	public function update_user_data($username,$user) {

		$this->db->where('username', $username);
		$this->db->update('users', $user); 
		//echo $this->db->last_query();

		if ($this->db->affected_rows() == 1) {
			return true;
		}			
		else
			return false;

	}

	public function getEnrollmentDataforPDF($person_id) {

		/*
		$givenName = $enrollment_data->givenName;
		$externalID = $enrollment_data->official_id;
		$personal_email = $enrollment_data->email;
		$emailCorporatiu = $enrollment_data->secondary_email;
		$uid = $enrollment_data->uid;
		$sn1 = $enrollment_data->sn1;
		$sn2 = $enrollment_data->sn2;
		*/

		$this->db->select('person_givenName,person_official_id,person_email,person_secondary_email,username,person_sn1,person_sn2');
		$this->db->from('person');
		$this->db->join('users','users.person_id = person.person_id');
		$this->db->where('person.person_id',$person_id);

		$this->db->limit(1);
		       
        $query = $this->db->get();
        //echo $this->db->last_query();

		if ($query->num_rows() == 1) {
			return $query->row();
		}			

		return false;
		
	}





	/* Insert Student Data */
	public function insert_student_data($student) {

		//First INSERT DATA AT PESON TABLE
        $this->db->insert('person', $student); 
		//echo $this->db->last_query();

		if ($this->db->affected_rows() == 1) {
			return $this->db->insert_id();
		}			
		else
			return false;
	}	

	/* Insert User Data */
	public function insert_user_data($user) {

		//First INSERT DATA AT PESON TABLE
        $this->db->insert('users', $user); 
		//echo $this->db->last_query();

		if ($this->db->affected_rows() == 1) {
            return $this->db->insert_id();
		}			
		else
			return false;
	}

	/* ENROLLMENT */

	/* Enrollment */
	// $enrollment = $this->enrollment_model->insert_enrollment($period_id, $person_id, $study_id, $course_id, $classroom_group_id);

	public function insert_enrollment($period_id=false,$person_id=false,$study_id=false,$course_id=false,$class_group_id=false) {
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
		*/

        $data = array(
        	'enrollment_periodid'  =>  $period_id,
        	'enrollment_personid'  =>  $person_id,
        	'enrollment_study_id'  =>  $study_id,
        	'enrollment_course_id' =>  $course_id,
        	'enrollment_group_id'  =>  $class_group_id,
        	'enrollment_entryDate' => date('Y-m-d H:i:s'),
        	'enrollment_creationUserId' => $this->session->userdata("user_id"),
        	'enrollment_lastupdateUserId' => $this->session->userdata("user_id"),
        	'enrollment_markedForDeletion' => 'n',
        	'enrollment_markedForDeletionDate' => '0000-00-00 00:00:00'
        );

        $this->db->insert('enrollment',$data);
		       
		//echo $this->db->last_query();

		if ($this->db->affected_rows() > 0) {

			return $this->db->affected_rows();
		}			
		else
			return false;
	}	



	/* Enrollment Submodules */
	// $enrollment_submodules = $this->enrollment_model->insert_enrollment_submodules($enrollment_id, $study_submodules_ids);   

	public function insert_enrollment_submodules($enrollment_id=false,$submodules_id=false) {

		$affected_rows = 0;
		$data = array();

		//print_r($submodules_id);
		foreach($submodules_id as $elements){

			$submodules_id = explode('#',$elements);

			//print_r($elements);
			if(!isset($submodules_id[1])){
					$data = array(
			        	'enrollment_submodules_enrollment_id' => $enrollment_id,
			        	'enrollment_submodules_moduleid' => $submodules_id[0],
			        	'enrollment_submodules_entryDate' => date('Y-m-d H:i:s'),
			        	'enrollment_submodules_creationUserId' => $this->session->userdata("user_id"),
			        	'enrollment_submodules_lastupdateUserId' => $this->session->userdata("user_id"),
			        	'enrollment_submodules_markedForDeletion' => 'n',
			        	'enrollment_submodules_markedForDeletionDate' => '0000-00-00 00:00:00'
			        );	
			} else {
				if ($submodules_id[1]=="NULL") {
					$data = array(
			        	'enrollment_submodules_enrollment_id' => $enrollment_id,
			        	'enrollment_submodules_moduleid' => $submodules_id[0],
			        	'enrollment_submodules_entryDate' => date('Y-m-d H:i:s'),
			        	'enrollment_submodules_creationUserId' => $this->session->userdata("user_id"),
			        	'enrollment_submodules_lastupdateUserId' => $this->session->userdata("user_id"),
			        	'enrollment_submodules_markedForDeletion' => 'n',
			        	'enrollment_submodules_markedForDeletionDate' => '0000-00-00 00:00:00'
			        );	
				} else {
				
					$data = array(
			        	'enrollment_submodules_enrollment_id' => $enrollment_id,
			        	'enrollment_submodules_moduleid' => $submodules_id[0],
			        	'enrollment_submodules_submoduleid' => $submodules_id[1],
			        	'enrollment_submodules_entryDate' => date('Y-m-d H:i:s'),
			        	'enrollment_submodules_creationUserId' => $this->session->userdata("user_id"),
			        	'enrollment_submodules_lastupdateUserId' => $this->session->userdata("user_id"),
			        	'enrollment_submodules_markedForDeletion' => 'n',
			        	'enrollment_submodules_markedForDeletionDate' => '0000-00-00 00:00:00'
			        );	
				}
			}
			
	        $result = $this->db->insert('enrollment_submodules',$data);

	        if ($result) {
	        	//echo $this->db->last_query();
				$affected_rows += $this->db->affected_rows();	
	        } else {
	        	return false;
	        }
		}

		return $affected_rows;

		/*
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


	/* Enrollment Submodules */
	/* OBSOLET
	public function insert_enrollment_submodules($period_id=false,$person_id=false,$study_id=false,$class_group_id=false,$modules_id=false,$submodules_id=false) {

		$modules = array();
		$submodules = array();

		$affected_rows = 0;

		foreach($submodules_id as $elements){

			$submodules_id = explode('#',$elements);

			//$modules[] = $submodules_id[0];
			//$submodules[] = $submodules_id[1];

		    $data = array(
	        	'enrollment_submodules_periodid' => $period_id,
	        	'enrollment_submodules_personid' => $person_id,
	        	'enrollment_submodules_study_id' => $study_id,
	        	'enrollment_submodules_group_id' => $class_group_id,
	        	'enrollment_submodules_moduleid' => $submodules_id[0],
	        	'enrollment_submodules_submoduleid' => $submodules_id[1]
	        );

	        $this->db->insert('enrollment_submodules',$data);
			       
			//echo $this->db->last_query();
			$affected_rows += $this->db->affected_rows();

		}

	}
	*/

	/* Enrollment Modules */
	/*OBSOLET
	public function insert_enrollment_modules($period_id=false,$person_id=false,$study_id=false,$class_group_id=false,$modules_id=false) {

	$affected_rows = 0;

		foreach($modules_id as $module){

        	$data = array(
        		'enrollment_modules_periodid' => $period_id,
        		'enrollment_modules_personid' => $person_id,
        		'enrollment_modules_study_id' => $study_id,
        		'enrollment_modules_group_id' => $class_group_id,
        		'enrollment_modules_moduleid' => $module
        	);

        $this->db->insert('enrollment_modules',$data);
		
        $affected_rows += $this->db->affected_rows();

		}       
		//echo $this->db->last_query();
		return $affected_rows;
		//if ($this->db->affected_rows() > 0) {

		//	return $this->db->affected_rows();
		//}			
		//else
		//	return false;
	}	*/

	/* Enrollment Studies */
	/* OBSOLET
	public function insert_enrollment_studies($period_id=false,$person_id=false,$study_id=false) {

        $data = array(
        	'enrollment_studies_periodid' => $period_id,
        	'enrollment_studies_personid' => $person_id,
        	'enrollment_studies_study_id' => $study_id
        );

        $this->db->insert('enrollment_studies',$data);
		       
		echo $this->db->last_query();

		if ($this->db->affected_rows() > 0) {

			return $this->db->affected_rows();
		}			
		else
			return false;
	}	
	*/

	/* Enrollment Classroom Group */
	/*OBSOLET
	public function insert_enrollment_class_group($period_id=false,$person_id=false,$study_id=false,$class_group_id=false) {

        $data = array(
        	'enrollment_class_group_periodid' => $period_id,
        	'enrollment_class_group_personid' => $person_id,
        	'enrollment_class_group_study_id' => $study_id,
        	'enrollment_class_group_group_id' => $class_group_id
        );

        $this->db->insert('enrollment_class_group',$data);
		       
		echo $this->db->last_query();

		if ($this->db->affected_rows() > 0) {

			return $this->db->affected_rows();
		}			
		else
			return false;
	}	*/
}