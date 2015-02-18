        <?php
        /**
        * @package		Ebre-escool
        * @subpackage	API
        * @category	    Controller
        * @author		Sergi Tur Badenas
        * @editedBy     Turcan Nicolae
        */

        class persons_model  extends CI_Model  {

            function __construct()
            {
                parent::__construct();
                $this->load->database();

                //$this->load->library('ebre_escool');
            }

            // Getting all the persons.
            function getPersons() 
            {
                /*
                SELECT person_id, person_givenName, person_sn1, person_sn2, 
                person_email
                 FROM person WHERE person_id = id


                 SELECT  `person_id` ,  `person_givenName` ,  `person_sn1` ,  `person_sn2` ,  `person_email` ,  `person_secondary_email` ,  `person_terciary_email` ,  `person_official_id` ,  `person_official_id_type`,  
                 `person_date_of_birth` ,  `person_gender` , `person_secondary_official_id` ,  `person_secondary_official_id_type` ,  `person_homePostalAddress` ,  `person_photo` ,  `person_locality_id` ,  
                 `person_telephoneNumber` ,  `person_mobile` ,  `person_bank_account_id` ,  `person_notes` , `person_entryDate` ,  `person_last_update` ,  `person_creationUserId` ,  `person_lastupdateUserId` ,  
                 `person_markedForDeletion` ,  `person_markedForDeletionDate` FROM  `person` LIMIT 0 , 30 
                 26



                */
                $this->db->select('person_id, person_givenName, person_sn1, person_sn2, person_email, person_secondary_email, person_terciary_email, 
                person_official_id, person_official_id_type, person_date_of_birth, person_gender, person_secondary_official_id, person_secondary_official_id_type, 
                person_homePostalAddress, person_photo, person_locality_id, person_telephoneNumber, person_mobile, person_bank_account_id, person_notes, person_entryDate, 
                person_last_update, person_creationUserId, person_lastupdateUserId, person_markedForDeletion, person_markedForDeletionDate');

                $this->db->from('person');

                $query = $this->db->get();
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


            // Getting a person by id.
            function getPerson($id)
            {
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

                $this->db->from('person');
                $this->db->where('person_id',$id);

                $query = $this->db->get();
                //echo $this->db->last_query(). "<br/>";

                // Cheching if we've got any row.
                if ($query->num_rows() == 1){
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

            //Deleting a person by id.
            function deletePerson($del) 
            {    
                if ($del) {
                    $this->db->where('person_id',$del);
                    $this->db->delete('person');
                    return true;
                }else{
                    return false;
                }
            }

            function updatePerson($id,$data)
            {
                if ($id && $data){
                    $this->db->where('person_id',$id);
                    $this->db->update('person',$data);
                    return true;
                }else{
                    return false;
                }
            }

        }