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

    //Hybrid_auth endpoint
    public function endpoint()
    {

        log_message('debug', 'controllers.HAuth.endpoint called.');
        log_message('info', 'controllers.HAuth.endpoint: $_REQUEST: '.print_r($_REQUEST, TRUE));

        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            log_message('debug', 'controllers.HAuth.endpoint: the request method is GET, copying REQUEST array into GET array.');
            $_GET = $_REQUEST;
        }

        log_message('debug', 'controllers.HAuth.endpoint: loading the original HybridAuth endpoint script.');
        require_once APPPATH.'/third_party/hybridauth/hybridauth/index.php';

    }

    public function login_hybrid_auth($provider)
    {
        log_message('debug', "controllers.HAuth.login($provider) called");
        try
        {
            log_message('debug', 'controllers.HAuth.login: loading HybridAuthLib');
            $this->load->library('HybridAuthLib');
            if ($this->hybridauthlib->providerEnabled($provider))
            {
                log_message('debug', "controllers.HAuth.login: service $provider enabled, trying to authenticate.");
                $service = $this->hybridauthlib->authenticate($provider);

                if ($service->isUserConnected())
                {
                    log_message('debug', 'controller.HAuth.login: user authenticated.');

                    $user_profile = $service->getUserProfile();

                    log_message('info', 'controllers.HAuth.login: user profile:'.PHP_EOL.print_r($user_profile, TRUE));

                    //Only valid for debug
                    $data['user_profile'] = $user_profile;

                    switch ($provider) {
                        case "Google":
                            //GET EMAIL--> GET EBRE-ESCOOL USER!
                            //LOGIN CORRECT --> POSTLOGIN ACTIONS
                            $email = $user_profile->email;
                            $identity = $this->skeleton_auth->check_if_identity_is_email_mysql($email);
                            
                            @$this->ebre_escool_auth_model->save_google_plus_profile_with_username($user_profile,$identity);
                            
                            $this->on_exit_login_hook($identity);
                            //FOR DEBUG uncomment this line comment next one: $this->load->view('hauth/done',$data);
                            redirect($this->after_succesful_login_page, 'refresh');
                            break;
                        case "Facebook":
                            $this->load->view('hauth/done',$data);
                            break;
                        case "Twitter":
                            $this->load->view('hauth/done',$data);
                            break;
                        default:
                            $this->load->view('hauth/done',$data);
                            break;    
                    }
                }
                else // Cannot authenticate user
                {
                    show_error('Cannot authenticate user');
                }
            }
            else // This service is not enabled.
            {
                log_message('error', 'controllers.HAuth.login: This provider is not enabled ('.$provider.')');
                show_404($_SERVER['REQUEST_URI']);
            }
        }
        catch(Exception $e)
        {
            $error = 'Unexpected error';
            switch($e->getCode())
            {
                case 0 : $error = 'Unspecified error.'; break;
                case 1 : $error = 'Hybriauth configuration error.'; break;
                case 2 : $error = 'Provider not properly configured.'; break;
                case 3 : $error = 'Unknown or disabled provider.'; break;
                case 4 : $error = 'Missing provider application credentials.'; break;
                case 5 : log_message('debug', 'controllers.HAuth.login: Authentification failed. The user has canceled the authentication or the provider refused the connection.');
                         //redirect();
                         if (isset($service))
                         {
                            log_message('debug', 'controllers.HAuth.login: logging out from service.');
                            $service->logout();
                         }
                         show_error('User has cancelled the authentication or the provider refused the connection.');
                         break;
                case 6 : $error = 'User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.';
                         break;
                case 7 : $error = 'User not connected to the provider.';
                         break;
            }

            if (isset($service))
            {
                $service->logout();
            }

            log_message('error', 'controllers.HAuth.login: '.$error);
            show_error('Error authenticating user. ' .$error);
        }
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