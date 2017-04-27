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
                        Llençol de professors
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
                  var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/teachers/teacher_sheet";
                  //alert(baseURL + "/" + selectedValue);
                  window.location.href = baseURL + "/" + selectedValue;

              });

              $('#go_button').on("click", function(e) {
                  var selectedValue = $("#select_teacher_academic_period_filter").select2("val");
                  var pathArray = window.location.pathname.split( '/' );
                  var secondLevelLocation = pathArray[1];
                  var baseURL = window.location.protocol + "//" + window.location.host + "/" + secondLevelLocation + "/index.php/teachers/teacher_sheet";
                  //alert(baseURL + "/" + selectedValue);
                  window.location.href = baseURL + "/" + selectedValue;
              });
});
</script>

<div class="container">

<table class="table table-striped table-bordered table-hover table-condensed" id="academic_periods_selexctor">
  <thead style="background-color: #d9edf7;">
    <tr>
      <td colspan="13" style="text-align: center;"> <h5>Seleccioneu el periode acadèmic
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

           <a id="go_button" class="btn btn-primary" href="#">
               Go!
           </a>
       </td>
    </tr>
  </thead>
</table>

</div>


<div class="space-30"></div>

	</div>
</div>
