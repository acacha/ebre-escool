<?php
/**
 * ebre_escool library
 *
 * Common functions
 *
 * @package    	ebre_escool library
 * @author     	Sergi Tur <sergiturbadenas@gmail.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */

class ebre_escool  {
	
	
	function __construct()
    {
        $this->ci =& get_instance();
        
        // Load the language file
        //$this->ci->lang->load('ebre_escool_ldap','catalan');
        //$this->ci->load->helper('language');
        
        //log_message('debug', lang('ebre_escool_model_ldap_initialization'));

        // Load the configuration
        //$this->ci->load->config('auth_ldap');
        
        //$this->_init();
    }

    public function user_is_admin() {

        $current_user_id = $this->ci->session->userdata('id');
        $current_username = $this->ci->session->userdata('username');

        if ($current_username == "jcaldero" || $current_username == "sergi" || $current_username == "sergitur" || $current_username == "pdavila" || $current_username == "rmelich" || $current_username == "jrodriguez" || $current_username == "jordivega1" || $current_username == "admin") {
            return true;
        }

        /* TODO: a default user id is always admin? (similar to root in unix)
        if ($current_user_id == 0) {
            return true;
        }*/

        return false;
    }
    
    
}
