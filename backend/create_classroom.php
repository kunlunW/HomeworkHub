<?php
include 'sql_connection.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$crname = $json["classroomname"];
$tname = $json["teachername"];

createClassroom($crname, $tname);
?>
