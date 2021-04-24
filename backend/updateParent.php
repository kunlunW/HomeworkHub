<?php
// @codeCoverageIgnoreStart
 include "backend_functions.php";

// Retrieve data from the frontend
$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"]; // Primary Key

$studentName = $json["studentName"];
$studentID = $json["studentID"];
$email = $json["email"];
$mobile_no = $json["mobile_no"];
$school = $json["school"];
$classroomID = $json["classroomID"];

$ret = UpdateParentsInfo($username, $studentName, $studentID, $email, $mobile_no, $school, $classroomID);
echo $ret;

// @codeCoverageIgnoreEnd
?>



