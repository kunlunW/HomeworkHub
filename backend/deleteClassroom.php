<?php
// @codeCoverageIgnoreStart
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$crname = $json["classroomname"];

$ret = DeleteClassroom($crname);
echo $ret;
// @codeCoverageIgnoreEnd
?>