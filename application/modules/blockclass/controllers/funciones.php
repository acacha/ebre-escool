<?php
//Incluimos el fichero de las constantes.
include('constantes.php');
//Función para recuperar el estado del firewall
function estado(){
        
   conecta();
   //Vamos a mirar el estado actual del firewall
   $sql="SELECT stat FROM status WHERE var='stat'";
   $row=mysql_fetch_array(mysql_query($sql));
   $estado=$row['stat'];
   desconecta();
   return $estado;
}
//Función que genera un mensaje en base al estado del firewall
function message(){
	$stat=estado();
	switch($stat){
		case 0:
		  $msg="Todas las aulas desbloqueadas";
		  break;
		case 1:
		  $msg="Aula 20.2 bloqueada.";
		  break;
		case 2:
		  $msg="Aula 20.3 bloqueada.";
		  break;
		case 3:
		  $msg="Aula 20.4 bloqueada";
		  break;
		case 4:
		  $msg="Aulas 20.2 y 20.3 bloqueadas. Aula 20.4 desbloqueada";
		  break;
		case 5:
		  $msg="Aulas 20.2 y 20.4 bloqueadas. Aula 20.3 desbloqueada";
		  break;
		case 6:
		  $msg="Aulas 20.3 y 20.4 bloqueadas. Aula 20.2 desbloqueada";
		  break;
		case 7:
		  $msg="Todas las aulas bloqueadas";
		  break;
        }
        return $msg;
}

//Función que introduce el nuevo estado del firewall
function newstat($stat){
    conecta();
    $sql="UPDATE status SET stat=$stat WHERE VAR='stat'";
    mysql_query($sql);
    desconecta();
}

//Función para ejecutar las órdenes(bloquear)
function bloquea($aula){
   
   //Vamos a mirar el estado actual del firewall
   $estado=estado();
  //Según el aula 
   switch($aula){
        case "20.2":
            //Según el estado del firewall
            switch($estado){
              case 0:
                system(EJECUTA.BORRA);  
                system(EJECUTA.UNO);
                $stat="1";
                break;
              case 2:
                system(EJECUTA.BORRA);  
                system(EJECUTA.CUATRO);
                $stat="4";
                break;
              case 3:
                system(EJECUTA.BORRA);
                system(EJECUTA.CINCO);
                $stat="5";
                break; 
              case 6:
                system(EJECUTA.BORRA);
                system(EJECUTA.SIETE);
                $stat="7";
                break;
            default:
                $stat=$estado;
                break;
              }
            break;
        case "20.3":
            //Según el estado del firewall
               switch($estado){
              case 0:
                system(EJECUTA.BORRA);  
                system(EJECUTA.DOS);
                $stat="2";
                break;
              case 1:
                system(EJECUTA.BORRA);  
                system(EJECUTA.CUATRO);
                $stat="4";
                break;
              case 3:
                system(EJECUTA.BORRA);  
                system(EJECUTA.SEIS);
                $stat="6";
                break;
              case 5:
                system(EJECUTA.BORRA);  
                system(EJECUTA.SIETE);
                $stat="7";
                break;
            default:
                $stat=$estado;
                break;
              }
            break;
        case "20.4":
            //Según el estado del firewall
               switch($estado){
              case 0:
                system(EJECUTA.BORRA);  
                system(EJECUTA.TRES);
                $stat="3";
                break;
              case 1:
                system(EJECUTA.BORRA);  
                system(EJECUTA.CINCO);
                $stat="5";
                break;
              case 2:
                system(EJECUTA.BORRA);  
                system(EJECUTA.SEIS);
                $stat="6";
                break;
              case 4:
                system(EJECUTA.BORRA);  
                system(EJECUTA.SIETE);
                $stat="7";
                break;
            default:
                $stat=$estado;
                break;
              }
            break;
    }
    //Guardamos el nuevo estado del firewall
    if($stat!=$estado){
    newstat($stat);
    }
}
//Función para desbloquear aulas.
function desbloquea($aula){
    //Verificamos el estado del firewall
    $estado=estado();
    //Según el aula a desbloquear.
       switch($aula){
        case "20.2":
            //Según el estado del firewall
            switch($estado){
              case 1:
                system(EJECUTA.BORRA);  
                system(EJECUTA.CERO);
                $stat="0";
                break;
              case 4:
                system(EJECUTA.BORRA);  
                system(EJECUTA.DOS);
                $stat="2";
                break;
              case 5:
                system(EJECUTA.BORRA);
                system(EJECUTA.TRES);
                $stat="3";
                break; 
              case 7:
                system(EJECUTA.BORRA);
                system(EJECUTA.SEIS);
                $stat="6";
                break;
            default:
                $stat=$estado;
                break;
              }
            break;
        case "20.3":
            //Según el estado del firewall
               switch($estado){
              case 2:
                system(EJECUTA.BORRA);  
                system(EJECUTA.CERO);
                $stat="0";
                break;
              case 4:
                system(EJECUTA.BORRA);  
                system(EJECUTA.UNO);
                $stat="1";
                break;
              case 6:
                system(EJECUTA.BORRA);  
                system(EJECUTA.TRES);
                $stat="3";
                break;
              case 7:
                system(EJECUTA.BORRA);  
                system(EJECUTA.CINCO);
                $stat="5";
                break;
            default:
                $stat=$estado;
                break;
              }
            break;
        case "20.4":
            //Según el estado del firewall
               switch($estado){
              case 3:
                system(EJECUTA.BORRA);  
                system(EJECUTA.CERO);
                $stat="0";
                break;
              case 5:
                system(EJECUTA.BORRA);  
                system(EJECUTA.UNO);
                $stat="1";
                break;
              case 6:
                system(EJECUTA.BORRA);  
                system(EJECUTA.DOS);
                $stat="2";
                break;
              case 7:
                system(EJECUTA.BORRA);  
                system(EJECUTA.CUATRO);
                $stat="4";
                break;
            default:
                $stat=$estado;
                break;
              }
            break;
    } 
    //Guardamos el nuevo estado del firewall
    if($stat!=$estado){
    newstat($stat);
    }
}

//Función para ejecutar comandos de terminal del RB
function comandos($cmd){
    $comando=GENERAL.$cmd;
    $ejecuta=shell_exec($comando);
    return $ejecuta;
}    
//Función para conectar a la base de datos
   function conecta(){
       //Variables para conectar con la base de datos
         $host="localhost";
	 $user="root";
	 $pass="criminal777";
         $basedatos="firewall";
       //Conexión con la base de datos.
         global $conexion;
         
         $conexion=mysql_connect($host,$user,$pass);
         mysql_select_db("$basedatos",$conexion);
         //retorno la variable que voy a usar en la desconexión.
         
   }
    //función para desconectar de la base de datos
   function desconecta(){
        global $conexion;
        //Desconexión de la base de datos
         mysql_close($conexion);
   }
