<?php defined('BASEPATH') OR exit('No direct script access allowed');

include "application/third_party/skeleton/application/controllers/skeleton_main.php";


class persons extends skeleton_main {
	
	public $body_header_view ='include/ebre_escool_body_header.php' ;

  public $body_header_lang_file ='ebre_escool_body_header' ;

  public $html_header_view ='include/ebre_escool_html_header' ;

  public $body_footer_view ='include/ebre_escool_body_footer' ;
	
	function __construct()
    {
    parent::__construct();

        //GROCERY CRUD
		$this->load->add_package_path(APPPATH.'third_party/grocery-crud/application/');
        $this->load->library('grocery_CRUD');
        $this->load->add_package_path(APPPATH.'third_party/image-crud/application/');
		$this->load->library('image_CRUD');  

		/* Set language */
		$current_language=$this->session->userdata("current_language");
		if ($current_language == "") {
			$current_language= $this->config->item('default_language');
		}
		$this->lang->load('persons', $current_language);	       

		
        //LANGUAGE HELPER:
    $this->load->helper('language');

    $this->load->model('persons_model');
	}

  public function delete_person() {
    $active_menu = array();
    $active_menu['menu']='#maintenances';
    $active_menu['submenu1']='#persons';
    $active_menu['submenu2']='#person';

    $header_data= $this->load_ace_files($active_menu);  

    //$this->grocery_crud->add_fields($table_name.'_sn1',$table_name.'_sn2',$table_name.'_givenName',$table_name.'_entryDate');

    $this->_load_html_header($header_data); 
    $this->_load_body_header();      
  
    $data = array();
    
    $this->load->view('delete_user',$data); 
                
    $this->_load_body_footer();  

  }

  public function profile() {

    $active_menu = array();
    $active_menu['menu']='#managment';
    $active_menu['submenu1']='#user_profile';

    $header_data= $this->load_ace_files($active_menu); 

    $output = array();    

    $output['organizational_unit_name'] = $this->persons_model->getOrganizationalNameById($this->session->userdata('mainOrganizationaUnitId'));
    
    $person = $this->persons_model->getPersonalDataByPersonId($this->session->userdata('person_id'));

    $output['person'] = $person;

    $this->_load_html_header($header_data,$output); 
    $this->_load_body_header();      
  
    $this->load->view('profile',$output); 
                
    $this->_load_body_footer(); 
  }

	public function person_official_id_type() {
    
    $active_menu = array();
    $active_menu['menu']='#maintenances';
    $active_menu['submenu1']='#persons';
    $active_menu['submenu2']='#person_official_id_type';

    $this->check_logged_user(); 

    /* Ace */
    $header_data= $this->load_ace_files($active_menu);  

    /* Grocery Crud */ 
    $this->current_table="person_official_id_type";
    $this->grocery_crud->set_table($this->current_table);
        
    $this->session->set_flashdata('table_name', $this->current_table); 
		
    //Establish subject:
    $this->grocery_crud->set_subject("Tipus identificador personal");
        
    //SPECIFIC COLUMNS
    $this->grocery_crud->display_as($this->current_table.'_id',lang($this->current_table.'_id'));
    $this->grocery_crud->display_as($this->current_table.'_shortname',lang('shortName'));
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));

    $this->grocery_crud->display_as($this->current_table.'_entryDate',lang('entryDate'));        
    $this->grocery_crud->display_as($this->current_table.'_last_update',lang('last_update'));
    $this->grocery_crud->display_as($this->current_table.'_creationUserId',lang('creationUserId'));
    $this->grocery_crud->display_as($this->current_table.'_lastupdateUserId',lang('lastupdateUserId'));          
    $this->grocery_crud->display_as($this->current_table.'_markedForDeletion',lang('markedForDeletion'));   
    $this->grocery_crud->display_as($this->current_table.'_markedForDeletionDate',lang('markedForDeletionDate')); 

    //UPDATE AUTOMATIC FIELDS
    $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
    $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
    $this->userCreation_userModification($this->current_table);

    $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');
   


    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data);        
	}

	

	public function valida_nif_cif_nie($cif,$type) {
		//Copyright ©2005-2011 David Vidal Serra. Bajo licencia GNU GPL.
		//Este software viene SIN NINGUN TIPO DE GARANTIA; para saber mas detalles
		//puede consultar la licencia en http://www.gnu.org/licenses/gpl.txt(1)
		//Esto es software libre, y puede ser usado y redistribuirdo de acuerdo
		//con la condicion de que el autor jamas sera responsable de su uso.
		//Returns: 1 = NIF ok, 2 = CIF ok, 3 = NIE ok, -1 = NIF bad, -2 = CIF bad, -3 = NIE bad, 0 = ??? bad

		 $cif = strtoupper($cif);
         for ($i = 0; $i < 9; $i ++)
         {
                  $num[$i] = substr($cif, $i, 1);
         }
		//si no tiene un formato valido devuelve error
         if (!preg_match('/((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)/', $cif))
         {
         		  $this->form_validation->set_message(__FUNCTION__, lang('person_official_id_not_correct1'));
                  return false;
         }
		//comprobacion de NIFs estandar
         if (preg_match('/(^[0-9]{8}[A-Z]{1}$)/', $cif))
         {
                  if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 0, 8) % 23, 1))
                  {
                           if ($type==1)
                           		return true;
                           else {
                   		   		$this->form_validation->set_message(__FUNCTION__, lang('person_official_id_not_correct3'));
                           		return false;        	
                           }
                  }
                  else
                  {
                  		   $this->form_validation->set_message(__FUNCTION__, lang('person_official_id_not_correct2'));
                           return false;
                  }
         }
			//algoritmo para comprobacion de codigos tipo CIF
         $suma = $num[2] + $num[4] + $num[6];
         for ($i = 1; $i < 8; $i += 2)
         {
                  $suma += substr((2 * $num[$i]),0,1) + substr((2 * $num[$i]), 1, 1);
         }
         $n = 10 - substr($suma, strlen($suma) - 1, 1);
		//comprobacion de NIFs especiales (se calculan como CIFs o como NIFs)
         if (preg_match('/^[KLM]{1}/', $cif))
         {
                  if ($num[8] == chr(64 + $n) || $num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 1, 8) % 23, 1))
                  {
                  		if ($type==1)
                           		return true;
                        else {
                   		   		$this->form_validation->set_message(__FUNCTION__, lang('person_official_id_not_correct3'));
                           		return false;        	
                        }
                  }
                  else
                  {
                           return false;
                  }
         }
		//comprobacion de CIFs
         if (preg_match('/^[ABCDEFGHJNPQRSUVW]{1}/', $cif))
         {
                  if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1))
                  {
                        if ($type==1)
                           		return true;
                        else {
                   		   		$this->form_validation->set_message(__FUNCTION__, lang('person_official_id_not_correct3'));
                           		return false;        	
                        }
                  }
                  else
                  {
                           return false;
                  }
         }
		//comprobacion de NIEs
         if (preg_match('/^[XYZ]{1}/', $cif))
         {
                  if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X','Y','Z'), array('0','1','2'), $cif), 0, 8) % 23, 1))
                  {
                           if ($type==2)
                           		return true;
                        	else {
                   		   		$this->form_validation->set_message(__FUNCTION__, lang('person_official_id_not_correct5'));
                           		return false;        	
                        	}
                  }
                  else
                  {
                  		   $this->form_validation->set_message(__FUNCTION__, lang('person_official_id_not_correct4'));
                           return false;
                  }
         }
		//si todavia no se ha verificado devuelve error
         return false;
	}

  /* PERSON MODIFICADA */

  public function person ($filter_type = "") {

        $active_menu = array();
        $active_menu['menu']='#maintenances';
        $active_menu['submenu1']='#persons';
        $active_menu['submenu2']='#person';

        $header_data= $this->load_ace_files($active_menu);  


        $table_name="person";
        $this->session->set_flashdata('table_name', $table_name.'_');
        $this->grocery_crud->set_table($table_name);  
    
        //Establish subject:
        $this->grocery_crud->set_subject("persona");

        //Relacions
        $this->grocery_crud->set_relation('person_official_id_type','person_official_id_type','{person_official_id_type_shortname} - {person_official_id_type_id}',null,null,"persons");
        $this->grocery_crud->set_relation('person_locality_id','locality','{locality_name}');
        $this->grocery_crud->set_relation('person_bank_account_id','bank_account','{bank_account_entity_code}-{bank_account_office_code}-{bank_account_control_digit_code}-{bank_account_number}');        

        $this->grocery_crud->columns(
          $table_name.'_id',
          $table_name.'_sn1',
          $table_name.'_sn2',
          $table_name.'_givenName',
          $table_name.'_official_id',
          $table_name.'_homePostalAddress',
          $table_name.'_locality_id',
          $table_name.'_email',
          $table_name.'_telephoneNumber',
          $table_name.'_mobile',
          $table_name.'_photo',
          $table_name.'_bank_account_id');

        //$this->grocery_crud->add_fields($table_name.'_sn1',$table_name.'_sn2',$table_name.'_givenName',$table_name.'_entryDate');
        //$this->grocery_crud->edit_fields($table_name.'_sn1',$table_name.'_sn2',$table_name.'_givenName',$table_name.'_entryDate',$table_name.'_last_update');

        $this->grocery_crud->add_fields($table_name.'_official_id_type',$table_name.'_official_id',$table_name.'_sn1',$table_name.'_sn2',$table_name.'_givenName',$table_name.'_email',$table_name.'_homePostalAddress',$table_name.'_photo',$table_name.'_gender',
          $table_name.'_locality_id',$table_name.'_telephoneNumber',$table_name.'_mobile',$table_name.'_date_of_birth',$table_name.'_bank_account_id',$table_name.'_notes',$table_name.'_entryDate',$table_name.'_creationUserId',
          $table_name.'_lastupdateUserId',$table_name.'_markedForDeletion',$table_name.'_markedForDeletionDate');

        $this->grocery_crud->edit_fields($table_name.'_official_id_type',$table_name.'_official_id',$table_name.'_sn1',$table_name.'_sn2',$table_name.'_givenName',$table_name.'_email',$table_name.'_homePostalAddress',$table_name.'_photo',$table_name.'_gender',
          $table_name.'_locality_id',$table_name.'_telephoneNumber',$table_name.'_mobile',$table_name.'_date_of_birth',$table_name.'_bank_account_id',$table_name.'_notes',$table_name.'_entryDate',$table_name.'_last_update',$table_name.'_creationUserId',
          $table_name.'_lastupdateUserId',$table_name.'_markedForDeletion',$table_name.'_markedForDeletionDate');

        //Default column Names
        $this->grocery_crud->display_as($table_name.'_id',lang($table_name.'_id'));
        $this->grocery_crud->display_as($table_name.'_givenName',lang($table_name.'_givenName'));       
        $this->grocery_crud->display_as($table_name.'_sn1',lang($table_name.'_sn1'));       
        $this->grocery_crud->display_as($table_name.'_sn2',lang($table_name.'_sn2'));
        $this->grocery_crud->display_as($table_name.'_email',lang($table_name.'_email'));
        $this->grocery_crud->display_as($table_name.'_secondary_email',lang($table_name.'_secondary_email'));
        $this->grocery_crud->display_as($table_name.'_official_id',lang($table_name.'_official_id'));
        $this->grocery_crud->display_as($table_name.'_official_id_type',lang($table_name.'_official_id_type'));
        $this->grocery_crud->display_as($table_name.'_date_of_birth',lang($table_name.'_date_of_birth'));
        $this->grocery_crud->display_as($table_name.'_gender',lang($table_name.'_gender'));
        $this->grocery_crud->display_as($table_name.'_secondary_official_id',lang($table_name.'_secondary_official_id'));
        $this->grocery_crud->display_as($table_name.'_secondary_official_id_type',lang($table_name.'_secondary_official_id_type'));
        $this->grocery_crud->display_as($table_name.'_homePostalAddress',lang($table_name.'_homePostalAddress'));
        $this->grocery_crud->display_as($table_name.'_photo',lang($table_name.'_photo'));
        $this->grocery_crud->display_as($table_name.'_locality_id',lang($table_name.'_locality_id'));
        $this->grocery_crud->display_as($table_name.'_telephoneNumber',lang($table_name.'_telephone_number'));
        $this->grocery_crud->display_as($table_name.'_bank_account_id',lang($table_name.'_bank_account_id'));
        $this->grocery_crud->display_as($table_name.'_notes',lang($table_name.'_notes'));
        $this->grocery_crud->display_as($table_name.'_mobile',lang($table_name.'_mobile'));
        $this->grocery_crud->display_as($table_name.'_entryDate',lang($table_name.'_entryDate'));
        $this->grocery_crud->display_as($table_name.'_last_update',lang($table_name.'_last_update'));
        $this->grocery_crud->display_as($table_name.'_creationUserId',lang($table_name.'_creationUserId'));
        $this->grocery_crud->display_as($table_name.'_lastupdateUserId',lang($table_name.'_lastupdateUserId'));
        $this->grocery_crud->display_as($table_name.'_markedForDeletion',lang($table_name.'_markedForDeletion'));
        $this->grocery_crud->display_as($table_name.'_markedForDeletionDate',lang($table_name.'_markedForDeletionDate'));

        //Default Values
        $this->grocery_crud->set_default_value($table_name,'person_official_id_type',1);
        $this->grocery_crud->set_default_value($table_name,'person_markedForDeletion','n');
        
        //Callbacks
        $this->grocery_crud->callback_column($this->_unique_field_name('person_bank_account_id'),array($this,'_callback_person_bank_account_id_url'));
        $this->grocery_crud->callback_column('person_email',array($this,'_callback_person_email_url'));
        $this->grocery_crud->callback_column('person_secondary_email',array($this,'_callback_person_secondary_email_url'));
        $this->grocery_crud->callback_column($this->_unique_field_name('person_locality_id'),array($this,'_callback_person_locality_id_url'));
        
        //Usuari de Creació
        $this->grocery_crud->set_relation('person_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($table_name,'person_creationUserId',$this->session->userdata('user_id'));
        
        //Usuari Última Modificació
        $this->grocery_crud->set_relation('person_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($table_name,'person_lastupdateUserId',$this->session->userdata('user_id'));
        
        //Regles
        $this->grocery_crud->set_rules('person_official_id',lang('person_official_id'),'callback_valida_nif_cif_nie['.$this->input->post('person_official_id_type').']');
        $this->grocery_crud->set_rules('person_email',lang('person_email'),'valid_email');
        $this->grocery_crud->set_rules('person_secondary_email',lang('person_secondary_email'),'valid_email');
        $this->grocery_crud->allow_save_without_validation();

        //Camps last update no editable i automàtic  
        $this->grocery_crud->callback_add_field($table_name.'_entryDate',array($this,'add_field_callback_entryDate'));      
        $this->grocery_crud->callback_edit_field($table_name.'_entryDate',array($this,'edit_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field($table_name.'_last_update',array($this,'edit_callback_last_update'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_last_update'));

        $this->grocery_crud->set_field_upload('person_photo','uploads/person_photos');

        //print_r($this->session->flashdata('persons_filter'));


        if ( is_array($this->session->flashdata('persons_filter')) && $filter_type == "persons_filter"  ) {
          foreach ($this->session->flashdata('persons_filter') as $condition) {
            $this->grocery_crud->or_where('person_official_id',$condition);
            $this->grocery_crud->order_by($table_name.'_official_id','desc');
          }            
        }

        if (is_array($this->session->flashdata('without_photo_persons_id')) && $filter_type == "without_photo_persons_id" ) {
          foreach ($this->session->flashdata('without_photo_persons_id') as $condition) {
            $this->grocery_crud->or_where( $table_name . ".person_id",$condition);
          }            
        }

        $output = $this->grocery_crud->render();

        $this->_load_html_header($header_data,$output); 
        $this->_load_body_header();      
  
    $default_values=$this->_get_default_values();
    $default_values["table_name"]=$table_name;
    $default_values["field_prefix"]=$table_name."_";
    $this->load->view('defaultvalues_view.php',$default_values); 

    $this->load->view('persons',$output); 
                
    $this->_load_body_footer();  
  }



  /* FI PERSON MODIFICADA */

  /* PERSON ORIGINAL *//*
	public function person() {
		    $table_name="person";
        $this->grocery_crud->set_table($table_name);  
		
		    //Establish subject:
        $this->grocery_crud->set_subject("persona");

        //RELATIONS
        $this->grocery_crud->set_relation('person_official_id_type','person_official_id_type','{person_official_id_type_shortname} - {person_official_id_type_id}',null,null,"persons");
        //$this->grocery_crud->unset_dropdowndetails("person_official_id_type");

        $this->grocery_crud->set_relation('person_locality_id','locality','{locality_name}');
        $this->grocery_crud->set_relation('person_bank_account_id','bank_account','{bank_account_entity_code}-{bank_account_office_code}-{bank_account_control_digit_code}-{bank_account_number}');
        
        $this->grocery_crud->columns('person_id','person_sn1','person_sn2','person_givenName','person_official_id','person_homePostalAddress','person_locality_id','person_email','person_telephoneNumber','person_mobile','person_gender','person_bank_account_id');

        $this->grocery_crud->add_fields('person_official_id_type','person_official_id','person_sn1','person_sn2','person_givenName','person_email','person_homePostalAddress','person_gender',
        	'person_locality_id','person_telephoneNumber','person_mobile','person_date_of_birth','person_bank_account_id','person_notes','person_entryDate','person_creationUserId',
        	'person_lastupdateUserId','person_markedForDeletion','person_markedForDeletionDate');

        $this->grocery_crud->edit_fields('person_official_id_type','person_official_id','person_sn1','person_sn2','person_givenName','person_email','person_homePostalAddress','person_gender',
        	'person_locality_id','person_telephoneNumber','person_mobile','person_date_of_birth','person_bank_account_id','person_notes','person_entryDate','person_last_update','person_creationUserId',
        	'person_lastupdateUserId','person_markedForDeletion','person_markedForDeletionDate');

        $this->grocery_crud->unset_dropdowndetails("person_official_id_type");

        //Camps last update no editable i automàtic  

        $this->grocery_crud->callback_add_field('person_entryDate',array($this,'add_field_callback_entryDate'));      
        $this->grocery_crud->callback_edit_field('person_entryDate',array($this,'edit_field_callback_entryDate'));
        //$this->grocery_crud->callback_edit_field('person_last_update',array($this,'add_field_callback_entryDate'));

        $this->grocery_crud->display_as('person_id',lang('person_id'));
       	$this->grocery_crud->display_as('person_givenName',lang('person_givenName'));       
       	$this->grocery_crud->display_as('person_sn1',lang('person_sn1'));       
       	$this->grocery_crud->display_as('person_sn2',lang('person_sn2'));
       	$this->grocery_crud->display_as('person_email',lang('person_email'));
       	$this->grocery_crud->display_as('person_secondary_email',lang('person_secondary_email'));
       	$this->grocery_crud->display_as('person_official_id',lang('person_official_id'));
       	$this->grocery_crud->display_as('person_official_id_type',lang('person_official_id_type'));
       	$this->grocery_crud->display_as('person_date_of_birth',lang('person_date_of_birth'));
       	$this->grocery_crud->display_as('person_gender',lang('person_gender'));
       	$this->grocery_crud->display_as('person_secondary_official_id',lang('person_secondary_official_id'));
       	$this->grocery_crud->display_as('person_secondary_official_id_type',lang('person_secondary_official_id_type'));
       	$this->grocery_crud->display_as('person_homePostalAddress',lang('person_homePostalAddress'));
       	$this->grocery_crud->display_as('person_photo',lang('person_photo'));
       	$this->grocery_crud->display_as('person_locality_id',lang('person_locality_id'));
       	$this->grocery_crud->display_as('person_telephoneNumber',lang('person_telephone_number'));
       	$this->grocery_crud->display_as('person_bank_account_id',lang('person_bank_account_id'));
       	$this->grocery_crud->display_as('person_notes',lang('person_notes'));
       	$this->grocery_crud->display_as('person_mobile',lang('person_mobile'));
       	$this->grocery_crud->display_as('person_entryDate',lang('person_entryDate'));
       	$this->grocery_crud->display_as('person_last_update',lang('person_last_update'));
       	$this->grocery_crud->display_as('person_creationUserId',lang('person_creationUserId'));
       	$this->grocery_crud->display_as('person_lastupdateUserId',lang('person_lastupdateUserId'));
       	$this->grocery_crud->display_as('person_markedForDeletion',lang('person_markedForDeletion'));
       	$this->grocery_crud->display_as('person_markedForDeletionDate',lang('person_markedForDeletionDate'));

        //UPDATE AUTOMATIC FIELDS
        $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
        $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));

        //$this->grocery_crud->callback_before_insert(array($this,'before_insert_user_preference_callback'));
        
        $this->grocery_crud->unset_add_fields('person_lastupdate');

 		    $this->grocery_crud->set_default_value($table_name,'person_official_id_type',1);
        //$this->grocery_crud->set_default_value($table_name,'person_creationUserId','TODO');
        
        $this->grocery_crud->set_default_value($table_name,'person_markedForDeletion','n');

        //CALLBACKS
        $this->grocery_crud->callback_column($this->_unique_field_name('person_bank_account_id'),array($this,'_callback_person_bank_account_id_url'));
        $this->grocery_crud->callback_column('person_email',array($this,'_callback_person_email_url'));
        $this->grocery_crud->callback_column('person_secondary_email',array($this,'_callback_person_secondary_email_url'));
		    $this->grocery_crud->callback_column($this->_unique_field_name('person_locality_id'),array($this,'_callback_person_locality_id_url'));
        
        //$this->grocery_crud->callback_add_field('person_entryDate',array($this,'add_field_callback_entryDate')); 

        //USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
        $this->grocery_crud->set_relation('person_creationUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($table_name,'person_creationUserId',$this->session->userdata('user_id'));

        //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
        $this->grocery_crud->set_relation('person_lastupdateUserId','users','{username}',array('active' => '1'));
        $this->grocery_crud->set_default_value($table_name,'person_lastupdateUserId',$this->session->userdata('user_id'));

        //$this->grocery_crud->unset_dropdowndetails("person_creationUserId","person_lastupdateUserId");
        
       	//validations:
       	$this->grocery_crud->set_rules('person_official_id',lang('person_official_id'),'callback_valida_nif_cif_nie['.$this->input->post('person_official_id_type').']');

       	$this->grocery_crud->set_rules('person_email',lang('person_email'),'valid_email');
       	$this->grocery_crud->set_rules('person_secondary_email',lang('person_secondary_email'),'valid_email');

        $this->grocery_crud->allow_save_without_validation();

        $output = $this->grocery_crud->render();

		$this->_load_html_header($this->_get_html_header_data(),$output); 
		$this->_load_body_header();
	
    $default_values=$this->_get_default_values();
    $default_values["table_name"]=$table_name;
    $default_values["field_prefix"]=$table_name."_";
    $this->load->view('defaultvalues_view.php',$default_values); 

		$this->load->view('persons',$output); 
                
		$this->_load_body_footer();	 
	}
  *//* FI PERSON ORIGINAL */


	protected function _unique_field_name($field_name)
    {
    	return 's'.substr(md5($field_name),0,8); //This s is because is better for a string to begin with a letter and not with a number
    }

	
	public function index() {
		$this->person();
	}
	
	public function localities() {

    $active_menu = array();
    $active_menu['menu']='#maintenances';
    $active_menu['submenu1']='#persons';
    $active_menu['submenu2']='#localities';
    
    $this->check_logged_user(); 

    /* Ace */
    $header_data= $this->load_ace_files($active_menu);  

    /* Grocery Crud */ 
    $this->current_table="locality";
    $this->grocery_crud->set_table($this->current_table);
        
    $this->session->set_flashdata('table_name', $this->current_table); 
    
    //Establish subject:
    $this->grocery_crud->set_subject(lang($this->current_table.'_subject'));
        
    //SPECIFIC COLUMNS
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));        
    $this->grocery_crud->display_as($this->current_table.'_parent_locality_id',lang($this->current_table.'_parent_locality_id'));
    $this->grocery_crud->display_as($this->current_table.'_state_id',lang($this->current_table.'_state_id'));
    $this->grocery_crud->display_as($this->current_table.'_ine_id',lang($this->current_table.'_ine_id'));          
    $this->grocery_crud->display_as($this->current_table.'_aeat_id',lang($this->current_table.'_aeat_id'));   
    $this->grocery_crud->display_as($this->current_table.'_postal_code',lang($this->current_table.'_postal_code')); 

    $this->grocery_crud->display_as($this->current_table.'_entryDate',lang('entryDate'));        
    $this->grocery_crud->display_as($this->current_table.'_last_update',lang('last_update'));
    $this->grocery_crud->display_as($this->current_table.'_creationUserId',lang('creationUserId'));
    $this->grocery_crud->display_as($this->current_table.'_lastupdateUserId',lang('lastupdateUserId'));          
    $this->grocery_crud->display_as($this->current_table.'_markedForDeletion',lang('markedForDeletion'));   
    $this->grocery_crud->display_as($this->current_table.'_markedForDeletionDate',lang('markedForDeletionDate')); 

    //UPDATE AUTOMATIC FIELDS
    $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
    $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
    $this->userCreation_userModification($this->current_table);

    $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');
   
    //RELACIONS
    $this->grocery_crud->set_relation($this->current_table.'_parent_locality_id','locality','{locality_name}');
    $this->grocery_crud->set_relation($this->current_table.'_state_id','state','{state_name}');

    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data); 

	}
	
	public function states() {
		
    $active_menu = array();
    $active_menu['menu']='#maintenances';
    $active_menu['submenu1']='#persons';
    $active_menu['submenu2']='#states';

    $this->check_logged_user(); 

    /* Ace */
    $header_data= $this->load_ace_files($active_menu);  

    /* Grocery Crud */ 
    $this->current_table="state";
    $this->grocery_crud->set_table($this->current_table);
    $this->session->set_flashdata('table_name', $this->current_table); 
    
    //Establish subject:
    $this->grocery_crud->set_subject(lang($this->current_table.'_subject'));
        
    $this->common_callbacks($this->current_table);

    //SPECIFIC COLUMNS
    $this->grocery_crud->display_as($this->current_table.'_name',lang('name'));        
    $this->grocery_crud->display_as($this->current_table.'_parent_state_id',lang($this->current_table.'_parent_state_id'));
    $this->grocery_crud->display_as($this->current_table.'_parent_state_name',lang($this->current_table.'_parent_state_name'));

    $this->grocery_crud->display_as($this->current_table.'_entryDate',lang('entryDate'));        
    $this->grocery_crud->display_as($this->current_table.'_last_update',lang('last_update'));
    $this->grocery_crud->display_as($this->current_table.'_creationUserId',lang('creationUserId'));
    $this->grocery_crud->display_as($this->current_table.'_lastupdateUserId',lang('lastupdateUserId'));          
    $this->grocery_crud->display_as($this->current_table.'_markedForDeletion',lang('markedForDeletion'));   
    $this->grocery_crud->display_as($this->current_table.'_markedForDeletionDate',lang('markedForDeletionDate')); 

    //UPDATE AUTOMATIC FIELDS
    $this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
    $this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
    $this->grocery_crud->unset_add_fields($this->current_table.'_last_update');
        
    $this->userCreation_userModification($this->current_table);

    $this->grocery_crud->unset_dropdowndetails($this->current_table.'_creationUserId',$this->current_table.'_lastupdateUserId');

    $this->grocery_crud->set_default_value($this->current_table,$this->current_table.'_markedForDeletion','n');

    $this->renderitzar($this->current_table,$header_data); 

	}

function check_logged_user()
{
    if (!$this->skeleton_auth->logged_in())
    {
        //redirect them to the login page
        redirect($this->skeleton_auth->login_page, 'refresh');
    }

    //CHECK IF USER IS READONLY --> unset add, edit & delete actions
    $readonly_group = $this->config->item('readonly_group');
    if ($this->skeleton_auth->in_group($readonly_group)) {
        $this->grocery_crud->unset_add();
        $this->grocery_crud->unset_edit();
        $this->grocery_crud->unset_delete();
    }
}


function userCreation_userModification($table_name)
{   
    //USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_insert_object_callback
    $this->grocery_crud->set_relation($table_name.'_creationUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($table_name,$table_name.'_creationUserId',$this->session->userdata('user_id'));

    //LAST UPDATE USER ID: show only active users and by default select current userid. IMPORTANT: Field is not editable, always forced to current userid by before_update_object_callback
    $this->grocery_crud->set_relation($table_name.'_lastupdateUserId','users','{username}',array('active' => '1'));
    $this->grocery_crud->set_default_value($table_name,$table_name.'_lastupdateUserId',$this->session->userdata('user_id'));
}

function renderitzar($table_name,$header_data)
{
       $output = $this->grocery_crud->render();

       // HTML HEADER
       
       $this->_load_html_header($header_data,$output); 
    
       // BODY       

       $this->_load_body_header();
       
       $default_values=$this->_get_default_values();
       $default_values["table_name"]=$table_name;
       $default_values["field_prefix"]=$table_name."_";
       $this->load->view('defaultvalues_view.php',$default_values); 

       //$this->load->view('course.php',$output);     
       $this->load->view($table_name.'.php',$output);     
       
       //      FOOTER     
       $this->_load_body_footer();  

}

function load_ace_files($active_menu){

$header_data= $this->add_css_to_html_header_data(
            $this->_get_html_header_data(),
            "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css");

        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/ace-fonts.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/ace.min.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/ace-responsive.min.css'));
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
                base_url('assets/css/ace-skins.min.css'));
/*                      
        $header_data= $this->add_css_to_html_header_data(
            $header_data,
            base_url('assets/css/no_padding_top.css'));  
*/

        //JS
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/jquery-1.9.1.js");
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            "http://code.jquery.com/ui/1.10.3/jquery-ui.js");   

        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
            base_url('assets/js/ace-extra.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace-elements.min.js'));
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/ace.min.js'));    
        $header_data= $this->add_javascript_to_html_header_data(
            $header_data,
                base_url('assets/js/jquery.slimscroll.min.js'));    
        $header_data= $this->add_javascript_to_html_header_data(
                    $header_data,
                    base_url('assets/js/ebre-escool.js'));


        $header_data['menu']= $active_menu;
        return $header_data;
}

  //CALLBACKS
function common_callbacks()
{
        //CALLBACKS        
        $this->grocery_crud->callback_add_field($this->session->flashdata('table_name').'_entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field($this->session->flashdata('table_name').'_entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field($this->session->flashdata('table_name').'_last_update',array($this,'edit_callback_last_update'));
}

  public function edit_field_callback_entryDate($value, $primary_key){
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
  }

  public function edit_callback_last_update($value, $primary_key){

    $data = date('d/m/Y H:i:s', time());
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. $data .'"  name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';

  }

  public function before_update_last_update($post_array, $primary_key) {
    $data= date('d/m/Y H:i:s', time());
    //$post_array['person_last_update'] = $data;
    $post_array[$this->session->flashdata('table_name').'_last_update'] = $data;
    //$post_array['lastupdateUserId'] = $this->session->userdata('user_id');
    return $post_array;
}  

public function add_field_callback_entryDate(){  

    $data= date('d/m/Y H:i:s', time());
    //return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="person_entryDate" id="field-entryDate" readonly>';    
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="'.$this->session->flashdata('table_name').'_entryDate" id="field-entryDate" readonly>';    
}

public function add_callback_last_update(){  
   
    return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" name="'.$this->session->flashdata('table_name').'_last_update" id="field-last_update" readonly>';
}  

  public function _callback_person_bank_account_id_url($value, $row)  {
    if (isset($row->person_bank_account_id))
      return "<a href='". base_url('/index.php/banks/bank_account/edit/') . "/" . $row->person_bank_account_id ."'>". $value . "</a>";
    else
      return $value;
  }

  public function _callback_person_locality_id_url($value, $row)  {
    if (isset($row->person_locality_id))
      return "<a href='". base_url('/index.php/persons/localities/edit/') . "/" . $row->person_locality_id ."'>". $value . "</a>";
    else
      return $value;
  }

  public function _callback_person_email_url($value, $row)  {
    if (isset($row->person_email))
      return "<a href='mailto:". $value . "'>" . $value . "</a>";
      else
      return $value;
  }

  public function _callback_person_secondary_email_url($value, $row)  {
    if (isset($row->person_secondary_email))
      return "<a href='mailto:". $value . "'>" . $value . "</a>";
      else
      return $value;
  }


}
