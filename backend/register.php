<?php
// @codeCoverageIgnoreStart
include "backend_functions.php";

// Retrieve data from the frontend
$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"];
$password = $json["password"];
$type = $json["type"];

$ret = AddUser($username, $password, $type);
echo $ret;
// @codeCoverageIgnoreStart
?>



