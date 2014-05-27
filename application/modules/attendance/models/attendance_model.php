<?php
/**
 * Attendance_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergitur@ebretic.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class attendance_model  extends CI_Model  {
	
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

	function insert_incidence($data_incident_array){
		$this->db->insert('incident', $data_incident_array); 
		echo $this->db->last_query();
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

	function getTeacherCode($person_id) {
		$this->db->select('teacher_code');
		$this->db->from('teacher');
		$this->db->where('teacher.teacher_person_id',$person_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->teacher_code;
		}			
		return false;
	}

	function getAllGroupStudentsInfo($class_group_id) {
		/*
		SELECT `student_id` , person.person_id, person.person_sn1, person.person_sn2, person.person_givenName, users.username, person.person_secondary_email
		FROM `student`
		INNER JOIN person ON student.`student_person_id` = person.person_id
		INNER JOIN users ON person.`person_id` = users.person_id
		INNER JOIN enrollment_class_group ON users.person_id = enrollment_class_group.enrollment_class_group_personid
		WHERE enrollment_class_group_group_id =26
		LIMIT 0 , 30
		*/

		$this->db->select('student.student_id,person.person_id, person.person_sn1, person.person_sn2, person.person_givenName,
			users.username, person.person_secondary_email,person.person_photo');
		$this->db->from('student');
		$this->db->join('person','student.student_person_id = person.person_id');
		$this->db->join('users','person.person_id = users.person_id');
		$this->db->join('enrollment_class_group','users.person_id = enrollment_class_group.enrollment_class_group_personid');
		
		$this->db->where('enrollment_class_group.enrollment_class_group_group_id',$class_group_id);
		
		$this->db->order_by('person.person_sn1');
		$this->db->order_by('person.person_sn2');
		$this->db->order_by('person.person_givenName');
		$this->db->distinct();
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {
			$student_info_array = array();

			foreach ($query->result_array() as $row)	{

				//$student_info_array[] = $row;
   				$student = new stdClass();
				
				$student->student_id = $row['student_id'];
				$student->person_id = $row['person_id'];
				$student->sn1 = $row['person_sn1'];
				$student->sn2 = $row['person_sn2'];
				$student->givenName = $row['person_givenName'];
				$student->username = $row['username'];
				$student->email = $row['person_secondary_email'];
				$student->photo_url = $row['person_photo'];
				
				$student_info_array[$row['student_id']] = $student;

			}

			return $student_info_array;
		}			
		else {
			return array();
		}
			

	}

	function getAllIncidentsGroupByDate($group,$start_date,$end_date = false) {
		$this->db->select('person.person_id, student.student_id, person.person_givenName, person.person_sn1, person.person_sn2, 
			attendance_incident.attendance_incident_day, 
			attendance_incident.data_incidencia, classroom_group.classroom_group_code, attendance_incident.attendance_incident_type');
		$this->db->from('student');
		$this->db->join('person','student.student_person_id = person.person_id');
		$this->db->join('attendance_incident','attendance_incident.attendance_incident_student_id = student.student_id');
		$this->db->join('enrollment_class_group','enrollment_class_group_personid = person.person_id');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = enrollment_class_group.enrollment_class_group_group_id');
		$this->db->where('enrollment_class_group.enrollment_class_group_group_id = ', $group);
		
		if($end_date == false){
			$this->db->where('attendance_incident.data_incidencia =', $start_date);
		} else {
			$this->db->where('attendance_incident.data_incidencia >=', $start_date);
			$this->db->where('attendance_incident.data_incidencia <=', $end_date);
		}
		
		$this->db->order_by('person.person_sn1');
		$this->db->order_by('person.person_sn2');
		$this->db->order_by('person.person_givenName');
		$this->db->order_by('attendance_incident.data_incidencia');
		$this->db->distinct();
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$student_incident_array = array();

			foreach ($query->result_array() as $row)	{

				$incident = new stdClass();
				
				//$incident->person_id = $row['person_id'];
				$incident->student_id = $row['student_id'];
				$incident->sn1 = $row['person_sn1'];
				$incident->sn2 = $row['person_sn2'];
				$incident->givenName = $row['person_givenName'];
				$incident->incident_type = $row['attendance_incident_type'];
				$incident->incident_date = $row['data_incidencia'];				
				
				$student_incident_array[] = $incident;

			}

			return $student_incident_array;
		}			
		else
			return false;

	}

	function getAllIncidentsGroupByMonth($group,$month,$year) {
		$this->db->select('person.person_id, student.student_id, person.person_givenName, person.person_sn1, person.person_sn2, 
			attendance_incident.attendance_incident_day, 
			attendance_incident.data_incidencia, classroom_group.classroom_group_code, attendance_incident.attendance_incident_type');
		$this->db->from('student');
		$this->db->join('person','student.student_person_id = person.person_id');
		$this->db->join('attendance_incident','attendance_incident.attendance_incident_student_id = student.student_id');
		$this->db->join('enrollment_class_group','enrollment_class_group_personid = person.person_id');
		$this->db->join('classroom_group','classroom_group.classroom_group_id = enrollment_class_group.enrollment_class_group_group_id');
		$this->db->where('enrollment_class_group.enrollment_class_group_group_id = ', $group);
		
		$this->db->where('month(attendance_incident.data_incidencia)', $month);
		$this->db->where('year(attendance_incident.data_incidencia)', $year);
		
		$this->db->order_by('attendance_incident.data_incidencia');		

		$this->db->distinct();
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$student_incident_array = array();

			foreach ($query->result_array() as $row)	{

				$incident = new stdClass();
				
				//$incident->person_id = $row['person_id'];
				$incident->student_id = $row['student_id'];
				$incident->sn1 = $row['person_sn1'];
				$incident->sn2 = $row['person_sn2'];
				$incident->givenName = $row['person_givenName'];
				$incident->incident_type = $row['attendance_incident_type'];
				$incident->incident_date = $row['data_incidencia'];				
				
				$student_incident_array[] = $incident;

			}

			return $student_incident_array;
		}			
		else
			return false;

	}



	function getAllStudentsMail(){
		/*
		SELECT `student_id` , person.person_id, person.person_sn1, person.person_sn2, person.person_givenName, users.username, person.person_secondary_email
		FROM `student`
		INNER JOIN person ON student.`student_person_id` = person.person_id
		INNER JOIN users ON person.`person_id` = users.person_id
		INNER JOIN enrollment_class_group ON users.person_id = enrollment_class_group.enrollment_class_group_personid
		WHERE enrollment_class_group_group_id =26
		LIMIT 0 , 30
		*/

		$this->db->select('student.student_id,person.person_id, person.person_sn1, person.person_sn2, person.person_givenName, person.person_email, person.person_secondary_email,person.person_photo');
		$this->db->from('student');
		$this->db->join('person','student.student_person_id = person.person_id');
	//	$this->db->join('users','person.person_id = users.person_id');
	//	$this->db->join('enrollment_class_group','users.person_id = enrollment_class_group.enrollment_class_group_personid');
		
	//	$this->db->where('enrollment_class_group.enrollment_class_group_group_id',$class_group_id);
		
		$this->db->order_by('person.person_sn1');
		$this->db->order_by('person.person_sn2');
		$this->db->order_by('person.person_givenName');
		$this->db->distinct();
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$student_info_array = array();

			foreach ($query->result_array() as $row)	{

				//$student_info_array[] = $row;
   				$student = new stdClass();
				
				//$student->id = $row['student_id'];
				$student->person_id = $row['person_id'];
				$student->sn1 = $row['person_sn1'];
				$student->sn2 = $row['person_sn2'];
				$student->givenName = $row['person_givenName'];
//				$student->username = $row['username'];
				$student->email = $row['person_email'];
				$student->secondary_email = $row['person_secondary_email'];
				$student->photo_url = $row['person_photo'];
				
				$student_info_array[$row['student_id']] = $student;

			}

			return $student_info_array;
		}			
		else
			return false;

	}

	function getGroupInfoByGroupId($group_id) {
		$this->db->select('classroom_group_id,classroom_group_name,classroom_group_shortName,classroom_group_code');
		$this->db->from('classroom_group');
		
		$this->db->where('classroom_group.classroom_group_id',$group_id);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return array('id' => $row->classroom_group_id, 'name' => $row->classroom_group_name, 'shortname' => $row->classroom_group_shortName, 'code' => $row->classroom_group_code);
		}			
		else {
			return "";
		}
	}

	function getStudyModuleInfoByModuleId($study_module_id) {
		$this->db->select('study_module_id,study_module_external_code,study_module_shortname,study_module_name');
		$this->db->from('study_module');
		
		$this->db->where('study_module.study_module_id',$study_module_id);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return array('name' => $row->study_module_name, 'shortname' => $row->study_module_shortname, 'code' => $row->study_module_external_code);
		}			
		else {
			return "";
		}
	}

	public function getStudy_module_info($day,$time_lot,$classgroup_id) {
		/*
			SELECT `lesson_study_module_id` , `study_module_shortname` , nom_grup, teacher_id, `person_givenName` , `person_sn1` , `person_sn2`
			FROM `lesson`
			INNER JOIN study_module ON `lesson`.`lesson_study_module_id` = study_module.study_module_id
			INNER JOIN teacher ON `study_module`.`study_module_teacher_id` = teacher.teacher_id
			INNER JOIN person ON `teacher`.`teacher_person_id` = person.person_id
			WHERE `lesson_day` =1
			AND `lesson_time_slot_id` =14
			AND `lesson_classroom_group_id` =25
		*/

		$this->db->select("lesson_study_module_id, study_module_shortname, study_module_name, teacher_id, teacher_code , person_givenName, person_sn1, person_sn2");
		$this->db->from('lesson');
		$this->db->join('study_module','lesson.lesson_study_module_id = study_module.study_module_id');
		$this->db->join('teacher','study_module.study_module_teacher_id = teacher.teacher_id');
		$this->db->join('person','teacher.teacher_person_id = person.person_id');
		$this->db->where('lesson.lesson_day',$day);
		$this->db->where('lesson.lesson_time_slot_id',$time_lot);
		$this->db->where('lesson.lesson_classroom_group_id',$classgroup_id);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) { 

			$study_module_info = array();

			$row = $query->row();

			$study_module_info['id'] = $row->lesson_study_module_id;
			$study_module_info['shortname'] = $row->study_module_shortname;
			$study_module_info['name'] = $row->study_module_name;

			$study_module_info['teacher_id'] = $row->teacher_id;
			$study_module_info['teacher_code'] = $row->teacher_code;
			$study_module_info['teacher_givenName'] = $row->person_givenName;
			$study_module_info['teacher_sn1'] = $row->person_sn1;
			$study_module_info['teacher_sn2'] = $row->person_sn2;
				
			return $study_module_info;

		}			
		else {
			return false;
		}
	}

	public function getTimeSlotsByClassgroupId($classgroup_id,$day) {
		/*
		SELECT DISTINCT `time_slot_id` , `time_slot_start_time` , `time_slot_end_time` , `time_slot_lective`, time_slot_order
		FROM `time_slot`
		INNER JOIN lesson ON time_slot.`time_slot_id` = lesson.`lesson_time_slot_id`
		WHERE `time_slot_lective` =1
		AND lesson.`lesson_classroom_group_id` = 25
		ORDER BY time_slot_order
		*/

		$this->db->select("time_slot_id, time_slot_start_time, time_slot_end_time, time_slot_lective, time_slot_order");
		$this->db->from('time_slot');
		$this->db->join('lesson','time_slot.time_slot_id = lesson.lesson_time_slot_id');
		
		$this->db->where('time_slot.time_slot_lective',1);
		$this->db->where('lesson.lesson_classroom_group_id',$classgroup_id);
		$this->db->order_by('time_slot_order');

		$this->db->distinct();

		$query = $this->db->get();

		//echo "query:" . $this->db->last_query();
		
		if ($query->num_rows() > 0) {
			
			$time_slots = array();

			$i=1;
			$results_array = $query->result_array();
			if ( is_array($results_array) ) {
				foreach ( $results_array as $row)	{
					$time_slot = new stdClass();

					$time_slot->id = $row['time_slot_id'];
					$time_slot->hour = $row['time_slot_start_time'];
					$time_slot->range = $row['time_slot_start_time'] . " - " . $row['time_slot_end_time'];

					$study_module_info = $this->getStudy_module_info ($day, $time_slot->id, $classgroup_id);

					$time_slot->study_module_id = $study_module_info['id'];
					$time_slot->study_module_shortname = $study_module_info['shortname'];
					$time_slot->study_module_name = $study_module_info['name'];

					$study_submodules = $this->getStudySubModulesFromStudyModuleId( $time_slot->study_module_id );

					$time_slot->study_submodules = $study_submodules;

					$time_slot->teacher_id = $study_module_info['teacher_id'];
					$time_slot->teacher_code = $study_module_info['teacher_code'];
					$time_slot->teacher_name = $study_module_info['teacher_sn1'] . " " . $study_module_info['teacher_sn2'] . ", " . $study_module_info['teacher_givenName'];

					$time_slots[$i] = $time_slot;
					$i++;
				}	
			}
			
			return $time_slots;
		}			
		else {
			return false;
		}
	}

	public function getStudySubModulesFromStudyModuleId( $study_module_id, $orderby = "ASC" ) {
		/*
		SELECT `study_submodules_id`, `study_submodules_shortname`, `study_submodules_name`, `study_submodules_initialDate`, `study_submodules_endDate`, `study_submodules_totalHours`
		FROM `study_submodules` 
		INNER JOIN study_module
		ON `study_module_id` = `study_submodules_study_module_id`
		WHERE `study_module_id`=273
		*/

		$this->db->select("study_submodules_id, study_submodules_shortname, study_submodules_name, study_submodules_initialDate, study_submodules_endDate, study_submodules_totalHours");
		$this->db->from('study_submodules');
		$this->db->join('study_module','study_module_id = study_submodules_study_module_id');
		
		$this->db->where('study_module.study_module_id', $study_module_id);
		$this->db->order_by('study_submodules_order',$orderby);
		$this->db->order_by('study_submodules_shortname',$orderby);

		$this->db->distinct();
		$query = $this->db->get();

		//echo "query:" . $this->db->last_query();
		
		if ($query->num_rows() > 0) {
			
			$study_submodules = array();

			$results_array = $query->result_array();
			if ( is_array($results_array) ) {
				foreach ( $results_array as $row)	{
					$study_submodule = new stdClass();

					$study_submodule->shortname = $row['study_submodules_shortname'];
					$study_submodule->name = $row['study_submodules_name'];

					$startdate = date_format(new DateTime($row['study_submodules_initialDate']),"d/m/Y");
					$finaldate = date_format(new DateTime($row['study_submodules_endDate']),"d/m/Y");

					$study_submodule->startdate = $startdate;
					$study_submodule->finaldate = $finaldate;
					$study_submodule->totalHours = $row['study_submodules_totalHours'];

					$study_submodule->active = $this->check_in_range($row['study_submodules_initialDate'], $row['study_submodules_endDate'], now());

					$study_submodules[$row['study_submodules_id']] = $study_submodule;
				}	
			}
			
			return $study_submodules;
		}			
		else {
			return false;
		}
	}

	private function check_in_range($start_date, $end_date, $date_from_user) {

		// Convert to timestamp
  		$start_ts = strtotime($start_date);
  		$end_ts = strtotime($end_date);
  		$user_ts = $date_from_user;

  		// Check that user date is between start & end
  		return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}

	public function getTimeSlotsByStudyModuleId($classgroup_id) {
		/*
		SELECT DISTINCT `time_slot_id` , `time_slot_start_time` , `time_slot_end_time` , `time_slot_lective`, time_slot_order
		FROM `time_slot`
		INNER JOIN lesson ON time_slot.`time_slot_id` = lesson.`lesson_time_slot_id`
		WHERE `time_slot_lective` =1
		AND lesson.`lesson_classroom_group_id` = 25
		ORDER BY time_slot_order
		*/

		// ******* TODO 

		$this->db->select(`time_slot_id` , `time_slot_start_time` , `time_slot_end_time` , `time_slot_lective` , `time_slot_order`);
		$this->db->from('time_slot');
		$this->db->join('lesson','time_slot.time_slot_id = lesson.lesson_time_slot_id');
		$this->db->where('time_slot.time_slot_lective',1);
		$this->db->where('lesson.lesson_classroom_group_id',$classgroup_id);
		
		$this->db->distinct();
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {
			return $query->result_array();
		}			
		else {
			return false;
		}
			
	}
			



/* Get All Group Students Info 

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
*/

function getAllGroupStudentInfo($group){

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
		$this->db->where('classroom_group.classroom_group_id',$group);
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

	function get_all_groups($orderby="asc") {
		$this->db->from('classroom_group');
        $this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name');

		$this->db->order_by('classroom_group_code', $orderby);
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$groups_array = array();

			foreach ($query->result_array() as $row)	{
   				$groups_array[$row['classroom_group_id']] = $row['classroom_group_code'] . " - " . $row['classroom_group_name'] . "( " . $row['classroom_group_shortName'] . " )";
   				//$groups_array[$row['classroom_group_code']] = $row['classroom_group_code'] . " - " . $row['classroom_group_shortName'];
			}
			return $groups_array;
		}			
		else
			return false;
	}	


	function get_teacher_departmentInfo($teacherId,$orderby="asc") {
		$this->db->select('department_id,department_shortName,department_name');
		$this->db->from('department');        
   		$this->db->join('teacher', 'department.department_id = teacher.teacher_department_id');

		$this->db->order_by('department_shortName', $orderby);

		$this->db->where('teacher_id', $teacherId);			
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return array ( "id" => $row->department_id, "name" => $row->department_shortName);
		}			
		else
			return false;
	}
	 

	function get_teacher_departmentName($teacherId,$orderby="asc") {
		$this->db->from('department');
        $this->db->select('department_id,department_shortName,department_name');
   		$this->db->join('teacher', 'department.department_id = teacher.teacher_department_id');

		$this->db->order_by('department_shortName', $orderby);

		$this->db->where('teacher_id', $teacherId);			
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->department_shortName;
		}			
		else
			return false;
	}
	

	function get_teacher_departments($teacherId,$orderby="asc") {
		$this->db->from('department');
        $this->db->select('department_id,department_shortName,department_name');
   		$this->db->join('teacher', 'department.department_id = teacher.teacher_department_id');

		$this->db->order_by('department_shortName', $orderby);

		$this->db->where('teacher_id', $teacherId);			
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$departments_array = array();

			foreach ($query->result_array() as $row)	{
   				$departments_array[$row['department_id']] = $row['department_shortName'];
			}
			return $departments_array;
		}			
		else
			return false;
	}

	function get_department($departmentId,$orderby="asc") {
		$this->db->from('department');
        $this->db->select('department_id,department_shortName,department_name');

		$this->db->order_by('department_shortName', $orderby);

		$this->db->where('department_id', $departmentId);			
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$departments_array = array();

			foreach ($query->result_array() as $row)	{
   				$departments_array[$row['department_id']] = $row['department_shortName'];
			}
			return $departments_array;
		}			
		else
			return false;
	}

	function get_all_departments($orderby="asc") {
		$this->db->from('department');
        $this->db->select('department_id,department_shortName,department_name');

		$this->db->order_by('department_shortName', $orderby);
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$departments_array = array();

			foreach ($query->result_array() as $row)	{
   				$departments_array[$row['department_id']] = $row['department_shortName'];
			}
			return $departments_array;
		}			
		else
			return false;
	}

	function get_all_groupscodenameByTeacher($teacherId,$orderby="asc") {
		$this->db->from('classroom_group');
        $this->db->select('classroom_group_id,classroom_group_code');
        $this->db->join('lesson', 'classroom_group.classroom_group_id = lesson.lesson_classroom_group_id');
        $this->db->distinct();
		$this->db->order_by('classroom_group_code', $orderby);

		$this->db->where('lesson.lesson_teacher_id', $teacherId);
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$groups_array = array();

			foreach ($query->result_array() as $row)	{
   				$groups_array[$row['classroom_group_id']] = $row['classroom_group_code'];
			}
			return $groups_array;
		}			
		else
			return false;
	}	

	function get_all_groupscodenameByDeparment($departmentId,$orderby="asc") {
		/*
		SELECT DISTINCT `classroom_group_code`,`studies_shortname`,`department_name`,department.`department_id`
		FROM `classroom_group` 
		INNER JOIN course
		ON classroom_group.`classroom_group_course_id` = course.course_id
		INNER JOIN studies
		ON course.`course_estudies_id` = studies.`studies_id`
		INNER JOIN study_department
		ON studies.studies_id = study_department.study_id
		INNER JOIN department
		ON study_department.`study_id` = department.`department_id`
		WHERE department.`department_id` = 2
		*/
		$this->db->select('classroom_group_id,classroom_group_code, studies_shortname, department_name, department.department_id');
		$this->db->from('classroom_group');        

		$this->db->join('course', 'classroom_group.classroom_group_course_id = course.course_id');
		$this->db->join('studies', 'course.course_estudies_id = studies.studies_id');
		$this->db->join('study_department', 'studies.studies_id = study_department.study_id');
		$this->db->join('department', 'study_department.study_id = department.department_id');
        

		$this->db->where('department.department_id', $departmentId);
		$this->db->order_by('classroom_group_code', $orderby);
		       
		$this->db->distinct();       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$groups_array = array();

			foreach ($query->result_array() as $row)	{
   				$groups_array[$row['classroom_group_id']] = $row['classroom_group_code'];
			}
			return $groups_array;
		}			
		else
			return false;
	}	

	function get_all_groupscodename($orderby="asc") {
		$this->db->from('classroom_group');
        $this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name');

		$this->db->order_by('classroom_group_code', $orderby);
		       
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$groups_array = array();

			foreach ($query->result_array() as $row)	{
   				$groups_array[$row['classroom_group_id']] = $row['classroom_group_code'];
			}
			return $groups_array;
		}			
		else
			return false;
	}	



	function get_teacher_ids_and_names($teacher_id,$orderby="asc") {

		$this->db->from('teacher');
        $this->db->select('teacher_code,person_sn1,person_sn2,person_givenName,person_id,person_official_id');

		//$this->db->order_by('lesson_code', $orderby);
		
		$this->db->join('person', 'person.person_id = teacher.teacher_person_id');
		$this->db->where('teacher_id', $teacher_id);
        
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$teachers_array = array();

			foreach ($query->result_array() as $row)	{
   				$teachers_array[$row['teacher_code']] = $row['teacher_code'] . " - " . $row['person_sn1'] . " " . $row['person_sn2'] . ", " . $row['person_givenName'] . " - " . $row['person_official_id'];
			}
			return $teachers_array;
		}			
		else
			return false;
	}

	function get_all_teachers_ids_and_names() {

		$this->db->from('teacher');
        $this->db->select('teacher_code,person_sn1,person_sn2,person_givenName,person_id,person_official_id');

		//$this->db->order_by('lesson_code', $orderby);
		
		$this->db->join('person', 'person.person_id = teacher.teacher_person_id');
        
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$teachers_array = array();

			foreach ($query->result_array() as $row)	{
   				$teachers_array[$row['teacher_code']] = $row['teacher_code'] . " - " . $row['person_sn1'] . " " . $row['person_sn2'] . ", " . $row['person_givenName'] . " - " . $row['person_official_id'];
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

	function get_teacher_info_from_teacher_code($teacher_code) {
		$this->db->select('teacher_id,teacher_person_id,teacher_code,person_givenName,person_sn1,person_sn2');
		$this->db->from('teacher');
		$this->db->join('person', 'teacher.teacher_person_id = person.person_id');
		$this->db->where('teacher.teacher_code',$teacher_code);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return array ( "teacher_id" => $row->teacher_id , "teacher_code" => $row->teacher_code ,  
				"givenName" => $row->person_givenName , "sn1" => $row->person_sn1 , "sn2" => $row->person_sn2);
		}
		else
			return false;
	}

	function get_teacher_code_from_teacher_id($teacher_id) {
		$this->db->select('teacher_code');
		$this->db->from('teacher');
		$this->db->where('teacher.teacher_id',$teacher_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->teacher_code;
		}
		else
			return false;
	}


	function get_teacher_id_from_teacher_code($teacher_code) {

		$this->db->select('teacher_id');
		$this->db->from('teacher');
		$this->db->where('teacher.teacher_code',$teacher_code);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->teacher_id;
		}
		else
			return false;
	}

	function getAllTimeSlotsByTeacherCodeAndDay($teacher_id, $day,$orderby = "asc") {
		/*
		SELECT time_slot_id,time_slot_start_time,time_slot_end_time,time_slot_lective
		FROM lesson
		INNER JOIN time_slot ON lesson.`lesson_time_slot_id`=time_slot.time_slot_id
		WHERE `lesson_day`=1 AND `lesson_teacher_id`=38
		*/
		$this->db->select('time_slot_id,time_slot_start_time,time_slot_end_time,time_slot_lective');
		$this->db->from('lesson');
		$this->db->order_by('time_slot_order', $orderby);
		$this->db->where('lesson_day', $day);
		$this->db->where('lesson_teacher_id', $teacher_id);
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');

		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}

	function getTimeSlotKeyFromLessonId ( $lesson_id) {
		//SELECT `lesson_time_slot_id` FROM `lesson` WHERE `lesson_id`=971
		$this->db->select('lesson_time_slot_id');
		$this->db->from('lesson');
		$this->db->where('lesson_id', $lesson_id);
		
		$query = $this->db->get();

		if ($query->num_rows() == 1)	{
			$row = $query->row(); 
			return $row->lesson_time_slot_id;
		}
		else
			return 0;
	}

	function getAllLessonsByTeacherCodeAndDay ($teacher_id, $day,$orderby = "asc") {
		/*
		SELECT `lesson_id`,`lesson_code`,classroom_group_code,classroom_group_shortName,classroom_group_name
		FROM lesson
		INNER JOIN classroom_group ON lesson.`lesson_classroom_group_id`= classroom_group.classroom_group_id
		WHERE `lesson_day`=1 AND `lesson_teacher_id`=38
		*/
		
		$this->db->select('time_slot_order,time_slot_id,lesson_id,lesson_code,classroom_group_id,classroom_group_code,classroom_group_shortName,
						  classroom_group_name,study_module_id,study_module_shortname,study_module_name,location_shortName,classroom_group_location_id');
		$this->db->from('lesson');
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id');
		$this->db->join('study_module', 'lesson.lesson_study_module_id = study_module.study_module_id');
		$this->db->join('location', 'lesson.lesson_location_id = location.location_id','left');
		$this->db->order_by('time_slot_order', $orderby);
		$this->db->where('lesson_day', $day);
		$this->db->where('lesson_teacher_id', $teacher_id);


		$query = $this->db->get();
		if ($query->num_rows() > 0)	{
			
			$lessons_array = array();

			foreach ($query->result_array() as $row)	{

				$lesson = new stdClass();
				$lesson->group_id = $row['classroom_group_id'];
				$lesson->group_code = $row['classroom_group_code'];
				$lesson->base_url = base_url("index.php?/attendance/check_attendance/" . $row['classroom_group_code']);
				$lesson->group_shortname = $row['classroom_group_shortName'];
				$lesson->group_name = $row['classroom_group_name'];
				$lesson->study_module_id = $row['study_module_id'];
				$lesson->classroom_group_code = $row['classroom_group_code'];				
				$lesson->lesson_id = $row['lesson_id'];
				$lesson->lesson_code = $row['lesson_code'];
				$lesson->lesson_shortname = $row['study_module_shortname'];
				$lesson->lesson_name = $row['study_module_name'];
				$lesson->lesson_location = $row['location_shortName'];
				$lesson->classroom_group_location_id = $row['classroom_group_location_id'];

   				$lessons_array[$row['time_slot_id']] = $lesson;

			}
			return $lessons_array;
		}
		else
			return false;
	}


//OSCAR: Obtenir les incidències d'una data i hora
	function getAllIncidentsByDateTime($data, $hora,$tipus_falta,$orderby = "asc") {
		
		$this->db->select('student_id,teacher_id,st.person_givenName as "student_name",st.person_sn1 as "student_sn1",st.person_sn2 as "student_sn2",
			teach.person_givenName as "teacher_name",teach.person_sn1 as "teacher_sn1",teach.person_sn2 as "teacher_sn2",
			data_incidencia,attendance_incident_timeslot_id,attendance_incident_lesson_id, attendance_incident_type,observacions,
			classroom_group_code,study_module_shortname');
		$this->db->from('attendance_incident');
		$this->db->join('student','attendance_incident_student_id=student_id');
		$this->db->join('person as st','student_person_id=st.person_id');
		$this->db->join('teacher','attendance_incident_teacher_id=teacher_id');
		$this->db->join('person as teach','teacher_person_id=teach.person_id');		
		$this->db->join('lesson','lesson_teacher_id=teacher_id');
		$this->db->join('classroom_group','lesson_classroom_group_id=classroom_group_id');
		$this->db->join('study_module','lesson_study_module_id=study_module_id');	

		$this->db->where('attendance_incident_timeslot_id',$hora);
		$this->db->where('data_incidencia',date("Y-m-d", strtotime($data)));
		if($tipus_falta!=''){
			$this->db->where_in('attendance_incident_type', $tipus_falta);
		} else {
			$this->db->where('attendance_incident_type','');
		}

		$this->db->distinct();
		$query = $this->db->get();

		//echo $this->db->last_query();
		if ($query->num_rows() > 0)	{
			
			$incident = array();

			foreach ($query->result_array() as $row)	{

				$incident = new stdClass();
				$incident->student_id = $row['student_id'];

				$incident->student_name = $row['student_name'];
				$incident->student_sn1 = $row['student_sn1'];
				$incident->student_sn2 = $row['student_sn2'];

				$incident->teacher_id = $row['teacher_id'];
				$incident->teacher_name = $row['teacher_name'];
				$incident->teacher_sn1 = $row['teacher_sn1'];
				$incident->teacher_sn2 = $row['teacher_sn2'];				

				$incident->group = $row['classroom_group_code'];
				$incident->study_module = $row['study_module_shortname'];				
				$incident->type = $row['attendance_incident_type'];
				$incident->timeslot = $row['attendance_incident_timeslot_id'];
				$incident->day = $row['data_incidencia'];
				
   				$incidents_array[] = $incident;

			}
			return $incidents_array;
		}
		else
			return false;
	}

//OSCAR: Obtenir les incidències entre 2 dates
	function getAllIncidentsBetweenDates($data_ini, $data_fi,$tipus_falta,$limit=false,$orderby = "asc") {
		
		$this->db->select('student_id,teacher_id,st.person_givenName as "student_name",st.person_sn1 as "student_sn1",st.person_sn2 as "student_sn2",
			teach.person_givenName as "teacher_name",teach.person_sn1 as "teacher_sn1",teach.person_sn2 as "teacher_sn2",
			data_incidencia,attendance_incident_timeslot_id,attendance_incident_lesson_id, attendance_incident_type,observacions,
			classroom_group_code,study_module_shortname');
		$this->db->from('attendance_incident');
		$this->db->join('student','attendance_incident_student_id=student_id');
		$this->db->join('person as st','student_person_id=st.person_id');
		$this->db->join('teacher','attendance_incident_teacher_id=teacher_id');
		$this->db->join('person as teach','teacher_person_id=teach.person_id');		
		$this->db->join('lesson','lesson_teacher_id=teacher_id');
		$this->db->join('classroom_group','lesson_classroom_group_id=classroom_group_id');
		$this->db->join('study_module','lesson_study_module_id=study_module_id');	

		$this->db->where('data_incidencia >=', date("Y-m-d", strtotime($data_ini)));
		$this->db->where('data_incidencia <=', date("Y-m-d", strtotime($data_fi)));
		if($tipus_falta!=''){
			$this->db->where_in('attendance_incident_type', $tipus_falta);
		} else {
			$this->db->where('attendance_incident_type','');
		}

		$this->db->distinct();
		if($limit){
			$this->db->limit($limit);
		}
		$query = $this->db->get();

		//echo $this->db->last_query();
		if ($query->num_rows() > 0)	{
			
			$incident = array();

			foreach ($query->result_array() as $row)	{

				$incident = new stdClass();
				$incident->student_id = $row['student_id'];
				$incident->student_name = $row['student_name'];
				$incident->student_sn1 = $row['student_sn1'];
				$incident->student_sn2 = $row['student_sn2'];

				$incident->teacher_id = $row['teacher_id'];
				$incident->teacher_name = $row['teacher_name'];
				$incident->teacher_sn1 = $row['teacher_sn1'];
				$incident->teacher_sn2 = $row['teacher_sn2'];				

				$incident->group = $row['classroom_group_code'];
				$incident->study_module = $row['study_module_shortname'];				
				$incident->type = $row['attendance_incident_type'];
				$incident->timeslot = $row['attendance_incident_timeslot_id'];
				$incident->day = $row['data_incidencia'];
				
   				$incidents_array[] = $incident;

			}
			return $incidents_array;
		}
		else
			return false;
	}



//OSCAR: Obtenir les lliçons d'un dia
	function getAllLessonsByDay($day,$classroom_group_id,$orderby = "asc") {
		/*
		SELECT `lesson_id`,`lesson_code`,classroom_group_code,classroom_group_shortName,classroom_group_name
		FROM lesson
		INNER JOIN classroom_group ON lesson.`lesson_classroom_group_id`= classroom_group.classroom_group_id
		WHERE `lesson_day`=1 AND `lesson_teacher_id`=38
		*/
		$this->db->select('time_slot_order,time_slot_id,lesson_id,lesson_code,classroom_group_code,classroom_group_shortName,
						  classroom_group_name,study_module_id,study_module_shortname,study_module_name,location_shortName,classroom_group_location_id');
		$this->db->from('lesson');
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id');
		$this->db->join('study_module', 'lesson.lesson_study_module_id = study_module.study_module_id');
		$this->db->join('location', 'lesson.lesson_location_id = location.location_id','left');
		$this->db->order_by('time_slot_order', $orderby);
		$this->db->where('lesson_day', $day);
		$where = "classroom_group_id = '$classroom_group_id'";
		
		$this->db->where($where);

		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0)	{
			
			$lessons_array = array();

			foreach ($query->result_array() as $row)	{

				$lesson = new stdClass();
				$lesson->group_code = $row['classroom_group_code'];
				$lesson->base_url = base_url("index.php?/attendance/check_attendance/" . $row['classroom_group_code']);
				$lesson->group_shortname = $row['classroom_group_shortName'];
				$lesson->group_name = $row['classroom_group_name'];
				$lesson->study_module_id = $row['study_module_id'];
				$lesson->classroom_group_code = $row['classroom_group_code'];				
				$lesson->lesson_code = $row['lesson_code'];
				$lesson->lesson_shortname = $row['study_module_shortname'];
				$lesson->lesson_name = $row['study_module_name'];
				$lesson->lesson_location = $row['location_shortName'];
				$lesson->classroom_group_location_id = $row['classroom_group_location_id'];

   				$lessons_array[$row['time_slot_id']] = $lesson;

			}
			return $lessons_array;
		}
		else
			return false;
	}


	
	function getAllLessons($exists_assignatures_table=false,$orderby="asc") {
		//classroom_group
        if (!$exists_assignatures_table) {
            $this->db->select('lesson_id,lesson_code,classroom_group.groupShortName,classroom_group_code,teacher_code,lesson_shortname,classrom_code,day_code,hour_code');
        }
        else {
            $this->db->select('lesson_id,lesson_code,classroom_group.groupShortName,classroom_group_code,teacher_code,lesson_shortname,assignatura.nom_assignatura,classrom_code,day_code,hour_code');
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
		$this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name,classroom_group_description,classroom_group_mentorId');
		$this->db->from('classroom_group');
		$this->db->order_by('classroom_group_code', $orderby);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
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
  
	function get_group_by_teachercode_and_day($teacher_code,$day_code)	{
	/* 
        SELECT assignatura.nom_assignatura, grup.nom_grup, grup.codi_grup,
                   classe.codi_dia, classe.codi_hora, classe.codi_assignatura,
                   interval_horari.hora_inici, interval_horari.hora_final, optativa
        FROM assignatura
                 NATURAL JOIN classe NATURAL JOIN grup 
                 NATURAL JOIN interval_horari
        WHERE classe.codi_professor = '{$VALS['teacher_code']}'
                  AND  classe.codi_dia = '{$VALS['day_of_week']}'
                  ORDER BY classe.codi_hora, grup.nom_grup
	 */
		$this->db->select('assignatura.nom_assignatura, classroom_group.nom_grup, classroom_group.codi_grup,
                   classe.codi_dia, classe.codi_hora, classe.codi_assignatura,
                   interval_horari.hora_inici, interval_horari.hora_final, optativa');
		$this->db->from('assignatura');
		$this->db->join('classe', 'barcode.barcodeId = externalIDType.barcodeId','inner');
		$this->db->join('classroom_group', 'barcode.barcodeId = externalIDType.barcodeId','inner');
		$this->db->join('interval_horari', 'barcode.barcodeId = externalIDType.barcodeId','inner');
		$this->db->where('classe.codi_professor',$teacher_code);
		$this->db->where('classe.codi_dia',$day_code);
		$this->db->order_by('classe.codi_hora', 'asc');
		$this->db->order_by('classroom_group.nom_grup', 'asc'); 
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}

	function getAllTeachersFromClassgroupId ( $class_group_id ) {
		/*
		SELECT DISTINCT `lesson_teacher_id`, `person_givenName`, `person_sn1`, `person_sn2`
		FROM `lesson` 
		INNER JOIN teacher 
		ON lesson.lesson_teacher_id = teacher.`teacher_id`
		INNER JOIN person
		ON teacher.teacher_id = person.`person_id`
		WHERE `lesson_classroom_group_id`=25
		*/

		$this->db->select('lesson_teacher_id, person_givenName, person_sn1, person_sn2');
		$this->db->from('lesson');
		$this->db->join('teacher', 'teacher.teacher_id = lesson.lesson_teacher_id');
		$this->db->join('person', 'teacher.teacher_id = person.person_id');
		
		//$this->db->order_by('time_slot_order', $orderby);
		
		$this->db->where("lesson.lesson_classroom_group_id", $class_group_id);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)	{
			
			$group_teachers = array();

			foreach ($query->result_array() as $row)	{

				$teacher = new stdClass();
				$teacher->id = $row['lesson_teacher_id'];
				$teacher->givenName = $row['person_givenName'];
				$teacher->sn1 = $row['person_sn1'];
				$teacher->sn2 = $row['person_sn2'];
				
   				$group_teachers[$row['lesson_teacher_id']] = $teacher;

			}
			return $group_teachers;
		}
		else
			return false;
	} 

	function getTutorFromClassgroupId ( $class_group_id ) {
		/*
		SELECT `classroom_group_mentorId`,`person_givenName`, `person_sn1`, `person_sn2`
		FROM `classroom_group` 
		INNER JOIN teacher 
		ON classroom_group.classroom_group_mentorId = teacher.`teacher_id`
		INNER JOIN person
		ON teacher.teacher_id = person.`person_id`
		WHERE `classroom_group_id`=25
		*/

		$this->db->select('teacher.teacher_id,classroom_group_mentorId, person_givenName, person_sn1, person_sn2');
		$this->db->from('classroom_group');
		$this->db->join('teacher', 'teacher.teacher_id = classroom_group.classroom_group_mentorId');
		$this->db->join('person', 'teacher.teacher_id = person.person_id');
		
		//$this->db->order_by('time_slot_order', $orderby);
		
		$this->db->where("classroom_group.classroom_group_id", $class_group_id);
		$this->db->distinct();

		$query = $this->db->get();
		//echo $this->db->last_query() ."<br/>";
		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			return $row->teacher_id;
		}
		else
			return "";
	} 

	function getAllGroupStudymodules ( $class_group_id, $orderby = "ASC" ) {

		/*
		SELECT DISTINCT `lesson_study_module_id` , `study_module_external_code` , `study_module_shortname` , `study_module_name`
		FROM `lesson`
		INNER JOIN study_module ON `lesson`.`lesson_study_module_id` = study_module.`study_module_id`
		WHERE `lesson_classroom_group_id` =26
		ORDER BY study_module_order,`study_module_shortname`
		*/

		$this->db->select('lesson_study_module_id,study_module_id,study_module_external_code,study_module_shortname,study_module_name');
		$this->db->from('lesson');
		$this->db->join('study_module', "lesson.lesson_study_module_id = study_module.study_module_id");
		
	/*	$this->db->order_by('study_module_order', $orderby); */
		$this->db->order_by('study_module_shortname', $orderby);
		
		$this->db->where("lesson.lesson_classroom_group_id", $class_group_id);
		
		$this->db->distinct();
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)	{
			
			$study_modules = array();

			foreach ($query->result_array() as $row)	{

				$study_module = new stdClass();
				$study_module->id = $row['study_module_id'];
				$study_module->shortname = $row['study_module_shortname'];				
				$study_module->name = $row['study_module_name'];
				$study_module->code = $row['study_module_external_code'];
				
   				$study_modules[$row['study_module_id']] = $study_module;

			}
			return $study_modules;
		}
		else
			return false;

	}

	function getAllTeacherStudymodules ( $teacher_id , $orderby = "ASC") {
		/*
		SELECT DISTINCT `lesson_study_module_id` , `study_module_external_code` , `study_module_shortname` , `study_module_name`
		FROM `lesson`
		INNER JOIN study_module ON `lesson`.`lesson_study_module_id` = study_module.`study_module_id`
		WHERE `lesson_teacher_id` = 39
		ORDER BY study_module_order,`study_module_shortname`
		*/

		$this->db->select('lesson_study_module_id,study_module_id,study_module_external_code,study_module_shortname,study_module_name');
		$this->db->from('lesson');
		$this->db->join('study_module', "lesson.lesson_study_module_id = study_module.study_module_id");
		
	/*	$this->db->order_by('study_module_order', $orderby); */
		$this->db->order_by('study_module_shortname', $orderby);
		
		$this->db->where("lesson.lesson_teacher_id", $teacher_id);

		$this->db->distinct();		
		$query = $this->db->get();

		//echo $this->db->last_query();
		
		if ($query->num_rows() > 0)	{
			
			$study_modules = array();

			foreach ($query->result_array() as $row)	{

				$study_module = new stdClass();
				$study_module->id = $row['study_module_id'];
				$study_module->shortname = $row['study_module_shortname'];				
				$study_module->name = $row['study_module_name'];
				$study_module->code = $row['study_module_external_code'];
				
   				$study_modules[$row['study_module_id']] = $study_module;

			}
			return $study_modules;
		}
		else
			return false;

	}

}
