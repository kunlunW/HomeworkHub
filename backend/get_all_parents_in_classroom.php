<?php
// @codeCoverageIgnoreStart
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$cid = $json["classroomid"];

$ret = GetAllParentsInClassroom($cid);
echo $ret;
// @codeCoverageIgnoreEnd
?>

