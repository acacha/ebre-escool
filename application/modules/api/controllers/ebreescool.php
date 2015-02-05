<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Persons API
 *
 * @package     Ebre-escool
 * @subpackage  API
 * @category    Controller
 * @author         Sergi Tur Badenas
 * @link        http://acacha.org/meidawiki/index.php/ebre-escool
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class ebreescool extends REST_Controller
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

        $this->load->model('ebre_escool_auth_model');
        $this->load->model('api_model');

        $this->load->add_package_path(APPPATH.'third_party/skeleton/application/');
            $params = array('model' => "skeleton_auth_model");
            $this->load->library('skeleton_auth',$params);


    }

    public function index_get(){
        $this->person_get();
    }

    /*
    !!IMPORTANT!!
    DEPRECATED. SEE CONTROLLER ebreescool_login.php
    For better security password have to be hasehd no original password!
    Tried passwords are logged!
    */
    /*function login_post()
    {
        
        
    }*/

    
    function person_get()
    {
        if(!$this->get('id'))
        {
            $this->response(NULL, 400);
        }

        $person = $this->api_model->getPerson( $this->get('id') );
        //$person = $this->api_model->getPersonAlt( $this->get('id') );
        
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
    
    function person_post()
    {
        //$this->some_model->updateperson( $this->get('id') );
        $message = array('id' => $this->get('id'), 'name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function person_delete()
    {
        //$this->some_model->deletesomething( $this->get('id') );
        $message = array('id' => $this->get('id'), 'message' => 'DELETED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function persons_get()
    {
        //$persons = $this->some_model->getSomething( $this->get('limit') );
        $persons = array(
            array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com'),
            array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com'),
            3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => array('hobbies' => array('fartings', 'bikes'))),
        );
        
        if($persons)
        {
            $this->response($persons, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'Couldn\'t find any persons!'), 404);
        }
    }


    public function send_post()
    {
        var_dump($this->request->body);
    }

    private get_current_lesson(){
        $timestamp = time();
        log_message('debug', 'Timestamp: ' . $timestamp)
        $day = date("N",$timestamp);
        log_message('debug', 'Day of week: ')

    }


    public function send_put()
    {
        var_dump($this->put('foo'));
    }

    //Navegador d'horari/lliçons

    //IMPORTANT: Data actual la proporciona el servidor no li passa la app al servidor!

    //Partim de data i hora actual i professor --> Obtenir Lliço més propera
    //

    //mètode next_lesson()
    //-> PROBLEMA: Petició cada vegada que es passa? Lent? Fer una CAche?

    //mètode previous_lesson
    //->

    //Partim del professor obtenir les lliçons setmanals a la taula lessons. 

    /*
    
    BUCLE TOTES LES LLIÇONS {
        //INFO LLIÇO:
    }
    */

    /*
    * NOTES: On obtenir la informació
    * Control accés: Només poden utilitzar els usuaris que són professors
    * teacher_code: informació del perfil (SharedPreference
    * Utilitzar Pager: Navegar endavant endarrera per lliçons pertoquen al professor
    *  Per defecte mostrar la lliço que toca en aquell moment i sinó la més propera que sigui passada
    *  NO TOCARIA però mostrar lliçons futures. Recorrer l'horari de professor
    *
    * day/month/year/time_slot -> dia i hora
    */
    function check_attendance_get() {
        //GET PARAMETERS
        //$selected_group_id
        //$teacher_code
        //$selected_study_module_id
        //$lesson_id
        //$day 
        //$month
        //$year
        //$selected_time_slot_id
        if(!$this->get('id'))
        {
            $this->response(NULL, 400);
        }

    }
}