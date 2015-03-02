<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* @package		Ebre-escool
* @subpackage	API
* @category	    Controller
* @author		Sergi Tur Badenas
* @editedBy     Turcan Nicolae
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'libraries/REST_Controller.php';

class Persons extends REST_Controller
{
	function __construct()
    {
        parent::__construct();
        
        // Configure limits on our controller methods. Ensure
        // you have created the 'limits' table and enabled 'limits'
        // within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key

        //Load model
        $this->load->model('Persons_model');
    }
    
    
    public function index_get(){
        
        $this->persons_get();
        
    }
  
    function person_get()
    {
        if(!$this->get('id'))
        {
            $message = array('id'=>'','message'=>'YOU MUST SEND AN ID');
            $this->response($message, 400);
        }

        $person = $this->Persons_model->getPerson( $this->get('id') );

        if($person)
        {
            $this->response($person, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('id' => $this->get('id'),'message' => 'person NOT EXISTS!'), 404);
        }
    }
   
    function person_post()
    {

        if (isset($_POST)){
            $postdata = file_get_contents("php://input");
            //log_message('debug',$postdata);
            $personObject = json_decode($postdata);

             $data = array(
            'person_id'=>$personObject->{'id'},                 
            'person_givenName'=>$personObject->{'givenName'},
            'person_sn1'=>$personObject->{'sn1'},
            'person_sn2'=>$personObject->{'sn2'},
            'person_email'=>$personObject->{'email1'},
            'person_official_id'=>$personObject->{'official_id'},
            'person_official_id_type'=>$personObject->{'official_id_type'},
            'person_date_of_birth'=>$personObject->{'date_of_birth'},
            'person_gender'=>$personObject->{'gender'},
            'person_homePostalAddress'=>$personObject->{'homePostalAddress'},
            'person_photo'=>$personObject->{'photo'},
            'person_locality_id'=>$personObject->{'locality_id'},
            'person_telephoneNumber'=>$personObject->{'telephoneNumber'},
            'person_mobile'=>$personObject->{'mobile'},
            'person_bank_account_id'=>$personObject->{'bank_account_id'},
            'person_notes'=>$personObject->{'notes'},
            'person_entryDate'=>$personObject->{'entryDate'},
            'person_last_update'=>$personObject->{'last_update'},
            'person_creationUserId'=>$personObject->{'creationUserId'},                
            'person_lastupdateUserId'=>$personObject->{'lastupdateUserId'},
            'person_markedForDeletion'=>$personObject->{'markedForDeletion'},
            'person_markedForDeletionDate'=>$personObject->{'markedForDeletionDate'});

            $response = $this->Persons_model->insertPerson($data);
        }
        
        if($response['response']){
          $message = array('id' => $response['id'], 'message' => 'NEW person INSERTED!');
          $this->response($message, 200); // 200 being the HTTP response code
        }else{
            $message = array('id' =>$response['id'], 'message' => 'ERROR INSERTING!');
            $this->response($message, 404); // 404 being the HTTP response code(Not Found)
        }
    }
 
    function person_delete(){

        if(!$this->get('id')){
        
            $message = array('id'=>'','message'=>'YOU MUST SEND AN ID');
            $this->response($message, 400);
        }
        log_message('debug',"delete id: ".$this->get('id'));
        
    	$response = $this->Persons_model->deletePerson( $this->get('id') );
       
       if($response){
            $message = array('id' => $this->get('id'), 'message' => 'DELETED!');
            $this->response($message, 200); // 200 being the HTTP response code
        }else{
        $message = array('id' => $this->get('id'), 'message' => 'ERROR DELETING!');
        
        $this->response($message, 404); // 400 being the HTTP response code(Not Found)
       }
    }
    
    function persons_get(){

        $persons = $this->Persons_model->getPersons();
        
        if($persons)
        {
            $this->response($persons, 200); // 200 being the HTTP response code
        }else{
           $this->response(array('id' => $this->get('id'),'message' => 'Couldn\'t find any persons!'), 404);
        }
    }

    function person_put(){
        //GET THE ID
         $id = $this->put('id');
        $data = array(
            'person_id'=>$personObject->{'id'},                 
            'person_givenName'=>$personObject->{'givenName'},
            'person_sn1'=>$personObject->{'sn1'},
            'person_sn2'=>$personObject->{'sn2'},
            'person_email'=>$personObject->{'email1'},
            'person_official_id'=>$personObject->{'official_id'},
            'person_official_id_type'=>$personObject->{'official_id_type'},
            'person_date_of_birth'=>$personObject->{'date_of_birth'},
            'person_gender'=>$personObject->{'gender'},
            'person_homePostalAddress'=>$personObject->{'homePostalAddress'},
            'person_photo'=>$personObject->{'photo'},
            'person_locality_id'=>$personObject->{'locality_id'},
            'person_telephoneNumber'=>$personObject->{'telephoneNumber'},
            'person_mobile'=>$personObject->{'mobile'},
            'person_bank_account_id'=>$personObject->{'bank_account_id'},
            'person_notes'=>$personObject->{'notes'},
            'person_entryDate'=>$personObject->{'entryDate'},
            'person_last_update'=>$personObject->{'last_update'},
            'person_creationUserId'=>$personObject->{'creationUserId'},                
            'person_lastupdateUserId'=>$personObject->{'lastupdateUserId'},
            'person_markedForDeletion'=>$personObject->{'markedForDeletion'},
            'person_markedForDeletionDate'=>$personObject->{'markedForDeletionDate'});
                
         $updateResponse = $this->Persons_model->updatePerson($id,$data);
         
         if($updateResponse){
            $message = array('id' => $id,'message' => 'UPDATED!');
            $this->response($message,200);//200 being the HTTP response code

         }else{
            $message = array('id' => $id, 'message' => 'ERROR UPDATING!');
            $this->response($message, 422); // 422 being the HTTP response code
         } 
    }

    function markForDeletion_put(){
        
            $today = date('Y-m-d H:i:s');
            $id = $this->put('id');
             $data = array(
            'person_markedForDeletion'=>$this->put('marked_for_deletion'),
            'person_markedForDeletionDate'=>$today);

             $response = $this->Persons_model->updatePerson($id,$data);
        
    
       
        if($response){
          $message = array('id' => $id, 'message' => 'UPDATED!');
          $this->response($message, 200); // 200 being the HTTP response code
        }else{
            $message = array('id' =>$id, 'message' => 'ERROR UPDATING!');
            $this->response($message, 404); // 404 being the HTTP response code(Not Found)
        }
    
    }

    
	public function send_post()
	{
		var_dump($this->request->body);
	}


	public function send_put()
	{
		var_dump($this->put('foo'));
	}
}