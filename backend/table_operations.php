<?php
require_once 'sql_connection.php';

/**
 * @codeCoverageIgnore
 */
function CreateUsersTable()
{
    $conn = OpenCon();
    $sql = "CREATE TABLE users (
    username VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    type ENUM('parent', 'teacher') NOT NULL DEFAULT 'parent'
    )";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "users table was not created<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function DropUsersTable() 
{
    $conn = OpenCon();
    $sql = "DROP TABLE users";

    if ($conn->query($sql)) {
        CloseCon($conn);
        return true;
    } else {
        echo "users table was not dropped<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function TruncateUsersTable() 
{
    $conn = OpenCon();
    $sql = "TRUNCATE TABLE users";

    if ($conn->query($sql)) {
        CloseCon($conn);
        return true;
    } else {
        echo "users table was not truncated<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function CreateClassroomsTable()
{
    $conn = OpenCon();
    $sql = "CREATE TABLE classrooms (
    classroomname VARCHAR(255) NOT NULL,
    classroomid INT PRIMARY KEY AUTO_INCREMENT,
    teachername VARCHAR(255) NOT NULL,
    joincode VARCHAR NOT NULL,
    FOREIGN KEY (teachername) REFERENCES users(username)
    )";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "classrooms table was not created<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function DropClassroomsTable() 
{
    $conn = OpenCon();
    $sql = "DROP TABLE classrooms";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "classrooms table was not dropped<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function TruncateClassroomsTable() 
{
    $conn = OpenCon();
    $sql = "TRUNCATE TABLE classrooms";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "classrooms table was not truncated<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function CreateRequestsTable()
{
    $conn = OpenCon();
    $sql = "CREATE TABLE requests (
    username VARCHAR(255) NOT NULL,
    classroomid INT NOT NULL,
    PRIMARY KEY (username, classroomid),
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (classroomid) REFERENCES classrooms(classroomid)
    )";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "requests table was not created<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function DropRequestsTable()
{
    $conn = OpenCon();
    $sql = "DROP TABLE requests";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "requests table was not dropped<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function TruncateRequestsTable()
{
    $conn = OpenCon();
    $sql = "TRUNCATE TABLE requests";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "requests table was not truncated<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function CreateEventsTable()
{
    $conn = OpenCon();
    $sql = "CREATE TABLE events (
    eventid INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    duedate DATE NOT NULL,
    classroomid INT NOT NULL,
    type ENUM('homework', 'test', 'announcement') NOT NULL,
    FOREIGN KEY (classroomid) REFERENCES classrooms(classroomid)
    )";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "events table was not created<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function DropEventsTable() 
{
    $conn = OpenCon();
    $sql = "DROP TABLE events";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "events table was not dropped<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function TruncateEventsTable() 
{
    $conn = OpenCon();
    $sql = "TRUNCATE TABLE events";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "events table was not truncated<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function CreateTeachersTable()
{
    $conn = OpenCon();
    $sql = "CREATE TABLE Teachers (
    teacherUserName VARCHAR(255) PRIMARY KEY,
    gender ENUM('male', 'female') NOT NULL,
    email VARCHAR(255) NOT NULL,
    mobile_no INT NOT NULL,
    school VARCHAR(255) NOT NULL,
    FOREIGN KEY (teacherUserName) REFERENCES users(username)
    )";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "Teachers table was not created<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function DropTeachersTable() 
{
    $conn = OpenCon();
    $sql = "DROP TABLE Teachers";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "Teachers table was not dropped<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function TruncateTeachersTable() 
{
    $conn = OpenCon();
    $sql = "TRUNCATE TABLE Teachers";

    if ($conn->query($sql) === TRUE) {
        CloseCon($conn);
        return true;
    } else {
        echo "Teachers table was not truncated<br>";
        CloseCon($conn);
        return false;
    }
}

/**
 * @codeCoverageIgnore
 */
function ResetTables()
{
    DropAllTables();
    CreateAllTables();
}

/**
 * @codeCoverageIgnore
 */
function DropAllTables()
{
    DropRequestsTable();
    DropEventsTable();
    DropClassroomsTable();
    DropTeachersTable();
    DropUsersTable();
}

/**
 * @codeCoverageIgnore
 */
function CreateAllTables()
{
    CreateUsersTable();
    CreateClassroomsTable();
    CreateRequestsTable();
    CreateEventsTable();
    CreateTeachersTable();
}

?>
