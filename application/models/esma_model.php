<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Esma_model extends CI_Model{

    function __construct()
    {
       parent::__construct();
        $this->load->database();
    }
    function getUsersJson(){

    	$query = $this->db->query('SELECT person_id,person_givenName,person_sn1,person_sn2,person_photo 
                  FROM person where person_id= ANY 
                  (SELECT student_person_id FROM student) LIMIT 0 , 5 ');

      return $query->result();
    }


}

//SELECT person_id,person_givenName,person_sn1,person_sn2 
//FROM person where person_id= ANY (SELECT student_person_id FROM student) AND person_sn1="borrell"