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
                        Crear paraula de pas inicial
                    </small>
                </h1>
</div><!-- /.page-header -->

<div style='height:10px;'></div>
	<div style="margin:10px;">
   		


<script>
$(function(){

  // AJAX get Classroom_Group from Study for step 4
  $.ajax({
    url:'<?php echo base_url("index.php/enrollment/generate_password");?>',
    type: 'post',
    datatype: 'json',
    statusCode: {
      404: function() {
        $.gritter.add({
          title: 'Error connectant amb el servidor!',
          text: 'No s\'ha pogut contactar amb el servidor. Error 404 not found. URL: index.php/enrollment/generate_password ' ,
          class_name: 'gritter-error gritter-center'
        });
      },
      500: function() {
        $("#response").html('A server-side error has occurred.');
        $.gritter.add({
          title: 'Error connectant amb el servidor!',
          text: 'No s\'ha pogut contactar amb el servidor. Error 500 Internal Server error. URL: index.php/enrollment/generate_password ' ,
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
  }).done(function(data){
    data = $.parseJSON(data);
    password = data['password'];
    $('#new_password').val(password);
  });

  var availableTags = <?php echo json_encode($all_usernames);?>;

     $("#username").autocomplete({
      source: availableTags
     });

});   
</script>

<div class="container">


  <form class="form-horizontal" action="<?php echo base_url('/index.php/managment/create_initial_password') ;?>" method="post">
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

          <div class="control-group">
            <label class="control-label" for="username">Usuari:</label>

            <div class="controls">
              <input type="text" id="username" name="username" />
            </div>
          </div>

        <div class="control-group">
          <label class="control-label" for="new_password">Nova paraula de pas inicial:</label>

          <div class="controls">
            <input type="text" id="new_password" name="new_password"/> 
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