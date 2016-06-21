<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Inventory Lang - Catalan
*
* Author: Sergi Tur Badenas
* 		  sergiturbadenas@gmail.com
*         @sergitur
*
* Author: ...
*         @....
*
*
* Created:  31.05.2013
*
* Description:  Català per a l'aplicació d'inventari
*
*/


//GENERAL
$lang['inventory']       		= 'Inventari';
/*
$lang['remember']       		= 'Recordar';

//LOGIN FORM
$lang['login-form-greetings']   = 'Si us plau, entreu';
$lang['User']   = 'Usuari';
$lang['Password']   = 'Paraula de pas';
$lang['Register']   = 'Registrar';
$lang['Login']   = 'Entrar';


// Camps
$lang['name']       		= 'Nom';
$lang['shortName']        	= 'Nom curt';           
$lang['description']            = 'Descripció';
$lang['entryDate']              = "Data d'entrada (automàtica)";
$lang['manualEntryDate']        = "Data d'entrada (manual)";
$lang['last_update']            = 'Última actualització (automàtica)';
$lang['manual_last_update']     = 'Última actualització (manual)';
$lang['creationUserId']         = 'Usuari de creació';
$lang['lastupdateUserId']       = 'Usuari darrera actualització';
$lang['materialId']             = 'Tipus de material';
$lang['brandId']             = 'Marca';
$lang['brand']             = 'Marca';
$lang['modelId']             = 'Model';
$lang['location']               = 'Ubicació';
$lang['quantityInStock']        = 'Quantitat'; 
$lang['price']                  = 'Preu'; 
$lang['moneySourceIdcolumn']    = 'Font dels diners'; 
$lang['providerId']             = 'Proveïdor'; 
$lang['preservationState']      = 'Estat de conservació'; 
$lang['markedForDeletion']      = 'Baixa lògica?'; 
$lang['markedForDeletionDate']  = 'Data de baixa'; 
$lang['file_url']               = 'Fitxer principal'; 
$lang['OwnerOrganizationalUnit']  = 'Unitat organitzativa'; 
$lang['mainOrganizationaUnitId']  = 'Unitat organitzativa principal'; 
$lang['publicId'] = 'Id públic';
$lang['externalId'] = 'Id extern';
$lang['externalID'] = 'Id extern';
$lang['externalIDType'] = 'Tipus Id extern';
$lang['Id'] = 'Id';
$lang['id'] = 'Id';
$lang['userId'] = "Id usuari";
$lang['theme'] = 'Tema';
$lang['barcodeId'] = 'Tipus de codi de barres';
$lang['dialogforms'] = 'Activar formularis en mode diàleg';


$lang['code'] = 'Codi';
$lang['parentLocation'] = 'Espai pare';
$lang['parentMaterialId'] = 'Material pare'; 

//SUBJECTS
$lang['object_subject'] = 'objecte';
$lang['externalID_subject']       		= 'identificador extern';
$lang['organizationalunit_subject']     = 'unitat organitzativa';
$lang['location_subject']     = 'ubicació';
$lang['material_subject']     = 'tipus material';
$lang['brand_subject']     = 'marca';
$lang['model_subject']     = 'model';
$lang['provider_subject']     = 'proveïdor';
$lang['money_source_id_subject'] = 'origen dels diners';
$lang['users_subject'] = 'usuari';
$lang['groups_subject'] = 'grup';
$lang['user_preferences_subject'] = "preferència usuari";
$lang['barcode_subject'] = "codi de barres";

//BUTTONS
$lang['reset'] = 'Reset';
$lang['select_all'] = 'Seleccionar tot';
$lang['unselect_all'] = 'Deseleccionar tot';
$lang['apply'] = 'Aplicar';

//PLACEHOLDERS
$lang['choose_fields'] = 'Escull els camps a mostrar';
$lang['fields_tho_show'] = 'Camps a mostrar';


//ACTIONS
$lang['Images'] = 'Imatges';
$lang['QRCode'] = 'Codi QR';
$lang['View'] = 'Veure';

//LOGIN & AUTH
$lang['CloseSession'] = 'Tancar Sessió';

//ERRORS
$lang['404_page_not_found'] = '404 Pàgina no trobada';
$lang['404_page_not_found_message'] = "La pàgina que heu demanat no s'ha pogut trobar";
$lang['table_not_found'] = 'Taula no trobada';
$lang['table_not_found_message'] = "La taula no s'ha pogut trobar";
$lang['InventoryObjectId_not_found']="No s'ha trobat el identificador del objecte a la base de dades";
 
//OPTIONS
$lang['Good'] = 'Bo';
$lang['Regular'] = 'Regular';
$lang['Bad'] = 'Dolent';
$lang['Yes'] = 'Si';
$lang['No'] = 'No';

//SUPPORTED LANGUAGES
$lang['language'] = 'Idioma';
$lang['catalan'] = 'Català';
$lang['spanish'] = 'Castellà';
$lang['english'] = 'Anglès';

$lang['ip_address'] = 'Adreça IP';
$lang['username'] = "Nom d'usuari";
$lang['email'] = 'Correu electrònic';
$lang['activation_code'] = "Codi d'activació";
$lang['forgotten_password_code'] = 'Codi paraula de pas oblidada';
$lang['forgotten_password_time'] = 'Temps de la paraula de pas oblidada' ;
$lang['remember_code'] = 'Codi de recuperació';
$lang['created_on'] = 'Creat el';
$lang['active'] = 'Actiu';
$lang['first_name'] = 'Nom';
$lang['last_name'] = 'Cognoms';
$lang['company'] = 'Companyia';
$lang['phone'] = 'Telèfon';


$lang['Filter by organizational units'] = 'Filtrar per unitats organitzatives';
$lang['choose_organization_unit'] = 'Escolliu una unitat organitzativa';
$lang['all_organizational_units'] = 'Totes les unitats organitzatives';

$lang['maintenance_mode_message'] = "El sistema es troba actualment en manteniment. No podeu entrar a l'aplicació en aquests moments, proveu més tard o poseu-vos en contacte amb l'administrador. Disculpeu les molèsties.";
$lang['maintenance_mode']="Mode manteniment";
$lang['maintenance_mode_login_error_message']="El login no és correcte";

$lang['grocerycrud_state_unknown']="Desconegut";
$lang['grocerycrud_state_listing']="Llistant";
$lang['grocerycrud_state_adding']="Afegint";
$lang['grocerycrud_state_editing']="Editant";
$lang['grocerycrud_state_deleting']="Esborrant";
$lang['grocerycrud_state_inserting']="inserting";
$lang['grocerycrud_state_updating']="Actualitzant";
$lang['grocerycrud_state_listing_ajax']="Llista ajax";
$lang['grocerycrud_state_listing_ajax_info']="Llista d'informació Ajax";
$lang['grocerycrud_state_inserting_validation']="Validant inserció";
$lang['grocerycrud_state_uploading_validation']="Validant pujada de fitxer";
$lang['grocerycrud_state_uploading_file']="Pujant fitxer";
$lang['grocerycrud_state_deleting_file']="Esborrant fitxer";
$lang['grocerycrud_state_ajax_relation']="Relació Ajax";
$lang['grocerycrud_state_ajax_relation_n_n']="Relació Ajax n_n";
$lang['grocerycrud_state_exit']="Èxit";
$lang['grocerycrud_state_exporting']="Exportant";
$lang['grocerycrud_state_printing']="Imprimint";

$lang['login_unsuccessful_not_allowed_role'] = "El login és correcte però l'usuari no té un rol adequat per accedir a l'aplicació";

$lang['user_info_title']="Informació de l'usuari";
$lang['user_id_title']="Identificador d'usuari";
$lang['username_title']="Nom d'usuari";
$lang['name_title']="Nom";
$lang['surname_title']="Cognoms";
$lang['email_title']="Correu electrònic";
$lang['realm_title']="Reialme";
$lang['user_groups_in_database']="Grups";
$lang['main_user_organizational_unit']="Unitat organitzativa principal";
$lang['rol_title']="Rol";
$lang['inventory_object_fields_title']="Camps per defecte dels objectes";
$lang['externalIDType_fields_title']="Camps per defecte dels identificadors externs";
$lang['organizational_unit_fields_title']="Camps per defecte de les unitats organitzatives";
$lang['location_fields_title']="Camps per defecte dels espais";
$lang['material_fields_title']="Camps per defecte dels tipus de material";
$lang['brand_fields_title']="Camps per defecte de les marques";
$lang['model_fields_title']="Camps per defecte dels models";
$lang['provider_fields_title']="Camps per defecte dels proveïdors";
$lang['money_source_fields_title']="Camps per defecte dels origens dels diners";
$lang['users_fields_title']="Camps per defecte dels usuaris";
$lang['groups_fields_title']="Camps per defecte dels grups";

$lang['come_back']="Tornar";

$lang['user_preferences_admin message1']="Es mostren les preferències de tots els usuaris perque sou un usuari amb un rol que ho permet.";
$lang['user_preferences_admin message2']="Podeu veure les vostres preferències ";
$lang['user_preferences_admin message3']="Podeu editar les vostres preferències ";
$lang['user_preferences_not_yet_message1']="Esteu utilitzant les preferències per defecte ja que encara no les heu definit.";
$lang['user_preferences_not_yet_message2']="Podeu crear les vostres preferències ";
$lang['here']="aquí";

$lang['operation_not_allowed']="Operació no permesa";
$lang['edit_not_allowed']="L'edició d'aquest registre no li està permesa al vostre usuari";
$lang['insert_not_allowed']="L'inserció d'aquest registre no li està permesa al vostre usuari";

$lang['verify_password']="Verificar paraula de pas";
$lang['MainOrganizationaUnitId']="Unitat organitzativa";

//QR
$lang['id_is_needed_to_generate_qr_codes']="Cal indicar un identificador per generar els codis de barres i codis QR";
$lang['inventory_object_url']="URL del objecte";

$lang['show_express_form']="Mostrar el formulari express";
$lang['hide_express_form']="Amagar el formulari express";

$lang['Add']="Afegir";
*/