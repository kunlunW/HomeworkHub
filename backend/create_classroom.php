<?php
// @codeCoverageIgnoreStart
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$crname = $json["classroomname"];
$tname = $json["teachername"];
$joincode = $json["joincode"];

$ret = CreateClassroom($crname, $tname, $joincode);
echo $ret;
// @codeCoverageIgnoreEnd
?>
