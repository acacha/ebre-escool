<?php

/**
* @package		CodeIgniter
* @subpackage	WEB Rest Server
* @category	    Controller
* @author		Turcan Nicolae
*/

class Persons_model extends CI_Model
{
function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  // Getting all the teachers.
  function getPeople() {
    $data = $this->db->get('person');
    $people = array();
    if ($data->num_rows() > 0) {
     return $data;

   }else{

    return FALSE;
  }
}

// Getting a person by id.
function getPerson($id){
 $this->db->where('person_id',$id);
 $data = $this->db->get('person');
 $result = $data->result();
// Cheching if we've got any row.
    if ( $result->num_rows() > 0){
        return $result;
}else{
  return false;
}
}

//Deleting a person by id.
function deletePerson($del) {
  if ($del) {
    $this->db->where('person_id',$del);
    $this->db->delete('person');
    return true;
  }else{
    return false;
  }
}
}
?>
