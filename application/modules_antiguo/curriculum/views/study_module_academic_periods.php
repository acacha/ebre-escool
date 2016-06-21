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
                                <?php echo lang('study_module');?> per període acadèmic
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
         També us pot interessar l'<strong class="green"><a href="<?php echo base_url('/index.php/managment/curriculum_reports_studymodules');?>">
          informe de Mòduls Professionals/Crèdits
        </strong></a> que mostra informació resumida sobre tots els MPs/Crèdits del centre
      </div>
   		<?php echo $output; ?>		
	</div>	
</div>