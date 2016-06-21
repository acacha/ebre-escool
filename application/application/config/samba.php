<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * This file is part of ebre-escool

    Auth_Ldap is free software: you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Auth_Ldap is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Auth_Ldap.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

/**
 * @author      Sergi Tur Badenas <sergiturbadenas@gmail.com>
 * @copyright   Copyright © 2014 by Sergi Tur <sergiturbadenas@gmail.com>
 * @package     ebre-escool
 * @subpackage  configuration
 * @license     GNU Lesser General Public License
 */
	
$config['samba_newusers_gidnumber'] = 513;
$config['samba_homes_basepath'] = "/samba/homes/";
$config['samba_SID']="S-1-5-21-4045161930-1404234508-1517741366-";
$config['samba_domainName']="INSEBRE";
$config['samba_default_logonScript']="alumnat.bat";
$config['samba_student_logonScript']="alumnat.bat";
$config['samba_teacher_logonScript']="professorat.bat";
$config['samba_managment_logonScript']="gestio.bat";
$config['samba_homeDrive']="U:";
$config['samba_homePath']="\\\\samba01\\";
$config['samba_acctFlags']="[UX          ]";
$config['samba_badPasswordCount']=0;
$config['samba_badPasswordTime']=0;
$config['samba_logonTime']=0;
//2147483647 is the greater value accepted by ldap attribute
$config['samba_pwdLastSet']="2147483647";

$config['samba_mungedDial']="IAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAUAAQABoACAABAEMAdAB4AEMAZgBnAFAAcgBlAHMAZQBuAHQANTUxZTBiYjAYAAgAAQBDAHQAeABDAGYAZwBGAGwAYQBnAHMAMQAwMGUwMDAxMBYAAAABAEMAdAB4AEMAYQBsAGwAYgBhAGMAawASAAgAAQBDAHQAeABTAGgAYQBkAG8AdwAwMTAwMDAwMCIAAAABAEMAdAB4AEsAZQB5AGIAbwBhAHIAZABMAGEAeQBvAHUAdAAqAAIAAQBDAHQAeABNAGkAbgBFAG4AYwByAHkAcAB0AGkAbwBuAEwAZQB2AGUAbAAwMCAAAgABAEMAdAB4AFcAbwByAGsARABpAHIAZQBjAHQAbwByAHkAMDAgAAIAAQBDAHQAeABOAFcATABvAGcAbwBuAFMAZQByAHYAZQByADAwGAACAAEAQwB0AHgAVwBGAEgAbwBtAGUARABpAHIAMDAiAAIAAQBDAHQAeABXAEYASABvAG0AZQBEAGkAcgBEAHIAaQB2AGUAMDAgAAIAAQBDAHQAeABXAEYAUAByAG8AZgBpAGwAZQBQAGEAdABoADAwIgACAAEAQwB0AHgASQBuAGkAdABpAGEAbABQAHIAbwBnAHIAYQBtADAwIgACAAEAQwB0AHgAQwBhAGwAbABiAGEAYwBrAE4AdQBtAGIAZQByADAwKAAIAAEAQwB0AHgATQBhAHgAQwBvAG4AbgBlAGMAdABpAG8AbgBUAGkAbQBlADAwMDAwMDAwLgAIAAEAQwB0AHgATQBhAHgARABpAHMAYwBvAG4AbgBlAGMAdABpAG8AbgBUAGkAbQBlADAwMDAwMDAwHAAIAAEAQwB0AHgATQBhAHgASQBkAGwAZQBUAGkAbQBlADAwMDAwMDAw";
$config['samba_primaryGroupSID']="S-1-5-21-4045161930-1404234508-1517741366-513";


?>