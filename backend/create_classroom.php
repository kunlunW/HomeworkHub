<?php
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$crname = $json["classroomname"];
$tname = $json["teachername"];

$ret = CreateClassroom($crname, $tname);
echo $ret;
?>
