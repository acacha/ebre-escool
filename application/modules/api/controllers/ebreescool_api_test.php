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


class ebreescool_api_test extends CI_Controller
{
    function __construct()
    {

        parent::__construct();

        // Load the library
        $this->load->library('REST');

        $this->load->config('rest_client');

        // Set config options (only 'server' is required to work)

        //http://localhost/ebre-escool/index.php/api/ebreescool/person/id/1
        $config = array('server'          => 'http://localhost/ebre-escool/index.php/api/ebreescool/',
                        'api_key'         => $this->config->item('api_key'),
                        'api_name'        => 'X-API-KEY',
                        //'http_user'       => 'username',
                        //'http_pass'       => 'password',
                        //'http_auth'       => 'basic',
                        //'ssl_verify_peer' => TRUE,
                        //'ssl_cainfo'      => '/certs/cert.pem'
                        );

        // Run some setup
        $this->rest->initialize($config);

    }

    public function index(){
        // Pull in an array of tweets
        $person = $this->rest->get('person/id/1');

        echo json_encode($person);
        
    }

    public function test_login(){

        $username = "sergitur";
        $password = "PUT_YOUR_PASSWORD_HERE";
        $realm = "ldap";

        $post_array = array("username" => $username, "password" => $password, "realm" => $realm);
        
        // Pull in an array of tweets        
        $result = $this->rest->post('login',$post_array);
        echo "<br> STATUS CODE: " . $result = $this->rest->status() . "</br>";
        $result = $this->rest->debug();

        echo json_encode($result);
        
    }
    
}