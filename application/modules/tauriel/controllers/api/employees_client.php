<?php defined('BASEPATH') OR exit('No direct script access allowed');
class HellClient extends CI_Controller{
function __construct()
{
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
function getTeacher($id = null){
$getTeacher_Url = 'criminal/api/hell/teacher/id/';
$getAllTeacher_Url = 'criminal/api/hell/teachers/';
//If not null get just one teacher by 'id'
if($id!=null){
// We call the function teacher_get of hell controller
$teacher = $this->rest->get($getTeacher_Url,array('id'=>$id));
}else{
//we want to get all teachers from database
$teacher = $this->rest->get($getAllTeacher_Url,null);
}
echo json_encode($teacher);
}
//Update teacher
function updateTeacher(){
$updateTeacher_Url = 'criminal/api/hell/teacher/';
//EXAMPLE UPDATE WITHOUT FORM
$id = 200;
$column = 'person_officialid';
$officialId = '88888888L';
$data = array(
'id'=>$id,
$column=>$officialId);
$updateResponse = $this->rest->post($updateTeacher_Url,$data);
echo json_encode($updateResponse);
}
//Delete teacher
function deleteTeacher($id = null){
$deleteTeacher_Url = 'criminal/api/hell/teacher';
if($id){
$deleteResponse = $this->rest->delete($deleteTeacher_Url.'/id/'.$id);
echo json_encode($deleteResponse);
}else{
//call server without id if we don't have it
$message = $this->rest->delete($deleteTeacher_Url.'/id/');
echo json_encode($message);
}
}
//Insert teacher into teacher table
function insertTeacher(){
//Example array to insert into table
$teacher = array(
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
}
}
?>
