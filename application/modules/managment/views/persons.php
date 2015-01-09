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
                    Persones
                    <small>
                        <i class="icon-double-angle-right"></i>
                        consulta i operacions
                    </small>
                </h1>
</div><!-- /.page-header -->

<div style='height:10px;'></div>
	<div style="margin:10px;">
   		
      <script>

      var all_persons_table;

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

              var all_persons_table = $('#all_persons').DataTable( {
                      "bDestroy": true,
                      "sAjaxSource": "<?php echo base_url('index.php/managment/get_persons/');?>",
                      "fnInitComplete": function () {
                          $("#spinner").hide();   // Hide the spinner
                      },
                      "aoColumns": [
                        { "mData": function(data, type, full) {
                          return '<label><input class="ace" type="checkbox" name="google-apps-user-checkbox" id="' + data.person_id + '"><span class="lbl">&nbsp;</span></label>';
                        }},   
                        { "mData": function(data, type, full) {
                          if (data.person_photo != null) {
                            base_url = "<?php echo base_url('uploads/person_photos');?>";
                            fullname = data.person_givenName + " " + data.person_sn1 + "" + data.person_sn2;
                            return '<a class="image-thumbnail" href="' + base_url + "/" + data.person_photo + '"><img data-rel="tooltip" class="msg-photo" alt="'+ data.fullName +'" title="'+ fullname +'" src="' + base_url + "/" + data.person_photo + '" alt="foto" style="width:75px;"></img></a>';                            
                          } else {
                            return 'Sense foto';
                          }
                        }},
                        { "mData": function(data, type, full) {
                            return data.person_id;            
                        }},  
                        { "mData": function(data, type, full) {
                            return data.person_givenName;            
                        }},    
                        { "mData": function(data, type, full) {
                            return data.person_sn1;                
                        }},
                        { "mData": function(data, type, full) {
                            return data.person_sn2;                
                        }},
                        { "mData": function(data, type, full) {
                            return data.person_email;                
                        }},    
                        { "mData": function(data, type, full) {
                            return data.person_secondary_email;            
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                            return data.person_terciary_email;            
                        },"bVisible": false},    
                        { "mData": function(data, type, full) {
                            return data.person_official_id;            
                        }},    
                        { "mData": function(data, type, full) {
                            return data.person_official_id_type;            
                        },"bVisible": false}, 
                        { "mData": function(data, type, full) {
                            return data.person_date_of_birth;            
                        },"bVisible": false}, 
                        { "mData": function(data, type, full) {
                            return data.person_gender;            
                        }}, 
                        { "mData": function(data, type, full) {
                            return data.person_secondary_official_id;            
                        },"bVisible": false}, 
                        { "mData": function(data, type, full) {
                            return data.person_secondary_official_id_type;            
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                            return data.person_homePostalAddress;            
                        }},  
                        { "mData": function(data, type, full) {
                            return data.person_locality_id;            
                        }},  
                        { "mData": function(data, type, full) {
                            return data.person_telephoneNumber;            
                        },"bVisible": false},  
                        { "mData": function(data, type, full) {
                            return data.person_mobile;            
                        },"bVisible": false},  
                        { "mData": function(data, type, full) {
                            return data.person_bank_account_id;
                        },"bVisible": false},  
                        { "mData": function(data, type, full) {
                            return data.person_notes;            
                        }}, 
                        { "mData": function(data, type, full) {
                            return data.person_entryDate;            
                        }}, 
                        { "mData": function(data, type, full) {
                              return data.person_last_update;
                        },"bVisible": false},  
                        { "mData": function(data, type, full) {
                            return data.person_creationUserId;            
                        },"bVisible": false},  
                        { "mData": function(data, type, full) {
                            return data.person_lastupdateUserId;            
                        },"bVisible": false}, 
                        { "mData": function(data, type, full) {
                            return data.person_markedForDeletion;            
                        }},   
                        { "mData": function(data, type, full) {
                            return data.person_markedForDeletionDate;            
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
                                              "sPdfMessage": "<?php echo lang("all_persons");?>",
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

     
    

        //$("#select_all_persons_main_organizational_unit_filter").select2({ width: 'resolve', placeholder: "Seleccioneu una unitat organitzativa", allowClear: true });
        /*
        $("#select_all_persons_main_organizational_unit_filter").on( 'change', function () {
            var val = $(this).val();
            all_persons_table.column(5).search( val , false, true ).draw();
        } );*/

});
</script>

<div class="container">

<table style="display: none;" class="table table-striped table-bordered table-hover table-condensed" id="all_persons_filter">
  <thead style="background-color: #d9edf7;">
    <tr>
      <td colspan="6" style="text-align: center;"> <strong>Filtres per columnes
        </strong></td>
    </tr>
    <tr> 
       <td><?php echo "Unitat organitzativa"?>:</td>
       <td>
        TODO<select id="select_all_persons_main_organizational_unit_filter"><option value=""></option></select>
       </td>
       <td><?php echo "Tipus usuari"?>:</td>
       <td colspan="2">
        TODO<select id="select_all_persons_user_type_filter"><option value=""></option><option value="1">1</option><option value="2">2</option></select>
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

<table class="table table-striped table-bordered table-hover table-condensed" id="all_persons">
 <thead style="background-color: #d9edf7;">
  <tr>
     <th>&nbsp;</th> 
     <th title="person_photo">Foto</th>
     <th title="person_id">Id</th>
     <th title="person_givenName">Nom</th>
     <th title="person_sn1">Cognom 1</th>
     <th title="person_sn2">Cognom 2</th>
     <th title="person_email">Correu electrònic</th>
     <th title="person_secondary_email">Email secundari</th>
     <th title="person_terciary_email">Email terciari</th>
     <th title="person_official_id">DNI/NIEPassaport</th>
     <th title="person_official_id_type">Tipus Id</th>
     <th title="person_date_of_birth">Data naixement</th>
     <th title="person_gender">Sexe</th>
     <th title="person_secondary_official_id">Id secundari</th>
     <th title="person_secondary_official_id_type">Tipus Id secundari</th>
     <th title="person_homePostalAddress">Adreça postal</th>     
     <th title="person_locality_id">Localitat</th>
     <th title="person_telephoneNumber">Telèfon</th>
     <th title="person_mobile">Mòbil</th>
     <th title="person_bank_account_id">Compte bancari</th>
     <th title="person_notes">Notes</th>
     <th title="person_entryDate">Data entrada</th>
     <th title="person_last_update">Data última modificació</th>
     <th title="person_creationUserId">Usuari creació</th>
     <th title="person_lastupdateUserId">Usuari última modificació</th>
     <th title="person_markedForDeletion">Baixa?</th>
     <th title="person_markedForDeletionDate">Data de baixa</th>
  </tr>
 </thead>
 
</table> 

  <div class="space-30"></div>

	</div>	
</div>