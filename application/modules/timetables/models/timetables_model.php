<?php
/**
 * timetables_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergiturbadenas@gmail.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class timetables_model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();

        /* Set language */
        $current_language=$this->session->userdata("current_language");
        if ($current_language == "") {
            $current_language= $this->config->item('default_language','skeleton_auth');
        }
        
        $this->lang->load('timetables', $current_language);
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

	function get_all_groups_byteacherid($teacher_id, $orderby = "asc", $academic_period_id=null) {

        if ($academic_period_id==null) {
            $academic_period_id = $this->get_current_academic_period_id();
        }

		/*
		SELECT DISTINCT group_code,group_shortName,group_name
		FROM `lesson` 
		INNER JOIN classroom_group ON `lesson`.`lesson_classroom_group_id`  = classroom_group.classroom_group_id
		WHERE lesson_teacher_id=39
		*/

		$this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name');
		$this->db->distinct();
		$this->db->from('lesson');
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id');

		$this->db->where('lesson.lesson_teacher_id',$teacher_id);
		$this->db->where('lesson.lesson_academic_period_id',$academic_period_id);
		
		$this->db->order_by('classroom_group_code', $orderby);
        
        $query = $this->db->get();
		
		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return false;

		
	}
//
function get_all_group_by_study_module($study_module,$teacher_id) {

/*
SELECT DISTINCT classroom_group_code, lesson_teacher_id,lesson_study_module_id FROM lesson 
JOIN classroom_group ON classroom_group.classroom_group_id = lesson.lesson_classroom_group_id WHERE lesson_teacher_id = 30
*/

        $this->db->select('classroom_group_code, lesson_teacher_id,lesson_study_module_id');
		$this->db->distinct();
		$this->db->from('lesson');
        $this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id');
		$this->db->where('lesson_study_module_id',$study_module);
		$this->db->where('lesson_teacher_id',$teacher_id);

/*
        $this->db->select('study_module_id,classroom_group_code');
		$this->db->distinct();
		$this->db->from('lesson');
        $this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id');
        $this->db->join('study_module', 'study_module.study_module_id = lesson.lesson_study_module_id');
		$this->db->where('lesson_study_module_id',$study_module);
		$this->db->where('lesson_teacher_id',$teacher_id);
 */       
        $query = $this->db->get();
        //echo $this->db->last_query()."<br />";		
		foreach ($query->result() as $row)
		{
			if($row->classroom_group_code)
    			return $row->classroom_group_code;
    		else
    			return false;
		}
		//if ($query->num_rows() > 0) {
		//	return $query;
		//}			
		//else
		//	return false;

}	

	function get_teachers_study_modules_list($classroom_group_id) {

		$current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT DISTINCT `lesson_teacher_id`,`lesson_study_module_id`
		FROM lesson
		INNER JOIN teacher ON teacher.teacher_id = lesson.lesson_teacher_id
		INNER JOIN teacher_academic_periods ON  teacher_academic_periods.`teacher_academic_periods_teacher_id` = teacher.teacher_id
		INNER JOIN person ON person.person_id = teacher.teacher_person_id
		WHERE `lesson_classroom_group_id`=1 AND `teacher_academic_periods_academic_period_id`=5 
		ORDER BY `lesson_teacher_id`,`lesson_study_module_id`
		*/

		$this->db->select('lesson_teacher_id,lesson_study_module_id, study_module_shortname, study_module_name');
		$this->db->distinct();
		$this->db->from('lesson');        
        $this->db->join('teacher','teacher.teacher_id = lesson.lesson_teacher_id');
        $this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');
        $this->db->join('person','person.person_id = teacher.teacher_person_id');
        $this->db->join('study_module', 'study_module.study_module_id = lesson_study_module_id');

		$this->db->where('lesson_classroom_group_id',$classroom_group_id);
		$this->db->where('teacher_academic_periods_academic_period_id',$current_academic_period_id);

		$this->db->order_by('lesson_teacher_id, study_module_shortname','ASC');
        
        $query = $this->db->get();	

        if ($query->num_rows() > 0) {

			$teachers_study_modules_list = array();

			foreach ($query->result_array() as $row)	{	
				$study_module = new stdClass();

				$study_module->id = $row["lesson_study_module_id"];
				$study_module->shortName = $row["study_module_shortname"];
				$study_module->name = $row["study_module_name"];

				$teachers_study_modules_list[$row["lesson_teacher_id"]]->studymodules[] = $study_module;
			}

			return $teachers_study_modules_list;

		}

		return false;

	}

	function get_teachers_list($classroom_group_id) {

		$current_academic_period_id = $this->get_current_academic_period_id();

		$teachers_study_modules_list = $this->get_teachers_study_modules_list($classroom_group_id);

		/*
		SELECT DISTINCT `lesson_teacher_id`,`teacher_person_id`, `teacher_academic_periods_code`, person.person_sn1, person.person_sn2,person.person_givenName
		FROM lesson
		INNER JOIN teacher ON teacher.teacher_id = lesson.lesson_teacher_id
		INNER JOIN  teacher_academic_periods ON  teacher_academic_periods.`teacher_academic_periods_teacher_id` = teacher.teacher_id
		INNER JOIN person ON person.person_id = teacher.teacher_person_id
		WHERE `lesson_classroom_group_id`=1 AND `teacher_academic_periods_academic_period_id`=5
		*/

		$this->db->select('lesson_teacher_id, teacher_person_id, teacher_academic_periods_code, person.person_sn1, person.person_sn2,person.person_givenName');
		$this->db->distinct();
		$this->db->from('lesson');        
        $this->db->join('teacher','teacher.teacher_id = lesson.lesson_teacher_id');
        $this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');
        $this->db->join('person','person.person_id = teacher.teacher_person_id');

		$this->db->where('lesson_classroom_group_id',$classroom_group_id);
		$this->db->where('teacher_academic_periods_academic_period_id',$current_academic_period_id);
		$this->db->where('lesson_academic_period_id',$current_academic_period_id);
        
        $query = $this->db->get();	
     	//echo $this->db->last_query();

        if ($query->num_rows() > 0) {

			$teachers_list = array();

			foreach ($query->result_array() as $row)	{	
				$teacher = new stdClass();

				$teacher->id = $row['lesson_teacher_id'];
				$teacher->sn1 = $row['person_sn1'];
				$teacher->sn2 = $row['person_sn2'];
				$teacher->givenName = $row['person_givenName'];
				$teacher->code = $row['teacher_academic_periods_code'];

				$study_modules = "";

				
				if (array_key_exists($teacher->id,$teachers_study_modules_list)) {
					$i=1;
					foreach ( $teachers_study_modules_list[$teacher->id]->studymodules as $study_module ) {
						$study_modules = $study_modules . $study_module->shortName;
						if ($i < count( $teachers_study_modules_list[$teacher->id]->studymodules )) {
							$study_modules = $study_modules . ", "; 	
						}
						$i++;
					}	
				}
				

				$teacher->study_modules = $study_modules;

				$teachers_list[$teacher->id]=$teacher;
			}

			return $teachers_list;

		}

		return false;

	}
	

	function get_mentor( $classroom_group_id ) {

		$current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT `classroom_group_academic_periods_mentorId`,person_sn1,person_sn2,person_givenName, `teacher_academic_periods_code`
		FROM `classroom_group` 
		INNER JOIN classroom_group_academic_periods ON classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id = `classroom_group`.`classroom_group_id`
		INNER JOIN teacher ON teacher.teacher_id = classroom_group_academic_periods_mentorId
		INNER JOIN teacher_academic_periods ON teacher_academic_periods.`teacher_academic_periods_teacher_id` = teacher.teacher_id
		INNER JOIN person ON person.person_id = teacher.teacher_person_id
		WHERE `classroom_group_academic_periods_classroom_group_id`=10 AND `classroom_group_academic_periods_academic_period_id`= 5
		*/

		$this->db->select('classroom_group_academic_periods_mentorId, person_sn1, person_sn2, person_givenName, teacher_academic_periods_code, teacher_id');
		$this->db->from('classroom_group');        
        $this->db->join('classroom_group_academic_periods','classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id = classroom_group.classroom_group_id');
        $this->db->join('teacher','teacher.teacher_id = classroom_group_academic_periods_mentorId');
        $this->db->join('teacher_academic_periods','teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');
        $this->db->join('person','person.person_id = teacher.teacher_person_id');

		$this->db->where('classroom_group_academic_periods_classroom_group_id',$classroom_group_id);
		$this->db->where('classroom_group_academic_periods_academic_period_id',$current_academic_period_id);
		$this->db->limit(1);
        
        $query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			$row = $query->row();
			$teacher = new stdClass();

			$teacher->id = $row->teacher_id;
			$teacher->code = $row->teacher_academic_periods_code;
			$teacher->sn1 = $row->person_sn1;
			$teacher->sn2 = $row->person_sn2;
			$teacher->givenName = $row->person_givenName;

			return $teacher;
		}

		return false;
	}


	//
	function get_all_group_study_modules($classroom_group_id) {
		
		/*
		SELECT DISTINCT `study_module_id`, `study_module_shortname`, `study_module_name`, `study_module_hoursPerWeek` 
		FROM (`study_module`) 
		JOIN `study_module_academic_periods` ON `study_module_academic_periods`.`study_module_academic_periods_study_module_id` = `study_module`.`study_module_id` 
		JOIN `study_module_ap_courses` ON `study_module_ap_courses`.`study_module_ap_courses_study_module_ap_id` = `study_module_academic_periods`.`study_module_academic_periods_id` 
		JOIN `course` ON `course`.`course_id` = `study_module_ap_courses`.`study_module_ap_courses_course_id` 
		JOIN `classroom_group` ON `course`.`course_id` = `classroom_group`.`classroom_group_course_id` 
		WHERE `classroom_group_id` = '13' AND `study_module_academic_periods_academic_period_id` = '5' 
		ORDER BY `study_module_shortname` asc 
		*/

		$current_academic_period_id = $this->get_current_academic_period_id();


        $this->db->select('study_module_id,study_module_shortname,study_module_name,study_module_hoursPerWeek');
		$this->db->from('study_module');
		$this->db->distinct();
		$this->db->join('study_module_academic_periods','study_module_academic_periods.study_module_academic_periods_study_module_id = study_module.study_module_id');		
		$this->db->join('study_module_ap_courses','study_module_ap_courses.study_module_ap_courses_study_module_ap_id =  study_module_academic_periods.study_module_academic_periods_id');
		$this->db->join('course','course.course_id = study_module_ap_courses.study_module_ap_courses_course_id');
		$this->db->join('classroom_group','course.course_id = classroom_group.classroom_group_course_id');
		$this->db->where('classroom_group_id',$classroom_group_id);
		$this->db->where('study_module_academic_periods_academic_period_id',$current_academic_period_id);		
		$this->db->order_by('study_module_shortname', "asc");
        
        $query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {
			return $query;
		}			
		else
			return false;
	}

	function get_all_teacher_study_modules($teacher_id,$academic_period_id = null) {

        if ($academic_period_id == null) {
            $academic_period_id = $this->get_current_academic_period_id();
        }

		/*
		SELECT DISTINCT `classroom_group_code`, `study_module_id`, `study_module_shortname`, `study_module_name`, `study_module_hoursPerWeek` 
		FROM (`lesson`) 
		LEFT JOIN `study_module` ON `lesson`.`lesson_study_module_id` = `study_module`.`study_module_id` 
		LEFT JOIN `classroom_group` ON `lesson`.`lesson_classroom_group_id` = `classroom_group`.`classroom_group_id` 
		WHERE `lesson_teacher_id`=127

		*/
        $this->db->select('classroom_group_code,study_module_id,study_module_shortname,study_module_name,study_module_hoursPerWeek');
		$this->db->from('lesson');
		$this->db->distinct();
		$this->db->join('study_module', 'lesson.lesson_study_module_id = study_module.study_module_id','left');
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id','left');
		$this->db->where('lesson_teacher_id',$teacher_id);
		$this->db->where('lesson_academic_period_id', $academic_period_id);

        $query = $this->db->get();
		//	echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query;
		}			
		else
			return false;
	}

	function get_all_lessonsfortimetablebygroupid($classroom_group_id,$academic_period_id = null)	{
		/*
		SELECT `lesson_id`, `lesson_teacher_id`, `teacher_academic_periods_code`, `lesson_code`, `lesson_day`, `time_slot_start_time`, 
		       `time_slot_order`, `study_module_id`, `study_module_shortname`, `study_module_name`, `lesson_classroom_group_id`, `classroom_group_code`, 
		       `classroom_group_shortName`, `classroom_group_name`, `lesson_location_id`, `location_shortName` 
		FROM (`lesson`) 
		JOIN `time_slot` ON `lesson`.`lesson_time_slot_id` = `time_slot`.`time_slot_id` 
		LEFT JOIN `study_module` ON `lesson`.`lesson_study_module_id` = `study_module`.`study_module_id` 
		LEFT JOIN `classroom_group` ON `lesson`.`lesson_classroom_group_id` = `classroom_group`.`classroom_group_id` 
		LEFT JOIN `location` ON `location`.`location_id` = `lesson`.`lesson_location_id` 
		JOIN `teacher_academic_periods` ON `teacher_academic_periods`.`teacher_academic_periods_teacher_id` = `lesson`.`lesson_teacher_id` 
		WHERE `lesson`.`lesson_classroom_group_id` = 25 AND `lesson`.`lesson_academic_period_id` = '5' AND `teacher_academic_periods`.`teacher_academic_periods_academic_period_id` = '5' 
		ORDER BY `lesson_day`, `time_slot_order` asc 
		*/

        if ( $academic_period_id == null ) {
            $academic_period_id = $this->get_current_academic_period_id();
        }

		$this->db->from('lesson');
        $this->db->select('lesson_id,lesson_teacher_id,teacher_academic_periods_code,lesson_code,lesson_day,time_slot_start_time,time_slot_order,study_module_id,study_module_shortname,study_module_name,
        	lesson_classroom_group_id, classroom_group_code,classroom_group_shortName,classroom_group_name,lesson_location_id,location_shortName');

		$this->db->order_by('lesson_day,time_slot_order', "asc");
		
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');
		$this->db->join('study_module', 'lesson.lesson_study_module_id = study_module.study_module_id','left');
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id','left');
		$this->db->join('location', 'location.location_id = lesson.lesson_location_id','left');
		$this->db->join('teacher_academic_periods', 'teacher_academic_periods.teacher_academic_periods_teacher_id = lesson.lesson_teacher_id');

		$this->db->where('lesson.lesson_classroom_group_id',$classroom_group_id);
		$this->db->where('lesson.lesson_academic_period_id',$academic_period_id);
		$this->db->where('teacher_academic_periods.teacher_academic_periods_academic_period_id',$academic_period_id);
        
        $query = $this->db->get();

      	//echo $this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$all_lessonsfortimetablebygroupid = array();

			$previous_day = null;
			$real_previous_time_slot_start_time = null;

			$previous_lesson_code = null;

			$counter_i = 1;
			foreach ($query->result_array() as $row)	{

				//echo "<br/>counter i: " . $counter_i . "<br/>";
				
				$day=$row['lesson_day'];
				$time_slot_start_time = $row['time_slot_start_time'];
				$lesson_id = $row['lesson_id'];
				$lesson_teacher_id = $row['lesson_teacher_id'];
				$lesson_teacher_code = $row['teacher_academic_periods_code'];				
				$lesson_code = $row['lesson_code'];
				$time_slot_order = $row['time_slot_order'];
				$study_module_id = $row['study_module_id'];
				$study_module_shortname = $row['study_module_shortname'];
				$study_module_name = $row['study_module_name'];
				$group_id = $row['lesson_classroom_group_id'];
				$group_code = $row['classroom_group_code'];
				$group_shortName = $row['classroom_group_shortName'];
				$group_name = $row['classroom_group_name'];
				$location_shortname = $row['location_shortName'];
				$location_id = $row['lesson_location_id'];

				$not_new_day=true;
				if ($previous_day == null || $day != $previous_day) {
					$day_lessons = new stdClass;	
					$lesson_by_day = array();
					$not_new_day=false;
				}

				//echo "<br/>day: " . $day . " | time_slot_start_time: " . $time_slot_start_time . " | lesson_id: " . $lesson_id . " | teacher: " . $lesson_teacher_id 
				//. " | lesson_code: " . $lesson_code . " | time_slot_order: " . $time_slot_order . " | study_module_shortname: " . $study_module_shortname ."<br/>" ; 

				//DETECT LESSONS DONE BY MULTIPLE TEACHERS

				//DOUBLED LESSONS ARE PER TEACHER IN GROUP TIMETABLES: Múltiple teachers at same day and time_slot doubling a group : DESDOBLAMENT
				$not_doubled_lesson=true;
				if ( ($day == $previous_day) && ($time_slot_start_time == $real_previous_time_slot_start_time) ) {
					if ($lesson_teacher_id == $previous_lesson_teacher_id) {
						echo "ALERT DUPLICATED LESSON! Lesson _info:<br/>";
						echo "<br/>day: " . $day . " | time_slot_start_time: " . $time_slot_start_time . " | lesson_id: " . $lesson_id . " | teacher: " . $lesson_teacher_id 
						. " | lesson_code: " . $lesson_code . " | time_slot_order: " . $time_slot_order . " | study_module_shortname: " . $study_module_shortname ."<br/>" ; 
						$not_doubled_lesson=false;
					} else {
						//DOUBLED LESSON:
						$not_doubled_lesson=false;
					}
					
				}

				//detect consecutive lessons and aggrupate in on event with more duration 
				if ( (($time_slot_start_time -1) == $real_previous_time_slot_start_time) &&  $previous_lesson_code == $lesson_code && $this->is_time_slot_lective_by_time_slot_order($time_slot_order-1) && $not_new_day && $not_doubled_lesson  ) {
					//Change previous lesson duration (++) and skip this one
					$all_lessonsfortimetablebygroupid[$day]->lesson_by_day[$previous_time_slot_start_time]->duration++;
					$previous_time_slot_start_time = $previous_time_slot_start_time;
					if ( ! array_key_exists ( $location_id , $all_lessonsfortimetablebygroupid[$day]->lesson_by_day[$previous_time_slot_start_time]->locations ) ) {
						$new_location = new stdClass();
						$new_location->code=$location_shortname;
						$new_location->id=$location_id;
						
						$lesson_data->locations[$new_location->id]=$new_location;	
					}
					if ( ! array_key_exists ( $study_module_id , $all_lessonsfortimetablebygroupid[$day]->lesson_by_day[$previous_time_slot_start_time]->study_modules ) ) {
						$new_study_module = new stdClass();
						$new_study_module->id = $study_module_id;
						$new_study_module->shortname = $study_module_shortname;
						$new_study_module->name = $study_module_name;						
						
						$all_lessonsfortimetablebygroupid[$day]->lesson_by_day[$previous_time_slot_start_time]->study_modules[$new_study_module->id]=$new_study_module;	
					}
					if ( ! array_key_exists ( $lesson_teacher_id , $all_lessonsfortimetablebygroupid[$day]->lesson_by_day[$previous_time_slot_start_time]->teachers ) ) {
						$new_teacher = new stdClass();
						$new_teacher->id = $lesson_teacher_id;
						$new_teacher->code = $lesson_teacher_code;
						
						$all_lessonsfortimetablebygroupid[$day]->lesson_by_day[$previous_time_slot_start_time]->teachers[$new_teacher->id]=$new_teacher;	
					}
				} else {
					if ($not_doubled_lesson) {
						$lesson_data = new stdClass;

						$lesson_data->lesson_id= $lesson_id;
						$lesson_data->lesson_code= $lesson_code;
						$lesson_data->time_slot_order= $time_slot_order;

						$new_study_module = new stdClass();
						$new_study_module->id = $study_module_id;
						$new_study_module->shortname = $study_module_shortname;
						$new_study_module->name = $study_module_name;						
						$lesson_data->study_modules[$new_study_module->id]=$new_study_module;

						$lesson_data->group_code= $group_code;
						$lesson_data->group_id= $group_id;
						$lesson_data->group_shortName= $group_shortName;
						$lesson_data->group_name= $group_name;
						$lesson_data->time_slot_lective=true;

						$new_teacher = new stdClass();
						$new_teacher->id = $lesson_teacher_id;
						$new_teacher->code = $lesson_teacher_code;						
						$lesson_data->teachers[$new_teacher->id]=$new_teacher;

						$lesson_data->locations=array();
						if ($location_shortname != null) {
							$new_location = new stdClass();
							$new_location->code=$location_shortname;
							$new_location->id=$location_id;
							$lesson_data->locations[$new_location->id]=$new_location;
						} 
						
						$lesson_data->duration= 1;

						$lesson_by_day[$time_slot_start_time] = $lesson_data;

									
						$day_lessons->lesson_by_day = $lesson_by_day;

	   					$all_lessonsfortimetablebygroupid[$day] = $day_lessons;	
	   					$previous_time_slot_start_time = $time_slot_start_time;

					} else {
						/*echo "ALERT DUPLICATED LESSON! Lesson _info:<br/>";
						echo "<br/>day: " . $day . " | time_slot_start_time: " . $time_slot_start_time . " | lesson_id: " . $lesson_id . " | teacher: " . $lesson_teacher_id 
						. " | lesson_code: " . $lesson_code . " | time_slot_order: " . $time_slot_order . " | study_module_shortname: " . $study_module_shortname .
						" | location: " . $location_id . " | location_shortname: " . $location_shortname  ."<br/>";*/
						if ( ! array_key_exists ( $study_module_id , $all_lessonsfortimetablebygroupid[$day]->lesson_by_day[$previous_time_slot_start_time]->study_modules ) ) {
							$new_study_module = new stdClass();
							$new_study_module->id = $study_module_id;
							$new_study_module->shortname = $study_module_shortname;
							$new_study_module->name = $study_module_name;						
							
							$all_lessonsfortimetablebygroupid[$day]->lesson_by_day[$previous_time_slot_start_time]->study_modules[$new_study_module->id]=$new_study_module;	
						}
						if ( ! array_key_exists ( $lesson_teacher_id , $all_lessonsfortimetablebygroupid[$day]->lesson_by_day[$previous_time_slot_start_time]->teachers ) ) {
							$new_teacher = new stdClass();
							$new_teacher->id = $lesson_teacher_id;
							$new_teacher->code = $lesson_teacher_code;
							
							$all_lessonsfortimetablebygroupid[$day]->lesson_by_day[$previous_time_slot_start_time]->teachers[$new_teacher->id]=$new_teacher;	
						}
						if ( ! array_key_exists ( $location_id , $all_lessonsfortimetablebygroupid[$day]->lesson_by_day[$previous_time_slot_start_time]->locations ) ) {
							$new_location = new stdClass();
							$new_location->code=$location_shortname;
							$new_location->id=$location_id;
							
							$lesson_data->locations[$new_location->id]=$new_location;	
						}
						$previous_time_slot_start_time = $previous_time_slot_start_time;
					}
   				}

   				$real_previous_time_slot_start_time = $time_slot_start_time;
   				
   				$previous_day=$day;
   				$previous_lesson_teacher_id = $lesson_teacher_id;
   				$previous_lesson_code = $lesson_code;
   				$counter_i++;
   			}

   			return $all_lessonsfortimetablebygroupid;

		}			
		else
			return false;

	}

	function is_time_slot_lective_by_time_slot_order( $time_slot_order ) {
		$this->db->from('time_slot');
        $this->db->select('time_slot_lective');

		$this->db->where('time_slot.time_slot_order',$time_slot_order);
        
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			if ($row->time_slot_lective == 1)
				return true;
			else
				return false;
		}

		return false;
	}


	function get_all_lessonsfortimetablebyteacherid($teacher_id,$academic_period_id=null) {

        if ($academic_period_id == null) {
            $academic_period_id = $this->get_current_academic_period_id();
        }

		/*
		SELECT `lesson_id`, `lesson_code`, `lesson_day`, `lesson_time_slot_id`, `time_slot_start_time`, `time_slot_order`, `study_module_id`, 
		`study_module_shortname`, `study_module_name`, `classroom_group_code`, `classroom_group_shortName`, `classroom_group_name` 
		FROM (`lesson`) 
		JOIN `teacher` ON `lesson`.`lesson_teacher_id` = `teacher`.`teacher_id` 
		JOIN `time_slot` ON `lesson`.`lesson_time_slot_id` = `time_slot`.`time_slot_id` 
		LEFT JOIN `study_module` ON `lesson`.`lesson_study_module_id` = `study_module`.`study_module_id` 
		LEFT JOIN `classroom_group` ON `lesson`.`lesson_classroom_group_id` = `classroom_group`.`classroom_group_id` 
		WHERE `teacher`.`teacher_id` = '89' ORDER BY `lesson_day`, `time_slot_order` asc 
		*/

		$this->db->from('lesson');
        $this->db->select('lesson_id, lesson_teacher_id, lesson_code, lesson_day, lesson_time_slot_id, time_slot_start_time, time_slot_order, study_module_id, study_module_shortname, study_module_name,
        	lesson_classroom_group_id,classroom_group_code, classroom_group_shortName, classroom_group_name, lesson_location_id,location_shortName');
		$this->db->order_by('lesson_day,time_slot_order', "asc");
		
		$this->db->join('teacher', 'lesson.lesson_teacher_id = teacher.teacher_id');
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');
		$this->db->join('study_module', 'lesson.lesson_study_module_id = study_module.study_module_id','left');
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id','left');
		$this->db->join('location', 'location.location_id = lesson.lesson_location_id','left');

		$this->db->where('teacher.teacher_id',$teacher_id);
		$this->db->where('lesson.lesson_academic_period_id',$academic_period_id);
		 	
        
        $query = $this->db->get();

        //echo $this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$all_lessonsfortimetablebyteacherid = array();

			$previous_day = null;
			$real_previous_time_slot_start_time = null;

			$previous_lesson_code = null;

			$counter_i=1;
			foreach ($query->result_array() as $row)	{

				$day=$row['lesson_day'];

				$lesson_time_slot_id = $row['lesson_time_slot_id'];
				$time_slot_start_time = $row['time_slot_start_time'];
				$lesson_id = $row['lesson_id'];
				$lesson_teacher_id = $row['lesson_teacher_id'];
				$lesson_code = $row['lesson_code'];
				$time_slot_order = $row['time_slot_order'];
				$study_module_id = $row['study_module_id'];
				$study_module_shortname = $row['study_module_shortname'];
				$study_module_name = $row['study_module_name'];
				$group_id = $row['lesson_classroom_group_id'];
				$group_code = $row['classroom_group_code'];
				$group_shortName = $row['classroom_group_shortName'];
				$group_name = $row['classroom_group_name'];

				$location_shortname = $row['location_shortName'];
				$location_id = $row['lesson_location_id'];
			
				$is_not_new_day=true;
				if ($previous_day == null || $day != $previous_day) {
					//NEW DAY
					$is_not_new_day=false;
					$day_lessons = new stdClass;	
					$lesson_by_day = array();
				}

				//echo "<br/>day: " . $day . " | time_slot_start_time: " . $time_slot_start_time . " | lesson_id: " . $lesson_id . " | teacher: " . $lesson_teacher_id 
				//. " | lesson_code: " . $lesson_code . " | time_slot_order: " . $time_slot_order . " | study_module_shortname: " . $study_module_shortname ."<br/>" ; 

				//DETECT LESSONS DONE BY MULTIPLE TEACHERS

				//DOUBLED LESSONS ARE PER GROUP IN TEACHERS TIMETABLES: Same teacher at same day and time_slot is doing a lesson for students of multiple groups!
				$not_doubled_lesson=true;
				if ( ($day == $previous_day) && ($time_slot_start_time == $real_previous_time_slot_start_time) ) {
					if ($group_id == $previous_group_id) {
						echo "ALERT DUPLICATED LESSON! Lesson _info:<br/>";
						echo "<br/>day: " . $day . " | time_slot_start_time: " . $time_slot_start_time . " | lesson_id: " . $lesson_id . " | teacher: " . $lesson_teacher_id 
						. " | lesson_code: " . $lesson_code . " | time_slot_order: " . $time_slot_order . " | study_module_shortname: " . $study_module_shortname ."<br/>" ; 
						$not_doubled_lesson=false;
					} else {
						//DOUBLED LESSON:
						$not_doubled_lesson=false;
					}
				}

				//detect consecutive lessons and aggrupate in on event with more duration. Consecutive lesson: same lesson && time slots consecutive
				if ( (($time_slot_start_time -1) == $real_previous_time_slot_start_time) && ($previous_lesson_code == $lesson_code) && $this->is_time_slot_lective_by_time_slot_order($time_slot_order-1) && $is_not_new_day && $not_doubled_lesson ) {
					//Change previous lesson duration (++) and skip this one
					$all_lessonsfortimetablebyteacherid[$day]->lesson_by_day[$previous_time_slot_start_time]->duration++;
					$previous_time_slot_start_time = $previous_time_slot_start_time;
					if ( ! array_key_exists ( $location_id , $all_lessonsfortimetablebyteacherid[$day]->lesson_by_day[$previous_time_slot_start_time]->locations ) ) {
						$new_location = new stdClass();
						$new_location->code=$location_shortname;
						$new_location->id=$location_id;
						
						$lesson_data->locations[$new_location->id]=$new_location;	
					}
				} else {
					if ($not_doubled_lesson) {
						$lesson_data = new stdClass;

						$lesson_data->lesson_id= $lesson_id;
						$lesson_data->lesson_code= $lesson_code;
						$lesson_data->time_slot_order= $time_slot_order;
						$lesson_data->study_module_id= $study_module_id;
						$lesson_data->study_module_shortname= $study_module_shortname;
						$lesson_data->study_module_shortname= $study_module_shortname;
						$lesson_data->study_module_name= $study_module_name;
						
						$lesson_data->time_slot_lective=true;
	
						/* a doubled lesson could have múltiple groups: Next lines are obsolet!
						$lesson_data->group_id= $group_id;
						$lesson_data->group_code= $group_code;
						$lesson_data->group_shortName= $group_shortName;
						$lesson_data->group_name= $group_name;
						*/

						$new_group = new stdClass();

						$new_group->group_id = $group_id;
						$new_group->group_code = $group_code;
						$new_group->group_shortName = $group_shortName;
						$new_group->group_name = $group_name;

						$lesson_data->groups[$new_group->group_id]=$new_group;				

						$lesson_data->locations=array();
						if ($location_shortname != null) {
							$new_location = new stdClass();
							$new_location->code=$location_shortname;
							$new_location->id=$location_id;
							$lesson_data->locations[$new_location->id]=$new_location;
						}
						
						$lesson_data->duration= 1;

						$lesson_by_day[$time_slot_start_time] = $lesson_data;

									
						$day_lessons->lesson_by_day = $lesson_by_day;

	   					$all_lessonsfortimetablebyteacherid[$day] = $day_lessons;
	   					$previous_time_slot_start_time = $time_slot_start_time;
	   					
	   					//TODO REMOVE
	   					//$previous_lesson_time_slot_id = $lesson_time_slot_id;
					} else {

						if ( ! array_key_exists ( $group_id , $all_lessonsfortimetablebyteacherid[$day]->lesson_by_day[$previous_time_slot_start_time]->groups ) ) {
							$new_group = new stdClass();

							$new_group->group_id = $group_id;
							$new_group->group_code = $group_code;
							$new_group->group_shortName = $group_shortName;
							$new_group->group_name = $group_name;

							$all_lessonsfortimetablebyteacherid[$day]->lesson_by_day[$previous_time_slot_start_time]->groups[$new_group->group_id]=$new_group;
						}

						if ( ! array_key_exists ( $location_id , $all_lessonsfortimetablebyteacherid[$day]->lesson_by_day[$previous_time_slot_start_time]->locations ) ) {
							$new_location = new stdClass();
							$new_location->code=$location_shortname;
							$new_location->id=$location_id;
							
							$lesson_data->locations[$new_location->id]=$new_location;	
						}
						
						$previous_time_slot_start_time = $previous_time_slot_start_time;
					}
	
   				}

   				$real_previous_time_slot_start_time = $time_slot_start_time;

   				$previous_day=$day;
   				$previous_group_id=$group_id;

   				$previous_lesson_code = $lesson_code;
   				$counter_i++;
   			}
			return $all_lessonsfortimetablebyteacherid;
		}			
		else
			return false;


		/*SELECT `lesson_id` , `lesson_code` , `lesson_day` , time_slot.time_slot_start_time, time_slot_order, `lesson_code` , study_module_shortname, study_module_name,group_code, group_shortName,group_name
		FROM `lesson`
		INNER JOIN teacher ON lesson.`lesson_teacher_id` = teacher.teacher_id
		INNER JOIN time_slot ON lesson.lesson_time_slot_id = time_slot.time_slot_id
		LEFT JOIN study_module ON lesson.lesson_study_module_id = study_module.study_module_id
		LEFT JOIN classroom_group ON lesson.lesson_classroom_group_id =  classroom_group.classroom_group_id
		WHERE teacher.teacher_code =41
		ORDER BY `lesson_day`,time_slot_order ASC*/
	}



	function get_all_classroom_groups_ids_and_names($orderby= "asc") {

		$current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT `classroom_group_id`, `classroom_group_code`, `classroom_group_shortName`, `classroom_group_name` 
		ROM (`classroom_group`) 
		JOIN `classroom_group_academic_periods` ON `classroom_group_academic_periods`.`classroom_group_academic_periods_classroom_group_id` = `classroom_group`.`classroom_group_id` 
		WHERE `classroom_group_academic_periods_academic_period_id` = '5' ORDER BY `classroom_group_code` asc
		*/
		$this->db->from('classroom_group');
        $this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name');
        $this->db->join('classroom_group_academic_periods','classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id = classroom_group.classroom_group_id');
        $this->db->where('classroom_group_academic_periods_academic_period_id',$current_academic_period_id);
        $this->db->where('classroom_group_type',1);
        

		$this->db->order_by('classroom_group_code', $orderby);
		
		//$this->db->join('person', 'person.person_id = teacher.teacher_person_id');
        
        $query = $this->db->get();
     	//echo $this->db->last_query();

		
		if ($query->num_rows() > 0) {

			$classroom_groups_array = array();

			foreach ($query->result_array() as $row)	{
   				$classroom_groups_array[$row['classroom_group_id']] = $row['classroom_group_code'] . " - " . $row['classroom_group_name'] . " ( " . $row['classroom_group_shortName'] . ") - " . $row['classroom_group_id'];
			}
			return $classroom_groups_array;
		}			
		else
			return false;
	}

	function getAllLectiveDays() {
		
		$monday = new stdClass;
        $monday->day_shortname = lang('monday_shortname'); 
        $monday->day_number = 1; 

        $tuesday = new stdClass;
        $tuesday->day_shortname = lang('tuesday_shortname');
        $tuesday->day_number = 2;

        $wednesday = new stdClass;
        $wednesday->day_shortname = lang('wednesday_shortname');
        $wednesday->day_number = 3;

        $thursday = new stdClass;
        $thursday->day_shortname = lang('thursday_shortname');
        $thursday->day_number = 4;

        $friday = new stdClass;
        $friday->day_shortname = lang('friday_shortname');
        $friday->day_number = 5;

        return array ($monday, $tuesday, $wednesday, $thursday, $friday );
    }

    public function get_time_slots_byShift($shift = 1) {   

       	switch ($shift) {
       		//Morning
    		case 1:
	        	return $this->getTimeSlots("asc",1,7);
	        	break;
	       	//Afternoon
    		case 2:
        		return $this->getTimeSlots("asc",9,15);
        		break;
    	} 
    }


	function getAllTimeSlots($orderby="asc") {
		
		$this->db->select('time_slot_id,time_slot_start_time,time_slot_end_time,time_slot_lective,time_slot_order');
		$this->db->from('time_slot');
		$this->db->order_by('time_slot_order', $orderby);

		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}

	function getMinTimeSlotOrderForGroup($classroom_group_id) {

		/*
		SELECT min( time_slot_order )
		FROM `lesson`
		INNER JOIN classroom_group ON classroom_group.classroom_group_id = `lesson`.lesson_classroom_group_id
		INNER JOIN time_slot ON time_slot.time_slot_id = `lesson`.lesson_time_slot_id
		WHERE classroom_group.classroom_group_id =25
		*/
	
		$this->db->select_min('time_slot_order','min_time_slot_order');
		$this->db->from('lesson');
		$this->db->join('classroom_group', 'classroom_group.classroom_group_id = lesson.lesson_classroom_group_id');
		$this->db->join('time_slot', 'time_slot.time_slot_id = lesson.lesson_time_slot_id');
		
		$this->db->where('classroom_group.classroom_group_id',$classroom_group_id);

		$query = $this->db->get();

		//echo $this->db->last_query();

		if ($query->num_rows() > 0)	{
			$row = $query->row();
			return $row->min_time_slot_order;
   		}
   		else
			return false;
	}

	function getMaxTimeSlotOrderForGroup($classroom_group_id) {

		$this->db->select_min('time_slot_order','max_time_slot_order');
		$this->db->from('lesson');
		$this->db->join('classroom_group', 'classroom_group.classroom_group_id = lesson.lesson_classroom_group_id');
		$this->db->join('time_slot', 'time_slot.time_slot_id = lesson.lesson_time_slot_id');
		
		$this->db->where('classroom_group.classroom_group_id',$classroom_group_id);

		$query = $this->db->get();

		//echo $this->db->last_query();

		if ($query->num_rows() > 0)	{
			$row = $query->row();
			return $row->max_time_slot_order;
   		}
   		else
			return false;
	}

	function getMaxTimeSlotOrderForTeacher($teacher_id) {
	
		$this->db->select_max('time_slot_order','max_time_slot_order');
		$this->db->from('lesson');
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');
		
		$this->db->where('lesson.lesson_teacher_id',$teacher_id);

		$query = $this->db->get();

		//echo $this->db->last_query() . "<br/>";

		if ($query->num_rows() > 0)	{
			$row = $query->row();
			return $row->max_time_slot_order;
   		}
   		else
			return false;
	}

	function getMinTimeSlotOrderForTeacher($teacher_id) {
	
		$this->db->select_min('time_slot_order','min_time_slot_order');
		$this->db->from('lesson');
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');
		
		$this->db->where('lesson.lesson_teacher_id',$teacher_id);

		$query = $this->db->get();

		//echo $this->db->last_query();

		if ($query->num_rows() > 0)	{
			$row = $query->row();
			return $row->min_time_slot_order;
   		}
   		else
			return false;
	}

	function get_teacher_fullname_from_teacher_id($teacher_id) {
		/*

		*/
		$this->db->select('person_givenName,person_sn1,person_sn2');
		$this->db->from('teacher');

		$this->db->join('person','teacher.teacher_person_id = person.person_id');
		

		$this->db->where('teacher.teacher_id',$teacher_id);


		$query = $this->db->get();
		//echo $this->db->last_query()."<br />";		


		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->person_sn1 .  " " . $row->person_sn2 . ", " . $row->person_givenName;
		}
		else
			return "";
	}

    function get_all_academic_periods($orderby="desc") {
        /*
        SELECT academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current FROM academic_periods WHERE 1
        */
        $this->db->select('academic_periods_id,academic_periods_shortname, academic_periods_name,academic_periods_alt_name,academic_periods_current,academic_periods_initial_date,academic_periods_final_date');
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

                $academic_period->initial_date = $row->academic_periods_initial_date;
                $academic_period->final_date = $row->academic_periods_final_date;

                $all_academic_periods[$academic_period->id] = $academic_period;
            }
            return $all_academic_periods;
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


	function get_teacher_code_from_teacher_id($teacher_id,$academic_period_id=null) {

        if ($academic_period_id == null) {
            $academic_period_id = $this->get_current_academic_period_id();
        }


		/*
		SELECT `teacher_academic_periods_code` 
		FROM `teacher_academic_periods` 
		WHERE `teacher_academic_periods_academic_period_id`=5 AND `teacher_academic_periods_teacher_id`=5
		*/
		$this->db->select('teacher_academic_periods_code');
		$this->db->from('teacher_academic_periods');
		$this->db->where('teacher_academic_periods.teacher_academic_periods_teacher_id',$teacher_id);
		$this->db->where('teacher_academic_periods.teacher_academic_periods_academic_period_id',$academic_period_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->teacher_academic_periods_code;
		}
		else
			return false;
	}


	function get_teacher_id_from_teacher_code($teacher_code) {

		$current_academic_period_id = $this->get_current_academic_period_id();

		/*
		SELECT `teacher_academic_periods_teacher_id` 
		FROM `teacher_academic_periods` 
		WHERE `teacher_academic_periods_academic_period_id`=5 AND `teacher_academic_periods_code`="02"
		*/

		$this->db->select('teacher_academic_periods_teacher_id');
		$this->db->from('teacher_academic_periods');
		$this->db->where('teacher_academic_periods.teacher_academic_periods_code',$teacher_code);
		$this->db->where('teacher_academic_periods.teacher_academic_periods_academic_period_id',$current_academic_period_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->teacher_academic_periods_teacher_id;
		}
		else
			return false;
	}

	function get_teacher_id_from_person_id($person_id) {

		$this->db->select('teacher_id');
		$this->db->from('teacher');
		$this->db->where('teacher_person_id',$person_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->teacher_id;
		}
		else
			return false;
	}

	function get_group_shift($classroom_group_id,$academic_period_id=null) {

        if ($academic_period_id==null) {
            $academic_period_id = $this->get_current_academic_period_id();
        }

		$this->db->select('classroom_group_academic_periods_shift');
		$this->db->from('classroom_group');
		$this->db->join('classroom_group_academic_periods','classroom_group_academic_periods.classroom_group_academic_periods_classroom_group_id = classroom_group.classroom_group_id');
		$this->db->where('classroom_group.classroom_group_id',$classroom_group_id);
        $this->db->where('classroom_group_academic_periods.classroom_group_academic_periods_academic_period_id',$academic_period_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			if ($row->classroom_group_academic_periods_shift!=0)
				return $row->classroom_group_academic_periods_shift;
			else {
				$mintimeslotorder = $this->getMinTimeSlotOrderForGroup($classroom_group_id);
				if ($mintimeslotorder > 6)
					return 2;
				else
					return 1;
			}
		}
		else
			return false;
	}

	function getTimeSlots($orderby="asc",$min_time_slot_order=1,$max_time_slot_order=15) {

		$this->db->select('time_slot_id,time_slot_start_time,time_slot_end_time,time_slot_lective,time_slot_order');
		$this->db->from('time_slot');
		$this->db->order_by('time_slot_order', $orderby);
		
		$this->db->where('time_slot_order >=',$min_time_slot_order);
		$this->db->where('time_slot_order <=',$max_time_slot_order);		

		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}


	function getCompactTimeSlotsForTeacher($teacher_id,$orderby="asc",$min_time_slot_order=1,$max_time_slot_order=15) {

		//if($this->getMinTimeSlotOrderForTeacher($teacher_id)){
		$min_time_slot_order=$this->getMinTimeSlotOrderForTeacher($teacher_id);
		//}

		//if($this->getMinTimeSlotOrderForTeacher($teacher_id)){
		$max_time_slot_order=$this->getMaxTimeSlotOrderForTeacher($teacher_id);
		//}

		//echo "MIN: " . $min_time_slot_order ."<br/>";
		//echo "MAX: " . $max_time_slot_order."<br/>";

		$this->db->select('time_slot_id,time_slot_start_time,time_slot_end_time,time_slot_lective,time_slot_order');
		$this->db->from('time_slot');
		$this->db->order_by('time_slot_order', $orderby);
		
		$this->db->where('time_slot_order >=',$min_time_slot_order);
		$this->db->where('time_slot_order <=',$max_time_slot_order);		
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}

	function getNotLectiveTimeSlots($orderby="asc") {
		
		$this->db->select('time_slot_id,time_slot_start_time,time_slot_end_time,time_slot_lective,time_slot_order');
		$this->db->from('time_slot');
		$this->db->order_by('time_slot_order', $orderby);

		$this->db->where('time_slot_lective', 0);

		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query;
		else
			return false;
	}	
	

	function get_all_teachers_ids_and_names($orderby="asc",$academic_period_id=null) {

		if ($academic_period_id == null) {
			$academic_period_id = $this->get_current_academic_period_id();
		}

		/*
		SELECT `teacher_academic_periods_code`, `person_sn1`, `person_sn2`, `person_givenName`, `person_id`, `person_official_id` 
		FROM (`teacher`) 
		JOIN `teacher_academic_periods` ON `teacher_academic_periods`.`teacher_academic_periods_teacher_id` = `teacher`.`teacher_id` 
		JOIN `person` ON `person`.`person_id` = `teacher`.`teacher_person_id` 
		WHERE `teacher_academic_periods_academic_period_id` = '5' 
		ORDER BY `teacher_academic_periods_code` asc
		*/

		$this->db->from('teacher');
        $this->db->select('teacher.teacher_id, teacher_academic_periods_code, person_sn1,person_sn2, person_givenName, person_id, person_official_id');

		$this->db->order_by('teacher_academic_periods_code', $orderby);
		
		$this->db->join('teacher_academic_periods', 'teacher_academic_periods.teacher_academic_periods_teacher_id = teacher.teacher_id');
		$this->db->join('person', 'person.person_id = teacher.teacher_person_id');

		$this->db->where('teacher_academic_periods_academic_period_id', $academic_period_id);
        
        $query = $this->db->get();
        //echo $this->db->last_query()."<br />";

		
		if ($query->num_rows() > 0) {

			$teachers_array = array();

			foreach ($query->result_array() as $row)	{
   				$teachers_array[$row['teacher_academic_periods_code']] = $row['teacher_academic_periods_code'] . " - " . $row['person_sn1'] . " " . $row['person_sn2'] . ", " . $row['person_givenName'] . " - " . $row['person_official_id'] . " (" . $row['teacher_id'] . ")";
			}
			return $teachers_array;
		}			
		else
			return false;
	}

	
	function get_module_morning_hours($module,$lesson_classroom_group_id=null,$teacher_id=null, $academic_period_id=null)
	{
        if ($academic_period_id == null) {
            $academic_period_id = $this->get_current_academic_period_id();
        }

		$this->db->from('lesson');
		$this->db->select('lesson_study_module_id,lesson_day,lesson_time_slot_id');
		$this->db->distinct();
		$this->db->where('lesson_study_module_id', $module);
		$this->db->where('lesson_time_slot_id >=', 1);
		$this->db->where('lesson_time_slot_id <=',7);	

		$this->db->where('lesson_academic_period_id', $academic_period_id);
		if ($lesson_classroom_group_id!=null)	{
			$this->db->where('lesson_classroom_group_id', $lesson_classroom_group_id);
		}
		if ($teacher_id!=null)	{
			$this->db->where('lesson_teacher_id', $teacher_id);
		}		
		
		$query = $this->db->get();
        //echo $this->db->last_query()."<br />";		

		if ($query->num_rows() > 0) {
			return $query->num_rows;
		}
		else
			return 0;
	}

	function get_module_afternoon_hours($module,$lesson_classroom_group_id=null,$teacher_id=null,$academic_period_id)
	{
        if ($academic_period_id == null) {
            $academic_period_id = $this->get_current_academic_period_id();
        }

		$this->db->from('lesson');
		$this->db->select('lesson_study_module_id,lesson_day,lesson_time_slot_id');
		$this->db->distinct();
		$this->db->where('lesson_study_module_id', $module);
		$this->db->where('lesson_time_slot_id >=', 9);
		$this->db->where('lesson_time_slot_id <=',15);
		$this->db->where('lesson_academic_period_id', $academic_period_id);
		if ($lesson_classroom_group_id!=null)	{
			$this->db->where('lesson_classroom_group_id', $lesson_classroom_group_id);
		}		
				
		if ($teacher_id!=null)	{
			$this->db->where('lesson_teacher_id', $teacher_id);
		}
		
		$query = $this->db->get();
        //echo $this->db->last_query()."<br />";		

		if ($query->num_rows() > 0) {
			return $query->num_rows;
		}
		else
			return 0;
	}

	function get_real_total_morning_hours_by_teacher_id($teacher_id,$academic_period_id=null) {

        if ($academic_period_id == null) {
            $academic_period_id = $this->get_current_academic_period_id();
        }


		/*
		SELECT DISTINCT `lesson_day`,`lesson_time_slot_id`
		FROM lesson
		WHERE `lesson_teacher_id`=8 AND `lesson_academic_period_id`=5
		*/	

		$this->db->from('lesson');
		$this->db->select('lesson_day,lesson_time_slot_id');
		$this->db->distinct();
		$this->db->where('lesson_teacher_id', $teacher_id);
		$this->db->where('lesson_academic_period_id', $academic_period_id);
		$this->db->where('lesson_time_slot_id >=', 1);
		$this->db->where('lesson_time_slot_id <=',7);	
		
		$query = $this->db->get();
        //echo $this->db->last_query()."<br />";		

		if ($query->num_rows() > 0) {
			return $query->num_rows;
		}
		else
			return 0;
	}

	function get_real_total_afternoon_hours_by_teacher_id($teacher_id,$academic_period_id=null) {

        if ($academic_period_id == null) {
            $academic_period_id = $this->get_current_academic_period_id();
        }

		/*
		SELECT DISTINCT `lesson_day`,`lesson_time_slot_id`
		FROM lesson
		WHERE `lesson_teacher_id`=8 AND `lesson_academic_period_id`=5
		*/	

		$this->db->from('lesson');
		$this->db->select('lesson_day,lesson_time_slot_id');
		$this->db->distinct();
		$this->db->where('lesson_teacher_id', $teacher_id);
		$this->db->where('lesson_academic_period_id', $academic_period_id);
		$this->db->where('lesson_time_slot_id >=', 9);
		$this->db->where('lesson_time_slot_id <=',15);
		
		$query = $this->db->get();
        //echo $this->db->last_query()."<br />";		

		if ($query->num_rows() > 0) {
			return $query->num_rows;
		}
		else
			return 0;
	}

	function get_real_total_hours_by_teacher_id($teacher_id,$academic_period_id = null) {

        if ($academic_period_id == null) {
            $academic_period_id = $this->get_current_academic_period_id();
        }


		/*
		SELECT DISTINCT `lesson_day`,`lesson_time_slot_id`
		FROM lesson
		WHERE `lesson_teacher_id`=8 AND `lesson_academic_period_id`=5
		*/	

		$this->db->from('lesson');
		$this->db->select('lesson_day,lesson_time_slot_id');
		$this->db->distinct();
		$this->db->where('lesson_teacher_id', $teacher_id);
		$this->db->where('lesson_academic_period_id', $academic_period_id);
		
		$query = $this->db->get();
        //echo $this->db->last_query()."<br />";		

		if ($query->num_rows() > 0) {
			return $query->num_rows;
		}
		else
			return 0;
	}

	function get_real_total_hours_by_group_id($group_id,$academic_period_id = null) {

        if ($academic_period_id == null) {
            $academic_period_id = $this->get_current_academic_period_id();
        }

		/*
		SELECT DISTINCT `lesson_day`,`lesson_time_slot_id`
		FROM lesson
		WHERE `lesson_classroom_group_id`=8 AND `lesson_academic_period_id`=5
		*/	

		$this->db->from('lesson');
		$this->db->select('lesson_day,lesson_time_slot_id');
		$this->db->distinct();
		$this->db->where('lesson_classroom_group_id', $group_id);
		$this->db->where('lesson_academic_period_id', $academic_period_id);
		
		$query = $this->db->get();
        //echo $this->db->last_query()."<br />";		

		if ($query->num_rows() > 0) {
			return $query->num_rows;
		}
		else
			return 0;
	}


	//Hores Setmanals totals reals
	//IT SEEMS NOT WORKS. OBSOLET!!!
	function get_real_module_hours_per_week($module,$lesson_classroom_group_id=null,$teacher_id=null, $academic_period_id = null) {

        if ($academic_period_id == null) {
            $academic_period_id = $this->get_current_academic_period_id();
        }

        $academic_period_id = $this->get_current_academic_period_id();


		$this->db->from('lesson');
		$this->db->select('lesson_day,lesson_time_slot_id');
		$this->db->distinct();
		$this->db->where('lesson_study_module_id', $module);
		$this->db->where('lesson_academic_period_id', $academic_period_id);
		if ($lesson_classroom_group_id!=null)	{
			$this->db->where('lesson_classroom_group_id', $lesson_classroom_group_id);
		}		
		if ($teacher_id!=null)	{
			$this->db->where('lesson_teacher_id', $teacher_id);
		}
		
		$query = $this->db->get();
        //echo $this->db->last_query()."<br />";		

		if ($query->num_rows() > 0) {
			return $query->num_rows;
		}
		else
			return 0;
	}	

	//Hores Setmanals totals no reals
	function get_module_hours_per_week($module,$lesson_classroom_group_id=null,$teacher_id=null,$academic_period_id=null)
	{
        if ($academic_period_id == null) {
            $academic_period_id = $this->get_current_academic_period_id();
        }

		$this->db->from('lesson');
		$this->db->select('lesson_study_module_id,lesson_day,lesson_time_slot_id');
		$this->db->distinct();
		$this->db->where('lesson_study_module_id', $module);
		$this->db->where('lesson_academic_period_id', $academic_period_id);
		if ($lesson_classroom_group_id!=null)	{
			$this->db->where('lesson_classroom_group_id', $lesson_classroom_group_id);
		}		
		if ($teacher_id!=null)	{
			$this->db->where('lesson_teacher_id', $teacher_id);
		}
		
		$query = $this->db->get();
        //echo $this->db->last_query()."<br />";		

		if ($query->num_rows() > 0) {
			return $query->num_rows;
		}
		else
			return 0;
	}
	
}
