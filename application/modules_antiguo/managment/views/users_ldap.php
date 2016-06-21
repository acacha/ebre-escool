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
                    <?php echo lang("users_ldap");?>
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Operacions massives amb usuaris
                    </small>
                </h1>
</div><!-- /.page-header -->

<div style='height:10px;'></div>
	<div style="margin:10px;">
   		
      <script>

      var all_ldap_users_table;

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

              var selectedAP = $("#select_class_list_academic_period_filter").select2("val");

              var all_ldap_users_table = $('#all_ldap_users').DataTable( {
                      "bDestroy": true,
                      "sAjaxSource": "<?php echo base_url('index.php/managment/get_users_ldap/');?>/" + selectedAP,
                      "aoColumns": [
                        { "mData": function(data, type, full) {
                                    return '<label><input class="ace" type="checkbox" name="form-field-checkbox" id="' + data.id + '"><span class="lbl">&nbsp;</span></label>';
                                  }},
                        { "mData": "enrollment_id" },          
                        { "mData": function(data, type, full) {
                                    return data.id;
                                  } },          
                        { "mData": function(data, type, full) {
                                    url1 = "<?php echo base_url('/index.php/skeleton/users/read/'); ?>/" + data.id;
                                    url2 = "<?php echo base_url('/index.php/skeleton/users/edit/'); ?>/" + data.id;
                                    return '<a href="' + url1 +'">' + data.id + '</a> (<a href="' + url2 + '">edit</a>)';
                                  } },
                        { "mData": function(data, type, full) {
                                    url1 = "<?php echo base_url('/index.php/persons/index/read/'); ?>/" + data.person_id;
                                    url2 = "<?php echo base_url('/index.php/persons/index/edit/'); ?>/" + data.person_id;
                                    return '<a href="' + url1 +'">' + data.person_sn1 + ' ' + data.person_sn2  + ', ' + data.person_givenName + '</a> (<a href="' + url2 + '">' + data.person_id + '</a>)';
                                  }},                                 
                        { "mData": "username" },
                        { "mData": function(data, type, full) {
                                    if (data.password_in_ldap_format == data.ldap_password) {
                                        return "Synced";
                                    }
                                    else {
                                        return "Not Synced";
                                    }
                                    return '<a href="' + url1 +'">' + data.person_sn1 + ' ' + data.person_sn2  + ', ' + data.person_givenName + '</a> (<a href="' + url2 + '">' + data.person_id + '</a>)';
                                  }}, 
                        { "mData": "password" },
                        { "mData": "password_in_ldap_format" },
                        { "mData": "ldap_password" },
                        { "mData": "ldap_pwdLastSet" },
                        { "mData": "ldap_LogonTime" },
                        { "mData": "enrollment_id" },   
                        { "mData": "enrollment_periodid" },
                        { "mData": "enrollment_entryDate" },
                        { "mData": "enrollment_last_update" },
                        { "mData": "enrollment_creationUserId" },
                        { "mData": "enrollment_lastupdateUserId" },
                        { "mData": "mainOrganizationaUnitId" },
                        { "mData": function(data, type, full) {
                                      usertype = "";
                                      switch (data.user_type) {
                                          case 1:
                                              usertype = "Professor";
                                              break;
                                          case 2:
                                              usertype = "Treballador";
                                              break;
                                          case 3:
                                              usertype = "Estudiant";
                                              break;
                                          case 4:
                                              usertype = "No classificat";
                                              break;
                                      } 
                                    return usertype;
                                  }},
                        { "mData": function(data, type, full) {
                                    return '<span title="'+ data.md5_initial_password +'">' + data.initial_password + '</span>';
                                  }},
                        { "mData": "calculated_lm_initial_password" },
                        { "mData": "real_lm_initial_password" },
                        { "mData": "calculated_nt_initial_password" },
                        { "mData": "real_nt_initial_password" },
                        { "mData": function(data, type, full) {
                                    if (  (data.calculated_lm_initial_password == data.real_lm_initial_password ) && (data.calculated_nt_initial_password == data.real_nt_initial_password) ) {
                                       return "Yes";
                                    } else {
                                      if (data.initial_password == "") {
                                        return "---";
                                      } else {
                                        return "ERROR WINDOWS PASSWORD";
                                      }
                                      
                                    }

                                  }},
                        { "mData": "last_login" },          
                        { "mData": function(data, type, full) {
                                    return data.force_change_password_next_login;
                                  }},          
                        { "mData": function(data, type, full) {
                                          if (data.md5_initial_password == data.password) {
                                              return "No";
                                          } else {
                                              return "Sí";
                                          }  
                                  }},
                        { "mData": function(data, type, full) {
                                    if ( data.real_ldap_dn && (data.ldap_dn!="")) {
                                        if (data.real_ldap_dn != data.ldap_dn) {
                                          return "Error";
                                        } else {
                                          return "Ok";
                                        }
                                    } else {
                                        return "No es pot saber";
                                    }
                                  }},           
                        { "mData": function(data, type, full) {
                                    return data.ldap_dn;
                                  }}, 
                        { "mData": function(data, type, full) {
                                    if (data.real_ldap_dn) {
                                      return data.real_ldap_dn;
                                    } else {
                                      return "No trobat";
                                    }
                                  }},           
                        { "mData": function(data, type, full) {
                                    return data.role;
                                  }},     
                        { "mData": function(data, type, full) {
                                    return data.creation_date;
                                  }},            
                        { "mData": function(data, type, full) {
                                    return data.last_modification_date;
                                  }},            
                        { "mData": function(data, type, full) {
                                    return data.creation_user;
                                  }},  
                        { "mData": function(data, type, full) {
                                    return data.last_modification_user;
                                  }},                      
                      ],
                      "columnDefs": [
                                      { "type": "html", "targets": 3 }
                                    ],
                      "aLengthMenu": [[10, 25, 50,100,200,-1], [10, 25, 50,100,200, "<?php echo lang('All');?>"]],       
                      "sDom": 'TC<"clear">lfrtip',               
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
                                              "sPdfMessage": "<?php echo lang("all_ldap_users");?>",
                                              "sTitle": "TODO",
                                              "sButtonText": "PDF"
                                      },
                                      {
                                              "sExtends": "print",
                                              "sButtonText": "<?php echo lang("Print");?>"
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

      
        $("#sync_mysql_password_to_ldap").click(function() {
              var txt;
              var r = confirm("Esteu segurs que voleu fer aquesta sincronització massiva de paswords de MySQL a Ldap?");
              if (r == true) {

                  var values = $('input:checkbox:checked.ace').map(function () {
                    return this.id;
                  }).get(); 
                  
                  //AJAX
                  $.ajax({
                  url:'<?php echo base_url("index.php/managment/sync_mysql_password_to_ldap");?>',
                  type: 'post',
                  data: {
                      values: values,
                  },
                  datatype: 'json',
                  statusCode: {
                    404: function() {
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/managment/sync_mysql_password_to_ldap' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    },
                    500: function() {
                      $("#response").html('A server-side error has occurred.');
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/managment/sync_mysql_password_to_ldap ' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    }
                  },
                  error: function() {
                    $.gritter.add({
                        title: 'Error!',
                        text: 'Ha succeït un error!' ,
                        class_name: 'gritter-error gritter-center'
                      });
                  },
                  success: function(data) {
                    //console.debug("data:" + JSON.stringify(data));
                    //console.debug(JSON.stringify(all_ldap_users_table));
                    all_ldap_users_table.ajax.reload();
                  }
                }).done(function(data){
                    //TODO: Something to check?
                
                });
              }

        });



        $("#interchange_windows_passwords").click(function() {
              var txt;
              var r = confirm("Esteu segurs que voleu fer aquesta operació de intercanviar paraules de pas Windows de forma massiva?");
              if (r == true) {

                  var values = $('input:checkbox:checked.ace').map(function () {
                    return this.id;
                  }).get(); 
                  
                  //AJAX
                  $.ajax({
                  url:'<?php echo base_url("index.php/managment/interchange_windows_passwords");?>',
                  type: 'post',
                  data: {
                      values: values,
                  },
                  datatype: 'json',
                  statusCode: {
                    404: function() {
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/managment/interchange_windows_passwords' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    },
                    500: function() {
                      $("#response").html('A server-side error has occurred.');
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/managment/interchange_windows_passwords ' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    }
                  },
                  error: function() {
                    $.gritter.add({
                        title: 'Error!',
                        text: 'Ha succeït un error!' ,
                        class_name: 'gritter-error gritter-center'
                      });
                  },
                  success: function(data) {
                    //console.debug("data:" + JSON.stringify(data));
                    //console.debug(JSON.stringify(all_ldap_users_table));
                    all_ldap_users_table.ajax.reload();
                  }
                }).done(function(data){
                    //TODO: Something to check?
                
                });
              }

        });

      $("#avoid_change_of_password_on_windows").click(function() {
              var txt;
              var r = confirm("Esteu segurs que voleu fer aquesta operació de forma massiva?");
              if (r == true) {

                  var values = $('input:checkbox:checked.ace').map(function () {
                    return this.id;
                  }).get(); 
                  
                  //AJAX
                  $.ajax({
                  url:'<?php echo base_url("index.php/managment/avoid_change_of_password_on_windows");?>',
                  type: 'post',
                  data: {
                      values: values,
                  },
                  datatype: 'json',
                  statusCode: {
                    404: function() {
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/managment/avoid_change_of_password_on_windows' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    },
                    500: function() {
                      $("#response").html('A server-side error has occurred.');
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/managment/avoid_change_of_password_on_windows ' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    }
                  },
                  error: function() {
                    $.gritter.add({
                        title: 'Error!',
                        text: 'Ha succeït un error!' ,
                        class_name: 'gritter-error gritter-center'
                      });
                  },
                  success: function(data) {
                    //console.debug("data:" + JSON.stringify(data));
                    //console.debug(JSON.stringify(all_ldap_users_table));
                    all_ldap_users_table.ajax.reload();
                  }
                }).done(function(data){
                    //TODO: Something to check?
                
                });
              }

        });
        

        $("#sync_mysql_ldap").click(function() {
              var txt;
              var r = confirm("Esteu segurs que voleu fer aquesta sincronització massiva de MySQL a Ldap?");
              if (r == true) {

                  var values = $('input:checkbox:checked.ace').map(function () {
                    return this.id;
                  }).get(); 
                  
                  //AJAX
                  $.ajax({
                  url:'<?php echo base_url("index.php/managment/sync_mysql_ldap");?>',
                  type: 'post',
                  data: {
                      values: values,
                  },
                  datatype: 'json',
                  statusCode: {
                    404: function() {
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/managment/sync_mysql_ldap' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    },
                    500: function() {
                      $("#response").html('A server-side error has occurred.');
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/managment/sync_mysql_ldap ' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    }
                  },
                  error: function() {
                    $.gritter.add({
                        title: 'Error!',
                        text: 'Ha succeït un error!' ,
                        class_name: 'gritter-error gritter-center'
                      });
                  },
                  success: function(data) {
                    //console.debug("data:" + JSON.stringify(data));
                    //console.debug(JSON.stringify(all_ldap_users_table));
                    all_ldap_users_table.ajax.reload();
                  }
                }).done(function(data){
                    //TODO: Something to check?
                
                });
              }

        });

        
        $("#assign_ldap_rol").click(function() {
              var txt;
              var r = confirm("Esteu segurs que voleu fer aquesta modificació massiva d'assignació de rols?");
              if (r == true) {

                  var values = $('input:checkbox:checked.ace').map(function () {
                    return this.id;
                  }).get(); 
                  
                  //AJAX
                  $.ajax({
                  url:'<?php echo base_url("index.php/managment/assign_multiple_ldap_roles");?>',
                  type: 'post',
                  data: {
                      values: values,
                  },
                  datatype: 'json',
                  statusCode: {
                    404: function() {
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/managment/assign_multiple_ldap_roles' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    },
                    500: function() {
                      $("#response").html('A server-side error has occurred.');
                      $.gritter.add({
                        title: 'Error connectant amb el servidor!',
                        text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/managment/assign_multiple_ldap_roles ' ,
                        class_name: 'gritter-error gritter-center'
                      });
                    }
                  },
                  error: function() {
                    $.gritter.add({
                        title: 'Error!',
                        text: 'Ha succeït un error!' ,
                        class_name: 'gritter-error gritter-center'
                      });
                  },
                  success: function(data) {
                    //console.debug("data:" + JSON.stringify(data));
                    //console.debug(JSON.stringify(all_ldap_users_table));
                    all_ldap_users_table.ajax.reload();
                  }
                }).done(function(data){
                    //TODO: Something to check?
                
                });
              }

        });


        $("#create_multiple_initial_passwords").click(function() {

                var txt;
                var r = confirm("Esteu segurs que voleu fer aquesta modificació massiva de paraules de pas dels usuaris? Els usuaris ja no podran entrar al sistema fins que no els entregueu la nova paraula de pas!");
                if (r == true) {

                    var values = $('input:checkbox:checked.ace').map(function () {
                      return this.id;
                    }).get(); 
                    
                    //AJAX
                    $.ajax({
                    url:'<?php echo base_url("index.php/managment/create_multiple_initial_passwords");?>',
                    type: 'post',
                    data: {
                        values: values,
                    },
                    datatype: 'json',
                    statusCode: {
                      404: function() {
                        $.gritter.add({
                          title: 'Error connectant amb el servidor!',
                          text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/managment/create_multiple_initial_passwords' ,
                          class_name: 'gritter-error gritter-center'
                        });
                      },
                      500: function() {
                        $("#response").html('A server-side error has occurred.');
                        $.gritter.add({
                          title: 'Error connectant amb el servidor!',
                          text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/managment/create_multiple_initial_passwords ' ,
                          class_name: 'gritter-error gritter-center'
                        });
                      }
                    },
                    error: function() {
                      $.gritter.add({
                          title: 'Error!',
                          text: 'Ha succeït un error!' ,
                          class_name: 'gritter-error gritter-center'
                        });
                    },
                    success: function(data) {
                      //console.debug("data:" + JSON.stringify(data));
                      //console.debug(JSON.stringify(all_ldap_users_table));
                      all_ldap_users_table.ajax.reload();
                    }
                  }).done(function(data){
                      //TODO: Something to check?
                  
                  });
                }

                
                

        });

        $("#select_all_ldap_users_main_organizational_unit_filter").select2({ width: 'resolve', placeholder: "Seleccioneu una unitat organitzativa", allowClear: true });

        $("#select_all_ldap_users_main_organizational_unit_filter").on( 'change', function () {
            var val = $(this).val();
            all_ldap_users_table.column(5).search( val , false, true ).draw();
        } );

        all_ldap_users_table.column(5).data().unique().sort().each( function ( d, j ) {
                var StrippedString = d.replace(/(<([^>]+)>)/ig,"");
                var textToSearch = StrippedString.slice(0,StrippedString.indexOf("(")-1).trim();
                $("#select_all_ldap_users_main_organizational_unit_filter").append( '<option value="'+ textToSearch  +'">'+ textToSearch +'</option>' )
        } );

        $("#select_all_ldap_users_user_type_filter").select2({ width: 'resolve', placeholder: "Seleccioneu un tipus d'usuari", allowClear: true });

        $("#select_all_ldap_users_user_type_filter").on( 'change', function () {
          console.debug("TEST");
            var val = $(this).val();
            all_ldap_users_table.column(6).search( val  , false, true ).draw();
        } );

        all_ldap_users_table.column(6).data().unique().sort().each( function ( d, j ) {
              $("#select_all_ldap_users_user_type_filter").append( '<option value="'+ d  +'">'+ d +'</option>' )
        } );

});
</script>

<div class="container">

<table class="table table-striped table-bordered table-hover table-condensed" id="all_ldap_users_filter">
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
        TODO<select id="select_all_ldap_users_main_organizational_unit_filter"><option value=""></option></select>
       </td>
       <td><?php echo "Tipus usuari"?>:</td>
       <td colspan="2">
        TODO<select id="select_all_ldap_users_user_type_filter"><option value=""></option><option value="1">1</option><option value="2">2</option></select>
      </td>
    </tr>
  </thead>  
 </table>
 <table  class="table table-striped table-bordered table-hover table-condensed" id="actions"> 
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

<table class="table table-striped table-bordered table-hover table-condensed" id="all_ldap_users">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="36" style="text-align: center;"> <h4>
      <a href="<?php echo base_url('/index.php/curriculum/user_ldaps') ;?>">
        <?php echo $user_ldap_table_title?>. Període acadèmic: <span id="academic_period_text">
      </a>
      </h4></td>
  </tr>
  <tr>
     <th>&nbsp;</th> 
     <th><?php echo lang('user_ldap_enrollment_id')?></th>
     <th><?php echo lang('user_ldap_id')?></th>
     <th><?php echo lang('user_ldap_id')?></th>
     <th><?php echo lang('user_ldap_person_id')?></th>
     <th><?php echo lang('user_ldap_username')?></th>
     <th><?php echo lang('user_ldap_password_synced')?></th>
     <th><?php echo lang('user_ldap_password')?></th>
     <th><?php echo lang('user_ldap_password_calculated_in_ldap_Format')?></th>
     <th><?php echo lang('user_ldap_password_ldap_password')?></th>
     <th><?php echo lang('user_ldap_password_last_set')?></th>
     <th><?php echo lang('user_ldap_logonTime')?></th>
     <th><?php echo lang('user_ldap_enrollment_id')?></th>
     <th><?php echo lang('user_ldap_enrollment_periodid')?></th>
     <th><?php echo lang('user_ldap_enrollment_entryDate')?></th>
     <th><?php echo lang('user_ldap_enrollment_last_update')?></th>
     <th><?php echo lang('user_ldap_enrollment_creationUserId')?></th>
     <th><?php echo lang('user_ldap_enrollment_lastupdateUserId')?></th>
     <th><?php echo lang('user_ldap_mainOrganizationaUnitId')?></th>
     <th><?php echo lang('user_ldap_user_type')?></th>
     <th><?php echo lang('user_ldap_initial_password')?></th>
     <th><?php echo "LM password calculated"?></th>
     <th><?php echo "Real LM password"?></th>
     <th><?php echo "NT password calculated"?></th>     
     <th><?php echo "Real NT password"?></th>
     <th><?php echo "Windows Passwords Ok?"?></th>
     <th><?php echo lang('user_ldap_last_login')?></th>
     <th><?php echo lang('user_ldap_force_change_password_next_login')?></th>     
     <th><?php echo lang('user_ldap_changed_initial_password')?></th>
     <th><?php echo lang('user_ldap_ldap_dn_error')?></th>     
     <th><?php echo lang('user_ldap_ldap_dn')?></th>     
     <th><?php echo lang('user_ldap_real_ldap_dn')?></th>     
     <th><?php echo lang('user_ldap_ldap_role')?></th>     
     <th><?php echo lang('user_ldap_creation_date')?></th> 
     <th><?php echo lang('user_ldap_last_modification_date')?></th> 
     <th><?php echo lang('user_ldap_creation_user')?></th>
     <th><?php echo lang('user_ldap_last_modification_user')?></th>
  </tr>
 </thead>
 
</table> 



<div class="space-30"></div>

	</div>	
</div>