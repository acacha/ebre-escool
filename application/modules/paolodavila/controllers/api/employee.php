<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package     CodeIgniter
 * @subpackage  Rest Server
 * @category    Controller
 * @author      Phil Sturgeon
 * @link        http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Employee extends REST_Controller {

    //public $LOGTAG = "EBRE_ESCOOL API: ";

    function __construct() {
        // Construct our parent class
        parent::__construct();
        
        // Configure limits on our controller methods. Ensure
        // you have created the 'limits' table and enabled 'limits'
        // within application/config/rest.php
        $this->methods['employee_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['employee_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['employee_delete']['limit'] = 50; //50 requests per hour per user/key
        $this->methods['employee_put']['limit'] = 10; //10 requests per hour per user/key

        //Loading "employees_model.php" model.
        $this->load->model('employees_model');
    }    

    
    public function index_get(){
        $this->employees_get();
    }
    

    function employee_get(){

        if(!$this->get('id')){
            //$message = array('id'=>'','message'=>'YOU MUST SEND AND ID');
            $this->response(NULL, 400);
        }

        //$this->load->model('Employee_model');

        //$employee = $this->api_employees->employees_model->getEmployee( $this->get('id') );
        $employee = $this->employees_model->getEmployee( $this->get('id') );

        if($employee){
            $this->response($employee, 200); // 200 being the HTTP response code
        } else {
            //$this->response(array('id' => $this->get('id'),'message' => 'employee NOT EXISTS!'), 404);
            $this->response(array('error' => 'employee could not be found'), 404);
        }
    }

    function employees_get(){

        //$this->load->model('Employees_model');
        //$employees = $this->api_employees->employees_get();
        $employee = $this->employees_model->getEmployees();
    
        if($employee){
            $this->response($employee, 200); // 200 being the HTTP response code
        } else {
            $this->response(array('error' => 'Couldn\'t find any employees!'), 404);
        }
    }

    function employee_post(){

        if (isset($_POST)){
            //GET DATA FROM POST
            $id = $this->input->get_post('id');
            $data = array('employees_id'=>$this->input->get_post('employees_id'));

            //CALL TO MODEL
            $response = $this->employees_model->updateEmployees($id,$data);
        }

        if($response){
            $message = array('id' => $id, 'message' => 'UPDATED!');
            $this->response($message, 200); // 200 being the HTTP response code
        } else{
            $message = array('id' =>$id, 'message' => 'ERROR UPDATING!');
            $this->response($message, 404); // 404 being the HTTP response code(Not Found)
        }
        //$message = array('id' => $this->get('id'), 'name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
    }

    function employee_put(){
        
        $data = array(
        'employees_id'=>$this->put('employees_id'),
        'employees_person_id'=>$this->put('employees_person_id'),
        'employees_code'=>$this->put('employees_code'),
        'employees_type'=>$this->put('employees_type_id'),
        'employees_entryDate'=>$this->put('employees_entryDate'),
        'employees_last_update'=>$this->put('employees_last_update'),
        'employees_creationUserId'=>$this->put('employees_creationUserId'),
        'employees_markedForDeletion'=>$this->put('employees_markedForDeletion'),
        'employees_markedForDeletionDate'=>$this->put('employees_markedForDeletionDate'));

        $insertResponse = $this->employees_model->insertEmployees($data);
        //echo $insertResponse['response']." ".$insertResponse['id'];
        
        if($insertResponse['response']){
            $message = array('id' => $insertResponse['id'],'message' => 'NEW EMPLOYEE INSERTED');
            $this->response($message,200);//200 being the HTTP response code
        } else{
            $message = array('id' => $insertResponse['id'], 'message' => 'ERROR INSERTING');
            $this->response($message, 422); // 422 being the HTTP response code
        }
    }

    function employee_delete(){

        if(!$this->get('id')){
            $message = array('id'=>'','message'=>'YOU MUST SEND AN ID');
            $this->response($message, 400);
        }

        $response = $this->api_employees->deleteEmployees( $this->get('id') );
        
        if($response){
            $message = array('id' => $this->get('id'), 'message' => 'DELETED!');
            $this->response($message, 200); // 200 being the HTTP response code
        } else{
            $message = array('id' => $this->get('id'), 'message' => 'ERROR DELETING!');
            $this->response($message, 404); // 400 being the HTTP response code(Not Found)
        }
    }


    public function send_post() {
        var_dump($this->request->body);
    }


    public function send_put() {
        var_dump($this->put('foo'));
    }
}