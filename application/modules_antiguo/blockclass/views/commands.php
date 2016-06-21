<div class="main-content">
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
            <a href="http://localhost/ebre-escool/index.php/blockclass/commands">

                Ejecutar comandos de terminal RB

            </a>
        </li>
    </ul>
  </div>
<div class="page-content">

    <div class="page-header position-relative">
        <h1>
            <a href="http://localhost/ebre-escool/index.php/blockclass/prueba">

               Ejecutar comandos de terminal RB

            </a>
        </h1>
    </div>
    <div id="firewall" align="center">
     <div class="well well-lg"><h4 class="blue">Ejecutar comandos de terminal del RB</h4>
     <form method="get" action="?cmd">
   <input type="text" name="cmd" value="" size="40" maxlength="100" placeholder="Introduce un comando de terminal"/><br/>
   <input type='submit' class="btn btn-info" value="Ejecutar" name="envia"/> 
               </form> 
         
          
         </div>
  
 <?php
   if(isset($_GET['cmd'])){
          echo "<div id=\"muestra\">
                <table border=\"2px\" align=\"center\">
                        <tr><td><pre style=\"border:1px solid #A2A2A2; background-color:#A9F5A9;
                         padding:8px margin:3px;color:#0150c7;overflow:auto\">";
       if(($_GET['cmd']=="system reset-configuration")||($_GET['cmd']=="system shutdown")){
           echo "NO PERMITIDO";
       }else{
       $cmd=comandos($_GET['cmd']);
       echo $cmd;
  }
   echo "</pre></td></tr></table></div>";
 }
 ?>
 </div>

</div>
