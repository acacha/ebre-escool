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
class managment_model  extends CI_Model  {
	
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

	function simple_password_generator() {
		$alpha = "abcdefghijklmnopqrstuvwxyz";
		$alpha_upper = strtoupper($alpha);
		$numeric = "0123456789";
		$special = ".-+=_,!@$#*%<>[]{}";
		$chars = "";
		 
		if (isset($_POST['length'])){
		    // if you want a form like above
		    if (isset($_POST['alpha']) && $_POST['alpha'] == 'on')
		        $chars .= $alpha;
		     
		    if (isset($_POST['alpha_upper']) && $_POST['alpha_upper'] == 'on')
		        $chars .= $alpha_upper;
		     
		    if (isset($_POST['numeric']) && $_POST['numeric'] == 'on')
		        $chars .= $numeric;
		     
		    if (isset($_POST['special']) && $_POST['special'] == 'on')
		        $chars .= $special;
		     
		    $length = $_POST['length'];
		}else{
		    // default [a-zA-Z0-9]{9}
		    $chars = $alpha . $alpha_upper . $numeric;
		    $length = 9;
		}
		 
		$len = strlen($chars);
		$pw = '';
		 
		for ($i=0;$i<$length;$i++)
		        $pw .= substr($chars, rand(0, $len-1), 1);
		 
		// the finished password
		$pw = str_shuffle($pw);

		return $pw;
	}

	function replace_ldap_info_to_interchange_windows_passwords($user_data) {
		$CI =& get_instance();
        $CI->load->config('samba');

        //Get Ldap base DN for active users. It could be different from basedn
		$active_users_basedn = $this->config->item('active_users_basedn');

        $user_exists=$this->managment_model->user_exists($user_data->username,$active_users_basedn);
		$user_dn="";
		if (!$user_exists) {
			//Anything TODO: skip this cases
			return;
		} else {
			$user_dn = $user_exists;
		}

		//GET CURRENT sambaNTPassword AND sambaLMPassword

		$ldap_passwords = $this->managment_model->get_ldap_passwords($user_data->username);
		
		$ldap_nt_password = $ldap_passwords->sambaNTPassword;
		$ldap_lm_password = $ldap_passwords->sambaLMPassword;

		echo "ldap_nt_password: " . $ldap_nt_password . " ";
		echo "ldap_lm_password: " . $ldap_lm_password . " ";

        //IMPORTANT: Replace unix password and Windows passwords!
        if (($ldap_nt_password != "" ) && ($ldap_lm_password != "" ) )  {
        	$this->_init_ldap();
			if ($this->_bind()) {

				// first check if username is already in group:
				$entry["sambaLMPassword"] = $ldap_nt_password;
	            $entry["sambaNTPassword"] = $ldap_lm_password;

				$result = ldap_mod_replace ( $this->ldapconn , $user_dn , $entry );
				return $result;
			}	
        }
		

		return false;

	}



	function replace_ldap_info_to_avoid_change_of_password_on_windows($user_data) {
		$CI =& get_instance();
        $CI->load->config('samba');

        //Get Ldap base DN for active users. It could be different from basedn
		$active_users_basedn = $this->config->item('active_users_basedn');

        $user_exists=$this->managment_model->user_exists($user_data->username,$active_users_basedn);
		//ALWAYS DELETE FIRST LDAP USER IF EXIST --> FORCE TO RESYNC ALL DATA
		$user_dn="";
		if (!$user_exists) {
			//Anything TODO: skip this cases
			return;
		} else {
			$user_dn = $user_exists;
		}

        //IMPORTANT: Replace unix password and Windows passwords!
		$this->_init_ldap();
		if ($this->_bind()) {

			// first check if username is already in group:
			$entry["sambaLogonTime"]=$CI->config->item('samba_logonTime');
            $entry["sambaPwdLastSet"]=$CI->config->item('samba_pwdLastSet');

			$result = ldap_mod_replace ( $this->ldapconn , $user_dn , $entry );
			return $result;
		}

		return false;

	}



	//IMPORTANT: password not hashed is necessary for Windows NT passwords!
	function replace_ldap_password($user_data,$password = null) {

		if ($password==null) {
			if ($user_data->initial_password!="") {
				$password = $user_data->initial_password;
			} else {
				//Not hashed password provided. Skip!
				return;
			}
			
		} 
		$md5_password= md5($password);

		$ldap_password = "{MD5}".base64_encode(pack("H*",$md5_password));
		$cr = new Crypt_CHAP_MSv1();
		$sambaNTPassword = strtoupper(bin2hex($cr->ntPasswordHash($password)));
		$sambaLMPassword = strtoupper(bin2hex($cr->lmPasswordHash($password)));	
		
		//Get Ldap base DN for active users. It could be different from basedn
		$active_users_basedn = $this->config->item('active_users_basedn');


		$user_exists=$this->managment_model->user_exists($user_data->username,$active_users_basedn);
		//ALWAYS DELETE FIRST LDAP USER IF EXIST --> FORCE TO RESYNC ALL DATA
		$user_dn="";
		if (!$user_exists) {
			//Anything TODO: skip this cases
			return;
		} else {
			$user_dn = $user_exists;
		}

		$CI =& get_instance();
        $CI->load->config('samba');

		//IMPORTANT: Replace unix password and Windows passwords!
		$this->_init_ldap();
		if ($this->_bind()) {

			// first check if username is already in group:
			$entry["userPassword"]=$ldap_password;
			$entry["sambaLMPassword"]=$sambaLMPassword;
			$entry["sambaNTPassword"]=$sambaNTPassword;
			$entry["sambaLogonTime"]=$CI->config->item('samba_logonTime');
            $entry["sambaPwdLastSet"]=$CI->config->item('samba_pwdLastSet');

			$result = ldap_mod_replace ( $this->ldapconn , $user_dn , $entry );
			return $result;
		}

		return false;
	}
		

	function sync_mysql_password_to_ldap($values) {
		
		//echo "values: " . print_r($values). "\n";
		foreach ($values as $value) {
			if ($value != "") {
				$user_data = new stdClass();
				$user_data = $this->get_user_data($value);

				//var_export($user_data);
				$this->replace_ldap_password($user_data);
			}
		}		
		return true;
	}

	function interchange_windows_passwords($values) {
		
		//echo "values: " . print_r($values). "\n";
		foreach ($values as $value) {
			if ($value != "") {
				$user_data = new stdClass();
				$user_data = $this->get_user_data($value);

				//$this->syncUserToLdap($user_data);
				$this->replace_ldap_info_to_interchange_windows_passwords($user_data);

			}
		}		
		return true;
	}	

	function avoid_change_of_password_on_windows($values) {
		
		//echo "values: " . print_r($values). "\n";
		foreach ($values as $value) {
			if ($value != "") {
				$user_data = new stdClass();
				$user_data = $this->get_user_data($value);

				//$this->syncUserToLdap($user_data);
				$this->replace_ldap_info_to_avoid_change_of_password_on_windows($user_data);

			}
		}		
		return true;
	}	


	
	function sync_mysql_ldap($values) {
		
		//echo "values: " . print_r($values). "\n";
		foreach ($values as $value) {
			if ($value != "") {
				$user_data = new stdClass();
				$user_data = $this->get_user_data($value);

				$this->syncUserToLdap($user_data);

			}
		}		
		return true;
	}

	function get_all_classroomgroups($academic_period_id = null) {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		}


		/*
		SELECT classroom_group_academic_periods_classroom_group_id,classroom_group_academic_periods_mentorId,classroom_group_code,classroom_group_shortName,classroom_group_name
		FROM classroom_group_academic_periods
		INNER JOIN  classroom_group ON classroom_group.classroom_group_id = classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id
		WHERE classroom_group_academic_periods_academic_period_id=5
		*/

		$this->db->select('classroom_group_academic_periods_classroom_group_id,classroom_group_academic_periods_mentorId,classroom_group_code,
			classroom_group_shortName,classroom_group_name');
		$this->db->from('classroom_group_academic_periods');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id');
		$this->db->where('classroom_group_academic_periods_academic_period_id',$academic_period_id);

		$query = $this->db->get();
		//echo $this->db->last_query();

		$classroomgroups = array();
		if ($query->num_rows() > 0){
			foreach ($query->result() as $row)	{
				$classroomgroup = new stdClass();

				$classroomgroup->id = $row->classroom_group_academic_periods_classroom_group_id;
				$classroomgroup->code = $row->classroom_group_code;
				$classroomgroup->shortName = $row->classroom_group_shortName;
				$classroomgroup->name = $row->classroom_group_name;
				$classroomgroup->mentorId = $row->classroom_group_academic_periods_mentorId;

				$classroomgroups[$classroomgroup->id] = $classroomgroup;
			}
			return $classroomgroups;
		}
		return false;
	}



	function get_lesson($lesson_id) {

		/*
		SELECT lesson_id, lesson_academic_period_id, lesson_import_id, lesson_code, lesson_codi_assignatura, lesson_classroom_group_id, lesson_codi_grup, 
		lesson_teacher_id, lesson_codi_professor, lesson_study_module_id, lesson_location_id, codi_espai, lesson_day, lesson_time_slot_id, codi_hora, 
		lesson_entryDate, lesson_last_update, lesson_creationUserId, lesson_lastupdateUserId, lesson_markedForDeletion, lesson_markedForDeletionDate 
		FROM lesson 
		WHERE lesson_id=1
		*/

		$this->db->select('lesson_id, lesson_academic_period_id, lesson_import_id, lesson_code, lesson_codi_assignatura, lesson_classroom_group_id, lesson_codi_grup, 
		lesson_teacher_id, lesson_codi_professor, lesson_study_module_id, lesson_location_id, codi_espai, lesson_day, lesson_time_slot_id, codi_hora, 
		lesson_entryDate, lesson_last_update, lesson_creationUserId, lesson_lastupdateUserId, lesson_markedForDeletion, lesson_markedForDeletionDate');
		$this->db->from('lesson');
		$this->db->where('lesson_id',$lesson_id);
		$this->db->limit(1);

		$query = $this->db->get();

		$lesson = new stdClass();
		if ($query->num_rows() == 1){ 			
			$row = $query->row();
			$lesson->id = $row->lesson_id;
			$lesson->academic_period_id = $row->lesson_academic_period_id;
			$lesson->import_id = $row->lesson_import_id;
			$lesson->code = $row->lesson_code;
			$lesson->codi_assignatura = $row->lesson_codi_assignatura;
			$lesson->classroom_group_id = $row->lesson_classroom_group_id;
			$lesson->codi_grup = $row->lesson_codi_grup;
			$lesson->teacher_id = $row->lesson_teacher_id;
			$lesson->codi_professor = $row->lesson_codi_professor;
			$lesson->study_module_id = $row->lesson_study_module_id;
			$lesson->location_id = $row->lesson_location_id;
			$lesson->codi_espai = $row->codi_espai;
			$lesson->day = $row->lesson_day;
			$lesson->time_slot_id = $row->lesson_time_slot_id;
			$lesson->codi_hora = $row->codi_hora;
			$lesson->entryDate = $row->lesson_entryDate;
			$lesson->last_update = $row->lesson_last_update;
			$lesson->creationUserId = $row->lesson_creationUserId;
			$lesson->lastupdateUserId = $row->lesson_lastupdateUserId;
			$lesson->markedForDeletion = $row->lesson_markedForDeletion;
			$lesson->markedForDeletionDate = $row->lesson_markedForDeletionDate;


			return $lesson;
		} else {
			return false;
		}

	}	

	function get_study_module_id_by_shortname_and_course_id ($study_module_shortname,$course_id) {
		
		$current_academic_period = $this->get_current_academic_period_id();

		/*
		SELECT study_module_id
		FROM study_module
		INNER JOIN study_module_academic_periods ON study_module.study_module_id = study_module_academic_periods.study_module_academic_periods_study_module_id
		INNER JOIN study_module_ap_courses ON study_module_academic_periods.study_module_academic_periods_id = study_module_ap_courses.study_module_ap_courses_study_module_ap_id
		WHERE study_module_shortname = "MP07" AND study_module_ap_courses_course_id =2 AND study_module_academic_periods_academic_period_id=5
		*/

		//FIRST SEARCH A PERFECT MATCH
		$this->db->select('study_module_id');
		$this->db->from('study_module');
		$this->db->join('study_module_academic_periods','study_module.study_module_id = study_module_academic_periods.study_module_academic_periods_study_module_id');
		$this->db->join('study_module_ap_courses','study_module_academic_periods.study_module_academic_periods_id = study_module_ap_courses.study_module_ap_courses_study_module_ap_id');
		$this->db->where('study_module_shortname',$study_module_shortname);
		$this->db->where('study_module_ap_courses_course_id',$course_id);
		$this->db->where('study_module_academic_periods_academic_period_id',$course_id);

		$query = $this->db->get();
		//echo $this->db->last_query();


		if ($query->num_rows() == 1){ 
			return $query->row()->study_module_id;
		}

		//THEN SEARCH AND APROXIMATE MATCH

		//Problems with M11 -> M1 OR M2 -> M12!!!!
		$study_module_shortname_number = preg_replace("/[^0-9]/","",$study_module_shortname);

		$this->db->select('study_module_id');
		$this->db->from('study_module');
		$this->db->join('study_module_academic_periods','study_module.study_module_id = study_module_academic_periods.study_module_academic_periods_study_module_id');
		$this->db->join('study_module_ap_courses','study_module_academic_periods.study_module_academic_periods_id = study_module_ap_courses.study_module_ap_courses_study_module_ap_id');
		//BE CAREFUL ! Like 2 will match MP12
		$this->db->like('study_module_shortname',$study_module_shortname_number);
		$this->db->where('study_module_ap_courses_course_id',$course_id);
		//IF QUERY SELECT M12 AND M2 then select ONLY M2!
		$this->db->order_by('study_module_shortname', 'ASC');
		$this->db->where('study_module_academic_periods_academic_period_id',$course_id);

		$query = $this->db->get();
		//echo $this->db->last_query();


		if ($query->num_rows() == 1){ 
			return $query->row()->study_module_id;
		}

		return false;
		
	}

	function get_course_id_by_classroom_group_id($classroom_group_id) {
		/*
		SELECT course_id
		FROM course
		INNER JOIN classroom_group ON classroom_group.classroom_group_course_id = course.course_id
		WHERE `classroom_group_id`=3
		*/

		$this->db->select('course_id');
		$this->db->from('course');
		$this->db->join('classroom_group','classroom_group.classroom_group_course_id = course.course_id');
		$this->db->where('classroom_group_id',$classroom_group_id);
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() == 1){ 
			return $query->row()->course_id;
		}
		return false;
	}

	function update_study_module_id($lesson_id,$study_module_id) {
		/*Example SQL
		UPDATE `lesson` 
		SET `lesson_study_module_id`= 4
		WHERE `lesson_id`= 1
		*/

		$data = array(
               'lesson_study_module_id' => $study_module_id
            );

		$this->db->where('lesson_id', $lesson_id);
		$this->db->update('lesson', $data);

	}

	

	function calculate_study_module($values) {
		
		//echo "values: " . print_r($values). "\n";
		foreach ($values as $value) {
			if ($value != "") {
				$lesson_id= $value;
				//value --> lesson_id
				//Obtain lesson
				$lesson = $this->get_lesson($lesson_id);
				//var_export($lesson);
				$course_id = $this->get_course_id_by_classroom_group_id($lesson->classroom_group_id);
				if (!$course_id) {
					return false;
				}
				// TODO: add classroomgroup as condition! MP07 in course 2 could give MP07 of ASIX and DAM! 3x2 problem!!!
				$study_module_id = $this->get_study_module_id_by_shortname_and_course_id($lesson->codi_assignatura,$course_id);
				if ($study_module_id) {
					$this->update_study_module_id($lesson_id,$study_module_id);
				}
			}
		}		
		return true;
	}

	function create_multiple_study_submodules_logse($values) {
		
		//echo "values: " . print_r($values). "\n";
		foreach ($values as $value) {
			if ($value != "") {
				$this->create_study_submodule_logse($value);
			}
		}		
		return true;
	}

	function get_course_id_by_study_module_id($study_module_id,$academic_period_id=null) {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		}
		/*
		SELECT `study_module_ap_courses_course_id`
		FROM `study_module_academic_periods` 
		INNER JOIN study_module_ap_courses ON  study_module_ap_courses.`study_module_ap_courses_study_module_ap_id` = study_module_academic_periods.`study_module_academic_periods_id`
		WHERE `study_module_academic_periods_study_module_id`= 1 AND `study_module_academic_periods_academic_period_id`=5
		*/

		$this->db->select('study_module_ap_courses_course_id');
		$this->db->from('study_module_academic_periods');
		$this->db->join('study_module_ap_courses','study_module_ap_courses.study_module_ap_courses_study_module_ap_id = study_module_academic_periods.study_module_academic_periods_id');
		$this->db->where('study_module_academic_periods_study_module_id',$study_module_id);
		$this->db->where('study_module_academic_periods_academic_period_id',$academic_period_id);
		$this->db->limit(1);

		$query = $this->db->get();
		echo $this->db->last_query()."<br/>";

		if ($query->num_rows() > 0){
			$row = $query->row();
			return $row->study_module_ap_courses_course_id;
		}

		return false;	
	}

	function create_study_submodule_logse ($study_module_id,$academic_period_id=null) {

		if ($academic_period_id==null) {
			$academic_period_id = $this->get_current_academic_period_id();
		}
		/*
		INSERT INTO `study_submodules`(`study_submodules_shortname`, `study_submodules_name`, `study_submodules_study_module_id`, `study_submodules_courseid`, 
		`study_submodules_order`, `study_submodules_description`, `study_submodules_entryDate`, `study_submodules_creationUserId`, `study_submodules_lastupdateUserId`) 
		VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13])
		*/

		$course_id = $this->get_course_id_by_study_module_id($study_module_id,$academic_period_id);

		if ($course_id == false) {
			$course_id = 0;
		}

		$data = array(
		   'study_submodules_shortname' => "UD G" ,
		   'study_submodules_name' => "Unitat didàctica gobal" ,
		   'study_submodules_study_module_id' => $study_module_id,
		   'study_submodules_courseid' => $course_id,
		   'study_submodules_order' => 1,
		   'study_submodules_description' => "Unitat didàctica simulada. Tot l'any",
		   'study_submodules_entryDate' => date('Y-m-d H:i:s'),
           'study_submodules_creationUserId' => $this->session->userdata("user_id"),
           'study_submodules_lastupdateUserId' => $this->session->userdata("user_id"),
		);

		$this->db->insert('study_submodules', $data);
		echo $this->db->last_query()."<br/>";

		if ($this->db->affected_rows() == 1) {

			//INSERT INTO `study_submodules_academic_periods`(`study_submodules_academic_periods_study_submodules_id`, `study_submodules_academic_periods_academic_period_id`, 
			//`study_submodules_academic_periods_initialDate`, `study_submodules_academic_periods_endDate`, `study_submodules_academic_periods_totalHours`, 
			//`study_submodules_academic_periods_entryDate`, `study_submodules_academic_periods_creationUserId`, 
			//`study_submodules_academic_periods_lastupdateUserId`, `study_submodules_academic_periods_markedForDeletion`, `study_submodules_academic_periods_markedForDeletionDate`)
			// VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12])
			$data = array(
			   'study_submodules_academic_periods_study_submodules_id' => $this->db->insert_id(),
			   'study_submodules_academic_periods_academic_period_id' => $academic_period_id ,
			   'study_submodules_academic_periods_initialDate' => "2014-09-01",
			   'study_submodules_academic_periods_endDate' => "2015-07-31",
			   'study_submodules_academic_periods_totalHours' => 0,
			   'study_submodules_academic_periods_entryDate' => date('Y-m-d H:i:s'),
	           'study_submodules_academic_periods_creationUserId' => $this->session->userdata("user_id"),
	           'study_submodules_academic_periods_lastupdateUserId' => $this->session->userdata("user_id"),
			);

			$this->db->insert('study_submodules_academic_periods', $data);
			//echo $this->db->last_query()."<br/>";

			if ($this->db->affected_rows() == 1) {

			} else {
				//TODO. Transaction problem
				return false;
			}

		} else {
			return false;
		}
	}

	function create_multiple_initial_passwords($values) {
		
		//echo "values: " . print_r($values). "\n";
		foreach ($values as $value) {
			if ($value != "") {

				$new_password = $this->simple_password_generator();
				$this->create_initial_password($value,$new_password,true);

			}
		}		
		return true;
	}

	function create_multiple_autoenrollments($values) {

		//echo "values: " . print_r($values). "\n";
		foreach ($values as $value) {
			if ($value != "") {
				$this->auto_enrollment($value);
			}
		}		
		return true;

	}

	function auto_enrollment( $enrollment_id ) {

		$current_academic_period_id = $this->get_current_academic_period_id();

		//GET ENROLLMENT COURSE
		/*
		SELECT enrollment_course_id,enrollment_group_id,enrollment_study_id
		FROM enrollment 
		WHERE enrollment_id=500 
		*/

		$this->db->select('enrollment_course_id,enrollment_group_id,enrollment_study_id');
		$this->db->from('enrollment');
		$this->db->where('enrollment_id', $enrollment_id);

		$query = $this->db->get();
		//echo $this->db->last_query();

		$enrollment_course_id = null;
		$enrollment_group_id = null;
		$enrollment_study_id = null;

		$persons_id_are_teachers = array();
		if ($query->num_rows() == 1){
			$row = $query->row();
			$enrollment_course_id = $row->enrollment_course_id;
			$enrollment_group_id = $row->enrollment_group_id;
			$enrollment_study_id = $row->enrollment_study_id;
		}

		//CHECK FOR ERRORS!
		if ( $enrollment_course_id == null ) {
			return false;
		}

		// GET STUDY_SUBMODULES FOR COURSE
		/*
		SELECT study_submodules_id,study_submodules_study_module_id
		FROM study_submodules 
		INNER JOIN study_submodules_academic_periods ON study_submodules.study_submodules_id = study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id
		WHERE study_submodules_academic_periods_academic_period_id=5 AND study_submodules_courseid= 9
		*/

		$this->db->select('study_submodules_id,study_submodules_study_module_id');
		$this->db->from('study_submodules');
		$this->db->join('study_submodules_academic_periods','study_submodules.study_submodules_id = study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id');
		$this->db->where('study_submodules_courseid', $enrollment_course_id);
		$this->db->where('study_submodules_academic_periods_academic_period_id', $current_academic_period_id);
		

		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0){
			foreach($query->result() as $row){		

				$study_module_id = $row->study_submodules_study_module_id;
				$study_submodule_id = $row->study_submodules_id;

				/*
				INSERT INTO `enrollment_submodules`(`enrollment_submodules_enrollment_id`, `enrollment_submodules_moduleid`, `enrollment_submodules_submoduleid`, 
				`enrollment_submodules_entryDate`, `enrollment_submodules_last_update`, `enrollment_submodules_creationUserId`, 
				`enrollment_submodules_lastupdateUserId`, `enrollment_submodules_markedForDeletion`, `enrollment_submodules_markedForDeletionDate`) 
				VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10])
				*/

				$data = array(
				   'enrollment_submodules_enrollment_id' => $enrollment_id ,
				   'enrollment_submodules_moduleid' => $study_module_id ,
				   'enrollment_submodules_submoduleid' => $study_submodule_id,
				   'enrollment_submodules_entryDate' => date('Y-m-d H:i:s'),
				   'enrollment_submodules_creationUserId' => $this->session->userdata("user_id"),
				   'enrollment_submodules_lastupdateUserId' => $this->session->userdata("user_id")
				);

				$this->db->insert('enrollment_submodules', $data); 
			}
		}
	}



	function get_group_to_search_dn($user_data){
		$group_to_search_dn=null;
		switch ($user_data->user_type) {
		    case 1:
		    	//TEACHER
		        //TODO: at this time teacher are not touched
		    	$group_to_search_dn="intranet_teacher";
		        break;
		    case 2:
		    	//EMPLOYEE
		        break;
		    case 3:
		    	//STUDENT
		    	$group_to_search_dn="intranet_student";
		        break;    
		    default:
		        break;
		}

		return $group_to_search_dn;
	}

	function assign_multiple_ldap_roles($values) {
		
		//echo "values: " . print_r($values). "\n";
		foreach ($values as $value) {
			if ($value != "") {
				//Get user data:
				//GET USER DATA FORM DATABASE
				$user_data = new stdClass();
				$user_data = $this->get_user_data($value);
				$group_to_search_dn = $this->get_group_to_search_dn($user_data);
				
				if ($group_to_search_dn!=null) {
					//Search group dn
					$group = $this->get_group($group_to_search_dn);

					//echo "group dn: " . $group->dn . "\n";
					//echo "group users: " . print_r($group->users) . "\n";
					//echo "username: " . $user_data->username . "\n";

					if ($group->dn) {
						$this->_init_ldap();
						if ($this->_bind()) {
							$result=false;
							
							if (!in_array($user_data->username, $group->users)) {
								$result = $this->add_uid_to_group($group->dn,$user_data->username);
							}
				     		ldap_close($this->ldapconn);
						}
					}
				}
			}
		}		
		return true;
	}

	function get_all_users() {
		/*
		SELECT id, person_id, ip_address, username, password, initial_password, 
		force_change_password_next_login, mainOrganizationaUnitId, salt, secondary_email, 
		activation_code, forgotten_password_realm, forgotten_password_code, forgotten_password_time, 
		remember_code, created_on, last_modification_date, last_modification_user, creation_user, 
		last_login, active, ldap_dn
		*/
		$this->db->select('id, person_id, ip_address, username, password, initial_password, 
			force_change_password_next_login, mainOrganizationaUnitId, salt,  
			activation_code, forgotten_password_realm, forgotten_password_code, forgotten_password_time, 
			remember_code, created_on, last_modification_date, last_modification_user, creation_user, 
			last_login, active, ldap_dn');
		$this->db->from('users');
		//TODO: Treure
		//$this->db->limit(50);
		
		$query = $this->db->get();
		//echo $this->db->last_query();

		$all_persons = array();
		if ($query->num_rows() > 0){
			$i=0;
			foreach($query->result() as $row){				
				//echo "i: " . $i . " | username: " . $row->username;
				
				$all_persons[$i]['id'] = $row->id;
				$all_persons[$i]['person_id'] = $row->person_id;
				
				//$all_persons[$i]['ip_address'] = $row->ip_address;
				$all_persons[$i]['username'] = $row->username;
				$all_persons[$i]['password'] = $row->password;
				$all_persons[$i]['initial_password'] = $row->initial_password;				
				$all_persons[$i]['force_change_password_next_login'] = $row->force_change_password_next_login;
				$all_persons[$i]['mainOrganizationaUnitId'] = $row->mainOrganizationaUnitId;
				$all_persons[$i]['salt'] = $row->salt;
				$all_persons[$i]['activation_code'] = $row->activation_code;
				$all_persons[$i]['forgotten_password_realm'] = $row->forgotten_password_realm;
				$all_persons[$i]['forgotten_password_code'] = $row->forgotten_password_code;
				$all_persons[$i]['forgotten_password_time'] = $row->forgotten_password_time;
				$all_persons[$i]['forgotten_password_code'] = $row->forgotten_password_code;
				$all_persons[$i]['remember_code'] = $row->remember_code;				
				$all_persons[$i]['created_on'] = $row->created_on;
				$all_persons[$i]['last_modification_date'] = $row->last_modification_date;
				$all_persons[$i]['last_modification_user'] = $row->last_modification_user;
				$all_persons[$i]['creation_user'] = $row->creation_user;
				$all_persons[$i]['last_login'] = $row->last_login;
				$all_persons[$i]['active'] = $row->active;
				$all_persons[$i]['ldap_dn'] = $row->ldap_dn;
				
				$i++;
			}
		}

		return $all_persons;

	}

	function get_all_persons() {
		$this->db->select('person_id, person_givenName, person_sn1, person_sn2, person_email, 
			person_secondary_email, person_terciary_email, person_official_id, 
			person_official_id_type, person_date_of_birth, person_gender, 
			person_secondary_official_id, person_secondary_official_id_type, person_homePostalAddress, 
			person_photo, person_locality_id, person_telephoneNumber, person_mobile, 
			person_bank_account_id, person_notes, person_entryDate, person_last_update,
			person_creationUserId, person_lastupdateUserId, person_markedForDeletion, 
			person_markedForDeletionDate');
		$this->db->from('person');
		//TODO: Treure
		//$this->db->limit(50);
		
		$query = $this->db->get();
		//echo $this->db->last_query();

		$all_persons = array();
		if ($query->num_rows() > 0){
			$i=0;
			foreach($query->result() as $row){				
				//echo "i: " . $i . " | username: " . $row->username;
				
				$all_persons[$i]['person_id'] = $row->person_id;
				$all_persons[$i]['person_givenName'] = $row->person_givenName;
				$all_persons[$i]['person_sn1'] = $row->person_sn1;
				$all_persons[$i]['person_sn2'] = $row->person_sn2;
				$all_persons[$i]['person_email'] = $row->person_email;
				$all_persons[$i]['person_secondary_email'] = $row->person_secondary_email;
				$all_persons[$i]['person_terciary_email'] = $row->person_terciary_email;
				$all_persons[$i]['person_official_id'] = $row->person_official_id;
				$all_persons[$i]['person_official_id_type'] = $row->person_official_id_type;
				$all_persons[$i]['person_date_of_birth'] = $row->person_date_of_birth;
				$all_persons[$i]['person_gender'] = $row->person_gender;
				$all_persons[$i]['person_secondary_official_id'] = $row->person_secondary_official_id;
				$all_persons[$i]['person_secondary_official_id_type'] = $row->person_secondary_official_id_type;
				$all_persons[$i]['person_homePostalAddress'] = $row->person_homePostalAddress;
				$all_persons[$i]['person_photo'] = $row->person_photo;
				$all_persons[$i]['person_locality_id'] = $row->person_locality_id;
				$all_persons[$i]['person_telephoneNumber'] = $row->person_telephoneNumber;
				$all_persons[$i]['person_mobile'] = $row->person_mobile;
				$all_persons[$i]['person_bank_account_id'] = $row->person_bank_account_id;
				$all_persons[$i]['person_notes'] = $row->person_notes;
				$all_persons[$i]['person_entryDate'] = $row->person_entryDate;
				$all_persons[$i]['person_last_update'] = $row->person_last_update;
				$all_persons[$i]['person_creationUserId'] = $row->person_creationUserId;
				$all_persons[$i]['person_lastupdateUserId'] = $row->person_lastupdateUserId;
				$all_persons[$i]['person_markedForDeletion'] = $row->person_markedForDeletion;
				$all_persons[$i]['person_markedForDeletionDate'] = $row->person_markedForDeletionDate;
				
				$i++;
			}
		}

		return $all_persons;

	}

	function get_all_ldap_users($academic_period_id = null) {

		//ldap_users
		/*
		SELECT id, users.person_id,username, password, mainOrganizationaUnitId,person_givenName,person_sn1,person_sn2,ldap_dn
		FROM users 
		INNER JOIN person ON person.person_id = users.person_id
		WHERE 1
		*/
		if ($academic_period_id == null) {
			$academic_period_shortname = $this->get_current_academic_period()->academic_periods_shortname;
		} else {
			$academic_period_shortname = $this->get_academic_period_by_periodid($academic_period_id)->academic_periods_shortname;
		}

		$this->db->select('id, users.person_id,username, password,initial_password,force_change_password_next_login,last_login, mainOrganizationaUnitId,person_givenName,person_sn1,
			    person_sn2,ldap_dn,created_on,last_modification_date,creation_user, last_modification_user,enrollment_id,enrollment_periodid,enrollment_entryDate, 
			    enrollment_last_update,enrollment_creationUserId, enrollment_lastupdateUserId');
		$this->db->from('users');
		$this->db->join('person','person.person_id = users.person_id','left');
		$this->db->join('enrollment','enrollment.enrollment_personid = person.person_id','left');
		$this->db->where('enrollment_periodid',$academic_period_shortname);
		//$this->db->where('last_login',"0000-00-00 00:00:00");
		//$this->db->where('initial_password',"");
		//TODO: Treure
		//$this->db->limit(15);
		
		$query = $this->db->get();

		//echo $this->db->last_query();

		$teachers_person_ids = $this->get_persons_id_are_teachers_array();	
		$employees_person_ids = $this->get_persons_id_are_employees_array();
		$students_person_ids = $this->get_persons_id_are_students_array();

		$teachers_group = $this->get_group("intranet_teacher");
		$students_group = $this->get_group("intranet_student");

		$basedn = $this->config->item('active_users_basedn');
		$all_ldap_users_uid = $this->get_all_ldap_users_uid($basedn);
		$all_ldap_users_passwords = $this->get_all_ldap_passwords($basedn);
		$all_ldap_users_pwdLastSet = $this->get_all_ldap_pwdLastSet($basedn);
		$all_ldap_users_logonTime = $this->get_all_ldap_LogonTime($basedn);

		$all_ldap_users_nt_passwords = $this->get_all_ldap_nt_passwords($basedn);
		$all_ldap_users_lm_passwords = $this->get_all_ldap_lm_passwords($basedn);

		$all_ldap_users = array();
		if ($query->num_rows() > 0){
			$i=0;
			foreach($query->result() as $row){				
				//echo "i: " . $i . " | username: " . $row->username;
				
				$all_ldap_users[$i]['id'] = $row->id;
				$all_ldap_users[$i]['person_id'] = $row->person_id;
				$all_ldap_users[$i]['username'] = $row->username;
				$all_ldap_users[$i]['password'] = $row->password;

				$all_ldap_users[$i]['password_in_ldap_format'] = "{MD5}" . base64_encode(pack('H*',$row->password));

				$ldap_password="";
				if ( array_key_exists ( $row->username , $all_ldap_users_passwords ) ) {
					$ldap_password = $all_ldap_users_passwords[$row->username];
				} else {
					$ldap_password = "";
				}
				$all_ldap_users[$i]['ldap_password'] = $ldap_password;

				$pwdLastSet="";
				if ( array_key_exists ( $row->username , $all_ldap_users_pwdLastSet ) ) {
					$pwdLastSet = $all_ldap_users_pwdLastSet[$row->username];
				} else {
					$pwdLastSet = "";
				}
				$all_ldap_users[$i]['ldap_pwdLastSet'] = $pwdLastSet;

				$ldap_LogonTime="";
				if ( array_key_exists ( $row->username , $all_ldap_users_logonTime ) ) {
					$ldap_LogonTime = $all_ldap_users_logonTime[$row->username];
				} else {
					$ldap_LogonTime = "";
				}
				$all_ldap_users[$i]['ldap_LogonTime'] = $ldap_LogonTime;

				
				
				
				
				$all_ldap_users[$i]['initial_password'] = $row->initial_password;
				$cr = new Crypt_CHAP_MSv1();		

				$calculated_sambaNTPassword = strtoupper(bin2hex($cr->ntPasswordHash($row->initial_password)));
				$calculated_sambaLMPassword = strtoupper(bin2hex($cr->lmPasswordHash($row->initial_password)));

				$all_ldap_users[$i]['calculated_nt_initial_password'] = $calculated_sambaNTPassword;
				$all_ldap_users[$i]['calculated_lm_initial_password'] = $calculated_sambaLMPassword;
				
				$ldap_nt_password="";
				if ( array_key_exists ( $row->username , $all_ldap_users_nt_passwords ) ) {
					$ldap_nt_password = $all_ldap_users_nt_passwords[$row->username];
				} else {
					$ldap_nt_password = "";
				}
				$all_ldap_users[$i]['real_nt_initial_password'] = $ldap_nt_password;

				$ldap_lm_password="";
				if ( array_key_exists ( $row->username , $all_ldap_users_lm_passwords ) ) {
					$ldap_lm_password = $all_ldap_users_lm_passwords[$row->username];
				} else {
					$ldap_lm_password = "";
				}
				$all_ldap_users[$i]['real_lm_initial_password'] = $ldap_lm_password;




				$all_ldap_users[$i]['force_change_password_next_login'] = $row->force_change_password_next_login;
				$all_ldap_users[$i]['last_login'] = $row->last_login;				
				$all_ldap_users[$i]['md5_initial_password'] = md5($row->initial_password);
				$all_ldap_users[$i]['mainOrganizationaUnitId'] = $row->mainOrganizationaUnitId;
				$all_ldap_users[$i]['person_givenName'] = $row->person_givenName;
				$all_ldap_users[$i]['person_sn1'] = $row->person_sn1;
				$all_ldap_users[$i]['person_sn2'] = $row->person_sn2;
				$all_ldap_users[$i]['ldap_dn'] = $row->ldap_dn;
				$all_ldap_users[$i]['creation_date'] = $row->created_on;
				$all_ldap_users[$i]['last_modification_date'] = $row->last_modification_date;
				$all_ldap_users[$i]['creation_user'] = $row->creation_user;
				$all_ldap_users[$i]['last_modification_user'] = $row->last_modification_user;
				$all_ldap_users[$i]['enrollment_id'] = $row->enrollment_id;
				$all_ldap_users[$i]['enrollment_periodid'] = $row->enrollment_periodid;
				$all_ldap_users[$i]['enrollment_entryDate'] = $row->enrollment_entryDate;
				$all_ldap_users[$i]['enrollment_last_update'] = $row->enrollment_last_update;
				$all_ldap_users[$i]['enrollment_creationUserId'] = $row->enrollment_creationUserId;
				$all_ldap_users[$i]['enrollment_lastupdateUserId'] = $row->enrollment_lastupdateUserId;
				
				//TOO SLOW
				//$real_ldap_dn = $this->user_exists($row->username,$active_users_basedn);	
				//FASTER
				if ( array_key_exists ( $row->username , $all_ldap_users_uid ) ) {
					$real_ldap_dn = $all_ldap_users_uid[$row->username];
				} else {
					$real_ldap_dn = "";
				}
				


				$all_ldap_users[$i]['real_ldap_dn'] = $real_ldap_dn;

				//TOO SLOW
				//$all_ldap_users[$i]['user_type'] = $this->get_user_type($row->person_id);
				//FASTER:
				if ( in_array ($row->person_id , $teachers_person_ids) ) {
					$all_ldap_users[$i]['user_type'] = 1;
				} elseif (in_array ($row->person_id , $employees_person_ids)) {
					$all_ldap_users[$i]['user_type'] = 2;

				} elseif (in_array ($row->person_id , $students_person_ids)) {
					$all_ldap_users[$i]['user_type'] = 3;
				} else {
					$all_ldap_users[$i]['user_type'] = 4;
				}

				$group_to_search_dn=null;
				$all_ldap_users[$i]['role']="";

				switch ($all_ldap_users[$i]['user_type']) {
				    case 1:
				    	//TEACHER
						if (in_array($row->username, $teachers_group->users)) {
								$all_ldap_users[$i]['role'] = "intranet_teacher";
						} else {
							$all_ldap_users[$i]['role'] = "";
						}
				        break;
				    case 2:
				    	//EMPLOYEE
				    	$all_ldap_users[$i]['role'] = "";
				        break;
				    case 3:
				    	//STUDENT
				    	if (in_array($row->username, $students_group->users)) {
								$all_ldap_users[$i]['role'] = "intranet_student";
						} else {
							$all_ldap_users[$i]['role'] = "";
						}
				        break;    
				    default:
				        break;
				}
				//echo "username: " . $row->username . " | " . "role: " . $all_ldap_users[$i]['role'] . "\n";
				
				$i++;
			}
		}

		return $all_ldap_users;
	}

	function get_persons_id_are_teachers_array() {
		$this->db->select('teacher_person_id');
		$this->db->from('teacher');

		$query = $this->db->get();

		$persons_id_are_teachers = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$persons_id_are_teachers[] = $row->teacher_person_id;
			}
		}

		return $persons_id_are_teachers;	
	}

	function get_persons_id_are_employees_array() {
		$this->db->select('employees_id');
		$this->db->from('employees');

		$query = $this->db->get();

		$persons_id_are_employees = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$persons_id_are_employees[] = $row->employees_id;
			}
		}

		return $persons_id_are_employees;	
	}


	function get_persons_id_are_students_array() {

		$current_academic_shortname = $this->get_current_academic_period()->shortname;

		$this->db->select('enrollment_personid');
		$this->db->from('enrollment');
		$this->db->join('person','enrollment.enrollment_personid = person.person_id');
		$this->db->where('enrollment_periodid',$current_academic_shortname);

		$query = $this->db->get();


		$persons_id_are_students= array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$persons_id_are_students[] = $row->enrollment_personid;
			}
		}

		return $persons_id_are_students;	
	}

	function get_user_type($person_id) {

		// RETURN VALUE:
		// 1-> Teacher
		// 2-> Employee
		// 3-> Student
		// 4-> Unknown user type

		//Check if user is teacher
		//SELECT `teacher_id` FROM `teacher` WHERE `teacher_person_id`=2 
		$this->db->select('teacher_id');
		$this->db->from('teacher');
		$this->db->where('teacher_person_id',$person_id);
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() == 1){ 
			//1 --> Person is teacher
			return 1;
		}

		//Check if user is employee
		//SELECT employees_id FROM employees WHERE employees_person_id=1
		$this->db->select('employees_id');
		$this->db->from('employees');
		$this->db->where('employees_person_id',$person_id);
		$this->db->limit(1);

		$query = $this->db->get();
		if ($query->num_rows() == 1){ 
			//2 --> Person is employee
			return 2;
		}

		//Check if user is student
		//BE CAREFUL. NOT USE OBSOLET STUDENT TABLE: SELECT student_id FROM `student` WHERE student_person_id=1
		
		//$this->db->select('student_id');
		//$this->db->from('student');
		//$this->db->where('student_person_id',$person_id);
		//$this->db->limit(1);
		//SELECT enrollment_id, enrollment_periodid, enrollment_personid
		//FROM enrollment 
		//INNER JOIN person ON enrollment.enrollment_personid= person.person_id
		//WHERE enrollment_periodid="2014-15"
		$current_academic_shortname = $this->get_current_academic_period()->shortname;

		$this->db->select('enrollment_personid');
		$this->db->from('enrollment');
		$this->db->join('person','enrollment.enrollment_personid = person.person_id');
		$this->db->where('enrollment_periodid',$current_academic_shortname);
		$this->db->where('enrollment_personid',$person_id);
		$this->db->limit(1);

		$query = $this->db->get();
		
		if ($query->num_rows() == 1){ 
			//3 --> Person is student
			return 3;
		}

		return 4;
	}

	private function _init_ldap() {
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
        $this->account_ou = $CI->config->item('account_ou');
        $this->login_attribute  = $CI->config->item('login_attribute');
        $this->use_ad = $CI->config->item('use_ad');
        $this->ad_domain = $CI->config->item('ad_domain');
        $this->proxy_user = $CI->config->item('proxy_user');
        $this->proxy_pass = $CI->config->item('proxy_pass');
        $this->roles = $CI->config->item('roles');
        $this->auditlog = $CI->config->item('auditlog');
        $this->member_attribute = $CI->config->item('member_attribute');
        
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

	public function user_exists($uid,$basedn) {
		$this->_init_ldap();
		$filter = '(uid='.$uid.')';				
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

	public function get_all_ldap_pwdLastSet($basedn) {
		$this->_init_ldap();
		$filter = '(uid=*)';	
		$all_ldap_pwdLastSet=array();			
		if ($this->_bind()) {
	     	$sr = ldap_search($this->ldapconn, $basedn, $filter);
	     	$entries = ldap_count_entries($this->ldapconn, $sr);
	     	//echo "Number of entires returned is: ". $entries;

	     	if ($entries > 0) {
	     		$info = ldap_get_entries($this->ldapconn, $sr);
				//echo "Data for ".$info["count"]." items returned:<p>";
		     	for ($i=0; $i<$info["count"]; $i++  ) {
					//echo "dn is: ". $info[$i]["dn"] ."\n";
					//echo "first cn entry is: ". $info[$i]["cn"][0] ."\n";
					//echo "first eail entry is: ". $info[$i]["email"][0] ."\n";
					if (in_array("sambapwdlastset", $info[$i])) {
						$all_ldap_pwdLastSet[$info[$i]["uid"][0]] = $info[$i]["sambapwdlastset"][0];
					}
					else {
						$all_ldap_pwdLastSet[$info[$i]["uid"][0]] = "No té sambapwdlastset";
					}
				}
			ldap_close($this->ldapconn);
			return $all_ldap_pwdLastSet;
			}
		
		}
		return false;	
	}

	public function get_all_ldap_LogonTime($basedn) {
		$this->_init_ldap();
		$filter = '(uid=*)';	
		$all_ldap_logonTime=array();			
		if ($this->_bind()) {
	     	$sr = ldap_search($this->ldapconn, $basedn, $filter);
	     	$entries = ldap_count_entries($this->ldapconn, $sr);
	     	//echo "Number of entires returned is: ". $entries;

	     	if ($entries > 0) {
	     		$info = ldap_get_entries($this->ldapconn, $sr);
				//echo "Data for ".$info["count"]." items returned:<p>";
		     	for ($i=0; $i<$info["count"]; $i++  ) {
					//echo "dn is: ". $info[$i]["dn"] ."\n";
					//echo "first cn entry is: ". $info[$i]["cn"][0] ."\n";
					//echo "first eail entry is: ". $info[$i]["email"][0] ."\n";
					if (in_array("sambalogontime", $info[$i])) {
						$all_ldap_logonTime[$info[$i]["uid"][0]] = $info[$i]["sambalogontime"][0];
					}
					else {
						$all_ldap_logonTime[$info[$i]["uid"][0]] = "No té sambalogontime";
					}
				}
			ldap_close($this->ldapconn);
			return $all_ldap_logonTime;
			}
		
		}
		return false;	
	}

	public function get_all_ldap_nt_passwords($basedn) {
		$this->_init_ldap();
		$filter = '(uid=*)';	
		$all_ldap_user_passwords=array();			
		if ($this->_bind()) {
	     	$sr = ldap_search($this->ldapconn, $basedn, $filter);
	     	$entries = ldap_count_entries($this->ldapconn, $sr);
	     	//echo "Number of entires returned is: ". $entries;

	     	if ($entries > 0) {
	     		$info = ldap_get_entries($this->ldapconn, $sr);
				//echo "Data for ".$info["count"]." items returned:<p>";
		     	for ($i=0; $i<$info["count"]; $i++  ) {
					//echo "dn is: ". $info[$i]["dn"] ."\n";
					//echo "first cn entry is: ". $info[$i]["cn"][0] ."\n";
					//echo "first eail entry is: ". $info[$i]["email"][0] ."\n";
					if (in_array("sambantpassword", $info[$i])) {
						$all_ldap_user_passwords[$info[$i]["uid"][0]] = $info[$i]["sambantpassword"][0];
					}
					else {
						$all_ldap_user_passwords[$info[$i]["uid"][0]] = "No té paraula de pas NT a Ldap";
					}
				}
			ldap_close($this->ldapconn);
			return $all_ldap_user_passwords;
			}
		
		}
		return false;	
	}
	
	public function get_all_ldap_lm_passwords($basedn) {
		$this->_init_ldap();
		$filter = '(uid=*)';	
		$all_ldap_user_passwords=array();			
		if ($this->_bind()) {
	     	$sr = ldap_search($this->ldapconn, $basedn, $filter);
	     	$entries = ldap_count_entries($this->ldapconn, $sr);
	     	//echo "Number of entires returned is: ". $entries;

	     	if ($entries > 0) {
	     		$info = ldap_get_entries($this->ldapconn, $sr);
				//echo "Data for ".$info["count"]." items returned:<p>";
		     	for ($i=0; $i<$info["count"]; $i++  ) {
					//echo "dn is: ". $info[$i]["dn"] ."\n";
					//echo "first cn entry is: ". $info[$i]["cn"][0] ."\n";
					//echo "first eail entry is: ". $info[$i]["email"][0] ."\n";
					if (in_array("sambalmpassword", $info[$i])) {
						$all_ldap_user_passwords[$info[$i]["uid"][0]] = $info[$i]["sambalmpassword"][0];
					}
					else {
						$all_ldap_user_passwords[$info[$i]["uid"][0]] = "No té paraula de pas LM a Ldap";
					}
				}
			ldap_close($this->ldapconn);
			return $all_ldap_user_passwords;
			}
		
		}
		return false;	
	}	

	public function get_all_ldap_passwords($basedn) {
		$this->_init_ldap();
		$filter = '(uid=*)';	
		$all_ldap_user_passwords=array();			
		if ($this->_bind()) {
	     	$sr = ldap_search($this->ldapconn, $basedn, $filter);
	     	$entries = ldap_count_entries($this->ldapconn, $sr);
	     	//echo "Number of entires returned is: ". $entries;

	     	if ($entries > 0) {
	     		$info = ldap_get_entries($this->ldapconn, $sr);
				//echo "Data for ".$info["count"]." items returned:<p>";
		     	for ($i=0; $i<$info["count"]; $i++  ) {
					//echo "dn is: ". $info[$i]["dn"] ."\n";
					//echo "first cn entry is: ". $info[$i]["cn"][0] ."\n";
					//echo "first eail entry is: ". $info[$i]["email"][0] ."\n";
					if (in_array("userpassword", $info[$i])) {
						$all_ldap_user_passwords[$info[$i]["uid"][0]] = $info[$i]["userpassword"][0];
					}
					else {
						$all_ldap_user_passwords[$info[$i]["uid"][0]] = "No té paraula de pas a Ldap";
					}
				}
			ldap_close($this->ldapconn);
			return $all_ldap_user_passwords;
			}
		
		}
		return false;	
	}

	public function update_study_submodule_total_hours($study_submodule_id, $new_total_hours,$academic_period_id = null) {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		} 

		/*Example SQL
		UPDATE `study_submodules_academic_periods` 
		SET study_submodules_academic_periods_totalHours=20
		WHERE `study_submodules_academic_periods_study_submodules_id` = 1
		AND `study_submodules_academic_periods_academic_period_id`= 5
		*/

		$data = array(
               'study_submodules_academic_periods_totalHours' => $new_total_hours
            );

		$this->db->where('study_submodules_academic_periods_study_submodules_id', $study_submodule_id);
		$this->db->where('study_submodules_academic_periods_academic_period_id', $academic_period_id);
		$this->db->update('study_submodules_academic_periods', $data);

		if ($this->db->affected_rows() == 1) {
			$result = new stdClass();
			$result->result = true;
			$result->message = "Ok updating study_submodule_id: " . $study_submodule_id . " to totalHours: " . $new_total_hours;
			return $result;
		} else {
			$result = new stdClass();
			$result->result = false;
			$result->message = "Error updating study_submodule_id: " . $study_submodule_id . " to totalHours: " . $new_total_hours;
			return $result;
		}
	}


	public function change_study_submodule_total_hours($study_submodule_id, $new_total_hours,$academic_period_id = null) {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		} 

		if ($this->study_submodule_exists($study_submodule_id,$academic_period_id)) {
			//UPDATE
			return $this->update_study_submodule_total_hours($study_submodule_id, $new_total_hours,$academic_period_id);
		} else {
			$result = new stdClass();
			$result->result = false;
			$result->message = "Error updating study_submodule_id: " . $study_submodule_id . " to totalHours: " . $new_total_hours . ". Study submodule does not exists!";
			return $result;
		}
	}

	public function update_study_submodule_initial_date($study_submodule_id, $new_initialDate,$academic_period_id = null) {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		} 

		/*Example SQL
		UPDATE `study_submodules_academic_periods` 
		SET study_submodules_academic_periods_initialDate=DATE
		WHERE `study_submodules_academic_periods_study_submodules_id` = 1
		AND `study_submodules_academic_periods_academic_period_id`= 5
		*/

		$database_date = date('Y-m-d', strtotime($new_initialDate));

		$data = array(
               'study_submodules_academic_periods_initialDate' => $database_date
            );

		$this->db->where('study_submodules_academic_periods_study_submodules_id', $study_submodule_id);
		$this->db->where('study_submodules_academic_periods_academic_period_id', $academic_period_id);
		$this->db->update('study_submodules_academic_periods', $data);

		if ($this->db->affected_rows() == 1) {
			$result = new stdClass();
			$result->result = true;
			$result->message = "Ok updating study_submodule_id: " . $study_submodule_id . " to new_initialDate: " . $new_initialDate . " database date format: " . $database_date;
			return $result;
		} else {
			$result = new stdClass();
			$result->result = false;
			$result->message = "Error updating study_submodule_id: " . $study_submodule_id . " to new_initialDate: " . $new_initialDate . " database date format: " . $database_date;
			return $result;
		}
	}

	public function update_study_submodule_initial_date_planned($study_submodule_id, $new_initialDate_planned,$academic_period_id = null) {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		} 

		/*Example SQL
		UPDATE `study_submodules_academic_periods` 
		SET study_submodules_academic_periods_initialDate=DATE
		WHERE `study_submodules_academic_periods_study_submodules_id` = 1
		AND `study_submodules_academic_periods_academic_period_id`= 5
		*/

		$database_date = date('Y-m-d', strtotime($new_initialDate_planned));

		$data = array(
               'study_submodules_academic_periods_initialDate_planned' => $database_date
            );

		$this->db->where('study_submodules_academic_periods_study_submodules_id', $study_submodule_id);
		$this->db->where('study_submodules_academic_periods_academic_period_id', $academic_period_id);
		$this->db->update('study_submodules_academic_periods', $data);

		if ($this->db->affected_rows() == 1) {
			$result = new stdClass();
			$result->result = true;
			$result->message = "Ok updating study_submodule_id: " . $study_submodule_id . " to new_initialDate_planned: " . $new_initialDate_planned . " database date format: " . $database_date;
			return $result;
		} else {
			$result = new stdClass();
			$result->result = false;
			$result->message = "Error updating study_submodule_id: " . $study_submodule_id . " to new_initialDate_planned: " . $new_initialDate_planned . " database date format: " . $database_date;
			return $result;
		}
	}


	public function change_study_submodule_initial_date($study_submodule_id, $new_initialDate,$academic_period_id = null) {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		} 

		if ($this->study_submodule_exists($study_submodule_id,$academic_period_id)) {
			//UPDATE
			return $this->update_study_submodule_initial_date($study_submodule_id, $new_initialDate,$academic_period_id);
		} else {
			$result = new stdClass();
			$result->result = false;
			$result->message = "Error updating study_submodule_id: " . $study_submodule_id . " to new_initialDate: " . $new_initialDate . ". Study submodule does not exists!";
			return $result;
		}
	}

	public function change_study_submodule_initial_date_planned($study_submodule_id, $new_initialDate_planned,$academic_period_id = null) {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		} 

		if ($this->study_submodule_exists($study_submodule_id,$academic_period_id)) {
			//UPDATE
			return $this->update_study_submodule_initial_date_planned($study_submodule_id, $new_initialDate_planned,$academic_period_id);
		} else {
			$result = new stdClass();
			$result->result = false;
			$result->message = "Error updating study_submodule_id: " . $study_submodule_id . " to new_initialDate_planned: " . $new_initialDate_planned . ". Study submodule does not exists!";
			return $result;
		}
	}

	public function update_study_submodule_final_date($study_submodule_id, $new_finalDate,$academic_period_id = null) {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		} 

		/*Example SQL
		UPDATE `study_submodules_academic_periods` 
		SET study_submodules_academic_periods_endDate=DATE
		WHERE `study_submodules_academic_periods_study_submodules_id` = 1
		AND `study_submodules_academic_periods_academic_period_id`= 5
		*/

		$database_date = date('Y-m-d', strtotime($new_finalDate));

		$data = array(
           'study_submodules_academic_periods_endDate' => $database_date
        );

		$this->db->where('study_submodules_academic_periods_study_submodules_id', $study_submodule_id);
		$this->db->where('study_submodules_academic_periods_academic_period_id', $academic_period_id);
		$this->db->update('study_submodules_academic_periods', $data);

		if ($this->db->affected_rows() == 1) {
			$result = new stdClass();
			$result->result = true;
			$result->message = "Ok updating study_submodule_id: " . $study_submodule_id . " to new_finalDate: " . $new_finalDate . " database date format: " . $database_date;
			return $result;
		} else {
			$result = new stdClass();
			$result->result = false;
			$result->message = "Error updating study_submodule_id: " . $study_submodule_id . " to new_finalDate: " . $new_finalDate . " database date format: " . $database_date;
			return $result;
		}
	}

	public function update_study_submodule_final_date_planned($study_submodule_id, $new_finalDate_planned,$academic_period_id = null) {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		} 

		/*Example SQL
		UPDATE `study_submodules_academic_periods` 
		SET study_submodules_academic_periods_endDate=DATE
		WHERE `study_submodules_academic_periods_study_submodules_id` = 1
		AND `study_submodules_academic_periods_academic_period_id`= 5
		*/

		$database_date = date('Y-m-d', strtotime($new_finalDate_planned));

		$data = array(
           'study_submodules_academic_periods_endDate_planned' => $database_date
        );

		$this->db->where('study_submodules_academic_periods_study_submodules_id', $study_submodule_id);
		$this->db->where('study_submodules_academic_periods_academic_period_id', $academic_period_id);
		$this->db->update('study_submodules_academic_periods', $data);

		if ($this->db->affected_rows() == 1) {
			$result = new stdClass();
			$result->result = true;
			$result->message = "Ok updating study_submodule_id: " . $study_submodule_id . " to new_finalDate_planned: " . $new_finalDate_planned .  " database date format: " . $database_date;
			return $result;
		} else {
			$result = new stdClass();
			$result->result = false;
			$result->message = "Error updating study_submodule_id: " . $study_submodule_id . " to new_finalDate_planned: " . $new_finalDate_planned . " database date format: " . $database_date;
			return $result;
		}
	}

	public function change_study_submodule_final_date($study_submodule_id, $new_finalDate,$academic_period_id = null) {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		} 

		if ($this->study_submodule_exists($study_submodule_id,$academic_period_id)) {
			//UPDATE
			return $this->update_study_submodule_final_date($study_submodule_id, $new_finalDate,$academic_period_id);
		} else {
			$result = new stdClass();
			$result->result = false;
			$result->message = "Error updating study_submodule_id: " . $study_submodule_id . " to new_finalDate: " . $new_finalDate . ". Study submodule does not exists!";
			return $result;
		}
	}

	public function change_study_submodule_final_date_planned($study_submodule_id, $new_finalDate_planned,$academic_period_id = null) {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		} 

		if ($this->study_submodule_exists($study_submodule_id,$academic_period_id)) {
			//UPDATE
			return $this->update_study_submodule_final_date_planned($study_submodule_id, $new_finalDate_planned,$academic_period_id);
		} else {
			$result = new stdClass();
			$result->result = false;
			$result->message = "Error updating study_submodule_id: " . $study_submodule_id . " to new_finalDate_planned: " . $new_finalDate_planned . ". Study submodule does not exists!";
			return $result;
		}
	}

	public function study_submodule_exists($study_submodule_id,$academic_period_id = null) {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		} 

		/* 
		SELECT study_submodules_academic_periods_study_submodules_id 
		FROM study_submodules_academic_periods 
		WHERE study_submodules_academic_periods_study_submodules_id=1 AND study_submodules_academic_periods_academic_period_id=5
		*/

		$this->db->select('study_submodules_academic_periods_study_submodules_id');
		$this->db->from('study_submodules_academic_periods');
		$this->db->where('study_submodules_academic_periods_study_submodules_id',$study_submodule_id);
		$this->db->where('study_submodules_academic_periods_academic_period_id',$academic_period_id);

		$query = $this->db->get();
		//echo $this->db->last_query();

		$user_data = new stdClass();
		if ($query->num_rows() == 1){
			return true;
		}	
		else {
			return false;
		}
	}

	public function get_all_ldap_users_uid($basedn) {
		$this->_init_ldap();
		$filter = '(uid=*)';	
		$all_ldap_users_uid=array();			
		if ($this->_bind()) {
	     	$sr = ldap_search($this->ldapconn, $basedn, $filter);
	     	$entries = ldap_count_entries($this->ldapconn, $sr);
	     	//echo "Number of entires returned is: ". $entries;

	     	if ($entries > 0) {
	     		$info = ldap_get_entries($this->ldapconn, $sr);
				//echo "Data for ".$info["count"]." items returned:<p>";
		     	for ($i=0; $i<$info["count"]; $i++  ) {
					//echo "dn is: ". $info[$i]["dn"] ."\n";
					//echo "first cn entry is: ". $info[$i]["cn"][0] ."\n";
					//echo "first eail entry is: ". $info[$i]["email"][0] ."\n";
					$all_ldap_users_uid[$info[$i]["uid"][0]] = $info[$i]["dn"];
				}
			ldap_close($this->ldapconn);
			return $all_ldap_users_uid;
			}
		
		}
		return false;
	}



	public function deleteLdapUser($user_dn) {

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


	public function addLdapUser($user_data,$ldap_passwords=false) {
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
		    
		    $user_data_array["cn"]=$user_data->cn;
		    
		    if ($user_data->sn != "") {
		    	$user_data_array["sn"]=$user_data->sn;
		    }
		    if ($user_data->person_sn1 != "") {
		    	$user_data_array["sn1"]=$user_data->person_sn1;
		    }

		    if ($user_data->person_sn2 != "") {
		    	$user_data_array["sn2"]=$user_data->person_sn2;
		    }
		    if ($user_data->person_givenName != "") {
		    	$user_data_array["givenName"]=$user_data->person_givenName;
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
				    case 1:											//TEACHER
				        //TODO: at this time teacher are not touched
				    	$user_data_array["sambaLogonScript"]=$CI->config->item('samba_teacher_logonScript');
				        break;
				    case 2:				    				    	//EMPLOYEE
				    	$user_data_array["sambaLogonScript"]=$CI->config->item('samba_default_logonScript');
				        break;
				    case 3:											//STUDENT
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
            $user_data_array["sambaPwdLastSet"]=$CI->config->item('samba_pwdLastSet');
		    $user_data_array["sambaMungedDial"]=$CI->config->item('samba_mungedDial');
		    $user_data_array["sambaPrimaryGroupSID"]=$CI->config->item('samba_primaryGroupSID');

		    //Calculate Windows Passwords		    
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
		    if (ldap_add($this->ldapconn, $user_data->dn,$user_data_array) === false){
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
			$group_to_search_dn = $this->get_group_to_search_dn($user_data);
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
		$basedn = $this->config->item('groups_basedn');

		if ($this->_bind()) {
	     	$sr = ldap_search($this->ldapconn, $basedn, $filter);
	     	$entries = ldap_count_entries($this->ldapconn, $sr);
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


	function get_group_dn ($group_name) {

		$this->_init_ldap();
		$filter = '(&(objectClass=posixGroup)(cn=' . $group_name . '))';
		$basedn = $this->config->item('active_users_basedn');;
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

	function get_ldap_passwords($username) {
		$ldap_passwords = new stdClass();

		$userPassword="";
		$sambaNTPassword="";
		$sambaLMPassword="";

		$this->_init_ldap();
		$filter = '(uid='.$username.')';	
		//Get Ldap base DN for active users. It could be different from basedn
		$active_users_basedn = $this->config->item('active_users_basedn');			
		if ($this->_bind()) {
	     	$sr = ldap_search($this->ldapconn, $active_users_basedn, $filter);
	     	$entries = ldap_count_entries($this->ldapconn, $sr);
	     	//echo "Count entries: " . $entries ."<br/>";
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
	     		die();
	     	}
			ldap_close($this->ldapconn);
		}

		$ldap_passwords->userPassword = $userPassword;
		$ldap_passwords->sambaNTPassword = $sambaNTPassword;
		$ldap_passwords->sambaLMPassword = $sambaLMPassword;


		return $ldap_passwords;
	}

	/*
	NOTE: I decided to modify Ldap users RECREATING THEM ldap object from zero every time. Please consider following notes about passwords:
	IF $new_password=false then password is not changed on mysql then does not change passwords on Ldap. Be careful: Ldap passwords cannot be recalculated without unhashed password! 
	The only possibility is to backup ldap passwords hashes before deleting object
	*/
	function syncUserToLdap($user_data,$new_password=false) {

		$ldap_passwords=false;

		//Get Ldap base DN for active users. It could be different from basedn
		$active_users_basedn = $this->config->item('active_users_basedn');

		$user_exists=$this->managment_model->user_exists($user_data->username,$active_users_basedn);
		//ALWAYS DELETE FIRST LDAP USER IF EXIST --> FORCE TO RESYNC ALL DATA
		if ($user_exists) {
			if ($new_password == false) {
				// WE HAVE TO BACKUP current Ldap passwords to restore_it
				$ldap_passwords=$this->managment_model->get_ldap_passwords($user_data->username);
			} 
			
			//user_exists is false if user doesn't not exists or is user DN if user exists
			if ($user_exists === $user_data->dn) {
				$this->managment_model->deleteLdapUser($user_data->dn);
			} else {
				//Debug
				//echo "ERROR! DNs not match!<br/>";
				$this->managment_model->deleteLdapUser($user_exists);
				//Force Mysql ldap DN to take value from LDAP
				$user_data->dn = $user_exists;
			}
		} else {
			//USER NOT EXISTS ON LDAP. 3 options:
			//1) Recently create user in ebre-escool -> Create Ldap user using initial_password
			//2) User change password on ebre-escool but not exists on Ldap -> Create Ldap user using password provided by user
			//3) No initial password && No $new_password --> ERROR user ldap passwords could not be created
			if ($new_password == false) {
				echo "Error. Any password given to create Ldap user";
				return -1;
			}
		}

		//DEBUG:
		//echo "user_data dn: " . $user_data->dn;
		
		//public function addLdapUser($user_data,$ldap_passwords=false) {
		$result = $this->managment_model->addLdapUser($user_data,$ldap_passwords);

		if (!$result) {
			return false;
		}
		$this->managment_model->update_user_ldap_dn($user_data->username, $user_data->dn);
		return true;
	}

	function is_mentor($person_id, $academic_period_id=null) {
		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		}

		/*
		SELECT teacher_id,teacher_academic_periods_id,classroom_group_academic_periods_classroom_group_id
		FROM teacher 
		INNER JOIN teacher_academic_periods ON teacher_academic_periods.teacher_academic_periods_teacher_id =teacher.teacher_id
		INNER JOIN classroom_group_academic_periods ON classroom_group_academic_periods.classroom_group_academic_periods_mentorId =teacher_academic_periods_teacher_id
		WHERE teacher_person_id=1809 AND teacher_academic_periods_academic_period_id=5 AND classroom_group_academic_periods_academic_period_id=5
		*/

		$this->db->select('teacher_id,teacher_academic_periods_id,classroom_group_academic_periods_classroom_group_id');
		$this->db->from('teacher');
		$this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id =teacher.teacher_id');	
		$this->db->join('classroom_group_academic_periods','classroom_group_academic_periods.classroom_group_academic_periods_mentorId =teacher_academic_periods_teacher_id');	
		$this->db->where('teacher_person_id',$teacher_person_id);	
		$this->db->where('teacher_academic_periods_academic_period_id',$academic_period_id);
		$this->db->where('teacher_academic_periods_academic_period_id',$academic_period_id);
		
		$query = $this->db->get();
        //echo $this->db->last_query();

		if ($query->num_rows() == 1){
			return true;
		} else {
			return false;
		}
	}

	function get_teacher_code_by_personid($person_id) {

		$get_current_academic_period = $this->get_current_academic_period_id();
		/*
		SELECT teacher_academic_periods_code
		FROM teacher_academic_periods 
		INNER JOIN teacher ON teacher.teacher_id =  teacher_academic_periods.teacher_academic_periods_teacher_id
		INNER JOIN person ON person.person_id = teacher.teacher_person_id
		WHERE teacher_academic_periods_academic_period_id=5 AND person_id= 56
		*/
		
		$this->db->select('teacher_academic_periods_code');
		$this->db->from('teacher_academic_periods');
		$this->db->join('teacher','teacher.teacher_id =  teacher_academic_periods.teacher_academic_periods_teacher_id');
		$this->db->join('person','person.person_id = teacher.teacher_person_id');
		$this->db->where('teacher_academic_periods.teacher_academic_periods_academic_period_id',$get_current_academic_period);
		$this->db->where('person.person_id',$person_id);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br/>";


		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->teacher_academic_periods_code;
		}			
		return false;
	}

	function get_teacher_ids_and_names($teacher_id,$academic_period_id=null,$orderby="asc") {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		}

		/*
		SELECT `teacher_academic_periods_code`, `person_sn1`, `person_sn2`, `person_givenName`, `person_id`, `person_official_id` 
		FROM (`teacher_academic_periods`) JOIN `teacher` ON `teacher`.`teacher_id` = `teacher_academic_periods`.`teacher_academic_periods_teacher_id` 
		JOIN `person` ON `person`.`person_id` = `teacher`.`teacher_person_id` 
		WHERE `teacher_academic_periods_teacher_id` = '71' AND `teacher_academic_periods_academic_period_id` = '5' 
		*/
		
        $this->db->select('teacher_academic_periods_code, person_sn1, person_sn2, person_givenName, person_id, person_official_id');
        $this->db->from('teacher_academic_periods');
        $this->db->join('teacher', 'teacher.teacher_id = teacher_academic_periods.teacher_academic_periods_teacher_id');
        $this->db->join('person', 'person.person_id = teacher.teacher_person_id');
		$this->db->where('teacher_academic_periods_teacher_id', $teacher_id);
		$this->db->where('teacher_academic_periods_academic_period_id', $academic_period_id);

		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$teachers_array = array();

			foreach ($query->result_array() as $row)	{
   				$teachers_array[$row['teacher_academic_periods_code']] = $row['teacher_academic_periods_code'] . " - " . $row['person_sn1'] . " " . $row['person_sn2'] . ", " . $row['person_givenName'] . " - " . $row['person_official_id'];
			}
			return $teachers_array;
		}			
		else
			return false;
	}

	function is_mentor_return_classroom_group_id($person_id, $academic_period_id=null) {
		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		}

		/*
		SELECT teacher_id,teacher_academic_periods_id,classroom_group_academic_periods_classroom_group_id
		FROM teacher 
		INNER JOIN teacher_academic_periods ON teacher_academic_periods.teacher_academic_periods_teacher_id =teacher.teacher_id
		INNER JOIN classroom_group_academic_periods ON classroom_group_academic_periods.classroom_group_academic_periods_mentorId =teacher_academic_periods_teacher_id
		WHERE teacher_person_id=1809 AND teacher_academic_periods_academic_period_id=5 AND classroom_group_academic_periods_academic_period_id=5
		*/

		$this->db->select('teacher_id,teacher_academic_periods_id,classroom_group_academic_periods_classroom_group_id');
		$this->db->from('teacher');
		$this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id =teacher.teacher_id');	
		$this->db->join('classroom_group_academic_periods','classroom_group_academic_periods.classroom_group_academic_periods_mentorId =teacher_academic_periods_teacher_id');	
		$this->db->where('teacher_person_id',$person_id);	
		$this->db->where('teacher_academic_periods_academic_period_id',$academic_period_id);
		$this->db->where('teacher_academic_periods_academic_period_id',$academic_period_id);
		
		$query = $this->db->get();
        //echo $this->db->last_query();

		if ($query->num_rows() > 0){
			$mentor_classroom_group_ids = array();
			foreach($query->result() as $row){
				$mentor_classroom_group_ids[] = $row->classroom_group_academic_periods_classroom_group_id;
			}
			return $mentor_classroom_group_ids;
		} else {
			return false;
		}
	}




	function change_password($username,$new_password,$old_pasword=null,$username_is_userid=false) {

		//GET USER DATA FORM DATABASE
		$user_data = new stdClass();
		if ($username_is_userid) {
			$userid = $username;
			$user_data = $this->get_user_data($userid);
		} else {
			$user_data = $this->get_user_data_by_username($username);
		}

		//echo "user_data:\n" ;
		//var_dump($user_data);
		//echo "user_data end:\n" ;

		//Verify old password:
		if ($old_pasword != null) {
			$old_password_hashed = md5($old_pasword);
		
			//echo "old_pasword: " . $old_pasword . "<br/>";
			//echo "old_password_hashed: " . $old_password_hashed . "<br/>";
			//echo "user_data->password: " . $user_data->password . "<br/>";

			if (!($old_password_hashed === $user_data->password )) {
				return -1;	
			}	
		}		

		/*
		UPDATE `users` 
		SET `password` = md5('password')
		WHERE `username`="username"
		*/

		//Update MYSQL PASSWORD
		$new_password_hashed = md5($new_password);
		$data = array(
               'password' => $new_password_hashed,
               'initial_password' => '',
               'force_change_password_next_login' => 'n',
               'last_modification_user' => $this->session->userdata('user_id') ,
			   'active' => 1  
            );

		if ($username_is_userid) {
			$this->db->where('id', $username);
		} else {
			$this->db->where('username', $username);
		}
		$this->db->update('users', $data);

		$active_users_basedn = $this->config->item('active_users_basedn');

		//echo "user name: " . $user_data->username;
		$user_exists=$this->managment_model->user_exists($user_data->username,$active_users_basedn);

		if ($user_exists) {
			if ($user_exists === $user_data->dn) {
				$this->managment_model->deleteLdapUser($user_data->dn);
			} else {
				//Debug
				//echo "ERROR! DNs not match!<br/>";
				$this->managment_model->deleteLdapUser($user_exists);
				$user_data->dn = $user_exists;
			}
		} 
		$user_data->password = $new_password;
		//echo "user_data dn: " . $user_data->dn;
		$result = $this->managment_model->addLdapUser($user_data);
		if (!$result) {
			return false;
		}
		$this->managment_model->update_user_ldap_dn($user_data->username, $user_data->dn);
		return true;

	}

	function create_initial_password($username,$new_password,$username_is_userid=false) {

		//GET USER DATA FORM DATABASE
		$user_data = new stdClass();
		$user_id=0;

		if ($username_is_userid) {
			$user_id=$username;
			$user_data = $this->get_user_data($user_id);
		} else {
			$user_data = $this->get_user_data_by_username($username);	
		}
		

		if ($user_data == false) {
			return -2;
		}		
		
		//echo "user_data:\n" ;
		//var_dump($user_data);
		//echo "user_data end:\n" ;

		/*
		UPDATE `users` 
		SET `password` = md5('password')
		WHERE `username`="username"
		*/

		//Update MYSQL PASSWORD
		$new_password_hashed = md5($new_password);
		$data = array(
               'password' => $new_password_hashed,
               'initial_password' => $new_password,
               'force_change_password_next_login' => 'y',
			   'last_modification_user' => $this->session->userdata('user_id') ,
			   'active' => 1              
            );
		if ($username_is_userid) {
			$this->db->where('id', $user_id);
		} else {
			$this->db->where('username', $username);	
		}
				
		$this->db->update('users', $data);

		$active_users_basedn = $this->config->item('active_users_basedn');

		//echo "user name: " . $user_data->username;
		$user_exists=$this->managment_model->user_exists($user_data->username,$active_users_basedn);

		if ($user_exists) {
			if ($user_exists === $user_data->dn) {
				$this->managment_model->deleteLdapUser($user_data->dn);
			} else {
				//Debug
				//echo "ERROR! DNs not match!<br/>";
				$this->managment_model->deleteLdapUser($user_exists);
				$user_data->dn = $user_exists;
			}
		} 
		$user_data->password = $new_password;
		//echo "user_data dn: " . $user_data->dn;
		$result = $this->managment_model->addLdapUser($user_data);
		if (!$result) {
			return false;
		}
		$this->managment_model->update_user_ldap_dn($user_data->username, $user_data->dn);
		return true;

	}

	function force_change_password($username,$new_password) {

		//GET USER DATA FORM DATABASE
		$user_data = new stdClass();
		$user_data = $this->get_user_data_by_username($username);

		if ($user_data == false) {
			//Username not found
			return -2;
		}
		
		//echo "user_data:\n" ;
		//var_dump($user_data);
		//echo "user_data end:\n" ;

		/*
		UPDATE `users` 
		SET `password` = md5('password')
		WHERE `username`="username"
		*/

		//Update MYSQL PASSWORD
		$new_password_hashed = md5($new_password);
		$data = array(
               'password' => $new_password_hashed,
               'initial_password' => '',
               'force_change_password_next_login' => 'n',
               'last_modification_user' => $this->session->userdata('user_id') ,
			   'active' => 1              
            );

		$this->db->where('username', $username);		
		$this->db->update('users', $data);

		$active_users_basedn = $this->config->item('active_users_basedn');

		//echo "user name: " . $user_data->username;
		$user_exists=$this->managment_model->user_exists($user_data->username,$active_users_basedn);

		if ($user_exists) {
			if ($user_exists === $user_data->dn) {
				$this->managment_model->deleteLdapUser($user_data->dn);
			} else {
				//Debug
				//echo "ERROR! DNs not match!<br/>";
				$this->managment_model->deleteLdapUser($user_exists);
				$user_data->dn = $user_exists;
			}
		} 
		$user_data->password = $new_password;
		//echo "user_data dn: " . $user_data->dn;
		$result = $this->managment_model->addLdapUser($user_data);
		if (!$result) {
			return false;
		}
		$this->managment_model->update_user_ldap_dn($user_data->username, $user_data->dn);
		return true;

	}						

	function get_user_data($userid,$user_id_is_username=false) {

		/* Example
		SELECT `id`, `users`.`person_id`, `username`, `password`, `users`.`initial_password`, `mainOrganizationaUnitId`, `ldap_dn`, `person_givenName`, 
		`person_sn1`, `person_sn2`, `person_email`, `person_secondary_email`, `person_terciary_email`, `person_official_id`, `person_official_id_type`, 
		`person_date_of_birth`, `person_gender`, `person_secondary_official_id`, `person_secondary_official_id_type`, `person_homePostalAddress`,
		 `person_photo`, `person_locality_id`, `locality_name`, `postalcode_code`, `person_telephoneNumber`, `person_mobile`
		FROM (`users`)
		JOIN `person` ON `users`.`person_id` = `person`.`person_id`
		LEFT JOIN `locality` ON `locality`.`locality_id` = `person`.`person_locality_id`
		LEFT JOIN `postalcode` ON `postalcode`.`postalcode_localityid` = `locality`.`locality_id`
		WHERE `id` =  '55'
		LIMIT 1
		*/

		$this->db->select('id, users.person_id, username, password,users.initial_password, mainOrganizationaUnitId,ldap_dn, person_givenName,person_sn1,
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
			$user_data->initial_password = $row->initial_password;
			
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

			$user_data->user_type = $this->get_user_type($user_data->person_id);

			$user_data->basedn_where_insert_new_ldap_user = "";

			//echo "User type: " . $user_data->user_type . "\n";

			switch ($user_data->user_type) {
			    case 1:
			    	//TEACHER
			        //TODO: at this time teacher are not touched
			    	$user_data->basedn_where_insert_new_ldap_user = $this->config->item('active_teachers_basedn');
			        break;
			    case 2:
			    	//EMPLOYEE
			        //TODO: at this time teacher are not touched
			    	$user_data->basedn_where_insert_new_ldap_user = $this->config->item('active_employees_basedn');
			        break;
			    case 3:
			    	//STUDENT
			        $user_data->basedn_where_insert_new_ldap_user = $this->config->item('active_students_basedn');			        
			        break;    
			    default:
			        $user_data->basedn_where_insert_new_ldap_user = $this->config->item('active_others_basedn');
			        break;
			}

			$user_data->cn = trim($user_data->person_givenName . " " . $user_data->person_sn1 . " " . $user_data->person_sn2);
			$user_data->sn = trim($user_data->person_sn1 . " " . $user_data->person_sn2);
			$user_data->dn = "cn=" . $user_data->cn . ",". $user_data->basedn_where_insert_new_ldap_user;

			return $user_data;
		}	
		else
			return false;

	
	}

	function get_user_data_by_username($username) {
		return $this->get_user_data($username,true);
	}

	function get_all_enrollment_academic_periods() {

		//enrollments
		$this->db->select('enrollment_periodid,count(enrollment_personid) as total_number_of_enrolled_persons');
		$this->db->from('enrollment');
		$this->db->group_by('enrollment_periodid');

		$query = $this->db->get();

		$academic_periods = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$academic_period = new stdClass;
				$academic_period->academic_period = $row->enrollment_periodid;
				$academic_period->total_number_of_enrolled_persons = $row->total_number_of_enrolled_persons;
				$academic_periods[$row->enrollment_periodid] = $academic_period;
			}
		}

		return $academic_periods;	

	}

	function all_usernames() {
		/*
		SELECT id,username FROM users
		*/
		$this->db->select('id,username');
		$this->db->from('users');

		$query = $this->db->get();

		$all_usernames = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row)	{
				$all_usernames[] = $row->username;
			}			
			return $all_usernames; 
		}	
		else
			return false;		
	}

	function get_academic_period_by_periodid($period_id) {

		/*
		SELECT academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current FROM academic_periods WHERE academic_periods_current=1
		*/
		$this->db->select('*');
		$this->db->from('academic_periods');
		$this->db->where('academic_periods_id',$period_id);
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() == 1){
			$row = $query->row(); 
			return $row;
		}	
		else
			return false;
	}

	function get_all_courses_study_info ($academic_period_id=null) {

		if ($academic_period_id == null ) {
			$academic_period_id = $this->get_current_academic_period_id();
		}

		/*
		SELECT DISTINCT course_id , course_study_id 
		FROM course
		INNER JOIN courses_academic_periods ON courses_academic_periods.courses_academic_periods_course_id = course.course_id
		WHERE courses_academic_periods_academic_period_id= 5
		*/

		$this->db->select('course_id , course_study_id');
		$this->db->distinct();
		$this->db->from('course');
		$this->db->join('courses_academic_periods','courses_academic_periods.courses_academic_periods_course_id = course.course_id');	
		$this->db->where('courses_academic_periods_academic_period_id', $academic_period_id);

		$query = $this->db->get();
        //echo $this->db->last_query() . "<br/>";

		$all_courses_study_info = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$all_courses_study_info[$row->course_id] = $row->course_study_id;
			}
		}
		
		return $all_courses_study_info;

	}

	function get_all_classrooms_groups_course_info ($academic_period_id=null) {

		if ($academic_period_id == null ) {
			$academic_period_id = $this->get_current_academic_period_id();
		}

		/*
		SELECT DISTINCT classroom_group_id,classroom_group_course_id 
		FROM classroom_group 
		INNER JOIN classroom_group_academic_periods ON classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id = classroom_group.classroom_group_id
		WHERE classroom_group_academic_periods_academic_period_id = 5	
		*/

		$this->db->select('classroom_group_id,classroom_group_course_id');
		$this->db->distinct();
		$this->db->from('classroom_group');
		$this->db->join('classroom_group_academic_periods','classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id = classroom_group.classroom_group_id');	
		$this->db->where('classroom_group_academic_periods_academic_period_id', $academic_period_id);

		$query = $this->db->get();
        //echo $this->db->last_query() . "<br/>";

		$all_classrooms_groups_course_info = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$all_classrooms_groups_course_info[$row->classroom_group_id] = $row->classroom_group_course_id;
			}
		}
		
		return $all_classrooms_groups_course_info;

	}

	
	public function get_all_enrollments_courses_info( $academic_period_id = null) {

		
		if ($academic_period_id == null) {
			$academic_period_shortname = $this->get_current_academic_period()->shortname;
		} else {
			$academic_period = $this->get_academic_period_by_periodid($academic_period_id);
			$academic_period_shortname = $academic_period->academic_periods_shortname;
		}

		/*
		SELECT DISTINCT `enrollment_id`,`study_submodules_courseid`,`course_study_id`
		FROM `enrollment` 
		INNER JOIN enrollment_submodules ON `enrollment_submodules_enrollment_id` = enrollment_id
		INNER JOIN study_submodules ON `study_submodules_id`  = `enrollment_submodules_submoduleid`
		INNER JOIN course ON course.course_id = study_submodules.study_submodules_courseid
		WHERE `enrollment_periodid`="2014-15" 
		*/	

		$this->db->select('enrollment_id , study_submodules_courseid, course_study_id');
		$this->db->distinct();
		$this->db->from('enrollment');
		$this->db->join('enrollment_submodules','enrollment_submodules_enrollment_id = enrollment.enrollment_id');	
		$this->db->join('study_submodules','study_submodules.study_submodules_id  = enrollment_submodules.enrollment_submodules_submoduleid');	
		$this->db->join('course','course.course_id = study_submodules.study_submodules_courseid');	
		$this->db->where('enrollment_periodid', $academic_period_shortname);

		$query = $this->db->get();
        //echo $this->db->last_query() . "<br/>";

		$all_enrollments_courses_info = array();
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row){
				if (array_key_exists($row->enrollment_id, $all_enrollments_courses_info)) {

					$course = new stdClass();
					$course->id = $row->study_submodules_courseid;
					$course->study_id = $row->course_study_id;

					array_push ($all_enrollments_courses_info[$row->enrollment_id],$course);
					
				} else {
					$courses = array();

					$course = new stdClass();
					$course->id = $row->study_submodules_courseid;
					$course->study_id = $row->course_study_id;

					$courses[] = $course;
					$all_enrollments_courses_info[$row->enrollment_id] = $courses;	
				}
			}
		}
		
		return $all_enrollments_courses_info;
	}
	
	function get_enrollment_reports_all_enrolled_persons_by_academic_period ($academic_period_id=null,$orderby="DESC") {

		if ($academic_period_id == null) {
			$academic_period_shortname = $this->get_current_academic_period()->shortname;
		} else {
			$academic_period = $this->get_academic_period_by_periodid($academic_period_id);
			$academic_period_shortname = $academic_period->academic_periods_shortname;
		}

		$all_courses_study_info = $this->get_all_courses_study_info($academic_period_id);
		$all_classrooms_groups_course_info = $this->get_all_classrooms_groups_course_info($academic_period_id);
		$all_enrollments_courses_info = $this->get_all_enrollments_courses_info($academic_period_id);

		//print_r($all_courses_study_info);

		//DEBUG
		/*
		foreach ($all_enrollments_courses_info as $key => $value) {
					# code...
				echo "Enrollment id: " . $key;
				echo "<br/>";
				echo "Number of courses: " . count($value) . " | courses: " . var_export($value)  . "<br/>";
				}		
		*/

		/*
		SELECT `enrollment_id`, `enrollment_periodid`, `enrollment_personid`, `person_sn1`, `person_sn2`, `person_givenName`, `person_official_id`, 
		`users`.`id`, `users`.`username`, `users`.`password`, `users`.`initial_password`, `users`.`force_change_password_next_login`,users.ldap_dn, `enrollment_study_id`, 
		`studies`.`studies_shortname`, `studies`.`studies_name`, `studies_studies_law_id`, `studies_law_shortname`, `studies_law_name`, `enrollment_course_id`, 
		`course_shortname`, `course_name`, `enrollment_group_id`, `classroom_group_code`, `classroom_group_shortName`, `classroom_group_name`, `enrollment_entryDate`, `
		enrollment_last_update`, `enrollment_creationUserId`, `enrollment_lastupdateUserId`, `enrollment_markedForDeletion`, `enrollment_markedForDeletionDate` 
		FROM (`enrollment`) 
		LEFT JOIN `person` ON `person`.`person_id` = `enrollment`.`enrollment_personid` 
		LEFT JOIN `users` ON `users`.`person_id` = `person`.`person_id` 
		LEFT JOIN `studies` ON `studies`.`studies_id` = `enrollment`.`enrollment_study_id` 
		LEFT JOIN `studies_law` ON `studies_law`.`studies_law_id` = `studies`.`studies_studies_law_id` 
		LEFT JOIN `course` ON `course`.`course_id` = `enrollment`.`enrollment_course_id` 
		LEFT JOIN `classroom_group` ON `classroom_group`.`classroom_group_id` = `enrollment`.`enrollment_group_id` 
		WHERE `enrollment_periodid` = '2014-15' 
		ORDER BY `enrollment_entryDate` DESC 
		*/

		//enrollments
		$this->db->select('enrollment_id, enrollment_periodid, enrollment_personid,person_sn1,person_sn2,person_givenName,person_official_id,
		    users.id,users.username, users.password, users.initial_password, users.force_change_password_next_login, users.ldap_dn, enrollment_study_id, studies.studies_shortname,
			studies.studies_name, studies_studies_law_id,studies_law_shortname,studies_law_name,enrollment_course_id, course_shortname,course_name, enrollment_group_id,
			classroom_group_code,classroom_group_shortName,classroom_group_name, enrollment_entryDate, enrollment_last_update, enrollment_creationUserId, 
			enrollment_lastupdateUserId, enrollment_markedForDeletion, enrollment_markedForDeletionDate,count(enrollment_submodules_id) as num_study_submodules');
		$this->db->from('enrollment');
		$this->db->join('enrollment_submodules','enrollment_submodules.enrollment_submodules_enrollment_id = enrollment.enrollment_id','left');	
		$this->db->join('person','person.person_id = enrollment.enrollment_personid','left');	
		$this->db->join('users','users.person_id = person.person_id','left');
		$this->db->join('studies','studies.studies_id = enrollment.enrollment_study_id','left');
		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id','left');
		$this->db->join('course','course.course_id = enrollment.enrollment_course_id','left');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = enrollment.enrollment_group_id','left');
		$this->db->group_by('enrollment_id, enrollment_periodid, enrollment_personid,person_sn1,person_sn2,person_givenName,person_official_id,
		    users.id,users.username, users.password, users.initial_password, users.force_change_password_next_login, users.ldap_dn, enrollment_study_id, studies.studies_shortname,
			studies.studies_name, studies_studies_law_id,studies_law_shortname,studies_law_name,enrollment_course_id, course_shortname,course_name, enrollment_group_id,
			classroom_group_code,classroom_group_shortName,classroom_group_name, enrollment_entryDate, enrollment_last_update, enrollment_creationUserId, 
			enrollment_lastupdateUserId, enrollment_markedForDeletion, enrollment_markedForDeletionDate');

		$this->db->order_by('enrollment_entryDate', $orderby);
		$this->db->where('enrollment_periodid', $academic_period_shortname);
		//$this->db->limit(10);


		$query = $this->db->get();
        //echo $this->db->last_query();

		$all_enrollments = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$enrollment = new stdClass;
				
				$enrollment->id= $row->enrollment_id;
				$enrollment->period_id = $row->enrollment_periodid;

				$enrollment->person_id = $row->enrollment_personid;
				$enrollment->person_sn1 = $row->person_sn1;
				$enrollment->person_sn2 = $row->person_sn2;
				$enrollment->person_givenName = $row->person_givenName;
				$enrollment->person_official_id = $row->person_official_id;

				$enrollment->user_id = $row->id;
				$enrollment->username = $row->username;
				$enrollment->password = $row->password;
				$enrollment->initial_password = $row->initial_password;
				$enrollment->md5_initial_password = md5($row->initial_password);
				$enrollment->ldap_dn = $row->ldap_dn;
				
				$enrollment->force_change_password_next_login = $row->force_change_password_next_login;

				$enrollment->study_id = $row->enrollment_study_id;
				$enrollment->studies_shortname = $row->studies_shortname;
				$enrollment->studies_name = $row->studies_name;

				$enrollment->studies_studies_law_id = $row->studies_studies_law_id;
				$enrollment->studies_law_shortname = $row->studies_law_shortname;
				$enrollment->studies_law_name = $row->studies_law_name;

				$enrollment->enrollment_course_id = $row->enrollment_course_id;
				$enrollment->course_shortname = $row->course_shortname;
				$enrollment->course_name = $row->course_name;

				$enrollment->enrollment_group_id = $row->enrollment_group_id;
				$enrollment->classroom_group_code = $row->classroom_group_code;
				$enrollment->classroom_group_shortName = $row->classroom_group_shortName;
				$enrollment->classroom_group_name = $row->classroom_group_name;

				$enrollment->enrollment_entryDate = $row->enrollment_entryDate;
				$enrollment->enrollment_last_update = $row->enrollment_last_update;



				$enrollment->enrollment_creationUserId = $row->enrollment_creationUserId;
				$enrollment->enrollment_lastupdateUserId = $row->enrollment_lastupdateUserId;

				$enrollment->enrollment_creationUserId_username = $this->getUserNameByUserId($row->enrollment_creationUserId);
				$enrollment->enrollment_lastupdateUserId_username = $this->getUserNameByUserId($row->enrollment_lastupdateUserId);

				$enrollment->num_study_submodules = $row->num_study_submodules;

				$enrollment->error = "NO";

				//CHECK IF COURSE AN STUDY ARE CORRECT
				if ( array_key_exists($enrollment->enrollment_course_id, $all_courses_study_info) ) {
					$study_id_by_course = $all_courses_study_info[$enrollment->enrollment_course_id];
					if ( $study_id_by_course != $enrollment->study_id) {
						$enrollment->error = "CURS: " . $enrollment->enrollment_course_id . " I ESTUDI: " . $enrollment->study_id . " no quadren! S'esperava estudi: " . $study_id_by_course;
					}
				} else {
					$enrollment->error = "EL CURS: " . $enrollment->enrollment_course_id . " NO TÉ ESTUDI!";
				}

				//CHECK IF CLASSROOM AND COURSE ARE CORRECT
				if ( array_key_exists($enrollment->enrollment_group_id, $all_classrooms_groups_course_info) ) {
					$course_by_classroom_group = $all_classrooms_groups_course_info[$enrollment->enrollment_group_id];
					if ( $course_by_classroom_group != $enrollment->enrollment_course_id) {
						$enrollment->error = "GRUP CLASSE: " . $enrollment->enrollment_group_id . " I CURS: " . $enrollment->enrollment_course_id . " no quadren! S'esperava CURS: " . $course_by_classroom_group;
					}
				} else {
					$enrollment->error = "EL GRUP: " . $enrollment->enrollment_group_id . " NO TÉ CURS!";
				}

				if (!($row->num_study_submodules > 0 )) {
					$enrollment->error = "Matrícula sense cap UF/UD matrículada!";	
				}

				if (array_key_exists($row->enrollment_id, $all_enrollments_courses_info)) {
					$study_submodules_courses = $all_enrollments_courses_info[$row->enrollment_id];

					if (is_array($study_submodules_courses)) {
						//CHECK ENROLLMENT COURSE WITH study_submodules_courses. It have to be the same or a course from same study
						foreach ($study_submodules_courses as $study_submodules_course) {
							if ( $enrollment->study_id != $study_submodules_course->study_id ) {
								$enrollment->error = "Hi ha UFs/UDs matrículades que no són del mateix estudi que l'estudi matrículat!";		
							}
						}

					} else {
						$enrollment->error = "ERROR NO ESPERAT!";		
					}

				} else {
					$enrollment->error = "La matrícula no té cap UF/UD matrículada en cap dels cursos relacionats amb l'estudi matrículat";	
				}
				 

				//$enrollment->enrollment_course_id
				//$enrollment->enrollment_group_id
				//$enrollment->study_id
				
				$all_enrollments[$row->enrollment_id] = $enrollment;
			}
		}

		return $all_enrollments;	

	}

	function getUserNameByUserId($user_id) {

		/*
		SELECT username FROM users WHERE id = userid
		*/

		//enrollments
		$this->db->select('username');
		$this->db->from('users');
		$this->db->where('id', $user_id);
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() == 1)	{
			$row = $query->row();
			return $row->username;
		} else {
			return false;
		}
	}
	

	function get_studymodules_by_study($withtotal = true) {
		/* studymodules by study
		SELECT course_study_id , count(study_module_id) 
		FROM study_module 
		INNER JOIN  study_module_academic_periods ON  study_module_academic_periods.study_module_academic_periods_study_module_id = study_module.study_module_id
		INNER JOIN study_module_ap_courses ON study_module_ap_courses.study_module_ap_courses_study_module_ap_id = study_module_academic_periods.study_module_academic_periods_id
		INNER JOIN course ON study_module_ap_courses.study_module_ap_courses_course_id = course.course_id
		WHERE study_module_academic_periods.study_module_academic_periods_academic_period_id=5
		GROUP BY course_study_id
		 */

		$current_academic_period = $this->get_current_academic_period_id();

		//courses
		$this->db->select('course_study_id,count(study_module_id) as total');
		$this->db->from('study_module');
		$this->db->join('study_module_academic_periods','study_module_academic_periods.study_module_academic_periods_study_module_id = study_module.study_module_id');	
		$this->db->join('study_module_ap_courses','study_module_ap_courses.study_module_ap_courses_study_module_ap_id = study_module_academic_periods.study_module_academic_periods_id');	
		$this->db->join('course','study_module_ap_courses.study_module_ap_courses_course_id = course.course_id');	
		$this->db->where('study_module_academic_periods.study_module_academic_periods_academic_period_id',$current_academic_period);	
		$this->db->group_by('course_study_id');
		$query = $this->db->get();

        //echo $this->db->last_query();


		$studymodules_by_study = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$deposit = new stdClass;
				$deposit->total =  $row->total;

				$studymodules_ids = array();
				//study_modules
				/*

				*/
				$this->db->select('study_module_id');
				$this->db->from('study_module');
				$this->db->join('study_module_academic_periods','study_module_academic_periods.study_module_academic_periods_study_module_id = study_module.study_module_id');	
				$this->db->join('study_module_ap_courses','study_module_ap_courses.study_module_ap_courses_study_module_ap_id = study_module_academic_periods.study_module_academic_periods_id');	
				$this->db->join('course','study_module_ap_courses.study_module_ap_courses_course_id = course.course_id');	
				$this->db->where('study_module_academic_periods.study_module_academic_periods_academic_period_id',$current_academic_period);	
				$this->db->where('course_study_id',$row->course_study_id);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0){
					foreach($query1->result() as $row1){
						$studymodules_ids[]=$row1->study_module_id;
					}
				}
				$deposit->studymodules_ids =  $studymodules_ids;
				
				if ($withtotal) {
					$studymodules_by_study[$row->course_study_id] = $deposit;
				}	else {
					$studymodules_by_study[$row->course_study_id] = $studymodules_ids;
				}
				
			}
		}

		return $studymodules_by_study;
	}

	function get_enrollmentdata_by_study ($withtotal = true) {

		/* studysubmodules by study
		SELECT enrollment_study_id,studies_shortname,studies_name,count(enrollment_id) as total 
		FROM enrollment 
		INNER JOIN studies ON studies.`studies_id` = enrollment.enrollment_study_id
		WHERE enrollment_periodid="2014-15"
		GROUP BY enrollment_study_id,studies_shortname,studies_name
		 */

		//
		$this->db->select('enrollment_study_id,studies_shortname,studies_name,count(enrollment_id) as total ');
		$this->db->from('enrollment');
		$this->db->join('studies','studies.studies_id = enrollment.enrollment_study_id');
		$this->db->group_by('enrollment_study_id,studies_shortname,studies_name');
		$this->db->where('enrollment_periodid','2014-15');
		$query = $this->db->get();

		$enrollment_by_study = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$deposit = new stdClass;
				$deposit->total =  $row->total;

				$enrollment_ids = array();
				//study_modules
				$this->db->select('enrollment_id');
				$this->db->from('enrollment');
				$this->db->where('enrollment_study_id',$row->enrollment_study_id);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0){
					foreach($query1->result() as $row1){
						$enrollment_ids[]=$row1->enrollment_id;
					}
				}
				$deposit->enrollment_ids =  $enrollment_ids;

				if ($withtotal) {
					$enrollment_by_study[$row->enrollment_study_id] = $deposit;
				} else {
					$enrollment_by_study[$row->enrollment_study_id] = $enrollment_ids;
				}
				
			}
		}

		return $enrollment_by_study;
	}
		

	function get_studysubmodules_by_study( $withtotal = true) {

		/* studysubmodules by study
	
		 SELECT `course_study_id`, count(study_module_id) as total 
		 FROM (`study_submodules`) 
		 LEFT JOIN `study_module` ON `study_submodules`.`study_submodules_study_module_id` = `study_module`.`study_module_id` 
		 JOIN `study_module_academic_periods` ON `study_module_academic_periods`.`study_module_academic_periods_study_module_id` = `study_module`.`study_module_id` 
		 JOIN `study_module_ap_courses` ON `study_module_ap_courses`.`study_module_ap_courses_study_module_ap_id` = `study_module_academic_periods`.`study_module_academic_periods_id` 
		 JOIN `course` ON `study_module_ap_courses`.`study_module_ap_courses_course_id` = `course`.`course_id` 
		 WHERE `study_module_academic_periods`.`study_module_academic_periods_academic_period_id` = '5' 
		 GROUP BY `course_study_id` 
		 */

		$current_academic_period = $this->get_current_academic_period_id();

		//courses
		$this->db->select('course_study_id,count(study_module_id) as total');
		$this->db->from('study_submodules');
		$this->db->join('study_module','study_submodules.study_submodules_study_module_id = study_module.study_module_id', 'left');
		$this->db->join('study_module_academic_periods','study_module_academic_periods.study_module_academic_periods_study_module_id = study_module.study_module_id');	
		$this->db->join('study_module_ap_courses','study_module_ap_courses.study_module_ap_courses_study_module_ap_id = study_module_academic_periods.study_module_academic_periods_id');	
		$this->db->join('course','study_module_ap_courses.study_module_ap_courses_course_id = course.course_id');	
		$this->db->where('study_module_academic_periods.study_module_academic_periods_academic_period_id',$current_academic_period);	
		$this->db->group_by('course_study_id');
		$query = $this->db->get();
		//echo $this->db->last_query();


		$studysubmodules_by_study = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$deposit = new stdClass;
				$deposit->total =  $row->total;

				$studysubmodules_ids = array();
				//study_modules
				$this->db->select('study_submodules_id');
				$this->db->from('study_submodules');
				$this->db->join('study_module','study_submodules.study_submodules_study_module_id = study_module.study_module_id', 'left');
				$this->db->join('study_module_academic_periods','study_module_academic_periods.study_module_academic_periods_study_module_id = study_module.study_module_id');	
				$this->db->join('study_module_ap_courses','study_module_ap_courses.study_module_ap_courses_study_module_ap_id = study_module_academic_periods.study_module_academic_periods_id');	
				$this->db->join('course','study_module_ap_courses.study_module_ap_courses_course_id = course.course_id');	
				$this->db->where('study_module_academic_periods.study_module_academic_periods_academic_period_id',$current_academic_period);	
				$this->db->where('course_study_id',$row->course_study_id);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0){
					foreach($query1->result() as $row1){
						$studysubmodules_ids[]=$row1->study_submodules_id;
					}
				}
				$deposit->studysubmodules_ids =  $studysubmodules_ids;

				if ($withtotal) {
					$studysubmodules_by_study[$row->course_study_id] = $deposit;
				} else {
					$studysubmodules_by_study[$row->course_study_id] = $studysubmodules_ids;
				}
				
			}
		}

		return $studysubmodules_by_study;
	}

	function get_classroomgroups_by_study( $withtotal = true ) {
		/* classroomgroups by study
		SELECT course_study_id, count(classroom_group_id) 
		FROM classroom_group 
		LEFT JOIN course ON classroom_group.`classroom_group_course_id`=course.course_id
		GROUP BY course_study_id
		 */

		//courses
		$this->db->select('course_study_id,count(classroom_group_id) as total');
		$this->db->from('classroom_group');
		$this->db->join('course','classroom_group.classroom_group_course_id = course.course_id', 'left');
		$this->db->group_by('course_study_id');
		$query = $this->db->get();
        //echo $this->db->last_query();

		$classroomgroups_by_study = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$deposit = new stdClass;
				$deposit->total =  $row->total;

				$classroomgroups_ids = array();
				//classroomgroups
				$this->db->select('classroom_group_id');
				$this->db->from('classroom_group');
				$this->db->join('course','classroom_group.classroom_group_course_id = course.course_id', 'left');
				$this->db->where('course_study_id',$row->course_study_id);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0){
					foreach($query1->result() as $row1){
						$classroomgroups_ids[]=$row1->classroom_group_id;
					}
				}
				$deposit->classroomgroups_ids =  $classroomgroups_ids;

				if ($withtotal) {
					$classroomgroups_by_study[$row->course_study_id] = $deposit;
				} else {
					$classroomgroups_by_study[$row->course_study_id] = $classroomgroups_ids;
				}
					
			}
		}

		return $classroomgroups_by_study;
	}


	function get_courses_by_study( $withtotal = true ) {
		/* courses by study
		SELECT course_study_id, count(`course_id`) 
		FROM course 
		GROUP BY course_study_id
		 */

		//courses
		$this->db->select('course_study_id,count(course_id) as total');
		$this->db->from('course');
		$this->db->group_by('course_study_id');
		$query = $this->db->get();

		$courses_by_study = array();
		if ($query->num_rows() > 0)	{
			foreach($query->result() as $row){
				$deposit = new stdClass;
				$deposit->total =  $row->total;

				$courses_ids = array();
				//courses
				$this->db->select('course_id');
				$this->db->from('course');
				$this->db->where('course_study_id',$row->course_study_id);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0){
					foreach($query1->result() as $row1){
						$courses_ids[]=$row1->course_id;
					}
				}
				$deposit->courses_ids =  $courses_ids;

				if ($withtotal) {
					$courses_by_study[$row->course_study_id] = $deposit;
				} else {
					$courses_by_study[$row->course_study_id] = $courses_ids;	
				}
				
			}
		}

		return $courses_by_study;
	}

	function get_teachers_by_department( $withtotal = true, $academic_period = null) {
		/* teachers by department
		SELECT `teacher_department_id`, count(`teacher_id`) 
		FROM `teacher` 
		GROUP BY teacher_department_id */

		if ($academic_period ==  null) {
			$academic_period = $this->get_current_academic_period_id();
		}

		//deparments
		$this->db->select('teacher_academic_periods_department_id,count(teacher_id) as total');
		$this->db->from('teacher');
		$this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');
		$this->db->where('teacher_academic_periods_academic_period_id', $academic_period);

		$this->db->group_by('teacher_academic_periods_department_id');
		$query = $this->db->get();

		$teachers_by_department = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$deposit = new stdClass;
				$deposit->total =  $row->total;

				$teachers_ids = array();
				//deparments
				$this->db->select('teacher_academic_periods_department_id,teacher_id');
				$this->db->from('teacher');
				$this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');
				$this->db->where('teacher_academic_periods_department_id',$row->teacher_academic_periods_department_id);
				$this->db->where('teacher_academic_periods_academic_period_id',$academic_period);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0){
					foreach($query1->result() as $row1){
						$teachers_ids[]=$row1->teacher_id;
					}
				}
				$deposit->teachers_ids =  $teachers_ids;
				if ($withtotal) {
					$teachers_by_department[$row->teacher_academic_periods_department_id] = $deposit;
				} else {
					$teachers_by_department[$row->teacher_academic_periods_department_id] = $teachers_ids;
				}
			}
		}

		return $teachers_by_department;
	}

	function get_studies_by_department( $withtotal = true ) {
		/* studies by department
		SELECT `department_id`,count(`study_id`) as total
		FROM `study_department` 
		GROUP BY department_id */

		//deparments
		$this->db->select('department_id,count(study_id) as total');
		$this->db->from('study_department');
		$this->db->group_by('department_id');
		$query = $this->db->get();

		$studies_by_department = array();
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$deposit = new stdClass;
				$deposit->total =  $row->total;

				$studies_ids = array();
				//studies
				$this->db->select('department_id,study_id');
				$this->db->from('study_department');
				$this->db->where('department_id',$row->department_id);
				$query1 = $this->db->get();
				if ($query1->num_rows() > 0){
					foreach($query1->result() as $row1){
						$studies_ids[]=$row1->study_id;
					}
				}

				$deposit->studies_ids = $studies_ids;
				if ($withtotal) {
					$studies_by_department[$row->department_id] = $deposit;
				} else {
					$studies_by_department[$row->department_id] = $studies_ids;
				}
				
				
			}
		}

		return $studies_by_department;
	}

	
	function get_all_studies_report_info($orderby = "DESC") {
		/*
		SELECT studies_id,studies_shortname,studies_name,studies_studies_organizational_unit_id, study_department.department_id, department_shortname
		FROM studies
		LEFT JOIN study_department ON studies.studies_studies_organizational_unit_id = study_department.study_id
		LEFT JOIN department ON study_department.department_id = department.department_id
		WHERE 1
		*/
		/*
		SELECT studies_id, studies_shortname, studies_name, studies_studies_organizational_unit_id,studies_organizational_unit_shortname
		FROM studies
		LEFT JOIN studies_organizational_unit ON studies.studies_studies_organizational_unit_id = studies_organizational_unit.studies_organizational_unit_id
		WHERE 1
		*/

		$courses_by_study = $this->get_courses_by_study();
		$classroomgroups_by_study = $this->get_classroomgroups_by_study();
		$studymodules_by_study = $this->get_studymodules_by_study();
		$studysubmodules_by_study = $this->get_studysubmodules_by_study();
		$enrollmentdata_by_study = $this->get_enrollmentdata_by_study();

		//deparments
		$this->db->select('studies_id,studies_shortname,studies_name,studies_studies_organizational_unit_id,studies_organizational_unit_shortname,
						  studies_law_id,studies_law_shortname,');
		$this->db->from('studies');
		$this->db->join('studies_organizational_unit','studies.studies_studies_organizational_unit_id = studies_organizational_unit.studies_organizational_unit_id', 'left');
		$this->db->join('studies_law','studies.studies_studies_law_id = studies_law.studies_law_id', 'left');
		
		$this->db->order_by('studies_shortname', $orderby);
		
		$query = $this->db->get();
        //echo $this->db->last_query();


		if ($query->num_rows() > 0){
			$all_studies = array();
			foreach($query->result() as $row){
				$study = new stdClass;
				
				$study->id = $row->studies_id;
				$study->shortname = $row->studies_shortname;
				$study->name = $row->studies_name;
				$study->studies_studies_organizational_unit_id = $row->studies_studies_organizational_unit_id;
				$study->studies_organizational_unit_shortname = $row->studies_organizational_unit_shortname;
				$study->studies_studies_law_id = $row->studies_law_id;
				$study->studies_studies_law_shortname = $row->studies_law_shortname;

				//get courses info
				if ( array_key_exists ( $row->studies_id , $courses_by_study )) {					
					$study->numberOfCourses = $courses_by_study[$row->studies_id]->total;
					$study->courses_ids = $courses_by_study[$row->studies_id]->courses_ids;

				}	else {
					$study->numberOfCourses = "";
					$study->courses_ids = "";
				}

				//get classroomgroups info
				if ( array_key_exists ( $row->studies_id , $classroomgroups_by_study )) {					
					$study->numberOfClassroomgroups = $classroomgroups_by_study[$row->studies_id]->total;
					$study->classroomgroups_ids = $classroomgroups_by_study[$row->studies_id]->classroomgroups_ids;

				}	else {
					$study->numberOfClassroomgroups = "";
					$study->classroomgroups_ids = "";
				}	

				//get studymodules info
				if ( array_key_exists ( $row->studies_id , $studymodules_by_study )) {					
					$study->numberOfStudyModules = $studymodules_by_study[$row->studies_id]->total;
					$study->studymodules_ids = $studymodules_by_study[$row->studies_id]->studymodules_ids;

				}	else {
					$study->numberOfStudyModules = "";
					$study->studymodules_ids = "";
				}		

				//get studysubmodules info
				if ( array_key_exists ( $row->studies_id , $studysubmodules_by_study )) {					
					$study->numberOfStudySubModules = $studysubmodules_by_study[$row->studies_id]->total;
					$study->studysubmodules_ids = $studysubmodules_by_study[$row->studies_id]->studysubmodules_ids;

				}	else {
					$study->numberOfStudySubModules = "";
					$study->studysubmodules_ids = "";
				}	


				//get ENROLLMENT INFO
				if ( array_key_exists ( $row->studies_id , $enrollmentdata_by_study )) {					
					$study->numberOfEnrolledStudies = $enrollmentdata_by_study[$row->studies_id]->total;
					//$study->studysubmodules_ids = $studysubmodules_by_study[$row->studies_id]->studysubmodules_ids;

				}	else {
					$study->numberOfEnrolledStudies = "";
					//$study->studysubmodules_ids = "";
				}		
				

				/*
				$teacher_fullname = $row->person_sn1 . " " . $row->person_sn1 . ", " . $row->person_givenName;
				$study->head_personid = $row->person_id;
				$study->head = "( " . $row->teacher1_code . " ) " . $teacher_fullname;
				$study->head_fullname = $teacher_fullname;
				$study->head_code = $row->teacher1_code;
				$study->head_id = $row->study_head;
				$study->parentstudy = $row->study_parent_study_id;
				$study->organizational_unit = $row->organizational_unit_name;
				$study->organizational_unit_id = $row->organizational_unit_id;
				$study->location = $row->location_name;
				$study->location_id = $row->study_location_id;				*/

				//get number of teacher Deparments
				/*if ( array_key_exists ( $row->study_id , $teachers_by_study )) {					
					$study->numberOfTeachers = $teachers_by_study[$row->study_id]->total;
					$study->teacher_ids = $teachers_by_study[$row->study_id]->teachers_ids;

				}	else {
					$study->numberOfTeachers = "";
					$study->teacher_ids = "";
				}

				//get number of teacher Studies
				if ( array_key_exists ( $row->study_id , $studies_by_study )) {					
					$study->numberOfStudies = $studies_by_study[$row->study_id]->total;
					$study->studies_ids = $studies_by_study[$row->study_id]->studies_ids;
				}	else {
					$study->numberOfStudies = "";
					$study->studies_ids = "";
				}*/
				
				$all_studies[$row->studies_id] = $study;
			}
			return $all_studies;
		}	
		else
			return false;
		

		/*$all_studies = array();

		$study1 = new stdClass;

		$study1->shortname = "Elèctrics";
		$study1->name = "Departament d'electrics";
		$study1->head = "Richard Stallman";
		$study1->location = "Aula 45";
		$study1->numberOfTeachers = 7;
		$study1->numberOfStudies = 2;

		$study2 = new stdClass;

		$study2->shortname = "Informàtica";
		$study2->name = "Departament d'informàtica";
		$study2->head = "Linus Torvalds";
		$study2->location = "Espai";
		$study2->numberOfTeachers = 6;
		$study2->numberOfStudies = 3;

		$all_studies[] = $study1;
		$all_studies[] = $study2;

		return $all_studies;*/
	}

	public function get_courses_study_module($study_module_id,$period=null,$order_by="ASC") {

        //GET period_id
        $period_id = $this->get_current_academic_period_id();
        if ($period!=null) {
            $period_id = $period;    
        }

        /*
        SELECT study_module_ap_courses_course_id,course_shortname,course_name,course_number
        FROM study_module_ap_courses
        INNER JOIN study_module_academic_periods  ON study_module_academic_periods.study_module_academic_periods_id =   study_module_ap_courses.study_module_ap_courses_study_module_ap_id
        INNER JOIN study_module ON study_module.study_module_id  = study_module_academic_periods.study_module_academic_periods_study_module_id
        INNER JOIN course ON course.course_id = study_module_ap_courses.study_module_ap_courses_course_id
        WHERE study_module_academic_periods_academic_period_id=5 AND study_module_id=1
        */

        $this->db->select('study_module_ap_courses_course_id,course_shortname,course_name,course_number,course_cycle_id, course_study_id,studies_shortname,
        				   studies_name, studies_studies_law_id, studies_law_shortname, studies_law_name');
        $this->db->distinct();
        $this->db->from('study_module_ap_courses');
        $this->db->join('study_module_academic_periods','study_module_academic_periods.study_module_academic_periods_id =   study_module_ap_courses.study_module_ap_courses_study_module_ap_id');
        $this->db->join('study_module','study_module.study_module_id  = study_module_academic_periods.study_module_academic_periods_study_module_id');
        $this->db->join('course','course.course_id = study_module_ap_courses.study_module_ap_courses_course_id');
        $this->db->join('studies','studies.studies_id = course.course_study_id');
   		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id', 'left');


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
                $course->studies_name = $row->studies_name;
                $course->studies_shortname = $row->studies_shortname;
                $course->studies_law_shortname = $row->studies_law_shortname;
                $course->studies_law_name = $row->studies_law_name;
                $course->studies_studies_law_id = $row->studies_studies_law_id;

                $courses_study_module[]=$course;
            }
        }   
        return $courses_study_module;

    }

	function get_all_studymodules_report_info($academic_period,$orderby = "DESC") {

		//TODO: GET COURSES INFO: pot haver 1 o més cursos per study_momdule

		//TODO: GET STUDY. ONLY COULD BE ONE. COULD BE OBTAINED BY courses_is. Tots els cursos han de ser del mateix estudy


		//classgroups
		//Example SQL:
		/*
		
		*/

		$this->db->select('study_module_id, study_module_academic_periods_external_code, study_module_shortname, study_module_name,study_module_hoursPerWeek, 
						   study_module_order, study_module_academic_periods_initialDate, study_module_academic_periods_endDate, study_module_type, 
						   study_module_subtype, study_module_description');
		$this->db->from('study_module_academic_periods');
		$this->db->join('study_module','study_module.study_module_id = study_module_academic_periods.study_module_academic_periods_study_module_id', 'left');
		$this->db->where('study_module_academic_periods_academic_period_id',$academic_period);
		
		//$this->db->order_by('studies_shortname', $orderby);


		
		$query = $this->db->get();
		//echo $this->db->last_query();


		if ($query->num_rows() > 0){
			$all_study_modules = array();
			foreach($query->result() as $row){
				$study_module = new stdClass;
				
				$study_module->id = $row->study_module_id;
				$study_module->code = $row->study_module_academic_periods_external_code;
				$study_module->shortname = $row->study_module_shortname;
				$study_module->name = $row->study_module_name;
				$study_module->description = $row->study_module_description;

				$courses = $this->get_courses_study_module($row->study_module_id,$academic_period);

				$study_module->courses = $courses;

				$study_module->study_module_hoursPerWeek = $row->study_module_hoursPerWeek;
				$study_module->study_module_order = $row->study_module_order;
				$study_module->study_module_initialDate = $row->study_module_academic_periods_initialDate;
				$study_module->study_module_endDate = $row->study_module_academic_periods_endDate;
				$study_module->study_module_type = $row->study_module_type;
				$study_module->study_module_subtype = $row->study_module_subtype;


				//get number of teacher Deparments
				/*
				if ( array_key_exists ( $row->course_id , $teachers_by_course )) {					
					$course->numberOfTeachers = $teachers_by_course[$row->course_id]->total;
					$course->teacher_ids = $teachers_by_course[$row->course_id]->teachers_ids;

				}	else {
					$course->numberOfTeachers = "";
					$course->teacher_ids = "";
				}	*/
				
				$all_study_modules[$row->study_module_id] = $study_module;
			}
			return $all_study_modules;
		}	
		else
			return false;

	}

	function get_all_lessons_report_info($academic_period,$orderby = "DESC") {

		//classgroups
		//Example SQL:
		/*
		SELECT lesson_id,lesson_academic_period_id, academic_periods.academic_periods_shortname,lesson_code, course_id, course_shortname, course_name, 
		course_study_id ,studies_shortname, studies_name ,lesson_classroom_group_id, classroom_group_code, classroom_group_shortName,classroom_group_name,lesson_teacher_id, 
		teacher_academic_periods_code, teacher_person_id, person_givenName, person_sn1, person_sn2, lesson_study_module_id, study_module_shortname, 
			   study_module_name, lesson_location_id, location_name, location_shortName, lesson_day, lesson_time_slot_id, time_slot_start_time, time_slot_end_time, time_slot_lective , time_slot_order
		FROM `lesson` 
		LEFT JOIN academic_periods ON academic_periods.academic_periods_id = lesson.lesson_academic_period_id
		LEFT JOIN classroom_group ON classroom_group.classroom_group_id = lesson.lesson_classroom_group_id
        LEFT JOIN course ON course.course_id = classroom_group.classroom_group_course_id
		LEFT JOIN studies ON studies.studies_id = course.course_study_id
		LEFT JOIN teacher ON teacher.teacher_id = lesson.lesson_teacher_id
		TODO 
		LEFT JOIN person ON person.person_id = teacher.teacher_person_id
		LEFT JOIN study_module ON study_module.study_module_id = lesson.lesson_study_module_id
		LEFT JOIN location ON location.location_id = lesson.lesson_location_id
		LEFT JOIN time_slot ON time_slot.time_slot_id = lesson.lesson_time_slot_id
		WHERE lesson_academic_period_id=4
		*/

		$this->db->select('lesson_id,lesson_academic_period_id,academic_periods.academic_periods_shortname,lesson_code, course_id, course_shortname, course_name, course_study_id ,studies_shortname, studies_name, lesson_classroom_group_id, classroom_group_code, classroom_group_shortName,
			   classroom_group_name,lesson_teacher_id, teacher_academic_periods_code, teacher_person_id, person_givenName, person_sn1, person_sn2, lesson_codi_assignatura, lesson_study_module_id, study_module_shortname, 
			   study_module_name, lesson_location_id, location_name, location_shortName, lesson_day, lesson_time_slot_id, time_slot_start_time, time_slot_end_time, time_slot_lective , time_slot_order');
		$this->db->from('lesson');
		$this->db->join('academic_periods','academic_periods.academic_periods_id = lesson.lesson_academic_period_id', 'left');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = lesson.lesson_classroom_group_id', 'left');
		$this->db->join('course','course.course_id = classroom_group.classroom_group_course_id', 'left');
		$this->db->join('studies','studies.studies_id = course.course_study_id', 'left');
		$this->db->join('teacher','teacher.teacher_id = lesson.lesson_teacher_id', 'left');
		$this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id', 'left');
		$this->db->join('person','person.person_id = teacher.teacher_person_id', 'left');
		$this->db->join('study_module','study_module.study_module_id = lesson.lesson_study_module_id', 'left');
		$this->db->join('location','location.location_id = lesson.lesson_location_id', 'left');
		$this->db->join('time_slot','time_slot.time_slot_id = lesson.lesson_time_slot_id', 'left');
		$this->db->where('lesson_academic_period_id',$academic_period);
		$this->db->where('teacher_academic_periods_academic_period_id',$academic_period);
		
		//$this->db->order_by('studies_shortname', $orderby);
		
		$query = $this->db->get();

		//echo $this->db->last_query();

		if ($query->num_rows() > 0){
			$all_lessons = array();
			foreach($query->result() as $row){
				$lesson = new stdClass;
				
				$lesson->id = $row->lesson_id;
				$lesson->academic_period = $row->lesson_academic_period_id;
				$lesson->academic_period_shortname = $row->academic_periods_shortname;				
				$lesson->code = $row->lesson_code;

				$lesson->course_id = $row->course_id;
				$lesson->course_shortname = $row->course_shortname;
				$lesson->course_name = $row->course_name;

				$lesson->studies_id = $row->course_study_id;
				$lesson->studies_shortname = $row->studies_shortname;
				$lesson->studies_name = $row->studies_name;

				$lesson->classroom_group_id = $row->lesson_classroom_group_id;
				$lesson->classroom_group_code = $row->classroom_group_code;
				$lesson->classroom_group_shortName = $row->classroom_group_shortName;
				$lesson->classroom_group_name = $row->classroom_group_name;

				$lesson->teacher_id = $row->lesson_teacher_id;
				$lesson->teacher_code = $row->teacher_academic_periods_code;
				$lesson->givenName = $row->person_givenName;
				$lesson->sn1 = $row->person_sn1;
				$lesson->sn2 = $row->person_sn2;

				$lesson->codi_assignatura = $row->lesson_codi_assignatura;
				$lesson->study_module_id = $row->lesson_study_module_id;
				$lesson->study_module_shortname = $row->study_module_shortname;
				$lesson->study_module_name = $row->study_module_name;
	

				$lesson->location_id = $row->lesson_location_id;
				$lesson->location_name = $row->location_name;
				$lesson->location_shortName = $row->location_shortName;

				$lesson->day = $row->lesson_day;
				$lesson->time_slot_id = $row->lesson_time_slot_id;
				$lesson->start_time = $row->time_slot_start_time;
				$lesson->end_time = $row->time_slot_end_time;
				$lesson->lective = $row->time_slot_lective;
				$lesson->order = $row->time_slot_order;
				
				$all_lessons[$row->lesson_id] = $lesson;
			}
			return $all_lessons;
		}	
		else
			return false;

	}

	function get_all_teachers_ids_and_names($orderby="ASC") {

		$get_current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT teacher_academic_periods_code, person_sn1, person_sn2, person_givenName, person_id, person_official_id
		FROM teacher_academic_periods
		INNER JOIN teacher ON teacher.teacher_id = teacher_academic_periods.teacher_academic_periods_teacher_id
		INNER JOIN person ON person.person_id = teacher.teacher_person_id
		WHERE teacher_academic_periods_academic_period_id=5

		*/
		$this->db->select('teacher_academic_periods_code, person_sn1, person_sn2, person_givenName, person_id, person_official_id');
		$this->db->from('teacher_academic_periods');        
		$this->db->join('teacher', 'teacher.teacher_id = teacher_academic_periods.teacher_academic_periods_teacher_id');
		$this->db->join('person', 'person.person_id = teacher.teacher_person_id');
		$this->db->order_by('teacher_academic_periods_code', $orderby);

        $query = $this->db->get();
        //echo $this->db->last_query(). "<br/>";
		
		if ($query->num_rows() > 0) {

			$teachers_array = array();

			foreach ($query->result_array() as $row)	{
   				$teachers_array[$row['teacher_academic_periods_code']] = $row['teacher_academic_periods_code'] . " - " . $row['person_sn1'] . " " . $row['person_sn2'] . ", " . $row['person_givenName'] . " - " . $row['person_official_id'];
			}
			return $teachers_array;
		}			
		else
			return false;
	}


	function get_all_study_submodules_ids_byteacher_id($academic_period_id,$teacher_id) {

		/*
		SELECT DISTINCT `study_submodules_id` 
		FROM (`lesson`) 
		INNER JOIN study_submodules ON study_submodules.`study_submodules_study_module_id`  = lesson.lesson_study_module_id
		INNER JOIN study_submodules_academic_periods ON study_submodules_academic_periods.`study_submodules_academic_periods_study_submodules_id` =  study_submodules.`study_submodules_id`
		WHERE `lesson_teacher_id` = '127' AND `lesson_academic_period_id` = '5' AND `study_submodules_academic_periods_academic_period_id`=5
		*/

		$this->db->select('study_submodules_id');
		$this->db->distinct();
		$this->db->from('lesson');
		$this->db->join('study_submodules','study_submodules.study_submodules_study_module_id  = lesson.lesson_study_module_id');
		$this->db->join('study_submodules_academic_periods','study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id =  study_submodules.study_submodules_id');
		$this->db->where('lesson_teacher_id',$teacher_id);
		$this->db->where('lesson_academic_period_id',$academic_period_id);
		$this->db->where('study_submodules_academic_periods_academic_period_id',$academic_period_id);

		$query = $this->db->get();
		//echo $this->db->last_query();

		$study_submodules_id = array();
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$study_submodules_id[] = $row->study_submodules_id;
			}
		}
		return $study_submodules_id;
	}

	function get_all_classroomgroupsids_by_mentor_id($academic_period_id,$mentor_id) {
		/*
		SELECT `classroom_group_academic_periods_classroom_group_id` 
		FROM (`classroom_group_academic_periods`) 
		WHERE `classroom_group_academic_periods_mentorId` = '71' AND `classroom_group_academic_periods_academic_period_id` = '5'
		*/

		$this->db->select('classroom_group_academic_periods_classroom_group_id');
		$this->db->from('classroom_group_academic_periods');
		$this->db->where('classroom_group_academic_periods_mentorId',$mentor_id);
		$this->db->where('classroom_group_academic_periods_academic_period_id',$academic_period_id);

		$query = $this->db->get();
		//echo $this->db->last_query() . "<br/>";

		$classroomgroupids = array();
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$classroomgroupids[] = $row->classroom_group_academic_periods_classroom_group_id;
			}
		}
		return $classroomgroupids;	
	}

	function get_all_study_submodules_id_by_mentor_id($academic_period_id,$teacher_code,$orderby = "ASC") {

		$teacher_id = $this->get_teacher_id_from_teacher_code($teacher_code,$academic_period_id);

		//GET CLASSROOM_GROUP_IDs where teacher is mentor
		$classroomgroupids = $this->get_all_classroomgroupsids_by_mentor_id($academic_period_id,$teacher_id);

		if ( ! (count($classroomgroupids) > 0) ) {
			return false;
		}

		/*
		SELECT DISTINCT `study_submodules_id` 
		FROM (`lesson`) 
		JOIN `study_submodules` ON `study_submodules`.`study_submodules_study_module_id` = `lesson`.`lesson_study_module_id` 
		JOIN `study_submodules_academic_periods` ON `study_submodules_academic_periods`.`study_submodules_academic_periods_study_submodules_id` = `study_submodules`.`study_submodules_id` 
		WHERE `lesson_classroom_group_id` IN ('25') AND `lesson_academic_period_id` = '5' AND `study_submodules_academic_periods_academic_period_id` = '5'
		*/

		$this->db->select('study_submodules_id');
		$this->db->distinct();
		$this->db->from('lesson');
		$this->db->join('study_submodules','study_submodules.study_submodules_study_module_id  = lesson.lesson_study_module_id');
		$this->db->join('study_submodules_academic_periods','study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id =  study_submodules.study_submodules_id');
		$this->db->where_in('lesson_classroom_group_id',$classroomgroupids);
		$this->db->where('lesson_academic_period_id',$academic_period_id);
		$this->db->where('study_submodules_academic_periods_academic_period_id',$academic_period_id);
		$this->db->order_by('study_submodules_id',$orderby);

		$query = $this->db->get();
		//echo $this->db->last_query() . "<br/>";

		$study_submodules_id = array();
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$study_submodules_id[] = $row->study_submodules_id;
			}
		}
		return $study_submodules_id;	
	}



	function get_all_study_submodules_ids_byteacher_code($academic_period_id,$teacher_code) {
		$teacher_id = $this->get_teacher_id_from_teacher_code($teacher_code,$academic_period_id) ;
		return $this->get_all_study_submodules_ids_byteacher_id($academic_period_id,$teacher_id);
	}

	function get_all_study_submodules_ids_classroomgroupid_and_teacher_code($academic_period_id,$teacher_code,$classroomgroupid) {
		$teacher_id = $this->get_teacher_id_from_teacher_code($teacher_code,$academic_period_id) ;
		return $this->get_all_study_submodules_ids_classroomgroupid_and_teacher_id($academic_period_id,$teacher_id,$classroomgroupid);
	}

	function get_all_study_submodules_ids_classroomgroupid_and_teacher_id($academic_period_id,$teacher_id,$classroomgroupid) {
		/*
		SELECT DISTINCT `study_submodules_id` 
		FROM (`lesson`) 
		JOIN `study_submodules` ON `study_submodules`.`study_submodules_study_module_id` = `lesson`.`lesson_study_module_id` 
		JOIN `study_submodules_academic_periods` ON `study_submodules_academic_periods`.`study_submodules_academic_periods_study_submodules_id` = `study_submodules`.`study_submodules_id` 
		WHERE `lesson_classroom_group_id` = '40' AND `lesson_academic_period_id` = '5' AND `study_submodules_academic_periods_academic_period_id` = '5' 
		*/

		$this->db->select('study_submodules_id');
		$this->db->distinct();
		$this->db->from('lesson');
		$this->db->join('study_submodules','study_submodules.study_submodules_study_module_id  = lesson.lesson_study_module_id');
		$this->db->join('study_submodules_academic_periods','study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id =  study_submodules.study_submodules_id');
		$this->db->where('lesson_classroom_group_id',$classroomgroupid);
		$this->db->where('lesson_teacher_id',$teacher_id);
		$this->db->where('lesson_academic_period_id',$academic_period_id);
		$this->db->where('study_submodules_academic_periods_academic_period_id',$academic_period_id);

		$query = $this->db->get();
		//echo $this->db->last_query();

		$study_submodules_id = array();
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$study_submodules_id[] = $row->study_submodules_id;
			}
		}
		return $study_submodules_id;
	}

	function get_all_study_submodules_ids_classroomgroupid($academic_period_id,$classroomgroupid) {
		/*
		SELECT DISTINCT `study_submodules_id` 
		FROM (`lesson`) 
		JOIN `study_submodules` ON `study_submodules`.`study_submodules_study_module_id` = `lesson`.`lesson_study_module_id` 
		JOIN `study_submodules_academic_periods` ON `study_submodules_academic_periods`.`study_submodules_academic_periods_study_submodules_id` = `study_submodules`.`study_submodules_id` 
		WHERE `lesson_classroom_group_id` = '40' AND `lesson_academic_period_id` = '5' AND `study_submodules_academic_periods_academic_period_id` = '5' 
		*/

		$this->db->select('study_submodules_id');
		$this->db->distinct();
		$this->db->from('lesson');
		$this->db->join('study_submodules','study_submodules.study_submodules_study_module_id  = lesson.lesson_study_module_id');
		$this->db->join('study_submodules_academic_periods','study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id =  study_submodules.study_submodules_id');
		$this->db->where('lesson_classroom_group_id',$classroomgroupid);
		$this->db->where('lesson_academic_period_id',$academic_period_id);
		$this->db->where('study_submodules_academic_periods_academic_period_id',$academic_period_id);

		$query = $this->db->get();
		//echo $this->db->last_query();

		$study_submodules_id = array();
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$study_submodules_id[] = $row->study_submodules_id;
			}
		}
		return $study_submodules_id;
	}

	function get_teacher_id_from_teacher_code($teacher_code, $current_academic_period_id = null) {

		if ($current_academic_period_id == null) {
			$current_academic_period_id = $this->get_current_academic_period_id();	
		}
		

		$this->db->select('teacher_academic_periods_teacher_id');
		$this->db->from('teacher_academic_periods');
		$this->db->where('teacher_academic_periods.teacher_academic_periods_code',$teacher_code);
		$this->db->where('teacher_academic_periods.teacher_academic_periods_academic_period_id',$current_academic_period_id);

		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->teacher_academic_periods_teacher_id;
		}
		else
			return false;
	}

	function get_all_study_submodules_report_info_by_teacher_code($academic_period,$teacher_code,$orderby = "DESC") {
		
		$study_submodules_id = $this->get_all_study_submodules_ids_byteacher_code($academic_period,$teacher_code);

		if (!(count($study_submodules_id)>0)) {
			return array();
		}


		//classgroups
		//Example SQL:
		/*
		SELECT study_submodules_id,study_submodules_shortname,study_submodules_name,study_submodules_study_module_id, study_module_shortname, 
		study_module_name, study_submodules_courseid, course_shortname, course_name , course.course_study_id, studies_shortname, studies_name,studies_studies_law_id, 
		studies_law_shortname, studies_law_name, study_submodules_academic_periods_initialDate, study_submodules_academic_periods_endDate, study_submodules_academic_periods_totalHours,study_submodules_order,study_submodules_description
		FROM study_submodules_academic_periods 
		LEFT JOIN study_submodules ON study_submodules.study_submodules_id = study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id
		LEFT JOIN study_module ON study_module.study_module_id = study_submodules.study_submodules_study_module_id
		LEFT JOIN course ON  course.course_id = study_submodules.study_submodules_courseid
		LEFT JOIN studies ON  studies.studies_id = course.course_study_id
		LEFT JOIN studies_law ON  studies_law.studies_law_id = studies.studies_studies_law_id
		WHERE study_submodules_academic_periods_academic_period_id = 5
		*/

		$this->db->select('study_submodules_id,study_submodules_shortname,study_submodules_name,study_submodules_study_module_id, study_module_shortname, 
							study_module_name, study_submodules_courseid, course_shortname, course_name , course.course_study_id, studies_shortname, studies_name,studies_studies_law_id, 
							studies_law_shortname, studies_law_name, study_submodules_academic_periods_initialDate, study_submodules_academic_periods_endDate, 
							study_submodules_academic_periods_initialDate_planned, study_submodules_academic_periods_endDate_planned, 
							study_submodules_academic_periods_totalHours,
							study_submodules_order,study_submodules_description');
		$this->db->from('study_submodules_academic_periods');
		$this->db->join('study_submodules','study_submodules.study_submodules_id = study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id', 'left');
		$this->db->join('study_module','study_module.study_module_id = study_submodules.study_submodules_study_module_id', 'left');
		$this->db->join('course','course.course_id = study_submodules.study_submodules_courseid', 'left');
		$this->db->join('studies','studies.studies_id = course.course_study_id', 'left');
		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id', 'left');
		$this->db->where('study_submodules_academic_periods_academic_period_id',$academic_period);
		$this->db->where_in('study_submodules_id',$study_submodules_id);
		
		$this->db->order_by('studies_shortname', $orderby);
		
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0){
			$all_study_submodules = array();
			foreach($query->result() as $row){
				$study_submodule = new stdClass;
				
				$study_submodule->id = $row->study_submodules_id;
				$study_submodule->shortname = $row->study_submodules_shortname;
				$study_submodule->name = $row->study_submodules_name;
				$study_submodule->description = $row->study_submodules_description;

				$study_submodule->module_id = $row->study_submodules_study_module_id;
				$study_submodule->module_shortname = $row->study_module_shortname;
				$study_submodule->module_name = $row->study_module_name;

				$study_submodule->course_id = $row->study_submodules_courseid;
				$study_submodule->course_shortname = $row->course_shortname;
				$study_submodule->course_name = $row->course_name;

				$study_submodule->study_id = $row->course_study_id;
				$study_submodule->study_shortname = $row->studies_shortname;
				$study_submodule->study_name = $row->studies_name;
				$study_submodule->study_law_id = $row->studies_studies_law_id;
				$study_submodule->study_law_name = $row->studies_law_shortname;
				$study_submodule->study_law_shortname = $row->studies_law_name;

				$study_submodule->study_submodules_totalHours = $row->study_submodules_academic_periods_totalHours;
				$study_submodule->study_submodules_order = $row->study_submodules_order;
				$study_submodule->study_submodule_initialDate = $row->study_submodules_academic_periods_initialDate;
				$study_submodule->study_submodule_endDate = $row->study_submodules_academic_periods_endDate;
				$study_submodule->study_submodule_initialDate_planned = $row->study_submodules_academic_periods_initialDate_planned;
				$study_submodule->study_submodule_endDate_planned = $row->study_submodules_academic_periods_endDate_planned;
				
				//get number of teacher Deparments
				/*
				if ( array_key_exists ( $row->course_id , $teachers_by_course )) {					
					$course->numberOfTeachers = $teachers_by_course[$row->course_id]->total;
					$course->teacher_ids = $teachers_by_course[$row->course_id]->teachers_ids;

				}	else {
					$course->numberOfTeachers = "";
					$course->teacher_ids = "";
				}	*/
				
				$all_study_submodules[$row->study_submodules_id] = $study_submodule;
			}
			return $all_study_submodules;
		}	
		else
			return false;

	}

	function get_all_study_submodules_report_info_by_classroomgroupid_and_teacher_code($academic_period,$teacher_code,$classroom_group_id,$orderby = "DESC") {

		$study_submodules_id = $this->get_all_study_submodules_ids_classroomgroupid_and_teacher_code($academic_period, $teacher_code, $classroom_group_id);

		if (!(count($study_submodules_id)>0)) {
			return array();
		}


		//classgroups
		//Example SQL:
		/*
		SELECT study_submodules_id,study_submodules_shortname,study_submodules_name,study_submodules_study_module_id, study_module_shortname, 
		study_module_name, study_submodules_courseid, course_shortname, course_name , course.course_study_id, studies_shortname, studies_name,studies_studies_law_id, 
		studies_law_shortname, studies_law_name, study_submodules_academic_periods_initialDate, study_submodules_academic_periods_endDate, study_submodules_academic_periods_totalHours,study_submodules_order,study_submodules_description
		FROM study_submodules_academic_periods 
		LEFT JOIN study_submodules ON study_submodules.study_submodules_id = study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id
		LEFT JOIN study_module ON study_module.study_module_id = study_submodules.study_submodules_study_module_id
		LEFT JOIN course ON  course.course_id = study_submodules.study_submodules_courseid
		LEFT JOIN studies ON  studies.studies_id = course.course_study_id
		LEFT JOIN studies_law ON  studies_law.studies_law_id = studies.studies_studies_law_id
		WHERE study_submodules_academic_periods_academic_period_id = 5
		*/

		$this->db->select('study_submodules_id,study_submodules_shortname,study_submodules_name,study_submodules_study_module_id, study_module_shortname, 
							study_module_name, study_submodules_courseid, course_shortname, course_name , course.course_study_id, studies_shortname, studies_name,studies_studies_law_id, 
							studies_law_shortname, studies_law_name, study_submodules_academic_periods_initialDate, study_submodules_academic_periods_endDate,
							study_submodules_academic_periods_initialDate_planned, study_submodules_academic_periods_endDate_planned, study_submodules_academic_periods_totalHours,
							study_submodules_order,study_submodules_description');
		$this->db->from('study_submodules_academic_periods');
		$this->db->join('study_submodules','study_submodules.study_submodules_id = study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id', 'left');
		$this->db->join('study_module','study_module.study_module_id = study_submodules.study_submodules_study_module_id', 'left');
		$this->db->join('course','course.course_id = study_submodules.study_submodules_courseid', 'left');
		$this->db->join('studies','studies.studies_id = course.course_study_id', 'left');
		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id', 'left');
		$this->db->where('study_submodules_academic_periods_academic_period_id',$academic_period);
		$this->db->where_in('study_submodules_id',$study_submodules_id);
		
		$this->db->order_by('studies_shortname', $orderby);
		
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0){
			$all_study_submodules = array();
			foreach($query->result() as $row){
				$study_submodule = new stdClass;
				
				$study_submodule->id = $row->study_submodules_id;
				$study_submodule->shortname = $row->study_submodules_shortname;
				$study_submodule->name = $row->study_submodules_name;
				$study_submodule->description = $row->study_submodules_description;

				$study_submodule->module_id = $row->study_submodules_study_module_id;
				$study_submodule->module_shortname = $row->study_module_shortname;
				$study_submodule->module_name = $row->study_module_name;

				$study_submodule->course_id = $row->study_submodules_courseid;
				$study_submodule->course_shortname = $row->course_shortname;
				$study_submodule->course_name = $row->course_name;

				$study_submodule->study_id = $row->course_study_id;
				$study_submodule->study_shortname = $row->studies_shortname;
				$study_submodule->study_name = $row->studies_name;
				$study_submodule->study_law_id = $row->studies_studies_law_id;
				$study_submodule->study_law_name = $row->studies_law_shortname;
				$study_submodule->study_law_shortname = $row->studies_law_name;

				$study_submodule->study_submodules_totalHours = $row->study_submodules_academic_periods_totalHours;
				$study_submodule->study_submodules_order = $row->study_submodules_order;
				$study_submodule->study_submodule_initialDate = $row->study_submodules_academic_periods_initialDate;
				$study_submodule->study_submodule_endDate = $row->study_submodules_academic_periods_endDate;
				$study_submodule->study_submodule_initialDate_planned = $row->study_submodules_academic_periods_initialDate_planned;
				$study_submodule->study_submodule_endDate_planned = $row->study_submodules_academic_periods_endDate_planned;

				
				//get number of teacher Deparments
				/*
				if ( array_key_exists ( $row->course_id , $teachers_by_course )) {					
					$course->numberOfTeachers = $teachers_by_course[$row->course_id]->total;
					$course->teacher_ids = $teachers_by_course[$row->course_id]->teachers_ids;

				}	else {
					$course->numberOfTeachers = "";
					$course->teacher_ids = "";
				}	*/
				
				$all_study_submodules[$row->study_submodules_id] = $study_submodule;
			}
			return $all_study_submodules;
		}	
		else
			return false;

	}



	function get_all_study_submodules_report_info_by_classroomgroupid($academic_period,$classroom_group_id,$orderby = "DESC") {
		
		$study_submodules_id = $this->get_all_study_submodules_ids_classroomgroupid($academic_period,$classroom_group_id);

		if (!(count($study_submodules_id)>0)) {
			return array();
		}


		//classgroups
		//Example SQL:
		/*
		SELECT study_submodules_id,study_submodules_shortname,study_submodules_name,study_submodules_study_module_id, study_module_shortname, 
		study_module_name, study_submodules_courseid, course_shortname, course_name , course.course_study_id, studies_shortname, studies_name,studies_studies_law_id, 
		studies_law_shortname, studies_law_name, study_submodules_academic_periods_initialDate, study_submodules_academic_periods_endDate, study_submodules_academic_periods_totalHours,study_submodules_order,study_submodules_description
		FROM study_submodules_academic_periods 
		LEFT JOIN study_submodules ON study_submodules.study_submodules_id = study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id
		LEFT JOIN study_module ON study_module.study_module_id = study_submodules.study_submodules_study_module_id
		LEFT JOIN course ON  course.course_id = study_submodules.study_submodules_courseid
		LEFT JOIN studies ON  studies.studies_id = course.course_study_id
		LEFT JOIN studies_law ON  studies_law.studies_law_id = studies.studies_studies_law_id
		WHERE study_submodules_academic_periods_academic_period_id = 5
		*/

		$this->db->select('study_submodules_id,study_submodules_shortname,study_submodules_name,study_submodules_study_module_id, study_module_shortname, 
							study_module_name, study_submodules_courseid, course_shortname, course_name , course.course_study_id, studies_shortname, studies_name,studies_studies_law_id, 
							studies_law_shortname, studies_law_name, study_submodules_academic_periods_initialDate, 
							study_submodules_academic_periods_initialDate_planned, study_submodules_academic_periods_endDate_planned,
							study_submodules_academic_periods_endDate, study_submodules_academic_periods_totalHours,
							study_submodules_order,study_submodules_description');
		$this->db->from('study_submodules_academic_periods');
		$this->db->join('study_submodules','study_submodules.study_submodules_id = study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id', 'left');
		$this->db->join('study_module','study_module.study_module_id = study_submodules.study_submodules_study_module_id', 'left');
		$this->db->join('course','course.course_id = study_submodules.study_submodules_courseid', 'left');
		$this->db->join('studies','studies.studies_id = course.course_study_id', 'left');
		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id', 'left');
		$this->db->where('study_submodules_academic_periods_academic_period_id',$academic_period);
		$this->db->where_in('study_submodules_id',$study_submodules_id);
		
		$this->db->order_by('studies_shortname', $orderby);
		
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0){
			$all_study_submodules = array();
			foreach($query->result() as $row){
				$study_submodule = new stdClass;
				
				$study_submodule->id = $row->study_submodules_id;
				$study_submodule->shortname = $row->study_submodules_shortname;
				$study_submodule->name = $row->study_submodules_name;
				$study_submodule->description = $row->study_submodules_description;

				$study_submodule->module_id = $row->study_submodules_study_module_id;
				$study_submodule->module_shortname = $row->study_module_shortname;
				$study_submodule->module_name = $row->study_module_name;

				$study_submodule->course_id = $row->study_submodules_courseid;
				$study_submodule->course_shortname = $row->course_shortname;
				$study_submodule->course_name = $row->course_name;

				$study_submodule->study_id = $row->course_study_id;
				$study_submodule->study_shortname = $row->studies_shortname;
				$study_submodule->study_name = $row->studies_name;
				$study_submodule->study_law_id = $row->studies_studies_law_id;
				$study_submodule->study_law_name = $row->studies_law_shortname;
				$study_submodule->study_law_shortname = $row->studies_law_name;

				$study_submodule->study_submodules_totalHours = $row->study_submodules_academic_periods_totalHours;
				$study_submodule->study_submodules_order = $row->study_submodules_order;
				$study_submodule->study_submodule_initialDate = $row->study_submodules_academic_periods_initialDate;
				$study_submodule->study_submodule_endDate = $row->study_submodules_academic_periods_endDate;
				$study_submodule->study_submodule_initialDate_planned = $row->study_submodules_academic_periods_initialDate_planned;
				$study_submodule->study_submodule_endDate_planned = $row->study_submodules_academic_periods_endDate_planned;
				
				//get number of teacher Deparments
				/*
				if ( array_key_exists ( $row->course_id , $teachers_by_course )) {					
					$course->numberOfTeachers = $teachers_by_course[$row->course_id]->total;
					$course->teacher_ids = $teachers_by_course[$row->course_id]->teachers_ids;

				}	else {
					$course->numberOfTeachers = "";
					$course->teacher_ids = "";
				}	*/
				
				$all_study_submodules[$row->study_submodules_id] = $study_submodule;
			}
			return $all_study_submodules;
		}	
		else
			return false;

	}



	function get_all_study_submodules_report_info($academic_period,$orderby = "DESC") {

		//classgroups
		//Example SQL:
		/*
		SELECT study_submodules_id,study_submodules_shortname,study_submodules_name,study_submodules_study_module_id, study_module_shortname, 
		study_module_name, study_submodules_courseid, course_shortname, course_name , course.course_study_id, studies_shortname, studies_name,studies_studies_law_id, 
		studies_law_shortname, studies_law_name, study_submodules_academic_periods_initialDate, study_submodules_academic_periods_endDate, study_submodules_academic_periods_totalHours,study_submodules_order,study_submodules_description
		FROM study_submodules_academic_periods 
		LEFT JOIN study_submodules ON study_submodules.study_submodules_id = study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id
		LEFT JOIN study_module ON study_module.study_module_id = study_submodules.study_submodules_study_module_id
		LEFT JOIN course ON  course.course_id = study_submodules.study_submodules_courseid
		LEFT JOIN studies ON  studies.studies_id = course.course_study_id
		LEFT JOIN studies_law ON  studies_law.studies_law_id = studies.studies_studies_law_id
		WHERE study_submodules_academic_periods_academic_period_id = 5
		*/

		$this->db->select('study_submodules_id,study_submodules_shortname,study_submodules_name,study_submodules_study_module_id, study_module_shortname, 
							study_module_name, study_submodules_courseid, course_shortname, course_name , course.course_study_id, studies_shortname, studies_name,studies_studies_law_id, 
							studies_law_shortname, studies_law_name, study_submodules_academic_periods_initialDate, 
							study_submodules_academic_periods_initialDate_planned, study_submodules_academic_periods_endDate_planned,
							study_submodules_academic_periods_endDate, study_submodules_academic_periods_totalHours,
							study_submodules_order,study_submodules_description');
		$this->db->from('study_submodules_academic_periods');
		$this->db->join('study_submodules','study_submodules.study_submodules_id = study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id', 'left');
		$this->db->join('study_module','study_module.study_module_id = study_submodules.study_submodules_study_module_id', 'left');
		$this->db->join('course','course.course_id = study_submodules.study_submodules_courseid', 'left');
		$this->db->join('studies','studies.studies_id = course.course_study_id', 'left');
		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id', 'left');
		$this->db->where('study_submodules_academic_periods_academic_period_id',$academic_period);
		//$this->db->limit(10);
		
		$this->db->order_by('studies_shortname', $orderby);
		
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0){
			$all_study_submodules = array();
			foreach($query->result() as $row){
				$study_submodule = new stdClass;
				
				$study_submodule->id = $row->study_submodules_id;
				$study_submodule->shortname = $row->study_submodules_shortname;
				$study_submodule->name = $row->study_submodules_name;
				$study_submodule->description = $row->study_submodules_description;

				$study_submodule->module_id = $row->study_submodules_study_module_id;
				$study_submodule->module_shortname = $row->study_module_shortname;
				$study_submodule->module_name = $row->study_module_name;

				$study_submodule->course_id = $row->study_submodules_courseid;
				$study_submodule->course_shortname = $row->course_shortname;
				$study_submodule->course_name = $row->course_name;

				$study_submodule->study_id = $row->course_study_id;
				$study_submodule->study_shortname = $row->studies_shortname;
				$study_submodule->study_name = $row->studies_name;
				$study_submodule->study_law_id = $row->studies_studies_law_id;
				$study_submodule->study_law_name = $row->studies_law_shortname;
				$study_submodule->study_law_shortname = $row->studies_law_name;

				$study_submodule->study_submodules_totalHours = $row->study_submodules_academic_periods_totalHours;
				$study_submodule->study_submodules_order = $row->study_submodules_order;
				$study_submodule->study_submodule_initialDate = $row->study_submodules_academic_periods_initialDate;
				$study_submodule->study_submodule_endDate = $row->study_submodules_academic_periods_endDate;
				$study_submodule->study_submodule_initialDate_planned = $row->study_submodules_academic_periods_initialDate_planned;
				$study_submodule->study_submodule_endDate_planned = $row->study_submodules_academic_periods_endDate_planned;
				
				//get number of teacher Deparments
				/*
				if ( array_key_exists ( $row->course_id , $teachers_by_course )) {					
					$course->numberOfTeachers = $teachers_by_course[$row->course_id]->total;
					$course->teacher_ids = $teachers_by_course[$row->course_id]->teachers_ids;

				}	else {
					$course->numberOfTeachers = "";
					$course->teacher_ids = "";
				}	*/
				
				$all_study_submodules[$row->study_submodules_id] = $study_submodule;
			}
			return $all_study_submodules;
		}	
		else
			return false;

	}

	function get_all_academic_periods($orderby="desc") {
		/*
		SELECT academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current FROM academic_periods WHERE 1
		*/
		$this->db->select('academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current');
		$this->db->from('academic_periods');
	

		$this->db->order_by('academic_periods_id', $orderby);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0){
			$all_academic_periods = array();
			foreach($query->result() as $row){
				$academic_period = new stdClass;
				
				$academic_period->id = $row->academic_periods_id;
				$academic_period->shortname = $row->academic_periods_shortname;
				$academic_period->name = $row->academic_periods_name;
				$academic_period->alt_name = $row->academic_periods_alt_name;
				$academic_period->current = $row->academic_periods_current;

				$all_academic_periods[$academic_period->id] = $academic_period;
			}
			return $all_academic_periods;
		}	
		else
			return false;
	}

	public function get_academic_period_dates($academic_period_id) {
		$this->db->select('academic_periods_initial_date,academic_periods_final_date');
		$this->db->from('academic_periods');
		$this->db->where('academic_periods_id',$academic_period_id);
		
		$query = $this->db->get();

		if ($query->num_rows() == 1){
			$row = $query->row(); 
			$dates = new stdClass();
			$dates->initial_date = $row->academic_periods_initial_date;
			$dates->final_date = $row->academic_periods_final_date;

			return $dates;
		}	
		else {
			return false;
		}

	}

	public function get_academic_period_initial_date($academic_period_id) {
		$this->db->select('academic_periods_initial_date');
		$this->db->from('academic_periods');
		$this->db->where('academic_periods_id',$academic_period_id);
		
		$query = $this->db->get();

		if ($query->num_rows() == 1){
			$row = $query->row(); 
			return $row->academic_periods_initial_date;
		}	
		else {
			return false;
		}
	
	}

	public function get_academic_period_final_date($academic_period_id){
		$this->db->select('academic_periods_final_date');
		$this->db->from('academic_periods');
		$this->db->where('academic_periods_id',$academic_period_id);
		
		$query = $this->db->get();

		if ($query->num_rows() == 1){
			$row = $query->row(); 
			return $row->academic_periods_final_date;
		}	
		else {
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
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() == 1){
			$row = $query->row(); 
			return $row->academic_periods_id;
		}	
		else
			return false;
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
			$academic_period = new stdClass;
			$row = $query->row();
				
			$academic_period->id = $row->academic_periods_id;
			$academic_period->shortname = $row->academic_periods_shortname;
			$academic_period->name = $row->academic_periods_name;
			$academic_period->alt_name = $row->academic_periods_alt_name;
			$academic_period->current = $row->academic_periods_current;

			return $academic_period;
		}	
		else
			return false;
	}

	function get_all_classgroups_report_info($academic_period,$orderby = "DESC") {

		/* SQL SCRIPT FOR MIGRATION
		UPDATE  classroom_group_academic_periods AS cgap 
		INNER JOIN classroom_group AS cg ON cg.classroom_group_id 	 = cgap.classroom_group_academic_periods_classroom_group_id
		SET cgap.classroom_group_academic_periods_mentorId = cg.classroom_group_mentorId, cgap.classroom_group_academic_periods_description = cg.classroom_group_description, cgap.classroom_group_academic_periods_shift = cg.classroom_group_shift,  cgap.classroom_group_academic_periods_location = cg.classroom_group_location_id
		WHERE classroom_group_academic_periods_academic_period_id = 5
		*/

		//classgroups
		//Example SQL:
		/*
		SELECT `classroom_group_id`, `classroom_group_code`, `classroom_group_shortName`, `classroom_group_name`, `classroom_group_course_id`, 
		`classroom_group_academic_periods_description`, `classroom_group_academic_periods_mentorId`, `classroom_group_academic_periods_shift`, 
		`classroom_group_academic_periods_location`, `course_shortname`, `course_name`, `course_study_id`, `studies_shortname`, `studies_name`, 
		`studies_studies_organizational_unit_id`, `studies_studies_law_id`, `studies_law_shortname`, `studies_law_name`, `teacher_person_id`,
		 `teacher_academic_periods_code`, `teacher_academic_periods_department_id`, `person_givenName`, `person_sn1`, `person_sn2`, `shift_name`,
		  `location_name`, `location_shortName` 
		  FROM (`classroom_group_academic_periods`) 
		  LEFT JOIN `classroom_group` ON `classroom_group`.`classroom_group_id` = `classroom_group_academic_periods`.`classroom_group_academic_periods_classroom_group_id` 
		  LEFT JOIN `course` ON `course`.`course_id` = `classroom_group`.`classroom_group_course_id` 
		  LEFT JOIN `studies` ON `studies`.`studies_id` = `course`.`course_study_id` 
		  LEFT JOIN `studies_law` ON `studies_law`.`studies_law_id` = `studies`.`studies_studies_law_id` 
		  LEFT JOIN `teacher` ON `teacher`.`teacher_id` = `classroom_group_academic_periods`.`classroom_group_academic_periods_mentorId` 
		  JOIN `teacher_academic_periods` ON `teacher_academic_periods`.`teacher_academic_periods_teacher_id` = `teacher`.`teacher_id` 
		  LEFT JOIN `person` ON `person`.`person_id` = `teacher`.`teacher_person_id` 
		  LEFT JOIN `shift` ON `shift`.`shift_id` = `classroom_group_academic_periods`.`classroom_group_academic_periods_shift` 
		  LEFT JOIN `location` ON `location`.`location_id` = `classroom_group_academic_periods`.`classroom_group_academic_periods_location` 
		  WHERE `classroom_group_academic_periods_academic_period_id` = '5' AND `teacher_academic_periods_academic_period_id` = '5' 
		  ORDER BY `studies_shortname` DESC 
		*/

		$this->db->select('classroom_group_id, classroom_group_code, classroom_group_shortName, classroom_group_name, classroom_group_course_id, classroom_group_academic_periods_description, classroom_group_academic_periods_mentorId, classroom_group_academic_periods_shift, 
		classroom_group_academic_periods_location, course_shortname, course_name, course_study_id, studies_shortname, studies_name, studies_studies_organizational_unit_id, studies_studies_law_id, studies_law_shortname, 
		studies_law_name, teacher_person_id, teacher_academic_periods_code,teacher_academic_periods_department_id, person_givenName, person_sn1, person_sn2,shift_name,location_name, location_shortName');
		$this->db->from('classroom_group_academic_periods');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id', 'left');
		$this->db->join('course','course.course_id = classroom_group.classroom_group_course_id', 'left');
		$this->db->join('studies','studies.studies_id = course.course_study_id', 'left');
		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id', 'left');
		$this->db->join('teacher','teacher.teacher_id = classroom_group_academic_periods.classroom_group_academic_periods_mentorId', 'left');
		$this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');
		$this->db->join('person','person.person_id = teacher.teacher_person_id', 'left');
		$this->db->join('shift','shift.shift_id = classroom_group_academic_periods.classroom_group_academic_periods_shift', 'left');
		$this->db->join('location','location.location_id = classroom_group_academic_periods.classroom_group_academic_periods_location', 'left');
		$this->db->where('classroom_group_academic_periods_academic_period_id',$academic_period);
		$this->db->where('teacher_academic_periods_academic_period_id',$academic_period);


		$this->db->order_by('studies_shortname', $orderby);
		
		$query = $this->db->get();
		//echo $this->db->last_query();


		if ($query->num_rows() > 0){
			$all_classroom_groups = array();
			foreach($query->result() as $row){
				$classroom_group = new stdClass;
				
				$classroom_group->id = $row->classroom_group_id;
				$classroom_group->code = $row->classroom_group_code;
				$classroom_group->shortname = $row->classroom_group_shortName;
				$classroom_group->name = $row->classroom_group_name;
				$classroom_group->description = $row->classroom_group_academic_periods_description;

				$classroom_group->course_id = $row->classroom_group_course_id;
				$classroom_group->course_shortname = $row->course_shortname;
				$classroom_group->course_name = $row->course_name;

				$classroom_group->study_id = $row->course_study_id;
				$classroom_group->study_shortname = $row->studies_shortname;
				$classroom_group->study_name = $row->studies_name;
				$classroom_group->study_ou_id = $row->studies_studies_organizational_unit_id;
				$classroom_group->study_law_id = $row->studies_studies_law_id;
				$classroom_group->study_law_name = $row->studies_law_shortname;
				$classroom_group->study_law_shortname = $row->studies_law_name;
				
				$classroom_group->mentor_id = $row->classroom_group_academic_periods_mentorId;
				$classroom_group->mentor_person_id = $row->teacher_person_id;
				$classroom_group->mentor_code = $row->teacher_academic_periods_code;
				$classroom_group->mentor_department_id = $row->teacher_academic_periods_department_id;
				$classroom_group->mentor_givenname = $row->person_givenName;
				$classroom_group->mentor_sn1 = $row->person_sn1;
				$classroom_group->mentor_sn2 = $row->person_sn2;

				$classroom_group->shift_id = $row->classroom_group_academic_periods_shift;
				$classroom_group->shift_name = $row->shift_name;

				$classroom_group->location_id = $row->classroom_group_academic_periods_location;
				$classroom_group->location_name = $row->location_name;
				$classroom_group->location_shortname = $row->location_shortName;

				//get number of teacher Deparments
				/*
				if ( array_key_exists ( $row->course_id , $teachers_by_course )) {					
					$course->numberOfTeachers = $teachers_by_course[$row->course_id]->total;
					$course->teacher_ids = $teachers_by_course[$row->course_id]->teachers_ids;

				}	else {
					$course->numberOfTeachers = "";
					$course->teacher_ids = "";
				}	*/
				
				$all_classroom_groups[$row->classroom_group_id] = $classroom_group;
			}
			return $all_classroom_groups;
		}	
		else
			return false;

	}
	

	function get_all_courses_report_info($orderby = "DESC") {

			
		//$teachers_by_department = $this->get_teachers_by_department();
		//$studies_by_department = $this->get_studies_by_department();


		//courses
		//Example SQL:
		/*
		SELECT course_id, course_shortname, course_name, course_number course_cycle_id, course_study_id, cycle_id, cycle_shortname, cycle_name, studies_id, studies_shortname, studies_name, studies_studies_organizational_unit_id, studies_studies_law_id, studies_law_shortname, studies_law_name
		FROM `course` 
		LEFT JOIN cycle ON cycle.cycle_id = course.course_cycle_id
		LEFT JOIN studies ON studies.studies_id = course.course_study_id
		LEFT JOIN studies_law ON studies_law.studies_law_id = studies.studies_studies_law_id
		WHERE 1
		*/

		$this->db->select('course_id, course_shortname, course_name, course_number, course_cycle_id, course_study_id, cycle_shortname, cycle_name,  
			               studies_shortname, studies_name, studies_studies_organizational_unit_id, studies_studies_law_id,
			               studies_law_shortname, studies_law_name');
		$this->db->from('course');
		$this->db->join('cycle','cycle.cycle_id = course.course_cycle_id', 'left');
		$this->db->join('studies','studies.studies_id = course.course_study_id', 'left');
		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id', 'left');
		$this->db->order_by('studies_shortname', $orderby);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0){
			$all_courses = array();
			foreach($query->result() as $row){
				$course = new stdClass;
				
				$course->id = $row->course_id;
				$course->shortname = $row->course_shortname;
				$course->name = $row->course_name;
				$course->course_number = $row->course_number;
				$course->course_cycle_id = $row->course_cycle_id;
				$course->course_study_id = $row->course_study_id;
				$course->cycle_shortname = $row->cycle_shortname;
				$course->cycle_name = $row->cycle_name;
				$course->studies_shortname = $row->studies_shortname;
				$course->studies_name = $row->studies_name;
				$course->studies_studies_organizational_unit_id = $row->studies_studies_organizational_unit_id;
				$course->studies_studies_law_id = $row->studies_studies_law_id;
				$course->studies_law_shortname = $row->studies_law_shortname;
				$course->studies_law_name = $row->studies_law_name;
				

				//get number of teacher Deparments
				/*
				if ( array_key_exists ( $row->course_id , $teachers_by_course )) {					
					$course->numberOfTeachers = $teachers_by_course[$row->course_id]->total;
					$course->teacher_ids = $teachers_by_course[$row->course_id]->teachers_ids;

				}	else {
					$course->numberOfTeachers = "";
					$course->teacher_ids = "";
				}

				//get number of teacher Studies
				if ( array_key_exists ( $row->course_id , $studies_by_course )) {					
					$course->numberOfStudies = $studies_by_course[$row->course_id]->total;
					$course->studies_ids = $studies_by_course[$row->course_id]->studies_ids;
				}	else {
					$course->numberOfStudies = "";
					$course->studies_ids = "";
				}*/
				
				$all_courses[$row->course_id] = $course;
			}
			return $all_courses;
		}	
		else
			return false;

	}


	function get_all_departments_report_info($academic_period = null, $orderby = "DESC") {

		if ($academic_period ==  null) {
			$academic_period = $this->get_current_academic_period_id();
		}

			
		$teachers_by_department = $this->get_teachers_by_department();
		$studies_by_department = $this->get_studies_by_department();


		//deparments
		$this->db->select('department_id,department_shortname,department_name,department_head,department_parent_department_id,
						   department_organizational_unit_id,department_location_id,
						   teacher_academic_periods_code,person_id,person_sn1,person_sn2,person_givenName,organizational_unit_id,organizational_unit_name,location_name');
		$this->db->from('department');
		$this->db->join('teacher','teacher.teacher_id = department.department_head', 'left');
		$this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');

		$this->db->join('person','teacher.teacher_person_id = person.person_id', 'left');
		$this->db->join('organizational_unit','department.department_organizational_unit_id = organizational_unit.organizational_unit_id', 'left');
		$this->db->join('location','department.department_location_id = location.location_id', 'left');
		$this->db->order_by('department_name', $orderby);
		$this->db->where('teacher_academic_periods_academic_period_id', $academic_period);
		
		$query = $this->db->get();
		//echo $this->db->last_query();


		if ($query->num_rows() > 0){
			$all_departments = array();
			foreach($query->result() as $row){
				$department = new stdClass;
				
				$department->id = $row->department_id;
				$department->shortname = $row->department_shortname;
				$department->name = $row->department_name;
				$teacher_fullname = $row->person_sn1 . " " . $row->person_sn1 . ", " . $row->person_givenName;
				$department->head_personid = $row->person_id;
				$department->head = "( " . $row->teacher_academic_periods_code . " ) " . $teacher_fullname;
				$department->head_fullname = $teacher_fullname;
				$department->head_code = $row->teacher_academic_periods_code;
				$department->head_id = $row->department_head;
				$department->parentDepartment = $row->department_parent_department_id;
				$department->organizational_unit = $row->organizational_unit_name;
				$department->organizational_unit_id = $row->organizational_unit_id;
				$department->location = $row->location_name;
				$department->location_id = $row->department_location_id;				

				//get number of teacher Deparments
				if ( array_key_exists ( $row->department_id , $teachers_by_department )) {					
					$department->numberOfTeachers = $teachers_by_department[$row->department_id]->total;
					$department->teacher_ids = $teachers_by_department[$row->department_id]->teachers_ids;

				}	else {
					$department->numberOfTeachers = "";
					$department->teacher_ids = "";
				}

				//get number of teacher Studies
				if ( array_key_exists ( $row->department_id , $studies_by_department )) {					
					$department->numberOfStudies = $studies_by_department[$row->department_id]->total;
					$department->studies_ids = $studies_by_department[$row->department_id]->studies_ids;
				}	else {
					$department->numberOfStudies = "";
					$department->studies_ids = "";
				}
				
				$all_departments[$row->department_id] = $department;
			}
			return $all_departments;
		}	
		else
			return false;
		

		/*$all_departments = array();

		$department1 = new stdClass;

		$department1->shortname = "Elèctrics";
		$department1->name = "Departament d'electrics";
		$department1->head = "Richard Stallman";
		$department1->location = "Aula 45";
		$department1->numberOfTeachers = 7;
		$department1->numberOfStudies = 2;

		$department2 = new stdClass;

		$department2->shortname = "Informàtica";
		$department2->name = "Departament d'informàtica";
		$department2->head = "Linus Torvalds";
		$department2->location = "Espai";
		$department2->numberOfTeachers = 6;
		$department2->numberOfStudies = 3;

		$all_departments[] = $department1;
		$all_departments[] = $department2;

		return $all_departments;*/
	}


	function get_all_classroom_groups($orderby='asc') {
		//classroom_group
		$this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name,classroom_group_description,classroom_group_educationalLevelId,classroom_group_mentorId');
		$this->db->from('classroom_group');
		$this->db->order_by('classroom_group_code', $orderby);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0){
			$groups_array = array();
			foreach($query->result() as $row){
				$groups_array[$row->classroom_group_code] = $row->classroom_group_name;
			}
			return $groups_array;
		}	
		else
			return false;
	}

	function getGroupNamesByGroupCode($group_code) {
		//classroom_group
		$this->db->select('classroom_group_name,classroom_group_shortName');
		$this->db->from('classroom_group');
		$this->db->where('classroom_group_code', $group_code);
		$this->db->count_all_results();
		
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			return array($row->classroom_group_shortName,$row->classroom_group_name);
		}
		else
			return false;
	}
	
	function getGroupTotals($group_code) {
		//classroom_group
		$this->db->select('classroom_group_name,classroom_group_shortName');
		$this->db->from('classroom_group');
		$this->db->where('classroom_group_code', $group_code);
		
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			return array($row->classroom_group_shortName,$row->classroom_group_name);
		}
		else
			return false;
	}

function getAllGroupStudentsInfo($group){

/* 
SELECT distinct(classroom_group_code), person_givenName, person_sn1, person_sn2 
FROM enrollment_modules 
JOIN person ON person.person_id = enrollment_modules.enrollment_modules_personid 
JOIN classroom_group ON enrollment_modules.enrollment_modules_group_id = classroom_group.classroom_group_id 
WHERE classroom_group.classroom_group_id = 3 
ORDER BY person.person_sn1
*/

		$this->db->select('classroom_group_id,person_givenName,person_sn1,person_sn2,person_official_id,person_photo');
		$this->db->from('enrollment_modules');
		$this->db->join('person','person.person_id = enrollment_modules.enrollment_modules_personid');
		$this->db->join('classroom_group','enrollment_modules.enrollment_modules_group_id = classroom_group.classroom_group_id');
		$this->db->where('classroom_group.classroom_group_code',$group);
		$this->db->order_by('person_sn1');
		$this->db->distinct();
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$student_info_array = array();

			foreach ($query->result_array() as $row)	{

				//$student_info_array[] = $row;
   				$student = new stdClass();
				$student->givenName = $row['person_givenName'];
				$student->sn1 = $row['person_sn1'];
				$student->sn2 = $row['person_sn2'];
				$student->irisPersonalUniqueID = $row['person_official_id'];
				$student->jpegPhoto = $row['person_photo'];
				$student_info_array[] = $student;

			}

			return $student_info_array;
		}			
		else
			return false;

}

    function get_all_teachers() {

		$this->db->select('teacher_id, person_givenName, person_sn1, person_sn2, person_photo');
		$this->db->from('teacher');
		$this->db->join('person','teacher_person_id = person_id');
		$query = $this->db->get();

		//echo $this->db->last_query();
		
		if ($query->num_rows() > 0) {
		
		//$teacher = new stdClass();

		foreach ($query->result_array() as $row)	{

				$teacher = new stdClass();
				
				$teacher->teacher_id = $row['teacher_id'];
				$teacher->givenName = $row['person_givenName'];
				$teacher->sn1 = $row['person_sn1'];
				$teacher->sn2 = $row['person_sn2'];
				$teacher->photo_url = $row['person_photo'];
				
				$all_teachers[] = $teacher;

			}
			return $all_teachers;
			//print_r($all_teachers);
		}			
		return false;
	}


	function get_all_groups($orderby="asc") {
		$this->db->from('classroom_group');
        $this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name');

		$this->db->order_by('classroom_group_code', $orderby);
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$groups_array = array();

			foreach ($query->result_array() as $row)	{
   				$groups_array[$row['classroom_group_id']] = $row['classroom_group_code'] . " - " . $row['classroom_group_name'] . "( " . $row['classroom_group_shortName'] . " )";
			}
			return $groups_array;
		}			
		else
			return false;
	}	

	function startsWith($haystack, $needle) {
	    // search backwards starting from haystack length characters from the end
	    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}

	function get_enrollments_by_person_id(){
		/*
		SELECT enrollment_id,enrollment_personid FROM enrollment WHERE 1 ORDER BY enrollment_personid
		*/
		
		$this->db->select('enrollment_id,enrollment_periodid,enrollment_personid');
        $this->db->from('enrollment');
		$this->db->order_by('enrollment_personid');
		       
        $query = $this->db->get();
		
		$last_enrollment = null;
		$enrollments_by_person_id = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row)	{
				$enrollment = new stdClass();

				$enrollment->id = $row->enrollment_id;
				$enrollment->periodid = $row->enrollment_periodid;
				$enrollment->person_id = $row->enrollment_personid;

				if ($last_enrollment != null) {
					if ($enrollment->person_id == $last_enrollment->person_id) {
						array_push( $enrollments_by_person_id[$last_enrollment->person_id] , $enrollment);
					} else {
						$enrollments = array();
						array_push( $enrollments , $enrollment);
						$enrollments_by_person_id[$enrollment->person_id] = $enrollments;
					}
				} else {
					$enrollments = array();
					array_push( $enrollments , $enrollment);
					$enrollments_by_person_id[$enrollment->person_id] = $enrollments;
				}

				$last_enrollment = $enrollment;
			}
		}
		
		return $enrollments_by_person_id;
	}

	function get_teachers_by_person_id(){
		
		/*
		SELECT teacher_id,teacher_user_id,teacher_person_id FROM teacher WHERE 1 ORDER BY teacher_person_id
		*/
		
		$this->db->select('teacher_id,teacher_user_id,teacher_person_id');
        $this->db->from('teacher');
		$this->db->order_by('teacher_person_id');
		       
        $query = $this->db->get();
		
		$last_teacher = null;
		$teachers_by_person_id = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row)	{
				$teacher = new stdClass();

				$teacher->id = $row->teacher_id;
				$teacher->user_id = $row->teacher_user_id;
				$teacher->person_id = $row->teacher_person_id;

				if ($last_teacher != null) {
					if ($teacher->person_id == $last_teacher->person_id) {
						array_push( $teachers_by_person_id[$last_teacher->person_id] , $teacher);
					} else {
						$teachers = array();
						array_push( $teachers , $teacher);
						$teachers_by_person_id[$teacher->person_id] = $teachers;
					}
				} else {
					$teachers = array();
					array_push( $teachers , $teacher);
					$teachers_by_person_id[$teacher->person_id] = $teachers;
				}

				$last_teacher = $teacher;
			}
		}
		
		return $teachers_by_person_id;
	}
	function get_employees_by_person_id(){
		/*
		SELECT employees_id,employees_person_id,employees_code FROM employees WHERE 1 ORDER BY employees_person_id
		*/
		
		$this->db->select('employees_id,employees_person_id,employees_code');
        $this->db->from('employees');
		$this->db->order_by('employees_person_id');
		       
        $query = $this->db->get();
		
		$last_employee = null;
		$employees_by_person_id = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row)	{
				$employee = new stdClass();

				$employee->id = $row->employees_id;
				$employee->code = $row->employees_code;
				$employee->person_id = $row->employees_person_id;

				if ($last_employee != null) {
					if ($employee->person_id == $last_employee->person_id) {
						array_push( $employees_by_person_id[$last_employee->person_id] , $employee);
					} else {
						$employees = array();
						array_push( $employees , $employee);
						$employees_by_person_id[$employee->person_id] = $employees;
					}
				} else {
					$employees = array();
					array_push( $employees , $employee);
					$employees_by_person_id[$employee->person_id] = $employees;
				}

				$last_employee = $employee;
			}
		}
		
		return $employees_by_person_id;
	}
	function get_hidden_student_by_person_id(){
		/*
		SELECT hidden_student_id,hidden_student_person_id FROM hidden_student WHERE 1 ORDER BY hidden_student_person_id
		*/
		
		$this->db->select('hidden_student_id,hidden_student_person_id');
        $this->db->from('hidden_student');
		$this->db->order_by('hidden_student_person_id');
		       
        $query = $this->db->get();
		
		$last_hidden_student = null;
		$hidden_students_by_person_id = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row)	{
				$hidden_student = new stdClass();

				$hidden_student->id = $row->hidden_student_id;
				$hidden_student->person_id = $row->hidden_student_person_id;

				if ($last_hidden_student != null) {
					if ($hidden_student->person_id == $last_hidden_student->person_id) {
						array_push( $hidden_students_by_person_id[$last_hidden_student->person_id] , $hidden_student);
					} else {
						$hidden_students = array();
						array_push( $hidden_students , $hidden_student);
						$hidden_students_by_person_id[$hidden_student->person_id] = $hidden_students;
					}
				} else {
					$hidden_students = array();
					array_push( $hidden_students , $hidden_student);
					$hidden_students_by_person_id[$hidden_student->person_id] = $hidden_students;
				}

				$last_hidden_student = $hidden_student;
			}
		}
		
		return $hidden_students_by_person_id;
	}

	function get_posible_duplicated_users() {


		$enrollments_by_person_id = array();
		$enrollments_by_person_id = $this->get_enrollments_by_person_id();

		$teachers_by_person_id = array();
		$teachers_by_person_id = $this->get_teachers_by_person_id();

		$employees_by_person_id = array();
		$employees_by_person_id = $this->get_employees_by_person_id();

		$hidden_students_by_person_id = array();
		$hidden_students_by_person_id = $this->get_hidden_student_by_person_id();

		/*
		SELECT username,person_sn1,person_sn2,person_givenName,person_official_id,person_email,
		       person_secondary_email,person_terciary_email,person_photo,person_telephoneNumber,person_mobile
		FROM users 
		INNER JOIN person ON users.person_id= person.person_id
		WHERE 1 
		ORDER BY username
		*/

        $this->db->select('id,username,person.person_id,person_sn1,person_sn2,person_givenName,person_official_id,person_email,
		       person_secondary_email,person_terciary_email,person_photo,person_telephoneNumber,person_mobile,
		       created_on,last_modification_date,last_modification_user,creation_user,last_login,active,mark_as_not_duplicated');
        $this->db->from('users');
        $this->db->join('person','users.person_id= person.person_id');
		$this->db->order_by('username');
		$this->db->where('mark_as_not_duplicated',0);
		
		       
        $query = $this->db->get();
		
		$last_user = null;
		$posible_duplicated_users = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row)	{
				$user = new stdClass();
				$user->id = $row->id;
				$user->person_id = $row->person_id;			
				$user->username = $row->username;
				$user->person_sn1 = $row->person_sn1;
				$user->person_sn2 = $row->person_sn2;
				$user->person_givenName = $row->person_givenName;
				$user->person_official_id = $row->person_official_id;
				$user->person_email = $row->person_email;
				$user->person_secondary_email = $row->person_secondary_email;
				$user->person_terciary_email = $row->person_terciary_email;
				$user->person_photo = $row->person_photo;
				$user->person_telephoneNumber = $row->person_telephoneNumber;
				$user->person_mobile = $row->person_mobile;

				$user->created_on = $row->created_on;
				$user->last_modification_date = $row->last_modification_date;
				$user->last_modification_user = $row->last_modification_user;
				$user->creation_user = $row->creation_user;
				$user->last_login = $row->last_login;
				$user->active = $row->active;
				$user->mark_as_not_duplicated = $row->mark_as_not_duplicated;
				

				$user->enrollments = "";

				if (is_array($enrollments_by_person_id)){
					if (array_key_exists($user->person_id, $enrollments_by_person_id)) {
						foreach ($enrollments_by_person_id[$user->person_id] as $enrollment) {
							$user->enrollments = $user->enrollments . $enrollment->id . " ( " . $enrollment->periodid . ")" . ", ";
						}		
					}
				}

				$user->teachers = "";

				if (is_array($teachers_by_person_id)){
					if (array_key_exists($user->person_id, $teachers_by_person_id)) {
						foreach ($teachers_by_person_id[$user->person_id] as $teacher) {
							$user->teachers = $user->teachers . $teacher->id . " ( " . $teacher->user_id . ")" . ", ";
						}		
					}
				}

				$user->employees = "";

				if (is_array($employees_by_person_id)){
					if (array_key_exists($user->person_id, $employees_by_person_id)) {
						foreach ($employees_by_person_id[$user->person_id] as $employee) {
							$user->employees = $user->employees . $employee->id . " ( " . $employee->code . ")" . ", ";
						}		
					}
				}

				$user->hidden_students = "";

				if (is_array($hidden_students_by_person_id)){
					if (array_key_exists($user->person_id, $hidden_students_by_person_id)) {
						foreach ($hidden_students_by_person_id[$user->person_id] as $hidden_student) {
							$user->hidden_students = $user->hidden_students . $hidden_student->id . ", ";
						}		
					}
				}
				

				if ($last_user != null) {
   					//check if last user is very similar (posible duplicate)
   					if($this->startsWith($user->username,$last_user->username)) {
   						$posible_duplicated_user = new stdClass();   						
   						$posible_duplicated_users[$row->id] = $user;
   						$posible_duplicated_users[$last_user->id] = $last_user;
   					}
   				}

   				$last_user = $user;
			}
			return $posible_duplicated_users;
		}			
		else
			return $posible_duplicated_users;
	}

/*
	function get_all_teachers_ids_and_names() {

		$this->db->from('teacher');
        $this->db->select('teacher_1code,person_sn1,person_sn2,person_givenName,person_id,person_official_id');

		//$this->db->order_by('lesson_code', $orderby);
		
		$this->db->join('person', 'person.person_id = teacher.teacher_person_id');
        
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$teachers_array = array();

			foreach ($query->result_array() as $row)	{
   				$teachers_array[$row['teacher1_code']] = $row['teacher1_code'] . " - " . $row['person_sn1'] . " " . $row['person_sn2'] . ", " . $row['person_givenName'] . " - " . $row['person_official_id'];
			}
			return $teachers_array;
		}			
		else
			return false;
	}

	/*
	function getAllLessonsWithGroupCodeShortNames($orderby="asc") {
		$all_lessons=$this->getAllLessons();
		
		foreach ($all_lessons as $lesson_key => $lesson) {
			$lesson->classroom_group_shortname="PROVA";
		}
		
		return $all_lessons;
	}*/
/*
	function getAllTimeSlots($orderby="asc") {
		
		$this->db->select('time_slot_id,time_slot_start_time,time_slot_end_time,time_slot_lective');
		$this->db->from('time_slot');
		$this->db->order_by('time_slot_order', $orderby);

		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}
	
	function getAllLessons($exists_assignatures_table=false,$orderby="asc") {
		//classroom_group
        if (!$exists_assignatures_table) {
            $this->db->select('lesson_id,lesson_code,classroom_group.groupShortName,classroom_group_code,teacher1_code,lesson_shortname,classrom_code,day_code,hour_code');
        }
        else {
            $this->db->select('lesson_id,lesson_code,classroom_group.groupShortName,classroom_group_code,teacher1_code,lesson_shortname,assignatura.nom_assignatura,classrom_code,day_code,hour_code');
        }
                                                
		$this->db->from('lesson');
		$this->db->order_by('lesson_code', $orderby);
		$this->db->join('classroom_group', 'classroom_group.groupCode = lesson.classroom_group_code', 'left');
                if ($exists_assignatures_table) {
                        $this->db->join('assignatura', 'lesson.lesson_shortname = assignatura.codi_assignatura', 'left');                                        
                }
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
			return $query;
		else
			return false;

	}

	function get_all_classroom_groups($orderby='asc') {
		//classroom_group
		$this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name,classroom_group_description,classroom_group_educationalLevelId,classroom_group_mentorId');
		$this->db->from('classroom_group');
		$this->db->order_by('classroom_group_code', $orderby);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}
	
	function getGroupNameByGroupCode($group_code) {
		//classroom_group
		$this->db->select('classroom_group_name');
		$this->db->from('classroom_group');
		$this->db->where('classroom_group_code', $group_code);
		
		$query = $this->db->get();

		if ($query->num_rows() == 1)	{
			$row = $query->row(); 
			return $row->groupName;
		}
		else
			return false;
	}
	
	function getGroupShortNameByGroupCode($group_code) {
		//classroom_group
		$this->db->select('classroom_group_shortName');
		$this->db->from('classroom_group');
		$this->db->where('classroom_group_code', $group_code);
		
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			return $row->groupShortame;
		}
		else
			return false;
	}
	
	function getGroupNamesByGroupCode($group_code) {
		//classroom_group
		$this->db->select('classroom_group_name,classroom_group_shortName');
		$this->db->from('classroom_group');
		$this->db->where('classroom_group_code', $group_code);
		
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			return array($row->classroom_group_shortName,$row->classroom_group_name);
		}
		else
			return false;
	}
  
	function get_group_by_teachercode_and_day($teacher1_code,$day_code)	{
	/* 
        SELECT assignatura.nom_assignatura, grup.nom_grup, grup.codi_grup,
                   classe.codi_dia, classe.codi_hora, classe.codi_assignatura,
                   interval_horari.hora_inici, interval_horari.hora_final, optativa
        FROM assignatura
                 NATURAL JOIN classe NATURAL JOIN grup 
                 NATURAL JOIN interval_horari
        WHERE classe.codi_professor = '{$VALS['teacher1_code']}'
                  AND  classe.codi_dia = '{$VALS['day_of_week']}'
                  ORDER BY classe.codi_hora, grup.nom_grup
	 */
/*
		$this->db->select('assignatura.nom_assignatura, classroom_group.nom_grup, classroom_group.codi_grup,
                   classe.codi_dia, classe.codi_hora, classe.codi_assignatura,
                   interval_horari.hora_inici, interval_horari.hora_final, optativa');
		$this->db->from('assignatura');
		$this->db->join('classe', 'barcode.barcodeId = externalIDType.barcodeId','inner');
		$this->db->join('classroom_group', 'barcode.barcodeId = externalIDType.barcodeId','inner');
		$this->db->join('interval_horari', 'barcode.barcodeId = externalIDType.barcodeId','inner');
		$this->db->where('classe.codi_professor',$teacher1_code);
		$this->db->where('classe.codi_dia',$day_code);
		$this->db->order_by('classe.codi_hora', 'asc');
		$this->db->order_by('classroom_group.nom_grup', 'asc'); 
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}
*/	
}
