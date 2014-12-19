<div class="main-content" >
<div id="breadcrumbs" class="breadcrumbs">
 <script type="text/javascript">
  try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
 </script>
 <ul class="breadcrumb">
  <li>
   <i class="icon-home home-icon"></i>
   <a href="#">Home</a>
   <span class="divider">
    <i class="icon-angle-right arrow-icon"></i>
   </span>
  </li>
  <li class="active"><?php echo lang('users');?></li>
 </ul>
</div>

<div class="page-header position-relative">
                <h1>
                    Usuaris
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Consulta i operacions
                    </small>
                </h1>
</div><!-- /.page-heaer -->

<div class="space-10"></div>

<div style="margin:10px;">
   		      

<div class="container">

<?php //var_export($posible_duplicated_users);?>  

<?php //echo "is_array: " . is_array($posible_duplicated_users) . "<br/>";?>  
<?php //echo "count: " . count($posible_duplicated_users) . "<br/>";?>  
<?php //echo "count result: " . (count($posible_duplicated_users) > 0) . "<br/>";?>  


<?php if (is_array($posible_duplicated_users) && ( count($posible_duplicated_users) > 0)) : ?>
  <div class="table-header" style="text-align:center;background-color:red;"> Possibles usuaris duplicats!</div>
  <table class="table table-striped table-bordered table-hover table-condensed" id="posible_duplicated_users_table">
  <thead style="background-color: #d9edf7;">
    <tr> 
       <td>&nbsp;</td>
       <td>Id Usuari</td>
       <td>Id persona</td>
       <td>Foto</td>
       <td>username</td>
       <td>Cognom 1</td>
       <td>Cognom 2</td>
       <td>Nom</td>
       <td>Id oficial</td>     
       <td>Matrícules</td>
       <td>Estudiants ocults?</td>
       <td>Data creació</td>
       <td>email</td>     
       <td>email 2</td>     
       <td>email 3</td>     
       <td>Telèfon</td>     
       <td>Mòbil</td>    
       <td>Data última modificació</td>
       <td>Usuari creació</td>
       <td>Usuari última modificació</td>
       <td>Últim login</td>
       <td>Actiu</td>
       <td>Professors?</td>
       <td>Empleats?</td>
       <td>No duplicat?</td>       
  </thead>  
  <tbody>
    <?php foreach($posible_duplicated_users as $posible_duplicated_user_key => $posible_duplicated_user):?>
      <tr>
         <td><?php echo '<label><input class="ace" type="checkbox" name="form-field-checkbox" id="' . $posible_duplicated_user->id . '"><span class="lbl">&nbsp;</span></label>';?></td>
         <td><?php echo $posible_duplicated_user->id;?></td>
         <td><?php echo $posible_duplicated_user->person_id;?></td>
         <td>
          <?php 
          $photos_base_url = base_url('/uploads/person_photos');
          $student_full_name = $posible_duplicated_user->person_sn1 . " " . $posible_duplicated_user->person_sn2 . ", " . $posible_duplicated_user->person_givenName;
          $photo_url = $photos_base_url . "/" . $posible_duplicated_user->person_photo;
          ?>
          <a class="image-thumbnail" href="<?php echo $photo_url;?>">
            <img data-rel="tooltip" class="msg-photo" alt="<?php echo $student_full_name; ?>" 
              title="<?php echo $student_full_name; ?>" src="<?php echo $photo_url; ?>" style="width:75px;"></img>
          </a>
         </td>
         <td><?php echo $posible_duplicated_user->username;?></td>
         <td><?php echo $posible_duplicated_user->person_sn1;?></td>
         <td><?php echo $posible_duplicated_user->person_sn2;?></td>
         <td><?php echo $posible_duplicated_user->person_givenName;?></td>
         <td><?php echo $posible_duplicated_user->person_official_id;?></td>
         <td><?php echo $posible_duplicated_user->enrollments;?></td>
         <td><?php echo $posible_duplicated_user->hidden_students;?></td>   
         <td><?php echo $posible_duplicated_user->created_on;?></td>
         <td><?php echo $posible_duplicated_user->person_email;?></td>
         <td><?php echo $posible_duplicated_user->person_secondary_email;?></td>
         <td><?php echo $posible_duplicated_user->person_terciary_email;?></td>
         <td><?php echo $posible_duplicated_user->person_telephoneNumber;?></td>
         <td><?php echo $posible_duplicated_user->person_mobile;?></td>
         <td><?php echo $posible_duplicated_user->last_modification_date;?></td>
         <td><?php echo $posible_duplicated_user->last_modification_user;?></td>
         <td><?php echo $posible_duplicated_user->creation_user;?></td>
         <td><?php echo $posible_duplicated_user->last_login;?></td>
         <td><?php echo $posible_duplicated_user->active;?></td>
         <td><?php echo $posible_duplicated_user->teachers;?></td>
         <td><?php echo $posible_duplicated_user->employees;?></td>    
         <td><?php echo $posible_duplicated_user->mark_as_not_duplicated;?></td>                         
      </tr>
    <?php endforeach;?>    
  </tbody>  
 </table>
<?php endif;?>

<table style="display: none;" class="table table-striped table-bordered table-hover table-condensed" id="all_users_filter">
  <thead style="background-color: #d9edf7;">
    <tr>
      <td colspan="6" style="text-align: center;"> <strong>Filtres per columnes
        </strong></td>
    </tr>
    <tr> 
       <td><?php echo "Unitat organitzativa"?>:</td>
       <td>
        TODO<select id="select_all_users_main_organizational_unit_filter"><option value=""></option></select>
       </td>
       <td><?php echo "Tipus usuari"?>:</td>
       <td colspan="2">
        TODO<select id="select_all_users_user_type_filter"><option value=""></option><option value="1">1</option><option value="2">2</option></select>
      </td>
    </tr>
  </thead>  
 </table>

 <table style="display:none;"  class="table table-striped table-bordered table-hover table-condensed" id="actions"> 
  <thead style="background-color: #d9edf7;">
    <tr>
      <td colspan="8" style="text-align: center;"> <strong>Accions massives (aplica l'acció sobre tots els usuaris seleccionats)
        </strong></td>
    </tr>
    <tr> 
       <td>
        <button class="btn btn-mini btn-info" id="create_multiple_initial_passwords">
          <i class="icon-bolt"></i>
          Crear paraula de pas inicial
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="select_all">
          <i class="icon-bolt"></i>
          Seleccionar tots
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="unselect_all">
          <i class="icon-bolt"></i>
          Deseleccionar tots
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="sync_mysql_ldap">
          <i class="icon-bolt"></i>
          Sync MySQL -> Ldap
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="assign_ldap_rol">
          <i class="icon-bolt"></i>
          Assignar Rol ldap
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="sync_mysql_password_to_ldap">
          <i class="icon-bolt"></i>
          Sync MySQL password a Ldap
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="avoid_change_of_password_on_windows">
          <i class="icon-bolt"></i>
          Impedir canvi de password a Windows
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
       <td>
        <button class="btn btn-mini btn-danger" id="interchange_windows_passwords">
          <i class="icon-bolt"></i>
          Canviar hash NT per LM i viceversa
          <i class="icon-arrow-right icon-on-right"></i>
        </button>
       </td>
    </tr>
  </thead>  
</table> 

</div>

<center><i id="spinner" class="icon-spinner icon-spin orange bigger-300"></i></center>

<table class="table table-striped table-bordered table-hover table-condensed" id="all_users">
 <thead style="background-color: #d9edf7;">
  <tr>
     <th>&nbsp;</th> 
     <th title="id">Id</th>
     <th title="person_id">Id persona</th>
     <th title="username">Nom usuari</th>
     <th title="last_login">Últim lògin</th>
     <th title="password">Paraula de pas</th>
     <th title="initial_password">initial_password</th>
     <th title="salt">salt</th>
     <th title="force_change_password_next_login">Canvi password forçat?</th>
     <th title="mainOrganizationaUnitId">mainOrganizationaUnitId</th>
     <th title="activation_code">activation_code</th>
     <th title="forgotten_password_realm">forgotten_password_realm</th>
     <th title="forgotten_password_code">forgotten_password_code</th>
     <th title="forgotten_password_time">forgotten_password_time</th>
     <th title="remember_code">remember_code</th>
     <th title="created_on">Data creació</th>
     <th title="last_modification_date">Data última modificació</th>     
     <th title="creation_user">Usuari de creacíó</th>
     <th title="last_modification_user">Usuari última modificació</th>
     <th title="active">Actiu?</th>
     <th title="ldap_dn">DN Ldap</th>
  </tr>
 </thead>
 
</table> 

  <div class="space-30"></div>

	</div>	
</div>


<script>

      var all_users_table;

      $(function(){

              //Jquery select plugin: http://ivaynberg.github.io/select2/
              $("#select_user_ldaps_academic_period_filter").select2();

              $('#select_user_ldaps_academic_period_filter').on("change", function(e) {  
                  var selectedValue = $("#select_user_ldaps_academic_period_filter").select2("val");
                  var pathArray = window.location.pathname.split( '/' );
                  var secondLevelLocation = pathArray[1];
                  var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/managment/curriculum_reports_user_ldaps";
                  //alert(baseURL + "/" + selectedValue);
                  window.location.href = baseURL + "/" + selectedValue;

              });

              $('#posible_duplicated_users_table').DataTable( {
                      "bDestroy": true,
                      "aLengthMenu": [[10, 25, 50,100,200,-1], [10, 25, 50,100,200, "<?php echo lang('All');?>"]],       
                      "sDom": 'TRC<"clear">lfrtip', 
                      "aoColumns": [ null,null,null,null,null,null,null,null,null,null,null,null,{"bVisible": false},null,{"bVisible": false},null,null,
                        {"bVisible": false},{"bVisible": false},{"bVisible": false},{"bVisible": false},{"bVisible": false},{"bVisible": false},{"bVisible": false},{"bVisible": false}
                      ],
                      "oColVis": {
                          "buttonText": "Mostrar / amagar columnes"
                      },                   
                      "oTableTools": {
                              "sSwfPath": "<?php echo base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf');?>",
                              "aButtons": [
                                      {
                                              "sExtends": "copy",
                                              "sButtonText": "<?php echo lang("Copy");?>"
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
                                              "sPdfMessage": "<?php echo lang("all_users");?>",
                                              "sTitle": "TODO",
                                              "sButtonText": "PDF"
                                      },
                                      {
                                              "sExtends": "print",
                                              "sButtonText": "<?php echo lang("Print");?>",
                                              "sToolTip": "Vista impressió",
                                              "sMessage": "<center><h2>Persones</h2></center>",
                                              "sInfo": "<h6>Vista impressió</h6><p>Si us plau utilitzeu l'opció d'imprimir del vostre navegador (Ctrl+P) per "+
                                                       "imprimir. Feu clic a la tecla Esc per tornar.",
                                      },
                              ]

                      },
              "iDisplayLength": 100,
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
            }
        }); 

              var all_users_table = $('#all_users').DataTable( {
                      "bDestroy": true,
                      "sAjaxSource": "<?php echo base_url('index.php/managment/get_users');?>",
                      "fnInitComplete": function () {
                          $("#spinner").hide();   // Hide the spinner
                      },
                      "aoColumns": [
                        { "mData": function(data, type, full) {
                          return '<label><input class="ace" type="checkbox" name="google-apps-user-checkbox" id="' + data.id + '"><span class="lbl">&nbsp;</span></label>';
                        }},   
                        { "mData": function(data, type, full) {
                            return data.id;            
                        }},  
                        { "mData": function(data, type, full) {
                            return data.person_id;            
                        }},  
                        { "mData": function(data, type, full) {
                            return data.username;            
                        }},    
                        { "mData": function(data, type, full) {
                            return data.last_login;                
                        }},
                        { "mData": function(data, type, full) {
                            return data.password;                
                        }},    
                        { "mData": function(data, type, full) {
                            return data.initial_password;            
                        }},
                        { "mData": function(data, type, full) {
                            if (data.salt != null) {
                              return data.salt;  
                            } else {
                              return "No utilitza salt";
                            }
                        },"bVisible": false},    
                        { "mData": function(data, type, full) {
                            return data.force_change_password_next_login;            
                        },"bVisible": false},    
                        { "mData": function(data, type, full) {
                            return data.mainOrganizationaUnitId;            
                        },"bVisible": false}, 
                        { "mData": function(data, type, full) {
                            if (data.activation_code != null) {
                              return data.activation_code;  
                            } else {
                              return "";
                            }        
                        },"bVisible": false}, 
                        { "mData": function(data, type, full) {
                            return data.forgotten_password_realm;            
                        },"bVisible": false}, 
                        { "mData": function(data, type, full) {
                            return data.forgotten_password_code;            
                        },"bVisible": false}, 
                        { "mData": function(data, type, full) {
                            return data.forgotten_password_time;            
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                            return data.remember_code;            
                        },"bVisible": false},  
                        { "mData": function(data, type, full) {
                            return data.created_on;            
                        }},  
                        { "mData": function(data, type, full) {
                            return data.last_modification_date;            
                        },"bVisible": false},  
                        { "mData": function(data, type, full) {
                            return data.creation_user;            
                        },"bVisible": false},  
                        { "mData": function(data, type, full) {
                            return data.last_modification_user;
                        },"bVisible": false},  
                        { "mData": function(data, type, full) {
                            return data.active;            
                        }}, 
                        { "mData": function(data, type, full) {
                            return data.ldap_dn;            
                        }}, 
                      ],
                      "columnDefs": [
                                      { "type": "html", "targets": 3 }
                                    ],
                      "aLengthMenu": [[10, 25, 50,100,200,-1], [10, 25, 50,100,200, "<?php echo lang('All');?>"]],       
                      "sDom": 'TRC<"clear">lfrtip', 
                      "oColVis": {
                          "buttonText": "Mostrar / amagar columnes"
                      },                   
                      "oTableTools": {
                              "sSwfPath": "<?php echo base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf');?>",
                              "aButtons": [
                                      {
                                              "sExtends": "copy",
                                              "sButtonText": "<?php echo lang("Copy");?>"
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
                                              "sPdfMessage": "<?php echo lang("all_users");?>",
                                              "sTitle": "TODO",
                                              "sButtonText": "PDF"
                                      },
                                      {
                                              "sExtends": "print",
                                              "sButtonText": "<?php echo lang("Print");?>",
                                              "sToolTip": "Vista impressió",
                                              "sMessage": "<center><h2>Persones</h2></center>",
                                              "sInfo": "<h6>Vista impressió</h6><p>Si us plau utilitzeu l'opció d'imprimir del vostre navegador (Ctrl+P) per "+
                                                       "imprimir. Feu clic a la tecla Esc per tornar.",
                                      },
                              ]

                      },
              "iDisplayLength": 100,
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
            }
        }); 



        $("#select_all").click(function() {

          $('input:checkbox').map(function () {
            this.checked = true;
          }).get(); 
          
        });

        $("#unselect_all").click(function() {

          $('input:checkbox').map(function () {
            this.checked = false;
          }).get(); 
          
        });

     
    

        //$("#select_all_users_main_organizational_unit_filter").select2({ width: 'resolve', placeholder: "Seleccioneu una unitat organitzativa", allowClear: true });
        /*
        $("#select_all_users_main_organizational_unit_filter").on( 'change', function () {
            var val = $(this).val();
            all_users_table.column(5).search( val , false, true ).draw();
        } );*/

});
</script>
