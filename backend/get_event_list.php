<?php
// @codeCoverageIgnoreStart
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$cid = $json["classroomid"];
$type = $json["type"];

$ret = GetEventList($cid, $type);
echo $ret;
// @codeCoverageIgnoreEnd
?>

