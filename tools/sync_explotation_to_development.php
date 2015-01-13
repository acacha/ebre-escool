<?php

# This script sync explotation data to development environment
#
# 1) MySQL database sync
# 2) Ldap database --> TODO
#

# Connect to server and backup database

# CAUTION: Avoid to push this file to github or another public places
require ('sync_explotation_to_development_config.php');

#$current_date = "13_01_2015";
$current_date = date("d_m_Y_H_i_s");
$mysqldump_cmd = "/usr/bin/mysqldump -u " . $database_username . " -p" . $database_password . " " . $database_name . " > " . $database_name . "_" . $current_date . ".sql";
$mysqldump_cmd_withou_passwd = "/usr/bin/mysqldump -u " . $database_username . " -pPASSWORD_HIDDEN" . " " . $database_name . " > " . $database_name . "_" . $current_date . ".sql";

echo "Creating a remote database backup on remote server...\n";
echo "Executing $mysqldump_cmd_withou_passwd ... on remote server " . $ssh_hostname . "\n";
#Example: ssh 192.168.50.80 /usr/bin/mysqldump -u ebre_escool -pPASSWORD ebre_escool > ebre_escool_13_01_2015_v2.sql
$salida = shell_exec('ssh ' .$ssh_hostname . " '" . $mysqldump_cmd . "'");

#Getting file
#example. $ scp 192.168.50.80:~/ebre_escool_13_01_2015.sql /tmp
$scp_command="scp " .$ssh_hostname . ":~/" . $database_name . "_" . $current_date . ".sql /tmp";
echo "Obtaining remote database backup from remote server...\n";
echo "Executing " . $scp_command . "\n";
$salida = shell_exec($scp_command);

#Making first local backup

$mysqldump_cmd_local = "/usr/bin/mysqldump -u " . $db['default']['username'] . " -p'" . $db['default']['password'] . " " . $db['default']['database'] . "' > ~/" . $db['default']['database'] . "_" . $current_date . ".sql";
$mysqldump_cmd_without_passwd_local = "/usr/bin/mysqldump -u " . $db['default']['username'] . " -pPASSWORD_HIDDEN" . " " . $db['default']['database'] . " > ~/" . $db['default']['database'] . "_" . $current_date . ".sql";
echo "Making local database backup...\n";
echo "Executing " . $mysqldump_cmd_without_passwd_local . "\n";
$salida = shell_exec($mysqldump_cmd_local);

#Remove local database
#mysql -p --execute="DROP DATABASE ebre_escool;"
$removing_local_database_cmd = '/usr/bin/mysql -u' . $db['default']['username']  . ' -p\'' . $db['default']['password'] .'\' --execute="DROP DATABASE ' . $db['default']['database'] . ';"';
$removing_local_database_cmd_without_passwd = '/usr/bin/mysql  -u' . $db['default']['username']  . ' -p\'PASSWORD_HERE\' --execute="DROP DATABASE ' . $db['default']['database'] . ';"';
echo "Removing local database...\n";
echo "Executing " . $removing_local_database_cmd_without_passwd . "\n";
$salida = shell_exec($removing_local_database_cmd);

#Create local database void
#mysql -p --execute="CREATE DATABASE ebre_escool;"
$creating_local_database_cmd = '/usr/bin/mysql -u' . $db['default']['username']  . ' -p\'' . $db['default']['password'] .'\' --execute="CREATE DATABASE ' . $db['default']['database'] . ';"';
$creating_local_database_cmd_without_passwd = '/usr/bin/mysql -u' . $db['default']['username']  . ' -p\'PASSWORD_HERE\' --execute="CREATE DATABASE ' . $db['default']['database'] . ';"';

echo "Creating local database...\n";
echo "Executing " . $creating_local_database_cmd_without_passwd . "\n";
$salida = shell_exec($creating_local_database_cmd);

#Restoring database
#mysql -pPASSWORD ebre_escool < /tmp/ebre_escool_13_01_2015.sql;"
$restoring_local_database_cmd = '/usr/bin/mysql  -u' . $db['default']['username']  . ' -p\'' . $db['default']['password'] .'\' ' . $db['default']['database'] . '  < /tmp/' . $database_name . '_' . $current_date . ".sql";
$restoring_local_database_cmd_without_passwd  = '/usr/bin/mysql  -u' . $db['default']['username']  . '  -p\'PASSWORD_HERE\' ' . $db['default']['database'] . ' < /tmp/' . $database_name . '_' . $current_date . ".sql";

echo "Restoring local database...\n";
echo "Executing " . $restoring_local_database_cmd_without_passwd . "\n";
$salida = shell_exec($restoring_local_database_cmd);

?>