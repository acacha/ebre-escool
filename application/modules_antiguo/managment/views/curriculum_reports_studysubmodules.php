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
                    <?php echo lang("curriculum");?>
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Unitats formatives / Unitats didàctiques
                    </small>
                </h1>
</div><!-- /.page-header -->

<div style='height:10px;'></div>
	<div style="margin:10px;">
   		



      <script>
      $(function(){

              //Jquery select plugin: http://ivaynberg.github.io/select2/
              $("#select_study_submodules_academic_period_filter").select2();

              $('#select_study_submodules_academic_period_filter').on("change", function(e) {  
                  var selectedValue = $("#select_study_submodules_academic_period_filter").select2("val");
                  var pathArray = window.location.pathname.split( '/' );
                  var secondLevelLocation = pathArray[1];
                  var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/managment/curriculum_reports_studysubmodules";
                  //alert(baseURL + "/" + selectedValue);
                  window.location.href = baseURL + "/" + selectedValue;

              });

              var all_study_submodules_table = $('#all_study_submodules').DataTable( {
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
                                              "sPdfMessage": "<?php echo lang("all_study_submodules");?>",
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

        $("#select_all_study_submodules_study_code_filter").select2({ width: 'resolve',placeholder: "Seleccioneu un estudi", allowClear: true });
        $("#select_all_study_submodules_study_code_filter").on( 'change', function () {
            var val = $(this).val();

            all_study_submodules_table.column(3).search( val ? '^'+$(this).val()+'$' : val, true, false ).draw();
        } );

        all_study_submodules_table.column(3).data().unique().sort().each( function ( d, j ) {
                $("#select_all_study_submodules_study_code_filter").append( '<option value="'+d+'">'+d+'</option>' )
        } );
        
        $("#select_all_study_submodules_course_code_filter").select2({ width: 'resolve', placeholder: "Seleccioneu un curs", allowClear: true });
        $("#select_all_study_submodules_course_code_filter").on( 'change', function () {
            var val = $(this).val();

            all_study_submodules_table.column(5).search( val ? '^'+$(this).val()+'$' : val, true, false ).draw();
        } );

        all_study_submodules_table.column(5).data().unique().sort().each( function ( d, j ) {
                $("#select_all_study_submodules_course_code_filter").append( '<option value="'+d+'">'+d+'</option>' )
        } );
 

});
</script>

<div class="container">

<table class="table table-striped table-bordered table-hover table-condensed" id="all_all_study_submoduless_filter">
  <thead style="background-color: #d9edf7;">
    <tr>
      <td colspan="13" style="text-align: center;"> <h4>Filtres per columnes
        </h4></td>
    </tr>
    <tr> 
       <td><?php echo lang('study_submodules_academic_period')?>: 
          <select id="select_study_submodules_academic_period_filter">
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
       <td><?php echo lang('study_submodule_study_code')?>: <select id="select_all_study_submodules_study_code_filter"><option value=""></option></select></td>
       <td><?php echo lang('study_submodule_course_code')?>: <select id="select_all_study_submodules_course_code_filter"><option value=""></option></select></td>
    </tr>
  </thead>  
</table> 

<table class="table table-striped table-bordered table-hover table-condensed" id="all_study_submodules">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="11" style="text-align: center;"> <h4>
      <a href="<?php echo base_url('/index.php/curriculum/study_submodules') ;?>">
        <?php echo $study_submodules_table_title?>
      </a>
      </h4></td>
  </tr>
  <tr> 
     <th><?php echo lang('study_submodule_id')?></th>
     <th><?php echo lang('study_submodule_shortname')?></th>
     <th><?php echo lang('study_submodule_name')?></th>
     <th><?php echo lang('study_submodule_study_code')?></th>
     <th><?php echo lang('study_submodule_study')?></th>
     <th><?php echo lang('study_submodule_course_code')?></th>
     <th><?php echo lang('study_submodule_course')?></th>
     <th><?php echo lang('study_submodules_totalHours')?></th>
     <th><?php echo lang('study_submodules_order')?></th>
     <th><?php echo lang('study_submodule_initialDate')?></th>
     <th><?php echo lang('study_submodule_endDate')?></th>
  </tr>
 </thead>
 <tbody> 

  <!-- Iteration that shows study_submodules-->
  <?php if (is_array($all_study_submodules) ) : ?>

  <?php foreach ($all_study_submodules as $study_submodule_key => $study_submodule) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">   
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/study_submodule/edit/' . $study_submodule->id ) ;?>">
          <?php echo $study_submodule->id;?>
      </a> 
     </td>

     <td>
      <a href="<?php echo base_url('/index.php/curriculum/study_submodule/read/' . $study_submodule->id ) ;?>">
          <?php echo $study_submodule->shortname;?>
      </a> 
     </td>
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/study_submodule/read/' . $study_submodule->id ) ;?>">
          <?php echo $study_submodule->name;?>
      </a> 
     </td>

     <td>
          <?php echo $study_submodule->study_shortname . ". " . $study_submodule->study_name;?>
     </td>
     
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/studies/read/' . $study_submodule->study_id ) ;?>">
          <?php echo $study_submodule->study_shortname . ". " . $study_submodule->study_name . " - " . $study_submodule->study_law_name . " -" . $study_submodule->study_law_shortname;?>
      </a>
      ( <a href="<?php echo base_url('/index.php/curriculum/studies/edit/' . $study_submodule->course_id ) ;?>">
          <?php echo $study_submodule->course_id ;?>
      </a> )
     </td>

     <td>
          <?php echo $study_submodule->course_shortname . ". " . $study_submodule->course_name;?>
     </td>

     <td>
      <a href="<?php echo base_url('/index.php/curriculum/course/read/' . $study_submodule->course_id ) ;?>">
          <?php echo $study_submodule->course_shortname . ". " . $study_submodule->course_name;?>
      </a>
      ( <a href="<?php echo base_url('/index.php/curriculum/course/edit/' . $study_submodule->course_id ) ;?>">
          <?php echo $study_submodule->course_id ;?>
      </a> )
     </td>
     
     

     <td>
      <?php echo $study_submodule->study_submodules_totalHours;?>
    </td>
    
    <td>
      <?php echo $study_submodule->study_submodules_order;?>
    </td>

    <td>
      <?php echo $study_submodule->study_submodule_initialDate;?>
    </td>

    <td>
      <?php echo $study_submodule->study_submodule_endDate;?>
    </td>

   </tr>
  <?php endforeach; ?>
  <?php endif; ?>
 </tbody>
</table> 

</div>

<div class="space-30"></div>

	</div>	
</div>