<?php
include 'sql_connection.php';

function Login($username, $password)
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

function CreateClassroom($crname, $tname)
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

function GetTeacherClassrooms($username)
{
    $conn = OpenCon();

    $sql = "SELECT * FROM classrooms WHERE teachername='$username'";

    $ret = '[';

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $ret .= '{"classroomid":"' . $row["classroomid"] . 
                '", "classroomname":"' . $row["classroomname"] . 
                '", "teachername":"' . $row["teachername"] . '},';
        }
    }

    $ret = rtrim($ret, ",");
    $ret .= ']';

    echo $ret;

    CloseCon($conn);
}
?>
