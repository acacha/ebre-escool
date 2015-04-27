<?php
/**
 * Ebre-escool inventory Model
 *
 *
 * @package    	Ebre-escool inventory model
 * @author     	Sergi Tur <sergiturbadenas@gmail.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-escool
 */
class inventory_Model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_primary_key($table_name) {
		$fields = $this->db->field_data($table_name);
		
		foreach ($fields as $field)	{
			if ($field->primary_key) {
					return $field->name;
			}
		} 	
		return false;
	}

	function get_last_added_value($table_name,$primary_key=null) {
		$primary_key_field_name;
		if ($primary_key==null)
			$primary_key_field_name=$this->get_primary_key($table_name);
		else
			$primary_key_field_name=$primary_key;
		
		$this->db->select($primary_key_field_name);
		$this->db->order_by($primary_key_field_name, "desc");
		$this->db->where("markedForDeletion", "n");
		$query = $this->db->get($table_name);
		if ($query->num_rows() != 0)
			return $query->row()->$primary_key_field_name;
		return false;
	}
    
    function get_dropdown_values($table_name,$field_name,$primary_key=null,$order_by="asc") {
		
		$primary_key_field_name;
		if ($primary_key==null)
			$primary_key_field_name=$this->get_primary_key($table_name);
		else
			$primary_key_field_name=$primary_key;
		
		$this->db->select("$primary_key_field_name,$field_name");
		$this->db->order_by($field_name, $order_by); 
		$this->db->where("markedForDeletion", "n"); 
		$query = $this->db->get($table_name);
		if ($query->num_rows() != 0)
			return $query->result();
		return false;
	}
    
    function user_have_preferences ($userid) {
		$this->db->where('userId',$userid);
		$query = $this->db->get('user_preferences');
		if ($query->num_rows() != 0)
			return true;
		return false;
	}
	
	function get_user_preferencesId ($userid) {
		$this->db->select('user_preferencesId');
		$this->db->where('userId',$userid);
		$query = $this->db->get('user_preferences');
		if ($query->num_rows() > 0)
			return $query->row()->user_preferencesId;
		else
			return false;
	}
	
	function get_user_theme($userid){
		$this->db->select('theme');
		$this->db->where('userId',$userid);
		$query = $this->db->get('user_preferences');
		if ($query->num_rows() > 0)
			return $query->row()->theme;
		else
			return false;
	}
	
	function get_user_dialogforms($userid){
		$this->db->select('dialogforms');
		$this->db->where('userId',$userid);
		$query = $this->db->get('user_preferences');
		if ($query->num_rows() > 0)
			return $query->row()->dialogforms;
		else
			return false;
	}
	
	function get_user_theme_by_username($username){
		$userid="TODO";
		return $this->get_user_theme($userid);
	}
	
	function get_organizational_units(){
		
		$this->db->select('organizational_unitId, name');
		$query = $this->db->get('organizational_unit');
		return $query->result_array();
	}

	function getAllorganizationalUnits(){
		$this->db->select('organizational_unit_Id, organizational_unit_name');
		$this->db->order_by("organizational_unit_name", "asc");
		$query = $this->db->get('organizational_unit');
		
		$organizational_units_array = array();

		foreach ($query->result_array() as $row)	{
   			$organizational_units_array[$row['organizational_unit_Id']] = $row['organizational_unit_name'];
		}
		return $organizational_units_array;
	}	

/*
`inventory_objectId` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_object_publicId` varchar(50) NOT NULL,
  `inventory_object_externalID` varchar(100) NOT NULL,
  `inventory_object_externalIDType` int(11) NOT NULL,
  `inventory_object_name` varchar(150) NOT NULL,
  `inventory_object_shortName` varchar(150) NOT NULL,
  `inventory_object_description` text,
  `inventory_object_location` int(11) DEFAULT NULL,
  `inventory_object_materialId` int(11) NOT NULL,
  `inventory_object_brandId` int(11) NOT NULL,
  `inventory_object_modelId` int(11) NOT NULL,
  `inventory_object_quantityInStock` smallint(6) NOT NULL,
  `inventory_object_price` double NOT NULL,
  `inventory_object_moneySourceId` int(11) DEFAULT NULL,
  `inventory_object_providerId` int(11) DEFAULT NULL,
  `inventory_object_preservationState` enum('Good','Regular','Bad') NOT NULL DEFAULT 'Good',
  `inventory_object_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `inventory_object_markedForDeletionDate` datetime NOT NULL,
  `inventory_object_file_url` varchar(250) NOT NULL,
  `inventory_object_mainOrganizationalUnitId` int(11) NOT NULL,
  `inventory_object_entryDate` datetime NOT NULL,
  `inventory_object_manualEntryDate` datetime NOT NULL,
  `inventory_object_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `inventory_object_manualLast_update` datetime NOT NULL,
  `inventory_object_creationUserId` int(11) DEFAULT NULL,
  `inventory_object_lastupdateUserId` int(11) DEFAULT NULL,



  <td style="font-size:x-small;" field-name="inventory_objectId" class="center"><?php echo $inventory_object->inventory_objectId;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_publicId"><?php echo $inventory_object->inventory_object_publicId;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_externalID"><?php echo $inventory_object->inventory_object_externalID;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_externalIDType"><?php echo $inventory_object->inventory_object_externalIDType;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_mainOrganizationalUnitId"><?php echo $inventory_object->inventory_object_mainOrganizationalUnitId;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_name"><?php echo $inventory_object->inventory_object_name;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_shortName"><?php echo $inventory_object->inventory_object_shortName;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_description"><?php echo $inventory_object->inventory_object_description;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_location"><?php echo $inventory_object->inventory_object_location;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_materialId"><?php echo $inventory_object->inventory_object_materialId;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_brandId"><?php echo $inventory_object->inventory_object_brandId;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_modelId"><?php echo $inventory_object->inventory_object_modelId;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_moneySourceId"><?php echo $inventory_object->inventory_object_moneySourceId;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_providerId"><?php echo $inventory_object->inventory_object_providerId;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_quantityInStock"><?php echo $inventory_object->inventory_object_quantityInStock;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_price"><?php echo $inventory_object->inventory_object_price;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_preservationState"><?php echo $inventory_object->inventory_object_preservationState;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_file_url"><?php echo $inventory_object->inventory_object_file_url;?></td>      
      <td style="font-size:x-small;" field-name="inventory_object_entryDate"><?php echo $inventory_object->inventory_object_entryDate;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_manualEntryDate"><?php echo $inventory_object->inventory_object_manualEntryDate;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_markedForDeletion"><?php echo $inventory_object->inventory_object_markedForDeletion;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_markedForDeletionDate"><?php echo $inventory_object->inventory_object_markedForDeletionDate;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_last_update"><?php echo $inventory_object->inventory_object_last_update;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_manualLast_update"><?php echo $inventory_object->inventory_object_manualLast_update;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_creationUserId"><?php echo $inventory_object->inventory_object_creationUserId;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_lastupdateUserId"><?php echo $inventory_object->inventory_object_lastupdateUserId;?></td>


*/
	function getAllInventoryObjects($selected = false) {
		$this->db->select('inventory_objectId,inventory_object_publicId, inventory_object_externalID, inventory_object_externalIDType,externalIDType_shortName,inventory_object_mainOrganizationalUnitId,organizational_unit_shortName,
			inventory_object_name,inventory_object_shortName,inventory_object_description,inventory_object_location,location_shortName,inventory_object_materialId,material_shortName,inventory_object_brandId,brand_shortName,
			inventory_object_modelId,model_shortName,inventory_object_moneySourceId,moneySource_shortName,inventory_object_providerId,provider_shortName,
			inventory_object_quantityInStock,inventory_object_price,inventory_object_preservationState,inventory_object_file_url,inventory_object_entryDate,inventory_object_manualEntryDate,
			inventory_object_markedForDeletion,inventory_object_markedForDeletionDate,inventory_object_last_update,inventory_object_manualLast_update,inventory_object_manualYearManufacture,
			inventory_object_creationUserId,inventory_object_lastupdateUserId');
 		$this->db->from('inventory_object');
 		$this->db->join('externalIDType', 'externalIDType.externalIDType_id = inventory_object.inventory_object_externalIDType','left');
		$this->db->join('organizational_unit', 'organizational_unit.organizational_unit_Id = inventory_object.inventory_object_mainOrganizationalUnitId','left');
		$this->db->join('location', 'location.location_id = inventory_object.inventory_object_location','left');
		$this->db->join('material', 'material.material_id = inventory_object.inventory_object_materialId','left');
		$this->db->join('brand', 'brand.brand_id = inventory_object.inventory_object_brandId','left');
		$this->db->join('model', 'model.model_id = inventory_object.inventory_object_modelId','left');
		$this->db->join('moneySource', 'moneySource.moneySource_id = inventory_object.inventory_object_moneySourceId','left');
		$this->db->join('provider', 'provider.provider_id = inventory_object.inventory_object_providerId','left');
		//print_r($selected);
		if($selected){

			$this->db->where(array_filter($selected));
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		$all_inventory_objects_array = array();

		foreach ($query->result() as $row)	{
			$row->creationUser = $this->getUserNameByUserId($row->inventory_object_creationUserId);
			$row->lastupdateUser = $this->getUserNameByUserId($row->inventory_object_lastupdateUserId);
			$all_inventory_objects_array[$row->inventory_objectId] = $row;
		}
		
		return $all_inventory_objects_array;
	}

	function getUserOrganizationalUnitNameFromId($ouid) {
		$this->db->select('organizational_unit_name');
		$this->db->from('organizational_unit');
		$this->db->where('organizational_unit_id', $ouid);

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$row = $query->row();
			return $row->organizational_unit_name;
		}			
		else {
			return "";
		}


	}

	function getUserMainOrganizationalUnit($userid) {

		$this->db->select('organizational_unit_Id,organizational_unit_name,organizational_unit_shortName');
		$this->db->from('users');
		$this->db->join('organizational_unit', 'users.mainOrganizationaUnitId = organizational_unit.organizational_unit_Id','left');
		$this->db->where('id', $userid);

		$query = $this->db->get();

		$row = $query->row();

		return $row;

	}

	function getUserNameByUserId($userid) {	
		$username = "";

		$this->db->select('username');
		$this->db->from('users');
		$this->db->where('id', $userid); 

		$row = $this->db->get()->row();

		return $row->username;
	}

	function getAllProviders() {
		$this->db->select('provider_id, provider_shortName');
		$this->db->order_by("provider_shortName", "asc"); 
		$query = $this->db->get('provider');
		
		$providers_array = array();

		foreach ($query->result_array() as $row)	{
   			$providers_array[$row['provider_id']] = $row['provider_shortName'];
		}
		return $providers_array;
	}

	function getAllProvidersByOrganizationalUnit($organizational_unit_id) {
		$this->db->select('provider_id, provider_shortName');
		$this->db->order_by("provider_shortName", "asc"); 
		$query = $this->db->get('provider');
		
		$providers_array = array();

		foreach ($query->result_array() as $row)	{
   			$providers_array[$row['provider_id']] = $row['provider_shortName'];
		}

		return $providers_array;
	}

	function getAllLocations() {
		$this->db->select('location_id, location_shortName');
		$this->db->order_by("location_shortName", "asc"); 
		$query = $this->db->get('location');

		$locations_array = array();

		foreach ($query->result_array() as $row)	{
   			$locations_array[$row['location_id']] = $row['location_shortName'];
		}
		return $locations_array;
	}

	function getAllMaterials() {
		$this->db->select('material_id, material_shortName');
		$this->db->order_by("material_shortName", "asc");
		$query = $this->db->get('material');
		
		$materials_array = array();

		foreach ($query->result_array() as $row)	{
   			$materials_array[$row['material_id']] = $row['material_shortName'];
		}
		return $materials_array;
	}

	function getAllBrands() {
		$this->db->select('brand_id, brand_shortName');
		$this->db->order_by("brand_shortName", "asc");
		$query = $this->db->get('brand');
		
		$brands_array = array();

		foreach ($query->result_array() as $row)	{
   			$brands_array[$row['brand_id']] = $row['brand_shortName'];
		}
		return $brands_array;
	}

	function getAllModels() {
		$this->db->select('model_id, model_shortName');
		$this->db->order_by("model_shortName", "asc");
		$query = $this->db->get('model');
		
		$models_array = array();

		foreach ($query->result_array() as $row)	{
   			$models_array[$row['model_id']] = $row['model_shortName'];
		}
		return $models_array;
	}

	function getAllUsers() {
		$this->db->select('id, first_name, last_name');
		$this->db->order_by("first_name", "asc");
		$query = $this->db->get('users');
		
		$users_array = array();

		foreach ($query->result_array() as $row)	{
   			$users_array[$row['id']] = $row['first_name']." ".$row['last_name'];
		}
		return $users_array;
	}

	function getAllMoneySources() {
		$this->db->select('moneySource_id, moneySource_shortName');
		$this->db->order_by("moneySource_shortName", "asc");
		$query = $this->db->get('moneySource');
		
		$money_sources_array = array();

		foreach ($query->result_array() as $row)	{
   			$money_sources_array[$row['moneySource_id']] = $row['moneySource_shortName'];
		}
		return $money_sources_array;
	}
	
	function get_main_organizational_unit_from_userid($userid){
		
		$this->db->select('mainOrganizationaUnitId');
		$this->db->where('id',$userid);
		$query = $this->db->get('users');
		return $query->row()->mainOrganizationaUnitId;
	}
	
	function get_main_organizational_unit_name_from_userid($userid){
		
		$unitid=$this->get_main_organizational_unit_from_userid($userid);
		$this->db->select('name');
		$this->db->where('organizational_unitId',$unitid);
		$query = $this->db->get('organizational_unit');
		if ($query->num_rows() > 0)
			return $query->row()->name;
		else
			return "";

	}
	
	function get_username_from_userid($userid){
		$this->db->select('username');
		$this->db->where('id',$userid);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0)
			return $query->row()->username;
		else
			return "";

	}
	

	function get_externalIdInfoByInventoryObjectId($inventory_objectid)	{
		$this->db->select('inventory_object_externalID,inventory_object_externalIDType');
		$this->db->where('inventory_objectId',$inventory_objectid);
		$query = $this->db->get('inventory_object');
		if ($query->num_rows() > 0)
			return array ("externalID" => $query->row()->inventory_object_externalID,
						  "externalIDType" => $query->row()->inventory_object_externalIDType);
		else
			return false;
	}
	
	function get_barcodetype_byExternalIDTypeID($externalIDTypeID)	{
		//Shortname is barcodetype (php-barcode format)
		$this->db->select('barcode.barcode_shortname');
		$this->db->from('externalIDType');
		$this->db->join('barcode', 'barcode.barcode_id = externalIDType.externalIDType_barcodeId','inner');
		$this->db->where('externalIDType_id',$externalIDTypeID);
		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query->row()->barcode_shortname;
		else
			return false;
	}
	
}
