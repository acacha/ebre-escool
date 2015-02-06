<?php
/**
 * ebre_escool_auth_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergiturbadenas@gmail.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class ebre_escool_auth_model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->load->library('ebre_escool');
    }

    function is_user_a_student ($person_id) {

      //STUDENTS ARE ENROLLED USER IN ANY ACADEMIC PERIOD
      //SELECT `enrollment_id` FROM `enrollment` WHERE `enrollment_personid` = 4270

      $this->db->select('enrollment_id');
      $this->db->from('enrollment');
      $this->db->where('enrollment.enrollment_personid',$person_id);

      $query = $this->db->get();

      if ($query->num_rows() > 0) {
        return true;
      }     
        return false;

    } 

    function is_user_a_teacher ($person_id,$academic_period_id = null) {

      if ($academic_period_id == null) {
        $academic_period_id = $this->get_current_academic_period_id();
      }

      $this->db->select('teacher_id');
      $this->db->from('teacher');
      $this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');  
      $this->db->where('teacher_academic_periods_academic_period_id', $academic_period_id );


      $this->db->where('teacher.teacher_person_id',$person_id);

      $query = $this->db->get();
      //echo $this->db->last_query()."<br/>";

      if ($query->num_rows() > 0) {
        return true;
      }     
        return false;
    } 

    public function is_set_force_change_password ($username) {
      /*
      SELECT `force_change_password_next_login`
      FROM `users`
      WHERE `username` = "sergitur"
      */

      $this->db->select('force_change_password_next_login');
      $this->db->from('users');      
      $this->db->where('users.username',$username);
      $this->db->limit(1);
       
      $query = $this->db->get();

      //echo $this->db->last_query()."<br/>";
    
      if ($query->num_rows() == 1) {
        $row = $query->row();
        $force_change_password_next_login = $row->force_change_password_next_login;
        if ( $force_change_password_next_login  == 'y') {
          return true;
        }
      }

      return false;
    }

    function save_google_plus_profile_with_username($user_profile,$username) {
      log_message('debug', 'Executing save_google_plus_profile_with_username...');
      
      $person_id = $this->getPersonIdFromUsername($username);

      if ($person_id!=null) {
        $result = $this->save_google_plus_profile($user_profile);
        log_message('debug', 'Result: ' . $result);
        if ($result == null) {
          //ERROR
          log_message('debug', 'Error saving Google plus profile: ' . print_r($user_profile, TRUE));
          return null;
        } else {
          // Insert/update person_id anf google_plus_id (is $result!) to table n-nrelationship
          $this->insert_update_person_google_plus($person_id,$result);          
        }
      } else {
        log_message('debug', 'Not person found for username' . $username);
        return null;
      }

    }

    function getPersonIdFromUsername($username){
      /*
      SELECT `person_id` FROM `users` WHERE `username`="USERNAME_HERE"
      */
      $this->db->select('person_id');
      $this->db->from('users');
      $this->db->where('username',$username);

      $query = $this->db->get();

      if ($query->num_rows() == 1){
        $row = $query->row(); 
        return $row->person_id;
      } 
      else
        return null;
    }

    function insert_update_person_google_plus($person_id,$google_plus_id) {
      log_message('debug', 'Executing insert_update_person_google_plus!');
      log_message('debug', 'person_id: ' . $person_id);
      log_message('debug', 'google_plus_id: ' . $google_plus_id);
      $result = $this->check_person_google_plus($person_id,$google_plus_id);
      log_message('debug', 'Result: ' . $result);
      $data = array(
           'person_google_plus_person_id' => $person_id ,
           'person_google_plus_gplus_id' => $google_plus_id,
        );    

      if($result) {
        //UPDATE
        log_message('debug', 'Already existing register for person_id: ' . $person_id . ' AND google_plus_id: ' . $google_plus_id . '. Skipping!');
      } else {
        //INSERT
        log_message('debug', 'Inserting new record to table person_google_plus!');
        $this->db->insert('person_google_plus', $data); 
        if ($this->db->affected_rows() == 1) {
          //INSERTED OK
          $inserted_id = $this->db->insert_id();
          log_message('debug', 'Inserted ok with id ' .$inserted_id);          
          return $inserted_id;  
        } else {
          //ERROR INSERTING
          log_message('debug', 'ERROR inserting record to table person_google_plus. Affected rows:' . $this->db->affected_rows()); 
          return null; 
        }  
      }

    }

    function check_person_google_plus($person_id,$google_plus_id) {

      /*
      SELECT `person_google_plus_id` FROM `person_google_plus` WHERE `person_google_plus_person_id`=PERSON_ID 
      AND `person_google_plus_gplus_id`=GOOGLE_PLUS_ID
      */
      $this->db->select('person_google_plus_id');
      $this->db->from('person_google_plus');
      $this->db->where('person_google_plus_person_id',$person_id);
      $this->db->where('person_google_plus_gplus_id',$google_plus_id);

      $query = $this->db->get();
      //log_message('debug',$this->db->last_query());

      if ($query->num_rows() == 1){
        $row = $query->row(); 
        return $row->person_google_plus_id;
      } 
      else
        return false;
    }    

    function save_google_plus_profile($user_profile) {
      log_message('debug', 'Executing save_google_plus_profile...');
      
      $google_plus_profile_database_id = 
          $this->check_if_google_plus_profile_exists($user_profile->identifier);
      $data = array(
           'google_plus_identifier' => $user_profile->identifier,
           'google_plus_webSiteURL' => $user_profile->webSiteURL ,
           'google_plus_profileURL' => $user_profile->profileURL,
           'google_plus_photoURL' => $user_profile->photoURL,
           'google_plus_displayName' => $user_profile->displayName,
           'google_plus_description' => $user_profile->description,
           'google_plus_firstName' => $user_profile->firstName,
           'google_plus_lastName' => $user_profile->lastName,
           'google_plus_gender' => $user_profile->gender,
           'google_plus_language' => $user_profile->language,
           'google_plus_age' => $user_profile->age,
           'google_plus_birthDay' => $user_profile->birthDay,
           'google_plus_birthMonth' => $user_profile->birthMonth,
           'google_plus_birthYear' => $user_profile->birthYear,
           'google_plus_email' => $user_profile->email,
           'google_plus_emailVerified' => $user_profile->emailVerified,
           'google_plus_phone' => $user_profile->phone,
           'google_plus_address' => $user_profile->address == null ? "": $user_profile->address,
           'google_plus_country' => $user_profile->country,
           'google_plus_region' => $user_profile->region,
           'google_plus_city' => $user_profile->city == null ? "": $user_profile->city,
           'google_plus_zip' => $user_profile->zip,
           'google_plus_creationUserId' => 2,
           'google_plus_lastupdateUserId' => 2,
           'google_plus_markedForDeletion' => 'n',
           'google_plus_markedForDeletionDate' => '',
        );    
      if ($google_plus_profile_database_id != false) {
        //UPDATE
        log_message('debug', 'Updating Google_plus_profile with id ' . $google_plus_profile_database_id);
        $this->db->where('google_plus_id', $google_plus_profile_database_id);
        $this->db->update('google_plus', $data); 
        //log_message('debug',$this->db->last_query());
        if ($this->db->affected_rows() == 1) {
          //UPDATE OK
          log_message('debug', 'Google_plus_profile updated ok with id');          
          return $google_plus_profile_database_id;  
        } else {
          if ($this->db->affected_rows() == 0) {            
            //NOTHING UPDATED -> CONTINUE (we use all data, maybe is zero because no changes applied)!
            log_message('debug', 'ERROR? updating Google_plus_profile. Affected rows: ' . $this->db->affected_rows()); 
            return $google_plus_profile_database_id;
          } else{
            log_message('debug', 'ERROR updating Google_plus_profile. Affected rows: ' . $this->db->affected_rows()); 
            return null;   
          }
          
        }  
      } else {
        //INSERT
        log_message('debug', 'Inserting Google_plus_profile to database!');        
        $this->db->insert('google_plus', $data); 
        $inserted_id = $this->db->insert_id();
        if ($this->db->affected_rows() == 1) {
          //INSERTED OK          
          log_message('debug', 'Google_plus_profile inserted ok with id ' . $inserted_id);          
          return $inserted_id;  
        } else {
          //ERROR INSERTING
          log_message('debug', 'ERROR inserting Google_plus_profile. Affected rows: ' . $this->db->affected_rows()); 
          return null; 
        }      
        
      }
    }

    function check_if_google_plus_profile_exists($google_plus_profile_identifier) {
      log_message('debug', 'Checking if google_plus_profile with identifier ' . $google_plus_profile_identifier . ' already exists...');
      //SELECT `google_plus_id` FROM `google_plus` WHERE `google_plus_identifier`="identifier_here"

      $this->db->select('google_plus_id');
      $this->db->from('google_plus');
      $this->db->where('google_plus_identifier',"$google_plus_profile_identifier");

      $query = $this->db->get();
      //log_message('debug',$this->db->last_query());
      if ($query->num_rows() == 1){
        $row = $query->row(); 
        log_message('debug', 'Google_plus_profile with identifier ' . $google_plus_profile_identifier. ' already exists!');
        return $row->google_plus_id;
      } 
      else {
        log_message('debug', 'Google_plus_profile with identifier ' .  $google_plus_profile_identifier . ' not exists on database!');
        return false;
      }
        
    }

    function get_current_academic_period_id() {

      /*
      SELECT academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current FROM academic_periods WHERE academic_periods_current=1
      */
      $this->db->select('academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current');
      $this->db->from('academic_periods');
      $this->db->where('academic_periods_current',1);

      $query = $this->db->get();

      if ($query->num_rows() == 1){
        $row = $query->row(); 
        return $row->academic_periods_id;
      } 
      else
        return false;
    }

    public function getApiUserProfile($username) {
        $api_user_profile = new stdClass();
        $api_user_profile->username = $username;
        $api_user_profile->prova = "TEST";
        $api_user_profile->another = "TEST 1";
        //TODO: Provides auth token for api access
        $api_user_profile->auth_token = "e613029163a79156e45ecbc37ff97f78";

        return $api_user_profile;
    }
  
    public function getSessionData($username) {

      $this->db->select('users.person_id');
      $this->db->from('users');
      $this->db->where('users.username',$username);
      $query = $this->db->get();
      //echo $this->db->last_query()."<br/>";

      $person_id = null;
      if ($query->num_rows() == 1) {
        $row = $query->row();
        $person_id = $row->person_id;
      } else {
        return false;
      }

      //echo "person_id: " . $person_id;

      $is_user_a_teacher = $this->is_user_a_teacher($person_id);

      //echo "is user a teacher: " . $is_user_a_teacher . "<br/>";

      $academic_period_id = $this->get_current_academic_period_id();

    	$this->db->from('users');
      if ($is_user_a_teacher) {
        $this->db->select('id,users.username,mainOrganizationaUnitId,person_email,person_secondary_email,person.person_terciary_email ,users.person_id,mainOrganizationaUnitId,
          person.person_id,person_givenName,person_sn1,person_sn2,person_photo,person.person_official_id,person.person_official_id_type,person.person_date_of_birth,person.person_gender,
          person.person_secondary_official_id,person.person_secondary_official_id_type,person.person_homePostalAddress,person.person_locality_id,person.person_telephoneNumber,person.person_mobile,
          person.person_notes,locality.locality_name,person.person_entryDate,teacher.teacher_id,teacher_academic_periods_code,teacher_academic_periods_department_id,department.department_shortname');
      } else {
          $this->db->select('id,users.username,mainOrganizationaUnitId,person_email,person_secondary_email,person.person_terciary_email ,users.person_id,mainOrganizationaUnitId,
          person.person_id,person_givenName,person_sn1,person_sn2,person_photo,person.person_official_id,person.person_official_id_type,person.person_date_of_birth,person.person_gender,
          person.person_secondary_official_id,person.person_secondary_official_id_type,person.person_homePostalAddress,person.person_locality_id,person.person_telephoneNumber,person.person_mobile,
          person.person_notes,locality.locality_name,person.person_entryDate');       
      }
      

      // 	first_name 	last_name and others from table person: person table (person_id)	
		  $this->db->join('person', 'users.person_id = person.person_id','left');
      $this->db->join('locality', 'person.person_locality_id = locality.locality_id','left');
      if ($is_user_a_teacher) {
        $this->db->join('teacher', 'person.person_id = teacher.teacher_person_id');
        $this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');  
        $this->db->join('department', 'teacher_academic_periods_department_id = department.department_id','left');
      }

		  $this->db->where('users.username',$username);
      if ( $is_user_a_teacher ) {
          $this->db->where('teacher_academic_periods_academic_period_id', $academic_period_id );
      }

      $query = $this->db->get();

      //echo $this->db->last_query()."<br/>";

      $sessiondata = array();
		
		if ($query->num_rows() > 0)	{
			$row = $query->row();

      $teacher_id="";
      if ( isset($row->teacher_id) ) {
        $teacher_id=$row->teacher_id;
      }
      $teacher_academic_periods_code="";
      if ( isset($row->teacher_academic_periods_code) ) {
        $teacher_academic_periods_code=$row->teacher_academic_periods_code;
      }
      $teacher_department_id="";
      if ( isset($row->teacher_academic_periods_department_id) ) {
        $teacher_department_id=$row->teacher_academic_periods_department_id;
      }
      
      $teacher_department_shortname="";
      if ( isset($row->department_shortname) ) {
        $teacher_department_shortname=$row->department_shortname;
      }
      
			$sessiondata = array(
                   'id'  				=> $row->id,
                   'username'  			=> $row->username,
                   'email'     			=> $row->person_email,
                   'secondary_email'    => $row->person_secondary_email ,
                   'terciary_email'    => $row->person_terciary_email,
                   'person_id'   		=> $row->person_id,
                   'mainOrganizationaUnitId' => $row->mainOrganizationaUnitId,    
                   'person_id' => $row->person_id,
                   'givenName' => $row->person_givenName,
                   'sn1' => $row->person_sn1,
                   'sn2' => $row->person_sn2,
                   'fullname'  => $row->person_givenName . " " . $row->person_sn1 . " " .  $row->person_sn2,
                   'alt_fullname'  => $row->person_sn1 . " " . $row->person_sn2 . ", " . $row->person_givenName,
                   'person_official_id' => $row->person_official_id,
                   'person_official_id_type' => $row->person_official_id_type,
                   'person_date_of_birth' => $row->person_date_of_birth,
                   'person_gender' => $row->person_gender,
                   'person_secondary_official_id' => $row->person_secondary_official_id,
                   'person_secondary_official_id_type' => $row->person_secondary_official_id_type ,
                   'person_homePostalAddress' => $row->person_homePostalAddress,
                   'person_locality_id' => $row->person_locality_id,
                   'locality_name' => $row->locality_name,
                   'person_entryDate' => $row->person_entryDate,                                      
                   'person_telephoneNumber' => $row->person_telephoneNumber,
                   'person_mobile' => $row->person_mobile,
                   'person_notes' => $row->person_notes,
                   'photo'  => $row->person_photo,
                   'logged_in' => TRUE,
                   'is_admin' => $this->ebre_escool->user_is_admin(),
                   'is_teacher' => $this->is_user_a_teacher($row->person_id),
                   'is_student' => $this->is_user_a_student($row->person_id),
                   'teacher_code' => $teacher_academic_periods_code,
                   'teacher_id' => $teacher_id,
                   'teacher_department_id' => $teacher_department_id,
                   'department_shortname' => $teacher_department_shortname,
                   
               );
		}
   		else {
			return false;
		}

    	return $sessiondata;
    }
	
	
}
