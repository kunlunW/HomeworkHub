<?php
// @codeCoverageIgnoreStart
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"];

$ret = GetAllParentsInTeachersClassrooms($cid);
echo $ret;
// @codeCoverageIgnoreEnd
?>

