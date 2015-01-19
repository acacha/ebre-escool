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

class Example extends REST_Controller {
    function __construct() {
        // Construct our parent class
        parent::__construct();
        
        // Configure limits on our controller methods. Ensure
        // you have created the 'limits' table and enabled 'limits'
        // within application/config/rest.php
        $this->methods['employee_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['employee_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['employee_delete']['limit'] = 50; //50 requests per hour per user/key
    }
    
    function employee_get()
    {
        if(!$this->get('id'))
        {
            $this->response(NULL, 400);
        }

        // $employee = $this->some_model->getSomething( $this->get('id') );
        $employees = array(
            1 => array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com', 'fact' => 'Loves swimming'),
            2 => array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com', 'fact' => 'Has a huge face'),
            3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => 'Is a Scott!', array('hobbies' => array('fartings', 'bikes'))),
        );
        
        $employee = @$employees[$this->get('id')];
        
        if($employee)
        {
            $this->response($employee, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }
    
    function employee_post() {
        //$this->some_model->updateEmployee( $this->get('id') );
        $message = array('id' => $this->get('id'), 'name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function employee_delete() {
        //$this->some_model->deletesomething( $this->get('id') );
        $message = array('id' => $this->get('id'), 'message' => 'DELETED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function employees_get() {
        //$employees = $this->some_model->getSomething( $this->get('limit') );
        $employees = array(
            array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com'),
            array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com'),
            3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => array('hobbies' => array('fartings', 'bikes'))),
        );
        
        if($employees) {
            $this->response($employees, 200); // 200 being the HTTP response code
        }

        else {
            $this->response(array('error' => 'Couldn\'t find any users!'), 404);
        }
    }


    public function send_post() {
        var_dump($this->request->body);
    }


    public function send_put() {
        var_dump($this->put('foo'));
    }
}