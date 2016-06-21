<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author      Sergi Tur Badenas  <sergiturbadenas@gmail.com>
 * @copyright   Copyright © 2014 by Sergi Tur <sergiturbadenas@gmail.com>
 * @package     GoogleApps
 * @subpackage  configuration
 */

/**
 * Array Index      - Usage
 * client_id:               Client ID provided by Google Console API
 *        Example: 10456720172255-42i2r39sadwgbl58eof1rku5apau2kq7.apps.googleusercontent.com
 * service_account_email:   service account email provided by Google Console API
 *        Example: 10456720172255-42i2r39sadwgbl58eof1rku5apau2kq7@developer.gserviceaccount.com
 * key_file:                p12 key file path provided by Google Console API
 *        Example: /usr/share/google-apps/Ebre-escool-d823asd8fc5b3.p12
 * domain_admin_email:      Email of an user with admin rigths in Google Apps Domain
 *        Example: sergitur@iesebre.com
 * domain:      Google Apps Domain
 *        Example: iesebre.com
 */

$config['client_id'] ="1066020172255-42i2r394st4qbl58eof1rku5apau2kq7.apps.googleusercontent.com";		
$config['service_account_email'] = "1066020172255-42i2r394st4qbl58eof1rku5apau2kq7@developer.gserviceaccount.com";
$config['key_file'] = "/usr/share/gplus-domains-directory-sample-php/Ebre-escool-d847da8fc5b3.p12";
$config['domain_admin_email'] = 'sergitur@iesebre.com';
$config['domain'] = 'iesebre.com';


?>
