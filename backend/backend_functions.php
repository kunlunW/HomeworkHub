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

function CreateClassroom($crname, $tname, $joincode)
{
    $conn = OpenCon();

    $sql = "INSERT INTO classrooms (classroomname, teachername, joincode) VALUES ('$crname', '$tname', '$joincode')";

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

function GetJoinCode($cid)
{
    // @codeCoverageIgnoreStart
    $conn = OpenCon();
    $ret;
    $sql = "SELECT joincode FROM classrooms WHERE classroomid='$cid'";

    $result = $conn->query($conn);
    if ($result->num_rows === 1)
        $ret = $result->fetch_assoc()["joincode"];
    else 
        $ret = -1;

    CloseCon($conn);
    return $ret;
    // @codeCoverageIgnoreEnd
}

/*
 * Returns:
 * 0: On success
 * 1: Join code does not correspond to any classroom
 * 2: Username does not correspond to any user
 * 3: If the user is already in the classroom
 * 4: Other error
 */
function JoinClassroom($username, $joincode)
{
    $conn = OpenCon();
    
    $sql = "SELECT * FROM classrooms WHERE joincode='$joincode'";
    $result = $conn->query($sql);
    if ($result->num_rows !== 1) {
        CloseCon($conn);
        return 1;
    }

    $cid = $result->fetch_assoc()["classroomid"];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows !== 1) {
        CloseCon($conn);
        return 2;
    }

    $sql = "SELECT * FROM  requests WHERE username='$username' AND classroomid='$cid'";
    $result = $conn->query($sql);
    if ($result->num_rows !== 0) {
        CloseCon($conn);
        return 3;
    }

    $sql = "INSERT INTO requests (username, classroomid) VALUES ('$username', '$cid')";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        CloseCon($conn);
        return 0;
    } else {
        // @codeCoverageIgnoreStart
        CloseCon($conn);
        return 4;
        // @codeCoverageIgnoreEnd
    }
}

/*
 * Returns:
 * 0: Success
 * 1: Failure
 * 2: classroomid does not correspond to a classroom
 * 3: invalid type
 */
function CreateEvent($name, $desc, $duedate, $cid, $type) 
{
    $conn = OpenCon();
    
    $sql = "SELECT * FROM classrooms WHERE classroomid='$cid'";
    $result = $conn->query($sql);
    if ($result->num_rows === 0) {
        CloseCon($conn);
        return 2;
    }

    if ($type !== "homework" and $type !== "test" and $type !== "announcement") {
        CloseCon($conn);
        return 3;
    }
    
    $sql = "INSERT INTO events (name, description, duedate, classroomid, type) VALUES ('$name', '$desc', '$duedate', '$cid', '$type')";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        $lastId = $conn->insert_id;
        CloseCon($conn);
        return $lastId;
    } else {
        // @codeCoverageIgnoreStart
        CloseCon($conn);
        return 0;
        // @codeCoverageIgnoreEnd
    }
}

/*
 * Returns:
 * 0: On success
 * 1: event id does not correspond to an event
 * 2: Other failure
 */
function UpdateEvent($eid, $name, $desc, $duedate)
{
    $conn = OpenCon();
    $sql = "SELECT * FROM events WHERE eventid='$eid'";
    $result = $conn->query($sql);
    if ($result->num_rows === 0) {
        CloseCon($conn);
        return 1;
    }

    $sql = "UPDATE events SET name='$name', description='$desc', duedate='$duedate' WHERE eventid='$eid'";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        CloseCon($conn);
        return 0;
    } else {
        // @codeCoverageIgnoreStart
        CloseCon($conn);
        return 2;
        // @codeCoverageIgnoreEnd
    }
}

/*
 * Returns:
 *  0: Success
 *  1: Failure
 */
function DeleteEvent($eid)
{
    $conn = OpenCon();
    $sql = "DELETE FROM events WHERE eventid='$eid'";
    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return 0;
    } else {
        // @codeCoverageIgnoreStart
        CloseCon($conn);
        return 1;
        // @codeCoverageIgnoreEnd
    }
}

function GetEventList($cid, $type) 
{
    $conn = OpenCon();
    $sql = "SELECT * FROM events WHERE classroomid='$cid' AND type='$type'";
    $ret = '[';
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $ret .= '{"eventid":' . $row["eventid"] . 
                ', "name":"' . $row["name"] . 
                '", "description":"' . $row["description"] . 
                '", "duedate":"' . $row["duedate"] . '"},';
        }
    }

    $ret = rtrim($ret, ",");
    $ret .= ']';

    CloseCon($conn);
    return $ret;
}

function GetAllEvents($cid) 
{
    $conn = OpenCon();
    $sql = "SELECT * FROM events WHERE classroomid='$cid'";
    $ret = '[';
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $ret .= '{"eventid":' . $row["eventid"] . 
                ', "name":"' . $row["name"] . 
                '", "description":"' . $row["description"] . 
                '", "duedate":"' . $row["duedate"] . 
                '", "type":"' . $row["type"] . '"},';
        }
    }

    $ret = rtrim($ret, ",");
    $ret .= ']';

    CloseCon($conn);
    return $ret;
}

function UpdateUsersInfo($username, $newUserame, $newPassword, $newType)
{
    // Check if there are NULL values among the three attributes
    if($newUserame === NULL || $newPassword === NULL || $newType === NULL) {
        // echo "Invalid input\n";
        CloseCon($conn);
        return 1;
    } else {
        //Check if the updated username is already in database
        $sql = "SELECT * FROM users WHERE username = '$newUsername';";
        $newUsernameCheck = $conn->query($sql);
        if ($newUsernameCheck->num_rows != 0) {
            // echo "Duplicate username\n"; //duplicate username
            CloseCon($conn);
            return 1;
        }

        $sqlUpdate = "UPDATE users u SET u.username = '$newUsername', u.password = '$newPassword', u.type = '$newType' WHERE u.username = '$username';";
        $updateRes = $conn->query($sqlUpdate);
        if (!$updateRes) {
            // echo "Update Failed\n";
            CloseCon($conn);
            return 1;
        } else {
            // echo "Update Success\n";
            CloseCon($conn);
            return 0;
        }
    }
}

function UpdateTeachersInfo($username, $gender, $email, $mobile_no, $school)
{
    $conn = OpenCon();
    $sqlCheck = "SELECT * FROM Teachers WHERE teacherUserName = '$username';";
    if($sqlCheck) { // Entry already exists
        $sqlUpdate = "UPDATE Teachers t SET t.gender = '$gender', t.email = '$email', t.mobile_no = '$mobile_no', t.school = '$school' WHERE t.teacherUserName = '$username';";
        $updateRes = $conn->query($sqlUpdate);
        if (!$updateRes) {
            // echo "Update Failed\n";
            CloseCon($conn);
            return 0;
        } else {
            // echo "Update Success\n";
            CloseCon($conn);
            return 1;
        }
    } else { // Entry doesn't exist
        $sqlInsert = "INSERT INTO Teachers (username, gender, email, mobile_no, school) VALUES ('$username', '$gender', '$email', '$mobile_no', '$school');";
        $insertRes = $conn->query($sqlInsert);
        if (!$insertRes) {
            // echo "Insert Failed\n";
            CloseCon($conn);
            return 1;
        } else {
            // echo "Insert Success\n";
            CloseCon($conn);
            return 0;
        }
    }
}

?>
