<?php
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$crname = $json["classroomname"];
$tname = $json["teachername"];

CreateClassroom($crname, $tname);
?>
