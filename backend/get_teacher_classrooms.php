<?php
include 'sql_connection.php';
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"];

GetTeacherClassrooms($username);
?>
