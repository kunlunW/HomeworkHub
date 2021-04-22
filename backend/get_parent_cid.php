<?php
// @codeCoverageIgnoreStart
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$pname = $json["username"];

$ret = GetParentCID($pname);
echo $ret;
// @codeCoverageIgnoreEnd
?>


