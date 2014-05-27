<?php
/**
 * timetables_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergitur@ebretic.com>
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

	function get_all_groups_byteacherid($teacher_id, $orderby = "asc") {

		/*
		SELECT DISTINCT group_code,group_shortName,group_name
		FROM `lesson` 
		INNER JOIN classroom_group ON `lesson`.`lesson_classroom_group_id`  = classroom_group.classroom_group_id
		WHERE lesson_teacher_id=39
		*/

		$this->db->from('lesson');
		$this->db->distinct();
        $this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name');

		$this->db->order_by('classroom_group_code', $orderby);
		
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id');

		$this->db->where('lesson.lesson_teacher_id',$teacher_id);
        
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


//

	function get_all_group_study_modules($classroom_group_id) {
        $this->db->select('study_module_id,study_module_shortname,study_module_name,study_module_hoursPerWeek');
		$this->db->from('study_module');
		//$this->db->distinct();
		$this->db->where('study_module_classroom_group_id',$classroom_group_id);
        
        $query = $this->db->get();

        //echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query;
		}			
		else
			return false;
	}

	function get_all_teacher_study_modules($teacher_id) {
/*
select 
`classroom_group`.`classroom_group_code`,
`study_module`.`study_module_shortname`,
`study_module`.`study_module_name`,
`study_module`.`study_module_hoursPerWeek` from lesson 
join classroom_group on lesson.lesson_classroom_group_id = classroom_group.classroom_group_id
join study_module on lesson.lesson_study_module_id = study_module.study_module_id
where lesson_teacher_id=7

*/
		//$this->db->from('study_module');
        //$this->db->select('study_module_id,study_module_shortname,study_module_name,study_module_hoursPerWeek');
		//$this->db->where('study_module_teacher_id',$teacher_id);
        $this->db->select('classroom_group_code,study_module_id,study_module_shortname,study_module_name,study_module_hoursPerWeek');
		$this->db->from('lesson');
		$this->db->distinct();
		$this->db->join('study_module', 'lesson.lesson_study_module_id = study_module.study_module_id','left');
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id','left');
		$this->db->where('study_module_teacher_id',$teacher_id);

        $query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query;
		}			
		else
			return false;
	}

	function get_all_lessonsfortimetablebygroupid($classroom_group_id)	{

		$this->db->from('lesson');
        $this->db->select('lesson_id,lesson_code,lesson_day,time_slot_start_time,time_slot_order,study_module_id,study_module_shortname,study_module_name,
        	classroom_group_code,classroom_group_shortName,classroom_group_name');

		$this->db->order_by('lesson_day,time_slot_order', "asc");
		
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');
		$this->db->join('study_module', 'lesson.lesson_study_module_id = study_module.study_module_id','left');
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id','left');

		$this->db->where('lesson.lesson_classroom_group_id',$classroom_group_id);
        
        $query = $this->db->get();

        //echo $this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$all_lessonsfortimetablebygroupid = array();

			$previous_day = null;

			$previous_lesson_code = null;

			foreach ($query->result_array() as $row)	{
				
				$day=$row['lesson_day'];
				$time_slot_start_time = $row['time_slot_start_time'];
				$lesson_id = $row['lesson_id'];
				$lesson_code = $row['lesson_code'];
				$time_slot_order = $row['time_slot_order'];
				$study_module_id = $row['study_module_id'];
				$study_module_shortname = $row['study_module_shortname'];
				$study_module_name = $row['study_module_name'];
				$group_code = $row['classroom_group_code'];
				$group_shortName = $row['classroom_group_shortName'];
				$group_name = $row['classroom_group_name'];

				if ($previous_day == null || $day != $previous_day) {
					$day_lessons = new stdClass;	
					$lesson_by_day = array();
				}

				//detect consecutive lessons and aggrupate in on event with more duration
				if ( $previous_lesson_code == $lesson_code && $this->is_time_slot_lective_by_time_slot_order($time_slot_order-1) ) {
					//Change previous lesson duration (++) and skip this one
					@$all_lessonsfortimetablebygroupid[$day]->lesson_by_day[$previous_time_slot_start_time]->duration++;
					$previous_time_slot_start_time = $previous_time_slot_start_time;
				} else {
					$lesson_data = new stdClass;

					$lesson_data->lesson_id= $lesson_id;
					$lesson_data->lesson_code= $lesson_code;
					$lesson_data->time_slot_order= $time_slot_order;
					$lesson_data->study_module_id= $study_module_id;
					$lesson_data->study_module_shortname= $study_module_shortname;
					$lesson_data->study_module_shortname= $study_module_shortname;
					$lesson_data->study_module_name= $study_module_name;
					$lesson_data->group_code= $group_code;
					$lesson_data->group_shortName= $group_shortName;
					$lesson_data->group_name= $group_name;
					$lesson_data->time_slot_lective=false;
					$lesson_data->location_code="20.2";
					
					$lesson_data->duration= 1;

					$lesson_by_day[$time_slot_start_time] = $lesson_data;

								
					$day_lessons->lesson_by_day = $lesson_by_day;

   					$all_lessonsfortimetablebygroupid[$day] = $day_lessons;
   					$previous_time_slot_start_time = $time_slot_start_time;
   				}

   				$previous_day=$day;
   				$previous_lesson_code = $lesson_code;
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


	function get_all_lessonsfortimetablebyteacherid($teacher_id) {

		$this->db->from('lesson');
        $this->db->select('lesson_id,lesson_code,lesson_day,lesson_time_slot_id,time_slot_start_time,time_slot_order,study_module_id,study_module_shortname,study_module_name,
        	classroom_group_code,classroom_group_shortName,classroom_group_name');

		$this->db->order_by('lesson_day,time_slot_order', "asc");
		
		$this->db->join('teacher', 'lesson.lesson_teacher_id = teacher.teacher_id');
		$this->db->join('time_slot', 'lesson.lesson_time_slot_id = time_slot.time_slot_id');
		$this->db->join('study_module', 'lesson.lesson_study_module_id = study_module.study_module_id','left');
		$this->db->join('classroom_group', 'lesson.lesson_classroom_group_id = classroom_group.classroom_group_id','left');

		$this->db->where('teacher.teacher_id',$teacher_id);
        
        $query = $this->db->get();

        //echo $this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$all_lessonsfortimetablebyteacherid = array();

			$previous_day = null;

			$previous_lesson_code = null;

			foreach ($query->result_array() as $row)	{
				
				$day=$row['lesson_day'];
				$lesson_time_slot_id = $row['lesson_time_slot_id'];
				$time_slot_start_time = $row['time_slot_start_time'];
				$lesson_id = $row['lesson_id'];
				$lesson_code = $row['lesson_code'];
				$time_slot_order = $row['time_slot_order'];
				$study_module_id = $row['study_module_id'];
				$study_module_shortname = $row['study_module_shortname'];
				$study_module_name = $row['study_module_name'];
				$group_code = $row['classroom_group_code'];
				$group_shortName = $row['classroom_group_shortName'];
				$group_name = $row['classroom_group_name'];
			
				if ($previous_day == null || $day != $previous_day) {
					$day_lessons = new stdClass;	
					$lesson_by_day = array();
				}

				//detect consecutive lessons and aggrupate in on event with more duration
				if ( $previous_lesson_code == $lesson_code && $this->is_time_slot_lective_by_time_slot_order($time_slot_order-1)) {
					//Change previous lesson duration (++) and skip this one
					@$all_lessonsfortimetablebyteacherid[$day]->lesson_by_day[$previous_time_slot_start_time]->duration++;
					$previous_time_slot_start_time = $previous_time_slot_start_time;
				} else {
					$lesson_data = new stdClass;

					$lesson_data->lesson_id= $lesson_id;
					$lesson_data->lesson_code= $lesson_code;
					$lesson_data->time_slot_order= $time_slot_order;
					$lesson_data->study_module_id= $study_module_id;
					$lesson_data->study_module_shortname= $study_module_shortname;
					$lesson_data->study_module_shortname= $study_module_shortname;
					$lesson_data->study_module_name= $study_module_name;
					$lesson_data->group_code= $group_code;
					$lesson_data->group_shortName= $group_shortName;
					$lesson_data->group_name= $group_name;
					$lesson_data->time_slot_lective=false;
					$lesson_data->location_code="20.2";
					
					$lesson_data->duration= 1;

					$lesson_by_day[$time_slot_start_time] = $lesson_data;

								
					$day_lessons->lesson_by_day = $lesson_by_day;

   					$all_lessonsfortimetablebyteacherid[$day] = $day_lessons;
   					$previous_time_slot_start_time = $time_slot_start_time;
   					$previous_lesson_time_slot_id = $lesson_time_slot_id;
   				}

   				$previous_day=$day;
   				$previous_lesson_code = $lesson_code;
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

		$this->db->from('classroom_group');
        $this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name');

		$this->db->order_by('classroom_group_code', $orderby);
		
		//$this->db->join('person', 'person.person_id = teacher.teacher_person_id');
        
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {

			$classroom_groups_array = array();

			foreach ($query->result_array() as $row)	{
   				$classroom_groups_array[$row['classroom_group_id']] = $row['classroom_group_code'] . " - " . $row['classroom_group_name'] . " ( " . $row['classroom_group_shortName'] . ")";
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

		//echo $this->db->last_query();

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
		$this->db->select('teacher_code,person_givenName,person_sn1,person_sn2');
		$this->db->from('teacher');

		$this->db->join('person','teacher.teacher_person_id = person.person_id');
		

		$this->db->where('teacher.teacher_id',$teacher_id);


		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->person_sn1 .  " " . $row->person_sn2 . ", " . $row->person_givenName;
		}
		else
			return "";
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

	function get_group_shift($classroom_group_id) {

		$this->db->select('classroom_group_shift');
		$this->db->from('classroom_group');
		$this->db->where('classroom_group.classroom_group_id',$classroom_group_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			if ($row->classroom_group_shift!=0)
				return $row->classroom_group_shift;
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

		//echo "MIN: " . $min_time_slot_order;
		//echo "MAX: " . $max_time_slot_order;

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
	

	function get_all_teachers_ids_and_names($orderby="asc") {

		$this->db->from('teacher');
        $this->db->select('teacher_code,person_sn1,person_sn2,person_givenName,person_id,person_official_id');

		$this->db->order_by('teacher_code', $orderby);
		
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

	//Hores Setmanals
	function get_module_hours_per_week($module)
	{
		$this->db->from('lesson');
		//$this->db->count_all_tesults('lesson_study_module_id');
		$this->db->select('lesson_study_module_id');
		$this->db->where('lesson_study_module_id', $module);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows;
		}
		else
			return 0;
	}
	
}
