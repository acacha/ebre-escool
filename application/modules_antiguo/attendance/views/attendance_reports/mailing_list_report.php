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
                            <?php echo lang("attendance").". ".lang("reports_educational_center_reports");?>
                            <small>
                                <i class="icon-double-angle-right"></i>
                                <?php echo lang('reports_educational_center_reports_student_emails');?> TODO. Pendent acacbar implementar
                            </small>
                        </h1>
        </div><!-- /.page-header -->

<!-- TITLE -->
<div style='height:10px;'></div>
	<div style="margin:10px; text-align:center;">
		<h2><?php echo $title; ?> TODO. Pendent acacbar implementar</h2>
	</div>    


	<!-- FORM -->    
	<div style="width:40%; margin:0px auto;">
		<form method="post" action="#" class="form-horizontal" role="form">
			<table class="table table-bordered" cellspacing="10" cellpadding="5">
				<div class="form-group">
					<tr>
						<td><label for="data_inicial">Select an option:</label></td>
						<td>
							<input type="radio" name="opcio" <?php if(($opcio)){ if($opcio=='P') { ?> checked="checked" <?php } else { } } else { ?> checked="checked" <?php } ?> value="P"/> Personal accounts<br />
							<input type="radio" name="opcio" <?php if(($opcio)){ if($opcio=='C') { ?> checked="checked" <?php } else { } } ?> value="C"> Center accounts<br />
							<input type="radio" name="opcio" <?php if(($opcio)){ if($opcio=='A') { ?> checked="checked" <?php } else { } } ?> value="A"> Booth accounts 
						</td>
					</tr>	
				</div>
				<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Veure l'informe" class="btn btn-primary"/></td></tr>
			</table>
		</form>
	</div>	
	<div style="width:40%; margin:0px auto;">
	<?php if($opcio){
		print_r($all_students_mail);
	} ?>
	</div>	
</div>	