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
class api_model  extends CI_Model  {
	
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


	function getPerson($id){
		/*
		SELECT person_id, person_givenName, person_sn1, person_sn2, 
		person_email, person_secondary_email, person_terciary_email, 
		person_official_id, person_official_id_type, person_date_of_birth,
		 person_gender, person_secondary_official_id, 
		 person_secondary_official_id_type, person_homePostalAddress, 
		 person_photo, person_locality_id, person_locality_name, 
		 person_telephoneNumber, person_mobile, person_bank_account_id, 
		 person_notes, person_entryDate, person_last_update, 
		 person_creationUserId, person_lastupdateUserId, 
		 person_markedForDeletion, person_markedForDeletionDate, 
		 dn, date_of_birth, user_type, username_original_ldap, 
		 calculated_username, duplicated_username, original_username, 
		 uidnumber, homedirectory, employeenumber, employeetype, 
		 createbydn, modifiedbydn, userpassword, postalcode, 
		 state 
		 FROM person WHERE person_id = id
		*/
		$this->db->select('person_id, person_givenName, person_sn1, person_sn2, 
		person_email, person_secondary_email, person_terciary_email, 
		person_official_id, person_official_id_type, person_date_of_birth,
		 person_gender, person_secondary_official_id, 
		 person_secondary_official_id_type, person_homePostalAddress, 
		 person_photo, person_locality_id, person_locality_name, 
		 person_telephoneNumber, person_mobile, person_bank_account_id, 
		 person_notes, person_entryDate, person_last_update, 
		 person_creationUserId, person_lastupdateUserId, 
		 person_markedForDeletion, person_markedForDeletionDate, 
		 dn, date_of_birth, user_type, username_original_ldap, 
		 calculated_username, duplicated_username, original_username, 
		 uidnumber, homedirectory, employeenumber, employeetype, 
		 createbydn, modifiedbydn, userpassword, postalcode, 
		 state');
		
		$this->db->from('person');
		$this->db->where('person_id',1);

		$query = $this->db->get();
		//echo $this->db->last_query(). "<br/>";

		if ($query->num_rows() == 1){
			$row = $query->row(); 

			$person = new stdClass();

			$person->id = $row->person_id;
			$person->givenName = $row->person_givenName;
			$person->sn1 = $row->person_sn1;
			$person->sn2 = $row->person_sn2;
			$person->email = $row->person_email;
			//...
			
			return $person;
		}	
		else
			return false;

	}

	function getPersonAlt($id){
		/*
		SELECT * FROM `person` WHERE person_id = id
		*/
		$this->db->select('*');
		$this->db->from('person');
		$this->db->where('person_id',1);
		
		$query = $this->db->get();
		//echo $this->db->last_query(). "<br/>";

		if ($query->num_rows() == 1){
			$row = $query->row(); 
			return $row;
		}	
		else {
			return false;
		}

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
