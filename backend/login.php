<?php
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"];
$password = $json["password"];

$ret = Login($username, $password);
echo $ret;
?>
