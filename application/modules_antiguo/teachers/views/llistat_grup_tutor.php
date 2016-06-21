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
                        Departaments
                    </small>
                </h1>
</div><!-- /.page-header -->

	  

<div style='height:10px;'></div>
	<div style="margin:10px;">
   		

      <div class="alert alert-block alert-success">
        <button type="button" class="close" data-dismiss="alert">
          <i class="icon-remove"></i>
        </button>

        <i class="icon-ok green"></i>
         També us pot interessar l'<strong class="green"><a href="<?php echo base_url('/index.php/managment/curriculum_reports_classgroup');?>">
          informe de grups de classe
        </strong></a> que mostra informació completa sobre tots els grups de classe del centre
      </div>

      <script>
      $(function(){

              //Jquery select plugin: http://ivaynberg.github.io/select2/
              $("#select_classroom_group_academic_period_filter").select2();

              $('#select_classroom_group_academic_period_filter').on("change", function(e) {  
                  var selectedValue = $("#select_classroom_group_academic_period_filter").select2("val");
                  var pathArray = window.location.pathname.split( '/' );
                  var secondLevelLocation = pathArray[1];
                  var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/teachers/tutors_report";
                  //alert(baseURL + "/" + selectedValue);
                  window.location.href = baseURL + "/" + selectedValue;

              });

              $('#all_groups').dataTable( {
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
                                              "sPdfMessage": "<?php echo lang("all_groups");?>",
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

<table class="table table-striped table-bordered table-hover table-condensed" id="all_groups_filter">
  <thead style="background-color: #d9edf7;">
    <tr>
      <td colspan="13" style="text-align: center;"> <h5>Filtres per columnes
        </h5></td>
    </tr>
    <tr> 
       <td><?php echo lang('classroom_group_academic_period')?>: 
          <select id="select_classroom_group_academic_period_filter">
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

<table class="table table-striped table-bordered table-hover table-condensed" id="all_groups">
 <thead style="background-color: #d9edf7;">
  <tr>
    <td colspan="3" style="text-align: center;"> <h4>
      <a href="<?php echo base_url('/index.php/curriculum/classroom_groups') ;?>">
        <?php echo $classgroup_table_title?>
      </a>
      </h4></td>
  </tr>
  <tr>      
  	 <th><?php echo lang('classroom_group_code')?></th>
     <th><?php echo lang('classroom_group_name')?></th>
     <th><?php echo lang('classroom_group_mentor')?></th>
  </tr>
 </thead>
 <tbody>
  <!-- Iteration that shows classroom_groups-->
  <?php if (is_array($all_classgroups)):?>
  <?php foreach ($all_classgroups as $classroom_group_key => $classroom_group) : ?>
   <tr align="center" class="{cycle values='tr0,tr1'}">   
     <td>
          <?php echo $classroom_group->code;?>
     </td>
     <td>
      <a href="<?php echo base_url('/index.php/curriculum/classroom_group/read/' . $classroom_group->id ) ;?>">
          <?php echo $classroom_group->name;?>
      </a> 
     </td>

        <?php $mentor_fullname =  $classroom_group->mentor_givenname . " " . $classroom_group->mentor_sn1 . " " . $classroom_group->mentor_sn2; ?>
     <td>
      ( <a href="<?php echo base_url('/index.php/teachers/teachers/index/edit/' . $classroom_group->mentor_id ) ;?>">
          <?php echo $classroom_group->mentor_code ;?>
      </a> ) <a href="<?php echo base_url('/index.php/persons/persons/index/read/' . $classroom_group->mentor_person_id ) ;?>">
          <?php echo $mentor_fullname;?>
      ( person id: <a href="<?php echo base_url('/index.php/persons/index/edit/' . $classroom_group->mentor_id ) ;?>">
          <?php echo $classroom_group->mentor_person_id ;?>
      </a> )   
      </a>
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