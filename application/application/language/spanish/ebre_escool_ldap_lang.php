<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Ldap Lang - English
*
* Author: Sergi Tur Badenas
* 		  sergiturbadenas@gmail.com
*         @sergitur
*
*
* Location: http://github.com/acacha
*
* Created:  03.09.2013
*
* Description:  English language file for Ion Auth Ldap views
*
*/

//ENROLLMENT
$lang['enrollment_str_title']="MATRÍCULA TIC";
$lang['enrollment_str_user']="Usuari";
$lang['enrollment_str_password']="Paraula de pas";
$lang['enrollment_str_internalid']="Identificador del centre";
$lang['enrollment_str_email']="Correu electrònic personal";
$lang['enrollment_str_corporative_email']="Correu electrònic del centre";
$lang['enrollment_str_userSignature']="Signatura de l'interessat/interessada";
$lang['enrollment_str_school_signature']="Signatura i segell del centre";
$lang['enrollment_str_userPageType']="Exemplar per a la persona interessada";
$lang['enrollment_str_school_page_type']="Exemplar per a la persona interessada";
$lang['enrollment_str_tutor_page_type']="Exemplar per al tutor";
$lang['enrollment_str_important_note']="IMPORTANT: La paraula de pas ha de ser PERSONAL i INTRANSFERIBLE, s'ha d'utilitzar en cura i no es pot deixar-la o prestar-la a altres usuaris. És la vostra responsabilitat no facilitar el vostre usuari o paraula de pas a NINGÚ. Queda expressament prohibit assumir la identitat d'altres usuaris.";

$date= date('j-m-y');	
setlocale(LC_TIME, "ca_ES.UTF-8");
$day_of_month = strftime("%e");
$month = strftime("%B");
$year = strftime("%G");

//TEXTS
//TEXT1 TODO
//$lang['enrollment_text1'] = <<<EOF
//En/Na $givenName $sn1 $sn2, amb número identificatiu $externalID, ha estat matriculat/da el $date per tal de tenir accés als recursos TIC de l'$this->high_school_name. Les dades que heu d'utilitzar per accedir als recursos TIC del centre són:
//EOF;
$lang['enrollment_text2'] = <<<EOF
En firmar aquesta matrícula esteu acceptant les normes d'ús dels recursos TIC del centre. Les normes les podeu consultar a: 


EOF;
$lang['enrollment_text3'] = <<<EOF
Amb el vostre compte d'usuari de centre podeu accedir a una sèrie de serveis que us ofereix el centre i que podeu consultar a:


EOF;
$lang['enrollment_text4'] = <<<EOF
En aquesta pàgina web també podeu trobar les instruccions per tal de modificar la vostra paraula de pas. És important que escolliu una paraula de pas prou segura i que us sigui fàcil de recordar. 

IMPORTANT: Si oblideu la vosta paraula de pas, la forma de recuperar-la serà enviar-vos una de nova a la vostra adreça de correu electrònic personal, per tant és molt important que ens proporcioneu una adreça de correu electrònic vàlida.

EOF;
$lang['enrollment_text5'] = <<<EOF
Tortosa, $day_of_month de $month de $year
EOF;

// Errors & LOGS
$lang['php_ldap_notpresent']='No està instal\·lada la funcionalitat de Ldap per PHP. Activeu el mòdul Ldap de PHP o utilitzeu un PHP amb suport per a Ldap compilat.';
$lang['successfully_authenticated_but_no_role']=" autenticat correctament, però no es permet l'accés perquè l'usuari no pertany a cap grup amb permisos per accedir a l'aplicació";
$lang['error_opening_audit_log']='Error obrint el log audit';
$lang['error_connecting_to']='Error connectant a';
$lang['could_not_connect_to_ldap']="No es pot connectar a cap dels servidors Ldap...";
$lang['error_connecting_to_ldap']="Error connectant als servidors Ldap. Si us plau reviseu la connexió i proveu un altre cop.";
$lang['unable_anonymous']="No s'ha pogut realitzar un bind anònim";
$lang['unable_bind']="No s'ha pogut realitzar el bind per localitzar el identificador del usuari";
$lang['successfully_bound']="S'ha realitzar el bind al servidor Ldap correctament. Realitzant la cerca del dn...";
$lang['error_searching_groups']='Error buscant el grup: ';
$lang['no_groups']="No es poden trobar els groups: ";
$lang['failed_login']='Intent de login erroni: ';
$lang['failed_login']=' de ';
$lang['has_no_role_to_play']=' no té cap rol assignat.';
$lang['succesful_login']='Login correcte: ';
$lang['from_ip']="origen";
$lang['failed_login']='Login incorrecte: ';

$lang['php_ldap_notpresent_log']='Funcionalitat Ldap de PHP no present.';
$lang['auth_ldap_initialization']='Auth_Ldap initialization ...';

