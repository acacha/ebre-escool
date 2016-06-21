<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Qr extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
 
        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');

        $this->load->add_package_path(APPPATH.'third_party/CodeIgniter-PHP-QR-Code/');
        //echo APPPATH.'third_party/CodeIgniter-PHP-QR-Code/';
        
        $this->load->helper('php-barcode');

        $this->load->library('ciqrcode'); 
        $this->load->library('session');       
        
        //LOAD INVENTORY MODEL
		$this->load->model('inventory_model');
        
        /* Set language */
		$current_language=$this->session->userdata("current_language");
		if ($current_language == "") {
			$current_language= $this->config->item('default_language');
		}
    	$this->lang->load('inventory', $current_language);	 
    	
    	//LANGUAGE HELPER:
        $this->load->helper('language');
    }
	
    public function index()
    {
		$this->generate();
    }
    
    public function _getvar($name){
		if (isset($_GET[$name])) return $_GET[$name];
		else if (isset($_POST[$name])) return $_POST[$name];
		else return false;
	}
    
    public function barcode()
    {
		
	if (get_magic_quotes_gpc()){
		$code=stripslashes($this->_getvar('code'));
		$barcodetype=stripslashes($this->_getvar('barcodetype'));
		$scale=stripslashes($this->_getvar('scale'));
		$mode=stripslashes($this->_getvar('mode'));
	} else {
		$code=$this->_getvar('code');
		$barcodetype=$this->_getvar('barcodetype');
		$scale=$this->_getvar('scale');
		$mode=$this->_getvar('mode');
	}
	if (!$code) $code='123456789012';
	if (!$barcodetype) $barcodetype='128B';
	if (!$scale) $scale=3;
	if (!$mode) $mode="png";

	barcode_print($code,$barcodetype,$scale,$mode);		
	
	}
    
    public function generate($id=null)	{ 
		   
	if ($id==null) {
		show_error(lang("id_is_needed_to_generate_qr_codes"));
	}
	
	// **** QR CODE ****
	$base_read_url = base_url('index.php/inventory/index/read/');
	
	$qr_code_relative_url="/uploads/qrcodes/temp_qr_code.png";
	
	$base_read_url_with_id = $base_read_url ."/". $id;
	
	//Create QR code temporal file
	$params['data'] = $base_read_url_with_id;
	$params['level'] = 'H';
	$params['size'] = 6;
	
	$params['savename'] = FCPATH.$qr_code_relative_url;
	
	$this->ciqrcode->generate($params);
       
	$data['qr_code_url']=base_url().$qr_code_relative_url;
	$data['base_read_url_with_id']=$base_read_url_with_id;
	
	// ** BARCODE **
	//Obtain externalID, and externalIDType by inventory_objectid
	$base_url_barcode= base_url() . "index.php/inventory/qr/barcode"; 
	$url_barcode="";
	$bar_code_type="128B";
	$bar_code_value="";
	$externalIdInfo = $this->inventory_model->get_externalIdInfoByInventoryObjectId($id);
	
	if (!$externalIdInfo) {
		show_error(lang("InventoryObjectId_not_found"));
	}
	
	if ($externalIdInfo['externalID'] != "") {
		//ONLY SHOW BARCODE IF externalID is set
		$url_barcode=$base_url_barcode;
		$bar_code_type="128B";
		$bar_code_value=$externalIdInfo['externalID'];
		if ($externalIdInfo['externalIDType'] != "") {
			//Obtain barcodeId by externalIDType
			$barcodetype = $this->inventory_model->
				get_barcodetype_byExternalIDTypeID($externalIdInfo['externalIDType']);
						
			if ($barcodetype) {
				//VALIDATE $barcodetype
				$valid_barcodetype_values= array ("EAN","UPC","ISBN","39","128","128B");
				if (in_array($barcodetype,$valid_barcodetype_values))
					$bar_code_type=$barcodetype;
			}	
		}
		$url_barcode = $url_barcode . "?code=" . urlencode($bar_code_value);
		$url_barcode = $url_barcode . "&barcodetype=".$bar_code_type;
	}
	
	
	$data['bar_code_url']="";
	if ($url_barcode!="") {
		$data['bar_code_url']=$url_barcode;
		$data['bar_code_type'] = $bar_code_type;
		$data['bar_code_value'] = $bar_code_value;
	}
	
	// SHOW QR CODE AND BARCODE IF EXISTS                                           
	$output = $this->load->view('qr_view',$data,true);
	    
	if ( $this->_is_ajax()) {   
		//MODAL WINDOWS US AJAX
		$this->output->set_content_type('application/json');
		echo json_encode(array ("output" => $output));
	} else {
			echo $output;       
	}
}
    
    protected function _is_ajax()
	{
		return array_key_exists('is_ajax', $_POST) && $_POST['is_ajax'] == 'true' ? true: false;
	}
        
}
 
/* End of file qr.php */
/* Location: ./application/controllers/qr.php */
