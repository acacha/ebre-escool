<?php
/**
 * Reports_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergiturbadenas@gmail.com>
 * @version    	1.0
 * @link		https://www.acacha.com/index.php/ebre-escool
 */
class teachers_model  extends CI_Model  {

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

    function get_all_teachers($academic_period_id=null) {

    	if ($academic_period_id == null ) {
    		$academic_period_id = $this->get_current_academic_period_id();
    	}

		$this->db->select('teacher_id,teacher_academic_periods_code,teacher_academic_periods_charge_short, teacher_academic_periods_charge_full, person_givenName, person_sn1, person_sn2, person_photo,teacher_academic_periods_charge_sheet_line1,
						teacher_academic_periods_charge_sheet_line2,teacher_academic_periods_charge_sheet_line3,teacher_academic_periods_charge_sheet_line4');
		$this->db->from('teacher');
		$this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');
		$this->db->join('person','teacher_person_id = person_id');
		$this->db->where('teacher_academic_periods_academic_period_id',$academic_period_id);
		$this->db->order_by("teacher_academic_periods_code", "asc");

		$query = $this->db->get();

		//echo $this->db->last_query()."<br/>";

		if ($query->num_rows() > 0) {

		//$teacher = new stdClass();

		foreach ($query->result_array() as $row)	{

				$teacher = new stdClass();

				$teacher->teacher_id = $row['teacher_id'];
				$teacher->teacher_code = $row['teacher_academic_periods_code'];
				$teacher->teacher_charge_short = $row['teacher_academic_periods_charge_short'];
				$teacher->teacher_charge_full = $row['teacher_academic_periods_charge_full'];
				$teacher->teacher_charge_sheet_line1 = $row['teacher_academic_periods_charge_sheet_line1'];
				$teacher->teacher_charge_sheet_line2 = $row['teacher_academic_periods_charge_sheet_line2'];
				$teacher->teacher_charge_sheet_line3 = $row['teacher_academic_periods_charge_sheet_line3'];
				$teacher->teacher_charge_sheet_line4 = $row['teacher_academic_periods_charge_sheet_line4'];

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

	function get_academic_period_by_id($academic_period_id) {

		/*
		SELECT academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current FROM academic_periods WHERE academic_periods_current=1
		*/
		$this->db->select('academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current');
		$this->db->from('academic_periods');
		$this->db->where('academic_periods_id',$academic_period_id);
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() == 1){
			$row = $query->row();

			$academic_period = new stdClass;

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


	/*
    * OBSOLET
	*/

	/*
	function get_all_classgroups_report_info_obsolet($orderby = "DESC") {



		//classgroups
		//Example SQL:
		/*
		SELECT classroom_group_id, classroom_group_code, classroom_group_shortName, classroom_group_name, classroom_group_course_id, classroom_group_description, classroom_group_mentorId, classroom_group_shift,
			   classroom_group_location_id, course_shortname, course_name, course_study_id, studies_shortname, studies_name, studies_studies_organizational_unit_id, studies_studies_law_id, studies_law_shortname,
			   studies_law_name, teacher_person_id, teacher1_code,teacher_department_id, person_givenName, person_sn1, person_sn2,shift_name,location_name, location_shortName
		FROM classroom_group
		LEFT JOIN  course ON  course.course_id = classroom_group.classroom_group_course_id
		LEFT JOIN  studies ON   studies.studies_id = course.course_study_id
		LEFT JOIN  studies_law ON   studies_law.studies_law_id = studies.studies_studies_law_id
		LEFT JOIN  teacher ON teacher.teacher_id = classroom_group. classroom_group_mentorId
		LEFT JOIN  person ON person.person_id = teacher. teacher_person_id
		LEFT JOIN  shift ON shift.shift_id = classroom_group. classroom_group_shift
		LEFT JOIN  location ON location.location_id = classroom_group. classroom_group_location_id
		WHERE 1


		$this->db->select('classroom_group_id, classroom_group_code, classroom_group_shortName, classroom_group_name, classroom_group_course_id, classroom_group_description, classroom_group_mentorId, classroom_group_shift,
			   classroom_group_location_id, course_shortname, course_name, course_study_id, studies_shortname, studies_name, studies_studies_organizational_unit_id, studies_studies_law_id, studies_law_shortname,
			   studies_law_name, teacher_person_id, teacher_1code,teacher_department_id, person_givenName, person_sn1, person_sn2,shift_name,location_name, location_shortName');
		$this->db->from('classroom_group');
		$this->db->join('course','course.course_id = classroom_group.classroom_group_course_id', 'left');
		$this->db->join('studies','studies.studies_id = course.course_study_id', 'left');
		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id', 'left');
		$this->db->join('teacher','teacher.teacher_id = classroom_group.classroom_group_mentorId', 'left');
		$this->db->join('person','person.person_id = teacher.teacher_person_id', 'left');
		$this->db->join('shift','shift.shift_id = classroom_group.classroom_group_shift', 'left');
		$this->db->join('location','location.location_id = classroom_group.classroom_group_location_id', 'left');

		$this->db->order_by('studies_shortname', $orderby);

		$query = $this->db->get();

		if ($query->num_rows() > 0){
			$all_classroom_groups = array();
			foreach($query->result() as $row){
				$classroom_group = new stdClass;

				$classroom_group->id = $row->classroom_group_id;
				$classroom_group->code = $row->classroom_group_code;
				$classroom_group->shortname = $row->classroom_group_shortName;
				$classroom_group->name = $row->classroom_group_name;
				$classroom_group->description = $row->classroom_group_description;

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

				$classroom_group->mentor_id = $row->classroom_group_mentorId;
				$classroom_group->mentor_person_id = $row->teacher_person_id;
				$classroom_group->mentor_code = $row->teacher1_code;
				$classroom_group->mentor_department_id = $row->teacher_department_id;
				$classroom_group->mentor_givenname = $row->person_givenName;
				$classroom_group->mentor_sn1 = $row->person_sn1;
				$classroom_group->mentor_sn2 = $row->person_sn2;

				$classroom_group->shift_id = $row->classroom_group_shift;
				$classroom_group->shift_name = $row->shift_name;

				$classroom_group->location_id = $row->classroom_group_location_id;
				$classroom_group->location_name = $row->location_name;
				$classroom_group->location_shortname = $row->location_shortName;


				$all_classroom_groups[$row->classroom_group_id] = $classroom_group;
			}
			return $all_classroom_groups;
		}
		else
			return false;

	}
	*/

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

	function get_all_classgroups_report_info($academic_period_id,$orderby = "DESC") {

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
		 LEFT JOIN `course` ON `course`.`course_id` = `classroom_group`.`classroom_group_course_id` LEFT JOIN `studies` ON `studies`.`studies_id` = `course`.`course_study_id`
		 LEFT JOIN `studies_law` ON `studies_law`.`studies_law_id` = `studies`.`studies_studies_law_id`
		 LEFT JOIN `teacher` ON `teacher`.`teacher_id` = `classroom_group_academic_periods`.`classroom_group_academic_periods_mentorId`
		 JOIN `teacher_academic_periods` ON `teacher_academic_periods`.`teacher_academic_periods_teacher_id` = `teacher`.`teacher_id`
		 LEFT JOIN `person` ON `person`.`person_id` = `teacher`.`teacher_person_id`
		 LEFT JOIN `shift` ON `shift`.`shift_id` = `classroom_group_academic_periods`.`classroom_group_academic_periods_shift`
		 LEFT JOIN `location` ON `location`.`location_id` = `classroom_group_academic_periods`.`classroom_group_academic_periods_location`
		 WHERE `classroom_group_academic_periods_academic_period_id` = '5' AND `teacher_academic_periods_academic_period_id` = '5'
		  ORDER BY `studies_name` DESC
		*/

		$this->db->select('classroom_group_id, classroom_group_code, classroom_group_shortName, classroom_group_name, classroom_group_course_id, classroom_group_academic_periods_description, classroom_group_academic_periods_mentorId, classroom_group_academic_periods_shift,
		classroom_group_academic_periods_location, course_shortname, course_name, course_study_id, studies_shortname, studies_name, studies_studies_organizational_unit_id, studies_studies_law_id, studies_law_shortname,
		studies_law_name, teacher_person_id, teacher_academic_periods_code,teacher_academic_periods_department_id, person_givenName, person_sn1, person_sn2,shift_name,location_name, location_shortName, teacher_id');
		$this->db->from('classroom_group_academic_periods');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id', 'left');
		$this->db->join('course','course.course_id = classroom_group.classroom_group_course_id', 'left');
		$this->db->join('studies','studies.studies_id = course.course_study_id', 'left');
		$this->db->join('studies_law','studies_law.studies_law_id = studies.studies_studies_law_id', 'left');
		$this->db->join('teacher','teacher.teacher_id = classroom_group_academic_periods.classroom_group_academic_periods_mentorId', 'left');
		$this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id','left');
		$this->db->join('person','person.person_id = teacher.teacher_person_id', 'left');
		$this->db->join('shift','shift.shift_id = classroom_group_academic_periods.classroom_group_academic_periods_shift', 'left');
		$this->db->join('location','location.location_id = classroom_group_academic_periods.classroom_group_academic_periods_location', 'left');
		$this->db->where('classroom_group_academic_periods_academic_period_id',$academic_period_id);
		//$this->db->where('teacher_academic_periods_academic_period_id',$academic_period_id);

		$this->db->order_by('studies_name', $orderby);

		$query = $this->db->get();
//		echo $this->db->last_query()."<br/>";


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
				$classroom_group->teacher_id = $row->teacher_id;

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


	function get_all_teachers_report_info($academic_period_id,$orderby = "ASC") {

		/* SQL EXAMPLE
		SELECT `teacher_id`, `teacher_user_id`, `users`.`ldap_dn` as ldap_dn, `teacher_academic_periods_academic_period_id`, `teacher_person_id`, `teacher_academic_periods_code`,
		`person_photo`, `username`, `password`, `initial_password`, `force_change_password_next_login`, `person_givenName`, `person_sn1`, `person_sn2`, `person_email`,
		`person_secondary_email`, `person_official_id`, `teacher_academic_periods_department_id`, `teacher_academic_periods_charge_full`, `teacher_academic_periods_charge_short`,
		`teacher_academic_periods_charge2_full`, `teacher_academic_periods_charge2_short`, `teacher_academic_periods_charge_sheet_line1`, `teacher_academic_periods_charge_sheet_line2`,
		 `teacher_academic_periods_charge_sheet_line3`, `teacher_academic_periods_charge_sheet_line4`
		 FROM (`teacher`)
		 JOIN `teacher_academic_periods` ON `teacher_academic_periods`.`teacher_academic_periods_teacher_id` = `teacher`.`teacher_id`
		 LEFT JOIN `person` ON `person`.`person_id` = `teacher`.`teacher_person_id`
		 LEFT JOIN `users` ON `users`.`id` = `teacher`.`teacher_user_id`
		 WHERE `teacher_academic_periods_academic_period_id` = '5'
		 ORDER BY `teacher_academic_periods_code` ASC
		*/

		$this->db->select('teacher_id, teacher_user_id,users.ldap_dn as ldap_dn,teacher_academic_periods_academic_period_id, teacher_person_id, teacher_academic_periods_code,person_photo, username,
			password,initial_password,force_change_password_next_login,person_givenName,person_sn1,person_sn2,person_email,person_secondary_email,person_official_id,
			teacher_academic_periods_department_id, department_name, department_shortname, teacher_academic_periods_charge_full, teacher_academic_periods_charge_short, teacher_academic_periods_charge2_full,
			teacher_academic_periods_charge2_short, teacher_academic_periods_charge_sheet_line1, teacher_academic_periods_charge_sheet_line2,
			teacher_academic_periods_charge_sheet_line3, teacher_academic_periods_charge_sheet_line4');
		$this->db->from('teacher');
		$this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id','left');
		$this->db->join('person','person.person_id = teacher.teacher_person_id', 'left');
		$this->db->join('users','users.id = teacher.teacher_user_id', 'left');
		$this->db->join('department','department.department_id = teacher_academic_periods.teacher_academic_periods_department_id', 'left');


		$this->db->where('teacher_academic_periods_academic_period_id',$academic_period_id);

		$this->db->order_by('teacher_academic_periods_code', $orderby);

		$query = $this->db->get();

		//echo $this->db->last_query()."<br/>";

		if ($query->num_rows() > 0){
			$all_teachers = array();
			foreach($query->result() as $row){
				$teacher = new stdClass;

				$teacher->id = $row->teacher_id;
				$teacher->person_id = $row->teacher_person_id;
				$teacher->code = $row->teacher_academic_periods_code;
				$teacher->photo = $row->person_photo;
				$teacher->user_id = $row->teacher_user_id;
				$teacher->username = $row->username;
				$teacher->password = $row->password;
				$teacher->initial_password = $row->initial_password;
				$teacher->force_change_password_next_login = $row->force_change_password_next_login;
				$teacher->ldap_dn = $row->ldap_dn;

				$CI =& get_instance();
        		$CI->load->config('auth_ldap');

        		$active_users_basedn = $CI->config->item('active_users_basedn');

				//echo "active_users_basedn: " . $active_users_basedn . "<br/>";

				$teacher->real_ldap_dn = $this->user_exists($row->username,$active_users_basedn);

				//echo "real_ldap_dn ( ". $row->username  ."): " . $teacher->real_ldap_dn . "<br/>";

				$teacher->givenName = $row->person_givenName;
				$teacher->person_sn1 = $row->person_sn1;
				$teacher->person_sn2 = $row->person_sn2;
				$teacher->email = $row->person_email;
				$teacher->secondary_email = $row->person_secondary_email;
				$teacher->official_id = $row->person_official_id;

				$teacher->department_id = $row->teacher_academic_periods_department_id;
				$teacher->department_name = $row->department_name;
				$teacher->department_shortname = $row->department_shortname;

				$teacher->charge_full = $row->teacher_academic_periods_charge_full;
				$teacher->charge_short = $row->teacher_academic_periods_charge_short;
				$teacher->charge2_full = $row->teacher_academic_periods_charge2_full;
				$teacher->charge2_short = $row->teacher_academic_periods_charge2_short;
				$teacher->charge_sheet_line1 = $row->teacher_academic_periods_charge_sheet_line1;
				$teacher->charge_sheet_line2 = $row->teacher_academic_periods_charge_sheet_line2;
				$teacher->charge_sheet_line3 = $row->teacher_academic_periods_charge_sheet_line3;
				$teacher->charge_sheet_line4 = $row->teacher_academic_periods_charge_sheet_line4;

				$all_teachers[$row->teacher_id] = $teacher;
			}
			return $all_teachers;
		}
		else
			return false;

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

}
