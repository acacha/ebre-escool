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
  <li class="active"><?php echo lang('curriculum');?></li>
 </ul>
</div>



        <div class="page-header position-relative">
                        <h1>
                            <?php echo lang("curriculum");?>
                            <small>
                                <i class="icon-double-angle-right"></i>
                                <?php echo lang('classroom_group');?>
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
                  Atenció: El codi de tutor és el codi intern de base de dades (teacher_id) no confondre amb el codi de profe que s'assigna des de cap d'estudis
              </div>
   		<?php echo $output; ?>		
	</div>	
</div>