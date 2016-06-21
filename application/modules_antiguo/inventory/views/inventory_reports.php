<div class="main-content">
 
<div id="breadcrumbs" class="breadcrumbs">
 <script type="text/javascript">
  try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
 </script>

<script>

  $(document).ready(function(){
    $(".dd2-content").click(function(){
      alert($(this).text());

    });
  });

</script> 

 <ul class="breadcrumb">
  <li>
   <i class="icon-home home-icon"></i>
   <a href="<?php echo base_url();?>">Home</a>
   <span class="divider">
    <i class="icon-angle-right arrow-icon"></i>
   </span>
  </li>
  <li class="active"><a href="<?php echo base_url('/index.php/inventory/inventory');?>"><?php echo lang('inventory');?></a></li>
 </ul>
</div>

<div class="page-content">

<div class="page-header position-relative">
                        <h1>
                            <a href="<?php echo base_url('index.php/inventory/inventory');?>"><?php echo lang("inventory");?></a>
                            <small>
                                <i class="icon-double-angle-right"></i>
                                Informes
                            </small>
                        </h1>
</div>

<div class="space-3"></div>

              <div class="row-fluid">
                
                <div class="span1"></div>


                <div class="span5 widget-container-span">
                  <div class="widget-box collapsed">
                    <div class="widget-header widget-header-small header-color-orange">
                      <h6>
                        <i class="icon-sort"></i>
                        Filtres
                      </h6>

                      <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                          <i class="icon-chevron-down"></i>
                        </a>

                        <a href="#" data-action="close">
                          <i class="icon-remove"></i>
                        </a>
                      </div>
                    </div>

                    <div class="widget-body">
                      <div class="widget-main">                        

                    <ol class="dd-list">

                      <!-- Unitat Organitzativa --> 
                      <li class="dd-item dd2-item" data-id="13">
                        <i class="normal-icon icon-download-alt blue bigger-130"></i>
                        <?php echo lang("organizational_unit");?><br />
                        <select id="organizational_unit_name" style="width: 400px">
                          <option value="all">Tots</option>
                          <?php foreach( (array) $organizational_units as $key => $value): ?>
                              <option value="<?php echo $key; ?>" <?php if(isset($selected["organizational_unit"])&&($key == $selected["organizational_unit"])){?> selected <?php } ?> ><?php echo $value; ?></option>
                          <?php endforeach; ?> 
                        </select> 
                      </li>

                      <!-- Materials --> 
                      <li class="dd-item dd2-item" data-id="13">
                        <i class="normal-icon icon-download-alt blue bigger-130"></i>
                        <?php echo lang("material_menu");?><br />
                        <select id="material" style="width: 400px">
                          <option value="all">Tots</option>
                          <?php foreach( (array) $materials as $key => $value): ?>
                              <option value="<?php echo $key; ?>" <?php if(isset($selected["material"])&&($key == $selected["material"])){?> selected <?php } ?>><?php echo $value; ?></option>
                          <?php endforeach; ?> 
                        </select> 
                      </li>

                      <!-- Ubicació --> 
                      <li class="dd-item dd2-item" data-id="13">
                        <i class="normal-icon icon-download-alt blue bigger-130"></i>
                        <?php echo lang("location");?><br />
                        <select id="location_name" style="width: 400px">
                          <option value="all">Tots</option>
                          <?php foreach( (array) $locations as $key => $value): ?>
                              <option value="<?php echo $key; ?>" <?php if(isset($selected["location"])&&($key == $selected["location"])){?> selected <?php } ?>><?php echo $value; ?></option>
                          <?php endforeach; ?> 
                        </select>
                      </li>

                      <!-- Marca --> 
                      <li class="dd-item dd2-item" data-id="13">
                        <i class="normal-icon icon-download-alt blue bigger-130"></i>
                        <?php echo lang("brand_menu");?><br />
                        <select id="brands" style="width: 400px">
                          <option value="all">Tots</option>
                          <?php foreach( (array) $brands as $key => $value): ?>
                              <option value="<?php echo $key; ?>" <?php if(isset($selected["brand"])&&($key == $selected["brand"])){?> selected <?php } ?> ><?php echo $value; ?></option>
                          <?php endforeach; ?> 
                        </select> 
                      </li>

                      <!-- Model --> 
                      <li class="dd-item dd2-item" data-id="13">
                        <i class="normal-icon icon-download-alt blue bigger-130"></i>
                        <?php echo lang("model_menu");?><br />
                        <select id="model" style="width: 400px">
                          <option value="all">Tots</option>
                          <?php foreach( (array) $models as $key => $value): ?>
                              <option value="<?php echo $key; ?>" <?php if(isset($selected["model"])&&($key == $selected["model"])){?> selected <?php } ?>><?php echo $value; ?></option>
                          <?php endforeach; ?> 
                        </select> 
                      </li>

                      <!-- Proveïdor --> 
                      <li class="dd-item dd2-item" data-id="13">
                        <i class="normal-icon icon-download-alt blue bigger-130"></i>
                        <?php echo lang("provider_menu");?><br />
                        <select id="provider" style="width: 400px">
                          <option value="all">Tots</option>
                          <?php foreach( (array) $providers as $key => $value): ?>
                              <option value="<?php echo $key; ?>" <?php if(isset($selected["provider"])&&($key == $selected["provider"])){?> selected <?php } ?>><?php echo $value; ?></option>
                          <?php endforeach; ?> 
                        </select> 
                      </li>

                      <!-- Usuari de Creació --> 
                      <li class="dd-item dd2-item" data-id="13">
                        <i class="normal-icon icon-download-alt blue bigger-130"></i>
                        <?php echo lang("creation_user");?><br />
                        <select id="creation_user" style="width: 400px">
                          <option value="all">Tots</option>
                          <?php foreach( (array) $users as $key => $value): ?>
                              <option value="<?php echo $key; ?>" <?php if(isset($selected["creation_user"])&&($key == $selected["creation_user"])){?> selected <?php } ?> ><?php echo $value; ?></option>
                          <?php endforeach; ?> 
                        </select> 
                      </li>

                      <!-- Usuari de Modificació --> 
                      <li class="dd-item dd2-item" data-id="13">
                        <i class="normal-icon icon-download-alt blue bigger-130"></i>
                        <?php echo lang("modification_user");?><br />
                        <select id="modification_user" style="width: 400px">
                          <option value="all">Tots</option>
                          <?php foreach( (array) $users as $key => $value): ?>
                              <option value="<?php echo $key; ?>" <?php if(isset($selected["modification_user"])&&($key == $selected["modification_user"])){?> selected <?php } ?>><?php echo $value; ?></option>
                          <?php endforeach; ?> 
                        </select> 
                      </li>

                      <!-- Origen dels Diners --> 
                      <li class="dd-item dd2-item" data-id="13">
                        <i class="normal-icon icon-download-alt blue bigger-130"></i>
                        <?php echo lang("money_source_menu");?><br />
                        <select id="money_source" style="width: 400px">
                          <option value="all">Tots</option>
                          <?php foreach( (array) $money_sources as $key => $value): ?>
                              <option value="<?php echo $key; ?>" <?php if(isset($selected["money_source"])&&($key == $selected["money_source"])){?> selected <?php } ?>><?php echo $value; ?></option>
                          <?php endforeach; ?> 
                        </select> 
                      </li>

                    </ol>

                        </p>
                      </div>
                    </div>
                  </div>
                </div>



                <div class="span5 widget-container-span">
                  <div class="widget-box collapsed">
                    <div class="widget-header widget-header-small header-color-green">
                      <h6>
                        <i class="icon-sort"></i>
                        Manteniments
                      </h6>

                      <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                          <i class="icon-chevron-down"></i>
                        </a>

                        <a href="#" data-action="close">
                          <i class="icon-remove"></i>
                        </a>
                      </div>
                    </div>

                    <div class="widget-body">
                      <div class="widget-main">                        

                    <ol class="dd-list">
                      <li class="dd-item dd2-item" data-id="13">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Tipus Identificadors externs</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="15">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt orange bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Tipus Material</a></div>

                      </li>

                      <li class="dd-item dd2-item" data-id="19">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Marques</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="19">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Models</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="19">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Proveïdors</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="19">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Origen dels diners</a></div>
                      </li>

                      <li class="dd-item dd2-item" data-id="19">
                        <div class="dd-handle dd2-handle">
                          <i class="normal-icon icon-download-alt blue bigger-130"></i>

                          <i class="drag-icon icon-move bigger-125"></i>
                        </div>
                        <div class="dd2-content"><a href="#">Codis de barres</a></div>
                      </li>
                    </ol>

                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                      

              <div class="span2"></div>
            </div>

<div id="selected_filters"></div>

  <div class="table-header">
    Objectes de l'Inventari
  </div>          
  <div class="table-responsive">

  <table style="max-width:none;" class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" id="inventory_report_table" width="100%" >
  
  <thead>
    <tr>
      <th style="font-size:small;" field-name="inventory_objectId">Id</th>
      <th style="font-size:small;" field-name="inventory_object_publicId">Id públic</th>
      <th style="font-size:small;" field-name="inventory_object_externalID">Id extern</th>
      <th style="font-size:small;" field-name="inventory_object_externalIDType">Tipus Id extern</th>
      <th style="font-size:small;" field-name="inventory_object_mainOrganizationalUnitId">Unitat organitzativa principal</th>
      <th style="font-size:small;" field-name="inventory_object_name">Nom</th>
      <th style="font-size:small;" field-name="inventory_object_shortName">Nom curt</th>
      <th style="font-size:small;" field-name="inventory_object_description">Descripció</th>
      <th style="font-size:small;" field-name="inventory_object_location">Ubicació</th>
      <th style="font-size:small;" field-name="inventory_object_materialId">Tipus material</th>
      <th style="font-size:small;" field-name="inventory_object_brandId">Marca</th>
      <th style="font-size:small;" field-name="inventory_object_modelId">Model</th>
      <th style="font-size:small;" field-name="inventory_object_moneySourceId">Origen dels diners</th>
      <th style="font-size:small;" field-name="inventory_object_providerId">Proveidor</th>
      <th style="font-size:small;" field-name="inventory_object_quantityInStock">Quantitat</th>
      <th style="font-size:small;" field-name="inventory_object_price">Preu</th>
      <th style="font-size:small;" field-name="inventory_object_preservationState">Estat de conservació</th>
      <th style="font-size:small;" field-name="inventory_object_file_url">Fitxer</th>      
      <th style="font-size:small;" field-name="inventory_object_entryDate">Data d'entrada</th>
      <th style="font-size:small;" field-name="inventory_object_manualEntryDate">Data d'entrada manual</th>
      <th style="font-size:small;" field-name="inventory_object_markedForDeletion">Baixa?</th>
      <th style="font-size:small;" field-name="inventory_object_markedForDeletionDate">Data de baixa</th>
      <th style="font-size:small;" field-name="inventory_object_last_update">Data última modificació</th>
      <th style="font-size:small;" field-name="inventory_object_manualLast_update">Data última modificació manual</th>
      <th style="font-size:small;" field-name="inventory_object_creationUserId">Usuari de creació</th>
      <th style="font-size:small;" field-name="inventory_object_lastupdateUserId">Usuari última modificació</th>
    </tr>
  </thead>
  
  <tbody>
    
    

<?php foreach ($inventory_objects as $inventory_object_key => $inventory_object): ?>

    <tr>
      <td style="font-size:x-small;" field-name="inventory_objectId" class="center"><?php echo $inventory_object->inventory_objectId;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_publicId"><?php echo $inventory_object->inventory_object_publicId;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_externalID"><?php echo $inventory_object->inventory_object_externalID;?></td>
      <td style="font-size:x-small;" id-field="<?php echo $inventory_object->inventory_object_externalIDType;?>" field-name="inventory_object_externalIDType"><?php echo $inventory_object->externalIDType_shortName;?></td>
      <td style="font-size:x-small;" id-field="<?php echo $inventory_object->inventory_object_mainOrganizationalUnitId;?>" field-name="inventory_object_mainOrganizationalUnitId"><?php echo $inventory_object->organizational_unit_shortName;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_name"><?php echo $inventory_object->inventory_object_name;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_shortName"><?php echo $inventory_object->inventory_object_shortName;?></td>
      <td style="font-size:x-small;" field-name="inventory_object_description"><?php echo $inventory_object->inventory_object_description;?></td>
      <td style="font-size:x-small;" id-field="<?php echo $inventory_object->inventory_object_location;?>" field-name="inventory_object_location"><?php echo $inventory_object->location_shortName;?></td>
      <td style="font-size:x-small;" id-field="<?php echo $inventory_object->inventory_object_materialId;?>" field-name="inventory_object_materialId"><?php echo $inventory_object->material_shortName;?></td>
      <td style="font-size:x-small;" id-field="<?php echo $inventory_object->inventory_object_brandId;?>" field-name="inventory_object_brandId"><?php echo $inventory_object->brand_shortName;?></td>
      <td style="font-size:x-small;" id-field="<?php echo $inventory_object->inventory_object_modelId;?>" field-name="inventory_object_modelId"><?php echo $inventory_object->model_shortName;?></td>
      <td style="font-size:x-small;" id-field="<?php echo $inventory_object->inventory_object_moneySourceId;?>" field-name="inventory_object_moneySourceId"><?php echo $inventory_object->moneySource_shortName;?></td>
      <td style="font-size:x-small;" id-field="<?php echo $inventory_object->inventory_object_providerId;?>" field-name="inventory_object_providerId"><?php echo $inventory_object->provider_shortName;?></td>
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
      <td style="font-size:x-small;" id-field="<?php echo $inventory_object->inventory_object_creationUserId;?>" field-name="inventory_object_creationUserId"><?php echo $inventory_object->creationUser;?></td>
      <td style="font-size:x-small;" id-field="<?php echo $inventory_object->inventory_object_lastupdateUserId;?>" field-name="inventory_object_lastupdateUserId"><?php echo $inventory_object->lastupdateUser;?></td>
    </tr>
  
  <?php endforeach; ?>

  </tbody>
  <tfoot>
    <tr>
      <th style="font-size:small;" field-name="inventory_objectId">Id</th>
      <th style="font-size:small;" field-name="inventory_object_publicId">Id públic</th>
      <th style="font-size:small;" field-name="inventory_object_externalID">Id extern</th>
      <th style="font-size:small;" field-name="inventory_object_externalIDType">Tipus Id extern</th>
      <th style="font-size:small;" field-name="inventory_object_mainOrganizationalUnitId">Unitat organitzativa principal</th>
      <th style="font-size:small;" field-name="inventory_object_name">Nom</th>
      <th style="font-size:small;" field-name="inventory_object_shortName">Nom curt</th>
      <th style="font-size:small;" field-name="inventory_object_description">Descripció</th>
      <th style="font-size:small;" field-name="inventory_object_location">Ubicació</th>
      <th style="font-size:small;" field-name="inventory_object_materialId">Tipus material</th>
      <th style="font-size:small;" field-name="inventory_object_brandId">Marca</th>
      <th style="font-size:small;" field-name="inventory_object_modelId">Model</th>
      <th style="font-size:small;" field-name="inventory_object_moneySourceId">Origen dels diners</th>
      <th style="font-size:small;" field-name="inventory_object_providerId">Proveidor</th>
      <th style="font-size:small;" field-name="inventory_object_quantityInStock">Quantitat</th>
      <th style="font-size:small;" field-name="inventory_object_price">Preu</th>
      <th style="font-size:small;" field-name="inventory_object_preservationState">Estat de conservació</th>
      <th style="font-size:small;" field-name="inventory_object_file_url">Fitxer</th>      
      <th style="font-size:small;" field-name="inventory_object_entryDate">Data d'entrada</th>
      <th style="font-size:small;" field-name="inventory_object_manualEntryDate">Data d'entrada manual</th>
      <th style="font-size:small;" field-name="inventory_object_markedForDeletion">Baixa?</th>
      <th style="font-size:small;" field-name="inventory_object_markedForDeletionDate">Data de baixa</th>
      <th style="font-size:small;" field-name="inventory_object_last_update">Data última modificació</th>
      <th style="font-size:small;" field-name="inventory_object_manualLast_update">Data última modificació manual</th>
      <th style="font-size:small;" field-name="inventory_object_creationUserId">Usuari de creació</th>
      <th style="font-size:small;" field-name="inventory_object_lastupdateUserId">Usuari última modificació</th>
    </tr>
  </tfoot>
</table>
</div>
</div>
      
</div>

<script type="text/javascript">

$(document).ready(function() {
  
  selected_values();
  
  function selected_values(){

    $("#organizational_unit_name").select2();
    var organizational_unit = $("#organizational_unit_name").select2("val");
    var organizational_unit_path = "organizational_unit/"+organizational_unit;
    if(organizational_unit != "all"){
      $("#organizational_unit_name").siblings("i").removeClass("blue").addClass("orange"); 
      $("#selected_filters").append("<span class='organizational_unit' style='margin-right:25px;'><b><?php echo lang("organizational_unit");?></b>: "+$("#organizational_unit_name option:selected").text()+"</span>");     
    } else {
      $("#selected_filters span.organizational_unit").text("");
    }

    $("#material").select2();
    var material = $("#material").select2("val"); 
    var material_path = "material/"+material; 
    if(material != "all"){
      $("#material").siblings("i").removeClass("blue").addClass("orange");
      $("#selected_filters").append("<span class='material' style='margin-right:25px;'><b><?php echo lang("material_menu");?></b>: "+$("#material option:selected").text()+"</span>");             
    } else {
      $("#selected_filters span.material").text("");
    }

    $("#location_name").select2();
    var location = $("#location_name").select2("val"); 
    var location_path = "location/"+location;
    if(location != "all"){
      $("#location_name").siblings("i").removeClass("blue").addClass("orange");    
      $("#selected_filters").append("<span class='location' style='margin-right:25px;'><b><?php echo lang("location");?></b>: "+$("#location_name option:selected").text()+"</span>");    
    } else {
      $("#selected_filters span.location").text("");
    }

    $("#brands").select2();
    var brand = $("#brands").select2("val");
    var brand_path = "brand/"+ brand;
    if(brand != "all"){
      $("#brands").siblings("i").removeClass("blue").addClass("orange");     
      $("#selected_filters").append("<span class='brand' style='margin-right:25px;'><b><?php echo lang("brand_menu");?></b>: "+$("#brands option:selected").text()+"</span>"); 
    } else {
      $("#selected_filters span.brand").text("");
    }

    $("#model").select2();
    var model = $("#model").select2("val"); 
    var model_path = "model/"+ model;
    if(model != "all"){
      $("#model").siblings("i").removeClass("blue").addClass("orange");    
      $("#selected_filters").append("<span class='model' style='margin-right:25px;'><b><?php echo lang("model_menu");?></b>: "+$("#model option:selected").text()+"</span>");   
    } else {
      $("#selected_filters span.model").text("");
    }

    $("#provider").select2();
    var provider = $("#provider").select2("val"); 
    var provider_path = "provider/"+ provider;
    if(provider != "all"){
      $("#provider").siblings("i").removeClass("blue").addClass("orange");     
      $("#selected_filters").append("<span class='provider' style='margin-right:25px;'><b><?php echo lang("provider_menu");?></b>: "+$("#provider option:selected").text()+"</span>");
    } else {
      $("#selected_filters span.provider").text("");
    }

    $("#creation_user").select2();
    var creation_user = $("#creation_user").select2("val"); 
    var creation_user_path = "creation_user/"+ creation_user;
    if(creation_user != "all"){
      $("#creation_user").siblings("i").removeClass("blue").addClass("orange");     
      $("#selected_filters").append("<span class='creation_user' style='margin-right:25px;'><b><?php echo lang("creation_user");?></b>: "+$("#creation_user option:selected").text()+"</span>");
    } else {
      $("#selected_filters span.creation_user").text("");  
    }

    $("#modification_user").select2();
    var modification_user = $("#modification_user").select2("val"); 
    var modification_user_path = "modification_user/"+ modification_user;
    if(modification_user != "all"){
      $("#modification_user").siblings("i").removeClass("blue").addClass("orange");      
      $("#selected_filters").append("<span class='modification_user' style='margin-right:25px;'><b><?php echo lang("modification_user");?></b>: "+$("#modification_user option:selected").text()+"</span>");
    } else {
      $("#selected_filters span.modification_user").text("");  
    }

    $("#money_source").select2();
    var money_source = $("#money_source").select2("val"); 
    var money_source_path = "money_source/"+ money_source;
    if(money_source != "all"){
      $("#money_source").siblings("i").removeClass("blue").addClass("orange");      
      $("#selected_filters").append("<span class='money_source' style='margin-right:25px;'><b><?php echo lang("money_source_menu");?></b>: "+$("#money_source option:selected").text()+"</span>");
    } else {
      $("#selected_filters span.money_source").text("");  
    }

    var full_path=organizational_unit_path+"/"+material_path+"/"+location_path+"/"+brand_path+"/"+model_path+"/"+provider_path+"/"+creation_user_path+"/"+modification_user_path+"/"+money_source_path;
    return full_path;
  }


  $('#organizational_unit_name').on("change", function(e) {  
      var selectedValue = $("#organizational_unit_name").select2("val");
      var pathArray = window.location.pathname.split( '/' );
      var secondLevelLocation = pathArray[1];
      var path = selected_values();
      var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/inventory/inventory_reports/inventory";
      window.location.href = baseURL + "/" + path;

  });


  $('#material').on("change", function(e) {  
      var selectedValue = $("#material").select2("val");
      var pathArray = window.location.pathname.split( '/' );
      var secondLevelLocation = pathArray[1];
      var path = selected_values();
      var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/inventory/inventory_reports/inventory";
      window.location.href = baseURL + "/" + path;

  });


  $('#location_name').on("change", function(e) {  
      var selectedValue = $("#location_name").select2("val");
      var pathArray = window.location.pathname.split( '/' );
      var secondLevelLocation = pathArray[1];
      var path = selected_values();
      var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/inventory/inventory_reports/inventory";
      window.location.href = baseURL + "/" + path;

  });


  $('#brands').on("change", function(e) {  
      var selectedValue = $("#brands").select2("val");
      var pathArray = window.location.pathname.split( '/' );
      var secondLevelLocation = pathArray[1];
      var path = selected_values();
      var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/inventory/inventory_reports/inventory";
      window.location.href = baseURL + "/" + path;

  });


  $('#model').on("change", function(e) {  
      var selectedValue = $("#model").select2("val");
      var pathArray = window.location.pathname.split( '/' );
      var secondLevelLocation = pathArray[1];
      var path = selected_values();
      var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/inventory/inventory_reports/inventory";
      window.location.href = baseURL + "/" + path;

  });

  $('#provider').on("change", function(e) {  
      var selectedValue = $("#provider").select2("val");
      var pathArray = window.location.pathname.split( '/' );
      var secondLevelLocation = pathArray[1];
      var path = selected_values();
      var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/inventory/inventory_reports/inventory";
      window.location.href = baseURL + "/" + path;

  });

  $('#creation_user').on("change", function(e) {  
      var selectedValue = $("#creation_user").select2("val");
      var pathArray = window.location.pathname.split( '/' );
      var secondLevelLocation = pathArray[1];
      var path = selected_values();
      var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/inventory/inventory_reports/inventory";
      window.location.href = baseURL + "/" + path;

  });

  $('#modification_user').on("change", function(e) {  
      var selectedValue = $("#modification_user").select2("val");
      var pathArray = window.location.pathname.split( '/' );
      var secondLevelLocation = pathArray[1];
      var path = selected_values();
      var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/inventory/inventory_reports/inventory";
      window.location.href = baseURL + "/" + path;

  });

  $('#money_source').on("change", function(e) {  
      var selectedValue = $("#money_source").select2("val");
      var pathArray = window.location.pathname.split( '/' );
      var secondLevelLocation = pathArray[1];
      var path = selected_values();
      var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/inventory/inventory_reports/inventory";
      window.location.href = baseURL + "/" + path;

  });


  $('#inventory_report_table').dataTable({
    "sScrollX": "100%",
    "bScrollCollapse": true,
    "bStateSave": true,
    "sDom": 'CRT<"clear">lfrtip',
    "aLengthMenu": [[10, 25, 50,100,200,500,1000,2000,10000,-1], [10, 25, 50,100,200,500,1000,2000,10000,"Tots"]],
    "oTableTools": {
            "sSwfPath": "<?php echo base_url() . 'assets/grocery_crud/themes/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf';?>",
      "aButtons": [
        {
          "sExtends": "copy",
          "sButtonText": "Copiar"
        },
        {
          "sExtends": "csv",
          "sButtonText": "CSV"
        },
        {
          "sExtends": "xls",
          "sButtonText": "XLS"
        },
        {
          "sExtends": "pdf",
          "sPdfOrientation": "landscape",
          "sPdfMessage": "TODO",
          "sTitle": "inventari_data",
          "sButtonText": "PDF"
        },
        {
          "sExtends": "print",
          "sButtonText": "Imprimir"
        },
      ]

        },
    "iDisplayLength": 50,
    "oLanguage": {
      "sProcessing":   "Processant...",
      "sLengthMenu":   "Mostra _MENU_ registres",
      "sZeroRecords":  "No s'han trobat registres.",
      "sInfo":         "Mostrant de _START_ a _END_ de _TOTAL_ registres",
      "sInfoEmpty":    "Mostrant de 0 a 0 de 0 registres",
      "sInfoFiltered": "(filtrat de _MAX_ total registres)",
      "sInfoPostFix":  "",
      "sSearch":       "Filtrar:",
      "sUrl":          "",
      "oPaginate": {
        "sFirst":    "Primer",
        "sPrevious": "Anterior",
        "sNext":     "Següent",
        "sLast":     "Últim"
        }
      },
      "oColVis": {
        "buttonText": "Mostrar/ocultar columnes"
      }
     
    });

} );

</script>
