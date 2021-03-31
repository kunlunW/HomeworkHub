<?php
include 'sql_connection.php';

function login($username, $password)
{
$conn = OpenCon();


$sql = "SELECT * FROM users WHERE username='" . $username . "' AND password='" . $password . "';";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    echo $row["type"];
} else {
    echo 2;
}

CloseCon($conn);
}

function createClassroom($crname, $tname)
{
$conn = OpenCon();

$sql = "INSERT INTO classrooms (classroomname, teachername) VALUES ('$crname', '$tname')";

if ($conn->query($sql) === TRUE) {
    $lastId = $conn->insert_id;
    echo $lastId;
} else {
    echo 0;
}

CloseCon($conn);
}
?>
