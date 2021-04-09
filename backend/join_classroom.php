<?php
// @codeCoverageIgnoreStart
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"];
$joincode = $json["joincode"];

$ret = JoinClassroom($username, $joincode);
echo $ret;
// @codeCoverageIgnoreEnd
?>

