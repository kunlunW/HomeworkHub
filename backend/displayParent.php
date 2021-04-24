<?php
// @codeCoverageIgnoreStart
 include 'backend_functions.php';

// Retrieve data from the frontend
$data = $_POST['formData'];
$json = json_decode($data, true);
$username = $json["username"]; // Primary Key

$ret = DisplayParentInfo($username);
echo $ret; 
// @codeCoverageIgnoreEnd
?>
