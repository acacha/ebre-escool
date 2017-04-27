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
                    Usuaris Google Apps
                    <small>
                        <i class="icon-double-angle-right"></i>
                        consulta i operacions
                    </small>
                </h1>
</div><!-- /.page-header -->

<div style='height:10px;'></div>
	<div style="margin:10px;">

      <script>

      var all_google_apps_users_table;

      $(function(){


              $("#select_class_list_academic_period_filter").select2();

              $("#academic_period_text").text( $("#select_class_list_academic_period_filter").select2("data").text);

              $('#select_class_list_academic_period_filter').on("change", function(e) {
                  var selectedValue = $("#select_class_list_academic_period_filter").select2("val");
                  var pathArray = window.location.pathname.split( '/' );
                  var secondLevelLocation = pathArray[1];
                  var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/managment/users_ldap";
                  //alert(baseURL + "/" + selectedValue);
                  window.location.href = baseURL + "/" + selectedValue;
              });

              //Jquery select plugin: https://ivaynberg.github.io/select2/
              $("#select_user_ldaps_academic_period_filter").select2();

              $('#select_user_ldaps_academic_period_filter').on("change", function(e) {
                  var selectedValue = $("#select_user_ldaps_academic_period_filter").select2("val");
                  var pathArray = window.location.pathname.split( '/' );
                  var secondLevelLocation = pathArray[1];
                  var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/managment/curriculum_reports_user_ldaps";
                  //alert(baseURL + "/" + selectedValue);
                  window.location.href = baseURL + "/" + selectedValue;

              });

              var selectedAP = $("#select_class_list_academic_period_filter").select2("val");

              var all_google_apps_users_table = $('#all_google_apps_users').DataTable( {
                      "bDestroy": true,
                      "sAjaxSource": "<?php echo base_url('index.php/managment/get_users_google_apps/');?>/" + selectedAP,
                      "fnInitComplete": function () {
                          $("#spinner").hide();   // Hide the spinner
                      },
                      "aoColumns": [
                        { "mData": function(data, type, full) {
                                    return '<label><input class="ace" type="checkbox" name="google-apps-user-checkbox" id="' + data.Id + '"><span class="lbl">&nbsp;</span></label>';
                                  }},
                        { "mData": function(data, type, full) {
                          if (data.thumbnailPhotoUrl != null) {
                            return '<a class="image-thumbnail" href="' + data.thumbnailPhotoUrl + '"><img data-rel="tooltip" class="msg-photo" alt="'+ data.fullName +'" title="'+ data.fullName +'" src="' + data.thumbnailPhotoUrl + '" alt="foto usuari Google Apps" style="width:75px;"></img></a>';
                          } else {
                            return 'Sense foto';
                          }
                        }},
                        { "mData": function(data, type, full) {
                            return data.primaryEmail;
                        }},
                        { "mData": function(data, type, full) {
                            return data.givenName;
                        }},
                        { "mData": function(data, type, full) {
                            return data.familyName;
                        }},
                        { "mData": function(data, type, full) {
                            return data.fullName;
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                            return data.id;
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                            return data.etag;
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                            return data.kind;
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                            return data.isAdmin;
                        }},
                        { "mData": function(data, type, full) {
                            return data.isDelegatedAdmin;
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                            return data.lastLoginTime;
                        }},
                        { "mData": function(data, type, full) {
                            return data.creationTime;
                        }},
                        { "mData": function(data, type, full) {
                            return data.deletionTime;
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                            return data.agreedToTerms;
                        }},
                        { "mData": function(data, type, full) {
                            return data.aliases;
                        }},
                        { "mData": function(data, type, full) {
                            return data.hashFunction;
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                            return data.password;
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                          if (data.suspended) {
                            return "Suspès";
                          } else {
                            return "Actiu";
                          }

                        }},
                        { "mData": function(data, type, full) {
                            return data.suspensionReason;
                        }},
                        { "mData": function(data, type, full) {
                            return data.changePasswordAtNextLogin;
                        }},
                        { "mData": function(data, type, full) {
                            if (data.addresses !=null) {
                              return data.addresses;
                            } else {
                              return "Sense adreces";
                            }
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                            return data.ipWhitelisted;
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                            return data.customerId;
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                            return data.orgUnitPath;
                        }},
                        { "mData": function(data, type, full) {
                            return data.isMailboxSetup;
                        }},
                        { "mData": function(data, type, full) {
                            return data.includeInGlobalAddressList;
                        }},
                        { "mData": function(data, type, full) {
                          strEmails="";
                          $.each(data.emails, function( index, value ) {
                              primary = "";
                              if (value.primary) {
                                primary = "primari";
                              }
                              strEmails = strEmails + value.address + " ( tipus: " + value.type + " " + primary + "), ";
                          });
                          return strEmails;
                        },"bVisible": false},
                        { "mData": function(data, type, full) {
                          strExternalIds="";
                          if (data.externalIds != null) {
                            $.each(data.externalIds, function( index, value ) {
                                strExternalIds = strExternalIds + value.value + " ( tipus: " + value.type + "), ";
                            });
                          }
                          return strExternalIds;
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
                                              "sPdfMessage": "<?php echo lang("all_google_apps_users");?>",
                                              "sTitle": "TODO",
                                              "sButtonText": "PDF"
                                      },
                                      {
                                              "sExtends": "print",
                                              "sButtonText": "<?php echo lang("Print");?>",
                                              "sToolTip": "Vista impressió",
                                              "sMessage": "<center><h2>Usuaris Google Apps</h2></center>",
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




        //$("#select_all_google_apps_users_main_organizational_unit_filter").select2({ width: 'resolve', placeholder: "Seleccioneu una unitat organitzativa", allowClear: true });
        /*
        $("#select_all_google_apps_users_main_organizational_unit_filter").on( 'change', function () {
            var val = $(this).val();
            all_google_apps_users_table.column(5).search( val , false, true ).draw();
        } );*/

});
</script>

<div class="container">

<table style="display: none;" class="table table-striped table-bordered table-hover table-condensed" id="all_google_apps_users_filter">
  <thead style="background-color: #d9edf7;">
    <tr>
      <td colspan="6" style="text-align: center;"> <strong>Filtres per columnes
        </strong></td>
    </tr>
    <tr>
      <td style="text-align: center;"> <strong>Període acadèmic:
        </strong>
      </td>
      <td colspan="4" style="text-align: center;">
              <select id="select_class_list_academic_period_filter">
                <?php foreach ($academic_periods as $academic_period_key => $academic_period_value) : ?>
                  <?php if ( $selected_academic_period_id) : ?>
                    <?php if ( $academic_period_key == $selected_academic_period_id) : ?>
                      <option selected="selected" value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                    <?php else: ?>
                        <option value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                    <?php endif; ?>
                  <?php else: ?>
                      <?php if ( $academic_period_value->current == 1) : ?>
                        <option selected="selected" value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                      <?php else: ?>
                        <option value="<?php echo $academic_period_key ;?>"><?php echo $academic_period_value->shortname ;?></option>
                      <?php endif; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
                </select>
      </td>
    </tr>
    <tr>
       <td><?php echo "Unitat organitzativa"?>:</td>
       <td>
        TODO<select id="select_all_google_apps_users_main_organizational_unit_filter"><option value=""></option></select>
       </td>
       <td><?php echo "Tipus usuari"?>:</td>
       <td colspan="2">
        TODO<select id="select_all_google_apps_users_user_type_filter"><option value=""></option><option value="1">1</option><option value="2">2</option></select>
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

<table class="table table-striped table-bordered table-hover table-condensed" id="all_google_apps_users">
 <thead style="background-color: #d9edf7;">
  <tr>
     <th>&nbsp;</th>
     <th>Photo</th>
     <th>primaryEmail</th>
     <th>givenName</th>
     <th>familyName</th>
     <th>fullName</th>
     <th>Id</th>
     <th>Etag</th>
     <th>Kind</th>
     <th>isAdmin</th>
     <th>isDelegatedAdmin</th>
     <th>lastLoginTime</th>
     <th>creationTime</th>
     <th>deletionTime</th>
     <th>agreedToTerms</th>
     <th>aliases</th>
     <th>hashFunction</th>
     <th>password</th>
     <th>suspended</th>
     <th>suspensionReason</th>
     <th>changePasswordAtNextLogin</th>
     <th>Addresses</th>
     <th>ipWhitelisted</th>
     <th>customerId</th>
     <th>orgUnitPath</th>
     <th>isMailboxSetup</th>
     <th>includeInGlobalAddressList</th>
     <th>emails</th>
     <th>externalIds</th>
  </tr>
 </thead>

</table>

  <div class="space-30"></div>

	</div>
</div>
