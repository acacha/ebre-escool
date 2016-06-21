<html>
 <head>
  <style>
div.img
  {
  margin:2px;
  height:auto;
  width:auto;
  float:left;
  text-align:left;
  }
div.img img
  {
  display:inline;
  margin:3px;
  border:1px solid #ffffff;
  }
div.desc
  {
  text-align:center;
  font-weight:normal;
  margin:2px;
  }
  </style>
 </head>
<body>

  <div class="img">
   <img src="<?php echo $qr_code_url;?>" alt="Codi URL">
   <div class="desc"><?php echo lang("inventory_object_url");?>:<br/> 
    <a href="<?php echo $base_read_url_with_id;?>"><?php echo $base_read_url_with_id;?>
    </a></div>
  </div>


<?php if ($bar_code_url != ""): ?>
  <div class="img">
   <img src="<?php echo $bar_code_url;?>" alt="Codi de barres">
   <div class="desc"><?php echo lang("externalId");?> (<?php echo $bar_code_type;?>): <?php echo $bar_code_value;?></div>
  </div>
<?php endif; ?>
  
  
 </body>
</html>
