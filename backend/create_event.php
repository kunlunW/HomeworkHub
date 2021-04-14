<?php
// @codeCoverageIgnoreStart
include 'backend_functions.php';

$data = $_POST['formData'];
$json = json_decode($data, true);
$type = $json["type"];
$name = $json["name"];
$desc = $json["description"];
$duedate = $json["duedate"];
$cid = $json["classroomid"];
$ret;

if ($type === "homework") {
    $points = $json["points"];
    $ret = CreateHomework($name, $desc, $duedate, $points, $cid);
} else if ($type === "test") {
    $points = $json["points"];
    $timelimit = $json["timelimit"];
    $ret = CreateTest($name, $desc, $duedate, $points, $timelimit, $cid); 
} else if ($type === "announcement") { 
    $ret = CreateAnnouncement($name, $desc, $duedate, $cid);
} else {
    $ret = -1;
}

echo $ret;
// @codeCoverageIgnoreEnd
?>
