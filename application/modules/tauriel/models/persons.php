<?php
/**
*
*
*
* @package Ebre-escool
* @author pdavila13
* @version 1.0
* @link	pdavila.org/mediawiki
*/

class Persons extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	// Getting all the teachers.
	function getAllPersons() {
		$data = $this->db->get('person');
		$teachers = array();

		if ($data->num_rows() > 0) {
			return $data;
		} else {
			return FALSE;
		}
	}

	// Getting a teacher by id.
	function getOnePerson($id) {
		$this->db->where('person_id',$id);
		$data = $this->db->get('person_givenName');

		// Cheching if we have any row.
		if ($data->num_rows() > 0) {
			return $data;
		} else {
			return false;
		}
	}

	//Deleting a teacher by id.
	function deletePerson($del) {
		if ($del) {
			$this->db->where('name',$del);
			$this->db->delete('users');
			return true;
		} else {
			return false;
		}
	}
}
?>