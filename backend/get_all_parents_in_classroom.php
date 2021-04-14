<?php
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$cid = $json["classroomid"];

$ret = GetTeacherClassrooms($cid);
echo $ret;
// @codeCoverageIgnoreEnd
?>

