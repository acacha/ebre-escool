<?php
/**
 * dashboard_model Model
 *
 *
 * @package    	Ebre-escool
 * @author     	Sergi Tur <sergitur@ebretic.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class dashboard_model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getPersonsStatistics() {

    	$person_statistics = array();

    	//All persons
    	$this->db->from('person');
        //$this->db->select('organizational_unit_name');
        //$this->db->where('organizational_unit_Id',$ou_id);
	       
        $query = $this->db->get();

        $person_statistics['total_number_of_persons'] = $query->num_rows();
		
		//All persons without person_official_id (DNI p.ex.) duplciates!
		$this->db->from('person');
		$this->db->select('person_official_id');
        $this->db->distinct();
        	       
        $query = $this->db->get();

        $person_statistics['total_number_of_distinct_persons'] = $query->num_rows();

        $person_statistics['total_number_of_duplicated_persons'] = $person_statistics['total_number_of_persons'] - $person_statistics['total_number_of_distinct_persons'];

        $duplicated_person_ids = array();

        //Get Duplicated ids
		/*
        SELECT `person_official_id` 
		FROM person
		GROUP BY `person_official_id`
		HAVING count( * ) >1
		*/

		//All persons without person_official_id (DNI p.ex.) duplicates!
		$this->db->from('person');
		$this->db->select('person_official_id');
        $this->db->group_by("person_official_id"); 
        $this->db->having('count( * ) > 1'); 
        	       
        $query = $this->db->get();
        $duplicated_person_ids = array();

        if ($query->num_rows() > 0)	{
   			foreach ($query->result() as $row)	{
      			$duplicated_person_ids[] = $row->person_official_id;
   			}
		} 	

        $person_statistics['duplicated_person_ids'] = $duplicated_person_ids;
		
		return $person_statistics;
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
