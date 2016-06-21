
 
<div class="main-content">
<?php
  if(isset($_GET['lock'])){
    bloquea($_GET ['lock']);
   
  }elseif(isset($_GET['unlock'])){
    desbloquea($_GET['unlock']);
   
  }
  ?>
<div id="breadcrumbs" class="breadcrumbs">

    <script type="text/javascript">


          try{ace.settings.check('breadcrumbs' , 'fixed')…

    </script>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="http://localhost/ebre-escool/">

                Home

            </a>
            <span class="divider">
                <i class="icon-angle-right arrow-icon"></i>
            </span>
        </li>
        <li class="">
            <a href="http://localhost/ebre-escool/index.php/blockclass/lock_unlock">

                Bloquear aulas

            </a>
        </li>
    </ul>
</div>
<div class="page-content">

    <div class="page-header position-relative">
        <h1>
            <a href="http://localhost/ebre-escool/index.php/blockclass/prueba">

               Bloquear/Desbloquear aulas

            </a>
        </h1>
    </div>


<div id="buttons" align="center">
   <div class="well well-lg"><h4 class="blue">Bloquear Aulas</h4>
           <?php echo $lock; ?>

   </div>
  <div class="well well-lg"><h4 class="blue">Desbloquear Aulas</h4>
           <?php echo $unlock; ?>
  </div>        
  <div class="well well-lg"><h4 class="blue">Estado del Firewall</h4>
           <?php $msg=message(); ?>
           <button class="btn disabled btn-yellow">
           <i class="icon-eye-open"></i>
             <b><?php echo $msg; ?></b>
            </button>

  </div>

    
    		
</div>
</div>
</div>


