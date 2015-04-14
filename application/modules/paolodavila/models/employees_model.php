<?php
/**
*
*
* @package Ebre-escool
* @author Sergi Tur <sergiturbadenas@gmail.com>
* @version 1.0
* @link http://www.acacha.com/index.php/ebre-escool
*/

class employees_model extends CI_Model {
    function __construct(){
        parent::__construct();
            $this->load->database();
            //$this->load->library('ebre_escool');
    }

    function getEmployees() {

        //$this->db->select('employees_id,employees_person_id,employees_code,employees_type_id');
        $this->db->select('*');
        $this->db->from('employees');
        //$this->db->where('employees_id',$id);
        $query = $this->db->get();

        $employees = array();
        
        if ($query->num_rows() > 0){

            foreach ($query->result() as $row) {
            //foreach ($query->$result as $row)
                # code...
                $employee = new stdClass();
                
                $employee->id = $row->employees_id;
                $employee->person_id = $row->employees_person_id;
                $employee->code = $row->employees_code;
                $employee->type_id = $row->employees_type_id;
                $employee->entryDate = $row->employees_entryDate;
                $employee->last_update = $row->employees_last_update;
                $employee->creationUserId = $row->employees_creationUserId;
                $employee->lastupdateUserId = $row->employees_lastupdateUserId;
                $employee->markedForDeletion = $row->employees_markedForDeletion;
                $employee->markedForDeletionDate = $row->employees_markedForDeletionDate;
            
                array_push($employees, $employee);
            }
            
            return $employees;
        } else
            return false;
    }

    function getEmployee($id) {

        /*
        SELECT *
        FROM `employees`
        WHERE `employees_id`
        */

        //$sql = "SELECT * FROM `employees` WHERE `employees_id` LIMIT 0, 30 ";
        
        //$this->db->select('employees_id,employees_person_id,employees_code,employees_type_id');
        $this->db->select('*');
        $this->db->from('employees');
        $this->db->where('employees_id',$id);

        $query = $this->db->get();
        
        if ($query->num_rows() == 1){
            $row = $query->row();

            $employee = new stdClass();

            $employee->id = $row->employees_id;
            $employee->person_id = $row->employees_person_id;
            $employee->code = $row->employees_code;
            $employee->type_id = $row->employees_type_id;
            $employee->entryDate = $row->employees_entryDate;
            $employee->last_update = $row->employees_last_update;
            $employee->creationUserId = $row->employees_creationUserId;
            $employee->lastupdateUserId = $row->employees_lastupdateUserId;
            $employee->markedForDeletion = $row->employees_markedForDeletion;
            $employee->markedForDeletionDate = $row->employees_markedForDeletionDate;

            return $employee;
        } else
            return false;
    }

    function deleteEmployees($id) {

        if ($id) {
            $this->db->where('employees_id',$id);
            $what = $this->db->delete('employees');
            $row = $this->db->affected_rows();
            //echo $this->db->last_query();

            if($row == 1){
                    return true;
                } else{
                    return false;
                }
        }
    }

    function updateEmployees($id,$data){
        if ($id && $data){
            $this->db->where('employees_id',$id);
            $this->db->update('employees',$data);
            //echo $this->db->last_query();
            
            if($this->db->affected_rows()==1){
                return true;
            } else{
                return false;
            }
        }
    }

    function insertEmployees($data){
        if ($data){
            $this->db->insert('employees',$data);
            $row = $this->db->affected_rows();
            $id = $this->db->insert_id();
            $result=array();
            $result['id'] = $id;
        
            //Check if it have gone right and return response
            if($row == 1){
                $response = true;
                $result['response'] = $response;
            } else{
                $response = false;
                $result['response'] = $response;
            }
            
            return $result;
        }
    } 
}