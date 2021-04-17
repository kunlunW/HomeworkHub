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

function DeleteClassroom($crname)
{
    $conn = OpenCon();

    $sql = "DELETE FROM classrooms WHERE classroomname = '$crname';";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return 1;
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
                '", "joincode":"' . $row["joincode"] . 
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
 * 4: If the user is not a parent
 * 5: Other error
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
    } else {
        $type = $result->fetch_assoc()["type"];
        if ($type !== "parent") {
            CloseCon($conn);
            return 4;
        }
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
        return 5;
        // @codeCoverageIgnoreEnd
    }
}

function LeaveClassroom($username, $cid)
{
    $conn = OpenCon();
    $sql = "DELETE FROM requests WHERE username='$username' AND classroomid='$cid'";
    $ret;

    if ($conn->query($sql) === TRUE) 
        $ret = 0;
    else
        $ret = 1;

    CloseCon($conn);
    return $ret;
}

function GetAllParentsInClassroom($cid)
{
    $conn = OpenCon();
    $sql = "SELECT * FROM requests WHERE classroomid='$cid' ORDER BY username ASC";
    $ret = '[';
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $ret .= '"' . $row["username"]  . '",';
        }
    }

    $ret = rtrim($ret, ",");
    $ret .= ']';

    CloseCon($conn);
    return $ret;
}

function GetAllClassroomsForParent($pname)
{
    $conn = OpenCon();
    $sql = "SELECT * FROM requests WHERE username='$pname' ORDER BY classroomid ASC";
    $ret = '[';
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $ret .= '' . $row["classroomid"]  . ',';
        }
    }

    $ret = rtrim($ret, ",");
    $ret .= ']';

    CloseCon($conn);
    return $ret;
}

/*
 * Returns:
 * 0: Success
 * 1: Failure
 * 2: classroomid does not correspond to a classroom
 */
function CreateHomework($name, $desc, $duedate, $points, $cid) 
{
    $conn = OpenCon();
    
    $sql = "SELECT * FROM classrooms WHERE classroomid='$cid'";
    $result = $conn->query($sql);
    if ($result->num_rows === 0) {
        CloseCon($conn);
        return 2;
    }
 
    $sql = "INSERT INTO homeworks (name, description, duedate, points, classroomid) VALUES ('$name', '$desc', '$duedate', '$points', '$cid')";
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
 * 0: Success
 * 1: Failure
 * 2: classroomid does not correspond to a classroom
 */
function CreateTest($name, $desc, $duedate, $points, $timelimit, $cid) 
{
    $conn = OpenCon();
    
    $sql = "SELECT * FROM classrooms WHERE classroomid='$cid'";
    $result = $conn->query($sql);
    if ($result->num_rows === 0) {
        CloseCon($conn);
        return 2;
    }
 
    $sql = "INSERT INTO tests (name, description, duedate, points, timelimit, classroomid) " . 
        "VALUES ('$name', '$desc', '$duedate', '$points', '$timelimit', '$cid')";
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
 * 0: Success
 * 1: Failure
 * 2: classroomid does not correspond to a classroom
 */
function CreateAnnouncement($name, $desc, $duedate, $cid) 
{
    $conn = OpenCon();
    
    $sql = "SELECT * FROM classrooms WHERE classroomid='$cid'";
    $result = $conn->query($sql);
    if ($result->num_rows === 0) {
        CloseCon($conn);
        return 2;
    }
 
    $sql = "INSERT INTO announcements (name, description, duedate, classroomid) " . 
        "VALUES ('$name', '$desc', '$duedate', '$cid')";
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
 * 1: homework id does not correspond to a homework
 * 2: Other failure
 */
function UpdateHomework($hid, $name, $desc, $duedate, $points)
{
    $conn = OpenCon();
    $sql = "SELECT * FROM homeworks WHERE homeworkid='$hid'";
    $result = $conn->query($sql);
    if ($result->num_rows === 0) {
        CloseCon($conn);
        return 1;
    }

    $sql = "UPDATE homeworks SET name='$name', description='$desc', duedate='$duedate', points='$points' WHERE homeworkid='$hid'";
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
 * 0: On success
 * 1: test id does not correspond to a test
 * 2: Other failure
 */
function UpdateTest($tid, $name, $desc, $duedate, $points, $timelimit)
{
    $conn = OpenCon();
    $sql = "SELECT * FROM tests WHERE testid='$tid'";
    $result = $conn->query($sql);
    if ($result->num_rows === 0) {
        CloseCon($conn);
        return 1;
    }

    $sql = "UPDATE tests SET name='$name', description='$desc', duedate='$duedate', points='$points', timelimit='$timelimit' WHERE testid='$tid'";
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
 * 0: On success
 * 1: test id does not correspond to a test
 * 2: Other failure
 */
function UpdateAnnouncement($aid, $name, $desc, $duedate)
{
    $conn = OpenCon();
    $sql = "SELECT * FROM announcements WHERE announcementid='$aid'";
    $result = $conn->query($sql);
    if ($result->num_rows === 0) {
        CloseCon($conn);
        return 1;
    }

    $sql = "UPDATE announcements SET name='$name', description='$desc', duedate='$duedate' WHERE announcementid='$aid'";
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
 *  2: invalid type
 */
function DeleteEvent($eid, $type)
{
    $conn = OpenCon();
    $sql;

    if ($type == "homework") {
        $sql = "DELETE FROM homeworks WHERE homeworkid='$eid'";
    } else if ($type == "test") {
        $sql = "DELETE FROM tests WHERE testid='$eid'"; 
    } else if ($type == "announcement") {
        $sql = "DELETE FROM announcements WHERE announcementid='$eid'";  
    } else { 
        CloseCon($conn);
        return 2; 
    }
    
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
    $sql;
    $ret = '[';

    if ($type == "homework") { 
        $sql = "SELECT * FROM homeworks WHERE classroomid='$cid'";
    } else if ($type == "test") {
        $sql = "SELECT * FROM tests WHERE classroomid='$cid'";
    } else if ($type == "announcement") {
        $sql = "SELECT * FROM announcements WHERE classroomid='$cid'";
    } else {
        CloseCon($conn);
        return -1;
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        if ($type == "homework") {
            while($row = $result->fetch_assoc()) {
                $ret .= '{"homeworkid":' . $row["homeworkid"] . 
                    ', "name":"' . $row["name"] . 
                    '", "description":"' . $row["description"] . 
                    '", "duedate":"' . $row["duedate"] .
                    '", "points":' . $row["points"] . '},';
            }
        } else if ($type == "test") {
            while($row = $result->fetch_assoc()) {
                $ret .= '{"testid":' . $row["testid"] . 
                    ', "name":"' . $row["name"] . 
                    '", "description":"' . $row["description"] . 
                    '", "duedate":"' . $row["duedate"] . 
                    '", "points":' . $row["points"] . 
                    ', "timelimit":' . $row["timelimit"] . '},';
            }
        } else if ($type == "announcement") {
            while($row = $result->fetch_assoc()) {
                $ret .= '{"announcementid":' . $row["announcementid"] . 
                    ', "name":"' . $row["name"] . 
                    '", "description":"' . $row["description"] . 
                    '", "duedate":"' . $row["duedate"] . '"},';
            }
        }
    }

    $ret = rtrim($ret, ",");
    $ret .= ']';

    CloseCon($conn);
    return $ret;
}

function GetEventListForAllClassrooms($username, $type)
{
    $conn = OpenCon();
    $sql;
    $ret = '[';

    if ($type == "homework") { 
        $sql = "SELECT * FROM homeworks h, requests r WHERE r.username='$username' AND r.classroomid=h.classroomid ORDER BY homeworkid ASC";
    } else if ($type == "test") {
        $sql = "SELECT * FROM tests t, requests r WHERE r.username='$username' AND r.classroomid=t.classroomid ORDER BY testid ASC";
    } else if ($type == "announcement") {
        $sql = "SELECT * FROM announcements a, requests r WHERE r.username='$username' AND r.classroomid=a.classroomid ORDER BY announcementid ASC";
    } else {
        CloseCon($conn);
        return -1;
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        if ($type == "homework") {
            while($row = $result->fetch_assoc()) {
                $ret .= '{"homeworkid":' . $row["homeworkid"] . 
                    ', "name":"' . $row["name"] . 
                    '", "description":"' . $row["description"] . 
                    '", "duedate":"' . $row["duedate"] .
                    '", "points":' . $row["points"] .
                    ', "classroomid":' . $row["classroomid"] . '},';
            }
        } else if ($type == "test") {
            while($row = $result->fetch_assoc()) {
                $ret .= '{"testid":' . $row["testid"] . 
                    ', "name":"' . $row["name"] . 
                    '", "description":"' . $row["description"] . 
                    '", "duedate":"' . $row["duedate"] . 
                    '", "points":' . $row["points"] . 
                    ', "timelimit":' . $row["timelimit"] .
                    ', "classroomid":' . $row["classroomid"] . '},';
            }
        } else if ($type == "announcement") {
            while($row = $result->fetch_assoc()) {
                $ret .= '{"announcementid":' . $row["announcementid"] . 
                    ', "name":"' . $row["name"] . 
                    '", "description":"' . $row["description"] . 
                    '", "duedate":"' . $row["duedate"] . 
                    '", "classroomid":' . $row["classroomid"] . '},';
            }
        }
    }

    $ret = rtrim($ret, ",");
    $ret .= ']';

    CloseCon($conn);
    return $ret;
}

function GetAllParentsInAllClassesOfUser($username)
{
    return -1;
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

/*
 * Returns:
 * 0: Failed to update teacher info
 * 1: Successfully updated teacher info
 * 2: Failed to insert teacher info
 * 3: Successfully inserted teacher info
 */
function UpdateTeachersInfo($username, $gender, $email, $mobile_no, $school)
{
    $conn = OpenCon();
    $sqlCheck = "SELECT * FROM teachers WHERE teacherUserName = '$username';";
    $newTeacherCheck = $conn->query($sqlCheck);
    if($newTeacherCheck->num_rows !== 0) { // Entry already exists
        $sqlUpdate = "UPDATE teachers t SET t.gender = '$gender', t.email = '$email', t.mobile_no = '$mobile_no', t.school = '$school' WHERE t.teacherUserName = '$username';";
        $updateRes = $conn->query($sqlUpdate);
        if (!$updateRes) {
            // echo "Update Failed\n";
            CloseCon($conn);
            return 0;
        } else {
            // @codeCoverageIgnoreStart
            // echo "Update Success\n";
            CloseCon($conn);
            return 1;
            // @codeCoverageIgnoreEnd
        }
    } else { // Entry doesn't exist
        $sqlInsert = "INSERT INTO teachers (teacherUserName, gender, email, mobile_no, school) VALUES ('$username', '$gender', '$email', '$mobile_no', '$school');";
        $insertRes = $conn->query($sqlInsert);
        if (!$insertRes) {
            // echo "Insert Failed\n";
            CloseCon($conn);
            return 2;
        } else {
            // echo "Insert Success\n";
            CloseCon($conn);
            return 3;
        }
    }
}

function DisplayTeacherInfo($username)
{
    $conn = OpenCon();
    $sqlDisplay = "SELECT * FROM Teachers WHERE teacherUserName = '$username';";
    $result = $conn->query($sqlDisplay);
    $ret = "[";
    
    if($result->num_rows > 0) { // Entry already exists
        $row = $result->fetch_assoc();
        $ret .= '{"gender":"' . $row["gender"] . 
            '", "email":"' . $row["email"] . 
            '", "mobile_no":"' . $row["mobile_no"] . 
            '", "school":"' . $row["school"] . '"}]';
        CloseCon($conn);
        return $ret;
    } else { // Entry doesn't exist
        CloseCon($conn);
        return 1;
    }
}

?>
