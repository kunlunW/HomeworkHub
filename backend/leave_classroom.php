<?php
// @codeCoverageIgnoreStart
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"];
$cid = $json["classroomid"];

$ret = LeaveClassroom($username, $cid);
echo $ret;
// @codeCoverageIgnoreEnd
?>


