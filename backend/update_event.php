<?php
// @codeCoverageIgnoreStart
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$type = $json["type"];
$eid = $json["eventid"];
$name = $json["name"];
$desc = $json["description"];
$duedate = $json["duedate"];
$ret;

if ($type === "homework") {
    $points = $json["points"];
    $ret = UpdateHomework($eid, $name, $desc, $duedate, $points);
} else if ($type === "test") {
    $points = $json["points"];
    $timelimit = $json["timelimit"];
    $ret = UpdateTest($eid, $name, $desc, $duedate, $points, $timelimit); 
} else if ($type === "announcement") { 
    $ret = UpdateAnnouncement($eid, $name, $desc, $duedate);
} else {
    $ret = -1;
}

echo $ret;
// @codeCoverageIgnoreEnd
?>
