#!/bin/bash
#Borramos las reglas del firewall
ssh admin@192.168.50.80 system script run borra
#Restablecemos las reglas por defecto
ssh admin@192.168.50.80 system script run inicio
#Accedemos a la base de datos
SQL_HOST="localhost"
SQL_USER="root"
SQL_PASSWORD="criminal777"
SQL_DATABASE="firewall"
SQL_ARGS="-h $SQL_HOST -u $SQL_USER -p$SQL_PASSWORD $SQL_DATABASE -s -e"
#Insertamos el estado por defecto
mysql $SQL_ARGS "UPDATE status SET stat=0 WHERE var='stat';"
exit
