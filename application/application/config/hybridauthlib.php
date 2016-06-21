<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

$config =
	array(
		// set on "base_url" the relative url that point to HybridAuth Endpoint
		'base_url' =>  base_url('/index.php/auth/hauth/endpoint'),

		"providers" => array (
			// openid providers
			"OpenID" => array (
				"enabled" => false
			),

			"Yahoo" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ),
			),

			"AOL"  => array (
				"enabled" => false
			),

			"Google" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "932895699540-7bcilqhutci33njuu1ogb3hiuakqu3j6.apps.googleusercontent.com", "secret" => "zyE1TiC-o_BY2uDbMuwcdil8" ),
				"hd"	  => "iesebre.com"
			),

			"Facebook" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "779450832121140", "secret" => "a1c9cb07d81ae3b0c9607b5c59531811" ),
			),

			"Twitter" => array (
				"enabled" => true,
				"keys"    => array ( "key" => "KbO1xJOPoeVPbzwj1ilzO8FkB", "secret" => "3Gg0YJUHTOI9Ej4SSai9Kz9jyYao3rI5NS4VzXqgJOi6MZer1G" )
			),

			// windows live
			"Live" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" )
			),

			"MySpace" => array (
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			"LinkedIn" => array (
				"enabled" => true,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			"Foursquare" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" )
			),
		),

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => (ENVIRONMENT == 'development'),

		"debug_file" => APPPATH.'/logs/hybridauth.log',
	);

return $config;
/* End of file hybridauthlib.php */
/* Location: ./application/config/hybridauthlib.php */