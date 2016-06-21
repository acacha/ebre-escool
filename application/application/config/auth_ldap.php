<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * This file is part of Auth_Ldap.

    Auth_Ldap is free software: you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Auth_Ldap is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Auth_Ldap.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

/**
 * @author      Greg Wojtak <gwojtak@techrockdo.com>
 * @copyright   Copyright © 2010,2011 by Greg Wojtak <gwojtak@techrockdo.com>
 * @package     Auth_Ldap
 * @subpackage  configuration
 * @license     GNU Lesser General Public License
 */

/**
 * Array Index      - Usage
 * hosts            - Array of ldap servers to try to authenticate against
 * ports            - The remote port on the ldap server to connect to
 * basedn           - The base dn of your ldap data store
 * login_attribute  - LDAP attribute used to check usernames against
 * proxy_user       - Distinguised name of a proxy user if your LDAP server does not allow anonymous binds
 * proxy pass       - Password to use with above
 * roles            - An array of role names to use within your app.  The values are arbitrary.  
 *                      The keys themselves represent the
 *			"security level," ie
 *			if( $security_level >= 3 ) {
 *				// Is a power user
 *				echo display_info_for_power_users_or_admins();
 *			}
 * member_attribute - Attribute to search to determine allowance after successful authentication
 * auditlog         - Location to log auditable events.  Needs to be writeable
 *                      by the web server
 */

$config['masterpassword'] ="fykiNE85zkudQ";
$config['hosts'] =array('192.168.50.30');
$config['ports'] = array(389);
$config['basedn'] = 'ou=All,dc=iesebre,dc=com';
$config['active_users_basedn'] = 'ou=All,dc=iesebre,dc=com';
$config['active_students_basedn'] = 'ou=Alumnes,'.$config['active_users_basedn'];
$config['active_teachers_basedn'] = 'ou=Profes,'.$config['active_users_basedn'];
$config['active_employees_basedn'] = 'ou=Personal,'.$config['active_users_basedn'];
$config['active_others_basedn'] = 'ou=Altres,'.$config['active_users_basedn'];
$config['groups_basedn'] = 'ou=maninfo,ou=Personal,'.$config['active_users_basedn'];
$config['login_attribute'] = 'uid';
$config['proxy_user'] = 'cn=admin,dc=iesebre,dc=com';
$config['proxy_pass'] = 'Ti4uH0KofysjE';
$config['member_attribute'] = 'memberUid';
$config['auditlog'] = 'application/logs/audit.log';  // Some place to log attempted logins (separate from message log)
		

?>
