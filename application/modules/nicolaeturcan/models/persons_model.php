<?php
/**
* @package		Ebre-escool
* @subpackage	API
* @category	    Controller
* @author		Sergi Tur Badenas
* @editedBy     Turcan Nicolae
*/

class Persons_model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
        //$this->load->library('ebre_escool');

    }

function getPersons() {
    /*
    SELECT  `person_id` ,  `person_givenName` ,  `person_sn1` ,  `person_sn2` ,  `person_email` ,  
    `person_secondary_email` , `person_terciary_email` ,  `person_official_id` ,  `person_official_id_type`, 
    `person_date_of_birth` ,  `person_gender` , `person_secondary_official_id` ,  `person_secondary_official_id_type` , 
    `person_homePostalAddress` ,  `person_photo` ,  `person_locality_id`, `person_telephoneNumber` ,  `person_mobile` , 
    `person_bank_account_id` ,  `person_notes` , `person_entryDate` ,  `person_last_update` ,  `person_creationUserId` , 
    `person_lastupdateUserId` , `person_markedForDeletion` ,  `person_markedForDeletionDate` FROM  `person`
    */

        $this->db->select('person_id, person_givenName, person_sn1, person_sn2, person_email, person_secondary_email, 
        person_terciary_email, person_official_id, person_official_id_type, person_date_of_birth, person_gender, 
        person_secondary_official_id, person_secondary_official_id_type, person_homePostalAddress, person_photo, 
        person_locality_id, person_telephoneNumber, person_mobile, person_bank_account_id, person_notes, person_entryDate, 
        person_last_update, person_creationUserId, person_lastupdateUserId, person_markedForDeletion, person_markedForDeletionDate');

        $this->db->from('person');
        $this->db->where('person_markedForDeletion','n');
        $query = $this->db->get();
        //echo $this->db->last_query(). "<br/>";
    
    $persons = array();
    if($query->num_rows()>0){
      
      foreach ($query->result() as $row ) {
        $person = new stdClass();
        // Adding rows to stdClass and changing their names.
        $person->id = $row->person_id;
        $person->givenName = $row->person_givenName;
        $person->sn1 = $row->person_sn1;
        $person->sn2 = $row->person_sn2;
        $person->email1 = $row->person_email;
        $person->email2 = $row->person_secondary_email;
        $person->email3 = $row->person_terciary_email;
        $person->official_id = $row->person_official_id;
        $person->official_id_type = $row->person_official_id_type;
        $person->date_of_birth = $row->person_date_of_birth;
        $person->gender = $row->person_gender;
        $person->official_id2 = $row->person_secondary_official_id;
        $person->official_id_type2 = $row->person_secondary_official_id_type;
        $person->homePostalAddress = $row->person_homePostalAddress;
        $person->photo = $row->person_photo;
        $person->locality_id = $row->person_locality_id;
        $person->telephoneNumber = $row->person_telephoneNumber;
        $person->mobile = $row->person_mobile;
        $person->bank_account_id = $row->person_bank_account_id;
        $person->notes = $row->person_notes;
        $person->entryDate = $row->person_entryDate;
        $person->last_update = $row->person_last_update;
        $person->creationUserId = $row->person_creationUserId;
        $person->lastupdateUserId = $row->person_lastupdateUserId;
        $person->markedForDeletion = $row->person_markedForDeletion;
        $person->markedForDeletionDate = $row->person_markedForDeletionDate;           
        //...
        array_push($persons, $person);
      }
       return $persons;
    }else{             
          return FALSE;
          }
     }


     function getPerson($id){
        /*
        SELECT person_id, person_givenName, person_sn1, person_sn2, 
        person_email, person_secondary_email, person_terciary_email, 
        person_official_id, person_official_id_type, person_date_of_birth,
        person_gender, person_secondary_official_id, 
        person_secondary_official_id_type, person_homePostalAddress 
        FROM person WHERE person_id = id
        */

        $this->db->select('person_id, person_givenName, person_sn1, person_sn2, person_email, person_secondary_email, person_terciary_email, 
        person_official_id, person_official_id_type, person_date_of_birth, person_gender, person_secondary_official_id, person_secondary_official_id_type, 
        person_homePostalAddress, person_photo, person_locality_id, person_telephoneNumber, person_mobile, person_bank_account_id, person_notes, person_entryDate, 
        person_last_update, person_creationUserId, person_lastupdateUserId, person_markedForDeletion, person_markedForDeletionDate');
       
         $this->db->where('person_id',$id);
         $this->db->from('person');
         $query = $this->db->get();
         //echo $this->db->last_query(). "<br/>";

         if ($query->num_rows()==1){
            $row = $query->row(); 
            // stdClass is a PHP generic empty class.
            $person = new stdClass();
            // Adding rows to stdClass and changing their names.
            $person->id = $row->person_id;
            $person->givenName = $row->person_givenName;
            $person->sn1 = $row->person_sn1;
            $person->sn2 = $row->person_sn2;
            $person->email1 = $row->person_email;
            $person->email2 = $row->person_secondary_email;
            $person->email3 = $row->person_terciary_email;
            $person->official_id = $row->person_official_id;
            $person->official_id_type = $row->person_official_id_type;
            $person->date_of_birth = $row->person_date_of_birth;
            $person->gender = $row->person_gender;
            $person->official_id2 = $row->person_secondary_official_id;
            $person->official_id_type2 = $row->person_secondary_official_id_type;
            $person->homePostalAddress = $row->person_homePostalAddress;
            $person->photo = $row->person_photo;
            $person->locality_id = $row->person_locality_id;
            $person->telephoneNumber = $row->person_telephoneNumber;
            $person->mobile = $row->person_mobile;
            $person->bank_account_id = $row->person_bank_account_id;
            $person->notes = $row->person_notes;
            $person->entryDate = $row->person_entryDate;
            $person->last_update = $row->person_last_update;
            $person->creationUserId = $row->person_creationUserId;
            $person->lastupdateUserId = $row->person_lastupdateUserId;
            $person->markedForDeletion = $row->person_markedForDeletion;
            $person->markedForDeletionDate = $row->person_markedForDeletionDate;   
            //...
            return $person;
      }else{
            return false;
      }
    }

    //Delete person using id
    function deletePerson($id) {
        
        //DELETE FROM `person` WHERE person_id = $id
        if ($id) {
            $this->db->where('person_id',$id);
            $what = $this->db->delete('person');
            $row = $this->db->affected_rows();
            //echo $this->db->last_query()."<br/>";

            if($row == 1){
                return true;
            }else{
                return false;
            }
        }
    }

    function updatePerson($id,$data){
        /*
        UPDATE `person` SET `person_id`=[value-1],`person_person_id`=[value-2],
        `person_user_id`=[value-3],`person_entryDate`=[value-4],
        `person_last_update`=[value-5],`person_creationUserId`=[value-6],
        `person_lastupdateUserId`=[value-7],`person_markedForDeletion`=[value-8],
        `person_markedForDeletionDate`=[value-9],`person_officialid`=[value-10] WHERE person_id = $id
         */
        
          if ($id && $data){
            $this->db->where('person_id',$id);
            $this->db->update('person',$data);
            //echo $this->db->last_query(). "<br/>";

              if($this->db->affected_rows()==1){
                  return true;
              }else{
                  return false;
              }
          }
      }

      function insertPerson($data){
          /*
          INSERT INTO `person`(`person_id`, `person_person_id`, `person_user_id`, 
          `person_entryDate`, `person_last_update`, `person_creationUserId`, 
          `person_lastupdateUserId`, `person_markedForDeletion`, 
          `person_markedForDeletionDate`, `person_officialid`) VALUES ($data);
          */
          
        if ($data){
            
            $this->db->insert('person',$data);

            $row = $this->db->affected_rows();
            //log_message('debug','insert response:'.$row);
            $id = $this->db->insert_id();
            $result=array();
            $result['id'] = $id;

            if($row ==1){
              $response = true;
               $result['response'] = $response;
             
              }else{
                $response = false;
                $result['response'] = $response;
              }
              return $result;

            }
        }
      }

?>