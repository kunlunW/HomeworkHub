<?php
include 'sql_connection.php';

function RetrieveUser($username, $password)
{
    $conn = OpenCon();


    $sql = "SELECT * FROM users WHERE username='" . $username . "' AND password='" . $password . "';";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        CloseCon($conn);
        return $row["type"];
    } else {
        CloseCon($conn);
        return 2;
    }
}

function CreateClassroom($crname, $tname)
{
    $conn = OpenCon();

    $sql = "INSERT INTO classrooms (classroomname, teachername) VALUES ('$crname', '$tname')";

    if ($conn->query($sql) === TRUE) {
        $lastId = $conn->insert_id;
        CloseCon($conn);
        return $lastId;
    } else {
        CloseCon($conn);
        return 0;
    }
}

function GetTeacherClassrooms($username)
{
    $conn = OpenCon();

    $sql = "SELECT * FROM classrooms WHERE teachername='$username'";

    $ret = '[';

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $ret .= '{"classroomid":' . $row["classroomid"] . 
                ', "classroomname":"' . $row["classroomname"] . 
                '", "teachername":"' . $row["teachername"] . '"},';
        }
    }

    $ret = rtrim($ret, ",");
    $ret .= ']';

    CloseCon($conn);
    return $ret;
}

function GetPendingRequests($cid)
{
    $conn = OpenCon();
    $sql = "SELECT * FROM requests WHERE  classroomid='$cid' AND status='pending'";

    $result = $conn->query($sql);
    $ret = '[';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ret .= '{"username":"' . $row["username"] . '"}, ';
        }
    }

    $ret = rtrim($ret, ",");
    $ret .= ']';

    CloseCon($conn);
    return $ret;
}
?>
