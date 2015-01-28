<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * API controlller for login
 *
 * @package     Ebre-escool
 * @subpackage  API
 * @category    Controller
 * @author         Sergi Tur Badenas
 * @link        http://acacha.org/meidawiki/index.php/ebre-escool
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class ebreescool_login extends REST_Controller
{

    public $LOGTAG = "EBRE_ESCOOL LOGIN API: ";

    function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
        // Configure limits on our controller methods. Ensure
        // you have created the 'limits' table and enabled 'limits'
        // within application/config/rest.php
        //TODO
        $this->methods['person_get']['limit'] = 500; //500 requests per hour per person/key
        
        $this->load->model('ebre_escool_auth_model');
        $this->load->model('api_model');

        $this->load->add_package_path(APPPATH.'third_party/skeleton/application/');
            $params = array('model' => "skeleton_auth_model");
            $this->load->library('skeleton_auth',$params);


    }

    /*
    For better security password have to be hashed. PLEASE NOT USE original passwords!
    BE CAREFUL! Passwords are logged to codeigniter log files at application/logs folder!

    AND ESPECIFIC API_KEY IS USED ONLY AUTHORIZED FOR LOGIN. Configure your database!
    */
    function login_post()   {
        
        log_message('debug', $this->LOGTAG . "Login_post called");

        $result = new stdClass();
        $result->message = "LOGIN POST";
        
        $username = $this->post('username');
        $password = $this->post('password');        
        $realm = $this->post('realm');

        //PASSWORDS can be logged when testing. Expected MD5 password no clear text
        log_message('debug', $this->LOGTAG . "Username: " . $username);
        //log_message('debug', $this->LOGTAG . "Password: " . $password);
        log_message('debug', $this->LOGTAG . "Realm: " . $realm);

        $result->username= $username;
        $result->password= $password;
        $result->realm= $realm;

        //VALIDATION
        if ($username == "" || !$result->username) {
            log_message('debug', $this->LOGTAG . "Incorrect username value");
            $result->message = "Incorrect username value";
            $this->response($result, 400);
        }

        if ($password == "" || !$result->password) {
            log_message('debug', $this->LOGTAG . "Incorrect password value");
            $result->message = "Incorrect password value!";
            $this->response($result, 400);
        }

        if ($realm == "" || !$result->realm || !$this->validate_realm($realm) ) {
            log_message('debug', $this->LOGTAG . "No valid realm specified");
            $result->message = "No valid realm specified!";
            $this->response($result, 400);
        }

        //Check if username exists --> Return 404 NOT FOUND!
        // TODO

        $this->skeleton_auth->skeleton_auth_model->setRealm($realm);
        
        log_message('debug', $this->LOGTAG . "password $password");

        if ($this->skeleton_auth->login($username, $password, false, true)) {
            //login is successful
            log_message('debug', $this->LOGTAG . "Login successful");
            
            $result->message = "Login successful!";
            $sessiondata = $this->ebre_escool_auth_model->getSessionData($username); 
            $result->sessiondata = $sessiondata;

            $api_user_profile = $this->ebre_escool_auth_model->getApiUserProfile($username);
            $result->api_user_profile = $api_user_profile;

            log_message('debug', $this->LOGTAG . " username: " . $username . " logged ok!");
            $this->response($result, 200);   
        } else {
            //Login was un-successful
            log_message('debug', $this->LOGTAG . "Login not successful");
            $result->message = "Login not successful!";
            $this->response($result, 400);   
        }

    }

    function validate_realm($realm){

        if ( (strcasecmp ( $realm , "ldap" ) == 0) || (strcasecmp ( $realm , "mysql" ) == 0) ) {
            return true;
        }
        return false;
    }
    
    
}