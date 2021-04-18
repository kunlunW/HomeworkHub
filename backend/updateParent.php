<?php
// @codeCoverageIgnoreStart
 include "sql_connection.php";

// Retrieve data from the frontend
$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"]; // Primary Key

$studentID = $json["studentID"];
$studentName = $json["studentName"];
$studentGender = $json["studentGender"];
$grade = $json["grade"];
$gpa = $json["gpa"];
$address = $json["address"];
$telephone = $json["telephone"];

$ret = UpdateParentsInfo($username, $studentID, $studentName, $studentGender, $grade, $gpa, $address, $telephone);
echo $ret;

// @codeCoverageIgnoreEnd
?>



