<script>
$(document).ready(function() { 
  $("#grup").select2(); 
});
</script>

<!-- Data Table -->
<script>
$(document).ready( function () {
  $('#users_in_group').dataTable({
    "bFilter": false,
    "bInfo": true,
    "sDom": 'T<"clear">lfrtip',
    "aLengthMenu": [[10, 25, 50,100,200,500,1000,-1], [10, 25, 50,100,200,500,1000, "All"]],    
    "oTableTools": {
      "sSwfPath": "<?php echo base_url('assets/grocery_crud/themes/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf');?>",
        "aButtons": [
          {
            "sExtends": "copy",
            "sButtonText": "<?php echo lang("Copy");?>"
          },
          {
            "sTitle": "<?php echo lang('users_in_group').$group_code;?>",
            "sExtends": "csv",
            "sButtonText": "CSV"
          },
          {
            "sTitle": "<?php echo lang('users_in_group').$group_code;?>",
            "sExtends": "xls",
            "sButtonText": "XLS"
          },
          {
            "sTitle": "<?php echo lang('users_in_group').$group_code;?>",
            "sExtends": "pdf",
            "sPdfOrientation": "portrait",
            "sButtonText": "PDF"
          },
          {
            "sExtends": "print",
            "sButtonText": "<?php echo lang("Print");?>"
          },
        ]
    },
        "iDisplayLength": 50,
        "aaSorting": [[ 1, "asc" ],[ 2, "asc" ],[ 3, "asc" ],[ 4, "asc" ]],
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
                            <?php echo "Currículum";?>
                            <small>
                                <i class="icon-double-angle-right"></i>
                                <?php echo lang('users_in_group');?>
                            </small>
                        </h1>
        </div><!-- /.page-header -->

<!-- TITLE -->
<div style='height:10px;'></div>
  <div style="margin:10px; text-align:center;">
    <!--<h2><?php echo $title; ?></h2>-->
  </div>  

  <!-- FORM -->    
  <div style="width:60%; margin:0px auto;">
    <form method="post" action="#" class="form-horizontal" role="form">
      <table class="table table-bordered" cellspacing="10" cellpadding="5">
        <div class="form-group ui-widget">
          <tr>
            <td><label for="grup" style="width:150px;">Selecciona el grup:</label></td>
            <td><select data-place_holder="TODO" style="width:580px;" id="grup" name="grup" data-size="5" data-live-search="true">
              <?php foreach ($grups as $key => $value) : ?>
                <option value="<?php echo $key ?>" <?php if(isset($_POST['grup']) && $key==$_POST['grup']){ ?> selected <?php }?>><?php echo $value ?></option>
              <?php endforeach; ?>
              </select> 
            </td>
          </tr> 
        </div>
        <div class="form-group">
          <tr>
            <td colspan="2" style="text-align:center;"><input type="submit" value="Veure l'informe" class="btn btn-primary"/></td>
          </tr>
        </div>
      </table>
    </form>
  </div>  

<table class="table table-striped table-bordered table-hover table-condensed" id="users_in_group">
  <thead style="background-color: #d9edf7;">
    <tr>
      <th>Id Alumne</th>
      <th>Cognoms</th>
      <th>Nom</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
  <!-- Iteration that shows teacher groups for selected day-->
   <?php foreach($all_students_in_group as $student): ?>
     <tr align="center" class="{cycle values='tr0,tr1'}">
      <td><?php echo $student->student_id;?></td>
      <td><?php echo $student->sn1." ".$student->sn2;?></td>
      <td><?php echo $student->givenName;?></td>
      <td><?php echo $student->email;?></td>
     </tr>
   <?php endforeach; ?>
  </tbody>
</table>

</div>  