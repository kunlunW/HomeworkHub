<?php
// @codeCoverageIgnoreStart
 include "sql_connection.php";
 include 'backend_functions.php';

// Retrieve data from the frontend
$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"]; // Primary Key

$ret = DisplayTeachersInfo($username);
echo $ret;
// @codeCoverageIgnoreEnd
?>


