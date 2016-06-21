<?php
/**
 * persons_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergiturbadenas@gmail.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class persons_model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getOrganizationalNameById($ou_id) {

    	$this->db->from('organizational_unit');
        $this->db->select('organizational_unit_name');
        $this->db->where('organizational_unit_Id',$ou_id);
	       
        $query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			$row = $query->row();
			return $row->organizational_unit_name;
		}			
		else {
			return "";
		}
    }
    
    function getPersonalDataByPersonId($person_id) {

    	$this->db->from('person');
        $this->db->select('person_locality_id,locality_name,person_entryDate,person_date_of_birth');
        $this->db->join('locality','locality_id = person_locality_id');
        $this->db->where('person_id',$person_id);
	       
        $query = $this->db->get();

        $person = array();

		if ($query->num_rows() == 1) {
			$row = $query->row();
			$person['person_locality_id'] = $row->person_locality_id;
			$person['person_locality_name'] = $row->locality_name;
			$person['person_date_of_birth'] = $row->person_date_of_birth;
			$person['person_entryDate'] = $row->person_entryDate;
		}			

		return $person;	

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

	
	
}
