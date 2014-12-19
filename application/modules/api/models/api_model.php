<?php
/**
 * Reports_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergiturbadenas@gmail.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class reports_model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->load->library('ebre_escool');
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

	function is_user_a_teacher ($person_id) {

		$this->db->select('teacher_id');
		$this->db->from('teacher');
		$this->db->where('teacher.teacher_person_id',$person_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return true;
		}			
		return false;
	}

	function get_classroom_group_hidden_students($classroom_group_id,$teacher_id=null,$academic_period_id=null) {

		$person_id = $this->session->userdata('person_id');
		$user_is_a_teacher = $this->is_user_a_teacher($person_id);	
		$user_is_admin = $this->ebre_escool->user_is_admin();

		if ( !($user_is_a_teacher || $user_is_admin) ) {
			//TODO: Return not allowed page!
			echo "Access Not Allowed!";
			return false;
		}	

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		}

		if ($teacher_id == null) {
			if ($user_is_a_teacher) {
				$teacher_id = $this->session->userdata('teacher_id');
			} else {
				return false;
			}
		}

		//DEBUG
		//echo "classroom_group_id: " . $classroom_group_id . " || " . "teacher_id: " . $teacher_id . " || " . " academic_period_id: " . $academic_period_id;

		/*
		SELECT `hidden_student_person_id` 
		FROM `hidden_student` 
		WHERE `hidden_student_teacher_id` = 127 AND `hidden_student_academic_period_id` = 5 AND `hidden_student_classroom_group_id` = 26
		*/

		$this->db->select('hidden_student_person_id');
		$this->db->from('hidden_student');
		$this->db->where('hidden_student_teacher_id',$teacher_id);
		$this->db->where('hidden_student_academic_period_id',$academic_period_id);
		$this->db->where('hidden_student_classroom_group_id',$classroom_group_id);

		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0){
			$hidden_students = array();
			foreach ($query->result() as $row)    {
                $hidden_students[]= $row->hidden_student_person_id;
            }
            return $hidden_students;
		}	
		else {
			return array();
		}

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

		$query = $this->db->get();	
		//echo $this->db->last_query();

		if ($query->num_rows() == 1) {

			$row = $query->row(); 
			return $row->classroom_group_course_id;
		}			
		else
			return false;


	}

	public function get_classroom_group_siblings($current_group) {

		//GET COURSE
		$course_id = $this->get_course_id_from_classroom_group_id($current_group); 
        
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

        $this->db->where('classroom_group_course_id',$course_id);
 
		$query = $this->db->get();	
		//echo $this->db->last_query();

		$groups_array = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row)	{
				if ($current_group != $row['classroom_group_id']) {
					$classroom_group_sibling = new stdClass();	
					$classroom_group_sibling->id = $row['classroom_group_id'];
					$classroom_group_sibling->code = $row['classroom_group_code'];
					$classroom_group_sibling->shortName = $row['classroom_group_shortName'];
					$classroom_group_sibling->name = $row['classroom_group_name'];
					$classroom_group_sibling->description = $row['classroom_group_description'];
					$classroom_group_sibling->course_id = $row['classroom_group_course_id'];

					$groups_array[$row['classroom_group_id']] = $classroom_group_sibling;	
				}
			}
			return $groups_array;
		}			
		else {
			return $groups_array;
		}
			
	}

	function getAllStudySubmodulesByClassroomGroupId($classroom_group_id,$academic_period_id=null) {

		if ($academic_period_id==null) {
			$academic_period_id = $this->get_current_academic_period_id();
		} 

		/*
		SELECT DISTINCT study_submodules_academic_periods_study_submodules_id
		FROM study_submodules_academic_periods 
		INNER JOIN study_submodules ON study_submodules.study_submodules_id = study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id
		INNER JOIN courses_academic_periods ON courses_academic_periods.courses_academic_periods_course_id  = study_submodules.study_submodules_courseid
		INNER JOIN classroom_group ON classroom_group.classroom_group_course_id = courses_academic_periods.courses_academic_periods_course_id
		INNER JOIN classroom_group_academic_periods ON classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id =  classroom_group.classroom_group_id
		WHERE study_submodules_academic_periods_academic_period_id=5 AND courses_academic_periods_academic_period_id=5 AND classroom_group_academic_periods_academic_period_id=5 
		AND classroom_group_id=1
		*/

		$this->db->select('study_submodules_academic_periods_study_submodules_id');
		$this->db->distinct();
		$this->db->from('study_submodules_academic_periods');
		$this->db->join('study_submodules','study_submodules.study_submodules_id = study_submodules_academic_periods.study_submodules_academic_periods_study_submodules_id');
		$this->db->join('courses_academic_periods','courses_academic_periods.courses_academic_periods_course_id  = study_submodules.study_submodules_courseid');		
		$this->db->join('classroom_group','classroom_group.classroom_group_course_id = courses_academic_periods.courses_academic_periods_course_id');	
		$this->db->join('classroom_group_academic_periods','classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id =  classroom_group.classroom_group_id');	
			
		$this->db->where('study_submodules_academic_periods_academic_period_id',$academic_period_id);
		$this->db->where('courses_academic_periods_academic_period_id',$academic_period_id);
		$this->db->where('classroom_group_academic_periods_academic_period_id',$academic_period_id);
		$this->db->where('classroom_group_id',$classroom_group_id);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br/>";

		if ($query->num_rows() > 0) {
			$study_submodules_array = array();

			foreach ($query->result() as $row)	{
				$study_submodules_array[] = $row->study_submodules_academic_periods_study_submodules_id;
			}

			return $study_submodules_array;
		}			
		else {
			return array();
		}


	}

	function get_class_list($classroom_group_id,$academic_period_id=null,$checkbox_show_all_group_enrolled_students=null,
						    $checkbox_show_all_students=null, $checkbox_show_hide_students=null, $teacher_id = null) {

		$academic_period_shortname = "2014-15";

		if ($academic_period_id == null) {
			//SELECT academic_periods_shortname FROM academic_periods WHERE academic_periods_current=1
			$this->db->select('academic_periods_shortname,academic_periods_id');
			$this->db->from('academic_periods');
			$this->db->where('academic_periods_current',1);

			$query = $this->db->get();
			if ($query->num_rows() == 1) {
				$row = $query->row();
				$academic_period_shortname = $row->academic_periods_shortname;
				$academic_period_id = $row->academic_periods_id;
			} else {
				return "Error: Current academic period not found (academic_periods_current=1 in academic_periods table)";
			}	
		} else {
			//SELECT academic_periods_shortname FROM academic_periods WHERE academic_periods_id=5
			$this->db->select('academic_periods_shortname');
			$this->db->from('academic_periods');
			$this->db->where('academic_periods_id',$academic_period_id);

			$query = $this->db->get();

			if ($query->num_rows() == 1) {
				$row = $query->row();
				$academic_period_shortname = $row->academic_periods_shortname;
			} else {
				return "Error: Academic period ( " . $academic_period_id . " ) not found.";
			}	
		}

		//echo "academic_period_shortname: " . $academic_period_shortname . "<br/>";
		//echo "checkbox_show_all_group_enrolled_students: " . $checkbox_show_all_group_enrolled_students . " || ";
		//echo "checkbox_show_all_students: " . $checkbox_show_all_students . " || ";
		//echo "checkbox_show_hide_students: " . $checkbox_show_hide_students . " || ";		

		$hidden_students = array();
		$hidden_students = $this->get_classroom_group_hidden_students($classroom_group_id,$teacher_id);	

		//DEBUG
		//print_r($hidden_students);
		
		//echo "academic_period_shortname: " . $academic_period_shortname . "<br/>";
		//echo "checkbox_show_all_group_enrolled_students: " . $checkbox_show_all_group_enrolled_students . " || ";
		//echo "checkbox_show_all_students: " . $checkbox_show_all_students . " || ";
		//echo "checkbox_show_hide_students: " . $checkbox_show_hide_students . " || ";		


		if ($checkbox_show_all_group_enrolled_students==null && $checkbox_show_all_students == null) {
			return(array());	
		}

		if ($checkbox_show_all_group_enrolled_students== "false" && $checkbox_show_all_students == "false") {
			return(array());	
		}
		
		if ($checkbox_show_all_students == "true") {
			/*
			SELECT DISTINCT `person`.`person_id`, `person`.`person_sn1`, `person`.`person_sn2`, `person`.`person_givenName`, `users`.`id`, `users`.`username`, `person`.`person_secondary_email`, `person`.`person_photo`, `person`.`person_official_id` 
			FROM (`person`) 
			INNER JOIN `users` ON `person`.`person_id` = `users`.`person_id` 
			JOIN `enrollment` ON `users`.`person_id` = `enrollment`.`enrollment_personid` 
			INNER JOIN enrollment_submodules ON enrollment_submodules.`enrollment_submodules_enrollment_id` = enrollment.enrollment_id
			WHERE `enrollment_submodules_submoduleid` IN (1,2,3) AND `enrollment`.`enrollment_periodid` = '2014-15' 
			ORDER BY `person`.`person_sn1`, `person`.`person_sn2`, `person`.`person_givenName`
			*/


			//GET SIBLINGS CLASSROOM GROUPS --> AVOID INCLUDING STUDENTS OF THIS GROUP
			$classroom_group_siblings = array();
			$classroom_group_siblings = $this->get_classroom_group_siblings($classroom_group_id);

			//echo "classroom_group_id: " . $classroom_group_id . "<br/>";
			//echo "academic_period_id: " . $academic_period_id  . "<br/>";

			$study_submodules_array = $this->getAllStudySubmodulesByClassroomGroupId($classroom_group_id,$academic_period_id);

			//DEBUG
			/*echo "classroom_group_siblings: ";
			print_r($classroom_group_siblings);

			echo "study_submodules_array: ";
			print_r($study_submodules_array);
			*/

			$this->db->select('person.person_id, person.person_sn1, person.person_sn2, person.person_givenName, users.id ,users.username, 
				users.initial_password, users.last_login, person.person_email,person.person_secondary_email, person.person_photo, 
				person.person_official_id,enrollment_group_id,enrollment_id');
			$this->db->distinct();
			$this->db->from('person');
			$this->db->join('users','person.person_id = users.person_id');
			$this->db->join('enrollment','users.person_id = enrollment.enrollment_personid');	
			$this->db->join('enrollment_submodules','enrollment_submodules.enrollment_submodules_enrollment_id = enrollment.enrollment_id');	
			$this->db->where_in('enrollment_submodules_submoduleid',$study_submodules_array);
			$this->db->where('enrollment.enrollment_periodid',$academic_period_shortname);
			
			$this->db->order_by('person.person_sn1');
			$this->db->order_by('person.person_sn2');
			$this->db->order_by('person.person_givenName');
			
			$query = $this->db->get();
			//echo $this->db->last_query()."<br/>";
		} else {
			/*
			SELECT DISTINCT `person`.`person_id`, `person`.`person_sn1`, `person`.`person_sn2`, `person`.`person_givenName`, `users`.`username`, `users`.`initial_password`, `users`.`last_login`, `person`.`person_email`, `person`.`person_secondary_email`, `person`.`person_photo`, `person`.`person_official_id`
			FROM (`person`)
			JOIN `users` ON `person`.`person_id` = `users`.`person_id`
			JOIN `enrollment` ON `users`.`person_id` = `enrollment`.`enrollment_personid`
			WHERE `enrollment`.`enrollment_group_id` =  '26'
			AND `enrollment`.`enrollment_periodid` =  '2014-15'
			ORDER BY `person`.`person_sn1`, `person`.`person_sn2`, `person`.`person_givenName`
			*/
			$this->db->select('person.person_id, person.person_sn1, person.person_sn2, person.person_givenName, users.id, users.username,
				users.initial_password, users.last_login, person.person_email, person.person_secondary_email, person.person_photo, 
				person.person_official_id,enrollment_group_id,enrollment_id');
			$this->db->distinct();	
			$this->db->from('person');
			$this->db->join('users','person.person_id = users.person_id');
			$this->db->join('enrollment','users.person_id = enrollment.enrollment_personid');		
			$this->db->where('enrollment.enrollment_group_id',$classroom_group_id);
			$this->db->where('enrollment.enrollment_periodid',$academic_period_shortname);
			
			$this->db->order_by('person.person_sn1');
			$this->db->order_by('person.person_sn2');
			$this->db->order_by('person.person_givenName');

			$query = $this->db->get();
			//echo $this->db->last_query()."<br/>";
		}
		

		if ($query->num_rows() > 0) {
			$student_info_array = array();
			$students_ids_to_i_array = array();
			$i = 0;
			foreach ($query->result_array() as $row)	{
				
				if ($checkbox_show_all_students == "true") {
					if ( ( array_key_exists($row['enrollment_group_id'], $classroom_group_siblings) ) ) {
						continue;
					}
				}
			
				$id = $row['person_id'];		


				$show_hidden_students = false;
				if ($checkbox_show_hide_students != null) {
					if ($checkbox_show_hide_students=="false") {
						if (is_array($hidden_students)) {
							if (in_array($id,$hidden_students)) {
								continue;
							}	
						}		
					} else {
						$show_hidden_students = true;
					} 
				}
				
				//$student_info_array[] = $row;
				if (array_key_exists($id, $students_ids_to_i_array)) {
					$old_i = $students_ids_to_i_array[$id];
					$student_info_array[$old_i]['multiple_usernames'] = "true";
					$student_info_array[$old_i]['userid'] = $student_info_array[$old_i]['userid'] . " " . $row['id'];
					$student_info_array[$old_i]['username'] = $student_info_array[$old_i]['username'] . " " . $row['username'];
					$student_info_array[$old_i]['last_login'] = $student_info_array[$old_i]['last_login'] . " " . $row['last_login'];				
					$student_info_array[$old_i]['initial_password'] = $student_info_array[$old_i]['initial_password'] . " " . $row['initial_password'];
				} else {
					$student_info_array[$i]['multiple_usernames'] = "false";
					$student_info_array[$i]['number'] = $i+1;
					$student_info_array[$i]['person_id'] = $id;
					$student_info_array[$i]['sn1'] = $row['person_sn1'];
					$student_info_array[$i]['sn2'] = $row['person_sn2'];
					$student_info_array[$i]['givenName'] = $row['person_givenName'];
					$student_info_array[$i]['userid'] = $row['id'];
					$student_info_array[$i]['username'] = $row['username'];
					$student_info_array[$i]['initial_password'] = $row['initial_password'];
					$student_info_array[$i]['last_login'] = $row['last_login'];				
					$student_info_array[$i]['personal_email'] = $row['person_secondary_email'];
					$student_info_array[$i]['corporative_email'] = $row['person_email'];
					$student_info_array[$i]['photo_url'] = $row['person_photo'];
					$student_info_array[$i]['person_official_id'] = $row['person_official_id'];	
					
					$student_info_array[$i]['hidden'] = false;
					if ($show_hidden_students) {
						if (is_array($hidden_students)) {
							if (in_array($id,$hidden_students)) {
								$student_info_array[$i]['hidden'] = true;
							}	
						}							
					}

					$student_info_array[$i]['type'] = "#";
					if ($row['enrollment_group_id'] == $classroom_group_id) {
						$student_info_array[$i]['type'] = "*";
					}
					
					$students_ids_to_i_array[$id]=$i;
					$i++;
				}
			}

			return $student_info_array;
		}			
		else {
			return "No s'ha trobat cap registre amb les condicions indicades. " . $this->db->last_query();
		}
	}

	function get_all_classgroups_report_info_by_mentor_id($academic_period_id, $mentor_id) {
		return $this->get_all_classgroups_report_info($academic_period_id,$mentor_id);
	}

	function get_all_classgroups_report_info($academic_period,$mentor_id=null,$orderby = "DESC") {

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
		 WHERE `classroom_group_academic_periods_academic_period_id` = '5' 
		 ORDER BY `classroom_group_code` DESC
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
		$this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id', 'left');
		$this->db->join('person','person.person_id = teacher.teacher_person_id', 'left');
		$this->db->join('shift','shift.shift_id = classroom_group_academic_periods.classroom_group_academic_periods_shift', 'left');
		$this->db->join('location','location.location_id = classroom_group_academic_periods.classroom_group_academic_periods_location', 'left');
		$this->db->where('classroom_group_academic_periods_academic_period_id',$academic_period);
		if ($mentor_id != null) {
			$this->db->where('classroom_group_academic_periods_mentorId',$mentor_id);	
		}		

		$this->db->order_by('classroom_group_code', $orderby);
		
		$query = $this->db->get();

		//echo $this->db->last_query()."<br/>";


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

	public function get_first_classroom_group_id ($teacher_id,$academic_period=null ) {

		if ($academic_period == null) {
			$current_academic_period_id = $this->get_current_academic_period_id();
		} else {
			$current_academic_period_id = $academic_period;
		}

		/*
		SELECT `lesson_classroom_group_id` FROM `lesson` WHERE `lesson_academic_period_id`=5 AND `lesson_teacher_id`=45 LIMIT 1
		*/

		$get_current_academic_period_id = $this->get_current_academic_period_id();

		$this->db->select('lesson_classroom_group_id');
		$this->db->from('lesson');
		$this->db->where('lesson_teacher_id', $teacher_id);	
		$this->db->where('lesson_academic_period_id', $current_academic_period_id);	
		$this->db->limit(1);	

		$query = $this->db->get();
		//echo $this->db->last_query()."<br/>";

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->lesson_classroom_group_id;
		}

		return false;	
	}

	public function is_mentor($teacher_id,$academic_period=null) {

		if ($academic_period == null) {
			$current_academic_period_id = $this->get_current_academic_period_id();
		} else {
			$current_academic_period_id = $academic_period;
		}
		

		/*
		SELECT classroom_group_academic_periods_mentorId
		FROM `classroom_group_academic_periods` 
		WHERE `classroom_group_academic_periods_mentorId`=71 AND `classroom_group_academic_periods_academic_period_id`=5
		*/

		$this->db->select('classroom_group_academic_periods_mentorId');
		$this->db->from('classroom_group_academic_periods');
		$this->db->where('classroom_group_academic_periods_mentorId',$teacher_id);	
		$this->db->where('classroom_group_academic_periods_academic_period_id',$current_academic_period_id);	

		$query = $this->db->get();
		//echo $this->db->last_query()."<br/>";

		if ($query->num_rows() > 0) {
			return true;
		}

		return false;
	}


	function get_mentors($academic_period_id,$orderby="asc") {
		/*
		SELECT `teacher_id`, `teacher_academic_periods_code`, `teacher_person_id`, `teacher_academic_periods_charge_full`, 
		`teacher_academic_periods_charge2_full`, `person`.`person_sn1`, `person`.`person_sn2`, `person`.`person_givenName` 
		FROM (`classroom_group_academic_periods`) 
		JOIN `teacher` ON `teacher`.`teacher_id` = `classroom_group_academic_periods`.`classroom_group_academic_periods_mentorId` 
		JOIN `teacher_academic_periods` ON `teacher_academic_periods`.`teacher_academic_periods_teacher_id` = `teacher`.`teacher_id` 
		JOIN `person` ON `teacher`.`teacher_person_id` = `person`.`person_id` 
		WHERE `classroom_group_academic_periods_academic_period_id` = '5' AND `teacher_academic_periods`.`teacher_academic_periods_academic_period_id` = '5' 
		ORDER BY `person_sn1` asc, `person_sn2` asc, `person_givenName` asc
		*/
		$this->db->select('teacher_id, teacher_academic_periods_code, teacher_person_id, teacher_academic_periods_charge_full, teacher_academic_periods_charge2_full, person.person_sn1, person.person_sn2, person.person_givenName');
		$this->db->from('classroom_group_academic_periods');
		$this->db->join('teacher','teacher.teacher_id = classroom_group_academic_periods.classroom_group_academic_periods_mentorId');
		$this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');
		$this->db->join('person','teacher.teacher_person_id = person.person_id');
		$this->db->where('classroom_group_academic_periods_academic_period_id',$academic_period_id);	
		$this->db->where('teacher_academic_periods.teacher_academic_periods_academic_period_id',$academic_period_id);	

		$this->db->order_by('person_sn1', $orderby);
		$this->db->order_by('person_sn2', $orderby);
		$this->db->order_by('person_givenName', $orderby);
		
		$query = $this->db->get();
		//echo $this->db->last_query()."<br/>";


		if ($query->num_rows() > 0){
			$all_mentors = array();
			foreach($query->result() as $row){
				$mentor = new stdClass;
				
				$mentor->id = $row->teacher_id;
				$mentor->code = $row->teacher_academic_periods_code;
				$mentor->person_id = $row->teacher_person_id;
				$mentor->charge_full = $row->teacher_academic_periods_charge_full;
				$mentor->charge2_full = $row->teacher_academic_periods_charge2_full;
				$mentor->sn1 = $row->person_sn1;
				$mentor->sn2 = $row->person_sn2;
				$mentor->givenName = $row->person_givenName;

				$all_mentors[$mentor->id] = $mentor;
			}
			return $all_mentors;
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

    function get_all_teachers($academic_period_id=null) {

    	if ($academic_period_id == null) {
    		$academic_period_id = $this->get_current_academic_period_id();
    	}

		$this->db->select('teacher_id, teacher_academic_periods_code,teacher_academic_periods_charge_short, teacher_academic_periods_charge_full, person_givenName, person_sn1, person_sn2, person_photo,teacher_academic_periods_charge_sheet_line1,
						teacher_academic_periods_charge_sheet_line2,teacher_academic_periods_charge_sheet_line3,teacher_academic_periods_charge_sheet_line4');
		$this->db->from('teacher');
		$this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');
		$this->db->join('person','teacher_person_id = person_id');
		$this->db->order_by("teacher_academic_periods_code", "asc"); 
		$this->db->where("teacher_academic_periods_academic_period_id", $academic_period_id);
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

    function get_all_conserges() {

		$this->db->select('employees_id, person_givenName, person_sn1, person_sn2, person_photo');
		$this->db->from('employees');
		$this->db->join('person','employees_person_id = person_id');
		$this->db->where('employees_type_id',1);
		$query = $this->db->get();

		//echo $this->db->last_query()."<br/>";
		
		if ($query->num_rows() > 0) {
		
		//$teacher = new stdClass();

		foreach ($query->result_array() as $row)	{

				$conserge = new stdClass();
				
				$conserge->employees_id = $row['employees_id'];
				$conserge->givenName = $row['person_givenName'];
				$conserge->sn1 = $row['person_sn1'];
				$conserge->sn2 = $row['person_sn2'];
				$conserge->photo_url = $row['person_photo'];
				
				$all_conserges[] = $conserge;

			}
			return $all_conserges;
			//print_r($all_teachers);
		}			
		return false;
	}

    function get_all_secretaria() {

		$this->db->select('employees_id, person_givenName, person_sn1, person_sn2, person_photo');
		$this->db->from('employees');
		$this->db->join('person','employees_person_id = person_id');
		$this->db->where('employees_type_id',2);
		$this->db->order_by('person_sn1','asc');
		$query = $this->db->get();

		//echo $this->db->last_query()."<br/>";
		
		if ($query->num_rows() > 0) {
		
		//$teacher = new stdClass();

		foreach ($query->result_array() as $row)	{

				$secretaria = new stdClass();
				
				$secretaria->employees_id = $row['employees_id'];
				$secretaria->givenName = $row['person_givenName'];
				$secretaria->sn1 = $row['person_sn1'];
				$secretaria->sn2 = $row['person_sn2'];
				$secretaria->photo_url = $row['person_photo'];
				
				$all_secretaria[] = $secretaria;

			}
			return $all_secretaria;
			//print_r($all_teachers);
		}			
		return false;
	}


		/*
		CREATE TABLE IF NOT EXISTS `hidden_student` (
		  `hidden_student_id` int(11) NOT NULL AUTO_INCREMENT,
		  `hidden_student_person_id` int(11) NOT NULL,
		  `hidden_student_teacher_id` int(11) NOT NULL,
		  `hidden_student_academic_period_id` int(11) NOT NULL,
		  `hidden_student_classroom_group_id` int(11) NOT NULL,
		  `hidden_student_study_module_id` int(11) NOT NULL,
		  `hidden_student_study_submodule_id` int(11) NOT NULL,
		  `hidden_student_day_id` int(11) NOT NULL,
		  `hidden_student_entryDate` datetime NOT NULL,
		  `hidden_student_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  `hidden_student_creationUserId` int(11) DEFAULT NULL,
		  `hidden_student_lastupdateUserId` int(11) DEFAULT NULL,
		  `hidden_student_markedForDeletion` enum('n','y') NOT NULL,
		  `hidden_student_markedForDeletionDate` datetime NOT NULL,
		  PRIMARY KEY (`hidden_student_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		*/

	function check_if_hidden_student_already_exists( $person_id , $classroom_group_id, $teacher_id,$academic_period_id) {

		$this->db->select('hidden_student_id');
		$this->db->from('hidden_student');
		$this->db->where('hidden_student_person_id',$person_id);
		$this->db->where('hidden_student_teacher_id',$teacher_id);
		$this->db->where('hidden_student_classroom_group_id',$classroom_group_id);
		$this->db->where('hidden_student_academic_period_id',$academic_period_id);
		$this->db->where('hidden_student_study_module_id',0);
		$this->db->where('hidden_student_study_submodule_id',0);
		$this->db->where('hidden_student_day_id',0);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br/>";

		if ($query->num_rows() == 1){
			$row = $query->row(); 
			return $row->hidden_student_id;
		}	
		else {
			return false;
		}
	}

	function unhide_student_on_classroom_group( $person_id , $classroom_group_id, $teacher_id,$academic_period_id = null) {

		$user_person_id = $this->session->userdata('person_id');

		$user_is_a_teacher = $this->is_user_a_teacher($user_person_id);	
		$user_is_admin = $this->ebre_escool->user_is_admin();

		if ( !($user_is_a_teacher || $user_is_admin) ) {
			//TODO: Return not allowed page!
			$result = new stdClass();
		    $result->result = false;
		    $result->message = "Access not allowed!";
			return $result;
		}	


		if ($academic_period_id==null) {
			$academic_period_id = $this->get_current_academic_period_id();
		}

		//ONLY DELETE IF EXISTS. 
		$hidden_student_already_exists = false;
		$hidden_student_already_exists = $this->check_if_hidden_student_already_exists($person_id , $classroom_group_id, $teacher_id,$academic_period_id);
		if ($hidden_student_already_exists) {
			$this->db->where('hidden_student_id', $hidden_student_already_exists);
			$this->db->delete('hidden_student');
		} else {
			$result = new stdClass();
		    $result->result = true;
		    $result->message = "NOT EXISTS: Person id " . $person_id  . " unhidden for classroomgroup " . $classroom_group_id  . " for teacher " . $teacher_id  . " at academic period id " . $academic_period_id;
			return $result;
		}

		if ($this->db->affected_rows() == 1) {
			$result = new stdClass();
		    $result->result = true;
		    $result->message = "Person id " . $person_id  . " unhidded for classroomgroup " . $classroom_group_id  . " for teacher " . $teacher_id  . " at academic period id " . $academic_period_id;
			return $result;
		} else {
			$result = new stdClass();
		    $result->result = false;
		    $result->message = "Error unhidding Person id " . $person_id  . " hidden for classroomgroup " . $classroom_group_id  . " for teacher " . $teacher_id  . " at academic period id " . $academic_period_id;
			return $result;
		}		

	}


	function hide_student_on_classroom_group( $person_id , $classroom_group_id, $teacher_id,$academic_period_id = null) {

		$user_person_id = $this->session->userdata('person_id');

		$user_is_a_teacher = $this->is_user_a_teacher($user_person_id);	
		$user_is_admin = $this->ebre_escool->user_is_admin();

		if ( !($user_is_a_teacher || $user_is_admin) ) {
			//TODO: Return not allowed page!
			$result = new stdClass();
		    $result->result = false;
		    $result->message = "Access not allowed!";
			return $result;
		}	


		if ($academic_period_id==null) {
			$academic_period_id = $this->get_current_academic_period_id();
		}

		$data = array(
		   'hidden_student_person_id' => $person_id ,
		   'hidden_student_teacher_id' => $teacher_id ,
		   'hidden_student_academic_period_id' => $academic_period_id,
		   'hidden_student_classroom_group_id' => $classroom_group_id,
		   'hidden_student_entryDate' => date('Y-m-d H:i:s'),
           'hidden_student_creationUserId' => $this->session->userdata("user_id"),
           'hidden_student_lastupdateUserId' => $this->session->userdata("user_id"),
		);

		$action = "";

		//ONLY INSERT IF NOT EXISTS. IF EXISTS UPDATE!
		$hidden_student_already_exists = false;
		$hidden_student_already_exists = $this->check_if_hidden_student_already_exists($person_id , $classroom_group_id, $teacher_id,$academic_period_id);
		if ($hidden_student_already_exists !=false) {
			//UPDATE
			$this->db->where('hidden_student_id', $hidden_student_already_exists);
			$this->db->update('hidden_student', $data);
			//echo $this->db->last_query()."<br/>";
			$action = "UPDATE";

		} else {
			//INSERT
			$this->db->insert('hidden_student', $data);
			//echo $this->db->last_query()."<br/>";
			$action = "INSERT";
		}

		if ($this->db->affected_rows() == 1) {
			$result = new stdClass();
		    $result->result = true;
		    $result->message = $action . ". Person id " . $person_id  . " hidden for classroomgroup " . $classroom_group_id  . " for teacher " . $teacher_id  . " at academic period id " . $academic_period_id;
			return $result;
		} else {
			$result = new stdClass();
		    $result->result = false;
		    $result->message = "Error hidding Person id " . $person_id  . " hidden for classroomgroup " . $classroom_group_id  . " for teacher " . $teacher_id  . " at academic period id " . $academic_period_id;
			return $result;
		}		

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
		
        $this->db->select('teacher_academic_periods_code, person_sn1, person_sn2, person_givenName, person_id, person_official_id,teacher.teacher_id');
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
   				$teachers_array[$row['teacher_id']] = $row['teacher_academic_periods_code'] . " - " . $row['person_sn1'] . " " . $row['person_sn2'] . ", " . $row['person_givenName'] . " - " . $row['person_official_id'] . " (" . $row['teacher_id'] . ")";
			}
			return $teachers_array;
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
		$this->db->select('teacher_academic_periods_code, person_sn1, person_sn2, person_givenName, person_id, person_official_id,teacher.teacher_id');
		$this->db->from('teacher_academic_periods');        
		$this->db->join('teacher', 'teacher.teacher_id = teacher_academic_periods.teacher_academic_periods_teacher_id');
		$this->db->join('person', 'person.person_id = teacher.teacher_person_id');
		$this->db->order_by('teacher_academic_periods_code', $orderby);

        $query = $this->db->get();
        //echo $this->db->last_query(). "<br/>";
		
		if ($query->num_rows() > 0) {

			$teachers_array = array();

			foreach ($query->result_array() as $row)	{
   				$teachers_array[$row['teacher_id']] = $row['teacher_academic_periods_code'] . " - " . $row['person_sn1'] . " " . $row['person_sn2'] . ", " . $row['person_givenName'] . " - " . $row['person_official_id'] . " (". $row['teacher_id'].")";
			}
			return $teachers_array;
		}			
		else
			return false;
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

	function get_teacher_id_by_personid($person_id) {

		$get_current_academic_period = $this->get_current_academic_period_id();
		/*
		SELECT teacher_academic_periods_code
		FROM teacher_academic_periods 
		INNER JOIN teacher ON teacher.teacher_id =  teacher_academic_periods.teacher_academic_periods_teacher_id
		INNER JOIN person ON person.person_id = teacher.teacher_person_id
		WHERE teacher_academic_periods_academic_period_id=5 AND person_id= 56
		*/
		
		$this->db->select('teacher_id');
		$this->db->from('teacher_academic_periods');
		$this->db->join('teacher','teacher.teacher_id =  teacher_academic_periods.teacher_academic_periods_teacher_id');
		$this->db->join('person','person.person_id = teacher.teacher_person_id');
		$this->db->where('teacher_academic_periods.teacher_academic_periods_academic_period_id',$get_current_academic_period);
		$this->db->where('person.person_id',$person_id);

		$query = $this->db->get();
		//echo $this->db->last_query()."<br/>";


		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->teacher_id;
		}			
		return false;
	}

}
