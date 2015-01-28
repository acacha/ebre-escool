<?php defined('BASEPATH') OR exit('No direct script access allowed');


require_once "application/third_party/skeleton/application/controllers/skeleton_auth/auth.php";

class ebre_escool_auth extends Auth {

    public $login_page = "skeleton_auth/ebre_escool_auth/login";

    public $reset_form_submit_url = 'skeleton_auth/ebre_escool_auth/reset_password/';
    public $forgotten_password_email_template = "skeleton_auth/ebre_escool_auth/reset_password";
    public $forgot_password_submit_url='index.php/skeleton_auth/ebre_escool_auth/forgot_password_';


    function __construct()
    {
		parent::__construct();

        $this->forgot_password_page="skeleton_auth/ebre_escool_auth/forgot_password";
    
        $this->load->model('ebre_escool_auth_model');

	}
	

    //log the user in
    function login()
    {
        parent::login();
    }

    //VOID: implement it on child classes
    public function on_exit_login_hook($username="") {
        //TODO: define default session data?
        $default_sessiondata = array(
                   'username'  => 'sergitur',
                   'email'     => 'sergiturbadenas@gmail.com',
                   'logged_in' => TRUE
               );

        if ($username == "") { 
            $sessiondata = $default_sessiondata;
        }   else {
            $sessiondata = $this->ebre_escool_auth_model->getSessionData($username);    
        }
        
        //Set session data:
        //echo "<br/>Session data:<br/>";
        //var_export($sessiondata);
        //echo "<br/><br/>";
        if (is_array($sessiondata)) {
            $this->session->set_userdata($sessiondata);    
        } else {
            $this->session->set_userdata(array());
        }
        
        //Check if user have to change password
        $force_change_password = $this->ebre_escool_auth_model->is_set_force_change_password($username); 
        if ($force_change_password) {
            $sessiondata_change_password = array(
                   'logged_in' => false,
                   'logged_in_change_password' => true,
               );
            $this->session->set_userdata($sessiondata_change_password);
            redirect("/managment/change_password", 'refresh');
        }

        return null;
    }

}