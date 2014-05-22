<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once "application/third_party/skeleton/application/controllers/skeleton_main.php";

class Android_client extends CI_controller {


function __construct()
    {
		parent::__construct();

        //$params = array('model' => "skeleton_auth_model");
        //$this->load->library('skeleton_auth',$params);
        
        //CONFIG skeleton_auth library:
        $this->load->database();
        $this->load->library('grocery_CRUD');
        		$this->load->model('ebre_escool_esmaModel');

	}

	public function index(){
	       $this->load->model('ebre_escool_esmaModel','students');
	       $data['json'] = $this->ebre_escool_esmaModel->getUsersJson();
	       
	       return $data;
	}

}