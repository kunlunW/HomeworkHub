<?php
require_once 'sql_connection.php';

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

function AddUser($username, $password, $type)
{
    $conn = OpenCon();
    $ret;

    //Check if username is already in database
    $sql = "SELECT * FROM users WHERE username= '$username';";
    $result = $conn->query($sql);
    if ($result->num_rows != 0) {
        $ret = 2;
        CloseCon($conn);
        return $ret;
    }

    $sqlRegister = "INSERT INTO users (username, password, type) VALUES ('$username', '$password', '$type')";
    $resultRegister = $conn->query($sqlRegister);
    if(!$resultRegister) {
        $ret = 1;
    } else {
        $ret = 0;
    }

    CloseCon($conn);
    return $ret; 
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

/*
 * Return Values:
 * 0: Request submitted successfully
 * 1: username is not a valid username
 * 2: classroom id is not a valid id
 * 3: The user is already in the classroom
 * 4: The user has already requested to join the classroom
 * 5: Error occured when creating the request
 */
function CreateRequest($username, $cid)
{
    $conn = OpenCon();
    $queryCheckValidUserName = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($queryCheckValidUserName);

    if ($result->num_rows === 0) {
        CloseCon($conn);
        return 1;
    }

    $queryCheckValidCID = "SELECT * FROM classrooms WHERE classroomid='$cid'";
    $result = $conn->query($queryCheckValidCID);

    if ($result->num_rows === 0) {
        CloseCon($conn);
        return 2;
    }

    $queryCheckUserInClassroom = "SELECT * FROM requests WHERE username='$username' AND classroomid='$cid'";
    $result = $conn->query($queryCheckUserInClassroom);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($row["status"] === "accepted") {
            CloseCon($conn);
            return 3;
        } else {
            CloseCon($conn);
            return 4;
        }
    }

    $sql = "INSERT INTO requests (username, classroomid) VALUES ('$username', '$cid')";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return 0;
    } else {
        // @codeCoverageIgnoreStart
        CloseCon($conn);
        return 5;
        // @codeCoverageIgnoreEnd
    }
}

function GetPendingRequests($cid)
{
    $conn = OpenCon();
    $sql = "SELECT * FROM requests WHERE  classroomid='$cid' AND status='pending'";

    $result = $conn->query($sql);
    $ret = '[';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ret .= '{"username":"' . $row["username"] . '"},';
        }
    }

    $ret = rtrim($ret, ",");
    $ret .= ']';

    CloseCon($conn);
    return $ret;
}

function AcceptRequest($username, $cid)
{
    $conn = OpenCon();
    $sql = "Update requests SET status='accepted' WHERE username='$username' AND classroomid='$cid'";

    if ($conn->query($sql) == TRUE) {
        CloseCon($conn);
        return 0;
    } else {
        // @codeCoverageIgnoreStart
        CloseCon($conn);
        return 1;
        // @codeCoverageIgnoreEnd
    }
}
?>
