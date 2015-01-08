<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* @package		Ebre-escool
* @subpackage	API
* @category	    Controller
* @author		Sergi Tur Badenas
* @editedBy     Turcan Nicolae
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class persons extends REST_Controller
{

    public $LOGTAG = "EBRE_ESCOOL API: ";

    function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
        // Configure limits on our controller methods. Ensure
        // you have created the 'limits' table and enabled 'limits'
        // within application/config/rest.php
        $this->methods['person_get']['limit'] = 500; //500 requests per hour per person/key
        $this->methods['person_post']['limit'] = 100; //100 requests per hour per person/key
        $this->methods['person_delete']['limit'] = 50; //50 requests per hour per person/key

        //Loading "persons_model.php" model.
        $this->load->model('persons_model');

    }
    
############################################################################################

    public function index_get(){
        
        $this->persons_get();
        
    }

############################################################################################

    // Getting a person by id.
    function person_get()
    {
        if(!$this->get('id'))
        {
            $this->response(NULL, 400);
        }

        $person = $this->persons_model->getPerson( $this->get('id') );
        //$person = $this->persons_model->getPersonAlt( $this->get('id') );
        
        /*$persons = array(
            1 => array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com', 'fact' => 'Loves swimming'),
            2 => array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com', 'fact' => 'Has a huge face'),
            3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => 'Is a Scott!', array('hobbies' => array('fartings', 'bikes'))),
        );
        
        $person = @$persons[$this->get('id')];
        */
        if($person)
        {
            $this->response($person, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'person could not be found'), 404);
        }
    }
    

    #############################################################################################

    function persons_get()
    {
        //$persons = $this->some_model->getSomething( $this->get('limit') );
        /*$persons = array(
            array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com'),
            array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com'),
            3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => array('hobbies' => array('fartings', 'bikes'))),
        );*/
        $persons = $this->persons_model->getPersons();

        if($persons)
        {
            $this->response($persons, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(array('error' => 'Couldn\'t find any person!'), 404);
        }
    }

############################################################################################

    function person_post()
    {
        //$this->some_model->updateperson( $this->get('id') );
        //$message = array('id' => $this->get('id'), 'name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
        
        //$this->response($message, 200); // 200 being the HTTP response code
        
        if (isset($_POST))
        {
            $id = $this->input->get_post('id');
            $data = array('person_sn2'=>$this->input->get_post('person_sn2'));
            $response = $this->persons_model->updatePerson($id,$data);
        }
        
        if($response)
        {
            $message = array('id' => $id, 'message' => 'UPDATED!');
            $this->response($message, 200); // 200 being the HTTP response code
        }
        else
        {
            $message = array('id' =>$id, 'message' => 'ERROR UPDATING!');
            $this->response($message, 422); // 422 being the HTTP response code
        }
    }
    
############################################################################################
    
    function person_delete()
    {
        //$this->some_model->deletesomething( $this->get('id') );
        //$message = array('id' => $this->get('id'), 'message' => 'DELETED!');
        
        //$this->response($message, 200); // 200 being the HTTP response code
        
        if(!$this->get('id'))
        {
            $this->response(NULL, 400);
        }

        $response = $this->persons_model->deletePerson( $this->get('id') );
        if($response)
        {
            $message = array('id' => $this->get('id'), 'message' => 'DELETED!');
            $this->response($message, 200); // 200 being the HTTP response code
        }
        else
        {
            $message = array('id' => $this->get('id'), 'message' => 'ERROR DELETING!');

            $this->response($message, 422); // 422 being the HTTP response code
        } 
    }

############################################################################################

    public function send_post()
    {
        var_dump($this->request->body);
    }

############################################################################################
    
    public function send_put()
    {
        var_dump($this->put('foo'));
    }
}