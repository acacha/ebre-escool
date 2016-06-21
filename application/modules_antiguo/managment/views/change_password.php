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
                    <?php echo lang("users");?>
                    <small>
                        <i class="icon-double-angle-right"></i>
                        Canviar la paraula de pas
                    </small>
                </h1>
</div><!-- /.page-header -->

<div style='height:10px;'></div>
	<div style="margin:10px;">
   		


<script>
$(function(){

  var availableTags = <?php echo json_encode($all_usernames);?>;

     $("#username").autocomplete({
      source: availableTags
     });

});   
</script>

<div class="container">

  <!-- WELL : CHANGE SHO PASSWORD-->

<?php if ($force_change_password_message): ?>

<div class="alert alert-block alert-error">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="icon-remove"></i>
                </button>

                <i class="icon-exclamation-sign red"></i>

                Esteu utilitzant una paraula de pas autogenerada per tal de poder entrar per primer cop. Si us plau heu de canviar 
                la paraula de pas per tal de poder continuar                
              </div>

<?php endif;?>

<?php if ($change_password_by_admin) : ?>
  <form class="form-horizontal" action="<?php echo base_url('/index.php/managment/change_password/1') ;?>" method="post">
<?php else:?>
  <form class="form-horizontal" action="<?php echo base_url('/index.php/managment/change_password') ;?>" method="post">
<?php endif;?>
    <div class="tabbable">

      <ul class="nav nav-tabs padding-16">
        <li class="active">
          <a data-toggle="tab" href="#edit-password">
            <i class="blue icon-key bigger-125"></i>
            Paraula de pas
          </a>
        </li>
      </ul>

      <?php if ($result_message_exists): ?>
        <div class="well well-small">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          &nbsp;
          <?php if ($result_message_ok): ?>
            <i class="green icon-ok">
          <?php else: ?>    
            <i class="red icon-exclamation-sign">
          <?php endif;?> 
         
         </i> <div class="inline middle blue bigger-110"><?php echo $result_message;?></div>
        </div><!-- /well -->
      <?php endif;?>  

      <div id="edit-password" class="tab-pane">
        <div class="space-10"></div>

        <?php if ($change_password_by_admin) : ?>
          <div class="control-group">
            <label class="control-label" for="username">Usuari:</label>

            <div class="controls">
              <input type="text" id="username" name="username" />
            </div>
          </div>
        <?php else: ?>
          <div class="control-group">
            <label class="control-label" for="form-field-pass0">Paraula de pas actual</label>

            <div class="controls">
              <input type="password" id="form-field-pass0" name="form-field-pass0" />
            </div>
          </div>
        <?php endif;?>

        

        <div class="control-group">
          <label class="control-label" for="form-field-pass1">Nova paraula de pas</label>

          <div class="controls">
            <input type="password" id="form-field-pass1" name="form-field-pass1" /> 
            <?php if (!$force_change_password_message): ?>
            <i class="red icon-exclamation-sign"></i> Podeu posar la mateixa paraula de pas per tal de forçar la regeneració de la paraula de pas
          <?php endif; ?>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="form-field-pass2" >Confirmeu la paraula de pas</label>

          <div class="controls">
            <input type="password" id="form-field-pass2" name="form-field-pass2"/>
          </div>
        </div>
      </div>

      <div class="form-actions">
        <button class="btn btn-info" type="submit">
          <i class="icon-ok bigger-110"></i>
          Guardar
        </button>

        &nbsp; &nbsp; &nbsp;
        <button class="btn" type="reset">
          <i class="icon-undo bigger-110"></i>
          Reset
        </button>
      </div>
    </div>
</form>
</div>

<div class="space-30"></div>

	</div>	
</div>