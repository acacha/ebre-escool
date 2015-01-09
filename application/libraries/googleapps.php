<?php
/**
 * googleapps library
 *
 * Common functions
 *
 * @package    	googleapps library
 * @author     	Sergi Tur <sergiturbadenas@gmail.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */

set_include_path(get_include_path() . PATH_SEPARATOR . 'application/third_party/google-api-php-client/src');

require_once "Google/Client.php";
require_once "Google/Service/Directory.php";
//require_once "Google/Service/PlusDomains.php";

class googleapps  {
	
    private $client_id = null;
    private $service_account_email = null;
    private $key_file = null;
    private $domain_admin_email = null;
    private $domain = null;

    private $client;

    private $scopes = array("https://www.googleapis.com/auth/admin.directory.user");
	
	function __construct()
    {
        $this->ci =& get_instance();
        
        // Load the language file. Example
        //$this->ci->lang->load('ebre_escool_ldap','catalan');
        //$this->ci->load->helper('language');
        
        // Load the configuration
        $this->ci->load->config('googleapps');
        
        $this->_init();
    }

    /**
     * @access private
     * @return void
     */
    private function _init() {

        $this->client_id = $this->ci->config->item('client_id');
        $this->service_account_email = $this->ci->config->item('service_account_email');
        $this->key_file = $this->ci->config->item('key_file');
        $this->domain_admin_email = $this->ci->config->item('domain_admin_email');
        $this->domain = $this->ci->config->item('domain');

        $this->client = new Google_Client();
        $this->client->setApplicationName("Ebre-escool");
        $this->client->setClientId($this->client_id);

        $key = file_get_contents($this->key_file);
        $credentials = new Google_Auth_AssertionCredentials(
            $this->service_account_email,
            $this->scopes,
            $key);

        // Set the API Client to act on behalf of the domain admin
        $credentials->sub = $this->domain_admin_email;
        $this->client->setAssertionCredentials($credentials);
        
    }

    public function get_all_users() {

        $directoryService = new Google_Service_Directory($this->client);
        
        //All ldap users info
        $google_apps_users_info = array ();

        $pageToken = null;
        $counter=0;
        do {
            // Call to the Admin Directory API to retrieve a list of all Domain Users
            $result = 
                $directoryService->users->listUsers(
                    array("domain" => $this->domain,"maxResults" => 500,"pageToken" => $pageToken));

            if (isset($result->users)) {
                //var_dump($result);
                //DEBUG
                //echo "ETAG: " . $result->etag ." \n";
                //echo "NextPageToken: " . $result->nextPageToken ." \n";
                //echo "Kind: " . $result->kind ." \n";

                $nextPageToken = $result->nextPageToken;
                foreach ($result->users as $user) {
                  //printf("%s %s\n", $counter, $user->name->fullName);
                  //var_dump($user);
                  
                  $google_apps_users_info[$counter]['id'] = $user->id;
                  $google_apps_users_info[$counter]['etag'] = $user->etag;
                  $google_apps_users_info[$counter]['kind'] = $user->kind;
                  $google_apps_users_info[$counter]['primaryEmail'] = $user->primaryEmail;
                  $google_apps_users_info[$counter]['givenName'] = $user->name->givenName;
                  $google_apps_users_info[$counter]['familyName'] = $user->name->familyName;
                  $google_apps_users_info[$counter]['fullName'] = $user->name->fullName;
                  $google_apps_users_info[$counter]['isAdmin'] = $user->isAdmin;
                  $google_apps_users_info[$counter]['isDelegatedAdmin'] = $user->isDelegatedAdmin;
                  $google_apps_users_info[$counter]['lastLoginTime'] = $user->lastLoginTime;
                  $google_apps_users_info[$counter]['creationTime'] = $user->creationTime;
                  $google_apps_users_info[$counter]['deletionTime'] = $user->deletionTime;
                  $google_apps_users_info[$counter]['agreedToTerms'] = $user->agreedToTerms;
                  //Always NULL:
                  $google_apps_users_info[$counter]['password'] = $user->password;
                  $google_apps_users_info[$counter]['hashFunction'] = $user->hashFunction;
                  $google_apps_users_info[$counter]['suspended'] = $user->suspended;
                  $google_apps_users_info[$counter]['suspensionReason'] = $user->suspensionReason;
                  $google_apps_users_info[$counter]['changePasswordAtNextLogin'] = $user->changePasswordAtNextLogin;
                  $google_apps_users_info[$counter]['ipWhitelisted'] = $user->ipWhitelisted;
                  $google_apps_users_info[$counter]['orgUnitPath'] = $user->orgUnitPath;
                  $google_apps_users_info[$counter]['isMailboxSetup'] = $user->isMailboxSetup;
                  $google_apps_users_info[$counter]['includeInGlobalAddressList'] = $user->includeInGlobalAddressList;
                  $google_apps_users_info[$counter]['customerId'] = $user->customerId;
                  $google_apps_users_info[$counter]['thumbnailPhotoUrl'] = $user->thumbnailPhotoUrl;

                  $google_apps_users_info[$counter]['addresses'] = $user->addresses;
                  $google_apps_users_info[$counter]['aliases'] = $user->aliases;
                  $google_apps_users_info[$counter]['emails'] = $user->emails;
                  $google_apps_users_info[$counter]['externalIds'] = $user->externalIds;
                  $google_apps_users_info[$counter]['ims'] = $user->ims;

                  $counter++;
                }
            }
            $pageToken = $result->nextPageToken;
        } while ( $pageToken);

        return $google_apps_users_info;
    }
    
    
}
