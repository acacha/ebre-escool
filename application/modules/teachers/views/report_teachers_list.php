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
  <li class="active"><?php echo lang('reports');?></li>
 </ul>
</div>

<div class="page-header position-relative">
                <h1>
                    <?php echo "Professors";?>
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Llista de professors
                    </small>
                </h1>
</div><!-- /.page-header -->



<div style='height:10px;'></div>
	<div style="margin:10px;">

      <!--
      <div class="alert alert-block alert-success">
        <button type="button" class="close" data-dismiss="alert">
          <i class="icon-remove"></i>
        </button>

        <i class="icon-ok green"></i>
         També us pot interessar l'<strong class="green"><a href="<?php echo base_url('/index.php/managment/curriculum_reports_classgroup');?>">
          informe de grups de classe
        </strong></a> que mostra informació completa sobre tots els grups de classe del centre
      </div> -->

      <script>
      $(function(){

              //Jquery select plugin: https://ivaynberg.github.io/select2/
              $("#select_teacher_academic_period_filter").select2();

              $('#select_teacher_academic_period_filter').on("change", function(e) {
                  var selectedValue = $("#select_teacher_academic_period_filter").select2("val");
                  var pathArray = window.location.pathname.split( '/' );
                  var secondLevelLocation = pathArray[1];
                  var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/teachers/report_teachers_list";
                  //alert(baseURL + "/" + selectedValue);
                  window.location.href = baseURL + "/" + selectedValue;

              });

              $('#all_teachers').dataTable( {
                      "aLengthMenu": [[10, 25, 50,100,200,-1], [10, 25, 50,100,200, "<?php echo lang('All');?>"]],
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
                                              "sPdfMessage": "<?php echo lang("all_teachers");?>",
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

});
</script>

<div class="container">

<table class="table table-striped table-bordered table-hover table-condensed" id="all_teachers_filter">
  <thead style="background-color: #d9edf7;">
    <tr>
      <td colspan="13" style="text-align: center;"> <h5>Filtres
        </h5></td>
    </tr>
    <tr>
       <td><?php echo lang('teacher_academic_period')?>:
          <select id="select_teacher_academic_period_filter">
          <?php foreach ($academic_periods as $academic_period_key => $academic_period_value) : ?>

            selected_academic_period_id

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
  </thead>
</table>

</div>

<table class="table table-striped table-bordered table-hover table-condensed" id="all_teachers">

 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="21" style="text-align: center;"> <h4>
      <a href="<?php echo base_url('/index.php/curriculum/teachers') ;?>">
        <?php echo $table_title?>
      </a>
      </h4></td>
  </tr>
  <tr>
  	 <th><?php echo lang('teacher_id')?></th>
     <th><?php echo lang('teacher_photo')?></th>
     <th><?php echo lang('teacher_code')?></th>
     <th><?php echo lang('teacher_person_id')?></th>
     <th><?php echo lang('teacher_user_id')?></th>
     <th><?php echo lang('teacher_person_full_name')?></th>
     <th><?php echo lang('teacher_username')?></th>
     <th><?php echo lang('teacher_password')?></th>
     <th><?php echo lang('teacher_initial_password')?></th>
     <th><?php echo lang('teacher_force_change_password_next_login')?></th>
     <th><?php echo lang('teacher_ldap_dn')?></th>
     <th><?php echo lang('teacher_ldap_dn_mysql')?></th>
     <th><?php echo lang('teacher_email')?></th>
     <th><?php echo lang('teacher_secondary_email')?></th>
     <th><?php echo lang('teacher_official_id')?></th>
     <th><?php echo lang('teacher_department')?></th>
     <th><?php echo lang('teacher_charge_short')?></th>
     <th><?php echo lang('teacher_charge_full')?></th>
     <th><?php echo lang('teacher_charge2_short')?></th>
     <th><?php echo lang('teacher_charge2_full')?></th>
     <th><?php echo lang('teacher_charge_on_sheet')?></th>
  </tr>

 </thead>

 <tbody>
  <!-- Iteration that shows teachers-->
  <?php if (is_array($all_teachers)) : ?>
   <?php foreach ($all_teachers as $teacher_key => $teacher) : ?>

   <tr align="center" class="{cycle values='tr0,tr1'}">
     <td>
          <a href="<?php echo base_url('/index.php/teachers/index/read/' . $teacher->id ) ;?>">
           <?php echo $teacher->id;?>
          </a> ( <a href="<?php echo base_url('/index.php/teachers/index/read/' . $teacher->id ) ;?>">edit</a>)
     </td>
     <td>
         <img style="width:75px;" alt="<?php echo $teacher->photo;?>" src="<?php echo base_url('/uploads/person_photos/'. $teacher->photo);?>"/ >
     </td>
     <td>
           <?php echo $teacher->code;?>
     </td>

     <td>
          <a href="<?php echo base_url('/index.php/persons/index/read/' . $teacher->person_id ) ;?>">
           <?php echo $teacher->person_id;?>
          </a> ( <a href="<?php echo base_url('/index.php/persons/index/edit/' . $teacher->person_id ) ;?>">edit</a>)
     </td>

     <td>
          <a href="<?php echo base_url('/index.php/skeleton/users/read/' . $teacher->user_id ) ;?>">
           <?php echo $teacher->user_id;?>
          </a> ( <a href="<?php echo base_url('/index.php/skeleton/users/edit/' . $teacher->user_id ) ;?>">edit</a>)
     </td>

     <td>
           <?php
           $teacher_person_full_name = $teacher->person_sn1 . " " . $teacher->person_sn2 . ", " . $teacher->givenName;
           echo $teacher_person_full_name;
           ?>
     </td>

     <td>
         <?php echo $teacher->username;?>
     </td>

     <td>
         <?php echo $teacher->password;?>
     </td>

     <td>
         <span title="<?php echo md5($teacher->initial_password);?>"><?php echo $teacher->initial_password;?></span>
     </td>

     <td>
         <?php echo $teacher->force_change_password_next_login;?>
     </td>

     <td>
         <?php
         if ($teacher->real_ldap_dn) {
            echo $teacher->real_ldap_dn;
         } else {
            echo "ERROR: No trobat!";
         }

         ;?>
     </td>

     <td>
         <?php
         if ($teacher->ldap_dn == "") {
            echo "&nbsp;";
         } else {
            echo $teacher->ldap_dn;
         }

         ;?>
     </td>


     <td>
         <?php echo $teacher->email;?>
     </td>

     <td>
         <?php echo $teacher->secondary_email;?>
     </td>

     <td>
         <?php echo $teacher->official_id;?>
     </td>

     <td>
          <a href="<?php echo base_url('/index.php/curriculum/departments/read/' . $teacher->department_id ) ;?>">
           <?php echo $teacher->department_name;?>
          </a> ( <a href="<?php echo base_url('/index.php/curriculum/departments/edit' . $teacher->department_id ) ;?>"><?php echo $teacher->department_id;?></a>)
     </td>

      <td>
         <?php echo $teacher->charge_short;?>
     </td>

      <td>
         <?php echo $teacher->charge_full;?>
     </td>

      <td>
         <?php echo $teacher->charge2_short;?>
     </td>

      <td>
         <?php echo $teacher->charge2_full;?>
     </td>

      <td>
         <?php echo $teacher->charge_sheet_line1 . "<br/>" . $teacher->charge_sheet_line2 . "<br/>" . $teacher->charge_sheet_line3 . "<br/>" . $teacher->charge_sheet_line4 . "<br/>";?>
     </td>
   </tr>

   <?php endforeach; ?>
  <?php endif; ?>
 </tbody>

</table>


<div class="space-30"></div>

	</div>
</div>
