<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Employees_client extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('Rest');
		$config = array('server' =>'http://localhost/ebre-escool/index.php/');
		$this->rest->initialize($config);
		//We can add:
		// 'http_user' => 'admin',
		// 'http_pass' => '1234',
		// 'http_auth' => 'basic' // or 'digest'
		// Load the rest client spark
		$this->load->library('Curl');
	}

	//Get one or all teacher
	function getEmployee($id = null){
		$getEmployee_Url = 'tauriel/api/employees/employee/id/';
		$getEmployees_Url = 'criminal/api/employees/employees/';
		//If not null get just one teacher by 'id'
		if($id!=null){
			// We call the function teacher_get of hell controller
			$teacher = $this->rest->get($getEmployee_Url,array('id'=>$id));
		} else{
			//we want to get all teachers from database
			$teacher = $this->rest->get($getEmployees_Url,null);
		}
		
		echo json_encode($teacher);
	}

	//Update teacher
	function updateTeacher(){
		$updateTeacher_Url = 'tauriel/api/employees/employee/';
		//EXAMPLE UPDATE WITHOUT FORM
		$id = 200;
		$column = 'employees_code';
		$officialId = '88888888L';
		$data = array(
		'id'=>$id,
		$column=>$employeesCode);
		$updateResponse = $this->rest->post($updateEmployee_Url,$data);
		echo json_encode($updateResponse);
	}

	//Delete teacher
	function deleteTeacher($id = null){
		$deleteEmployee_Url = 'tauriel/api/employees/employee';
		if($id){
			$deleteResponse = $this->rest->delete($deleteEmployee_Url.'/id/'.$id);
			echo json_encode($deleteResponse);
		}else{
			//call server without id if we don't have it
			$message = $this->rest->delete($deleteEmployee_Url.'/id/');
			echo json_encode($message);
		}
	}

	//Insert teacher into teacher table
	/*function insertEmployee(){
		//Example array to insert into table
		$employee = array(
		'teacher_person_id'=>1772,
		'teacher_user_id'=>3739,
		'teacher_entryDate'=>'1970-01-11 00:00:00',
		'teacher_creationUserid'=>15,
		'teacher_lastupdateUserId'=>15,
		'teacher_markedForDeletion'=>'n',
		'teacher_markedForDeletionDate'=>'0000-00-00 00:00:00',
		'person_officialid'=>'39847220L');
		//Call the RestServer
		$insertTeacher_Url = 'criminal/api/hell/teacher';
		$insertResponse = $this->rest->put($insertTeacher_Url,$teacher);
		echo json_encode($insertResponse);
		}*/
	}
?>
