<?php
/**
* ********************************* OBSOLET **************************************
 * Attendance_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergiturbadenas@gmail.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class Wizard_model  extends CI_Model  {
	
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

	/* Alumnes */
	public function get_students($orderby="asc") {

        $this->db->select('student_id,student_person_id,person_givenName,person_sn1,person_sn2');
		$this->db->from('student');
		$this->db->join('person','student_person_id=person_id');
		$this->db->order_by('student_id', $orderby);
		       
        $query = $this->db->get();

		if ($query->num_rows() > 0) {

			$student_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
   				$student_array[$i]['student_name'] = $row['person_givenName'];
   				$student_array[$i]['student_surname1'] = $row['person_sn1'];
   				$student_array[$i]['student_surname2'] = $row['person_sn2'];
   				$student_array[$i]['student_fullName'] = $row['person_givenName'] .' '.$row['person_sn1'].' '.$row['person_sn2'] ;
   				$student_array[$i]['student_id'] = $row['student_id'];
   				$student_array[$i]['student_person_id'] = $row['student_person_id'];
   				$i++;
			}
			return $student_array;
		}			
		else
			return false;
	}	

	/* Estudis */
	public function get_enrollment_studies($orderby="asc") {

        $this->db->select('studies_id,studies_shortname,studies_name');
		$this->db->from('studies');
		$this->db->order_by('studies_id', $orderby);
		       
        $query = $this->db->get();
		$this->db->last_query();
		
		if ($query->num_rows() > 0) {

			$studies_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
   				$studies_array[$i]['studies_id'] = $row['studies_id'];
   				$studies_array[$i]['studies_shortname'] = $row['studies_shortname'];
   				$studies_array[$i]['studies_name'] = $row['studies_name'];
   				$i++;
			}
			return $studies_array;
		}			
		else
			return false;
	}	

	/* Grups de classe */
	public function get_enrollment_classroom_groups($study=false,$orderby="asc") {

		if(!$study){
			$study=2;	//	"ASIX-DAM"
		}

		$this->db->select('classroom_group_id,classroom_group_code,classroom_group_shortName,classroom_group_name,course_shortname,course_name,studies_shortname,studies_name');
		$this->db->from('classroom_group');
		$this->db->join('course','classroom_group_course_id=course_id');
		$this->db->join('studies','course_estudies_id=studies_id');
		$this->db->where('studies_id',$study);
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

	/* Mòduls */
	public function get_enrollment_study_modules($classroom_group=false,$orderby="asc") {
		
		if(!$classroom_group){
			//$classroom_group=3;	//	"1ASIX-DAM"
		}		
//echo $classroom_group."<br />";
        $this->db->select('study_module_id,study_module_shortname,study_module_name');
		$this->db->from('study_module');
		$this->db->join('classroom_group','study_module_bclassroom_group_id=classroom_group_id');
		$this->db->where('classroom_group_id',$classroom_group);
		$this->db->order_by('study_module_shortname', $orderby);
		       
        $query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$study_module_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
   				$study_module_array[$i]['study_module_id'] = $row['study_module_id'];
   				$study_module_array[$i]['study_module_shortname'] = $row['study_module_shortname'];
   				$study_module_array[$i]['study_module_name'] = $row['study_module_name'];
   				$i++;
			}
			return $study_module_array;
		}			
		else
			return false;
	}	

	/* Unitats formatives */
	public function get_enrollment_study_submodules($study_modules=false,$orderby="asc") {

		if(!$study_modules){
			//$study_modules[]=282;	//	"M1"
			//$study_modules[]=268;	//	"M2"
		}	

        $this->db->select('study_submodules_id,study_submodules_shortname,study_submodules_name,study_module_shortname,study_submodules_study_module_id');
		$this->db->from('study_submodules');
		$this->db->join('study_module','study_submodules_study_module_id=study_module_id');
		$this->db->where_in('study_submodules_study_module_id',$study_modules);
		$this->db->order_by('study_submodules_id', $orderby);
		       
        $query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0) {

			$study_submodules_array = array();
			$i=0;
			foreach ($query->result_array() as $row)	{
				$study_submodules_array[$i]['study_module_shortname'] = $row['study_module_shortname'];
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

	/* Student Data */
	public function get_student_data($official_id) {
        $this->db->select('person_id, person_photo, person_secondary_official_id, person_givenName, person_sn1, person_sn2, person_email, person_date_of_birth, person_gender, person_homePostalAddress, person_locality_name, person_telephoneNumber, person_mobile');
		$this->db->from('person');
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


	/* ENROLLMENT */

	/* Enrollment */
	public function insert_enrollment($period_id=false,$person_id=false) {

        $data = array(
        	'enrollment_periodid' => $period_id,
        	'enrollment_personid' => $person_id 
        );

        $this->db->insert('enrollment',$data);
		       
		echo $this->db->last_query();

		if ($this->db->affected_rows() > 0) {

			return $this->db->affected_rows();
		}			
		else
			return false;
	}	

	/* Enrollment Studies */
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

	/* Enrollment Classroom Group */
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
	}	

	/* Enrollment Modules */
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
	}	

	/* Enrollment Submodules */
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

/*
	    $data = array(
        	'enrollment_submodules_periodid' => $period_id,
        	'enrollment_submodules_personid' => $person_id,
        	'enrollment_submodules_study_id' => $study_id,
        	'enrollment_submodules_group_id' => $class_group_id,
        	'enrollment_submodules_moduleid' => $modules_id,
        	'enrollment_submodules_submoduleid' => $submodules_id
        );
*/
      //  $this->db->insert('enrollment_submodules',$data);
		       
		//echo $this->db->last_query();

		//if ($this->db->affected_rows() > 0) {
			//return $this->db->affected_rows();
		//echo "Files afectades = $affected_rows<br />";
		//echo "Files rebudes = count($submodules_id)<br />";
		//if($affected_rows == count($submodules_id)){
			return $affected_rows;
		//}			
		//else
		//	return false;
	}	

}
