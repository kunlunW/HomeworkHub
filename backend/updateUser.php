<?php
// @codeCoverageIgnoreStart
include "sql_connection.php";
include 'backend_functions.php';

// Retrieve data from the frontend
$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"];

$newUserame = $json["newUsername"];
$newPassword = $json["newPassword"];
$newType = $json["newType"];

$ret = UpdateUsersInfo($username, $newUserame, $newPassword, $newType);
echo $ret;
// @codeCoverageIgnoreEnd
?>
