<?php
// @codeCoverageIgnoreStart
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"];
$type = $json["type"];

$ret = GetParentEventListForAllClassrooms($username, $type);
echo $ret;
// @codeCoverageIgnoreEnd
?>
