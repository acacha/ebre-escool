<?php
/**
 * Reports_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergitur@ebretic.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class reports_model  extends CI_Model  {
	
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

    function get_all_conserges() {

		$this->db->select('employees_id, person_givenName, person_sn1, person_sn2, person_photo');
		$this->db->from('employees');
		$this->db->join('person','employees_person_id = person_id');
		$this->db->where('employees_type_id',1);
		$query = $this->db->get();

		//echo $this->db->last_query();
		
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

		//echo $this->db->last_query();
		
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



}
