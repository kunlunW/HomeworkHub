<?php
// @codeCoverageIgnoreStart
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$type = $json["type"];
$eid = $json["eventid"];

$ret = DeleteEvent($eid, $type);

echo $ret;
// @codeCoverageIgnoreEnd
?>

